
<?php
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$veriler="";
$sql="";
$ax= User::model()->userobjecty('');
if(isset($_POST['Report']['clientid']))
{
	if(count($_POST['Report']['clientid'])>1)
	{
	$sql=$sql. " ";
    foreach ($_POST['Report']['clientid'] as $item)
    {
        $sql= $sql."clientid=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql."";
	}
	else{
			$model=Client::model()->findByPk($_POST['Report']['clientid'][0]);
			if($model->parentid!=0)
			{
					$sql="clientid=".$_POST['Report']['clientid'][0];
			}
			else{
				$model=Client::model()->findAll(array('condition'=>'parentid='.$_POST['Report']['clientid'][0]));
				foreach ($model as $value) {

					if($ax->clientbranchid!=0){

										$return=AuthAssignment::model()->find(array('condition'=>'itemname like "%'.$value->username.'%" and userid='.$ax->id));
						if($return)
						{
						  $sql= $sql."clientid=".$value->id." or ";
						}
					}
					else
					{
						$sql= $sql."clientid=".$value->id." or ";
					}
				}
				  $sql=rtrim($sql,"or ");
			}


	}

}
$sirala='';
if(isset($_POST['Report']['siralama']) && $_POST['Report']['siralama']==2 )
{
	$sirala='u.name asc';
}
else {
	$sirala='l.date asc';
}
$workorders = Yii::app()->db->createCommand()
		->from('workorder l')
		->join('client u', 'u.id=l.clientid')
		->where(str_replace("clientid", "l.clientid",$sql))
		->order($sirala)
		->queryall();


foreach ($workorders as $workorder)
{
  $time=strtotime($workorder[date]." ".$workorder[start_time]);


  if($time >= $midnight && $time<=$midnight2)
  {
    $visitype=Visittype::model()->findByPk($workorder[visittypeid])->name;
    $rstartTime="";
    $rfinishTime="";
    if($workorder[realstarttime])
    {
        $rstartTime=date("Y-m-d - H:i",$workorder[realstarttime]);
    }
    else{
      $rstartTime="Henüz Başlanmadı.";
    }

    if($workorder[realendtime])
    {
        $rfinishTime=date("Y-m-d - H:i",$workorder[realendtime]);
    }
    else{
      $rfinishTime="Henüz Bitirilmedi.";
    }


    $veriler .= "<tr>
	  <td>".Client::model()->findByPk($workorder[clientid])->name."</td>
      <td>".$workorder[date]." - ".$workorder[start_time]."</td>
      <td>".$workorder[date]." - ".$workorder[finish_time]."</td>
      <td>".$rstartTime."</td>
      <td>".$rfinishTime."</td>
      <td>".$visitype."</td>
    </tr>";

  }
}


$clientparent=Client::model()->findByPk($_POST['Report']['client']);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);

$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($_POST['Report']['client']);
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

$branch=Firm::model()->findByPk($_POST['Conformity']['branchid']);

$clients=Client::model()->findAll(array('condition' => str_replace("clientid", "id",$sql)));

$musterisubeler="";
foreach ($clients as $item)
{
		$musterisubeler .=$item->name.", ";
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
		<td colspan="3" align="center">
			<b><h2>İş Planı Raporu <br> (Workorder Report)</h2></b>
		</td>
	</tr>
	<tr>
		<td colspan="6">Müşteri Şube (Client Name): <b> '.$branch->name.'</b></td>
	</tr>

	<tr>
		<td colspan="6">Tarih (Date): '.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'</td>
	</tr>

  <tr>
		<td colspan="6">Müşteri Şube Seçim (Client Branch Selection):'.$musterisubeler.'</td>
	</tr>


	<tr>
	<td rowspan="2" style="width:100px" align="center">Müşteri <br> (Client)</td>
	<td colspan="2" align="center" style="width:200px">Planlanma Tarihi<br> (Planning Date)</td>
  	<td colspan="2" align="center">Gerçekleşme Tarihi Tarihi <br> (Date of realization)</td>
    <td rowspan="2" colspan="1" align="center">Ziyaret Türü  <br> (Visit Type)</td>
  </tr>
  <tr>
    <td style="width:100px" align="center">Başlangıç Tarihi <br> (Starting date) </td>
    <td style="width:100px" align="center">Bitiş Tarihi <br> (End Date)</td>
    <td align="center">Başlangıç Tarihi <br> (Starting date)</td>
    <td align="center">Bitiş Tarihi <br> (End Date)</td>
	</tr>
</thead>
	<tbody>
		'.$veriler.'
		</tbody></table></body></html>';

?>
