 <?php

User::model()->login();

$ax= User::model()->userobjecty('');
$client=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0',));
$conformity=Conformity::model()->findAll(array('order'=>'date ASC',));

	Workorder::model()->monitorupdate(7842165);
$firmid=$ax->firmid;
$firm=Firm::model()->find(array('condition'=>'id='.$firmid));
$country=$firm->country_id;

$date='';
$a=0;
	  if(isset($_GET['id']) && $_GET['id']!="")
{

		    $a=Servicereport::model()->find(array('condition'=>'reportno=:iid','params'=>array(':iid'=>$_GET['id'])));
}
if(isset($_GET['date']) && $_GET['date']!='')
{
	$date=$_GET['date'];
}

if(isset($_GET['id']) && $_GET['id']!="")
{
	$workorder=Workorder::model()->find(array('condition'=>'id='.$_GET['id']));
	$date=$workorder->date;
}

/* Code ran at 2016-04-06 */

/*
$date = new DateTime('second monday of 01-01-2019');

echo $date->format('Y-m-d');


*/
/* Output: 2016-03-28 */


?>


<?=User::model()->geturl('Workorder',$date,0,'workorder');?>

<?php if (Yii::app()->user->checkAccess('workorderdetail.view')){ ?>


<input type="hidden" id="getid" value="<?=@$_GET['id'];?>">


<div class="row" id="" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					<div class="col-md-12">
                        <center>
                            <?php if($workorder->clientid){ ?>
                            <img src="https://insectram.io/qrcode/qrcode?txt=<?=$workorder->clientid;?>&size=5">
                            <?php } ?>
                        </center>

						<h4  class="card-title"></h4>

					</div>
				</div>
			</div>

			<form id="workorder-savex" onsubmit="return validateForm()" action="<?php if(isset($_GET['id']) && $_GET['id']!="" && $_GET['id']!=0){echo "/workorderperiyodik/update?id=".$_GET['id'];}else{echo "/workorderperiyodik/create";}?>" method="post">
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 ">
								<label for="basicSelect"><?=t('Date');?></label>
								<div class="row">

								<?php

								if(isset($_GET['date']) && $_GET['date']!="")
									{
										 $data=explode('-',$_GET['date']);
										 $data=$data[1].'/'.$data[2].'/'.$data[0];
									}
								if(isset($_GET['id']) && $_GET['id']!="")
									{
										 $data=explode('-',$workorder->date);
										 $data=$data[1].'/'.$data[2].'/'.$data[0];
									}

								?>



								<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
									<fieldset class="form-group">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control singledate" id="workorderdate" name="Workorder[date]" <? if( $workorder->isperiod==1 && $a) {echo 'disabled';}?> value="<?php if(isset($_GET['date']) && $_GET['date']!=""){echo $data;}else{echo $data;}?>" required>
												<div class="input-group-append">
													<span class="input-group-text">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
									<fieldset class="form-group">
										<div class="form-group">
											<div class="input-group date" id="datetimepicker4" >
												<input type="text" autocomplete="off" <? if( $workorder->isperiod==1 && $a) {echo 'disabled';}?> class="form-control" id="workorderstime" name="Workorder[start_time]" value="<?=$workorder->start_time;?>" required>
												<div class="input-group-append">
													<span class="input-group-text">
														<span class="ft-clock"></span>
													</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>

								<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
									<fieldset class="form-group">
										<div class="form-group">
											<div class="input-group date" id="datetimepicker3" >
												<input type="text" <? if( $workorder->isperiod==1 && $a) {echo 'disabled';}?> class="form-control" id="workorderftime" name="Workorder[finish_time]"  autocomplete="off" value="<?=$workorder->finish_time;?>" >
												<div class="input-group-append">
													<span class="input-group-text">
														<span class="ft-clock"></span>
													</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>



						<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" <? if( $workorder->isperiod==1 && $a) {echo 'disabled';}?>  style="width:100%" id="firm" name="Workorder[firmid]" onchange="myfirm()" required>
									<option  value="" hidden><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Workorder[firmid]" value="<?=$ax->firmid;?>" required>
						<?php }?>



						<?php if($ax->firmid!=0 && $ax->branchid==0){

							$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
							if($firm->package!='Packagelite')
							{
						?>

						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" <? if( $workorder->isperiod==1 && $a) {echo 'disabled';}?> id="branch" name="Workorder[branchid]" onchange="mybranch()"  required placeholder="Please Select">
									<option  value="" hidden><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{
							$branch=Firm::model()->find(array('condition'=>'parentid='.$ax->firmid));
							?>
								<input type="hidden" class="form-control" id="branch" name="Workorder[branchid]" value="<?=$branch->id;?>">
						<?php }}else{?>

							<input type="hidden" class="form-control" id="branch" name="Workorder[branchid]" value="<?=$ax->branchid;?>" required>
						<?php }?>

						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Staff Team');?></label>
								<fieldset class="form-group">
									<select class="select2" style="width:100%" id="team" name="Workorder[teamstaffid]" onchange="teaminput()" <?php if($workorder->teamstaffid==1 && $workorder->staffid!='' && $a){echo 'disabled';}?> required>
										<option  value="" hidden><?=t('Please Chose');?></option>

										<?php										if($workorder->branchid!=0){
										$team=Staffteam::model()->findall(array('condition'=>'active=1 and isdelete=0 and firmid='.$workorder->branchid));
										 foreach($team as $teamx){?>
										<option <?php if($teamx->id==$workorder->teamstaffid){echo "selected";}?> value="<?=$teamx->id;?>"><?=$teamx->teamname;?></option>
										<?php }}?>
									</select>
								</fieldset>
						</div>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Staff');?></label>
								<fieldset class="form-group">
								  <select class="select2"  id="staff" onchange="staffinput()"  style="width:100%;" name="Workorder[staffid][]" <?php							if( $workorder->teamstaffid!=0 && ($workorder->staffid=='' || $workorder->staffid==0) ){echo 'disabled';}?>>
										<option  value="" hidden><?=t('Please Chose');?></option>



										<?//lite paket için

										if($ax->firmid!=0)
										{
											$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
											$liteuser=User::model()->find(array('condition'=>'active=1 and branchid=0 and firmid='.$ax->firmid));
											if($firm->package=='Packagelite')
											{
												?><option  value="<?=$ax->id;?>"><?=$liteuser->name;?></option><?php											}
										}

										?>


										<?php if(isset($_GET['id']) && $_GET['id']!=""){
										$staff=User::model()->findAll(array('order'=>'name ASC','condition'=>'active=1 and clientid=0 and clientbranchid=0 and  branchid='.$workorder->branchid,));

										foreach($staff as $staffx){?>
										  <option value="<?=$staffx->id;?>" <?php if(isset($_GET['id'])){if(Workorder::model()->isnumber($staffx->id,$workorder->staffid)){echo "selected";}}?>
										  ><?=$staffx->name.' '.$staffx->surname;?></option>
										<?php }}?>


									</select>
								</fieldset>
						</div>





					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Visit Type');?></label>
							<fieldset class="form-group">

							  <select class="select2" style="width:100%" id="visittype"  disabled name="Workorder[visittypeid]" <? if( $workorder->isperiod==1 && $a) {echo 'disabled';}?> required>
										<option  value="" hidden><?=t('Please Chose');?></option>
										<?php										if($workorder->branchid!=0){

										$type=Visittype::model()->findall(array('condition'=>'firmid=0 or (branchid=0 and firmid='.$workorder->firmid.') or branchid='.$workorder->branchid));

										//$type=Visittype::model()->findall(array('condition'=>'firmid='.$workorder->firmid));

										//$type=Visittype::model()->findall();
										 foreach($type as $typex){?>
										<option <?php if($typex->id==$workorder->visittypeid){echo "selected";}?> value="<?=$typex->id;?>"><?=t($typex->name);?></option>
										<?php }}?>

								</select>
							</fieldset>
						</div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Route');?></label>
							<fieldset class="form-group">

							  <select class="select2" style="width:100%" id="route" <?php if($a){?>disabled <?php }?>  name="Workorder[routeid]" onchange='routeclient()'>
										<option  value="" hidden><?=t('Please Chose');?></option>
										<?php										if($workorder->branchid!=0){
										$route=Route::model()->findall(array('condition'=>'branchid='.$workorder->branchid));
										 foreach($route as $routex){?>
										<option <?php if($routex->id==$workorder->routeid){echo "selected";}?> value="<?=$routex->id;?>"><?=$routex->name;?></option>
										<?php }}?>
								</select>
							</fieldset>
						</div>





					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" name="Workorder[clientid]" <?php if($a){?>disabled <?php }?> required onchange="myclient()">
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
														<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?><?=' -> '.$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }


								$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'firmid='.$workorder->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
								foreach($tclient as $tclientx)
								{

									$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
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



								}





								?>
							</select>
                        </fieldset>
                    </div>



