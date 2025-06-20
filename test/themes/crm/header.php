<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from sindevo.com/mobili/mobili/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Nov 2018 08:27:29 GMT -->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" href="images/apple-touch-startup-image-640x920.png">
<title>Insectram - mobile template</title>
<link rel="stylesheet" href="css/swiper.css">
<link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,900" rel="stylesheet"> 
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 

<style>
.navbar--fixed{
position: static !important;
}
.timeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}
.timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: white;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -3px;
}
.container {
    padding: 10px 40px;
    position: relative;
    background-color: inherit;
    width: 75% !important;
}
.right {
    left: 0%;
}

/* The circles on the timeline */
.container::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: -17px;
    background-color: #ff0000;
    border: 4px solid #ffffff;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
}
.right {
    left: 50%;
}
.right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
    left: -16px;
}
.content {
    padding: 20px 30px;
    background-color: white;
    position: relative;
    border-radius: 6px;
}
  /* Place the timelime to the left */
  .timeline::after {
    left: 31px;
  }
  
  /* Full-width containers */
  .container {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .container::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
    left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
    left: 0%;
  }
  .swiper-container-toolbar
  {
  height: 50px !important;
  }
  .toolbar-icon a img{
      max-width: 45px;
  }

</style>
</head>
<body id="mobile_wrap">

    <div class="panel-overlay"></div>

    <div class="panel panel-left panel-reveal">
                  
                 <div class="swiper-container-subnav multinav">
                    <div class="swiper-wrapper">
			<div class="swiper-slide">		
				<nav class="main_nav_underline">
				<ul>
				<li><a href="index.php"><img src="images/icons/gray/home.png" alt="" title="" /><span>Home</span></a></li>
				<li><a href="checklist.php"><img src="images/icons/gray/features.png" alt="" title="" /><span>Checklist</span></a></li>
				</ul>
				</nav>
			</div>	
					</div>
		</div>
    </div>

    <div class="panel panel-right panel-reveal">
      <div class="user_login_info">
	  
                <div class="user_thumb">
           
                  <div class="user_details">
                   <p>Mustafa Zorlu <span>Safran Çevre Sağlık</span></p>
                  </div>  
                  <div class="user_avatar"><img src="images/avatar3.jpg" alt="" title="" /></div>       
                </div>
				
                  <nav class="user-nav">
                    <ul>
                      <li><a href="features.html"><img src="images/icons/gray/settings.png" alt="" title="" /><span>Account Settings</span></a></li>
                      <li><a href="features.html"><img src="images/icons/gray/briefcase.png" alt="" title="" /><span>My Account</span></a></li>
                      <li><a href="features.html"><img src="images/icons/gray/message.png" alt="" title="" /><span>Messages</span><strong>12</strong></a></li>
                      <li><a href="features.html"><img src="images/icons/gray/love.png" alt="" title="" /><span>Favorites</span><strong>5</strong></a></li>
                      <li><a href="index.php?logout=1"><img src="images/icons/gray/lock.png" alt="" title="" /><span>Logout</span></a></li>
                    </ul>
                  </nav>
      </div>
    </div>
    <div class="views">

      <div class="view view-main">

        <div class="pages">

          <div data-page="index" class="page homepage">
            <div class="page-content">
			
		<div class="navbar navbar--fixed navbar--fixed-top">
			<div class="navbar__col navbar__col--title">
				<a href="index.php">Insectram</a>
			</div>
			<!--<div class="navbar__col navbar__col--icon navbar__col--icon-right">
				<a href="#" data-panel="left" class="open-panel"><img src="images/icons/white/menu.png" alt="" title="" /></a>
			</div>-->			
                </div>

                  <!-- Slider -->
			 <div class="col-xs-12" style="height: calc( 91vh - 70px ) !important; overflow-y:scroll; background:#8ddaee;">

			 
<style>
.jobstarthead{
    color: #fff;
    background-color: #4f40f1;
    background: -webkit-linear-gradient(60deg, #4f40f1, #6100bc);
    background: linear-gradient(60deg, #4f40f1, #6100bc);
    padding: 12px 30px;
    font-size: 12px;
}
.elli{float:left;  width: calc( 50% - 10px ) !important;   padding: 5px;}
.yuz{float:left; width: calc( 100% - 10px ) !important;   padding: 5px;}
.atmisbes{float:left; width: calc( 65% - 10px ) !important;   padding: 5px;}
.otuzbes{float:left; width: calc( 35% - 10px ) !important;   padding: 5px;}
.yirmibes{float:left; width: calc( 25% - 10px ) !important;   padding: 5px;}

.pad10{ padding-top:10px !important; padding-bottom:10px !important;}
/* Customize the label (the container) */
.containerx{
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.containerx input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmarkx {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.containerx:hover input ~ .checkmarkx {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.containerx input:checked ~ .checkmarkx {
  background-color: #f39521;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmarkx:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.containerx input:checked ~ .checkmarkx:after {
  display: block;
}

/* Style the checkmark/indicator */
.containerx .checkmarkx:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
			