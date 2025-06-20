<?php
$aylar=explode(',',$_POST['aylar']);
$xlure=explode(',',$_POST['xlure']);
$rm_i=explode(',',$_POST['rm_i']);
$rm_o=explode(',',$_POST['rm_o']);
$lt=explode(',',$_POST['lt']);
$rmlat=explode(',',$_POST['rmlat']);
$rm_snap=explode(',',$_POST['rm_snap']);
$id=explode(',',$_POST['id']);
$efk=explode(',',$_POST['efk']);
$ml=explode(',',$_POST['ml']);
$wp=explode(',',$_POST['wp']);
$xlureTop=$_POST['xlureTop'];
$rm_i_Top=$_POST['rm_i_Top'];
$rm_o_Top=$_POST['rm_o_Top'];
$lt_Top=$_POST['lt_Top'];
$rmlat_Top=$_POST['rmlat_Top'];
$rm_snapTop=$_POST['rm_snapTop'];
$idTop=$_POST['idTop'];
$efkTop=$_POST['efkTop'];
$mlTop=$_POST['mlTop'];
$wpTop=$_POST['wpTop'];
$genelToplam=$_POST['genelToplam'];
$xlureImage=$_POST['xlureImage'];
$rm_iImage=$_POST['rm_iImage'];
$rm_oImage=$_POST['rm_oImage'];
$ltImage=$_POST['ltImage'];
$rm_snapImage=$_POST['rm_snapImage'];
$idImage=$_POST['idImage'];
$efkImage=$_POST['efkImage'];
$mlImage=$_POST['mlImage'];
$wpImage=$_POST['wpImage'];
$rmlatImage=$_POST['rmlatImage'];
$yil=$_POST['yil'];
$description=$_POST['description'];
$descriptionrmdis=$_POST['aciklamarmdis'];
$descriptionrmic=$_POST['aciklamarmdic'];
$descriptionxlure=$_POST['aciklamaxlure'];
$descriptionrmsnap=$_POST['aciklamarmsnap'];
$descriptionid=$_POST['aciklamaid'];
$descriptionefk=$_POST['aciklamaefk'];
$descriptionml=$_POST['aciklamaml'];
$descriptionwp=$_POST['aciklamawp'];
$descriptionrmlat=$_POST['aciklamarmlat'];

$descriptionlt=$_POST['aciklamalt'];
$tarihAraligi=$_POST['tarihAraligi'];
$yaz='';
$yaz2='';
$client=Client::model()->findByPk($_POST['Reports']['clientid']);

for($i=0;$i<count($aylar);$i++)
{
				$yaz .="
			<tr>
				<td colspan='2'>".str_replace("'", "", $aylar[$i])."</td>
				 <td colspan='2'>".$xlure[$i]."</td>
				 <td colspan='2'>".$rm_i[$i]."</td>
				 <td colspan='2'>".$rm_o[$i]."</td>
				 <td colspan='2'>".$lt[$i]."</td>
				 <td colspan='2'>".$rm_snap[$i]."</td>
	       <td colspan='1'>".$id[$i]."</td>
				 <td colspan='1'>".$efk[$i]."</td>
         <td colspan='2'>".$ml[$i]."</td>
		 <td colspan='2'>".$wp[$i]."</td>
		 <td colspan='2'>".$rmlat[$i]."</td>
	   </tr>";
}
$yaz .="
<tr>
<td colspan='2'>".t('Toplam')."</td>
 <td colspan='2'>".$xlureTop."</td>
  <td colspan='2'>".$rm_i_Top."</td>
   <td colspan='2'>".$rm_o_Top."</td>
    <td colspan='2'>".$lt_Top."</td>
  <td colspan='2'>".$rm_snapTop."</td>
 <td colspan='1'>".$idTop."</td>
 <td colspan='1'>".$efkTop."</td>
 <td colspan='2'>".$mlTop."</td>
 <td colspan='2'>".$wpTop."</td>
 <td colspan='2'>".$rmlat_Top."</td>
</tr>";

