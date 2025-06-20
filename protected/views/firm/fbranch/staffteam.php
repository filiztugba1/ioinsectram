<?php User::model()->login(); ?>

<!-- Sayfada neredeyiz -->
<?= User::model()->geturl('Firm', 'Staff Team', $_GET['id'], 'firm'); ?>


<div class="card">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
				<div class="card-header" style="">
					<ul class="nav nav-tabs">
						<?php if ($type == "firm") { ?>
							<li class="nav-item">
								<a class="nav-link " href="<?= Yii::app()->baseUrl; ?>/firm/branch?type=<?= $type; ?>&&id=<?= $_GET['id']; ?>"><span
										class="btn-effect2"
										style="font-size: 15px;"><?php echo count($firm); ?></span><?= t('Branch'); ?></a></a>
							</li>
						<?php } ?>

						<li class="nav-item">
							<a class="nav-link " href="<?= Yii::app()->baseUrl; ?>/firm/staff?type=<?= $type; ?>&&id=<?= $_GET['id']; ?>"><span
									class="btn-effect2" style="font-size: 15px;">
									<?= count($say); ?>
								</span><?= t('Staff'); ?></a></a>
						</li>


						<?php if ($type == "branch" && $ax->branchid == 0) { ?>
							<li class="nav-item">
								<a class="nav-link active"
									href="<?= Yii::app()->baseUrl; ?>/firm/staffteam?type=<?= $type; ?>&&id=<?= $_GET['id']; ?>"><span class="btn-effect2"
										style="font-size: 15px;"><?php echo count($staffteams); ?></span><?= t('Staffteam'); ?></a></a>
							</li>
						<?php } ?>

						<?php if ($type == "branch" && $ax->branchid == 0) { ?>
							<li class="nav-item">
								<a class="nav-link " href="<?= Yii::app()->baseUrl; ?>/firm/client?type=<?= $type; ?>&&id=<?= $_GET['id']; ?>"><span
										class="btn-effect2"
										style="font-size: 15px;"><?php echo count($client) + count($tclient); ?></span><?= t('Client'); ?></a></a>
							</li>
						<?php } ?>
						<?php if ($type == "branch" && $ax->branchid == 0 && ($ax->id = 1 or $ax->id = 317)) { ?>
								<li class="nav-item">
									<a class="nav-link " href="<?= Yii::app()->baseUrl; ?>/firm/reports?firmid=<?= $_GET['id']; ?>&type=branch">
										<span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o"
												style="font-size: 15px;"></i></span><?= t('Reports'); ?></a>
								</li>
							<?php } ?>

					</ul>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row" id="createpage">
	<div class="col-xl-12 col-lg-12 col-md-12">

		<div class="card">
			<div class="card-header">
				<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					<div class="col-md-6">
						<h4 class="card-title"><?= t('New Team Create'); ?></h4>
					</div>
					<div class="col-md-6">
						<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i
								class="fa fa-times"></i></button>
					</div>
				</div>
			</div>

			<form id="staffcreate-form" action="<?= Yii::app()->baseUrl; ?>/staffteam/create" method="post">
				<div class="card-content">
					<div class="card-body">

						<input type="hidden" class="form-control" id="basicInput" name="Staffteam[firmid]"
							value="<?= $_GET['id']; ?>">
						<input type="hidden" class="form-control" id="basicInput" name="Staffteam[type]" value="firm">





						<div class="row">



							<div class="col-xl-5 col-lg-5 col-md-5 mb-1">
								<label for="basicSelect"><?= t('Team Name'); ?></label>
								<fieldset class="form-group">
									<input type="text" class="form-control" id="teamname"
										placeholder="<?= t('Team Name'); ?>" name="Staffteam[teamname]" required>
								</fieldset>
							</div>


							<div class="col-xl-2 col-lg-2 col-md-2 mb-1">
								<label for="basicSelect"><?= t('TEAM COLOR'); ?></label>
								<fieldset class="form-group">
									<input value="ffcc00" id='color' onchange='colorchange()'
										class="form-control jscolor {position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"
										name="Staffteam[color]" required>
								</fieldset>
							</div>



							<div class="col-xl-5 col-lg-5 col-md-5 mb-1">
								<label for="basicSelect"><?= t('TEAM LEADER'); ?></label>
								<fieldset class="form-group">

									<select class="select2" style="width:100%" id="leader" onchange="staff()"
										name="Staffteam[leaderid]" required>
										<option value="AK"><?= t('Please Chose'); ?></option>

										<?php //lite paket için
										
										if ($ax->firmid != 0) {
											$firm = Firm::model()->find(array('condition' => 'id=' . $ax->firmid));
											$liteuser = User::model()->find(array('condition' => 'branchid=0 and firmid=' . $ax->firmid));
											if ($firm->package == 'Packagelite') {
												echo '<option value="<?= $ax->id; ?>"><?= $liteuser->name; ?></option>';
											}
										}
							
										foreach ($user as $userx) {
											echo '<option value="' . $userx->id . '">' . $userx->name . ' ' . $userx->surname . '</option>';
										}
										?>
									</select>
								</fieldset>
							</div>


							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?= t('Staff'); ?></label>
								<fieldset class="form-group">
									<select class="select2-placeholder-multiple form-control" multiple="multiple"
										id="leaderstaff" style="width:100%;" name="Staffteam[staff][]" required>

										<?php //lite paket için
										
										if ($ax->firmid != 0) {
											$firm = Firm::model()->find(array('condition' => 'id=' . $ax->firmid));
											$liteuser = User::model()->find(array('condition' => 'branchid=0 and firmid=' . $ax->firmid));
											if ($firm->package == 'Packagelite') {
												echo '<option value="' . $ax->id . '">' . $liteuser->name . '</option>';
											}
										}

										 foreach ($user as $userx) {
											echo '<option value="' . $userx->id . '">' . $userx->name . ' ' . $userx->surname . '</option>';
										} ?>

										</optgroup>
									</select>
								</fieldset>
							</div>



							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<label for="basicSelect" style="margin-top:15px"></label>
								<fieldset class="form-group">
									<div class="input-group-append" id="button-addon2">
										<button class="btn btn-primary" onclick="clicked(); return false;"
											type="submit"><?= t('Create'); ?></button>
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






