<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$monitoring=Monitoring::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'condition'=>'clientid='.$_GET['id'],
));
?>

<?php    $department=Departments::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'order'=>'name ASC',
    'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
));


if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));

		$monitoring=Yii::app()->db->createCommand(
		'SELECT monitoring.* FROM monitoring INNER JOIN departmentpermission ON departmentpermission.clientid=monitoring.clientid WHERE departmentpermission.departmentid=monitoring.dapartmentid and departmentpermission.subdepartmentid=monitoring.subid'.$where)->queryAll();

	}


$monitoringpoints=Monitoring::model()->findAll(array('condition'=>'clientid='.$_GET["id"],'order'=>'mtypeid asc'));


if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$departments=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));

		$monitoring=Yii::app()->db->createCommand(
		'SELECT monitoring.* FROM monitoring INNER JOIN departmentpermission ON departmentpermission.clientid=monitoring.clientid WHERE departmentpermission.departmentid=monitoring.dapartmentid and departmentpermission.subdepartmentid=monitoring.subid and monitoring.clientid='.$_GET['id'].$where)->queryAll();
	}



User::model()->login();
$ax= User::model()->userobjecty('');
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
				$where="firmbranchid=".$ax->branchid;
			}
		}
		else
		{
			$where="firmid in (".implode(',',Firm::model()->getbranchids($ax->firmid)).")";
		}


		if(isset($_GET['status']))
		{
			$where=$where." and statusid=".$_GET['status'];
		}
	}
	else
	{
		$where="";

		if(isset($_GET['status']))
		{
			$where="statusid=".$_GET['status'];
		}
	}



	//echo $where;
    $conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'date desc'));


	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{

		$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and departmentpermission.userid='.$ax->id)->queryAll();
	}

$yetki=1;

if($ax->mainclientbranchid!=$ax->clientbranchid)
{
	$yetki=0;
}



?>



