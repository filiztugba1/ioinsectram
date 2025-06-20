<?php
User::model()->login();
$ax= User::model()->userobjecty('');






			$label='';
			$i=0;
			$acikuy='';
			$bekleyenuy='';
			$kapaliuy='';
			$toplam='';
			$userrr=$ax->id;
			if(isset($_POST['user']))
			{
				$userrr=$_POST['user'];
			}

			$startdate=strTotime("01.01.2019");
			$finishdate=time();

			if(isset($_POST['startdate']))
			{
				 $startdate=strTotime($_POST['startdate'].' 00:00:00');
			}

			if(isset($_POST['finishdate']))
			{
				  $finishdate=strTotime($_POST['finishdate'].' 23:59:59');
			}

/*
			if(($ax->type==26 || $ax->type==22) && (!isset($_POST['user']) || $_POST['user']=="0"))
				{

					$userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ax->clientbranchid));
					if($ax->type==22)
					{
						$userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid!=0"));

					}
				}
				else
				{

					$userss=User::model()->findAll(array("condition"=>"id=".$userrr));

				}

*/










 // if (Yii::app()->user->checkAccess('conformityuserassign.view')){
 if (1==1){ ?>
	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity','',0,'conformity');?>

  <section id="chartjs-bar-charts">

          <!-- Column Chart -->
          <div class="row">
            <div class="col-12">
              <div class="card">
			  <div class='card-header'>
			   <div class="col-xl-12 col-lg-12 col-md-12 mb-1" style='background:#e0ebff;padding:12px 10px 12px 0px;    border-radius: 5px;'>
							 <form id="conformity-form" action=""  method="post" enctype="multipart/form-data"onsubmit="submitForm(event)">
							 <div class="col-xl-12 col-lg-12 col-md-12 row">

								<input type='hidden' id='grafik' name='grafik'/>
<?php if($ax->type==22){?>
								<div class="col-md-3">
									<label for="basicSelect"><?=t('Client Branch');?></label>
										<fieldset class="form-group">
										<!--	<select class="select2-placeholder-multiple form-control" style="width:100%" name="user">
												<option value='0'><?=t("All");?></option>
												<?/*
												if($ax->type==26)
												{
													$userssh=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ax->clientbranchid));
												}
												else if($ax->type==27)
												{
													$userssh=User::model()->findAll(array("condition"=>"id=".$ax->id));

												}
												else if($ax->type==22)
												{
													$userssh=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid!=0"));
												}

												foreach($userssh as $userssxk)
												{?>

													<option <?php if(isset($_POST['user'])){
														if($userssxk->id==$_POST['user']){echo "selected";}}?> value="<?=$userssxk->id;?>">
														<?php if($userssxk->name=='' && $userssxk->surname==''){
															echo $userssxk->username;
														}else{
															echo $userssxk->name.' '.$userssxk->surname;}?>
														</option>
												<?php }
												*/?>
											</select>
										-->
										<select class="select2" style="width:100%" id="atananClient" name='cbid'>
											<?php											$atamaclient=Client::model()->findall(array('condition'=>'parentid='.$ax->clientid.' order by name asc'));
											$sayac=0;
											$ilkclient=0;
											 foreach($atamaclient as $atamaclients){?>
												 <option <?php if((!isset($_POST['cbid'])&& $sayac==0) || (isset($_POST['cbid']) && $_POST['cbid']==$atamaclients->id)){echo "selected";$ilkclient=$atamaclients->id;}?> value="<?=$atamaclients->id;?>"><?=$atamaclients->name;?></option>
											 <?php											 $sayac++;
										 }?>
										</select>
										</fieldset>
								</div>
								<?php }?>

								<?php								
								if($ax->type==26)
								{
									$userss=User::model()->findAll(array("condition"=>"(firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ax->clientbranchid.') or id in (select recipientuserid from conformityuserassign where senderuserid='.$ax->id.')'));
							
									// $userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ax->clientbranchid));
								}
								else if($ax->type==27)
								{
									$userss=User::model()->findAll(array("condition"=>"id=".$ax->id));

								}
								else if($ax->type==22)
								{
									$userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid));
								
								
									// $userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ilkclient));
								}
								foreach($userss as $userssx)
								{
								//	$userlar.push($userssx->id);
									$aciksay=0;
									$kapalisay=0;
									$bekliyorsay=0;

									// $conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"id desc","group"=>"conformityid"));
									// echo "recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate;
									// $conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"id desc"));
									$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"id desc"));
									if(count($conformityuserassign)!=0)
									{
									foreach($conformityuserassign as $conformityuserassignx)
									{
										$conformity=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid,"order"=>"id desc"));

										$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
										$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
										
										if(!$gerigonderme)
										{
											
											$status=$conformity->statusid;
											if(in_array($status,[2,3,4,6]))
											{
												$bekliyorsay++;
											}
											if(in_array($status,[5]))
											{
												$aciksay++;
											}
											if(in_array($status,[1]))
											{
												$kapalisay++;
											}
										}
										// if(!$gerigonderme && !$deadlineverme)
										// {
											// $aciksay++;
										// }

										// if(!$gerigonderme && $deadlineverme)
										// {
											// $kapalisay++;
										// }
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
										$bekleyenuy=$bekliyorsay;
										$toplam=$aciksay+$kapalisay+$bekliyorsay;
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
										$bekleyenuy=$bekleyenuy.','.$bekliyorsay;
										$top=$aciksay+$kapalisay+$bekliyorsay;
										$toplam=$toplam.','.$top;
									}
									}


									$i++;

								}

								?>

								<div class="col-md-3">
									<fieldset class="form-group">
									<label for="basicSelect"><?=t('Start Date');?></label>
									  <input type="date"  class="form-control"  placeholder="<?=t('Start Date');?>" name="startdate" id="startdate" value="<?php if(isset($_POST['startdate'])){echo $_POST['startdate'];}else{echo '2019-01-01';}?>">
									</fieldset>
								</div>

								<div class="col-md-3">
									<fieldset class="form-group">
									<label for="basicSelect"><?=t('Finish Date');?></label>
									  <input type="date"  class="form-control"  placeholder="<?=t('Finish Date');?>" name="finishdate" id="finishdate" value="<?php if(isset($_POST['startdate'])){echo $_POST['finishdate'];}else{echo date('Y-m-d');}?>">
									</fieldset>
								</div>

								<div class="col-md-3">
								<label for="basicSelect" style='margin: 11px;'></label>
									<fieldset class="form-group">

									<div class="input-group-append" id="button-addon2" style="float:left">
												<button class="btn btn-primary"  type="submit"><?=t('Search');?></button>
											</div>
									</fieldset>
								</div>





						</div>
						</form>
					</div>
			  </div>

                <div class="card-header ">
                 <h4 class="card-title"><?=t("Atanan Uygunsuzluk Grafik");?></h4>
								 	<div class="col-md-2 text-right" style="float:right"><a onclick="printDiv(x)" class=""><i class="fa fa-save"></i></a></div>

                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show col-<?php if(($ax->type==26 && isset($_POST['user']) && $_POST['user']!='0')|| ($ax->type!=26 && $ax->type!=22)){echo "6";}else{echo "12";}?>">
                  <div class="card-body" id='cartcolumn'>
                    <canvas id="column-chart" height="300"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Bar Stacked Chart -->


        </section>


				<!--uygunsuzluk atama raporu başlangıc-->
				<section id="html5">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="row" style="border-bottom: 1px solid #e3ebf3;">
										 <div class="col-xl-7 col-lg-9 col-md-9 mb-1">
										 <h4 class="card-title"><?=t('Açık ve kapalı uygunsuzluk raporu')?></h4>
										</div>
									</div>
								</div>
								<div class="card-content collapse show">
									<div class="card-body card-dashboard">
											<table  class="table table-striped table-bordered dataex-html5-export2 table-responsive">
												<thead>
													<tr>

														<th><?=t('ATANAN YETKİLİ ADI');?></th>
														<th><?=t('NON-CONFORMITY NO');?></th>
														<th><?=t('DEPARTMENT');?></th>
														<th><?=t('SUB-DEPARTMENT');?></th>
														<th><?=t('TANIM');?></th>
														<th><?=t('ÖNERİ');?></th>
														<th><?=t('ÖNCELİK');?></th>
														<th><?=t('UYGUNSUZLUK ATAMA TARİHİ');?></th>
														<th><?=t('Açık Uygunsuzluk')?></th>
														<th><?=t('Bekleyen Uygunsuzluklar');?></th>
														<th><?=t('Kapalı Uygunsuzluk');?></th>
													 <!--	<th>Atanan Yetkili Adı</th>
													 	<th>Uygunsuzluk Atama Tarihi</th>
														<th>Açık Uygunsuzluk</th>
														<th>Kapalı Uygunsuzluk</th>
														<th>Toplam Uygunsuzluk</th>
													-->
													</tr>
												</thead>
												<tbody id='waypointsTable'>
													<?php													$useridd=$userss[0]->id;
													$say=0;
													foreach($userss as $userssx)
													{

														$aciksay=0;
														$kapalisay=0;
														$bekliyorsay=0;
														
														$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"sendtime asc","group"=>"conformityid"));
														$say+= count($conformityuserassign);
														
														if(count($conformityuserassign)!=0)
														{
															$uygunsuzlukBas='';
															
															$acikUygunsuzluklarTr='';
															$bekliyenUygunsuzluklarTr='';
															$kapaliUygunsuzluklarTr='';
															foreach($conformityuserassign as $conformityuserassignx)
															{
																$conformity=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid,"order"=>"id desc"));

																$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
																$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
		
																	if(!$gerigonderme)
																	{
																		$conformityname=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid));
																		$status=intval($conformity->statusid);
																		
																		$uygunsuzlukBas.="<tr>";
																			$uygunsuzlukBas.="<td>".(($userssx->name=='' && $userssx->surname=='')?$userssx->username:$userssx->name.' '.$userssx->surname)."</td>";
																			$uygunsuzlukBas.="<td>".$conformityname->numberid."</td>";
																			$depart=Departments::model()->find(array('condition'=>'id='.$conformityname->departmentid));
																			
																			$uygunsuzlukBas.="<td>".($depart?$depart->name:'-')."</td>";
																			if($conformityname->subdepartmentid!=='' && $conformityname->subdepartmentid!==null)
																			{
																						$subdepart=Departments::model()->find(array('condition'=>'id='.$conformityname->subdepartmentid));
																					$uygunsuzlukBas.="<td>".($subdepart?$subdepart->name:'-')."</td>";
																				
																			}
																			$uygunsuzlukBas.="<td>".$conformityname->definition."</td>";	
																			$uygunsuzlukBas.="<td>".$conformityname->definition."</td>";	
																			$uygunsuzlukBas.="<td>".$conformityname->suggestion.' '.t('Degree')."</td>";	
																			$uygunsuzlukBas.="<td>".date('d-m-Y',$conformityuserassignx->sendtime)."</td>";
																			
																		if(in_array($status,[5]))
																		{
																			$aciksay++;
																				
																			$uygunsuzlukBas.="<td>1</td>";	
																			$uygunsuzlukBas.="<td>0</td>";	
																			$uygunsuzlukBas.="<td>0</td>";
																		}
																		if(in_array($status,[2,3,4,6]))
																		{
																			$bekliyorsay++;
																			$uygunsuzlukBas.="<td>0</td>";	
																			$uygunsuzlukBas.="<td>1</td>";	
																			$uygunsuzlukBas.="<td>0</td>";
																		}
																		
																			if(in_array($status,[1]))
																			{
																				$kapalisay++;
																				$uygunsuzlukBas.="<td>0</td>";	
																					$uygunsuzlukBas.="<td>0</td>";
																					$uygunsuzlukBas.="<td>1</td>";	
																			}
																			
																			$uygunsuzlukBas.="</tr>";
																	}
															}
															$acikuy1=$aciksay;
															$bekleyenuy1=$bekliyorsay;
															$kapaliuy1=$kapalisay;
															$toplam1=$aciksay+$kapalisay+$bekleyenuy1;
															echo $uygunsuzlukBas;
														
														?>
															<tr>
																<td style="color: red;"><?php if($userssx->name=='' && $userssx->surname==''){echo $userssx->username;}else{echo $userssx->name.' '.$userssx->surname;}?><?=' '.t('Toplam');?></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td style="color: red;"><?=$acikuy1;?></td>
																<td style="color: red;"><?=$bekleyenuy1;?></td>
																<td style="color: red;"><?=$kapaliuy1;?></td>
															</tr>
															<?php														}
															
															
															
													}
