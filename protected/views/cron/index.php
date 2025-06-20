<?php
/*
Conformity::model()->email('oneri.uygunsuzluk@insectram.io','oneri','test','test','test','Sibel.saglam@pakmaya.com','Sibel Sağlam');
Conformity::model()->email('oneri.uygunsuzluk@insectram.io','oneri','test','test','test','duzceinstantf@pakmaya.com','duzceinstantf@pakmaya.com');
Conformity::model()->email('oneri.uygunsuzluk@insectram.io','oneri','test','test','test','alpbarutcu@gmail.com','Alper Barutçu');
*/

// firm user mail
	$select=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,client.username as clientuser,clientbranch.username as cbranchuser,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id where conformity.endofdayemail=0 GROUP BY firmuser')->queryAll();
	foreach ($select as $item)
	{


		$countmail=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.name as branchname,firmbranch.username as branchuser,client.username as clientuser,client.name as clientname,clientbranch.name as cbranchname,clientbranch.username as cbranchuser,departments.name as departmentname,subdepartments.name as subname,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departments ON departments.id=conformity.departmentid INNER JOIN departments as subdepartments ON subdepartments.id=conformity.subdepartmentid where conformity.endofdayemail=0 and firm.id='.$item['firmid'])->queryAll();
		$msg2='';


		foreach($countmail as $countmailx)
		{
			//$msg2=$msg2.' [ '.$countmailx['firmname'].' > '.$countmailx['branchname'].' > '.$countmailx['clientname'].' > '.$countmailx['cbranchname'].'>'.$countmailx['departmentname'].'>'.$countmailx['subname'].' ] '.' ,<br>';
			$msg2=$msg2.$countmailx['cbranchname'].' '.$countmailx['numberid'].' '.$countmailx['definition'].' '.date("d-m-Y",$countmailx['date']).' Url:<a href="https://insectram.io/conformity/activity/'.$countmailx['id'].'">'.$countmailx['numberid'].'</a> ,<br>';
		}


		$usermail=Yii::app()->db->createCommand('SELECT * from user INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id where user.active=1 and user.branchid=0 and AuthAssignment.itemname LIKE "'.$item['packages'].'.'.$item['firmuser'].'.Admin"')->queryAll();

		foreach($usermail as $usermailx)
		{
			if ( $usermailx->languageid<>8){
					$senderemail='recommendations@insectram.io';//$firm->email;
			}else{
						$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
			}
	
		
			$sendername=$item['firmname'];
		//	$subject=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
		//	$altbody=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
		//$msg='<b>'.User::model()->dilbul($userx->languageid,'Opened non-conformities').':</b><br>'.$msg2;
		//	$subject=' Safran Group '.count($countmail).' adet uygunsuzluk açıldı';
		//	$altbody=' Safran Group '.count($countmail).' adet uygunsuzluk açıldı';

			$subject=' '.$sendername.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
			$altbody=' '.$sendername.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');

			 $msg='<b>'.User::model()->dilbul($usermailx->languageid,'Açılan Uygunsuzluklar').':</b><br>'.$msg2;
		//	$msg=$subject.'<br>'.$msg.'<br>url:<a href="https://insectram.io/conformity">'.User::model()->dilbul($userx->languageid,'Non-Comformity').'</a>';
			$msg=$subject.'<br>'.$msg;

			echo $buyeremail=$usermailx['email'];
			echo '<br>';
			 $buyername=$usermailx['name'].' '.$usermailx['surname'];


			$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
			if(!$ismail)
			{
				Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg, $buyeremail,$buyername);//$buyeremail
			}
		}

	}
