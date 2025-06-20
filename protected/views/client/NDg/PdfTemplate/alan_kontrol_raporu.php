<?php
$aylar=explode(',',$_POST['aylar']);
$rm=explode(',',$_POST['rm']);
$lt=explode(',',$_POST['lt']);
$mt=explode(',',$_POST['mt']);
$cl=explode(',',$_POST['cl']);
$lft=explode(',',$_POST['lft']);
$rmToplam=$_POST['rmToplam'];
$ltToplam=$_POST['ltToplam'];
$mtToplam=$_POST['mtToplam'];
$clToplam=$_POST['clToplam'];
$lftToplam=$_POST['lftToplam'];
$genelToplam=$_POST['genelToplam'];
$rmImage=$_POST['rmImage'];
$ltImage=$_POST['ltImage'];
$mtImage=$_POST['mtImage'];
$clImage=$_POST['clImage'];
$lftImage=$_POST['lftImage'];
$yil=$_POST['yil'];
$description=$_POST['description'];
$tarihAraligi=$_POST['tarihAraligi'];
$yaz='';
$yaz2='';
$client=Client::model()->findByPk($_POST['Reports']['clientid']);
$dep=empty($_POST['Report']['dapartmentid'])?["0"]:Client::model()->objectToArray($_POST['Report']['dapartmentid']);
$sub=empty($_POST['Monitoring']['subid'])?["0"]:Client::model()->objectToArray($_POST['Monitoring']['subid']);



	$response=Yii::app()->db->createCommand()
		->select('m.mno,d.name dep,sd.name sdep,DATE_FORMAT(FROM_UNIXTIME(mwm.checkdate), "%d-%m-%Y") datex,DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(mwm.checkdate), INTERVAL 1 HOUR), "%H:%i") timex,IF(mwd.activate=0,"Aktivite Yok",
		IF(mwd.activate=1,"Az",IF(mwd.activate=2,"Orta","Yoğun"))) activate,pt.name petname')
		->from('mobileworkorderdata mwd')
		->leftJoin('mobileworkordermonitors mwm','mwm.id=mwd.mobileworkordermonitorsid')
		->leftJoin('monitoringtype mt','mt.id=mwd.monitortype')
		->leftJoin('workorder w','w.id=mwd.workorderid')
		->leftJoin('departments d','d.id=mwd.departmentid')
		->leftJoin('departments sd','sd.id=mwd.subdepartmentid')
		->leftJoin('monitoring m','m.id=mwd.monitorid')
		->leftJoin('pets pt','pt.id=mwd.petid');
     $sql='w.firmid is not null and w.firmid>0 and mwd.clientbranchid='.$_POST['Report']['clientid'];
	 
	 
		
		if(!in_array("0",$dep))
		{
			$sql= $sql." departmentid in (".implode(",",$dep).") and ";
		}
		if(!in_array("0",$sub))
		{
			if(count($sub)>1)
			{
			$sql=$sql. " and (";
			foreach ($sub as $item)
			{
				$sql= $sql."subdepartment=".$item." or ";
			}
			$sql=rtrim($sql,"or ");
			$sql= $sql.")  ";
			}
			else{
				  $sql= $sql." and subdepartment=".$sub[0]."  ";
			}
		}

		if(isset($_POST["Monitoring"]["monitors"]))
		{
			if(count($_POST['Monitoring']['monitors'])>1)
			{
			$sql=$sql. " and (";
			foreach ($_POST['Monitoring']['monitors'] as $item)
			{
				$sql= $sql."monitorid=".$item." or ";
			}
			$sql=rtrim($sql,"or ");
			$sql= $sql.")  ";
			}
			else{
				  $sql= $sql."and monitorid=".$_POST['Monitoring']['monitors'][0]." ";
			}
		}
		
		
		 	if(isset($_POST['Monitoring']['date']) && $_POST['Monitoring']['date']!='')
		{
			$sql.=' and mwm.checkdate>="'.strtotime($_POST['Monitoring']['date'].' 00:00:00').'"  ';
		}

		if(isset($_POST['Monitoring']['date1']) && $_POST['Monitoring']['date1']!='')
		{
			$sql.=' and mwm.checkdate<="'.strtotime($_POST['Monitoring']['date1'].' 23:59:59').'"  ';
		}
        $sql= $sql.' and mt.id='.$_POST['Monitoring']['mtypeid'];
		
		$responseMonitor=$response->where($sql)->group('m.mno,d.name,sd.name,DATE_FORMAT(FROM_UNIXTIME(mwm.checkdate), "%d-%m-%Y"),mwd.activate')->order('mwm.checkdate asc,m.mno asc')->queryAll();
	
		$res='';
		$date='';
		for($i=0;$i<count($responseMonitor);$i++)
		{
			if($_POST['Monitoring']['date']!==$_POST['Monitoring']['date1'] && $date!==$responseMonitor[$i]['datex'])
			{
				$res.="<tr>
					<td width='100' colspan='12' bgcolor='#c3c3c3' align='center'>
						".$responseMonitor[$i]['datex']."
					</td>
				</tr>";
			}
			$date=$responseMonitor[$i]['datex'];
				$res.="<tr>
					<td width='100' colspan='1'>
						".$responseMonitor[$i]['mno']."
					</td>
					<td colspan='3'>
						".$responseMonitor[$i]['dep']."
					</td>
					<td colspan='3'>
						".$responseMonitor[$i]['sdep']."
					</td>
					<td colspan='2'>
						".$responseMonitor[$i]['timex']."
					</td>
					<td colspan='3'>
						".$responseMonitor[$i]['activate']."
					</td>
					
				</tr>";
		}
	
		
		
