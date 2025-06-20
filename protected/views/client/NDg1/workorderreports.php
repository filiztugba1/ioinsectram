<?php




User::model()->login();
$ax= User::model()->userobjecty('');
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isdelete=0',
							   ));
?>



<?=User::model()->geturl('Client','Reports',$_GET['id'],'client');?>
    <div class="card">
        <div class="card-header" style="">
            <ul class="nav nav-tabs">

                <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/workorderreports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Workorder Reports');?></a></a>
                    </li>
                <?}?>
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

        <form id="reports-form" action="/client/reportcreate" method="post" target="_blank">
            <div class="card-content">
                <div class="card-body">

                <input type="hidden" class="form-control" id="basicInput"  name="Report[client]" value="<?=$_GET['id'];?>">
                <input type="hidden" class="form-control" id="basicInput"  name="Report[active]" value="1">

      <div class="row">

          <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Report Type');?></label>
              <fieldset class="form-group">

                  <select class="select2" style="width:100%"  name="Report[type]" id="reptype" required>
                      <option value="9"><?=t('Workorder Report')?></option>
                  </select>
              </fieldset>
          </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Rapor Sıralaması');?></label>
							<fieldset class="form-group">

									<select class="select2" style="width:100%"  name="Report[siralama]" required>
											<option value="1"><?=t('İş planı tarihine göre sırala')?></option>
											<option value="2"><?=t('Müşteri ismine göre sırala')?></option>
									</select>
							</fieldset>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
            <fieldset class="form-group">

                <select class="select2" style="width:100%" id="client" multiple="multiple" name="Report[clientid][]"  required onchange="myFunctionClient()">
                  <option value='<?=$_GET["id"]?>'><?=t('All')?></option>
								<?php
                  $client=Client::model()->findByPk($_GET["id"]);
                  if($client)
                  {?>
                    		<optgroup label="<?=$client->name;?>">
                  <?php }

				  Yii::app()->getModule('authsystem');

                  $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$client->id));
									foreach($clientbranchs as $clientbranch)
									{
										if($ax->clientbranchid!=0){
										$return=AuthAssignment::model()->find(array('condition'=>'itemname like "%'.$clientbranch->username.'%" and userid='.$ax->id));
										if($return)
										{
										?>
										<option <?if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$client->name;?> -> <?=$clientbranch->name;?></option>

									<?}}else{?>

									<option <?if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$client->name;?> -> <?=$clientbranch->name;?></option>
									<?}}?>

				         </select>
            </fieldset>
          </div>






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






<?if($ax->firmid!=0){?>
	$( "#branch" ).prop( "disabled", false );
	if($("#firm").length>0)
	{
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});
	}

<?}?>






function myfirm()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

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
