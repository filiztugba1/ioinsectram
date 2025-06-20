<?php if (Yii::app()->user->checkAccess('workorderlist.view')){
	$ax= User::model()->userobjecty('');
	?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				   <div class="card-header">
                  <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('Report Search');?></h4>
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

			<form id="raports-search" action="/site/reportssearch" method="post">
				<div class="card-content">
					<div class="card-body">


					<div class="row">


					<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Reports[firmid]" onchange="myfirm()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$_GET['firm']){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Reports[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Reports[branchid]" onchange="mybranch()"  disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$_GET['branch']){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Reports[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Team');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id='team' onchange='searchteam()' name="Reports[team]" disabled>
									<option value="0"><?=t('Select');?></option>

								</select>
							</fieldset>
					</div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Staff');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" multiple="multiple" style="width:100%" id='staff' onchange='searchstaff()' name="Reports[staff][]" disabled>
									<option value=""><?=t('Select');?></option>
								</select>
							</fieldset>
					</div>


						<?php if($ax->branchid>0 && $ax->clientid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Route');?></label>
							<fieldset class="form-group">

							  <select class="select2" style="width:100%" id="route" disabled  name="Reports[routeid]" onchange='routeclient()'>
										<option  value="" hidden><?=t('Please Chose');?></option>
										<?php										if($workorder->branchid!=0){
										$route=Route::model()->findall(array('condition'=>'branchid='.$workorder->branchid));
										 foreach($route as $routex){?>
										<option <?php if($routex->id==$workorder->routeid){echo "selected";}?> value="<?=$routex->id;?>"><?=$routex->name;?></option>
										<?php }}?>
								</select>
							</fieldset>
						</div>


					<?php }
					if($ax->clientid>0 && $ax->clientbranchid==0){?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" name="Reports[clientid]" >
								<option value="0"><?=t('Select');?></option>
												<?php $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$ax->clientid));

													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if($clientbranch->id==$_GET['client']){echo "selected";}?> value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
													<?php }?>
							</select>
                        </fieldset>
                    </div>
					<?php }if($ax->clientid==0){?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" name="Reports[clientid]" disabled onchange="myclient()">
								<option value="0"><?=t('Select');?></option>
								<?php								if($workorder->branchid!=0){
								$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$workorder->branchid));

									foreach($client as $clientx)
										{ $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
										if(count($clientbranchs)>0){?>
											<optgroup label="<?=$clientx->name;?>">
												<?php
													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }


									$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
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

									}?>
							</select>
                        </fieldset>
                    </div>
					<?php }?>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Visit Type');?></label>
							<fieldset class="form-group">

							  <select class="select2" style="width:100%" id="visittype"  disabled name="Reports[visittypeid]" >
										<option  value="" hidden><?=t('Please Chose');?></option>
										<?php										if($workorder->branchid!=0){

										$type=Visittype::model()->findall(array('condition'=>'firmid=0 or (branchid=0 and firmid='.$workorder->firmid.') or branchid='.$workorder->branchid));

										$type=Visittype::model()->findall(array('condition'=>'firmid='.$workorder->firmid));

										//$type=Visittype::model()->findall();
										 foreach($type as $typex){?>
										<option <?php if($typex->id==$workorder->visittypeid){echo "selected";}?> value="<?=$typex->id;?>"><?=t($typex->name);?></option>
										<?php }}?>

								</select>
							</fieldset>
						</div>




			<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Start Date');?></label>

						 <input type="date" id='sdate'  class="form-control" <?php if(isset($_GET['sdate']) && $_GET['sdate']!=''){?>value='<?=$_GET['sdate'];?>'<?php }?>   name="Reports[startdate]">


						</fieldset>
					 </div>

					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Finish Date');?></label>

                          <input type="date" id='fdate'  class="form-control" <?php if(isset($_GET['fdate']) && $_GET['fdate']!=''){?>value='<?=$_GET['fdate'];?>'<?php }?>   name="Reports[finishdate]">

						</fieldset>
					 </div>
				 </div>
			 </div>

					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">
									<button class="btn btn-primary" onclick="clicked(); return false;"><?=t('Search');?></button>
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
        <section>
		<?php
		$firmid=$_GET['firm'];
		$branchid=$_GET['branch'];
		$team=$_GET['team'];
		$staff=$_GET['staff'];
		$routeid=$_GET['route'];
		$clientid=$_GET['client'];
		$visittypeid=$_GET['visittype'];
		$startdate=$_GET['sdate'];
		$finishdate=$_GET['fdate'];


		$where='';

		 if($ax->firmid>0){
			 $firmid=$ax->firmid;
		 }

		 if($ax->branchid>0){
			 $branchid=$ax->branchid;
		 }

		  if($ax->clientbranchid>0){
			 $clientid=$ax->clientbranchid;
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
				$where=$where.' and clientid='.$clientid;
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




			$workorder=Workorder::model()->findAll(array(
								   'condition'=>$where,
									));



			?>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('REPORTS');?></h4>
						</div>

					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                              <?php if($ax->firmid==0){?>
								<th><?=t('Firm');?></th>
								<?php }?>

								<?php if($ax->branchid==0){?>
								<th><?=t('Branch');?></th>
								<?php }?>


                            <th><?=t('Start Date');?></th>
							<th><?=t('STAFF/TEAM');?></th>
                            <th><?=t('Route');?></th>
							<th><?=t('Client');?></th>
							<th><?=t('VISITTYPE');?></th>
							<th><?=t('TODO');?></th>
							<th><?=t('MONITORING NO');?></th>
							<th><?=t('EXECUTION DATE');?></th>

                          </tr>
                        </thead>
                        <tbody >
             <?php
			foreach($workorder as $workorderx){?>
               <tr>

				   <?php if($ax->firmid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->firmid))->name;?>
					  </td>
				  <?php }?>
				    <?php if($ax->branchid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->branchid))->name;?>
					  </td>
				  <?php }?>


				  <td>
					<?=$workorderx->date.' '.$workorderx->start_time;?>
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
					 <?php if($workorderx->routeid!='' && $workorderx->routeid!=0){echo Route::model()->find(array('condition'=>'id='.$workorderx->routeid))->name;}?>
				 </td>
				   <td>
				   <?php if($workorderx->clientid!='' && $workorderx->clientid!=0){echo Client::model()->find(array('condition'=>'id='.$workorderx->clientid))->name;}?>
				 </td>
				  <td>
					 <?php if($workorderx->visittypeid!='' && $workorderx->visittypeid!=0){echo Visittype::model()->find(array('condition'=>'id='.$workorderx->visittypeid))->name;}?>
				 </td>
				   <td>
					<?=$workorderx->todo;?>
				  </td>
				  <td>
					<?php $departmentvisited=Departmentvisited::model()->findAll(array(
								   'condition'=>'workorderid='.$workorderx->id,
									));

					foreach($departmentvisited as $departmentvisitedx){
						if($departmentvisitedx->monitoringno!='')
						{
						echo $departmentvisitedx->monitoringno;
						}
					}?>
				  </td>

				   <td>
					<?php					   if($workorderx->executiondate!='')
						{
							echo date("d/m/Y H:i:s", strtotime($workorderx->executiondate));
						}
						else
						{
							echo t('Continues');
						}
					 ?>
				  </td>
				</tr>

		<?php		}?>


                        </tbody>
                        <tfoot>
                          <tr>

						    <?php if($ax->firmid==0){?>
									<th><?=t('Firm');?></th>
									<?php }?>

									<?php if($ax->branchid==0){?>
									<th><?=t('Branch');?></th>
									<?php }?>


															<th><?=t('Start Date');?></th>
								<th><?=t('STAFF/TEAM');?></th>
															<th><?=t('Route');?></th>
								<th><?=t('Client');?></th>
								<th><?=t('VISITTYPE');?></th>
								<th><?=t('TODO');?></th>
								<th><?=t('MONITORING NO');?></th>
								<th><?=t('EXECUTION DATE');?></th>
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

