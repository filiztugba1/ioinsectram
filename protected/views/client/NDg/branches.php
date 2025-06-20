<?php
User::model()->login();


?>

<?php if (Yii::app()->user->checkAccess('client.branch.detail.view')) { ?>

	<?= User::model()->geturl('Client', 'Branch Homepage', $getidx, 'client', 0, $ax->branchid); ?>


	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				<div class="card-header" style="">
					<ul class="nav nav-tabs">

						<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')) { ?>
							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/branchstaff?id=<?= $getidx; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect2" style="font-size: 15px;">
										<? $say = User::model()->findAll(array('condition' => 'clientbranchid=' . $getidx));
										echo count($say); ?>
									</span><?= t('Staff'); ?>

								</a>
							</li>
						<?php } ?>
						<?php if (Yii::app()->user->checkAccess('client.branch.department.view')) { ?>
							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/departments?id=<?= $getidx; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect2"
										style="font-size: 15px;"><?php echo count($department); ?></span><?= t('Departments'); ?></a></a>
							</li>
						<?php } ?>
						<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')) { ?>
							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/monitoringpoints?id=<?= $getidx; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect2"
										style="font-size: 15px;"><?php echo count($monitoring); ?></span><?= t('Monitoring Points'); ?></a></a>
							</li>
						<?php } ?>
						<?php if (Yii::app()->user->checkAccess('client.branch.reports.view')) { ?>

							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/reports?id=<?= $getidx; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o"
											style="font-size: 15px;"></i></span><?= t('Reports'); ?></a></a>
							</li>
						<?php } ?>
						<?php if (Yii::app()->user->checkAccess('client.branch.offers.view')) { ?>

							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/offers?id=<?= $getidx; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o"
											style="font-size: 15px;"></i></span><?= t('Offers'); ?></a></a>
							</li>
						<?php } ?>
						<li class="nav-item">
							<a class="nav-link" href="<?= Yii::app()->baseUrl ?>/client/visitreports/<?= $_GET['id']; ?>"><span
									class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o"
										style="font-size: 15px;"></i></span><?= t('Visit Reports'); ?></a></a>
						</li>
						<?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')) { ?>

							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/files2?id=<?= $getidx; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o"
											style="font-size: 15px;"></i></span><?= t('File Management'); ?> </a></a>
							</li>
						<?php } ?>

						<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
						<li class="nav-item">
							<a class="nav-link" href="/client/clientqr?id=<?= $getidx; ?>" target="_blank"><span
									class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode"
										style="font-size: 15px;"></i></span><?= t('Client QR'); ?> </a></a>
						</li>
						<?//} ?>
						<?php
						//		if (($ax->id==0||$ax->id==317||$ax->id==588)){ 
						?>
						<?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.update')) { ?>

							<li class="nav-item">
								<a class="nav-link" href="/client/maps?id=<?= $getidx; ?>"><span class="btn-effect"
										style="font-size: 15px;"><i class="fa fa-map"
											style="font-size: 15px;"></i></span><?= t('Haritalar'); ?> </a></a>
							</li>
						<?php } else {
							?>

							<li class="nav-item">
								<a class="nav-link" href="/client/mapsuser?id=<?= $getidx; ?>"><span class="btn-effect"
										style="font-size: 15px;"><i class="fa fa-map"
											style="font-size: 15px;"></i></span><?= t('Haritalar'); ?> </a></a>
							</li>
						<?php }

						//}
						?>

					</ul>
				</div>


				<div class="col-xl-12 col-lg-12 col-md-12">

					<div class="col-xl-12 col-lg-12 col-md-12 ">


						<?php			//php döngü başla
						
							if (isset($_POST['client'])) {
								if (!is_numeric($_GET['branchid'])) {
									echo 'no';
									exit;
								}


								$json = json_encode($_POST['clientsett']);

								foreach ($_POST['client'] as $id => $item) {
									if (!is_numeric($id)) {
										echo 'no';
										exit;
									}
									$financial = Financialsettings::model()->find(array('condition' => 'clientbranch_id=' . $id));

									if ($financial) {
										$financial->updated_time = time();
									} else {

										$financial = new Financialsettings;
										$financial->created_time = time();
									}


									$financial->clientbranch_id = $id;
									$financial->contract_start_date = $item['contratstartdate'];
									$financial->contract_end_date = $item['contratenddate'];
									$financial->vat = $item['vat'];

									$financial->joint_period = $item['freetype'];
									$financial->joint_limit = $item['maxtotfree'];
									$financial->json_data = $json;
									if ($financial->save()) {
										echo 'ok';
									} else {
										echo 'no';
									}

								}

								exit;
							}
							$ax = User::model()->userobjecty('');
							if (isset($_GET['firmid']) && $_GET['firmid'] != 0) {
								$ax->branchid = $_GET['firmid'];
							}


							$parentid = Client::model()->find(array('condition' => 'id=' . $_GET['id'], ));


							$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id']));
							$transferclient = 0;
							$countries = Country::model()->findAll();
							$client = Client::model()->findAll(array(
								#'select'=>'',
								#'limit'=>'5',
								'order' => 'name ASC',
								'condition' => 'id=' . $_GET['id'] . ' and isdelete=0 and (firmid=' . $clientview->firmid . ' or mainfirmid=' . $clientview->firmid . ')' . (isset($isActive) && $isActive != 0 ? ' and active=' . (isset($isActive) && intval($isActive) == 1 ? 1 : 0) : ''),
							));

							foreach ($client as $clientrow) {
								//echo 'xxx';
								if ($clientrow->id <> $_GET['id'])
									continue;
								$financial = Financialsettings::model()->find(array('condition' => 'clientbranch_id=' . $clientrow->id));

								if ($financial) {

								} else {
									$financial = new Financialsettings;
									$financial->clientbranch_id = $clientrow->id;
									$financial->contract_start_date = '';
									$financial->contract_end_date = '';
									$financial->vat = '';
									$financial->joint_period = '';
									$financial->joint_limit = '';
									$financial->json_data = '';
								}


								$type = Visittype::model()->findall(array('condition' => 'firmid=0 or (firmid=' . $ax->firmid . ' and branchid=' . $clientview->firmid . ')' . ' or ( firmid=' . $ax->firmid . ' and branchid=0 ) order by id = 25 desc, id=75 desc, id=26 desc, id=62 desc, id=31 desc, id=76 desc, id=32 desc, id=41 desc, id=60 desc  '));



								?>




							<!-- buradan başladık -->


							<table class="table table-bordered">
								<thead>
									<tr>
										<th> <span id="dates" style=" font-size:13px !important; text-align:center;"></span>
										<th colspan="2"
											style="background:#def4ff; font-size:13px !important; text-align:center;">
											<?= t('Service Specifications') ?></th>

										<th colspan="2"
											style="background:#dfdeff; font-size:13px !important; text-align:center;">
											<?= t('Workorder Scheduling') ?></th>
										<!--  <th>Unit Price</th>
						  <th>Total</th>-->
									</tr>
									<tr>
										<th><?= t('Visit Type') ?></th>
										<th style="background:#def4ff;"><?= t('Contract Period') ?></th>
										<th style="background:#def4ff;"><?= t('Contracted Visits') ?></th>
										<th style="background:#dfdeff;"><?= t('Planned Visits') ?></th>
										<th style="background:#dfdeff;"><?= t('Completed Visits') ?></th>
										<!--  <th>Unit Price</th>
						  <th>Total</th>-->
									</tr>

								</thead>
								<tbody>
									<?php $grandtotal = 0;
									$basilanlar = [];
									
									foreach ($type as $typex) {

										$visitperiod = '';
										$visitnumber = '0';
										$unitprice = '';
										$freecreditperiod = '';
										$freecreditinayear = '';
										if ($financial->json_data <> '' && json_decode($financial->json_data)) {
											$jsondata = json_decode($financial->json_data, true);

											if (isset($jsondata[$financial->clientbranch_id][$typex->id]['visitperiod'])) {
												$visitperiod = $jsondata[$financial->clientbranch_id][$typex->id]['visitperiod'];
											}
											if (isset($jsondata[$financial->clientbranch_id][$typex->id]['visitnumber'])) {
												$visitnumber = $jsondata[$financial->clientbranch_id][$typex->id]['visitnumber'];
											}
											if (isset($jsondata[$financial->clientbranch_id][$typex->id]['unitprice'])) {
												$unitprice = $jsondata[$financial->clientbranch_id][$typex->id]['unitprice'];
											}
											if (isset($jsondata[$financial->clientbranch_id][$typex->id]['freecreditperiod'])) {
												$freecreditperiod = $jsondata[$financial->clientbranch_id][$typex->id]['freecreditperiod'];
											}
											if (isset($jsondata[$financial->clientbranch_id][$typex->id]['freecreditinayear'])) {
												$freecreditinayear = $jsondata[$financial->clientbranch_id][$typex->id]['freecreditinayear'];
											}
											//   print_r($jsondata);exit;
											$monthssett = 0;
											if (isset($jsondata[$financial->clientbranch_id][$typex->id]['month'])) {
												foreach ($jsondata[$financial->clientbranch_id][$typex->id] as $itemx) {
													//print_r($itemx);
													if (is_array($itemx)) {
														foreach ($itemx as $itemx1) {

															if (is_numeric($itemx1)) {
																$monthssett = $monthssett + $itemx1;
															}

														}
													}
												}

											}

										}
										if ($visitnumber == '') {
											$visitnumber = 0;
										}
										if ($unitprice == '') {
											$unitprice = 0;
										}


										if (isset($selectedmonth) && $financial->contract_start_date > $selectedmonth) {
											$selectedmonth = $financial->contract_start_date;
										}
										else{
											$selectedmonth = $financial->contract_start_date;
										}

										$start_date = $financial->contract_start_date;
										//$start_date=$selectedmonth;
										$start_time = strtotime($start_date . ' 00:00:00');



										$start_datex = new DateTime($selectedmonth);
										$start_datex->modify('last day of this month');
										if ($start_datex->format("Y-m-d") > $financial->contract_end_date) {
											$end_date = $financial->contract_end_date;
										} else {
											$end_date = $start_datex->format("Y-m-d");

										}
										$end_date = $financial->contract_end_date;
										$end_time = strtotime($end_date . ' 23:59:59');



										//   echo 'status>0 and date>="'.$financial->contract_start_date.'"  and date>="'.$start_date.'" and date<="'.$start_datex->format("Y-m-d").'" and date<="'.$financial->contract_end_date.'" and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc ';exit;
										$plannedworkorder = Workorder::model()->findAll(array('condition' => 'status>=0 and  date>="' . $financial->contract_start_date . '" and date<="' . $financial->contract_end_date . '"  and (clientid=' . $financial->clientbranch_id . ') and visittypeid=' . $typex->id . ' ORDER BY date asc '));
										$closedworkorder = Workorder::model()->findAll(array('condition' => 'status=3 and realendtime>="' . $start_time . '" and realendtime<="' . $end_time . '" and (clientid=' . $financial->clientbranch_id . ') and visittypeid=' . $typex->id . ' ORDER BY date asc '));
										$plannedworkordercount = 0;
										foreach ($plannedworkorder as $workorderp) {
											$plannedworkordercount++;
										}
										$closedworkordercount = 0;
										foreach ($closedworkorder as $workorderp) {
											$closedworkordercount++;
										}

										if ($plannedworkordercount == 0 && $closedworkordercount == 0 && ($visitnumber == '' || $visitnumber == 0) && $monthssett == 0)
											continue; // hiç bir şey yoksa kalabalık etmeden geçiyoruz
							
										$total = $unitprice * $closedworkordercount;
										$grandtotal += $total;
										$thisclass = '';
										if ($plannedworkordercount > $closedworkordercount) {
											//   $thisclass='table-danger';
										}

										$basilanlar[] = [t($typex->name), number_format($unitprice, 2), $closedworkordercount, number_format(($total) * 1, 2)];
										?>

										<tr class="<?= $thisclass ?>" id="visittype<?= $typex->id; ?>">
											<td> <?= t($typex->name); ?></td>
											<td><?= ucfirst($visitperiod) ?> / <?= $visitnumber ?> </td>
											<td> <? echo $monthssett; ?></td>
											<td><?= $plannedworkordercount ?> 			<?= t('Planned') ?></td>
											<td><?= $closedworkordercount ?> 			<?= t('Completed') ?></td>
											<!--  <td>£<?= number_format($unitprice, 2) ?></td>
						  <td>£<?= number_format(($total) * 1, 2) ?></td> -->
										</tr>
									<?php

									}
									?>
									<!--   <tr>
					   <td>Total</td>
						   <td></td>
						   <td></td>
						   <td></td>
						   <td></td>
						   <td></td>
						  <td><b>£<?= number_format(($grandtotal) * 1, 2) ?></b></td>
				   
						</tr> -->
								</tbody>
							</table>
							<script>
								$('#dates').html('Contract Dates:  <?= $selectedmonth ?> - <?= $end_date ?> ');

							</script>

						<?php }
							//php döngü bit
							?>


					</div>


					<?php $clientview = Client::model()->find(array('condition' => 'id=' . $getidx, )); ?>









					<!-- client noncomf list -->


				</div>
			</div> <!-- var -->
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card" style="padding:25px;">
				<?php

				if (isset($_POST['notes'])) {
					$logdata = clone $clientview;

					$clientview->branch_notes = $_POST['notes'];
					$clientview->save();

					LogsNew::model()->logsaction($logdata, 'Note:' . $_POST['notes']);
				}
				if ($ax->clientid == 0 && $ax->clientbranchid == 0 && $ax->mainclientbranchid == 0) {
					?>

					<form method="POST">
						<label for="notes"><?= t('Notes') ?></label><br>
						<textarea id="notes" name="notes" rows="4"
							style="width:400px"><?= $clientview->branch_notes ?></textarea><br>
						<button class="btn btn-primary" type="submit"><?= t('Save') ?></button>
					</form>
				<?php }
				?>


			</div>
		</div>
	</div>


	<?php


	$client = Client::model()->findAll(array(
		#'select'=>'',
		#'limit'=>'5',
		'order' => 'name ASC',
		'condition' => 'isdelete=0',
	));
	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$where = "clientid=" . $_GET['id'];

	}

	$conformity = Conformity::model()->findAll(array('condition' => $where, 'order' => 'date desc', 'limit' => 5));


	if ($ax->mainclientbranchid != $ax->clientbranchid) {
		// 'condition'=>'statusid='.$ctypesx.' and  clientid='.$getidx,
		$conformity = Yii::app()->db->createCommand(
			'SELECT conformity.* FROM conformity INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and conformity.clientid=' . $getidx . ' and conformity.statusid=' . $ctypesx . ' GROUP BY conformity.id'
		)->queryAll();
	}

	?>

	<!-- HTML5 export buttons table -->
	<section id="html5">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="row" style="border-bottom: 1px solid #e3ebf3;">
							<div class="col-xl-7 col-lg-9 col-md-9 mb-1">
								<h4 class="card-title"><?= t('LAST 5 NON-CONFORMITY LIST'); ?></h4>
							</div>
							<div class="col-xl-5 col-lg-3 col-md-3 mb-1">
								<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.create') && $ax->clientid == 0) { ?>
									<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info"
										id="createbutton" type="submit"><?= t('Add Non-Conformity'); ?> <i
											class="fa fa-plus"></i></a>
								<?php } ?>
								<!--	<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="reportbutton" type="submit"><?= t('Reports'); ?> <i class="fa fa-file"></i></a>

						-->
							</div>


						</div>
					</div>

					<div class="card-content collapse show">
						<div class="card-body card-dashboard">

							<table class="table table-striped table-bordered dataex-html5-export table-responsive">
								<thead>
									<tr>
										<!--
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
						  -->
										<th><?= t('NON-CONFORMITY NO'); ?></th>
										<th><?= t('WHO'); ?></th>
										<th><?= t('TO WHO'); ?></th>
										<th><?= t('DEPARTMENT.'); ?></th>
										<th><?= t('SUB-DEPARTMENT.'); ?></th>
										<th><?= t('OPENING DATE'); ?></th>
										<th><?= t('ACTION DEFINITION.'); ?></th>
										<th><?= t('DEADLINE.'); ?></th>
										<th><?= t('STATUS'); ?></th>
										<th><?= t('NON-CONFORMITY TYPE'); ?></th>

										<th><?= t('CLOSED TIME'); ?></th>

										<th><?= t('DEFINATION'); ?></th>

									</tr>
								</thead>
								<tbody id='waypointsTable'>


									<?php

									foreach ($conformity as $conformityx) {
										$depart = Departments::model()->find(array('condition' => 'id=' . $conformityx['departmentid'], ));
										if ($depart) {
											$depart = $depart->name;
											$subdep = Departments::model()->find(array('condition' => 'id=' . $conformityx['subdepartmentid'], ))->name;
										} else {
											$depart = '-';
											$subdep = '-';

										}
										?>


										<tr <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.view')) { ?>
												onclick="window.open('<?= Yii::app()->baseUrl ?>/conformity/activity/<?= $conformityx['id']; ?>', '_blank')"
											<?php } ?>>

											<!--
							<td><input type="checkbox" name="Education[id][]" class='sec' value="<?= $conformityx->id; ?>"></td>
							-->

											<td>
												<?= $conformityx['numberid']; ?>
											</td>

											<td>
												<?php $userwho = User::model()->find(array('condition' => 'id=' . $conformityx['userid']));
												echo $userwho->name . ' ' . $userwho->surname;

												?>
											</td>
											<td>
												<?php if ($userwho->clientid == 0) {

													echo $listclient = Client::model()->find(array('condition' => 'id=' . $conformityx['clientid']))->name;
													/*
														$listclient=Client::model()->find(array('condition'=>'id='.$conformityx['clientid']))->parentid;
													echo Client::model()->find(array('condition'=>'id='.$listclient))->name;
													*/
												} else {

													echo Firm::model()->find(array('condition' => 'id=' . $userwho->firmid))->name;
												}
												?>

											</td>
											<td><?= $depart ?></td>
											<td><?= $subdep ?></td>
											<td>


												<?= date('Y-m-d', $conformityx['date']); ?>
												<?//explode(' ',Generalsettings::model()->dateformat($conformityx->date))[0]; ?>
											</td>

											<td><? $activitiondef = Conformityactivity::model()->find(array('condition' => 'conformityid=' . $conformityx['id'], ))->definition;
											if ($activitiondef != '') {
												echo $activitiondef;
											} else {
												echo '-';
											} ?>


											</td>


											<td>



												<?php $date = Conformityactivity::model()->find(array('order' => 'date DESC', 'condition' => 'conformityid=' . $conformityx['id']));

												if (isset($date)) {
													echo $date->date;
													//echo Generalsettings::model()->dateformat(strtotime($date->date));
										
												} else {
													echo '-';
												} ?>
											</td>



											<? if ($conformityx->closedtime != '') {
												$kpnma = date('Y-m-d', $conformityx->closedtime);
											} else {
												$kpnma = "-";
											}

											?>
											<td>


												<? $status = Conformitystatus::model()->find(array('condition' => 'id=' . $conformityx['statusid'])); ?>



												<a class="btn btn-<?= t($status->btncolor); ?> btn-sm"
													style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?= t($status->name); ?>
												</a>




											</td>
											<td><?= t(Conformitytype::model()->find(array('condition' => 'id=' . $conformityx['type'], ))->name); ?>
											</td>


											<? if ($conformityx->closedtime != '') {
												$kpnma = date('Y-m-d', $conformityx->closedtime);
											} else {
												$kpnma = "-";
											}

											?>

											<td><?= $kpnma ?></td>


											<td><?= $conformityx['definition']; ?></td>




											<!--<td>

										<div class="btn-group mr-1 mb-1">
										  <button type="button" class="btn btn-danger btn-block dropdown-toggle" data-toggle="dropdown"
										  aria-haspopup="true" aria-expanded="false">
											<?= t('Process'); ?>
										  </button>
										  <div class="dropdown-menu open-left arrow">
											<button class="dropdown-item" type="button"><?= t('Activity'); ?></button>
												<div class="dropdown-divider" style="border-top:1px solid #eceef1;"></div>
											<button class="dropdown-item" type="button"><?= t('Edit'); ?></button>
												<div class="dropdown-divider" style="border-top:1px solid #eceef1;"></div>
											<button class="dropdown-item" type="button"><?= t('Delete'); ?></button>


										  </div>
										</div>



										</td>
										-->





										</tr>
									<?php } ?>


								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ HTML5 export buttons table -->

	<!-- client active monitoring list -->
	<?php $mtype = Yii::app()->db->createCommand()
		->select('count(m.id) sayi,m.clientid cbid,m.mtypeid mtype,c.name cname,mt.name mtname,mt.detailed')
		->from('monitoring m')
		->leftJoin('client as c', 'c.id=m.clientid')
		->leftJoin('monitoringtype as mt', 'mt.id=m.mtypeid');
	if ($ax->clientbranchid == 0) {

		if (isset($_GET['id']) && is_numeric($_GET['id'])) {
			$mtype = $mtype->where('c.id=' . $_GET['id']);

		} else {
			$mtype = $mtype->where('c.parentid=' . $ax->clientid);
		}


		$mtype = $mtype->where('c.parentid=' . $ax->clientid);
	} else {
		$mtype = $mtype->where('c.id=' . $ax->clientbranchid);
	}
	$mtype = $mtype->group('m.mtypeid');
	$mtype = $mtype->queryAll();

	if (!empty($mtype)) {
		?>













		<section id="html5">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row" style="border-bottom: 1px solid #e3ebf3;">
								<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
									<h4 class="card-title"><?= t('Client Active Monitoring Point List'); ?></h4>
								</div>
							</div>
						</div>
						<div class="card-content collapse show">
							<div class="card-body card-dashboard" id='list'>

								<table class="table table-striped table-bordered  table-responsive ">
									<thead>
										<tr>
											<th><?= mb_strtoupper(t('Client')); ?></th>
											<? foreach ($mtype as $mtypex): ?>
												<th><?= t($mtypex['mtname']) . "</br>(" . t($mtypex['detailed']) . ")"; ?></th>
											<?php endforeach; ?>
											<th><?= mb_strtoupper(t('Toplam')); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php


										$client = Yii::app()->db->createCommand()
											->select('count(m.id) sayi,m.clientid cbid,m.mtypeid mtype,c.name cname,mt.name mtname')
											->from('monitoring m')
											->leftJoin('client as c', 'c.id=m.clientid')
											->leftJoin('monitoringtype as mt', 'mt.id=m.mtypeid');
										if ($ax->clientbranchid == 0) {
											if (isset($_GET['id']) && is_numeric($_GET['id'])) {
												$client = $client->where('c.id=' . $_GET['id']);
											} else {
												$client = $client->where('c.parentid=' . $ax->clientid);
											}

										} else {
											$client = $client->where('c.id=' . $ax->clientbranchid);
										}
										$client = $client->group('m.clientid');
										$client = $client->queryAll();
										foreach ($client as $clientx): ?>

											<tr>
												<td><?= $clientx['cname']; ?></td>
												<?php $toplamMonitor = 0;
												foreach ($mtype as $mtypex): ?>
													<?php $monitoring = Yii::app()->db->createCommand()
														->select('count(m.id) sayi,m.clientid cbid,m.mtypeid mtype,c.name cname,mt.name mtname')
														->from('monitoring m')
														->leftJoin('client as c', 'c.id=m.clientid')
														->leftJoin('monitoringtype as mt', 'mt.id=m.mtypeid');
													$monitoring = $monitoring->where('c.id=' . $clientx['cbid'] . ' and m.active=1 and m.mtypeid=' . $mtypex['mtype']);
													$monitoring = $monitoring->group('m.clientid,m.mtypeid');
													$monitoring = $monitoring->queryAll();
													?>
													<td><?= $monitoring['0']['sayi']; ?></td>
													<?php $toplamMonitor = $toplamMonitor + intval($monitoring['0']['sayi']);
													?>
												<?php endforeach; ?>
												<td><?= $toplamMonitor; ?></td>
											</tr>
										<?php endforeach; ?>

									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	<?php }


	if ($country > 1 && $clientview->simple_client == '1') {
		if (($ax->clientid > 0 && $clientview->monitor_info <> '') || ($ax->type == 23 || $ax->type == 13)) {
			if ($country <> 0) {
				$monitoringtypes = Monitoringtype::model()->findAll(array(
					'condition' => 'country_id=' . $country . ' or country_id=0 and active=1',
				));
			} else {
				// $monitoringtypes=Monitoringtype::model()->findAll();
				$monitoringtypes = Monitoringtype::model()->findAll(array(
					'condition' => '(country_id=1 or country_id=0) and  active=1',
				));
			}

			?>
			<form action="/client/branches/<?= $_GET['id'] ?>" method="POST">
				<section id="html5">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<div class="row" style="border-bottom: 1px solid #e3ebf3;">
										<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
											<h4 class="card-title"><?= t('Lite Client Monitoring Point List - (Manuel)'); ?></h4>
										</div>
									</div>
								</div>
								<div class="card-content collapse show">
									<div class="card-body card-dashboard" id='list'>

										<table class="table table-striped table-bordered  table-responsive ">
											<thead>
												<tr>
													<th><?= mb_strtoupper(t('Monitors')); ?></th>
													<?

													foreach ($monitoringtypes as $mtypex) {
														if (isset($mntrinf[$mtypex->id]) && is_numeric($mntrinf[$mtypex->id])) {
															$valuex = $mntrinf[$mtypex->id];
															$toplamMonitor = $toplamMonitor + $valuex;

														} else {
															$valuex = 0;
														}
														if ($valuex <> '' && $valuex > 0 || ($ax->type == 23 || $ax->type == 13)) {
															?>
															<th><?= t($mtypex->name) . "</br>(" . t($mtypex->detailed) . ")"; ?></th>
														<?php }
													} ?>
													<th><?= mb_strtoupper(t('Toplam')); ?></th>
												</tr>
											</thead>
											<tbody>


												<tr>
													<td>#</td>
													<?php $toplamMonitor = 0;
													foreach ($monitoringtypes as $mtypex): ?>
														<?php if (isset($mntrinf[$mtypex->id]) && is_numeric($mntrinf[$mtypex->id])) {
															$valuex = $mntrinf[$mtypex->id];
															$toplamMonitor = $toplamMonitor + $valuex;
														} else {
															$valuex = 0;
														}
														if (($ax->type == 23 || $ax->type == 13)) {
															?>
															<td> <input type="text" class="mntrs" id="fname" value="<?= $valuex ?>"
																	name="mntrs[<?= $mtypex->id ?>]"></td>

														<?php } else {
															if ($valuex <> '' && $valuex > 0) { ?>

																<td> <span> <?= $valuex ?></span></td>
																<?php
															}
														}
													endforeach; ?>

													<td><?= $toplamMonitor; ?></td>
												</tr>
												<?php if (($ax->type == 23 || $ax->type == 13)) {
													?>
													<tr>
														<td>
															-
														</td>
														<td>
															<input type="submit" class="btn btn-info" value="<?= t('Save All') ?>">
														</td>
													</tr>
												<?php
												}
												?>
											</tbody>

										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</section>
			</form>

		<?php }
	}
	?>
	<!-- client active monitoring list bitiş -->

