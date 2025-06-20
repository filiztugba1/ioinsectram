<?php

$sqlnn="";
$petsnn="";
$products="";
$yeninn="";

$monitorpettypesnn=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='.$rmpdfparams['Monitoring']['mtypeid']));
$colspan=count($monitorpettypesnn);
$col=4;
foreach ($monitorpettypesnn as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'(isproduct=0 and id='.$monitorpettype->petsid.")"));
    if($pet)
    {
		$ing=t($pet->name);
        $petsnn= $petsnn .'<td colspan="1" width="50px" align="center">'.t($pet->name).'</td>'; // KAPALI
		$col++;
        // $petsnn= $petsnn .'<td>'.$pet->name." ".$pet->id.'</td>'; Test Amaçlı Gelen veriler doğru yere geliyor mu diye AÇIK
    }

}
/*	foreach ($monitorpettypesnn as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'isproduct=1 and id='.$monitorpettype->petsid));
    if($pet)
    {
        $petsnn= $petsnn .'<td>'.$pet->name.'</td>'; // KAPALI
        // $petsnn= $petsnn .'<td>'.$pet->name." ".$pet->id.'</td>'; Test Amaçlı Gelen veriler doğru yere geliyor mu diye AÇIK
    }

}*/
//$petsnn= $petsnn .'<td>Durum</td>';

$tarih1nn=$rmpdfparams['Monitoring']['date'];
$tarih2nn=$rmpdfparams['Monitoring']['date1'];
$midnightnn = strtotime("today", strtotime($tarih1nn));
$midnightnn2 = strtotime("today", strtotime($tarih2nn)+3600*24);
$kriterlernn="";

$dep=empty($rmpdfparams['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Report']['dapartmentid']);
$sub=empty($rmpdfparams['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Monitoring']['subid']);

if(!isset($rmpdfparams["Monitoring"]["subid"]) || count($sub)==0 || !in_array("0",$dep)){  //sub departman yoksa girsin
  if(!in_array("0",$dep))
  {
      $sqlnn= $sqlnn." departmentid in (".implode(",",$dep).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$dep).")"));

    foreach($model as $modelx)
    {
      $kriterlernn .= t($modelx->name). ",";
    }
    /*if($kriterlernn!="")
    {
      $kriterlernn .=$kriterlernn. " - ";
    }
    */
  }
}
/*if($rmpdfparams['Monitoring']['subid'])
{
    $sqlnn= $sqlnn." subdepartment=".$rmpdfparams['Monitoring']['subid']." and ";
}*/
///////////////////////////////////////////////////////
if(isset($sub) and !in_array("0",$sub))
{
	if(count($sub)>1)
	{
	$sqlnn=$sqlnn. " (";
    foreach ($sub as $item)
    {
		$model=Departments::model()->findByPk($item);
		if($model)
		{
			$kriterlernn .= ", (".Departments::model()->findByPk($model->parentid)->name." - ".$model->name.")";
		}
        $sqlnn= $sqlnn."subdepartment=".$item." or ";
    }
    $sqlnn=rtrim($sqlnn,"or ");
    $sqlnn= $sqlnn.") and ";
	}
/*	else{
		$model=Departments::model()->findByPk($rmpdfparams['Monitoring']['subid'][0]);
		if($model)
		{
		//	$kriterlernn .= " ".$model->name;
		}
		$sqlnn= $sqlnn."subdepartment=".$rmpdfparams['Monitoring']['subid'][0]." and ";
	}
  */
}


///////////////////////////////////////////////////////
if($rmpdfparams['Monitoring']['date'])
{
    $sqlnn= $sqlnn." checkdate >=".$midnightnn." and ";
}
if($rmpdfparams['Monitoring']['date1'])
{
    $sqlnn= $sqlnn." checkdate <=".$midnightnn2." and ";
}




if(isset($rmpdfparams["Monitoring"]["monitors"]))
{
	if(count($rmpdfparams['Monitoring']['monitors'])>1)
	{
	$sqlnn=$sqlnn. " (";
    foreach ($rmpdfparams['Monitoring']['monitors'] as $item)
    {
        $sqlnn= $sqlnn."monitorid=".$item." or ";
    }
    $sqlnn=rtrim($sqlnn,"or ");
    $sqlnn= $sqlnn.") and ";
	}
	else{
		  $sqlnn= $sqlnn."monitorid=".$rmpdfparams['Monitoring']['monitors'][0]." and ";
	}
}
/*$varmimonitor=Mobileworkordermonitors::model()->findAll(array('condition'=>$sqlnn.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].'','order'=>'monitorid asc'));
foreach($varmimonitor as $var)
{
	$varmidata = Mobileworkorderdata::model()->findAll(array('condition' => 'isproduct=0 and mobileworkordermonitorsid=' . $var->id, 'order' => 'petid desc'));
	foreach($varmidata as $varmi)
	{
		if($varmi->)
	}
}*/

$isfix=0;
$monitors=MobileworkordermonitorstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlnn.'checkdate!=0 and isdelete=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].'','order'=>'timestamp asc, monitorno asc'));
if (!$monitors){
  $isfix=1;
$monitors=MobileworkordermonitorsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlnn.'checkdate!=0 and isdelete=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'].'','order'=>'timestamp asc, monitorno asc'));
}

/*
$verilernn = $verilernn. '
            <tr style="background-color:gray;">
			<td align="center" colspan="15">'.$bfrdate.'</td>
			</tr>
        ';*/