<script>

 function clicked()
  {

		var tarih1Str =document.getElementById("sdate").value.split('-');
		var tarih2Str = document.getElementById("fdate").value.split('-');

		var tarih1Day =tarih1Str[2];
		var tarih1Month =tarih1Str[1];
		var tarih1Year =tarih1Str[0];

		var tarih2Day =tarih2Str[2];
		var tarih2Month =tarih2Str[1];
		var tarih2Year =tarih2Str[0];

		var tarih1 = new Date(tarih1Year,tarih1Month,tarih1Day);
		var tarih2 = new Date(tarih2Year,tarih2Month, tarih2Day);

		if(tarih1Str!='' && tarih2Str!='')
		 {
		   if (tarih1 <= tarih2) {
				$("#raports-search").submit();

		   } else {
			   alert('<?=t("Must be less than or equal to the start date for searching");?>');
			   return false;
		   }
		 }
		 else
		 {
			$("#raports-search").submit();
		 }
  }


$(document).ready(function(){

	/*

	$("#raports-search").on('submit',(function(e) {
		e.preventDefault();
	$.ajax({
      url: "",
      type: "POST",
      data:  new FormData(this),
      contentType:'multipart/form-data',
      cache: false,
      processData:false,
      success: function(data)
        {
		 $('#tableSearch').html(data);
			 $('#dataex-html5-export').destroy();
        }
     });
  }));

*/

  	// Multiple Select Placeholder
    $(".select2-placeholder-multiple").select2({
      placeholder: "<?=t('Select State');?>",
    });

});

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

