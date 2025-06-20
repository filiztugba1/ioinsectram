<?php

User::model()->login();
$ax= User::model()->userobjecty('');
if (Yii::app()->user->checkAccess('workorder.view')){
	$who=User::model()-> whopermission();
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


<?=User::model()->geturl('Workorder',$date,0,'workorder',1);?>

<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Date Copy');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

		<form id="date">
				<div class="card-content">
					<div class="card-body">


					<div class="row">


					<?php if($ax->firmid==0){?>
						<div class="<?=$class;?> mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Workorder[firmid]" onchange="myfirm()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Workorder[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="<?=$class;?> mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Workorder[branchid]" onchange="mybranch()"  disabled requred>
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
							<input type="hidden" class="form-control" id="branch" name="Workorder[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>
						
						
										

					<?php					if(isset($_GET['id']) && $_GET['id']!="")
					{
						$workorder=Workorder::model()->find(array('condition'=>'id='.$_GET['id']));
					}

						if(isset($_GET['date']) && $_GET['date']!="")
						{
							 $data=explode('-',$_GET['date']);
							 $data=$data[1].'/'.$data[2].'/'.$data[0];
						}
					?>




						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
							<label for="basicSelect"><?=t('Months to be copied');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" name="Workorder[datemonth]" requred>
										<option value="01"><?=t('January');?></option>
										<option value="02"><?=t('February');?></option>
										<option value="03"><?=t('March');?></option>
										<option value="04"><?=t('April');?></option>
										<option value="05"><?=t('May');?></option>
										<option value="06"><?=t('June');?></option>
										<option value="07"><?=t('July');?></option>
										<option value="08"><?=t('August');?></option>
										<option value="09"><?=t('September');?></option>
										<option value="10"><?=t('October');?></option>
										<option value="11"><?=t('November');?></option>
										<option value="12"><?=t('December');?></option>
								</select>
							</fieldset>
					</div>





					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
							<label for="basicSelect"><?=t('Year to be copied');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" name="Workorder[dateyear]" requred>
									<?php for($i=date('Y');$i<2100;$i++){?>
									<option value="<?=$i;?>"><?=$i;?></option>
									<?php }?>
								</select>
							</fieldset>
					</div>

				<!--
					 <div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					 <label for="basicSelect"><?=t('Date Start');?></label>
                        <fieldset class="form-group">
								<div class="form-group">
								<div class="input-group">
								  <input type="text" class="form-control singledate" id="date_start" name="Workorder[date_start]" value="" requred>
								  <div class="input-group-append">
									<span class="input-group-text">
									  <span class="fa fa-calendar"></span>
									</span>
								  </div>
								</div>
							  </div>
						</div>




                	<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					 <label for="basicSelect"><?=t('Date Finish');?></label>
                        <fieldset class="form-group">
								<div class="form-group">
								<div class="input-group">
								  <input type="text" class="form-control singledate" id="date_finish"  name="Workorder[date_finish]" value="" requred>
								  <div class="input-group-append">
									<span class="input-group-text">
									  <span class="fa fa-calendar"></span>
									</span>
								  </div>
								</div>
							  </div>
						</div>

						-->





					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
						<label for="basicSelect"><?=t('Which Months Should You Copy');?></label>
                        <fieldset class="form-group">
                          <select class="select2-placeholder-multiple form-control" multiple="multiple" id="multi_placehodler" style="width:100%;" name="Workorder[month][]">
								<option value="january"><?=t('January');?></option>
								<option value="february"><?=t('February');?></option>
								<option value="march"><?=t('March');?></option>
								<option value="april"><?=t('April');?></option>
								<option value="may"><?=t('May');?></option>
								<option value="june"><?=t('June');?></option>
								<option value="july"><?=t('July');?></option>
								<option value="august"><?=t('August');?></option>
								<option value="september"><?=t('September');?></option>
								<option value="october"><?=t('October');?></option>
								<option value="november"><?=t('November');?></option>
								<option value="december"><?=t('December');?></option>

							  </select>
                        </fieldset>
                    </div>



					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Which Year Should You Copy');?></label>
                          <input type="number"  class="form-control" min="2017" max="2100" value="<?=date('Y');?>"  placeholder="<?=t('YYYY');?>" name="Workorder[year]">
                        </fieldset>
                    </div>



					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float: right;">
									<button class="btn btn-primary"  type="submit"><?=t('Copy');?></button>
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




<div class="content-body">
        <!-- Full calendar events example section start -->
        <section id="events-examples">
          <div class="row">
            <div class="col-12">
              <div class="card">
               <div class="card-header">
                  <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('Calender');?></h4>
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

				  <div class="row" style='padding: 10px 10px 1px 10px;border: 1px solid #d9d7d7;margin-top: 10px;background: #fef9f9;border-radius: 4px;'>
				  <?php				  $col='';
				  if($ax->firmid==0 && $ax->branchid==0 ){
					  $col=3;
				  }
				  else if($ax->firmid>0 && $ax->branchid==0 ){
					  $firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
					  if($firm->package=='Packagelite')
					  {
						  $col=6;
					  }
					  else
					  {
						$col=4;
					  }

				  }
				  else
				  {
					   $col=6;
				  }
				  ?>




						<?php if($ax->firmid==0){?>
						<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
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
						<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
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

	<?php if($ax->clientid==0){
								?>
							<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
											<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">
                          <select class="select2-placeholder-multiple form-control" style="width:100%" id="client2" name="Conformity[clientid]" onchange="myclient()"  multiple="multiple" <?=$ax->branchid==0?'disabled':'';?>>
														<option value="0"><?=t("Select");?></option>
														<?php														if($ax->branchid!=0){
															$client=Client::model()->findall(array('condition'=>'isdelete=0 and firmid='.$ax->branchid));
															foreach($client as $clientx)
															{?>
																<option <?php if($ax->clientid==$clientx->id){echo "selected";}?> value="<?=$clientx->id;?>"><?=$clientx->name;?></option>
															<?php }
															$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
															foreach($tclient as $tclientx){
															?>
																<option <?php if($ax->clientid==$tclientx->id){echo "selected";}?> value="<?=$tclientx->id;?>"><?=$tclientx->name;?></option>
															<?php															}
														}?>
													</select>
                        </fieldset>
                    	</div>
										<?php }?>
										
										
										
											<?php if($ax->clientbranchid==0){
								?>
							<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
											<label for="basicSelect"><?=t('Client Branch');?></label>
                        <fieldset class="form-group">
                          <select class="select2-placeholder-multiple form-control" style="width:100%" id="client3" name="Conformity[clientid]" disabled multiple="multiple">
														<option value="0"><?=t("Select");?></option>
														<?php														if ($ax->clientid<>0){
														$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$ax->clientid));
                              }else{
                              $clientbranchs=[];
                            }
														foreach($clientbranchs as $clientbranch)
																		{?>
																			<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
																		<?php }?>
													</select>
                        </fieldset>
                    	</div>
										<?php }?>
										
										
				  	<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
						<label for="basicSelect"><?=t('Team');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id='team' onchange='searchteam()' name="Workorder[branchid]" disabled>
									<option value="0"><?=t('Select');?></option>

								</select>
							</fieldset>
					</div>



					<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
						<label for="basicSelect"><?=t('Staff');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" multiple="multiple" style="width:100%" id='staff' onchange='searchstaff()' name="Workorder[branchid][]" disabled>
									<option value=""><?=t('Select');?></option>
								</select>
							</fieldset>
					</div>
            <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Start Date');?></label>
             <?php  if (isset($_GET['startDate']) && $_GET['startDate']<>''){
  $startdate=$_GET['startDate'];
  $enddate=$_GET['endDate'];
    }else{
   $startdate=date("Y",strtotime("-1 year"))."-01-01";
   $enddate=date("Y-m-d",strtotime("+1 year"));
    
  }
  ?>
	            <input id="startDate" type="date" class="form-control" placeholder="<?=t('Start Date');?>" name="Workorder[startdate]" value="<?=$startdate?>">
            </fieldset>
          </div>
            <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('End Date');?></label>
	            <input id="endDate" type="date" class="form-control" placeholder="<?=t('End Date');?>" name="Workorder[enddate]" value="<?=$enddate?>">
            </fieldset>
          </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" id='labelcolor'></label>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style=' border: 1px solid #aaa;border-radius: 5px;padding: 13px 15px 15px 15px;' id='stcolor'>

							<?php if(isset($_GET['t']) && $_GET['t']!='')
							{
							$branch=Staffteam::model()->find(array('condition'=>'id='.$_GET['t']));?>
							<?=$branch->teamname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
							<?php }?>

							<?php if(isset($_GET['s']) && $_GET['s']!='')
							{
							$staff=explode(',',$_GET['s']);
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


				  </div>



                </div>
                <div class="card-content collapse show">
                  <div class="card-body">



                    <div id='fc-bg-events'></div>
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
	  $client='';
	  $clientbranch='';
	  if(isset($_GET['s']) && $_GET['s']!=''){$staff=$_GET['s'];}
	  if(isset($_GET['c']) && $_GET['c']!=''){$client=$_GET['c'];}
	  if(isset($_GET['cb']) && $_GET['cb']!=''){$clientbranch=$_GET['cb'];}
	  ?>
<script>

$( "#stcolor" ).hide();


var firm='';
var branch='';
var staff='';
var team='';
var client='';
var clientbranch='';
<?php if(isset($_GET['f'])){?>firm=<?=$_GET['f'];?>;<?php }?>
<?php if(isset($_GET['b']) && $_GET['b']!=''){?>branch=<?=$_GET['b'];?>;<?php }?>
<?php if($staff!=''){?>staff="<?=$staff;?>";<?php }?>
<?php if($client!=''){?>client="<?=$client;?>";<?php }?>
<?php if($clientbranch!=''){?>clientbranch="<?=$clientbranch;?>";<?php }?>
<?php if(isset($_GET['t']) && $_GET['t']!=''){?>team=<?=$_GET['t'];?>;<?php }?>


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
			
				//staff
		$.post( "/workorder/mainclient?id="+branch).done(function( data ) {
			
			$('#client2').html(data);
				if(client!=''){
					$( "#client2" ).prop( "disabled", false );
				$('#client2').val(client.split(','));
				$('#client2').select2('destroy');
				$('#client2').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				
				$.post( "/workorder/clientbranch?fid="+firm+"&id="+client).done(function( data ) {
					$('#client3').html(data);
					$( "#client3" ).prop( "disabled", false );
					if(clientbranch!=''){
				$('#client3').val(clientbranch.split(','));
				$('#client3').select2('destroy');
				$('#client3').select2({
					closeOnSelect: false,
						 allowClear: true
				});
					}
				});
		
				
	
			}
			
		});
			
				//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

			$.post( "/workorder/staffteam?id="+branch).done(function( data ) {
				$('#team').html(data);
				$('#team').val(team);
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


<?php if($ax->firmid!=0 && !isset($_GET['f'])){?>
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
<?php }?>

<?php if($ax->branchid!=0 && !isset($_GET['f'])){?>

	$.post( "/workorder/staffteam?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#team" ).prop( "disabled", false );
			$('#team').html(data);
		});
		$.post( "/workorder/staff?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#staff" ).prop( "disabled", false );
			$('#staff').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});
<?php }?>