$bfrdate=213123123;
// echo count($monitors).'--'.microtime();
foreach ($monitors as $monitor) {


        if ($bfrdate != date("d-m-Y", $monitor->checkdate)) {
            $verilernn = $verilernn . '
                <tr style="background-color:lightgray;">
                <td align="center" colspan="14">' . date("d-m-Y", $monitor->checkdate) . '</td>
                </tr>
            ';
        }
        $bfrdate = date("d-m-Y", $monitor->checkdate);
        $subdepartment = Departments::model()->findByPk($monitor->subdepartment);
		$MonitorTipi=Monitoringtype::model()->findByPk($rmpdfparams['Monitoring']['mtypeid']);
    if ($isfix){
       $reportx = MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=49 and mobileworkordermonitorsid=' . $monitor->id));
    }else{
       $reportx = MobileworkorderdatatiView::model()->find(array('condition' => 'isproduct=1 and petid=49 and mobileworkordermonitorsid=' . $monitor->id));
    }
		
		 $yazdurum=" - ";
		 if($reportx)
		{
			 if($reportx->value==1){ $yazdurum=t("KYK"); }
			 if($reportx->value==2){ $yazdurum=t("Br"); }
			 if($reportx->value==3){ $yazdurum=t("N/A"); }
		}
      if ($isfix){
         $reporty= MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=36 and mobileworkordermonitorsid=' . $monitor->id));
    
     }else{
         $reporty= MobileworkorderdatatiView::model()->find(array('condition' => 'isproduct=1 and petid=36 and mobileworkordermonitorsid=' . $monitor->id));
    
      }
    if($reporty)
   {
      if($reporty->value==1){ $yazdurum=t("ENW"); }
   }
  
      if (!$isfix){
   $reportz= MobileworkorderdatatiView::model()->find(array('condition' => 'isproduct=1 and petid=35 and mobileworkordermonitorsid=' . $monitor->id));
      }else{
        $reportz= MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=35 and mobileworkordermonitorsid=' . $monitor->id));
    
      }
   if($reportz)
  {
     if($reportz->value==1){ $yazdurum=t("TNW"); }
  }

  $bolum= $subdepartment->name;
  if($monitor->firmid==412)
  {
      $bolum=$bolum.' - '.$monitor->definationlocation;
  }

        $verilernn = $verilernn . '
        <tr>
                <td colspan="1" align="center">' . $monitor->monitorno . '</td>
                <td colspan="2" align="left">' . $bolum . '</td>
                <td colspan="1" align="center" width="50px">'.$yazdurum.'</td>
        ';
       if (!$isfix){
          $reports = MobileworkorderdatatiView::model()->findAll(array('select'=>'value,createdtime','condition' => 'isproduct=0  and mobileworkordermonitorsid=' . $monitor->id,'order'=>'id asc'));
      
       }else{
          $reports = MobileworkorderdataView::model()->findAll(array('select'=>'value,createdtime','condition' => 'isproduct=0  and mobileworkordermonitorsid=' . $monitor->id,'order'=>'id asc'));
      
       }
         foreach ($reports as $report) {
            $verilernn = $verilernn . '<td align="center" colspan="1">' .($report->createdtime>0?$report->value:'-') . '</td>'; // Kapalı
            // $verilernn = $verilernn.'<td align="center">'.$report->value." ".$report->petid.'</td>';  Test amaçlı veriler doğru yere geliyor mu AÇIK
        }

        //$verilernn = $verilernn . $yeninn.$yaz . '</tr>';
        $verilernn = $verilernn . $yeninn  . '</tr>';
        //$yeninn = "";

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


if (strlen($verilernn)<30){

	$htmlefk='';
}else{
	
	
$htmlefk='
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><style>
.f12
{
	//font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
//font-size:8pt;
}
td {
font-family:Arial;
//font-size:6pt;
}
</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<td width="100" align="center" colspan="2">
			 <img src="/'.$resim.'" border="0" width="75px">
		</td>
		<td colspan="'.($col>12?$col-2:10).'" align="center">
			<b><h2>'.t('Uçan Haşere Üniteleri Kontrol ve İçerik Listesi').'</h2></b>
			<br><h3>'.t('(Fly Unit Control &amp; Contents Checklist)').'</h3>
		</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Müşteri Adı (Client Name)').': <b> '.$client->name.'</b></td>
		<td colspan="2" rowspan="4">
		<b>'.t('N/A').'</b> '.t('Ulaşılamadı (Not-Approachable)').' <br>
		<b>'.t('ENW').'</b> '.t('Ekipman Çalışmıyor (Equipment Not Working)').' <br>
		<b>'.t('TNW').'</b> '.t('Tek Lamba Yanmıyor ( One Tube Not Working)').' <br>
		<b>'.t('Br').'</b>  '.t('Kırık (Broken)').'
		</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Rapor Kriterleri (Report Criteria)').': '.t($monitype->name)." ".t($monitype->detailed).' <br> '.$kriterlernn.'</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Tarih (Date)').': '.$rmpdfparams['Monitoring']['date'].' / '.$rmpdfparams['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="'.($col>12?$col-2:10).'">'.t('Kontrol Eden (Kontroller) - İmza (Signature)').': 	<img src="'.$reportinfo->technician_sign.'" style="//filter: brightness(30) grayscale(100%) invert(100%); margin-top:-10px; margin-right:-20px;" width="100px"> </td>
	</tr>

	<tr>
		<td align="center" colspan="1">'.t('Monitor No').'</td>
		<td colspan="2">'.t('Cihazın Bulunduğu Yer<br>(Location)').'</td>
		<td colspan="1">'.t('Cihazın Durumu<br>(Type)').'</td>
		'.$petsnn.'
	</tr>
</thead>
	<tbody>
		'.$verilernn.'
		</tbody></table></body></html>';

}
?>

<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
