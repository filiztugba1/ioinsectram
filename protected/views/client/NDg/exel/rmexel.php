


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
$mtypesxt='';    
$dep=empty($_POST['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($_POST['Report']['dapartmentid']);
$sub=empty($_POST['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($_POST['Monitoring']['subid']);
if(!in_array("0",$dep))
{
    $sql= $sql." departmentid in (".implode(",",$dep).") and ";
}
if(!in_array("0",$sub))
{
	if(count($sub)>1)
	{
	$sql=$sql. " (";
    foreach ($sub as $item)
    {
        $sql= $sql."subdepartment=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
	else{
		  $sql= $sql."subdepartment=".$sub[0]." and ";
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



$veriler='';
$ccvmn='';

$monitortype='('.$_POST['Monitoring']['mtypeid'].')';
if(intval($_POST['Monitoring']['mtypeid'])==-100)
{
	$monitortype='(24,25,26,33,32,31)';
}

$monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype in '.$monitortype.' and (checkdate between '.$midnight.' and '.$midnight2.') group by checkdate','order'=>'timestamp asc,monitorno asc'));

$tarihler=array();
$visittype=array();
foreach ($monitors as $monitor)
{
	if(!in_array(date("d-m-Y", $monitor->checkdate),$tarihler))
	{

	//	array_push($tarihler,date("d-m-Y", $monitor->checkdate));
	$datem=date("d-m-Y", $monitor->checkdate);
	$datem2=date("Y-m-d", $monitor->checkdate);
		$tarihler[$datem]= $monitor->workorderid;
		$isFollowOrCheck=Workorder::model()->find(array('select'=>'visittypeid','condition'=>'visittypeid in (31,26) and clientid='.$_POST['Report']['clientid'].' and date="'.$datem2.'"'));
		
		$visittype[$datem]=isset($isFollowOrCheck->visittypeid)?$isFollowOrCheck->visittypeid:0;
    if (count($tarihler)==8)
    {
      break;
    }
	}
}

for($i=1;$i<9-count($tarihler);$i++)
{
  $ccvmn = $ccvmn.'<td></td>';
}
$monitors=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype in '.$monitortype.' and (checkdate between '.$midnight.' and '.$midnight2.') group by monitorid','order'=>'monitorno asc'));
$monitorsdate=WorkorderreportsView::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>'(isproduct=0 or petid=48 or petid=49 ) and clientbranchid='.$_POST['Report']['clientid'].' and monitortype in '.$monitortype.' and (checkdate between '.$midnight.' and '.$midnight2.') and (isproduct=0 or petid=48 or petid=49 )'));

foreach ($monitors as $monitor)
{
  $monitoringlocation=Monitoringlocation::model()->findByPk($monitoring->mlocationid);
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
      $bolum=$bolum.' N/S '.$monitor->definationlocation;
  }


$monitype=Monitoringtype::model()->findByPk($monitor->monitortype);
  $veriler= $veriler .'<tr>
    <td align="center">'.$monitor->monitorno.'</td>
    <td align="center">'.t($monitor->detailed).' ('.t($monitor->name).')'.'</td>
    <td align="center">'.t($monitype->name).'</td>
	'.($monitor->firmid!==412?'<td width="30" align="center">'.$monitor->definationlocation.'</td>':'').'
    <td align="left" colspan="2">'.$bolum.'</td>';

    foreach($tarihler as $tarih=>$wkn)
    {
	
      $bilgiler='';
      $tarihbasla=strtotime($tarih);
      $tarihbiti=($tarihbasla+(3600*24)) - 1;
      $durum=2;
      $petno=0;
    foreach($monitorsdate as $monitorsdatex)
    {

      if($monitorsdatex->openedtimeend>=$tarihbasla && $monitorsdatex->openedtimeend<=$tarihbiti && $monitorsdatex->monitorid==$monitor->monitorid)
      {
          if($monitorsdatex->value<>0)
          {
            $durum=1;
            $petno=$monitorsdatex->petid;
            $verim=$monitorsdatex->value;
            break;
          }else
          {
            $durum=0;
          }
        }

      }
      if($durum==0)
			{
				$bilgiler = $bilgiler.'<td align="center">O'.'</td>';
			}
			else if($durum==1)
			{
				$canli='Ot';
				$heyvan=Pets::model()->findBypk($petno);
				if($petno==37){ $canli='<span style="color:red;">M</span>';}
				if($petno==38){ $canli='<span style="color:red;">R</span>';}
				if($petno==25){ $canli=t("Ot");}
				if($petno==48){ $canli="B";}
				if($petno==49){
					if ($verim==1){
					$canli="KYK";
					}

					if ($verim==2){
					$canli="KK";
					}

					if ($verim==3){
					$canli="N/A";
					}


					}
				if($petno==27 || $petno==26 || $petno==31){ $canli="I";}
				$bilgiler = $bilgiler.'<td align="center" ><b>'.$canli.'</b></td>';
				//break;
			}	else if($durum==2)
			{
				$bilgiler = $bilgiler.'<td align="center">N/S</td>';
			}


        $veriler= $veriler.$bilgiler;
			
    }


        $veriler= $veriler.$ccvmn;
    }
    $veriler= 	$veriler.'</tr>' ;
  foreach($tarihler as $item=>$wkn)
  {
  	 $aktiveler=$aktiveler.'<td>'.$item.($visittype[$item]!=0?($visittype[$item]==31?' </br>'.t('Follow Up'):' </br>'.t('Call Out')):'').'</td>';
	// var_dump($visittype);
  }
  
 // exit;
  for($i=1;$i<9-count($tarihler);$i++)
  {
  	$aktiveler = $aktiveler.'<td></td>';
		
 // $mtypesxt.='<td width="50">'.t('Tarih - Date').$wkn.'</td>';
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
        <td width="100" align="center" rowspan="7" colspan="4">
            <img src="'.$resim.'" border="0" width="75px">
        </td>
        <td rowspan="7" colspan="'.($firm->id!==412?6:5).'" align="center">
               <b><h2>'.t('Kemirgenler İçin Monitör Yerleşim Listesi').'</h2></b>
        </td>
        <td colspan="4" width="200">'.t('Location Of Monitor - Monitör Yeri').'</td>
    </tr>
    <tr>
        <td>O</td>
        <td colspan="3">'.t('Dış Alan Gözlem Noktası (Outdoor)').'</td>
    </tr>
    <tr>
        <td>I</td>
        <td colspan="3">'.t('İç Alan Gözlem Noktası (Indoor)').'</td>
    </tr>
    <tr>
        <td colspan="4">'.t("Type of Monitor").'</td>
    </tr>

    <tr>
        <td>RM</td>
        <td colspan="3">'.t('Kemirgen Monitorü (Rodent Monitor)').'</td>
    </tr>

    <tr>
        <td>LT</td>
        <td colspan="3">'.t('Canlı Yakalama (Live Trap)').'</td>
    </tr>
    <tr>
        <td colspan="4">'.t('Monitör Durumu - Condition of Monitor').'</td>
    </tr>
    <tr>
        <td rowspan="5" colspan="'.($firm->id!==412?10:9).'" class="f12">'.t('Müşteri Adı (Client Name)').':<b> '.$client->name.'</b></td>
        <td>O</td>
        <td colspan="3">'.t('Tüketim Yok (No Consumption)').'</td>
    </tr>
    <tr>
        <td colspan="2">'.t('R: Sıçan (rattus)').'</td>
        <td colspan="2">'.t('M: Fare (Mouse)').'</td>
    </tr>
    <tr>
    <td colspan="2">'.t('D: Diğer (Other)').'</td>
   <td colspan="2"></td>
    </tr>
    <tr>
        <td>B</td>
        <td colspan="3">'.t('Bozulmuş Yem').'</td>
    </tr>

	<tr>
        <td>N/S</td>
        <td colspan="3">'.t('Kontrol Edilmedi').'</td>
    </tr>

    <tr>
        <td rowspan="3" colspan="'.($firm->id!==412?10:9).'"> '.t('İmza').': </td>
        <td>N/A</td>
        <td colspan="3">'.t('Ulaşılamadı (Not-Approachable)').'</td>
    </tr>
    <tr>
        <td>KK</td>
        <td colspan="3">'.t('Kutu Kırık (Broken Box)').'</td>
    </tr>
    <tr>
        <td>KYK</td>
        <td colspan="3">'.t('Kutu Kayıp (Lost Box)').'</td>
    </tr>
    <tr>
        <td rowspan="3" width="20" align="center">No</td>
        <td rowspan="3" width="20" align="center">'.t('Yeri<br>(Location)').'</td>
        <td rowspan="3" width="30" align="center">'.t('Tipi<br>(Type)').'</td>
		'.($firm->id!==412?'<td rowspan="3" width="30" align="center">'.t('D.LOCATION').'</td>':'').'
        <td rowspan="3" colspan="2">'.t('Bölüm Adı<br>(Area Name)').'</td>
        <td colspan="8" align="center">'.t('Aktivite Durumu (Condition Of Activity)').'</td>
    </tr>
    <tr>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
        <td width="50">'.t('Tarih - Date').'</td>
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

