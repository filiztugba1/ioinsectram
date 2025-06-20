

<?php


User::model()->newdocument();


User::model()->login();
$ax= User::model()->userobjecty('');
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isdelete=0',
							   ));
							   
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
				$where="branchid=".$ax->branchid;
			}
		}
		else
		{
			$where="firmid in (".implode(',',Firm::model()->getbranchids($ax->firmid)).")";
		}
	}
	else
	{
		$where="";
	}
	
		
	
    $conformity=Conformity::model()->findAll(array('condition'=>$where));
	
	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
			
		$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid')->queryAll();
	}

?>




<div class="row">
    
   <div class="col-xl-12 col-lg-12 col-12">
	<div class="row">
		

<?php
	


$where=" and clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";

if($ax->clientbranchid==0)
{
	$conformitya=Conformity::model()->findAll(array('condition'=>'statusid!=1'.$where)); // branch
	$conformityk=Conformity::model()->findAll(array('condition'=>'statusid=1'.$where)); // branch
}
else
{
	$conformitya=Conformity::model()->findAll(array('condition'=>'clientid='.$ax->clientbranchid.' and statusid!=1')); // branch
	$conformityk=Conformity::model()->findAll(array('condition'=>'clientid='.$ax->clientbranchid.' and statusid=1')); // branch
}
	?>
				<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>
		<div class="col-xl-6 col-lg-6 col-6">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">
						<div class="p-2 text-center bg-info bg-darken-2">
							<i class="icon-user font-large-2 white"></i>
						</div>
						<div class="p-2 bg-gradient-x-info white media-body">
							<h5><?=t('Opened / Closed Non-Conformities');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformitya);?> / <?=count($conformityk);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>


		<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) 

	
			
	$conformityx=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id WHERE (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) && conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL '.Conformity::model()->where())->queryAll();




	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
			
		$conformityx=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) &&  conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL and departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and departmentpermission.userid='.$ax->id)->queryAll();
	}?>




		<div class="col-xl-6 col-lg-6 col-6">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">
					
						<div class="p-2 text-center bg-info bg-darken-2" style='background-color: #d21f1f !important; border-right: 1px solid #e85555;'>
							
							<a href='/site/conformitydeadline'>
								<i class="fa fa-cloud-upload white" style='font-size: 40px;'></i>
								<div style='font-size: 15px;color: #fff;'><?=t('Rapor Al');?></div>
								
							</a>
						</div>
					
						<div class="p-2 bg-gradient-x-info white media-body" style='background-image: linear-gradient(to right, #d21f1f 0%, #ec5d5d 100%);'>
							<h5><?=t('Non-conformities beyond the deadline');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformityx);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>


    </div>
    </div>




<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>	


	 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
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
						<!--	<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="reportbutton" type="submit"><?=t('Reports');?> <i class="fa fa-file"></i></a>

						-->
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
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('OPENING DATE');?></th>
							<th><?=t('ACTION DEFINITION');?></th>
							<th><?=t('DEADLINE');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('NON-CONFORMITY TYPE');?></th>

							<th><?=t('CLOSED TIME');?></th>

							<th><?=t('DEFINATION');?></th>
							
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
							

							<tr <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.view')){?> onclick="window.open('<?=Yii::app()->baseUrl?>/conformity/activity/<?=$conformityx['id'];?>', '_blank')" <?php }?>>

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

							
								 <?=date('Y-m-d',$conformityx['date']);?>
									 <?//explode(' ',Generalsettings::model()->dateformat($conformityx->date))[0];?></td>

									  <td><?php $activitiondef=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->definition;
								if($activitiondef!=''){echo $activitiondef;}else{echo '-';}?>
								
								
								</td>


								 <td>

								 	 
								 
								 <?php									 $date=Conformityactivity::model()->find(array('order'=>'date DESC','condition'=>'conformityid='.$conformityx['id']));
									
									if(isset($date)){
											echo $date->date;
										//echo Generalsettings::model()->dateformat(strtotime($date->date));
									 
									 }else{echo '-';}?></td>



								<?php if($conformityx->closedtime!='')
								{
									$kpnma=date('Y-m-d',$conformityx->closedtime);
								}
								else{
									$kpnma="-";
								}

								?>
								 <td>
									
								
								<?php $status=Conformitystatus::model()->find(array('condition'=>'id='.$conformityx['statusid']));?>
								


									<a class="btn btn-<?=t($status->btncolor);?> btn-sm" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t($status->name);?> </a>



								
								</td>
								 <td><?=t(Conformitytype::model()->find(array('condition'=>'id='.$conformityx['type'],))->name);?></td>


								 	 <?php if($conformityx->closedtime!='')
								{
									$kpnma=date('Y-m-d',$conformityx->closedtime);
								}
								else{
									$kpnma="-";
								}

								?>
								
								 <td><?=$kpnma?></td>


									 <td><?=$conformityx['definition'];?></td>


							
									
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
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('OPENING DATE');?></th>
							<th><?=t('ACTION DEFINITION');?></th>
							<th><?=t('DEADLINE');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('NON-CONFORMITY TYPE');?></th>

							<th><?=t('CLOSED TIME');?></th>

							<th><?=t('DEFINATION');?></th>
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


