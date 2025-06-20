


<?php

User::model()->login();

$ax= User::model()->userobjecty('');
$firmid=$ax->firmid;
$firm=Firm::model()->find(array('condition'=>'id='.$firmid));
$country=$firm->country_id;

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
	$conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'date desc'));

	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{

		$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and conformity.clientid='.$ax->clientbranchid.' GROUP BY conformity.id')->queryAll();
	}





?>





<div class="row">

   <div class="col-xl-12 col-lg-12 col-12">
	<div class="row">


<?php
	 // $yil=date('Y');
	 $yil=2019;
$starttime=strtotime('01-01-'.$yil.' 03:00:00');
$tarih='01-01-'.($yil+1).' 00:00:00';
//$finishtime=strtotime($tarih);
$finishtime=time();

$where=" and clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";

if($ax->clientbranchid==0)
{
	$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (date>='.$starttime.' and date<='.$finishtime.')'.$where)); // branch
	$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')'.$where)); // branch
}
else
{
	$conformitya=Conformity::model()->findAll(array('condition'=>'clientid='.$ax->clientbranchid.' and (date>='.$starttime.' and date<='.$finishtime.')')); // branch
	$conformityk=Conformity::model()->findAll(array('condition'=>'clientid='.$ax->clientbranchid.' and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch
}
	?>
				<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>

		<div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">

						<div class="p-2 text-center bg-info bg-darken-2" style='background-color: #21c2dc !important; border-right: 1px solid #6bddeb;;'>

							<a href='/site/closeopenconformity'>
								<i class="fa fa-cloud-upload white" style='font-size: 40px;'></i>
								<div style='font-size: 15px;color: #fff;'><?=t('Rapor Al');?></div>

							</a>
						</div>

						<div class="p-2 bg-gradient-x-info white media-body" style='background-image: linear-gradient(to right, #21c2dc 0%, #6bddeb 100%);'>
							<h5><?=t('Opened / Closed Non-Conformities');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformitya);?> / <?=count($conformityk);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }

		?>



<?php if($ax->clientid!=0 && $ax->clientbranchid==0)
{
	$x='';
	$i=0;
	$cl=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
	foreach($cl as $clx)
	{
		if($i==0)
		{
			$x=$clx->id;
		}
		else
		{
			$x=$x.','.$clx->id;
		}
	}
	$qr=Workorder::model()->findAll(array("condition"=>"(cantscancomment='' or cantscancomment='null') and clientid in (".$x.')'));
	$notqr=Workorder::model()->findAll(array("condition"=>"cantscancomment!='' and cantscancomment!='null' and clientid in (".$x.')'));

}
if($ax->clientbranchid!=0)
{

		$qr=Workorder::model()->findAll(array("condition"=>"(cantscancomment='' or cantscancomment='null') and clientid=".$ax->clientbranchid));
	$notqr=Workorder::model()->findAll(array("condition"=>"cantscancomment!='' and cantscancomment!='null' and clientid=".$ax->clientbranchid));


}

?>

<!--
		<div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">

						<div class="p-2 text-center bg-info bg-darken-2" style='background-color: #d21f1f !important; border-right: 1px solid #e85555;'>

							<a href='/site/conformityqrreports'>
								<i class="fa fa-cloud-upload white" style='font-size: 40px;'></i>
								<div style='font-size: 15px;color: #fff;'><?=t('Rapor Al');?></div>

							</a>
						</div>

						<div class="p-2 bg-gradient-x-info white media-body" style='background-image: linear-gradient(to right, #d21f1f 0%, #ec5d5d 100%);'>
							<h5><?=t('Monitor read qr / not read qr');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="fa fa-check"> <?=count($qr);?> / <i class="fa fa-times"> <?=count($notqr);?></i></i></h5>
						</div>
					</div>
				</div>
			</div>
		</div>

-->


		<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6)

		Yii::app()->getModule('authsystem');
		$return=AuthAssignment::model()->findAll(array('condition'=>'userid='.$ax->id));

		/*if(count($return)>1)
		{
			*/

		?>



	<div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
	<a href='client/workorderreports/<?=$ax->clientid?>'>
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">
						<div class="p-2 text-center bg-info bg-darken-2">
							<i class="icon-user font-large-2 white"></i>
						</div>
						<div class="p-2 bg-gradient-x-info white media-body" style='min-height: 104px;'>
							<h5 style='    margin-top: 17px;'><?=t('Workorder Reports');?></h5>
							<!--
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformitya);?> / <?=count($conformityk);?></h5>
							-->
						</div>
					</div>
				</div>
			</div>
			</a>
		</div>
		<?php }//} ?>


								<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6)


	$conformityk=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id WHERE (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) && conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL '.Conformity::model()->where())->queryAll();