<?php

$available=0;
if(isset($_GET['id'])){

		$dvisit=Departmentvisited::model()->find(array('condition'=>'treatmenttypeid!="" and workorderid='.$_GET['id']));
		//$available=count($dvisit);

}
?>


<input type='hidden'  name="Workorder[mavailable]" value="1" /> 
					<!--<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Monitoring');?></label>
								<fieldset class="form-group">
									<select class="select2" style="width:100%" id="monitoringavailable" <?//if(!$dvisit && !isset($_GET['id'])){echo 'disabled';}?>   onchange="mymonitoring()" name="Workorder[mavailable]">
										<option value="0" <?//if(isset($_GET['id'])){if($dvisit){echo "selected";}}?>><?=t('Not Available');?></option>

										<option value="1" <?//if(isset($_GET['id'])){if(!$dvisit){echo "selected";}}?>><?=t('Available');?></option>

									</select>
								</fieldset>
					</div>-->
					<!--

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1" id="notavailable">
								<label for="basicSelect"><?=t('Treatment Type');?></label>
								<fieldset class="form-group">
								  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="treatmenttype" style="width:100%;" name="Workorder[treatmenttypeid][]" <?php if(!$dvisit && !isset($_GET['id'])){echo 'disabled';}?>>
									<?php //$treatmenttypes=Treatmenttype::model()->findAll(array('order'=>'name ASC','condition'=>'branchid='.$workorder->branchid,));

									if(isset($_GET['id'])){

									$treatmenttypes=Treatmenttype::model()->findAll(array('order'=>'name ASC','condition'=>'firmid=0 or(firmid='.$workorder->firmid.' and branchid=0) or branchid='.$workorder->branchid,));

									foreach($treatmenttypes as $treatmenttype){?>

										  <option value="<?=$treatmenttype->id;?>"

										 <?php if($dvisit->treatmenttypeid!=''){if(Workorder::model()->isnumber($treatmenttype->id,$dvisit->treatmenttypeid)){echo "selected";}}?>
										  ><?=$treatmenttype->name;?></option>
										 <?php }
									}?>

									  </select>
								</fieldset>
					</div>
					-->



						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('To Do');?></label>
							<fieldset class="form-group">
							  <input type="text"  class="form-control" value="<?=$workorder->todo;?>"  placeholder="<?=t('To Do');?>"  id="workordertodo" name="Workorder[todo]" required>
							</fieldset>
						</div>
              	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Technician Note');?></label>
							<fieldset class="form-group">
							  <input type="text"  class="form-control" value="<?=$workorder->special_notes;?>"  placeholder="<?=t('Technician Note');?>"  id="workorderspecial_notes" name="Workorder[special_notes]" >
							</fieldset>
						</div>
              				<?php if(isset($_GET['id']) && $workorder->code!=''){?>
              <input type="hidden" name="Workorderperiod[isperiod]" value="0"> 
			<!--		<input type="hidden" name="workorderisperiod[updateperiod]" value="1"> -->
							<div class="col-xl-8 col-lg-8 col-md-8 mb-1" id='periodapply'>
							<label for="basicSelect"><?=t('Workorder Period');?></label>
								<fieldset class="form-group">
									<!--<select class="select2" id="applyw" style="width:100%" name="workorderisperiod[updateperiod]">
											<option  value="1" ><?=t('Apply to this workorder');?></option>
											<option  value="3" ><?=t('Apply to workorders after the start date of this workorder');?></option>
                    
											<option  value="2" selected><?=t('Apply to open workorders');?></option>
									</select>-->
									
									<select class="select2" id="applyw" onchange="uperiod()" style="width:100%" name="Workorderisperiod[updateperiod]">
											<option  value="1" selected><?=t('Apply to this workorder');?></option>
									<option  value="2" ><?=t('Apply to open workorders');?></option> 
										<!--	<option  value="3" ><?=t('Apply to open workorders after the start date of this workorder');?></option>-->
									</select>
									
								</fieldset>
							</div>
						<?php }?>

              

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<button class="btn btn-primary block-page" id="kydt" style="float:right" type="submit"><?=t('Save');?></button>

		
						<a class="btn btn-danger btn-sm" id="sl" onclick="workordersil(this)" data-id="<?=$_GET['id'];?>" style="line-height: 29px;color: #fff;margin-right: 15px;font-size: 14px;padding-right:20px; padding-left:20px; float:right;"><?=t('Delete');?></a>
	

					
						</div>
              


					  </div>



					</div>
				</div>
				</form>
			</div>

	</div><!-- form -->
</div>



<div class="row" id="" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="card">
			

			<form id="workorder-save" onsubmit="return validateForm()" action="<?php if(isset($_GET['id']) && $_GET['id']!="" && $_GET['id']!=0){echo "/workorderperiyodik/Updatep?id=".$_GET['id'];}else{echo "/workorderperiyodik/create";}?>" method="post">
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 ">
  
  
  
  
  
              