<?php
		$workorderwhere='';

			if($ax->clientbranchid==0)
			{
				$client=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
				$i=0;
				foreach($client as $clientx)
				{
					if($i==0)
					{
						$workorderwhere='clientid='.$clientx->id;
						$i++;
					}
					else
					{
						$workorderwhere=$workorderwhere.' or clientid='.$clientx->id;
					}
				}
				
			}
			else
			{
				$workorderwhere='clientid='.$ax->clientbranchid;
			}




			

		
?>
<!---------->
		 <section id="html5">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row" style="border-bottom: 1px solid #e3ebf3;">
								<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
									<h4 class="card-title"><?=t('Workorders');?></h4>
								</div>					
							</div>
						</div>

						 <div class="card-content collapse show">


						 <div class="row">
						 <div class="col-xl-6 col-lg-6 col-md-6">

						 <div class="col-xl-12 col-lg-12 col-md-12"><?=t('5 business plans planned after this date');?></div>
							<div class="card-body card-dashboard">

						 <table class="table table-striped table-bordered dataex-html5-export2 table-responsive">
                        <thead>
                          <tr>
						  <th><?=t('NAME');?></th>
						  <th><?=t('TODO');?></th>
                            <th><?=t('START DATE');?></th>
							
							
                          </tr>
                        </thead>
                        <tbody >
						<?php							
							$workorder=Workorder::model()->findAll(array('condition'=>'status!=3 and date>="'.date("Y-m-d").'" and ('.$workorderwhere.') ORDER BY date DESC limit 5'));
									foreach($workorder as $workorderm){?>
									   <tr>
									 
										 
										  <td><?=Client::model()->finD(array('condition'=>'id='.$workorderm->clientid))->name;?>
											  </td>
										   <td><?=$workorderm->todo;?></td>
										    <td><?=date('d-m-Y',strtotime($workorderm->date)).' '.$workorderm->start_time;?> </td>
										 
										   
										   <!--<td>
											<?php											   if($workorderm->executiondate!='')
												{
													echo date("d-m-Y H:i:s",$workorderm->executiondate);
												}
												else
												{
													echo t('Continues');
												}
											 ?>
										  </td>

										  -->
										</tr>

								<?php								}?>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
						  <th><?=t('NAME');?></th>
						  <th><?=t('TODO');?></th>
                            <th><?=t('START DATE');?></th>
							
                          </tr>
                        </tfoot>
                      </table>
				</div>	
			</div>


			<div class="col-xl-6 col-lg-6 col-md-6">

			<div class="col-xl-12 col-lg-12 col-md-12"><?=t('5 business plans completed before this date');?></div>
					<div class="card-body card-dashboard">

						 <table style='padding:0px' class="table table-striped table-bordered dataex-html5-export2 table-responsive">
                        <thead>
                          <tr>
							<th><?=t('NAME');?></th>
						 <!-- <th style='width: 100%;'><?=t('TODO');?></th> -->
                            <th style='width: 100%;'><?=t('START DATE');?></th>
							
							<th style='width: 100%;'><?=t('EXECUTION DATE');?></th>
							
                          </tr>
                        </thead>
                        <tbody >
								 <?php
				
						//echo $workorderwhere;
						/*
						$workordery=Workorder::model()->findAll(array('condition'=>'status=3 and executiondate<="'.date("Y-m-d").'" and ('.$workorderwhere.') ORDER BY executiondate desc limit 5'));
						*/



						$workordery=Workorder::model()->findAll(array('condition'=>'status=3 and executiondate<="'.date("Y-m-d").'" and ('.$workorderwhere.') ORDER BY executiondate desc limit 5'));
								foreach($workordery as $workorderx){?>
								   <tr>

								   <td><?=Client::model()->finD(array('condition'=>'id='.$workorderx->clientid))->name;?>
											  </td>


								 <?// echo date("d-m-Y H:i:s",1552286120);?>
								   <!--   <td><?=$workorderx->todo;?></td> -->
									  <td><?php  
									  if($workorderx->realstarttime)
									  {
									 echo date('d/m/Y H:i',$workorderx->realstarttime);
									  }
									  else{
										  echo "-";

									  }
									  
									  
									  ?> </td>
									 
									   <td>
										<?php										   if($workorderx->realendtime!='')
											{
												echo date("d/m/Y H:i",$workorderx->realendtime);
											}
											else
											{
												echo t('Continues');
											}
										 ?>
									  </td>
									</tr>

							<?php }?>
						
						 
                        </tbody>
                        <tfoot>
                          <tr>
						<th><?=t('NAME');?></th>
						  <!-- <th style='width: 100%;'><?=t('TODO');?></th> -->
                            <th style='width: 100%;'><?=t('START DATE');?></th>
							
							<th style='width: 100%;'><?=t('EXECUTION DATE');?></th>
                          </tr>
                        </tfoot>
                      </table>

					</div>	
				</div>	
		</div>
