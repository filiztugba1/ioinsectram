<?php

if (isset($_GET['email'])){
file_put_contents("iletim.php", $_GET['email'].' ('. $_GET['name'].') =>'.date('d.m.Y H:i:s')." tarihinde okundu.<br>", FILE_APPEND);
}
$file = 'logo.png';
$type = 'image/png';
header('Content-Type:'.$type);
header('Content-Length: ' . filesize($file));
readfile($file);
?>