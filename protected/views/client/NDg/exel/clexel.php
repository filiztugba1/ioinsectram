<?

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


//echo $type= $_POST['Report']['type'].'<br>';
$sql="";
$pets="";
$products="";
$kriterler="";
// $_POST['Report']['dapartmentid'] department id
// $_POST['Monitoring']['subid'] subdepartment id
// var_dump($_POST['Monitoring']['monitors'])  monitors id array
$monitorpettypes=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid'],'order'=>'petsid desc'));
$colspan=count($monitorpettypes);
foreach ($monitorpettypes as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'isproduct=0 and id!=25 and id='.$monitorpettype->petsid));
    if($pet)
    {
        $pets= $pets .'<td colspan="1" align="center">'.t($pet->name).'</td>';
        //$pets= $pets .'<td align="center">'.$pet->name." ".$pet->id.'</td>'; Test için aç
    }
}
	$pets= $pets.'<td align="center">'.t('Other').'</td>';
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];



$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);


// $_POST['Monitoring']['date'] Başlangıç time
// $_POST['Monitoring']['date1'] Bitiş time
/*if($_POST['Monitoring']['mtypeid'])
{
    $sql= $sql ." monitortype=".$_POST['Monitoring']['mtypeid']." and ";
}*/
if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'] <> 0)
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));

    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. ",";
    }
    /*if($kriterler!="")
    {
      $kriterler .=$kriterler. " - ";
    }
    */
  }
}
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
$monitors=Mobileworkordermonitors::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'timestamp asc, monitorno asc'));
$bfrdate=date("Y-m-d",$monitors[0]->checkdate);
$veriler = $veriler. '
            <tr >
			<td style="background-color:gray;" align="center" colspan="8">'.$bfrdate.'</td>
			</tr>
        ';

foreach ($monitors as $monitor)
{

        if ($bfrdate != date("Y-m-d",$monitor->checkdate))
        {
            $veriler = $veriler. '
            <tr >
			<td style="background-color:gray;" align="center" colspan="8">'.date("Y-m-d",$monitor->checkdate).'</td>
			</tr>
        ';
        }
        $bfrdate=date("Y-m-d",$monitor->checkdate);
        $subdepartment=Departments::model()->findByPk($monitor->subdepartment);
		 $reportx = Mobileworkorderdata::model()->find(array('condition' => 'isproduct=1 and petid=49 and mobileworkordermonitorsid=' . $monitor->id, 'order' => 'petid desc'));
		 $yazdurum=" - ";
		 if($reportx)
		{
			 if($reportx->value==1){ $yazdurum=t("KYK"); }
			 if($reportx->value==2){ $yazdurum=t("KK"); }
			 if($reportx->value==3){ $yazdurum=t("N/A"); }
		}
        $veriler= $veriler .'
    <tr>
			<td colspan="1" align="center">'.$monitor->monitorno.'</td>
			<td colspan="2" align="left">'.$monitor->departmentname.' - '.$subdepartment->name.'</td>
			<td colspan="1" align="center" width="50px">'.$yazdurum.'</td>';
        $reports=Mobileworkorderdata::model()->findAll(array('condition'=>'isproduct=0 and petid!=25 and mobileworkordermonitorsid='.$monitor->id.' and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'petid desc'));
        foreach ($reports as $report)
        {
            $veriler = $veriler.'<td colspan="1" align="center">'.$report->value.'</td>';
            //$veriler = $veriler.'<td align="center">'.$report->value." ".$report->petid.'</td>'; Test için aç
        }
		$reports=Mobileworkorderdata::model()->findAll(array('condition'=>'isproduct=0 and petid=25 and mobileworkordermonitorsid='.$monitor->id.' and monitortype='.$_POST['Monitoring']['mtypeid']));
		 foreach ($reports as $report)
        {
			$veriler = $veriler.'<td colspan="1" align="center">'.$report->value.'</td>';
		}

        $veriler= $veriler .  '</tr>';


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
$html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body><style>
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
		<td width="100" align="center" colspan="2">
			 <img src="'.$resim.'" border="0" width="75px">
		</td>
		<td colspan="6" align="center">
			<b><h2>'.t('Haşere Kontrol Formu').'</h2></b>
			<br><h3>'.t('(Böcekler)').'</h3>
		</td>
	</tr>
	<tr>
		<td colspan="8">'.t('Müşteri Adı (Client Name)').': <b> '.$client->name.'</b></td>
	</tr>
	<tr>
		<td colspan="8">'.t('Rapor Kriterleri').': '.$monitype->name." ".$monitype->detailed.'  <br> '.$kriterler.'</td>
	</tr>
	<tr>
		<td colspan="8">'.t('Tarih (Date)').': '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>
	<tr>
		<td colspan="8">'.t('Kontrol Eden (Kontroller) - İmza (Signature)').':</td>
	</tr>

	<tr>
		<td colspan="1" align="center">'.t('Conformity Number').'</td>
		<td colspan="2" align="center">'.t('Cihazın Bulunduğu Yer<br>(Location)').'</td>

		<td colspan="1" >'.t('Cihazın Durumu<br>(Type)').'</td>
		'.$pets.'
	</tr>
</thead>
	<tbody>

	'.$veriler.'
    </tbody>
	</table></body></html>';




  exportExcel(t('Hasere kontrol formu'),$html,$replaceDotCol);
Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']);

?>
