<?php

User::model()->login();


?>

<?php if (Yii::app()->user->checkAccess('client.branch.view')) { ?>
	<?= User::model()->geturl('Client', 'Branch', $id, 'client', 0, $ax->branchid); ?>


	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				<div class="card-header" style="">
					<ul class="nav nav-tabs">

						<?php if (Yii::app()->user->checkAccess('client.branch.view')) { ?>
							<li class="nav-item">
								<a class="nav-link active"
									href="<?= Yii::app()->baseUrl ?>/client/view?id=<?= $id; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect2"
										style="font-size: 15px;"><?php echo count($client); ?></span><?= t('Branch'); ?></a>
							</li>
						<?php } ?>

						<?php if (Yii::app()->user->checkAccess('client.staff.view') && $transferclient == 0) { ?>
							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/staff?id=<?= $id; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect2" style="font-size: 15px;"><?php if ((isset($_GET['status']) && $_GET['status'] == 1) || !isset($_GET['status'])) {
											$userwhere = ' and active=1';
										} else if (isset($_GET['status']) && $_GET['status'] == 2) {
											$userwhere = ' and active=0';
										} else {
											$userwhere = '';
										}
										$say = User::model()->findAll(array('condition' => 'clientid=' . $id . ' and (clientbranchid=0 or type in (24,22))' . $userwhere));
										echo count($say); ?>
									</span><?= t('Staff'); ?>


								</a>
							</li>

						<?php } ?>


						<?php if ($ax->type == 22 || $ax->type == 17 || $ax->type == 23 || $ax->type == 13 || $ax->type == 13 || $ax->id == 1) { ?>
							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/workorderreports?id=<?= $id; ?>&firmid=<?= $ax->branchid; ?>"><span
										class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o"
											style="font-size: 15px;"></i></span><?= t('Workorder Report'); ?></a>
							</li>

						<?php } ?>

						<?php if ($ax->type == 23 || $ax->type == 13 || $ax->id == 1) { ?>
							<li class="nav-item">
								<a class="nav-link"
									href="<?= Yii::app()->baseUrl ?>/client/financials?id=<?= $id; ?>"><span
										class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-text-o"
											style="font-size: 15px;"></i></span><?= t('Financials'); ?></a>
							</li>

						<?php } ?>

					</ul>
				</div>
			</div>
		</div>
	</div>



	<?php if (Yii::app()->user->checkAccess('client.branch.create')) { ?>
		<div class="row" id="createpage">
			<div class="col-xl-12 col-lg-12 col-md-12">

				<div class="card">


					<div class="card-header" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
						<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							<div class="col-md-6">
								<h4 class="card-title"><?= t('Branch Client Create'); ?></h4>
							</div>
							<div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i
										class="fa fa-times"></i></button>
							</div>
						</div>
					</div>

					<form id="client-form" action="<?= Yii::app()->baseUrl ?>/client/create/<?= $id; ?>" method="post">
						<div class="card-content">
							<div class="card-body">


								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1" style='display:none'>
										<label for="basicSelect"><?= t('Kod'); ?></label>
										<fieldset class="form-group">
											<input type="hide" class="form-control" id="basicInput"
												placeholder="<?= t('Client Kodu'); ?>" name="Client[client_code]">
										</fieldset>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<fieldset class="form-group">
											<label for="basicSelect"><?= t('Client Name'); ?></label>
											<input required type="text" class="form-control" id="basicInput"
												value='<?= $clientview->name; ?>' placeholder="<?= t('Name'); ?>"
												name="Client[name]">
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Commercial Title'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="basicInput"
												placeholder="<?= t('Title'); ?>" value='<?= $clientview->title; ?>'
												name="Client[title]">
										</fieldset>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Taxoffice'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="basicInput"
												placeholder="<?= t('Taxoffice'); ?>" value='<?= $clientview->taxoffice; ?>'
												name="Client[taxoffice]">
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Taxno'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="basicInput"
												placeholder="<?= t('Taxno'); ?>" value='<?= $clientview->taxno; ?>'
												name="Client[taxno]">
										</fieldset>
									</div>



									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Sector'); ?></label>
										<fieldset class="form-group">
											<select class="custom-select block" id="customSelect" name="Client[branchid]">
												<?php if (count($sector) != 0) { ?>
													<?php foreach ($sector as $sectors) { ?>
														<option <?php if ($clientview->branchid == $sectors->id) {
															echo 'selected';
														} ?>
															value="<?= $sectors->id; ?>"><?= t($sectors->name); ?></option>
													<?php } ?>

												<?php } ?>
											</select>
										</fieldset>
									</div>

									<?php $clientx = Client::model()->findAll(array(
										#'select'=>'',
										#'limit'=>'5',
										'order' => 'name ASC',
										# 'condition'=>'active=1',
									));

									?>





									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Land Phone'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="basicInput"
												placeholder="<?= t('Land Phone'); ?>" value='<?= $clientview->landphone; ?>'
												name="Client[landphone]">
										</fieldset>
									</div>


									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 1</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address]" class="form-control"
												placeholder="<?= t('Address Line') ?> 1"><?= $clientview->address; ?></textarea>

										</fieldset>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 2</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address2]" class="form-control"
												placeholder="<?= t('Address Line') ?> 2"><?= $clientview->address2; ?></textarea>

										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 3</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address3]" class="form-control"
												placeholder="<?= t('Address Line') ?> 3"><?= $clientview->address3; ?></textarea>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 4</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address4]" class="form-control"
												placeholder="<?= t('Address Line') ?> 4"><?= $clientview->address4; ?></textarea>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('County'); ?> </label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[county]" class="form-control"
												placeholder="<?= t('County') ?> "></textarea>

										</fieldset>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= ucfirst(t('Country')); ?></label>
										<fieldset class="form-group">
											<select class="custom-select block" id="customSelect" name="Client[country_id]"
												required>
												<?php foreach ($countries as $country) { ?>
													<option value="<?= $country['id'] ?>"
														<?= $availablefirm->country_id == $country['id'] ? 'selected' : '' ?>>
														<?= t($country['name']) ?>
													</option>

												<?php } ?>

											</select>
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Town or city'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="basicInput"
												value='<?= $clientview->town_or_city; ?>'
												placeholder="<?= t('Town or city'); ?>" name="Client[town_or_city]">
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Post code'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="basicInput"
												value='<?= $clientview->postcode; ?>' placeholder="<?= t('Post code'); ?>"
												name="Client[postcode]">
										</fieldset>
									</div>



									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('E-mail'); ?></label>
										<fieldset class="form-group">
											<input type="email" class="form-control" id="basicInput"
												placeholder="<?= t('E-mail'); ?>" value='<?= $clientview->email; ?>'
												name="Client[email]">
										</fieldset>
									</div>



									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Active'); ?></label>
										<fieldset class="form-group">
											<select class="custom-select block" id="customSelect" name="Client[active]">
												<option selected=""><?= t('Select'); ?></option>
												<option value="1" selected><?= t('Active'); ?></option>
												<option value="0"><?= t('Passive'); ?></option>
											</select>
										</fieldset>
									</div>



									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<fieldset class="form-group">
											<div class="input-group-append" id="button-addon2">
												<button class="btn btn-primary" type="submit"><?= t('Create'); ?></button>
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
	<?php } ?>








	<!-- HTML5 export buttons table -->
	<section id="html5">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="row" style="border-bottom: 1px solid #e3ebf3;">
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<h4 class="card-title"><?= $parentid->name . ' ' . t('BRANCH LIST'); ?></h4>
							</div>

							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<?php if (Yii::app()->user->checkAccess('client.branch.create') && $ax->type != 22) { ?>
										<button class="btn btn-info" id="createbutton" type="submit"><?= t('Add Branch'); ?> <i
												class="fa fa-plus"></i></button>
										<?php
									}
									?>
								</div>

							</div>
						</div>
						<a href='?id=<?= $id; ?>&firmid=<?= $firmid; ?>&status=2'
							class="btn btn-danger btn-sm <?= $isActive == 2 ? 'isActive' : ''; ?>" style='float:right'
							type="submit"><?= t('Passive'); ?> </a>

						<a href='?id=<?= $id; ?>&firmid=<?= $firmid; ?>&status=1'
							class="btn btn-success btn-sm <?= $isActive == 1 ? 'isActive' : ''; ?>" style='float:right'
							type="submit"><?= t('Active'); ?> </a>
						<a href='?id=<?= $id; ?>&firmid=<?= $firmid; ?>&status=0'
							class="btn btn-warning btn-sm <?= $isActive == 0 ? 'isActive' : ''; ?>" style='float:right'
							type="submit"><?= t('All'); ?> </a>

					</div>

					<div class="card-content collapse show">
						<div class="card-body card-dashboard" id='confotmityListTable'></div>
					</div>
				</div>
			</div>
		</div>
	</section>





	<?php if (Yii::app()->user->checkAccess('client.branch.update')) { ?>
		<!-- GÜNCELLEME BAŞLANGIÇ-->
		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="form-group">
				<!-- Modal -->
				<div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header bg-warning white">
								<h4 class="modal-title" id="myModalLabel8"><?= t('Client Update'); ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<!--form baslangıç-->
							<form id="client-form" action="<?= Yii::app()->baseUrl; ?>/client/update/0" method="post">
								<div class="modal-body">
									<input type="hidden" class="form-control" id="modalclientid" name="Client[id]" value="0">
									<input type="hidden" class="form-control" id="modalclientparentid" name="Client[parentid]"
										value="0">

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style='display:none'>
										<label for="basicSelect"><?= t('Kod'); ?></label>
										<fieldset class="form-group">
											<input type="hide" id="modalclient_code" class="form-control" id="basicInput"
												placeholder="<?= t('Client Kodu'); ?>" name="Client[client_code]">
										</fieldset>
									</div>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Client Name'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modalclientname"
												placeholder="<?= t('Name'); ?>" name="Client[name]" value="">
										</fieldset>
									</div>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Commercial Title'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modalclienttitle"
												placeholder="<?= t('Title'); ?>" name="Client[title]" value="">
										</fieldset>
									</div>


									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Taxoffice'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modalclienttaxoffice"
												placeholder="<?= t('Taxoffice'); ?>" name="Client[taxoffice]" value="">
										</fieldset>
									</div>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Taxno'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modalclienttaxno"
												placeholder="<?= t('Taxno'); ?>" name="Client[taxno]" value="">
										</fieldset>
									</div>

									<?php $sector = Sector::model()->findAll(array(
										#'select'=>'',
										#'limit'=>'5',
										'order' => 'name ASC',
										'condition' => 'active=1',
									));

									?>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Sector'); ?></label>
										<fieldset class="form-group">
											<select class="custom-select block" id="modalclientbranchid"
												name="Client[branchid]">
												<?php if (count($sector) != 0) { ?>
													<?php foreach ($sector as $sectors) { ?>
														<option value="<?= $sectors->id; ?>"><?= t($sectors->name); ?></option>
													<?php } ?>

												<?php } ?>
											</select>
										</fieldset>
									</div>

									<?php $clientx = Client::model()->findAll(array(
										#'select'=>'',
										#'limit'=>'5',
										'order' => 'name ASC',
										# 'condition'=>'active=1',
									));

									?>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 1</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address]" class="form-control"
												id="modalclientaddress" placeholder="<?= t('Address Line') ?> 1"></textarea>

										</fieldset>
									</div>


									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?>2</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address2]" class="form-control"
												id="modalclientaddress2" placeholder="<?= t('Address Line') ?> 2"></textarea>

										</fieldset>
									</div>



									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 3</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address3]" class="form-control"
												id="modalclientaddress3" placeholder="<?= t('Address Line') ?> 3"></textarea>

										</fieldset>
									</div>




									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Address Line'); ?> 4</label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[address4]" class="form-control"
												id="modalclientaddress4" placeholder="<?= t('Address Line') ?> 4"></textarea>

										</fieldset>
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('County'); ?> </label>
										<fieldset class="form-group">
											<textarea type="text" name="Client[county]" class="form-control"
												id="modalclientcounty" placeholder="<?= t('County') ?> "></textarea>

										</fieldset>
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= ucfirst(t('Country')); ?></label>
										<fieldset class="form-group">
											<select class="custom-select block" id="modalcountry_id" name="Client[country_id]"
												required>
												<?php foreach ($countries as $country) { ?>
													<option value="<?= $country['id'] ?>"><?= t($country['name']) ?></option>
												<?php } ?>

											</select>
										</fieldset>
									</div>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Town or city'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modaltownorcity"
												placeholder="<?= t('Town or city'); ?>" name="Client[town_or_city]">
										</fieldset>
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Post code'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modalpostcode"
												placeholder="<?= t('Post code'); ?>" name="Client[postcode]">
										</fieldset>
									</div>

									<!--	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?= t('Address Line'); ?> 2</label>
						<fieldset class="form-group">
						  <textarea  type="text" name="Client[address2]" class="form-control" id="modalclientaddress2" placeholder="<?= t('Address Line') ?> 2"></textarea>
						
						</fieldset>
					</div>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?= t('Address Line'); ?> 3</label>
						<fieldset class="form-group">
						<textarea  type="text" name="Client[address3]" class="form-control" id="modalclientaddress3" placeholder="<?= t('Address Line') ?> 3"></textarea>
						</fieldset>
					</div>
					-->



									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('Land Phone'); ?></label>
										<fieldset class="form-group">
											<input type="text" class="form-control" id="modalclientlandphone"
												placeholder="<?= t('Land Phone'); ?>" name="Client[landphone]">
										</fieldset>
									</div>

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<label for="basicSelect"><?= t('E-mail'); ?></label>
										<fieldset class="form-group">
											<input type="email" class="form-control" id="modalclientemail"
												placeholder="<?= t('E-mail'); ?>" name="Client[email]">
										</fieldset>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?= t('Lite Client?'); ?></label>
										<fieldset class="form-group">
											<select class="custom-select block" id="modalsimpleclient"
												name="Client[simple_client]">
												<option value="0"><?= t('No'); ?></option>
												<option value="1"><?= t('Yes'); ?></option>
											</select>
										</fieldset>
									</div>


									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<fieldset class="form-group">
											<select class="custom-select block" id="modalclientactive" name="Client[active]">
												<option value="1"><?= t('Active'); ?></option>
												<option value="0"><?= t('Passive'); ?></option>
											</select>
										</fieldset>
									</div>


								</div>
								<div class="modal-footer">
									<button type="button" class="btn grey btn-outline-secondary"
										data-dismiss="modal"><?= t('Close'); ?></button>
									<button class="btn btn-warning block-page" type="submit"><?= t('Update'); ?></button>
								</div>

							</form>

							<!--form bitiş-->
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- GÜNCELLEME BİTİŞ-->
	<?php } ?>


	<?php if (Yii::app()->user->checkAccess('client.branch.delete')) { ?>

		<!--SİL BAŞLANGIÇ-->

		<div class="col-lg-4 col-md-6 col-sm-12">
			<div class="form-group">
				<!-- Modal -->
				<div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header bg-danger white">
								<h4 class="modal-title" id="myModalLabel8"><?= t('Client Delete'); ?></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<!--form baslangıç-->
							<form id="client-form" action="<?= Yii::app()->baseUrl; ?>/client/delete/0" method="post">

								<input type="hidden" class="form-control" id="modalclientid2" name="Client[id]" value="0">
								<input type="hidden" class="form-control" id="modalparentid2" name="Client[parentid]" value="0">

								<div class="modal-body">

									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<h5> <?= t('Do you want to delete?'); ?></h5>
									</div>



								</div>
								<div class="modal-footer">
									<button type="button" class="btn grey btn-outline-secondary"
										data-dismiss="modal"><?= t('Close'); ?></button>
									<button class="btn btn-danger block-page" type="submit"><?= t('Delete'); ?></button>
								</div>

							</form>

							<!--form bitiş-->
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- SİL BİTİŞ -->
	<?php } ?>
