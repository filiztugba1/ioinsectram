<?php 


User::model()->login();

	$ax= User::model()->userobjecty('');
					$where="";
					if($ax->firmid>0)
						{
							if($ax->branchid>0)
							{
								if($ax->clientid>0)
								{
									if($ax->clientbranchid>0)
									{
										$where='clientid='.$ax->clientbranchid;
									}
									else
									{
										$workorder1=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
										$i=0;
										foreach($workorder1 as $workordery)
										{
											if($i==0)
											{
												$where='clientid='.$workordery->id;
											}
											else
											{
												$where=$where.' or clientid='.$workordery->id;
											}
											
										}
									}
								}
								else
								{
									$where="branchid=".$ax->branchid;
								}
							}
							else
							{
								$where="firmid=".$ax->firmid;
							}
						}
						else
						{
							$where="";
						}
						
						
						
						if(isset($_POST['Workorder']['firmid']) && $_POST['Workorder']['firmid']!=0)
						{
							$where="firmid=".$_POST['Workorder']['firmid'];
							if(isset($_POST['Workorder']['branchid']) && $_POST['Workorder']['branchid']!='' &&$_POST['Workorder']['branchid']!=0)
							{
								$where=$where." and branchid=".$_POST['Workorder']['branchid'];

								if(isset($_POST['Workorder']['clientid']) && $_POST['Workorder']['clientid']!='' &&$_POST['Workorder']['clientid']!=0)
								{
									
									 $clientk = implode(",", $_POST['Workorder']['clientid']);
									
									$where=$where." and clientid in (".$clientk.")";

								}

								if($_POST['Workorder']['team']!=0)
								{
									$where=$where." and teamstaffid=".$_POST['Workorder']['team'];
								}
								if($_POST['Workorder']['staff']!='')
								{
									$x=implode(",", $_POST['Workorder']['staff']);
								$where=$where." and (staffid in (".$x.")";
								


								$teamss='';
								for($k=0;$k<count($_POST['Workorder']['staff']);$k++)
									{
									$stafff=$_POST['Workorder']['staff'][$k];
									$steam=Staffteam::model()->findAll(array('condition'=>'leaderid='.$stafff.' or staff like "'.$stafff.',%" or staff like "%,'.$stafff.'" or staff like "%,'.$stafff.',%" or staff like "'.$stafff.'"'));

									foreach($steam as $steamx)
									{
										if($teamss=='')
										{
											$teamss=$steamx->id;
										}
										else
										{
											$teamss=$teamss.','.$steamx->id;
										}
									}
									
								}
								
							//echo $teamss;


								$where=$where." or teamstaffid in (".$teamss."))";
								}
							}
							
						}
						
					


					

					// $workorder=Workorder::model()->findAll(array('condition'=>$where));
					
					
