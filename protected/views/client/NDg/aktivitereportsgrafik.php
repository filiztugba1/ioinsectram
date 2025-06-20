<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$date = strtotime('-1 month');
$ay='';

 $rm='';
 $lt='';
 $mt='';
 $cl='';
 $lft='';

 $rmTop=0;
 $ltTop=0;
 $mtTop=0;
 $clTop=0;
 $lftTop=0;

 $yil=date('Y');


 if(isset($_POST['Monitoring']['date']))
 {

	 $starttime1=strtotime($_POST['Monitoring']['date'].' 03:00:00');
	$tarih=$_POST['Monitoring']['date1'].' 00:00:00';
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

$ilkayinsongunu=date('m',$_POST['Monitoring']['date']);
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
if(isset($_POST['Report']['dapartmentid']) && $_POST['Report']['dapartmentid'][0]!=0)
{
  //$where=' and departmentid in ('.implode(",",$_POST['Report']['dapartmentid']).')';
  $where=' and mwm.departmentid in ('.implode(",",$_POST['Report']['dapartmentid']).')';
//  $depandsub=Departments::model()->find(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).')'.));
  $deps=Departments::model()->findAll(array("condition"=>'id in ('.implode(",",$_POST['Report']['dapartmentid']).')'));
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

if(isset($_POST['Monitoring']['subid']))
{
  $subdepartmanid=implode(",",$_POST['Monitoring']['subid']);
  if($subdepartmanid!='' && $subdepartmanid!=0)
  {
    // $where=$where.' and subdepartmentid in ('.$subdepartmanid.')';
	$where=$where.' and mwm.subdepartment in ('.$subdepartmanid.')';
  //  $depandsub=$depandsub.' '.t(Departments::model()->find(array("condition"=>"id=".$_POST['Monitoring']['subid']))['name']);
  }
$sub=1;
}


if (isset($_POST['Report']['clientid']))     //adminse
{

for($i=0;$i<count($baslangisvebitisarray);$i++)
{
	  $starttime=strtotime($baslangisvebitisarray[$i]["baslangic"].' 01:00:00');
	  $tarih=$baslangisvebitisarray[$i]["bitis"].' 23:59:59';
	  $finishtime=strtotime($tarih);



 // echo "clientbranchid=".$_POST['Report']['clientid']." and monitortype=10 and (petid=37 or petid=38) and createdtime!=0 and checkdate>=".$starttime." and isproduct=0 and checkdate<=".$finishtime.$where;
	// exit;
	$rmval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=10 and mwd.petid in (37,38)  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);
   $ltval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=8 and mwd.petid in (37,38)  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);
   $mtval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=9 and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);
   $clval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=6 and mwd.petid!=25 and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);
    $lftval=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and mwd.value>0 and mwd.monitortype=12  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub);
   
    // $rmval=0;
	   // $rmMd=MobileworkorderdataView::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=10 and (petid=37 or petid=38) and createdtime!=0 and checkdate>=".$starttime." and isproduct=0 and checkdate<=".$finishtime.$where));
   
	// foreach($rmMd as $rmMdx)
    // {
      // $rmval=$rmval+$rmMdx->value;
    // }
    // $ltMd=MobileworkorderdataView::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=8 and (petid=37 or petid=38) and createdtime!=0 and checkdate>".$starttime." and isproduct=0 and checkdate<=".$finishtime.$where));
    // $ltval=0;
    // foreach($ltMd as $ltMdx)
    // {
      // $ltval=$ltval+$ltMdx->value;
    // }
    // $mtMd=MobileworkorderdataView::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=9 and createdtime!=0 and checkdate>".$starttime." and isproduct=0 and checkdate<=".$finishtime.$where));
    // $mtval=0;
    // foreach($mtMd as $mtMdx)
    // {
      // $mtval=$mtval+$mtMdx->value;
    // }
    // $clMd=MobileworkorderdataView::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=6 and petid!=25 and createdtime!=0 and checkdate>".$starttime." and isproduct=0 and checkdate<=".$finishtime.$where));
    // $clval=0;
    // foreach($clMd as $clMdx)
    // {
      // $clval=$clval+$clMdx->value;
    // }
    // $lftMd=MobileworkorderdataView::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=12 and createdtime!=0 and checkdate>".$starttime." and isproduct=0 and checkdate<=".$finishtime.$where));

    // $lftval=0;
    // foreach($lftMd as $lftMdx)
    // {
      // $lftval=$lftval+$lftMdx->value;
    // }

    $rmTop=$rmTop+$rmval;
    $ltTop=$ltTop+$ltval;
    $mtTop=$mtTop+$mtval;
    $clTop=$clTop+$clval;
    $lftTop=$lftTop+$lftval;
    	if($i==0)
    	{

    	   $rm=$rmval;
         $lt=$ltval;
         $mt=$mtval;
         $cl=$clval;
         $lft=$lftval;
    	}
    	else
    	{
        $rm=$rm.','.$rmval;
        $lt=$lt.','.$ltval;
        $mt=$mt.','.$mtval;
        $cl=$cl.','.$clval;
        $lft=$lft.','.$lftval;
    	}
}
}
$rmarray=explode(',',$rm);
$ltarray=explode(',',$lt);
$mtarray=explode(',',$mt);
$clarray=explode(',',$cl);
$lftarray=explode(',',$lft);
$clientname=Client::model()->find(array('condition'=>'id='.$_POST['Report']['clientid']));
?>

