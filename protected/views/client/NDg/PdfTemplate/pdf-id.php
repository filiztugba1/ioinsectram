<?php

//echo $type= $_POST['Report']['type'].'<br>';
$sql="";
$pets="";
$products="";
$kriterler="";

$monitortypeandpetsView=MonitortypeandpetsView::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid']));
$count=3;
foreach ($monitortypeandpetsView as $monitortypeandpetsViewx)
{
  $pets= $pets .'<td align="center">'.t($monitortypeandpetsViewx->name).'</td>';
  $count++;
}
//	$pets= $pets.'<td align="center">'.'Diğer</td>';
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

$dep=empty($_POST['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($_POST['Report']['dapartmentid']);
$sub=empty($_POST['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($_POST['Monitoring']['subid']);

if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0 || !in_array("0",$dep)){  //sub departman yoksa girsin
  if(!in_array("0",$dep))
  {

      $sql= $sql." departmentid in (".implode(",",$dep).") and ";
  	  $model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$dep).")"));

    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. ",";
    }
  }
}

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
$veriler = $veriler. '
      <tr style="background-color:gray;">
			<td align="center" colspan="'.($count).'">'.$bfrdate.'</td>
			</tr>
        ';
$i=0;
foreach ($monitors as $monitor)
{
  if ($bfrdate != date("Y-m-d",$monitor->checkdate))
  {
    $veriler = $veriler. '
      <tr style="background-color:gray;">
			   <td align="center" colspan="'.($count).'">'.date("Y-m-d",$monitor->checkdate).'</td>
			</tr>
        ';

        $bfrdate=date("Y-m-d",$monitor->checkdate);
  }
 
    $veriler= $veriler .  '<tr>';
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
      $bolum=$monitor->departmentname.' - '.$monitor->subdepartmentname;
    }
    if($monitor->firmid==412)
      {
          $bolum=$bolum.' - '.$monitor->definationlocation;
      }
    $veriler= $veriler .'
			<td align="center">'.$monitor->monitorno.'</td>
			<td align="left">'.$bolum.'</td>
			<td align="center" width="50px">'.$yazdurum.'</td>';
			  if($monitor->isproduct==0)
			  {
				if($monitor->value>0)
				{
				  $style='style="color:#fff;background:#000"';
				}else {
					$style='';
				}
				  $veriler = $veriler.'<td align="center" '.$style.'>'.($monitor->createdtime>0?$monitor->value:'-').'</td>';
			  }

  }

 
    $veriler= $veriler .  '</tr>';
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
$html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
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
		<td width="100" align="center" colspan="3">
			 <img src="'.$resim.'" border="0" width="75px">
		</td>
		<td colspan="'.($count-3).'" align="center">
			<b><h2>'.t('Haşere Kontrol Formu-').'</h2></b>
	
		</td>
	</tr>
	<tr>
		<td colspan="'.($count).'">'.t('Müşteri Adı').': <b> '.$monitor->clientname.'</b></td>
	</tr>
	<tr>
		<td colspan="'.($count).'">'.t('Rapor Kriterleri').': '.t($monitype->name)." ".t($monitype->detailed).'  <br> '.$kriterler.'</td>
	</tr>
	<tr>
		<td colspan="'.($count).'">'.t('Tarih').': '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="'.($count).'">'.t('Kontrol Eden - İmza').':</td>
	</tr>

	<tr>
		<td align="center">'.t('No').'</td>
		<td align="center">'.t('Cihazın Bulunduğu Yer').'</td>

		<td>'.t('Cihazın Durumu').'</td>
		'.$pets.'
	</tr>
</thead>
	<tbody>

	'.$veriler.'
    </tbody>
	</table></body></html>';

?>

<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>