if (Yii::app()->user->checkAccess('workorder.view')){?>	


<?php	$who=User::model()-> whopermission();
	$class="";

	

	if($who->who=='admin')
	{
		$class="col-xl-6 col-lg-6 col-md-6";
	}
	if($who->who=='firm')
	{
		$class="col-xl-12 col-lg-12 col-md-12";
	}
	
	

?>


<?=User::model()->geturl('Workorder',"Qr reports",0,'workorder',1);?>






<div class="content-body">
        <!-- Full calendar events example section start -->
        <section id="events-examples">
          <div class="row">
            <div class="col-12">
              <div class="card">
               <div class="card-header">
                  <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('Monitor data matrix reading or non-reading');?></h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                     <!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li>-->
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                   <li><a data-action="expand"><i class="ft-maximize"></i></a></li> 
				    <li>
					<!--
					<button class="btn btn-info" id="createbutton" type="submit" style="color:#fff"><?=t('Date Copy');?> <i class="fa fa-plus"></i></button></li> 
					-->
                       <!--  <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                    </ul>

				


                  </div>
				  <form action="/site/conformityqrreports" method="post">	
				 
				  <div class="row" style='padding: 10px 10px 1px 10px;border: 1px solid #d9d7d7;margin-top: 10px;background: #fef9f9;border-radius: 4px;'>
					
				     <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                            <label id='tarihkisitlama' for="basicSelect"><?=t("Date Range");?></label>
                            <fieldset class="form-group" id='startdate'>
                                <input type="date" class="form-control" id="datetimestart" name="date"
							value="<?php if(isset($_POST['date'])){echo $_POST['date'];}else{
							 $y=date('Y',strtotime(date('Y-m-d')));

								 $start=$y.'-01-01';
								 echo $start;
								 }?>" >
                            </fieldset>
                        </div>

					<?php						$y=date('Y');
						 $m=date('m');
						 $day = cal_days_in_month(CAL_GREGORIAN,  $m,  $y);
						
					?>
                  <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id="gzl">
                            <label for="basicSelect" class="hidden-xs hidden-sm" style="margin-top:15px "></label>
                            <fieldset class="form-group">
                                <input type="date" class="form-control" id="datetimefinish"  name="date1" value="<?php if(isset($_POST['date1'])){echo $_POST['date1'];}else{echo $y.'-'.$m.'-'.$day;}?>"
							>
                            </fieldset>
                        </div>



				
			
				  
				  
				  
				  
						<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm2" name="Workorder[firmid]" onchange="myfirm2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm2" name="Workorder[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>
						
					<?php if($ax->branchid==0){
							
							$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
							if($firm->package!='Packagelite')
							{
								
						?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch2" name="Workorder[branchid]" onchange="mybranch()"  disabled requred>
									<option value="0"><?=t('Please Chose');?></option>
									
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
								<input type="hidden" class="form-control" id="branch2" name="Workorder[branchid]" value="<?=$branch->id;?>">
						<?php }}else{?>
							
							<input type="hidden" class="form-control" id="branch2" name="Workorder[branchid]" value="<?=$ax->branchid;?>" required>
						<?php }?>

								 <?php    $departments=Departments::model()->findAll(array(
                            #'select'=>'',
                            #'limit'=>'5',
                            'order'=>'name ASC',
                            'condition'=>'parentid=0',
                        ));?>
				  	
						
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2-placeholder-multiple" style="width:100%" multiple="multiple" id="client" name="Workorder[clientid][]" onclick='' disabled ">
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
									<?php $tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$workorder->branchid));
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


                       

				  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Team');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id='team' onchange='searchteam()' name="Workorder[team]" disabled>
									<option value="0"><?=t('Select');?></option>
									
								</select>
							</fieldset>
					</div>


					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Staff');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" multiple="multiple" style="width:100%" id='staff' onchange='searchstaff()' name="Workorder[staff][]" disabled>
									<option value=""><?=t('Select');?></option>
								</select>
							</fieldset>
					</div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" id='labelcolor'></label>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style=' border: 1px solid #aaa;border-radius: 5px;padding: 13px 15px 15px 15px;' id='stcolor'>

							<?php if($_POST['Workorder']['team']!='' && isset($_POST['Workorder']['team']))
							{
							$branch=Staffteam::model()->find(array('condition'=>'id='.$_POST['Workorder']['team']));?>
							<?=$branch->teamname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
							<?php }?>

								  <?php	 
								  $staff='';
								  if(isset($_POST['Workorder']['staff']) && $_POST['Workorder']['staff']!=''){
									  
									  // $staff=$_POST['Workorder']['staff'];
										// print_r($_POST['Workorder']['staff']);
										for($i=0;$i<count($_POST['Workorder']['staff']);$i++)
									  {
										if($i==0)
										  {
											$staff=$_POST['Workorder']['staff'][$i];
										  }
										  else
										  {
											 $staff=$staff.','.$_POST['Workorder']['staff'][$i];
										  }
									  }
								  }?>



							<?php if($_POST['Workorder']['staff']!='' && isset($_POST['Workorder']['staff']))
							{
							$staff=explode(',',$staff);
							?><div class='row'><?php							
							for($i=0;$i<count($staff);$i++){

								$branch=User::model()->find(array('condition'=>'id='.$staff[$i]));
								?>
								<div class='col-xl-3 col-lg-3 col-md-3'>
									<?=$branch->name.' '.$branch->surname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
								</div>
							<?php }?>
							
							</div>
							
							<?php }?>

							
					</div>

					</div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					     <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float: right;">
									<button id='search' class="btn btn-primary" type="submit"><?=t('Search');?></button>
							
						</div>
                        </fieldset>
                    </div>
					</form>
				
				  
				  </div>
				  
				  
				  <?php					  if(isset($_POST['date']))
					  {
						$start=$_POST['date'];
						$finish=$_POST['date1'];
					  }
					  else
					  {
								$start=date('Y-m-d');

								 $y=date('Y',strtotime(date('Y-m-d')));

								 $start=$y.'-01-01';


								 $m=date('m',strtotime(date('Y-m-d')));
								 $day = cal_days_in_month(CAL_GREGORIAN,  $m,  $y);

								$finish=$y.'-'.$m.'-'.$day;
					  }


				
					

					
					if($where=='')
					{
						$where='(realstarttime!="" or realstarttime!=0) and date>="'.$start.'" and date<="'.$finish.'"';
					}
					else
					{
						$where=$where.' and (realstarttime!="" or realstarttime!=0) and date>="'.$start.'" and date<="'.$finish.'"';
					}
					
				?>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
						  <?php						$exel='0,1,2,3';  
					  if($ax->firmid==0)
							{
						 $exel='0,1,2,3,4,5,6,7,8,9';  
						  ?>
							<th><?=t('Firm');?></th>
							<th><?=t('Firm Branch');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>

						  <?php }?>

						   <?php							   
						   if($ax->firmid!=0 && $ax->branchid==0)
							{
							   $exel='0,1,2,3,4,5,6,7,8';?>
							<th><?=t('Firm Branch');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
						  <?php }?>

						   <?php							   if($ax->branchid!=0 && $ax->clientid==0)
							{
							   $exel='0,1,2,3,4,5,6,7';
							   ?>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
						  <?php }?>

						  <?php if($ax->clientid!=0 && $ax->clientbranchid==0)
							{
							  $exel='0,1,2,3,4,5,6,7';
							  ?>
							<th><?=t('Client Branch');?></th>
						  <?php }?>
							<th><?=t('Tarih-saat');?></th>
							<th><?=t('Real Start Time');?></th>
							<th><?=t('Real end Time');?></th>
							<th><?=t('Team/Personel');?></th>
							<th><?=t('Qr okutma');?></th>
							<th><?=t('Açıklama');?></th>

                            
							
                          </tr>
                        </thead>
                        <tbody>
						<?php $workorder=Workorder::model()->findAll(array('condition'=>$where));
						  foreach($workorder as $workorderk)
						  {
						
								
							?>
								

						<tr>
						  <?php if($ax->firmid==0)
							{
							$cl=Client::model()->find(array('condition'=>'id='.$workorderk->clientid));
							?>
							<td><?echo Firm::model()->find(array('condition'=>'id='.$workorderk->firmid))->name;?></td>
							<td><?echo Firm::model()->find(array('condition'=>'id='.$workorderk->branchid))->name;?></td>
							<td><?php							
						if($cl)
								{
						echo Client::model()->find(array('condition'=>'id='.$cl->parentid))->name;?></td>
							<td><?echo $cl->name;?></td><?php						}else
								{
						?><td></td><?php						}
							
						  }?>

						   <?php if($ax->firmid!=0 && $ax->branchid==0)
							{?>
							<td><?echo Firm::model()->find(array('condition'=>'id='.$workorderk->branchid))->name;?></td>
							<td><?php							$cl=Client::model()->find(array('condition'=>'id='.$workorderk->clientid));
							if($cl)
								{
						echo Client::model()->find(array('condition'=>'id='.$cl->parentid))->name;?></td>
							<td><?echo $cl->name;?></td><?php						}else
								{
						?><td></td><?php						}
							
						  }?>

						   <?php if($ax->branchid!=0 && $ax->clientid==0)
							{?>
							<td><?php							$cl=Client::model()->find(array('condition'=>'id='.$workorderk->clientid));
							if($cl)
								{
						echo Client::model()->find(array('condition'=>'id='.$cl->parentid))->name;?></td>
							<td><?echo $cl->name;?></td><?php						}
						else
								{
						?><td></td><?php						}
							
						  }?>

						  <?php if($ax->clientid!=0 && $ax->clientbranchid==0)
							{?>
							<td><?echo Client::model()->find(array('condition'=>'id='.$workorderk->clientid))->name;?></td>
						  <?php }?>
							<td><?=$workorderk->date;?></td>
							<td><?php if($workorderk->realstarttime!='' && $workorderk->realstarttime!=0){echo date("Y-m-d H:i:s",$workorderk->realstarttime);}else{echo '-';}?></td>
							<td>
							<?php if($workorderk->realendtime!='' && $workorderk->realendtime!=0){echo date("Y-m-d H:i:s",$workorderk->realendtime);}else{echo '-';}?>
							</td>
							<td><?php						  
						  if($workorderk->staffid!='' && $workorderk->staffid!=0)
						{
						  $user=User::model()->find(array('condition'=>'id='.$workorderk->staffid));
						  echo $user->name.' '.$user->surname;
						  }
						  else
						  {
							 $team=Staffteam::model()->find(array('condition'=>'id='.$workorderk->teamstaffid));
							echo $team->teamname;
							$staff=explode(',',$team->staff.',');
							$us=User::model()->find(array('condition'=>'id='.$team->leaderid));
							$u=$us->name.' '.$us->surname;
							for($i=0;$i<count($staff);$i++)
							{
								if($staff[$i]!='')
								{
									// echo $staff[$i];
									$us=User::model()->find(array('condition'=>'id='.$staff[$i]));
									if($us)
									{
									$u=$u.','.$us->name.' '.$us->surname;
									}
								}
							}
							echo '('.$u.')';
						  }
						  ?>
						  </td>
							<?php if($workorderk->cantscancomment=='' || $workorderk->cantscancomment=="null" || $workorderk->cantscancomment==null){echo '<td  bgcolor="green" class="td">'.t('Okutuldu').'</td>';}else{echo '<td class="td" bgcolor="red">'.t('Okutulmadı').'</td>';}?></td>
							<td><?php if($workorderk->cantscancomment!='null'){echo $workorderk->cantscancomment;}?></td>

                            
							
                          </tr><?php							
						  }
						  ?>
							
             			
                        </tbody>
                        <tfoot>
                     <tr>
						  <?php if($ax->firmid==0)
							{?>
							<th><?=t('Firm');?></th>
							<th><?=t('Firm Branch');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
						  <?php }?>

						   <?php if($ax->firmid!=0 && $ax->branchid==0)
							{?>
							<th><?=t('Firm Branch');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
						  <?php }?>

						   <?php if($ax->branchid!=0 && $ax->clientid==0)
							{?>
							<th><?=t('Client');?></th>
							<th><?=t('Client Branch');?></th>
						  <?php }?>

						  <?php if($ax->clientid!=0 && $ax->clientbranchid==0)
							{?>
							<th><?=t('Client Branch');?></th>
						  <?php }?>
							<th><?=t('Tarih-saat');?></th>
							<th><?=t('Real Start Time');?></th>
							<th><?=t('Real end Time');?></th>
							<th><?=t('Team/Personel');?></th>
							<th><?=t('Qr okutma');?></th>
							<th><?=t('Açıklama');?></th>

                            
							
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>


              </div>
            </div>
          </div>
   
        </section>
        <!-- // Full calendar events example section end -->
      </div>
	  <?php	 
								  $staff='';
								  if(isset($_POST['Workorder']['staff']) && $_POST['Workorder']['staff']!=''){
									  
									  // $staff=$_POST['Workorder']['staff'];
										// print_r($_POST['Workorder']['staff']);
										for($i=0;$i<count($_POST['Workorder']['staff']);$i++)
									  {
										if($i==0)
										  {
											$staff=$_POST['Workorder']['staff'][$i];
										  }
										  else
										  {
											 $staff=$staff.','.$_POST['Workorder']['staff'][$i];
										  }
									  }
								  }?>

