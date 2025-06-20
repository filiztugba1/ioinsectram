<?php
$ax= User::model()->userobjecty('');
if(isset($_GET['firmid']) && $_GET['firmid']!=0)
{
	$ax->branchid=$_GET['firmid'];
}
User::model()->login();

$parentid=Client::model()->find(array('condition'=>'id='.$_GET['id'],));


$clientview=Client::model()->find(array('condition'=>'id='.$_GET['id'],));
 $transferclient=0;

$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (firmid='.$clientview->firmid.' or mainfirmid='.$clientview->firmid.')',
							   ));


$transferclient=0;

if($ax->branchid>0)
{


	$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (mainfirmid='.$ax->branchid.' or firmid='.$ax->branchid.')',
							   ));


	$clientview=Client::model()->find(array('condition'=>'id='.$_GET['id']));
		if($clientview->mainfirmid!=$ax->branchid)
		{
			$transferclient=1;
		}





}


if($ax->clientid>0)
{


	$client=Client::model()->findAll(array(
	#'select'=>'',
	 #'limit'=>'5',
	'order'=>'name ASC',
	'condition'=>'parentid='.$ax->clientid.' and isdelete=0',
	 ));


}





$transfer=0;
if($clients->firmid!=$clients->mainfirmid && $clients->firmid!=$_GET['id'])
{
	 $transfer=1;
}


?>

<?php if (Yii::app()->user->checkAccess('client.branch.view')){ ?>
<?=User::model()->geturl('Client','Branch',$_GET['id'],'client',0,$ax->branchid);?>


	<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
			<div class="card-header" style="">
						<ul class="nav nav-tabs">

						<?php if (Yii::app()->user->checkAccess('client.branch.view')){ ?>
                       <li class="nav-item">
                        <a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/view?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $client);?></span><?=t('Branch');?></a>
                      </li>
					  <?php }?>

					<?php if (Yii::app()->user->checkAccess('client.staff.view')  && $transferclient==0){ ?>
                      <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/staff?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect2" style="font-size: 15px;"><?php								$say=User::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and clientbranchid=0'));
							echo count($say);?>
						</span><?=t('Staff');?>


							</a>
                      </li>

					  <?php }?>


            <?php if ($ax->type==22 || $ax->type==17 || $ax->type==23 || $ax->type==13 || $ax->type==13 || $ax->id==1){ ?>
                        <li class="nav-item">
                          <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/workorderreports?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Workorder Report');?></a>
                        </li>

              <?php }?>


                    </ul>
				</div>
			</div>
	</div>
</div>



