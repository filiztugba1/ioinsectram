<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$packages=  Firmapackages::model()->findAll();	?>

<?php if (Yii::app()->user->checkAccess('packages.view')){?>
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Firma User Packages Settings','',0,'packages');?>
<?php if (Yii::app()->user->checkAccess('packages.create')){?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Firma Personel Ayarı Ekle');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="packages-form" action="/firmapackages/create" method="post">
				<div class="card-content">
					<div class="card-body">


					<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
									<label for="basicSelect"><?=t('Firm');?></label>
									<fieldset class="form-group">
										<select class="select2" style="width:100%" id="firm" name="Firmapackages[firmid]" >
											<option value="0">Please Chose</option>
												<?
												$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
												 foreach($firm as $firmx){?>
												<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
												 <?php }?>
										</select>
									</fieldset>
								</div>

					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Firm Staff number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="basicInput" placeholder="<?=t('Staff number');?>" name="Firmapackages[maxfirmstaff]">
                        </fieldset>
                    </div>

					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Firm Admin number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="basicInput" placeholder="<?=t('Admin number');?>" name="Firmapackages[maxfirmadmin]" >
                        </fieldset>
                    </div>



					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Branch Staff number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="basicInput" placeholder="<?=t('Staff number');?>" name="Firmapackages[maxtech]">
                        </fieldset>
                    </div>

					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Branch Admin number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="basicInput" placeholder="<?=t('Admin number');?>" name="Firmapackages[maxadmin]" >
                        </fieldset>
                    </div>

					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('File size');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="basicInput" placeholder="<?=t('File size');?>" name="Firmapackages[maxfile]" >
                        </fieldset>
                    </div>
					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style='float:right'>
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
<?php }?>


	<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('Firma Personel Ayar Listesi');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('packages.create')){?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Package');?> <i class="fa fa-plus"></i></button>
								</div>

						</div>
						<?php }?>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive" >
                        <thead>
                          <tr>
						     <th><?=t('Firm Name');?></th>
							 <th><?=t('FIRM STAFF NUMBER');?></th>
							 <th><?=t('FIRM ADMIN NUMBER');?></th>
							 <th><?=t('BRANCH STAFF NUMBER');?></th>
							<!-- <th><?=t('BRANCH ADMIN NUMBER');?></th> -->
							 <th><?=t('FILE SIZE');?></th>
                            <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($packages as $package):?>
                                <tr>
								     <td><?
									 $firm=Firm::model()->find(array(
								   'condition'=>'id=:firmid','params'=>array('firmid'=>$package->firmid)
							   ));
									 echo $firm->name;?></td>
									<td><?php if($package->maxfirmstaff==-1){echo t('Unlimited');}else{echo $package->maxfirmstaff;}?></td>
									<td><?php if($package->maxfirmadmin==-1){echo t('Unlimited');}else{echo $package->maxfirmadmin;}?></td>
									<td><?php if($package->maxtech==-1){echo t('Unlimited');}else{echo $package->maxtech;}?></td>
									<!-- <td><?php if($package->maxadmin==-1){echo t('Unlimited');}else{echo $package->maxadmin;}?></td> -->
									<td><?php if($package->maxfile==-1){echo t('Unlimited');}else{echo $package->maxfile.' '.t('mb');}?></td>




							

									<td>
									<?php if (Yii::app()->user->checkAccess('packages.update')){?>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?=$package->id;?>" data-firmid="<?=$package->firmid;?>"
										data-maxfirmadmin="<?=$package->maxfirmadmin;?>"
										data-maxfirmstaff="<?=$package->maxfirmstaff;?>"
										data-maxtech="<?=$package->maxtech;?>"
										data-maxadmin="<?=$package->maxadmin;?>"
										data-maxfile="<?=$package->maxfile;?>"
										data-active="<?=$package->isactive;?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"
										><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>

											<!--   -->

									<?php if (Yii::app()->user->checkAccess('packages.delete')){?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$package->id;?>"
									data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"
									><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>

									</td>
                                </tr>

								<?php endforeach;?>


                        </tbody>
                        <tfoot>
                          <tr>
						   
							<th><?=t('Firm Name');?></th>
<th><?=t('FIRM STAFF NUMBER');?></th>
<th><?=t('FIRM ADMIN NUMBER');?></th>
<th><?=t('BRANCH STAFF NUMBER');?></th>
<!-- <th><?=t('BRANCH ADMIN NUMBER');?></th> -->
<th><?=t('FILE SIZE');?></th>
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


	<?php if (Yii::app()->user->checkAccess('packages.update')){?>

<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Package Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="packages-form" action="/firmapackages/update" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalpackageid" name="Firmapackages[id]" value="0">
									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('Firm');?></label>
									<fieldset class="form-group">
										<select class="select2" style="width:100%" id="modalfirm" name="Firmapackages[firmid]" >
											<option value="0">Please Chose</option>
												<?
												$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
												 foreach($firm as $firmx){?>
												<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
												 <?php }?>
										</select>
									</fieldset>
								</div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Firm Staff number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="modalfirmstaff" placeholder="<?=t('Firm Staff number');?>" name="Firmapackages[maxfirmstaff]">
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Firm Admin number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="modalfirmadmin" placeholder="<?=t('Firm Admin number');?>" name="Firmapackages[maxfirmadmin]" >
                        </fieldset>
                    </div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Branch Staff number');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="modalmaxtech" placeholder="<?=t('Branch Staff number');?>" name="Firmapackages[maxtech]">
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<!-- <label for="basicSelect"><?=t('Branch Admin number');?></label> -->
                        <fieldset class="form-group">
                          <input type="hidden"  class="form-control" min='-1' id="modalmaxadmin" placeholder="<?=t('Branch Admin number');?>" name="Firmapackages[maxadmin]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('File size');?></label>
                        <fieldset class="form-group">
                          <input type="number" class="form-control" min='-1' id="modalmaxfile" placeholder="<?=t('File size');?>" name="Firmapackages[maxfile]" >
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

<?php }?>
<!-- G�NCELLEME BA�LANGI�-->
	<!--S�L BA�LANGI�-->
<?php if (Yii::app()->user->checkAccess('packages.delete')){?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Package Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="package-form" action="/firmapackages/delete" method="post">

						<input type="hidden" class="form-control" id="modalpackageid2" name="Firmapackages[id]" value="0">

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
	$('#modalpackageid').val($(obj).data('id'));
	$('#modalfirm').val($(obj).data('firmid'));
	$('#modalfirm').select2('destroy');
				$('#modalfirm').select2({
					closeOnSelect: false,
						 allowClear: true
				});
	$('#modalmaxtech').val($(obj).data('maxtech'));
	$('#modalmaxadmin').val($(obj).data('maxadmin'));
	$('#modalmaxfile').val($(obj).data('maxfile'));
	$('#modalfirmstaff').val($(obj).data('maxfirmstaff'));
	$('#modalfirmadmin').val($(obj).data('maxfirmadmin'));
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modalpackageid2').val($(obj).data('id'));
	$('#sil').modal('show');

}

function authchange(data,permission,obj)
{
$.post( "?", { packageid: data, active: permission })
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
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Pdf');?>',
			className: 'd-none d-sm-none d-md-block',
        },
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
<style>
#waypointsTable tr:hover {
    background-color:#ccdcf7;
}
.select2-selection__choice{
	    min-width: 127px !important;
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


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';

?>
