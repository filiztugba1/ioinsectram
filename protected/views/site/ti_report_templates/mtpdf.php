<?php

//echo $type= $rmpdfparams['Report']['type'].'<br>';
$sqlcc="";
$petscc="";
$products="";
$kriterlercc="";

$monitortypeandpetsView=MonitortypeandpetsView::model()->findAll(array('condition'=>'monitoringtypeid='.$rmpdfparams['Monitoring']['mtypeid']));
foreach ($monitortypeandpetsView as $monitortypeandpetsViewx)
{
  $petscc= $petscc .'<td align="center">'.t($monitortypeandpetsViewx->name).'</td>';
}
//	$petscc= $petscc.'<td align="center">'.'Diğer</td>';
$tarih1=$rmpdfparams['Monitoring']['date'];
$tarih2=$rmpdfparams['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$dep=empty($rmpdfparams['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Report']['dapartmentid']);
$sub=empty($rmpdfparams['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($rmpdfparams['Monitoring']['subid']);

if(!isset($rmpdfparams["Monitoring"]["subid"]) || count($rmpdfparams['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if(!in_array("0",$dep))
  {
      $sqlcc= $sqlcc." departmentid in (".implode(",",$rmpdfparams['Report']['dapartmentid']).") and ";
  	  $model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$rmpdfparams['Report']['dapartmentid']).")"));

    foreach($model as $modelx)
    {
      $kriterlercc .= $modelx->name. ",";
    }
  }
}
if(!in_array("0",$sub))
{
		if(count($sub)>1)
	{
	$sqlcc=$sqlcc. " (";
    foreach ($sub as $item)
    {
		$model=Departments::model()->findByPk($item);
		if($model)
		{
			$kriterlercc .= ", (".Departments::model()->findByPk($model->parentid)->name." - ".$model->name.")";
		}
        $sqlcc= $sqlcc."subdepartment=".$item." or ";
    }
    $sqlcc=rtrim($sqlcc,"or ");
    $sqlcc= $sqlcc.") and ";
	}
/*	else{
		$model=Departments::model()->findByPk($rmpdfparams['Monitoring']['subid'][0]);
		if($model)
		{
		//	$kriterlercc .= " ".$model->name;
		}
		$sqlcc= $sqlcc."subdepartment=".$rmpdfparams['Monitoring']['subid'][0]." and ";
	}
  */
}

if($rmpdfparams['Monitoring']['date'])
{
    $sqlcc= $sqlcc." checkdate >=".$midnight." and ";
}
if($rmpdfparams['Monitoring']['date1'])
{
    $sqlcc= $sqlcc." checkdate <=".$midnight2." and ";
}

if(isset($rmpdfparams["Monitoring"]["monitors"]))
{
	if(count($rmpdfparams['Monitoring']['monitors'])>1)
	{
	$sqlcc=$sqlcc. " (";
    foreach ($rmpdfparams['Monitoring']['monitors'] as $item)
    {
        $sqlcc= $sqlcc."monitorid=".$item." or ";
    }
    $sqlcc=rtrim($sqlcc,"or ");
    $sqlcc= $sqlcc.") and ";
	}
	else{
		  $sqlcc= $sqlcc."monitorid=".$rmpdfparams['Monitoring']['monitors'][0]." and ";
	}
}
$isfix=0;
$monitors=WorkorderreportstiView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlcc.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'],'order'=>'timestamp asc,monitorno asc,petid desc'));
if (!$monitors){
  $isfix=1;
  $monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlcc.'checkdate!=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'],'order'=>'timestamp asc,monitorno asc,petid desc'));
}
//$monitors=Mobileworkordermonitors::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sqlcc.'checkdate!=0 and isdelete=0 and clientbranchid='.$rmpdfparams['Report']['clientid'].' and monitortype='.$rmpdfparams['Monitoring']['mtypeid'],'order'=>'timestamp asc, monitorid asc'));
$bfrdate=date("Y-m-d",$monitors[0]->checkdate);
$monitorid=$monitors[0]->monitorid;
if ( $bfrdate<>'1970-01-01'){
$verilercc = $verilercc. '
      <tr style="background-color:gray;">
			<td align="center" colspan="12">'.$bfrdate.'</td>
			</tr>
        ';}
$i=0;
$gray=0;
foreach ($monitors as $monitor)
{
  if ($bfrdate != date("Y-m-d",$monitor->checkdate) && date("Y-m-d",$monitor->checkdate)<>'1970-01-01')
  {
    $verilercc = $verilercc. '
      <tr style="background-color:gray;">
			   <td align="center" colspan="12">'.date("Y-m-d",$monitor->checkdate).'</td>
			</tr>
        ';

        $bfrdate=date("Y-m-d",$monitor->checkdate);
        $gray=1;
  }
  if ($monitorid != $monitor->monitorid || $i==0)
  {
    $monitorid =$monitor->monitorid;
  	$yazdurumcc=" - ";
		if($monitor->petid==49 && $monitor->isproduct==1)
		{
			 if($monitor->value==1){ $yazdurumcc="KYK"; }
			 if($monitor->value==2){ $yazdurumcc="KK"; }
			 if($monitor->value==3){ $yazdurumcc="N/A"; }
		}

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

    $verilercc= $verilercc .'
    <tr>
			<td align="center">'.$monitor->monitorno.'</td>
			<td align="left">'.$bolum.'</td>
			<td align="center" width="50px">'.$yazdurumcc.'</td>';
      $gray=0;
  }
  if($monitor->isproduct==0 && $gray==0)
  {
    if($monitor->value>0)
    {
      $style='style="color:#fff;background:#000"';
    }else {
        $style='';
    }
      $verilercc = $verilercc.'<td align="center" '.$style.'>'.($monitor->createdtime>0?$monitor->value:'-').'</td>';
  }
  if ($monitorid != $monitor->monitorid)
  {
    $verilercc= $verilercc .  '</tr>';
  }
  $i++;
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


if (strlen($verilercc)<30){

	$htmlmt='';
}else{
	
	
$htmlmt='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
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
        <td width="100" align="center" colspan="2">
            <img src="/'.$resim.'" border="0" width="75px">
        </td>
        <td colspan="11" align="center">
            <b><h2>'.t('Moth Lures Form').'</h2></b>
          
        </td>
    </tr>
    <tr>
        <td colspan="13">'.t('Müşteri Adı').': <b> '.$client->name.'</b></td>
    </tr>
    <tr>
        <td colspan="13">'.t('Rapor Kriterleri').': '.t($monitype->name)." ".t($monitype->detailed).' <br> '.$kriterlercc.'</td>
    </tr>
    <tr>
        <td colspan="13">'.t('Tarih').': '.$rmpdfparams['Monitoring']['date'].' / '.$rmpdfparams['Monitoring']['date1'].'</td>
    </tr>
    <tr>
        <td colspan="13">'.t('Kontrol Eden - İmza').': <img src="'.$reportinfo->technician_sign.'" style="//filter: brightness(30) grayscale(100%) invert(100%); margin-top:-10px; margin-right:-20px;" width="100px"></td>
    </tr>

    <tr>
        <td align="center">'.t('No').'</td>
        <td align="center">'.t('Cihazın Bulunduğu Yer').'</td>
		<td>'.t('Cihazın Durumu').'</td>
        '.$petscc.'
    </tr>
    </thead>
    <tbody>
    '.$verilercc.'
    </tbody>
</table>
</body>
</html>';
}
?>
