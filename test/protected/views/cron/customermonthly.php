<?php
$client=Client::model()->findAll(array('condition'=>'parentid=0')); //müşteri hatırlatma
foreach($client as $clientx)
{
	$select=Yii::app()->db->createCommand('SELECT client.id as clientid,clientbranch.id as clientbranchid from conformity INNER JOIN client as clientbranch ON clientbranch.id=conformity.clientid INNER JOIN client ON client.id=clientbranch.parentid where (conformity.statusid=0 or conformity.statusid=5) and client.isdelete!=1 and clientbranch.isdelete!=1 and client.id='.$clientx->id)->queryAll();  	
	
	$say=count($select);
	$usermail=User::model()->findAll(array('condition'=>'clientid='.$clientx->id.' and clientbranchid=0 and type=22')); //müşteri hatırlatma
	if($say!=0)
	{
		foreach($usermail as $usermailx)
		{
			$firm=Firm::model()->find(array('condition'=>'id='.$usermailx->firmid));
			$branch=Firm::model()->find(array('condition'=>'id='.$usermailx->branchid));
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=$branch->name;
			if($sendername=='')
			{
				$sendername=$firm->name;
			}
			$subject=' '.$sendername.' '.User::model()->dilbul($usermailx->languageid,'Uygunsuzluk Durum Bildirimi');
			$altbody=' '.$sendername.' '.User::model()->dilbul($usermailx->languageid,'Uygunsuzluk Durum Bildirimi');
			 $msg=' '.$sendername.' '.User::model()->dilbul($usermailx->languageid,'tarafından açılan').' '.count($select).' '.User::model()->dilbul($usermailx->languageid,'Adet uygunsuzluk/öneri sizler tarafından değerlendirilmemiştir.Bilgilerinize sunarız.');
			
			 echo $buyeremail=$usermailx['email'];
			echo $usermailx['email'];
			// $buyeremail='fcurukcu@gmail.com';
			echo '<br>';
			$buyername=$usermailx['name'].' '.$usermailx['surname'];


			$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
			if(!$ismail)
			{
				 Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg, $buyeremail,$buyername);//$buyeremail
			}
		}
	}


}


$client=Client::model()->findAll(array('condition'=>'parentid!=0')); //müşteri sube hatırlatma
foreach($client as $clientx)
{
	$select=Yii::app()->db->createCommand('SELECT client.id as clientid,clientbranch.id as clientbranchid from conformity INNER JOIN client as clientbranch ON clientbranch.id=conformity.clientid INNER JOIN client ON client.id=clientbranch.parentid where (conformity.statusid=0 or conformity.statusid=5) and client.isdelete!=1 and clientbranch.isdelete!=1 and clientbranch.id='.$clientx->id)->queryAll();  	
	
	$say=count($select);
	$usermail=User::model()->findAll(array('condition'=>'type=26 and clientbranchid='.$clientx->id)); //müşteri sube hatırlatma
	if($say!=0)
	{
		foreach($usermail as $usermailx)
		{
			$firm=Firm::model()->find(array('condition'=>'id='.$usermailx->firmid));
			$branch=Firm::model()->find(array('condition'=>'id='.$usermailx->branchid));
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=$branch->name;
			if($sendername=='')
			{
				$sendername=$firm->name;
			}
			$subject=' '.$sendername.' '.User::model()->dilbul($usermailx->languageid,'Uygunsuzluk Durum Bildirimi');
			$altbody=' '.$sendername.' '.User::model()->dilbul($usermailx->languageid,'Uygunsuzluk Durum Bildirimi');
			 $msg=' '.$sendername.' '.User::model()->dilbul($usermailx->languageid,'tarafından açılan').' '.count($select).' '.User::model()->dilbul($usermailx->languageid,'Adet uygunsuzluk/öneri sizler tarafından değerlendirilmemiştir.Bilgilerinize sunarız.');
			
			echo $buyeremail=$usermailx['email'];
			echo $usermailx['email'];
			 //$buyeremail='fcurukcu@gmail.com';
			echo '<br>';
			$buyername=$usermailx['name'].' '.$usermailx['surname'];


			$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
			if(!$ismail)
			{
				 Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg, $buyeremail,$buyername);//$buyeremail
			}
		}
	}


}






?>