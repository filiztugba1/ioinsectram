<?php
User::model()->login();
$ax= User::model()->userobjecty('');


// type list sql start

$col=6;
	if($ax->firmid>0)
	{
		if($ax->branchid>0)
		{
			if($ax->clientid>0)
			{
				if($ax->clientbranchid>0)
				{
					$where="clientbranchid=".$ax->clientbranchid." and documentid=".$_GET['id'];
				}
				else
				{
					$where="clientid=".$ax->clientid." and clientbranchid!=0 and documentid=".$_GET['id'];
				}
			}
			else
			{
				$where="branchid=".$ax->branchid." and clientid!=0  and documentid=".$_GET['id'];
			}
		}
		else
		{
			$where="firmid=".$ax->firmid." and branchid!=0 and documentid=".$_GET['id'];
		}
	}
	else
	{
		$where="documentid=".$_GET['id'];
	}

// type list sql finish


$document=  Documents::model()->find(array("condition"=>"id=".$_GET['id']));
$documentviewfirm=  Documentviewfirm::model()->findAll(array("condition"=>$where));?>



	<?=User::model()->geturl('Döküman',$document->name,0,'/documents/documandetay?id='.$_GET['id']);?>



	<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
						 
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
					   <h4 style class="card-title"></h4>
						</div>
					
					
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
					
							 <?if($ax->firmid==0){?>
							 <th><?=t('FIRM');?></th>
							 <?}?>
							 <?if($ax->branchid==0){?>
							 <th><?=t('BRANCH');?></th>
							 <?}?>
							 <?if($ax->clientid==0){?>
							 <th><?=t('CLIENT');?></th>
							 <?}?>
							 <?if($ax->clientbranchid==0){?>
							 <th><?=t('CLIENT BRANCH');?></th>
							 <?}?>
						
							
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($documentviewfirm as $firm):?>
                                <tr>
							
									 <?if($ax->firmid==0){?>
										 <td>
										 <?if($firm->firmid!=0){?>
										 <?=$firm->firmid;?>
											<?=Firm::model()->find(array('condition'=>'id='.$firm->firmid))->name;?>
										 <?}?>
										 </td>
									 <?}?>
									 <?if($ax->branchid==0){?>
										 <td>
											<?if($firm->branchid!=0){?>
											<?=Firm::model()->find(array('condition'=>'id='.$firm->branchid))->name;?>
											<?}?>
										 </td>
									 <?}?>
									
								
									
									 <?if($ax->clientid==0){?>
										 <td>
										 <?if($firm->clientid!=0){?>
											<?=Client::model()->find(array('condition'=>'id='.$firm->clientid))->name;?>
										 <?}?>
										</td>
									 <?}?>
									 <?if($ax->clientbranchid==0){?>
									 <td>
										 <?if($firm->clientbranchid!=0){?>
											<?=Client::model()->find(array('condition'=>'id='.$firm->clientbranchid))->name;?>
										<?}?>
									</td>
										
									 <?}?>
									
									
								
                                </tr>
						
								<?php endforeach;?>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
						
							 <?if($ax->firmid==0){?>
							 <th><?=t('FIRM');?></th>
							 <?}?>
							 <?if($ax->branchid==0){?>
							 <th><?=t('BRANCH');?></th>
							 <?}?>
							 <?if($ax->clientid==0){?>
							 <th><?=t('CLIENT');?></th>
							 <?}?>
							 <?if($ax->clientbranchid==0){?>
							 <th><?=t('CLIENT BRANCH');?></th>
							 <?}?>
						
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





function myfirm() 
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}

 function mybranch() 
{

	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});

}



 
function openmodal(obj)
{
	$('#modaltypeid').val($(obj).data('id'));
	$('#modaltypename').val($(obj).data('name'));
	$('#modaltypeactive').val($(obj).data('active'));
	$('#duzenle').modal('show');
	
}

function openmodalsil(obj)
{
	$('#modaltypeid2').val($(obj).data('id'));
	$('#sil').modal('show');
	
}

function authchange(data,permission,obj)
{
$.post( "?", { typeid: data, active: permission })
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