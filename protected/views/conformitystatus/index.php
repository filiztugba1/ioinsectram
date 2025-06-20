<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$col=6;
	if($ax->firmid>0)
	{
		if($ax->branchid>0)
		{
			if($ax->clientid>0)
			{
				if($ax->clientbranchid>0)
				{
					$where="firmid=0 or (firmid=".$ax->firmid." and branchid=0) or (branchid=".$ax->branchid." and clientid=0) or clientid=".$ax->clientbranchid;
				}
				else
				{
						$workorder=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
						$i=0;
						foreach($workorder as $workorderx)
						{
						if($i==0)
						{
							$where='clientid='.$workorderx->id;
						}
						else
						{
						$where=$where.' or clientid='.$workorderx->id;
						}

						$where=$where." or firmid=0 or (firmid=".$ax->firmid." and branchid=0)";

					}
				}
			}
			else
			{
				$col=6;
				$where="firmid=0 or (firmid=".$ax->firmid." and branchid=0) or branchid=".$ax->branchid;
			}
		}
		else
		{
			$col=4;
			$where="firmid=0 or firmid=".$ax->firmid;
		}
	}
	else
	{
		$col=3;
		$where="";
	}
    $status=Conformitystatus::model()->findAll(array('condition'=>$where));


?>

<?=User::model()->geturl('Conformity Status','',0,'conformitystatus');?>

