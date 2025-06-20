<?php
date_default_timezone_set('UTC');
User::model()->login();
$ax= User::model()->userobjecty('');
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isdelete=0',
							   ));


  $conformity=Conformity::model()->find(array(
								   'order'=>'date ASC',
								   'condition'=>'id='.$_GET['id'],
							   ));
	$who=User::model()->whopermission();


	$user=User::model()->find(array('condition'=>'id='.$conformity->userid));
	$viewdeadline='no';
	$efficiencyview='no';
	$statusview='ok';
	$closedview='ok';

			if($user->clientid>0)
			{

				if(($who->who=='branch' && $ax->branchid==$user->branchid) || ($who->who=='firm' && $ax->firmid==$user->firmid) || ($who->who=='admin'))
					{
						$viewdeadline='ok';
						$statusview='no';
						$closedview='no';
						$efficiencyview='ok';

						if($conformity->statusid==0)
						{
						$conformityx=Conformity::model()->find(array('condition'=>'id='.$_GET['id']));
						$conformityx->statusid=5;
						$conformityx->save();
						}

					}
			}
			else
			{

				if($who->who=='client' || $who->who=='clientbranch')
				{
					$viewdeadline='ok';
					$statusview='no';
					$closedview='no';
					$efficiencyview='ok';

					 $clientparent=Client::model()->find(array('condition'=>'id='.$conformity->clientid))->parentid;

					if($ax->clientbranchid==$conformity->clientid || $ax->clientid==$clientparent)
					{
						if($conformity->statusid==0)
						{
						$conformityx=Conformity::model()->find(array('condition'=>'id='.$_GET['id']));
						$conformityx->statusid=5;
						$conformityx->save();
						}
					}
				}
			}




		  $conformity=Conformity::model()->find(array(
								   'order'=>'date ASC',
								   'condition'=>'id='.$_GET['id'],
							   ));


		  $user=User::model()->find(array('condition'=>'id='.$conformity->userid,));

		 $cactive=Conformityactivity::model()->find(array(
										   'order'=>'date ASC',
										   'condition'=>'conformityid='.$_GET['id'],
									   ));


	 $efficiencyevaluation=Efficiencyevaluation::model()->find(array(
										   'condition'=>'conformityid='.$_GET['id'],
									   ));



		//number güncelleme

		/*
			$cli=Client::model()->find(array('condition'=>'id='.$conformity->clientid));
			$clix=Conformity::model()->findAll(array('condition'=>'clientid='.$cli->id,'order'=>'date asc'));
			$say=1;
			foreach($clix as $clixm)
			{
				if($clixm->id==$conformity->id)
				{
					break;
				}
				$say++;
			}
			$de=date("y",$conformity->date);

			$number=$de.'.'.$cli->id.'.'.$say;

			$conformity->numberid=$number;

			$conformity->save();

			*/


	?>

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.view')){?>