<style>
.td{
color:#fff
}
</style>
<script>


$(document).ready(function() {


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
                columns: [ <?=$exel?>]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('MÜŞTERİ QR OKUTMA RAPORU')?> <?=$start.' - '.$finish;?>\n',
			messageTop:'<?//if(isset($_GET["id"]) && $_GET["id"]!=''){echo User::model()->table("clientbranch",$workorder->clientid);}?> \n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [<?=$exel?>]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('MÜŞTERİ QR OKUTMA RAPORU')?> <?=$start.' - '.$finish;?>\n',
			messageTop:' \n',
			/*action: function (e, dt, node, config)
			{
				//This will send the page to the location specified
				window.location.href = 'https://development.insectram.io/workorder/reportsexel?date=<?=$_POST["date"]?>&date1=<?=$_POST["date1"]?>&firmid=<?=$_POST["Workorder"]["firmid"]?>&branchid=<?=$_POST["Workorder"]["branchid"]?>&team=<?=$_POST["Workorder"]["team"]?>&staff=<?=$staff;?>&clientid=<?=$_POST["Workorder"]["clientid"]?>';
			}
			*/
        },



		
		{
             extend: 'pdfHtml5',
				 orientation: 'landscape',
                pageSize: 'LEGAL',
			 exportOptions: {
                columns: [ <?=$exel?>]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: '<?=t('MÜŞTERİ QR OKUTMA RAPORU')?> ',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t('MÜŞTERİ QR OKUTMA RAPORU')?> <?=$start.' - '.$finish;?>\n',
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
					text: '<?=t('MÜŞTERİ QR OKUTMA RAPORU')?> <?=$start.' - '.$finish;?>',
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
} );



$( "#stcolor" ).hide();


var firm='';
var branch='';
var staff='';
var team='';
var clientid='';
<?php if(isset($_POST['Workorder']['firmid'])){?>firm=<?=$_POST['Workorder']['firmid'];?>;<?php }?>
<?php if(isset($_POST['Workorder']['branchid']) && $_POST['Workorder']['branchid']!=''){?>branch=<?=$_POST['Workorder']['branchid'];?>;<?php }?>
<?php if($staff!=''){?>staff="<?=$staff;?>";<?php }?>
<?php if(isset($_POST['Workorder']['team']) && $_POST['Workorder']['team']!=''){?>team=<?=$_POST['Workorder']['team'];?>;<?php }?>
<?php if(isset($_POST['Workorder']['clientid']) && $clientk!=''){?>clientid="<?=$clientk;?>";<?php }?>

if(firm!='')
{
	$('#firm2').val(firm);
	$( "#branch2" ).prop( "disabled", false );
	$.post( "/workorder/firmbranch?id="+firm).done(function( data ) {
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		$('#branch2').val(branch);
		});
	
	
	if(branch!='')
	{
		
		
		
		$( "#team" ).prop( "disabled", false );
		$( "#staff" ).prop( "disabled", false );	
		
		
		//staff 
		$.post( "/workorder/staff?id="+branch).done(function( data ) {
			$('#staff').html(data);
			if(staff!=''){
				$('#staff').val(staff.split(','));
				$('#staff').select2('destroy');
				$('#staff').select2({
					closeOnSelect: false,
						 allowClear: true
				});
			}
			});
				//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
				
			$.post( "/workorder/staffteam?id="+branch).done(function( data ) {
				$('#team').html(data);
				$('#team').val(team);
			});

		$.post( "/workorder/client?id="+branch).done(function( data ) {
			

			$('#client').html(data);
				// $('#client').val(clientid);
				// alert(clientid);
				$('#client').val(clientid.split(','));
				$('#client').select2('destroy');
				$('#client').select2({
					closeOnSelect: false,
						 allowClear: true
				});


				$( "#client" ).prop( "disabled", false );
		});
		
		if(staff!='')
		{
			$( "#staff" ).prop( "disabled", false );
			$( "#team" ).prop( "disabled", true );
			$( "#stcolor" ).show();
			$('#labelcolor').html('Staff Color');
		}
		
		if(team!=0)
		{	
			$( "#team" ).prop( "disabled", false );
			$( "#staff" ).prop( "disabled", true );	
			$( "#stcolor" ).show();
			$('#labelcolor').html('Team Color');
		}

		
		
		
	}
}


<?php if($ax->firmid!=0 && !isset($_POST['Workorder']['firmid'])){?>
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
<?php }?>

<?php if($ax->branchid!=0 && !isset($_POST['Workorder']['firmid'])){?>

	$.post( "/workorder/staffteam?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#team" ).prop( "disabled", false );
			$('#team').html(data);
		});
		$.post( "/workorder/staff?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#staff" ).prop( "disabled", false );
			$('#staff').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});
		$.post( "/workorder/client?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#client" ).prop( "disabled", false );
			$('#client').html(data);
		});
