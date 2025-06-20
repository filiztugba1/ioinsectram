<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="INSECTRAM CRM LOGIN PAGE.">
  <meta name="keywords" content="INSECTRAM CRM">
  <meta name="author" content="DATAHAN">
  <title>Insectram CRM Login Page</title>
  <link rel="apple-touch-icon" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/forms/icheck/custom.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/app.css">
  <!-- END STACK CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/pages/login-register.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/extensions/toastr.css">
  <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-menu" data-col="1-column">

<?php
echo $content;
?>
  <!-- BEGIN VENDOR JS-->
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN STACK JS-->
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/js/core/app-menu.js" type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/js/core/app.js" type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/js/scripts/customizer.js" type="text/javascript"></script>
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
  <!-- END STACK JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>

<?php
Yii::app()->user->setFlash('success-full', "Data saved!");
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	echo '<script>';
	$keytitle='';
    foreach($flashMessages as $key => $message) {
		if ($key=='success')
		{
			$keytitle='Success';
		}
		elseif ($key=='warning')
		{
			$keytitle='Warning';
		}
		elseif ($key=='error')
		{
			$keytitle='Error';
		}
		?>		
		toastr.<?=$key?>("<center><?=$message?></center>", "<center><?=$keytitle?>!</center>", {
				positionClass: "toast-top-full-width",
				containerId: "toast-top-full-width"
		});
  <?php  }  
	echo '</script>';
}
?>
 
  <!-- END PAGE LEVEL JS-->
</body>
</html>