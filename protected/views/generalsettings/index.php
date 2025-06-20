<?php

User::model()->login();
 $firm=  Firm::model()->findAll();	?>

<?
$ax= User::model()->userobjecty('');
										//Yii::app()->getModule('authsystem');
			//Generalsettings::model()->dateformat();?>


<!--
<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-12">
				<form id="auth-item-form" action="/generalsettings/create" method="post">		
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Add Setting</h4>
						</div>
						<div class="card-content">
							<div class="card-body">
							
								<fieldset>
									<div class="input-group">
									<input maxlength="64" placeholder="Setting name" class="form-control" name="Generalsettings[name]" type="text" />			
									<input  type="hidden" name="Generalsettings[isactive]" value="1" />	
									<input  type="hidden" name="Generalsettings[type]" value="1" />	
									<div class="input-group-append" id="button-addon2">
											<button class="btn btn-primary" type="submit">Create</button>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</form>
	</div>
</div>
-->

	<!-- HTML5 export buttons table -->



<?php if (Yii::app()->user->checkAccess('generalsettings.view')){?>	
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('GENERAL SETTING LIST');?></h4>
						</div>

					
					
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

					<div class="row">

					


	<?$dateformat=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'dateformat','userid'=>$ax->id)
							   ));
	if(count($dateformat)==0)
	{
		Generalsettings::model()->defaultcreate('dateformat');
	}?>


					<div class="col-md-4">
							<div class="col-md-12 generalsetting">
								<div class="row">
									<div class="col-md-12">
										<h5><?=t('Date Format');?></h5>
									</div>
									<div class="col-md-12">
									<fieldset class="form-group">
										 <select class="custom-select block" id="generaldateformat" onchange=generaldateformat(this) name="Generalsettings[type]">
											<option value="1" <?php if($dateformat->type==1){echo "selected";}?>><?=t('ISO Date (Y/m/d H:i:s)');?></option>
											<option value="2" <?php if($dateformat->type==2){echo "selected";}?>><?=t('Short Date (d/m/Y H:i:s)');?></option>
											<option value="3" <?php if($dateformat->type==3){echo "selected";}?>><?=t('Long Date (g:ia \o\n l jS F Y)');?></option>
										 </select>
									</fieldset>
								</div>
								</div>		
							</div>
						</div>

	<?$notification=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'notification','userid'=>$ax->id)
							   ));
	if(count($notification)==0)
	{
		Generalsettings::model()->defaultcreate('notification');
	}?>

						<div class="col-md-4">
							<div class="col-md-12 generalsetting">
								<div class="row">
									<div class="col-md-12">
										<h5><?=t('Notifications');?></h5>
									</div>
									<div class="col-md-12">
									<fieldset class="form-group">
										 <select class="custom-select block" id="dateformats" name="Generalsettings[type]">
											<option value="0" <?php if($notification->type==0){echo "selected";}?>><?=t('Active');?></option>
											<option value="1" <?php if($notification->type==1){echo "selected";}?>><?=t('Passive');?></option>
										 </select>
									</fieldset>
								</div>
								</div>		
							</div>
						</div>


	<?$conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$ax->id)
							   ));


	if(count($conformityemail)==0)
	{
		Generalsettings::model()->defaultcreate('conformityemail');
	}

	?>

						<div class="col-md-4">
							<div class="col-md-12 generalsetting">
								<div class="row">
									<div class="col-md-12">
										<h5><?=t('Conformity Email Status');?></h5>
									</div>
									<div class="col-md-12">
									<fieldset class="form-group">
										 <select class="custom-select block" id="conformityemail" onchange="conformityemail(this)" name="Generalsettings[type]">
											<option value="0" <?php if($conformityemail->type==0){echo "selected";}?>><?=t('Active');?></option>
											<option value="1" <?php if($conformityemail->type==1){echo "selected";}?>><?=t('Passive');?></option>
										 </select>
									</fieldset>
								</div>
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

		
	
	<?php }?>	
		

		
	


<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}
.generalsetting{
padding: 12px 8px 7px 11px;
border-radius: 9px;
color: #00a651;
border: 1px solid #00a651;
}
</style>
<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });
 
function openmodal(obj)
{
	$('#modalfirmid').val($(obj).data('id'));
	$('#modalfirmname').val($(obj).data('name'));
	$('#modalfirmactive').val($(obj).data('active'));
	$('#duzenle').modal('show');
	
}

function openmodalsil(obj)
{
	$('#modalfirmid2').val($(obj).data('id'));
	$('#sil').modal('show');
	
}

function authchange(data,permission,obj)
{
$.post( "?", { firmid: data, active: permission })
  .done(function( returns ) {
	  toastr.success("Success");
});	
};


function generaldateformat(obj)
{
	id=document.getElementById("generaldateformat").value;
	 $.post( "/generalsettings/updateajax?id="+id+"&&name=dateformat").done(function( data ){});

	if(id==1)
	{
			toastr.success("<center><?=t('Menu toggle saved as close');?></center>", "<center><?=t('Menu Toggle Success!');?></center>", {
				positionClass: "toast-top-right", 
				containerId: "toast-top-right"
		});
	}
	else
	{
		toastr.success("<center><?=t('Menu toggle saved as open');?></center>", "<center><?=t('Menu Toggle Success!');?></center>", {
				positionClass: "toast-top-right", 
				containerId: "toast-top-right"
		});
	}

}

function conformityemail(obj)
{
	id=document.getElementById("conformityemail").value;
	 $.post( "/generalsettings/updateajax?id="+id+"&&name=conformityemail").done(function( data ){});

	if(id==1)
	{
			   toastr.success("<center>Conformity email saved as close</center>", "<center>Conformity email Success!</center>", {
				positionClass: "toast-top-right", 
				containerId: "toast-top-right"
		});
	}
	else
	{
		        toastr.success("<center>Conformity email saved as open</center>", "<center>Conformity email Success!</center>", {
				positionClass: "toast-top-right", 
				containerId: "toast-top-right"
		});
	}

}


/*
function generaldateformat(obj)
{
	id=document.getElementById("generaldateformat").value;
	 $.post( "/generalsettings/updateajax?id="+id+"&&name=dateformat").done(function( data ){});

	if(id==1)
	{
			toastr.success("<center>Menu toggle saved as close</center>", "<center>Menu Toggle Success!</center>", {
				positionClass: "toast-top-right", 
				containerId: "toast-top-right"
		});
	}
	else
	{
		toastr.success("<center>Menu toggle saved as open</center>", "<center>Menu Toggle Success!</center>", {
				positionClass: "toast-top-right", 
				containerId: "toast-top-right"
		});
	}

}

*/

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



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';
  

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

?>