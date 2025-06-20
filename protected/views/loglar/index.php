<!-- super log baslangıc -->


<?
User::model()->login();
$ax= User::model()->userobjecty('');
if($ax->id==1)
	{?>
		 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-7 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('NON-CONFORMITY LOG LIST');?></h4>
						</div>
					</div>



                </div>

                <div class="card-content collapse show">

                  <div class="card-body card-dashboard">

                      <table  class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
						  <!--
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
						  -->
						  <th><?=t('PROCESS');?></th>
						  <th><?=t('OPERATION');?></th>
						 <th><?=t('NON-CONFORMITY NO');?></th>
							<th><?=t('WHO');?></th>
                            <th><?=t('TO WHO');?></th>
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('OPENING DATE');?></th>
							<th><?=t('ACTION DEFINITION');?></th>
							<th><?=t('DEADLINE');?></th>
							<th><?=t('CLOSED TIME');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('NON-CONFORMITY TYPE');?></th>



							<th><?=t('DEFINATION');?></th>

							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>





                          </tr>
                        </thead>
                        <tbody id='waypointsTable'>

							<?$loglar=Loglar::model()->findAll(array('condition'=>"tablename='conformity'"));?>
					 		<?php
								foreach($loglar as $loglarx){
								$x=json_decode($loglarx->data);
								$user=User::model()->find(array('condition'=>'id='.$x->userid));
								$client=Client::model()->find(array('condition'=>'id='.$x->clientid));
								$departman=Departments::model()->find(array('condition'=>'id='.$x->departmentid));
								$subdepartman=Departments::model()->find(array('condition'=>'id='.$x->subdepartmentid));
								$activitiondef=Conformityactivity::model()->find(array('condition'=>'conformityid='.$x->id,));
								$status=Conformitystatus::model()->find(array('condition'=>'id='.$x->statusid,));

								$type=Conformitytype::model()->find(array('condition'=>'id='.$x->type,));
								?>

								<tr>
									<td>
							<!--
							<a  class="btn btn-success btn-sm" onclick="openmodal(this)"
							 data-id="<?=$loglarx->id;?>" ><i style="color:#fff;" class="fa fa-reply"></i></a>
							 -->

							 	<a  class="btn btn-danger btn-sm" style='margin-top:2px' onclick="logsil(this)"
							 data-id="<?=$loglarx->id;?>" ><i style="color:#fff;" class="fa fa-trash"></i></a>
								  </td>
								  <td><?php if($loglarx->operation=='conformitystatusbutton'){echo t('update');}else{echo t($loglarx->operation);}?></td>
									<td><?=$x->numberid;?></td>
									<td><?=$user->name.' '.$user->surname;?></td>
									<td><?=$client->name;?></td>
									<td><?=$departman->name;?></td>
									<td><?=$subdepartman->name;?></td>

									<td><?=date('d:m:Y',$x->date);?></td>
									<td><?=$activitiondef->definition;?></td>
									<td><?=$activitiondef->date;?></td>
									<td><?php if($x->closedtime!=0 && $x->closedtime!='')date('d:m:Y',$x->closedtime);?></td>

									<td><?=$status->name;?></td>

									<td><?=$type->name;?></td>
									<td><?=$x->definition;?></td>

									<td><?=Conformityactivity::model()->find(array('condition'=>'conformityid='.$x->id,))->nokdefinition;?></td>
									<td><?=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$x->id,))->activitydefinition;?></td>
								</tr>
								<?php }?>

                       </tr>



                        </tbody>
                        <tfoot>
                          <tr>
							<th><?=t('PROCESS');?></th>
							<th><?=t('OPERATION');?></th>
							<th><?=t('NON-CONFORMITY NO');?></th>
							 <th><?=t('WHO');?></th>
                            <th><?=t('TO WHO');?></th>
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('OPENING DATE');?></th>
							<th><?=t('ACTION DEFINITION');?></th>
							<th><?=t('DEADLINE');?></th>
							<th><?=t('CLOSED TIME');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('NON-CONFORMITY TYPE');?></th>



							<th><?=t('DEFINATION');?></th>

							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>


                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
	<?php }?>

							  	<?php if($ax->id==1){?>

				<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="conformitylogsil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Activity Log Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="user-form" action="/loglar/delete/0" method="post">

					 <input type="hidden" class="form-control" id="modallogid" name="Loglar[id]" value="0">
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

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>
		<?php }?>


<script>

 function logsil(obj)
{
	$('#modallogid').val($(obj).data('id'));
	$('#conformitylogsil').modal('show');

}


$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

<?$whotable=User::model()->iswhotable();?>
$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[3,10,20,50,100, -1], [3,10,20,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			html:true,
			colvis: "<?=t('Columns Visibility');?>",
        },
				     "sDecimal": ",",
                     "sEmptyTable": "<?=t('Data is not available in the table');?>",
                     //"sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
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

		"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				// "targets": 0
			} ],
			// "order": [[ 4, 'asc' ]],



	 buttons: [

		 <?php if($yetki==1){?>
        {
            extend: 'copyHtml5',
            exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
		 },
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
				   text:'<?=t('PDF');?>',
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Non-Conformity \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?php if($whotable->isactive==1){echo $whotable->name;}?> \n',
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

			<?php }?>




        'colvis',
		'pageLength'
    ]


} );
<?
$ax= User::model()->userobjecty('');
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

 <?php

 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

?>
