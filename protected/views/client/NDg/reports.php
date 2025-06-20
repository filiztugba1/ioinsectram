<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$firmid=$ax->firmid;
$firm=Firm::model()->find(array('condition'=>'id='.$firmid));

$client=Client::model()->find(array("condition"=>"id=".$_GET['id']))->parentid;

			$fbid=Client::model()->find(array("condition"=>"id=".$client))->firmid;

			$firmid=Firm::model()->find(array("condition"=>"id=".$fbid))->parentid;	

			$country=Firm::model()->find(array("condition"=>"id=".$firmid))->country_id;	
			


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

/*
if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));

		$monitoring=Yii::app()->db->createCommand(
		'SELECT monitoring.* FROM monitoring INNER JOIN departmentpermission ON departmentpermission.clientid=monitoring.clientid WHERE departmentpermission.departmentid=monitoring.dapartmentid and departmentpermission.subdepartmentid=monitoring.subid'.$where)->queryAll();

	}
*/

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
						<?php							if((isset($_GET['status']) && $_GET['status']==1) || !isset($_GET['status']))
								{
								$userwhere=' and active=1';
								}
								else if(isset($_GET['status']) && $_GET['status']==2)
								{
								$userwhere=' and active=0';
								}
								else
								{
								 $userwhere='';
								}
								$say=User::model()->findAll(array('condition'=>'type not in (24,22) and clientbranchid='.$_GET['id'].$userwhere));
								
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
				  <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/visitreports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Visit Reports');?></a></a>
						  </li>
						  
                <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files2/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a>
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

        <form id="departments-form" onsubmit="return validateForm();" action="/client/reportcreate" method="post" target="_blank">
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
									<?//if($ax->id==1 || $ax->id==317 || $ax->id==1285 || $ax->id==1286 || $ax->id==2023 || $ax->id==662 ){?>
									<option value="10"><?=t('Activity Exel Reports');?></option>
									<?//}?>
									<option value="11"><?=t('Aktivite Miktarı Rapor-Grafik');?></option>
                                    <!-- <option value="6"><?=t('Products Reports');?></option> -->
									 <option value="3"><?=t('Total Number of Pests Based on Date');?></option>
									 <option value="42"><?=t('Pest Trend By Units')?></option>
                                    <option value="8"><?=t('Department - Sub Department Report')?></option>
                                    <option value="2"><?=t('Regional Trend Analysis');?></option>
                                   <option value="7"><?=t('Consumption Use - Non-Activity Report')?></option>
								   <option value="98"><?=t('Yıllık Aktivite Kıyas Raporu')?></option>
								   
                                    <option value="4"><?=t('Excel Monitoring Point List');?></option>
                  									<option value="5"><?=t('Single Monitor Report')?></option>
                  									
                  									<?php if($ax->id==317 || $ax->id==1  ){ ?>
                  								 <!-- <option value="6"><?=t('Production Report')?></option> -->
                                   <option value="13"><?=t('Servis Raporları Mobil')?></option>
								   
                  									<?php } ?>
													
									
									<?php if($ax->id==1 || $ax->id==317 || $ax->id==1433){?>
									<option value="40"><?=t('Alan Kontrol Raporu')?></option>
									
									<?php }?>
									<option value="41"><?=t('Pesticides Logs')?></option>
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
                            <label for="basicSelect"><?=t('Sub-Department');?></label>
                            <fieldset class="form-group">

                                <select class="select2-placeholder-multiple form-control "  style="width:100%" id="subdepartment"  multiple="multiple" name="Monitoring[subid][]" onchange="myReport()">
                                    <option value="0"><?=t('Select');?></option>

                                </select>
                            </fieldset>
                        </div>








                        <?php  
											//$monitoringtypes=Monitoringtype::model()->findAll(
					//	array(
  