echo '<br> branchmail <br>';
// branch user mail

	$select=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,firmbranch.id as firmbranchid,client.username as clientuser,clientbranch.username as cbranchuser,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id where conformity.endofdayemail=0 GROUP BY branchuser')->queryAll();
	foreach ($select as $item)
	{
		$countmail=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.name as branchname,firmbranch.username as branchuser,client.username as clientuser,client.name as clientname,clientbranch.name as cbranchname,clientbranch.username as cbranchuser,departments.name as departmentname,subdepartments.name as subname,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departments ON departments.id=conformity.departmentid INNER JOIN departments as subdepartments ON subdepartments.id=conformity.subdepartmentid where conformity.endofdayemail=0 and clientbranch.firmid='.$item['firmbranchid'])->queryAll();
		$msg2='';

		foreach($countmail as $countmailx)
		{
		//	$msg2=$msg2.' [ '.$countmailx['firmname'].' > '.$countmailx['branchname'].' > '.$countmailx['clientname'].' > '.$countmailx['cbranchname'].' > '.$countmailx['departmentname'].' > '.$countmailx['subname'].' ] '.' ,<br>';
$msg2=$msg2.$countmailx['cbranchname'].' '.$countmailx['numberid'].' '.$countmailx['definition'].' '.date("d-m-Y",$countmailx['date']).' Url:<a href="https://insectram.io/conformity/activity/'.$countmailx['id'].'">'.$countmailx['numberid'].'</a> ,<br>';
		}


		$usermail=Yii::app()->db->createCommand('SELECT * from user INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id where user.active=1 and user.branchid!=0 and AuthAssignment.itemname LIKE "'.$item['packages'].'.'.$item['firmuser'].'.'.$item['branchuser'].'.Admin"')->queryAll();

		foreach($usermail as $usermailx)
		{
					if ( $usermailx->languageid<>8){
					$senderemail='recommendations@insectram.io';//$firm->email;
			}else{
						$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
			}
		//	$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
			$sendername=$item['firmname'];
		//	$subject=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
		//	$altbody=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
		//$msg='<b>'.User::model()->dilbul($userx->languageid,'Opened non-conformities').':</b><br>'.$msg2;
		$subject=' '.$sendername.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
		$altbody=' '.$sendername.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
			 $msg='<b>'.User::model()->dilbul($usermailx->languageid,'Açılan Uygunsuzluklar').':</b><br>'.$msg2;
		//	$msg=$subject.'<br>'.$msg.'<br>url:<a href="https://insectram.io/conformity">'.User::model()->dilbul($userx->languageid,'Non-Comformity').'</a>';
			$msg=$subject.'<br>'.$msg;
			echo $buyeremail=$usermailx['email'];
			 $buyername=$usermailx['name'].' '.$usermailx['surname'];
			 echo '<br>';

			$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
			if(!$ismail)
			{
			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg, $buyeremail,$buyername);//$buyeremail
			}
		}

	}




	// client user mail

	$select=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,client.id as clientidx,client.username as clientuser,clientbranch.username as cbranchuser,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id where conformity.endofdayemail=0 GROUP BY clientuser')->queryAll();
	foreach ($select as $item)
	{
		$countmail=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.name as branchname,firmbranch.username as branchuser,client.username as clientuser,client.name as clientname,clientbranch.name as cbranchname,clientbranch.username as cbranchuser,departments.name as departmentname,subdepartments.name as subname,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departments ON departments.id=conformity.departmentid INNER JOIN departments as subdepartments ON subdepartments.id=conformity.subdepartmentid where conformity.endofdayemail=0 and client.id='.$item['clientidx'])->queryAll();
		$msg2='';
		$cbranchname='';
		foreach($countmail as $countmailx)
		{
		//	$msg2=$msg2.' [ '.$countmailx['firmname'].' > '.$countmailx['branchname'].' > '.$countmailx['clientname'].' > '.$countmailx['cbranchname'].' > '.$countmailx['departmentname'].' > '.$countmailx['subname'].' ] '.' ,<br>';
	$msg2=$msg2.$countmailx['cbranchname'].' '.$countmailx['numberid'].' '.$countmailx['definition'].' '.date("d-m-Y",$countmailx['date']).' Url:<a href="https://insectram.io/conformity/activity/'.$countmailx['id'].'">'.$countmailx['numberid'].'</a> ,<br>';
	$cbranchname=$countmailx['cbranchname'];
		}

		$usermail=Yii::app()->db->createCommand('SELECT * from user INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id where user.active=1 and AuthAssignment.itemname LIKE "'.$item['packages'].'.'.$item['firmuser'].'.'.$item['branchuser'].'.'.$item['clientuser'].'.Admin"')->queryAll();

		foreach($usermail as $usermailx)
		{
					if ( $usermailx->languageid<>8){
					$senderemail='recommendations@insectram.io';//$firm->email;
			}else{
						$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
			}
		//	$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
			$sendername=$item['firmname'];
		//	$subject=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
		//	$altbody=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
		//$msg='<b>'.User::model()->dilbul($userx->languageid,'Opened non-conformities').':</b><br>'.$msg2;
			$subject=' '.$cbranchname.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
			$altbody=' '.$cbranchname.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
			 $msg='<b>'.User::model()->dilbul($usermailx->languageid,'Açılan Uygunsuzluklar').':</b><br>'.$msg2;
		//	$msg=$subject.'<br>'.$msg.'<br>url:<a href="https://insectram.io/conformity">'.User::model()->dilbul($userx->languageid,'Non-Comformity').'</a>';
			$msg=$subject.'<br>'.$msg;
		echo $buyeremail=$usermailx['email'];
			 $buyername=$usermailx['name'].' '.$usermailx['surname'];
		echo '<br>';

			$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
			if(!$ismail)
			{

				Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//$buyeremail
			}
		}

	}


	// client user mail

	/*
	$select=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,client.id as clientid,client.username as clientuser,clientbranch.username as cbranchuser,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id where conformity.endofdayemail=0 GROUP BY clientuser')->queryAll();
	foreach ($select as $item)
	{
		$countmail=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.name as branchname,firmbranch.username as branchuser,client.username as clientuser,client.name as clientname,clientbranch.name as cbranchname,clientbranch.username as cbranchuser,departments.name as departmentname,subdepartments.name as subname,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departments ON departments.id=conformity.departmentid INNER JOIN departments as subdepartments ON subdepartments.id=conformity.subdepartmentid where conformity.endofdayemail=0 and client.id='.$item['clientid'])->queryAll();
		$msg2='';



		$usermail=Yii::app()->db->createCommand('SELECT * from user INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id where AuthAssignment.itemname LIKE "'.$item['packages'].'.'.$item['firmuser'].'.'.$item['branchuser'].'.'.$item['clientuser'].'.Admin"')->queryAll();



		foreach($usermail as $usermailx)
		{
			if($item['clientid']==$usermailx['mainclientbranchid'])
			{
				$senderemail='info@insectram.io';//$firm->email;
				$sendername=$item['firmname'];
				$subject=count($countmail).' pieces of non-compliance opened';
				$altbody=count($countmail).' pieces of non-compliance opened';

				$msg=$subject.'<br>url:<a href="development.insectram.io/conformity">Non Comformity</a>';

				echo $buyeremail=$usermailx['email'];
				 $buyername=$usermailx['name'].' '.$usermailx['surname'];
				 echo '<br>';

				$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=1','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
				if(count($ismail)>0)
				{
					Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);//$buyeremail
				}
			}
		}

	}


*/

	// clientbranch user mail
	$select=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,clientbranch.id as clientbranchid,client.username as clientuser,clientbranch.username as cbranchuser,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id where conformity.endofdayemail=0 GROUP BY cbranchuser')->queryAll();
	foreach ($select as $item)
	{
		$countmail=Yii::app()->db->createCommand('SELECT firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.name as branchname,firmbranch.username as branchuser,client.username as clientuser,client.name as clientname,clientbranch.name as cbranchname,clientbranch.username as cbranchuser,departments.name as departmentname,subdepartments.name as subname,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departments ON departments.id=conformity.departmentid INNER JOIN departments as subdepartments ON subdepartments.id=conformity.subdepartmentid where conformity.endofdayemail=0 and clientbranch.id='.$item['clientbranchid'])->queryAll();
		$msg2='';
		$cbranchname='';
		foreach($countmail as $countmailx)
		{
		//	$msg2=$msg2.' [ '.$countmailx['firmname'].' > '.$countmailx['branchname'].' > '.$countmailx['clientname'].' > '.$countmailx['cbranchname'].' > '.$countmailx['departmentname'].' > '.$countmailx['subname'].' ] '.' ,<br>';
	$msg2=$msg2.$countmailx['cbranchname'].' '.$countmailx['numberid'].' '.$countmailx['definition'].' '.date("d-m-Y",$countmailx['date']).' Url:<a href="https://insectram.io/conformity/activity/'.$countmailx['id'].'">'.$countmailx['numberid'].'</a> ,<br>';
$cbranchname=$countmailx['cbranchname'];
		}

		$usermail=Yii::app()->db->createCommand('SELECT * from user INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id where user.active=1 and AuthAssignment.itemname LIKE "'.$item['packages'].'.'.$item['firmuser'].'.'.$item['branchuser'].'.'.$item['clientuser'].'.'.$item['cbranchuser'].'.Admin"')->queryAll();



		foreach($usermail as $usermailx)
		{
			if($item['clientbranchid']==$usermailx['mainclientbranchid'])
			{
						if ( $usermailx->languageid<>8){
					$senderemail='recommendations@insectram.io';//$firm->email;
			}else{
						$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
			}
				//$senderemail='oneri.uygunsuzluk@insectram.io';//$firm->email;
				$sendername=$item['firmname'];
			//	$subject=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
			//	$altbody=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
			//$msg='<b>'.User::model()->dilbul($userx->languageid,'Opened non-conformities').':</b><br>'.$msg2;
				$subject=' '.$cbranchname.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
				$altbody=' '.$cbranchname.' '.count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
				 $msg='<b>'.User::model()->dilbul($usermailx->languageid,'Açılan Uygunsuzluklar').':</b><br>'.$msg2;
			//	$msg=$subject.'<br>'.$msg.'<br>url:<a href="https://insectram.io/conformity">'.User::model()->dilbul($userx->languageid,'Non-Comformity').'</a>';
				$msg=$subject.'<br>'.$msg;
				echo $buyeremail=$usermailx['email'];
				echo '<br>';
				 $buyername=$usermailx['name'].' '.$usermailx['surname'];
				 $ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
				if(!$ismail)
				{
					Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//$buyeremail
				}
			}
		}

	}


 Yii::app()->db->createCommand('UPDATE conformity SET endofdayemail=1')->execute();