<!---------->


						</div>	
					</div>					
				</div>
			 </div>
		</div>					
	</div>
</div>

        <!--/ HTML5 export buttons table -->

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.update')){ ?>
<!-- GÜNCELLEME BAŞLANGIÇ-->		
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Management Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangıç-->						
				<form id="conformity-form2" action="/conformity/update/0" method="post" enctype="multipart/form-data">	
                     <div class="modal-body">
					 <input type="hidden" class="form-control" id="modalid" name="Conformity[id]" value="0">

						<?php if($ax->firmid==0){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm2" name="Conformity[firmid]" onchange="myfirm2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm2" name="Conformity[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>
						
						<?php if($ax->branchid==0){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch2" name="Conformity[branchid]" onchange="mybranch2()" requred>
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
							<input type="hidden" class="form-control" id="branch2" name="Conformity[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>
					
					<?php if($ax->clientid==0){?>					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">
						
                          <select class="select2" style="width:100%" id="client2" name="Conformity[clientid]" requred onchange="myFunctionClient2()">
								<option value="0">Select</option>
								<?php								if($workorder->branchid!=0){
								$client=Client::model()->findall(array('condition'=>'parentid=0 and firmid='.$workorder->branchid));
								
									foreach($client as $clientx)
										{?>
											<optgroup label="<?=$clientx->name;?>">
												<?php $clientbranchs=Client::model()->findAll(array('condition'=>'parentid='.$clientx->id));
													
													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
								<?php }}?>
							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client2" name="Conformity[clientid]" value="<?=$ax->branchid;?>" requred>
					<?php }?>

					
					
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Department');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="department2" name="Conformity[departmentid]" onchange="myFunctionDepartment2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									
									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						
						
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Sub-department');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="subdepartment2" name="Conformity[subdepartmentid]" requred>
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
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					 <label for="basicSelect"><?=t('Non-Conformity Type');?></label>
                       <fieldset class="form-group">
						  <select class="select2" id="modaltype" style="width:100%"  name="Conformity[type]">
                            <option value="0" selected=""><?=t('Please Chose');?></option>
							
							<?php								foreach($type as $typex){?>
									<option value="<?=$typex->id;?>"><?=t($typex->name);?></option>
							<?php }?>
                        
                          </select>
                        </fieldset>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					 <label for="basicSelect"><?=t('Non-Conformity Status');?></label>
                       <fieldset class="form-group">
						  <select class="select2" id="modalstatusid" style="width:100%"  name="Conformity[statusid]">
                          </select>
                        </fieldset>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Priority');?></label>
                        <fieldset class="form-group">
						
                          <select class="select2" style="width:100%" id="modalpriority" name="Conformity[priority]">
								<option value="1"><?=t('1. Degree');?></option>
								<option value="2"><?=t('2. Degree');?></option>
								<option value="3"><?=t('3. Degree');?></option>
								<option value="4"><?=t('4. Degree');?></option>
							</select>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Date');?></label>
                          <input type="date"  class="form-control"  placeholder="<?=t('Date');?>" name="Conformity[date]" id="modaldate">
                        </fieldset>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<div id="img"></div>
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Upload File');?></label>
                          <input type="file"  class="form-control"  name="Conformity[filesf]">
                        </fieldset>
                    </div>
				<input type="hidden"  class="form-control"  name="Conformity[filesfx]" id="modalfilesf">
		
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Definition');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Definition');?>" id="modaldefinition" name="Conformity[definition]"></textarea>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Conformity[suggestion]" id="modalsuggestion"></textarea>
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


	
	<?php }?>
	<!-- GÜNCELLEME BİTİŞ-->

<?php }?>