<?php if(isset($_GET['firm']) && $_GET['firm']!=0 && $_GET['firm']!=''){?>

	$.post( "/workorder/firmbranch?id=<?=$_GET['firm'];?>").done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);

		<?php if(isset($_GET['branch']) && $_GET['branch']!=0 || $_GET['branch']!=''){?>
		$('#branch').val(<?=$_GET['branch'];?>);
		$('#branch').select2('destroy');
				$('#branch').select2({
					closeOnSelect: false,
						 allowClear: true
				});

		$('#branch').val(<?=$_GET['branch'];?>);
		<?php }?>

	});

		$.post( "/workorder/visittype?id=<?=$_GET['firm'];?>").done(function( data ) {
		$( "#visittype" ).prop( "disabled", false );
		$('#visittype').html(data);

		<?php if(isset($_GET['visittype']) && $_GET['visittype']!=0 || $_GET['visittype']!=''){?>
		$('#visittype').val(<?=$_GET['visittype'];?>);
		$('#visittype').select2('destroy');
				$('#visittype').select2({
					closeOnSelect: false,
						 allowClear: true
				});

		$('#visittype').val(<?=$_GET['branch'];?>);
		<?php }?>
	});
<?php }?>


<?php if(isset($_GET['branch']) && $_GET['branch']!=0 && $_GET['branch']!=''){?>
		var staff="<?=$_GET['staff'];?>";
		var team="<?=$_GET['team'];?>";

		$.post( "/workorder/staffteam?id=<?=$_GET['branch'];?>").done(function( data ) {
			if(staff==''){
			$( "#team" ).prop( "disabled", false );
			}
			$('#team').html(data);
				<?php if(isset($_GET['team']) && $_GET['team']!=0 || $_GET['team']!=''){?>
				$('#team').val(<?=$_GET['team'];?>);
				$('#team').select2('destroy');
						$('#team').select2({
							closeOnSelect: false,
								 allowClear: true
						});

				$('#team').val(<?=$_GET['team'];?>);
				<?php }?>
		});




		$.post( "/workorder/staff?id=<?=$_GET['branch'];?>").done(function( data ) {
			if(team==''){
			$( "#staff" ).prop( "disabled", false );
			}
			$('#staff').html(data);

			<?php if(isset($_GET['staff']) && $_GET['staff']!=0 || $_GET['staff']!=''){?>
				$('#staff').val(staff.split(','));
				$('#staff').select2('destroy');
						$('#staff').select2({
							closeOnSelect: false,
								 allowClear: true
						});

				<?php }?>
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});

		$.post( "/workorder/route?id=<?=$_GET['branch'];?>").done(function( data ) {
		$( "#route" ).prop( "disabled", false );
		$('#route').html(data);

		<?php if(isset($_GET['route']) && $_GET['route']!=0 || $_GET['route']!=''){?>
		$('#route').val(<?=$_GET['route'];?>);
		$('#route').select2('destroy');
				$('#route').select2({
					closeOnSelect: false,
						 allowClear: true
				});

		$('#route').val(<?=$_GET['route'];?>);
		<?php }?>

		});

	$.post( "/workorder/client?id=<?=$_GET['branch'];?>").done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
		<?php if(isset($_GET['client']) && $_GET['client']!=0 || $_GET['client']!=''){?>
		$('#client').val(<?=$_GET['client'];?>);
		$('#client').select2('destroy');
				$('#client').select2({
					closeOnSelect: false,
						 allowClear: true
				});

		$('#client').val(<?=$_GET['client'];?>);
		<?php }?>
	});








