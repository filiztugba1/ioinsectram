<?php  

$ax= User::model()->userobjecty('');


$client=Yii::app()->db->createCommand('SELECT COUNT(*),user.name as name,user.surname as surname,user.username as username,user.email as email,AuthAssignment.itemname as itemname FROM  AuthAssignment INNER JOIN user ON user.id=AuthAssignment.userid where AuthAssignment.itemname like "%.K-fteciyusuf396.%" group by user.id order by user.id')->queryAll();

?><div class='row' style='margin-bottom:10px'><?phpforeach($client as $clients){?>

	<div class='col-md-4'><div class='col-md-12' style='text-align:center;background: #00a849;
    color: #fff;    margin-top: 7px; padding: 12px;'><div class='col-md-12'><?=$clients['COUNT(*)'];?></div><div class='col-md-12'><?=$clients['name'].' '.$clients['surname']?></div></div></div>


<?php }

?>
</div>



<?php

$client=Yii::app()->db->createCommand('SELECT user.name as name,user.surname as surname,user.username as username,user.email as email,AuthAssignment.itemname as itemname FROM  AuthAssignment INNER JOIN user ON user.id=AuthAssignment.userid where AuthAssignment.itemname like "%.K-fteciyusuf396.%" order by user.id')->queryAll();

?>

	
	
	
	
	 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title">Köfteci yusuf şube personellerinin yetkili oldukları şubeler</h4>
						</div>

					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
							<th>Şube Adı</th>
                            <th>Ad Soyad</th>
							<th>Kullanıcı Adı</th>
							<th>Email</th>
							
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($client as $clients):?>
                                <tr>
						
									
									
								<td>
									<?php										$x=explode('.',$clients['itemname']);
										if(count($x)==5)
										{
											echo Client::model()->find(array('condition'=>'username="'.$x[3].'"'))->name;
										}
										else
										{
											echo Client::model()->find(array('condition'=>'username="'.$x[3].'"'))->name.' - '.Client::model()->find(array('condition'=>'username="'.$x[4].'"'))->name;
										}



										?>
								</td>

								<td><?=$clients['name'].' '.$clients['surname'];?></td>
								<td><?=$clients['username'];?></td>
								<td><?=$clients['email'];?></td>
									
						
									
								
                                </tr>
						
								<?php endforeach;?>


						 
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Şube Adı</th>
                            <th>Ad Soyad</th>
							<th>Kullanıcı Adı</th>
							<th>Email</th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		
		
		
		



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
	$('#modalclientid').val($(obj).data('id'));
	$('#modalclientname').val($(obj).data('name'));
	$('#modalclienttitle').val($(obj).data('title'));
	$('#modalclienttaxoffice').val($(obj).data('taxoffice'));
	$('#modalclienttaxno').val($(obj).data('taxno'));
	$('#modalclientactive').val($(obj).data('active'));
	$('#modalclientbranchid').val($(obj).data('branchid'));
	$('#modalclientemail').val($(obj).data('email'));
	$('#modalclientlandphone').val($(obj).data('landphone'));
	$('#modalclientaddress').val($(obj).data('address'));
	$('#startdate').val($(obj).data('startdate'));
	$('#finishdate').val($(obj).data('finishdate'));
	$('#iskdv').val($(obj).data('kdv'));
	$('#productsamount').val($(obj).data('productsamount'));
	$('#duzenle').modal('show');
	
}



function openmodalsil(obj)
{
		var id=$(obj).data('id');
		var x='';
	
		$.post( "/firm/firmdelete?id="+$(obj).data('id')+'&&user=Client&&type=client').done(function( data ) {
		if(data>0)
		{
			$('#delete').html('<?=t("You must delete the customers branch in order to delete the customer");?>');
			$('#btn-delete').html('<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t("Close");?></button>');
		}
		else
		{
			$('#delete').html('<?=t("Do you want to delete?");?>');
			$('#btn-delete').html('<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t("Close");?></button><button  class="btn btn-danger" type="submit"><?=t("Delete");?></button>');
		}
	});

	$('#modalclientid2').val($(obj).data('id'));
	$('#modalparentid2').val($(obj).data('parentid'));
	$('#sil').modal('show');
	
}

function authchange(data,permission,obj)
{
$.post( "?", { clientid: data, active: permission })
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


<?php $whotable=User::model()->iswhotable();?>
$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
	"search": {
    "caseInsensitive": true
	},
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			html:true,
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
                columns: [ 0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Client (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
               columns: [ 0,1,2,3]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Client (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
		 },
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  exportOptions: {
               columns: [ 0,1,2,3]
            },
				   text:'<?=t('PDF');?>',
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Client \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  }, 
				 {
					text: '<?php if($whotable->isactive==1){echo $whotable->name;}?> \n',
					bold: true,
					fontSize: 12,
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
		'pageLength',
		
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