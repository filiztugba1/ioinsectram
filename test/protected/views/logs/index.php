
<?php
User::model()->login();
$ax= User::model()->userobjecty('');
	if (Yii::app()->user->checkAccess('logs.view')){ ?>
	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Logs','',0,'logs');?>
<?php  $logs=Logs::model()->findAll(array(
								   'order'=>'createtime DESC',
							   ));?>

<div id="logs" style="display: none;"><?=count($logs);?></div>
 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						 <h4 class="card-title"><?=t('LOG LIST');?></h4>
						</div>

					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                    <table class="table table-striped table-bordered dataex-html5-export" id="example">
                        <thead>
                          <tr>
                            <th><?=t('OPERATION');?></th>
							<th><?=t('PLACE');?></th>

							<th><?=t('USER');?></th>
							<th><?=t('CREATE TIME');?></th>


                          </tr>
                        </thead>
                        <tbody id="logscontainer">
             			<?php foreach($logs as $log):?>
                                <tr id="<?=$log->id;?>">
                                    <td><?=$log->operation;?></td>
									<td><?=$log->place;?></td>

									<?php  $user=User::model()->find(array('condition'=>'id='.$log->userid));?>
									<td><?=$user->name.' '.$user->surname;?></td>

									<td><?=date('d.m.Y H:i:s', $log->createtime);?></td>

                                </tr>

					<?php endforeach;?>


                        </tbody>
                        <tfoot>
                          <tr>
                           <th><?=t('OPERATION');?></th>
							<th><?=t('PLACE');?></th>

							<th><?=t('USER');?></th>
							<th><?=t('CREATE TIME');?></th>


                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>


	<div id="sonuc"></div>







<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}
</style>

<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>


<script>


/*setInterval(function(){

		$.post( "/logs/getlogs").done(function( data ) {
				$('#logscontainer').html(data);


		 });

		 $.post( "/logs/getlogs/1").done(function( data ) {
		var x=$('#logs').html();
				 x=x.trim();
				 console.log(x);
				 result=data.split('|');
			 if(x<result[0])
			 {
				$('#logscontainer').html(data);
				x=result[0].trim();
				$('#logs').html(x);
				toastr.success(result[1],"<center>Yeni Bildirim</center>" , {
				positionClass: "toast-bottom-right",
				containerId: "toast-top-right"
			 });

		 }});

		}, 10000);

*/

var xx=$('#logs').html();
var yy=$('#logscontainer tr:first').attr('id');
setInterval(function(){
		yy=$('tbody>tr:first').attr('id');
		 $.post( "/logs/getlogs2?id="+yy).done(function( data ) {
				 xx=xx.trim();
				 console.log(xx);
				 result = data.split('|');
				 if (result[0]>0)
				 {

				 var markup = "<tr style='background:#ffd9d9;'" + 'id="'+result[0]+'"'+"><td>"+result[1]+"</td><td>"+result[2]+"</td><td>"+result[3]+"</td><td>"+result[4]+"</td></tr>";

				 setTimeout(function(){
					 $('tr').eq(1).hide().css({'background-color':'white'}).fadeIn(100);
					 }, 5000);

                 $("table tbody").prepend(markup).fadeIn('slow');
					toastr.success(result[1]+' '+result[4]+' '+result[3]+' '+result[4],"<center>Yeni Bildirim</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				 });

				 xx=$('#logs').html(result[0]);
				xx=result[0].trim();

				}

		});
		}, 5000);




// setTimeout(function(){
// $('tr').eq(1).hide().css({'background-color':'white'}).fadeIn(100);
// }, 00);


// $(document).ready(function(){
// $(".page-link").click(function(){ $(location).attr('href', 'logs?sayfa=1') });
// });





function openmodalsil(obj)
{
	$('#modallogsid2').val($(obj).data('id'));
	$('#sil').modal('show');

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

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


?>
<?php }?>
