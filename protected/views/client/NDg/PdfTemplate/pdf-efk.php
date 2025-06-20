<?php
ini_set('pcre.backtrack_limit', 10000000); // 10 milyon olarak ayarlanır

$sql="";
$pets="";
$products="";
$yeni="";

$monitorpettypes=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid']));
$colspan=count($monitorpettypes);
$col=4;
$petids=[];
$pestsx=[];
foreach ($monitorpettypes as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'(isproduct=0 and id='.$monitorpettype->petsid.")"));
    if($pet)
    {
		$ing=t($pet->name);
        $pets= $pets .'<td colspan="1" width="50px" align="center">'.t($pet->name).'</td>'; // KAPALI
      $pestsx[$pet->id]=0;
		$col++;
		$petids[$monitorpettype->petsid]=0;
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

$dep=empty($_POST['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($_POST['Report']['dapartmentid']);
$sub=empty($_POST['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($_POST['Monitoring']['subid']);

if(!isset($_POST["Monitoring"]["subid"]) || count($sub)==0 || !in_array("0",$dep)){  //sub departman yoksa girsin
  if(!in_array("0",$dep))
  {
      $sql= $sql." departmentid in (".implode(",",$dep).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$dep).")"));

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
if(isset($sub) and !in_array("0",$sub))
{
	if(count($sub)>1)
	{
	$sql=$sql. " (";
    foreach ($sub as $item)
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


$monitors=MobileworkordermonitorsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].'','order'=>'timestamp asc, monitorno asc'));


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
		 $reportx = MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=49 and mobileworkordermonitorsid=' . $monitor->id));
		 $yazdurum=" - ";
		 if($reportx)
		{
			 if($reportx->value==1){ $yazdurum=t("KYK"); }
			 if($reportx->value==2){ $yazdurum=t("Br"); }
			 if($reportx->value==3){ $yazdurum=t("N/A"); }
		}
    $reporty= MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=36 and mobileworkordermonitorsid=' . $monitor->id));
    if($reporty)
   {
      if($reporty->value==1){ $yazdurum=t("ENW"); }
   }
   $reportz= MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=35 and mobileworkordermonitorsid=' . $monitor->id));
   if($reportz)
  {
     if($reportz->value==1){ $yazdurum=t("TNW"); }
  }

  $bolum=$monitor->departmentname.' - '. $subdepartment->name;
  if($monitor->firmid==412)
  {
      $bolum=$bolum.' - '.$monitor->definationlocation;
  }
  
  $mnmno=Monitoring::model()->findByPk($monitor->monitorid);
     $idms=$monitor->monitorno;
  if (trim($mnmno->alternativenumber)<>''){
    $idms=$mnmno->alternativenumber;
    
  }
  

        $veriler = $veriler . '
        <tr>
                <td colspan="1" align="center">' . $idms . '</td>
                <td colspan="2" align="left">' . $bolum . '</td>
                <td colspan="1" align="center" width="50px">'.$yazdurum.'</td>
		
        ';
        $reports = MobileworkorderdataView::model()->findAll(array('select'=>'value,createdtime,petid','condition' => 'isproduct=0  and mobileworkordermonitorsid=' . $monitor->id,'order'=>'id asc'));
//print_r($pestsx);Exit;
		foreach ($reports as $report) {
			
			$petids[$report->petid]=1;
      if (isset($pestsx[$report->petid]) ){
              $pestsx[$report->petid]=($report->createdtime>0?$report->value:'-');
      }

        //    $veriler = $veriler . '<td align="center" colspan="1">' .($report->createdtime>0?$report->value:'-') . '</td>'; // Kapalı
            // $veriler = $veriler.'<td align="center">'.$report->value." ".$report->petid.'</td>';  Test amaçlı veriler doğru yere geliyor mu AÇIK
        }		
  foreach ($pestsx as $as=>$ps) {
			

        $veriler = $veriler . '<td align="center" colspan="1">' .$ps . '</td>'; // Kapalı
            
        //    $veriler = $veriler . '<td align="center" colspan="1">' .($report->createdtime>0?$report->value:'-') . '</td>'; // Kapalı
            // $veriler = $veriler.'<td align="center">'.$report->value." ".$report->petid.'</td>';  Test amaçlı veriler doğru yere geliyor mu AÇIK
        }
		foreach($petids as $petd)
		{
			if($petd==0)
			{
				//$veriler = $veriler . '<td align="center" colspan="1">0</td>'; // Kapalı
			}
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
		<td width="100" align="center" colspan="'.($firm->id!==412?3:2).'">
			 <img src="'.$resim.'" border="0" width="75px">
		</td>
		<td colspan="'.($col>12?$col-2:10).'" align="center">
			<b><h2>'.t('Uçan Haşere Üniteleri Kontrol ve İçerik Listesi').'</h2></b>
			<br><h3>'.t('(Fly Unit Control &amp; Contents Checklist)').'</h3>
		</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Müşteri Adı (Client Name)').': <b> '.$client->name.'</b></td>
		<td colspan="'.($firm->id!==412?3:2).'" rowspan="4">
		<b>'.t('N/A').'</b> '.t('Ulaşılamadı (Not-Approachable)').' <br>
		<b>'.t('ENW').'</b> '.t('Ekipman Çalışmıyor (Equipment Not Working)').' <br>
		<b>'.t('TNW').'</b> '.t('Tek Lamba Yanmıyor ( One Tube Not Working)').' <br>
		<b>'.t('Br').'</b>  '.t('Kırık (Broken)').'
		</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Rapor Kriterleri (Report Criteria)').': '.t($monitype->name)." ".t($monitype->detailed).' <br> '.$kriterler.'</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Tarih (Date)').': '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Kontrol Eden (Kontroller) - İmza (Signature)').':</td>
	</tr>

	<tr>
		<td align="center" colspan="1">'.t('Monitor No').'</td>
		<td colspan="2">'.t('Cihazın Bulunduğu Yer<br>(Location)').'</td>
		<td colspan="1">'.t('Cihazın Durumu<br>(Type)').'</td>
		'.$pets.'
	</tr>
</thead>
	<tbody>
		'.$veriler.'
		</tbody></table></body></html>';


?>

<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
