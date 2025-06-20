<?php

//if($_POST["code_tip"]=="qr")

include "lib/class.barcode.php";
function barcode($id)
{
			try{

        if (!file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/barcode/monitor/".$id.".png")) {
        $qr = new BarcodeQR();
        //$qr->url( $_SERVER['DOCUMENT_ROOT']."/uploads/barcode/monitor/".$ids[$i]);
        $qr->text($id);
        $qr->draw(90, $_SERVER['DOCUMENT_ROOT']."/uploads/barcode/monitor/".$id.".png");
       
        }
		
			}catch(Exception $e){
				return ["success"=>500,"data"=> $e];
			}
  return ["success"=>true,"data"=> "başarılı"];
}

?>