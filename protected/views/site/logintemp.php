  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <style>    html body.bg-full-screen-image {
     /*background: url(../../app-assets/images/backgrounds/bg-2.jpg) no-repeat center center fixed;*/
	 background:#055860;
      background-size: cover; }

	.danger{
	  padding: 5px;
    background: #f00;
    margin-bottom: 14px;
    border-radius: 3px;
	}

	.success{
	  padding: 5px;
    background: #00a651;
    margin-bottom: 14px;
    border-radius: 3px;
	}
  </style>

<? if(isset($_COOKIE['goindex']))
{
	$login=(array) json_decode($_COOKIE['giris']);
	 
	$user=User::model()->find(array(
								   'condition'=>'username=:username','params'=>array('username'=>$login['username']))
							   );

	if(isset($user))
	{
	
		header("Location:index");
	}
}?>
 
  <div id="getchangecode"><?=isset($_GET['code']) ? $_GET['code'] : '';?></div>
  <div id="login" class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container" 
		style="//height:auto !important"
		>
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="margin-bottom:10px !important;margin-top:10px !important">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <img src="https://insectram.io/images/purean_logo.png" style="width:70%;" alt="branding logo">
					
                  </div>
                </div>
                <div class="card-content">
					
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>Account Details</span>
					
                  </p>

				  <?php if(isset($_GET['active'])){echo '<p style="text-align:center;color: red;">Your membership has been disabled. Please contact the authorities for information!</p>';}?>
				  
				  
				  <?php				   $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));
				   
				   if($systeminmaintenance->ismaintenance==1)
		            {
		                echo '<p style="text-align:center;color: red;">Sistem Bak覺mda ( System in Maintenance )!</p>';
		            }
				//  echo '<p style="text-align:center;color: red;">Sistem 21:00 - 23:00 saatleri arasında bakımda olacaktır ( The system will be in maintenance between 21:00 - 23:00 )!</p>';
				  ?>
                  <div class="card-body">
						<?php
							$form=$this->beginWidget('CActiveForm', array(
							'id'=>'login-form',
							'enableClientValidation'=>true,
							'clientOptions'=>array(
								'validateOnSubmit'=>true,
							),
							));
						?>
                      <fieldset class="form-group position-relative has-icon-left">
						<?php echo $form->textField($model,'username', array ('class' => 'form-control','placeholder'=>'Your Username ' ,'required'=>'true')); ?>
                      
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <?php echo $form->passwordField($model,'password', array ('class' => 'form-control','placeholder'=>'Your Password ' ,'required'=>'true')); ?>
                      
                        <div class="form-control-position">
                          <i class="fa fa-key"></i>
                        </div>
                      </fieldset>
                      <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-sm-left">
                          <fieldset>
						  <?php echo $form->checkBox($model,'rememberMe',array('class'=>'chk-remember')); ?>
                            <label for="remember-me">Remember Me</label>
                          </fieldset>
                        </div>
                        <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a href="#" id="forgot" class="card-link">Forgot Password?</a></div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block"><i class="ft-unlock"></i> Login</button>
                 

					
<?php $this->endWidget(); ?>
                  </div>
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1 mb-3">
                    <span><a href="https://www.insectram.co.uk/googlelanding/" target="_blank" style="
    border: 1px solid #00dbdf;
    padding: 8px;
    border-radius: 5px;
   // background: #009c9f;
    color: black;
">New to Insectram?</a></span>
                  </p>
				     <!--<div class="card-body" style="margin-top:-20px;">
				  <a id='' href="https://insectram.io/uploads/Insectram_1.9.4_UK_.apk" style='line-height: 17px;
    color: #65a500;
    border: #65a500 1px solid;' target="_blank" class="btn btn-outline-success btn-block"><i class='fa fa-android' style='    font-size: 26px;
  
    line-height: 0px;
    margin-top: 6px;'></i> Global Version Android Apk </a>
               </div>
			   
                  <div class="card-body">
				  <a id='' href="https://insectram.io/Insectram_30.apk" style='line-height: 17px;
    color: #65a500;
    border: #65a500 1px solid;' target="_blank" class="btn btn-outline-success btn-block"><i class='fa fa-android' style='    font-size: 26px;
  
    line-height: 0px;
    margin-top: 6px;'></i> Android Apk İndir</a>
               </div>
			   -->
			   
			  <div class="row mx-2 my-1">
			   <p class="card-subtitle line-on-side text-muted text-center font-small-3 col-md-6">
                    <span><a href="https://insectram.io/privacy/" target="_blank">Privacy Policy </a></span> 
                  </p>
			    <p class="card-subtitle line-on-side text-muted text-center font-small-3 col-md-6" style="">
                   <span><a href="https://insectram.io/terms_and_conditions/" target="_blank">Terms & Conditions</a></span>
                  </p>
                 
				 <p class="card-subtitle text-muted text-center font-small-3 mx-2 my-1 col-md-12">
                    <span>Purean Solutions & Technology Ltd <br>
