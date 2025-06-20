<?
include "include/session.php";
include "lib/functions.php";
if($session->userinfo["lang"]=="")
	$session->userinfo["lang"]="tr";
include "lib/lang/".$session->userinfo["lang"].".php";
echo girisYapilmismi();
include "lib/class.barcode.php"; 
echo '<style>
p{
	padding:0;
	margin:0;
}
</style>';
$d = $database->connection->query("select * from musteriler where id='".base64_decode($_GET["v"])."'");
if($d->rowCount()>0)
{
	$qr = new BarcodeQR(); 
	$qr2 = new BarcodeQR(); 
		foreach($d as $s)
		{
			$qr->text($s["barcodeGiris"]); 
			$qr2->text($s["barcodeCikis"]); 
		}
		
	$qr->draw(200, BASEDIR_."/uploads/barcode/".$s["barcodeGiris"].".png");	
	$qr2->draw(200, BASEDIR_."/uploads/barcode/".$s["barcodeCikis"].".png");
echo '
<br>
<br>

<br>
<br><center><h2>'.$s["musteriAdi"].'</h2> 
</center><br>
<br>
<br>
<br>
<br>
<center>
<p><img src="/uploads/barcode/'.$s["barcodeGiris"].'.png" alt="Giriş Barcode"></p>
<p>'.GIRIS_QR_CODE.'</p>
</center>

<br>
<br>
<br>
<br>
<br>
<center>
<p><img src="/uploads/barcode/'.$s["barcodeCikis"].'.png" alt="Giriş Barcode"></p>
<p>'.CIKIS_QR_CODE.'</p>
</center>
<script>
window.print();
</script>
';	

}

?>