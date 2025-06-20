<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$notifications=Notifications::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'createdtime ASC',
								   'condition'=>'userid='.$ax->id,
							   ));

						?>

<?php  $notificationsender=Notifications::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'createdtime ASC',
								   'condition'=>'sender='.$ax->id,
							   ));

						?>

<?php  $users=User::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'active=1',
							   ));

						?>

					
<?php if (Yii::app()->user->checkAccess('notifications.view')){ ?>
	<?php if (Yii::app()->user->checkAccess('notifications.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
			
			<div class="card">
				  <div class="card-header">
					 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					 <div class="col-md-6">
                  <h4  class="card-title"><?=t('New Notification Create');?></h4>
					</div>
					 <div class="col-md-6">
               	<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
						</div>	
                </div>
				 </div>
				 
				 <form id="notifications-form" action="/notifications/create" method="post">	
				<div class="card-content">
					<div class="card-body">
					
					
					<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('subject');?></label>
                        <fieldset class="form-group">
                          <input type="textrea" max="255" class="form-control" id="basicInput" placeholder="<?=t('subject');?>" name="Notifications[subject]">
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Users');?></label>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row" style="padding-top: 15px;padding-bottom: 15px;border: 1px solid #ccd6e6;border-radius: 10px;background: #f7f7f7;">
						<?php foreach($users as $user){?>
						  <div class="skin skin-square col-md-4 col-sm-12">
							<fieldset>
							  <input type="checkbox" name="recurdays[]" value="<?=$user->id;?>" id="input-<?=$user->id;?>">
							  <label for="input-<?=$user->id;?>"><?=$user->name.' '.$user->surname;?></label>
							</fieldset>

						</div>
						<?php }?>
					</div>
					</div>
				
						
					
                    </div>


				
				
				
					  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
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
						 <h4 class="card-title"><?=t('TRANSFER LIST');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('notifications.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Transfer');?> <i class="fa fa-plus"></i></button>
								</div>
							   
						</div>
						<?php }?>
					</div>
                </div>



      <div class="col-xl-12 col-lg-12">
              <div class="card">
                  <div class="card-content">
                  <div class="card-body">
                    <ul class="nav nav-tabs nav-underline">

                      <li class="nav-item">
                        <a class="nav-link active" id="baseIcon-tab21" data-toggle="tab" aria-controls="tabIcon21"
                        href="#tabIcon21" aria-expanded="true"><i class="fa fa-minus-circle"></i><?=t('Pending Transfers');?></a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab22" data-toggle="tab" aria-controls="tabIcon22"
                        href="#tabIcon22" aria-expanded="false"><i class="fa fa-times-circle"></i><?=t('Approved transfers');?></a>
                      </li>

					   <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab22" data-toggle="tab" aria-controls="tabIcon22"
                        href="#tabIcon22" aria-expanded="false"><i class="fa fa-check-circle"></i><?=t('Unapproved transfers');?></a>
                      </li>
                   
                    
                    </ul>


                    <div class="tab-content px-1 pt-1">
                      <div role="tabpanel" class="tab-pane active" id="tabIcon21" aria-expanded="true"
                      aria-labelledby="baseIcon-tab21">
							
							<!--gelen bildirimler ba�lang�� -->

					<table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                            <th><?=t('FROM BRANCH');?></th>
							<th><?=t('TO BRANCH');?></th>
							<th><?=t('CLIENT');?></th>
							<th><?=t('CLIENT BRANCH');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('PROCESS');?></th>
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($notifications as $notification):?>
                                <tr>
                                    <td><?=$notification->subject;?></td>
									
									

									<?php  $sender=User::model()->find(array('condition'=>'id='.$notification->sender));?>
									<td><?=$sender->name.' '.$sender->surname;?></td>
									<!--
									<?php  $userid=User::model()->find(array('condition'=>'id='.$notification->userid));?>
									<td><?=$userid->name.' '.$userid->surname;?></td>

									
									<td><?=date('d.m.Y H:i:s', $notification->readtime);?></td>
									-->
									<td><?=date('d.m.Y H:i:s', $notification->createdtime);?></td>
									<td>
								

								<?php if (Yii::app()->user->checkAccess('notifications.delete')){ ?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$notification->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
								<?php }?>

								
									
									</td>
                                </tr>
						
					<?php endforeach;?>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
                           <th><?=t('FROM BRANCH');?></th>
							<th><?=t('TO BRANCH');?></th>
							<th><?=t('CLIENT');?></th>
							<th><?=t('CLIENT BRANCH');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('PROCESS');?></th>
                          </tr>
                        </tfoot>
                      </table>


							<!--gelen bildirim biti�-->
					  </div>
					 

                       <div class="tab-pane" id="tabIcon22" aria-labelledby="baseIcon-tab22">
							
							<!--g�nderilen bildirim ba�lang�c-->

							 <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                            <th><?=t('SUBJECT');?></th>
							<th><?=t('RECEIVER');?></th>
							<!--
							
							<th><?=t('RECEIVER');?></th>
							<th><?=t('READ TIME');?></th>
							-->
							<th><?=t('CREATED TIME');?></th>
							
							<th><?=t('PROCESS');?></th>
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($notificationsender as $notificationsenderx):?>
                                <tr>
                                    <td><?=$notificationsenderx->subject;?></td>
									
									

									<?php  $sender=User::model()->find(array('condition'=>'id='.$notificationsenderx->sender));?>
									<td><?=$sender->name.' '.$sender->surname;?></td>
									<!--
									<?php  $userid=User::model()->find(array('condition'=>'id='.notificationsenderx>userid));?>
									<td><?=$userid->name.' '.$userid->surname;?></td>

									
									<td><?=date('d.m.Y H:i:s', $notificationsenderx->readtime);?></td>
									-->
									<td><?=date('d.m.Y H:i:s', $notificationsenderx->createdtime);?></td>
									<td>
									<?php if (Yii::app()->user->checkAccess('notifications.delete')){ ?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$notificationsenderx->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>

								
									
									</td>
                                </tr>
						
					<?php endforeach;?>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
                           <th><?=t('SUBJECT');?></th>
							<th><?=t('RECEIVER');?></th>
							<th><?=t('CREATED TIME');?></th>
							<th><?=t('PROCESS');?></th>
                          </tr>
                        </tfoot>
                      </table>

							<!--g�nderilen bildirim biti�-->
					  </div>
					
					</div>
				</div>
			</div>
			</div>
				
             <!--
			 <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                     
                  </div>
                </div>

			-->

              </div>
            </div>
          </div>
        </section>
		
		
		
	
	
<?php if (Yii::app()->user->checkAccess('notifications.delete')){ ?>
	
	<!--S�L BA�LANGI�-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Certificate Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
				<!--form baslang��-->						
						<form id="notifications-form" action="/notifications/delete/0" method="post">	
						
						<input type="hidden" class="form-control" id="modalnotificateid2" name="Notifications[id]" value="0">
								
                            <div class="modal-body">
							
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Do you want to delete?');?></h5>
								</div>
				
								
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger" type="submit"><?=t('Delete');?></button>
                                </div>
								
						</form>
									
				<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

			  
	<!-- S�L B�T�� -->			
	
<?php }}?>

	


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
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });



function openmodalsil(obj)
{
	$('#modalnotificateid2').val($(obj).data('id'));
	$('#sil').modal('show');
	
}




$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[50,100, -1], [50,100, "All"]],
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