<?php if (Yii::app()->user->checkAccess('nonconformitystatus.view')){?>
<?php if (Yii::app()->user->checkAccess('nonconformitystatus.create')){?>

<div id="createpage" >

			<div class="card col-xl-12 col-lg-12 col-md-12">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
									  <h4  class="card-title"><?=t('Non-Conformity Status Add');?></h4>
						</div>
						<div class="col-md-6">
									<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
						</div>
					</div>

				</div>

				<form id="conformitystatus-form" action="/conformitystatus/create" method="post">
				<div class="card-content">
					<div class="card-body">

						<div class="row">
						<?php if($ax->firmid==0){?>
						<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Conformitystatus[firmid]" onchange="myfirm()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Conformitystatus[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Conformitystatus[branchid]" onchange="mybranch()" disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Conformitystatus[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>

					<?php if($ax->clientid==0){?>
					<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" name="Conformitystatus[clientid]" disabled requred >
								<option value="0"><?=t('Select');?></option>
								<?php								if($workorder->branchid!=0){
								$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$workorder->branchid));

									foreach($client as $clientx)
										{
										$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
										if(count($clientbranchs)>0){?>
											<optgroup label="<?=$clientx->name;?>">
												<?php
													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }


									$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
									foreach($tclient as $tclientx)
									{

										$tclients=Client::model()->findAll(array('condition'=>'id='.$tclientx->mainclientid));
										foreach($tclients as $tclientsx)
										{?>
											<optgroup label="<?=$tclientsx->name;?>">
											<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$workorder->branchid));
											foreach($tclientbranchs as $tclientbranchsx)
											{?>
												<option <?php if($tclientbranchsx->id==$workorder->clientid){echo "selected";}?>  value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
											<?php }?>
											</optgroup>
										<?php }

									}}?>



							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client" name="Conformitystatus[clientid]" value="<?=$ax->branchid;?>" requred>
					<?php }?>


					<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
						<label for="basicSelect"><?=t('Conformity status name');?></label>
							<fieldset class="form-group">

							  <input type="text"  class="form-control" name="Conformitystatus[name]"  placeholder="<?=t('Conformity status name');?>" name="Workorder[todo]" requred>
							</fieldset>
					</div>

					<input  type="hidden" name="Conformitystatus[isactive]" value="1" />

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">

								<button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
                    </div>


					</div>
				</div>
				</form>
				</div>
			</div>

</div>
<?php }?>



	<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="padding-bottom: 3px;border-bottom: 1px solid #ccd6e6;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 style='line-height: 41px;' class="card-title"><?=t('Non-Conformity Status List');?></h4>
						</div>
						<?php if (Yii::app()->user->checkAccess('nonconformitystatus.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Non Conformity Status');?> <i class="fa fa-plus"></i></button>
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
						   <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
                             <th><?=t('Name');?></th>
							 <?php if($ax->firmid==0){?>
							 <th><?=t('Firm');?></th>
							 <?php }?>
							 <?php if($ax->branchid==0){?>
							 <th><?=t('Branch');?></th>
							 <?php }?>
							 <?php if($ax->clientid==0){?>
							 <th><?=t('Client');?></th>
							 <?php }?>
							 <?php if($ax->clientbranchid==0){?>
							 <th><?=t('Client Branch');?></th>
							 <?php }?>
							 <?php if (Yii::app()->user->checkAccess('nonconformitystatus.update')){?>
							 <th><?=t('Active');?></th>
							 <?php }?>
							 <?php if (Yii::app()->user->checkAccess('nonconformitystatus.update') || Yii::app()->user->checkAccess('nonconformitystatus.update') ){?>
                            <th><?=t('PROCESS');?></th>
							 <?php }?>

                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($status as $statusx):?>
                                <tr>
								<td><input type="checkbox" name="Conformitystatus[id][]" class='sec' value="<?=$statusx->id;?>"></td>
                                    <td><?=t($statusx->name);?></td>

									 <?php if($ax->firmid==0){?>
										 <td>
										 <?php if($statusx->firmid!=0){?>
											<?=Firm::model()->find(array('condition'=>'id='.$statusx->firmid))->name;?>
										 <?php }?>
										 </td>
									 <?php }?>
									 <?php if($ax->branchid==0){?>
										 <td>
											<?php if($statusx->branchid!=0){?>
											<?=Firm::model()->find(array('condition'=>'id='.$statusx->branchid))->name;?>
											<?php }?>
										 </td>
									 <?php }?>

									<?php if($statusx->clientid!=0){?>
										<?$client=Client::model()->find(array('condition'=>'id='.$statusx->clientid));?>
									<?php }?>

									 <?php if($ax->clientid==0){?>
										 <td>
										 <?php if($statusx->clientid!=0){?>
											<?=Client::model()->find(array('condition'=>'id='.$client->parentid))->name;?>
										 <?php }?>
										</td>
									 <?php }?>
									 <?php if($ax->clientbranchid==0){?>
									 <td>
										 <?php if($statusx->clientid!=0){?>
											<?=$client->name;?>
										<?php }?>
									</td>

									 <?php }?>


								<?php if (Yii::app()->user->checkAccess('nonconformitystatus.update')){?>
									<td>
										<div class="form-group pb-1">
											<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$statusx->id;?>"  <?php if($statusx->isactive==1){echo "checked";}if (!Yii::app()->user->checkAccess('nonconformitystatus.update')){echo "disabled";}?>/>
										</div>
									</td>
								<?php }?>

								<?php if (Yii::app()->user->checkAccess('nonconformitystatus.update') || Yii::app()->user->checkAccess('nonconformitystatus.update') ){?>
									<td>
									<?php if (Yii::app()->user->checkAccess('nonconformitystatus.update')){?>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?=$statusx->id;?>" data-name="<?=$statusx->name;?>" data-active="<?=$statusx->isactive;?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"
										><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>

									<?php if (Yii::app()->user->checkAccess('nonconformitystatus.delete')){?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$statusx->id;?>"
									data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>

									</td>
								<?php }?>
                                </tr>

								<?php endforeach;?>


                        </tbody>
                        <tfoot>
                          <tr>

						    <th style='width:1px;'>
							<?php if (Yii::app()->user->checkAccess('nonconformitystatus.delete')){?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete selected');?>"><i class="fa fa-trash"></i></button>
								</div>
								<?php }?>
							</th>
							<th><?=t('Name');?></th>
<?php if($ax->firmid==0){?>
<th><?=t('Firm');?></th>
<?php }?>
<?php if($ax->branchid==0){?>
<th><?=t('Branch');?></th>
<?php }?>
<?php if($ax->clientid==0){?>
<th><?=t('Client');?></th>
<?php }?>
<?php if($ax->clientbranchid==0){?>
<th><?=t('Client Branch');?></th>
<?php }?>
<?php if (Yii::app()->user->checkAccess('nonconformitystatus.update')){?>
<th><?=t('Active');?></th>
							 <?php }?>
							 <?php if (Yii::app()->user->checkAccess('nonconformitystatus.update') || Yii::app()->user->checkAccess('nonconformitystatus.update') ){?>
                            <th><?=t('PROCESS');?></th>
							 <?php }?>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>




<?php if (Yii::app()->user->checkAccess('nonconformitystatus.update')){?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Status Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="conformitystatus-form" action="/conformitystatus/update/0" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalstatusid" name="Conformitystatus[id]" value="0">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Name');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalstatusname" placeholder="<?=t('Name');?>" name="Conformitystatus[name]" value="">
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Active');?></label>
									<fieldset class="form-group">
										 <select class="custom-select block" id="modalstatusactive" name="Conformitystatus[isactive]">
											<option value="1"><?=t('Active');?></option>
											<option value="0"><?=t('Passive');?></option>
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

<?php }?>
	<!-- G�NCELLEME B�T��-->
	<!--S�L BA�LANGI�-->
<?php if (Yii::app()->user->checkAccess('nonconformitystatus.delete')){?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Status Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="conformitystatus-form" action="/conformitystatus/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalstatusid2" name="Conformitystatus[id]" value="0">

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
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Status Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslang��-->
						<form action="/conformitystatus/deleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Conformitystatus[id]" value="0">

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




 <?php if($ax->firmid!=0){?>
	 $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
<?php }?>

<?php if($ax->branchid!=0){?>
		$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});

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
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});

}



function openmodal(obj)
{
	$('#modalstatusid').val($(obj).data('id'));
	$('#modalstatusname').val($(obj).data('name'));
	$('#modalstatusactive').val($(obj).data('active'));
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modalstatusid2').val($(obj).data('id'));
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
			title:'Non-Conformity Status (<?=date('d-m-Y H:i:s');?>)'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
               columns: [ 0,1]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity Status (<?=date('d-m-Y H:i:s');?>)'
		 },
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1]
            },
				   text:'<?=t('PDF');?>',
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Non-Conformity Status\n',
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
