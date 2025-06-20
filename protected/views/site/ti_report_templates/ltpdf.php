<?php

$sqlvv="";
$pets="";
$products="";
$yeni="";
$aktivelervv="";
$tarih1vv=$rmpdfparams['Monitoring']['date'];
$tarih2vv=$rmpdfparams['Monitoring']['date1'];
$midnightvv = strtotime("today", strtotime($tarih1vv));
$midnightvv2 = strtotime("today", strtotime($tarih2vv)+3600*24);
$depvv=empty($rmpdfparams['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Report']['dapartmentid']);
$subvv=empty($rmpdfparams['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Monitoring']['subid']);

if(!in_array("0",$depvv))
{
    $sqlvv= $sqlvv." departmentid in (".implode(",",$depvv).") and ";
}
if(!in_array("0",$subvv))
{
	if(count($subvv)>1)
	{
	$sqlvv=$sqlvv. " (";
    foreach ($subvv as $item)
    {
        $sqlvv= $sqlvv."subdepartment=".$item." or ";
    }
    $sqlvv=rtrim($sqlvv,"or ");
    $sqlvv= $sqlvv.") and ";
	}
	else{
		  $sqlvv= $sqlvv."subdepartment=".$subvv[0]." and ";
	}
}

if(isset($rmpdfparams["Monitoring"]["monitors"]))
{
	if(count($rmpdfparams['Monitoring']['monitors'])>1)
	{
	$sqlvv=$sqlvv. " (";
    foreach ($rmpdfparams['Monitoring']['monitors'] as $item)
    {
        $sqlvv= $sqlvv."monitorid=".$item." or ";
    }
    $sqlvv=rtrim($sqlvv,"or ");
    $sqlvv= $sqlvv.") and ";
	}
	else{
		  $sqlvv= $sqlvv."monitorid=".$rmpdfparams['Monitoring']['monitors'][0]." and ";
	}
}



$verilervv='';
$ccvmn='';

$isfix=0;
$monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlvv.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightvv.' and '.$midnightvv2.') group by timestamp'));
if (!$monitors){
  $isfix=1;
  
  $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlvv.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightvv.' and '.$midnightvv2.') group by timestamp'));
  
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
        $monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlvv.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightvv.' and '.$midnightvv2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlvv.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightvv.' and '.$midnightvv2.') and (isproduct=0 or petid=48 or petid=49 )','order'=>'timestamp asc,monitorno asc'));
      }
else{
  $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlvv.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightvv.' and '.$midnightvv2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlvv.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].' and (checkdate between '.$midnightvv.' and '.$midnightvv2.') and (isproduct=0 or petid=48 or petid=49 )','order'=>'timestamp asc,monitorno asc'));
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
  $verilervv= $verilervv .'<tr>
    <td align="center">'.$monitor->monitorno.'</td>
    <td align="center">'.t($monitor->detailed).' ('.t($monitor->name).')'.'</td>
    <td align="center">'.t($monitype->name).'</td>
    <td align="left" colspan="2">'.$bolum.'</td>';
    foreach($tarihler as $tarih)
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
        //    echo date('Y-m-d',$tarihbasla).' - '.$monitor->monitorno.' - '.$monitorsdatex->petid.' - '.$monitorsdatex->value.'<br>';

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
      {   $canli='O';
        $heyvan=Pets::model()->findBypk($petno);
        if($petno==37){ $canli="M";}
        if($petno==38){ $canli="R";}
        if($petno==25){ $canli="D";}
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
        $bilgiler = $bilgiler.'<td align="center"><b>'.t($canli).'</b></td>';
        //break;
      }	else if($durum==2)
      {
        $bilgiler = $bilgiler.'<td align="center">-</td>';
      }

        $verilervv= $verilervv.$bilgiler;
    }


        $verilervv= $verilervv.$ccvmn;
    }
    $verilervv= 	$verilervv.'</tr>' ;
  foreach($tarihler as $item)
  {
  	 $aktivelervv=$aktivelervv.'<td>'.$item.'</td>';
  }
  for($i=1;$i<9-count($tarihler);$i++)
  {
  	$aktivelervv = $aktivelervv.'<td></td>';
  }

$clientparent=Client::model()->findByPk($rmpdfparams['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($rmpdfparams['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($rmpdfparams['Monitoring']['mtypeid']);

/*$mttd=' <tr>
        <td>MT</td>
        <td colspan="3">'.t('Güve Tuzağı (Moth Trap)').'</td>
    </tr>';
    */
    $mttd=' <tr>
            <td>LT</td>
            <td colspan="3">'.t('Canlı Yakalama (Live Trap)').'</td>
        </tr>';
if($firm->id==200)
{
    $mttd=' <tr>
        <td>LT</td>
        <td colspan="3">'.t('Canlı Tuzağı (Live Trap)').'</td>
    </tr>';
}
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
if (strlen($verilervv)<30){

	$htmlltglue='';
}else{
	
	
$htmlltglue='
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
            <img src="/'.$resim.'" border="0" width="75px">
        </td>
        <td rowspan="7" colspan="5" align="center">
            <b><h2>'.t('Kemirgenler İçin Monitör Yerleşim Listesi').'</h2></b>
            <br><h3>'.t('(Location List For Rodent and Insect Monitoring Points)').'</h3>
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
        <td colspan="4">'.t('Type of Monitor').'</td>
    </tr>

    <tr>
        <td>RM</td>
        <td colspan="3">'.t('Kemirgen Monitorü (Rodent Monitor)').'</td>
    </tr>

   '.$mttd.'
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
        <td>-</td>
        <td colspan="3">'.t('Kontrol Edilmedi').'</td>
    </tr>

    <tr>
        <td rowspan="3" colspan="9"> '.t('İmza').' :</td>
        <td>'.t('N/A').'</td>
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
        <td rowspan="3" width="20" align="center">'.t('Monitor No').'</td>
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
        '.$aktivelervv.'


    </tr>
    </thead>
    <tbody>

    '.$verilervv.'


    </tbody>
</table>
</body>
</html>
 ';
}
?>

<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