<!-- HTML5 export buttons table -->

<section id="html5">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
						<div class="col-xl-8 col-lg-8 col-md-8 mb-1">
							<h4 class="card-title"><?= t('TEAM LIST'); ?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('staffteam.create')) { ?>
							<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton"
										type="submit"><?= t('Team Registration'); ?> <i class="fa fa-plus"></i></button>
								</div>

							</div>
						<?php } ?>



					</div>
					<a href='?type=<?= $_GET['type']; ?>&&id=<?= $_GET['id']; ?>&&status=2'
						class="btn btn-danger btn-sm <?= $isActive == 2 ? 'isActive' : ''; ?>" style='float:right'
						type="submit"><?= t('Passive'); ?> </a>

					<a href='?type=<?= $_GET['type']; ?>&&id=<?= $_GET['id']; ?>&&status=1'
						class="btn btn-success btn-sm <?= $isActive == 1 ? 'isActive' : ''; ?>" style='float:right'
						type="submit"><?= t('Active'); ?> </a>
					<a href='?type=<?= $_GET['type']; ?>&&id=<?= $_GET['id']; ?>&&status=0'
						class="btn btn-warning btn-sm <?= $isActive == 0 ? 'isActive' : ''; ?>" style='float:right'
						type="submit"><?= t('All'); ?> </a>

				</div>

				<div class="card-content collapse show">
					<div class="card-body card-dashboard">

						<table class="table table-striped table-bordered dataex-html5-export">
							<thead>
								<tr>
									<th style='width:1px;'><input type="checkbox" name="select_all" value="1"
											id="select_all"></th>
									<th><?= t('Name'); ?></th>
									<th><?= t('TEAM LEADER'); ?></th>
									<th><?= t('Team Staff'); ?></th>
									<th><?= t('TEAM COLOR'); ?></th>
									<th><?= t('Active'); ?></th>
									<th><?= t('PROCESS'); ?></th>


								</tr>
							</thead>
							<tbody>

								<?php foreach ($staffteams as $staffteam): ?>
									<tr>
										<td><input type="checkbox" name="Staffteam[id][]" class='sec'
												value="<?= $staffteam['id']; ?>"></td>
										<td><?= $staffteam->teamname; ?></td>
										<td><?= $staffteam['name'] . ' ' . $staffteam['surname']; ?></td>


										<?

										$bolstaff = explode(",", $staffteam->staff);
										?>

										<td>
											<?
											for ($i = 0; $i < count($bolstaff); $i++) {
												$tbstaff = User::model()->find(array(
													'select' => 'name,surname',
													'condition' => 'id=' . $bolstaff[$i],
												));
												?>
												<?= $tbstaff->name . ' ' . $tbstaff->surname . ' - '; ?>
												<!--<button class="btn btn-info btn-sm" id="createbutton" type="submit"></button>-->
												<?

											}
											?>
											<?= $tbusers->name . ' ' . $tbusers->surname; ?>

											<?
											?>
										</td>

										<td>
											<div
												style="width: 52px;height: 18px; border-radius: 5px;background:<?= '#' . $staffteam->color; ?>">
											</div>
										</td>



										<td>
											<div class="form-group pb-1">
												<input type="checkbox" id="switchery" data-size="sm" class="switchery"
													data-id="<?= $staffteam->id; ?>" <?php if ($staffteam->active == 1) {
														echo "checked";
													} ?> 	<?php if ($staffteam->active == 1) {
															 echo "checked";
														 } ?> 	<?php if (Yii::app()->user->checkAccess('staffteam.update') == 0) { ?>disabled<?php } ?> />
											</div>
										</td>


										<td>
											<div class='row'>

												<?php if (Yii::app()->user->checkAccess('staffteam.update')) { ?>
													<a class="btn btn-warning btn-sm" onclick="openmodal(this)"
														style='margin-right:2px' data-id="<?= $staffteam->id; ?>"
														data-teamname="<?= $staffteam->teamname; ?>"
														data-leaderid="<?= $staffteam->leaderid; ?>"
														data-staff="<?= implode(',', $bolstaff) ?>,"
														data-color="<?= $staffteam->color; ?>"><i style="color:#fff;"
															class="fa fa-edit"></i></a>
												<?php } ?>


												<?php if (Yii::app()->user->checkAccess('staffteam.delete')) { ?>
													<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)"
														data-id="<?= $staffteam->id; ?>"><i style="color:#fff;"
															class="fa fa-trash"></i></a>

												<?php } ?>
											</div>
										</td>



									</tr>

								<?php endforeach; ?>

							</tbody>
							<tfoot>
								<tr>
									<th style='width:1px;'>
										<?php if (Yii::app()->user->checkAccess('staffteam.delete')) { ?>
											<div class="input-group-append" id="button-addon2"
												style="float: right; text-align: right;">
												<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit"
													data-toggle="tooltip" data-placement="top" title=""
													data-original-title="<?= t('Delete selected'); ?>"><i
														class="fa fa-trash"></i></button>
											</div>
										<?php } ?>
									</th>
									<th><?= t('Name'); ?></th>
									<th><?= t('TEAM LEADER'); ?></th>
									<th><?= t('Team Staff'); ?></th>
									<th><?= t('TEAM COLOR'); ?></th>
									<th><?= t('Active'); ?></th>
									<th><?= t('PROCESS'); ?></th>

								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>






