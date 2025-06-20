<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$date = strtotime('-1 month');
$ay='';

 
 
 $rm_ioTop=0;
	 $rm_snapTop=0;
    $idTop=0;
    $efkTop=0;
    $mlTop=0;
    $wpTop=0;
  $xlureTop=0;
    $rm_i_Top=0;
    $rm_o_Top=0;
    $lt_Top=0;
    $rmlat_Top=0;

 $yil=date('Y');


 if(isset($aktivitearr['Monitoring']['date']))
 {

	 $starttime1=strtotime($aktivitearr['Monitoring']['date'].' 03:00:00');
	$tarih=$aktivitearr['Monitoring']['date1'].' 00:00:00';
	 $finishtime1=strtotime($tarih);

	 $yil=date('Y',$starttime1);
 }
/* else
 {
	 $starttime1=strtotime('01-01-'.$yil.' 03:00:00');
	 $day = cal_days_in_month(CAL_GREGORIAN,12, $yil);
	$tarih=$day.'-12-'.($yil).' 00:00:00';
	 $finishtime1=strtotime($tarih);
 }
 */

  $baslangicay=intval(date('m',$starttime1));
 $bitisay=intval(date('m',$finishtime1));




//$ay ='"'.t('ocak').'","'.t('şubat').'","'.t('mart').'","'.t('nisan').'","'.t('mayıs').'","'.t('haziran').'","'.t('temmuz').'","'.t('ağustos').'","'.t('eylül').'","'.t('ekim').'","'.t('kasım').'","'.t('aralık').'"';

$diziay = array("'".trim(t('Ocak'))."'","'".trim(t('Şubat'))."'","'".trim(t('Mart'))."'","'".trim(t('Nisan'))."'", "'".trim(t('Mayıs'))."'","'".trim(t('Haziran'))."'","'".trim(t('Temmuz'))."'","'".trim(t('Ağustos'))."'","'".trim(t('Eylül'))."'","'".trim(t('Ekim'))."'","'".trim(t('Kasım'))."'","'".trim(t('Aralık'))."'");

$baslangisvebitisarray=array();

$ilkayinsongunu=date('m',$aktivitearr['Monitoring']['date']);
$day = cal_days_in_month(CAL_GREGORIAN, $ilkayinsongunu, date('Y',$starttime1));


for($i=intval(date('Y',$starttime1));$i<=intval(date('Y',$finishtime1));$i++)
{
  if($i==intval(date('Y',$starttime1)))
  {
    if(intval(date('Y',$starttime1))-intval(date('Y',$finishtime1))==0)
    {
      $bitisay=$bitisay;
    }
    else {
      $bitisay=12;
    }
    for($j=$baslangicay;$j<=$bitisay;$j++)
    {

      $day = cal_days_in_month(CAL_GREGORIAN, $j, $i);
      array_push($baslangisvebitisarray,array(
        "ay"=>$j,
        "baslangic"=>"01-".$j."-".$i,
        "bitis"=>$day."-".$j."-".$i
      ));

    }
  }
  else {
    $bitisay=intval(date('m',$finishtime1));
   for($j=1;$j<=$bitisay;$j++)
    {
      $day = cal_days_in_month(CAL_GREGORIAN, $j, $i);
      array_push($baslangisvebitisarray,array(
        "ay"=>$j,
        "baslangic"=>"01-".$j."-".$i,
        "bitis"=>$day."-".$j."-".$i
      ));

    }

  }
}
//print_r($baslangisvebitisarray);






for($i=0;$i<count($baslangisvebitisarray);$i++)
{
	if($i==0)
	{
		$ay=$diziay[$baslangisvebitisarray[$i]['ay']-1];
	}
	else
	{
		$ay=$ay.",".$diziay[$baslangisvebitisarray[$i]['ay']-1];
	}
}

