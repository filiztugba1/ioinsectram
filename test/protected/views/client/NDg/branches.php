<?php
User::model()->login();
$ax= User::model()->userobjecty('');
if(isset($_GET['firmid']) && $_GET['firmid']!=0)
{
	$ax->branchid=$_GET['firmid'];
}
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0',
							   ));

						?>

<?php    $monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$_GET['id'],
							   ));


						?>

<?php    $department=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
							   ));

if($ax->mainclientbranchid!=$ax->clientbranchid)
{
	$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
}
if($ax->mainclientbranchid==$ax->clientbranchid)
{
	$departmentk=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
	if(count($departmentk)!=0)
	{
		$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
	}
}


						?>

<?php if (Yii::app()->user->checkAccess('client.branch.detail.view')){ ?>

<?=User::model()->geturl('Client','Branch Homepage',$_GET['id'],'client',0,$ax->branchid);?>


<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
			<div class="card-header" style="">
					<ul class="nav nav-tabs">

					<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
                      <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?php $say=User::model()->findAll(array('condition'=>'clientbranchid='.$_GET['id']));
									echo count($say);?>
									</span><?=t('Staff');?>

							</a>
                      </li>
					<?php }?>
					<?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>
					  <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/departments?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $department);?></span><?=t('Departments');?></a></a>
                      </li>
					<?php }?>
					<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
					    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a></a>
                      </li>
					  <?php }?>
					<?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

					      <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/reports?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a></a>
                      </li>
					  <?php }?>
					<?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>

					      <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a></a>
                      </li>
					  <?php }?>
					<?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

					        <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?> </a></a>
                      </li>
					 <?php }?>

					<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a></a>
                      </li>
					 <?//}?>


                    </ul>
				</div>
				<div class="card-content">
				<div class="card-body">
					<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="row">

						<div class="col-xl-8 col-lg-8 col-md-8">
						<div class="row">
							<div class="col-md-4" style='text-align: center;'>
                          <!-- Floating button Regular with text -->
								 <a href="/client/branches?id=<?=$_GET['id'];?>&&type=1" class="btn btn-float btn-float-lg btn-secondary" style="padding:30px 44px 30px 44px;"><i class="fa fa-smile-o"></i><span><?=t('Closed');?></span></a>
							 </div>
							<div class="col-md-4" style='text-align: center;'>
								 <a href="/client/branches?id=<?=$_GET['id'];?>&&type=0" class="btn btn-float btn-float-lg btn-pink"  style="padding:30px 40px 30px 40px;"><i class="fa fa-frown-o"></i><span><?=t('Pending');?></span></a>
							 </div>
							<div class="col-md-4" style='text-align: center;'>
								<a href="/client/branches?id=<?=$_GET['id'];?>&&type=2" class="btn btn-float btn-float-lg btn-cyan"  style="padding:30px;"><i class="fa fa-meh-o"></i><span><?=t('Completed');?></span></a>
							</div>
						</div>
						</div>


						 <?php  $clientview=Client::model()->find(array('condition'=>'id='.$_GET['id'],));?>


					 <div class="col-md-4">
						<div class="col-md-12" style="padding: 20px;margin-top: 9px;border: 1px solid #ecf0f7;border-radius: 4px;">
								<h6><?=$clientview->name;?></h6>
									<br><small class="text-muted"><b><?=t('Tax No');?>:</b> <?=$clientview->taxno;?></small>
									<br><small class="text-muted"><b><?=t('Tax Office');?>:</b> <?=$clientview->taxoffice;?></small><br>				</div>
					 </div>


						 <div class="col-md-12">
						<div class="col-md-12" style="padding: 20px;margin-top: 9px;border: 1px solid #ecf0f7;border-radius: 4px;">


										<div class="table-responsive">
										<?php


								if(!isset($_GET['type']))
								 {
									 	  $comformity=Conformity::model()->findAll(array(
											   #'select'=>'id,name,',
											   #'limit'=>'5',
											   'order'=>'date ASC',
											   'condition'=>'clientid='.$_GET['id'],
										   ));
								 }
								 else
								 {
									  $comformity=Conformity::model()->findAll(array(
											   #'select'=>'id,name,',
											   #'limit'=>'5',
											   'order'=>'date ASC',
											   'condition'=>'statusid='.$_GET['type'].' and  clientid='.$_GET['id'],
										   ));
								 }

										?>

					<div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table  class="table table-striped table-bordered dataex-html5-export">
											<thead>
											  <tr>
												<th><?=t('Client Name');?></th>
												<th><?=t('Date');?></th>
												<th><?=t('Type');?></th>
												<th><?=t('Etkinlik');?></th>
												<th><?=t('Process');?></th>

											  </tr>
											</thead>
											<tbody>
											<?php foreach($comformity as $cm){?>
											  <tr>

											  <?php												$cc=Client::model()->findbypk($cm->clientid);


												  ?>
												<td><?php if($cc){ echo $cc->name; }else{ echo '-';} ?></td>
											  <td><?php
												  echo date('Y-m-d H:i',$cm->date);
												  // Generalsettings::model()->dateformat($cm->date);?></td>

												<?php    $type=Conformitytype::model()->find(array(
													   'condition'=>'id='.$cm->type,
												   ));

												?>

												<td><?=t($type->name);?></td>

												<td><?=Conformitystatus::model()->findbypk($cm->statusid)->name?></td>
												<td>
													<a href="/conformity/activity/<?=$cm->id;?>" class="btn btn-info btn-sm" data-id="<?=$cm->id;?>"><i style="color:#fff;" class="fa fa-info"></i></a>

												</td>

											  </tr>
											  <?php }?>

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

	</div><!-- form -->
	</div>


	<?php }?>

		<script>
	$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

<?php $whotable=User::model()->iswhotable();?>
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
			html:true,
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

		"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				// "targets": 0
			} ],
			"order": [[ 4, 'asc' ]],



	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
               columns: [ 0,1,2,3]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3]
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
               columns: [ 0,1,2,3]
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


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';
?>
