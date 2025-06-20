<?php

$sqldd="";
$pets="";
$products="";
$yeni="";
$aktivelerdd="";
$tarih1dd=$rmpdfparams['Monitoring']['date'];
$tarih2dd=$rmpdfparams['Monitoring']['date1'];
$midnightdd = strtotime("today", strtotime($tarih1dd));
$midnightdd2 = strtotime("today", strtotime($tarih2dd)+3600*24);

$dep=empty($rmpdfparams['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Report']['dapartmentid']);
$sub=empty($rmpdfparams['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Monitoring']['subid']);
if(!in_array("0",$dep))
{
    $sqldd= $sqldd." departmentid in (".implode(",",$dep).") and ";
}
if(!in_array("0",$sub))
{
	if(count($sub)>1)
	{
	$sqldd=$sqldd. " (";
    foreach ($sub as $item)
    {
        $sqldd= $sqldd."subdepartment=".$item." or ";
    }
    $sqldd=rtrim($sqldd,"or ");
    $sqldd= $sqldd.") and ";
	}
	else{
		  $sqldd= $sqldd."subdepartment=".$sub[0]." and ";
	}
}

if(isset($rmpdfparams["Monitoring"]["monitors"]))
{
	if(count($rmpdfparams['Monitoring']['monitors'])>1)
	{
	$sqldd=$sqldd. " (";
    foreach ($rmpdfparams['Monitoring']['monitors'] as $item)
    {
        $sqldd= $sqldd."monitorid=".$item." or ";
    }
    $sqldd=rtrim($sqldd,"or ");
    $sqldd= $sqldd.") and ";
	}
	else{
		  $sqldd= $sqldd."monitorid=".$rmpdfparams['Monitoring']['monitors'][0]." and ";
	}
}



$verilerdd='';
$ccvmn='';

$isfix=0;
$monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqldd.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightdd.' and '.$midnightdd2.') group by checkdate','order'=>'timestamp asc,monitorno asc'));
if (!$monitors){
  $isfix=1;
  $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqldd.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightdd.' and '.$midnightdd2.') group by checkdate','order'=>'timestamp asc,monitorno asc'));
}



$tarihler=array();
foreach ($monitors as $monitor)
{
	if(!in_array(date("d-m-Y", $monitor->checkdate),$tarihler))
	{

		array_push($tarihler,date("d-m-Y", $monitor->checkdate));
    if (count($tarihler)==8)
    {
      break;
    }
	}
}
for($i=1;$i<9-count($tarihler);$i++)
{
  $ccvmn = $ccvmn.'<td></td>';
}
       if (!$isfix){
$monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqldd.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightdd.' and '.$midnightdd2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>'(isproduct=0 or petid=48 or petid=49 ) and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightdd.' and '.$midnightdd2.') and (isproduct=0 or petid=48 or petid=49 )'));
       }else{
         $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqldd.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightdd.' and '.$midnightdd2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>'(isproduct=0 or petid=48 or petid=49 ) and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightdd.' and '.$midnightdd2.') and (isproduct=0 or petid=48 or petid=49 )'));
       }
         