?>

		<div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
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
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformityk);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>


    </div>
    </div>
</div>

<?php





///////////////////////////////


		$where='';

		 if($ax->firmid>0){
			 $firmid=$ax->firmid;
		 }

		 if($ax->branchid>0){
			 $branchid=$ax->branchid;
		 }

		  if($ax->clientbranchid>0){
			 $clientid=$ax->clientbranchid;
		 }else{
        			 $clientid=$ax->clientid;
      }






		if($firmid==0)
		{

			$where='';

			if($startdate!='' && $finishdate!='')
			{
				$where='date between "'.$startdate.'" and "'.$finishdate.'"';
			}
			if($startdate=='' && $finishdate!='')
			{
				$where='date<="'.$finishdate.'"';
			}
			if($startdate!='' && $finishdate=='')
			{
				$where='date>="'.$startdate.'"';
			}

		}
		else if($firmid>0)
		{

			$where='firmid='.$firmid;
			if($branchid!=0 || $branchid!='')
			{
				$where=$where.' and branchid='.$branchid;
			}
			if($team!=0 || $team!='')
			{
				$where=$where.' and teamstaffid='.$team;
			}
			if($staff!=0 || $staff!='')
			{
				$sarray=explode(',',$staff);
				$swhere='';
				for($i=0;$i<count($sarray);$i++)
				{
					if($i==0)
					{
						$swhere='staffid="'.$sarray[$i].'" or staffid LIKE "'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].'"';
					}
					else
					{
						$swhere=$swhere.' or (staffid="'.$sarray[$i].'" or staffid LIKE "'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].'")';
					}
				}

				$where=$where.' and ('.$swhere.')';
			}

			if($routeid!=0 || $routeid!='')
			{
				$where=$where.' and routeid='.$routeid;
			}
			if($clientid!=0 || $clientid!='')
			{
        		  if($ax->clientbranchid>0){
                	$where=$where.' and clientid='.$clientid;
		  			 $clientid=$ax->client;
             

      }else{
        
                $subcli=Client::model()->findAll(array(
								   'condition'=>'parentid='.$clientid,
									));
                $arrx=[];
                foreach ($subcli as $itm ){
            
                 $arrx[]= $itm->id;
                }
                if (is_countable($arrx) && count($arrx)){
          
                     	$where=$where.' and clientid in ('.implode(',',$arrx).')';
                }else{
      
                     	$where=$where.' and clientid='.$clientid;
                }
     
              }
			
			}
			if($visittypeid!=0 || $visittypeid!='')
			{
				$where=$where.' and visittypeid='.$visittypeid;
			}

			if($startdate!='' && $finishdate!='')
			{
				$where=$where.' and date between "'.$startdate.'" and "'.$finishdate.'"';
			}
			if($startdate=='' && $finishdate!='')
			{
				$where=$where.' and date<="'.$finishdate.'"';
			}
			if($startdate!='' && $finishdate=='')
			{
				$where=$where.' and date>="'.$startdate.'"';
			}

		}


if($where==''){
  $where='1=1 ';
  $workorder=[];

}else{
  $workorder=Workorder::model()->findAll(array(
						
								   'condition'=>$where.' and status=3 and visittypeid<>109 ',
        
								   'order'=>'executiondate desc',
								   'limit'=>3000
									));

}

		


//$workorder=Workorder::model()->findAll(array(
					//			   'condition'=>'id > 1000 and id<1001',
					//				));

?>