<?=User::model()->geturl('Conformity','Activity',$_GET['id'],'conformity');?>


			<div class="card">
				     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
								 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Non-Conformity Info');?></h4>
								  <p style='    border: 1px solid #dadada; border-radius: 5px; padding: 4px 10px 4px 10px; line-height: 23px;max-width: 217px;margin-top: 5px;'>
								  <?=t('Non-Conformity Number').' : '.$conformity->numberid;?> <br>
								  <?=t('Date').' : ';?>

								 <?php								 	 echo date('Y-m-d',$conformity['date']);
							/*	if( gmdate('m',$conformity['date'])==2)
								{
								 echo gmdate('Y-m-d',$conformity['date']);
								}
								 else
								{
								 echo date('Y-m-d',$conformity['date']);
								}
								*/
								?>

								  </p>
									</div>
									 <div class="col-md-6">



								<?php if((($user->clientbranchid==0 && $user->clientid==0) && ($who->who!='client' && $who->who!='clientbranch')) ||(($user->clientbranchid!=0 && $user->clientid!=0) && ($who->who=='client' && $who->who=='clientbranch'))){?>

								<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.delete')){ ?>
												 <button style='margin: 2px;float:right;color:#fff' class="btn btn-danger" onclick="conformitymodalsil(this)" data-id="<?=$conformity->id;?>"
												 data-file="<?=$conformity->filesf;?>"
												 ><?=t('Delete');?></button>
								<?php }?>

								<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.update')){ ?>
										 <button style='margin: 2px;float:right;color:#fff'  class="btn btn-warning" onclick="conformitymodalupdate(this)"
										 data-id="<?=$conformity->id;?>"
										 data-clientid="<?=$conformity->clientid;?>"
										 data-firmid="<?=$conformity->firmid;?>"
										 data-branchid="<?=$conformity->branchid;?>"
										 data-departmentid="<?=$conformity->departmentid;?>"
										 data-subdepartmentid="<?=$conformity->subdepartmentid;?>"
										 data-type="<?=$conformity->type;?>"
										 data-definition="<?=$conformity->definition;?>"
										 data-suggestion="<?=$conformity->suggestion;?>"
										 data-statusid="<?=$conformity->statusid;?>"
										 data-priority="<?=$conformity->priority;?>"
										 data-date="<?=date('Y-m-d',$conformity->date);?>"
										 data-filesf="<?=$conformity->filesf;?>"
										 ><?=t('Update');?></button>
								<?php }}?>




								</div>
						</div>
					 </div>




				<div class="card-content">
					<div class="card-body">

							<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							<div class="col-md-3" style="width:100%"><h5><?=t('Upload File');?></h5>

										<?php if(file_exists(Yii::getPathOfAlias('webroot').'/'.$conformity->filesf) && $conformity->filesf!=''){?>
										 <a href="<?=$conformity->filesf;?>" download> <img class="brand-logo" alt="stack admin logo" style=" width: 126px;" src="<?=Yii::app()->baseUrl.$conformity->filesf;?>"> </a>
										<?php }
										else
										{?>
											<div style='text-align: center; background: #65799c; color: #fff; padding: 50px 0 50px 0;font-size: 21px;'><?=t('No picture')?></div>
										<?php }?>

							</div>
						<div class="col-md-9">
						<div class="row">
							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('From Who?');?></h5><p style="color: #636161;">
									 <?php $user=User::model()->find(array(
									'condition'=>'id=:id',
									'params'=>array(':id'=>$conformity->userid),
									)); ?>
									<?=$user->name;?>
									</p>
							</div>

							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('To Whom?');?></h5><p style="color: #636161;">
									 <?php $client=Client::model()->find(array(
									'condition'=>'id=:id',
									'params'=>array(':id'=>$conformity->clientid),
									)); ?>
									<?=$client->name;?>
									</p>
							</div>


							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Department');?></h5><p style="color: #636161;">
										<?php $department=Departments::model()->find(array(
											'condition'=>'id=:id',
											'params'=>array(':id'=>$conformity->departmentid),
										));?>
										<?=$department->name;?>
								</p>
							</div>

							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Sub Department');?></h5><p style="color: #636161;">
										<?php $subdepartment=Departments::model()->find(array(
											'condition'=>'id=:id',
											'params'=>array(':id'=>$conformity->subdepartmentid),
										));?>
										<?=$subdepartment->name;?>
								</p>
							</div>


							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Non-conformity Status');?></h5><p style="color: #636161;">
										<?php $status=Conformitystatus::model()->find(array(
											'condition'=>'id=:id',
											'params'=>array(':id'=>$conformity->statusid),
										));?>
										<?=t($status->name);?>
								</p>
							</div>

							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Non-conformity Type');?></h5><p style="color: #636161;">
										<?php $type=Conformitytype::model()->find(array(
											'condition'=>'id=:id',
											'params'=>array(':id'=>$conformity->type),
										));?>
										<?=t($type->name);?>
								</p>
							</div>

							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Non-conformity Degree');?></h5><p style="color: #636161;">
										<?=t($conformity->priority.'. Degree');?>
								</p>
							</div>


							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Definition');?></h5><p style="color: #636161;">

										<?=$conformity->definition;?>
								</p>
							</div>

							<div class="col-md-4" style="border-left: #d8d8d8 1px solid;"><h5><?=t('Suggestion / Preventive Action');?></h5><p style="color: #636161;">

										<?=$conformity->suggestion;?>
								</p>
							</div>



					</div>
					</div>



					</div>
					<?php if($conformity->statusid==5){?>

						<div class="col-md-12" style='background: #eaeaea;padding: 0px 23px 0px 23px;' >
						<p style='font-size: 20px;border-bottom: 1px solid #d4d4d4;'><?=t('Assign User');?></p>


						<div class="col-md-12" style='background: #eaeaea;padding: 0px 23px 0px 23px;' >

								<div class="row" >
									<div class="col-md-2" style=""><h5><?=t('Sender User');?></h5>

								</div>

									<div class="col-md-2" style=""><h5>
										<?=t('Recipient User');?></h5>
									</div>

									<div class="col-md-2" style=""><h5>
										<?=t('Operation');?></h5>
									</div>

									<div class="col-md-2" style="">

										<h5><?=t('Send Time');?></h5>
									</div>

									<div class="col-md-2" style="">

										<h5><?=t('Geri çevirme nedeni');?></h5>
									</div>

								</div>
							</div>


						<?php
						$assisgn=Conformityuserassign::model()->findAll(array('condition'=>'conformityid='.$conformity->id));


						foreach($assisgn as $assisgnx)
						{

						?>

						<div class="col-md-12" style='background: #eaeaea;padding: 0px 23px 0px 23px;' >

								<div class="row" >
									<div class="col-md-2" style="">
										<p style="color: #636161;">

												<?php $senderuser=User::model()->find(array('condition'=>'id='.$assisgnx->senderuserid));
													echo $senderuser->name.' '.$senderuser->surname;
												?>
										</p>
									</div>

									<div class="col-md-2" style="">
										<p style="color: #636161;">
												<?php $recipient=User::model()->find(array('condition'=>'id='.$assisgnx->recipientuserid));
													echo $recipient->name.' '.$recipient->surname;
												?>
										</p>
									</div>


									<div class="col-md-2" style="">
										<p style="color: #636161;">
											<?php if($assisgnx->returnstatustype==1){

												echo t('Atama Yapıldı');

											}else{

												echo t('Atama Geri Çevrildi');
											}?>
										</p>
									</div>


									<div class="col-md-2" style="">
										<p style="color: #636161;">

												<?=date('d-m-Y',$assisgnx->sendtime);?>
										</p>


									</div>


									<div class="col-md-2" style="">
										<p style="color: #636161;">

												<?=$assisgnx->definition;?>
										</p>


									</div>

								</div>
							</div>




					<?php }}
					?>


							<?php if(isset($cactive['id'])){?>
							<div class="col-md-12" style='background: #eaeaea;padding: 19px 23px 19px 23px;' >
								<div class="row" >
									<div class="col-md-3" style=""><h5><?=t('Deadline');?></h5><p style="color: #636161;">

												<?=$cactive->date;?>
										</p>
									</div>

									<div class="col-md-3" style=""><h5><?=t('Action Definition');?></h5><p style="color: #636161;">

												<?=$cactive->definition;?>
										</p>
									</div>
										<div class="col-md-3" style=""><h5><?=t('User');?></h5><p style="color: #636161;">
												<?php												if($cactive->deadlineUser!=0){$deadlineUser=User::model()->find(array('condition'=>'id='.$cactive->deadlineUser));?>
												<?=$deadlineUser->name.' '.$deadlineUser->surname;}?>
										</p>
									</div>
									<div class="col-md-3" style="">

									<?php if((($user->clientbranchid==0 && $user->clientid==0) && ($who->who=='client' || $who->who=='clientbranch')) || (($user->clientbranchid!=0 && $user->clientid!=0) && ($who->who!='client' && $who->who!='clientbranch'))){?>


										<?php if($conformity->statusid!=1 && $conformity->statusid!=3 && $conformity->statusid!=2 && $conformity->statusid!=6){?>

										<a style='margin: 2px;float:right;color:#fff' class="btn btn-warning btn-sm" onclick="adefinationupdate(this)" data-id="<?=$cactive->id;?>"
										data-datex="<?=$cactive->date;?>"
										data-definition="<?=$cactive->definition;?>"
												 ><?=t('Action Definition Update');?></a>

										<?php }}?>


									</div>

								</div>
							</div>

							<?php }?>


									<?php if($conformity->statusid==6)
							{?>

								<div class="col-md-12" style='background: #eaeaea;padding: 19px 23px 19px 23px;margin-top:10px' >
								<p style='font-size: 15px;font-weight: 700;border-bottom: 1px solid #dedddd;'><?=t('Nok-Computed');?></p>
								<div class="row" >
									<div class="col-md-4" style=""><h5><?=t('Deadline');?></h5><p style="color: #636161;">

												<?=$cactive->nokdate;?>
										</p>
									</div>

									<div class="col-md-8" style=""><h5><?=t('Action Definition');?></h5><p style="color: #636161;">

												<?=$cactive->nokdefinition;?>
										</p>
									</div>
								</div>
							</div>
							<?php }?>




							<?php if($conformity->statusid!=4 && $conformity->statusid!=5 && $conformity->statusid!=0 && $conformity->statusid!=6){?>
								<div class="col-md-12" style='background: #eaeaea;padding: 14px 23px 7px 23px;margin-top:10px' >
								<p style='font-size: 15px;font-weight: 700;'><?=t('OK - Completed Date');?> : <?=date('Y-m-d',$conformity->closedtime);?>


								<?php if((($user->clientbranchid==0 && $user->clientid==0) && ($who->who!='client' && $who->who!='clientbranch')) ||(($user->clientbranchid!=0 && $user->clientid!=0) && ($who->who=='client' && $who->who=='clientbranch'))){?>


								<button style='margin: 2px;float:right;color:#fff' class="btn btn-warning btn-sm" onclick="modalok(this)" data-id="<?=$_GET['id'];?>"
									data-datex="<?=date('Y-m-d',$conformity->closedtime);?>"
									><?=t('OK - Completed Date Update');?></button>
								</p>


								<?php }}?>



							</div>







							<?php if(($conformity->statusid==1 || $conformity->statusid==3) && is_countable($efficiencyevaluation) && count($efficiencyevaluation)>0){?>


								<div class="col-md-12" style='background: #eaeaea;padding: 19px 23px 19px 23px;margin-top:10px' >
								<p style='font-size: 15px;font-weight: 700;border-bottom: 1px solid #dedddd;'><?=t('Efficiency Evaluation');?></p>
								<div class="row" >
									<div class="col-md-4" style=""><h5><?=t('Deadline');?></h5><p style="color: #636161;">



													<?php if(isset($efficiencyevaluation)){echo $efficiencyevaluation->controldate;}?>
										</p>
									</div>

									<div class="col-md-8" style=""><h5><?=t('Action Definition');?></h5><p style="color: #636161;">

								<?php if(isset($efficiencyevaluation) && $efficiencyevaluation->activitydefinition!=''){echo $efficiencyevaluation->activitydefinition;}else
								{echo t('No activity rating');}?>
										</p>
									</div>
								</div>
							</div>

							<?php }?>





							<?php if($conformity->statusid==1 && $statusview=='ok'){?>
							<!--
							<a style='margin: 2px;float:right;color:#fff' class="btn btn-warning btn-sm" onclick="closedupdate(this)" data-id="<?=$_GET['id'];?>"
								data-ttime="<?=date('Y-m-d',$conformity->closedtime);?>"
								><?=t('Closed Time Update');?></a>

								-->
							<?php }?>



					<?php if( isset($cactive['id']) && $conformity->statusid!=3 && $conformity->statusid!=2 && $conformity->statusid!=1 && $statusview=='ok'){?>
					<div class="col-md-12" style="margin-bottom: 36px;">


					<?php if($conformity->statusid!=6){?>
					<a style='margin: 2px;float:right;color:#fff' class="btn btn-danger" onclick="modalnok(this)" data-id="<?=$_GET['id'];?>"
					data-datex="<?=date('Y-m-d',time());?>"
					data-definition=""
					><?=t('NOK - Completed');?>

					</a>

					<?php }else{?>

					<a style='margin: 2px;float:right;color:#fff' class="btn btn-warning" onclick="modalnok(this)" data-id="<?=$_GET['id'];?>"
					data-datex="<?=$cactive->nokdate;?>"
					data-definition="<?=$cactive->nokdefinition;?>"
					><?=t('NOK - Completed Update');?>

					</a>
					<?php }?>






					<button data-id="<?=$_GET['id'];?>"
					data-datex="<?=date('Y-m-d',time());?>" onclick="modalok(this)" style='margin: 2px;color:#fff;float:right' class="btn btn-success" ><?=t('OK - Completed');?></button>


					</div>
					<?php }?>

					<?php if($conformity->statusid==3 && $closedview=='ok'){?>
					<div class="col-md-12" style="margin-bottom: 36px;">

					<!--
					<a href='/conformity/conformitystatusbutton?id=<?=$_GET['id'];?>&&status=1' style='margin: 2px;color:#fff;float:right' class="btn btn-danger" ><?=t('Closed');?></a>
					-->

					<a style='margin: 2px;float:right;color:#fff' class="btn btn-danger" onclick="modalclosed(this)" data-id="<?=$_GET['id'];?>"
									data-datex="<?=date('Y-m-d',$conformity->closedtime);?>"
									><?=t('Closed');?></a>



					</div>
					<?php }?>



					</div>
				</div>

			</div>

