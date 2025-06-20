<?php

$monitorTop=json_decode($_POST['tum_veri'],true);

$aylar=explode(',',$_POST['aylar']);


$genelToplam=$_POST['genelToplam'];

$yil=$_POST['yil'];
$description=$_POST['description'];

$tarihAraligi=$_POST['tarihAraligi'];
$yaz='';
$yaz2='';
$client=Client::model()->findByPk($_POST['Reports']['clientid']);
$totalmonitor=count($monitorTop)*2;
for($i=0;$i<count($aylar);$i++)
{
				$yaz .="<tr><td colspan='2'>".str_replace("'", "", $aylar[$i])."</td>";
		 
		 	
					foreach($monitorTop as $key=>$monitorTopx)
						{
							 $yaz .="<td colspan='2'>".(isset($monitorTopx['explode'][$i]) && $monitorTopx['explode'][$i]!=''?$monitorTopx['explode'][$i]:0)."</td>";
						}
			$yaz .="</tr>";
}
$yaz .="
<tr>
<td colspan='2'>".t('Toplam')."</td>";
foreach($monitorTop as $key=>$monitorTopx)
						{
							$yaz .="<td colspan='2'>".$monitorTop[$key]['top']."</td>";
						}
						
$yaz .="</tr>";
$yaz .="
<tr>
<td colspan='2'>".t('Genel Toplam')."</td>
 <td colspan='".$totalmonitor."'>".$genelToplam."</td>";
						
						$yaz .="</tr>";

$bas=0;

foreach($monitorTop as $key=>$monitorTopx)
						{
							if($bas==0 || $bas%2==0)
							{
								$yaz2 .="<tr style='border:none;'>";
							}
							$yaz2 .= "<td style='border:none;' colspan='".($totalmonitor%2==0?$totalmonitor/2:($totalmonitor-1)/2)."'><img width='100%' src='".$_POST['Image'.$key]."'/><br><center>".$_POST['Aciklama'.$key]."<hr></center><br><br><br><br></td>";
							if(($bas!=0 && $bas%2==0) || ($bas%2!=0 && $bas==count($monitorTop)-1))
							{
								$yaz2 .= "</tr>";
							}
							$bas++;
						}


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

$th="<tr> <th colspan='2'>".$yil."</th>";
foreach($monitorTop as $key=>$monitorTopx)
						{
							$th.="<th colspan='2'>".mb_strtoupper($monitorTopx['monitorname'],"UTF-8")."</th>";
						}
						$th.="</tr>";
						
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
          		<td colspan='".($totalmonitor)."' align='center'>
          			<b><h2>".t('Aktivite Miktarı Rapor-Grafik')."</h2></b>
                	<br><h3>".$client->name." - ".$tarihAraligi."</h3>
          		</td>
          	</tr>
              <tr>
							     
								  ".$th."
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