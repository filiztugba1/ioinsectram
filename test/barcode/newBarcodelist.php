<?php
include "lib/class.barcode.php";
echo '<ul style="list-style: none;
padding:0;
margin:0;">';

for($i=0;$i<count($QRs) ;$i++ ){
			try{
			$qr = new BarcodeQR();
			$qr->text($QRs[$i]);
			$qr->draw(90, $_SERVER['DOCUMENT_ROOT']."/uploads/barcode/monitor/".$QRs[$i].".png");
				echo '<li style="padding: 0;
			    margin: 0;
			    width: 60px;
			    position: relative;
			    display: inline-block;
				margin-right:15px;
				text-align:center;
				height:80px;text-align:left;"><img src="/uploads/barcode/monitor/'.$QRs[$i].'.png"  style="position: relative;
			    right: 10px;
				padding-left:5px;" width="100%" alt="'.$QRs[$i].'"><center></center></li>';
			}catch(Exception $e){
				print_R($e);
			}
}
echo '</ul>';

?>
