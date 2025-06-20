<?php $ax= User::model()->userobjecty('');

  if ( !isset($_GET['ajaxref'])){
    if ($ax->clientid>0 ){
    ?>
	<script>
		setInterval(function() {


			$.ajax({

				type: "GET",
				url: '<?=$_SERVER['
				REQUEST_URI ']?>&ajaxref',
				success: function(data) {
					// data is ur summary
					$('#reloadcnt').html(data);
				}

			});



		}, 10000);
	</script>
	<?php			  } 
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
  ->select('sr.*,w.id wid,w.firmid,w.clientid,f.name fname,fb.address,fb.id fbid,c.id cid,cb.id cbid,w.realstarttime,w.realendtime,w.executiondate,w.date
  ,fb.landphone,fb.email,cb.address cbadres,IF(w.staffid is null,CONCAT(uts.name," ",uts.surname),CONCAT(u.name," ",u.surname)) teknisyen, CONCAT(ux.name," ",ux.surname) teknisyen_saver')
		->from('servicereport sr')
		->leftjoin('workorder w', 'w.id=sr.reportno')
		->leftjoin('firm f', 'f.id=w.firmid')
		->leftjoin('firm fb', 'fb.id=w.branchid')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->leftjoin('client c', 'c.id=cb.parentid')
		->leftjoin('visittype vt', 'vt.id=w.visittypeid')
		->leftjoin('user u', 'u.id=w.staffid')
		->leftjoin('user ux', 'ux.id=sr.saver_id')
		->leftjoin('staffteam st', 'st.id=w.teamstaffid')
		->leftjoin('user uts', 'uts.id=st.leaderid')
		->where('sr.id='.$_GET['id'])
		->queryall();
      if ($workorders[0]['teknisyen_saver']==''){
        $workorders[0]['teknisyen_saver']=  $workorders[0]['teknisyen'];
      }
			//print_r($workorders);exit;
		$firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));
    //  print_r($firm->servicereport_color);exit;
		$anarenk="#00a748";
$alternatifrenk="#33937f";
	$renksecim=$anarenk;
      if ($firm->servicereport_color<>''){
        $renksecim=$firm->servicereport_color;
      }
	if ($workorders[0]['firmid']==646){
	//	$renksecim=$alternatifrenk;
	}
	
	if ($workorders[0]['simple_client']=='1'){
		$is_simple=true;
	}else{
			$is_simple=false;
	}
	if ($workorders[0]['is_published']=='1'){
		$is_published=true;
	}else{
			$is_published=false;
	}

		 $permission=User::model()->userpagepermission($workorders[0]['firmid'],$workorders[0]['fbid'],$workorders[0]['cid'],$workorders[0]['cbid']);
		 if($permission==0)
		 {
			 header('Location: /site/notpages');
			 exit;
		 }
		 
  $basla=strtotime("today", $workorders[0]['realendtime']);
  $bit=strtotime("today", $workorders[0]['realendtime'])+86400;
  $bit2=strtotime("today", $workorders[0]['realendtime'])+(86400*5);

		$uygunsuzluklar= Yii::app()->db->createCommand()
		->select('c.*,cb.name cbname')
		->from('conformity c')
		->leftjoin('client cb', 'cb.id=c.clientid')
		//->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit.' and c.workorderid='.$workorders[0]['wid'])
		->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit2.' and c.workorderid='.$workorders[0]['wid'])
		->order('c.numberid asc')
		->limit(50)
		->queryall();
		
	if ($is_simple){
			$acikiemirleri = [];
		
  
	}else{
				$acikiemirleri = Yii::app()->db->createCommand()
		->select('w.*,cb.name cbname,IF(w.statusid=0,"Askıda",IF(w.statusid=5,"Görüldü","Devam Ediyor")) status')
		->from('conformity w')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->where('w.clientid='.$workorders[0]['clientid'].' and w.statusid in (4,5,0) and w.date<'.$bit.' and w.workorderid<>'.$workorders[0]['wid'])
		->queryall();
  
	}

  
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
	if($workorders[0]['firmid']==538){
    $technician_sign= 'https://insectram.io'.'/uploads/Tepetesisyonetimi1/tepe_imza.jpg';
  }else{
 
    $img_file = $workorders[0]['technician_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
$technician_sign = $filePath.'.jpg';
    transparent_background($technician_sign,'0,0,0',$input_file);
    
  }
    
  $img_file = $workorders[0]['client_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
$client_sign = $filePath.'.jpg';
transparent_background($client_sign,'0,0,0',$input_file);

//echo mime_content_type($base);exit;








/*
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
      $rstartTime=t("Henüz Başlanmadı.");
    }

    if($workorder['realendtime'] && $workorder['executiondate']!='')
    {
        $rfinishTime=date("Y-m-d - H:i",$workorder['realendtime']);
    }
    else{
      $rfinishTime=t("Henüz Bitirilmedi.");
    }

  
    $veriler .= "<tr>"; 
    if(isset($_POST['Report']['firm']))
    {
		
		
      $veriler .= "<td>".$workorder['cname']."</td>";
    }
    
	  $veriler .= "<td>".$workorder['cbname']."</td>";
	  if($firmid==538)
		{
			$veriler .= "<td>".$workorder['client_code']."</td>";
		}
		
      $veriler .="<td>".$workorder['date']." - ".$workorder['start_time']."</td>
      <td>".$workorder['date']." - ".$workorder['finish_time']."</td>
      <td>".$rstartTime."</td>
      <td>".$rfinishTime."</td>
      <td>".t($visitype)."</td>
    </tr>";

  }
}
*/
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

	if ($is_simple){
		$uygunsuzlukdate=date('d/m/Y',$uygunsuzluk['date']);
	}else{
					$uygunsuzlukdate=date('d/m/Y H:i',$uygunsuzluk['date']);
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
			 '.$uygunsuzlukdate.'
	    </td>
      
		<td colspan="1" style="padding:2px">
			 '.t(Conformitystatus::model()->find(array('condition'=>'id='.$uygunsuzluk['statusid']))->name).'
	    </td>
	</tr>';
  if ($uygunsuzluk['statusid']==0 || $uygunsuzluk['statusid']==5  ){
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
$rmdegisen=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=10 and  petid=49 and value in (1,2))'));
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
$cidegisen=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=6 and  petid=49 and value in (1,2))'));
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


$ciyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=29 and  petid=83 and value=1 )'));
$ciyapiskanvalue=0;
foreach($ciyapiskan as $item){
$ciyapiskanvalue+=$item->value;
}

if ($ciyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
 '.t('WP Fluid Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			<center> '.$ciyapiskanvalue.'</center>
	    </td>
	</tr>';
}

/// LT


//print_r($workorders);exit;
//$ltdegisen=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=19 and  petid=85 and value in (1,2))'));
$efkshtdegisen=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=19 and  petid=85 and value=1)'));
$efkshtdegisenvalue=0;
foreach($efkshtdegisen as $item){
$efkshtdegisenvalue++;
}

