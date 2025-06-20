<?php
User::model()->login();
$ax= User::model()->userobjecty('');

// Clone işlemi
if(isset($_POST['clone_map_id']) && !empty($_POST['clone_map_id'])) {
    $originalMap = Maps::model()->findByPk($_POST['clone_map_id']);
    if($originalMap) {
        $clonedMap = new Maps();
        $clonedMap->attributes = $originalMap->attributes;
        $clonedMap->id = null; // Yeni ID otomatik oluşturulacak
        $clonedMap->map_name = $originalMap->map_name . '-clone';
        $clonedMap->monitor = '"[]"'; // Monitor sütununu çift tırnaklı olarak ayarla
        $clonedMap->created_date = date('Y-m-d H:i:s');
        
        // Belirtilen alanları kaynak kayıttan bire bir kopyala
        $clonedMap->is_active = $originalMap->is_active;
        $clonedMap->client_id = $originalMap->client_id;
        $clonedMap->points = $originalMap->points;
        $clonedMap->image = $originalMap->image;
        $clonedMap->notes = $originalMap->notes;
        $clonedMap->canvasSize = $originalMap->canvasSize;
        $clonedMap->imageSize = $originalMap->imageSize;
        $clonedMap->mapBackgroundImage = $originalMap->mapBackgroundImage;
        
        if($clonedMap->save()) {
            echo "<script>
                toastr.success('Harita başarıyla klonlandı!', 'Başarılı');
                setTimeout(function(){ location.reload(); }, 1500);
            </script>";
        } else {
            echo "<script>
                toastr.error('Klonlama işlemi başarısız!', 'Hata');
            </script>";
        }
    }
}

$departments=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
							   ));




						?>


<?php//monitor benzerliği
/*
$mbarkod=Monitoring::model()->findAll(array(
							 'condition'=>'id>9999 && id<16000'));
foreach ($mbarkod as $monitorx) {
	$mbarkodvarmi=Monitoring::model()->findAll(array(
								 'condition'=>'barcodeno="'.$monitorx->barcodeno.'"',
							 ));
	if($mbarkodvarmi && count($mbarkodvarmi)>1)
	{
		echo count($mbarkodvarmi).'-'.$monitorx->id.'<br>';
		$model=Monitoring::model()->find(array('condition'=>'id='.$monitorx->id));
		$model->barcodeno=Monitoring::model()->barkodeControl($model->barcodeno);
		$model->save();
	}
}
*/
?>

<?php
$where='';
if(isset($_GET['isactive']))
{
	$where=' and active='.$_GET['isactive'];
}

$maps=Maps::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'client_id='.$_GET['id'].$where,
							   ));




$monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$_GET['id'].$where,
							   ));


$clientbtitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_GET['id'])));
$clienttitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientbtitle->parentid)));
$branchtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clienttitle->firmid)));
$firmtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$branchtitle->parentid)));






?>


<?php if (Yii::app()->user->checkAccess('client.branch.maps.view') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
<?=User::model()->geturl('Client','Maps',$_GET['id'],'maps');?>
MAP Çizme Ekranı
			<div class="card">
		<div class="card-header" style="">
							<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
						  <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?$say=User::model()->findAll(array('condition'=>'clientbranchid='.$_GET['id']));
									echo count($say);?>

							</span><?=t('Staff');?>

							</a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

						  <li class="nav-item">
							<a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $departments);?></span><?=t('Departments');?></a>
						  </li>
					   <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
							<li class="nav-item">
							<a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

					      <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
						   <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a>
						  </li>

					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

					        <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files2/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a>
						  </li>
						<?php }?>

								<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a></a>
                      </li>
					 <?//}?>
	<?php if (Yii::app()->user->checkAccess('client.maps.view') ){ ?>
					        <li class="nav-item">
                        <a class="nav-link active"  href="/client/maps?id=<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-map" style="font-size: 15px;"></i></span><?=t('Haritalar');?> </a></a>
                      </li>
					 <?php }?>


                    </ul>
				</div>