foreach ($monitors as $monitor)
{
  $monitoringlocation=Monitoringlocation::model()->findByPk($monitoring->mlocationid);
  $bolum='';
  if($monitor->subdepartmentname=='' || $monitor->subdepartmentname==null)
  {
    $bolum=$monitor->departmentname;
  }
  else {
    $bolum=$monitor->subdepartmentname;
  }

  if($monitor->firmid==412)
  {
      $bolum=$bolum.' - '.$monitor->definationlocation;
  }

$monitype=Monitoringtype::model()->findByPk($rmpdfparams['Monitoring']['mtypeid']);
  $verilerdd= $verilerdd .'<tr>
    <td align="center">'.$monitor->monitorno.'</td>
    <td align="center">'.t($monitor->detailed).' ('.t($monitor->name).')'.'</td>
    <td align="center">'.t($monitype->name).'</td>
    <td align="left" colspan="2">'.$bolum.'</td>';
    foreach($tarihler as $tarih)
    {
      $bilgilerdd='';
      $tarihbasla=strtotime($tarih);
      $tarihbiti=($tarihbasla+(3600*24)) - 1;
      $durum=2;
      $petno=0;
    foreach($monitorsdate as $monitorsdatex)
    {

      if($monitorsdatex->openedtimeend>=$tarihbasla && $monitorsdatex->openedtimeend<=$tarihbiti && $monitorsdatex->monitorid==$monitor->monitorid)
      {
          if($monitorsdatex->value<>0)
          {
            $durum=1;
            $petno=$monitorsdatex->petid;
            $verim=$monitorsdatex->value;
            break;
          }else
          {
            $durum=0;
          }
        }

      }
      if($durum==0)
			{
				$bilgilerdd = $bilgilerdd.'<td align="center">O'.'</td>';
			}
			else if($durum==1)
			{
				$canli='O';
				$heyvan=Pets::model()->findBypk($petno);
        $canli='N';
				if($petno==83){ $canli="Y";}
				if($petno==38){ $canli="R";}
				if($petno==25){ $canli="D";}
				if($petno==48){ $canli="B";}
				if($petno==49){
					if ($verim==1){
					$canli="KYK";
					}

					if ($verim==2){
					$canli="KK";
					}

					if ($verim==3){
					$canli="N/A";
					}


					}
				if($petno==27 || $petno==26 || $petno==31){ $canli="I";}
				$bilgilerdd = $bilgilerdd.'<td align="center"><b>'.$canli.'</b></td>';
				//break;
			}	else if($durum==2)
			{
				$bilgilerdd = $bilgilerdd.'<td align="center">-</td>';
			}


        $verilerdd= $verilerdd.$bilgilerdd;
    }


        $verilerdd= $verilerdd.$ccvmn;
    }
    $verilerdd= 	$verilerdd.'</tr>' ;
  foreach($tarihler as $item)
  {
  	 $aktivelerdd=$aktivelerdd.'<td>'.$item.'</td>';
  }
  for($i=1;$i<9-count($tarihler);$i++)
  {
  	$aktivelerdd = $aktivelerdd.'<td></td>';
  }


$clientparent=Client::model()->findByPk($rmpdfparams['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($rmpdfparams['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($rmpdfparams['Monitoring']['mtypeid']);
if($firm->image)
{
    $resim=$firm->image;
}
else if($clientparent->image)
{
	$resim=$clientparent->image;
}
else{
	$resim="/images/nophoto.png";
}
if (strlen($verilerdd)<30){

	$htmlwp='';
}else{
	
$htmlwp='
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
<style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
font-size:8pt;
}
td {
font-family:Arial;
font-size:6pt;
}
</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td width="100" align="center" rowspan="7" colspan="4">
            <img src="'.$resim.'" border="0" width="75px">
        </td>
        <td rowspan="7" colspan="9" align="center">
               <b><h2>'.t('Wasp Pots Form').'</h2></b>
        </td>
    </tr>
    <tr >
        <td></td>
        <td ></td>
    </tr>
    <tr>
        <td></td>
        <td ></td>
    </tr>
    <tr>
        <td ></td>
    </tr>

    <tr>
        <td></td>
        <td ></td>
    </tr>

    <tr>
        <td></td>
        <td colspan="0"></td>
    </tr>
    <tr>
        <td colspan="0"></td>
    </tr>
    <tr>
        <td rowspan="5" colspan="9" class="f12">'.t('Müşteri Adı (Client Name)').':<b> '.$client->name.'</b></td>
        <td></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2"></td>
    </tr>
    <tr>
    <td colspan="2"></td>
   <td colspan="2"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3"></td>
    </tr>

	<tr>
        <td>-</td>
        <td colspan="3">'.t('Kontrol Edilmedi').'</td>
    </tr>

    <tr>
        <td rowspan="3" colspan="9"> '.t('İmza').': <img src="'.$reportinfo->technician_sign.'" style="//filter: brightness(30) grayscale(100%) invert(100%); margin-top:-10px; margin-right:-20px;" width="100px"> </td>
        <td>N/A</td>
        <td colspan="3">'.t('Ulaşılamadı (Not-Approachable)').'</td>
    </tr>
    <tr>
        <td>KK</td>
        <td colspan="3">'.t('Kutu Kırık (Broken Box)').'</td>
    </tr>
    <tr>
        <td>KYK</td>
        <td colspan="3">'.t('Kutu Kayıp (Lost Box)').'</td>
    </tr>
    <tr>
        <td rowspan="3" width="20" align="center">No</td>
        <td rowspan="3" width="20" align="center">'.t('Yeri<br>(Location)').'</td>
        <td rowspan="3" width="30" align="center">'.t('Tipi<br>(Type)').'</td>
        <td rowspan="3" colspan="2">'.t('Bölüm Adı<br>(Area Name)').'</td>
        <td colspan="8" align="center">'.t('Aktivite Durumu (Condition Of Activity)').'</td>
    </tr>
    <tr>

        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
    </tr>
    <tr>
        '.$aktivelerdd.'


    </tr>
    </thead>
    <tbody>

    '.$verilerdd.'


    </tbody>
</table>
</body>
</html>

 ';
}
?>