<div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('VISIT REPORTS');?></h4>
						</div>

					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                    

       
                              <th><?=t('VISIT REPORT');?></th>
                              <th><?=t('EXECUTION DATE');?></th>
                            		<th><?=t('Client');?></th>		
                            	<th><?=t('DESCRIPTION');?></th>	
                            	<th><?=t('STAFF/TEAM');?></th>
                            		<th><?=t('Visit Type');?></th>
             
                          </tr>
                        </thead>
                        <tbody >
             <?php
			foreach($workorder as $workorderx){?>
              <tr>

               <!--   
				   <?php if($ax->firmid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->firmid))->name;?>
					  </td>
				  <?php }?>
				    <?php if($ax->branchid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->branchid))->name;?>
					  </td>
				  <?php }?>-->
                   
                        <td>
                	<? $idsr= Servicereport::model()->find(array('condition'=>'reportno='.$workorderx->id));
                   if($idsr->id>1){
                     if( $country=='2'){
											 if ($idsr->ti_checklist<>''){
												    ?>
                   
                   <a href="/site/tireport?id=<?=$idsr->id?>&pdf=ok" target="_blank"> TI_<?=$workorderx->id?></a>
                   <?php											 }else{
												 											 if ($idsr->simple_client==1){
											
												   ?>
                   
                   <a href="/site/servicereport4?id=<?=$idsr->id?>&pdf=ok" target="_blank"> sVR_<?=$workorderx->id?></a>
                   <? 
																							 }else{
																								 ?>
																								 
                   <a href="/site/servicereport4?id=<?=$idsr->id?>&pdf=ok" target="_blank"> VR_<?=$workorderx->id?></a>
																								 <?php
																							 }
											 }
											 
                    
                     }else{
                        ?>
                   
                   <a href="/site/servicereport?id=<?=$idsr->id?>" target="_blank"> <?=$workorderx->id?></a>
                   <?php                     }
                    
                   }else{
                     echo '---';
                   }
                   ?>
					  </td>

   <td>
					<?php					   if($workorderx->realendtime!='' && $workorderx->realendtime!=0)
						{
                if($idsr->id>1){
                  echo date("Y/m/d H:i:s", ($idsr->date));
                     ?>
                
                   <?php                   }else{
					    echo date("Y/m/d H:i:s",  $workorderx->realendtime);
				   }
							
						}
						else
						{
							echo t('Continues');
						}
					 ?>
				  </td>
				 

			
				 
				   <td>
				   <?php if($workorderx->clientid!='' && $workorderx->clientid!=0){echo Client::model()->find(array('condition'=>'id='.$workorderx->clientid))->name;}?>
				 </td>
				
				   <td>
					<?=$workorderx->todo;?>
				  </td>
				 
	  <td>
					<?php if($workorderx->staffid!='' && $workorderx->staffid!=0){
						$staffs=explode(',',$workorderx->staffid);

						for($i=0;$i<count($staffs);$i++)
						{
							if($staffs[$i]!='')
							{
								echo User::model()->find(array('condition'=>'id='.$staffs[$i]))->name;
							}
						}
				  }?>
					<?php if($workorderx->teamstaffid!='' && $workorderx->teamstaffid!=0){
						echo Staffteam::model()->find(array('condition'=>'id='.$workorderx->teamstaffid))->teamname;
					}?>
				  </td>
				
             <td>
                 <?php                                       
                                        
                                         if   (is_numeric($workorderx->visittypeid)){
                                            $vt=Visittype::model()->find(array('condition'=>'id='.$workorderx->visittypeid)); 
                                        echo   t($vt->name);
                                         }else{
                                           echo '--';
                                         }
                                         
                                         
				?>
                 </td>    
				</tr>

		<?php		}?>


                        </tbody> 
                        <tfoot>
                          <tr>
<!--
						    <?php if($ax->firmid==0){?>
									<th><?=t('Firm');?></th>
									<?php }?>

									<?php if($ax->branchid==0){?>
									<th><?=t('Branch');?></th>
									<?php }?>-->


					
                      
       
                              <th><?=t('VISIT REPORT');?></th>
                              <th><?=t('EXECUTION DATE');?></th>
                            		<th><?=t('Client');?></th>		
                            	<th><?=t('DESCRIPTION');?></th>	
                            	<th><?=t('STAFF/TEAM');?></th>
                            		<th><?=t('Visit Type');?></th>
             
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>


<?php /*if (Yii::app()->user->checkAccess('conformityuserassign.view')){

	if($ax->clientid!=0){?>
    <section id="chartjs-bar-charts">

          <!-- Column Chart -->
          <div class="row">
            <div class="col-<?php if($ax->type==27){echo "6";}else{echo "12";}?>">
              <div class="card">
                <div class="card-header " style="padding-top: 9px;
    padding-bottom: 0px;
    border-bottom: 1px solid #f1f1f1;">
							<div class='col-md-12'>
								<div class='row'>
									<div class='col-md-9'>
										<h4 class="card-title" style="line-height: 46px;"><?=t("Atanan Uygunsuzluk Grafik");?></h4>
									</div>
							<?php if($ax->type==22){?>
								<div class='col-md-3' style="float:right">
									<fieldset class="form-group">
										<select class="select2" style="width:100%" id="atananClient" onchange="clientatama(this)">
											<?php											$atamaclient=Client::model()->findall(array('condition'=>'parentid='.$ax->clientid.' order by name asc'));
											$sayac=0;
											$ilkclient=0;
											 foreach($atamaclient as $atamaclients){?>
												 <option <?php if((!isset($_GET['cbid'])&& $sayac==0) || (isset($_GET['cbid']) && $_GET['cbid']==$atamaclients->id)){echo "selected";$ilkclient=$atamaclients->id;}?> value="<?=$atamaclients->id;?>"><?=$atamaclients->name;?></option>
											 <?php											 $sayac++;
										 }?>
										</select>
									</fieldset>
								</div>
								<?php }?>
								</div>
							</div>




                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                    <canvas id="column-chart" height="300"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Bar Stacked Chart -->


        </section>

<?php }}*/?>


