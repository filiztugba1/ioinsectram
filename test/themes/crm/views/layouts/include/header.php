<?php

$ax= User::model()->userobjecty('');
	$user=User::model()->findbypk($ax->id);


//dil deðiþince caþýþacak kod
if(isset($_GET['languageok']))
{
	Yii::app()->getModule('translate');
	$language= Translatelanguages::model()->find(array('condition'=>'name="'.$_GET['languageok'].'"'))->id;
	$lguser=User::model()->findbypk($ax->id);
	$lguser->languageid=$language;
	$lguser->save();
} //bitis
User::model()->login();
$usersinfo=Userinfo::model()->find(array(
						   #'select'=>'title',
							'condition'=>'id=:id',
							'params'=>array(':id'=>$ax->id),
						));
$moduleid='';
$controllerid='';
$actionid='';
$activepageid='';
if (isset(Yii::app()->controller->module->id)){
	$moduleid=Yii::app()->controller->module->id.'/';
}
if (isset(Yii::app()->controller->id)){
	$controllerid=Yii::app()->controller->id.'/';
}
if (isset(Yii::app()->controller->action->id)){
	if (Yii::app()->controller->action->id=='index')
	{
		$actionid='';
	}else
	{
		$actionid=Yii::app()->controller->action->id.'/';
	}
}
	Yii::app()->params['activepageid']='/'.$moduleid.$controllerid.$actionid;
	function menuactive($url,$addsubmenu='')
	{
		//ltrim(Yii::app()->params['activepageid'],'/site/').' | '.$url;
		$active='';
		if ($addsubmenu<>''){
		if (strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],$url)>0){ $active='active';}
		}else{
		if ( '/'.ltrim(Yii::app()->params['activepageid'],'/site/')==$url){ $active='active';}

		}
			return $active;
	}


	//menu active
	$url=$_SERVER['REQUEST_URI'];

//userobject



?>




<!DOCTYPE html>
<html translate="no" class="loading" lang="en" data-textdirection="ltr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="google" content="notranslate">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="DATAHAN">
  <title><?php
  if (CHtml::encode($this->pageTitle)<>'') {echo CHtml::encode($this->pageTitle);}else{ echo 'Dashboard - Datahan CRM';} ?></title>
  <link rel="apple-touch-icon" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/extensions/unslider.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/weather-icons/climacons.min.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/fonts/meteocons/style.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/charts/morris.css">
  <!-- END VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/plugins/forms/switch.css">

  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/app.css">
  <!-- END STACK CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/fonts/simple-line-icons/style.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/extensions/toastr.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/pages/timeline.css">
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
  <!-- BEGIN VENDOR JS-->
	<link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/css/forms/toggle/switchery.min.css">
  <script src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  
  <?php include 'defaultModuleJs.php';?>
<?php
	$scriptlist=explode(';',Yii::app()->params['css']);
	foreach($scriptlist as $item)
	{
		if (strlen($item)>=3)
			{
			echo '  <link rel="stylesheet" type="text/css" href="'.$item.'?1">'."\r\n";
			}
	}
  ?>
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->

  <!-- END Custom CSS-->

  <style>
  * {

    text-transform: none !important;
}
.nav.navbar-nav.mr-auto.float-left
{
z-index:9999999999;
}
  .custom-select {
  background: unset;
  }
  .navbar-semi-dark .navbar-header {
    background: #fff;
}
.navbar-semi-dark .navbar-nav .nav-link {
    color: #ffffff;
}

.header-navbar .navbar-container {
    padding: 0rem 18px;
    transition: 300ms ease all;
    background: #404e67;

}

body.vertical-layout.vertical-menu-modern.menu-collapsed .navbar .navbar-brand {
    padding: 10px 0px;
}

.header-navbar .navbar-header {
    height: 100%;
    width: 240px;
    height: 4rem;
    float: left;
    position: relative;
    padding: 0px 4px 0px 11px;
    transition: 300ms ease all;
}

.header-navbar .navbar-header .navbar-brand {
    padding: 8px 0px;
}
.btn:not(:disabled):not(.disabled)
{
 border: solid !important;
  border-width: 1px !important;
}
  </style>

</head>


<?php




