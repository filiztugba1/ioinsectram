<?php
$sql="";
$pets="";
$products="";
$ssskay=0;
$yeni="";
$aktiveler="";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$sorsql="";
if($_POST['Report']['dapartmentid'] <> 0)
{
    $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
	$sorsql= $sorsql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
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



		//
	if(count($_POST['Monitoring']['subid'])>1)
	{
	$sorsql=$sorsql. " (";
    foreach ($_POST['Monitoring']['subid'] as $item)
    {
        $sorsql= $sorsql."subdepartmentid=".$item." or ";
    }
    $sorsql=rtrim($sorsql,"or ");
    $sorsql= $sorsql.") and ";
	}
	else{
		  $sorsql= $sorsql."subdepartmentid=".$_POST['Monitoring']['subid'][0]." and ";
	}

		//
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


	//

	/*if(count($_POST['Monitoring']['monitors'])>1)
	{
	$sorsql=$sorsql. " (";
    foreach ($_POST['Monitoring']['monitors'] as $item)
    {
        $sorsql= $sorsql."monitorid=".$item." or ";
    }
    $sorsql=rtrim($sorsql,"or ");
    $sorsql= $sorsql.") and ";
	}
	else{
		  $sorsql= $sorsql."monitorid=".$_POST['Monitoring']['monitors'][0]." and ";
	}*/
}


$yaztipleri=" Pests : ";
if(count($_POST['Report']['pests'])>0)
	{
		$sorsql .=" (";
		foreach ($_POST['Report']['pests'] as $item)
		{
			$sorsql= $sorsql."petid=".$item." or ";
			$yaztipleri .= " ".t(Pets::model()->findByPk($item)->name).",";
		}
		$sorsql=rtrim($sorsql,"or ");
		$sorsql= $sorsql.") and";
	}
	else{
		//$sorsql="";
	}


$veriler='';
/*$ccvmn='';

	for($i=1;$i<9-count($tarihler);$i++)
{
    $ccvmn = $ccvmn.'<td></td>';
}*/
/////sorun yok\\\\\\\
$monitors=Mobileworkordermonitors::model()->findAll(array('condition'=>$sql.'checkdate!=0 and monitortype='.$_POST['Monitoring']['mtypeid'].' and clientbranchid='.$_POST['Report']['clientid'].' and isdelete=0 and (checkdate between '.$midnight.' and '.$midnight2.') group by monitorid' ,'order'=>'monitorid asc, checkdate asc'));

foreach ($monitors as $monitor)
{




	$saybe=0;
	$dataverim=Mobileworkorderdata::model()->findall(array('condition'=>''.$sorsql.' isproduct=1 and value!=0 and monitorid='.$monitor->monitorid.' and monitortype='.$monitor->monitortype.' and (createdtime between '.$midnight.' and '.$midnight2.')'));
	foreach($dataverim as $dataveri)
	{
		$saybe++;

	}
	if($saybe>0)
	{
		$saybe++;
		$subdepartment=Departments::model()->findByPk($monitor->subdepartment);
		$department=Departments::model()->findByPk($monitor->departmentid);
		$monitoring=Monitoring::model()->find(array('condition'=>'id='.$monitor->monitorid.' and clientid='.$monitor->clientbranchid));
		$monitoringlocation=Monitoringlocation::model()->findByPk($monitoring->mlocationid);
		$veriler= $veriler .'<tr>
			<td align="center" rowspan="'.$saybe.'">'.$monitor->monitorno.'</td>

			<td align="left" rowspan="'.$saybe.'">'.$department->name.'</td>
			<td align="left" rowspan="'.$saybe.'">'.$subdepartment->name.'</td>
			<td align="left" rowspan="'.$saybe.'">'.$monitoring->definationlocation.'</td></tr>';

			$tarihbasla=$monitor->checkdate;
			$tarihbiti=($midnight2+(3600*24)) - 1;
			$dataverim=Mobileworkorderdata::model()->findall(array('condition'=>''.$sorsql.' isproduct=1 and value!=0 and monitorid='.$monitor->monitorid.' and monitortype='.$monitor->monitortype.'  and (createdtime between '.$midnight.' and '.$midnight2.')'));

			foreach($dataverim as $dataveri)
			{

				if($dataveri->petid==49){
					if($dataveri->value==1){ $durum=t("Kayıp"); }
					if($dataveri->value==2){ $durum=t("Kırık"); }
					if($dataveri->value==3){ $durum=t("Ulaşılamıyor"); }
				}
				else if($dataveri->petid==36)
				{
					$durum=t("Ekipman Çalışmıyor (Equipment Not Working)");
				}
				else if($dataveri->petid==35)
				{
					$durum=t("Tek Lamba Yanmıyor ( One Tube Not Working)");
				}

				else{
					/*Pets::model()->findByPk($dataveri->petid)->name." : ".*/
					$durum=$dataveri->value;
				}

				$veriler .= '<tr>
								<td>'.$durum.'</td>
								<td>'.date('d/m/Y',$dataveri->createdtime).'</td>
							</tr>';
			//$ssskay++;
				if($dataveri->petid == 49)
				{
					$ssskay = $ssskay + 1;
				}
				else{
					$ssskay = $ssskay + $dataveri->value;
				}

			}
	}


		/*$veriler = $veriler.'
		<tr>
		<td>1</td>
		<td>'.date('d/m/Y',$monitor->checkdate).'</td>
		</tr>
		<tr>
		<td>1</td>
		<td>'.date('d/m/Y',$monitor->checkdate).'</td>
		</tr>
		';*/


	///////////////////////////////////start////////////////

//	$veriler= $veriler.$ccvmn;
$saybe=0;
}

