
<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isdelete=0',
							   ));
$okconformity=Conformity::model()->findAll(array('condition'=>"statusid=2",'order'=>'date desc'));
	foreach($okconformity as $okconformityx){
		$okconformityx->statusid=4;
	}

/*	Yii::app()->db->createCommand(
	'UPDATE conformity SET statusid=4 WHERE statusid=2')->execute();
*/

	if($ax->firmid>0)
	{
		if($ax->branchid>0)
		{
			if($ax->clientid>0)
			{
				if($ax->clientbranchid>0)
				{
					$where="clientid=".$ax->clientbranchid;


				}
				else
				{
					$where="clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";

					/*	$workorder=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
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

						}*/


				}
			}
			else
			{
				$where="firmbranchid=".$ax->branchid;
			}
		}
		else
		{
			$where="firmid in (".implode(',',Firm::model()->getbranchids($ax->firmid)).")";
		}


		if(isset($_GET['status']))
		{
			$where=$where." and statusid=".$_GET['status'];
		}
	}
	else
	{
		$where="";

		if(isset($_GET['status']))
		{
			$where="statusid=".$_GET['status'];
		}
	}



	//echo $where;
    $conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'date desc'));


	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$where='';
		if(isset($_GET['status']))
		{

			$where=" and conformity.statusid=".$_GET['status'];
		}

		$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid  and departmentpermission.userid='.$ax->id.$where)->queryAll();
	}
// echo count( $conformity);
$yetki=1;

if($ax->mainclientbranchid!=$ax->clientbranchid)
{
	$yetki=0;
}



?>

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>
	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity','',0,'conformity');?>
<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Non-Conformity Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				 <form id="conformity-form" action="/conformity/create" method="post" enctype="multipart/form-data">
				<div class="card-content">
					<div class="card-body">


					<div class="row">


						<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Conformity[firmid]" onchange="myfirm()" requred>
									<option value="0">Please Chose</option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Conformity[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Conformity[branchid]" onchange="mybranch()" disabled requred>
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
							<input type="hidden" class="form-control" id="branch" name="Conformity[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>

					<?php if($ax->clientbranchid==0){?>
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" name="Conformity[clientid]" disabled requred onchange="myFunctionClient()">
								<option value="0"><?=t("Select");?></option>
								<?php								if($workorder->branchid!=0){
								$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$workorder->branchid));

									foreach($client as $clientx)
										{ $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));

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

									}

									}?>
							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client" name="Conformity[clientid]" value="<?=$ax->branchid;?>" requred>
					<?php }?>



						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Department');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="department" name="Conformity[departmentid]" onchange="myFunctionDepartment()" disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Sub-Department');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="subdepartment" name="Conformity[subdepartmentid]" disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>


					<?php					$type=Conformitytype::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isactive=1',
							   ));

					?>
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					 <label for="basicSelect"><?=t('Non-Conformity Type');?></label>
                       <fieldset class="form-group">
						  <select class="select2" id="conformitytype" style="width:100%" name="Conformity[type]" disabled>
                            <option value="0" selected=""><?=t('Please Chose');?></option>

							<?php								foreach($type as $typex){?>
									<option value="<?=$typex->id;?>"><?=t($typex->name);?></option>
							<?php }?>

                          </select>
                        </fieldset>


                    </div>



					<input type="hidden"  class="form-control"  name="Conformity[statusid]" value="0">

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Priority');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" name="Conformity[priority]">
								<option value="1">1.<?=' '.t('Degree');?></option>
								<option value="2">2.<?=' '.t('Degree');?></option>
								<option value="3">3.<?=' '.t('Degree');?></option>
								<option value="4">4.<?=' '.t('Degree');?></option>
							</select>
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Date');?></label>
                          <input type="date"  class="form-control"  placeholder="<?=t('Date');?>" name="Conformity[date]" value="<?=date('Y-m-d');?>">
                        </fieldset>
                    </div>
