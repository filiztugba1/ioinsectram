<?php
$arr=[];

$id=$_GET['id'];
if (is_numeric($_GET['id'])){
	
}else{
	echo 'wrong number!';exit;
}
//echo 'tireport'.$id;//exit;
function jsnfix($json)
{
    return 	preg_replace('/\r|\n/','\n',trim($json));
}
$reportinfo=Servicereport::model()->find(array('condition'=>'id='.$id));
if (!$reportinfo){
	echo 'no report!';exit;
}
$workorderid= $reportinfo->reportno;
$reportdate=date('Y-m-d',$reportinfo->date);
if (isset($_POST['descriptionrmdic'])){
	
	 $_POST = array_map ( 'htmlspecialchars' , $_POST );
	 $_POST = array_map ( 'jsnfix' , $_POST );



	$reportinfo->ti_data=json_encode($_POST,true );
$reportinfo->update();
}
if (isset($_POST['publish'])){
	$reportinfo->is_published=$_POST['publish'];
$reportinfo->update();
}
if ($reportinfo->ti_data<>''){
	$ti_data=json_decode($reportinfo->ti_data);
}
$ax= User::model()->userobjecty('');
$clientmi=0;
$is_published=0;
if ($ax->clientid<>0){
	$clientmi=1;
}
if ($reportinfo->is_published==1){
	$is_published=1;
}

if ($is_published==1){
	$pubcss=' disabled="true" ';
}else{
	
	$pubcss='  ';
}

?>


<?php
  $baseurl = Yii::app()->basepath."/views/site/ti_report_templates/";
$tarih1=date('Y',$reportinfo->date);
$tarih2=date('Y',$reportinfo->date);

//$year = date('Y') - 1; // Get current year and subtract 1
$year = date('Y',$reportinfo->date) ; //
$midnight = mktime(0, 0, 0, 1, 1, $year);
$midnight2 = mktime(0, 0, 0, 12, 31, $year);


$verilerwor="";
$sqlwor="";
$ax= User::model()->userobjecty('');

$lguser=User::model()->findbypk($ax->id);


$workorderinfo=Workorder::model()->findByPk($workorderid);
	
	
$firmid=$workorderinfo->firmid;

$clientid=$workorderinfo->clientid;// 3062;
   $clientinfo=Client::model()->findByPk($clientid);
   $clientadmin=User::model()->find(array('condition'=>'clientbranchid='.$clientid.' and  type=26'));
if ($clientadmin){
	$clientadminname=$clientadmin->name.' '.$clientadmin->surname;
}else{
	$clientadminname=' - ';
}

   $branch=Firm::model()->findByPk($firmid);


        $sqlwor= $sqlwor."clientid=".$clientid;

	$sirala='l.date asc';

$workorders = Yii::app()->db->createCommand()
  ->select('l.*,u.name cbname,ux.name cname,u.client_code')
		->from('workorder l')
		->leftjoin('client u', 'u.id=l.clientid')
    ->leftjoin('client ux', 'ux.id=u.parentid')
		->where($sqlwor)
		->order($sirala)
		->queryall();

foreach ($workorders as $workorder)
{
	
	$firmid=intval($workorder['firmid']);
  $time=strtotime($workorder['date']." ".$workorder['start_time']);


  if($time >= $midnight && $time<=$midnight2)
  {
    $visitype=Visittype::model()->findByPk($workorder['visittypeid'])->name;
    $rstartTime="";
    $rfinishTime="";
    if($workorder['realstarttime'] && $workorder['executiondate']!='')
    {
        $rstartTime=date("Y-m-d - H:i",$workorder['realstarttime']);
    }
    else{
			continue;
      $rstartTime=t("Henüz Başlanmadı.");
    }

    if($workorder['realendtime'] && $workorder['executiondate']!='')
    {
        $rfinishTime=date("Y-m-d - H:i",$workorder['realendtime']);
    }
    else{
			continue;
      $rfinishTime=t("Henüz Bitirilmedi.");
    }

  
    $verilerwor .= "<tr>"; 
    if(isset($firmid))
    {
		
		
      $verilerwor .= "<td>".$workorder['cname']."</td>";
    }
    
	  $verilerwor .= "<td>".$workorder['cbname']."</td>";

		
      $verilerwor .="<td>".$workorder['date']." - ".$workorder['start_time']."</td>
      <td>".$workorder['date']." - ".$workorder['finish_time']."</td>
      <td>".$rstartTime."</td>
      <td>".$rfinishTime."</td>
      <td>".t($visitype)."</td>
    </tr>";

  }
}

$col=0;


$htmlwor='
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
font-size:11px;
}
td {
font-family:Arial;
font-size:11px;
}
</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<thead>
	<tr>

		<td colspan="12" align="center" style="background:#204799;color:white;"> ';

		$htmlwor=$htmlwor.'<b>SUMMARY OF ALL VISITS COMPLETED THIS YEAR</b>';

				$htmlwor=$htmlwor.'</td>
	</tr>
	<tr>
		<td colspan="'.(6+$col).'">'.($lguser->languageid!=8?t('Müşteri Şube'):t('Müşteri Şube').' (Client Name)').' : '.$branch->name.'</b></td>
	</tr>

	<tr>
		<td colspan="'.(6+$col).'">'.($lguser->languageid!=8?t('Tarih'):t('Tarih').' (Date)').'
		: '.$tarih1.'-01-01 / '.$reportdate.'</td>
	</tr>

  <tr>
		<td colspan="'.(6+$col).'">'.($lguser->languageid!=8?t('Müşteri Şube Seçim'):t('Müşteri Şube Seçim').' (Client Branch Selection)').'
		: '.$clientinfo->name.'</td>
	</tr>


	<tr>';
