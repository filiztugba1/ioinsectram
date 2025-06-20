<?php

$site = "https://insectram.io/mail/";

	function tarihduzelt ($t){



$newDate = date("d-m-Y H:i", strtotime($t));



return $newDate;



}

 function timeTR($f, $zt = 'now'){  

    $z = date("$f", strtotime($zt));  

    $donustur = array(  

        'Monday'    => 'Pazartesi',  

        'Tuesday'   => 'Salı',  

        'Wednesday' => 'Çarşamba',  

        'Thursday'  => 'Perşembe',  

        'Friday'    => 'Cuma',  

        'Saturday'  => 'Cumartesi',  

        'Sunday'    => 'Pazar',  

        'January'   => 'Ocak',  

        'February'  => 'Şubat',  

        'March'     => 'Mart',  

        'April'     => 'Nisan',  

        'May'       => 'Mayıs',  

        'June'      => 'Haziran',  

        'July'      => 'Temmuz',  

        'August'    => 'Ağustos',  

        'September' => 'Eylül',  

        'October'   => 'Ekim',  

        'November'  => 'Kasım',  

        'December'  => 'Aralık',  

        'Mon'       => 'Pts',  

        'Tue'       => 'Sal',  

        'Wed'       => 'Çar',  

        'Thu'       => 'Per',  

        'Fri'       => 'Cum',  

        'Sat'       => 'Cts',  

        'Sun'       => 'Paz',  

        'Jan'       => 'Oca',  

        'Feb'       => 'Şub',  

        'Mar'       => 'Mar',  

        'Apr'       => 'Nis',  

        'Jun'       => 'Haz',  

        'Jul'       => 'Tem',  

        'Aug'       => 'Ağu',  

        'Sep'       => 'Eyl',  

        'Oct'       => 'Eki',  

        'Nov'       => 'Kas',  

        'Dec'       => 'Ara',  

    );  

    foreach($donustur as $en => $tr){  

        $z = str_replace($en, $tr, $z);  

    }  

    if(strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z = str_replace('Mayıs', 'May', $z);  

    return $z;  

} 



function emailkontrol($deger){

if(isset($deger) AND !is_array($deger) AND is_string($deger) ) {

$sonuc =   trim(filter_input(INPUT_POST,''.e($deger).'', FILTER_SANITIZE_EMAIL));

return  $sonuc;

 }else{

break;


 }

 

}



function get($deger){

if(isset($deger) AND !is_array($deger) AND is_string($deger) ) {

 $sonuc =  trim(filter_input(INPUT_GET, ''.e($deger).'',  FILTER_SANITIZE_STRING));

 return  $sonuc;

 }else{

break;

 }

}



function post($deger){

if(isset($deger) AND !is_array($deger) AND is_string($deger) ) {

$sonuc = trim(filter_input(INPUT_POST,''.e($deger).'',  FILTER_SANITIZE_STRING));

 return  $sonuc;

 }else{

break;

 }

}


function go($par, $time = 0){

//header('Refresh: '.$time.'; url='.$par.'');	

//echo '<script>window.setTimeout(function() {window.location.href = "'.$par.'";}, '.$time.'000);</script>';

	}

function eposta ($adsoyad,$eposta, $konu, $mesaj,$uploadfile,$dosyaadi){

 
$mailPort     = 465;
$mailUsername = 'AKIA5RYFVY6FV74VI4CY';
$mailPassword = 'ArWnvZ9V/uBVrvjNBtRpXIGBepOWpWcUHmDj/hyWTZ6Q';
$mailfirmaadi = 'Datahan Admin';
$Hostt        = 'email-smtp.eu-west-1.amazonaws.com';

require 'classlar/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSendmail();

$mail->IsSMTP(); 

$mail->SMTPDebug        = 0; 

$mail->SMTPAuth         = true; 

$mail->Mailer           = 'smtp';

$mail->Host             = "$Hostt";

$mail->Port             = "$mailPort";
//Normalde var içi boş
$mail->SMTPSecure     = 'ssl'; 
//Normalde böyle bir satır yok
$mail->SMTPAutoTLS      = false;

$mail->Username         = "$mailUsername";

$mail->Password         = "$mailPassword";

$mail->setFrom("$mailUsername","$mailfirmaadi");

$mail->addReplyTo("$mailUsername","$mailfirmaadi");

$mail->addAddress("$mailUsername", "$adsoyad");

$mail->CharSet          = 'UTF-8';

$mail->isHTML(true);   

$mail->Subject          = "$konu";

$mail->Body             = "$mesaj";



if(!empty($uploadfile)){

$mail->addAttachment($uploadfile, $dosyaadi);	

}

 

if(!$mail->send()) {

echo 'Mail Gönderilemedi.';

echo '' . $mail->ErrorInfo;

return false ;

} else {



return true ;

}

	

}





function e($data)

{

    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array(

        '&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);

    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);

    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);

    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);

    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20] *r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);

    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00- \x20]*:* [^>]*+>#iu', '$1>', $data);

    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {

        $old_data = $data;

        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);

    } while ($old_data !== $data);

    return $data;

}



?>