<?php if (Yii::app()->user->checkAccess('client.branch.create')){ ?>
<div class="row" id="createpage">
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">


				<div class="card-header" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					 <div class="col-md-6">
                  <h4  class="card-title"><?=t('Branch Client Create');?></h4>
					</div>
					 <div class="col-md-6">
               	<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
						</div>
                </div>
				</div>

					<form id="client-form" action="/client/create/<?=$_GET['id'];?>" method="post">
				<div class="card-content">
					<div class="card-body">


					<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Client Name');?></label>
                          <input required type="text" class="form-control" id="basicInput" value='<?=$clientview->name;?>' placeholder="<?=t('Name');?>" name="Client[name]">
                        </fieldset>
                    </div>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Commercial Title');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Title');?>" value='<?=$clientview->title;?>' name="Client[title]">
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Taxoffice');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Taxoffice');?>" value='<?=$clientview->taxoffice;?>' name="Client[taxoffice]">
                        </fieldset>
                    </div>
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Taxno');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Taxno');?>" value='<?=$clientview->taxno;?>' name="Client[taxno]">
                        </fieldset>
                    </div>


						<?php    $sector=Sector::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'active=1',
							   ));

						?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Sector');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Client[branchid]">
							<?php if(count($sector)!=0){?>
								 <?php foreach($sector as $sectors){?>
									<option <?php if($clientview->branchid==$sectors->id){echo 'selected';}?> value="<?=$sectors->id;?>"><?=t($sectors->name);?></option>
								 <?php }?>

							<?php }?>
                          </select>
                        </fieldset>
                    </div>

						<?php    $clientx=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								  # 'condition'=>'active=1',
							   ));

						?>




				<!--
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect">Parent</label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Client[parentid]">
						  <option value="0">Select</option>
						  <?php if(count($clientx)!=0){?>
						  <?php foreach($clientx as $clienty){?>
                            <option value="<?=$clienty->id;?>"><?=$clienty->name;?></option>
						  <?php }?>
						  <?php }?>
                          </select>
                        </fieldset>
                    </div>
					-->

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Address');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Address');?>" value='<?=$clientview->address;?>' name="Client[address]" >
                        </fieldset>
                    </div>


				<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Land Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Land Phone');?>" value='<?=$clientview->landphone;?>' name="Client[landphone]" >
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('E-mail');?></label>
                        <fieldset class="form-group">
                          <input type="email" class="form-control" id="basicInput" placeholder="<?=t('E-mail');?>" value='<?=$clientview->email;?>' name="Client[email]" >
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Active');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Client[active]">
                            <option selected=""><?=t('Select');?></option>
                            <option  value="1" selected><?=t('Active');?></option>
                            <option  value="0"><?=t('Passive');?></option>
                          </select>
                        </fieldset>
                    </div>



					  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit"><?=t('Create');?></button>
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
					   <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
						 <h4 class="card-title"><?=$parentid->name.' '.t('BRANCH LIST');?></h4>
						</div>

						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
							 <?php if (Yii::app()->user->checkAccess('client.branch.create') && $ax->type!=22){?>
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Branch');?> <i class="fa fa-plus"></i></button>
							<?php
							}
						?>
								</div>

						</div>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>

														<th><?=mb_strtoupper(t('Name'));?></th>
							<th><?=mb_strtoupper(t('Sector'));?></th>
								<th><?=t('TRANSFER');?></th>
							<th><?=mb_strtoupper(t('Active'));?></th>
												<th>  <?=mb_strtoupper(t('Process'));?></th>

                          </tr>
                        </thead>
                        <tbody>
             		<?php foreach($client as $clients):?>
                                <tr>
                                    <td><a href="<?=Yii::app()->baseUrl?>/client/branches/<?=$clients->id;?>"><?=$clients->name;?></a></td>

										<?php $sector=Sector::model()->find(array(
											'condition'=>'id=:id',
											'params'=>array(':id'=>$clients->branchid),
										));?>



									<td><?=t($sector->name);?></td>

										<!--<?php #$clientk=Client::model()->find(array(
											#'condition'=>'id=:id',
											#'params'=>array(':id'=>$clients->parentid),
										#));?>


									<td><?#=$clientk->name;?></td>

									-->
								<?php
									  $transfer=Client::model()->istransfer($clients->id);?>
								<td><?php if($transfer==1){echo Firm::model()->find(array('condition'=>'id='.$clients->firmid))->name;}else{echo 'No Transfer';}?></td>

								<td>
								<?php if(Yii::app()->user->checkAccess('client.branch.update')){?>
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$clients->id;?>"  <?php if($clients->active==1){echo "checked";}?>
									<?php if (($transfer==1 && $clients->mainfirmid==$ax->branchid && $ax->branchid!=0) || ($transfer==0 && $clients->firmid!=$ax->branchid && $ax->branchid!=0)){?>disabled<?php }?> />
									</div>
								<?php }?>
								</td>




									<td>
										<?php if (($transfer==1 && $clients->mainfirmid!=$ax->branchid) || ($transfer==0 && $clients->firmid==$ax->branchid)||$ax->branchid==0){?>

									<?php if (Yii::app()->user->checkAccess('client.branch.update')){ ?>
									 <a   class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?=$clients->id;?>"
																									  data-name="<?=$clients->name;?>"
																									  data-title="<?=$clients->title;?>"
																									  data-taxoffice="<?=$clients->taxoffice;?>"
																									  data-taxno="<?=$clients->taxno;?>"
																									  data-active="<?=$clients->active;?>"
																									  data-branchid="<?=$clients->branchid;?>"
																									  data-parentid="<?=$clients->parentid;?>"
																									  data-email="<?=$clients->email;?>"
																									  data-landphone="<?=$clients->landphone;?>"
																									   data-address="<?=$clients->address;?>"

																									  ><i style="color:#fff;" class="fa fa-edit"></i></a>

									<?php }?>
									<?php if (Yii::app()->user->checkAccess('client.branch.view')){ ?>
										<a href="<?=Yii::app()->baseUrl?>/client/view/<?=$clients->id;?>"  class="btn btn-info btn-sm" ><i style="color:#fff;" class="fa fa-info"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('client.branch.delete')){ ?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$clients->id;?>" data-parentid="<?=$clients->parentid;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>

										<?php }?>
									</td>
                                </tr>

								<?php endforeach;?>

                        </tbody>
                        <tfoot>
                          <tr>
														<th><?=mb_strtoupper(t('Name'));?></th>
							<th><?=mb_strtoupper(t('Sector'));?></th>
								<th><?=t('TRANSFER');?></th>
							<th><?=mb_strtoupper(t('Active'));?></th>
												<th>  <?=mb_strtoupper(t('Process'));?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>





<?php if (Yii::app()->user->checkAccess('client.branch.update')){ ?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Client Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="client-form" action="/client/update/0" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalclientid" name="Client[id]" value="0">
							<input type="hidden" class="form-control" id="modalclientparentid" name="Client[parentid]" value="0">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Client Name');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalclientname" placeholder="<?=t('Name');?>" name="Client[name]" value="">
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('Commercial Title');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalclienttitle" placeholder="<?=t('Title');?>" name="Client[title]" value="">
									</fieldset>
								</div>


								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Taxoffice');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalclienttaxoffice" placeholder="<?=t('Taxoffice');?>" name="Client[taxoffice]" value="">
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Taxno');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalclienttaxno" placeholder="<?=t('Taxno');?>" name="Client[taxno]" value="">
									</fieldset>
								</div>

										<?php    $sector=Sector::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'active=1',
							   ));

						?>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Sector');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="modalclientbranchid" name="Client[branchid]">
							<?php if(count($sector)!=0){?>
								 <?php foreach($sector as $sectors){?>
									<option value="<?=$sectors->id;?>"><?=t($sectors->name);?></option>
								 <?php }?>

							<?php }?>
                          </select>
                        </fieldset>
                    </div>

						<?php    $clientx=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								  # 'condition'=>'active=1',
							   ));

						?>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Address');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalclientaddress" placeholder="<?=t('Address');?>" name="Client[address]" >
                        </fieldset>
                    </div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Land Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalclientlandphone" placeholder="<?=t('Land Phone');?>" name="Client[landphone]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('E-mail');?></label>
                        <fieldset class="form-group">
                          <input type="email" class="form-control" id="modalclientemail" placeholder="<?=t('E-mail');?>" name="Client[email]" >
                        </fieldset>
                    </div>


								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<fieldset class="form-group">
										 <select class="custom-select block" id="modalclientactive" name="Client[active]">
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

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>


	<!-- GÜNCELLEME BİTİŞ-->