<!-- super log baslangıc -->
<?php if($ax->id==1)
	{?>
		 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-7 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('NON-CONFORMITY LOG LIST');?></h4>
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
						  <th><?=t('PROCESS');?></th>
							<th><?=mb_strtoupper(t('NON-CONFORMITY NO'));?></th>
							<th><?=mb_strtoupper(t('WHO'));?></th>
														 <th><?=mb_strtoupper(t('TO WHO'));?></th>
														 <th><?=mb_strtoupper(t('Department'));?></th>
														 <th><?=mb_strtoupper(t('Sub-Department'));?></th>
														 <th><?=mb_strtoupper(t('OPENING DATE'));?></th>
							<th><?=mb_strtoupper(t('Action Definetion'));?></th>
							<th><?=mb_strtoupper(t('Deadline'));?></th>
							<th><?=mb_strtoupper(t('CLOSED TIME'));?></th>
							<th><?=mb_strtoupper(t('STATUS'));?></th>
							<th><?=mb_strtoupper(t('NON-CONFORMITY TYPE'));?></th>



							<th><?=mb_strtoupper(t('DEFINATION'));?></th>

							<th><?=mb_strtoupper(t('NOK - COMPLETED DEFINATION'));?></th>
							<th><?=mb_strtoupper(t('EFFICIENCY FOLLOW-UP DEFINATION'));?></th>





                          </tr>
                        </thead>
                        <tbody id='waypointsTable'>

							<?php $loglar=Loglar::model()->findAll(array('condition'=>"tablename='conformity' and data LIKE '%{\"id\":".'"'.$_GET['id']."\"%'"));?>
					 		<?php
								foreach($loglar as $loglarx){
								$x=json_decode($loglarx->data);
								$user=User::model()->find(array('condition'=>'id='.$x->userid));
								$client=Client::model()->find(array('condition'=>'id='.$x->clientid));
								$departman=Departments::model()->find(array('condition'=>'id='.$x->departmentid));
								$subdepartman=Departments::model()->find(array('condition'=>'id='.$x->subdepartmentid));
								$activitiondef=Conformityactivity::model()->find(array('condition'=>'conformityid='.$x->id,));
								$status=Conformitystatus::model()->find(array('condition'=>'id='.$x->statusid,));

								$type=Conformitytype::model()->find(array('condition'=>'id='.$x->type,));
								?>

								<tr>
									<td>
							<!-- <a  class="btn btn-success btn-sm" onclick="openmodal(this)"
							 data-id="<?=$loglarx->id;?>" ><i style="color:#fff;" class="fa fa-reply"></i></a>
							 -->

							 	<a  class="btn btn-danger btn-sm" style='margin-top:2px' onclick="logsil(this)"
							 data-id="<?=$loglarx->id;?>"  data-conformityid="<?=$x->id;?>" ><i style="color:#fff;" class="fa fa-trash"></i></a>
								  </td>
									<td><?=$x->numberid;?></td>
									<td><?=$user->name.' '.$user->surname;?></td>
									<td><?=$client->name;?></td>
									<td><?=$departman->name;?></td>
									<td><?=$subdepartman->name;?></td>

									<td><?=date('d:m:Y',$x->date);?></td>
									<td><?=$activitiondef->definition;?></td>
									<td><?=$activitiondef->date;?></td>
									<td><?php if($x->closedtime!=0 && $x->closedtime!='')date('d:m:Y',$x->closedtime);?></td>

									<td><?=$status->name;?></td>

									<td><?=$type->name;?></td>
									<td><?=$x->definition;?></td>

									<td><?=Conformityactivity::model()->find(array('condition'=>'conformityid='.$x->id,))->nokdefinition;?></td>
									<td><?=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$x->id,))->activitydefinition;?></td>
								</tr>
								<?php }?>

                       </tr>



                        </tbody>
                        <tfoot>
                          <tr>
							<th><?=t('PROCESS');?></th>
							<th><?=mb_strtoupper(t('NON-CONFORMITY NO'));?></th>
							<th><?=mb_strtoupper(t('WHO'));?></th>
														 <th><?=mb_strtoupper(t('TO WHO'));?></th>
														 <th><?=mb_strtoupper(t('Department'));?></th>
														 <th><?=mb_strtoupper(t('Sub-Department'));?></th>
														 <th><?=mb_strtoupper(t('OPENING DATE'));?></th>
							<th><?=mb_strtoupper(t('Action Definetion'));?></th>
							<th><?=mb_strtoupper(t('Deadline'));?></th>
							<th><?=mb_strtoupper(t('CLOSED TIME'));?></th>
							<th><?=mb_strtoupper(t('STATUS'));?></th>
							<th><?=mb_strtoupper(t('NON-CONFORMITY TYPE'));?></th>



							<th><?=mb_strtoupper(t('DEFINATION'));?></th>

							<th><?=mb_strtoupper(t('NOK - COMPLETED DEFINATION'));?></th>
							<th><?=mb_strtoupper(t('EFFICIENCY FOLLOW-UP DEFINATION'));?></th>


                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
	<?php }?>