if ($efkshtdegisenvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
		'.t('Shatter Proof Tube Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
		<center>	 '.$efkshtdegisenvalue.'</center>
	    </td>
	</tr>';
}


$efktubeyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=19 and  petid=86 )'));
$efktubeyapiskanvalue=0;
foreach($efktubeyapiskan as $item){
$efktubeyapiskanvalue+=$item->value;
}

if ($efktubeyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('EFK Led Tube Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
		<center>	 '.$efktubeyapiskanvalue.'</center>
	    </td>
	</tr>';
}


$lftyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=19 and  petid=34 )'));
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
      
      
      
$mtyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=9 and  petid=50 )'));
$mtyapiskanvalue=0;
foreach($mtyapiskan as $item){
$mtyapiskanvalue+=$item->value;
}

if ($mtyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('MT Pheromone Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			 <center>'.$mtyapiskanvalue.'</center>
	    </td>
	</tr>';
}
      
$ltyyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=23 and  petid=39 )'));
$ltyyapiskanvalue=0;
foreach($ltyyapiskan as $item){
$ltyyapiskanvalue+=$item->value;
}

if ($ltyyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('LT Glueboard Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			 <center>'.$ltyyapiskanvalue.'</center>
	    </td>
	</tr>';
}

      
         
$idyyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( monitortype=27 and  petid=39 )'));
$idyyapiskanvalue=0;
foreach($idyyapiskan as $item){
$idyyapiskanvalue+=$item->value;
}

if ($idyyapiskanvalue>0){
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('ID Glueboard Changed').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			 <center>'.$idyyapiskanvalue.'</center>
	    </td>
	</tr>';
}

      
          
$badbaityapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and (   petid=48 )'));
$badbaityapiskanvalue=0;
foreach($badbaityapiskan as $item){
$badbaityapiskanvalue+=$item->value;
}

if ($badbaityapiskanvalue>0){// >0 olacaktı gizlemek için ekledik
  $materials_used.='<tr>
		<td style="padding:2px"  colspan="6">
'.t('Bad Bait.').'
	    </td>
	
		<td style="padding:2px"  colspan="4">
			 <center>'.$badbaityapiskanvalue.'</center>
	    </td>
	</tr>';
}



//$cldegisen=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));
//$clyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));

//$ltdegisen=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));
//$ltyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));


//$lftyapiskan=Mobileworkorderdata::model()->findall(array('condition'=>'workorderid='.$workorders[0]['wid'].' and ( petid in (34,39,49))'));





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
	?>

						<div class="row">
							<div class="col-lg-10  col-md-10 offset-lg-1 offset-md-1 ">
								<div class="card">
											<?php
											if(!$is_simple){
											?>
									<div class="card-content" style="padding:15px;">
										<center>
									
											
											<?=t('Now before being able to print out your VR you need to interact with Recommendations Section using the links on recommendation unique numbers and add a deadline and your action please.')?>
						
									</div>
												<?	
											}		?>
									<div>

										<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style="margin-top:20px;">
											<center>
												<?php
												
												
												
		if($is_simple  && ($ax->type==23 || $ax->type==13 )){
			if ($is_published ){
			?>
													<a target="" href="/site/servicereport4?id=<?=$_GET['id']?>&publish=0&languageok=en&pdf=ok" class="btn btn-warning block-page" ><?=t('Unpublish')?></a>
                        	<?	if($workorders[0]['firmid']==799){	?>	<a class="btn btn-success btn-md" style="color:white; margin-right: 5px;" onclick="showApprovedVR(<?=$_GET['id']?>)">
													<?=t('Approved VR')?>
												</a>
                      <?php }  ?>
													<a target="_Blank" href="/site/servicereport5?id=<?=$_GET['id']?>&languageok=en&pdf=ok" class="btn btn-primary block-page" ><?=t('Download PDF')?></a>
													<button onclick="sendmail_simple(<?=$_GET['id']?>)"  class="btn btn-primary block-page" id="sendemail" ><?=t('Send E-Mail')?></button>
													<?php				}else{
				
				?>
													<a target="" href="/site/servicereport4?id=<?=$_GET['id']?>&publish=1&languageok=en&pdf=ok" class="btn btn-primary block-page" ><?=t('Publish')?></a>
												<?php				//publish
			}
		}
												
												if (($ax->type!=23 && $ax->type!=13 ) && $is_published){ ?>
													
													
													<a target="_Blank" href="/site/servicereport5?id=<?=$_GET['id']?>&languageok=en&pdf=ok" class="btn btn-primary block-page" ><?=t('Download PDF')?></a>
                        		    	<?	if($workorders[0]['firmid']==799){	?>	<a class="btn btn-success btn-md" style="color:white; margin-right: 5px;" onclick="showApprovedVR(<?=$_GET['id']?>)">
													<?=t('Approved VR')?>
												</a>
                      <?php }  ?>
                        
													<button onclick="sendmail_simple(<?=$_GET['id']?>)"  class="btn btn-primary block-page" id="sendemail" ><?=t('Send E-Mail')?></button>
												<?	
												}
												
												
								if (!$is_simple)	{
  if ($button_disabled=='0'){
		

  ?>
														<a target="_Blank" href="/site/servicereport5?id=<?=$_GET['id']?>&languageok=en&pdf=ok" class="btn btn-primary block-page" ><?=t('Download PDF')?></a>
                        		    	<?	if($workorders[0]['firmid']==799){	?>	<a class="btn btn-success btn-md" style="color:white; margin-right: 5px;" onclick="showApprovedVR(<?=$_GET['id']?>)">
													<?=t('Approved VR')?>
												</a>
                      <?php }  ?>
														<?php	
  }  else{
   ?>
			<a href="#" class="btn btn-danger block-page" ><?=t('Please Check Recommendations Section')?></a>
		<?php    }
									}			
    ?>
															
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						
						<div class="row">
							<div class="col-lg-10  col-md-10 offset-lg-1 offset-md-1 ">
								<div class="card">
										
									<div>

										<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style="margin-top:20px;">
											<center>
								
																
																<?php if(intval($ax->clientid)==0 && !($ax->firmid==597 && $ax->type==19)){?>
																	<div class="float-right">
																<a class="btn btn-warning btn-md" style="color:white; " href="/conformity?workorderid=<?=$workorders[0]["id"];?>" target="_Blank" >
													<?=t('Open Non-Conformity');?>
												</a>	
																		<a class="btn btn-warning btn-md" style="color:white; " onclick="openmodal(this)">
													<?=t('Edit')?> 
												</a>
																		<a class="btn btn-warning btn-md" style="color:white; margin-right: 5px;" onclick="openfindingmodal(this)">
													<?=t('Attachments / Findings Edit or Create')?>
												</a>
									
																	</div>
																	<?php }?>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						


						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<!-- Modal -->
								<div class="modal fade text-left" id="duzenle2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
									<div class="modal-dialog modal-ml" role="document">
										<div class="modal-content">
											<div class="modal-header bg-warning white">
												<h4 class="modal-title" id="myModalLabel8">
													<?=t('Visit Report Update');?>
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
											</div>

											<form id="user-form1" action="/site/servicereportupdate" method="post">
												<div class="card-content">
													<div class="card-body">
														<div class="row">
															<input type="hidden" name="id" class="form-control" value="<?=$workorders[0]["id"];?>">
															<input type="hidden" name="reportno" class="form-control" value="<?=$workorders[0]['reportno'];?>">

															<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
																<label for="basicSelect"><?=t('Client Contact Person')?></label>
																<fieldset class="form-group">
																	<input type="text" name="trade_name" class="form-control" placeholder="<?=t('Client Contact Person')?>" value="<?=$workorders[0]["trade_name"];?>">
																</fieldset>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
																<label for="basicSelect"><?=t('Treatment and Observations')?></label>
																<fieldset class="form-group">
																	<?php	if($workorders[0]["treatment_and_observations"]=='') {
	$workorders[0]["treatment_and_observations"]=t('OK');
}
																									
																									?>
																		<textarea type="text" rows="7" name="treatment_and_observations" class="form-control" placeholder="<?=t('Treatment and Observations')?>"><?=strip_tags($workorders[0]["treatment_and_observations"]);?></textarea>

																</fieldset>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
																<label for="basicSelect"><?=t('Housekeeping')?></label>
																<fieldset class="form-group">
																	<?php	if($workorders[0]["housekeeping"]=='') {
	$workorders[0]["housekeeping"]=t('Housekeeping is in good conditon');
}
																									
																									?>
																		<textarea rows="7" type="text" name="housekeeping" class="form-control" placeholder="<?=t('Housekeeping')?>"><?=strip_tags($workorders[0]["housekeeping"]);?></textarea>
																</fieldset>
															</div>

															<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
																<label for="basicSelect"><?=t('Proofing')?></label>
																<fieldset class="form-group">
																	<?php	if($workorders[0]["proofing"]=='') {
	$workorders[0]["proofing"]=t('Proofing is in good condition');
}
																									
																									?>
																		<textarea type="text" rows="7" name="proofing" class="form-control" placeholder="<?=t('Proofing')?>"><?=strip_tags($workorders[0]["proofing"]);?></textarea>

																</fieldset>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
														<button class="btn btn-warning block-page-update" type="submit"><?=t('Update');?></button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							
								<div class="modal fade text-left" id="duzenle3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header bg-warning white">
												<h4 class="modal-title" id="myModalLabel8">
													<?=t('Visit Report Attachments / Findings Update');?>
												</h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
											</div>

												<div class="card-content">
													<div class="card-body">
														<div class="row">
														
														<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
														<form id="findings-create" method="post">				
																	<div class="row findings-s" >
																	<div class="col-xl-12 col-lg-12 col-md-12">
																							<label for="basicSelect" class="label-left"><?=t('Image');?></label>
																							<fieldset class="form-group">
																								<input type="file" name="Findings[picture_url]" class="form-control" placeholder="<?=t('Image');?>" value="">
																							</fieldset>
																						</div>
																						
																	<div class="col-xl-12 col-lg-12 col-md-12">
																							<label for="basicSelect" class="label-left"><?=t('Note');?></label>
																							<fieldset class="form-group">
																								
																								<textarea rows="7" type="text" name="Findings[note]" class="form-control" placeholder="<?=t('Note')?>"></textarea>
															
															
																							</fieldset>
																						</div>
																	<div class="col-xl-12 col-lg-12 col-md-12">
																							<button class="btn btn-success btn-sm" type="submit" style="width:100%"><?=t('Create');?></button>
																						</div>
																		<input type="hidden" name="id" class="form-control" value="0">
																		<input type="hidden" name="workorderid" class="form-control" value="<?=$workorders[0]["id"];?>">
																		<input type="hidden" name="reportno" class="form-control" value="<?=$workorders[0]['reportno'];?>">
																	
															</div>
															
															</form>
															</div>
														
															<div class='row' id='findings'>
									
							
														</div>
													</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
														
													</div>
												</div>
										</div>
									</div>
								</div>
							
							
							</div>
						</div>
						
						
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="findingsil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Finding Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->

						<form id='finding-form-delete'>

						<input type="hidden" class="form-control" id="findingid" name="Finding[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	

						<?php	
	$visitsuumm='';
	$summary=[];
	if(strlen($workorders[0]["visit_report_summary"])>4) {
	$summary=json_decode($workorders[0]["visit_report_summary"]);
		//print_r($summary);
}
																									if(isset($summary)){
																				
																										$visitsuumm='<br>';
																										foreach($summary as $idkf){
																									
																												
																									
																											$visitsuumm =$visitsuumm.'<b>'.''.$idkf->title.'</b><br>';
																									
																									
																											foreach($idkf->description as $descf){
																												
																													$visitsuumm =$visitsuumm.'&nbsp;'.$descf.' | ';
																											
																											}
																												$visitsuumm =$visitsuumm.'<br><br>';
																										}
																									}
              
              
              
    
                           // $id=$_GET["id"];
							$say2=0;
                            $mobileworkordermonitors=Mobileworkordermonitors::model()->findAll(array("condition"=>"workorderid=".$workorders[0]['wid'],'order'=>'monitorno asc'));
							//$workorder=Workorder::model()->findByPk($mobileworkordermonitors[0]->workorderid);
                 $veris=[];
              $say2=0; 
                            foreach($mobileworkordermonitors as $mobileworkordermonitor){
   
                            $mnonew=Monitoring::model()->findbypk($mobileworkordermonitor->monitorid);
                     if (isset($mnonew->alternativenumber) && trim($mnonew->alternativenumber)<>''){
$mobileworkordermonitor->monitorno=$mnonew->alternativenumber;
            }  
								$monitordurumu="secondary";
								$say2++;
								$mobileworkordatas=Mobileworkorderdata::model()->findall(array('condition'=>'mobileworkordermonitorsid='.$mobileworkordermonitor->id));
								$say=0;
								$veriler="";
								$goster="";
								if($mobileworkordermonitor->checkdate==0){    $veris[$mobileworkordermonitor->monitortype]['notchecked'][]=$mobileworkordermonitor->monitorno;  $monitordurumu="danger";}else{
                  $veris[$mobileworkordermonitor->monitortype]['checked'][$mobileworkordermonitor->monitorno]=1;
                }
                         
                           
                              
								foreach ($mobileworkordatas as $mobileworkordata){
									$say++;
                  		if($mobileworkordata->petid==49){
                      
                        // $veris[$mobileworkordata->monitortype]['checked']=$say2;
                        $val='';
										if($mobileworkordata->value==1){ $val="Lost";}
										if($mobileworkordata->value==2){ $val="Broken";}
										if($mobileworkordata->value==3){ $val="Unreacheble";}
                          $veris[$mobileworkordata->monitortype][$val][]=$mobileworkordermonitor->monitorno;  
                         continue;
									}
									else{
                    if ($mobileworkordata->value>0 ){
                        if ($mobileworkordata->isproduct==0){
                       $veris[$mobileworkordata->monitortype]['activity'][$mobileworkordermonitor->monitorno]=1; 
                     continue;
                          }else{
                         //      $veris[$mobileworkordata->monitortype]['activity'][$mobileworkordermonitor->monitorno]=$mobileworkordata->value; 
                          $typenms=	$pet=Pets::model()->findByPk($mobileworkordata->petid);
                          
                           $veris[$mobileworkordata->monitortype]['xx!!'.t($typenms->name)][$mobileworkordermonitor->monitorno]=$mobileworkordata->value;  
                     continue;
                        
                        }
                    }
                    
										//$val=$mobileworkordata->value;
									}
                }
                            
                                                      
                /*                                                  
									$pet=Pets::model()->findByPk($mobileworkordata->petid);
							
									$veriler =$veriler.  'data-id'.$say.'="'.$mobileworkordata->id.'"
												  data-petid'.$say.'="'.$mobileworkordata->petid.'"
												  data-petname'.$say.'="'.t($pet->name).'" 
												  data-checkdate="'.date("d/m/Y H:i",$mobileworkordermonitor->checkdate).'"
												  data-value'.$say.'="'.$mobileworkordata->value.'"';
									$goster= $goster .' '. t($pet->name). ' : '.t($val).' <br> ';
								}
                              $texh=User::model()->findbypk($mobileworkordata->saverid);
                              if ($texh){
                                 $goster=$goster.'Tech: '.$texh->name.' '.$texh->surname;
                              }else{
                                  $goster='-';
                              }
                             
*/
						
                             

} 
       //    print_r($veris);
              if ($ax->firmid==52 || 1==1){
              		if(isset($veris)){
																				
                    $visitsuumm='<br>';
                    foreach($veris as $idkf=>$mns){
                      $mname=Monitoringtype::model()->find(array('condition'=>'id='.$idkf));
                      

                      $visitsuumm =$visitsuumm.'<b>'.''.t($mname->name).' '.t('Monitoring Point Control').'</b><br>';
                       $visitsuumm =$visitsuumm.'&nbsp;'.t('Number of MPs checked:');
                      if (!$mns['checked']){
                        $visitsuumm =$visitsuumm.' '.t('none').' | ';
                      }else{
                        
                      foreach ($mns as $tips=>$ictips){
                        
                          if ($tips=='checked'){
                              $visitsuumm =$visitsuumm.count($ictips).' | ';
                          }
                      }
                      }
                           
                      
                        $visitsuumm =$visitsuumm.'&nbsp;'.t('MPs with pest activity at:');
                      if (!$mns['activity']){
                        $visitsuumm =$visitsuumm.' '.t('none').' | ';
                      }else{
                             foreach ($mns as $tips=>$ictips){
                     if ($tips=='activity'){
                            foreach($ictips as $ics=>$icstmp){
                              $visitsuumm= $visitsuumm.$ics.', ';
                            }
                            
                          }
                             }
                        
                              $visitsuumm=$visitsuumm.' | ';
                      }
                           
                       
                        $visitsuumm =$visitsuumm.'&nbsp;'.t('Lost MPs:');
                      if (!$mns['Lost']){
                        $visitsuumm =$visitsuumm.' '.t('none').' | ';
                      }else{
                             foreach ($mns as $tips=>$ictips){
                     if ($tips=='Lost'){
                            foreach($ictips as $ics=>$icstmp){
                              $visitsuumm= $visitsuumm.$icstmp.', ';
                            }
                            
                          }
                             }
                        
                              $visitsuumm=$visitsuumm.' | ';
                      }
                           
                      
                      
                               
                        $visitsuumm =$visitsuumm.'&nbsp;'.t('Broken MPs:');
                      if (!$mns['Broken']){
                        $visitsuumm =$visitsuumm.' '.t('none').' | ';
                      }else{
                             foreach ($mns as $tips=>$ictips){
                     if ($tips=='Broken'){
                            foreach($ictips as $ics=>$icstmp){
                              $visitsuumm= $visitsuumm.$icstmp.', ';
                            }
                            
                          }
                             }
                        
                              $visitsuumm=$visitsuumm.' | ';
                      }
                           
                      
                      
                               
                        $visitsuumm =$visitsuumm.'&nbsp;'.t('Unreacheble MPs:');
                      if (!$mns['Unreacheble']){
                        $visitsuumm =$visitsuumm.' '.t('none').' | ';
                      }else{
                             foreach ($mns as $tips=>$ictips){
                     if ($tips=='Unreacheble'){
                            foreach($ictips as $ics=>$icstmp){
                              $visitsuumm= $visitsuumm.$icstmp.', ';
                            }
                            
                          }
                             }
                        
                              $visitsuumm=$visitsuumm.' | ';
                      }
                      
                                       foreach ($mns as $mnsname=>$bfdfb){
                        if (strpos($mnsname,'!!')  ){ 
                          $mntscc=[];
                          foreach($bfdfb as $asr=>$svz){
                            
                          $mntscc[]=$asr;
                            
                          }
                          $mnsname=explode ('!!',$mnsname);
                          $mnsname=$mnsname[1];
                          $visitsuumm =$visitsuumm. ' '.t($mnsname." - MPs")." : ".implode(',',$mntscc).' | ';
                         //e print_r($bfdfb);
                     
                                   }

                                       }
                      
          
                      
                   
              
                        $visitsuumm =$visitsuumm.'<br><br>';
                    }
							    }
              
              }
              
             
              
																							
																									
	$sonsecilenler=	$workorders[0]['security_precautions'];
	// 32515 idli olan hepsi seçili servicereport
	// 32516 idli olan no geldi hiç bir şey seçilmedi
	// 32517 idli olan yes geldi hiç bir şey seçilmedi
	$riskc=t('Technician has confirmed that an assessment relating to CRRU has been undertaken and completed. Check as below;').'<br>';
	if ($sonsecilenler<>''){
		$sonsecilenler=json_decode($sonsecilenler);
		foreach($sonsecilenler as $itemxr){
	
		//	if ($itemxr->id=='TreatmentNotSafe'){
			if ($itemxr->id=='Bats'){
				break;
			}else{
				if($itemxr->answer){
				$riskc.=t($itemxr->question).' '.t('(Yes)').' .';
			} 
				array_shift($sonsecilenler);
			}
			
		}
		
		
				foreach($sonsecilenler as $itemxr){
				if($itemxr->answer){
							$riskc.='<br><br><br> <b>'.t('PROTECTED SPECIES').'</b><br>';
					break;
			} 
		}
		
		
				foreach($sonsecilenler as $itemxr){
				if($itemxr->answer){
							$riskc.=t($itemxr->question).' '.t('(Yes)').' .';
			} 
		}
		


		
	}else{
		$riskc=t('Technician has confirmed that an assessment relating to CRRU is not needed.');
	}
	
	$init = $workorders[0]['realendtime']-$workorders[0]['realstarttime'];
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;
	$totti='';
	if ($hours>1){
			$hoi="$hours ".t('hours');
	}else if ($hours==1){
					$hoi="$hours ".t('hour');
	}else{
					$hoi="";
	}
	
	if ($minutes>0){
			$minu="$minutes ".t('minutes');
	}else if ($minutes==1){
					$minu="$minutes ".t('minute');
	}else{
					$minu=t("1 minute");
	}
	$totti=$hoi.$minu;
	
	

																									?>


							<div class="col-lg-10  col-md-10 offset-lg-1 offset-md-1 ">
								<div class="card">
									<div class="card-content" style="padding:15px;">
										<?php $html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><style>
.f12
{
	font-size:10px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
font-size:10pt;
}
td {
font-family:Arial;
font-size:8pt;
}

.noneColer{
	border:none !important;
}

</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<thead>
	<tr class="noneColer">
		<td align="left" colspan="2" class="noneColer">
			 <img src="'.$resim.'" border="0" width="125px">
		</td>
		<td align="center" colspan="6" class="noneColer">
			 <b><h2>'.mb_strtoupper($workorders[0]['fname'],"UTF-8").' <br> '.t('TREATMENT REPORT').'</h2></b>
		</td>
		<td align="right" colspan="2" class="noneColer">
			 <p style="font-size=10px">
			 '.$workorders[0]['fname'].'<br>
		
			 '.$workorders[0]['address'].' <br>
			 '.t('Tel').': '.$workorders[0]['landphone'].'<br>
			  '.$workorders[0]['email'].'
</p>
		</td>
	</tr>
	
</thead>
	<tbody>
		<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
	<tr>
		<td align="left" colspan="2" class="noneColer">
			 <b>'.t('Client').':</b><br>
			    '.ucwords($workorders[0]['client_name']).'<br>
			    '.$workorders[0]['cbadres'].'<br>
		</td>
		<td align="center" colspan="5" class="noneColer" style="padding-left:100px">
			 <b>
			 '.t('Visit Type').'
			 <h1><u>'.t($workorders[0]['visittype']).'</u></h1>
			 </b>
		</td>
		<td align="right" colspan="3" class="noneColer">
			 <b>'.t('Treatment Date').':</b> '.date('d/m/Y',$workorders[0]['realendtime']).'<br>
			<b>'.t('Contract/Job Number').':</b> '.$workorders[0]['reportno'].'<br>
			<b>'.t('Technician').':</b> '.ucwords($workorders[0]['teknisyen_saver']).'<br>
			';
							if (!$is_simple){
                 if($workorders[0]['firmid']==799 || $workorders[0]['firmid']==717){
                  }else{
			$html.='<b>'.t('Sign IN/OUT times').':</b> '.date("H:i", $workorders[0]['realstarttime']).' - '.date("H:i", $workorders[0]['realendtime']).'<br>
			<b>'.t('Total Time').':</b> '.$totti.'<br>
			';}
								}
							$html.='
			<!--<b>'.t('Visit Number').':</b> V21317<br>-->
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
	<tr>
	
	
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('DESCRIPTION OF WORKS').'</b><br>
			  '.$workorders[0]['visittype'].' 
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>

	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('HEALTH & SAFETY RISK ASSESSMENT').'</b><br>
       '.t('Technican has confirmed that; All hazards and risks have been considered prior to work commencing. All works completed are covered by our safe working practices. Current site risk assesment is understood and inspection for rodent carcasses done.').'
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>

	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('ENVIRONMENTAL RISK ASSESSMENT').'</b><br>
     '.$riskc.'
		</td>
	</tr>
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>

	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('CAMPAIGN FOR RESPONSIBLE RODENTICIDE USAGE').'</b><br>
			  '.t('Technician has confirmed that an assessment relating to CRRU has been undertaken and completed if necessary.').' 
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>

	<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Treatment and Observations').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="left" colspan="10" >
		'.$workorders[0]['treatment_and_observations'].'<br><br>
	    </td>
	</tr>
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>

	<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="5" style="color:#fff">
			 <b>'.t('Housekeeping').'</b><br>
	    </td>
		<td align="center" colspan="5" style="color:#fff">
			 <b>'.t('Proofing').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="left" colspan="5">
			 '.$workorders[0]['housekeeping'].'<br><br>
	    </td>
		<td align="left" colspan="5">
			 '.$workorders[0]['proofing'].'<br><br>
	    </td>
	</tr>
	
	
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
';
              
                       
  if ($button_disabled=='0'){
    	$html.='<tr  bgcolor="'.$renksecim.'">';
  }else{
        	$html.='<tr  bgcolor="red">';
  }
      

              
  
	$html.='<td align="center" colspan="10" style="color:#fff">
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
	
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>
	<tr>
	<tr  bgcolor="'.$renksecim.'">
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
	<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Materials Used').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="center" colspan="6">
			 <b>'.t('Description.').'</b>
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
		
	<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Visit Summary').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="left" colspan="10" style="word-break: break-word;">
		'.$visitsuumm.'<br>
	    </td>
	</tr>	
		
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br><br>
		</td>
		</tr>';
							if (!$is_simple){
								
			$html.='
	<tr>
	<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Open Actions from Previous Visits').'</b><br>
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
	'.$acik_is_emirleri;
							
							}
							$html.='
	
	
	
	
	
	

    
    ';
                     	    $findings=  Findings::model()->findAll(array("condition"=>"workorder_id=".$workorders[0]['wid'], 'order'=>'id asc'));

    if (is_countable($findings) && count($findings)>0){
	$htmlconf='	<tr>
	<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Attachments / Findings').'</b><br>
	    </td>
	</tr><br><table width="100%">
  ';
}else{
	$htmlconf='';
}

$say=0;
foreach($findings as $uygunsuzluk)
{
	$say++;
if ($say==1){
	$htmlconf.='<tr>';
}

	$htmlconf.='	
        <td  style="width:800px; padding-top:15px;" align="center">	<center><img src="'.$uygunsuzluk->picture_url.'"  style="background: white; max-height:750px;  width:100%;"></center>
				<br><div style="width:100%; font-size:25px;"><b>Note:</b> '.$uygunsuzluk->note.'<br> </div></td>

	';
		if ($say==2){
	$htmlconf.='</tr>';
			$say=0;
}
	
}
if ($say==1){
	$htmlconf.='</tr>';
}                
                    
	$html.=$htmlconf.'
  		</tbody></table>
		</div>
		</div>
		</div>
		</body></html>';
////'.$veriler.$stokKimyasal.$veriler2.'

echo $html;
?>
											<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>
											<?php  if (!isset($_GET['ajaxref'])){
    
    ?>
									</div>
									<?php  }
    
    ?>
<style>
.label-left{
	 float: left;
    padding: 8px;
    margin-left: -22px;
}
.findings-s{
    border: 1px solid #dbdbdb;
    padding: 8px;
    border-radius: 5px;
}
</style>

<!-- Approved VR Modal -->
<?php
// Handle file upload if form was submitted
if (isset($_FILES['approved_vr_image']) && isset($_POST['workorder_id'])) {
    $workorderId = $_POST['workorder_id'];
    $uploadResult = uploadApprovedVRImage($workorderId);
    
    // If this is an AJAX request, return JSON response
    if (Yii::app()->request->isAjaxRequest) {
        echo json_encode($uploadResult);
        Yii::app()->end();
    }
}

// Function to get approved VR image from database
function getApprovedVRImage($id) {
    $result = ['success' => false];
    
    if ($id) {
        $servicereport = Yii::app()->db->createCommand()
            ->select('approved_vr_image')
            ->from('servicereport')
            ->where('id=:id', array(':id' => $id))
            ->queryRow();
        
        if ($servicereport && !empty($servicereport['approved_vr_image'])) {
            $result = [
                'success' => true,
                'imageUrl' => $servicereport['approved_vr_image']
            ];
        }
    }
    
    return $result;
}

// Function to handle file upload and database update
function uploadApprovedVRImage($workorderId) {
    global $firm; // Use the existing $firm variable
    $response = ['success' => false, 'message' => 'Upload failed'];
    
    if (!$workorderId) {
        $response['message'] = 'Invalid workorder ID';
        return $response;
    }
    
    // Use the existing $firm variable which is already defined
    if (!$firm || !$firm->username) {
        // Fallback to getting firm info if $firm is not available
        // Get firm from workorders using the firmid
        global $workorders;
        if (isset($workorders[0]['firmid'])) {
            $firm = Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));
        }
        
        // If still not found, try to get from current user
        if (!$firm || !$firm->username) {
            $currentUserId = Yii::app()->user->id;
            $user = User::model()->find('id=:id', array(':id' => $currentUserId));
            if ($user && $user->firmid) {
                $firm = Firm::model()->findByPk($user->firmid);
            }
            
            if (!$firm || !$firm->username) {
                $response['message'] = 'Firm not found';
                return $response;
            }
        }
    }
    
    // Check if the uploads directory exists, if not create it
    $uploadDir = Yii::getPathOfAlias('webroot') . '/uploads/' . $firm->username;
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Handle file upload
    if (isset($_FILES['approved_vr_image']) && $_FILES['approved_vr_image']['error'] == 0) {
        $file = $_FILES['approved_vr_image'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'application/pdf'];
        if (!in_array($file['type'], $allowedTypes)) {
            $response['message'] = 'Invalid file type. Only JPG, PNG, GIF and PDF are allowed.';
            return $response;
        }
        
        // Generate a unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $randomUniqueName = 'approved_vr_' . uniqid() . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . '/' . $randomUniqueName;
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Update the servicereport table
            $imageUrl = '/uploads/' . $firm->username . '/' . $randomUniqueName;
            
            // Check if there's an existing servicereport record
            $servicereport = Yii::app()->db->createCommand()
                ->select('id')
                ->from('servicereport')
                ->where('id=:id', array(':id' => $workorderId))
                ->queryRow();
            
            if ($servicereport) {
                // Update existing record
                Yii::app()->db->createCommand()->update('servicereport', 
                    array('approved_vr_image' => $imageUrl),
                    'id=:id', array(':id' => $workorderId)
                );
            } else {
                // Insert new record
                Yii::app()->db->createCommand()->insert('servicereport', array(
                    'id' => $workorderId,
                    'approved_vr_image' => $imageUrl
                ));
            }
            
            $response = [
                'success' => true,
                'message' => 'Image uploaded successfully',
                'imageUrl' => $imageUrl
            ];
        }
    }
    
    return $response;
}
?>
<style>
/* Approved VR Modal styles */
#approvedVRModal .modal-dialog {
    max-width: 90%;
    margin: 1.75rem auto;
}