<?php if($ax->branchid==0 && !isset($_GET['f']) &&!isset($_GET['b'])){
		if($firm->package=='Packagelite')
		{?>
			$.post( "/workorder/staffteam?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#team" ).prop( "disabled", false );
			$('#team').html(data);
			});
			$.post( "/workorder/staff?id="+document.getElementById("branch2").value).done(function( data ) {
				$( "#staff" ).prop( "disabled", false );
				$('#staff').html(data);
			//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
			});
		<?php }
	}
?>


<?php
  

$urlx="/workorder/workorderlist";
 if (isset($_GET) &&(isset($_GET['f']) || isset($_GET['b']))) {
		$urlx="/workorder/workorderlist?f=".$_GET['f']."&b=".$_GET['b']."&c=".$_GET['c']."&cb=".$_GET['cb']."&t=".$_GET['t']."&s=".$_GET['s']."&startDate=".$_GET['startDate']."&endDate=".$_GET['endDate'];
}?>


$("#search").click(function(){
	var f=document.getElementById("firm2").value;
	var b=document.getElementById("branch2").value;
	var startDate=document.getElementById("startDate").value;
	var endDate=document.getElementById("endDate").value;
	
	var t=t=document.getElementById("team").value;
	 var Secilenler = "";
            $('#staff :selected').each(function () {
                //Secilenler.push($(this).val());
                Secilenler += $(this).val() + ",";
            });


			Secilenler=Secilenler.substr(0,Secilenler.length-1)

 var Secilenlerclient = "";
            $('#client2 :selected').each(function () {
                //Secilenler.push($(this).val());
                Secilenlerclient += $(this).val() + ",";
            });
			Secilenlerclient=Secilenlerclient.substr(0,Secilenlerclient.length-1)
			

 var Secilenlerclientbranch = "";
            $('#client3 :selected').each(function () {
                //Secilenler.push($(this).val());
                Secilenlerclientbranch += $(this).val() + ",";
            });
			Secilenlerclientbranch=Secilenlerclientbranch.substr(0,Secilenlerclientbranch.length-1)
			
 //workorderList("/workorder/workorderlist?f="+f+"&b="+b+"&t="+t+"&s="+Secilenler);
	window.location="/workorder?f="+f+"&b="+b+"&c="+Secilenlerclient+"&cb="+Secilenlerclientbranch+"&t="+t+"&s="+Secilenler+"&startDate="+startDate+"&endDate="+endDate;

			$("#backgroundLoading").removeClass("loadingDisplay");  


		 });