exit;


	// clientbranch department user mail
	$select=Yii::app()->db->createCommand('SELECT departmentpermission.userid as useridx,firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,clientbranch.id as clientbranchid,client.username as clientuser,clientbranch.username as cbranchuser,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departmentpermission ON departmentpermission.clientid=clientbranch.id where departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and conformity.endofdayemail=0 GROUP by departmentpermission.userid')->queryAll();
	foreach ($select as $item)
	{
		$countmail=Yii::app()->db->createCommand('SELECT departmentpermission.userid as userid,firm.name as firmname,firm.package as packages,firm.username as firmuser,firmbranch.username as branchuser,clientbranch.id as clientbranchid,client.username as clientuser,firmbranch.name as branchname,clientbranch.username as cbranchuser,client.name as clientname,clientbranch.name as cbranchname,departments.name as departmentname,subdepartments.name as subname,conformity.* from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN conformity ON conformity.clientid=clientbranch.id INNER JOIN departmentpermission ON departmentpermission.clientid=clientbranch.id INNER JOIN departments ON departments.id=conformity.departmentid INNER JOIN departments as subdepartments ON subdepartments.id=conformity.subdepartmentid where departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and conformity.endofdayemail=0 and departmentpermission.userid='.$item['useridx'])->queryAll();
		$msg2='';

		/*
		foreach($countmail as $countmailx)
		{
			$msg2=$msg2.' [ '.$countmailx['firmname'].' > '.$countmailx['branchname'].' > '.$countmailx['clientname'].' > '.$countmailx['cbranchname'].' > '.$countmailx['departmentname'].' > '.$countmailx['subname'].' ] '.' ,<br>';
		}
		*/

		$usermail=Yii::app()->db->createCommand('SELECT * from user where id='.$item['useridx'])->queryAll();

		foreach($usermail as $usermailx)
		{
				$senderemail='info@insectram.io';//$firm->email;
				$sendername=$item['firmname'];
				$subject=count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
			$altbody=count($countmail).' '.User::model()->dilbul($usermailx->languageid,'adet uygunsuzluk açıldı');
				// $msg='<b>Opened nonconformities:</b><br>'.$msg2;
				$msg=$subject.'<br>url:<a href="https://insectram.io/conformity">'.User::model()->dilbul($userx->languageid,'Non-Comformity').'</a>';

				echo $buyeremail=$usermailx['email'];
				 $buyername=$usermailx['name'].' '.$usermailx['surname'];

				 echo '<br>';

				$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and type=0','params'=>array('name'=>'conformityemail','userid'=>$usermailx['id'])));
				if(!$ismail)
				{
					Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);//$buyeremail
				}
		}

	}






Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']);





