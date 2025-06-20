<?php
User::model()->login();
$ax= User::model()->userobjecty('');


$hizmet=Hizmet::model()->findAll();	?>


<div id="createpage" >
<div class="card col-xl-12 col-lg-12 col-md-12">
	<div class="card-header">
		<div class="row">
			<div class="col-md-6">
				<h4  class="card-title"><?=t('Hizmet Ekle');?></h4>
			</div>
			<div class="col-md-6">
				<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
			</div>
		</div>
	</div>
	<form id="genelicerik-form" action="/web/hizmetcreate" method="post">
		<div class="card-content">
			<div class="card-body">
				<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Fiyat');?></label>
							<fieldset class="form-group">
							<input placeholder="<?=t('Fiyat');?>" class="form-control" name="Hizmet[fiyat]"  type="number" />
							</fieldset>
					</div>
        <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
  						<label for="basicSelect"><?=t('İndirim Oranı');?></label>
  							<fieldset class="form-group">
  							<input placeholder="<?=t('Fiyat');?>" class="form-control" name="Hizmet[indirim_orani]"  type="number" />
  							</fieldset>
  					</div>

            <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                <label for="basicSelect"><?=t('Yıllık Fiyat');?></label>
                  <fieldset class="form-group">
                  <input placeholder="<?=t('Yıllık Fiyat');?>" class="form-control" name="Hizmet[yillik_fiyat]"  type="number" />
                  </fieldset>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                  <label for="basicSelect"><?=t('Baslik');?></label>
                    <fieldset class="form-group">
                    <input placeholder="<?=t('Baslik');?>" class="form-control" name="Hizmet[baslik]"  type="text" />
                    </fieldset>
                </div>

              <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                    <label for="basicSelect"><?=t('Özellik');?></label>
                      <fieldset class="form-group">
                      <input placeholder="<?=t('Özellik');?>" class="form-control" name="Hizmet[ozellik]"  type="text" />
                      </fieldset>
                  </div>

                  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                      <label for="basicSelect"><?=t('İcerik');?></label>
                        <fieldset class="form-group">
                        <input placeholder="<?=t('İcerik');?>" class="form-control" name="Hizmet[icerik]"  type="text" />
                        </fieldset>
                    </div>
                <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <label for="basicSelect"><?=t('Sef');?></label>
                          <fieldset class="form-group">
                          <input placeholder="<?=t('Sef');?>" class="form-control" name="Hizmet[sef]"  type="text" />
                          </fieldset>
                      </div>

                  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                          <label for="basicSelect"><?=t('Keyboards');?></label>
                            <fieldset class="form-group">
                            <input placeholder="<?=t('Keyboards');?>" class="form-control" name="Hizmet[keywords]"  type="text" />
                            </fieldset>
                        </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                            <label for="basicSelect"><?=t('Sıra No');?></label>
                              <fieldset class="form-group">
                              <input placeholder="<?=t('Sıra No');?>" class="form-control" name="Hizmet[sira_no]"  type="number" />
                              </fieldset>
                          </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                              <label for="basicSelect"><?=t('Ana Sayfa');?></label>
                                <fieldset class="form-group">
                                <input placeholder="<?=t('Ana Sayfa');?>" class="form-control" name="Hizmet[anasayfa]"  type="number" />
                                </fieldset>
                            </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                                <label for="basicSelect"><?=t('Yazar');?></label>
                                  <fieldset class="form-group">
                                  <input placeholder="<?=t('Yazar');?>" class="form-control" name="Hizmet[yazar]"  type="number" />
                                  </fieldset>
                              </div>
                              <div class="col-xl-12 col-lg-12 col-md-12 mb-1">

  <button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
                                        </div>
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
					   	<h4 style class="card-title"><?=t('Hizmet Liste');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Hizmet Ekle');?> <i class="fa fa-plus"></i></button>
								</div>
						</div>
					</div>
        </div>
				<div class="card-content collapse show">
        	<div class="card-body card-dashboard">
						<table class="table table-striped table-bordered dataex-html5-export table-responsive">
              <thead>
              <tr>
						  	<th><?=t('FİYAT');?></th>
								<th><?=t('İNDİRİM ORANI');?></th>
								<th><?=t('YILLIK FİYAT');?></th>
                <th><?=t('BAŞLIK');?></th>
                <th><?=t('ÖZELLİK');?></th>
                <th><?=t('İÇERİK');?></th>
                <th><?=t('SEF');?></th>
                <th><?=t('KEYBOARDS');?></th>
                <th><?=t('SIRA NO');?></th>
                <th><?=t('ANASAYFA');?></th>
                <th><?=t('YAZAR');?></th>
                <th><?=t('KAYIT TARİHİ');?></th>
								<th><?=t('PROCESS');?></th>
             </tr>
            </thead>
            <tbody>
            <?php foreach($hizmet as $hizmetx):?>
              <tr>
								<td><?=$hizmetx->fiyat;?></td>

								<td><?=$hizmetx->indirim_orani;?></td>
                <td><?=$hizmetx->yillik_fiyat;?></td>
                <td><?=t($hizmetx->baslik);?></td>
                <td><?=t($hizmetx->ozellik);?></td>
                <td><?=t($hizmetx->icerik);?></td>
                <td><?=$hizmetx->sef;?></td>
                  <td><?=t($hizmetx->keywords);?></td>
                    <td><?=$hizmetx->sira_no;?></td>
                      <td><?=$hizmetx->anasayfa;?></td>
                  <td><?=$hizmetx->yazar;?></td>

								<td><?=$hizmetx->kayit_tarihi;?></td>
								<td>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
                    data-id="<?=$hizmetx->hizmet_no;?>"
                    data-fiyat="<?=$hizmetx->fiyat;?>"
                    data-indirimorani='<?=$hizmetx->indirim_orani;?>'
                    data-yillikfiyat='<?=$hizmetx->yillik_fiyat;?>'
                    data-baslik='<?=$hizmetx->baslik;?>'
                    data-ozellik='<?=$hizmetx->ozellik;?>'
                    data-icerik='<?=$hizmetx->icerik;?>'
                    data-keyboards='<?=$hizmetx->keywords;?>'
                    data-sef='<?=$hizmetx->sef;?>'
                    data-sirano='<?=$hizmetx->sira_no;?>'
                    data-anasayfa='<?=$hizmetx->anasayfa;?>'
                    data-yazar='<?=$hizmetx->yazar;?>'
										 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"
										 ><i style="color:#fff;" class="fa fa-edit"></i></a>


									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$hizmetx->hizmet_no;?>"
									 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"><i style="color:#fff;" class="fa fa-trash"></i></a>

								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
            <tfoot>
							<tr>
                <th><?=t('FİYAT');?></th>
                <th><?=t('İNDİRİM ORANI');?></th>
                <th><?=t('YILLIK FİYAT');?></th>
                <th><?=t('BAŞLIK');?></th>
                <th><?=t('ÖZELLİK');?></th>
                <th><?=t('İÇERİK');?></th>
                <th><?=t('SEF');?></th>
                <th><?=t('KEYWORDS');?></th>
                <th><?=t('SIRA NO');?></th>
                <th><?=t('ANASAYFA');?></th>
                <th><?=t('YAZAR');?></th>
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
            <h4 class="modal-title" id="myModalLabel8"><?=t('Hizmet Güncelleme');?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
            </button>
          </div>
					<form id="conformitytype-form" action="/web/hizmetupdate/0" method="post">
            <div class="modal-body">
								<input type="hidden" class="form-control"  id='modalhizmetno' name="Hizmet[id]" value="0">

                <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
        						<label for="basicSelect"><?=t('Fiyat');?></label>
        							<fieldset class="form-group">
        							<input placeholder="<?=t('Fiyat');?>" id='modalhizmetfiyat' class="form-control" name="Hizmet[fiyat]"  type="number" />
        							</fieldset>
        					</div>
                  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
          						<label for="basicSelect"><?=t('İndirim Oranı');?></label>
          							<fieldset class="form-group">
          							<input placeholder="<?=t('İndirim Oranı');?>" id='modalhizmetindirimorani' class="form-control" name="Hizmet[indirim_orani]"  type="number" />
          							</fieldset>
          					</div>

                    <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <label for="basicSelect"><?=t('Yıllık Fiyat');?></label>
                          <fieldset class="form-group">
                          <input placeholder="<?=t('Yıllık Fiyat');?>" id='modalhizmetyillikfiyat' class="form-control" name="Hizmet[yillik_fiyat]"  type="number" />
                          </fieldset>
                      </div>
                      <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                          <label for="basicSelect"><?=t('Baslik');?></label>
                            <fieldset class="form-group">
                            <input placeholder="<?=t('Baslik');?>" id='modalhizmetbaslik' class="form-control" name="Hizmet[baslik]"  type="text" />
                            </fieldset>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                            <label for="basicSelect"><?=t('Özellik');?></label>
                              <fieldset class="form-group">
                              <input placeholder="<?=t('Özellik');?>" id='modalhizmetozellik' class="form-control" name="Hizmet[ozellik]"  type="text" />
                              </fieldset>
                          </div>

                          <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                              <label for="basicSelect"><?=t('İcerik');?></label>
                                <fieldset class="form-group">
                                <input placeholder="<?=t('İcerik');?>" id='modalhizmeticerik' class="form-control" name="Hizmet[icerik]"  type="text" />
                                </fieldset>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                <label for="basicSelect"><?=t('Sef');?></label>
                                  <fieldset class="form-group">
                                  <input placeholder="<?=t('Sef');?>" id='modalhizmetsef' class="form-control" name="Hizmet[sef]"  type="text" />
                                  </fieldset>
                              </div>

                              <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                  <label for="basicSelect"><?=t('Keywords');?></label>
                                    <fieldset class="form-group">
                                    <input placeholder="<?=t('Keywords');?>" id='modalhizmetkeyboards' class="form-control" name="Hizmet[keywords]"  type="text" />
                                    </fieldset>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                    <label for="basicSelect"><?=t('Sıra No');?></label>
                                      <fieldset class="form-group">
                                      <input placeholder="<?=t('Sıra No');?>" id='modalhizmetsirano' class="form-control" name="Hizmet[sira_no]"  type="number" />
                                      </fieldset>
                                  </div>
                                  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                      <label for="basicSelect"><?=t('Ana Sayfa');?></label>
                                        <fieldset class="form-group">
                                        <input placeholder="<?=t('Ana Sayfa');?>" id='modalhizmetanasayfa' class="form-control" name="Hizmet[anasayfa]"  type="number" />
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                        <label for="basicSelect"><?=t('Yazar');?></label>
                                          <fieldset class="form-group">
                                          <input placeholder="<?=t('Yazar');?>" id='modalhizmetyazar' class="form-control" name="Hizmet[yazar]"  type="number" />
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
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Hizmet Sil');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="conformitytype-form" action="/web/hizmetdelete/0" method="post">

						<input type="hidden" class="form-control" id="modaltypeid2" name="Hizmet[id]" value="0">

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

	  $('#modalhizmetno').val($(obj).data('id'));
  	$('#modalhizmetfiyat').val($(obj).data('fiyat'));
    $('#modalhizmetindirimorani').val($(obj).data('indirimorani'));
  	$('#modalhizmetyillikfiyat').val($(obj).data('yillikfiyat'));
  	$('#modalhizmetbaslik').val($(obj).data('baslik'));
  	$('#modalhizmetozellik').val($(obj).data('ozellik'));
  	$('#modalhizmeticerik').val($(obj).data('icerik'));
  	$('#modalhizmetsef').val($(obj).data('sef'));
  	$('#modalhizmetkeyboards').val($(obj).data('keyboards'));
  	$('#modalhizmetsirano').val($(obj).data('sirano'));
    $('#modalhizmetanasayfa').val($(obj).data('anasayfa'));
    $('#modalhizmetyazar').val($(obj).data('yazar'));

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
