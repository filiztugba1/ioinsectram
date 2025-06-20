<?php

$sql="";
$pets="";
$products="";
$yeni="";

$monitorpettypes=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid']));
$colspan=count($monitorpettypes);
foreach ($monitorpettypes as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'(isproduct=0 and id='.$monitorpettype->petsid.")"));
    if($pet)
    {
		$ing=t($pet->name);
        $pets= $pets .'<td width="50px" align="center">'.t($pet->name).'</td>'; // KAPALI
        // $pets= $pets .'<td>'.$pet->name." ".$pet->id.'</td>'; Test Amaçlı Gelen veriler doğru yere geliyor mu diye AÇIK
    }

}
/*	foreach ($monitorpettypes as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'isproduct=1 and id='.$monitorpettype->petsid));
    if($pet)
    {
        $pets= $pets .'<td>'.$pet->name.'</td>'; // KAPALI
        // $pets= $pets .'<td>'.$pet->name." ".$pet->id.'</td>'; Test Amaçlı Gelen veriler doğru yere geliyor mu diye AÇIK
    }

}*/
//$pets= $pets .'<td>Durum</td>';

$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$kriterler="";
if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'] <> 0)
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));

    foreach($model as $modelx)
    {
      $kriterler .= t($modelx->name). ",";
    }
    /*if($kriterler!="")
    {
      $kriterler .=$kriterler. " - ";
    }
    */
  }
}
/*if($_POST['Monitoring']['subid'])
{
    $sql= $sql." subdepartment=".$_POST['Monitoring']['subid']." and ";
}*/
///////////////////////////////////////////////////////
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
			$kriterler .= ", (".t(Departments::model()->findByPk($model->parentid)->name)." - ".t($model->name).")";
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


///////////////////////////////////////////////////////
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
/*$varmimonitor=Mobileworkordermonitors::model()->findAll(array('condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].'','order'=>'monitorid asc'));
foreach($varmimonitor as $var)
{
	$varmidata = Mobileworkorderdata::model()->findAll(array('condition' => 'isproduct=0 and mobileworkordermonitorsid=' . $var->id, 'order' => 'petid desc'));
	foreach($varmidata as $varmi)
	{
		if($varmi->)
	}
}*/


$monitors=Mobileworkordermonitors::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].'','order'=>'timestamp asc, monitorno asc'));


/*
$veriler = $veriler. '
            <tr style="background-color:gray;">
			<td align="center" colspan="15">'.$bfrdate.'</td>
			</tr>
        ';*/
$bfrdate=213123123;
// echo count($monitors).'--'.microtime();
foreach ($monitors as $monitor) {


        if ($bfrdate != date("d-m-Y", $monitor->checkdate)) {
            $veriler = $veriler . '
                <tr style="background-color:gray;">
                <td align="center" colspan="12">' . date("d-m-Y", $monitor->checkdate) . '</td>
                </tr>
            ';
        }
        $bfrdate = date("d-m-Y", $monitor->checkdate);
        $subdepartment = Departments::model()->findByPk($monitor->subdepartment);
		$MonitorTipi=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);
		 $reportx = Mobileworkorderdata::model()->find(array('condition' => 'isproduct=1 and petid=49 and mobileworkordermonitorsid=' . $monitor->id));
		 $yazdurum=" - ";
		 if($reportx)
		{
			 if($reportx->value==1){ $yazdurum=t("KYK"); }
			 if($reportx->value==2){ $yazdurum=t("Br"); }
			 if($reportx->value==3){ $yazdurum=t("N/A"); }
		}
    $reporty= Mobileworkorderdata::model()->find(array('condition' => 'isproduct=1 and petid=36 and mobileworkordermonitorsid=' . $monitor->id));
    if($reporty)
   {
      if($reporty->value==1){ $yazdurum=t("ENW"); }
   }
   $reportz= Mobileworkorderdata::model()->find(array('condition' => 'isproduct=1 and petid=35 and mobileworkordermonitorsid=' . $monitor->id));
   if($reportz)
  {
     if($reportz->value==1){ $yazdurum=t("TNW"); }
  }
        $veriler = $veriler . '
        <tr>
                <td align="center">' . $monitor->monitorno . '</td>
                <td align="left">' . t($subdepartment->name) . '</td>
                <td align="center" width="50px">'.$yazdurum.'</td>
        ';
        $reports = Mobileworkorderdata::model()->findAll(array('select'=>'value','condition' => 'isproduct=0  and mobileworkordermonitorsid=' . $monitor->id, 'order' => 'FIELD(petid,26,27,28,29,30,31,32,33,25)'));
        foreach ($reports as $report) {
            $veriler = $veriler . '<td align="center">' .$report->value . '</td>'; // Kapalı
            // $veriler = $veriler.'<td align="center">'.$report->value." ".$report->petid.'</td>';  Test amaçlı veriler doğru yere geliyor mu AÇIK
        }

        //$veriler = $veriler . $yeni.$yaz . '</tr>';
        $veriler = $veriler . $yeni  . '</tr>';
        //$yeni = "";

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
			<b><h2>'.t('Uçan Haşere Üniteleri Kontrol ve İçerik Listesi').'</h2></b>
			<br><h3>'.t('(Fly Unit Control &amp; Contents Checklist)').'</h3>
		</td>
	</tr>
	<tr>
		<td colspan="10">'.t('Müşteri Adı (Client Name)').': <b> '.$client->name.'</b></td>
		<td colspan="2" rowspan="4">
		<b>'.t('N/A').'</b> '.t('Ulaşılamadı (Not-approachable)').' <br>
		<b>'.t('ENW').'</b> '.t('Ekipman Çalışmıyor (Equipment Not Working)').' <br>
		<b>'.t('TNW').'</b> '.t('Tek Lamba Yanmıyor ( One Tube Not Working)').' <br>
		<b>'.t('Br').'</b>  '.t('Kırık (Broken)').'
		</td>
	</tr>
	<tr>
		<td colspan="10">'.t('Rapor Kriterleri (Report Criteria)').': '.t($monitype->name)." ".t($monitype->detailed).' <br> '.$kriterler.'</td>
	</tr>
	<tr>
		<td colspan="10">'.t('Tarih (Date)').': '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="10">'.t('Kontrol Eden (Kontroller) - İmza (Signature)').':</td>
	</tr>

	<tr>
		<td align="center">'.t('No').'</td>
		<td>'.t('Cihazın Bulunduğu Yer<br>(Location)').'</td>
		<td>'.t('Cihazın Durumu<br>(Type)').'</td>
		'.$pets.'
	</tr>
</thead>
	<tbody>
		'.$veriler.'
		</tbody></table></body></html>';


?>

<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
