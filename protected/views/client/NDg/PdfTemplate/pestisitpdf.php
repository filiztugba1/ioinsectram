<?
$replaceDotCol=array(3);


$ax= User::model()->userobjecty('');
		$response=Yii::app()->db->createCommand()
		->select('w.date,vt.name,sr.reportno,COALESCE(skk.kimyasaladi, ai.trade_name) kimyasaladi,COALESCE(skk.aktifmaddetanimi, ai.active_ingredient) aktifmaddetanimi,ai.amount_applied,IF(skk.urunAmbajBirimi=0,"Adet",
                                                                                           IF(skk.urunAmbajBirimi=1,"gr",
                                                                                             IF(skk.urunAmbajBirimi=2,"ml",
                                                                                               IF(skk.urunAmbajBirimi=3,"gr",
                                                                                                 IF(skk.urunAmbajBirimi=4,"ml",""))))) birim,skk.urunAmbajBirimi,
                                                                                                 sr.technician_sign,
                                                                                                 sr.client_sign')
		->from('workorder w')
		->leftJoin('activeingredients ai','ai.workorderid=w.id')
		->leftJoin('servicereport sr','sr.reportno=w.id')
		->leftJoin('stokkimyasalkullanim skk','skk.id =ai.tradeId')
		->leftJoin('visittype vt','vt.id=w.visittypeid')
		->where('ai.amount_applied is not null and w.clientid='.$_POST['Report']['clientid']);
		 if($_POST['Monitoring']['date'])
		 {
			 $response=$response->andwhere('sr.date>='.strtotime($_POST['Monitoring']['date'].' 00:00:00'));
		 }
		 if($_POST['Monitoring']['date1'])
		 {
			 $response=$response->andwhere('sr.date<='.strtotime($_POST['Monitoring']['date1'].' 23:59:59'));
		 }
		
       $response=$response->order("CONCAT(ai.trade_name,ai.active_ingredient) asc,sr.date asc")->queryAll();
$datam=[];
$Datedatam=[];
$dateBoyut=0;
$titleBoyut1=10;
$titleBoyut2=10;


$list='';
		foreach($response as $responsex)
		{
			 $list.='<tr>'.
				'<td colspan="1">'.$responsex['date'].'</td>'.
				'<td colspan="1">'.$responsex['name'].'</td>'.
				'<td colspan="1">'.$responsex['reportno'].'</td>'.
				'<td colspan="2">'.$responsex['kimyasaladi'].'</td>'.
				'<td colspan="2">'.$responsex['aktifmaddetanimi'].'</td>'.
				'<td colspan="1">'.$responsex['amount_applied'].' '.t($responsex['birim']).'</td>'.
				($responsex['client_sign']==""?'<td></td>':'<td colspan="1"><img src="'.$responsex['client_sign'].'" border="0" width="75px"/></td>').
				($responsex['technician_sign']==""?'<td></td>':'<td colspan="1"><img src="'.$responsex['technician_sign'].'" border="0" width="75px"/></td>').
			'</tr>';
			
		}
    


		


$clientparent=Client::model()->findByPk($_POST['Report']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($_POST['Report']['clientid']);
$monitype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);
if($firm->image)
{
    $resim='/'.$firm->image;
}
else if($clientparent->image)
{
	$resim='/'.$clientparent->image;
}
else{
	$resim="/images/nophoto.png";
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
	<td colspan="10" align="center">
	<b>'.t('Pesticides Logs').'</b>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<b>'.t('Client Branch').'</b>
	</td>
	<td colspan="8">
		'.$client->name.'
	</td>
	</tr>
	
		<tr>
	<td colspan="2">
	<b>'.t('Date').'</b>
	</td>
	<td colspan="8">
		'.$_POST['Monitoring']['date'].' / '.$_POST['Monitoring']['date1'].'
	</td>
	</tr>
	
	
	
	<tr>
		<td colspan="1"><b>'.t('Date').'</b> </td>
		<td colspan="1"><b>'.t('Ziyaret Tipi').'</b></td>
		<td colspan="1"><b>'.t('Ziyaret Rapor No').'</b></td>
		<td colspan="2"><b>'.t('Kullanılan Pestisit-Rodentisit Türü').'</b></td>
		<td colspan="2"><b>'.t('Aktif Maddesi').'</b></td>
		<td colspan="1"><b>'.t('Kullanılan Miktar').'</b></td>
		<td colspan="1"><b>'.t('Client Sign').'</b></td>
		<td colspan="1"><b>'.t('Techinician Sign').'</b></td>
	</tr>
    </thead>
    <tbody>
		'.$list.'

    </tbody>
</table>
</body>
</html>
 ';


 Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']);


?>