$menu=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'menu','userid'=>$ax->id)
							   ));
	if(!isset($aa) || count($menu)==0)
	{
		Generalsettings::model()->defaultcreate('menu');
	}


	if($menu->type==1)
	{
		$menucollapsed='';
	}else
	{
		$menucollapsed='';
	}
	if (!isset($_GET['hdde'])){
	?>
  <div id="backgroundLoading" class=""></div>
		<body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar pace-done  menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
			




  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-border navbar-semi-light bg-gradient-x-grey-blue">
      <div class="navbar-wrapper" style=" background: #404e67;">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row position-relative">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1" style="color:#404e67;"></i></a></li>
            <li class="nav-item mr-auto">
				<a class="navbar-brand" href="/">
              <img class="brand-logo" alt="stack admin logo" style="width:40px;" src="<?=Yii::app()->baseUrl.'/images/insectram.png';?>">
              <img class="brand-logo" alt="stack admin logo" style=" width: 126px;margin-left: 4px;line-height: 0;padding-bottom: 6px;" src="<?=Yii::app()->baseUrl.'/images/insectram_.png';?>">
					   </a>



					   </li>
            <li class="nav-item d-none d-md-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" onclick="menu(this)"  data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 " style="color: #404e67 !important;" data-ticon="ft-toggle-right"></i></a></li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i style="color:#404e67;" class="fa fa-ellipsis-v"></i></a></li>
          </ul>
        </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">


          <ul class="nav navbar-nav mr-auto float-left">



		  <?php
            /* <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Mega</a>
              <ul class="mega-dropdown-menu dropdown-menu row">
                <li class="col-md-2">
                  <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="fa fa-newspaper-o"></i> News</h6>
                  <div id="mega-menu-carousel-example">
                    <div>
                      <img class="rounded img-fluid mb-1" src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/slider/slider-2.png"
                      alt="First slide"><a class="news-title mb-0" href="#">Poster Frame PSD</a>
                      <p class="news-content">
                        <span class="font-small-2">January 26, 2016</span>
                      </p>
                    </div>
                  </div>
                </li>
                <li class="col-md-3">
                  <h6 class="dropdown-menu-header text-uppercase"><i class="fa fa-random"></i> Drill down menu</h6>
                  <ul class="drilldown-menu">
                    <li class="menu-list">
                      <ul>
                        <li>
                          <a class="dropdown-item" href="layout-2-columns.html"><i class="ft-file"></i> Page layouts & Templates</a>
                        </li>
                        <li><a href="#"><i class="ft-align-left"></i> Multi level menu</a>
                          <ul>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-bookmark-o"></i>  Second level</a></li>
                            <li><a href="#"><i class="fa fa-lemon-o"></i> Second level menu</a>
                              <ul>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-heart-o"></i>  Third level</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-file-o"></i> Third level</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-trash-o"></i> Third level</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa fa-clock-o"></i> Third level</a></li>
                              </ul>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-hdd-o"></i> Second level, third link</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-floppy-o"></i> Second level, fourth link</a></li>
                          </ul>
                        </li>
                        <li>
                          <a class="dropdown-item" href="color-palette-primary.html"><i class="ft-camera"></i> Color pallet system</a>
                        </li>
                        <li><a class="dropdown-item" href="sk-2-columns.html"><i class="ft-edit"></i> Page starter kit</a></li>
                        <li><a class="dropdown-item" href="changelog.html"><i class="ft-minimize-2"></i> Change log</a></li>
                        <li>
                          <a class="dropdown-item" href="https://pixinvent.ticksy.com/"><i class="fa fa-life-ring"></i> Customer support center</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="col-md-3">
                  <h6 class="dropdown-menu-header text-uppercase"><i class="fa fa-list-ul"></i> Accordion</h6>
                  <div id="accordionWrap" role="tablist" aria-multiselectable="true">
                    <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                      <div class="card-header p-0 pb-2 border-0" id="headingOne" role="tab"><a data-toggle="collapse" data-parent="#accordionWrap" href="#accordionOne"
                        aria-expanded="true" aria-controls="accordionOne">Accordion Item #1</a></div>
                      <div class="card-collapse collapse show" id="accordionOne" role="tabpanel" aria-labelledby="headingOne"
                      aria-expanded="true">
                        <div class="card-content">
                          <p class="accordion-text text-small-3">Caramels dessert chocolate cake pastry jujubes bonbon.
                            Jelly wafer jelly beans. Caramels chocolate cake liquorice
                            cake wafer jelly beans croissant apple pie.</p>
                        </div>
                      </div>
                      <div class="card-header p-0 pb-2 border-0" id="headingTwo" role="tab"><a class="collapsed" data-toggle="collapse" data-parent="#accordionWrap"
                        href="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Accordion Item #2</a></div>
                      <div class="card-collapse collapse" id="accordionTwo" role="tabpanel" aria-labelledby="headingTwo"
                      aria-expanded="false">
                        <div class="card-content">
                          <p class="accordion-text">Sugar plum bear claw oat cake chocolate jelly tiramisu
                            dessert pie. Tiramisu macaroon muffin jelly marshmallow
                            cake. Pastry oat cake chupa chups.</p>
                        </div>
                      </div>
                      <div class="card-header p-0 pb-2 border-0" id="headingThree" role="tab"><a class="collapsed" data-toggle="collapse" data-parent="#accordionWrap"
                        href="#accordionThree" aria-expanded="false" aria-controls="accordionThree">Accordion Item #3</a></div>
                      <div class="card-collapse collapse" id="accordionThree" role="tabpanel" aria-labelledby="headingThree"
                      aria-expanded="false">
                        <div class="card-content">
                          <p class="accordion-text">Candy cupcake sugar plum oat cake wafer marzipan jujubes
                            lollipop macaroon. Cake dragée jujubes donut chocolate
                            bar chocolate cake cupcake chocolate topping.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="col-md-4">
                  <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="fa fa-envelope-o"></i> Contact Us</h6>
                  <form class="form form-horizontal">
                    <div class="form-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="inputName1">Name</label>
                        <div class="col-sm-9">
                          <div class="position-relative has-icon-left">
                            <input class="form-control" type="text" id="inputName1" placeholder="John Doe">
                            <div class="form-control-position pl-1"><i class="fa fa-user-o"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="inputEmail1">Email</label>
                        <div class="col-sm-9">
                          <div class="position-relative has-icon-left">
                            <input class="form-control" type="email" id="inputEmail1" placeholder="john@example.com">
                            <div class="form-control-position pl-1"><i class="fa fa-envelope-o"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="inputMessage1">Message</label>
                        <div class="col-sm-9">
                          <div class="position-relative has-icon-left">
                            <textarea class="form-control" id="inputMessage1" rows="2" placeholder="Simple Textarea"></textarea>
                            <div class="form-control-position pl-1"><i class="fa fa-commenting-o"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 mb-1">
                          <button class="btn btn-primary float-right" type="button"><i class="fa fa-paper-plane-o"></i> Send</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </li>
              </ul>
            </li>  */ ?>




            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>

         <?php if($ax->clientid==0){?>
			<li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
              <div class="search-input">

			  <form>

				 <input id="livesearch2" class="input" type="text"  placeholder="Explore...">
				<div id="livesearch"></div>

			  </form>



			  </div>

            </li>
			<?php }?>


          </ul>
          <ul class="nav navbar-nav float-right">

				<?php $ax= User::model()->userobjecty('');

				if($ax->firmid>0)
				{?>
				  <?php					if($ax->branchid>0)
					{
						if($ax->clientid>0)
						{
							if($ax->clientbranchid>0)
							{
								$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
								$branch=Firm::model()->find(array('condition'=>'id='.$ax->branchid));
								$client=Client::model()->find(array('condition'=>'id='.$ax->clientid));
								$clientbranch=Client::model()->find(array('condition'=>'id='.$ax->clientbranchid));
								$curf= $firm->name.' > '.$branch->name.' > '.$client->name.' > '.$clientbranch->name;

								if(strlen($curf)>50)
								{
								   $curf= '...'.$client->name.' > '.$clientbranch->name;
								}
							}
							else
							{
								$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
								$branch=Firm::model()->find(array('condition'=>'id='.$ax->branchid));
								$client=Client::model()->find(array('condition'=>'id='.$ax->clientid));
								$curf=  $firm->name.' > '.$branch->name.' > '.$client->name;
							}
						}
						else
						{
							$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
							$branch=Firm::model()->find(array('condition'=>'id='.$ax->branchid));
							$curf= $firm->name.' > '.$branch->name;
						}
					}
					else
					{
						$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
						$curf= $firm->name;

					}?>


				<?php }


				?>


            <?php if($ax->id==1){

            $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));
            if($systeminmaintenance->ismaintenance==0){?>
                <li><a href="?ismaintenance=1" style='margin-top: 16px;' class="btn btn-sm btn-danger">Sistemi bakıma al!</a></li>
            <?php }else{?>
                <li><a href="?ismaintenance=0" style='margin-top: 16px;' class="btn btn-sm btn-success">Sistemi bakımdan çıkar!</a></li>
            <?php }}?>

            <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" style='font-size: 9px;'><i class="fa fa-exchange "></i><span class="selected-language"></span><?=$curf?></a>

			  <div class="dropdown-menu" aria-labelledby="dropdown-flag" style='overflow: scroll;max-height:200px'>

				<?php

						foreach(User::model()->getauthcb() as $authx)
					{?>
							 <a class="dropdown-item" href="/?changemode=<?=$authx?>"><i class="fa fa-exchange "></i><?=User::model()->getauthxname($authx);?></a>
					<?php
					}
						?>


              <?php /*  <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a> */ ?>
              </div>
            </li>

            <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-<?=Yii::app()->getModule('translate')->language->definedlanguageflag();?>"></i><span class="selected-language"></span></a>

			  <div class="dropdown-menu" aria-labelledby="dropdown-flag">
			   <?php $tranlateslanguage= Yii::app()->getModule('translate')->language->getlanguages(); ?>

				<?php foreach($tranlateslanguage as $tlanguage){?>
					 <a class="dropdown-item" href="?language=<?=$tlanguage->name?>"><i class="flag-icon flag-icon-<?=$tlanguage->flag;?>"></i><?=$tlanguage->title;?></a>
				<?php }?>
              <?php /*  <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
                <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a> */ ?>
              </div>
            </li>

				  <?php  $notifications=Notifications::model()->findAll(array(
								   #'select'=>'',
								   'limit'=>'5',
								   'order'=>'createdtime DESC',
								   'condition'=>'userid=:userid','params'=>array('userid'=>$ax->id)
							   ));





						?>
  <?php $count=Notifications::model()->findAll(array(
								   'condition'=>'userid=:userid and readtime=:readtime','params'=>array('userid'=>$ax->id,'readtime'=>0)
							   ));?>
					<?php
						if (count($count)==0)
						{
							$dspl='none';
						}else
						{
							$dspl='inline-block';
						}
					?>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label"  href="#" data-toggle="dropdown" onclick="openmodaldurum(this)"><i class="ficon ft-bell"></i>
                   <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="deger" style="display:<?=$dspl;?>;">

				   <?=count($count);?></span>

				   <!-- <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="deger" style="display:none;">


					</span>  -->
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2"><?=t("Notifications");?></span>


                    <span class="notification-tag badge badge-default badge-danger float-right m-0" id="deger1" style="display:<?=$dspl;?>;"><?=count($count);?> <?=t("new");?></span>
                  </h6>
                </li>
                <li class="scrollable-container media-list" id="notificationscontainer">
				<?php foreach($notifications as $notificatex){?>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">
							<?php  $sender=User::model()->find(array('condition'=>'id='.$notificatex->sender));?>
							<?=$sender->name.' '.$sender->surname;?>

						</h6>
                        <p class="notification-text font-small-3 text-muted"><?=$notificatex->subject;?></p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00"><?=date('d.m.Y H:i:s', $notificationx->createdtime);?></time>
                        </small>
                      </div>
                    </div>
                  </a>
				<?php }?>


				  <?php /*
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                        <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">Complete the task</h6>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">Generate monthly report</h6>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
				*/?>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="/notifications/index"><?=t('Read all notifications');?></a></li>
              </ul>
            </li>





            <?php /*   <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i>
               <?php /* <span class="badge badge-pill badge-default badge-warning badge-default badge-up">3</span> */ ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
               <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">
					Messages</span>
                       <?php /* <span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span> */ ?>
                  </h6>
                </li>
               <li class="scrollable-container media-list">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-online rounded-circle">
                          <img src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Margaret Govan</h6>
                        <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-busy rounded-circle">
                          <img src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Bret Lezama</h6>
                        <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-online rounded-circle">
                          <img src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Carie Berra</h6>
                        <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-away rounded-circle">
                          <img src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Eric Alsobrook</h6>
                        <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li> */ ?>
              </ul>
            </li>
 <!--
			 <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label"  href="/email/email/emailgo"><i class="ficon ft-message-square"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="deger" style="display:<?=$dspl;?>;">

				   <?=count($count);?></span>
              </a>

			  </li>
-->


            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="avatar avatar-online">
                  <img src="<?php if($user->image!=''){echo Yii::app()->baseUrl.'/'.$user->image;}else {if($usersinfo->gender==0){ echo Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mr.png';}else{echo Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }}?>"  alt="Avatar">


<i></i></span>
                <span class="user-name"><?=$ax->username;?></span>
              </a>




              <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="/user/editprofile/<?=$ax->id;?>"><i class="ft-user"></i><?=t("Edit Profile");?></a>

			<div class="dropdown-divider"></div>
			 <a class="dropdown-item" href="/user/company/<?=$ax->id;?>"><i class="fa fa-building-o"></i><?=t("Edit My Company");?></a>



                 <?php /*   <a class="dropdown-item" href="email-application.html"><i class="ft-mail"></i> My Inbox</a>
                <a class="dropdown-item" href="user-cards.html"><i class="ft-check-square"></i> Task</a>
                <a class="dropdown-item" href="chat-application.html"><i class="ft-message-square"></i> Chats</a>  */  ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/site/logout"><i class="ft-power"></i><?=t("Logout");?></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
<?php
	}else
	{echo '<body>';
	}
/*
Menü Baþlangýcý
*/
?>
