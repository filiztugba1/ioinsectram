<?php
User::model()->login();
 $tranlateslanguage=  Translatelanguages::model()->findAll();	?>
<?php if (Yii::app()->user->checkAccess('managalanguages.view')){ ?>
<?php if (Yii::app()->user->checkAccess('managalanguages.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		
			<div class="card">
				 <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('New Language Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>	
						</div>
					 </div>
					 
				<form id="tranlatelanguages-form" action="/translate/translatelanguages/create" method="post">		
				<div class="card-content">
					<div class="card-body">
					
					
					<div class="row">
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Name');?>" name="Translatelanguages[name]">
                        </fieldset>
                    </div>

					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Title');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Title');?>" name="Translatelanguages[title]">
                        </fieldset>
                    </div>

						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label for="basicSelect"><?=t('Flag');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Flag');?>" name="Translatelanguages[flag]">
                        </fieldset>
                    </div>
				
					
					
					
					
					  	<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label class='hidden-sm hidden-xs' style='margin-top:11px' for="basicSelect"></label>
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
						 <h4 class="card-title"><?=t('LANGUAGE LIST');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Language');?> <i class="fa fa-plus"></i></button>
								</div>
							   
						</div>
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                             <th><?=t('NAME');?></th>
							 <th><?=t('TITLE');?></th>
							 <th><?=t('FLAG');?></th>
                            <th><?=t('PROCESS');?></th>
							
                          </tr>
                        </thead>
                        <tbody>
             				<?php foreach($tranlateslanguage as $translate):?>
                                <tr>
                                    <td><?=$translate->name;?></td>
									
								
									
									
									 <td><?=t($translate->title);?></td>
									 
									 <td><?=$translate->flag;?></td>
								
								
									<td>
										<?php if (Yii::app()->user->checkAccess('managalanguages.update')){ ?>	
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										 data-id="<?=$translate->id;?>"
										 data-name="<?=$translate->name;?>"
										 data-title="<?=$translate->title;?>"
										 data-flag="<?=$translate->flag;?>">
										 <i style="color:#fff;" class="fa fa-edit"></i></a>
										 <?php }?>
									
										<?php if (Yii::app()->user->checkAccess('managalanguages.delete')){ ?>	
										<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" 
										data-id="<?=$translate->id;?>">
										<i style="color:#fff;" class="fa fa-trash"></i></a>
										<?php }?>
									
									</td>
                                </tr>
						
								<?php endforeach;?>
						 
                        </tbody>
                        <tfoot>
                          <tr>
                            <th><?=t('NAME');?></th>
							 <th><?=t('TITLE');?></th>
							 <th><?=t('FLAG');?></th>
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

		
		
	
<?php if (Yii::app()->user->checkAccess('managalanguages.update')){ ?>		    
	
<!-- G�NCELLEME BA�LANGI�-->		
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Language Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="translatelanguages-form" action="/translate/translatelanguages/update?id=0" method="post">	
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modallanguageid" name="Translatelanguages[id]" value="0">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Name');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modallanguagename" placeholder="<?=t('Name');?>" name="Translatelanguages[name]" value="">
									</fieldset>
								</div>
				
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('title');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modallanguagetitle" placeholder="<?=t('title');?>" name="Translatelanguages[title]" value="">
									</fieldset>
								</div>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('Flag');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modallanguageflag" placeholder="Flag" name="Translatelanguages[flag]" value="">
									</fieldset>
								</div>
								
					
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
	<?php if (Yii::app()->user->checkAccess('managalanguages.delete')){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Language Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="translatelanguages-form" action="/translate/translatelanguages/delete?id=0" method="post">	
						
						<input type="hidden" class="form-control" id="modallanguageid2" name="Translatelanguages[id]" value="0">
								
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
	$('#modallanguageid').val($(obj).data('id'));
	$('#modallanguagename').val($(obj).data('name'));
	$('#modallanguagetitle').val($(obj).data('title'));
	$('#modallanguageflag').val($(obj).data('flag'));
	$('#duzenle').modal('show');
	
}

function openmodalsil(obj)
{
	$('#modallanguageid2').val($(obj).data('id'));
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


<?php }?>


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
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';?>