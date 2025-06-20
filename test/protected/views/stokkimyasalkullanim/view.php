<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$where='stokkimyasalkullanimid='.$_GET['id'];
$stokkimyasalkullanim=Stokkimyasalkullanim::model()->find(array('condition'=>'id='.$_GET['id']));
$stokkimyasalkullanims=Stokkimyasalhedeflenenzararli::model()->findAll(array('condition'=>$where));
//$visittypes=Visittype::model()->findAll(array('order'=>'name ASC'));?>


<?php if (Yii::app()->user->checkAccess('medfirms.view')){ ?>
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Stok kimyasal kullanim',$stokkimyasalkullanim->kimyasaladi.' hedeflenen zararlı listesi',0,'stokkimyasalkullanim/view');?>
<?php if (Yii::app()->user->checkAccess('medfirms.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					<div class="col-md-6">
						<h4  class="card-title"><?=$stokkimyasalkullanim->kimyasaladi;?> hedef zararlı ekleme</h4>
					</div>
					<div class="col-md-6">
						<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
					</div>
				</div>
			</div>
			<form id="visittype-form" action="/Stokkimyasalkullanim/hedefzararliekle" method="post">
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<input type="hidden" class="form-control" name="Stokkimyasalkullanim[id]" value="<?=$_GET['id'];?>">
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
							<label for="basicSelect">Monitor Tipi</label>
							<fieldset class="form-group">
								<select class="custom-select block" id="monitortype" name="Stokkimyasalkullanim[mtype]" onchange="typepets()">
									<option value="">Seçiniz</option>
								<?php $mtypes=Monitoringtype::model()->findAll(array('condition'=>'active=1'));
									foreach($mtypes as $mtype)
										{?><option value="<?=$mtype->id;?>"><?=$mtype->name?></option><?php }?>
								</select>
							</fieldset>
							</div>

								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<label for="basicSelect">Hedef Canlı</label>
								<fieldset class="form-group">
									<select class="custom-select block" id="hedeflenencanli" name="Stokkimyasalkullanim[petsid]" disabled>
									<option value="">Seçiniz</option>
									</select>
								</fieldset>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
									<label for="basicSelect">Dozaj</label>
								 	<fieldset class="form-group">
									 	<input type="text" class="form-control" name="Stokkimyasalkullanim[dozaj]" value="0">
									</fieldset>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
									<fieldset class="form-group">
										<label for="basicSelect">Birim</label>
								 		<select class="custom-select block"  name="Stokkimyasalkullanim[olcubirimi]">
									 		<option value="Litre">Litre</option>
									 		<option value="Kilogram">Kilogram</option>
									 		<option value="Gram">Gram</option>
								 		</select>
							 		</fieldset>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect" class="hidden-xs hidden-sm" style="margin:11px"></label>
            				<fieldset class="form-group">
	                  	<div class="input-group-append" id="button-addon2" style="float: right;">
										     <button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
							      	</div>
            				</fieldset>
          			</div>
							</div>

					</div>
				</form>
			</div>
		</div><!-- form -->
	</div>
</div>
<?php }?>

<section id="html5">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						     <h4 class="card-title"><?=$stokkimyasalkullanim->kimyasaladi;?> hedeflenen zararlı listesi</h4>
						 </div>
						<?php if (Yii::app()->user->checkAccess('medfirms.create')){ ?>
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
									<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
										<button class="btn btn-info" id="createbutton" type="submit">Zararlı Ekle <i class="fa fa-plus"></i></button>
									</div>
							</div>
						<?php }?>
					</div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body card-dashboard">
              <table class="table table-striped table-bordered dataex-html5-export">
                <thead>
                    <tr>
											  <th>Monitor Tipi</th>
                      <th>Hedef Canlı</th>
							        <th>Dozaj</th>
                      <th>Birim</th>
                      <th><?=t('PROCESS');?></th>
                    </tr>
                  </thead>
                	<tbody>
	             		<?php foreach($stokkimyasalkullanims as $stokkimyasalkullanim):?>
		              <tr>
										<td><?=Monitoringtype::model()->find(array('condition'=>'id='.$stokkimyasalkullanim->monitortype))->name;?></td>
		                <td><?php										$petname=Pets::model()->find(array('condition'=>'id='.$stokkimyasalkullanim->petsid))->name;
										echo $petname;?></td>
		                <td><?=$stokkimyasalkullanim->dozaj;?></td>
		                <td><?=$stokkimyasalkullanim->olcubirimi;?></td>
		                <td>
											<?php if (Yii::app()->user->checkAccess('medfirms.update')){ ?>
												<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
		                    data-id="<?=$stokkimyasalkullanim->id;?>"
												data-mtype="<?=$stokkimyasalkullanim->monitortype;?>"
												data-petsid="<?=$stokkimyasalkullanim->petsid;?>"
												data-petname="<?=$petname;?>"
		                    data-dozaj="<?=$stokkimyasalkullanim->dozaj;?>"
		                    data-olcubirimi="<?=$stokkimyasalkullanim->olcubirimi;?>"
		                    data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"><i style="color:#fff;" class="fa fa-edit"></i></a>
											<?php }?>
											<?php if (Yii::app()->user->checkAccess('medfirms.delete')){ ?>
												<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)"
													data-petname="<?=$petname;?>"
													data-id="<?=$stokkimyasalkullanim->id;?>"
													data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
											<?php }?>
										</td>
		              </tr>
	            	<?php endforeach;?>
          		</tbody>
			        <tfoot>
			          <tr>
									<th>Monitor Tipi</th>
									<th>Hedef Canlı</th>
									<th>Dozaj</th>
									<th>Birim</th>
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
<?php if (Yii::app()->user->checkAccess('medfirms.update')){ ?>
<div class="form-group">
      <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning white">
                <h4 class="modal-title" id="petnameguncelleme"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
                </button>
            </div>
						<form id="visittype-form" action="/Stokkimyasalkullanim/hedefzararliguncelle" method="post">
 		 				<div class="card-content">
 		 					<div class="card-body">
 		 						<div class="row">
									<input type="hidden" class="form-control"  name="Stokkimyasalkullanim[id]" value='<?=$_GET["id"]?>'>
									<input type="hidden" class="form-control" id='stokkimyasalhedeflenenzararliid' name="Stokkimyasalhedeflenenzararli[id]">
 		 							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
 		 							<label for="basicSelect">Monitor Tipi</label>
 		 							<fieldset class="form-group">
 		 								<select class="custom-select block" id="monitortypeguncelle" name="Stokkimyasalkullanim[mtype]" onchange="typepetsguncelle()">
 		 									<option value="">Seçiniz</option>
 		 								<?php $mtypes=Monitoringtype::model()->findAll(array('condition'=>'active=1'));
 		 									foreach($mtypes as $mtype)
 		 										{?><option value="<?=$mtype->id;?>"><?=$mtype->name?></option><?php }?>
 		 								</select>
 		 							</fieldset>
 		 							</div>

 		 								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
 		 								<label for="basicSelect">Hedef Canlı</label>
 		 								<fieldset class="form-group">
 		 									<select class="custom-select block" id="hedeflenencanliguncelle" name="Stokkimyasalkullanim[petsid]" disabled>
 		 									<option value="">Seçiniz</option>
 		 									</select>
 		 								</fieldset>
 		 								</div>
 		 								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
 		 									<label for="basicSelect">Dozaj</label>
 		 								 	<fieldset class="form-group">
 		 									 	<input type="text" class="form-control" id="dozajguncelle" name="Stokkimyasalkullanim[dozaj]" value="0">
 		 									</fieldset>
 		 								</div>
 		 								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
 		 									<fieldset class="form-group">
 		 										<label for="basicSelect">Birim</label>
 		 								 		<select class="custom-select block" id="olcubirimiguncelle"  name="Stokkimyasalkullanim[olcubirimi]">
 		 									 		<option value="Litre">Litre</option>
 		 									 		<option value="Kilogram">Kilogram</option>
 		 									 		<option value="Gram">Gram</option>
 		 								 		</select>
 		 							 		</fieldset>
 		 								</div>
 		 								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
 		 									<label for="basicSelect" class="hidden-xs hidden-sm" style="margin:11px"></label>
 		             				<fieldset class="form-group">
 		 	                  	<div class="input-group-append" id="button-addon2" style="float: right;">
 		 										     <button class="btn btn-primary block-page" type="submit"><?=t('Update');?></button>
 		 							      	</div>
 		             				</fieldset>
 		           			</div>
 		 							</div>

 		 					</div>
 		 				</form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php }?>
<?php if (Yii::app()->user->checkAccess('medfirms.delete')){ ?>
	<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-danger white">
              <h4 class="modal-title" id="petnamesilme"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
              </button>
            </div>
						<form id="medfirms-form" action="/stokkimyasalkullanim/hedefzararlisil" method="post">
							<input type="hidden" class="form-control" id="modalid2" name="Stokkimyasalhedeflenenzararli[id]" value="0">
							<input type="hidden" class="form-control"  name="Stokkimyasalkullanim[id]" value='<?=$_GET["id"]?>'>
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
					</div>
        </div>
      </div>
    </div>
</div>


	<!-- delete all finish -->
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

function typepets()
{
	var x = document.getElementById("monitortype").value;
	$.post( "/stokkimyasalkullanim/monitorpets?id="+x).done(function( data ) {
		$( "#hedeflenencanli" ).prop( "disabled", false );
		$('#hedeflenencanli').html(data);
	});
}

function typepetsguncelle()
{
	var x = document.getElementById("monitortypeguncelle").value;
	$.post( "/stokkimyasalkullanim/monitorpets?id="+x).done(function( data ) {
		$( "#hedeflenencanliguncelle" ).prop( "disabled", false );
		$('#hedeflenencanliguncelle').html(data);
	});
}
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

	$('#stokkimyasalhedeflenenzararliid').val($(obj).data('id'));
	$('#monitortypeguncelle').val($(obj).data('mtype'));
	$('#petnameguncelleme').html($(obj).data('petname')+" için kimyasal güncelleme");
	$('#dozajguncelle').val($(obj).data('dozaj'));
	$('#olcubirimiguncelle').val($(obj).data('olcubirimi'));

	$.post( "/stokkimyasalkullanim/monitorpets?id="+$(obj).data('mtype')).done(function( data ) {
		$( "#hedeflenencanliguncelle" ).prop( "disabled", false );
		$('#hedeflenencanliguncelle').html(data);
		$('#hedeflenencanliguncelle').val($(obj).data('petsid'));
	});

	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#petnamesilme').html($(obj).data('petname')+" için kimyasal silme");
	$('#modalid2').val($(obj).data('id'));
	$('#sil').modal('show');

}

function authchange(data,permission,obj)
{
$.post( "?", { visittypeid: data, active: permission })
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
                 columns: [0,1,2]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder (<?=date("d-m-Y H:i:s");?>)\n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [0,1,2]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder (<?=date("d-m-Y H:i:s");?>)\n',
        },



		{
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Workorder MedFirms',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'MedFirms \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },

					{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 10,
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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';



?>
