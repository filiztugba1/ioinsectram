<?php
User::model()->login();
$translatelanguages=Translatelanguages::model()->findAll();	?>
	<?php $translates=Translates::model()->findAll(array('condition'=>'code="en"'));	?>

<?php if (Yii::app()->user->checkAccess('managetranslates.view')){ ?>
	<section id="html5">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
								 <h4 class="card-title"><?=t('Language excel FileUpload');?></h4>
									</div>
								<div class="card-body ">
									<h6 style="background: #ffa7a7;border-radius: 5px;padding: 3px 6px 5px 11px;margin-top: 5px;margin-bottom: 5px;"><a href="/translate/translatelanguages"><?=t("Manage Languages")?></a> <?=t("sayfasındaki dil isimlerini excel başlığı olarak veriniz.")?></h6>
								<div class="row">
								<div class="col-xl-4 mb-1">
									<label for="basicSelect"><?=t('File');?></label>
										<fieldset class="form-group">
												<input class="form-control" type="file" id="fileUpload" />
										</fieldset>
								</div>
								<div class="col-xl-4 mb-1">
									<label class="mt-1" for="basicSelect"> </label>
										<fieldset class="form-group">
											<button class="btn btn-info" id="upload" value="Upload" onclick="UploadProcess()" /><?=t("Upload")?></button>
                      <a class="btn btn-warning" href="<?=Yii::app()->baseUrl.'/images/ornek_traslate_excel.xlsx';?>" target="_blank"><?=t("Örnek Excel Dosyası")?></a>
                  	</fieldset>
								</div>
</div>
</div>
							</div>
			</div>
		</div>
</section>
  <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-8 col-lg-8 col-md-8 mb-1">
						 <h4 class="card-title"><?=t('LANGUAGE TAGS');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('managalanguages.view')){ ?>
						<div class="col-xl-2 col-lg-2 col-md-2 mb-1">

								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<a href="/translate/translatelanguages" class="btn btn-info"  type="submit"><?=t('Manage Languages');?> <i class="fa fa-plus"></i></a>
								</div>


						</div>
						<?php }?>
						<?php if (Yii::app()->user->checkAccess('managetranslates.view')){ ?>
						<div class="col-xl-2 col-lg-2 col-md-2 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<a href="/translate/translates/create" class="btn btn-info"  type="submit"><?=t('Add Tag');?> <i class="fa fa-plus"></i></a>
								</div>

						</div>
						<?php }?>
					</div>
                </div>

                <div class="card-content collapse show" id="tableList">

                </div>
              </div>
            </div>
          </div>
        </section>

<script>