<!-- GÜNCELLEME BAŞLANGIÇ-->
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="form-group">
		<!-- Modal -->
		<div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-warning white">
						<h4 class="modal-title" id="myModalLabel8"><?= t('User Update'); ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<!--form baslangıç-->
					<form id="user-form" action="/staffteam/update/0" method="post">
						<div class="modal-body">
							<input type="hidden" class="form-control" id="modalstaffid" name="Staffteam[id]" value="0">
							<input type="hidden" class="form-control" id="basicInput" name="Staffteam[firmid]"
								value="<?= $_GET['id']; ?>">
							<input type="hidden" class="form-control" id="basicInput" name="Staffteam[type]"
								value="firm">

							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?= t('Team Name'); ?></label>
								<fieldset class="form-group">
									<input type="text" class="form-control" id="modalstaffname"
										placeholder="<?= t('Team Name'); ?>" name="Staffteam[teamname]" required>
								</fieldset>
							</div>


							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?= t('TEAM COLOR'); ?></label>
								<fieldset class="form-group">
									<input id='color2' onchange='colorchange2()'
										class="form-control jscolor {position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"
										name="Staffteam[color]" required>
								</fieldset>
							</div>



							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?= t('TEAM LEADER'); ?></label>
								<fieldset class="form-group">
									<select class="select2 form-control" style="width:100%;" id="modalstaffleaderid"
										onchange='staff2()' name="Staffteam[leaderid]" required>

										<? foreach ($user as $userx) { ?>
											<option value="<?= $userx->id; ?>"><?= $userx->name . ' ' . $userx->surname; ?></option>
										<?php } ?>


										</optgroup>
									</select>
								</fieldset>
							</div>


							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?= t('Staff'); ?></label>
								<fieldset class="form-group">
									<select class="select2-placeholder-multiple form-control" value="1"
										id="modalstaffstaff" multiple="multiple" style="width:100%;"
										name="Staffteam[staff][]" required>

										<? foreach ($user as $userx) { ?>
											<option value="<?= $userx->id; ?>"><?= $userx->name . ' ' . $userx->surname; ?></option>
										<?php } ?>

										</optgroup>
									</select>
								</fieldset>
							</div>



						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary"
								data-dismiss="modal"><?= t('Close'); ?></button>
							<button class="btn btn-warning block-page-update" type="submit"><?= t('Update'); ?></button>
						</div>

					</form>

					<!--form bitiş-->
				</div>
			</div>
		</div>
	</div>