<section id="html5">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row" style="border-bottom: 1px solid #e3ebf3;">
             <div class="col-xl-7 col-lg-9 col-md-9 mb-1">
               <h4 class="card-title"><?=mb_strtoupper($clientname->name.' '.t("AKTİVİTE GRAFİĞİ"),"UTF-8");?></h4>
               <h5><?="(".$_POST['Monitoring']['date']." - ".$_POST['Monitoring']['date1'].') '.$depandsub;?></h5>
            </div>
        </div>

        <div class="card-content collapse show">

          <div class="card-body card-dashboard">
              <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Pdf için açıklama giriniz')?></label>
              <textarea id="description" type="text" class="form-control" placeholder="<?=t('Pdf için açıklama giriniz')?>" value=""></textarea>
            </fieldset>
          </div>
              <table  class="table table-striped table-bordered dataex-html5-export table-responsive">
                <thead>
                  <tr>

                    <th><?=t(date("Y",$finishtime1).' '.t('yılı'));?> </th>
                    <th><?=t('RM-DIŞ ALAN KEMİRGEN');?></th>
                    <th><?=t('LT-İÇ ALAN KEMRİGEN');?></th>
                    <th><?=t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI');?></th>
                    <th><?=t('CI-YÜRÜYEN HEŞERE');?></th>
                    <th><?=t('LFT-UÇAN HAŞERE');?></th>
                  </tr>
                </thead>
                <tbody>
                    <?
                    for($i=0;$i<count($baslangisvebitisarray);$i++)
                    {
                      ?>
                      <tr>

                        <td><?=t(mb_convert_case(str_replace("'","", $diziay[$baslangisvebitisarray[$i]['ay']-1]), MB_CASE_TITLE, "UTF-8"));?></td>
                        <td><?=$rmarray[$i];?></td>
                        <td><?=$ltarray[$i];?></td>
                        <td><?=$mtarray[$i];?></td>
                        <td><?=$clarray[$i];?></td>
                        <td><?=$lftarray[$i];?></td>

                      </tr>
                      <?
                    }
                    ?>

                    <tr>

                      <td><?=t('Toplam')?></td>
                      <td><?=$rmTop;?></td>
                      <td><?=$ltTop;?></td>
                      <td><?=$mtTop;?></td>
                      <td><?=$clTop;?></td>
                      <td><?=$lftTop;?></td>

                    </tr>

                    <tr>

                      <td><?=t('Genel Toplam');?></td>
                      <td><?=$rmTop+$ltTop+$mtTop+$clTop+$lftTop;?></td>
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
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; " >
              <div class="card">
                <div class="card-header">

                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a class="hidden-md hidden-sm hidden-xs" data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-rm-img">
                  <!--  <h6 class='grafikBaslik'><?=trim(t('RM-DIŞ ALAN KEMİRGEN'));?></h6> -->
                    <div id="column-chart-rm" style="width:600px; height:300px"></div>
                    <!-- <canvas id="" height="300"></canvas> -->

                  </div>
                </div>
              </div>
            </div>

            <!--LT---->

            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; " >
              <div class="card">
                <div class="card-header">

                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a class="hidden-md hidden-sm hidden-xs" data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body"id="column-chart-lt-img">
                  <!--  <h6 class='grafikBaslik'><?=trim(t('LT İÇ ALAN KEMİRGEN'));?></h6> -->
                    <div id="column-chart-lt" style="width:600px; height:300px"></div>
                  </div>
                </div>
              </div>
            </div>

            <!--mt---->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; " >
              <div class="card">
                <div class="card-header">

                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a class="hidden-md hidden-sm hidden-xs" data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-mt-img">
                  <!--  <h6 class='grafikBaslik'><?=trim(t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI'));?></h6> -->
                    <div id="column-chart-mt" style="width:600px; height:300px"></div>
                  </div>
                </div>
              </div>
            </div>
<!--cl--->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; " >
              <div class="card">
                <div class="card-header">

                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a class="hidden-md hidden-sm hidden-xs" data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-cl-img">
                  <!--  <h6 class='grafikBaslik'><?=trim(t('CL-YÜRÜYEN HAŞERE'));?></h6> -->
                <div id="column-chart-cl" style="width:600px; height:300px"></div>

                  </div>
                </div>
              </div>
            </div>
            <!--lft--->
            <div class="col col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="width:750px; " >
              <div class="card">
                <div class="card-header">

                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a class="hidden-md hidden-sm hidden-xs" data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body" id="column-chart-lft-img">
                    <!-- <h6 class='grafikBaslik'><?=trim(t('LFT-UÇAN HAŞERE'));?></h6> -->
                  <div id="column-chart-lft" style="width:600px; height:300px"></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- Bar Stacked Chart -->


        </section>


        <form id="activityRapor-form" action="/client/pdfactiviterapor"  method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" id="aylar" name="aylar" value="<?=$ay;?>">
          <input type="hidden" class="form-control" id="rm" name="rm" value="<?=$rm;?>">
          <input type="hidden" class="form-control" id="lt" name="lt" value="<?=$lt;?>">
          <input type="hidden" class="form-control" id="mt" name="mt" value="<?=$mt;?>">
          <input type="hidden" class="form-control" id="cl" name="cl" value="<?=$cl;?>">
          <input type="hidden" class="form-control" id="lft" name="lft" value="<?=$lft;?>">
          <input type="hidden" class="form-control" id="rmToplam" name="rmToplam" value="<?=$rmTop;?>">
          <input type="hidden" class="form-control" id="ltToplam" name="ltToplam" value="<?=$ltTop;?>">
          <input type="hidden" class="form-control" id="mtToplam" name="mtToplam" value="<?=$mtTop;?>">
          <input type="hidden" class="form-control" id="clToplam" name="clToplam" value="<?=$clTop;?>">
          <input type="hidden" class="form-control" id="lftToplam" name="lftToplam" value="<?=$lftTop;?>">
          <input type="hidden" class="form-control" id="rmImage" name="rmImage">
          <input type="hidden" class="form-control" id="ltImage" name="ltImage">
          <input type="hidden" class="form-control" id="mtImage" name="mtImage">
          <input type="hidden" class="form-control" id="clImage" name="clImage">
          <input type="hidden" class="form-control" id="lftImage" name="lftImage">
          <input type="hidden" class="form-control" id="genelToplam" name="genelToplam" value="<?=$rmTop+$ltTop+$mtTop+$clTop+$lftTop;?>">
          <input type="hidden" class="form-control" id="yil" name="yil" value="<?=date("Y",$finishtime1).' '.t('yılı');?>">
          <input type="hidden" class="form-control"  name="Reports[clientid]" value="<?=$_POST['Report']['clientid'];?>">
          <input type="hidden" class="form-control"  name="tarihAraligi" value="<?=Date('d-m-Y',$starttime1).'/ '.Date('d-m-Y',$finishtime1)?>">
          <input type="hidden" class="form-control"  name="depName" value="<?=$depName;?>">
          <input type="hidden" class="form-control" id="aciklama"  name="description" value="">
        </form>




<script>

function grafik(id,sName,sData,featureShow)
{
  //var array=sData.split(",");
  var MyChart = echarts.init(document.getElementById(id));
  option = {
      tooltip : {
          trigger: 'axis'
      },
      legend: {
          data:[sName]
      },
      toolbox: {
          show : true,
          feature : {

              magicType : {show: featureShow, type: ['line', 'bar']},
              restore : {show: featureShow},
              saveAsImage : {show: featureShow}
          }
      },
      color: ["#F2490C"],
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
                  type:'line',
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
      grafik('column-chart-rm',"<?=trim(t('RM-DIŞ ALAN KEMİRGEN'));?>",[<?=$rm.',';?>],true);
       grafik('column-chart-lt',"<?=trim(t('LT İÇ ALAN KEMİRGEN'));?>",[<?=$lt.',';?>],true);
      grafik('column-chart-mt',"<?=trim(t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI'));?>",[<?=$mt.',';?>],true);
      grafik('column-chart-cl',"<?=trim(t('CL-YÜRÜYEN HAŞERE'));?>",[<?=$cl.',';?>],true);
      grafik('column-chart-lft',"<?=trim(t('LFT-UÇAN HAŞERE'));?>",[<?=$lft;?>],true);
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

        {
            extend: 'copyHtml5',
            exportOptions: {
               columns: [ 0,1,2,3,4,5]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=mb_strtoupper($clientname->name.' '.t("AKTİVİTE GRAFİĞİ"),"UTF-8");?>',
			messageTop:'<?=$_POST['Monitoring']['date'].' - '.$_POST['Monitoring']['date1'].' / '.$depandsub;?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3,4,5]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=mb_strtoupper($clientname->name.' '.t("AKTİVİTE GRAFİĞİ"),"UTF-8");?>',
			messageTop:'<?=$_POST['Monitoring']['date'].' - '.$_POST['Monitoring']['date1'].' / '.$depandsub;?>'
		 },
        {
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
          /*
          grafik('column-chart-rm',"<?=trim(t('RM-DIŞ ALAN KEMİRGEN'));?>","<?=$rm.',';?>",false);
          grafik('column-chart-lt',"<?=trim(t('LT İÇ ALAN KEMİRGEN'));?>","<?=$lt.',';?>",false);
          grafik('column-chart-mt',"<?=trim(t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI'));?>","<?=$mt.',';?>",false);
          grafik('column-chart-cl',"<?=trim(t('CL-YÜRÜYEN HAŞERE'));?>","<?=$cl.',';?>",false);
          grafik('column-chart-lft',"<?=trim(t('LFT-UÇAN HAŞERE'));?>","<?=$lft.',';?>",false);
          setTimeout(() => {

            }, 1000);
          */
         $("#aciklama").val($("#description").val());

            html2canvas(document.querySelector('#column-chart-rm')).then(function(rmCanvas) {
                $("#rmImage").val(rmCanvas.toDataURL('image/jpeg', 0.4));
                html2canvas(document.querySelector('#column-chart-lt')).then(function(ltCanvas) {
                    $("#ltImage").val(ltCanvas.toDataURL('image/jpeg', 0.4));
                    html2canvas(document.querySelector('#column-chart-mt')).then(function(mtCanvas) {
                        $("#mtImage").val(mtCanvas.toDataURL('image/jpeg', 0.4));
                        html2canvas(document.querySelector('#column-chart-cl')).then(function(clCanvas) {
                            $("#clImage").val(clCanvas.toDataURL('image/jpeg', 0.4));
                            html2canvas(document.querySelector('#column-chart-lft')).then(function(lftCanvas) {
                                $("#lftImage").val(lftCanvas.toDataURL('image/jpeg', 0.4));

                              /*  grafik('column-chart-rm',"<?=trim(t('RM-DIŞ ALAN KEMİRGEN'));?>","<?=$rm.',';?>",true);
                                grafik('column-chart-lt',"<?=trim(t('LT İÇ ALAN KEMİRGEN'));?>","<?=$lt.',';?>",true);
                                grafik('column-chart-mt',"<?=trim(t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI'));?>","<?=$mt.',';?>",true);
                                grafik('column-chart-cl',"<?=trim(t('CL-YÜRÜYEN HAŞERE'));?>","<?=$cl.',';?>",true);
                                grafik('column-chart-lft',"<?=trim(t('LFT-UÇAN HAŞERE'));?>","<?=$lft.',';?>",true);
                                */
                                var formdata= $("#conformity-form").serialize();
                                var formElement = document.getElementById("activityRapor-form");

                                  formElement.target="_blank";
                                  formElement.action="<?=Yii::app()->getbaseUrl(true)?>/client/pdfactiviterapor/";
                                  formElement.submit();
                          });
                      });
                  });
              });
              //  var link = document.createElement('a');
              //  link.href = canvas.toDataURL();
              //  link.download = 'grafik-tablo.png';
              //  document.body.appendChild(link);
              //  console.log("asdasdasd"+link);
              //  document.body.removeChild(link);

          });

                   /* window.location = '/conformity/print'; */


         //    var request = new XMLHttpRequest();
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
					text: '<?=$_POST['Monitoring']['date'].' - '.$_POST['Monitoring']['date1'].' / '.$depandsub;?>',
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


        },
        'colvis',
		'pageLength'
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