if(isset($firmid))
{
  $htmlwor=$htmlwor.'<td rowspan="2" style="width:100px" align="center">'.($lguser->languageid!=8?t('Müşteri'):t('Müşteri').' <br> (Client)').'</td>';
  $htmlwor=$htmlwor.'<td rowspan="2" style="width:100px" align="center">'.($lguser->languageid!=8?t('Müşteri Şube'):t('Müşteri Şube').' <br> (Client Branch)').'</td>';

}
else
{
   $htmlwor=$htmlwor.'<td rowspan="2" style="width:100px" align="center">'.($lguser->languageid!=8?t('Müşteri'):t('Müşteri').' <br> (Client)').'</td>';
}

	$htmlwor=$htmlwor.'
	<td colspan="2" align="center" style="width:200px">'.($lguser->languageid!=8?t('Planlanma Tarihi'):t('Planlanma Tarihi').' <br> (Planning Date)').'</td>
  	<td colspan="2" align="center">'.($lguser->languageid!=8?t('Gerçekleşme Tarihi Tarihi'):t('Gerçekleşme Tarihi Tarihi').' <br> (Date of realization)').'</td>
    <td rowspan="2" colspan="1" align="center">'.($lguser->languageid!=8?t('Ziyaret Türü'):t('Ziyaret Türü').' <br> (Visit Type)').'</td>
  </tr>
  <tr>
    <td style="width:100px" align="center">'.($lguser->languageid!=8?t('Başlangıç Tarihi'):t('Başlangıç Tarihi').' <br> (Starting date)').'</td>
    <td style="width:100px" align="center">'.($lguser->languageid!=8?t('Bitiş Tarihi'):t('Bitiş Tarihi').' <br> (End Date)').'</td>
    <td align="center">'.($lguser->languageid!=8?t('Başlangıç Tarihi'):t('Başlangıç Tarihi').' <br> (Starting date)').'</td>
    <td align="center">'.($lguser->languageid!=8?t('Bitiş Tarihi'):t('Bitiş Tarihi').' <br> (End Date)').'</td>
	</tr>
</thead>
	<tbody>
		'.$verilerwor.'
		</tbody></table></body></html>';

?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>



<?php  if (!isset($_GET['ajaxref'])){
    
    ?>

<div id="reloadcnt">
  
  <?php      
  }
      ?>
  
<?php


 
	$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/en.php';
			if (file_exists($langfileurl)) //dil dosyasını arıyoruz.
			{	//dil dosyası varsa yüklüyoruz.
				include $langfileurl;
			}
if (isset($_GET['id']) && is_numeric($_GET['id'])){
  
}else{
  echo "Bad id";exit;
}
  $button_disabled=0;
 // ob_start();
		$workorders = Yii::app()->db->createCommand()
  ->select('sr.*,w.id wid,w.firmid,w.clientid,f.name fname,fb.address,w.realstarttime,w.realendtime,w.executiondate,w.date
  ,fb.landphone,fb.email,cb.address cbadres,IF(w.staffid is null,CONCAT(uts.name," ",uts.surname),CONCAT(u.name," ",u.surname)) teknisyen')
		->from('servicereport sr')
		->leftjoin('workorder w', 'w.id=sr.reportno')
		->leftjoin('firm f', 'f.id=w.firmid')
		->leftjoin('firm fb', 'fb.id=w.branchid')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->leftjoin('visittype vt', 'vt.id=w.visittypeid')
		->leftjoin('user u', 'u.id=w.staffid')
		->leftjoin('staffteam st', 'st.id=w.teamstaffid')
		->leftjoin('user uts', 'uts.id=st.leaderid')
		->where('sr.id='.$_GET['id'])
		->queryall();
		$firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));
		
		

  $basla=strtotime("today", $workorders[0]['realendtime']);
  $bit=strtotime("today", $workorders[0]['realendtime'])+86400;
/*
		$uygunsuzluklar= Yii::app()->db->createCommand()
		->select('c.*,cb.name cbname')
		->from('conformity c')
		->leftjoin('client cb', 'cb.id=c.clientid')
		->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit)
		->order('c.numberid asc')
		->limit(10)
		->queryall();
  */
  		$uygunsuzluklar= Yii::app()->db->createCommand()
		->select('c.*,cb.name cbname')
		->from('conformity c')
		->leftjoin('client cb', 'cb.id=c.clientid')
		->where('c.workorderid='.$workorders[0]['reportno'])
		->order('c.numberid asc')
		->limit(1000)
		->queryall();
		
		$acikiemirleri = Yii::app()->db->createCommand()
		->select('w.*,cb.name cbname,IF(w.statusid=0,"Askıda",IF(w.statusid=5,"Görüldü","Devam Ediyor")) status')
		->from('conformity w')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->where('w.clientid='.$workorders[0]['clientid'].' and w.statusid in (4,5,0) and w.date<'.$basla)
		->queryall();
  
  
		$stokKimyasalmodelx = Yii::app()->db->createCommand()
		->select('*')
		->from('activeingredients')
		->where('workorderid='.$workorders[0]['reportno'])
		->queryall();


		
		
		
		$mobileworkordermonitorsview = Yii::app()->db->createCommand()
		->select('count(mtv.id) toplam,mt.name,mtv.*')
		->from('mobileworkordermonitors_view mtv')
		->leftjoin('monitoringtype mt', 'mt.id=mtv.monitortype')
		->where('mtv.workorderid='.$workorders[0]['wid'])
		->group('mtv.monitortype')
		->queryall();

		$url = Yii::app()->basepath."/views/site/";
		 $mpdf=new \Mpdf\Mpdf();
			// include($url . "servicereport4.php");

  ?>
