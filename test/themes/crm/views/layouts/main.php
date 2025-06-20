<?php
 if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION']<>''){
          $data = array();
		$data= array();
		api_response($data,false,404,'Bu action apiye uygun değil!');
        exit;
      }
include 'include/header.php';
include 'include/leftmenu.php';
echo $content;

include 'include/footer.php';
?>