</div>




  <?php if (Yii::app()->user->checkAccess('client.map.create')|| ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
<div class="row" id="createpage" >


	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">

			   <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Map Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

					<!-- <form id="departments-form" action="/monitoring/create" method="post">	-->

				<form id="monitoring-form" >
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput"  name="Maps[client_id]" value="<?=$_GET['id'];?>">
                      <input type="hidden" class="form-control" id="basicInput"  name="Maps[is_active]" value="1">

					<div class="row">


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Map Name');?></label>
                        <fieldset class="form-group" id='monitorno'>
                          <input type="text"  class="form-control"   placeholder="<?=t('Map Name');?>" name="Maps[name]">
                        </fieldset>
                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
                    </div>

					
					  </div>
					</div>

					</div>
				</div>
				</form>
			</div>

	</div><!-- form -->
	</div>

<?php }?>



<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('Map List');?></h4>
						</div>

						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Map');?> <i class="fa fa-plus"></i></button>
								</div>


						</div>



				



                </div>



                <div class="card-content collapse show">
                  <div class="card-body card-dashboard" id='list'>

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
                               <th><?=mb_strtoupper(t('Map Name'));?></th>
							 <th><?=mb_strtoupper(t('Map Created Date'));?></th>

								 <th><?=t('IS ACTIVE');?></th>
                          <th>  <?=mb_strtoupper(t('Process'));?></th>
							

                          </tr>
                        </thead>
                        <tbody>


             				<?php foreach($maps as $map):?>

							


                                <tr>
								<td><input type="checkbox" name="Maps[id][]" class='sec' value="<?=$map['id'];?>"></td>
                                <td>
								
								<!-- <a href="/client/mapsupdate?id=<?=$_GET['id']?>&hid=<?=$map->id?>"><?=$map->map_name;?></a>-->
                  <?=$map->map_name;?>
								</td>
								 <td><?=$map->created_date;?></td>



									<td>

									<div class="form-group pb-1">
										<input type="checkbox" data-size="sm" id="switchery"  class="switchery" data-id="<?=$map['id'];?>"  <?php if($map['is_active']==1){echo "checked";} if(Yii::app()->user->checkAccess('client.maps.update') || ($ax->id==0||$ax->id=317||$ax->id=588)){}else{echo ' disabled';}?>  />
									</div>

								</td>

									<td>

								<?php if (Yii::app()->user->checkAccess('client.maps.update') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
                     <a  class="btn btn-success btn-sm" href='<?='/map?cbid='.$_GET['id'].'&mapid='.$map['id']?>'  data-original-title="<?=t('Monitor Ekle/Güncelle');?>"

										 ><i style="color:#fff;" class="fa fa-map"></i> <?=t('Map');?></a>
                    <a  class="btn btn-primary btn-sm" href='<?='/map/monitors?cbid='.$_GET['id'].'&mapid='.$map['id']?>' data-original-title="<?=t('Monitor Ekle/Güncelle');?>"

										 ><?=t('Monitor Ekle/Güncelle');?></a>                    
								<?php }?>
								<?php if (Yii::app()->user->checkAccess('client.maps.update') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
										 <a  class="btn btn-info btn-sm" onclick="cloneMap(<?=$map['id'];?>)"
										 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Clone');?>"
										 ><i style="color:#fff;" class="fa fa-copy"></i> Clone</a>
										 
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										 data-id="<?=$map['id'];?>"
										 data-name="<?=$map['map_name'];?>"
										 data-created_date="<?=$map['created_date'];?>"
										 data-is_active="<?=$map['is_active'];?>"
										 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"

										 ><i style="color:#fff;" class="fa fa-edit"></i></a>

								<?php }?>

								<?php if (Yii::app()->user->checkAccess('client.maps.delete') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>


										<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$map['id'];?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"
										><i style="color:#fff;" class="fa fa-trash"></i></a>

								<?php }?>



									</td>

								
                                </tr>


								<?php endforeach;?>

                        </tbody>
                        <tfoot>
                          <tr>

						  <th style='width:1px;'>
						  <?php if (Yii::app()->user->checkAccess('client.map.delete')|| ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete selected');?>"><i class="fa fa-trash"></i></button>
								</div>
						<?php }?>
							</th>

							 <th><?=mb_strtoupper(t('Map Name'));?></th>
							 <th><?=mb_strtoupper(t('Map Created Date'));?></th>
							 <th><?=t('IS ACTIVE');?></th>
                         	 <?php if (Yii::app()->user->checkAccess('client.maps.update') ||Yii::app()->user->checkAccess('client.maps.delete') || ($ax->id==0||$ax->id=317||$ax->id=588) ){ ?>
                          <th>  <?=mb_strtoupper(t('Process'));?></th>
							<?php }?>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>




