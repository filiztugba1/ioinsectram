<?php
User::model()->login();
$ax= User::model()->userobjecty('');

?>

	<?php if ($ax->type == 13){
    ?>


	<section id="headers">
          <div class="row pagestart">
            <div class="col-12">
              <div class="card card-fullscreen">
                <div class="card-header">
                  <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title">Superlogs</h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-minimize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
		<div class="row">

		      <div class="col-xl-12 col-lg-12">
		          <div id="success_alert" class="alert alert-success" role="alert">
                    Kullanıcı senkronizasyonu başarılı.
                  </div>
                  <div id="error_alert" class="alert alert-danger" role="alert">
                    Kullanıcıyı yeniden senkronize ederken hata oluştu.
                  </div>
              <div class="card">
                  <div class="card-content">
                  <div class="card-body">
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="tabIcon21" aria-expanded="true"
                            aria-labelledby="baseIcon-tab21">
                            <?php 
                            $startTime = Yii::app()->getRequest()->getQuery('stime');
                            $endTime = Yii::app()->getRequest()->getQuery('etime');
                            
                           
                            if($startTime && !$endTime){
                                $endTime = $startTime + 200000;
                            }
                            if($startTime) {
                                $select=Yii::app()->db->createCommand('SELECT * FROM superlogs WHERE createdtime BETWEEN '.$startTime.' AND '.$endTime.' ORDER BY id DESC LIMIT 5000')->queryAll(); 
                            }else{
                                $select=Yii::app()->db->createCommand('SELECT * FROM superlogs ORDER BY id DESC LIMIT 5000')->queryAll(); 
							
                            } ?>
                            <div style="width:100%">
                              <p style="margin-top:14px">Mobilden gelen süperloglar arasında aramak için birşeyler girin:</p>
                              <input class="form-control" id="myInput" type="text" placeholder="Kullanıcı adı, tarih, müşteri...">
                              <br>
                              <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>İş Emirlerindeki Müşteriler</th>
                                    <th>Okunan Monitörler</th>
                                    <th>Kullanıcı İsmi</th>
                                    <th>DeviceID</th>
                                    <th>Zaman</th>
                                    <th>Aksiyon</th>
                                  </tr>
                                </thead>
                                <tbody id="myTable">
                                    <?php foreach ($select as $log)
                                	{
                                	    //$dataShort = substr($log['data'],0,200);
                                	    $date = date('m/d/Y H:i:s', $log['createdtime']);
                                	    $userName = Yii::app()->db->createCommand('SELECT username FROM user WHERE id='.$log['userid'])->queryRow();
                                	    $data = json_decode($log['data'],true);
                                	    $clientName = '';
                                	    $monitorsChecked = '';

                                	    if($data['Workorders']) {
                                    	    foreach($data['Workorders'] as $workorder)
                                    	    {
                                    	        $clientName = $clientName.$workorder['clientname'].'<br>';
                                    	        $monitorsChecked = $monitorsChecked.'<b>'.$workorder['clientname'].'</b>'.': ';
                                    	        foreach($workorder['workordermonitors'] as $monitor)
																							{
																								if($monitor['checkdate'] > 0) 
																								{
																									$monitorsChecked = $monitorsChecked.'<tal style="color:blue">'.$monitor['monitorno'].'</tal>, ';
																								}else{
																									
																									$monitorsChecked = $monitorsChecked.'<tal style="color:red">'.$monitor['monitorno'].'</tal>, ';
																								}
																								
																							}
																						
                                    	        $monitorsChecked = substr($monitorsChecked, 0, -2).'<br>';
                                    	    }
                                	    }

                                		echo "
                                		 <tr>
                                            <td>{$log['id']}</td>
                                            <td>{$clientName}</td>
                                            <td>{$monitorsChecked}</td>
                                            <td>{$userName['username']}</td>
                                            <td>{$log['deviceid']}</td>
                                            <td>{$date}</td>
                                            <td><button type=\"button\" class=\"btn btn-success\" id=\"{$log['id']}\">Tekrarla</button></td>
                                         </tr>";
                                	} ?>
                                </tbody>
                              </table>
                            </div>
					    </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>


		 </div>
     </div>
                </div>
              </div>
            </div>
          </div>
        </section>

	<?php }?>

<script>

   $(document).ready(function() {

    var successAlert = $("#success_alert").toggle();
    var errorAlert = $("#error_alert").toggle();

    $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("button").click(function() {
        //alert(this.id); // or alert($(this).attr('id'));
        $(this).prop('disabled', true);

        $.get("https://insectram.io/api/package2?id="+this.id, function(data, status){
            if(data.success)
            {
                successAlert.toggle(300);
                setTimeout(function(){ successAlert.toggle(300); }, 3000);
            }
            else
            {
                errorAlert.toggle(300);
                setTimeout(function(){ errorAlert.toggle(300); }, 3000);
                $(this).prop('disabled', false);
            }
            $('section, div').animate({
            scrollTop: $("div.pagestart").offset().top
          }, 300);
         });
    });
});

</script>