$where='';
$depandsub='';
$depName='';
$dep=0;
$sub=0;
if(isset($aktivitearr['Report']['dapartmentid']) && ['Report']['dapartmentid'][0]!=0)
{
  //$where=' and departmentid in ('.implode(",",$aktivitearr['Report']['dapartmentid']).')';
  $where=' and m.dapartmentid in ('.implode(",",$aktivitearr['Report']['dapartmentid']).')';
//  $depandsub=Departments::model()->find(array("condition"=>"id in (".implode(",",$aktivitearr['Report']['dapartmentid']).')'.));
  $deps=Departments::model()->findAll(array("condition"=>'id in ('.implode(",",$aktivitearr['Report']['dapartmentid']).')'));
  $d=0;
  foreach($deps as $dep)
  {
    if($d==0)
    {
      $depName=$dep->name;
    }
    else
    {
      $depName=$depName.','.$dep->name;
    }
    $d++;
  }

  if($d==1)
  {
    $depName=$depName.' Bölümü';
  }
  if($d>1)
  {
    $depName=$depName.' Bölümleri';
  }
  $dep=1;
}

if(isset($aktivitearr['Monitoring']['subid']))
{
  $subdepartmanid=implode(",",$aktivitearr['Monitoring']['subid']);
  if($subdepartmanid!='' && $subdepartmanid!=0)
  {
    // $where=$where.' and subdepartmentid in ('.$subdepartmanid.')';
	$where=$where.' and m.subid in ('.$subdepartmanid.')';
  //  $depandsub=$depandsub.' '.t(Departments::model()->find(array("condition"=>"id=".$aktivitearr['Monitoring']['subid']))['name']);
  }
$sub=1;
}


if (isset($aktivitearr['Report']['clientid']))     //adminse
{

for($i=0;$i<count($baslangisvebitisarray);$i++)
{
	  $starttime=strtotime($baslangisvebitisarray[$i]["baslangic"].' 01:00:00');
	  $tarih=$baslangisvebitisarray[$i]["bitis"].' 23:59:59';
	  $finishtime=strtotime($tarih);



 
	
    $rm_i_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and (mwd.monitortype in (26,25) or mwd.monitortype in (32,31) ) and m.mlocationid=4  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);
   
	
	
	$rm_o_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and ( ( mwd.monitortype in (26,25,31,32) and m.mlocationid=3) or mwd.monitortype in (33) )  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);

	
	
   $rm_io_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype in (25,26,31,32,33) and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
	$lt_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype in (23)  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
   $rm_snap_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=24 and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
   $idval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=27 and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
   $efkval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=19 and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok	
   $mlval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=28 and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
    $wpval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and mwd.value>0 and mwd.monitortype=29  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
	$xlure_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and  mwd.value>0 and mwd.monitortype in (20)  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);//ok
   $rmlat_val=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$aktivitearr['Report']['clientid']." and mwd.value>0 and mwd.monitortype=30  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub); //ok
   
     $rm_ioTop=$rm_ioTop+$rm_io_val;
	 $rm_snapTop=$rm_snapTop+$rm_snap_val;
    $idTop=$idTop+$idval;
    $efkTop=$efkTop+$efkval;
    $mlTop=$mlTop+$mlval;
    $wpTop=$wpTop+$wpval;
	
	 $xlureTop=$xlureTop+$xlure_val;
    $rm_i_Top=$rm_i_Top+$rm_i_val;
    $rm_o_Top=$rm_o_Top+$rm_o_val;
    $lt_Top=$lt_Top+$lt_val;
    $rmlatTop=$rmlatTop+$rmlat_val;
	
	
    	if($i==0)
    	{

    	 $rm_io=$rm_io_val;
		 $rm_snap=$rm_snap_val;
         $id=$idval;
         $efk=$efkval;
         $ml=$mlval;
         $wp=$wpval;
		 
		  $xlure=$xlure_val;
         $rm_i=$rm_i_val;
         $rm_o=$rm_o_val;
         $lt=$lt_val;
         $rmlat=$rmlat_val;
		 
    	}
    	else
    	{
        $rm_io=$rm_io.','.$rm_io_val;
		$rm_snap=$rm_snap.','.$rm_snap_val;
        $id=$id.','.$idval;
        $efk=$efk.','.$efkval;
        $ml=$ml.','.$mlval;
        $wp=$wp.','.$wpval;
		
		 $xlure=$xlure.','.$xlure_val;
         $rm_i=$rm_i.','.$rm_i_val;
         $rm_o=$rm_o.','.$rm_o_val;
         $lt=$lt.','.$lt_val;
         $rmlat=$rmlat.','.$rmlat_val;
		 
    	}

	
}
}
	
		$rm_ioarray=explode(',',$rm_io);
		$rm_snaparray=explode(',',$rm_snap);
		$idarray=explode(',',$id);
		$efkarray=explode(',',$efk);
		$mltarray=explode(',',$ml);
		$wptarray=explode(',',$wp);
		
		$xlurearray=explode(',',$xlure);
		$rm_iarray=explode(',',$rm_i);
		$rm_oarray=explode(',',$rm_o);
		$ltarray=explode(',',$lt);
		$rmlatarray=explode(',',$rmlat);
	


