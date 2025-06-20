
<?php
	$langfileurl= '/home/ioinsectram/public_html/protected/modules/translate/languages/en.php';
   include $langfileurl;


$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$veriler="";
$sql="";
$ax= User::model()->userobjecty('');

$lguser=User::model()->findbypk($ax->id);

////// 542


/// yetki için
  $workorder=Workorder::model()->findByPk($workorders[0]['id']);
	 $cb=Workorder::model()->findByPk($workorder->clientid);
	/* $permission=User::model()->userpagepermission($workorder->firmid,$workorder->branchid,$cb->parentid,$workorder->clientid);
		 if($permission==0)
		 {
			// header('Location: /site/notpages');
			// exit;
		 }
		 */
	/// yetki için	 

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
		$anarenk="#00a748";
$alternatifrenk="#33937f";
	$renksecim=$anarenk;
	if ($workorders[0]['firmid']==646){
		$renksecim=$alternatifrenk;
	}

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

	if($workorders[0]['firmid']==538){
		
  //  $technician_sign= 'https://insectram.io'.'/uploads/Tepetesisyonetimi1/tepe_imza.jpg';
  }else{
 
    $img_file = $workorders[0]['technician_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
//$technician_sign = $filePath.'.jpg';
$technician_sign = $filePath;
  //  transparent_background($technician_sign,'0,0,0',$input_file);
    
  }
    
    $img_file = $workorders[0]['client_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
//$client_sign = $filePath.'.jpg';
$client_sign = $filePath;
//transparent_background($client_sign,'0,0,0',$input_file);
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
		$recommended_actions.='<tr>
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
		<td colspan="1" '.$bgdc.'>
			'.t($uygunsuzluk['priority'].'. Degree').'
	    </td>
		<td colspan="1" style="padding:2px">
			 '.$uygunsuzlukdate.'
	    </td>
      
		<td colspan="1" style="padding:2px">
			 '.t(Conformitystatus::model()->find(array('condition'=>'id='.$uygunsuzluk['statusid']))->name).'
	    </td>
	</tr>';
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
	
		if($workorders[0]["treatment_and_observations"]=='') {
	$workorders[0]["treatment_and_observations"]=t('No Treatment and Observations');
}											

	if($workorders[0]["housekeeping"]=='') {
	$workorders[0]["housekeeping"]=t('Housekeeping is in good conditon');
}
												
												if($workorders[0]["proofing"]=='') {
	$workorders[0]["proofing"]=t('Proofing is in good condition');
}
	//$workorders[0]['treatment_and_observations']=substr($workorders[0]['treatment_and_observations'],100);
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
                          $visitsuumm =$visitsuumm. ' '.t($mnsname." - MPs")." : ".implode(', ',$mntscc).' | ';
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
							$riskc.='<br> <b>'.t('PROTECTED SPECIES').'</b><br>';
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
																																								

$html='
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
			 <img src="'.$resim.'" border="0" width="95px">
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
			<br>
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
			 <h1><u>'.$workorders[0]['visittype'].'</u></h1>
			 </b>
		</td>
		<td align="right" colspan="3" class="noneColer">
			 <b>'.t('Treatment Date').':</b> '.date('d/m/Y',$workorders[0]['realendtime']).'<br>
			<b>'.t('Contract/Job Number').':</b> '.$workorders[0]['reportno'].'<br>
			<b>'.t('Technician').':</b> '.ucwords($workorders[0]['teknisyen_saver']).'<br>			';
							if (!$is_simple){
                  if($workorders[0]['firmid']==799 || $workorders[0]['firmid']==717){
                  }else{
			$html.='<b>'.t('Sign IN/OUT times').':</b> '.date("H:i", $workorders[0]['realstarttime']).' - '.date("H:i", $workorders[0]['realendtime']).'<br>
			<b>'.t('Total Time').':</b> '.$totti.'<br>
			';
                  }
								}
							$html.='
				<!--<b>'.t('Visit Number').':</b> V21317<br>-->
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
	<tr>
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('DESCRIPTION OF WORKS').'</b><br>
			  '.$workorders[0]['visittype'].' 
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('HEALTH & SAFETY RISK ASSESSMENT').'</b><br>
       Technican has confirmed that all hazards and risks have been considered prior to work commencing. All works completed are covered by our safe working practices.
			   '.substr($workorders[0]['security_precautions'],0,0).'
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('ENVIRONMENTAL RISK ASSESSMENT').'</b><br>
     '.$riskc.'
		</td>
	</tr>
	</tr>
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			 <b>'.t('CAMPAIGN FOR RESPONSIBLE RODENTICIDE USAGE').'</b><br>
			   Technician has confirmed that an assessment relating to CRRU has been undertaken and completed if necessary.
		</td>
	</tr>
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
</table>
<div style=" width:100% !important;    font-family: Arial;
    font-size: 8pt; border-style: solid;
    border-width: 1px;">
	<div  bgcolor="'.$renksecim.'" style=" width:100% !important;    font-family: Arial;
    font-size: 8pt;">
		<div	 align="center" coldiv="10" style="color:#fff; background:'.$renksecim.'; width:100% !important; text-aling:center;     font-family: Arial;
    font-size: 8pt;" >
			 <b>'.t('Treatment and Observations').'</b><br>
	    </div>
	</div>
	
	
		'.$workorders[0]['treatment_and_observations'].'<br>

	</tr>
</div>
	<table style="    width: 100%;">
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
	<tr>
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
			 '.$workorders[0]['housekeeping'].'<br>
	    </td>
		<td align="left" colspan="5">
			 '.$workorders[0]['proofing'].'<br>
	    </td>
	</tr>

   ';
if ($recommended_actions<>''){
  $html.='
  	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
	<tr>
	<tr  bgcolor="'.$renksecim.'">
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
	'.$recommended_actions;
}

if ($stokKimyasal<>''){
  $html.='
	
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
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
	
	'.$stokKimyasal;
	
}

if ($materials_used<>''){

	  $html.='
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
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
	
	'.$materials_used;
}
  
if (strlen($visitsuumm)>5){
$html.='
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
		
		<tr  bgcolor="'.$renksecim.'">
		<td align="center" colspan="10" style="color:#fff">
			 <b>'.t('Visit Summary').'</b><br>
	    </td>
	</tr>
	<tr>
		<td align="left" colspan="10" >
		'.$visitsuumm.'<br>
	    </td>
	</tr>	
	';}
	$html.='
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
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
	
	<tr>
		<td align="left" colspan="10" class="noneColer">
			<br>
		</td>
		</tr>
		
			<tr>
		<td align="left" colspan="10" class="noneColer">
		<b>	'.t('SIGN OF').'</b>
		</td>
		</tr>
	<tr>
		<td align="left" colspan="2" class="noneColer">
			<center> <br><b>'.t('Customer Name').'</b></center><br>
		</td>
		<td align="left" colspan="3" class="noneColer">
			 <b>
			 '.t('Customer Signature').'
			 </b><br>
		</td>
		<td align="left" colspan="3" class="noneColer">
			 <b>'.t('Technician Name').'</b><br>
		</td>
		<td align="center" colspan="2" class="noneColer">
			 <b>
			 '.t('Technician Signature').'
			 </b>
		</td>
	</tr>
	
	
	<tr>
		<td align="left" colspan="2" class="noneColer">
			<center>  '.ucwords($workorders[0]['trade_name']).'</center> <br>
		</td>
		<td align="left" colspan="3" class="noneColer">
		<img src="'.$client_sign.'"  width="125px" height="75px" style="background: white; ">
		</td>
		<td align="left" colspan="3" class="noneColer">
			 '.ucwords($workorders[0]['teknisyen_saver']).'<br>
		</td>
		<td align="center" colspan="2" class="noneColer">
			 <center><img src="'.$technician_sign.'"  width="125px" height="75px" style="background: white; "></center>
		</td>
	</tr>
	';
	if($workorders[0]['firmid']==799){
		
 
	$html.='
	<tr>
		<td align="center" colspan="10" class="noneColer">
			<br>
		</td>
	</tr>
	
	<tr>
		<td align="left" colspan="10" class="noneColer" style="padding-ledt:20px;">
			 <b>'.t('Date').'__________</b>
		</td>
	</tr>
	
	<tr>
		<td align="left" colspan="10" class="noneColer"  style="padding-ledt:20px;"><br>
			 <b>'.t('Quality Signature').'_______________</b>
		</td>
	</tr>
	
		';
    
     //  $technician_sign= 'https://insectram.io'.'/uploads/Tepetesisyonetimi1/tepe_imza.jpg';
  }
		$html.='	</tbody></table>

		</body></html>';
////'.$veriler.$stokKimyasal.$veriler2.'
//echo $html;exit;
$htmlconf22='';
if ($workorders[0]['picture']<>''){
  $htmlconf22='	<div width="100%" style="font-weight:bold; font-size:18px; text-align:center;"><center>Service Report Picture</center> <br>
  <center><img src="'.$workorders[0]['picture'].'"  style="background: white; max-height:950px;  width:100%;"></center>
  </div><br>
  ';
}
if (is_countable($findings) && count($findings)>0){
	$htmlconf='	<div width="100%" style="font-weight:bold; font-size:18px; text-align:center;"><center>Attachments / Findings</center></div><br><table width="100%">
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

if ($htmlconf<>''){
$htmlconf.='       
    </table>';}
//echo $html; exit;

?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>