$yaz .="
<tr>
<td colspan='2'>".t('Genel Toplam')."</td>
 <td colspan='2'>".$genelToplam."</td>
 <td colspan='2'></td>
 <td colspan='2'></td>
 <td colspan='2'></td>
 <td colspan='2'></td>
  <td colspan='2'></td>
   <td colspan='2'></td>
 <td colspan='2'></td>
  <td colspan='2'></td>
  <td colspan='2'></td>
</tr>";



$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$xlureImage."'/><br><center>".$descriptionxlure."<hr></center><br><br><br><br></td>
 <td style='border:none;' colspan='6'><img width='100%' src='".$rm_iImage."'/><br><center>".$descriptionrmic."<hr></center><br><br><br><br></td>
</tr>";

$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$rm_oImage."'/><br><center>".$descriptionrmdis."<hr></center><br><br><br><br></td>
 <td style='border:none;' colspan='6'><img width='100%' src='".$ltImage."'/><br><center>".$descriptionlt."<hr></center><br><br><br><br></td>
 
</tr>";
$yaz2 .="

<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$rm_snapImage."'/><br><center>".$descriptionrmsnap."<hr></center><br><br><br><br></td>
 <td style='border:none;' colspan='6'><img width='100%' src='".$idImage."'/><br><center>".$descriptionid."<hr></center><br><br><br><br></td>
</tr>";
$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$efkImage."'/><br><center>".$descriptionefk."<hr></center><br><br><br><br></td>
  <td style='border:none;' colspan='6'><img width='100%' src='".$mlImage."'/><br><center>".$descriptionml."<hr></center><br><br><br><br></td>
</tr>";
$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><img width='100%' src='".$wpImage."'/><br><center>".$descriptionwp."<hr></center><br><br><br><br></td>
 <td style='border:none;' colspan='6'><img width='100%' src='".$rmlatImage."'/><br><center>".$descriptionrmlat."<hr></center><br><br><br><br></td>
</tr>";
$yaz2 .="
<tr style='border:none;'>
 <td style='border:none;' colspan='6'><center></center><br><br><br><br></td>
  <td style='border:none;' colspan='6'><center></center><br><br><br><br></td>
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
 *{
 font-size:16px !important;
 }
.f12
{

}td,th{
	border:1px solid #333333;

}
th {
//font-family:Arial;
}
td {
font-size:14px !important;
//font-family:Arial;
}
td{
font-weight:normal;
font-size:15px;
}
#xxx tbody tr td{
font-weight:normal;
font-size:25px;
}
</style><table border='0'  width='100%' cellpadding='0' cellspacing='0'>
            <thead>
            <tr>
          		<td width='100' align='center' colspan='2'>
              <img src='".Yii::app()->getbaseUrl(true)."/".$resim."' width='95px'  >
          		</td>
          		<td colspan='18' align='center'>
          			<b><h2>".t('Aktivite Miktarı Rapor-Grafik')."</h2></b>
                	<br><h3>".$client->name." - ".$tarihAraligi."</h3>
          		</td>
          	</tr>
              <tr>
							      <th colspan='2'>".$yil."</th>
								  <th colspan='2'>".t('X-Lure MultiSpecies Trap')."</th>
								  <th colspan='2'>".t('RM - Indoor Nontoxic+Toxic')."</th>
								  <th colspan='2'>".t('RM - Outdoor Nontoxic+Toxic')."</th>
							      <th colspan='2'>".t('LT - Glueboard')."</th>
								  <th colspan='2'>".t('RM - Snaptrap')."</th>
                    <th colspan='1'>".t('ID')."</th>
                    <th colspan='1'>".t('EFK')."</th>
                    <th colspan='2'>".t('ML')."</th>
                    <th colspan='2'>".t('WP')."</th>
                    <th colspan='2'>".t('RM - Latent')."</th>
              </tr>
            </thead>
          <tbody>
            ".$yaz."

            </tbody>
        </table>

        <table border='0'  width='100%' cellpadding='0' cellspacing='0' style='margin-top:100px'  id='xxx'>

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