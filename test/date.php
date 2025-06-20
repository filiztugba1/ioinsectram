<?php if(isset($_GET['time']) && $_GET['time'])
{
echo date('d-m-Y',$_GET['time']);
}


if(isset($_GET['date']) && $_GET['date'])
{
echo strtotime($_GET['date']);
}




?>