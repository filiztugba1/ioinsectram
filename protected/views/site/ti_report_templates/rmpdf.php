<?php

$sqlmmm="";
$petsm="";
$productsm="";
$yenim="";
$aktivelermm="";
$tarih1mm=$rmpdfparams['Monitoring']['date'];
$tarih2mm=$rmpdfparams['Monitoring']['date1'];
$midnightmm = strtotime("today", strtotime($tarih1mm));
$midnightmm2 = strtotime("today", strtotime($tarih2mm)+3600*24);
$mtypesxt='';    
$depmm=empty($rmpdfparams['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Report']['dapartmentid']);
$submm=empty($rmpdfparams['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Monitoring']['subid']);
if(!in_array("0",$depmm))
{
    $sqlmmm= $sqlmmm." departmentid in (".implode(",",$depmm).") and ";
}
if(!in_array("0",$submm))
{
	if(count($submm)>1)
	{
	$sqlmmm=$sqlmmm. " (";
    foreach ($submm as $item)
    {
        $sqlmmm= $sqlmmm."subdepartment=".$item." or ";
    }
    $sqlmmm=rtrim($sqlmmm,"or ");
    $sqlmmm= $sqlmmm.") and ";
	}
	else{
		  $sqlmmm= $sqlmmm."subdepartment=".$submm[0]." and ";
	}
}

if(isset($rmpdfparams["Monitoring"]["monitors"]))
{
	if(count($rmpdfparams['Monitoring']['monitors'])>1)
	{
	$sqlmmm=$sqlmmm. " (";
    foreach ($rmpdfparams['Monitoring']['monitors'] as $item)
    {
        $sqlmmm= $sqlmmm."monitorid=".$item." or ";
    }
    $sqlmmm=rtrim($sqlmmm,"or ");
    $sqlmmm= $sqlmmm.") and ";
	}
	else{
		  $sqlmmm= $sqlmmm."monitorid=".$rmpdfparams['Monitoring']['monitors'][0]." and ";
	}
}



$verilermm='';
$ccvmnmm='';

$monitortypemm='('.$rmpdfparams['Monitoring']['mtypeid'].')';
if(intval($rmpdfparams['Monitoring']['mtypeid'])==-100)
{
	$monitortypemm='(21,22,23,24,25,26,30,33,32,31)';
}
$isfix=0;
$monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlmmm.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype in '.$monitortypemm.' and (checkdate between '.$midnightmm.' and '.$midnightmm2.') group by checkdate','order'=>'timestamp asc,monitorno asc'));
if (!$monitors)
{
  $isfix=1;
  $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlmmm.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype in '.$monitortypemm.' and (checkdate between '.$midnightmm.' and '.$midnightmm2.') group by checkdate','order'=>'timestamp asc,monitorno asc'));

}

$tarihler=array();
foreach ($monitors as $monitor)
{
	if(!in_array(date("d-m-Y", $monitor->checkdate),$tarihler))
	{

	//	array_push($tarihler,date("d-m-Y", $monitor->checkdate));
		$tarihler[date("d-m-Y", $monitor->checkdate)]= $monitor->workorderid;
    if (count($tarihler)==8)
    {
      break;
    }
	}
}
for($i=1;$i<9-count($tarihler);$i++)
{
  $ccvmnmm = $ccvmnmm.'<td></td>';
}
if ($isfix==1){
  $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlmmm.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype in '.$monitortypemm.' and (checkdate between '.$midnightmm.' and '.$midnightmm2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>'(isproduct=0 or petid=48 or petid=49 ) and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype in '.$monitortypemm.' and (checkdate between '.$midnightmm.' and '.$midnightmm2.') and (isproduct=0 or petid=48 or petid=49 )'));
}else{
  $monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlmmm.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype in '.$monitortypemm.' and (checkdate between '.$midnightmm.' and '.$midnightmm2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>'(isproduct=0 or petid=48 or petid=49 ) and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype in '.$monitortypemm.' and (checkdate between '.$midnightmm.' and '.$midnightmm2.') and (isproduct=0 or petid=48 or petid=49 )'));
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
      $bolum=$bolum.' N/S '.$monitor->definationlocation;
  }

$monitype=Monitoringtype::model()->findByPk($monitor->monitortype);
  $verilermm= $verilermm .'<tr>
    <td align="center">'.$monitor->monitorno.'</td>
    <td align="center">'.t($monitor->detailed).' ('.t($monitor->name).')'.'</td>
    <td align="center">'.t($monitype->name).'</td>
    <td align="left" colspan="2">'.$bolum.'</td>';

    foreach($tarihler as $tarih=>$wkn)
    {
	
      $bilgiler='';
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
				$bilgiler = $bilgiler.'<td align="center">O'.'</td>';
			}
			else if($durum==1)
			{
				$canli='Ot';
				$heyvan=Pets::model()->findBypk($petno);
				if($petno==37){ $canli='<span style="color:red;">M</span>';}
				if($petno==38){ $canli='<span style="color:red;">R</span>';}
				if($petno==25){ $canli=t("Ot");}
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
				$bilgiler = $bilgiler.'<td align="center" ><b>'.$canli.'</b></td>';
				//break;
			}	else if($durum==2)
			{
				$bilgiler = $bilgiler.'<td align="center">N/S</td>';
			}


        $verilermm= $verilermm.$bilgiler;
			
    }


        $verilermm= $verilermm.$ccvmnmm;
    }
    $verilermm= 	$verilermm.'</tr>' ;
  foreach($tarihler as $item=>$wkn)
  {
  	 $aktivelermm=$aktivelermm.'<td>'.$item.'</td>';
  }
  for($i=1;$i<9-count($tarihler);$i++)
  {
  	$aktivelermm = $aktivelermm.'<td></td>';
		
 // $mtypesxt.='<td width="50">'.t('Tarih - Date').$wkn.'</td>';
  }