<?php 
                                                         
                                                                 	$period=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
                                                                         if ($period->startfinishdate<>''){
                                                                           ?>
                                                                           
                                                                           		<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Period Info');?></label>
							<fieldset class="form-group">
							<textarea id="txtArea" rows="7" cols="70" disabled><?php          
                                                                          	$periodworks=Workorder::model()->findall(array('condition'=>'id>0 and code="'.$workorder->code.'"'));
                                                                          	$periodworksop=Workorder::model()->findall(array('condition'=>'id>0 and code="'.$workorder->code.'" and status<>3'));
                                                                          	$periodworksclosed=Workorder::model()->findall(array('condition'=>'id>0 and code="'.$workorder->code.'" and status=3'));
                                                                           
                                                                 echo 'Start & Finish: '.$period->startfinishdate.PHP_EOL;
                                                                 echo 'Every : '.ucfirst($period->againnumber.' '.$period->dayweekmonthyear.PHP_EOL);
                                                                 echo 'Period : '.ucfirst($period->day).' '.$period->monthday.PHP_EOL;
                                                                 echo 'Total Workorder : '.count($periodworks).PHP_EOL;
                                                                 
                                                                 echo 'Open : '.count($periodworksop).PHP_EOL;
                                                                 echo 'Closed : '.count($periodworksclosed).PHP_EOL;
?>
                		</textarea></fieldset>
						</div>
<?php                                                                         }
                                                                 ?>

							<?php								$isperiod=$workorder->isperiod;
								$startfinishdate='';
								$againnumber='';
								$dayweekmonthyear='';
								$day='';
								$monthday='';
								$code='';

								if(isset($_GET['id']))
								{
									$period=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
									$againnumber=$period->againnumber;
									$startfinishdate=$data.' - '.explode(' - ',$period->startfinishdate)[1];
									$dayweekmonthyear=$period->dayweekmonthyear;
									$day=$period->day;
									$monthday=$period->monthday;
									$code=$period->code;
								}

							?>
              			<!--	<input type="hidden" name="Workorderperiod[isperiod]" value="0">-->
		<?php if($workorder->isperiod==1 || !isset($_GET['id'])){  ?>

						<div class="col-xl-4 col-lg-4 col-md-4 <mb-1></mb-1>">
						<?php if(isset($_GET['id'])){?>
								<label for="basicSelect"><?=t('Do you want to change period?');?></label>
						<?php }else{?>
								<label for="basicSelect"><?=t('Do you want to add period?');?></label>
						<?php }?>

		
						<fieldset class="form-group">
									<select class="select2"  style="width:100%" id="isperiod" onchange="workorderisperiod()" name="Workorderperiod[isperiod]">
										<option value="1"  		<?php if($workorder->isperiod==1){ echo 'selected ' ;}?> ><?=t('Yes');?></option>
										<option value="0" <?php if($workorder->isperiod==0){ echo 'selected '; }?> ><?=t('No');?></option>
									</select>
								</fieldset>
             	
						</div>
 	<?php }?>	
						<?php if(isset($_GET['id']) && $workorder->code!=''){?>
			<!--		<input type="hidden" name="workorderisperiod[updateperiod]" value="1"> -->
							<div class="col-xl-8 col-lg-8 col-md-8 mb-1" id='periodapply'>
							<label for="basicSelect"><?=t('Workorder Period');?></label>
								<fieldset class="form-group">
									<!--<select class="select2" id="applyw" style="width:100%" name="workorderisperiod[updateperiod]">
											<option  value="1" ><?=t('Apply to this workorder');?></option>
											<option  value="3" ><?=t('Apply to workorders after the start date of this workorder');?></option>
                    
											<option  value="2" selected><?=t('Apply to open workorders');?></option>
									</select>-->
									
									<!--	<select class="select2" id="applyw" onchange="uperiod()" style="width:100%" name="Workorderisperiod[updateperiod]">
										<option  value="1" selected><?=t('Apply to this workorder');?></option>
									<option  value="2" ><?=t('Apply to open workorders');?></option> 
							<option  value="3" ><?=t('Apply to open workorders after the start date of this workorder');?></option>-->
									</select>
									
								</fieldset>
							</div>
						<?php }?>

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style=' border: 1px solid #dddbdb;padding-top: 29px;background: #f2f2f2;border-radius: 5px;' id='isperiodform'>
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
									<label for="basicSelect"><?=t('Start and finish date period');?></label>
									<fieldset class="">
										<div class="">
											<div class="input-group">
												<input type="text" class="form-control openRight" id="workorderdate" value ='<?=$startfinishdate;?>' name="Workorderperiod[startfinishdate]">
												<div class="input-group-append">
													<span class="input-group-text">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>

								<div class="col-xl-8 col-lg-8 col-md-8 mb-1">
								<label for="basicSelect"><?=t('Period Type ( How many day or weeks or months or year? )');?></label>
									<div class="row">

										<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
										<fieldset class="">
											<input type="text"  autocomplete="off" min='1' value='1' class="form-control" name="Workorderperiod[againnumber]" value ='<?=$againnumber;?>'>
										</fieldset>
										</div>
										<div class="col-xl-9 col-lg-9 col-md-9 mb-1">

												<fieldset class="">
													<select class="select2" style="width:100%" id='periodtype' onchange='workorderperiodtype()' name="Workorderperiod[dayweekmonthyear]">
														<option  value="year" <?php if($dayweekmonthyear=='year'){echo "selected";}?>><?=t('Year');?></option>
														<option  value="day" <?php if($dayweekmonthyear=='day'){echo "selected";}?>><?=t('Day');?></option>
														<option  value="week" <?php if($dayweekmonthyear=='week'){echo "selected";}?>><?=t('Week');?></option>
														<option  value="month" <?php if($dayweekmonthyear=='month'){echo "selected";}?>><?=t('Month');?></option>
													</select>
												</fieldset>
										</div>

									</div>
								</div>
							<!--week copy days-->
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id='days'>
									<label for="basicSelect"><?=t('Repeat these days');?></label>
									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<div class="row" style=' padding: 16px 0px 15px 0px; border: 1px #c0bcbc solid;border-radius: 9px;background: #e3e1e1;'>

										  <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "monday")){echo "checked";}?> name="Workorderperiod[day][]" value="monday">
											  <label for="input-1"><?=t('Monday');?></label>
											</fieldset>
											</div>

										     <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "tuesday")){echo "checked";}?>  name="Workorderperiod[day][]" value="tuesday">
											  <label for="input-1"><?=t('Tuesday');?></label>
											</fieldset>
											</div>

										     <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "wednesday")){echo "checked";}?> name="Workorderperiod[day][]" value="wednesday">
											  <label for="input-1"><?=t('Wednesday');?></label>
											</fieldset>
											</div>

											 <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "thursday")){echo "checked";}?> name="Workorderperiod[day][]" value="thursday">
											  <label for="input-1"><?=t('Thursday');?></label>
											</fieldset>
											</div>

											 <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "friday")){echo "checked";}?> name="Workorderperiod[day][]" value="friday">
											  <label for="input-1"><?=t('Friday');?></label>
											</fieldset>
											</div>

											 <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "saturday")){echo "checked";}?> name="Workorderperiod[day][]" value="saturday">
											  <label for="input-1"><?=t('Saturday');?></label>
											</fieldset>
											</div>

											 <div class="skin skin-square col-md-3 col-sm-4 col-xs-6">
											<fieldset>
											  <input type="checkbox" <?php if(strstr($day, "sunday")){echo "checked";}?> name="Workorderperiod[day][]" value="sunday">
											  <label for="input-1"><?=t('Sunday');?></label>
											</fieldset>
											</div>

										</div>
									</div>
								</div>
								<!--week copy days-->

								<!--month copy days-->

								<!--week copy days-->
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id='monthdays'>
									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<div class="row" style=' padding: 16px 0px 15px 0px; border: 1px #c0bcbc solid;border-radius: 9px;background: #e3e1e1;'>

											<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect"><?=t('Day of each month');?></label>
												<fieldset class="form-group">

												  <input type="number"  class="form-control" value="<?php if($monthday==''){echo '1';}else{echo $monthday;}?>"  placeholder="<?=t('Day of each month');?>" name="Workorderperiod[monthday]" max='31' required>
												</fieldset>
											</div>

										</div>
									</div>
								</div>
								<!--month copy days-->


							</div>


						</div>