<div style="max-width:75%; margin-left:auto; margin-right:auto;">
  <? // echo $html; 
  ?>
</div>
<?php

	$langfileurl= '/home/ioinsectram/public_html/protected/modules/translate/languages/en.php';
   include $langfileurl;


$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$veriler="";
$sql="";


$lguser=User::model()->findbypk($ax->id);

////// 542

	

  function transparent_background($filename, $color,$input_file) 
{
    

//trigger exception in a "try" block


//catch exception
if(exif_imagetype($input_file) != IMAGETYPE_JPEG){

       $img =  imagecreatefrompng($input_file);
}else{
      $img =   imagecreatefromjpeg($input_file);
}

 
    
  //  $img = imagecreatefrompng($input_file); //or whatever loading function you need
    $colors = explode(',', $color);
    $remove = imagecolorallocate($img, $colors[0], $colors[1], $colors[2]);
    imagefilter($img, IMG_FILTER_GRAYSCALE);
    imagefilter($img, IMG_FILTER_CONTRAST, 0);
    imagefilter($img, IMG_FILTER_NEGATE);
    imagefilter($img, IMG_FILTER_COLORIZE, 10, 10, 10);
    imagefilter($img, IMG_FILTER_NEGATE);
    imagecolortransparent($img, $remove);
    imagepng($img,$filename);
 
     
} 

    $img_file = $workorders[0]['technician_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
$technician_sign = $filePath.'.jpg';
    transparent_background($technician_sign,'0,0,0',$input_file);
    
    
    $img_file = $workorders[0]['client_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
$client_sign = $filePath.'.jpg';
transparent_background($client_sign,'0,0,0',$input_file);
//echo mime_content_type($base);exit;



$col=0;
   
    if($firm->image)
    {
		$resim=Yii::app()->baseUrl.'/'.$firm->image;
    }
    else{
      $resim="/images/nophoto.png";
    }
	
	 if($firm->image)
    {
		$resim2=Yii::app()->baseUrl.'/'.$firm->image2;
    }
    else{
      $resim2="/images/nophoto.png";
    }

$recommended_actions='';
foreach($uygunsuzluklar as $uygunsuzluk)
{
$bgdc='';
  if ($uygunsuzluk['priority']==1){
      $bgdc= 'style="padding:2px; color:white;" bgcolor="red"';
  } else if ($uygunsuzluk['priority']==2){
        $bgdc= 'style="padding:2px; color:white;" bgcolor="orange"';
  }
else if ($uygunsuzluk['priority']==3){
        $bgdc= 'style="padding:2px; " bgcolor="yellow"';
  }

		$recommended_actions.='<tr >
    
			<td colspan="1" style="padding:2px"><a target="_blank" href="/conformity/activity/'.$uygunsuzluk['id'].'">

			 '.$uygunsuzluk['numberid'].'</a>
	    </td>
		<td colspan="2" style="padding:2px">
			'.$uygunsuzluk['definition'].'
	    </td>
		<td colspan="2" style="padding:2px">
			'.$uygunsuzluk['suggestion'].'
	    </td>
		<td colspan="2" style="padding:2px">
			'.$uygunsuzluk['cbname'].' 
	    </td>
		<td colspan="1"  '.$bgdc.'>
			'.t($uygunsuzluk['priority'].'. Degree').'
	    </td>
		<td colspan="1" style="padding:2px">
			 '.date('d/m/Y H:i',$uygunsuzluk['date']).'
	    </td>
      
		<td colspan="1" style="padding:2px">
			 '.t(Conformitystatus::model()->find(array('condition'=>'id='.$uygunsuzluk['statusid']))->name).'
	    </td>
	</tr>';
  if ($uygunsuzluk['statusid']==0){
    $button_disabled=1;
  }
}
$stokKimyasal='';


//// stokkimyasal burda başlar

$trades=Activeingredients::model()->findAll(array('condition'=>'workorderid='.$workorders[0]['wid']));
                                              $stokKimyasalmodelx = Yii::app()->db->createCommand()
  ->select('*')
		->from('activeingredients')
		->where('workorderid='.$workorders[0]['wid'])
		->queryall();

                                 foreach($stokKimyasalmodelx as $stokKimyasalmodelt)
{
                                          $stokKimyasalmodel=Stokkimyasalkullanim::model()->findbypk($stokKimyasalmodelt['tradeId']);
                                   
                                   

                                        
                                               
                       $meds=Meds::model()->find(array('condition'=>'name="'.$trade->active_ingredient.'"'));
														$unittype=Units::model()->findByPk($meds->unit);
													
                      
$stokKimyasalmodel=Stokkimyasalkullanim::model()->findbypk($stokKimyasalmodelt['tradeId']);

	$stokKimyasal .='<tr>
	<td colspan="2" style="padding:2px">'.$stokKimyasalmodel->kimyasaladi.'</td>
	<td colspan="2" style="padding:2px">'.$stokKimyasalmodel->yontem.'</td>
	<td colspan="2" style="padding:2px">'.$stokKimyasalmodel->aktifmaddetanimi.'</td>
	<td colspan="2" style="padding:2px">'.$stokKimyasalmodel->urunAntidotu.'</td>
	<td colspan="2" style="padding:2px">'.$stokKimyasalmodelt['amount_applied'].' '.($stokKimyasalmodel->urunAmbajBirimi==0?t('Adet'):
	($stokKimyasalmodel->urunAmbajBirimi==1?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==2?'ml':
	($stokKimyasalmodel->urunAmbajBirimi==3?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==4?'ml':'')
	)
	)
	)).'</td>