/*													
													foreach($userss as $userssx)
													{
														$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"id desc","group"=>"conformityid"));
														if(count($conformityuserassign)>0)
														{
														?><tr>
															<td style="width=100px">

															<?php															$aciksay=0;
															$kapalisay=0;


															foreach($conformityuserassign as $conformityuserassignx)
															{
																$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
																$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));



																if(!$gerigonderme && !$deadlineverme)
																{
																	$conformityname=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid));
																	echo $conformityname->numberid.' <br> ';
																}
																if(!$gerigonderme && $deadlineverme)
																{
																	$conformityname=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid));
																	echo $conformityname->numberid.' <br> ';
																}

															}
																if(count($conformityuserassign)==0){echo '-';}
															?></td>
															<td><?php if($userssx->name=='' && $userssx->surname==''){echo $userssx->username;}else{echo $userssx->name.' '.$userssx->surname;}?></td><?php															?><td><?php														foreach($conformityuserassign as $conformityuserassignx)
														{
															$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
															$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
															if(!$gerigonderme && !$deadlineverme)
															{
																$aciksay++;
																echo date('d-m-Y',$conformityuserassignx->sendtime).' <br> ';
															}

															if(!$gerigonderme && $deadlineverme)
															{
																$kapalisay++;
																echo date('d-m-Y',$conformityuserassignx->sendtime).' <br> ';
															}


														}
														if(count($conformityuserassign)==0){echo '-';}
													?></td><?php


															$acikuy1=$aciksay;
															$kapaliuy1=$kapalisay;
															$toplam1=$aciksay+$kapalisay;


														?>
														<td><?=$acikuy1;?></td>
														<td><?=$kapaliuy1?></td>
														<td><?=$toplam1;?></td>
														<?php

														$i++;

												?></tr><?	}}

												*/?>
												</tbody>
												<tfoot>
													<tr>

														<th><?=t('ATANAN YETKİLİ ADI');?></th>
														<th><?=t('NON-CONFORMITY NO');?></th>
														<th><?=t('DEPARTMENT');?></th>
														<th><?=t('SUB-DEPARTMENT');?></th>
														<th><?=t('TANIM');?></th>
														<th><?=t('ÖNERİ');?></th>
														<th><?=t('ÖNCELİK');?></th>
														<th><?=t('UYGUNSUZLUK ATAMA TARİHİ');?></th>
														<th><?=t('Açık Uygunsuzluk')?></th>
														<th><?=t('Bekleyen Uygunsuzluklar');?></th>
														<th><?=t('Kapalı Uygunsuzluk');?></th>
													</tr>
												</tfoot>
											</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- uygunsuzluk atama raporu bitiş-->

	 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-7 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('Atama yapılan açık ve kapalı uygunsuzluk raporu');?></h4>
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
							<th><?=t('CLOSED TIME');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('NON-CONFORMITY TYPE');?></th>



							<th><?=t('DEFINATION');?></th>

							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>



                          </tr>
                        </thead>
                        <tbody id='waypointsTable'>


					 		<?php
							$ux=$ax->id;
							if(isset($_POST['user']))
							{
									$ux=$_POST['user'];
							}


							$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$ux." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"id desc","group"=>"conformityid"));

							foreach($conformityuserassign as $conformityuserassignx){



							$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
							$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));

							if(!$gerigonderme)
							{
							$conformityx=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid));
							$depart=Departments::model()->find(array('condition'=>'id='.$conformityx['departmentid'],));
							if ($depart){ $depart=$depart->name;
							$subdep=Departments::model()->find(array('condition'=>'id='.$conformityx['subdepartmentid'],))->name;
							}else{
							$depart='-';
							$subdep='-';

							}
								?>

						   <?$status=Conformitystatus::model()->find(array('condition'=>'id='.$conformityx['statusid']));?>
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


								 <?=date('Y-m-d',$conformityx['date']);?>
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




								<td><?=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformityx->id,))->nokdefinition;?></td>
								<td><?=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$conformityx->id,))->activitydefinition;?></td>




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


						<?php }
							}?>


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
							<th><?=t('CLOSED TIME');?></th>
							<th><?=t('STATUS');?></th>
							<th><?=t('NON-CONFORMITY TYPE');?></th>



							<th><?=t('DEFINATION');?></th>

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

				<!--form baslangıç-->
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

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- delete all finish -->