$clientparent=Client::model()->findByPk($rmpdfparams['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($rmpdfparams['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($rmpdfparams['Monitoring']['mtypeid']);
if($firm->image<>'')
{
    $resim=$firm->image;
}
else if($clientparent->image<>'')
{
	$resim=$clientparent->image;
}
else{
	$resim="https://insectram.io/images/nophoto.png";
}

if (strlen($verilermm)<30){

	$htmlrmpdf='';
}else{
	
$htmlrmpdf='
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
<style>
.f12
{
	//font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
//font-family:Arial;
//ont-size:8pt;
}
td {
//font-family:Arial;
//font-size:6pt;
}
</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td width="100" align="center" rowspan="7" colspan="4">
            <img src="/'.$resim.'" border="0" width="75px">
        </td>
        <td rowspan="7" colspan="5" align="center">
               <b><h2>'.t('Kemirgenler İçin Monitör Yerleşim Listesi').'</h2></b>
        </td>
        <td colspan="4" width="200">'.t('Location Of Monitor - Monitör Yeri').'</td>
    </tr>
    <tr>
        <td>O</td>
        <td colspan="3">'.t('Dış Alan Gözlem Noktası (Outdoor)').'</td>
    </tr>
    <tr>
        <td>I</td>
        <td colspan="3">'.t('İç Alan Gözlem Noktası (Indoor)').'</td>
    </tr>
    <tr>
        <td colspan="4">'.t("Type of Monitor").'</td>
    </tr>

    <tr>
        <td>RM</td>
        <td colspan="3">'.t('Kemirgen Monitorü (Rodent Monitor)').'</td>
    </tr>

    <tr>
        <td>LT</td>
        <td colspan="3">'.t('Canlı Yakalama (Live Trap)').'</td>
    </tr>
    <tr>
        <td colspan="4">'.t('Monitör Durumu - Condition of Monitor').'</td>
    </tr>
    <tr>
        <td rowspan="5" colspan="9" class="f12">'.t('Müşteri Adı (Client Name)').':<b> '.$client->name.'</b></td>
        <td>O</td>
        <td colspan="3">'.t('Tüketim Yok (No Consumption)').'</td>
    </tr>
    <tr>
        <td colspan="2">'.t('R: Sıçan (rattus)').'</td>
        <td colspan="2">'.t('M: Fare (Mouse)').'</td>
    </tr>
    <tr>
    <td colspan="2">'.t('D: Diğer (Other)').'</td>
   <td colspan="2"></td>
    </tr>
    <tr>
        <td>B</td>
        <td colspan="3">'.t('Bozulmuş Yem').'</td>
    </tr>

	<tr>
        <td>N/S</td>
        <td colspan="3">'.t('Kontrol Edilmedi').'</td>
    </tr>

    <tr>
        <td rowspan="3" colspan="9"> '.t('İmza').': 		<img src="'.$reportinfo->technician_sign.'" style="//filter: brightness(30) grayscale(100%) invert(100%); margin-top:-10px; margin-right:-20px;" width="100px">
				</td>
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
        <td width="400">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
    </tr>
    <tr>
        '.$aktivelermm.'

    </tr>
    </thead>
    <tbody>

    '.$verilermm.'


    </tbody>
</table>
</body>
</html>

 ';
	
}
