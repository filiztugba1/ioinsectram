<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		
			<div class="card">
				     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Non-Conformity Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>	
						</div>
					 </div>
				 
				 <form id="education-form" action="/education/create" method="post">		
				<div class="card-content">
					<div class="card-body">
					
					
					<div class="row">
				
					<!--
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect">Client</label>
							 <select class="select2 form-control">
								<option value="AK">Please Chose</option>
							</select>
                    </div>
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect">Department</label>
							 <select class="select2 form-control">
								<option value="AK">Please Chose</option>
							</select>
                    </div>
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect">Sub-department</label>
							 <select class="select2 form-control">
								<option value="AK">Please Chose</option>
							</select>
                    </div>
					
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect">Non-Conformity Type</label>
							 <select class="select2 form-control">
								<option value="AK">Please Chose</option>
							</select>
                    </div>
					
				
					
					
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect">Non-Conformity Status</label>
							 <select class="select2 form-control">
								<option value="AK">Please Chose</option>
							</select>
                    </div>
					
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect">Priority</label>
							 <select class="select2 form-control">
								<option value="AK">Please Chose</option>
							</select>
                    </div>
					-->
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Date');?></label>
                          <input type="date"  class="form-control"  placeholder="<?=t('Date');?>" name="Userinfo[leave_description]">
                        </fieldset>
                    </div>
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Upload File');?></label>
                          <input type="file"  class="form-control"  placeholder="<?=t('Leave Description');?>" name="Userinfo[leave_description]">
                        </fieldset>
                    </div>
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Detailed');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Detailed');?>" name="Userinfo[leave_description]"></textarea>
                        </fieldset>
                    </div>
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Userinfo[leave_description]"></textarea>
                        </fieldset>
                    </div>
					
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Userinfo[leave_description]"></textarea>
                        </fieldset>
                    </div>
					
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Userinfo[leave_description]"></textarea>
                        </fieldset>
                    </div>
					      
				
				
					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">
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
	
	 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('NON-CONFORMITY LIST');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Non-Conformity');?> <i class="fa fa-plus"></i></button>
								</div>
							   
						</div>
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                            <th><?=t('PRO');?></th>
                            <th><?=t('CLIENT');?></th>
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('DATE');?></th>
                            <th><?=t('PROCESS');?></th>
							
                          </tr>
                        </thead>
                        <tbody>
                         <tr>
                     
                             <td>Safran Çevre Sağlık</td>
									<td>Kerevitaş Akçalar</td>
									<td>DMS</td>
									<td>Dış Alan</td>
									<td>10.04.2018</td>
									<!--
									<td>-</td>
									
									<td>OK - Completed</td>
									<td>Çevresel Risk</td>
									-->
									<td>
						
										<div class="btn-group mr-1 mb-1">
										  <button type="button" class="btn btn-danger btn-block dropdown-toggle" data-toggle="dropdown"
										  aria-haspopup="true" aria-expanded="false">
											<?=t('Process');?>
										  </button>
										  <div class="dropdown-menu open-left arrow">
											<button class="dropdown-item" type="button"><?=t('Activity');?></button>
												<div class="dropdown-divider" style="border-top:1px solid #eceef1;"></div>
											<button class="dropdown-item" type="button"><?=t('Edit');?></button>
												<div class="dropdown-divider" style="border-top:1px solid #eceef1;"></div>
											<button class="dropdown-item" type="button"><?=t('Delete');?></button>
										
										
										  </div>
										</div>
                     


										</td>
						
                       </tr>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
                            <th><?=t('PRO');?></th>
                            <th><?=t('CLIENT');?></th>
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('DATE');?></th>
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
        <!--/ HTML5 export buttons table -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle();
 });
 $("#cancel").click(function(){
        $("#createpage").hide();
 });

 
 function sec(obj)
{
	$('#modalclientid').val($(obj).data('id'));
	$('#modalclientname').val($(obj).data('name'));
	$('#modalclienttitle').val($(obj).data('title'));
	$('#modalclienttaxoffice').val($(obj).data('taxoffice'));
	$('#modalclienttaxno').val($(obj).data('taxno'));
	$('#modalclientactive').val($(obj).data('active'));
	$('#modalclientbranchid').val($(obj).data('branchid'));
	$('#duzenle').modal('show');
	
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
                '-1': "<?=t('Tout afficher');?>"
            },
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
	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Copy');?>',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            },
			text:'<?=t('Excel');?>',
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
 <?php
 
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/jszip.min.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/pdfmake.min.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/vfs_fonts.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/buttons.html5.min.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/buttons.print.min.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/buttons.colVis.min.js;';
#Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/tables/datatables-extensions/datatable-button/datatable-html5.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/vendors.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';



?>