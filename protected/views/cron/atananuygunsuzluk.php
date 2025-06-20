<?
//client actionAdmin
$finishdate=time();
$startdate=strTotime(date("d.m.y",strtotime("-7 day")));
$clientArrayPdf=ConuserassignraporView::model()->findAll(array("condition"=>"type=22 and sendtime>=".$startdate." and sendtime<=".$finishdate,"group"=>"clientid"));
foreach ($clientArrayPdf as $clientArrayPdfx) {
  $user=User::model()->find(array("condition"=>"clientid=".$clientArrayPdfx->clientid." and clientbranchid=0"));
  $pdfMetin=ConuserassignraporView::model()->findAll(array("condition"=>"type=22 && clientid=".$clientArrayPdfx->clientid));
  foreach ($pdfMetin as $pdfMetinx) {
      echo "https://insectram.io/conformityuserassign/print?firmid=".$pdfMetinx->firmid."&branchid=".$pdfMetinx->branchid."&clientid=".$pdfMetinx->clientid."&clientbranchid=".$pdfMetinx->clientbranchid."&type=22".'<br>';
  }

}

//client branch admin
$clientArrayPdf=ConuserassignraporView::model()->findAll(array("condition"=>"type=26 and sendtime>=".$startdate." and sendtime<=".$finishdate,"group"=>"clientbranchid"));
foreach ($clientArrayPdf as $clientArrayPdfx) {
  $user=User::model()->find(array("condition"=>"clientbranchid=".$clientArrayPdfx->clientbranchid));
  echo "https://insectram.io/conformityuserassign/print?firmid=".$user->firmid."&branchid=".$user->branchid."&clientid=".$user->clientid."&clientbranchid=".$user->clientbranchid."&type=26".'<br>';
}
?>
