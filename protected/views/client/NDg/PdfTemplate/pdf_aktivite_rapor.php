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

for($i=0;$i<count($aylar);$i++)
{
				$yaz .="
			<tr>
				<td colspan='2'>".str_replace("'", "", $aylar[$i])."</td>
				 <td colspan='2'>".$rm[$i]."</td>
				 <td colspan='2'>".$lt[$i]."</td>
	       <td colspan='2'>".$mt[$i]."</td>
				 <td colspan='2'>".$cl[$i]."</td>
         <td colspan='2'>".$lft[$i]."</td>
	   </tr>";
}
$yaz .="
<tr>
<td colspan='2'>".t('Toplam')."</td>
 <td colspan='2'>".$rmToplam."</td>
 <td colspan='2'>".$ltToplam."</td>
 <td colspan='2'>".$mtToplam."</td>
 <td colspan='2'>".$clToplam."</td>
 <td colspan='2'>".$lftToplam."</td>
</tr>";

$yaz .="
<tr>
<td colspan='2'>".t('Genel Toplam')."</td>
 <td colspan='2'>".$genelToplam."</td>
 <td colspan='2'></td>
 <td colspan='2'></td>
 <td colspan='2'></td>
 <td colspan='2'></td>
</tr>";
$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$rmImage."'/></td>
 <td style='border:none;' colspan='6'><img width='100%' src='".$ltImage."'/></td>
</tr>";
$yaz2 .="

<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$mtImage."'/></td>
 <td style='border:none;' colspan='6'><img width='100%' src='".$clImage."'/></td>
</tr>";
$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$lftImage."'/></td>
 <td style='border:none;' colspan='6'></td>
</tr>";

/*<meta http-equiv="Content-Type" content="text/html; charset=utf-8">*/
$clientparent=Client::model()->findByPk($_POST['Reports']['clientid']);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$firmbranch=Firm::model()->findByPk($clientparent->firmid);
$firm=Firm::model()->find(array("condition"=>"id=".$firmbranch->parentid));
$client=Client::model()->findByPk($_POST['Reports']['clientid']);
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
          		<td width='100' align='center' colspan='2'>
              <img src='".Yii::app()->getbaseUrl(true)."/".$resim."' width='95px'  >
          		</td>
          		<td colspan='10' align='center'>
          			<b><h2>".t('Aktivite Miktarı Rapor-Grafik')."</h2></b>
                	<br><h3>".$client->name." - ".$tarihAraligi."</h3>
          		</td>
          	</tr>
              <tr>
							      <th colspan='2'>".$yil."</th>
							      <th colspan='2'>".t('RM-DIŞ ALAN KEMİRGEN')."</th>
                    <th colspan='2'>".t('LT-İÇ ALAN KEMRİGEN')."</th>
                    <th colspan='2'>".t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI')."</th>
                    <th colspan='2'>".t('CI-YÜRÜYEN HEŞERE')."</th>
                    <th colspan='2'>".t('LFT-UÇAN HAŞERE')."</th>
              </tr>
            </thead>
          <tbody>
            ".$yaz."

            </tbody>
        </table>

        <table border='0'  width='100%' cellpadding='0' cellspacing='0' style='margin-top:100px'>

                  <tbody>
                    ".$yaz2."
                     <tr>
              </tr>
                    </tbody>
                </table>
                <br><br>
                <b>".t('Açıklama')."</b>:".$description."
                ";

?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>