<?php } ?>


<!-- workorder list -->
<!---------->

<?php
$workorderwhere = '';

if ($ax->clientbranchid == 0) {
	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$client = Client::model()->findAll(array('condition' => 'id=' . $_GET['id']));

	} else {
		$client = Client::model()->findAll(array('condition' => 'parentid=' . $ax->clientid));
	}


	$i = 0;
	foreach ($client as $clientx) {
		if ($i == 0) {
			$workorderwhere = 'clientid=' . $clientx->id;
			$i++;
		} else {
			$workorderwhere = $workorderwhere . ' or clientid=' . $clientx->id;
		}
	}

} else {
	$workorderwhere = 'clientid=' . $ax->clientbranchid;
}







?>
<section id="html5">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
						<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
							<h4 class="card-title"><?= t('Workorders'); ?></h4>
						</div>
					</div>
				</div>

				<div class="card-content collapse show">


					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6">

							<div class="col-xl-12 col-lg-12 col-md-12">
								<?= t('5 business plans planned after this date'); ?></div>
							<div class="card-body card-dashboard">

								<table class="table table-striped table-bordered dataex-html5-export2 table-responsive">
									<thead>
										<tr>
											<th><?= t('NAME.'); ?></th>
											<th><?= t('TODO'); ?></th>
											<th><?= t('START DATE.'); ?></th>


										</tr>
									</thead>
									<tbody>
										<?php
										$workorder = Workorder::model()->findAll(array('condition' => 'status!=3 and date>="' . date("Y-m-d") . '" and (' . $workorderwhere . ') ORDER BY date asc limit 5'));
										foreach ($workorder as $workorderm) { ?>
											<tr>


												<td><?= Client::model()->finD(array('condition' => 'id=' . $workorderm->clientid))->name; ?>
												</td>
												<td><?= $workorderm->todo; ?></td>
												<td><?= date('d-m-Y', strtotime($workorderm->date)) . ' ' . $workorderm->start_time; ?>
												</td>


												<!--<td>
											<?php if ($workorderm->executiondate != '') {
												echo date("d-m-Y H:i:s", $workorderm->executiondate);
											} else {
												echo t('Continues');
											}
											?>
										  </td>

										  -->
											</tr>

										<?php } ?>


									</tbody>

								</table>
							</div>
						</div>


						<div class="col-xl-6 col-lg-6 col-md-6">

							<div class="col-xl-12 col-lg-12 col-md-12">
								<?= t('5 business plans completed before this date'); ?></div>
							<div class="card-body card-dashboard">

								<table style='padding:0px'
									class="table table-striped table-bordered dataex-html5-export2 table-responsive">
									<thead>
										<tr>
											<th><?= t('NAME.'); ?></th>
											<!-- <th style='width: 100%;'><?= t('TODO'); ?></th> -->
											<th style='width: 100%;'><?= t('START DATE.'); ?></th>

											<th style='width: 100%;'><?= t('EXECUTION DATE'); ?></th>

										</tr>
									</thead>
									<tbody>
										<?php

										//echo $workorderwhere;
										/*
										$workordery=Workorder::model()->findAll(array('condition'=>'status=3 and executiondate<="'.date("Y-m-d").'" and ('.$workorderwhere.') ORDER BY executiondate desc limit 5'));
										*/



										$workordery = Workorder::model()->findAll(array('condition' => 'status=3 and executiondate<="' . date("Y-m-d") . '" and (' . $workorderwhere . ') ORDER BY executiondate desc limit 5'));
										foreach ($workordery as $workorderx) { ?>
											<tr>

												<td><?= Client::model()->finD(array('condition' => 'id=' . $workorderx->clientid))->name; ?>
												</td>


												<?// echo date("d-m-Y H:i:s",1552286120); ?>
												<!--   <td><?= $workorderx->todo; ?></td> -->
												<td><?php
												if ($workorderx->realstarttime) {
													echo date('d/m/Y H:i', $workorderx->realstarttime);
												} else {
													echo "-";

												}


												?> </td>

												<td>
													<?php if ($workorderx->realendtime != '') {
														echo date("d/m/Y H:i", $workorderx->realendtime);
													} else {
														echo t('Continues');
													}
													?>
												</td>
											</tr>

										<?php } ?>


									</tbody>

								</table>

							</div>
						</div>
					</div>
					<!---------->




					<!-- workorder list end -->

					<script>
						$(document).ready(function () {

							/******************************************
							*       js of HTML5 export buttons        *
							******************************************/

							<? $whotable = User::model()->iswhotable(); ?>
							$('.dataex-html5-export').DataTable({
								dom: 'Bfrtip',
								lengthMenu: [[5, 10, 50, 100, -1], [5, 10, 50, 100, "<?= t('All'); ?>"]],
								language: {
									buttons: {
										pageLength: {
											_: "<?= t('Show'); ?> %d <?= t('rows'); ?>",
											'-1': "<?= t('Tout afficher'); ?>",
											className: 'd-none d-sm-none d-md-block',
										},
										html: true,
										colvis: "<?= t('Columns Visibility'); ?>",
									},
									"sDecimal": ",",
									"sEmptyTable": "<?= t('Data is not available in the table'); ?>",
									//"sInfo": "_TOTAL_ kay�ttan _START_ - _END_ aras�ndaki kay�tlar g�steriliyor",
									"sInfo": "<?= t('Total number of records'); ?> : _TOTAL_",
									"sInfoEmpty": "<?= t('No records found'); ?> ! ",
									"sInfoFiltered": "(_MAX_ <?= t('records'); ?>)",
									"sInfoPostFix": "",
									"sInfoThousands": ".",
									"sLengthMenu": "<?= t('Top of page'); ?> _MENU_ <?= t('record'); ?>",
									"sLoadingRecords": "<?= t('Loading'); ?>...",
									"sProcessing": "<?= t('Processing'); ?>...",
									"sSearch": "<?= t('Search'); ?>:",
									"sZeroRecords": "<?= t('No records found'); ?> !",
									"oPaginate": {
										"sFirst": "<?= t('First page'); ?>",
										"sLast": "<?= t('Last page'); ?>",
										"sNext": "<?= t('Next'); ?>",
										"sPrevious": "<?= t('Previous'); ?>"
									},
								},

								"columnDefs": [{
									"searchable": false,
									"orderable": false,
									// "targets": 0
								}],
								"order": [[4, 'asc']],



								buttons: [
									{
										extend: 'copyHtml5',
										exportOptions: {
											columns: [0, 1, 2, 3]
										},
										text: '<?= t('Copy'); ?>',
										className: 'd-none d-sm-none d-md-block',
										title: 'Non-Conformity (<?= date('d-m-Y H:i:s'); ?>)',
										messageTop: '<?php if ($whotable->isactive == 1) {
											echo $whotable->name;
										} ?>'
									},
									{
										extend: 'excelHtml5',
										exportOptions: {
											columns: [0, 1, 2, 3]
										},
										text: '<?= t('Excel'); ?>',
										className: 'd-none d-sm-none d-md-block',
										title: 'Non-Conformity (<?= date('d-m-Y H:i:s'); ?>)',
										messageTop: '<?php if ($whotable->isactive == 1) {
											echo $whotable->name;
										} ?>'
									},
									{
										extend: 'pdfHtml5',
										//message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
										exportOptions: {
											columns: [0, 1, 2, 3]
										},
										text: '<?= t('PDF'); ?>',
										title: 'Export',
										header: true,
										customize: function (doc) {
											doc.content.splice(0, 1, {
												text: [{
													text: 'Non-Conformity \n',
													bold: true,
													fontSize: 16,
													alignment: 'center'
												},
												{
													text: '<?php if ($whotable->isactive == 1) {
														echo $whotable->name;
													} ?> \n',
													bold: true,
													fontSize: 12,
													alignment: 'center'
												},

												{
													text: '<?= date('d-m-Y H:i:s'); ?>',
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


							});
							<?php
							$ax = User::model()->userobjecty('');
							$pageUrl = explode('?', $_SERVER['REQUEST_URI'])[0];
							$pageLength = 5;
							$table = Usertablecontrol::model()->find(array(
								'condition' => 'userid=:userid and sayfaname=:sayfaname',
								'params' => array(
									'userid' => $ax->id,
									'sayfaname' => $pageUrl
								)
							));
							if ($table) {
								$pageLength = $table->value;
							}
							?>
							var table = $('.dataex-html5-export').DataTable();
							table.page.len(<?= $pageLength; ?>).draw();
							var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
							var info = table.page.info();
							var lengthMenuSetting = info.length; //The value you want
							// alert(table.page.info().length);
						});





					</script>




					<?php

					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/icheck/icheck.min.js;';
					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/js/scripts/forms/checkbox-radio.js;';

					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/forms/icheck/icheck.css;';


					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/select/select2.full.min.js;';
					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/js/scripts/forms/select/form-select2.js;';



					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/datatables.min.js;';
					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
					Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/datatables.min.css;';
					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/forms/selects/select2.min.css;';
					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/css/app.css;';


					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';


					Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/assets/css/style.css;';
					?>