<?php }?>


 
function finishdate(obj)
{
	//alert(obj);
	 $.post( "/workorder/aysonu?id="+obj).done(function( data ) {
		$( "#datetimefinish" ).prop( "disabled", false );
		$('#gzl').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}


function myfirm() 
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
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

function mybranch() 
{
		$.post( "/workorder/staffteam?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#team" ).prop( "disabled", false );
			$('#team').html(data);
		});
		$.post( "/workorder/staff?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#staff" ).prop( "disabled", false );
			$('#staff').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});
		$.post( "/workorder/client?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#client" ).prop( "disabled", false );
			$('#client').html(data);
		});
	
}





function searchteam()
{
	if(document.getElementById("team").value!=0)
	{
		$( "#staff" ).prop( "disabled", true );

		$.post( "/workorder/teamcolor?id="+document.getElementById("team").value).done(function( data ) {
			$( "#stcolor" ).show(500);
			$('#stcolor').html(data);
			$('#labelcolor').html('Team Color');
			
		});
	}
	else
	{
		$( "#staff" ).prop( "disabled", false );

		
	}
}
function searchstaff()
{
	if(document.getElementById("staff").value!='')
	{
		$( "#team" ).prop( "disabled", true );

		 var Secilenler = "";
            $('#staff :selected').each(function () {
                //Secilenler.push($(this).val());
                Secilenler += $(this).val() + ",";
            });
		
			Secilenler=Secilenler.substr(0,Secilenler.length-1)

			$( "#stcolor" ).show(500);

		$.post( "/workorder/staffcolor?id="+Secilenler).done(function( data ) {
			$('#stcolor').html(data);
			$('#labelcolor').html('Staff Color');
		});
	}
	else
	{
		$( "#team" ).prop( "disabled", false );
	}
}






<?php if($ax->branchid==0){?>
	$( "#route" ).prop( "disabled", true );
<?php }?>

<?php if($ax->firmid!=0){?>
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
<?php }?>










</script>	
	
	  

<style>




@media only screen and (max-width: 600px) {
  .fc-prev-button
	{
		width: 50%;
	}
.fc-next-button
	{
		width: 50%;
	}
.fc-today-button
	{
		width: 100%;
		margin-bottom: 3px !important;
	}
.fc-left{
	width: 100%;
}

.fc-button-group{
	width: 100%;
    margin-bottom: 3px;
}

.fc .fc-toolbar>*>* {
    margin-left: 0; 
}
}




</style>


<?php }?>
<?php
///Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/vendors.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/extensions/moment.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/extensions/fullcalendar.min.js;';
  

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/vendors.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/calendars/fullcalendar.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/plugins/calendars/fullcalendar.css;';

 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
//Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

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