#approvedVRModal .modal-body {
    padding: 1rem;
    text-align: center;
    max-height: 80vh;
    overflow: auto;
}

#approvedVRImageContainer img {
    max-width: 100%;
    max-height: 50vh; /* Reduced height to make room for upload form */
    object-fit: contain;
}
</style>

<div class="modal fade text-left" id="approvedVRModal" tabindex="-1" role="dialog" aria-labelledby="approvedVRModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h4 class="modal-title" id="approvedVRModalLabel"><?=t('Approved VR Image')?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div id="approvedVRImageContainer" class="text-center">
                            <!-- Content will be loaded by PHP when modal is shown -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="upload-section" style="border-left: 1px solid #eee; padding-left: 15px;">
                            <h5><?=t('Upload New Approved VR Image')?></h5>
                            <form id="approvedVRUploadForm" enctype="multipart/form-data" method="post">
                                <input type="hidden" id="approvedVRWorkorderId" name="workorder_id" value="">
                                <div class="form-group">
                                    <label for="approvedVRImageFile"><?=t('Select Image or PDF')?></label>
                                    <input type="file" class="form-control" id="approvedVRImageFile" name="approved_vr_image" accept="image/*,.pdf" required>
                                </div>
                                <div class="progress" style="display: none;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                </div>
                                <div id="uploadStatus" class="mt-2"></div>
                                <button type="submit" class="btn btn-primary mt-2"><?=t('Upload')?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close')?></button>
                <a id="downloadApprovedVRBtn" href="#" class="btn btn-success" download style="display: none;"><?=t('Download Approved VR File')?></a>
            </div>
        </div>
    </div>
