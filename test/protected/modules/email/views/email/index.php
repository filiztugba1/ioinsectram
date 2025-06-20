<?php 
User::model()->login();
$email=Email::model()->findAll();?>

<?php if (Yii::app()->user->checkAccess('email.recipiant.information.view')){?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
				
			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Email Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>	
						</div>
					 </div>
					 
				<form id="firm-form" action="/email/email/create" method="post">
				<div class="card-content">
					<div class="card-body">
					
					
					<div class="row">

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Smtp Host');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Smtp Host');?>" name="Email[smtphost]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Port');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Port');?>" name="Email[port]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Email');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Email');?>" name="Email[email]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Password');?>" name="Email[password]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('From Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('From Name');?>" name="Email[fromname]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('From Email');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('From Email');?>" name="Email[fromemail]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Is Default');?></label>
									<fieldset class="form-group">
										 <select class="custom-select block"  name="Email[isdefault]">
											<option value="1"><?=t('Active');?></option>
											<option value="0"><?=t('Passive');?></option>
										 </select>
									</fieldset>
					</div>





					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
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
						 <h4 class="card-title"><?=t('EMAIL LIST');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Email');?> <i class="fa fa-plus"></i></button>
								</div>
							   
						</div>
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                             <th><?=t('SMTP HOST');?></th>
							 <th><?=t('PORT');?></th>
							 <th><?=t('EMAIL');?></th>
							 <th><?=t('FROM NAME');?></th>
							 <th><?=t('FROM EMAIL');?></th>
							  <th><?=t('IS DEFAULT');?></th>
                            <th><?=t('PROCESS');?></th>
							
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($email as $emailx):?>
                                <tr>
                                    <td><?=$emailx->smtphost;?></td>
									<td><?=$emailx->port;?></td>
									<td><?=$emailx->email;?></td>
									<td><?=$emailx->fromname;?></td>
									<td><?=$emailx->fromemail;?></td>
									
								<td> 
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$emailx->id;?>"  <?php if($emailx->isdefault==1){echo "checked";}?> />
									</div>								
								</td>

									
									<td>
								

								<?php if (Yii::app()->user->checkAccess('email.recipiant.information.update')){?>
									<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
									data-id="<?=$emailx->id;?>"
									data-smtphost="<?=$emailx->smtphost;?>"
									data-port="<?=$emailx->port;?>"
									data-email="<?=$emailx->email;?>"
									data-isdefault="<?=$emailx->isdefault;?>"
									data-password="<?=$emailx->password;?>"
									data-fromname="<?=$emailx->fromname;?>"
									data-fromemail="<?=$emailx->fromemail;?>"

									
									><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('email.recipiant.information.delete')){?>
									
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$emailx->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>
									
									</td>
                                </tr>
						
								<?php endforeach;?>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
                            <th><?=t('SMTP HOST');?></th>
							 <th><?=t('PORT');?></th>
							 <th><?=t('EMAIL');?></th>
							 <th><?=t('FROM NAME');?></th>
							 <th><?=t('FROM EMAIL');?></th>
							  <th><?=t('IS DEFAULT');?></th>
                            <th><?=t('PROCESS');?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

		
	
		
<?php if (Yii::app()->user->checkAccess('email.recipiant.information.update')){?>
<!-- G�NCELLEME BA�LANGI�-->		
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Email Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="email-form" action="/email/email/update/0" method="post">	
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalemailid" name="Email[id]" value="0">
								
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Smtp Host');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalemailsmtphost" placeholder="<?=t('Smtp Host');?>" name="Email[smtphost]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Port');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalemailport" placeholder="<?=t('Port');?>" name="Email[port]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Email');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalemail" placeholder="<?=t('Email');?>" name="Email[email]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalemailpassword" placeholder="<?=t('Password');?>" name="Email[password]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('From Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalemailfromname" placeholder="<?=t('From Name');?>" name="Email[fromname]" requred>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('From Email');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalemailfromemail" placeholder="<?=t('From Email');?>" name="Email[fromemail]" requred>
                        </fieldset>
                    </div>

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Active');?></label>
									<fieldset class="form-group">
										 <select class="custom-select block" id="modalemailisdefault"  name="Email[isdefault]">
											<option value="1"><?=t('Active');?></option>
											<option value="0"><?=t('Passive');?></option>
										 </select>
									</fieldset>
					</div>

				
							


                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning" type="submit"><?=t('Update');?></button>
                                </div>
								
						</form>
									
									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>	
	
	<!-- G�NCELLEME B�T��-->	
	<!--S�L BA�LANGI�-->
	<?php if (Yii::app()->user->checkAccess('email.recipiant.information.delete')){?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Email Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="email-form" action="/email/email/delete/0" method="post">	
						
						<input type="hidden" class="form-control" id="modalemailid2" name="Email[id]" value="0">
								
                            <div class="modal-body">
							
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>
				
								
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
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
	<?php }?>
<?php }?>

<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}
</style>
<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });
 
function openmodal(obj)
{
	$('#modalemailid').val($(obj).data('id'));
	$('#modalemailsmtphost').val($(obj).data('smtphost'));
	$('#modalemailport').val($(obj).data('port'));
	$('#modalemail').val($(obj).data('email'));
	$('#modalemailpassword').val($(obj).data('password'));
	$('#modalemailfromname').val($(obj).data('fromname'));
	$('#modalemailfromemail').val($(obj).data('fromemail'));
	$('#modalemailisdefault').val($(obj).data('isdefault'));

	$('#duzenle').modal('show');
	
}

function openmodalsil(obj)
{
	$('#modalemailid2').val($(obj).data('id'));
	$('#sil').modal('show');
	
}


function authchange(data,permission,obj)
{
$.post( "?", { emailid: data, active: permission })
  .done(function( returns ) {
	  toastr.success("Success");
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
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 5 ]
            },
			text:'<?=t('Pdf');?>',
			className: 'd-none d-sm-none d-md-block',
        },
        'colvis',
		'pageLength'
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



?>