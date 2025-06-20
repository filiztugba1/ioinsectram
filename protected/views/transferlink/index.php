<?php
User::model()->login();
$ax= User::model()->userobjecty('');

if($ax->firmid==0)
{
		$client=Yii::app()->db->createCommand('SELECT clientbranch.* FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id where clientbranch.firmid!=clientbranch.mainfirmid')->queryall();
}
else
{
	if($ax->branchid==0)
	{
		$client=Yii::app()->db->createCommand('SELECT clientbranch.* FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id where clientbranch.firmid!=clientbranch.mainfirmid and firm.id='.$ax->firmid)->queryall();

	}
	else
	{
		$client=Yii::app()->db->createCommand('SELECT clientbranch.* FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id where clientbranch.firmid!=clientbranch.mainfirmid and (clientbranch.firmid='.$ax->branchid.' or clientbranch.mainfirmid='.$ax->branchid.')')->queryall();

	}
}





?>




<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				  <div class="card-header">
					 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					 <div class="col-md-6">
                  <h4  class="card-title"><?=t('Treansfer Link Add');?></h4>
					</div>
					 <div class="col-md-6">
               	<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
						</div>
                </div>
				 </div>

				 <form id="notifications-form" action="/transferlink/create" method="post">
				<div class="card-content">
					<div class="card-body">


					<div class="row">


				<?$col='';

					if($ax->firmid>0 && $ax->branchid==0)
					{
						$col='col-xl-4 col-lg-4 col-md-4 mb-1';
					}
					else
					{
						$col='col-xl-6 col-lg-6 col-md-6 mb-1';
					}
					?>



					<?php if($ax->firmid==0){?>
						<div class="<?=$col;?>">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Transfer[firmid]" onchange="myfirm()" requred>
									<option value="0"><?=t("Please Choose")?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Transfer[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="<?=$col;?>">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Transfer[branchid]" onchange="mybranch()" disabled requred>
									<option value="0"><?=t("Please Choose")?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Transfer[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>



					<?php if($ax->clientbranchid==0){?>
					<div class="<?=$col;?>">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" name="Transfer[clientid]" disabled requred onchange="myFunctionClient()">
								<option value="0"><?=t("Select");?></option>
									<?php

								$who=User::model()->whopermission();
								if($who->type==2){
										$firm=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid=:firmid','params'=>array('firmid'=>$ax->branchid)));

											foreach($firm as $firmx)
											{
													$cb=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=:parentid','params'=>array('parentid'=> $firmx->id)));

													if(count($cb))
													{
													?><optgroup  label="<?=$firmx->name;?>"></option><?php
													foreach($cb as $cbx)
													{
														$transfer=Client::model()->istransfer($cbx->id);
														if(($transfer!=1 || $ax->branchid==0)){
														?>
														<option value="<?=$cbx->id;?>"><?=$firmx->name;?> --> <?=$cbx->name;?></option>
													<?php }}
													}



												?>


											<?php }

												$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$who->id.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
												foreach($tclient as $tclientx)
												{

													$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
													foreach($tclients as $tclientsx)
													{?>
													<optgroup label="<?=$tclientsx->name;?>">
													<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$who->id));
													foreach($tclientbranchs as $tclientbranchsx)
													{?>
														<option value="<?=$tclientbranchsx->id;?>"><?=$tclientbranchsx->name;?></option>
													<?php }?>
													</optgroup>
													<?php }

												}
											}


											?>
							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client" name="Transfer[clientid]" value="<?=$ax->branchid;?>" requred>
					<?php }?>



					<div class="<?=$col;?>">
					<label for="basicSelect"><?=t('Transfer Branch');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="transferclient" name="Transfer[tbranchid]" disabled requred>

							</select>
                        </fieldset>
                    </div>



					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style='float:right'>
									<button class="btn btn-primary" type="submit"><?=t('Save');?></button>
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
						 <h4 class="card-title"><?=t('TRANSFER LIST');?></h4>
						</div>


						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Transfer');?> <i class="fa fa-plus"></i></button>
								</div>

						</div>

					</div>
                </div>



      <div class="col-xl-12 col-lg-12">
              <div class="card">
                  <div class="card-content">
                  <div class="card-body">

							<!--gelen bildirimler ba�lang�� -->

					<table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                            <th><?=t('FROM BRANCH');?></th>
							<th><?=t('TO BRANCH');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
                          </tr>
                        </thead>
                        <tbody>

							<?php for($i=0;$i<count($client);$i++){?>
                                <tr>
                                    <td><?=Firm::model()->find(array('condition'=>'id='.$client[$i]['mainfirmid']))->name;?></td>
									<td><?=Firm::model()->find(array('condition'=>'id='.$client[$i]['firmid']))->name;?></td>
									<td><?=Client::model()->find(array('condition'=>'id='.$client[$i]['parentid']))->name;?></td>

									<td><?=Client::model()->find(array('condition'=>'id='.$client[$i]['id']))->name;?></td>

                                </tr>

					<?php }?>


                        </tbody>
                        <tfoot>
                          <tr>
														<th><?=t('FROM BRANCH');?></th>
							<th><?=t('TO BRANCH');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
                          </tr>
                        </tfoot>
                      </table>


							<!--gelen bildirim biti�-->

				</div>
			</div>
			</div>

             <!--
			 <div class="card-content collapse show">
                  <div class="card-body card-dashboard">


                  </div>
                </div>

			-->

              </div>
            </div>
          </div>
        </section>






	<!--S�L BA�LANGI�-->

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

				<!--form baslang��-->
						<form id="notifications-form" action="/notifications/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalnotificateid2" name="Notifications[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Do you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger" type="submit"><?=t('Delete');?></button>
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
#waypointsTable tr:hover {
    background-color:#ccdcf7;
}
</style>