</div>


<!-- GÜNCELLEME BİTİŞ-->

<!--SİL BAŞLANGIÇ-->

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="form-group">
		<!-- Modal -->
		<div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger white">
						<h4 class="modal-title" id="myModalLabel8"><?= t('Staffteam Delete'); ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<!--form baslangıç-->
					<form id="user-form" action="/staffteam/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalstaffid2" name="Staffteam[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput" name="Staffteam[firmid]"
							value="<?= $_GET['id']; ?>">
						<input type="hidden" class="form-control" id="basicInput" name="Staffteam[type]" value="firm">
						<div class="modal-body">

							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<h5> <?= t('Do you want to delete?'); ?></h5>
							</div>



						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary"
								data-dismiss="modal"><?= t('Close'); ?></button>
							<button class="btn btn-danger block-page-delete" type="submit"><?= t('Delete'); ?></button>
						</div>

					</form>

					<!--form bitiş-->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- SİL BİTİŞ -->

<!--delelete all start-->

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="form-group">
		<!-- Modal -->
		<div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger white">
						<h4 class="modal-title" id="myModalLabel8"><?= t('Staffteam Delete'); ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<!--form baslangıç-->
					<form action="/firm/teamdeleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Staffteam[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput" name="Staffteam[firmid]"
							value="<?= $_GET['id']; ?>">

						<div class="modal-body">

							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<h5><?= t('Are you sure you want to delete?'); ?></h5>
							</div>



						</div>
						<div class="modal-footer">
							<button type="button" class="btn grey btn-outline-secondary "
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

<!-- delete all finish -->