<?php if(!$a){?>
						 	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="workorderupdate" style="float:right">

							</div>
                        </fieldset>
                    </div>

<?php }?>

  
  
</div>
  
</div>
  
</div>
  
</div>
  
        </form>
</div>
  
</div>
  
</div>
  
</div>


<?php
if(isset($_GET['id'])){

	if(isset($_GET['visitid']))
	{

		$dvisit=Departmentvisited::model()->find(array(
								   'condition'=>'id='.$_GET['visitid'],
									));
	}

?>


<?php if(!$a || 1==1){?>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<button class="btn btn-warning" onclick='dvisited()'><?=t('Department visited add');?></button>

					</div>





				</div>
			</div>
		<form id="departmentvisited-form" action="<?php if(isset($_GET['visitid'])){echo '/workorderperiyodik/visitedupdate?id='.$_GET['visitid'];}else{echo '/workorderperiyodik/addsave';}?>" method="post">
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<input type="hidden"  class="form-control"  id="workorderid" name="Workorder[workorderid]" value="<?=$_GET['id'];?>" >
							<input type="hidden"  class="form-control" name="Workorder[mavailable]" value="1" >


							<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Monitoring');?></label>
								<fieldset class="form-group">
									<select class="select2" style="width:100%" id="monitoringavailable" onchange="mymonitoring()" name="Workorder[mavailable]">
											<option value="0" <?php if(isset($_GET['visitid'])){if($dvisit->mavailable==0){echo "selected";}}?>><?=t('Not Available');?></option>

										<option value="1" <?php if(isset($_GET['visitid'])){if($dvisit->mavailable==1){echo "selected";}}?>><?=t('Available');?></option>

									</select>
								</fieldset>
							</div>




							<?php if($workorder->code!=''){?>
							<div class="col-xl-8 col-lg-8 col-md-8 mb-1">
							<label for="basicSelect"><?=t('Workorder Period');?></label>
								<fieldset class="form-group">
									<select class="select2" style="width:100%" name="workorderisperiod[updateperiod]">
											<option  value="1" ><?=t('Apply to this workorder');?></option>
											<option  value="2" selected><?=t('Apply to open workorders');?></option>
										<!--	<option  value="3" ><?=t('Apply to workorders after the start date of this workorder');?></option>-->
									</select>
								</fieldset>
							</div>
							<?php }?>

						<!-- id="available" -->
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Department');?></label>
								<fieldset class="form-group">
								  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="department" onchange="mydepartment()" style="width:100%;" name="Workorder[departmentid][]">
															<?php if(isset($_GET['id']) && $_GET['id']!=""){
										$department=Departments::model()->findAll(array('order'=>'name ASC','condition'=>'parentid=0 and clientid='.$workorder->clientid,));

										foreach($department as $departmentx){?>
										  <option value="<?=$departmentx->id;?>" <?php if(isset($_GET['visitid'])){if(Workorder::model()->isnumber($departmentx->id,$dvisit->departmentid)){echo "selected";}}?>
										  ><?=$departmentx->name;?></option>
										<?php }}?>


										<?php if(isset($_GET['visitid']) &&$dvisit->departmentid!=''){
										$department=Departments::model()->findAll(array('order'=>'name ASC','condition'=>'parentid=0 and clientid='.$workorder->clientid,));

										foreach($department as $departmentx){?>
										  <option value="<?=$departmentx->id;?>" <?php if(isset($_GET['visitid'])){if(Workorder::model()->isnumber($departmentx->id,$dvisit->departmentid)){echo "selected";}}?>
										  ><?=$departmentx->name;?></option>
										<?php }}?>


									</select>
								</fieldset>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Sub-Department');?></label>
								<fieldset class="form-group">
								  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="subdepartment" onchange="mysubdepartment()" style="width:100%;" name="Workorder[subdepartmentid][]" disabled>
										<?php if(isset($_GET['visitid']) &&$dvisit->departmentid!=''){
										$department=Departments::model()->findAll(array('order'=>'name ASC','condition'=>'parentid='.$departmentx->id));

										foreach($department as $departmentx){?>
										  <option value="<?=$departmentx->id;?>" <?php if(isset($_GET['visitid']) &&$dvisit->subdepartmentid!=''){if(Workorder::model()->isnumber($departmentx->id,$dvisit->subdepartmentid)){echo "selected";}}?>
										  ><?=$departmentx->name;?></option>
										<?php }}?>
								 </select>
								</fieldset>
							</div>


							<?php $monitoringtype=Monitoringtype::model()->findAll();?>
							<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<label for="basicSelect"><?=t('Monitoring Type');?></label>
								<fieldset class="form-group">
								  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="monitoringtype" onchange="mymonitoringtype()" style="width:100%;" name="Workorder[monitoringtype][]">
										<?php foreach($monitoringtype as $monitoringtypex){?>
											<option value="<?=$monitoringtypex->id;?>" <?php if(isset($_GET['visitid']) && $dvisit->monitoringtype!=''){if(Workorder::model()->isnumber($monitoringtypex->id,$dvisit->monitoringtype)){echo "selected";}}?>
											><?=$monitoringtypex->name;?></option>
										 <?php }?>
									</select>
								</fieldset>
							</div>
							</div>



							<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style="padding: 9px 0px 4px 7px;border-bottom:#c3c2c2 1px solid;border-top:#c3c2c2 1px solid;">
								<label for="basicSelect" style="font-size: 15px;"><?=t('Monitoring Points');?></label>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
								<div class="row skin skin-square" id="monitoringno">
								</div>
							</div>

							</div>




					<!--
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="notavailable">
								<label for="basicSelect"><?=t('Treatment Type');?></label>
								<fieldset class="form-group">
								  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="multi_placehodler" style="width:100%;" name="Workorder[treatmenttypeid][]">
									<?php //$treatmenttypes=Treatmenttype::model()->findAll(array('order'=>'name ASC','condition'=>'branchid='.$workorder->branchid,));


									$treatmenttypes=Treatmenttype::model()->findAll();
									foreach($treatmenttypes as $treatmenttype){?>

										  <option value="<?=$treatmenttype->id;?>"

										 <?php if(isset($_GET['visitid']) && $dvisit->treatmenttypeid!=''){if(Workorder::model()->isnumber($treatmenttype->id,$dvisit->treatmenttypeid)){echo "selected";}}?>
										  ><?=$treatmenttype->name;?></option>
										 <?php }?>

									  </select>
								</fieldset>
							</div>
					-->



							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<fieldset class="form-group">
								<div class="input-group-append" id="button-addon2" style="float:right">

											<button class="btn btn-primary block-page" id="kydt2" type="submit"><?=t('Save');?></button>

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

    <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-8 col-lg-8 col-md-8 mb-1">
						 <h4 class="card-title"><?=t('DEPARTMENT TO BE VISITED LIST');?></h4>
						</div>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard" id="">
						<table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                             <th><?=t('Department');?></th>
							 <th><?=t('Sub-Dep.');?></th>
							 <th><?=t('Types');?></th>
							 <th><?=t('Monitors');?></th>
							 <th><?=t('Team Name');?></th>
							 <th><?=t('Team Staff');?></th>
							 <th><?=t('Staff');?></th>
							 <th><?=t('Process');?></th>


                          </tr>
                        </thead>
                        <tbody>



						<?php  if ($workorder->visittypeid==62){
    	$visits=Departmentvisitedti::model()->findall(array(
								   'condition'=>'workorderid='.$workorder->id,
									));
  }else{
    	$visits=Departmentvisited::model()->findall(array(
								   'condition'=>'workorderid='.$workorder->id,
									));
  }
			

							foreach($visits as $visit)
							{?>
							<tr>

							<?php							if($visit->departmentid!='')
							{
							$departments=Departments::model()->findall(array('condition'=>Workorder::model()->serarchsplit('id',$visit->departmentid)));
							}
							if($visit->subdepartmentid!='')
							{
							$subdepartments=Departments::model()->findall(array('condition'=>Workorder::model()->serarchsplit('id',$visit->subdepartmentid)));
							}
							if($visit->monitoringtype!='')
							{
							$monitoringtypes=Monitoringtype::model()->findall(array('condition'=>Workorder::model()->serarchsplit('id',$visit->monitoringtype)));
							}


							if($workorder->teamstaffid!='' && $workorder->teamstaffid!=0)
							{
								$team=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid));
								$user=User::model()->findall(array('condition'=>Workorder::model()->serarchsplit('id',$team->staff)));
							}

							if($workorder->staffid!='' && $workorder->staffid>1)
							{

					$user=User::model()->findall(array('condition'=>Workorder::model()->serarchsplit('id',$workorder->staffid)));
							}

							?>
							<td>
							<?php							if($visit->departmentid!=''){
								foreach($departments as $department){?>
										<!--<button class="btn btn-info btn-sm" id="createbutton" type="submit"></button>-->
										<?=$department->name;?>-
								<?php }
								if(!isset($departments)){echo t("All");}
							}else{echo t("All");}
								?>
							</td>
							<td>
							<?php							if($visit->subdepartmentid!=''){
								foreach($subdepartments as $subdepartment){?>
										<?=$subdepartment->name;?>-
								<?php }
								if(!isset($departments)){echo t("All");}
							}else{echo t("All");}
							?>
							</td>

							<td>
								<?php							if($visit->monitoringtype!=''){
								foreach($monitoringtypes as $monitoringtype){?>
										<?=$monitoringtype->name;?>-
								<?php }
								if(!isset($departments)){echo t("All");}
							}else{echo t("All");}?>
							</td>
								<td>
								<?php
							$getmids=	explode(',',$visit->monitoringno);
							if ($getmids)
								{
									foreach ($getmids as $mids)
									{
										$mmmno=Monitoring::model()->findbypk($mids);
										if ($mmmno)
										{
										echo 	$mmmno->mno.',';
										}

									}
								}
								if($visit->monitoringno=='')
								{
									echo t("All");
								}
							?>
							</td>


							<td>
							<?php							if($workorder->teamstaffid!='' && $workorder->teamstaffid!=0)
							{
							echo $team->teamname;
							}
							else
							{
								echo '-';
							}?>
							</td>

							<td>
							<?php							if($workorder->teamstaffid!='' && $workorder->teamstaffid!=0)
							{
							echo User::model()->find(array('condition'=>'id='.Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid))->leaderid))->name.',';

								foreach($user as $userx)
								{
									echo $userx->name.',';
								}



								// echo User::model()->find(array('condition'=>'id='.Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid))));



							}else
							{
								echo '---';
							}?>

							</td>
							<td>
							<?php if($workorder->staffid!=''  && $workorder->staffid!=0)
							{
								foreach($user as $userx)
								{
									echo $userx->name.',';
								}
							}
							else
							{
								echo '---';
							}?>
							</td>


								<td>
									<?php
									/*<a href="/workorder/workorder?id=<?=$visit->workorderid;?>&&visitid=<?=$visit->id;?>" class="btn btn-warning btn-sm swq" data-id="<?=$visit->id;?>"><i style="color:#fff;" class="fa fa-edit"></i></a> */
								?>
 <?php if ($workorder->isperiod==1){?>
									<a class="btn btn-danger btn-sm swq" onclick="openmodalsil(this)" data-id="<?=$visit->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
 <?php } ?>
								</td>

							</tr>
							<?php }?>

						</tbody>
                        <tfoot>
                          <tr>
                             <th><?=t('Department');?></th>
							 <th><?=t('Sub-Dep.');?></th>
							 <th><?=t('Types');?></th>
							 <th><?=t('Monitors');?></th>
							 <th><?=t('Team Name');?></th>
							 <th><?=t('Team Staff');?></th>
							 <th><?=t('Staff');?></th>
							 <th><?=t('Process');?></th>
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

	  <div class="col-12">
		<?php

	  if(isset($_GET['id']) && $_GET['id']!="")
{

		    $a=Servicereport::model()->find(array('condition'=>'reportno=:iid','params'=>array(':iid'=>$_GET['id'])));
		  if($a)
{

?>
					<a class="btn btn-primary" target="_blank" href="<?=Yii::app()->getBaseUrl();?>/site/<?=($country=='2') ? 'servicereport4':'servicereport';?>?id=<?=$a->id ?><?php if ($country=='2'){
	echo '&languageok=en&pdf=ok';
}?>"><?=t('Open Service Report');?></a>
	<?php
}}
    if(isset($_GET['id']) && $_GET['id']!=""){

	/*if (Mobileworkorderdata::model()->find(array('condition'=>'workorderid=:id', 'params'=>array('id'=>$_GET['id']) )))
	{*/
	?>
		<a class="btn btn-info" target="_blank" href="<?=Yii::app()->getBaseUrl();?>/workorder/monitor?id=<?=$_GET['id'] ?>"><?=t('Open Monitor Data');?></a>

   <?php
	/* }*/ }
