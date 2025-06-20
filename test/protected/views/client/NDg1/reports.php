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




?>



<?=User::model()->geturl('Client','Reports',$_GET['id'],'client');?>
    <div class="card">
        <div class="card-header" style="">
            <ul class="nav nav-tabs">
                <?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
						<?php $say=User::model()->findAll(array('condition'=>'clientbranchid='.$_GET['id']));
									echo count($say);?>
						</span><?=t('Staff');?>

							</a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $department);?></span><?=t('Departments');?></a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a>
                    </li>

                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a>
                    </li>
                <?php }?>


					<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a>
                      </li>
					 <?//}?>



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
                  			<?php if($ax->id==317 || $ax->id==1){ ?>
                    <a href="../workorderreports/<?=$_GET["id"]?>"><?=t("Workorder raporu için tıklayın (Sadece mustafa bey ve admin'e özeldir.)");?> </a> <br><br>
                    <?php } ?>
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

                                <select class="select2" style="width:100%"  name="Report[type]" id="reptype"  required>
                                    <option value="1"><?=t('Activity Reports');?></option>
									<?php if($ax->id==1 || $ax->id==317){?><option value="10"><?=t('Activity Exel Reports');?></option><?php }?>
                <option value="11"><?=t('Aktivite Miktarı Rapor-Grafik');?></option>
                                    <!-- <option value="6"><?=t('Products Reports');?></option> -->
                                    <option value="2"><?=t('Regional Trend Analysis');?></option>
                                    <option value="3"><?=t('Total Number of Pests Based on Date');?></option>
                                    <option value="4"><?=t('Excel Monitoring Point List');?></option>
                  									<option value="5"><?=t('Single Monitor Report')?></option>
                  									<option value="7"><?=t('Consumption Use - Non-Activity Report')?></option>
                  									<?php if($ax->id==317 || $ax->id==1){ ?>
                  								 <!-- <option value="6"><?=t('Production Report')?></option> -->
                  									<?php } ?>
                                    <option value="8"><?=t('Department - Sub Department Report')?></option>
                                </select>
                            </fieldset>
                        </div>



                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id='departmanblog'>
                            <label for="basicSelect"><?=t('Department');?></label>
                            <fieldset class="form-group">

                                <select class="select2-placeholder-multiple form-control" style="width:100%" id="typeselect" onchange="myFunction()"  multiple="multiple"   name="Report[dapartmentid][]">
                                    <option value="0">All</option>
                                    <?php foreach($departments as $departmentx){?>
                                        <option value="<?=$departmentx['id'];?>"><?=$departmentx['name'];?></option>
                                    <?php }?>

                                </select>
                            </fieldset>
                        </div>




                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id="subdepartmentblok">
                            <label for="basicSelect"><?=t('Sub-department');?></label>
                            <fieldset class="form-group">

                                <select class="select2-placeholder-multiple form-control "  style="width:100%" id="subdepartment"  multiple="multiple" name="Monitoring[subid][]" onchange="myReport()">
                                    <option value="0"><?=t('Select');?></option>

                                </select>
                            </fieldset>
                        </div>








                        <?php    $monitoringtypes=Monitoringtype::model()->findAll();?>




                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id='typex'>
                            <label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                            <fieldset class="form-group">

                                <select class="select2" style="width:100%" id="type" name="Monitoring[mtypeid]" onchange="myType()" >
                                    <?php foreach($monitoringtypes as $monitoringtype){?>
                                        <option value="<?=$monitoringtype->id;?>"><?=$monitoringtype->name.' - '.t($monitoringtype->detailed);?></option>
                                    <?php }?>

                                </select>
                            </fieldset>
                        </div>





                        <div class="col-xl-8 col-lg-8 col-md-8 mb-1" id="gzl2">
                            <label for="basicSelect"><?=t('Monitoring Point No');?></label>
                            <fieldset class="form-group">
                                <select class="select2-placeholder-multiple form-control" multiple="multiple" id="pointno" style="width:100%;" name="Monitoring[monitors][]">
                                    <optgroup id="pointno">
									<?php foreach($monitoringpoints as $point){
									$type=Monitoringtype::model()->findByPk($point->mtypeid);
									?>
									<option value="<?=$point>id?>"><?=$type->name.' - '.$point->mno?></option>
									<?php } ?>
									</optgroup>
                                </select>
                            </fieldset>
                        </div>




                        <div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="gzl3">
                            <label for="basicSelect" id="pesttypeChange"><?=t('Pest Type');?></label>
                            <fieldset class="form-group">
                                <select class="select2-placeholder-multiple form-control" multiple="multiple" id="pests" style="width:100%;" name="Report[pests][]">


                                </select>
                            </fieldset>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 mb-1" id="gzl">
                            <label id='tarihkisitlama' for="basicSelect"><?=t("Date Range")."".t("(En fazla iki (2) ay tarih aralığı seçiniz.)");?></label>
                            <fieldset class="form-group" id='startdate'>
                                <input type="date" class="form-control" id="datetimestart" onchange="test(this.value)"  name="Monitoring[date]"
							value="<?=date("Y-m-d",time())?>">
                            </fieldset>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                            <label for="basicSelect" class="hidden-xs hidden-sm" style="margin-top:15px "></label>
                            <fieldset class="form-group">
                                <input type="date" class="form-control" id="datetimefinish"  name="Monitoring[date1]" value="<?=date("Y-m-d",time())?>"
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


        //ekle b�l�m� biti�




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

			if($("#reptype").val()==1)
			{
				// alert(document.getElementById("datetimestart").value);
				$("#tarihkisitlama").html('<?=t("Date Range (En fazla iki (2) ay tarih aralığı seçiniz.)");?>');
				 $.post( "/client/datetime?time="+document.getElementById("datetimestart").value).done(function( data ) {
				// alert(data);;
				var value = jQuery.parseJSON( data );
				// alert(value)
						$('#datetimefinish').val(value);
						var x = document.getElementById("datetimefinish").max =value;
					});
          $("#typex").show();
			}
			else
			{
				$("#tarihkisitlama").html('<?=t("Date Range");?>');
				document.getElementById("datetimefinish").max='<?=date("Y-m-d",time());?>';
         $("#typex").show();
			}


            if($("#reptype").val()==4)
            {
				 $("#departmanblog").show("slow");
                $("#gzl").hide("slow");
					 $("#subdepartmentblok").show("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                $("#type").prepend("<option value='0' selected='selected'>Select</option>");
                $("[name='Monitoring[date]']").hide("slow");
                $("[name='Monitoring[date1]']").hide("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
            }
            else if($("#reptype").val()==2)
            {
				 $("#departmanblog").show("slow");
                $("#gzl3").show("slow");
					 $("#subdepartmentblok").show("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
            }
			else if($("#reptype").val()==5)
			{
				 $("#departmanblog").show("slow");
				$("#gzl3").show("slow");
					 $("#subdepartmentblok").show("slow");
				$("#gzl").show("slow");
                $("#gzl2").show("slow");
 $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
				$("#pointno").removeAttr("multiple")
			}
			else if($("#reptype").val()==7)
			{
				 $("#departmanblog").show("slow");
				 $("#gzl3").show("slow");
				 	 $("#subdepartmentblok").show("slow");
         $("#pesttypeChange").html("<?=t('Report Criterion')?>");

			}
			else if($("#reptype").val()==8)
			{
					$("#gzl3").show("slow");
					$("#gzl2").hide("slow");
				 $("#subdepartmentblok").hide("slow");
				 $("#typeselect").val(0);
				  $("#typeselect").trigger("change");
				   $("#departmanblog").hide("slow");


			}
      else if($("#reptype").val()==11)
      {

        $("#departmanblog").show("slow");
               $("#gzl").show("slow");
          $("#subdepartmentblok").show("slow");
          $("#typex").hide();
               $("#gzl2").hide("slow");
               $("#gzl3").hide("slow");
               $("#type").prepend("<option value='0' selected='selected'>Select</option>");
               $("[name='Monitoring[date]']").show("slow");
               $("[name='Monitoring[mtypeid]']").hide("slow");
               $("[name='Monitoring[date1]']").show("slow");
                $("#pesttypeChange").html("<?=t('Pest Type')?>");

        $("#typeselect").show("slow");
        $("#subdepartment").show("slow");

        $("#pointno").hide();
      }
            else
            {
				 $("#departmanblog").show("slow");
				 $("#subdepartmentblok").show("slow");
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


<script>
function test(a){
// alert(a);
	if($("#reptype").val()==1)
	{
	 $.post( "/client/datetime?time="+a).done(function( data ) {
		// alert(data);
		var value = jQuery.parseJSON( data );
		// alert(value)
                $('#datetimefinish').val(value);
				var x = document.getElementById("datetimefinish").max =value;
            });
	}
	else
	{
		document.getElementById("datetimefinish").max='<?=date("Y-m-d",time());?>';
	}
}

      function myFunction() {

 department="";
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
				// yy=document.getElementById("typeselect").value;
        var selected1=$("#typeselect option:selected").map(function(){ return this.value }).get();
        selected1.push(document.getElementById("typeselect").value);// 2 is the val I set for Dog
        department=selected1.join();
				$.post( "/client/subdepartments?id="+department).done(function( data ) {
					$('#subdepartment').html(data);

				});
				$( "#subdepartment" ).prop( "disabled", false );
				// department=document.getElementById("typeselect").value;
				subdepartment=document.getElementById("subdepartment").value;
				type=document.getElementById("type").value;
				$.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function( data ) {
					$('#pointno').html(data);
				});
			}
        }

			function myReport(){
            // department=document.getElementById("typeselect").value;
            var selected1=$("#typeselect option:selected").map(function(){ return this.value }).get();
          selected1.push(document.getElementById("typeselect").value);// 2 is the val I set for Dog
        department =selected1.join();
            var selected=$("#subdepartment option:selected").map(function(){ return this.value }).get();
    selected.push(document.getElementById("subdepartment").value);// 2 is the val I set for Dog
   subdepartment=selected.join();

//console.log(selected.join());


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

</script>
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