<?php if (Yii::app()->user->checkAccess('client.maps.update') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitoring Points Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
							<form id="departments-form" action="/client/mapupdate" method="post">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control"  name="Maps[client_id]" value="<?=$_GET['id'];?>">
					   <input type="hidden" class="form-control" id="modalmapsid"  name="Maps[id]" value="">


					<div class="row">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Map Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalmapsname" placeholder="<?=t('Map Name');?>" name="Maps[name]">
                        </fieldset>
                    </div>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Is Active');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="modalmapsactive" name="Maps[active]" >

						  <option value="1"><?=t('Active');?></option>
						  <option value="0"><?=t('Passive');?></option>

                           </select>
                        </fieldset>
						
						</div>
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page" type="submit"><?=t('Update');?></button>
								</div>
                        </fieldset>
                    </div>
						

					</div>
				</div>
				

									<!--form biti�-->
                    </div>
					</form>
                </div>
            </div>
        </div>
    </div>

	<?php }?>
	<!-- G�NCELLEME B�T��-->
	<!--S�L BA�LANGI�-->
	<?php if (Yii::app()->user->checkAccess('client.maps.delete') || ($ax->id==0||$ax->id=317||$ax->id=588)){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Map Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="departments-form" action="/client/mapdelete/0" method="post">
						<input type="hidden" class="form-control" id="basicInput"  name="Maps[client_id]" value="<?=$_GET['id'];?>">


						<input type="hidden" class="form-control" id="modalmapid2" name="Maps[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- S�L B�T�� -->

	<!--delelete all start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Map Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslang��-->
						<form action="/client/mapdeleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Maps[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput"  name="Maps[client_id]" value="<?=$_GET['id'];?>">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Are you sure you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- delete all finish -->

<?php }
}?>
<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}

</style>

<script>


$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});



 //delete all start
$(document).ready(function(){
	$("#barcodesearch").hide();
	$("#openbarcode").on('click',function(){
		$("#barcodesearch").show("slow");
	})


    $('#select_all').on('click',function(){
        if(this.checked){
            $('.sec').each(function(){
                this.checked = true;
            });
        }else{
             $('.sec').each(function(){
                this.checked = false;
            });
        }
    });

    $('.sec').on('click',function(){
        if($('.sec:checked').length == $('.sec').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

 function deleteall()
 {
	var ids = [];
	$('.sec:checked').each(function(i, e) {
		ids.push($(this).val());
	});
	$('#modalid3').val(ids);
	if(ids=='')
	 {
		alert("<?=t('You must select at least one of the checboxes!');?>");
	}
	else
	 {
		$('#deleteall').modal('show');
	 }

 }
 // delete all finish


//ekle b�l�m� baslang�c

function myFunction() {
	yy=document.getElementById("typeselect").value;
		 $.post( "/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient').html(data);
			$("#subdepartmentclient" ).prop( "disabled", false );

		 });
}


function myFunction5() {
	yy=document.getElementById("typeselect5").value;
		 $.post( "/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient5').html(data);
			$("#subdepartmentclient5" ).prop( "disabled", false );

		 });
}
//ekle b�l�m� biti�


//G�ncelle b�l�m� baslang�c




function myFunction2() {
	yy=document.getElementById("typeselect2").value;
		 $.post( "/client/subdepartments2?id="+yy).done(function( data ) {
			$('#subdepartmentclient2').html(data);

		 });
}


//G�ncelle b�l�m� biti�



function authchange(data,permission,obj)
{
$.post( "?id=<?=$_GET['id'];?>;", { id: data, active: permission })
  .done(function( returns ) {
	  toastr.success("<?=t('Update Successful');?>");
});
};

$(document).ready(function(){
	$(".switchery").on('change', function() {

	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }

	  $('#checkbox-value').text($('#checkbox1').val());
});
});


</script>


<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });
 $("#cancelb").click(function(){
        $("#barcodesearch").hide(500);
 });
 $(document).ready(function(){

	$("#monitoring-form").on('submit',(function(e) {
	e.preventDefault();
	 $.ajax({
      url: "/client/mapcreate",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data)
        {
			if(data.trim()=='ok')
			{

				toastr.success("<?=t('Monitoring is create successful!');?>","<center><?=t('Successful');?></center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				});
			location.reload(true);

				// $.post("/client/maplist?id="+<?=$_GET['id'];?>).done(function( data ) {
					// $('#list').html(data);
							// $(".switchery").on('change', function() {

								  // if ($(this).is(':checked')) {
									  // authchange($(this).data("id"),1,$(this));
								  // } else {
									  // authchange($(this).data("id"),0,$(this));
								  // }

								  // $('#checkbox-value').text($('#checkbox1').val());
							// });




				// });

			


			}
			else
			{
				toastr.error(data,"<center><?=t('Error');?></center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				});
			}
        }
     });


  }));





 });



   $(document).ready(function() {
      $('.block-page').on('click', function() {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 20000, //unblock after 20 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });

});


function openmodal(obj)
{


	$('#modalmapsid').val($(obj).data('id'));
	$('#modalmapsactive').val($(obj).data('is_active'));
	$('#modalmapsname').val($(obj).data('name'));


	$('#duzenle').modal('show');

}



function openmodalsil(obj)
{
	$('#modalmapid2').val($(obj).data('id'));
	$('#sil').modal('show');

}

function cloneMap(mapId) {
    if(confirm('Bu haritayı klonlamak istediğinizden emin misiniz?')) {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 20000,
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
        
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                clone_map_id: mapId
            },
            success: function(response) {
                $.unblockUI();
                // Başarı mesajı response içinde JavaScript olarak gelecek
                if(response.includes('toastr.success')) {
                    eval(response.match(/<script>(.*?)<\/script>/s)[1]);
                } else {
                    toastr.success('Harita başarıyla klonlandı!', 'Başarılı');
                    setTimeout(function(){ location.reload(); }, 1500);
                }
            },
            error: function() {
                $.unblockUI();
                toastr.error('Klonlama işlemi başarısız!', 'Hata');
            }
        });
    }
}

