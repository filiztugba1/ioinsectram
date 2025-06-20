<?php

/*

$client=Client::model()->findAll(array('condition'=>'id=456'));

$dep=array("Mutfak ve Arka Plan Alanları", "Müşteri Alanları");
$sub1=array("Bina Çevresi - Dış Alan", "Bulaşıkhane", "Çöp Alanı", "Depo Kuru", "Depo Soğuk", "Izgara Bölümü", "Mutfak - Hazırlık Alanları", "Personel Yemekhanesi", "Soyunma Odaları", "Diğer");

$sub2=array("Salon Dış Teras", "Salon İç", "Salata - Tatlı İstasyonu", "Kasap", "Çay Ocağı", "Şarkuteri", "Mescit", "Oyun Alanı", "Diğer");

foreach($client as $clientx)
{

	  $return=Departments::model()->depsuboto('Mutfak ve Arka Plan Alanları',$clientx->id,0);

	 for($i=0;$i<count($sub1);$i++)
	 {
		 Departments::model()->depsuboto($sub1[$i],$clientx->id,$return);
	 }

	 $return=Departments::model()->depsuboto('Müşteri Alanları',$clientx->id,0);
	 for($i=0;$i<count($sub2);$i++)
	 {
	 	Departments::model()->depsuboto($sub2[$i],$clientx->id,$return);
	 }
}
*/





	User::model()->login();


		Yii::app()->getModule('authsystem');
		//Leftmenu::model()->headermenu(0);
		//Authmodules::model()->leftmenu();

		//echo Authmodules::model()->menupermission(38);
		//Authmodules::model()->header2(0);


$certificate=Certificate::model()->findAll();	?>


<?php if (Yii::app()->user->checkAccess('certificate.view')){ ?>
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Certificate','',0,'certificate');?>
<?php if (Yii::app()->user->checkAccess('certificate.create')){ ?>

<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				  <div class="card-header">
					 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					 <div class="col-md-6">
                  <h4  class="card-title"><?=t('New Certificate Create');?></h4>
					</div>
					 <div class="col-md-6">
               	<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
						</div>
                </div>
				 </div>

				 <form id="certificate-form" action="/certificate/create" method="post">
				<div class="card-content">
					<div class="card-body">


					<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Name');?>" name="Certificate[name]">
                        </fieldset>
                    </div>

					  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
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

<?php }?>


		 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('CERTIFICATE LIST');?></h4>
						</div>

						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<?php if (Yii::app()->user->checkAccess('certificate.create')){ ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Certificate');?> <i class="fa fa-plus"></i></button>
								</div>
						<?php }?>

						</div>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  <!-- <form id="certificate-deleteall" action="/certificate/deleteall" method="post"> -->
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
                          <th><?=t('NAME');?></th>
                          <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>

             			<?php foreach($certificate as $certificates):?>
                                <tr>
								<td><input type="checkbox" name="Certificate[id][]" class='sec' value="<?=$certificates->id;?>"></td>
                                    <td><?=$certificates->name;?></td>


									<td>
									<?php if (Yii::app()->user->checkAccess('certificate.update')){ ?>
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?=$certificates->id;?>" data-name="<?=$certificates->name;?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Update"><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('certificate.delete')){ ?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$certificates->id;?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>
									</td>
                                </tr>

						<?php endforeach;?>


                        </tbody>
                        <tfoot>


						 <th style='width:1px;'>
						 <?php if (Yii::app()->user->checkAccess('certificate.delete')){ ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete selected"><i class="fa fa-trash"></i></button>
								</div>
						<?php }?>
						</th>
                          <th><?=t('NAME');?></th>
                          <th><?=t('PROCESS');?></th>
                        </tfoot>
                      </table>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>






<?php if (Yii::app()->user->checkAccess('certificate.update')){ ?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Certificate Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="certificate-form" action="/certificate/update/0" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalcertificateid" name="Certificate[id]" value="0">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalcertificatename" placeholder="<?=t('Name');?>" name="Certificate[name]" value="">
									</fieldset>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning block-page" type="submit"><?=t('Update');?></button>
                                </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>


	<!-- GÜNCELLEME BİTİŞ-->
	<!--SİL BAŞLANGIÇ-->

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

				<!--form baslangıç-->
						<form id="certificate-form" action="/certificate/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalcertificateid2" name="Certificate[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Do you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>



		<!--delelete all start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Certificate Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslangıç-->
						<form action="/certificate/deleteall" method="post">

						<input type="hidden" class="form-control" id="modalcertificateid3" name="Certificate[id]" value="0">

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

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- delete all finish -->

<?php }?>
<?php }?>

	<!-- SİL BİTİŞ -->



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
	$('#modalcertificateid3').val(ids);

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
</script>


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
	$('#modalcertificateid').val($(obj).data('id'));
	$('#modalcertificatename').val($(obj).data('name'));
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modalcertificateid2').val($(obj).data('id'));
	$('#sil').modal('show');

}



$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[-1,5,10,50,100], [5,10,50,100, "<?=t('All');?>"]],
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
                 columns: [1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Certificate <?=date('d-m-Y H:i:s');?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [1]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Certificate <?=date('d-m-Y H:i:s');?>'
        },

		{
             extend: 'pdfHtml5',
			exportOptions: {
                 columns: [1]
            },
			text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Certificate\n',
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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';
?>
