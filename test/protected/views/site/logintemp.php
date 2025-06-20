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

<?php if(isset($_COOKIE['goindex']))
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
 
  <div id="getchangecode"><?=@$_GET['code'];?></div>
  <div id="login" class="app-content content">
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
					
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>Account Details</span>
					
                  </p>

				  <?php if(isset($_GET['active'])){echo '<p style="text-align:center;color: red;">Your membership has been disabled. Please contact the authorities for information!</p>';}?>
				  
				  
				  <?php				   $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));
				   
				   if($systeminmaintenance->ismaintenance==1)
		            {
		                echo '<p style="text-align:center;color: red;">Sistem Bakımda ( System in Maintenance )!</p>';
		            }
				  
				  ?>
                  <div class="card-body">
                    <form id="login-form">

                      <fieldset class="form-group position-relative has-icon-left">
                        <input class="form-control" placeholder="Your Firm Code " required="required" name="LoginForm[code]" id="LoginForm_code" type="text">                      
                          <div class="form-control-position">
                            <i class="ft-code"></i>
                          </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input class="form-control" placeholder="Your Username " required="required" name="LoginForm[username]" id="LoginForm_username" type="text">                      
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input class="form-control" placeholder="Your Password " required="required" name="LoginForm[password]" id="LoginForm_password" type="password">                      
                        <div class="form-control-position">
                          <i class="fa fa-key"></i>
                        </div>
                     </fieldset>
                      <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-sm-left">
                          <fieldset>
                            <input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]"><div class="icheckbox_square-blue" style="position: relative;"><input class="chk-remember" name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>                            <label for="remember-me">Remember Me</label>
                          </fieldset>
                        </div>
                        <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a href="#" id="forgot" class="card-link">Forgot Password?</a></div>
                      </div>
                      <button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> Login</button>
                    </form>
                  </div>
                  
                  
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>New to Insectram?</span>
                  </p>
                  <div class="card-body">
                    <a href="register-with-bg-image.html" class="btn btn-outline-danger btn-block disabled" ><i class="ft-user"></i> Register</a>
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


    $('#login-form').submit(function (e) {
      $.ajax({
                url: "/site/login",
                data: new FormData(this),
                cache: false,
                type: 'POST', // For jQuery < 1.9
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#backgroundLoading").addClass("loadingDisplay");
                    var jsonData =data ;
                    if (jsonData['status'] !== true) {
                      	toastr.error("<center><?='Please check your login informations!'?></center>", "<center><?='Warning'?>!</center>", {
				positionClass: "toast-top-full-width",
				containerId: "toast-top-full-width"
		});
                    } else {
                            	toastr.success("<center><?='Login successful!'?></center>", "<center><?=''?>!</center>", {
				positionClass: "toast-top-full-width",
				containerId: "toast-top-full-width"
		});
                      localStorage.setItem('token', jsonData['data']['token']);
                      localStorage.setItem('name_surname', jsonData['data']['name_surname']);
                      window.location.assign("/");
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                }
            });
      
      return false;
    });



  </script>