<!-- super log bitis -->
<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.update')){ ?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="conformityduzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
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
						<label for="basicSelect"><?=t('Sub-Department');?></label>
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

					<!--
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					 <label for="basicSelect"><?=t('Non-Conformity Status');?></label>
                       <fieldset class="form-group">
						  <select class="select2" id="modalstatusid" style="width:100%"  name="Conformity[statusid]">
                          </select>
                        </fieldset>
                    </div>
					-->

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


					<?php						/*
					if($conformity->statusid==1 && $statusview=='ok')
					{
						$time='';
						if($conformity->closedtime=='')
						{
							$time=time();
						}
						else
						{
							$time=$conformity->closedtime;
						}
						?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Closed Date');?></label>
                          <input type="date"  class="form-control" value='<?=date('Y-m-d',$time);?>'  name="Conformity[closedtime]" id="modaldate">
						<?php if($conformity->closedtime=='')
						{?>
							<label for="basicSelect"><?=t('Closed time daha once kaydedilmediğinden bugunun tarihi verilmiştir.');?></label>
						<?php }?>
						</fieldset>
                    </div>

					<?php }
					*/?>

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





		<!--SİL BAŞLANGIÇ-->
	<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.delete')){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="conformitysil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Activity Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="user-form" action="/conformity/delete/0" method="post">

					 <input type="hidden" class="form-control" id="modalid2" name="Conformity[id]" value="0">
					 <input type="hidden"  class="form-control"  name="Conformity[filesfx]" id="modalfile">

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



	<?php if($ax->id==1){?>

				<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="conformitylogsil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Activity Log Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="user-form" action="/loglar/delete/0" method="post">

					 <input type="hidden" class="form-control" id="modallogid" name="Loglar[id]" value="0">
						<input type="hidden" class="form-control" id="modalconformityid" name="Loglar[conformityid]" >
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
		<?php }?>