<style>
#waypointsTable tr:hover {
    background-color:#ccdcf7;
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

 

 function openmodal(obj)
{
	$('#firm2').val($(obj).data('firmid'));
	
	  $.post( "/workorder/firmbranch?id="+$(obj).data('firmid')).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		$('#branch2').val($(obj).data('branchid'));
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});
	$.post( "/workorder/client?id="+$(obj).data('branchid')).done(function( data ) {
		$( "#client2" ).prop( "disabled", false );
		$('#client2').html(data);
		$('#client2').val($(obj).data('clientid'));
	});
	$.post( "/conformity/client?id="+$(obj).data('clientid')).done(function( data ) {
		$( "#department2" ).prop( "disabled", false );
		$('#department2').html(data);
		$('#department2').val($(obj).data('departmentid'));
	});
	$.post( "/conformity/department?id="+$(obj).data('departmentid')).done(function( data ) {
		$( "#subdepartment2" ).prop( "disabled", false );
		$('#subdepartment2').html(data);
		$('#subdepartment2').val($(obj).data('subdepartmentid'));
	});
	
	$.post( "/conformity/conformitytype?id="+$(obj).data('clientid')+'&&branch='+$(obj).data('branchid')+'&&firm='+$(obj).data('firmid')).done(function( data ) {
		$( "#modaltype" ).prop( "disabled", false );
		$('#modaltype').html(data);
		$('#modaltype').val($(obj).data('type'));
	});
	
	$.post( "/conformity/conformitystatus?id="+$(obj).data('clientid')+'&&branch='+$(obj).data('branchid')+'&&firm='+$(obj).data('firmid')).done(function( data ) {
		$( "#modalstatusid" ).prop( "disabled", false );
		$('#modalstatusid').html(data);
		$('#modalstatusid').val($(obj).data('statusid'));
	});
	

										 
	$('#modalid').val($(obj).data('id'));
	
	
	
	
	$('#modaldefinition').val($(obj).data('definition'));
	$('#modalsuggestion').val($(obj).data('suggestion'));
	$('#modalstatusid').val($(obj).data('statusid'));
	$('#modalpriority').val($(obj).data('priority'));
	$('#modaldate').val($(obj).data('date'));
	$('#modalfilesf').val($(obj).data('filesf'));
	$('#duzenle').modal('show');
	
}




$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

<?php $whotable=User::model()->iswhotable();?>
$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[3,10,20,50,100, -1], [3,10,20,50,100, "<?=t('All');?>"]],
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

		"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				// "targets": 0
			} ],
			// "order": [[ 4, 'asc' ]],
		


	 buttons: [

		 <?php if($yetki==1){?>
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

			<?php }?>

	


        'colvis',
		'pageLength'
    ]
	

} );
} );


$(document).ready(function() {
    var t = $('.dataex-html5-export2').DataTable( {

		responsive: true,
         scrollCollapse: true,
        paging:         false,
		 "bAutoWidth": true,

		language: {
   
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


        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            // "targets": 0
        } ],
       "order": []
    } );
 
 
} );





</script>		 
 <?php
 

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

?>