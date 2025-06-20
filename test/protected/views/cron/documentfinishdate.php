<?php
$document=Documents::model()->findAll(array("condition"=>"finishdate>".time()));
foreach($document as $documentx)
{
  echo date("Y-m-d",strtotime('-1 month',$documentx->finishdate));
  if(date("Y-m-d",strtotime('-1 month',$documentx->finishdate))==date("Y-m-d"))
  {
    $where='';
    if($documentx->firmid>0)
    {
      $where="firmid=".$documentx->firmid." and type=13";
    }
    if($documentx->branchid>0)
    {
      $where="(firmid=".$documentx->firmid." and branchid=0 and type=13) or (firmid=".$documentx->firmid." and (branchid=".$documentx->branchid." or mainbranchid=".$documentx->branchid.") and type=23)";
    }

    $usermail=User::model()->findAll(array("condition"=>$where));
    $firm=Firm::model()->find(array("condition"=>"id=".$documentx->firmid));
    foreach($usermail as $usermailx)
		{
			$senderemail='info@insectram.io';//$firm->email;
			$sendername=$firm->name;
			// $subject=count($countmail).' '.User::model()->dilbul($userx->languageid,'pieces of non-conformity opened');
      $subject=$documentx->name." adlı dosyanızın son geçerlilik süresine 1 ay kaldı";
			$altbody=$documentx->name." adlı dosyanızın son geçerlilik süresine 1 ay kaldı";
			$msg=$subject;

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
}


?>