$clientname=Client::model()->find(array('condition'=>'id='.$aktivitearr['Report']['clientid']));
?>

<section id="html5">
  <div class="row">
    <div class="col-md-12" style=" padding: 0px !important;">
      <div class="card"  style=" padding: 0px !important;">
        <div class="card-header"  style=" padding: 0px !important;">
            <div class="row" style="border-bottom: 1px solid #e3ebf3;"  style=" padding: 0px !important;">
             <div class="col-xl-7 col-lg-9 col-md-9 mb-1"  style=" padding: 0px !important;">
               <h4 class="card-title"><?=mb_strtoupper($clientname->name.' '.t("AKTİVİTE GRAFİĞİ"),"UTF-8");?></h4>
               <h5><?="(".$aktivitearr['Monitoring']['date']." - ".$aktivitearr['Monitoring']['date1'].') '.$depandsub;?></h5>
            </div>
        </div>

        <div class="card-content collapse show"  style=" padding: 0px !important;">

          <div class="card-body card-dashboard"  style=" padding: 0px !important;">
           
		 <style>
		.table th, .table td {
    padding: 0.75rem 1rem;
} </style>
              <table  class="table table-striped table-bordered dataex-html5-export " >
                <thead>
                  <tr>

                    <th><?=t(date("Y",$finishtime1).' '.t('yılı'));?> </th>
          <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,4) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,4)   || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,4)   || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,4) ) {  ?> <th><?=t('RM - Indoor<br>  Nontox+Toxic');?></th><? } ?>
                    
					<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,3)  || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],33)  ) {  ?><th><?=t('RM - Outdoor<br> Nontoxic+Toxic');?></th><? } ?>
					  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],23) ) {  ?><th><?=t('LT <br> Glueboard');?></th><? } ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],24) ) {  ?><th><?=t('RM <br> Snaptrap');?></th><? } ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],27) ) {  ?><th><?=t('ID');?></th><? } ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],19) ) {  ?><th><?=t('EFK');?></th><? } ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],28) ) {  ?><th><?=t('ML');?></th><? } ?>
						<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],29) ) {  ?><th><?=t('WP');?></th><? } ?>
						<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],30) ) {  ?><th><?=t('RM <br> Latent');?></th><? } ?>
						<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],20) ) {  ?><th><?=t('X-Lure MT');?></th><? } ?>
                  </tr>
                </thead>
                <tbody>
                    <?
                    for($i=0;$i<count($baslangisvebitisarray);$i++)
                    {
                      ?>
                      <tr>

                        <td><?=t(mb_convert_case(str_replace("'","", $diziay[$baslangisvebitisarray[$i]['ay']-1]), MB_CASE_TITLE, "UTF-8"));?></td>
						 <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,4) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,4)  || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,4)   || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,4) ) {  ?><td><?=$rm_iarray[$i];?></td><? } ?>
                        
                        
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],33)  ) {  ?><td><?=$rm_oarray[$i];?></td><? } ?>
                        
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],23) ) {  ?><td><?=$ltarray[$i];?></td><? } ?>
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],24) ) {  ?><td><?=$rm_snaparray[$i];?></td><? } ?>
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],27) ) {  ?><td><?=$idarray[$i];?></td><? } ?>
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],19) ) {  ?><td><?=$efkarray[$i];?></td><? } ?>
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],28) ) {  ?><td><?=$mltarray[$i];?></td><? } ?>
							<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],29) ) {  ?><td><?=$wptarray[$i];?></td><? } ?>
							<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],30) ) {  ?><td><?=$rmlatarray[$i];?></td><? } ?>
              <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],20) ) {  ?><td><?=$xlurearray[$i];?></td><? } ?>
                      </tr>
                      <?
                    }
                    ?>

                    <tr>

                      <td><?=t('Toplam')?></td>
        		 <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,4) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,4)  || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,4)   || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,4)){  ?><td><?=$rm_i_Top;?></td><? }else {$rm_i_Top=0;} ?>
                
                
                <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],33)  ) {  ?><td><?=$rm_o_Top;?></td><? }else {$rm_o_Top=0;} ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],23) ) {  ?><td><?=$lt_Top;?></td><? }else {$lt_Top=0;} ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],24) ) {  ?><td><?=$rm_snapTop;?></td><? }else {$rm_snapTop=0;} ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],27) ) {  ?><td><?=$idTop;?></td><? }else {$idTop=0;} ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],19) ) {  ?><td><?=$efkTop;?></td><? }else {$efkTop=0;} ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],28) ) {  ?><td><?=$mlTop;?></td><? }else {$mlTop=0;} ?>
					 	<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],29) ) {  ?> <td><?=$wpTop;?></td><? }else {$wpTop=0;} ?>
					 	<? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],30) ) {  ?> <td><?=$rmlatTop;?></td><? }else {$rmlatTop=0;} ?>
            <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],20) ) {  ?> <td><?=$xlureTop;?></td><? }else {$xlureTop=0;} ?>
                    </tr>
                    <tr>

                      <td><?=t('Genel Toplam');?></td>
                      <td><?=$rm_ioTop+$rm_snapTop+$idTop+$efkTop+$mlTop+$wpTop+$rmlatTop+$xlureTop;?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
					  <td></td>
					  <td></td>
                      <td></td>
					  <td></td>
                    </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="chartjs-bar-charts">

          <!-- Column Chart -->
          <div class="row">
      
			<!-- Column Chart -->
         
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,4) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,4)  || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,4)   || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,4)){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-rm--i-img">
										<center>
                  <!--  <h6 class='grafikBaslik'><?=trim(t('RM - Indoor Nontoxic+Toxic'));?></h6> -->
                    <div id="column-chart-rm-i" style="width:600px; height:300px"></div>
										
												    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionrmdic" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
                    <!-- <canvas id="" height="300"></canvas> -->
										</center>
                  </div>
                </div>
              </div>
            </div>
			<!-- Column Chart -->
         
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],25,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],26,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],31,3) || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],32,3)  || Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],33)  ) { }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-rm-o-img">
										<center>
                  <!--  <h6 class='grafikBaslik'><?=trim(t('RM - Outdoor Nontoxic+Toxic'));?></h6> -->
                    <div id="column-chart-rm-o" style="width:600px; height:300px"></div>
										
												    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionrmdis" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
                    <!-- <canvas id="" height="300"></canvas> -->
										</center>
                  </div>
                </div>
              </div>
            </div>
			
          
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],23) ){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-lt-img"><center>
                    <div id="column-chart-lt" style="width:600px; height:300px"></div>
										    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionlt" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
                    <!-- <canvas id="" height="300"></canvas> -->
</center>
                  </div>
                </div>
              </div>
            </div>
			
			  <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],24) ){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-rm-img">
										<center>
                    <div id="column-chart-rm-snap" style="width:600px; height:300px"></div>
													    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionrmsnap" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
                    <!-- <canvas id="" height="300"></canvas> -->
										</center>
                  </div>
                </div>
              </div>
            </div>

            <!--ID---->

            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],27) ){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body"id="column-chart-id-img">
										<center>
                    <div id="column-chart-id" style="width:600px; height:300px"></div>
													    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionid" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
											</div></center>
                  </div>
                </div>
              </div>
            </div>

            <!--efk---->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],19) ){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-efk-img">
										<center>
                  <!--  <h6 class='grafikBaslik'><?=trim(t('EFK'));?></h6> -->
                    <div id="column-chart-efk" style="width:600px; height:300px"></div>
													    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionefk" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
											</div></center>
                  </div>
                </div>
              </div>
            </div>
			<!--ML--->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],28) ){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-ml-img">
										<center>
                  <!--  <h6 class='grafikBaslik'><?=trim(t('ML'));?></h6> -->
                <div id="column-chart-ml" style="width:600px; height:300px"></div>
													    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionml" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
										</center>
                  </div>
                </div>
              </div>
            </div>
            <!--WP--->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],29) ){ }else { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-wp-img">
										<center>
                    <!-- <h6 class='grafikBaslik'><?=trim(t('WP'));?></h6> -->
                  <div id="column-chart-wp" style="width:600px; height:300px"></div>
													    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionwp" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
										</center>
                  </div>
                </div>
              </div>
            </div>
    <!--WP--->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; <? if ( Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],30) ){ }else  { echo ' height:0px !important;'; } ?>" ><hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-rmlat-img">
										<center>
                    <!-- <h6 class='grafikBaslik'><?=trim(t('Rm-Latent'));?></h6> -->
                  <div id="column-chart-rmlat" style="width:600px; height:300px"></div>
													    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionrmlat" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
										</center>
                  </div>
                </div>
              </div>
            </div>
			
						      <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px;  <? if (Monitoringtype::model()->clientmytpecheck($aktivitearr['Report']['clientid'],20) ){ }else { echo ' height:0px !important;'; } ?>" >			<hr>
              <div class="card">
                <div class="card-header">

                  
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-xlure-img">
										<center>
                    <div id="column-chart-xlure" style="width:600px; height:300px"></div>
                    <!-- <canvas id="" height="300"></canvas> -->
											    <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Add comments')?></label>
              <textarea id="descriptionxlure" type="text" class="form-control"   <?=$pubcss?> placeholder="<?=t('Add comments')?>" value=""></textarea>
            </fieldset>
          </div>
										</center>
                  </div>
								
		 
                </div>
              </div>
            </div>

          <!-- Bar Stacked Chart -->


   <form id="activityRapor-form" action="/client/pdfactiviteraporingiltere"  method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" id="aylar" name="aylar" value="<?=$ay;?>">
		  <input type="hidden" class="form-control" id="xlure" name="xlure" value="<?=$xlure;?>">
		  <input type="hidden" class="form-control" id="rm_i" name="rm_i" value="<?=$rm_i;?>">
		  <input type="hidden" class="form-control" id="rm_o" name="rm_o" value="<?=$rm_o;?>">
          <input type="hidden" class="form-control" id="lt" name="lt" value="<?=$lt;?>">
          <input type="hidden" class="form-control" id="rm_snap" name="rm_snap" value="<?=$rm_snap;?>">
          <input type="hidden" class="form-control" id="id" name="id" value="<?=$id;?>">
          <input type="hidden" class="form-control" id="efk" name="efk" value="<?=$efk;?>">
          <input type="hidden" class="form-control" id="ml" name="ml" value="<?=$ml;?>">
		  <input type="hidden" class="form-control" id="wp" name="wp" value="<?=$wp;?>">
		  <input type="hidden" class="form-control" id="rmlat" name="rmlat" value="<?=$rmlat;?>">
		  <input type="hidden" class="form-control" id="xlureTop" name="xlureTop" value="<?=$xlureTop;?>">
		  <input type="hidden" class="form-control" id="rm_i_Top" name="rm_i_Top" value="<?=$rm_i_Top;?>">
		  <input type="hidden" class="form-control" id="rm_o_Top" name="rm_o_Top" value="<?=$rm_o_Top;?>">
          <input type="hidden" class="form-control" id="lt_Top" name="lt_Top" value="<?=$lt_Top;?>">
          <input type="hidden" class="form-control" id="rm_snapTop" name="rm_snapTop" value="<?=$rm_snapTop;?>">
          <input type="hidden" class="form-control" id="idTop" name="idTop" value="<?=$idTop;?>">
          <input type="hidden" class="form-control" id="efkTop" name="efkTop" value="<?=$efkTop;?>">
          <input type="hidden" class="form-control" id="mlTop" name="mlTop" value="<?=$mlTop;?>">
		  <input type="hidden" class="form-control" id="wpTop" name="wpTop" value="<?=$wpTop;?>">
		  <input type="hidden" class="form-control" id="rmlat_Top" name="rmlat_Top" value="<?=$rmlatTop;?>">
	
          <input type="hidden" class="form-control" id="xlureImage" name="xlureImage">
		   <input type="hidden" class="form-control" id="rm_iImage" name="rm_iImage">
		    <input type="hidden" class="form-control" id="rm_oImage" name="rm_oImage">
			 <input type="hidden" class="form-control" id="ltImage" name="ltImage">
		  <input type="hidden" class="form-control" id="rm_snapImage" name="rm_snapImage">
          <input type="hidden" class="form-control" id="idImage" name="idImage">
          <input type="hidden" class="form-control" id="efkImage" name="efkImage">
          <input type="hidden" class="form-control" id="mlImage" name="mlImage">
          <input type="hidden" class="form-control" id="wpImage" name="wpImage">
          <input type="hidden" class="form-control" id="rmlatImage" name="rmlatImage">
          <input type="hidden" class="form-control" id="genelToplam" name="genelToplam" value="<?=$rm_ioTop+$rm_snapTop+$idTop+$efkTop+$mlTop+$wpTop+$rmlatTop;?>">
          <input type="hidden" class="form-control" id="yil" name="yil" value="<?=date("Y",$finishtime1).' '.t('yılı');?>">
          <input type="hidden" class="form-control"  name="Reports[clientid]" value="<?=$aktivitearr['Report']['clientid'];?>">
          <input type="hidden" class="form-control"  name="tarihAraligi" value="<?=Date('d-m-Y',$starttime1).'/ '.Date('d-m-Y',$finishtime1)?>">
          <input type="hidden" class="form-control"  name="depName" value="<?=$depName;?>">
          <input type="hidden" class="form-control" id="aciklama"  name="description" value="">
          <input type="hidden" class="form-control" id="aciklamarmdis"  name="aciklamarmdis" value="">
          <input type="hidden" class="form-control" id="aciklamarmdic"  name="aciklamarmdic" value="">
          <input type="hidden" class="form-control" id="aciklamaxlure"  name="aciklamaxlure" value="">
          <input type="hidden" class="form-control" id="aciklamalt"  name="aciklamalt" value="">
          <input type="hidden" class="form-control" id="aciklamarmsnap"  name="aciklamarmsnap" value="">
          <input type="hidden" class="form-control" id="aciklamaid"  name="aciklamaid" value="">
          <input type="hidden" class="form-control" id="aciklamaefk"  name="aciklamaefk" value="">
          <input type="hidden" class="form-control" id="aciklamaml"  name="aciklamaml" value="">
          <input type="hidden" class="form-control" id="aciklamawp"  name="aciklamawp" value="">
          <input type="hidden" class="form-control" id="aciklamarmlat"  name="aciklamarmlat" value="">
        </form>
     