<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>




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
												<?$clientbranchs=Client::model()->findAll(array('condition'=>'parentid='.$clientx->id));

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

<!-- grafik uygunsuzluk atama sayıları-->
	<?php
if($ax->type==26)
{
	$userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ax->clientbranchid));
}
else if($ax->type==27)
{
	$userss=User::model()->findAll(array("condition"=>"id=".$ax->id));

}
else if($ax->type==22)
{

	$userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid!=0"));
}




			$label='';
			$i=0;
			$acikuy='';
			$kapaliuy='';
			$toplam='';
			if($userss){
			foreach($userss as $userssx)
			{
				$aciksay=0;
				$kapalisay=0;
				$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1","order"=>"id desc","group"=>"conformityid"));
				foreach($conformityuserassign as $conformityuserassignx)
				{
					$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
					$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
					if(!$gerigonderme && !$deadlineverme)
					{
						$aciksay++;
					}

					if(!$gerigonderme && $deadlineverme)
					{
						$kapalisay++;
					}
				}


				if($i==0)
				{
					if($userssx->name=='' && $userssx->surname=='')
					{
						$label='"'.$userssx->username.'"';
					}
					else{
						$label='"'.$userssx->name.' '.$userssx->surname.'"';
					}

					$acikuy=$aciksay;
					$kapaliuy=$kapalisay;
					$toplam=$aciksay+$kapalisay;
				}
				else
				{
					if($userssx->name=='' && $userssx->surname=='')
					{
							$label=$label.',"'.$userssx->username.'"';
					}
					else{
							$label=$label.',"'.$userssx->name.' '.$userssx->surname.'"';
					}

					$acikuy=$acikuy.','.$aciksay;
					$kapaliuy=$kapaliuy.','.$kapalisay;
					$top=$aciksay+$kapalisay;
					$toplam=$toplam.','.$top;
				}



				$i++;

			}
		}




			?>

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

function clientatama(elm)
{

	window.location.href = '?cbid='+elm.value;
	/*
	$.post( "/client/atananClient?id="+document.getElementById("atananClient").value).done(function( data ) {

		var res = $.parseJSON(data);

		console.log(res['label']);
	});

	*/
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
   function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}
  
  
  
  var userLang = navigator.language || navigator.userLanguage; 
  if (userLang==='tr' && getCookie('crmlanguage')!=='tr'){
    let text = "Diliniz Türkçe değil, dilinizi Türkçe yapmak ister misiniz?";
  if (confirm(text) == true) {
    text = "Y";
    window.location.href = "/?language=tr";
  } else {
    text = "N";
  }
 // document.getElementById("demo").innerHTML = text;
    console.log(userLang);
  }
  
} );
  
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

<?$whotable=User::model()->iswhotable();?>
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
			 "order": [[ 5, 'desc' ]],
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


		<?php		$ax= User::model()->userobjecty('');
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




$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#column-chart");

    // Chart Options
    var chartOptions = {
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each bar to be 2px wide and green
        elements: {
            rectangle: {
                borderWidth: 2,
                borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
            }
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'top',
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#3e3e3e",
                    drawTicks: false,

                },
                scaleLabel: {
                    display: true,
                },

            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }]
        },
        title: {
            display: true,
            text: '<?=t("Kapalı-Açık Uygunsuzluk Durumu");?>'
        },

    };

    // Chart Data
    var chartData = {


        labels: [<?=$label;?>],


           datasets: [{
            label: "Açık Uygunsuzluk",
            data: [<?=$acikuy;?>],
            backgroundColor: "#16D39A",
            hoverBackgroundColor: "rgba(22,211,154,.9)",
            borderColor: "transparent",
        }, {
            label: "Kapalı Uygunsuzluk",
            data: [<?=$kapaliuy;?>],
            backgroundColor: "#dc0000",
            hoverBackgroundColor: "rgba(226, 98, 40, 1)",
            borderColor: "transparent"
        },
			 {
            label: "Toplam Uygunsuzluk",
            data: [<?=$toplam;?>],
            backgroundColor: "#002f98",
            hoverBackgroundColor: "rgba(40, 108, 226, 1)",
            borderColor: "transparent"
        }]
    };

    var config = {
        type: 'bar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
});


</script>
<script>
var userLang = navigator.language || navigator.userLanguage; 
  if (userLang==='tr'){
    let text = "Diliniz Türkçe değil, dilinizi Türkçe yapmak ister misiniz?";
  if (confirm(text) == true) {
    text = "Y";
  } else {
    text = "N";
  }
 // document.getElementById("demo").innerHTML = text;
    console.log(userLang);
  }
//alert ("The language is: " + userLang);
</script>
 <?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/chart.min.js;';
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
