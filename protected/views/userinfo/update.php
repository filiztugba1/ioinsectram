<?php
User::model()->login();

if (Yii::app()->user->checkAccess('staff.detail.view') || ($users->clientid == $ax->clientid)) { ?>
	<section id="headers">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title">
							<?= t('Userinfo List'); ?></h4>
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
					<div class="card-content collapse show">
						<div class="card-body card-dashboard">
							<div class="row">
								<div class="col-xl-3 col-md-6 col-12">
									<div class="card">
										<div class="text-center">
											<div class="card-body">
												<img src="<?php if ($usersinfo->gender == 0) { ?><?= Yii::app()->theme->baseUrl . '/app-assets/images/staff-logo-mr.png'; ?><?php } else { ?><?= Yii::app()->theme->baseUrl . '/app-assets/images/staff-logo-mrs.png'; ?><?php } ?>"
													class="rounded-circle  height-150" alt="Card image">
											</div>

											<?php foreach ($user as $userview) { ?>
												<div class="card-body">
													<h4 class="card-title"><?= $userview->name . ' ' . $userview->surname; ?></h4>

													<h6 class="card-subtitle text-muted">
														<?php if ($userview->type != '1') {
															echo t(Authtypes::model()->find(array('condition' => 'id=' . $userview->type))->name);
														} else {
															echo 'Super Admin';
														} ?>
													</h6>

												</div>

											<?php } ?>
											<!--
			   <div class="text-center">
				  <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
					<span class="fa fa-facebook"></span>
				  </a>
				  <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">
					<span class="fa fa-twitter"></span>
				  </a>
				  <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin">
					<span class="fa fa-linkedin font-medium-4"></span>
				  </a>
				</div>

				-->
										</div>
									</div>
								</div>




								<div class="col-xl-9 col-lg-12">
									<div class="card">
										<div class="card-content">
											<div class="card-body">
												<ul class="nav nav-tabs nav-underline">
													<li class="nav-item">
														<a class="nav-link active" id="baseIcon-tab21" data-toggle="tab"
															aria-controls="tabIcon21" href="#tabIcon21"
															aria-expanded="true"><i class="fa fa-address-card"></i></a>
													</li>
													<li class="nav-item">
														<a class="nav-link" id="baseIcon-tab22" data-toggle="tab"
															aria-controls="tabIcon22" href="#tabIcon22"
															aria-expanded="false"><i class="fa fa-graduation-cap"></i></a>
													</li>
													<li class="nav-item">
														<a class="nav-link" id="baseIcon-tab23" data-toggle="tab"
															aria-controls="tabIcon23" href="#tabIcon23"
															aria-expanded="false"><i class="fa fa-suitcase"></i></a>
													</li>

												</ul>
												<div class="tab-content px-1 pt-1">
													<div role="tabpanel" class="tab-pane active" id="tabIcon21"
														aria-expanded="true" aria-labelledby="baseIcon-tab21">

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('NAME AND SURNAME'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?= $users->name . ' ' . $users->surname; ?></p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Primary Phone'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->primaryphone; ?>
																</p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Secondary Phone'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->secondaryphone; ?>
																</p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('E-mail'); ?></h5>
																<p style="color: #bdbdbd;"><?= $users->email; ?></p>
															</div>

														</div>

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Birth Date'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->birthdate; ?></p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Birth Place'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->birthplace; ?></p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Identification Number'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?= $usersinfo->identification_number; ?></p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Gender'); ?></h5>
																<p style="color: #bdbdbd;"><?php if ($usersinfo->gender == 0) {
																	echo t('Not Gender');
																}
																if ($usersinfo->gender == 1) {
																	echo t('Gender');
																} ?></p>
															</div>

														</div>

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Country'); ?></h5>
																<p style="color: #bdbdbd;"><?php $location = Location::model()->find(array(
																	#'select'=>'title',
																	'condition' => 'id=:id',
																	'params' => array(':id' => $usersinfo->country),
																)); ?></p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Married'); ?></h5>
																<p style="color: #bdbdbd;"><?php if ($usersinfo->marital == 0) {
																	echo t('Single');
																}
																if ($usersinfo->marital == 1) {
																	echo t('Married');
																} ?></p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Children'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->children; ?></p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Blood'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->blood; ?></p>
															</div>




														</div>

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
															<div class="col-6" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Address'); ?></h5>
																<p style="color: #bdbdbd;"><?= $usersinfo->address; ?></p>
															</div>
															<div class="col-6" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Address City'); ?></h5>
																<p style="color: #bdbdbd;">
																</p>
															</div>

														</div>

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Military'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if ($usersinfo && $usersinfo->military == 0) {
																		echo t('No');
																	}
																	if ($usersinfo && $usersinfo->military == 1) {
																		echo t('Yes');
																	} ?>
																</p>
															</div>
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Driving Licance'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if ($usersinfo && $usersinfo->driving_licance == 0) {
																		echo t('No');
																	}
																	if ($usersinfo && $usersinfo->driving_licance == 1) {
																		echo t('Yes');
																	} ?>
																</p>
															</div>




														</div>


													</div>


													<div class="tab-pane" id="tabIcon22" aria-labelledby="baseIcon-tab22">



														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Education'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($education->name)) {
																		echo $education->name;
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Speaks'); ?></h5>
																<p style="color: #bdbdbd;">

																	<?php if (isset($languages->name)) {
																		echo $languages->name;
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Computer Skills'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if ($usersinfo && $usersinfo->computerskills == 0) {
																		echo t('No');
																	}
																	if ($usersinfo && $usersinfo->computerskills == 1) {
																		echo t('Yes');
																	} ?>
																</p>
															</div>


															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Certificate'); ?></h5>
																<p style="color: #bdbdbd;">

																	<?php if (isset($certificate->name)) {
																		echo $certificate->name;
																	} ?>
																</p>
															</div>



														</div>

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">

															<div class="col-12" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Referance'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($usersinfo->referance)) {
																		echo $usersinfo->referance;
																	} ?>
																</p>
															</div>

														</div>

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">



															<div class="col-12" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Projects'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($usersinfo->projects)) {
																		echo $usersinfo->projects;
																	} ?>
																</p>
															</div>

														</div>



													</div>



													<div class="tab-pane" id="tabIcon23" aria-labelledby="baseIcon-tab23">

														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Travel'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if ($usersinfo && $usersinfo->travel == 0) {
																		echo t('No');
																	}
																	if ($usersinfo && $usersinfo->travel == 1) {
																		echo t('Yes');
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Health Problem'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if ($usersinfo && $usersinfo->health_problem == 0) {
																		echo t('No');
																	}
																	if ($usersinfo && $usersinfo->health_problem == 1) {
																		echo t('Yes');
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Health Description'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($usersinfo->health_description)) {
																		echo $usersinfo->health_description;
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Smoking'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if ($usersinfo && $usersinfo->smoking == 0) {
																		echo t('No');
																	}
																	if ($usersinfo && $usersinfo->smoking == 1) {
																		echo t('Yes');
																	} ?>
																</p>
															</div>

														</div>


														<div class="row"
															style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Emergency Name'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($usersinfo->emergencyname)) {
																		echo $usersinfo->emergencyname;
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Emergency Phone'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($usersinfo->emergencyphone)) {
																		echo $usersinfo->emergencyphone;
																	} ?>
																</p>
															</div>

															<div class="col-3" style="border-right: #d8d8d8 1px solid;">
																<h5><?= t('Leave Date'); ?></h5>
																<p style="color: #bdbdbd;">
																	<?php if (isset($usersinfo->leavedate)) {
																		echo $usersinfo->leavedate;
																	} ?>
																</p>
															</div>



														</div>


													</div>


												</div>
											</div>
											<?php if (Yii::app()->user->checkAccess('staff.detail.view')) { ?>
												<a href="<?= Yii::app()->baseUrl ?>/userinfo/index/<?= $usersinfo->id; ?>"
													class="btn btn-primary" style="float:right"
													type="submit"><?= t('Update'); ?></a>
											<?php } ?>
										</div>

									</div>
								</div>


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php } ?>