<!--

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Date');?></label>
									<fieldset class="form-group">
										<div class="form-group">
											<div class="input-group date">
												<input type="text"  id="datetimepicker2" name="Conformity[date]" required>
													 <div class="input-group-append">
														<span class="input-group-text">
														  <span class="fa fa-calendar"></span>
														</span>
													  </div>
											</div>
										</div>
								</fieldset>
						</div>

	-->





					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Upload File');?></label>
                          <input type="file"  class="form-control"  name="Conformity[filesf]">
                        </fieldset>
                    </div>



					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Definition');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Definition');?>" name="Conformity[definition]"></textarea>
                        </fieldset>
                    </div>

					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Conformity[suggestion]"></textarea>
                        </fieldset>
                    </div>





					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">
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
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
						<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   	<div class="col-xl-7 col-lg-9 col-md-9 mb-1">
						 		<h4 class="card-title"><?=t('NON-CONFORMITY LIST');?></h4>
							</div>
						 	<div class="col-xl-5 col-lg-3 col-md-3 mb-1">
							<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.create') && $ax->clientid==0){ ?>
							<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="createbutton" type="submit"><?=t('Add Non-Conformity');?> <i class="fa fa-plus"></i></a>
							<?php }?>
							<a href='/conformity/reports' target="_blank" style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="reportbutton" type="submit"><?=t('Reports');?> <i class="fa fa-file"></i></a>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style='background:#e0ebff;padding:12px 10px 12px 0px;    border-radius: 5px;'>




						<?$status=Conformitystatus::model()->findAll(array('order'=>'sira desc'));



					foreach($status as $statusk){?>
					<a href='/conformity?status=<?=$statusk->id;?>' class="btn btn-<?=$statusk->btncolor;?> btn-sm" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t($statusk->name);?> </a>

					<?php }?>

							 <a href='/conformity' class="btn btn-sm bet-default" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t('All');?> </a>

						</div>




					</div>



                </div>

                <div class="card-content collapse show">




                  <div class="card-body card-dashboard">

                      <table  class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
						  <!--
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
						  -->
						 <th><?=t('NON-CONFORMITY NO');?></th>
							<th><?=t('WHO');?></th>
                            <th><?=t('TO WHO');?></th>
                            <th><?=mb_strtoupper(t('Department'));?></th>
                            <th><?=mb_strtoupper(t('Sub-Department'));?></th>
                            <th><?=t('OPENING DATE');?></th>
							<th><?=mb_strtoupper(t('Action Definition'));?></th>
							<th><?=mb_strtoupper(t('Deadline'));?></th>
							<th><?=t('CLOSED TIME');?></th>
							<th><?=mb_strtoupper(t('Status'));?></th>
							<th><?=mb_strtoupper(t('Non-Conformity Type'));?></th>



							<th><?=mb_strtoupper(t('Definition'));?></th>

							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>



                          </tr>
                        </thead>
                        <tbody id='waypointsTable'>


					 		<?php
								foreach($conformity as $conformityx){



							$depart=Departments::model()->find(array('condition'=>'id='.$conformityx['departmentid'],));
							if ($depart){ $depart=$depart->name;
							$subdep=Departments::model()->find(array('condition'=>'id='.$conformityx['subdepartmentid'],))->name;
							}else{
							$depart='-';
							$subdep='-';

							}
								?>

						   <?php

							 $status=Conformitystatus::model()->find(array('condition'=>'id='.$conformityx['statusid']));?>
							<tr <?php if($status->id==0){echo 'style="background-color: #c8d2f9;"';}?>  <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.view')){?> onclick="window.open('<?=Yii::app()->baseUrl?>/conformity/activity/<?=$conformityx['id'];?>', '_blank')" <?php }?>>

							<!--
							<td><input type="checkbox" name="Education[id][]" class='sec' value="<?=$conformityx->id;?>"></td>
							-->

							 <td>

									 <?=$conformityx['numberid'];?>
								 </td>

								 <td>
									 <?php										$userwho=User::model()->find(array('condition'=>'id='.$conformityx['userid']));
										echo $userwho->name.' '.$userwho->surname;

									 ?>
								 </td>
								 <td>
									<?php									 	if($userwho->clientid==0)
										{

											echo $listclient=Client::model()->find(array('condition'=>'id='.$conformityx['clientid']))->name;
											/*
												$listclient=Client::model()->find(array('condition'=>'id='.$conformityx['clientid']))->parentid;
											echo Client::model()->find(array('condition'=>'id='.$listclient))->name;
											*/
										}
										else
										{

											echo Firm::model()->find(array('condition'=>'id='.$userwho->firmid))->name;
										}
									?>

								 </td>
								 <td><?=$depart?></td>
								 <td><?=$subdep?></td>
								 <td>


								 <?php
								 if( gmdate('m',$conformityx['date'])==2)
								{
								 echo gmdate('Y-m-d',$conformityx['date']);
								}
								 else
								{
								 echo date('Y-m-d',$conformityx['date']);
								 };?>
									 <?//explode(' ',Generalsettings::model()->dateformat($conformityx->date))[0];?></td>

									  <td><?$activitiondef=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->definition;
								if($activitiondef!=''){echo $activitiondef;}else{echo '-';}?>


								</td>


								 <td>



								 <?php									 $date=Conformityactivity::model()->find(array('order'=>'date DESC','condition'=>'conformityid='.$conformityx['id']));

									if(isset($date)){
											echo $date->date;
										//echo Generalsettings::model()->dateformat(strtotime($date->date));

									 }else{echo '-';}?></td>



								<?	if($conformityx->closedtime!='')
								{
									$kpnma=date('Y-m-d',$conformityx->closedtime);
								}
								else{
									$kpnma="-";
								}

								?>


									 	 <?	if($conformityx->closedtime!='')
								{
									$kpnma=date('Y-m-d',$conformityx->closedtime);
								}
								else{
									$kpnma="-";
								}

								?>

								 <td><?=$kpnma?></td>



								 <td>






									<a class="btn btn-<?=$status->btncolor;?> btn-sm" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t($status->name);?> </a>




								</td>
								 <td><?=t(Conformitytype::model()->find(array('condition'=>'id='.$conformityx['type'],))->name);?></td>





									 <td><?=$conformityx['definition'];?></td>




								<td><?=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->nokdefinition;?></td>
								<td><?=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->activitydefinition;?></td>




									<!--<td>

										<div class="btn-group mr-1 mb-1">
										  <button type="button" class="btn btn-danger btn-block dropdown-toggle" data-toggle="dropdown"
										  aria-haspopup="true" aria-expanded="false">
											<?=t('Process');?>
										  </button>
										  <div class="dropdown-menu open-left arrow">
											<button class="dropdown-item" type="button"><?=t('Activity');?></button>
												<div class="dropdown-divider" style="border-top:1px solid #eceef1;"></div>
											<button class="dropdown-item" type="button"><?=t('Edit');?></button>
												<div class="dropdown-divider" style="border-top:1px solid #eceef1;"></div>
											<button class="dropdown-item" type="button"><?=t('Delete');?></button>


										  </div>
										</div>



										</td>
										-->





                       </tr>

					    <style>

						<?php if($status->id==0){?>
						#waypointsTable tr {
							background-color:#ccdcf7;
						}
						<?php }?>

						</style>


						<?php }?>


                        </tbody>
                        <tfoot>
                          <tr>
						  <!--
						   <th style='width:1px;'>
						   <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.delete')){ ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete selected');?>"><i class="fa fa-trash"></i></button>
								</div>
								<?php }?>
							</th>
							-->
							<th><?=t('NON-CONFORMITY NO');?></th>
							 <th><?=t('WHO');?></th>
                            <th><?=t('TO WHO');?></th>
                            <th><?=mb_strtoupper(t('Department'));?></th>
                            <th><?=mb_strtoupper(t('Sub-Department'));?></th>
                            <th><?=t('OPENING DATE');?></th>
							<th><?=mb_strtoupper(t('Action Definition'));?></th>
							<th><?=mb_strtoupper(t('Deadline'));?></th>
							<th><?=t('CLOSED TIME');?></th>
							<th><?=mb_strtoupper(t('Status'));?></th>
							<th><?=mb_strtoupper(t('Non-Conformity Type'));?></th>



							<th><?=mb_strtoupper(t('Definition'));?></th>

							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>


                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ HTML5 export buttons table -->



	<!--delelete all start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslang��-->
						<form action="/conformity/deleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Conformity[id]" value="0">

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