</div>
										<script>
                                            function showApprovedVR(id) {
                                                // Get the approved VR image data directly from PHP
                                                <?php
                                                echo "var vrImageData = {};"; // Initialize empty object
                                                echo "var vrImages = {};"; // Store all VR images
                                                
                                                // Get all workorder IDs that might be displayed
                                                if (isset($workorders) && is_array($workorders)) {
                                                    foreach ($workorders as $wo) {
                                                        if (isset($wo['id'])) {
                                                            $vrData = getApprovedVRImage($wo['id']);
                                                            echo "vrImages[" . $wo['id'] . "] = " . json_encode($vrData) . ";";
                                                        }
                                                    }
                                                } else if (isset($workorders[0]['id'])) {
                                                    // Single workorder case
                                                    $vrData = getApprovedVRImage($workorders[0]['id']);
                                                    echo "vrImages[" . $workorders[0]['id'] . "] = " . json_encode($vrData) . ";";
                                                }
                                                ?>
                                                
                                                // Set the workorder ID in the upload form
                                                $('#approvedVRWorkorderId').val(id);
                                                $('#approvedVRModal').modal('show');
                                                
                                                // Use the pre-loaded data
                                                var response = vrImages[id] || {success: false};
                                                if (response.success && response.imageUrl) {
                                                    if (response.imageUrl.toLowerCase().endsWith('.pdf')) {
                                                        // For PDF files, show an embed or object tag
                                                        $('#approvedVRImageContainer').html('<object data="' + response.imageUrl + '" type="application/pdf" width="100%" height="500px"><p>Your browser does not support PDFs. <a href="' + response.imageUrl + '">Click here to download the PDF</a>.</p></object>');
                                                    } else {
                                                        // For images, show an img tag
                                                        $('#approvedVRImageContainer').html('<img src="' + response.imageUrl + '" class="img-fluid" alt="Approved VR Image">');
                                                    }
                                                    $('#downloadApprovedVRBtn').attr('href', response.imageUrl);
                                                    $('#downloadApprovedVRBtn').show();
                                                } else {
                                                    $('#approvedVRImageContainer').html('<p><?=t("No approved VR image found")?>.</p>');
                                                    $('#downloadApprovedVRBtn').hide();
                                                }
                                            }
                                            
                                            // Handle the Approved VR image upload
                                            $(document).ready(function() {
                                                $('#approvedVRUploadForm').on('submit', function(e) {
                                                    e.preventDefault();
                                                    
                                                    var formData = new FormData(this);
                                                    var workorderId = $('#approvedVRWorkorderId').val();
                                                    
                                                    // Show progress bar
                                                    $('#approvedVRUploadForm .progress').show();
                                                    
                                                    $.ajax({
                                                        url: window.location.href, // Submit to the current page
                                                        type: 'POST',
                                                        data: formData,
                                                        contentType: false,
                                                        processData: false,
                                                        xhr: function() {
                                                            var xhr = new window.XMLHttpRequest();
                                                            xhr.upload.addEventListener('progress', function(evt) {
                                                                if (evt.lengthComputable) {
                                                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                                                    $('.progress-bar').css('width', percentComplete + '%');
                                                                }
                                                            }, false);
                                                            return xhr;
                                                        },
                                                        success: function(response) {
                                                            try {
                                                                // Parse the response if it's not already a JSON object
                                                                if (typeof response === 'string') {
                                                                    // Check if the response starts with HTML content
                                                                    if (response.trim().startsWith('<!DOCTYPE') || response.trim().startsWith('<html')) {
                                                                        // This is an HTML response, likely a redirect or full page
                                                                        // Consider it a success and reload the page
                                                                        $('#uploadStatus').html('<div class="alert alert-success"><?=t("Upload successful! Refreshing page...")?></div>');
                                                                        setTimeout(function() {
                                                                            window.location.reload();
                                                                        }, 1000);
                                                                        return;
                                                                    }
                                                                    
                                                                    // Try to parse as JSON
                                                                    response = JSON.parse(response);
                                                                }
                                                                
                                                                if (response.success) {
                                                                    $('#uploadStatus').html('<div class="alert alert-success">' + response.message + '</div>');
                                                                    
                                                                    // Update the displayed image or PDF
                                                                    if (response.imageUrl.toLowerCase().endsWith('.pdf')) {
                                                                        // For PDF files, show an embed or object tag
                                                                        $('#approvedVRImageContainer').html('<object data="' + response.imageUrl + '" type="application/pdf" width="100%" height="500px"><p>Your browser does not support PDFs. <a href="' + response.imageUrl + '">Click here to download the PDF</a>.</p></object>');
                                                                    } else {
                                                                        // For images, show an img tag
                                                                        $('#approvedVRImageContainer').html('<img src="' + response.imageUrl + '" class="img-fluid" alt="Approved VR Image">');
                                                                    }
                                                                    $('#downloadApprovedVRBtn').attr('href', response.imageUrl);
                                                                    $('#downloadApprovedVRBtn').show();
                                                                    
                                                                    // Update the cached image data
                                                                    vrImages[workorderId] = {
                                                                        success: true,
                                                                        imageUrl: response.imageUrl
                                                                    };
                                                                    
                                                                    // Reset the form
                                                                    $('#approvedVRImageFile').val('');
                                                                    
                                                                    // Reload the page after a short delay to ensure everything is updated properly
                                                                    setTimeout(function() {
                                                                        window.location.reload();
                                                                    }, 1000);
                                                                } else {
                                                                    $('#uploadStatus').html('<div class="alert alert-danger">' + response.message + '</div>');
                                                                }
                                                            } catch (e) {
                                                                // If response is not JSON, assume success and reload
                                                                $('#uploadStatus').html('<div class="alert alert-success"><?=t("Upload successful! Refreshing page...")?></div>');
                                                                console.log('Response was not JSON, assuming success:', e);
                                                                
                                                                // Reload the page after a short delay
                                                                setTimeout(function() {
                                                                    window.location.reload();
                                                                }, 1000);
                                                            }
                                                        },
                                                        error: function() {
                                                            $('#uploadStatus').html('<div class="alert alert-danger"><?=t("Upload failed. Please try again.")?></div>');
                                                        },
                                                        complete: function() {
                                                            // Hide progress bar
                                                            setTimeout(function() {
                                                                $('#approvedVRUploadForm .progress').hide();
                                                                $('.progress-bar').css('width', '0%');
                                                            }, 1000);
                                                        }
                                                    });
                                                });
                                            });
                                            
											function sendmail_simple(id){
												$('#sendemail').prop("disabled", true);
												$('#sendemail').text('Please Wait...'); 
												$.ajax({
            type : "GET",  //type of method
            url  : "/site/servicereport6?id="+id+"&languageok=en",  //your page
            success: function(res){  
								$('#sendemail') .prop("disabled", false);
												$('#sendemail').text( 'Send E-Mail'); 
alert(res);
					
                    }
        });
    }
											
											function openmodal(obj) {
												$('#duzenle2').modal('show');
											}
											function openfindingmodal(obj) {
												$('#duzenle3').modal('show');
											}
											
											
											
	
 $("#findings-update").on('submit',(function(e) {
    e.preventDefault();

	
 }));
 
 
 	
 $("#findings-create").on('submit',(function(e) {
    e.preventDefault();

	jQuery.ajax({
	   url:"/site/findingscu",
		data: new FormData(this),
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST', 
		success: function(data)
		{
			if(+data)
						{
							toastr.success("<center><?=t('Save successful!');?></center>", "<center><?=t('Successful!');?></center>", {
										positionClass: "toast-top-right",
										containerId: "toast-top-right"
										});
										findinglist();
						}
						else
						{
						toastr.error("<center><?=t('Save error!');?></center>", "<center><?=t('Error!');?></center>", {
										positionClass: "toast-top-right",
										containerId: "toast-top-right"
										});	
						}
		}
	});
 }));
 
 function findingdelete(id)
 {
	  $('#findingid').val(id);
	 $('#findingsil').modal('show');
 }
 function findingupdate(id)
 {
	// var fileInput = document.getElementById('picture_url_'+id);
    // var file = fileInput.files[0]; 
	 var formdata=new FormData();
	 formdata.append('id',$('#id_'+id).val());
	 formdata.append('workorderid',$('#workorderid_'+id).val());
	 formdata.append('reportno',$('#reportno_'+id).val());
	 // formdata.append('Findings[picture_url]',file);
	 formdata.append('Findings[note]',$('#note_'+id).val());
	 // console.log(formdata);
	 jQuery.ajax({
	   url:"/site/findingscu",
		data: formdata,
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST', // For jQuery < 1.9
		success: function(data)
		{
			if(+data)
			{
				toastr.success("<center><?=t('Save successful!');?></center>", "<center><?=t('Successful!');?></center>", {
							positionClass: "toast-top-right",
							containerId: "toast-top-right"
							});
			}
			else
			{
			toastr.error("<center><?=t('Save error!');?></center>", "<center><?=t('Error!');?></center>", {
							positionClass: "toast-top-right",
							containerId: "toast-top-right"
							});	
			}
		
		}
	});
	
 }
 $("#finding-form-delete").on('submit',(function(e) {
    e.preventDefault();

	jQuery.ajax({
	   url:"/site/findingdelete",
		data: new FormData(this),
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST', 
		success: function(data)
		{
			if(+data==1)
						{
							toastr.success("<center><?=t('Save successful!');?></center>", "<center><?=t('Successful!');?></center>", {
										positionClass: "toast-top-right",
										containerId: "toast-top-right"
										});
										findinglist();
						}
						else if(+data==2)
						{
						toastr.warning("<center><?=t('Not found!');?></center>", "<center><?=t('Warning!');?></center>", {
										positionClass: "toast-top-right",
										containerId: "toast-top-right"
										});	
						}
						else
						{
						toastr.error("<center><?=t('Save error!');?></center>", "<center><?=t('Error!');?></center>", {
										positionClass: "toast-top-right",
										containerId: "toast-top-right"
										});	
						}
						 $('#findingsil').modal('hide');
		}
	});
 }));
 
 findinglist();
 function findinglist()
 {
 	jQuery.ajax({
	   url:"/site/findinglist?workorderid=<?=$workorders[0]['wid'];?>&reportno=<?=$workorders[0]['reportno'];?>",
		cache: false,
		contentType: false,
		processData: false,
		method: 'GET',
		type: 'GET', 
		success: function(data)
		{
			$('#findings').html(data);
		}
	});
 }
 
										</script>