function myfirm()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
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

	var branch=document.getElementById("branch2").value;
	if(branch!='' && branch!=0 && branch!=null && branch!=undefined)
  {
		$.post( "/workorder/mainclient?id="+branch).done(function( data ) {
			$( "#client2" ).prop( "disabled", false );
			$('#client2').html(data);
		});
	}
	
}

function myclient()
{

	var client=document.getElementById("client2").value;
	if(document.getElementById("client2").value!='')
	{

		 var Secilenler = "";
            $('#client2 :selected').each(function () {
                //Secilenler.push($(this).val());
                Secilenler += $(this).val() + ",";
            });

			Secilenler=Secilenler.substr(0,Secilenler.length-1)
		$.post( "/workorder/clientbranch?fid="+document.getElementById("branch2").value+"&id="+Secilenler).done(function( data ) {
			$('#client3').html(data);
			$( "#client3" ).prop( "disabled", false );
		});
	}
	

	// if(client!='' && client!=0 && client!=null && client!=undefined)
  // {
		// $.post( "/workorder/mainclient?id="+branch).done(function( data ) {
			// $( "#client2" ).prop( "disabled", false );
			// $('#client2').html(data);
		// });
	// }
	
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

$(document).ready(function(){

	$("#date").on('submit',(function(e) {
		e.preventDefault();
	var date='';
    $.ajax({
      url: "/workorder/copy",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data)
        {

		  date=data.split(",");

		for(i=0;i<date.length;i++)
		{
			date2=date[i].split("-");
			if(date[i]!=''){
				if(date2[3]=='ok')
				{
					toastr.success(date2[0]+" Copying is successful!","<center>Successful</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"

					});

				}
				else
				{
					toastr.error(date2[0]+" Available data!","<center>Copying is error!</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"

					});

				}
			}



		}

		if(data==0)
		{
			toastr.error(date2[0]+"Business plan of this company could not be found between given dates!","<center>Error</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"

					});
		}


				window.location="https://insectram.io/workorder";

        }
     });


  }));

	// Multiple Select Placeholder
    $(".select2-placeholder-multiple").select2({
      placeholder: "<?=t('Select State');?>",
    });
});