<script>

function grafik(id,sName,sData,featureShow)
{
  //var array=sData.split(",");
  var MyChart = echarts.init(document.getElementById(id));
  option = {
      tooltip : {
				show:false,
          trigger: 'axis'
      },
      legend: {
          data:[sName]
      },
      toolbox: {
          show : false,
          feature : {

              magicType : {show: featureShow, type: ['line', 'bar']},
              restore : {show: featureShow},
              saveAsImage : {show: featureShow}
          }
      },
      color: ["#204799"],
      calculable : true,
      xAxis : [
          {
              type : 'category',
              data : [<?=$ay;?>]
          }
      ],
      yAxis : [
          {
              type : 'value'
          }
      ],
      series : [
      {
                  name:sName,
                  type:'bar',
                  data:sData,
                  markPoint : {
                      data : [
                          {type : 'max', name: 'Max'},
                          {type : 'min', name: 'Min'}
                      ]
                  },
                  markLine : {
                      data : [
                          {type : 'average', name: 'Average'}
                      ]
                  }
      },

      ]
  };
  MyChart.setOption(option, true), $(function() {
      function resize() {
          setTimeout(function() {
              MyChart.resize()
          }, 100)
      }
      $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
  });

}

    $(document).ready(function() {
		grafik('column-chart-rm-i',"<?=trim(t('RM - Indoor Nontoxic+Toxic'));?>",[<?=$rm_i.',';?>],true);
		grafik('column-chart-rm-o',"<?=trim(t('RM - Outdoor Nontoxic+Toxic'));?>",[<?=$rm_o.',';?>],true);
      grafik('column-chart-lt',"<?=trim(t('LT - Glueboard'));?>",[<?=$lt.',';?>],true);
	  grafik('column-chart-rm-snap',"<?=trim(t('RM - Snaptrap'));?>",[<?=$rm_snap.',';?>],true);
       grafik('column-chart-id',"<?=trim(t('ID'));?>",[<?=$id.',';?>],true);
      grafik('column-chart-efk',"<?=trim(t('EFK'));?>",[<?=$efk.',';?>],true);
      grafik('column-chart-ml',"<?=trim(t('ML'));?>",[<?=$ml.',';?>],true);
      grafik('column-chart-wp',"<?=trim(t('WP'));?>",[<?=$wp;?>],true);
      grafik('column-chart-rmlat',"<?=trim(t('RM - Latent'));?>",[<?=$rmlat;?>],true);
		grafik('column-chart-xlure',"<?=trim(t('X-Lure'));?>",[<?=$xlure.',';?>],true);
  });
	