<script>
//$("#createpage").hide();
$("#reports").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

$("#reportbutton").click(function(){
        $("#reports").toggle(500);
 });
 $("#cancel1").click(function(){
        $("#reports").hide(500);
 });


 $('#waypointsTable tr').hover(function() {
    $(this).addClass('hover');
}, function() {
    $(this).removeClass('hover');
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



<?php if($ax->firmid!=0){?>
	$( "#branch" ).prop( "disabled", false );
	if($("#firm").length>0)
	{
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});
	}

<?php }?>

<?php if($ax->branchid!=0){?>
	$( "#client" ).prop( "disabled", false );
<?php }?>







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
		// alert(document.getElementById("branch").value);
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});


}


function myFunctionClient() {
	$.post( "/transferlink/transferclient?id="+document.getElementById("firm").value+'&&client='+document.getElementById("client").value).done(function( data ) {
		$( "#transferclient" ).prop( "disabled", false );
		$('#transferclient').html(data);
	});
}




function myFunctionDepartment() {
  	$.post( "/conformity/department?id="+document.getElementById("department").value).done(function( data ) {
		$( "#subdepartment" ).prop( "disabled", false );
		$('#subdepartment').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}





function myfirm2()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

 function mybranch2()
{
	$.post( "/workorder/client?id="+document.getElementById("branch2").value).done(function( data ) {
		$( "#client2" ).prop( "disabled", false );
		$('#client2').html(data);
	});
}


function myFunctionClient2() {
  	$.post( "/conformity/client?id="+document.getElementById("client2").value).done(function( data ) {
		$( "#department2" ).prop( "disabled", false );
		$('#department2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

function myFunctionDepartment2() {
  	$.post( "/conformity/department?id="+document.getElementById("department2").value).done(function( data ) {
		$( "#subdepartment2" ).prop( "disabled", false );
		$('#subdepartment2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}






$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/




<?$whotable=User::model()->iswhotable();?>
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
			html:true,
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

		"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				// "targets": 0
			} ],
			// "order": [[ 4, 'asc' ]],



	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
		 },
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
				   text:'<?=t('PDF');?>',
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Non-Conformity \n',
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

 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

?>
