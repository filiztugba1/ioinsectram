<?php

Yii::import('application.modules.pdf.components.pdf.mpdf');
$html = "test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>test<br>";
$mpdf=new mpdf();
$mpdf->SetHTMLHeader('
<div style="text-align: right; font-weight: bold;">
    My document
</div>');
$mpdf->WriteHTML($html);
// Output a PDF file directly to the browser
//$mpdf->Output("aaa.pdf", "D");
$mpdf->setFooter('insectram.io - info@insectram.io |  | Sayfa {PAGENO}');
$mpdf->Output();
exit;

//$mpdf->AddPage('L');
//$mpdf->setHTMLHeader($rm, '', true);
$mpdf->WriteHTML($html);
$mpdf->Output("aaa.pdf", "D");
exit;
?>