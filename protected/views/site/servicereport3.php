
<?php
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$veriler="";
$sql="";
$ax= User::model()->userobjecty('');

$lguser=User::model()->findbypk($ax->id);

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
	
	
$isek1form= Yii::app()->db->createCommand()
  ->select('*')
		->from('ek1_firm_forms ekff')
		->where("ekff.firm_id=".intval($workorders[0]['fid'])." and ekff.firm_branch_id=".intval($workorders[0]['fbid']))
		->queryall();

if(!empty($isek1form))
{
	
	$ek1Where="ekff.firm_id=".$workorders[0]['fid']." and ekff.firm_branch_id=".$workorders[0]['fbid'];
}
else
{
	$ek1Where="ekff.firm_id=".$workorders[0]['fid']." and ekff.firm_branch_id=0";

}

$ek1forms= Yii::app()->db->createCommand()
  ->select('ekff.defaults_json_data,ekff.firm_id,ekff.firm_branch_id,
 efd.baslik_name name,efd.ek1_form_id,efd.baslik_name,efd.json_data,efd.sira,unic_name')
		->from('ek1_firm_forms ekff')
		->leftJoin('ek1_forms ef','ef.id=ekff.ek1_form_id')
		->leftJoin('ek1_forms_detail efd','efd.ek1_form_id=ef.id')
		->where($ek1Where)
		->order('efd.sira asc')
		->queryall();



function stokKimyasal($workorders,$ek1formcolon,$lguser)
{
	
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
 
$stokKimyasalmodel=Stokkimyasalkullanim::model()->findbypk($stokKimyasalmodelt['tradeId']);

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
return $stokKimyasal;
}




$veriler .= 
'<tr class="noneColer">
	<td colspan="10" class="noneColer">'.'<br/><br/><b>'.($lguser->languageid!=8?t('BİYOSİDAL ÜRÜN UYGULAMA İŞLEM FORMU'):t('BİYOSİDAL ÜRÜN UYGULAMA İŞLEM FORMU').' <i>(BIOCIDAL PRODUCT APPLICATION PROCESS FORM)</i>').'</b><br/><br/></td>
</tr>';



foreach($ek1forms as $ek1form)
{
	if($ek1form['name']!='')
		{
			$veriler.='<tr class="noneColer">
				<td colspan="10" class="noneColer">'.'<b><br/><br/>'.($lguser->languageid!=8?t($ek1form['name']):$ek1form['name'].' <br><i>()</i>').'</b><br/><br/></td>
			</tr>';
		}
	
	$ek2=str_replace("[", "", $ek1form['json_data']);
	$ek2=str_replace("]", "",$ek2);
	$ek2=str_replace('"', "",$ek2);
	$ek1Arr= explode(',',$ek2);
	
	if($ek1form['unic_name']=='kimyasallar')
	{
		$veriler .=stokKimyasal($workorders,$ek1form,$lguser);
	}
	else if($ek1form['unic_name']=='imageler')
	{
		
		
		//// bu olduğunda ekrana basmayacak sadece footer ve header resimleri kontrol edilecek
		$img_header=in_array('12',$ek1Arr_def);
		$img_footer=in_array('13',$ek1Arr_def);;
	}
	else
	{
		
		
		$ek2_def=str_replace("[", "", $ek1form['defaults_json_data']);
		$ek2_def=str_replace("]", "",$ek2_def);
		$ek2_def=str_replace('"', "",$ek2_def);
		$ek1Arr_def= explode(',',$ek2_def);
		
		$is_imza=0;
		for($i=0;$i<count($ek1Arr);$i++)
		{
			$ekitem=Ek1Items::model()->findbypk(intval($ek1Arr[$i]));
			$deger=$workorders[0][$ekitem['table_names']];
			if($ekitem['table_names']!='' && $ekitem['table_names']!='')
			{
				if(count($ek1Arr_def)>0 && in_array($ek1Arr[$i],$ek1Arr_def))
				{
					$deger='';
				}
				$veriler .='<tr>
					<td colspan="5">'.($lguser->languageid!=8?t($ekitem['name']):$ekitem['name'].' <br/><i>(Name of the company that made the application)</i>').'</td>
					<td colspan="5">'.$deger.'</td>
				</tr>';
			}
			else
			{
				if($is_imza==0)
				{
					$veriler .='<tr>
						<td colspan="5" ><br>'.($lguser->languageid!=8?t('Ekip Sorumlusu'):t('Ekip Sorumlusu').'<i>(Team Manager)</i>').'
					'.($lguser->languageid!=8?t('İmza'):t('İmza').'<i>(Signature)</i>').'<br/><center><br/><img src="';
					if($workorders[0]['firmid']==538){
						$veriler .= 'https://insectram.io'.'/uploads/Tepetesisyonetimi1/tepe_imza.jpg';
					  }else{
					 
						$img_file = $workorders[0]['technician_sign'];
					$filePath=Yii::app()->basepath."/..".$img_file;
					$input_file = $filePath;
					$technician_sign = $filePath.'.jpg';
						transparent_background($technician_sign,'0,0,0',$input_file);
					   $veriler .= $technician_sign;
					  }
					  
					  
					  $img_file = $workorders[0]['client_sign'];
						$filePath=Yii::app()->basepath."/..".$img_file;
						$input_file = $filePath;
						$client_sign = $filePath.'.jpg';
						transparent_background($client_sign,'0,0,0',$input_file);
						//echo mime_content_type($base);exit;

						$veriler .='"  width="125px" height="75px" style="background: white; "></center></td><br/>
							<td colspan="5"><br/>'.($lguser->languageid!=8?t('Uygulama Yapılan Yerin Sorumlusu / Yetkilisi'):t('Uygulama Yapılan Yerin Sorumlusu / Yetkilisi').'<i>(Responsible / Official of the Place of Implementation)</i>').'
							<br/>'.($lguser->languageid!=8?t('İmza'):t('İmza').'<i>(Signature)</i>').'<br/> <center><img src="'.$client_sign.'" width="150px" height="75px"></center>
							</td>
						</tr>'; 
				}
				$is_imza=1;
			}
		}
	}
	
}









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
		'.($img_header?'<td width="100" align="right" colspan="5" class="noneColer">
			 <img src="'.$resim2.'" border="0" width="65px">
		</td>':'').'
		
	</tr>
	
</thead>
	<tbody>
		'.$veriler.'
		</tbody></table>
		<p style="font-size:9px">Not: ZEHiRLENME DURUMLARINDA GEREKTİĞİNDE ULUSAL ZEHİR DANIŞMA MERKEZİNİN (UZEM) 114 VE ACİL SAĞLIK HİZMETLERİNİN 112 NOLU
TELEFONUNU ARAYINIZ.<br/>
Bu form iki nüsha olarak hazırlanır ve bir nüsha uygulama yapılan yerin yetkililerine/sahibine verilmesi zorunludur.</p>
		</body></html>';

?>
<?php Yii::app()->getModule('translate')->language->addtagsfromarray($GLOBALS['news']); ?>