/*<meta http-equiv="Content-Type" content="text/html; charset=utf-8">*/
$clientparent=Client::model()->findByPk($_POST['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($_POST['Report']['clientid']);
if($firm->image)
{
    $resim=$firm->image;
}
else if($clientparent->image)
{
	$resim=$clientparent->image;
}
else{

	$resim="images/nophoto.png";
}
 $html="<html><head></head><body><style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
}
td {
font-family:Arial;
}
</style><table border='0'  width='100%' cellpadding='0' cellspacing='0'>
            <thead>
            <tr>
          		<td width='100' align='center' colspan='4'>
              <img src='".Yii::app()->getbaseUrl(true)."/".$resim."' width='95px'  >
          		</td>
          		<td colspan='8' align='center'>
          			<b><h2>".t('ALAN KONTROL RAPORU')."</h2></b>
          		</td>
          	</tr>
			 <tr>
          		<td width='100' colspan='4'>
					Müşteri Tanımı
          		</td>
          		<td colspan='8'>
          			".$client->name."
          		</td>
          	</tr>
			<tr>
          		<td width='100' colspan='4'>
					Tarih
          		</td>
          		<td colspan='8'>
          			".($_POST['Monitoring']['date']==$_POST['Monitoring']['date1']?date('d-m-Y',strtotime($_POST['Monitoring']['date'])):date('d-m-Y',strtotime($_POST['Monitoring']['date'])).' - '.date('d-m-Y',strtotime($_POST['Monitoring']['date1'])))."
          		</td>
          	</tr>
			<tr>
          		<td width='100' colspan='4'>
					Uygulayıcı Adları
          		</td>
          		<td colspan='8'>
          			".$firmbranch->name."
          		</td>
          	</tr>
			
            </thead>
			<tbody>
				<tr>
					<td width='100' colspan='1'>
						Monitör No
					</td>
					<td colspan='3'>
						Bölüm Tanımı
					</td>
					<td colspan='3'>
						Alt Bölüm Tanımı
					</td>
					<td colspan='2'>
						Uygulama Saati
					</td>
					<td colspan='3'>
						Aktivite
					</td>
					
				</tr>
				
				".$res."
			
			</tbody>
        </table>";

?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>