function printDiv(divName) {
			html2canvas(document.querySelector('#chartjs-bar-charts')).then(function(canvas) {
          canvas.toDataURL();
					saveAs(canvas.toDataURL(), 'grafik-tablo.png');
			});



	function saveAs(uri, filename) {

			var link = document.createElement('a');
      console.log(link);
			if (typeof link.download === 'string') {

					link.href = uri;
					link.download = filename;

					//Firefox requires the link to be in the body
					document.body.appendChild(link);



					//simulate click
					link.click();

					//remove the link when done
					document.body.removeChild(link);

			} else {

					window.open(uri);

			}
	 }
 }


$(document).ready(function() {
$('.dataex-html5-export').DataTable( {
	searching: false, paging: false, info: false,
    dom: 'Bfrtip',
		lengthMenu: [[-1], ["<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			html:true,
			colvis: "<?=t('Columns Visibility');?>",
        },
				     "sDecimal": ",",
                     "sEmptyTable": "<?=t('Data is not available in the table');?>",
                     //"sInfo": "_TOTAL_ kay�ttan _START_ - _END_ aras�ndaki kay�tlar g�steriliyor",
                     "sInfo": "<?=t('Total number of records');?> : _TOTAL_",
                     "sInfoEmpty": "<?=t('No records found');?> ! ",
                     "sInfoFiltered": "(_MAX_ <?=t('records');?>)",
                     "sInfoPostFix": "",
                     "sInfoThousands": ".",
                     "sLengthMenu": "<?=t('Top of page');?> _MENU_ <?=t('record');?>",
                     "sLoadingRecords": "<?=t('Loading');?>...",
                     "sProcessing": "<?=t('Processing');?>...",
                     "sSearch": "<?=t('Search');?>:",
                     "sZeroRecords": "<?=t('No records found');?> !",
                     "oPaginate": {
                         "sFirst": "<?=t('First page');?>",
                         "sLast": "<?=t('Last page');?>",
                         "sNext": "<?=t('Next');?>",
                         "sPrevious": "<?=t('Previous');?>"
                     },
    },

		"columnDefs": [ {
				"searchable": false,
				"orderable": false,
				// "targets": 0
			} ],
      "ordering": false,
		//	 "order": [[ 5, 'desc' ]],



	 buttons: [

     
    /*    {
             extend: 'pdfHtml5',
				 orientation: 'landscape',
                pageSize: 'LEGAL',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,2,3,4,5]
            },
				   text:'<?=t('PDF');?>',
			  title: '<?=mb_strtoupper($clientname->name.' '.t("AKTİVİTE GRAFİĞİ"),"UTF-8");?>',
			  header: true,
        action: function ( e, dt, node, config ) {
      
         $("#aciklama").val($("#description").val());
         $("#aciklamarmdis").val($("#descriptionrmdis").val());
					
         $("#aciklamarmdic").val($("#descriptionrmdic").val());
         $("#aciklamaxlure").val($("#descriptionxlure").val());
         $("#aciklamalt").val($("#descriptionlt").val());
         $("#aciklamarmsnap").val($("#descriptionrmsnap").val());
         $("#aciklamaid").val($("#descriptionid").val());
         $("#aciklamaefk").val($("#descriptionefk").val());
         $("#aciklamaml").val($("#descriptionml").val());
         $("#aciklamawp").val($("#descriptionwp").val());
         $("#aciklamarmlat").val($("#descriptionrmlat").val());
					
					
		grafik('column-chart-xlure',"<?=trim(t('X-Lure MultiSpecies Trap'));?>",[<?=$xlure.',';?>],true);
		grafik('column-chart-rm-i',"<?=trim(t('RM - Indoor Nontoxic+Toxic'));?>",[<?=$rm_i.',';?>],true);
		grafik('column-chart-rm-o',"<?=trim(t('RM - Outdoor Nontoxic+Toxic'));?>",[<?=$rm_o.',';?>],true);
      grafik('column-chart-lt',"<?=trim(t('LT - Glueboard'));?>",[<?=$lt.',';?>],true);
      grafik('column-chart-rmlat',"<?=trim(t('RM - Latent'));?>",[<?=$rmlat.',';?>],true);
	  
	  html2canvas(document.querySelector('#column-chart-xlure')).then(function(rmioCanvas) {
                $("#xlureImage").val(rmioCanvas.toDataURL('image/jpeg', 0.4));
		html2canvas(document.querySelector('#column-chart-rm-i')).then(function(rmioCanvas) {
                $("#rm_iImage").val(rmioCanvas.toDataURL('image/jpeg', 0.4));
			html2canvas(document.querySelector('#column-chart-rm-o')).then(function(rmioCanvas) {
                $("#rm_oImage").val(rmioCanvas.toDataURL('image/jpeg', 0.4));
				
				
            html2canvas(document.querySelector('#column-chart-lt')).then(function(rmioCanvas) {
                $("#ltImage").val(rmioCanvas.toDataURL('image/jpeg', 0.4));
				html2canvas(document.querySelector('#column-chart-rm-snap')).then(function(rmsnapCanvas) {
                $("#rm_snapImage").val(rmsnapCanvas.toDataURL('image/jpeg', 0.4));
                html2canvas(document.querySelector('#column-chart-id')).then(function(idCanvas) {
                    $("#idImage").val(idCanvas.toDataURL('image/jpeg', 0.4));
                    html2canvas(document.querySelector('#column-chart-efk')).then(function(efkCanvas) {
                        $("#efkImage").val(efkCanvas.toDataURL('image/jpeg', 0.4));
                        html2canvas(document.querySelector('#column-chart-ml')).then(function(mlCanvas) {
                            $("#mlImage").val(mlCanvas.toDataURL('image/jpeg', 0.4));
                            html2canvas(document.querySelector('#column-chart-wp')).then(function(wpCanvas) {
                                $("#wpImage").val(wpCanvas.toDataURL('image/jpeg', 0.4));
																		  html2canvas(document.querySelector('#column-chart-rmlat')).then(function(rmlatCanvas) {
                                $("#rmlatImage").val(rmlatCanvas.toDataURL('image/jpeg', 0.4));
                   
                                var formdata= $("#conformity-form").serialize();
                                var formElement = document.getElementById("activityRapor-form");

                                  formElement.target="_blank";
                                  formElement.action="<?=Yii::app()->getbaseUrl(true)?>/client/pdfactiviteraporingiltere/";
                                  formElement.submit();
                          }); });
						   });
						    });
							 });
                      });
                  });
              });
      

          });
  });
                
                },
			  customize: function(doc) {
          var grafigUrl='';
          html2canvas(document.querySelector('#chartjs-bar-charts')).then(function(canvas) {
              grafigUrl=canvas.toDataURL();
              var link = document.createElement('a');
              link.href = canvas.toDataURL();
              link.download = 'grafik-tablo.png';
              document.body.appendChild(link);
              console.log("asdasdasd"+link);
              document.body.removeChild(link);

				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=mb_strtoupper($clientname->name.' '.t("AKTİVİTE GRAFİĞİ"),"UTF-8");?> \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '\n',
					bold: true,
					fontSize: 12,
						alignment: 'center'
				  },
						{
					text: '<?=$aktivitearr['Monitoring']['date'].' - '.$aktivitearr['Monitoring']['date1'].' / '.$depandsub;?>',
					bold: true,
					fontSize: 11,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]

				}

        ,{
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: link
                      },
      );
        });
			  }


        }*/
   
    ]


} );
});
</script>
<style>
.grafikBaslik{
  text-align: center;
    font-weight: 700;
    border-bottom: 1px solid #eff1f5;
    padding-bottom: 8px;
}
	.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: 0px;
    margin-left: 0px;
}
</style>
 <?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/plugins/echarts/echarts-all.js;';
//Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.min.js;';
Yii::app()->params['scripts'].='https://html2canvas.hertzen.com/dist/html2canvas.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';




 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

?>