<?php

$assign=Conformityuserassign::model()->find(array('condition'=>'conformityid='.$_GET['id'].' and returnstatustype=1 and parentid=0','order'=>'sendtime desc'));
$yetki=0;
$gerigonderim=0;
if($assign)
{
	$return=Conformityuserassign::model()->find(array('condition'=>'parentid='.$assign->id));
	if($return)
	{
		$yetki=1;
	}
	else
	{
		if($assign->recipientuserid==$ax->id)
		{
			$yetki=1;
			$gerigonderim=1;

		}
	}
}
else
{
	$yetki=1;
}
//if ( !$cactive && Yii::app()->user->checkAccess('nonconformitymanagement.activity.create') && count($cactive)==0 && $viewdeadline=='ok' && $yetki==1){
if ( !$cactive && Yii::app()->user->checkAccess('nonconformitymanagement.activity.create') && $viewdeadline=='ok' && $yetki==1){

?>



<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Add Deadline');?></h4>
									</div>
							<div class="col-md-6">

							<?php if($gerigonderim==0){?>
								  <a style='margin: 2px;float:right;color:#fff' class="btn btn-success" onclick="assign(this)" data-id="<?=$_GET['id'];?>"
									data-datex="<?=date('Y-m-d',$conformity->closedtime);?>"
									><?=t('Assign');?></a>
							<?php }?>

							</div>

						</div>
					 </div>

				<form id="conformity-form" action="/conformityactivity/create" method="post" enctype="multipart/form-data">
				<div class="card-content">
					<div class="card-body">


					<div class="row">


					<input type="hidden"  class="form-control" name="Conformityactivity[conformityid]" value="<?=$_GET['id'];?>">
					<input type="hidden"  class="form-control" name="Conformityactivity[isactive]" value="1">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Deadline');?></label>
                        <fieldset class="form-group col-md-10">
                          <input type="date"  class="form-control" name="Conformityactivity[date]" value="<?=date("Y-m-d");?>">
                        </fieldset>
						</div>
                    </div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Action Definition');?></label>
                        <fieldset class="form-group col-md-10">
                          <textarea  class="form-control" name="Conformityactivity[definition]"></textarea>
                        </fieldset>
						</div>
                    </div>




					  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">

							<?php if($gerigonderim==0){?>
							<?php }else{?>


									<a style='margin: 2px;float:right;color:#fff' class="btn btn-danger" onclick="modalreturnassign(this)"><?=t('Uygunsuzluk tanımlamasını geri gönder');?>

									</a>



							<?php }?>


									<button class="btn btn-primary block-page" type="submit"><?=t('Save');?></button>

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




	<?php if($conformity->statusid==1){?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
<!--
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <div class="modal fade text-left" id="closedupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Closed Time Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<form id="conformity-form2" action="/conformity/closed" method="post" enctype="multipart/form-data">
                     <div class="modal-body">

					 <input type="hidden"  class="form-control"  name="Conformity[id]" value="<?=$_GET['id'];?>">


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Deadline');?></label>
                        <fieldset class="form-group col-md-10">
                         <input type="date" class="form-control" id="closedtime" name="Conformity[closedtime]">
                        </fieldset>
						</div>
                    </div>


                  </div>
                  <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                          <button class="btn btn-warning block-page" type="submit"><?=t('Update');?></button>
                   </div>

						</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
	-->
<?php }?>
	<!-- GÜNCELLEME BİTİŞ-->



<!--return assign GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="returnassign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Geri Gönderme Nedeni');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
				<form id="conformity-form2" action="/conformity/returnassign" method="post" enctype="multipart/form-data">
                     <div class="modal-body">

					<input type="hidden" class="form-control" name="Conformity[id]" value="<?=$_GET['id'];?>">
					<input type="hidden" class="form-control" name="Conformity[assignid]" value="<?=$assign->id;?>">
					<input type="hidden" class="form-control" name="Conformity[senderuserid]" value="<?=$assign->senderuserid;?>">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<div class="row">
								<label class="col-md-2" for="basicSelect"><?=t('Definition');?></label>
								<fieldset class="form-group col-md-10">
								  <textarea  class="form-control" name="Conformity[definition]"></textarea>
								</fieldset>
								</div>
					</div>



                  </div>
                  <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                          <button class="btn btn-warning block-page" type="submit"><?=t('Save');?></button>
                   </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!--return assign  BİTİŞ-->




<!--nok GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="nokupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Reason for not being closed');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
				<form id="conformity-form2" action="/conformity/conformitystatusbutton?id=<?=$_GET['id'];?>&&status=6" method="post" enctype="multipart/form-data">
                     <div class="modal-body">

					 <input type="hidden"  class="form-control"  name="Conformity[id]" value="<?=$_GET['id'];?>">


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Nok Date');?></label>
                        <fieldset class="form-group col-md-10">
                         <input type="date" class="form-control" id="nokdate" name="Conformityactivity[nokdate]">
                        </fieldset>
						</div>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<div class="row">
								<label class="col-md-2" for="basicSelect"><?=t('Nok Definition');?></label>
								<fieldset class="form-group col-md-10">
								  <textarea  class="form-control" id='nokdefination' name="Conformityactivity[definition]"></textarea>
								</fieldset>
								</div>
					</div>



                  </div>
                  <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                          <button class="btn btn-warning block-page" type="submit"><?=t('Save');?></button>
                   </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!--nok GÜNCELLEME BİTİŞ-->




	<!--nok GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="okupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Ok Date');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
				<form id="conformity-form2" action="/conformity/conformitystatusbutton?id=<?=$_GET['id'];?>&&status=2" method="post" enctype="multipart/form-data">
                     <div class="modal-body">

					 <input type="hidden"  class="form-control"  name="Conformity[id]" value="<?=$_GET['id'];?>">


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Ok Date');?></label>
                        <fieldset class="form-group col-md-10">
                         <input type="date" class="form-control" id="okdate" name="Conformityactivity[okdate]">
                        </fieldset>
						</div>
                    </div>


                  </div>
                  <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                          <button class="btn btn-warning block-page" type="submit"><?=t('Save');?></button>
                   </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!--nok GÜNCELLEME BİTİŞ-->





	<!-- Closed start-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="closedupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Closed');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
				<form id="conformity-form2" action="/conformity/conformitystatusbutton?id=<?=$_GET['id'];?>&&status=1" method="post" enctype="multipart/form-data">
                     <div class="modal-body">

					 <input type="hidden"  class="form-control"  name="Conformity[id]" value="<?=$_GET['id'];?>">


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Closed Date');?></label>
                        <fieldset class="form-group col-md-10">
                         <input type="date" class="form-control" value='<?=date('Y-m-d',time());?>' name="Conformityactivity[closeddate]">
                        </fieldset>
						</div>
                    </div>


                  </div>
                  <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                          <button class="btn btn-danger block-page" type="submit"><?=t('Save');?></button>
                   </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- Closed Finish-->







		<!-- assingn start-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="assingnuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('User assignment');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
				<form id="conformity-form2" action="/conformity/assigncreate" method="post" enctype="multipart/form-data">
                     <div class="modal-body">

					 <input type="hidden"  class="form-control"  name="Conformity[id]" value="<?=$_GET['id'];?>">



						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Users');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="userassign" name="Conformity[recipientuser]"  requred>
								</select>
							</fieldset>
						</div>

                  </div>
                  <div class="modal-footer">
                          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                          <button class="btn btn-success block-page" type="submit"><?=t('Save');?></button>
                   </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- assign Finish-->



<?php



if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.update')){?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Activation defination update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
				<form id="conformity-form2" action="/conformityactivity/update/0" method="post" enctype="multipart/form-data">
                     <div class="modal-body">
				 <input type="hidden" class="form-control" id="modalidd" name="Conformityactivity[id]" value="0">

					 <input type="hidden"  class="form-control"  name="Conformityactivity[conformityid]" value="<?=$_GET['id'];?>">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Deadline');?></label>
                        <fieldset class="form-group col-md-10">
                          <input type="date"  class="form-control" id="modaldated" name="Conformityactivity[date]">
                        </fieldset>
						</div>
                    </div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Action Definition');?></label>
                        <fieldset class="form-group col-md-10">
                          <textarea  class="form-control" id="modaldefinitiond"  name="Conformityactivity[definition]"></textarea>
                        </fieldset>
						</div>
                    </div>


					<!--
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Is Active');?></label>
                        <fieldset class="form-group col-md-10">
                            <select class="custom-select block" id="customSelect6" id="modalisactive" name="Conformityactivity[isactive]">
								<option value="1"><?=t('Active');?></option>
								<option value="0"><?=t('Passive');?></option>
							</select>
                        </fieldset>
						</div>
                    </div>
					-->





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

		<!--SİL BAŞLANGIÇ-->
<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.delete')){?>

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Deadline Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="user-form" action="/conformityactivity/delete/0" method="post">

					 <input type="hidden" class="form-control" id="modalid2" name="Conformityactivity[id]" value="0">
					  <input type="hidden"  class="form-control"  name="Conformityactivity[conformityid]" value="<?=$_GET['id'];?>">

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


	<?php if($conformity->statusid==2 && $efficiencyview=='no'){?>
	<div class='row'>
		<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Efficiency Evaluation');?></h4>
									</div>

						</div>
					 </div>

				<form id="conformity-form" action="/conformityactivity/efficiencyevaluation" method="post" enctype="multipart/form-data">
				<div class="card-content">
					<div class="card-body">


					<div class="row">

					<input type="hidden"  class="form-control" name="Conformityactivity[conformityid]" value="<?=$_GET['id'];?>">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Need For Efficiency Evaluation?');?></label>

					 <div class='row col-md-10 col-sm-10'>

							<p style='margin: 6px;'>
							<input type="radio" name="yes_no" id='close' value='0' <?php if(!isset($efficiencyevaluation)){echo 'checked';}?> > <?=t("Hayır");?></input>
							</p>

							<p style='margin: 6px;'>
							<input type="radio" name="yes_no" id='open' value='1' <?php if(isset($efficiencyevaluation)){echo 'checked';}?> > <?=t("Yes");?></input>
							</p>


					</div>

					<!--
					  <div class="row skin skin-square" style='margin-right: 10px;'>
						  <div class="col-md-12 col-sm-12">
								<fieldset>
								  <input type="radio" name="input-radio-3" id="open" value='1'>
								  <label for="input-radio-11"><?=t('Yes');?></label>
								</fieldset>
						   </div>
						</div>
						 <div class="row skin skin-square">
						     <div class="col-md-12 col-sm-12">
								<fieldset>
								  <input type="radio" name="input-radio-3" id="close" value='0'>
								  <label for="input-radio-11"><?=t('No');?></label>
								</fieldset>
						   </div>
						</div>

						-->

						</div>
                    </div>

					<div class='row col-xl-12 col-lg-12 col-md-12 mb-1' id="addEfficiency">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Action Definition');?></label>
                        <fieldset class="form-group col-md-10">
                          <textarea  class="form-control" name="Conformityactivity[activitydefinition]"><?php if(isset($efficiencyevaluation)){echo $efficiencyevaluation->activitydefinition;}?></textarea>
                        </fieldset>
						</div>
                    </div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<div class="row">
						<label class="col-md-2" for="basicSelect"><?=t('Control Date');?></label>
                        <fieldset class="form-group col-md-10">
                          <input type="date"  class="form-control" name="Conformityactivity[controldate]" value='<?php if(isset($efficiencyevaluation)){echo $efficiencyevaluation->controldate;}?>'>
                        </fieldset>
						</div>
                    </div>




					</div>

					  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">
									<button class="btn btn-primary block-page" type="submit"><?=t('Save');?></button>
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

<?php }?>
<?php }?>