</tr>';
                                   
                                 
                                 
}

////////bitti


$acik_is_emirleri='';
foreach($acikiemirleri as $uygunsuzluk)
{

		$acik_is_emirleri.='<tr>
		<td colspan="1" style="padding:2px">
			 '.$uygunsuzluk['numberid'].'
	    </td>
		<td colspan="2" style="padding:2px">
			'.$uygunsuzluk['definition'].'
	    </td>
		<td colspan="2" style="padding:2px">
			'.$uygunsuzluk['suggestion'].'
	    </td>
		<td colspan="2" style="padding:2px">
			'.$uygunsuzluk['cbname'].' 
	    </td>
		<td colspan="1" style="padding:2px">
			'.t($uygunsuzluk['priority'].'. Degree').'
	    </td>
		<td colspan="1" style="padding:2px">
			 '.date('d/m/Y H:i',$uygunsuzluk['date']).'
	    </td>
      
		<td colspan="1" style="padding:2px">
			 '.t(Conformitystatus::model()->find(array('condition'=>'id='.$uygunsuzluk['statusid']))->name).'
	    </td>
	</tr>';
}


$materials_used='';
//print_r($workorders);exit;
$rmdegisen=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=10 and  petid=49 and value in (1,2))'));
$rmdegisenvalue=0;
foreach($rmdegisen as $item){
$rmdegisenvalue++;
}

if ($rmdegisenvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
			 '.t('RM Monitoring Box Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
		<center>	 '.$rmdegisenvalue.'</center>
	    </td>
	</tr>';
}


//print_r($workorders);exit;
$cidegisen=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=6 and  petid=49 and value in (1,2))'));
$cidegisenvalue=0;
foreach($cidegisen as $item){
$cidegisenvalue++;
}

if ($cidegisenvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
			 '.t('ID Monitoring Box Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			<center> '.$cidegisenvalue.'</center>
	    </td>
	</tr>';
}


$ciyapiskan=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=6 and  petid=39 )'));
$ciyapiskanvalue=0;
foreach($ciyapiskan as $item){
$ciyapiskanvalue+=$item->value;
}

if ($ciyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
 '.t('CI Glueboard Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			<center> '.$ciyapiskanvalue.'</center>
	    </td>
	</tr>';
}

/// LT


//print_r($workorders);exit;
$ltdegisen=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=8 and  petid=49 and value in (1,2))'));
$ltdegisenvalue=0;
foreach($ltdegisen as $item){
$ltdegisenvalue++;
}

if ($ltdegisenvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
		'.t('LT Monitoring Box Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
		<center>	 '.$ltdegisenvalue.'</center>
	    </td>
	</tr>';
}


$ltyapiskan=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=8 and  petid=39 )'));
$ltyapiskanvalue=0;
foreach($ltyapiskan as $item){
$ltyapiskanvalue+=$item->value;
}

if ($ltyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('LT Glueboard Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
		<center>	 '.$ltyapiskanvalue.'</center>
	    </td>
	</tr>';
}


$lftyapiskan=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=19 and  petid=34 )'));
$lftyapiskanvalue=0;
foreach($lftyapiskan as $item){
$lftyapiskanvalue+=$item->value;
}