function calender(list)
{
	$('#fc-bg-events').destroy;
	$('#fc-bg-events').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay',
		},
		buttonText:{
			today:    '<?=ucfirst(t('today'));?>',
			month:    '<?=ucfirst(t('Month'));?>',
			week:     '<?=ucfirst(t('Week'));?>',
			day:      '<?=ucfirst(t('Day'));?>',
			list:     '<?=ucfirst(t('List'));?>'
		},

			//titleFormat:'sdfsdf',
			dayNames:['<?=t('Sunday');?>', '<?=t('Monday');?>', '<?=t('Tuesday');?>', '<?=t('Wednesday');?>', '<?=t('Thursday');?>', '<?=t('Friday');?>', '<?=t('Saturday');?>'],
			dayNamesShort:  ['<?=t('Sun');?>', '<?=t('Mon');?>', '<?=t('Tue');?>', '<?=t('Wed');?>', '<?=t('Thu');?>', '<?=t('Fri');?>', '<?=t('Sat');?>'],
			monthNames:['<?=t('January');?>','<?=t('February');?>','<?=t('March');?>','<?=t('April');?>','<?=t('May');?>','<?=t('June');?>','<?=t('July');?>','<?=t('August');?>','<?=t('September');?>','<?=t('October');?>','<?=t('November');?>','<?=t('December');?>'],
			monthNamesShort:['<?=t('Jan');?>', '<?=t('Feb');?>', '<?=t('Mar');?>', '<?=t('Apr');?>', '<?=t('May');?>', '<?=t('Jun');?>','<?=t('Jul');?>', '<?=t('Aug');?>', '<?=t('Sep');?>', '<?=t('Oct');?>', '<?=t('Nov');?>', '<?=t('Dec');?>'],
			//defaultDate: '2016-06-12',
			businessHours: true, // display business hours
		<?php if(Yii::app()->user->checkAccess('workorder.update')){ ?>
			editable: true,
		<?php } ?>
			selectable: true,
			selectHelper: true,		<?php if(Yii::app()->user->checkAccess('workorder.create')){ ?>
			select: function(start, end) {

			window.location = "/workorder/workorder?date="+start.format();
			$('#fc-bg-events').fullCalendar('unselect');
		}, 		<?php } ?>

		   eventRender: function(eventObj, $el) {
        $el.popover({
          title: eventObj.title,
          content: eventObj.description,
          trigger: 'hover',
          placement: 'top',
          container: 'body',
		  html:true
        });
      },




			eventDrop: function(event, delta, revertFunc)
				{
					//alert(event.id + " <?=t('was dropped on');?> " + event.start.format());
					<?php if(Yii::app()->user->checkAccess('workorder.update')){ ?>
					if (!confirm("<?=t('Are you sure about this change?');?>"))
					{
						revertFunc();
					}
					else
					{
						$.post( "/workorder/change?id="+event.id+'&&date='+event.start.format()).done(function( data ) {

						if(data.trim()=='ok')
						{
									toastr.success("<center>Workorder change success.</center>", "<center>WOrkorder Success!</center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
						}
						else
						{
							toastr.error("<center>Workorder change error.</center>", "<center>WOrkorder Error!</center>", {
									positionClass: "toast-top-right",
									containerId: "toast-top-right"
							});
						}
					});
					}
					<?php } ?>
				},


			textEscape: false,
			events: list,
			textEscape: false,

	});
}



function workorderList()
{

	$("#backgroundLoading").removeClass("loadingDisplay");  
	$.ajax({
		url: "<?=$urlx;?>",
		type: "POST",
	//	data: fd ,
		contentType: false,
		cache: false,
		processData:false,
		success: function(data)
			{
				datam=JSON.parse(data);
				if(datam['status']==200)
				{
					$("#backgroundLoading").addClass("loadingDisplay");  
					calender(datam['response']);
				}
				else {
					alert('hata')
				}
			}
	 });
}
$(document).ready(function() {
workorderList();
	$('#datetimepicker3').datetimepicker({
		format: 'LT'
	});

	$('#datetimepicker4').datetimepicker({
		format: 'LT'
	});

	// Single Date Range Picker
	$('.singledate').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true
	});

/******************************************
*       js of HTML5 export buttons        *
******************************************/


} );

$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });





</script>




<script>
  document.querySelector("input[type=number]")
  .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
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




Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';



?>
