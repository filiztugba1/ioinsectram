<?php
User::model()->login();
$ax= User::model()->userobjecty('');


$genelIcerik=GenelIcerik::model()->findAll();	?>


<div id="createpage" >
<div class="card col-xl-12 col-lg-12 col-md-12">
	<div class="card-header">
		<div class="row">
			<div class="col-md-6">
				<h4  class="card-title"><?=t('Genel İçerik');?></h4>
			</div>
			<div class="col-md-6">
				<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
			</div>
		</div>
	</div>
	<form id="genelicerik-form" action="/web/create" method="post">
		<div class="card-content">
			<div class="card-body">
				<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Genel İçerik Baslik');?></label>
							<fieldset class="form-group">
							<input placeholder="<?=t('Genel İçerik Baslik');?>" class="form-control" name="GenelIcerik[baslik]"  type="text" />
							</fieldset>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<fieldset class="form-group">
						<label for="basicSelect"><?=t('Genel İçerik İçerik');?></label>
								 <textarea class="ckeditor" name="GenelIcerik[icerik]" placeholder="<?=t('Genel İçerik İçerik');?>"></textarea>
								<script>
								CKEDITOR.replace( 'modalgenelicerik',
										{
										toolbar : 'MyToolbar'
										});
								</script>
					</fieldset>
					</div>
					<button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>


				</div>
			</div>
	</form>
	</div>
</div>
</div>

<section id="html5">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
						<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
					   	<h4 style class="card-title"><?=t('Genel Liste');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Genel İçerik Ekle');?> <i class="fa fa-plus"></i></button>
								</div>
						</div>
					</div>
        </div>
				<div class="card-content collapse show">
        	<div class="card-body card-dashboard">
						<table class="table table-striped table-bordered dataex-html5-export">
              <thead>
              <tr>
						  	<th><?=t('BAŞLIK');?></th>
								<th><?=t('İCERİK');?></th>
								<th><?=t('KAYIT TARİHİ');?></th>
								<th><?=t('PROCESS');?></th>
             </tr>
            </thead>
            <tbody>
            <?php foreach($genelIcerik as $genelIcerikx):?>
              <tr>
								<td><?=t($genelIcerikx->baslik);?></td>

								<td><?=t($genelIcerikx->icerik);?></td>

								<td><?=$genelIcerikx->kayit_tarihi;?></td>
								<td>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?=$genelIcerikx->genel_icerik_no;?>" data-baslik="<?=$genelIcerikx->baslik;?>" data-icerik='<?=$genelIcerikx->icerik;?>'
										 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"
										 ><i style="color:#fff;" class="fa fa-edit"></i></a>


									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$genelIcerikx->genel_icerik_no;?>"
									 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"><i style="color:#fff;" class="fa fa-trash"></i></a>

								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
            <tfoot>
							<tr>
						  	<th><?=t('BAŞLIK');?></th>
								<th><?=t('İCERİK');?></th>
								<th><?=t('KAYIT TARİHİ');?></th>
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
    <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning white">
            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Type Update');?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
            </button>
          </div>
					<form id="conformitytype-form" action="/web/update/0" method="post">
            <div class="modal-body">
								<input type="hidden" class="form-control"  id='modalgenelno' name="GenelIcerik[id]" value="0">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('Genel İçerik Baslik');?></label>
										<fieldset class="form-group">
										<input placeholder="?=t('Genel İçerik Baslik');?>" id='modalgenelbaslik' class="form-control" name="GenelIcerik[baslik]"  type="text" />
										</fieldset>
								</div>


								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<fieldset class="form-group">
									<label for="basicSelect"><?=t('Genel İçerik İçerik');?></label>
											 <textarea class="ckeditor" id="modalgenelicerik" name="GenelIcerik[icerik]" placeholder="Translate value"></textarea>
											<script>
											CKEDITOR.replace( 'modalgenelicerik',
													{
													toolbar : 'MyToolbar'
													});
											</script>
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
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Genel Liste Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="conformitytype-form" action="/web/delete/0" method="post">

						<input type="hidden" class="form-control" id="modaltypeid2" name="GenelIcerik[id]" value="0">

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
	$('#modalgenelno').val($(obj).data('id'));
	$('#modalgenelbaslik').val($(obj).data('baslik'));
	$('#modalgenelicerik').html($(obj).data('icerik'));
	CKEDITOR.instances['modalgenelicerik'].setData($(obj).data('icerik'));
	$('#duzenle').modal('show');


}

function openmodalsil(obj)
{
	$('#modaltypeid2').val($(obj).data('id'));
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
                columns: [ 0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Non-Conformity Type')?> (<?=date('d-m-Y H:i:s');?>)',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
               columns: [ 0,1]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Non-Conformity Type')?> (<?=date('d-m-Y H:i:s');?>)',
		 },
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1]
            },
			text:'<?=t('PDF');?>',
			  title: '<?=t('Export')?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t('Non-Conformity Type')?>\n',
					bold: true,
					fontSize: 16,
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
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/ckeditor/ckeditor.js;';
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