if ($lftyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('EFK Glueboard Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			 <center>'.$lftyapiskanvalue.'</center>
	    </td>
	</tr>';
}



//$cldegisen=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));
//$clyapiskan=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));

//$ltdegisen=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));
//$ltyapiskan=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));


//$lftyapiskan=Mobileworkorderdatati::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));





foreach($mobileworkordermonitorsview as $materials_usedx)
{
	continue;
		$materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
			 '.$materials_usedx['definationlocation'].'
	    </td>
	
		<td style="padding:2px"  colspan="2">
			 '.$materials_usedx['toplam'].'
	    </td>
	</tr>';
}
//print_r($workorders[0]);
//exit;
	
		$init = $workorders[0]['realendtime']-$workorders[0]['realstarttime'];
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;
	$totti='';
	if ($hours>1){
			$hoi="$hours hours ";
	}else if ($hours==1){
					$hoi="$hours hour ";
	}else{
					$hoi="";
	}
	
	if ($minutes>1){
			$minu="$minutes minutes";
	}else if ($hours==1){
					$minu="$minutes minute";
	}else{
					$minu="";
	}
	$totti=$hoi.$minu;
	
	
	?>


    <div class="col-lg-10  col-md-10 offset-lg-1 offset-md-1 "  >
        <div class="card"> 
            <div class="card-content" style="padding:15px;">
<?php $html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><style>
.f12
{
	//font-size:10px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
//font-size:10pt;
}
td {
font-family:Arial;
//font-size:8pt;
}

.noneColer{
	border:none !important;
}
th{
//border: 1px solid #a2a2a2;
}
</style>

<table border="0" width="100%" cellpadding="0" cellspacing="0"> 
<thead>
  <tr>
    <th style="background:#204799;color:white;height: 30px; text-align: right;
  padding-right: 15px;">Service Date:<br></th>
    <th style="padding-left: 10px;">'.date('Y-m-d',$reportinfo->date).' ( '.date("H:i", $workorders[0]['realstarttime']).' - '.date("H:i", $workorders[0]['realendtime']).' | '.$totti.' )'.'</th>
    <th style="background:#204799;color:white;text-align: right;
  padding-right: 15px;">Visit Number:</th>
    <th style="padding-left: 10px;">'.$workorders[0]['wid'].'</th>
  </tr>
	<tr>
    <th style="background:#204799;color:white;height: 30px;text-align: right;
  padding-right: 15px;">Client:</th>
    <th style="padding-left: 10px;" colspan="3">'.$clientinfo->name.'</th>
    
  </tr>
	<tr>
    <th style="background:#204799;color:white;height: 30px;text-align: right;
  padding-right: 15px;">Site Address:</th>
    <th style="padding-left: 10px;" colspan="3">'.$clientinfo->address.' </th>
    
  </tr>

	<tr>
    <th style="background:#204799;color:white;height: 30px;text-align: right;
  padding-right: 15px;">Post Code:</th>
    <th style="padding-left: 10px;" colspan="3">'.$clientinfo->postcode.'</th>
    
  </tr>
	<tr>
    <th style="background:#204799;color:white;height: 30px;text-align: right;
  padding-right: 15px;">Site Contact:</th>
    <th style="padding-left: 10px;" colspan="3">'.$clientadminname.' </th>
    
  </tr>
</thead>

</table>


<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> 
<thead>
  <tr>
    <th style="background:#204799;color:white;height: 30px; text-align: right;
  padding-right: 15px;">Type of Visit:<br></th>
    <th style="padding-left: 10px;">Technical Inspection</th>
    <th style="background:#204799;color:white;text-align: right;
  padding-right: 15px;">Description:</th>
    <th style="padding-left: 10px;">'.$workorderinfo->todo.'</th>
  </tr>

</thead>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> 
<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
	<tr>
	<tr  bgcolor="#204799">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Biocides Used').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			 <b>'.t('Trade name').'</b>
	    </td>
		<td align="center" colspan="2">
			 <b>'.t('Application Method').'</b>
	    </td>
		<td align="center" colspan="2">
			 <b>'.t('Active ingredient').'</b>
	    </td>
		<td align="center" colspan="2">
			 <b>'.t('Antidote').'</b>
	    </td>
		<td align="center" colspan="2">
			 <b>'.t('Amount used').'</b>
	    </td>
      
	</tr>
	
	'.$stokKimyasal.'
	
	
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
	<tr>
	<tr  bgcolor="#204799">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Materials Used').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="center" colspan="6">
			 <b>'.t('Description').'</b>
	    </td>
	
		<td align="center" colspan="4">
			 <b>'.t('Amount').'</b>
	    </td>
	</tr>
	
	'.$materials_used.'
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
</table>

'.$htmlwor;
            
  if ($button_disabled=='0'){
    	$html.='<tr  bgcolor="#204799">';
  }else{
        	$html.='<tr  bgcolor="red">';
  }
      

              
  
	$html.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Recommended Actions').'</b><br>
	    </td>
	</tr>
	
	<tr>
		<td align="center" colspan="1">
			 <b>'.t('Number').'</b>
	    </td>
		<td align="center" colspan="2">
			<b>'.t('Actions').'</b>
	    </td>
		<td align="center" colspan="2">
			<b>'.t('Recommendations').'</b>
	    </td>
		<td align="center" colspan="2">
			<b>'.t('Resp.').'</b>
	    </td>
		<td align="center" colspan="1">
			<b>'.t('Priority').'</b>
	    </td>
		<td align="center" colspan="1">
			 <b>'.t('Created On').'</b>
	    </td>
      	<td align="center" colspan="1">
			 <b>'.t('Status').'</b>
	    </td>
	</tr>
	'.$recommended_actions.'
	
	</table>';
							
					
	$html.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('Folder/Portal Document Review').'</b><br>
	    </td>
	</tr>
	</td>
</table>
	<table border="0" width="100%" cellpadding="0" cellspacing="0"> 
	';
							$say=0;
								$ticheckhtml='';
							if (strlen($reportinfo->ti_checklist)>5){
			foreach(json_decode($reportinfo->ti_checklist) as $tiitems){
				if ($say=='0'){
					$ticheckhtml.='<tr>';
				}
				$say++;
				$evethayir='';
				if ($tiitems->value=='0'){
					$evethayir='No';
				}else{
						$evethayir='Yes';
				}
				$ticheckhtml.='		<td style="padding:2px"  colspan="3">
			'.$tiitems->item_name.'
	    </td>
	
		<td style="padding:2px"  colspan="1">
		<center>	'.$evethayir.' </center>
	    </td>';
				
				if ($say==3) { $say=0; 	$ticheckhtml.='</tr>'; }
			}
	}
	$html.=$ticheckhtml.'
	
	
	
	</table>

';
								if($clientmi==0 || $is_published==1 ){			
								$rmxhtml.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('TECHNICAL INSPECTION RECORD OF RM MONITORS ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
							$rmpdfparams=[];
							$rmpdfparams['Monitoring']['date']=$reportdate;//'2023-01-10';
							$rmpdfparams['Monitoring']['date1']=$reportdate;//'2024-03-12';
						
						//	$rmpdfparams['Report']['dapartmentid']='';
							//	$rmpdfparams['Monitoring']['subid']='';
							//$rmpdfparams["Monitoring"]["monitors"]='';
							$rmpdfparams['Monitoring']['mtypeid']='-100';
							$rmpdfparams['Report']['clientid']=$clientinfo->id;
							
							include($baseurl.'rmpdf.php');
							if($htmlrmpdf<>''){
							$html.=$rmxhtml.$htmlrmpdf;
							}
										$efkxhtml.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('TECHNICAL INSPECTION RECORD OF EFK MONITORS ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
							$rmpdfparams['Monitoring']['mtypeid']='19';
							include($baseurl.'efkpdf.php');
							
												if($htmlefk<>''){
							$html.=$efkxhtml.$htmlefk;
							}

							
							
							
								
										$ltxhtml.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('TECHNICAL INSPECTION RECORD OF LT MONITORS ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
							$rmpdfparams['Monitoring']['mtypeid']='23';
							//unset(	$rmpdfparams['Monitoring']['mtypeid']);
							include($baseurl.'ltpdf.php');
											if($htmlltglue<>''){
							$html.=$ltxhtml.$htmlltglue;
							}
			
							
								
										$cixhtml.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('TECHNICAL INSPECTION RECORD OF ID MONITORS ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
							$rmpdfparams['Monitoring']['mtypeid']='27';
							//unset(	$rmpdfparams['Monitoring']['mtypeid']);
							include($baseurl.'cipdf.php');
										if($htmlci<>''){
							$html.=$cixhtml.$htmlci;
							}
				
							
										$mtxhtml.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('TECHNICAL INSPECTION RECORD OF MT MONITORS ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
							$rmpdfparams['Monitoring']['mtypeid']='28';
							//unset(	$rmpdfparams['Monitoring']['mtypeid']);
							include($baseurl.'mtpdf.php');
							
												if($htmlmt<>''){
							$html.=$mtxhtml.$htmlmt;
							}
							
			
							
							
										$wpxhtml.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('TECHNICAL INSPECTION RECORD OF WP MONITORS ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
							$rmpdfparams['Monitoring']['mtypeid']='29';
							//unset(	$rmpdfparams['Monitoring']['mtypeid']);
							include($baseurl.'wppdf.php');
									if($htmlwp<>''){
							$html.=$wpxhtml.$htmlwp;
							}
										
							
									
										$html.='<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px"> <td align="center" colspan="10" style="color:#fff">
		
		<tr  bgcolor="#204799">
		<td align="center" colspan="12" style="color:#fff">
			 <b>'.t('Graphics ').'</b><br>
	    </td>
	</tr>
	</td>
</table>';
				
									$aktivitearr=[];

							$aktivitearr['Monitoring']['date']= date('Y',$reportinfo->date).'-01-01';//'2023-01-10';
							$aktivitearr['Monitoring']['date1']=date('Y',$reportinfo->date).'-12-31';//'2024-03-12';
						
						//	$aktivitearr['Report']['dapartmentid']='';
							//	$aktivitearr['Monitoring']['subid']='';
							//$aktivitearr["Monitoring"]["monitors"]='';
							//$aktivitearr['Monitoring']['mtypeid']='-100';
							$aktivitearr['Report']['clientid']=$clientinfo->id;
							echo $html;
							$html='';
							//unset(	$aktivitearr['Monitoring']['mtypeid']);
							include($baseurl.'pdfaktivite.php');
						//	$html.=$htmlwp.'';
							
							
							
							
							$html.='

	
	
		';
							?>
							
							<div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; " ><hr>
							
              <div class="card" style="text-align:center;">
         <h1>
					    TECHNICAL INSPECTION
								</h1>
								<h2>
									EXECUTIVE SUMMARY (Problem areas and recommendations)
								</h2>
                <div class="card-content collapse show">
                  <div class="card-body" >
										<center>
                
										
												    <div class="col-xl-10 col-lg-10 col-md-10 mb-1">				
											<hr>
          	<fieldset class="form-group" style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('A - External areas')?></label>
              <textarea  rows="5"  id="sectiona" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
							
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('A.1 - Waste store, compactors and bins')?></label>
              <textarea  rows="5"  id="sectiona1" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
                   
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('A.2 - Building perimeter, smoking areas, pest bird risk assessment, external door check')?></label>
              <textarea  rows="5"  id="sectiona2" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
                   
											
															    <div class="col-xl-10 col-lg-10 col-md-10 mb-1">				
											<hr>
          	<fieldset class="form-group" style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B - Internal areas')?></label>
              <textarea  rows="5"  id="sectionb" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
											
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B.1 - Production areas')?></label>
              <textarea  rows="5"  id="sectionb1" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
											
																						
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B.2 - Storage areas, goods in, goods out')?></label>
              <textarea  rows="5"  id="sectionb2" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
											
																						
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B.3 - Engineering, boiler rooms, plant rooms')?></label>
              <textarea  rows="5"  id="sectionb3" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
											
																						
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B.4 - Staff changing, canteen and break rooms')?></label>
              <textarea  rows="5"  id="sectionb4" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
																						
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B.5 - Toilets')?></label>
              <textarea  rows="5"  id="sectionb5" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
																						
											<div class="col-xl-8 col-lg-8 col-md-8 mb-1">				
											<hr>
          	<fieldset class="form-group"  style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('B.6 - Offices')?></label>
              <textarea  rows="5"  id="sectionb6" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>					
									
										
															    <div class="col-xl-10 col-lg-10 col-md-10 mb-1">				
											<hr>
          	<fieldset class="form-group" style=" text-align:left !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('C.1 - General Assesment & Comments')?></label>
              <textarea  rows="5" id="sectionc1" type="text" class="form-control"  <?=$pubcss?>  placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>		
											
											<div class="col-xl-12 col-lg-12 col-md-12">			
										
					
										
											
          	<fieldset class="form-group" style=" text-align:right !important;">
							<label for="basicSelect" style="font-size:14px; font-weight:bold;"><?=t('Name and signature of inspector')?></label><br>
							<div style="margin-right:100px;">
									<?php $saverid=User::model()->find(array('condition'=>'id='.$reportinfo->saver_id));
			if($saverid){
				$saverid=$saverid->name.' '.$saverid->surname;
			}else{
				
				$saverid='-';
			}
								?>
								
							<span style="    z-index: 1111111 !important;
    position: relative;"><?=$saverid?></span><br>
							<img src="<?=$reportinfo->technician_sign?>" style="//filter: brightness(30) grayscale(100%) invert(100%); margin-top:-10px; margin-right:-20px;" width="100px">
						</div>
            </fieldset>
				
											
											
										
											<?php
										if($clientmi==0 || $is_published==1){		
											?>
													    <div class="col-xl-10 col-lg-10 col-md-10 mb-1">				
								
							
          	<fieldset id ="butonalan" class="form-group" style=" text-align:left !important;"><center>
				<?php
										if($clientmi==0){		
											?>		<a  onclick="postfunction()" id="" style="color:white !important;"  class="btn btn-lg btn-primary block-page" disabled="true"><span style="font-size:18px" id="savetitle">Save</span></a>
							<?php										}
											?>
						<?php
											if ($clientmi==0){
												if($is_published==0){	
				echo '	<a  onclick="postfunctionp(1)" style="color:white !important;" class="btn btn-lg btn-success block-page" disabled="true">Publish</a>';
												}else{
				echo '	<a  onclick="postfunctionp(0)" style="color:white;"  class="btn btn-lg btn-danger block-page" disabled="true">Unpublish</a>';
														
													}}
							?>
							<a  onclick="CreatePDFfromHTML2()" style="color:white !important;"  class="btn btn-lg btn-primary block-page" disabled="true">Download PDF</a>
				
							</center>
            </fieldset>
										
																				
																				
          </div>		
												
							
											<?php
										}
																?>
										</center>
                  </div>
                </div>
              </div>
						<?php }		?>
            </div>

								
							
						
		
							<?php		
	$html.='	
		</div></body></html>';

echo $html;
?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
     <?php  if (!isset($_GET['ajaxref'])){
    
    ?>         
</div>
          <?php  }
    
    ?>
					
					
					
					
					
					
					
					<div class="row" style="display:none;">
     <div class="col-lg-10  col-md-10 offset-lg-1 offset-md-1 "  >
        <div class="card"> 
            <div class="card-content" style="padding:15px;">
                  <center>      <?=t('Now before being able to print out your VR you need to interact with Recommendations Section using the links on recommendation unique numbers and add a deadline and your action please.')?>              </div>
              <div>
        
                	 	<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style="margin-top:20px;">
                  <center>     
                       <?php
  if ($button_disabled=='0'){
    
  ?>
								<a target="_Blank" href="/site/servicereport5?id=<?=$_GET['id']?>&languageok=en&pdf=ok" class="btn btn-primary block-page" disabled="true">Download PDF</a>
		<?php  }  else{
      ?>
      		<a href="#" class="btn btn-danger block-page" disabled="true">Please Check Recommendations Section </a>
                    <?php    }
    ?>
                  
                    </center>
                    </div>
              </div>
          </div>
       </div>
  </div>
						
						
						
					       <script>
    function postfunction() {
			    unsaved = false;
			document.getElementById("savetitle").innerHTML="Please Wait";
			var descriptionrmdic = document.getElementById("descriptionrmdic").value;
			var descriptionrmdis = document.getElementById("descriptionrmdis").value;
			var descriptionlt = document.getElementById("descriptionlt").value;
			var descriptionrmsnap = document.getElementById("descriptionrmsnap").value;
			var descriptionid = document.getElementById("descriptionid").value;
			var descriptionefk = document.getElementById("descriptionefk").value;
			var descriptionml = document.getElementById("descriptionml").value;
			var descriptionwp = document.getElementById("descriptionwp").value;
			var descriptionrmlat = document.getElementById("descriptionrmlat").value;
			var descriptionxlure = document.getElementById("descriptionxlure").value;
			var sectiona = document.getElementById("sectiona").value;
			var sectiona1 = document.getElementById("sectiona1").value;
			var sectiona2 = document.getElementById("sectiona2").value;
			var sectionb = document.getElementById("sectionb").value;
			var sectionb1 = document.getElementById("sectionb1").value;
			var sectionb2 = document.getElementById("sectionb2").value;
			var sectionb3 = document.getElementById("sectionb3").value;
			var sectionb4 = document.getElementById("sectionb4").value;
			var sectionb5 = document.getElementById("sectionb5").value;
			var sectionb6 = document.getElementById("sectionb6").value;
			var sectionc1 = document.getElementById("sectionc1").value;
			document.getElementById("sectionc1").value=sectionc1;
    $.ajax({
            type : "POST",  //type of method
            url  : "/site/tireport?id=<?=$_GET['id']?>",  //your page
            data : { descriptionrmdic : descriptionrmdic
										, descriptionrmdis : descriptionrmdis
										, descriptionlt : descriptionlt
									 , descriptionrmsnap : descriptionrmsnap
									 , descriptionid : descriptionid
									 , descriptionefk : descriptionefk
									 , descriptionml : descriptionml
										, descriptionwp : descriptionwp
										, descriptionrmlat : descriptionrmlat
										, descriptionxlure : descriptionxlure
										, sectiona : sectiona
										, sectiona1 : sectiona1
										, sectiona2 : sectiona2
										, sectionb : sectionb
										, sectionb1 : sectionb1
										, sectionb2 : sectionb2
										, sectionb3 : sectionb3
										, sectionb4 : sectionb4
										, sectionb5 : sectionb5
										, sectionb6 : sectionb6
										, sectionc1 : sectionc1
									 },// passing the values
            success: function(res){  
//alert('Saved');
							window.location.href = '/site/tireport?id=<?=$_GET['id']?>';
						//	location.reload();
                    }
        });
    }
									 
									 
									 
    function postfunctionp(publ) {
    if(unsaved){
			
			 let result =  confirm("You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?")
            if (result === true) {
    unsaved = false;
            
            } else {
        return false;
            }
			
    
			
    }
    $.ajax({
            type : "POST",  //type of method
            url  : "/site/tireport?id=<?=$_GET['id']?>",  //your page
            data : { publish : publ
									 },// passing the values
            success: function(res){  
alert('Published');
							location.reload();
                    }
        });
    }
								<?	
	$reportinfo->ti_data= str_replace("'","\'",$reportinfo->ti_data); 
									$reportinfo->ti_data= nl2br(str_replace("&quot;",'\\\"',$reportinfo->ti_data)); 
									 
									 ?>
									 var ti_data='<?=$reportinfo->ti_data;?>';
									 if (ti_data!==''){
										 ti_data=JSON.parse(ti_data);
										 
									
    
										const ele = document.getElementsByTagName('textarea');

										for (let i = 0; i <= ele.length - 1; i++) {
											
												 if (ele[i].id in ti_data){
									ele[i].value=ti_data[ele[i].id];
												
									
										}
								}
										 
								
									 console.log(ti_data);
									 console.log(ti_data.sectionc1);
									 
									 if ("sectionc122" in ti_data){
										 console.log ('var');
									 }else{
										 console.log('yok');
									 }
									 }
									 function CreatePDFfromHTML2() {
										   if(unsaved){
			
			 let result =  confirm("You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?")
            if (result === true) {
    unsaved = false;
            
            } else {
        return false;
            }
			
    
			
    }
										 
										 										 $("#butonalan").hide();
										 $("#reloadcnt").attr('style', 'width:28cm !important');

										
    var HTML_Width = $("#reloadcnt").width();
    var HTML_Height = $("#reloadcnt").height();
										 
										  $("textarea").each(function(){
												 $( this ).replaceWith( "<div>" + this.value + "</div>" );
       // this.value = this.value.replace("AFFURL",producturl);
    });
										 
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("#reloadcnt")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save("ti_<?=$id?>.pdf");
											 $("#reloadcnt").attr('style', 'width:100%;');
			  setInterval(function() {
  window.location.reload(true);
  }, 4000);
        //$("#content").hide();
    });
}
						var unsaved=false;			 
									 $(window).bind('beforeunload', function() {
    if(unsaved){
        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
    }
});

// Monitor dynamic inputs
$(document).on('change', ':input', function(){ //triggers change in all input fields including text type
    unsaved = true;
});
    </script>     
						
						<?php
	
Yii::app()->params['scripts'].='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js;';
Yii::app()->params['scripts'].='https://html2canvas.hertzen.com/dist/html2canvas.js;';
	?>