?>


		  </div>
<!--Department visited delete start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Department Visited Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="user-form" action="/workorderperiyodik/visiteddelete/0" method="post">

						<input type="hidden" class="form-control" id="modalvisitid2" name="Departmetvisited[id]" value="0">
						<input type="hidden"  class="form-control"  id="workorderid" name="Workorder[workorderid]" value="<?=$_GET['id'];?>" >

                            <div class="modal-body">

							<?php if($workorder->code!=''){?>
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('Workorder Period');?></label>
								<fieldset class="form-group">
									<select class="select2" style="width:100%" name="workorderisperiod[updateperiod]">
											<option  value="1" ><?=t('Apply to this workorder');?></option>
											<option  value="2" selected><?=t('Apply to open workorders');?></option>
										<!--	<option  value="3" ><?=t('Apply to workorders after the start date of this workorder');?></option>-->
									</select>
								</fieldset>
							</div>
							<?php }?>

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

<!--Department visited delete finish-->

<!--Workorder delete Start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="workordersil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Workorder Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->

						<form id="user-form" action="/workorderperiyodik/deleteperiyodik/0" method="post">

						<input type="hidden" class="form-control" id="modalvisitid2" name="Workorder[id]" value="<?=$_GET['id'];?>">

                            <div class="modal-body">



							<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id='wperioddelete'>
							<?php if(( !$visits && $workorder->code!='') ||( $ax->id==1 && $workorder->code!='') ||( $ax->type==13 && $workorder->code!='')){?>
							<label for="basicSelect"><?=t('Workorder Period');?></label>
								<fieldset class="form-group">
									<select class="select2" style="width:100%" name="Workorderisperiod[updateperiod]">
											<option  value="1" ><?=t('Apply to this workorder');?></option>
											<option  value="2" selected><?=t('Apply to open workorders');?></option>
									<!--		<option  value="3" ><?=t('Apply to workorders after the start date of this workorder');?></option>-->
									</select>
								</fieldset>
							</div>

							<?php }?>


								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<?php if( is_countable($visits) && count($visits)>0 && $ax->id!=1 && $ax->type!=13){?>
										<h5><?=t('You cannot delete visited places!');?></h5>

									<?php }else{?>
										<h5> <?=t('Do you want to delete?');?></h5>
									<?php }?>

								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <?php if( is_countable($visits) && count($visits)==0 || $ax->id==1 || $ax->type==13){?>
								 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
								 <?php }?>
                                </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--Workorder delete finish-->


