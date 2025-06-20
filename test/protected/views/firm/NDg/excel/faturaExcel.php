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
$where='c.isdelete!=1 and c.firmid='.$_POST['Report']['firm'];
if(isset($_POST['Report']['clientid']))
{
  if(!in_array(0,$_POST['Report']['clientid']))
  {
    $where.=' and cb.id in ('.implode($_POST['Report']['clientid']).')';
  }
}
if(isset($_POST['Monitoring']['date']))
{
   $where.=' and c.contractstartdate>= "'.$_POST['Monitoring']['date'].'"';
}
if(isset($_POST['Monitoring']['date1']))
{
   $where.=' and c.contractfinishdate<= "'.$_POST['Monitoring']['date1'].'"';
}

if(isset($_POST['Report']['siralama']))
{
  if($_POST['Report']['siralama']==1)
  {
    $order='c.contractfinishdate asc';
  }
  else
  {
    $order='c.name asc,cb.name';
  }
}
else{
  $order='id asc';
}
	$response=Yii::app()->db->createCommand()
		->select("c.*,cb.name as cb_name")
		->from('client cb')
		->leftJoin('client c','c.id=cb.parentid')
  	->where($where)
    ->order($order)
		->queryAll();

$veriler='';
foreach($response as $responsex)
{
  $veriler.='	<tr>
		<td colspan="2" align="center">'.$responsex['name'].'</td>
		<td colspan="2" align="center">'.$responsex['cb_name'].'</td>
	  <td colspan="2" align="center">'.$responsex['email'].'</td>
    <td colspan="1" align="center">'.$responsex['phone'].'</td>
    <td colspan="1" align="center">'.$responsex['contractstartdate'].'</td>
     <td colspan="1" align="center">'.$responsex['contractfinishdate'].'</td>
     <td colspan="1" align="center">'.$responsex['productsamount'].'</td>
     <td colspan="1" align="center">'.$responsex['iskdv'].'</td>
	</tr>';
}



$firmB=Firm::model()->findByPk($_POST['Report']['firm']);
$firm=Firm::model()->findByPk($firmB->parentid);


if($firmB->image)
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
		<td colspan="11" align="center">
			<b><h2>'.t('Fatura Kontrol Formu').'</h2></b>
		</td>
	</tr>
	<tr>
		<td colspan="11">'.t('Firma Şube Adı (Firm Branh Name)').': <b> '.$firmB->name.'</b></td>
	</tr>

	<tr>
		<td colspan="2" align="center"><b>'.t('Client Name').'</b></td>
		<td colspan="2" align="center"><b>'.t('Client Branch Name').'</b></td>
	  <td colspan="2" align="center"><b>'.t('Email').'</b></td>
    <td colspan="1" align="center"><b>'.t('Phone').'</b></td>
    <td colspan="1" align="center"><b>'.t('Start Date').'</b></td>
     <td colspan="1" align="center"><b>'.t('Finish Date').'</b></td>
     <td colspan="1" align="center"><b>'.t('Sözleşme Tutarı').'</b></td>
     <td colspan="1" align="center"><b>'.t('KDV').'</b></td>
	</tr>
</thead>
	<tbody>

	'.$veriler.'
    </tbody>
	</table></body></html>';




  exportExcel($firmB->name.' '.t('Fatura Kontrol Formu').' - '.date('Y-m-d'),$html,$replaceDotCol);
Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']);

?>
