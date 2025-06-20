<?php

class CronController extends Controller
{
	public function actionIndex()
	{
		$this->layout='login';
		$this->render('index');
	}

	public function actionCustomermonthly()
	{
		$this->render('customermonthly');
	}
	public function actionDocumentfinishdate()
	{
		$this->render('documentfinishdate');
	}
	public function actionAtananuygunsuzluk()
	{
		$this->render('atananuygunsuzluk');
	}
	public function actionBilgilendirme()
	{
		$this->render('bilgilendirme');
	}
	public function actionRaporcron(){

		echo "ok";
	}
	public function actionServicereportcron(){
$serviceemail=Servicereport::model()->findAll(array(
								   'condition'=>'( (id>35839 and saver_id<>0 ) ) and 
mail_sent=0 and simple_client=0 limit 5')
							   );
    foreach ($serviceemail as $item){
      echo $item->id;
$ch = curl_init();

$url = 'https://insectram.io/site/servicereport5?id=' . $item->id;
      echo $url;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Test için
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: Mozilla/5.0'
]);

$a = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "HTTP code: $httpcode<br>";
    echo "Response:<br><pre>$a</pre>";
}

curl_close($ch);
    
      echo $a.'a';
     // if ($a<>''){
            $item->mail_sent=1;    
				$item->save();
    //  }

    //  print_r($item);
    }
		echo "ok";
    exit;
	}
  
  
  
  	public function actionAutoaddmonitors(){
$serviceemail=Workorder::model()->findAll(array(
								   'condition'=>'id>7820638 and 
(visittypeid=62 or visittypeid=31 or visittypeid=26 )  and autoaddmonitor=0 limit 30')
							   );
    foreach ($serviceemail as $item){
     
		 if ($item->visittypeid==62 || $item->visittypeid==31 || $item->visittypeid==26){
       $tempcode='';
       $tempperiod='';
       $tempcode=$item->code;
       $tempperiod=$item->isperiod;
       $item->code='';
       $item->isperiod=0;
       $item->save();
       Workorder::model()->addmonitortotifollow($item->id);
       $item->code=$tempcode;
       $item->isperiod=$tempperiod;
       $item->autoaddmonitor=1;
       $item->save();
       echo 'okok';
      }
      
    }
		echo "ok";
    exit;
	}
  
  
  
  
	public function actionAutodatemonitors(){
    
    
 $dates=time()-3600000000;
    
/*$serviceemail=Servicereport::model()->findAll(array(
								   'condition'=>'( (id>54138  ) ) and 
checked_for_longwork=0 date<'.$dates.' limit 1')
							   );*/
    $srid=54197;
    echo $srid.PHP_EOL;
$serviceemail=Servicereport::model()->findAll(array(
								   'condition'=>'id>'.$srid.'  and 
checked_for_longwork=0 and technician_sign like "%Issireland1%" limit 1')
							   );

    foreach ($serviceemail as $item){

        
   $min = Mobileworkordermonitors::model()->find(array(
    'condition' => 'workorderid = :wid AND checkdate != 0',
    'params' => array(':wid' => $item->reportno),
    'order' => 'checkdate ASC',
    'limit' => 1,
));

$max = Mobileworkordermonitors::model()->find(array(
    'condition' => 'workorderid = :wid AND checkdate != 0',
    'params' => array(':wid' => $item->reportno),
    'order' => 'checkdate DESC',
    'limit' => 1,
));
  
      if (isset($min['checkdate']) && isset($max['checkdate']) ){
 
          
            $ts1 =  $min['checkdate'];
            $ts2 = $max['checkdate'];

            $tarih1 = date('Y-m-d', $ts1);
            $tarih2 = date('Y-m-d', $ts2);

            if ($tarih1 !== $tarih2) {
                echo "Farklı günler. işlem yap";
              
              
                            
              ///////////////////////////////////////////////////////////////////////////////////////////////////
              ///////////////////////////////////////////////////////////////////////////////////////////////////
              
              
              
              		$model=Workorder::model()->findByPk($item->reportno);
	//	$model->status=3;


	
		$timestamp1 = $ts1;

	
		$timestamp2 = $ts2;
	
     $modelMWM=Mobileworkorderdata::model()->findAll(array('condition'=>'workorderid>0 and workorderid='.$item->reportno.' and createdtime<>0'));
        foreach($modelMWM as $modelMWMx)
        {
              $modelD=Mobileworkorderdata::model()->findByPk($modelMWMx['id']);
              $yenitarih=$timestamp2;
              $modelM=Mobileworkordermonitors::model()->findByPk($modelD->mobileworkordermonitorsid);
              $modelM['checkdate']=$timestamp2;
              $modelM->update();
              ///
              $modelD->createdtime=$yenitarih;
              $modelD->openedtimeend=$yenitarih;
              $modelD->update();
          
        }
        
     
			echo "success";
		
              ///////////////////////////////////////////////////////////////////////////////////////////////////
              ///////////////////////////////////////////////////////////////////////////////////////////////////
              
            } else {
                echo "Aynı gün. yapma";
            }

        
      }else{ 
      
      echo 'min maxlardan biri yok!=>'.$item->id;
      
      }
      
   $item->checked_for_longwork=1;
      
      $item->save();
    }
    exit;
	}
  
	public function actionServicereportcronaudited(){

    $dates=time()-3600;
$serviceemail=Servicereport::model()->findAll(array(
								   'condition'=>'( (id>36260  ) ) and 
mail_sent=0 and simple_client=1 and date<'.$dates.' limit 5')
							   );
    foreach ($serviceemail as $item){
			$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://insectram.io/site/Servicereport6?id='.$item->id);//https://insectram.io/site/servicereport6?id=30541&languageok=en
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


//$headers = array();
//$headers[] = "Accept: application/json";
//$headers[] = "Authorization: Bearer APIKEY";
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$a = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
			
    
      echo $a;
     // if ($a<>''){
            $item->mail_sent=1;    
            $item->is_published=1;    
				$item->save();
    //  }

      print_r($item);
    }
		echo "ok";
    exit;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
