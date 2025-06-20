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


if(is_countable($_POST["Monitoring"]["subid"]) && count($_POST["Monitoring"]["subid"])>0)
{
		$sql=$sql. " subdepartment in (".implode(",", $_POST['Monitoring']['subid']).") and ";
    $sorsql=$sorsql. " subdepartment in (".implode(",", $_POST['Monitoring']['subid']).") and ";
}
if(is_countable($_POST["Monitoring"]["monitors"]) && count($_POST["Monitoring"]["monitors"])>1)
{
  $sql=$sql. " monitorid in (".implode(",", $_POST['Monitoring']['monitors']).") and ";
  $sorsql=$sorsql. " monitorid in (".implode(",", $_POST['Monitoring']['monitors']).") and ";
}


$yaztipleri=" Pests : ";
if(is_countable($_POST['Report']['pests']) && count($_POST['Report']['pests'])>0)
	{
    $sorsql=$sorsql. " petid in (".implode(",", $_POST['Report']['pests']).") and ";
//    $sql=$sorsql. " petid in (".implode(",", $_POST['Report']['pests']).") and ";
		foreach ($_POST['Report']['pests'] as $item)
		{
			$yaztipleri .= " ".t(Pets::model()->findByPk($item)->name).",";
		}
	}


$veriler='';
$monitorsSql=$sql.'checkdate!=0 and monitortype='.$_POST['Monitoring']['mtypeid'].' and clientbranchid='.$_POST['Report']['clientid'].' and isdelete=0 and (checkdate between '.$midnight.' and '.$midnight2.') group by monitorid ORDER BY monitorid asc, checkdate asc';
$monitors=MobileworkordermonitorsView::model()->findAll(array('condition'=>$monitorsSql));


$datamonitor=[];
if(count($monitors)>0)
{
$dcbselect=Yii::app()->db->createCommand('SELECT mwdw.* FROM mobileworkorderdata_view as mwdw left join (SELECT monitorid,monitortype FROM mobileworkordermonitors_view where '.$monitorsSql.') as mdmw on mdmw.monitorid=mwdw.monitorid and mdmw.monitortype=mwdw.monitortype where mwdw.isproduct=1 and mwdw.value!=0 and (mwdw.createdtime between '.$midnight.' and '.$midnight2.')')->queryAll();
  foreach ($dcbselect as $key => $value) {
    array_push($datamonitor,['id'=>$value['id'],
      "mobileworkordermonitorsid"=>$value['mobileworkordermonitorsid'],
      "workorderid"=>$value['workorderid'],
      "monitorid"=>$value['monitorid'],
      "monitortype"=>$value['monitortype'],
      "petid"=>$value['petid'],
      "pettype"=>$value['pettype'],
      "value"=>$value['value'],
      "saverid"=>$value['saverid'],
      "createdtime"=>$value['createdtime'],
      "firmid"=>$value['firmid'],
      "firmbranchid"=>$value['firmbranchid'],
      "clientid"=>$value['clientid'],
      "clientbranchid"=>$value['clientbranchid'],
      "departmentid"=>$value['departmentid'],
      "departmentname"=>$value['departmentname'],
      "subdepartmentid"=>$value['subdepartmentid'],
      "subdepartmentname"=>$value['subdepartmentname'],
      "openedtimestart"=>$value['openedtimestart'],
      "openedtimeend"=>$value['openedtimeend'],
      "isproduct"=>$value['isproduct'],
    ]);
  }
  //$dataverim=MobileworkorderdataView::model()->findall(array('condition'=>''.$sorsql.' isproduct=1 and value!=0 and monitorid in ('.implode(",", $monitorid).') and monitortype='.$monitor->monitortype.' and (createdtime between '.$midnight.' and '.$midnight2.')'));
}
//print_r($datamonitor);exit;
foreach ($monitors as $monitor)
{
// print_r(array_filter($array1, "tek"));
  $dataverim=[];
  foreach($datamonitor as $datamonitorss)
  {
    if($datamonitorss['monitorid']==$monitor->monitorid && $datamonitorss['monitortype']==$monitor->monitortype)
    {
      if(isset($_POST['Report']['pests']) &&count($_POST['Report']['pests'])>0)
      {
      $val=gettype(array_search($datamonitorss["petid"],$_POST['Report']['pests'],true));
        if($val==="integer")
        {
          array_push($dataverim,$datamonitorss);
        }
      }
      else {
        array_push($dataverim,$datamonitorss);
      }

    }
  }
$count=count($dataverim);
  $saybe=count($dataverim);
	if($saybe>0)
	{
		$saybe++;
    $key = array_search($monitor->monitorid, array_column($datamonitor, 'monitorid'));
		$subdepartment=$datamonitor[$key]['subdepartmentname'];
		$department=$datamonitor[$key]['departmentname'];;
		$monitoring=Monitoring::model()->find(array('condition'=>'id='.$monitor->monitorid.' and clientid='.$monitor->clientbranchid));
		$monitoringlocation=Monitoringlocation::model()->findByPk($monitoring->mlocationid);


$monitorSay=0;
			$tarihbasla=$monitor->checkdate;
			$tarihbiti=($midnight2+(3600*24)) - 1;
			$dataverim=$dataverim;
      $monitorno='';
			foreach($dataverim as $dataveri)
			{
        $monitorData=true;



        if($monitorSay==0)
        {
          $monitorno=$monitor->monitorno;
          $veriler= $veriler .'<tr>
            <td align="center" rowspan="'.$saybe.'">'.$monitor->monitorno.'</td>

            <td align="left" rowspan="'.$saybe.'">'.$department.'</td>
            <td align="left" rowspan="'.$saybe.'">'.$subdepartment.'</td>
            <td align="left" rowspan="'.$saybe.'">'.$monitoring->definationlocation.'</td>';
        }
				if($dataveri["petid"]==49){
					if($dataveri["value"]==1){ $durum=t("Kayıp"); }
					if($dataveri["value"]==2){ $durum=t("Kırık"); }
					if($dataveri["value"]==3){ $durum=t("Ulaşılamıyor"); }
				}
				else if($dataveri["petid"]==36)
				{
					$durum=t("Ekipman Çalışmıyor (Equipment Not Working)");
				}
				else if($dataveri["petid"]==35)
				{
					$durum=t("Tek Lamba Yanmıyor ( One Tube Not Working)");
				}

				else{
					//Pets::model()->findByPk($dataveri->petid)->name." : "
					$durum=$dataveri["value"];
				}
        $veriler .= '<tr>
                <td>'.$durum.'</td>
                <td>'.date('d/m/Y',$dataveri["createdtime"]).'</td>
              </tr>';
			//$ssskay++;
				if($dataveri['petid'] != 49 && $dataveri["petid"]!=36 && $dataveri["petid"]!=35)
				{
          $ssskay = $ssskay + $dataveri["value"];
					       //  $ssskay = $ssskay + 1;
				}


			/*	else{
					$ssskay = $ssskay + $dataveri["value"];
				}
        */


$monitorSay++;
if($count-1==$monitorSay)
{
  $veriler .= '</tr>';
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
if (is_countable($total)){
$toplamm= $toplamm + count($total);
  
}

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
