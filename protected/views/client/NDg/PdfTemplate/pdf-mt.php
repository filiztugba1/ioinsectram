<?php

//echo $type= $_POST['Report']['type'].'<br>';
$sql="";
$pets="";
$products="";
$kriterler="";

	$monitoringtype=Yii::app()->db->createCommand()
			->select('mt.name,mt.detailed')
			->from('monitoringtype mt')
			->where('mt.id='.$_POST['Monitoring']['mtypeid'])
			->queryAll();

$monitortypeandpetsView=MonitortypeandpetsView::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid']));
$petid=[];
foreach ($monitortypeandpetsView as $monitortypeandpetsViewx)
{
	$petid[]=$monitortypeandpetsViewx->petsid;
  $pets= $pets .'<td align="center">'.t($monitortypeandpetsViewx->name).'</td>';
}

//	$pets= $pets.'<td align="center">'.'Diğer</td>';
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$dep=empty($_POST['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($_POST['Report']['dapartmentid']);
$sub=empty($_POST['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($_POST['Monitoring']['subid']);

if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if(!in_array("0",$dep))
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	  $model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));

    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. ",";
    }
  }
}
if(!in_array("0",$sub))
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
$monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'timestamp asc,monitorno asc,petid desc'));

//$monitors=Mobileworkordermonitors::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'timestamp asc, monitorid asc'));
$bfrdate=date("Y-m-d",$monitors[0]->checkdate);
$monitorid=$monitors[0]->monitorid;
/*$veriler = $veriler. '
      <tr style="background-color:gray;">
			<td align="center" colspan="12">'.$bfrdate.'</td>
			</tr>
        ';
		*/
$i=0;
$gray=0;
$monitorsTopla=[];

foreach ($monitors as $monitor)
{
  
    $mnmno=Monitoring::model()->findByPk($monitor->monitorid);
     $idms=$monitor->monitorno;
  if (trim($mnmno->alternativenumber)<>''){
    $monitor->monitorno=$mnmno->alternativenumber;
    
  }
	$date=date("Y-m-d",$monitor->checkdate);
	$monitorsTopla[$date][$monitor->monitorno][$monitor->petid]=$monitor;
	$yazdurum=" - ";
	if($monitor->petid==49 && $monitor->isproduct==1)
	{
							if($monitor->value==1){ $yazdurum="KYK"; }
							if($monitor->value==2){ $yazdurum="KK"; }
							if($monitor->value==3){ $yazdurum="N/A"; }
	}
	
	
		$bolum='';
						if($monitor->subdepartmentname=='' || $monitor->subdepartmentname==null)
						{
						  $bolum=$monitor->departmentname;
						}
						else {
						  $bolum=$monitor->departmentname.' - '.$monitor->subdepartmentname;
						}

					  if($monitor->firmid==412)
					  {
						  $bolum=$bolum.' - '.$monitor->definationlocation;
					  }
		$monitorsTopla[$date][$monitor->monitorno]['yazdurum']=$yazdurum;
		$monitorsTopla[$date][$monitor->monitorno]['bolum']=$bolum;		
		$monitorsTopla[$date][$monitor->monitorno]['bolum']=$bolum;		
}
/*
foreach ($monitors as $monitor)
{
	$monitorsTopla[$monitor->checkdate][$monitor->monitorno][$monitor->pettype]=$monitor;
  if ($bfrdate != date("Y-m-d",$monitor->checkdate))
  {
    $veriler = $veriler. '
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
  	$yazdurum=" - ";
		if($monitor->petid==49 && $monitor->isproduct==1)
		{
			 if($monitor->value==1){ $yazdurum="KYK"; }
			 if($monitor->value==2){ $yazdurum="KK"; }
			 if($monitor->value==3){ $yazdurum="N/A"; }
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

    $veriler= $veriler .'
    <tr>
			<td align="center">'.$monitor->monitorno.'</td>
			<td align="left">'.$bolum.'</td>
			<td align="center" width="50px">'.$yazdurum.'</td>';
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
      $veriler = $veriler.'<td align="center" '.$style.'>'.($monitor->createdtime>0?$monitor->value:'-').'</td>';
  }
  if ($monitorid != $monitor->monitorid)
  {
    $veriler= $veriler .  '</tr>';
  }
  $i++;
}
*/
foreach($monitorsTopla as $monkey=>$monitors)
{
	/// tarihler 
	if($monitorsTopla[$monkey]!==null && !empty($monitorsTopla[$monkey]))
	{
	$veriler = $veriler. '
      <tr style="background-color:gray;">
			   <td align="center" colspan="12">'.$monkey.'</td>
			</tr>
        ';
	foreach($monitors as $monkeyx=>$monitorsx)
	{	
	    $veriler= $veriler .'
		<tr>
				<td align="center" colspan="1">'.$monkeyx.'</td>';
				
		
						 $veriler= $veriler .'<td align="left" colspan="2">'.$monitorsTopla[$monkey][$monkeyx]['bolum'].'</td>
						<td align="center"  colspan="1">'.$monitorsTopla[$monkey][$monkeyx]['yazdurum'].'</td>';
					
					
		
		foreach($petid as $pet)
		{
			  	$yazdurum=" - ";
				$mon=$monitorsTopla[$monkey][$monkeyx][$pet];
				if($mon!==null)
				{
					  if($mon->isproduct==0 && $gray==0)
					  {
						if($mon->value>0)
						{
						  $style='style="color:#fff;background:#000"';
						}else {
							$style='';
						}
						  $veriler = $veriler.'<td align="center" '.$style.' colspan="1">'.($mon->createdtime>0?$mon->value:'-').'</td>';
					  }
					  else
					  {
						  $veriler = $veriler.'<td align="center" colspan="1">0</td>';
					  }
		  
					$say++;
				}
				else
				{
					$veriler = $veriler.'<td align="center" colspan="1">0</td>';
				}
		}
		 $veriler= $veriler .'
		<tr>';
	}
	}
	
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
$pageCount=4+count($petid);
$html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
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
        <td width="100" align="center" colspan="3">
            <img src="'.$resim.'" border="0" width="75px">
        </td>
        <td colspan="'.($pageCount-3).'" align="center">
            <b><h2>'.t($monitoringtype[0]['name'].' '.$monitoringtype[0]['detailed']. ' Form').'</h2></b>
          
        </td>
    </tr>
    <tr>
        <td colspan="'.$pageCount.'">'.t('Müşteri Adı').': <b> '.$client->name.'</b></td>
    </tr>
    <tr>
        <td colspan="'.$pageCount.'">'.t('Rapor Kriterleri').': '.t($monitype->name)." ".t($monitype->detailed).' <br> '.$kriterler.'</td>
    </tr>
    <tr>
        <td colspan="'.$pageCount.'">'.t('Tarih').': '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
    </tr>
    <tr>
        <td colspan="'.$pageCount.'">'.t('Kontrol Eden - İmza').':</td>
    </tr>

    <tr>
        <td align="center" colspan="1">'.t('Monitor No').'</td>
        <td align="center" colspan="2">'.t('Cihazın Bulunduğu Yer').'</td>
		<td colspan="1">'.t('Cihazın Durumu').'</td>
        '.$pets.'
    </tr>
    </thead>
    <tbody>
    '.$veriler.'
    </tbody>
</table>
</body>
</html>';
?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