$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			colvis: "<?=t('Columns Visibility');?>",

        },
				     "sDecimal": ",",
                     "sEmptyTable": "<?=t('Data is not available in the table');?>",
                     //"sInfo": "_TOTAL_ kay�ttan _START_ - _END_ aras�ndaki kay�tlar g�steriliyor",
                     "sInfo": "<?=t('Total number of records');?> : _TOTAL_",
                     "sInfoEmpty": "<?=t('No records found');?> ! ",
                     "sInfoFiltered": "(_MAX_ <?=t('records');?>)",
                     "sInfoPostFix": "",
                     "sInfoThousands": ".",
                     "sLengthMenu": "<?=t('Top of page');?> _MENU_ <?=t('record');?>",
                     "sLoadingRecords": "<?=t('Loading');?>...",
                     "sProcessing": "<?=t('Processing');?>...",
                     "sSearch": "<?=t('Search');?>:",
                     "sZeroRecords": "<?=t('No records found');?> !",
                     "oPaginate": {
                         "sFirst": "<?=t('First page');?>",
                         "sLast": "<?=t('Last page');?>",
                         "sNext": "<?=t('Next');?>",
                         "sPrevious": "<?=t('Previous');?>"
                     },
    },
	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2,3,4,5 ]
            },
			text:'<?=mb_strtoupper(t('Pdf'));?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Client Branch \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=User::model()->table('clientbranch',$_GET['id']);?> \n',
					bold: true,
					fontSize: 12,
						alignment: 'center'
				  },

						{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 11,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]

				});
			  }

        },





        'colvis',
		'pageLength'
    ]
} );
<?php $ax= User::model()->userobjecty('');
$pageUrl=explode('?',$_SERVER['REQUEST_URI'])[0];
$pageLength=5;
$table=Usertablecontrol::model()->find(array(
							 'condition'=>'userid=:userid and sayfaname=:sayfaname',
							 'params'=>array(
								 'userid'=>$ax->id,
								 'sayfaname'=>$pageUrl)
						 ));
if($table){
	$pageLength=$table->value;
}
?>
var table = $('.dataex-html5-export').DataTable();
table.page.len( <?=$pageLength;?> ).draw();
var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
var info = table.page.info();
var lengthMenuSetting = info.length; //The value you want
// alert(table.page.info().length);
} );
</script>

<style>
@media (max-width: 991.98px) {

.hidden-xs,.buttons-collection{
display:none;
}
 div.dataTables_wrapper div.dataTables_filter label{
 white-space: normal !important;
 }
div.dataTables_wrapper div.dataTables_filter input{
margin-left:0px !important;
}

 }
</style>



<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/switch.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
