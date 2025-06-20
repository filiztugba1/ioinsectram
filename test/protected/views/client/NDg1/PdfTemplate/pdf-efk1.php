<?php //echo $type= $_POST['Report']['type'].'<br>';
$sql="";
$pets="";
$products="";
$kriterler="";

$monitortypeandpetsView=MonitortypeandpetsView::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid'],"order"=>"petsid asc"));
foreach ($monitortypeandpetsView as $monitortypeandpetsViewx)
{
  $pets= $pets .'<td align="center" width="50px">'.$monitortypeandpetsViewx->name.'</td>';
}
//	$pets= $pets.'<td align="center">'.'Diğer</td>';
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'] <> 0)
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	  $model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));

    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. ",";
    }
  }
}
if(isset($_POST["Monitoring"]["subid"]))
{
	if(count($_POST['Monitoring']['subid'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['subid'] as $item)
    {
		$model=Departments::model()->findByPk($item);
		if($model)
		{
			$kriterler .= ", (".Departments::model()->findByPk($model->parentid)->name." - ".$model->name.")";
		}
        $sql= $sql."subdepartment=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
/*	else{
		$model=Departments::model()->findByPk($_POST['Monitoring']['subid'][0]);
		if($model)
		{
		//	$kriterler .= " ".$model->name;
		}
		$sql= $sql."subdepartment=".$_POST['Monitoring']['subid'][0]." and ";
	}
  */
}

if($_POST['Monitoring']['date'])
{
    $sql= $sql." checkdate >=".$midnight." and ";
}
if($_POST['Monitoring']['date1'])
{
    $sql= $sql." checkdate <=".$midnight2." and ";
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
$monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'timestamp asc,monitorno asc,petid asc'));

//$monitors=Mobileworkordermonitors::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'timestamp asc, monitorid asc'));
$bfrdate=date("Y-m-d",$monitors[0]->checkdate);
$monitorid=$monitors[0]->monitorid;
$veriler = $veriler. '
      <tr style="background-color:gray;">
			<td align="center" colspan="12">'.$bfrdate.'</td>
			</tr>
        ';
$i=0;
foreach ($monitors as $monitor)
{
  if ($bfrdate != date("Y-m-d",$monitor->checkdate))
  {
    $veriler = $veriler. '
      <tr style="background-color:gray;">
			   <td align="center" colspan="12">'.date("Y-m-d",$monitor->checkdate).'</td>
			</tr>
        ';

        $bfrdate=date("Y-m-d",$monitor->checkdate);
  }
  if ($monitorid != $monitor->monitorid || $i==0)
  {
    $monitorid =$monitor->monitorid;
  	$yazdurum=" - ";
    foreach($monitors as $monitorsk)
    {
      if(($monitorsk->petid==49 && $monitorsk->isproduct==1) && $monitor->monitorid==$monitorsk->monitorid && $bfrdate == date("Y-m-d",$monitorsk->checkdate))
  		{
  			 if($monitorsk->value==1){ $yazdurum="KYK"; }
  			 if($monitorsk->value==2){ $yazdurum="KK"; }
  			 if($monitorsk->value==3){ $yazdurum="N/A"; }
  		}
    }
    $veriler= $veriler .'
    <tr>
			<td align="center">'.$monitor->monitorno.'</td>
			<td align="left">'.$monitor->subdepartmentname.'</td>
			<td align="center" width="50px">'.$yazdurum.'</td>';

  }
  if($monitor->isproduct==0)
  {
    if($monitor->value>0)
    {
      $style='style="color:#fff;background:#000"';
    }else {
        $style='';
    }
      $veriler = $veriler.'<td align="center" '.$style.'>'.$monitor->value.'</td>';
  }
  if ($monitorid != $monitor->monitorid)
  {
    $veriler= $veriler .  '</tr>';
  }
  $i++;
}


$clientparent=Client::model()->findByPk($_POST['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($_POST['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);
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
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><style>
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
		<td width="100" align="center" colspan="2">
			 <img src="'.$resim.'" border="0" width="75px">
		</td>
		<td colspan="10" align="center">
			<b><h2>Uçan Haşere Üniteleri Kontrol ve İçerik Listesi</h2></b>
			<br><h3>(Fly Unit Control &amp; Contents Checklist)</h3>
		</td>
	</tr>
	<tr>
		<td colspan="10">Müşteri Adı (Client Name): <b> '.$client->name.'</b></td>
		<td colspan="2" rowspan="4">
		<b>N/A</b> Ulaşılamadı (Not-approachable) <br>
		<b>ENW</b> Ekipman Çalışmıyor (Equipment Not Working) <br>
		<b>TNW</b> Tek Lamba Yanmıyor ( One Tube Not Working) <br>
		<b>Br</b>  Kırık (Broken)
		</td>
	</tr>
	<tr>
		<td colspan="10">Rapor Kriterleri (Report Criteria): '.t($monitype->name)." ".t($monitype->detailed).' <br> '.$kriterler.'</td>
	</tr>
	<tr>
		<td colspan="10">Tarih (Date): '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="10">Kontrol Eden (Kontroller) - İmza (Signature):</td>
	</tr>

	<tr>
		<td align="center">No</td>
		<td>Cihazın Bulunduğu Yer<br>(Location)</td>
		<td>Cihazın Durumu<br>(Type)</td>
		'.$pets.'
	</tr>
</thead>
	<tbody>
		'.$veriler.'
		</tbody></table></body></html>';


?>