<?php }?>






function mybranch()
{
		$.post( "/workorder/staffteam?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#team" ).prop( "disabled", false );
			$('#team').html(data);
		});
		$.post( "/workorder/staff?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#staff" ).prop( "disabled", false );
			$('#staff').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});

		$.post( "/workorder/route?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#route" ).prop( "disabled", false );
		$('#route').html(data);
	});

	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
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


function searchteam()
{
	if(document.getElementById("team").value!=0)
	{
		$( "#staff" ).prop( "disabled", true );
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
	}
	else
	{
		$( "#team" ).prop( "disabled", false );
	}
}







<?php if($ax->branchid==0){?>
	$( "#route" ).prop( "disabled", true );

<?php }?>

<?php if($ax->branchid!=0 && ($_GET['branch']==0 || $_GET['branch']=='')){?>

		$.post( "/workorder/staffteam?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#team" ).prop( "disabled", false );
			$('#team').html(data);
		});
		$.post( "/workorder/staff?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#staff" ).prop( "disabled", false );
			$('#staff').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});

		$.post( "/workorder/route?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#route" ).prop( "disabled", false );
			$('#route').html(data);
		});

		$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#client" ).prop( "disabled", false );
			$('#client').html(data);
		});
<?php }?>


<?php if($ax->firmid!=0 &&(isset($_GET['firm']) && $_GET['firm']==0 || $_GET['firm']=='')){?>
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});

		$.post( "/workorder/visittype?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#visittype" ).prop( "disabled", false );
		$('#visittype').html(data);
	});
<?php }?>


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
                 columns: [ 2,3,4,5,6,7,8,9]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t("Reports")?> (<?=date("d-m-Y H:i:s");?>)\n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [ 2,3,4,5,6,7,8,9]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t("Reports")?> (<?=date("d-m-Y H:i:s");?>)\n',
        },



		{
             extend: 'pdfHtml5',
			orientation: 'landscape',
            pageSize: 'LEGAL',
			 exportOptions: {
				 <?php if($ax->firmid==0){?>
                columns: [ 0,1,2,3,4,5,6,7,8,9],
				<?php }
				 else if($ax->branch==0){?>
                columns: [ 1,2,3,4,5,6,7,8,9],
				<?php }
				 else{?>
                columns: [ 2,3,4,5,6,7,8,9],
				<?php }?>
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: '<?=t("Reports")?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t("Reports")?> \n',
					bold: true,
					fontSize: 16,
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
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/switch.js;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';



?>
