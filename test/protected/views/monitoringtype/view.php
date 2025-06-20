<?php
User::model()->login();
$ax= User::model()->userobjecty('');

	$mpnitoringpets=Monitoringtypepets::model()->findAll(array(
								   'condition'=>'monitoringtypeid='.$_GET['id'],
							   ));
							   
					
							   
							   ?>	
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		
			<div class="card">
				 <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Pest Identification');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>	
						</div>
					 </div>
					 
				<form id="pets-form" action="/monitoringtypepets/create" method="post">		
				<div class="card-content">
					<div class="card-body">
					
					
					<div class="row">

					<input type="hidden" class="form-control" id="basicInput"  name="Monitoringtypepets[monitoringtypeid]" value="<?=$_GET['id'];?>">
				
				

					<?php						$pets=Pets::model()->findAll(array('order'=>'name ASC'));?>
				
				
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Priority');?></label>
                        <fieldset class="form-group">
						
                          <select class="select2" style="width:100%" id="modalpriority" name="Monitoringtypepets[petsid]">
							 <option value="0"><?=t('Select');?></option>
								  <?php foreach($pets as $pet){?>
									<option value="<?=$pet->id;?>"><?=$pet->name;?></option>
									<?php }?>
							</select>
                        </fieldset>
                    </div>
					
					


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Quantity to be input? FIND THIS');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Monitoringtypepets[isactive]">
                            <option value="1" selected><?=t('Yes');?></option>
                            <option value="0"><?=t('No');?></option>
                          </select>
                        </fieldset>
                    </div>



					
					  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
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
						 <h4 class="card-title"><?=t('Monitoring Point Identification List');?></h4>
						</div>

				
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Pest');?> <i class="fa fa-plus"></i></button>
								</div>
							   
						</div>
					
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
                             <th><?=t('NAME');?></th>
							 <th><?=t('QALITY');?></th>
                            <th><?=t('PROCESS');?></th>
							
                          </tr>
                        </thead>
                        <tbody>
             				<?php foreach($mpnitoringpets as $mpnitoringpet):?>
                                <tr>

								<?php								$pets=Pets::model()->find(array(
								   'condition'=>'id='.$mpnitoringpet->petsid,
							   ));
							   ?>
							   <td><input type="checkbox" name="Monitoringtypepets[id][]" class='sec' value="<?=$mpnitoringpet->id;?>"></td>
                                    <td><?=t($pets->name);?></td>
									
								
									 	
								<td> 
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery"  data-size="sm" class="switchery" data-id="<?=$mpnitoringpet->id;?>"  <?php if($mpnitoringpet->isactive==1){echo "checked";}?>  />
									</div>								
								</td>
								
								
									<td>
										
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										 data-id="<?=$mpnitoringpet->id;?>"
										 data-name="<?=$pets->id;?>" 
										 data-isactive="<?=$mpnitoringpet->isactive;?>" 
										 ><i style="color:#fff;" class="fa fa-edit"></i></a>
								
											
										<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$mpnitoringpet->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									
									</td>
                                </tr>
						
								<?php endforeach;?>
						 
                        </tbody>
                        <tfoot>
                          <tr>
						   <th style='width:1px;'>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete selected');?>"><i class="fa fa-trash"></i></button>
								</div>
							</th>
                            <th><?=t('NAME');?></th>
							 <th><?=t('QALITY');?></th>
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

		
		
	
		

<!-- G�NCELLEME BA�LANGI�-->		
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Pest Identification Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="sector-form" action="/monitoringtypepets/update/0" method="post">	
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalpetsid" name="Monitoringtypepets[id]" value="0">

							
										<?php						$pets=Pets::model()->findAll(array('order'=>'name ASC'));?>
				
				
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Priority');?></label>
                        <fieldset class="form-group">
						
                          <select class="select2" style="width:100%" id="modalpetsname" name="Monitoringtypepets[petsid]">
								  <?php foreach($pets as $pet){?>
									<option value="<?=$pet->id;?>"><?=$pet->name;?></option>
									<?php }?>
							</select>
                        </fieldset>
                    </div>


								<input type="hidden" class="form-control" id="basicInput"  name="Monitoringtypepets[monitoringtypeid]" value="<?=$_GET['id'];?>">
				
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Quantity to be input? FIND THIS');?></label>
									<fieldset class="form-group">
										 <select class="custom-select block" id="modalsectoractive" name="Monitoringtypepets[isactive]">
											<option value="1"><?=t('Yes');?></option>
											<option value="0"><?=t('No');?></option>
										 </select>
									</fieldset>
								</div>
								
						
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning block-page" type="submit"><?=t('Update');?></button>
                                </div>
								
						</form>
									
									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
	<!-- G�NCELLEME B�T��-->

	
	<!--S�L BA�LANGI�-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Pest Identification Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="sector-form" action="/monitoringtypepets/delete/0" method="post">	
						
						<input type="hidden" class="form-control" id="modalpetsid2" name="Monitoringtypepets[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput"  name="Monitoringtypepets[monitoringtypeid]" value="<?=$_GET['id'];?>">
								
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
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitoring Type Pets Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
				<!--form baslang��-->						
						<form action="/monitoringtypepets/deleteall" method="post">	
						
						<input type="hidden" class="form-control" id="modalid3" name="Monitoringtypepets[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput"  name="Monitoringtypepets[monitoringtypeid]" value="<?=$_GET['id'];?>">
								
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

 //delete all start
$(document).ready(function(){
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
	$('#modalpetsid').val($(obj).data('id'));
	$('#modalpetsname').val($(obj).data('name'));
	$('#modalpetsname').select2('destroy');
	$('#modalpetsname').select2({
		closeOnSelect: false,
			 allowClear: true
	});
	$('#modalpetsactive').val($(obj).data('isactive'));
	$('#duzenle').modal('show');
	
}

function openmodalsil(obj)
{

	$('#modalpetsid2').val($(obj).data('id'));
	$('#sil').modal('show');
	
}


function authchange(data,permission,obj)
{
$.post( "?", { petsid: data, active: permission })
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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';
  

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';?>