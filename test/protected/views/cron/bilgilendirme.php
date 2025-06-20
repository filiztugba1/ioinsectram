<?php
$senderemail='info@insectram.io';//$firm->email;
$sendername='Insectram';
//	$subject=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
//	$altbody=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
//$msg='<b>'.User::model()->dilbul($userx->languageid,'Opened non-conformities').':</b><br>'.$msg2;
//	$subject=' Safran Group '.count($countmail).' adet uygunsuzluk açıldı';
//	$altbody=' Safran Group '.count($countmail).' adet uygunsuzluk açıldı';

$subject='Insectram planlı bakım';
$altbody='Insectram planlı bakım ';
$msg=' dikkate almayınız';

///Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg, 'alpbarutcu@gmail.com','Alper Barutçu');//$buyeremail
exit;

$users=User::model()->findAll(array("condition"=>"active=1"));
foreach($users as $user)
{
 /* echo $buyeremail=$user->email;
  echo '<br>';
  echo $buyername=$user->name.' '.$user->surname;
  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg, $buyeremail,$buyername);//$buyeremail
*/
}


?>
