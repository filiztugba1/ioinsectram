
<?php
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$veriler="";
$sql="";
$ax= User::model()->userobjecty('');

/// yetki için
  $workorder=Workorder::model()->findByPk($workorders[0]['id']);
	 $cb=Workorder::model()->findByPk($workorder->clientid);
	 $permission=User::model()->userpagepermission($workorder->firmid,$workorder->branchid,$cb->parentid,$workorder->clientid);
		 if($permission==0)
		 {
			 header('Location: /site/notpages');
			 exit;
		 }
	/// yetki için	 
		 
		 
$lguser=User::model()->findbypk($ax->id);




$stokKimyasal='';
$stokKimyasalmodelx = Yii::app()->db->createCommand()
  ->select('*')
		->from('activeingredients')
		->where('workorderid='.$workorders[0]['reportno'])
		->queryall();




$stokKimyasal .='<tr>
	<td colspan="2">'.($lguser->languageid!=8?t('Ürünün ticari adı, ruhsat tarihi ve sayısı'):t('Ürünün ticari adı, ruhsat tarihi ve sayısı').' <br/><i>(Trade name of the product, date and number of registration)</i>').'</td>
	<td colspan="2">'.($lguser->languageid!=8?t('Ürünün uygulama şekli'):t('Ürünün uygulama şekli').' <br/><i>(Product application method)</i>').'</td>
	<td colspan="2">'.($lguser->languageid!=8?t('Ürünün aktif maddesi'):t('Ürünün aktif maddesi').' <br/><i>(Active ingredient of the product)</i>').'</td>
	<td colspan="2">'.($lguser->languageid!=8?t('Ürünün antidotu'):t('Ürünün antidotu').' <br/><i>( Product antidote)</i>').'</td>
	<td colspan="2">'.($lguser->languageid!=8?t('Ürünün ambalajının miktarı'):t('Ürünün ambalajının miktarı').' <br/><i>(The amount of packaging of the product)</i>').'</td>
</tr>';

foreach($stokKimyasalmodelx as $stokKimyasalmodelt)
{
 
	 $eskitip=0;
                                          $stokKimyasalmodel=Stokkimyasalkullanim::model()->findbypk($stokKimyasalmodelt['tradeId']);
																					if ($stokKimyasalmodel){
																						
																					}else{
																						$stokKimyasalmodel=(object)'';
																						$stokKimyasalmodel->kimyasaladi=$stokKimyasalmodelt['trade_name'];
																						$stokKimyasalmodel->aktifmaddetanimi=$stokKimyasalmodelt['active_ingredient'];
																								 $meds=Stokkimyasalkullanim::model()->find(array('condition'=>'kimyasaladi="'.$stokKimyasalmodel->kimyasaladi.'"'));
																		 		
																				//	$unittype=Units::model()->findByPk($meds->urunAmbajBirimi);	 
																		 $stokKimyasalmodel->urunAmbajBirimi=$meds->urunAmbajBirimi;
																		 $stokKimyasalmodel->urunAmbajMiktari=$meds->urunAmbajMiktari;
																						
																						
																						$stokKimyasalmodel->yontem=$meds->yontem; 
																						$stokKimyasalmodel->urunAntidotu=$meds->urunAntidotu;
																						
																						
																						
																								 $eskitip=1;
																					}

$lguser=User::model()->findbypk($ax->id);
  
	$stokKimyasal .='<tr>
	<td colspan="2">'.$stokKimyasalmodel->kimyasaladi.'</td>
	<td colspan="2">'.$stokKimyasalmodel->yontem.'</td>
	<td colspan="2">'.$stokKimyasalmodel->aktifmaddetanimi.'</td>
	<td colspan="2">'.$stokKimyasalmodel->urunAntidotu.'</td>
	<td colspan="2">'.$stokKimyasalmodel->urunAmbajMiktari.' '.($stokKimyasalmodel->urunAmbajBirimi==0?'Adet':
	($stokKimyasalmodel->urunAmbajBirimi==1?'kg':
	($stokKimyasalmodel->urunAmbajBirimi==2?'lt':
	($stokKimyasalmodel->urunAmbajBirimi==3?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==4?'ml':'')
	)
	)
	)).'/'.$stokKimyasalmodelt['amount_applied'].' '.($stokKimyasalmodel->urunAmbajBirimi==0?'Adet':
	($stokKimyasalmodel->urunAmbajBirimi==1?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==2?'ml':
	($stokKimyasalmodel->urunAmbajBirimi==3?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==4?'ml':'')
	)
	)
	)).'</td>
