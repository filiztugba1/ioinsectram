<?php
function exportExcel($filename='ExportExcel',$html,$replaceDotCol=array()){
    header('Content-Encoding: UTF-8');
    header('Content-Type: text/plain; charset=utf-8');
    header("Content-disposition: attachment; filename=".$filename.".xls");
    echo "\xEF\xBB\xBF"; // UTF-8 BOM

   echo $html;


}


/*
 $replaceDotCol
 Decimal kolonlardaki noktayı (.) virgüle (,) dönüştürüelecek kolon numarası belirtilmelidir.
 Örneğin; Kolon 4'ün verilerinde nokta değilde virgül görülmesini istiyorsanız
 ilgili kolonun array key numarasını belirtmelisiniz. İlk kolonun key numarası 0'dır.
*/
$replaceDotCol=array(3);


$sql="";
$pets="";
$products="";
$yeni="";
$aktiveler="";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
if($_POST['Report']['dapartmentid'] <> 0)
{
    $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
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

$monitors=Mobileworkordermonitors::model()->findAll(array('condition'=>$sql.'checkdate!=0 and monitortype='.$_POST['Monitoring']['mtypeid'].' and clientbranchid='.$_POST['Report']['clientid'].' and (checkdate between '.$midnight.' and '.$midnight2.')','order'=>' checkdate asc,monitorno asc'));
$tarihler=array();
foreach ($monitors as $monitor)
{

	if(!in_array(date("d-m-Y", $monitor->checkdate),$tarihler))
	{

		array_push($tarihler,date("d-m-Y", $monitor->checkdate));
	}

}
$veriler='';
$ccvmn='';

/*
for($i=1;$i<count($tarihler);$i++)
{
    $ccvmn = $ccvmn.'<td></td>';
}
*/
/////sorun yok\\\\\\\
$monitors=Mobileworkordermonitors::model()->findAll(array('condition'=>$sql.'checkdate!=0 and monitortype='.$_POST['Monitoring']['mtypeid'].' and clientbranchid='.$_POST['Report']['clientid'].' and isdelete=0 and (checkdate between '.$midnight.' and '.$midnight2.') group by monitorid' ,'order'=>'monitorid asc'));
foreach ($monitors as $monitor)
{
	$subdepartment=Departments::model()->findByPk($monitor->subdepartment);
	$monitoring=Monitoring::model()->find(array('condition'=>'id='.$monitor->monitorid));
	$monitoringlocation=Monitoringlocation::model()->findByPk($monitoring->mlocationid);
	$veriler= $veriler .'<tr>
		<td align="center">'.$monitor->monitorno.'</td>
		<td align="center" colspan="2">'.t($monitoringlocation->detailed).' ('.t($monitoringlocation->name).')'.'</td>
		<td align="center">'.t('RM').'</td>
		<td align="left" colspan="2">'.t($subdepartment->name).'</td>';
	$reports=Mobileworkorderdata::model()->findAll(array('condition'=>'isproduct=0 and  workorderid='.$monitor->workorderid.' and mobileworkordermonitorsid='.$monitor->id.' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'petid desc'));

	///////////////////////////////////start////////////////
foreach($tarihler as $tarih)
	{
		$bilgiler='';
		$tarihbasla=strtotime($tarih);
		$tarihbiti=($tarihbasla+(3600*24)) - 1;
		$dataverim=Mobileworkorderdata::model()->findall(array('condition'=>'(isproduct=0 or petid=48 or petid=49 )  and monitorid='.$monitor->monitorid.' and monitortype='.$monitor->monitortype.' and (openedtimeend between '.$tarihbasla.' and '.$tarihbiti.')'));
		$durum=2;
		foreach ($dataverim as $dataveri)
		{
			/////////////// bu tarihte bu monitör tipinde ve bu monitör numarasında veri varsa \\\\\

			if($dataveri->value<>0)
			{
				$durum=1;
				$petno=$dataveri->petid;
				$verim=$dataveri->value;
				break;
			}else
			{
				$durum=0;
			}

		}
			if($durum==0)
			{
				$bilgiler = $bilgiler.'<td align="center">O'.'</td>';
			}
			else if($durum==1)
			{
				$canli='O';
				$heyvan=Pets::model()->findBypk($petno);
				if($petno==37){ $canli=t("M");}
				if($petno==38){ $canli=t("R");}
				if($petno==25){ $canli=t("D");}
				if($petno==48){ $canli=t("B");}
				if($petno==49){
					if ($verim==1){
					$canli=t("KYK");
					}

					if ($verim==2){
					$canli=t("KK");
					}

					if ($verim==3){
					$canli=t("N/A");
					}


					}
				if($petno==27 || $petno==26 || $petno==31){ $canli=t("I");}
				$bilgiler = $bilgiler.'<td align="center"><b>'.$canli.'</b></td>';
				//break;
			}	else if($durum==2)
			{
				$bilgiler = $bilgiler.'<td align="center">-</td>';
			}

			/////////////// bu tarihte bu monitör tipinde ve bu monitör numarasında veri varsa \\\\\


	$veriler= $veriler.$bilgiler;
	}
	$veriler= $veriler.$ccvmn;
}
	$veriler= 	$veriler.'</tr>' ;
/*foreach($tarihler as $item)
{
	 $aktiveler=$aktiveler.'<td>'.$item.'</td>';
}
*/

for($i=0;$i<count($tarihler);$i++)
{
	$aktiveler = $aktiveler.'<td>.'.$tarihler[$i].'</td>';
}


$clientparent=Client::model()->findByPk($_POST['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$client=Client::model()->findByPk($_POST['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);

if($clientparent->image)
{
	$resim=$clientparent->image;
}
else{
	$resim="/images/nophoto.png";
}
$ektd='';
if(count($tarihler)>8)
{
$sayi=count($tarihler)-8;

for($i=0;$i<$sayi;$i++)
	{
$ektd=$ektd.' <td width="50">'.t('Tarih - Date').'</td>';
}
}
$html='
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>
<style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
font-size:12pt;
}
td {
font-family:Arial;
font-size:10pt;
}
</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td width="100" align="center" rowspan="7" colspan="5">
            <img src="'.$resim.'" border="0" width="75px">
        </td>
        <td rowspan="7" colspan="5" align="center">
          '.t('  <b><h2>Kemirgenler İçin Monitör Yerleşim Listesi</h2></b>
            <br><h3>(Location List For Rodent and Insect Monitoring Points)</h3>').'
        </td>
        <td colspan="'.($sayi+4).'" width="200">'.t('Location Of Monitor - Monitör Yeri').'</td>
    </tr>
    <tr>
        <td>'.t('O').'</td>
        <td colspan="'.($sayi+3).'">'.t('Dış Alan Gözlem Noktası (Outdoor)').'</td>
    </tr>
    <tr>
        <td>'.t('I').'</td>
        <td colspan="'.($sayi+3).'">'.t('İç Alan Gözlem Noktası (Indoor)').'</td>
    </tr>
    <tr>
        <td colspan="'.($sayi+4).'">'.t('Type of Monitor').'</td>
    </tr>

    <tr>
        <td>'.t('RM').'</td>
        <td colspan="'.($sayi+3).'">'.t('Kemirgen Monitorü (Rodent Monitor)').'</td>
    </tr>

    <tr>
        <td>'.t('MT').'</td>
        <td colspan="'.($sayi+3).'">'.t('Güve Tuzağı (Moth Trap)').'</td>
    </tr>
    <tr>
        <td colspan="'.($sayi+4).'">'.t('Monitör Durumu - Condition of Monitor').'</td>
    </tr>
    <tr>
        <td rowspan="5" colspan="10" class="f12">'.t('Müşteri Adı (Client Name)').':<b> '.$client->name.'</b></td>
        <td>O</td>
        <td colspan="'.($sayi+3).'">'.t('Tüketim Yok (No Consumption)').'</td>
    </tr>
    <tr>
        <td colspan="2">'.t('R: Sıçan (rattus)').'</td>
        <td colspan="'.($sayi+2).'">'.t('M: Fare (Mouse)').'</td>
    </tr>
    <tr>
        <td colspan="2">'.t('I: Böcek (Insect)').'</td>
        <td colspan="'.($sayi+2).'">'.t('D: Diğer (Other)').'</td>
    </tr>
    <tr>
        <td>'.t('B').'</td>
        <td colspan="'.($sayi+3).'">'.t('Bozulmuş Yem').'</td>
    </tr>

	<tr>
        <td>-</td>
        <td colspan="'.($sayi+3).'">'.t('Kontrol Edilmedi').'</td>
    </tr>

    <tr>
        <td rowspan="3" colspan="10"> '.t('İmza').': </td>
        <td>'.t('N/A').'</td>
        <td colspan="'.($sayi+3).'">'.t('Ulaşılamadı (Not-Approachable)').'</td>
    </tr>
    <tr>
        <td>'.t('KK').'</td>
        <td colspan="'.($sayi+3).'">'.t('Kutu Kırık (Broken Box)').'</td>
    </tr>
    <tr>
        <td>'.t('KYK').'</td>
        <td colspan="'.($sayi+3).'">'.t('Kutu Kayıp (Lost Box)').'</td>
    </tr>
    <tr>
        <td rowspan="3" width="20" align="center">'.t('Conformity Number').'</td>
        <td rowspan="3" colspan="2" width="20" align="center">'.t('Yeri<br>(Location)').'</td>
        <td rowspan="3" width="30" align="center">'.t('Tipi<br>(Type)').'</td>
        <td rowspan="3" colspan="2">'.t('Bölüm Adı<br>(Area Name)').'</td>
        <td colspan="'.($sayi+8).'" align="center">'.t('Aktivite Durumu (Condition Of Activity)').'</td>
    </tr>
    <tr>

        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>'.$ektd.'
    </tr>
    <tr>
        '.$aktiveler.'


    </tr>
    </thead>
    <tbody>

    '.$veriler.'


    </tbody>
</table>
</body>
</html>

 ';

exportExcel(t('Hasere kontrol formu'),$html,$replaceDotCol);
 Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']);


?>