//)
//);


											
										
				/*	if($ax->id==1 or $ax->id==317)
					{
						*/
						$andwhere='';
						if ($country<>0) {
							$andwhere='and country_id='.$country.' or country_id=0)';
						}
						$monitoringtypes=Yii::app()->db->createCommand()
						->select('mt.id,mt.name,mt.detailed')
						->from('monitoring m')
						->leftJoin('monitoringtype mt','mt.id=m.mtypeid')
						->where('m.clientid='.$_GET['id'].' and m.active=1')
						->group('mtypeid')
						->queryAll();		
					
					/*}
					else
					{
						$monitoringtypes=Yii::app()->db->createCommand()
						->select('mt.id,mt.name,mt.detailed')
						->from('monitoringtype mt');
						if ($country<>0) {
							$monitoringtypes=$monitoringtypes->where('(country_id='.$country.' or country_id=0) and active=1');
						}
						
						
						$monitoringtypes=$monitoringtypes->queryAll();
						
						
					}
					*/
					
											?>




                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id='typex'>
                            <label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                            <fieldset class="form-group">

                                <select class="select2" style="width:100%" id="type" name="Monitoring[mtypeid]" onchange="myType()" >
                                    <?php									if($country==2){?>
										 <option value="-100"><?=t('RM').' - '.t('All Rodents');?></option>
									<?php }
									foreach($monitoringtypes as $monitoringtype){?>
                                        <option value="<?=$monitoringtype['id'];?>"><?=t($monitoringtype['name']).' - '.t($monitoringtype['detailed']);?></option>
                                    <?php }?>

                                </select>
                            </fieldset>
                        </div>
						
						  <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id="typex2">
                            <label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                            <fieldset class="form-group">
                                <select class="select2-placeholder-multiple form-control" id="type2"  multiple="multiple" onchange="myType2()"  style="width:100%;" name="Monitoring[mtypeid2][]">
								 <option value=""><?=t('Seçiniz');?></option>
                                     <?php foreach($monitoringtypes as $monitoringtype){?>
                                        <option value="<?=$monitoringtype['id'];?>"><?=t($monitoringtype['name']).' - '.t($monitoringtype['detailed']);?></option>
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
									<option value="<?=$point->id?>"><?=t($type->name).' - '.$point->mno?></option>
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

                      <div class='col-xl-12 col-lg-12 col-md-12 mb-1' id="startEndTime">
                         <div class='row'>
                        <div class="col-xl-6 col-lg-6 col-md-6 mb-1" id="gzl">
                            <label id='tarihkisitlama' for="basicSelect"><?=t("Date Range")."".t("(En fazla iki (6) ay tarih aralığı seçiniz.)");?></label>
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
                           </div>

                        </div>
						
						<div class='col-xl-12 col-lg-12 col-md-12 mb-1' id="startEndDate">
                         <div class='row'>
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<label for="basicSelect"><?=t("1. yıl");?></label>
								<fieldset class="form-group">
									<select class="select2 form-control" style="width:100%;" id="oneyear" onchange='oneyearSelect()' name="Report[oneyear][]">
										<?php for($i=2019;$i<=date('Y');$i++){?>
											<option value="<?=$i?>" <?$i==date('Y')?"selected":""?>><?=$i?></option>
										<?php }?>
									</select>
								</fieldset>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<label for="basicSelect"><?=t("2. yıl");?></label>
								<fieldset class="form-group">
									<select class="select2 form-control" style="width:100%;" id="secondyear" onchange='secondyearSelect()' name="Report[secondyear][]">
										<?php for($i=2020;$i<=date('Y');$i++){?>
											<option value="<?=$i?>" <?$i==date('Y')?"selected":""?>><?=$i?></option>
										<?php }?>
									</select>
								</fieldset>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<label for="basicSelect"><?=t("Kıyaslama Tipi");?></label>
								<fieldset class="form-group">
									<select class="select2 form-control" style="width:100%;" id="mounthType" onchange='mounthTypeSelect()' name="Report[mounthType][]">
										<option selected value="0"><?=t("Seçilen aylara göre kıyaslama");?></option>
										<option value="1"><?=t("3 aylık periyotla kıyaslama");?></option>
									</select>
								</fieldset>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1" id="ismounth">
								<label for="basicSelect" id="pesttypeChange"><?=t('Raporlanacak aylar');?></label>
								<fieldset class="form-group">
									<select class="select2-placeholder-multiple form-control"  id="mounth" style="width:100%;" multiple="multiple"  name="Report[mounth][]">
										<option value="1" ><?=t("Ocak");?></option>
										<option value="2"><?=t("Şubat");?></option>
										<option value="3"><?=t("Mart");?></option>
										<option value="4"><?=t("Nisan");?></option>
										<option value="5"><?=t("Mayıs");?></option>
										<option value="6"><?=t("Haziran");?></option>
										<option value="7"><?=t("Temmuz");?></option>
										<option value="8"><?=t("Ağustos");?></option>
										<option value="9"><?=t("Eylül");?></option>
										<option value="10"><?=t("Ekim");?></option>
										<option value="11"><?=t("Kasım");?></option>
										<option value="12"><?=t("Aralık");?></option>

									</select>
								</fieldset>
							</div>
						

                       </div>

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

		function validateForm() {
			if(+$('#reptype').val()===98)
			{
				console.log($('#mounth').val());
				console.log($('#mounth').val().length);
				if(+($('#mounth').val().length)>0) {
					return true;
				} else {
					if ($("#mounthType").val()==='0'){
						
					toastr.error("<?=t("Raporlanacak ay seçmelisiz.")?>","<center><?=t("Hata")?></center>" , {
										positionClass: "toast-bottom-right",
										containerId: "toast-top-right"

			
										});	
							return false;
					}
				
	
				}
			}
			return true;
			
		}

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
	
		function oneyearSelect(){
			var oneselect=+($('#oneyear').val());
			var secondselect=+($('#secondyear').val());
			if(oneselect>=secondselect)
			{
				var newSelect=oneselect+1;
				
				$('#secondyear').val(newSelect)
				$('#secondyear').select2('destroy');
				$('#secondyear').select2({
					closeOnSelect: false,
						 allowClear: true
				});
			}
		}
		function secondyearSelect(){
			var oneselect=+($('#oneyear').val());
			var secondselect=+($('#secondyear').val());
			if(oneselect>=secondselect)
			{
				var newSelect=oneselect+1;
				
				$('#secondyear').val(newSelect);
				$('#secondyear').select2('destroy');
				$('#secondyear').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				alert('<?=t("seçmiş olduğunuz 2. yıl 1. yıldan büyük olmalıdır")?>');
			}

		}
		
		function mounthTypeSelect(){
			var select=+($('#mounthType').val());
			if(select==0)
			{
				$("#ismounth").show("slow");
			}
			else
			{
				
				$("#ismounth").hide("slow");
			}
		}
		
		var beforemounth=['0'];
		function mounthSelect(e){
			var select=$('#mounth').val();
			if(select.find(k=>k=='0') && beforemounth.find(k=>k!='0'))
			{
				
				beforemounth=['0'];
				
			}
			else
			{
				beforemounth=[];
				select.forEach(k=>{
					if(k!='0')
					{
						beforemounth.push(k);
					}
				});
			}
			
				$('#mounth').val(beforemounth);
				$('#mounth').select2('destroy');
				$('#mounth').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				
		}
		
		
		
$("#startEndDate").hide("slow");
$("#typex2").hide("slow");
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
				$("#tarihkisitlama").html('<?=t("Date Range (En fazla iki (6) ay tarih aralığı seçiniz.)");?>');
				 $.post( "/client/datetime?time="+document.getElementById("datetimestart").value).done(function( data ) {
				// alert(data);;
				var value = jQuery.parseJSON( data );
				// alert(value)
						$('#datetimefinish').val(value);
						var x = document.getElementById("datetimefinish").max =value;
					});
					$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
          $("#typex").show();
			}
      else if($("#reptype").val()==11)
      {
        var tarih = new Date(document.getElementById("datetimestart").value);
        var y = tarih.getFullYear();
        tarih.setFullYear(tarih.getFullYear()+1, 1, 0);
         // tarih.setDate(-1);
        var d = tarih.getDate();
        var m =  12;
        document.getElementById("datetimefinish").max =y + "-" + m + "-" + d;
        document.getElementById("datetimefinish").min=document.getElementById("datetimestart").value;

        $("#tarihkisitlama").html('<?=t("Date Range (Aktivite raporu alabilmek için tarihler aynı yıl içinde olmalıdır.)");?>');
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
                $("#pointno").hide("slow");

        $("#typeselect").show("slow");
        $("#subdepartment").show("slow");

        $("#pointno").hide();
		$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
        return;
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
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
            else if($("#reptype").val()==2)
            {
				 $("#departmanblog").show("slow");
                $("#gzl3").show("slow");
					 $("#subdepartmentblok").show("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
			
			else if($("#reptype").val()==42)
            {
				 $("#departmanblog").show("slow");
                $("#gzl3").hide("slow");
				 $("#gzl2").hide("slow");
					 $("#subdepartmentblok").show("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
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
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
			}
			else if($("#reptype").val()==7)
			{
				 $("#departmanblog").show("slow");
				 $("#gzl3").show("slow");
				 	 $("#subdepartmentblok").show("slow");
         $("#pesttypeChange").html("<?=t('Report Criterion')?>");
		 $("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
				$("#startEndTime").show("slow");
				$("#typex2").hide("slow");

			}
			else if($("#reptype").val()==8)
			{
					$("#gzl3").show("slow");
					$("#gzl2").hide("slow");
				 $("#subdepartmentblok").hide("slow");
				 $("#typeselect").val(0);
				  $("#typeselect").trigger("change");
				   $("#departmanblog").hide("slow");
				
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
			}
				else if($("#reptype").val()==98)
			{
				$("#departmanblog").show("slow");
			   $("#subdepartmentblok").show("slow");
               $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("#gzl").show("slow");
                $("#gzl2").show("slow");
                $("#gzl3").show("slow");
                if($("#type option:selected").text()=="Select")
                    $("#type").find("option").eq(0).remove();

                $("[name='Monitoring[date]']").hide("slow");
                $("[name='Monitoring[date1]']").hide("slow");
				$("#startEndTime").hide("slow");
				$("#startEndDate").show("slow");
				$("#typex").hide("slow");
				$("#typex2").show("slow");
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
				
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
				
            }

          if($("#reptype").val()==13)
            {
               $("#departmanblog").hide("slow");
					       $("#subdepartmentblok").hide("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                 $("#typex").hide("slow");
                $("#datetimefinish").show("slow");
                $("#datetimestart").show("slow");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
			
			  if($("#reptype").val()==41)
            {
               $("#departmanblog").hide("slow");
			   $("#subdepartmentblok").hide("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                 $("#typex").hide("slow");
                $("#datetimefinish").show("slow");
                $("#datetimestart").show("slow");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
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
  else if($("#reptype").val()==11)
  {
    var tarih = new Date(document.getElementById("datetimestart").value);
    var y = tarih.getFullYear();
    tarih.setFullYear(tarih.getFullYear()+1, 1, 0);
     // tarih.setDate(-1);
     // tarih.setDate(+1);
    var d = tarih.getDate();
    var m =  12;
    document.getElementById("datetimefinish").max =y + "-" + m + "-" + d;
    document.getElementById("datetimefinish").min=document.getElementById("datetimestart").value;
    document.getElementById("datetimefinish").value =y + "-" + m + "-" + d;
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
									$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );
				$.post( "/client/tumunugetir?id="+<?=$_GET["id"]?>).done(function( data ) {
					$('#pointno').html(data);
					$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
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
	
				// department=document.getElementById("typeselect").value;
				subdepartment=document.getElementById("subdepartment").value;
				type=document.getElementById("type").value;
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );
								$( "#pointno" ).prop( "disabled", true );			$( "#subdepartment" ).prop( "disabled", true );
				$.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function( data ) {
								$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
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
					$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );

            type=document.getElementById("type").value;
            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function(data) {
												$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pointno').html(data);
            });
        }


		  function myType(){
            department=document.getElementById("typeselect").value;
            subdepartment=document.getElementById("subdepartment").value;
            type=document.getElementById("type").value;
			reptype=document.getElementById("reptype").value;

			var client=<?=$_GET["id"]?>;
						$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );

            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type+"&&clientid="+client).done(function( data ) {
										$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pointno').html(data);
            });

             //Zararlıları getir
            $.post( "/client/peststypes?type="+type+"&reptype="+reptype).done(function( data ) {
													$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pests').html(data);
            });

        }
		
		  function myType2(){
            department=document.getElementById("typeselect").value;
            subdepartment=document.getElementById("subdepartment").value;
            type=document.getElementById("type2").value;
			reptype=document.getElementById("reptype").value;
			
			
			  var select = document.getElementById('type2');
    var selectedValues = [];

    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].selected) {
            selectedValues.push(select.options[i].value);
        }
    }
	type=selectedValues.join(',')
			var client=<?=$_GET["id"]?>;
							$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );

            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type+"&&clientid="+client).done(function( data ) {
										$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pointno').html(data);
            });

             //Zararlıları getir
            $.post( "/client/peststypes?type="+type+"&reptype="+reptype).done(function( data ) {
																		$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
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