<?=User::model()->geturl('Client','Reports',$_GET['id'],'client');?>
    <div class="card">
        <div class="card-header" style="">
            <ul class="nav nav-tabs">

                <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/workorderreports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Workorder Reports');?></a></a>
                    </li>
                <?php }?>
            </ul>
        </div>

    </div>





    <div class="card">

        <div class="card-header">
            <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
                <div class="col-md-6">
                    <h4  class="card-title"><?=t('Reports');?></h4>
                </div>
                <div class="col-md-6">
                    <button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>

        <form id="departments-form" action="/client/reportcreate" method="post" target="_blank">
            <div class="card-content">
                <div class="card-body">

                    <input type="hidden" class="form-control" id="basicInput"  name="Report[clientid]" value="<?=$_GET['id'];?>">
                    <input type="hidden" class="form-control" id="basicInput"  name="Report[active]" value="1">

                    <div class="row">


                        <?php    $departments=Departments::model()->findAll(array(
                            #'select'=>'',
                            #'limit'=>'5',
                            'order'=>'name ASC',
                            'condition'=>'parentid=0 and clientid='.$_GET['id'],
                        ));


						if($ax->mainclientbranchid!=$ax->clientbranchid)
						{

							$departments=Yii::app()->db->createCommand(
							'SELECT departments.* FROM departments INNER JOIN departmentpermission ON departmentpermission.clientid=departments.clientid WHERE departmentpermission.departmentid=departments.id and departmentpermission.subdepartmentid=0 and departmentpermission.userid='.$ax->id)->queryAll();


						}


                        ?>


                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                            <label for="basicSelect"><?=t('Report Type');?></label>
                            <fieldset class="form-group">

                                <select class="select2" style="width:100%"  name="Report[type]" id="reptype" required>


                  <option value="9"><?=t('Workorder Report')?></option>




                                </select>
                            </fieldset>
                        </div>




						<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Conformity[firmid]" onchange="myfirm()" requred>
									<option value="0">Please Chose</option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Conformity[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Conformity[branchid]" onchange="mybranch()" disabled requred>
									<option value="0"><?=t("Please Choose")?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Conformity[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>

					<?php if($ax->clientbranchid==0){?>
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" multiple="multiple" name="Report[clientid][]" disabled requred onchange="myFunctionClient()">

								<?php								if($workorder->branchid!=0){
								$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$workorder->branchid));

									foreach($client as $clientx)
										{ $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));

											if(count($clientbranchs)>0){?>
											<optgroup label="<?=$clientx->name;?>">
												<?php
													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }

									$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
									foreach($tclient as $tclientx)
									{

										$tclients=Client::model()->findAll(array('condition'=>'id='.$tclientx->mainclientid));
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
					<?php }else{?>
							<input type="hidden" class="form-control" id="client" name="Report[clientid]" value="<?=$ax->branchid;?>" requred>
					<?php }?>






 <div class="col-xl-8 col-lg-8 col-md-8 mb-1"></div>


                        <div class="col-xl-6 col-lg-6 col-md-6 mb-1" id="gzl">
                            <label for="basicSelect"><?=t('Date Range');?></label>
                            <fieldset class="form-group">
                                <input type="date" class="form-control" id="basicInput"  name="Monitoring[date]"
							value="<?=date("Y-m-d",time())?>">
                            </fieldset>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                            <label for="basicSelect" class="hidden-xs hidden-sm" style="margin-top:15px "></label>
                            <fieldset class="form-group">
                                <input type="date" class="form-control" id="basicInput"  name="Monitoring[date1]" value="<?=date("Y-m-d",time())?>"
							>
                            </fieldset>
                        </div>



                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                            <label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                            <fieldset class="form-group">
                                <div class="input-group-append" id="button-addon2">
                                    <button class="btn btn-primary" type="submit"><?=t('Report');?></button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>
    </div>
    </form>


    </div><!-- form -->



    <style>
        .switchery,.switch{
            margin-left:auto !important;
            margin-right:auto !important;
        }

        .table tr{
            cursor: pointer;
        }
        .hiddenRow{
            padding: 0 4px !important;
            background-color: #eeeeee;
            font-size: 13px;
        }

    </style>

    <script>



        //ekle b�l�m� baslang�c

        $( "#subdepartment" ).prop( "disabled", true );

        function myFunction() {

			if($("#typeselect").val()==0)
			{
				$.post( "/client/tumunugetir?id="+<?=$_GET["id"]?>).done(function( data ) {
					$('#pointno').html(data);

				});
					$( "#subdepartment" ).prop( "disabled", true );
					$( "#subdepartment" ).val( 0);
			}
			else
			{
				yy=document.getElementById("typeselect").value;
				$.post( "/client/subdepartments?id="+yy).done(function( data ) {
					$('#subdepartment').html(data);

				});
				$( "#subdepartment" ).prop( "disabled", false );
				department=document.getElementById("typeselect").value;
				subdepartment=document.getElementById("subdepartment").value;
				type=document.getElementById("type").value;
				$.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function( data ) {
					$('#pointno').html(data);
				});
			}
        }
        //ekle b�l�m� biti�


		function myReport(){
            department=document.getElementById("typeselect").value;
            subdepartment=document.getElementById("subdepartment").value;
            type=document.getElementById("type").value;
            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function(data) {
                $('#pointno').html(data);
            });
        }


       function myType(){
            department=document.getElementById("typeselect").value;
            subdepartment=document.getElementById("subdepartment").value;
            type=document.getElementById("type").value;
			reptype=document.getElementById("reptype").value;

			var client=<?=$_GET["id"]?>;
            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type+"&&clientid="+client).done(function( data ) {
                $('#pointno').html(data);
            });

             //Zararlıları getir
            $.post( "/client/peststypes?type="+type+"&reptype="+reptype).done(function( data ) {
                $('#pests').html(data);
            });

        }





        //monitoring point no
    /*    department=document.getElementById("typeselect").value;
        subdepartment=document.getElementById("subdepartment").value;
        type=document.getElementById("type").value;
        $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function( data ) {
            $('#pointno').html(data);
        });
*/

        //monitoring point no bitis

        $(document).ready(function() {

            $('.select2-placeholder-multiple').select2({
                closeOnSelect: false,
                allowClear: true
            });
        });

        $("#gzl3").hide();
        $("#reptype").change(function () {
			 $( '#pointno' ).attr("multiple","multiple");
			$( '#pointno' ).val(0);
			$("#type").trigger("change");
            if($("#reptype").val()==4)
            {
                $("#gzl").hide("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                $("#type").prepend("<option value='0' selected='selected'>Select</option>");
                $("[name='Monitoring[date]']").hide("slow");
                $("[name='Monitoring[date1]']").hide("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
            }
            else if($("#reptype").val()==2)
            {
                $("#gzl3").show("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
            }
			else if($("#reptype").val()==5)
			{
				$("#gzl3").show("slow");
				$("#gzl").show("slow");
                $("#gzl2").show("slow");
 $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
				$("#pointno").removeAttr("multiple")
			}
			else if($("#reptype").val()==7)
			{
				 $("#gzl3").show("slow");
         $("#pesttypeChange").html("<?=t('Report Criterion')?>");

			}
            else
            {
               $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("#gzl").show("slow");
                $("#gzl2").show("slow");
                $("#gzl3").hide("slow");
                if($("#type option:selected").text()=="Select")
                    $("#type").find("option").eq(0).remove();

                $("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
            }



        })






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

		// $('#client').html(data);
	});
	}
<?php }?>



<?php if($ax->clientid!=0){?>
	if($("#branch").length>0)
	{
	$.post( "/workorder/client?id=<?=$ax->clientid;?>").done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		 $('#client').html(data);
	});
	}
<?php }?>

<?php if($ax->clientbranchid==0){

	if($ax->clientid>0)
	{
    // CLİENTLERİN DOLDUĞU YER  CLİENTLERİN DOLDUĞU YER  CLİENTLERİN DOLDUĞU YER  CLİENTLERİN DOLDUĞU YER  CLİENTLERİN DOLDUĞU YER  CLİENTLERİN DOLDUĞU YER
		?>
		$.post( "/workorder/clientb?id=<?=$ax->clientid;?>").done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		 $('#client').html(data);
              $('#client').html("<option value='<?=$_GET["id"]?>'>All</option>"  +      $('#client').html() );
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});

	$.post( "/workorder/clientb?id=<?=$ax->clientid?>"+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		 $('#client').html(data);
         $('#client').html("<option value='<?=$_GET["id"]?>'>All</option>"  +      $('#client').html() );
	});



<?php }}?>

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

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
