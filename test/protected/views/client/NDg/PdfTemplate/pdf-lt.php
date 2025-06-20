<?php

$sql="";
$pets="";
$products="";
$yeni="";
$aktiveler="";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
if($_POST['Report']['dapartmentid'] <> 0)
{
    $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
}
if(isset($_POST["Monitoring"]["subid"]))
{
	if(count($_POST['Monitoring']['subid'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['subid'] as $item)
    {
        $sql= $sql."subdepartment=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
	else{
		  $sql= $sql."subdepartment=".$_POST['Monitoring']['subid'][0]." and ";
	}
}

if(isset($_POST["Monitoring"]["monitors"]))
{
	if(count($_POST['Monitoring']['monitors'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['monitors'] as $item)
    {
        $sql= $sql."monitorid=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
	else{
		  $sql= $sql."monitorid=".$_POST['Monitoring']['monitors'][0]." and ";
	}
}



$veriler='';
$ccvmn='';

$monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and (checkdate between '.$midnight.' and '.$midnight2.') group by timestamp'));

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
$monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and (checkdate between '.$midnight.' and '.$midnight2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and (checkdate between '.$midnight.' and '.$midnight2.') and (isproduct=0 or petid=48 or petid=49 )','order'=>'timestamp asc,monitorno asc'));
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
  
  $veriler= $veriler .'<tr>
    <td align="center">'.$monitor->monitorno.'</td>
    <td align="center">'.t($monitor->detailed).' ('.t($monitor->name).')'.'</td>
    <td align="center">LT</td>
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

        $veriler= $veriler.$bilgiler;
    }


        $veriler= $veriler.$ccvmn;
    }
    $veriler= 	$veriler.'</tr>' ;
  foreach($tarihler as $item)
  {
  	 $aktiveler=$aktiveler.'<td>'.$item.'</td>';
  }
  for($i=1;$i<9-count($tarihler);$i++)
  {
  	$aktiveler = $aktiveler.'<td></td>';
  }

$clientparent=Client::model()->findByPk($_POST['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($_POST['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);

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

$html='
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
        '.$aktiveler.'


    </tr>
    </thead>
    <tbody>

    '.$veriler.'


    </tbody>
</table>
</body>
</html>
 ';

?>

<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