</tr>';
}
$veriler .= 
'<tr class="noneColer">
	<td colspan="10" class="noneColer">'.'<br/><br/><b>'.($lguser->languageid!=8?t('BİYOSİDAL ÜRÜN UYGULAMA İŞLEM FORMU'):t('BİYOSİDAL ÜRÜN UYGULAMA İŞLEM FORMU').' <i>(BIOCIDAL PRODUCT APPLICATION PROCESS FORM)</i>').'</b><br/><br/></td>
</tr>
<tr class="noneColer">
	<td colspan="10" class="noneColer">'.'<br/><br/><b>'.($lguser->languageid!=8?t('UYGULAMAYI YAPANA AİT BİLGİLER'):t('UYGULAMAYI YAPANA AİT BİLGİLER').' <br/><i>(INFORMATION ABOUT THE APPLICATION)</i>').'</b><br/><br/></td>
</tr>

<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Uygulamayı yapan firma adı'):t('Uygulamayı yapan firma adı').' <br/><i>(Name of the company that made the application)</i>').'</td>
	<td colspan="5">'.$workorders[0]['fname'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Açık adresi'):t('Açık adresi').' <br><i>(Full address)</i>').'</td>
	<td colspan="5">'.$workorders[0]['address'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Mesul müdür'):t('Mesul müdür').' <br/><i>(Responsible manager)</i>').'</td>
	<td colspan="5">Furkan SOYDAN</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Uygulayıcı/lar isim,soyisim'):t('Uygulayıcı/lar isim,soyisim').' <br/><i>(Practitioner(s) name, surname)</i>').'</td>
	<td colspan="5">'.$workorders[0]['pr_name_surname'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Telefon/faks numarası'):t('Telefon/faks numarası').' <br/><i>(Telephone/fax number)</i>').'</td>
	<td colspan="5">'.$workorders[0]['landphone'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Müdürlük izin tarih ve sayısı'):t('Müdürlük izin tarih ve sayısı').' <br/><i>(Date and number of directorate permit)</i>').'</td>
	<td colspan="5">'.$workorders[0]['signature_date'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Ekip sorumlusu'):t('Ekip sorumlusu').' <i>(Team leader)</i>').'</td>
	<td colspan="5">'.$workorders[0]['team_leader'].'</td>
</tr>
<tr class="noneColer">
	<td colspan="10" class="noneColer">'.'<b><br/><br/>'.($lguser->languageid!=8?t('KULLANILAN BİYOSİDAL ÜRÜNE AİT BİLGİLER'):t('KULLANILAN BİYOSİDAL ÜRÜNE AİT BİLGİLER').' <br><i>(INFORMATION ON THE BIOCIDAL PRODUCT USED)</i>').'</b><br/><br/></td>
</tr>
';
$veriler2 .='<tr class="noneColer">
	<td colspan="10" class="noneColer">'.'<b><br/><br/>'.($lguser->languageid!=8?t('UYGULAMA YAPILAN YER HAKKINDA BİLGİLER'):t('UYGULAMA YAPILAN YER HAKKINDA BİLGİLER').' <br><i>(INFORMATION ABOUT THE APPLICATION PLACE)</i>').'</b><br/><br/></td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Uygulama yapılan yerin açık adresi'):t('Uygulama yapılan yerin açık adresi').' <br/><i>(Full address of the place of application)</i>').'</td>
	<td colspan="5"><br/>'.$workorders[0]['client_name'].'<br/></td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Uygulama yapılan hedef zararlı türü/adı'):t('Uygulama yapılan hedef zararlı türü/adı').' <br/><i>(Target pest type/name applied)</i>').'</td>
	<td colspan="5">'.$workorders[0]['pest_types'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Uygulama tarihi,başlangıç ve bitiş saati'):t('Uygulama tarihi,başlangıç ve bitiş saati').' <br/><i>(Application date, start and end time)</i>').'</td>
	<td colspan="5"><br/>'.date('d-m-Y',$workorders[0]['executiondate']).' '.date('H:i',$workorders[0]['realstarttime']).' - '.date('H:i',$workorders[0]['realendtime']).'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Mesken/işyeri ve benzeri'):t('Mesken/işyeri ve benzeri').' <br/><i>(Domicile/workplace and so on)</i>').'</td>
	<td colspan="5">'.$workorders[0]['workplace_and_soon'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Mesken ise daire sayısı'):t('Mesken ise daire sayısı').' <br/><i>(If residential, number of flats)</i>').'</td>
	<td colspan="5">'.$workorders[0]['number_of_flats'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Uygulama yapılan yerin alanı'):t('Uygulama yapılan yerin alanı').' <br/><i>(Area of ​​application)</i>').'</td>
	<td colspan="5">'.$workorders[0]['pr_area_ground'].'</td>
