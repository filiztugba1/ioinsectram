<?php

$sql="";
$pets="";
$products="";
$yeni="";


$pets= $pets .'<td width="50px" align="center">'.t("Ölçüm Değeri").'</td>'; // KAPALI
$pets= $pets .'<td width="50px" align="center">'.t("Sonuç").'</td>'; // KAPALI



$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

if($_POST['Report']['dapartmentid'] <> 0)
{
    $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
}

///////////////////////////////////////////////////////
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



$monitors=MobileworkordermonitorsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].'','order'=>'timestamp asc, monitorid asc'));

$bfrdate=213123123;
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
		 $reportx = MobileworkorderdataView::model()->find(array('condition' => 'isproduct=1 and petid=49 and mobileworkordermonitorsid=' . $monitor->id, 'order' => 'petid desc'));
		 $yazdurum=" - ";
		 if($reportx)
		{
			 if($reportx->value==1){ $yazdurum="KYK"; }
			 if($reportx->value==2){ $yazdurum="KK"; }
			 if($reportx->value==3){ $yazdurum="N/A"; }
		}
        $veriler = $veriler . '
        <tr>
                <td align="center">' . $monitor->monitorno . '</td>
                <td align="left">' . $subdepartment->name . '</td>
                <td align="center" width="50px">'.$yazdurum.'</td>
        ';
        $reports = MobileworkorderdataView::model()->findAll(array('condition' => 'isproduct=0 and mobileworkordermonitorsid=' . $monitor->id, 'order' => 'petid desc'));
        foreach ($reports as $report) {
            $veriler = $veriler . '<td align="center">' . $report->value . '</td>'; // Kapalı
            // $veriler = $veriler.'<td align="center">'.$report->value." ".$report->petid.'</td>';  Test amaçlı veriler doğru yere geliyor mu AÇIK
        }

        /*$productlar = Mobileworkorderdata::model()->findAll(array('condition' => 'isproduct=1 and mobileworkordermonitorsid=' . $monitor->id, 'order' => 'petid asc'));
        foreach ($productlar as $productla) {										UV Ölçüm ve Durumu kaldırdık
            $yeni = $yeni . '<td align="center">' . $productla->value . '</td>'; // Kapalı
            //$yeni = $yeni.'<td align="center">'.$productla->value." ".$productla->petid.'</td>';  Test amaçlı veriler doğru yere geliyor mu AÇIK
        }*/
        /*if ($productlar[count($productlar) - 1]->value >= 3000) {
            $yaz = '<td> Good </td>';
        } else {
            $yaz = '<td> Bad </td>'; Kapalı olan alanlar efk monitörlerinde Uv Ölçüm ve Durumu kaldırıyor
        }*/

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
		<td colspan="10" align="center">
			<b><h2>Uçan Haşere Üniteleri Kontrol ve İçerik Listesi</h2></b>
			<br><h3>(Fly Unit Control &amp; Contents Checklist)</h3>
		</td>
	</tr>
	<tr>
		<td colspan="12">Müşteri Adı (Client Name): <b> '.$client->name.'</b></td>
	</tr>
	<tr>
		<td colspan="12">Rapor Kriterleri: '.t($monitype->name)." ".t($monitype->detailed).'</td>
	</tr>
	<tr>
		<td colspan="12">Tarih (Date): '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="12">Kontrol Eden (Kontroller) - İmza (Signature):</td>
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