<?php }
?>
<?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/plugins/echarts/echarts-all.js;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.js;';

?>
<style>
#waypointsTable tr:hover {
    background-color:#ccdcf7;
}
</style>

<script>

    function submitForm(event) {
		event.preventDefault();
        // Girilen tarihleri al
       
        
        	$.post( "/conformityuserassign/control?startdate="+document.getElementById('startdate').value).done(function( data ) {
					 // Tarih karşılaştırması yap
				if (+data==1) {
					// Girilen tarihler şimdiki tarihten küçükse, kullanıcıya uyarı ver
					if (!confirm("Başlangıç tarihinden önce atanan ve kapanmayan uygunsuzluk var, yine de bu tarih aralığında rapor almak istiyor musunuz?")) {
						// Kullanıcı devam etmek istemiyorsa formu gönderme
						return false; 
					}
					else
					{
						 // Kullanıcı devam etmek istiyorsa formu gönder
					document.getElementById('conformity-form').submit();
					}
				}
				else
				{
					 // Kullanıcı devam etmek istiyorsa formu gönder
					document.getElementById('conformity-form').submit();
				}
			});
      
	   
		 return false; 
        
       
    }






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




function printDiv(divName) {



			html2canvas(document.querySelector('#cartcolumn')).then(function(canvas) {

					console.log(canvas);
					saveAs(canvas.toDataURL(), 'grafik-tablo.png');
			});



	function saveAs(uri, filename) {

			var link = document.createElement('a');

			if (typeof link.download === 'string') {

					link.href = uri;
					link.download = filename;

					//Firefox requires the link to be in the body
					document.body.appendChild(link);



					//simulate click
					link.click();

					//remove the link when done
					document.body.removeChild(link);

			} else {

					window.open(uri);

			}
	 }
 }


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
        }
    };

    // Chart Data
    var chartData = {


        labels: [<?=$label;?>],


           datasets: [{
            label: "<?=t('Açık Uygunsuzluk')?>",
            data: [<?=$acikuy;?>],
            backgroundColor: "#16D39A",
            hoverBackgroundColor: "rgba(22,211,154,.9)",
            borderColor: "transparent",
        }
		, 
		{
            label: "<?=t('Bekleyen Uygunsuzluklar')?>",
            data: [<?=$bekleyenuy;?>],
            backgroundColor: "#ffa700",
            hoverBackgroundColor: "rgba(226, 98, 40, 1)",
            borderColor: "transparent"
        },{
            label: "<?=t('Kapalı Uygunsuzluk')?>",
            data: [<?=$kapaliuy;?>],
            backgroundColor: "#dc0000",
            hoverBackgroundColor: "rgba(226, 98, 40, 1)",
            borderColor: "transparent"
        },
			 {
            label: "<?=t('Toplam Uygunsuzluk')?>",
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

$('.dataex-html5-export2').DataTable( {
    dom: 'Bfrtip',
	"search": {
    "caseInsensitive": true
	},
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
                columns: [ 0,1,2,3,4,5,6,7,8,9]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			fileName:'Atanan_Uygunsuzluk_Raporu-<?=date('d/m/Y',$startdate);?>-<?=date('d/m/Y',$finishdate);?>',
			title:'Atanan Uygunsuzluk Raporu',
			messageTop:'<?=date('d/m/Y',$startdate);?> - <?=date('d/m/Y',$finishdate);?>'
        },
        // {
            // extend: 'excelHtml5',
            // exportOptions: {
               // columns: [ 0,1,2,3,4,5,6,7,8,9]
            // },
			// text:'<?=t('Excel');?>',
			// className: 'd-none d-sm-none d-md-block',
				// title:'ATANAN UYGUNSUZLUK RAPORU',
				// action: function ( e, dt, node, config ) {
									 // /* window.location = '/conformity/print'; */

					// var formdata= $("#conformity-form").serialize();
					// var formElement = document.getElementById("conformity-form");

					// formElement.target="_blank";
					// formElement.action="<?=Yii::app()->getbaseUrl(true)?>/conformityuserassign/excel/";


					// formElement.submit();

					// formElement.target="";
					// formElement.action="/conformityuserassign/reports";

					// //    var request = new XMLHttpRequest();
				// },
			// messageTop:'<?=date('d/m/Y',$startdate);?> - <?=date('d/m/Y',$finishdate);?>'
		 // },
		   {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3,4,5,6,7,8,9,10]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Açık ve kapalı uygunsuzluk raporu');?> (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
		 },
		 
		 
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7,8,9]
            },
				   text:'<?=t('PDF');?>',
			  	title:'Atanan_Uygunsuzluk_Raporu-<?=date('d/m/Y',$startdate);?>-<?=date('d/m/Y',$finishdate);?>',

								  action: function ( e, dt, node, config ) {
					                   /* window.location = '/conformity/print'; */

										var formdata= $("#conformity-form").serialize();
										var formElement = document.getElementById("conformity-form");

										html2canvas(document.querySelector('#cartcolumn')).then(function(canvas) {
												//saveAs(canvas.toDataURL(), 'grafik-tablo.png');
												console.log(canvas.toDataURL());
												document.getElementById("grafik").value=grafikResim;
												formElement.target="_blank";
												formElement.action="<?=Yii::app()->getbaseUrl(true)?>/conformityuserassign/print/";


												formElement.submit();

												formElement.target="";
												formElement.action="/conformityuserassign/reports";
										});

										//    var request = new XMLHttpRequest();
					                },
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'ATANAN UYGUNSUZLUK RAPORU',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: ' \n',
					bold: true,
					fontSize: 12,
						alignment: 'center'
				  },

						{
					text: '<?=date('d/m/Y',$startdate);?> - <?=date('d/m/Y',$finishdate);?>',
					bold: true,
					fontSize: 11,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]

				});
			  }

        },
        'colvis',
		'pageLength',

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



var grafikResim='';

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


  Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/vendors.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/chart.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/core/app-menu.js;';



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