</tr>
<tr>
	<td colspan="5">'.($lguser->languageid!=8?t('Alınan güvenlik önlemleri, yapılan öneri ve uyarılar'):t('Alınan güvenlik önlemleri, yapılan öneri ve uyarılar').' <br/><i>(Security measures taken, suggestions and warnings made)</i>').'</td>
	<td colspan="5">'.$workorders[0]['security_precautions'].'</td>
</tr>

<tr>
	<td colspan="5" ><br>'.($lguser->languageid!=8?t('Ekip Sorumlusu'):t('Ekip Sorumlusu').'<i>(Team Manager)</i>').'
	'.($lguser->languageid!=8?t('İmza'):t('İmza').'<i>(Signature)</i>').'<br/><center><br/><img src="';
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
    $veriler2 .= 'https://insectram.io'.'/uploads/Tepetesisyonetimi1/tepe_imza.jpg';
  }else{
 
    $img_file = $workorders[0]['technician_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
$technician_sign = $filePath.'.jpg';
    transparent_background($technician_sign,'0,0,0',$input_file);
    

/*
$input = imagecreatefromjpeg($input_file);
$width = imagesx($input);
$height = imagesy($input);
$output = imagecreatetruecolor($width, $height);

$background = imagecolorallocate($output, 0, 0, 0);
    // remove the black 
   // imagecolortransparent($output, $background);

    // turn off alpha blending
    imagealphablending($output, false);


    imagesavealpha($output, true);

imagejpeg($output, $output_file);*/


  // $veriler2 .= 'https://insectram.io'.''.$workorders[0]['technician_sign'];
   $veriler2 .= $technician_sign;
  }
    
    $img_file = $workorders[0]['client_sign'];
$filePath=Yii::app()->basepath."/..".$img_file;
$input_file = $filePath;
$client_sign = $filePath.'.jpg';
transparent_background($client_sign,'0,0,0',$input_file);
//echo mime_content_type($base);exit;

$veriler2 .='"  width="125px" height="75px" style="background: white; "></center></td><br/>
	<td colspan="5"><br/>'.($lguser->languageid!=8?t('Uygulama Yapılan Yerin Sorumlusu / Yetkilisi'):t('Uygulama Yapılan Yerin Sorumlusu / Yetkilisi').'<i>(Responsible / Official of the Place of Implementation)</i>').'
	<br/>'.($lguser->languageid!=8?t('İmza'):t('İmza').'<i>(Signature)</i>').'<br/> <center><img src="'.$client_sign.'" width="150px" height="75px"></center>
	</td>
</tr>'; 









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


$html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
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
		<td width="100" align="left" colspan="5" class="noneColer">
			 <img src="'.$resim.'" border="0" width="65px">
		</td>
		<td width="100" align="right" colspan="5" class="noneColer">
			 <img src="'.$resim2.'" border="0" width="65px">
		</td>
	</tr>
	
</thead>
	<tbody>
		'.$veriler.$stokKimyasal.$veriler2.'
		</tbody></table>
		<p style="font-size:9px">Not: ZEHiRLENME DURUMLARINDA GEREKTİĞİNDE ULUSAL ZEHİR DANIŞMA MERKEZİNİN (UZEM) 114 VE ACİL SAĞLIK HİZMETLERİNİN 112 NOLU
TELEFONUNU ARAYINIZ.<br/>
Bu form iki nüsha olarak hazırlanır ve bir nüsha uygulama yapılan yerin yetkililerine/sahibine verilmesi zorunludur.</p>
		</body></html>';

?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>