<!--Workorder period add Start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="periodadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Workorder Period');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->

						<form id="user-form" action="/workorderperiyodik/addperiod/0" method="post">

						<input type="hidden" class="form-control" id="modalvisitid2" name="Workorder[id]" value="<?=$_GET['id'];?>">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('Start and finish date period');?></label>
									<fieldset class="form-group">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control openRight" id="workorderdate" name="Workorder[date]"  autocomplete="off">
												<div class="input-group-append">
													<span class="input-group-text">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Period Type ( How many weeks or how many months? )');?></label>
									<div class="row">

										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<fieldset class="form-group">
											<input type="text" min='1' class="form-control" name="Workorder[date]"  autocomplete="off" required>
										</fieldset>
										</div>
										<div class="col-xl-8 col-lg-8 col-md-8 mb-1">

												<fieldset class="form-group">
													<select class="select2" style="width:100%" name="Workorder[firmid]" onchange="myfirm()" required>
														<option  value="1" hidden><?=t('Week');?></option>
														<option  value="2" hidden><?=t('Month');?></option>
													</select>
												</fieldset>
										</div>

									</div>
								</div>




                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <?php if($visits==0){?>
								 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
								 <?php }?>
                                </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--Workorder period add finish-->


<?php }
?>



<script>


function uperiod()
{
	console.log($( "#applyw" ).val());
	var d=$( "#applyw" ).val();
	if(d==2 || d==3)
	{
		$( "#workorderdate" ).prop( "disabled", true );
	}
	else
	{
		$( "#workorderdate" ).prop( "disabled", false );
	}
	
}
function validateForm() {
    var workorderstime = document.getElementById('workorderstime').value;
    var workorderftime = document.getElementById('workorderftime').value;
	var branch = document.getElementById('branch').value;
	var team = document.getElementById('team').value;
	var staff = document.getElementById('staff').value;
	var visittype = document.getElementById('visittype').value;
	var route = document.getElementById('route').value;
	var client = document.getElementById('client').value;
	var workordertodo = document.getElementById('workordertodo').value;
    if (workorderstime === "") {
      toastr.error("<center><?=t('Uyarı')?>.</center>", "<center><?=t('Başlangıç saati zorunlu alandır')?></center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
							return false;
    }
	 if (workorderftime === "") {
      toastr.error("<center><?=t('Uyarı')?>.</center>", "<center><?=t('Bitiş saati zorunlu alandır')?></center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
							return false;
    }
	 if (team === "" && staff === "") {
      toastr.error("<center><?=t('Uyarı')?>.</center>", "<center><?=t('Takım veya personel alanlarınından birini seçmek zorunludur')?></center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
							return false;
    }
	if (visittype === "") {
      toastr.error("<center><?=t('Uyarı')?>.</center>", "<center><?=t('Ziyaret tipi zorunlu alandır')?></center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
							return false;
    }
	if (client === "") {
      toastr.error("<center><?=t('Uyarı')?>.</center>", "<center><?=t('Müşteri alanı zorunlu alandır')?></center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
							return false;
    }
if (workordertodo === "") {
      toastr.error("<center><?=t('Uyarı')?>.</center>", "<center><?=t('Yapılacak alanı zorunlu alandır')?></center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
							return false;
    }
    // Diğer gerekli kontrol işlemleri buraya eklenebilir

    return true;
  }



$("#createpage").hide();
$("#departmentvisited-form").hide();

$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });


 $("#days").hide();
 $("#monthdays").hide();

function dvisited()
{
		$("#departmentvisited-form").show(500);
			var d=$("#department").val();
	var sd=$("#subdepartment").val();
	var mpt=$("#monitoringtype").val();
	var cid=$("#client").val();


	$.post( "/workorder/monitoringpointno?d="+d+"&&sd="+sd+"&&mpt="+mpt+'&&cid='+cid).done(function( data ) {
		$('#monitoringno').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}


  function clicked()
  {
       if (confirm("<?=t('If you update that period, this period can be deleted and recreated.Do you want to continue?');?>")) {
            $("#workorder-save").submit();
       } else {
           return false;
       }
  }


 function workorderperiodtype()
{
	 var period=document.getElementById("periodtype").value;
	 if(period=='week')
	 {
		 $("#days").show(500);
		 $("#monthdays").hide(500);
	 }
	 else if(period=='month')
	 {
		 $("#days").hide(500);
		 $("#monthdays").show(500);
	 }
	 else
	 {
		 $("#days").hide(500);
		 $("#monthdays").hide(500);
	 }
 }


setTimeout(function() {
   workorderisperiodfirst();
}, 100); // 2000 milisaniye = 2 saniye

function workorderisperiodfirst()
 {
	  
	  var isperiod=$('#isperiod').val();
	  if(isperiod==1)
	  {
		  $("#isperiodform").hide(500);
		  
		  $("#periodapply").show(500);
		  
		  
		  $( "#workorderdate" ).prop( "disabled", false );
		
		  
		  	$('#isperiod').val('0');
				$('#isperiod').select2('destroy');
				$('#isperiod').select2({
					closeOnSelect: false,
						 allowClear: true
				});
			
		  <?php if(isset($_GET['id']) && $_GET['id']!='' && !$a)
		  {?>
			 $("#workorderupdate").html('');

		  <?php }?>
	  }
 }

 function workorderisperiod()
 {
	 
	    var isperiod=$('#isperiod').val();
	 
	  if(isperiod==1)
	  {
	


		  $("#isperiodform").show(500);
		  
		  $("#periodapply").show(500);
		  
		  $( "#workorderdate" ).prop( "disabled", true );
		
		  
		  	$('#isperiod').val('1');
				$('#isperiod').select2('destroy');
				$('#isperiod').select2({
					closeOnSelect: false,
						 allowClear: true
				});

		  <?php if(isset($_GET['id']) && $_GET['id']!='' && !$a)
		  {?>
			// $("#workorderupdate").html('<a class="btn btn-danger btn-sm" id="sl" onclick="workordersil(this)" data-id="<?=$_GET['id'];?>" style="line-height: 29px;color: #fff;margin-right: 5px;font-size: 14px;"><?=t('Delete');?></a><button class="btn btn-primary" onclick="clicked(); return false;"><?=t('Regenerate');?></button>');
			 $("#workorderupdate").html('<button class="btn btn-primary" onclick="clicked(); return false;"><?=t('Regenerate');?></button>');

		  <?php }?>
	  }
	  else
	  {
		   $( "#workorderdate" ).prop( "disabled", false );
		  $("#periodapply").show(500);
		  $("#isperiodform").hide(500);

		   <?php if(isset($_GET['id']) && $_GET['id']!='' && !$a)
		  {?>
			 $("#workorderupdate").html('');

		  <?php }?>
	  }
 }

  <?php if(isset($_GET['id']) && $_GET['id']!='' && !$a)
		  {?>

		 $("#workorderupdate").html('');
	<?php }?>


 <?php if($isperiod!='')
 {?>
	$("#periodapply").show();
	$("#isperiodform").hide();


 <?php }

 if($dayweekmonthyear!='')
 {
	 if($dayweekmonthyear=='month')
	 {?>
		 $("#days").hide(500);
		 $("#monthdays").show(500);
	 <?php }
	 else if($dayweekmonthyear=='week')
	 {?>
		 $("#days").show(500);
		 $("#monthdays").hide(500);
	 <?php }
	 else
	 {?>
		 $("#days").hide(500);
		 $("#monthdays").hide(500);
	 <?php }
 }

 if(!isset($_GET['id']))
 {?>
	 $("#isperiodform").hide();
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



function teaminput()
{
	var d=$("#team").val();
	if(d==0)
	{
		$( "#team" ).prop( "disabled", false );
		$( "#staff" ).prop( "disabled", false );
	}
	else
	{
		$( "#team" ).prop( "disabled", false );
		$( "#staff" ).prop( "disabled", true );
	}
}

function staffinput()
{
	var d=$("#staff").val();
	if(d=='' || d==0)
	{
		$( "#team" ).prop( "disabled", false );
		$( "#staff" ).prop( "disabled", false );
	}
	else
	{
		$( "#team" ).prop( "disabled", true );
		$( "#staff" ).prop( "disabled", false );
	}
}




 <?php if(isset($_GET['visitid'])){?>
	$( "#subdepartment" ).prop( "disabled", false );

	var d=$("#department").val();
	var sd=$("#subdepartment").val();
	var mpt=$("#monitoringtype").val();
	var cid=$("#client").val();


	$.post( "/workorder/monitoringpointno?d="+d+"&&sd="+sd+"&&mpt="+mpt+'&&cid='+cid).done(function( data ) {
		$('#monitoringno').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});


 <?php }?>

<?php if($ax->firmid!=0 && $_GET['id']==''){?>
	  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		});


	$.post( "/workorder/visittype?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#visittype" ).prop( "disabled", false );
		$('#visittype').html(data);
	});
<?php }?>



<?php if($ax->branchid!=0 && $_GET['id']==''){?>

	$.post( "/workorder/staffteam?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#team" ).prop( "disabled", false );
		$('#team').html(data);
	});

	$.post( "/workorder/route?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#route" ).prop( "disabled", false );
		$('#route').html(data);
	});
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	$.post( "/workorder/staff?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#staff" ).prop( "disabled", false );
		$('#staff').html(data);
	});

	$( "#monitoringavailable" ).prop( "disabled", false );

	$.post( "/workorder/treatmenttype?id="+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#monitoringavailable" ).prop( "disabled", false );
		$( "#treatmenttype" ).prop( "disabled", false );
		$('#treatmenttype').html(data);
	});