$(document).ready(function(){
YoksisListe(); 
function YoksisListe() { 
	$( "#backgroundLoading" ).removeClass( "loadingDisplay" );
	var namesurname=$(this).data("namesurname"); 
	$.ajax({ 
		url: '/translate/translates/traslatelist', 
		type: "GET", 
		cache: false, 
		processData: false, 
		//data: "id=" + $(this).data("id"), 
		contentType: "application/json", 
		dataType: "json", 
		success: function (datam) { 
			$( "#backgroundLoading" ).addClass( "loadingDisplay" );
			var columnsData=[ ];
			var languages=datam["languages"];
		  var data='<div class="card-body card-dashboard"><table class="table table-striped table-bordered dataTableList" id="tableTH"> <thead>  <tr> ';
			var translateData=datam["traslate"];
			data=data+' <th aria-controls="tableTH">  <a class="column_sort" id="title" > <?=t('Title')?></a> </th> ';
columnsData.push({ "data": "title" });
	for (var i = 0; i < (Object.keys(languages).length); i++) {
		if(languages[i])
		{
			data=data+' <th aria-controls="tableTH">  <a class="column_sort" id="'+languages[i]["name"]+'_value" > '+languages[i]['title']+'</a> </th> ';
			columnsData.push({ "data": languages[i]["name"]+"_value" });
		}
	}
	data=data+' <th aria-controls="tableTH">  <a id="process" > <?=t("Process");?></a> </th> ';
	data=data+'	</tr> </thead> </tr>    </table></div>';
		$('#tableList').html(data);
		columnsData.push({  data: null,
			defaultContent: '<a data-url="/translate/translates/update" data-isurl="true" data-tableclassname="dataTableList" data-ismodal="false" onclick="edititem(this);" class="btn btn-warning btn-sm"><i style="color:#fff;" class="fa fa-edit"></i></a>' 
			});
			$ ('.dataTableList'). DataTable (). destroy ();
			colonArray=[];
			for(let i=0;i<(columnsData.length)-1;i++)
			{
			   colonArray.push(i) 
			}
			document('dataTableList',
								colonArray,
								"liste",
								columnsData,
								"/translate/translates/traslatelist",
								translateData); 
						} ,
				error: function (jqXHR, textStatus, errorThrown) {
					$( "#backgroundLoading" ).addClass( "loadingDisplay" );
					// showResultFailed(jqXHR.responseText);
					 // hideWaitingFail();
			 }
					});
				}

function document(classname,columns,pdfbaslik,columnsData,url,data)  { 
	$("."+classname).DataTable({
    dom: 'Bfrtip',
     "scrollX": true,
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
					extend: "excelHtml5", 
					exportOptions: { columns: columns },
 text: '<?=t("Excel");?>', 
					className: "d-none d-sm-none d-md-block", 
					title: pdfbaslik+"-<?=date("d/m/Y");?>",
 messageTop: pdfbaslik
        },
				{ 
					 extend: "pdfHtml5",
					 exportOptions: { 
						  columns: columns 
						}, 
						 text: "<?=t('Pdf');?>", 
						 title: pdfbaslik+'<?=date("d/m/Y");?>', 
						 header: true, 
						 customize: function (doc) { 
							 doc.content.splice(0, 1, { 
								 text: [{ 
									 text: "\n", 
									 bold: true, 
									 fontSize: 16,
								 }, 
								 { 
									 text: pdfbaslik + "\n", 
								   bold: true, 
									 fontSize: 12
								 }, 
								 { 
									 text: '<?=date("d/m/Y");?>', 
									  bold: true, 
										fontSize: 11
									}], 
									 margin: [0, 0, 0, 12] 
								  });
						} 
					},
        'colvis',
		'pageLength',

	],
		"columns": columnsData, 
		"data":data,
		"fnRowCallback": function(nRow, aData, iDisplayIndex) {
				 nRow.setAttribute('id',aData['en_id']);
				 },


} );
}
});

function edititem(obj) {
	var url=$(obj).data("url");
	var isurl=$(obj).data("isurl");
	var tableclassname=$(obj).data("tableclassname");
	var ismodal=$(obj).data("ismodal");
			    jQuery('.'+tableclassname+' tr').click(function(e) {
			        e.stopPropagation();
			        var $this = jQuery(this);
			        var trid = $this.closest('tr').attr('id');
			        var x = 0, y = 0; // default values
			    x = window.screenX +5;
			    y = window.screenY +275;
					if(isurl===true)
					{
						window.open(url+"?id="+trid, '_blank');
					}
		 });
}
</script>
<?php }?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script type="text/javascript">
    function UploadProcess() {
        //Reference the FileUpload element.
        var fileUpload = document.getElementById("fileUpload");

        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        console.log(regex.test(fileUpload.value.toLowerCase()));
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();

                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        GetTableFromExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        GetTableFromExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
    };
    function GetTableFromExcel(data) {
        //Read the Excel File data in binary
        var workbook = XLSX.read(data, {
            type: 'binary'
        });

        //get the name of First Sheet.
        var Sheet = workbook.SheetNames[0];

        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);

        //Create a HTML Table element.
        var myTable  = document.createElement("table");
        myTable.border = "1";

        //Add the header row.
        var row = myTable.insertRow(-1);

        //Add the header cells.
				var formData = new FormData();
				formData.append('datam',JSON.stringify(excelRows));
				$.ajax({
						url: '/translate/translates/traslateexcelimport',
						type: 'POST',
						data: formData,
						async: false,
						success: function (data) {
							if(JSON.parse(data).length==0)
							{
								  alert("Aktarım Başarılı");
							}
							else {
									alert(data)
							}
						},
						cache: false,
						contentType: false,
						processData: false
				});
     return false;
    };
</script>

<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/ckeditor/ckeditor.js;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


?>