<?php } ?>



<style>
	.switchery,
	.switch {
		margin-left: auto !important;
		margin-right: auto !important;
	}
</style>
<script>

	$("#createpage").hide();
	$("#createbutton").click(function () {
		$("#createpage").toggle(500);
	});
	$("#cancel").click(function () {
		$("#createpage").hide(500);
	});

	$(document).ready(function () {
		$('.block-page').on('click', function () {
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

	// function openmodal(obj)
	// {
	// $('#modalclientid').val($(obj).data('id'));
	// $('#modalclientname').val($(obj).data('name'));
	// $('#modalclienttitle').val($(obj).data('title'));
	// $('#modalclienttaxoffice').val($(obj).data('taxoffice'));
	// $('#modalclienttaxno').val($(obj).data('taxno'));
	// $('#modalsimpleclient').val($(obj).data('simple'));
	// $('#modalclientactive').val($(obj).data('active'));
	// $('#modalclientbranchid').val($(obj).data('branchid'));
	// $('#modalclientparentid').val($(obj).data('parentid'));
	// $('#modalcountry_id').val($(obj).data('country_id'));
	// $('#modalclientemail').val($(obj).data('email'));
	// $('#modalclientlandphone').val($(obj).data('landphone'));
	// $('#modalclientaddress').val($(obj).data('address'));
	// $('#modalclientaddress2').val($(obj).data('address2'));
	// $('#modalclientaddress3').val($(obj).data('address3'));
	// $('#modaltownorcity').val($(obj).data('town_or_city'));
	// $('#modalpostcode').val($(obj).data('postcode'));
	// $('#modalclient_code').val($(obj).data('client_code'));
	// $('#duzenle').modal('show');

	// }



	// function openmodalsil(obj)
	// {
	// $('#modalclientid2').val($(obj).data('id'));
	// $('#modalparentid2').val($(obj).data('parentid'));
	// $('#sil').modal('show');

	// }

	function authchange(data, permission, obj) {
		$.post("index?", { clientid: data, active: permission })
			.done(function (returns) {
				toastr.success("Success");
			});
	};

	$(document).ready(function () {
		$(".switchery").on('change', function () {

			if ($(this).is(':checked')) {
				authchange($(this).data("id"), 1, $(this));
			} else {
				authchange($(this).data("id"), 0, $(this));
			}

			$('#checkbox-value').text($('#checkbox1').val());
		});
	});



	$(document).ready(function () {

		/******************************************
		*       js of HTML5 export buttons        *
		******************************************/

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
					colvis: "<?= t('Columns Visibility'); ?>",

				},
				"sDecimal": ",",
				"sEmptyTable": "<?= t('Data is not available in the table'); ?>",
				//"sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
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
			buttons: [
				{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [0, 1]
					},
					text: '<?= t('Copy'); ?>',
					className: 'd-none d-sm-none d-md-block',
					title: ' <?= t('Client Branch') ?> (<?= date('d-m-Y'); ?>)',
					messageTop: '<?= User::model()->table('client', $id); ?>'
				},
				{
					extend: 'excelHtml5',
					exportOptions: {
						columns: [0, 1]
					},
					text: '<?= t('Excel'); ?>',
					className: 'd-none d-sm-none d-md-block',
					title: ' <?= t('Client Branch') ?> (<?= date('d-m-Y'); ?>)',
					messageTop: '<?= User::model()->table('client', $id); ?>'
				},

				{
					extend: 'pdfHtml5',
					exportOptions: {
						columns: [0, 1]
					},
					text: '<?= t('PDF'); ?>',
					//message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
					title: 'Export',
					header: true,
					customize: function (doc) {
						doc.content.splice(0, 1, {
							text: [{
								text: ' <?= t('Client Branch') ?> \n',
								bold: true,
								fontSize: 16,
								alignment: 'center'
							},
							{
								text: '<?= User::model()->table('client', $id); ?> \n',
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



<style>
	@media (max-width: 991.98px) {

		.hidden-xs,
		.buttons-collection {
			display: none;
		}

		div.dataTables_wrapper div.dataTables_filter label {
			white-space: normal !important;
		}

		div.dataTables_wrapper div.dataTables_filter input {
			margin-left: 0px !important;
		}

	}

	.isActive {
		box-shadow: 0px 0px 4px 0px #000;
	}

	table {
		width: 100%
	}
</style>


<script>

	$(document).ready(function () {
		//YoksisListe();

		var listTable = [];
		function document(classname, columns, pdfbaslik, columnsData, url, data) {
			$("#backgroundLoading").removeClass("loadingDisplay");
			$('.' + classname + ' tbody').empty();
			dataTable = $("." + classname).DataTable({
				dom: 'Bfrtip',
				"order": [[0, 'desc']],
				"scrollX": false,
				responsive: true, // Mobil uyumluluk için
				lengthMenu: [[5, 10, 50, 100, -1], [5, 10, 50, 100, "<?= t('All'); ?>"]],
				language: {
					buttons: {
						pageLength: {
							_: "<?= t('Show'); ?> %d <?= t('rows'); ?>",
							'-1': "<?= t('Tout afficher'); ?>"
						},
						colvis: "<?= t('Columns Visibility'); ?>",
					},
					"sDecimal": ",",
					"sEmptyTable": "<?= t('Data is not available in the table'); ?>",
					//"sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
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
				/*	select: {
								 style:    'os',
								 selector: 'td:first-child'
						 },
						 */
				// select:true ,

				buttons: [
					{
						extend: "excelHtml5",
						exportOptions: { columns: columns },
						text: '<?= t("Excel"); ?>',
						className: "d-none d-sm-none d-md-block",
						title: pdfbaslik + "-<?= date("d/m/Y"); ?>",
						messageTop: pdfbaslik
					},
					{
						extend: "pdfHtml5",
						exportOptions: {
							columns: columns
						},
						text: "<?= t('Pdf'); ?>",
						title: pdfbaslik + '<?= date("d/m/Y"); ?>',
						header: true,
						customize: function (doc) {
							doc.content.splice(0, 1, {
								text: [{
									text: "\n",
									bold: true,
									fontSize: 16,
									// alignment: "center"
								},
								{
									text: pdfbaslik + "\n",
									bold: true,
									fontSize: 12,
									// alignment: "center"
								},
								{
									text: '<?= date("d/m/Y"); ?>',
									bold: true,
									fontSize: 11,
									// alignment: center
								}],
								margin: [0, 0, 0, 12]
							});
						}
					},
					'colvis',
					'pageLength',


				],
				"columns": columnsData,
				"ajax": {
					"type": "GET",
					"url": url,
					"dataSrc": function (json) {
						//Make your callback here.
						$("#backgroundLoading").addClass("loadingDisplay");
						if (json.status == 200) {
							return json.response;
						}
						else {
							alert("hata");
							return [];
						}

					},
					error: function (xhr, error, code) {
						console.log(xhr);
						console.log(code);
					}
				},
				"rowCallback": function (row, data) {
					$(row).addClass("trUrl");
					if (data.color != "" && data.color != undefined && data.color != null) {
						$(row).css("backgroundColor", data.color);

					}
				},





			});

			dataTable.on('draw', function () {
				$('.switchery').each(function () {
					// Eğer checkbox zaten dönüştürülmüşse atla
					if (!$(this).attr('data-switchery')) {
						new Switchery(this);
					}
				});
			});

			isDataTableIndex = listTable.findIndex(x => x.class == classname);
			if (isDataTableIndex != undefined && isDataTableIndex != null) {
				listTable.splice(isDataTableIndex, 1);
			}
			listTable.push({ "class": classname, "value": dataTable });
		}
		//// liste çekiliş başlıyor //////
		var freeListColumnArray = [
			{
				"key": "cblitename", "value": "<?= mb_strtoupper(t('Name')); ?>",
				"data": [
					"active", "address", "address2", "address3", "address4", "county", "barcode", "branchid", "client_code", "contractfinishdate", "contractstartdate", "country_id", "createdtime", "email", "firmid", "id", "image", "image2",
					"image_footer", "isdelete", "iskdv", "json_notes", "landphone", "mainclientid", "mainfirmid", "monitor_info", "name", "package", "parentid", "postcode", "productsamount", "simple_client", "simple_client_svr_period",
					"taxno", "taxoffice", "title", "town_or_city", "username"
				]
			},
			{ "key": "postcode", "value": "<?= mb_strtoupper(t('Post Code.')); ?>" },
			{ "key": "sector", "value": "<?= mb_strtoupper(t('Sector')); ?>" },
			{ "key": "istransfer", "value": "<?= t('TRANSFER'); ?>" },
			{
				"key": "active", "value": "<?= t('Active'); ?>",
				"data": [
					"active", "address", "address2", "address3", "address4", "county", "barcode", "branchid", "client_code", "contractfinishdate", "contractstartdate", "country_id", "createdtime", "email", "firmid", "id", "image", "image2",
					"image_footer", "isdelete", "iskdv", "json_notes", "landphone", "mainclientid", "mainfirmid", "monitor_info", "name", "package", "parentid", "postcode", "productsamount", "simple_client", "simple_client_svr_period",
					"taxno", "taxoffice", "title", "town_or_city", "username"
				],
				"checkbox": 1
			}

		];




		var listButtonArray = [
			{
				"class": "btn btn-warning btn-sm scholarshipHistoryUpdate",
				"title": "<?= t('Update'); ?>",
				"iconClass": "fa fa-edit text-white",
				"data": [
					"active", "address", "address2", "address3", "address4", "county", "barcode", "branchid", "client_code", "contractfinishdate", "contractstartdate", "country_id", "createdtime", "email", "firmid", "id", "image", "image2",
					"image_footer", "isdelete", "iskdv", "json_notes", "landphone", "mainclientid", "mainfirmid", "monitor_info", "name", "package", "parentid", "postcode", "productsamount", "simple_client", "simple_client_svr_period",
					"taxno", "taxoffice", "title", "town_or_city", "username"
				]
			},
			{
				"class": "btn btn-danger btn-sm scholarshipHistoryDelete",
				"title": "<?= t('Update'); ?>",
				"iconClass": "fa fa-trash text-white",
				"data": [
					"active", "address", "address2", "address3", "address4", "county", "barcode", "branchid", "client_code", "contractfinishdate", "contractstartdate", "country_id", "createdtime", "email", "firmid", "id", "image", "image2",
					"image_footer", "isdelete", "iskdv", "json_notes", "landphone", "mainclientid", "mainfirmid", "monitor_info", "name", "package", "parentid", "postcode", "productsamount", "simple_client", "simple_client_svr_period",
					"taxno", "taxoffice", "title", "town_or_city", "username"
				]
			},
		];

		tableList("confotmityListTable", "confotmityList", freeListColumnArray, listButtonArray, "<?= Yii::app()->baseUrl; ?>/client/clientList?cid=<?= $id ?>&cbid=0&bid=<?= $firmid ?>&status=<?= isset($_GET['status']) && intval($_GET['status']) != 0 ? $_GET['status'] : 0 ?>", "GET", null, "Liste", "", 0, 0, 0);

		$('#confotmityListTable').on('click', 'a.scholarshipHistoryUpdate', function () {
			const dataAttributes = $(this).data();
			console.log(dataAttributes);

			$('#modalclientid').val($(this).data('id'));
			$('#modalclientname').val($(this).data('name'));
			$('#modalclienttitle').val($(this).data('title'));
			$('#modalclienttaxoffice').val($(this).data('taxoffice'));
			$('#modalclienttaxno').val($(this).data('taxno'));
			$('#modalsimpleclient').val($(this).data('simple_client'));
			$('#modalclientactive').val($(this).data('active'));
			$('#modalclientbranchid').val($(this).data('branchid'));
			$('#modalclientparentid').val($(this).data('parentid'));
			$('#modalcountry_id').val($(this).data('country_id'));
			$('#modalclientemail').val($(this).data('email'));
			$('#modalclientlandphone').val($(this).data('landphone'));
			$('#modalclientaddress').val($(this).data('address'));
			$('#modalclientaddress2').val($(this).data('address2'));
			$('#modalclientaddress3').val($(this).data('address3'));
			$('#modalclientaddress4').val($(this).data('address4'));
			$('#modalclientcounty').val($(this).data('county'));
			$('#modaltownorcity').val($(this).data('town_or_city'));
			$('#modalpostcode').val($(this).data('postcode'));
			$('#modalclient_code').val($(this).data('client_code'));
			$('#modalclient_code').val($(this).data('client_code'));
			$('#duzenle').modal('show');
			// window.open('<?= Yii::app()->baseUrl ?>/conformity/activity/'+data["0"]["id"], '_blank');
		});

		$('#confotmityListTable').on('click', 'a.scholarshipHistoryDelete', function () {
			$('#modalclientid2').val($(this).data('id'));
			$('#modalparentid2').val($(this).data('parentid'));
			$('#sil').modal('show');

		});




		$(document).on('change', '.switchery', function () {
			let isChecked = $(this).is(':checked'); // Checkbox'ın seçili olup olmadığını kontrol et
			let dataId = $(this).data('id'); // Checkbox'ın data-id değerini al

			$.post("index?", { clientid: dataId, active: (isChecked ? 1 : 0) })
				.done(function (returns) {
					// alert("başarılı");
					toastr.success("Success");
				});

		});


		function tableList(listId, tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = '', multiSelect = 0, order = null, savedPageNumber = 0) {

			tableHtml =
				'<table class="table table-striped table-bordered table-sm ' + tableClass + '">' +
				'<thead>';

			if (columnArray[0][0] != undefined && columnArray[0][0] != null) {
				for (let i = 0; i < columnArray.length; i++) {
					tableHtml = tableHtml + '<tr>';


					for (let j = 0; j < columnArray[i].length; j++) {
						var colspan = columnArray[i][j]["colspan"];
						colspan1 = colspan != null && colspan != undefined && colspan != "" ? "colspan='" + colspan + "'" : "";
						var rowspan = columnArray[i][j]["rowspan"];
						rowspan1 = rowspan != null && rowspan != undefined && rowspan != "" ? "rowspan='" + rowspan + "'" : "";
						tableHtml = tableHtml + '<th ' + rowspan1 + ' ' + colspan1 + '>' + columnArray[i][j]['value'] + '</th>';
					}
					if (i == columnArray.length - 1 && listButtonArray != null && listButtonArray != undefined && listButtonArray != '' && listButtonArray.length > 0) {
						tableHtml = tableHtml + '<th><?= t('Process'); ?></th>';
					}
					tableHtml = tableHtml + '</tr>';
				}
			} else {
				tableHtml = tableHtml + '<tr>';


				for (var i = 0; i < columnArray.length; i++) {
					tableHtml = tableHtml + '<th><a class="column_sort" id="' + columnArray[i]['key'] + '" >' + columnArray[i]['value'] + '</a></th>';
				}
				if (listButtonArray != null && listButtonArray != undefined && listButtonArray != '' && listButtonArray.length > 0) {
					tableHtml = tableHtml + '<th><?= t('Process'); ?></th>';
				}

				tableHtml = tableHtml + '</tr>';
			}

			tableHtml = tableHtml +
				'</thead>' +
				'</table>';


			$('#' + listId).html(tableHtml);
			ApiListeFunc(tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata, multiSelect, order, savedPageNumber);
		}


		function ApiListeFunc(tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = '', multiSelect, order = null, savedPageNumber) {
			// var namesurname = $(this).data("namesurname");
			$("#backgroundLoading").removeClass("loadingDisplay");
			var columnsData = [];
			var pdfArray = [];
			// var defaultContent = '';



			if (columnArray[0][0] != undefined && columnArray[0][0] != null) {
				columnArray = columnArray[columnArray.length - 1];
			}

			for (let i = 0; i < columnArray.length; i++) {

				if (columnArray[i]['data'] != undefined && columnArray[i]['data'] != null) {
					columnsData.push({
						"data": null,
						className: "center",
						"render": function (data) {
							let defaultContent = '';
							let datam = '';
							for (let j = 0; j < columnArray[i]['data'].length; j++) {
								datam = datam + ' data-' + columnArray[i]['data'][j] + '="' + data[columnArray[i]['data'][j]] + '"';
							}
							if (columnArray[i]['button-text'] != undefined && columnArray[i]['button-text'] != null && columnArray[i]['button-text'] != '') {
								defaultContent += '<div class="col-12">' +
									'<a  style="color:#000;cursor: pointer;background:#d6d2d2"' + datam + ' class="btn btn-sm tablerow ' + columnArray[i]['key'] + '"  data-buttontype="' + columnArray[i]['key'] + '" data-toggle="tooltip" data-placement="top" title="' + columnArray[i]['value'] + '">' +
									columnArray[i]['button-text']
								'</div>';
							}
							else if (columnArray[i]['checkbox'] != undefined && columnArray[i]['checkbox'] != null && columnArray[i]['checkbox'] != '') {
								defaultContent += '<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="' + data['id'] + '"  ' + (data['active'] == 1 ? "checked" : "") + '/>';
							}
							else {
								if (columnArray[i]['type'] === 'url') {
									defaultContent += '<div class="col-12">' +
										'<a target="_blank" href="' + data[columnArray[i]['data'][0]] + '" style="color:red;cursor: pointer;"' + datam + ' class="tablerow ' + columnArray[i]['key'] + '"  data-buttontype="' + columnArray[i]['key'] + '" data-toggle="tooltip" data-placement="top" title="' + columnArray[i]['value'] + '">' +
										columnArray[i]['value'] +
										'</div>';
								}
								else {
									defaultContent += '<div class="col-12">' +
										'<a target="_blank" href="<?= Yii::app()->baseUrl ?>/client/branches/' + data['id'] + '" style="color:#009c9f;cursor: pointer;"' + datam + ' class="tablerow ' + columnArray[i]['key'] + '"  data-buttontype="' + columnArray[i]['key'] + '" >' +
										data[columnArray[i]['key']] +
										'</div>';
								}

							}
							//   console.log(defaultContent);
							return defaultContent;
						}
					});
				}
				else {

					columnsData.push({ "data": columnArray[i]['key'] }); //the variables are fill in the table
				}
				pdfArray.push(i);
			}

			if (listButtonArray != '' && listButtonArray != null && listButtonArray.length != 0 && listButtonArray != undefined) {

				/* columnsData.push({
					   "data": null,
					   className: "center",
					   // defaultContent: defaultContent,
					   "render": function (data) {
						   return '<div class="m-4"><input type="checkbox" class="pendingChk" value="' + data['stu_id'] + '">';

					   }
				   });
				   */

				columnsData.push({
					"data": null,
					className: "center",
					// defaultContent: defaultContent,
					"render": function (data) {
						let defaultContent = '';
						for (let i = 0; i < listButtonArray.length; i++) {
							let datam = '';
							for (let j = 0; j < listButtonArray[i]['data'].length; j++) {
								datam = datam + ' data-' + listButtonArray[i]['data'][j] + '="' + data[listButtonArray[i]['data'][j]] + '"';
							}
							if (listButtonArray[i]["a_id"] != null) {
								defaultContent +=
									'<a style="margin: 0px 1px;" ' + datam + ' class="' + listButtonArray[i]['class'] + '" id= "' + listButtonArray[i]["a_id"] + '"  data-buttontype="' + listButtonArray[i]['class'] + '" data-toggle="tooltip" data-placement="top" title="' + listButtonArray[i]['title'] + '">' +
									'<i class="' + listButtonArray[i]["iconClass"] + '"></i></a>';
							}
							else {
								defaultContent +=
									'<a style="margin: 0px 1px;" ' + datam + ' class="' + listButtonArray[i]['class'] + '"  data-buttontype="' + listButtonArray[i]['class'] + '" data-toggle="tooltip" data-placement="top" title="' + listButtonArray[i]['title'] + '">' +
									'<i class="' + listButtonArray[i]["iconClass"] + '"></i></a>'; //table içerisindeki buton aksiyonları
							}

						}
						//   console.log(defaultContent);
						return defaultContent;
					}
				});

			}

			// console.log(pdfArray);
			document(tableClass, pdfArray, pdfName, columnsData, ajaxUrl, ajaxMethod, formData, multiSelect, tabledata, order, savedPageNumber);

		}

	});

	$(document).ready(function () {
		$('#confotmityListTable>.dataTables_scroll>.confotmityList tbody').on('click', 'tr', function () {

			alert('You clicked on');
		});
	});
	function edititem(obj) {
		var url = $(obj).data("url");
		var isurl = $(obj).data("isurl");
		var tableclassname = $(obj).data("tableclassname");
		var ismodal = $(obj).data("ismodal");
		jQuery('.' + tableclassname + ' tr').click(function (e) {
			e.stopPropagation();
			var $this = jQuery(this);
			var trid = $this.closest('tr').attr('id');
			var x = 0, y = 0; // default values
			x = window.screenX + 5;
			y = window.screenY + 275;
			if (isurl === true) {
				window.open(url + "?id=" + trid, '_blank');
			}
		});
	}


	// document.querySelectorAll('.switchery').forEach(function(element) {
	// new Switchery(element);
	// });

</script>
<?php
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/js/scripts/forms/switch.js;';



Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/assets/css/style.css;';
?>