<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });


 //window.addEventListener('beforeunload', function (e) {
  // Cancel the event
//  e.preventDefault(); // If you prevent default behavior in Mozilla Firefox prompt will always be shown
  // Chrome requires returnValue to be set
//  e.returnValue = '';
//});
 <?php if($conformity->statusid==2){
 ?>


/* console.log(window);
     $(function() {

         try{
             opera.setOverrideHistoryNavigationMode('compatible');
             history.navigationMode = 'compatible';
         }catch(e){}

         function ReturnMessage()
         {
					  alert();
             return "wait";
         }

         function UnBindWindow()
         {

             $(window).unbind('beforeunload', ReturnMessage);
         }

          $(window).bind('beforeunload',ReturnMessage );
     });

		 */

		 var link_was_clicked = false;
document.addEventListener("click", function(e) {
   if (e.target.nodeName.toLowerCase() === 'a') {
      link_was_clicked = true;
   }
}, true);

/*window.onbeforeunload = function(e) {
    if(link_was_clicked) {
        return;
    }
    return confirm('Are you sure?');
}


 $("a").click(function(){
 	var txt;
   var r = confirm("<?echo t('Etkinlik Takibi bilgisi girişi yapmadınız. Devam ediyor konumuna dönülecektir');?>");
   if (r == true) {
     // txt = "You pressed OK!";
   } else {
 		event.preventDefault();
 				event.stopPropagation();
   }
   //document.getElementById("demo").innerHTML = txt;


 });
 */
 <?php }?>


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

	<?php	 if(!isset($efficiencyevaluation))
	 {?>
		 $("#addEfficiency").hide(500);
	 <?php }

								?>

