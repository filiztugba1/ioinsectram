<?php

if (!isset($_GET['hdde'])){ ?>
 <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow menu-bordered " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" navigation-header">
          <span><?=t('Menu')?></span><i class=" ft-minus" data-toggle="tooltip" data-placement="right"
          data-original-title="General"></i>
        </li>
		
		
		<?php		Yii::app()->getModule('authsystem');
		//Leftmenu::model()->headermenu(0);
		//Authmodules::model()->headermenu(0);
		Authmodules::model()->header2(0);?>
			
	
      </ul>
    </div>
  </div>
<?php 
/* 
Men� Biti�i
*/  
?>
<?php 
/* 
Body Content Header Ba�lang�c�
## Bu k�s�mda g�vdeye yaz�lacak contente ait toparlay�c� divleri ba�lat�yoruz
*/  
?>
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
	  <?php 
/* 
Body Content Header Biti�i
## 
*/  
} else {
	//hdde
}
?>