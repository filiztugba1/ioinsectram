<?php

function replace_between($str, $needle_start, $needle_end, $replacement) {
    $pos = strpos($str, $needle_start);
    $start = $pos === false ? 0 : $pos + strlen($needle_start);

    $pos = strpos($str, $needle_end, $start);
    $end = $pos === false ? strlen($str) : $pos;

    return substr_replace($str, $replacement, $start, $end - $start);
}

$ekle='';
//$str=file_get_contents($path=Yii::app()->basePath.'/config/main.php');
$str=file_get_contents($path='protected/config/main.php');
$basla = '/*authmodulelist*/';
$bit = '/*authmodulelistend*/';

for ($i=0; $i<=0; $i++) /// içeriði silip baþtan ekliyor. Yani bütün modülleri foreach ile yazdýrýyoruz buradan. alper was here kýsmýnýn yerine modül kodlarý. 
{
	$ekle=  "\n"."\t"."\t"."\t"."\t"."'deneme2',". "\n"."\t"."\t"."\t";
}

echo $ekle;
$str= replace_between($str,$basla, $bit, $ekle);

file_put_contents($path, $str);
exit;

?>