<?php }?>
  
  


 function myfirm()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});

	$.post( "/workorder/visittype?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#visittype" ).prop( "disabled", false );
		$('#visittype').html(data);
	});
}

function myclient()
{
	var cid=$("#client").val();

}
  


function mysubdepartment()
{
	var d=$("#department").val();
	var sd=$("#subdepartment").val();
	var mpt=$("#monitoringtype").val();
	var cid=$("#client").val();
	$.post( "/workorder/monitoringpointno?d="+d+"&&sd="+sd+"&&mpt="+mpt+'&&cid='+cid).done(function( data ) {
		$('#monitoringno').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

function routeclient()
{
	var route=$("#route").val();
	var branch=$("#branch").val();
	$.post( "/workorder/routeclient?route="+route+"&&branch="+branch).done(function( data ) {
		$('#client').html(data);
	});
}


function mymonitoringtype()
{
	var d=$("#department").val();
	var sd=$("#subdepartment").val();
	var mpt=$("#monitoringtype").val();
	var cid=$("#client").val();


	$.post( "/workorder/monitoringpointno?d="+d+"&&sd="+sd+"&&mpt="+mpt+'&&cid='+cid).done(function( data ) {
		$('#monitoringno').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

 function mybranch()
{
	$.post( "/workorder/staffteam?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#team" ).prop( "disabled", false );
		$('#team').html(data);
	});

	$.post( "/workorder/route?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#route" ).prop( "disabled", false );
		$('#route').html(data);
	});
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	$.post( "/workorder/staff?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#staff" ).prop( "disabled", false );
		$('#staff').html(data);
	});



	$.post( "/workorder/treatmenttype?id="+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#monitoringavailable" ).prop( "disabled", false );
		$( "#treatmenttype" ).prop( "disabled", false );
		$('#treatmenttype').html(data);
	});

}

if(document.getElementById("getid").value>0)
{
	$( "#branch" ).prop( "disabled", false );
	$( "#team" ).prop( "disabled", false );
	$( "#visittype" ).prop( "disabled", false );
	$( "#route" ).prop( "disabled", false );
	$( "#client" ).prop( "disabled", false );
	$( "#staff" ).prop( "disabled", false );


	if(($("#staff").val()=='' || $("#staff").val()==0)  && $("#team").val()>0)
	{
		$( "#team" ).prop( "disabled", false );
		$( "#staff" ).prop( "disabled", true );
	}
	if(($("#staff").val()!='' && $("#staff").val()>=1) && $("#team").val()==0)
	{
		$( "#team" ).prop( "disabled", true );
		$( "#staff" ).prop( "disabled", false );
	}
	if(($("#staff").val()=='' || $("#staff").val()==0) && $("#team").val()==0)
	{
		$( "#team" ).prop( "disabled", false );
		$( "#staff" ).prop( "disabled", false );
	}


	
}