<?php }?>


<?php if (Yii::app()->user->checkAccess('client.branch.delete')){ ?>

	<!--SİL BAŞLANGIÇ-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Client Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslangıç-->
						<form id="client-form" action="/client/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalclientid2" name="Client[id]" value="0">
							<input type="hidden" class="form-control" id="modalparentid2" name="Client[parentid]" value="0">

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

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- SİL BİTİŞ -->
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
	$('#modalclientid').val($(obj).data('id'));
	$('#modalclientname').val($(obj).data('name'));
	$('#modalclienttitle').val($(obj).data('title'));
	$('#modalclienttaxoffice').val($(obj).data('taxoffice'));
	$('#modalclienttaxno').val($(obj).data('taxno'));
	$('#modalclientactive').val($(obj).data('active'));
	$('#modalclientbranchid').val($(obj).data('branchid'));
	$('#modalclientparentid').val($(obj).data('parentid'));

	$('#modalclientemail').val($(obj).data('email'));
	$('#modalclientlandphone').val($(obj).data('landphone'));
	$('#modalclientaddress').val($(obj).data('address'));
	$('#duzenle').modal('show');

}



function openmodalsil(obj)
{
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
                 columns: [ 0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:' <?=t('Client Branch')?> (<?=date('d-m-Y');?>)',
			messageTop:'<?=User::model()->table('client',$_GET['id']);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [ 0,1]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:' <?=t('Client Branch')?> (<?=date('d-m-Y');?>)',
			messageTop:'<?=User::model()->table('client',$_GET['id']);?>'
        },

		 {
             extend: 'pdfHtml5',
			exportOptions: {
                 columns: [ 0,1]
            },
			 text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: ' <?=t('Client Branch')?> \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=User::model()->table('client',$_GET['id']);?> \n',
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

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';
?>