/*
$department=Yii::app()->db->createCommand(
	'SELECT departmentpermission.* FROM departmentpermission INNER JOIN conformity ON conformity.clientid=departmentpermission.clientid WHERE departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and conformity.endofdayemail=0')->queryAll();



	$select=Yii::app()->db->createCommand(
	'SELECT firm.* from conformity INNER JOIN firm ON firm.id=conformity.firmid GROUP by package')->queryAll();
*/

/*
	// firm mail
	$select=Yii::app()->db->createCommand('SELECT * FROM conformity where endofdayemail=0 group by firmid')->queryAll();
	foreach ($select as $item)
	{


		$countmail=Yii::app()->db->createCommand('SELECT * FROM conformity where endofdayemail=0 and firmid='.$item['firmid'])->queryAll();
		$msg='';
		foreach($countmail as $countmailx)
		{
			$msg=$msg.Client::model()->findbypk($countmailx['clientid'])->name.',';
		}

		$usermail=Yii::app()->db->createCommand('SELECT user.* from user INNER JOIN conformity ON conformity.firmid=user.firmid where user.mainbranchid=0 and user.clientid=0 and user.mainclientbranchid=0 and user.firmid='.$item['firmid'].' group by username')->queryAll();

		foreach($usermail as $usermailx)
		{
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=Firm::model()->findbypk($item['firmid'])->name;
			$subject=count($countmail).' pieces of non-compliance opened';
			$altbody=count($countmail).' pieces of non-compliance opened';
			$msg='Opened nonconformities:'.$msg;

			$buyeremail=$usermailx['email'];
			$buyername=$usermailx['name'].' '.$usermailx['surname'];
			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);//$buyeremail
		}

	}



	// branch mail
	$select=Yii::app()->db->createCommand('SELECT * FROM conformity where endofdayemail=0 group by firmbranchid')->queryAll();
	foreach ($select as $item)
	{


		$countmail=Yii::app()->db->createCommand('SELECT * FROM conformity where endofdayemail=0 and firmbranchid='.$item['firmbranchid'])->queryAll();
		$msg='';
		foreach($countmail as $countmailx)
		{
			$msg=$msg.Client::model()->findbypk($countmailx['clientid'])->name.',';
		}

		$usermail=Yii::app()->db->createCommand('SELECT user.* from user INNER JOIN conformity ON conformity.firmid=user.firmid where conformity.firmbranchid=user.mainbranchid and user.clientid=0 and user.mainclientbranchid=0 and user.branchid='.$item['firmbranchid'].' group by username')->queryAll();

		foreach($usermail as $usermailx)
		{
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=Firm::model()->findbypk($item['firmid'])->name;
			$subject=count($countmail).' pieces of non-compliance opened';
			$altbody=count($countmail).' pieces of non-compliance opened';
			$msg='Opened nonconformities:'.$msg;

			$buyeremail=$usermailx['email'];
			$buyername=$usermailx['name'].' '.$usermailx['surname'];
			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);//$buyeremail
		}

	}




	// client mail
	$select=Yii::app()->db->createCommand('SELECT conformity.*,client.id as parentclientid from conformity INNER JOIN client as clientbranch ON clientbranch.id=conformity.clientid INNER JOIN client ON client.id=clientbranch.parentid GROUP by client.id')->queryAll();
	foreach ($select as $item)
	{


		$countmail=Yii::app()->db->createCommand('SELECT conformity.* from conformity INNER JOIN client as clientbranch ON clientbranch.id=conformity.clientid INNER JOIN client ON client.id=clientbranch.parentid where client.id='.$item['parentclientid'])->queryAll();
		$msg='';
		foreach($countmail as $countmailx)
		{
			$msg=$msg.Client::model()->findbypk($countmailx['clientid'])->name.',';
		}

		$usermail=Yii::app()->db->createCommand('SELECT user.* from user INNER JOIN conformity ON conformity.firmid=user.firmid INNER JOIN client as clientbranch ON clientbranch.id=conformity.clientid INNER JOIN client ON client.id=clientbranch.parentid where user.branchid=conformity.branchid and user.clientid=client.id  and user.clientbranchid=0 and client.id='.$item['parentclientid'].' group by username')->queryAll();

		foreach($usermail as $usermailx)
		{
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=Firm::model()->findbypk($item['firmid'])->name;
			$subject=count($countmail).' pieces of non-compliance opened';
			$altbody=count($countmail).' pieces of non-compliance opened';
			$msg='Opened nonconformities:'.$msg;

			$buyeremail=$usermailx['email'];
			$buyername=$usermailx['name'].' '.$usermailx['surname'];
			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);//$buyeremail
		}

	}





	//clientbrach


		$select=Yii::app()->db->createCommand('SELECT * from conformity group by clientid')->queryAll();
	foreach ($select as $item)
	{


		$countmail=Yii::app()->db->createCommand('SELECT * from conformity where clientid='.$item['clientid'])->queryAll();
		$msg='';
		foreach($countmail as $countmailx)
		{
			$msg=$msg.Client::model()->findbypk($countmailx['clientid'])->name.',';
		}

		$usermail=Yii::app()->db->createCommand('SELECT user.* from user
		INNER JOIN conformity ON conformity.firmid=user.firmid
		INNER JOIN client as clientbranch ON clientbranch.id=conformity.clientid
		INNER JOIN client ON client.id=clientbranch.parentid
		where user.firmid=conformity.firmid and user.branchid=conformity.branchid and user.clientid=client.id  and user.clientbranchid=conformity.clientid and user.clientbranchid='.$item['clientid'].' group by username')->queryAll();

		foreach($usermail as $usermailx)
		{
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=Firm::model()->findbypk($item['firmid'])->name;
			$subject=count($countmail).' pieces of non-compliance opened';
			$altbody=count($countmail).' pieces of non-compliance opened';
			$msg='Opened nonconformities:'.$msg;

			$buyeremail=$usermailx['email'];
			$buyername=$usermailx['name'].' '.$usermailx['surname'];
			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);//$buyeremail
		}

	}



*/

// alpbarutcu@gmail.com