function mydepartment()
{
	$.post( "/workorder/subdepartment?id="+$("#department").val()).done(function( data ) {
		$( "#subdepartment" ).prop( "disabled", false );
		$('#subdepartment').html(data);
	});

	var d=$("#department").val();
	var sd=$("#subdepartment").val();
	var mpt=$("#monitoringtype").val();
	var cid=$("#client").val();
	$.post( "/workorder/monitoringpointno?d="+d+"&&sd="+sd+"&&mpt="+mpt+'&&cid='+cid).done(function( data ) {
		$('#monitoringno').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}


if($("#monitoringavailable").val()!=0)
	{
		$("#available").show();
		$("#notavailable").hide();
	}
	else
	{
		$("#available").hide();
		$("#notavailable").show();
	}

function mymonitoring()
{
	if($("#monitoringavailable").val()!=0)
	{
		$("#available").show();
		$("#notavailable").hide();
	}
	else
	{
		$("#available").hide();
		$("#notavailable").show();
	}
}


<?php if($ax->branchid==0){
		if($firm->package=='Packagelite')
		{?>

				$.post( "/workorder/staffteam?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#team" ).prop( "disabled", false );
		$('#team').html(data);
	});

	$.post( "/workorder/route?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#route" ).prop( "disabled", false );
		$('#route').html(data);
	});
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	$.post( "/workorder/staff?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#staff" ).prop( "disabled", false );
		$('#staff').html(data);
	});



	$.post( "/workorder/treatmenttype?id="+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#monitoringavailable" ).prop( "disabled", false );
		$( "#treatmenttype" ).prop( "disabled", false );
		$('#treatmenttype').html(data);
	});


	<?php }
}

if($ax->branchid==0 && $_GET['id']!=''){
		if($firm->package=='Packagelite')
		{

			?>

				$.post( "/workorder/visittype?id="+document.getElementById("firm").value).done(function( data ) {

				$( "#visittype" ).prop( "disabled", false );
				$('#visittype').html(data);
				$( "#visittype" ).val(<?=$workorder->visittypeid;?>);
			});

				$.post( "/workorder/staffteam?id="+document.getElementById("branch").value).done(function( data ) {
				<?php if($workorder->teamstaffid>0){?>
					$( "#team" ).prop( "disabled", false );
				<?php }else{?>
					$( "#team" ).prop( "disabled", true );
				<?php }?>
					$('#team').html(data);
					$( "#team" ).val(<?=$workorder->teamstaffid;?>);

			});

			$.post( "/workorder/route?id="+document.getElementById("branch").value).done(function( data ) {
				$( "#route" ).prop( "disabled", false );
				$('#route').html(data);
				$( "#route" ).val(<?=$workorder->routeid;?>);
			});
			$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
				$( "#client" ).prop( "disabled", false );
				$('#client').html(data);
				$( "#client" ).val(<?=$workorder->clientid;?>);
			});
			$.post( "/workorder/staff?id="+document.getElementById("branch").value).done(function( data ) {
				<?php if($workorder->staffid!=''){?>
					$( "#staff" ).prop( "disabled", false );
				<?php }else{?>
					$( "#staff" ).prop( "disabled", true );
				<?php }?>
				$('#staff').html(data);
				$( "#staff" ).val(<?=$workorder->staffid;?>);
			});

			$.post( "/workorder/treatmenttype?id="+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
				<?php if($dvisit){?>
				$( "#monitoringavailable" ).prop( "disabled", false );
				$( "#treatmenttype" ).prop( "disabled", false );
				<?php }?>
				$('#treatmenttype').html(data);
				$( "#treatmenttype" ).val(<?=$dvisit->treatmenttypeid;?>);



			});
		<?php }
	}


	?>


 

function openmodalsil(obj)
{
	$('#modalvisitid2').val($(obj).data('id'));
	$('#sil').modal('show');

}
function workordersil(obj)
{
	$('#workorderid2').val($(obj).data('id'));
	$('#workordersil').modal('show');

}

function addperiod(obj)
{
	$('#workorderid3').val($(obj).data('id'));
	$('#periodadd').modal('show');

}

$(document).ready(function() {

	$('#datetimepicker3').datetimepicker({

		format: 'HH:mm'
	});

	$('#datetimepicker4').datetimepicker({
		format: 'HH:mm'
	});

	// Single Date Range Picker
	$('.singledate').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true
	});

	// Date Limit
	$('.openRight').daterangepicker({
		opens: "left",	// left/right/center
    minDate:"<?=date("m-d-Y")?>",   
	 maxDate: moment().add(25, 'months').format('MM-DD-YYYY'),
    maxSpan: {
        "days":366
    },

    
	});

} );




$(document).ready(function() {

	 $(".select2-placeholder-multiple").select2({
      placeholder: "<?=t('Select State');?>",
    });


  
<? if( $workorder->isperiod==1) {?>
  
  		// $( "#visittype" ).prop( "disabled", true );
  	 $( "#branch" ).prop( "disabled", true );
  		// $( "#monitoringavailable" ).prop( "disabled", true );
		// $( "#treatmenttype" ).prop( "disabled", true );
  		 $( "#client" ).prop( "disabled", true );
  		// $( "#route" ).prop( "disabled", true );
  		// $( "#workordertodo" ).prop( "disabled", true );
  		// $( "#isperiod" ).prop( "disabled", true );
  		// $( "#applyw" ).prop( "disabled", true );
  
  <?php } ?>

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
                columns: [ 0,1,2,3,4,5]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Workorder')?> (<?=$workorder->todo;?>) <?=date('d-m-Y H:i:s');?>\n',
			messageTop:'<?//if(isset($_GET["id"]) && $_GET["id"]!=''){echo User::model()->table("clientbranch",$workorder->clientid);}?> \n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0,1,2,3,4,5]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Workorder')?> (<?=$workorder->todo;?>) <?=date('d-m-Y H:i:s');?>\n',
			messageTop:'<?//if(isset($_GET["id"]) && $_GET["id"]!=''){echo User::model()->table("clientbranch",$workorder->clientid);}?> \n',
        },



		{
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2,3,4,5]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: '<?=t('Export')?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t('Workorder')?> (<?=$workorder->todo;?>)\n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },

				  {
					text: '<?//if(isset($_GET["id"]) && $_GET["id"]!=''){echo User::model()->table("clientbranch",$workorder->clientid);}?> \n',
					bold: true,
					fontSize: 11,
						alignment: 'center'
				  },

						{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 10,
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
console.log(info);
var lengthMenuSetting =info==undefined?0: info.length; //The value you want
// alert(table.page.info().length);
} );
</script>
<?php

if(isset($_GET['id']))
{
$workorder=Workorder::model()->find(array('condition'=>'id='.$_GET['id']));
if($workorder->status==3 ){ ?>
<script>
    //Selectboxlar
    $('#firm').attr('disabled',true);
    $('#branch').attr('disabled',true);
    $('#team').attr('disabled',true);
    $('#staff').attr('disabled',true);
    $('#visittype').attr('disabled',true);
    $('#route').attr('disabled',true);
    $('#client').attr('disabled',true);



    // Textboxlar
    $('#workorderdate').attr('disabled',true);
    $('#workorderstime').attr('disabled',true);
    $('#workorderftime').attr('disabled',true);
    $('#workordertodo').attr('disabled',true);

<?php if($ax->id!=1 && $ax->type!=13)
	{?>
    $("#sl").removeAttr('onclick');
	<?php }?>
<?php if($ax->type!=13 && $ax->type!=1){?>
    $(".swq").hide();
    $('#department').attr('disabled',true);
    $('#monitoringtype').attr('disabled',true);
      $('#kydt2').attr('disabled',true);
    <?php }?>

    // Buttonlar
    $('#kydt').attr('disabled',true);




    $('#monitoringavailable').attr('disabled',true);
        console.log("calisti");

</script>
<?php }

 }?>


 <?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/extensions/moment.min.js;';
 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/daterange/daterangepicker.js;';


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