<?php }
?>

<style>
#waypointsTable tr:hover {
    background-color:#ccdcf7;
}
</style>

<script>
$("#createpage").hide();
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
	if($("#branch").length>0)
	{
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	}
<?php }?>



<?php if($ax->clientid!=0){?>
	if($("#branch").length>0)
	{
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	}
<?php }?>


<?php if($ax->clientbranchid!=0){?>
	if($("#client").length>0)
	{
		$.post( "/conformity/client?id="+document.getElementById("client").value).done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});

	$.post( "/conformity/conformitytype?id="+document.getElementById("client").value+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
	});
	}


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


function myFunctionClient() {

  	$.post( "/conformity/client?id="+document.getElementById("client").value).done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});

	$.post( "/conformity/conformitytype?id="+document.getElementById("client").value+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
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




<?$whotable=User::model()->iswhotable();
$whotable->name='';?>
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
			 "order": [[ 5, 'desc' ]],



	 buttons: [

        {
            extend: 'copyHtml5',
            exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Non-Conformity-Report')?> (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Non-Conformity-Report')?> (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
		 },
        {
             extend: 'pdfHtml5',
				 orientation: 'landscape',
                pageSize: 'LEGAL',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
				   text:'<?=mb_strtoupper(t('Pdf'));?>',
			  title: '<?=t('Non-Conformity-Report')?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t('Non-Conformity Report')?> \n',
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