$("#open").click(function(){
      $("#addEfficiency").show(500);
 });
 $("#close").click(function(){
      $("#addEfficiency").hide(500);
 });







 function openmodalsil(obj)
{
	$('#modalid2').val($(obj).data('id'));
	$('#sil').modal('show');

}



 function closedupdate(obj)
{
	$('#closedtime').val($(obj).data('ttime'));
	$('#closedupdate').modal('show');

}



 function logsil(obj)
{
	$('#modallogid').val($(obj).data('id'));
	$('#modalconformityid').val($(obj).data('conformityid'));
	$('#conformitylogsil').modal('show');

}

 function modalnok(obj)
{

	$('#nokdate').val($(obj).data('datex'));
	$('#nokdefination').val($(obj).data('definition'));
	$('#nokupdate').modal('show');

}

 function modalreturnassign(obj)
{


	$('#returnassign').modal('show');

}



 function modalok(obj)
{

	$('#okdate').val($(obj).data('datex'));
	$('#okupdate').modal('show');

}

 function modalclosed(obj)
{
	$('#closedupdate').modal('show');
}

 function assign(obj)
{


	$.post( "/conformity/assign?id=<?=$_GET['id'];?>").done(function( data ) {
		$('#userassign').html(data);
	});


	$('#assingnuser').modal('show');

}










	function adefinationupdate(obj)
	{
			$('#modalidd').val($(obj).data('id'));
			$('#modaldated').val($(obj).data('datex'));
			$('#modaldefinitiond').val($(obj).data('definition'));
			$('#duzenle').modal('show');

	}


 function conformitymodalupdate(obj)
{


		<?php if($ax->firmid==0){?>
	$('#firm2').val($(obj).data('firmid'));
	$('#firm2').select2('destroy');
	$('#firm2').select2({
		closeOnSelect: false,
			allowClear: true
	});
<?php }?>



	<?php if($ax->branchid==0){?>
	$('#branch2').val($(obj).data('branchid'));
	$('#branch2').select2('destroy');
	$('#branch2').select2({
		closeOnSelect: false,
			allowClear: true
	});
<?php }?>

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

	$('#modaldate').val($(obj).data('date'));
	$('#modalfilesf').val($(obj).data('filesf'));





	$('#modalpriority').val($(obj).data('priority'));
	$('#modalpriority').select2('destroy');
	$('#modalpriority').select2({
		closeOnSelect: false,
			allowClear: true
	});




	$('#conformityduzenle').modal('show');

}


 function conformitymodalsil(obj)
{
	$('#modalid2').val($(obj).data('id'));
	$('#modalfile').val($(obj).data('file'));
	$('#conformitysil').modal('show');

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




//checkbox database start

function authchange(data,permission,obj)
{
$.post( "?", { activityid: data, active: permission })
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

//checkbox database finish




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
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Copy');?>',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            },
			text:'<?=t('Excel');?>',
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Pdf');?>',
        },
        'colvis',
		'pageLength'
    ],



} );



//window.location.hash="no-back-button";
//$(window).click(function(e) {
  //  alert(e.target.id); // gives the element's ID
  //  alert(e.target.className); // gives the elements class(es)
//});


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
