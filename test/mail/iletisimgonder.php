 <?php
 
require 'classlar/PHPMailerAutoload.php';
function eposta ($adsoyad,$eposta, $konu, $mesaj,$uploadfile,$dosyaadi){

 
$mailPort     = 465;
$mailUsername = 'alperbarutcu@insectram.io';
$mailPassword = 'ArWnvZ9V/uBVrvjNBtRpXIGBepOWpWcUHmDj/hyWTZ6Q';
$mailfirmaadi = 'Datahan Admin';
$Hostt        = 'email-smtp.eu-west-1.amazonaws.com';


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

$mail->Username         = "AKIA5RYFVY6FV74VI4CY";

$mail->Password         = "$mailPassword";

$mail->setFrom("alperbarutcu@insectram.io","$mailfirmaadi");

$mail->addReplyTo("alperbarutcu@insectram.io","$mailfirmaadi");

$mail->addAddress("$eposta", "$adsoyad");

$mail->CharSet          = 'UTF-8';

$mail->isHTML(true);   

$mail->Subject          = "$konu";

$mail->Body             = "$mesaj";



if(!empty($uploadfile)){

$mail->addAttachment($uploadfile, $dosyaadi);	

}

 //echo "$eposta,";
 echo "$eposta => Sended...".'<br>';

if(!$mail->send()) {

echo 'Mail Gönderilemedi.';

echo '' . $mail->ErrorInfo;

return false ;

} else {



return true ;

}

	

}
$emailler=array (
'alperbarutcu@datahan.com.tr'=>'Alper Barutçu'
/*'ufuktas@datahan.com.tr'=>'Ufuk Taş',
'ufukguvenc@datahan.com.tr'=>'Ufuk Güvenç',
'alpbarutcu@gmail.com'=>'Alper Barutçu',
'mehmetozturk@datahan.com.tr'=>'Mehmet Öztürk',
'burakbayman@datahan.com.tr'=>'Burak Bayman',
'burakbayman@gmail.com'=>'Burak Bayman',
'ufukguvenc06@gmail.com'=>'Ufuk Güvenç',
'mehmetozturkk35@gmail.com'=>'Mehmet Öztürk',
'damladurmus@datahan.com.tr'=>'Damla Durmuş',
'gizemdcomak@datahan.com.tr'=>'Gizem Dinçer Çomak',*/
);

foreach ($emailler as $e=>$n)
{
	 //eposta ('alper barutçu','alpbarutcu@gmail.com','Amazon test emaili','Bu amazon test içeriğidir. <br><center><img  src="https://insectram.io/mail/image.php?email='.$e.'&name='.$n.'"  /> </center>',$uploadfile="",$dosyaadi="") ;

eposta ($n,$e,'Amazon test emaili','Bu amazon test içeriğidir. <br><img  src="https://insectram.io/mail/image.php?email='.$e.'&name='.$n.'&'.time().'" height="30px" width="auto" /> ',$uploadfile="",$dosyaadi="") ;
}
?>