<style>
	.switchery,
	.switch {
		margin-left: auto !important;
		margin-right: auto !important;
	}

	.isActive {
		box-shadow: 0px 0px 4px 0px #000;
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


	function authchange(data, permission, obj) {
		//alert(data);
		$.post("?id=<?= $_GET['id'] ?>", { id: data, active: permission })
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



	function clicked() {

		var color = document.getElementById("color").value;
		$.post("/staffteam/color?ara=" + color + '&&branch=' + <?= $_GET['id']; ?>).done(function (data) {
			//$('#staffteam').html(data);
			if (data == 1) {
				alert("<?= t('This color is available. Please choose a different color.'); ?>");
				return false;
			}
			else {
				$("#staffcreate-form").submit();
			}
		});
	}
	//delete all start
	$(document).ready(function () {
		$('#select_all').on('click', function () {
			if (this.checked) {
				$('.sec').each(function () {
					this.checked = true;
				});
			} else {
				$('.sec').each(function () {
					this.checked = false;
				});
			}
		});

		$('.sec').on('click', function () {
			if ($('.sec:checked').length == $('.sec').length) {
				$('#select_all').prop('checked', true);
			} else {
				$('#select_all').prop('checked', false);
			}
		});
	});

	function deleteall() {
		var ids = [];
		$('.sec:checked').each(function (i, e) {
			ids.push($(this).val());
		});
		$('#modalid3').val(ids);
		if (ids == '') {
			alert("<?= t('You must select at least one of the checboxes!'); ?>");
		}
		else {
			$('#deleteall').modal('show');
		}

	}
	// delete all finish


	//color change	start

	function colorchange() {
		var color = document.getElementById("color").value;
		$.post("/staffteam/color?ara=" + color + '&&branch=' + <?= $_GET['id']; ?>).done(function (data) {
			//$('#staffteam').html(data);
			if (data == 1) {
				alert("<?= t('This color is available. Please choose a different color.'); ?>");
			}
		});

	}

	function colorchange2() {
		var color = document.getElementById("color").value;
		$.post("/staffteam/color?ara=" + color + '&&branch=' + <?= $_GET['id']; ?>).done(function (data) {
			//$('#staffteam').html(data);
			if (data == 1) {
				alert("<?= t('This color is available. Please choose a different color.'); ?>");
			}
		});

	}
	//color change finish



	$(document).ready(function () {
		$('.block-page-create').on('click', function () {

			var teamname = document.getElementById("teamname").value;
			var color = document.getElementById("color").value;
			var leaderstaff = document.getElementById("leaderstaff").value;
			var leader = document.getElementById("leader").value;
			if (teamname != '' && color != '' && leaderstaff != '' && leader != '') {
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
			}

		});

		$('.block-page-update').on('click', function () {

			var teamname = document.getElementById("modalstaffname").value;
			var color = document.getElementById("modalstaffcolor").value;
			var leaderstaff = document.getElementById("modalstaffstaff").value;
			var leader = document.getElementById("modalstaffleaderid").value;
			if (teamname != '' && color != '' && leaderstaff != '' && leader != '') {
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
			}

		});

		$('.block-page-delete').on('click', function () {
			var teamname = document.getElementById("modalstaffname").value;
			var color = document.getElementById("modalstaffcolor").value;
			var leaderstaff = document.getElementById("modalstaffstaff").value;
			var leader = document.getElementById("modalstaffleaderid").value;
			if (teamname != '' && color != '' && leaderstaff != '' && leader != '') {
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
			}

		});

	});

	function staff() {

		$.post("/staffteam/teamleader?id=" + document.getElementById("leader").value + "&&branch=<?= $_GET['id']; ?>").done(function (data) {
			$('#leaderstaff').html(data);
		});
	}

	function staff2() {

		$.post("/staffteam/teamleader?id=" + document.getElementById("modalstaffleaderid").value + "&&branch=<?= $_GET['id']; ?>").done(function (data) {
			$('#modalstaffstaff').html(data);
		});
	}


	function openmodal(obj) {
		$('#modalstaffid').val($(obj).data('id'));
		$('#modalstaffname').val($(obj).data('teamname'));
		$('#modalstaffleaderid').val($(obj).data('leaderid'));
		$('#modalstaffleaderid').select2('destroy');
		$('#modalstaffleaderid').select2({
			closeOnSelect: false,
			allowClear: true
		});


		$('#modalstaffstaff').val($(obj).data('staff').split(','));
		$('#modalstaffstaff').select2('destroy');
		$('#modalstaffstaff').select2({
			closeOnSelect: false,
			allowClear: true
		});

		$('#color2').val($(obj).data('color'));

		$('#duzenle').modal('show');

	}



	function openmodalsil(obj) {
		$('#modalstaffid2').val($(obj).data('id'));
		$('#sil').modal('show');

	}


	//staff search	start
	$(function () {
		$('#staffsearch').keyup(function () {
			staff = document.getElementById("staffsearch").value;
			$.post("/user/staffsearch?ara=" + staff).done(function (data) {
				$('#staffteam').html(data);

			});
		});
	});
	//staff search finish

	//checkbox database start
	/*
	function authchange(data,permission,obj)
	{
	$.post( "?", { userid: data, active: permission })
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
	
	*/

	//checkbox database finish


	$(document).ready(function () {

		$('.select2-placeholder-multiple').select2({
			closeOnSelect: false,
			allowClear: true
		});


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
						columns: [1, 2, 3]
					},
					text: '<?= t('Copy'); ?>',
					className: 'd-none d-sm-none d-md-block',
					title: 'Staff Team (<?= date('d-m-Y'); ?>)',
					messageTop: '<?= User::model()->table('branch', $_GET['id']); ?>'
				},
				{
					extend: 'excelHtml5',
					exportOptions: {
						columns: [1, 2, 3]
					},
					text: '<?= t('Excel'); ?>',
					className: 'd-none d-sm-none d-md-block',
					title: 'Staff Team (<?= date('d-m-Y'); ?>)',
					messageTop: '<?= User::model()->table('branch', $_GET['id']); ?>'
				},


				{
					extend: 'pdfHtml5',
					exportOptions: {
						columns: [1, 2, 3]
					},
					text: '<?= t('PDF'); ?>',
					//message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
					title: 'Export',
					header: true,
					customize: function (doc) {
						doc.content.splice(0, 1, {
							text: [{
								text: 'Staff Team \n',
								bold: true,
								fontSize: 16,
								alignment: 'center'
							},
							{
								text: '<?= User::model()->table('branch', $_GET['id']); ?> \n',
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
		<?
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
</style>


<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<?php
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/js/scripts/forms/switch.js;';

Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/js/scripts/forms/select/form-select2.js;';


Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/select/select2.full.min.js;';
//Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/assets/css/style.css;';


Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/forms/selects/select2.min.css;';

Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/assets/js/jscolor.js;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;'; ?>