314 Midsummer Blvd, MK9 2UB, Milton Keynes,  UK <br>
office: +44 1908 835165 <br>mobile: +44 7493 392335</span>
                  </p>
			  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>


  <div id="forgotpassword" class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <img src="https://insectram.co.uk/upload/logo.png" style="width:100%;" alt="branding logo">
                  </div>
                </div>
                <div class="card-content">
               <form action="/site/forgotform" method="post">
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>Forgot Password?</span>
                  </p>
                  <div class="card-body">
					
					
                      <fieldset class="form-group position-relative has-icon-left">
					  <input class="form-control" placeholder="Your Email " required="required" name="LoginForm[email]"  type="email">
						
                        <div class="form-control-position">
                          <i class="ft-envelope"></i>
                        </div>
                      </fieldset>
                  
                      <div class="form-group">
                       
                        
                      <button type="submit"  class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> Recover Password</button>
                 
				
					
                  </div>
                 </form>
                 
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>




    <div id="changepassword" class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <img src="https://insectram.co.uk/upload/logo.png" style="width:100%;" alt="branding logo">
                  </div>
                </div>
                <div class="card-content">
               <form id="idForm">
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span> Please enter your new password!</span>
                  </p>
                  <div class="card-body">
					
					
                      <fieldset class="form-group position-relative has-icon-left">
					  <input class="form-control" id="newpassword" placeholder="New Password " required="required" name="LoginForm[email]"  type="password">
						
                        <div class="form-control-position">
                          <i class="fa fa-key"></i>
                        </div>
                      </fieldset>

					  <fieldset class="form-group position-relative has-icon-left">
					  <input class="form-control" id="againpassword"  placeholder="Verify your password" required="required" name="LoginForm[email]"  type="password">
						
                        <div class="form-control-position">
                          <i class="fa fa-key"></i>
                        </div>
                      </fieldset>

					 
					<div id="change" class="danger"></div>
					<div id="equal" class=""></div>
                  
                      <div class="form-group">
                       
                      
 
                      <a id="key" style="border: 1px solid #3bc6c8;"  class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> Reset Password</a>
					<center>
					  <a  href="<?=Yii::app()->getBaseUrl(true);?>/site/login" style="text-align:center;margin-top:10px;" class="">Login Page</a>
					  </center>
                 
				
					
                  </div>
                 </form>
                 
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>



  <!-- ////////////////////////////////////////////////////////////////////////////-->
 <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
#android:hover{
	    border-color: #65a500;
    background-color: transparent;
    color: #65a500;
}
</style>
  <script>

 $("#getchangecode").hide();
$("#forgotpassword").hide();	
$("#changepassword").hide();
if($("#getchangecode").html()!='')
{
	$("#changepassword").show();
	$("#login").hide();
	 
}
 $(document).ready(function() {
  $('#forgot').click(function(event) {
	   $("#login").fadeOut("hide");
	  $("#forgotpassword").slideDown("slow");	
	 
	
	
 // $("#forgotpasword").animate({top: '-580px'});

});





});

//again password start
	$(function(){
	$('#againpassword').keyup(function(){
		again=document.getElementById("againpassword").value;
		newp=document.getElementById("newpassword").value;
		if(again==newp){
			$("#change").addClass('success');
			$("#change").removeClass('danger');
			
		}
		else
		{
			$("#change").addClass('danger');
			$("#change").removeClass('success');

		}
		});
	});

	
//again password finish
 $('#key').click(function(event) {
		again=document.getElementById("againpassword").value;
		newp=document.getElementById("newpassword").value;
		if(again==newp){
			var status;
			var subject;
			 $.post( "/site/createpassword?code="+$("#getchangecode").html()+"&&password="+newp).done(function( data ) {
				 if(data=="danger")
				 {
					
					toastr.error("Your password change is not successful.","<center>Not Success!</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
					});

				 }
				 if(data=="success")
				 {
					
					 toastr.success("Your password change is successful.","<center>Success!</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
					});

				 }

				  setTimeout(function(){                                  
                   window.location = "<?=Yii::app()->getBaseUrl(true)."/site/login"?>"
                    }, 3000);

			

				//$('#staffteam').html(data);
				
			 });
		}
		else
		{
			$('#equal').html('<p style="color:red">Passwords are not equal</p>');
		}
 });





  </script>