/*$total=Mobileworkorderdata::model()->findAll(array('SELECT'=>'*,sum(value) as total','condition'=>$sorsql.' isproduct=1 and value!=0 and  (checkdate between '.$midnight.' and '.$midnight2.') and clientbranchid='.$_POST["Report"]["clientid"].''));
*/
$toplamm=0;
/*echo $ssskay;
echo 'SELECT * FROM mobileworkorderdata where '.$sorsql.' clientbranchid='.$_POST['Report']['clientid'].'   and value!=0  and monitortype='.$_POST['Monitoring']['mtypeid'].' and (createdtime between '.$midnight.' and '.$midnight2.')'; exit;
$total= Yii::app()->db->createCommand('SELECT * FROM mobileworkorderdata where '.$sorsql.' clientbranchid='.$_POST['Report']['clientid'].'   and value!=0  and monitortype='.$_POST['Monitoring']['mtypeid'].' and (createdtime between '.$midnight.' and '.$midnight2.')')->queryAll();*/
//$x=$total[0];
$toplamm= $toplamm + count($total);

/*
if($sorsql=="")
{

	$total49= Yii::app()->db->createCommand('SELECT *,count(value) as toplam FROM mobileworkorderdata where    clientbranchid='.$_POST['Report']['clientid'].' and isproduct=1 and value!=0 and  petid=49 and monitortype='.$_POST['Monitoring']['mtypeid'].' and (createdtime between '.$midnight.' and '.$midnight2.')')->queryAll();
	$x1=$total49[0];
	$toplamm= $toplamm +$x1["toplam"];
}
else{
	if(strstr($sorsql,"49")){
		$total49= Yii::app()->db->createCommand('SELECT *,count(value) as toplam FROM mobileworkorderdata where   clientbranchid='.$_POST['Report']['clientid'].' and isproduct=1 and value!=0 and  petid=49 and monitortype='.$_POST['Monitoring']['mtypeid'].' and (createdtime between '.$midnight.' and '.$midnight2.')')->queryAll();
		$x1=$total49[0];
		$toplamm= $toplamm +$x1["toplam"];
	}
}*/






	$veriler .= '<tr>
	<td colspan="4" style="text-align:right;">'.t('Total ').'</td>
	<td  style="text-align:left;"> '.$ssskay.'</td>
	</tr>';
//$veriler= 	$veriler.'</tr>' ;
/*foreach($tarihler as $item)
{
	 $aktiveler=$aktiveler.'<td>'.$item.'</td>';
}
for($i=1;$i<9-count($tarihler);$i++)
{
	$aktiveler = $aktiveler.'<td></td>';
}*/

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
		<td width="100" align="center" colspan="2">
			 <img src="'.$resim.'" border="0" width="75px">
		</td>
		<td colspan="4" align="center">
			<b><h2>'.t('Consumption Use - Non-Activity Report').'</h2></b>

		</td>
	</tr>
	<tr>
		<td colspan="6">'.t('Client Name').': <b> '.$client->name.'</b></td>
	</tr>
	<tr>
		<td colspan="6">'.t('Report Selections').': '.$monitype->name." ".$monitype->detailed.' -  '.$yaztipleri.'</td>
	</tr>
	<tr>
		<td colspan="6">'.t('Date').': '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="6">'.t('Controller - Signature').':</td>
	</tr>

	<tr>
		<td align="center">No</td>
		<td>'.t('Department').'</td>
		<td>'.t('Sub Department').'</td>
		<td>'.t('Defination Location').'</td>
		<td>'.t('Piece').'</td>
		<td>'.t('Date').'</td>
		'.$pets.'
	</tr>
</thead>
	<tbody>
		'.$veriler.'
		</tbody></table></body></html>';

?>
