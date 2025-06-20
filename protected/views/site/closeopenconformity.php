<?php
User::model()->login();

$ax= User::model()->userobjecty('');

$date = strtotime('-1 month');

$conformity=0;
$saonamonth=0;
$allfirm=0;
$conformitya=0;
$conformityk=0;

$ay='';
 $acikuy='';
 $kapaliuy='';
 $toplam='';

	
 $yil=date('Y');
 if(isset($_POST['date']))
 {
	 
	 $starttime1=strtotime($_POST['date'].' 03:00:00');
	$tarih=$_POST['date1'].' 00:00:00';
	 $finishtime1=strtotime($tarih);

	 $yil=date('Y',$starttime1);
 }
 else
 {
	 $starttime1=strtotime('01-01-'.$yil.' 03:00:00');
	 $day = cal_days_in_month(CAL_GREGORIAN,12, $yil);
	$tarih=$day.'-12-'.($yil).' 00:00:00';
	 $finishtime1=strtotime($tarih);
 }

  $baslangicay=intval(date('m',$starttime1)-1);
 $bitisay=intval(date('m',$finishtime1));



//$ay ='"'.t('ocak').'","'.t('şubat').'","'.t('mart').'","'.t('nisan').'","'.t('mayıs').'","'.t('haziran').'","'.t('temmuz').'","'.t('ağustos').'","'.t('eylül').'","'.t('ekim').'","'.t('kasım').'","'.t('aralık').'"';

$diziay = array("'".trim(t('Ocak'))."'","'".trim(t('Şubat'))."'","'".trim(t('Mart'))."'","'".trim(t('Nisan'))."'", "'".trim(t('Mayıs'))."'","'".trim(t('Haziran'))."'","'".trim(t('Temmuz'))."'","'".trim(t('Ağustos'))."'","'".trim(t('Eylül'))."'","'".trim(t('Ekim'))."'","'".trim(t('Kasım'))."'","'".trim(t('Aralık'))."'");


for($i=$baslangicay;$i<$bitisay;$i++)
{
	if($i==$baslangicay)
	{
		$ay=$diziay[$i];
	}
	else
	{
		$ay=$ay.",".$diziay[$i];
	}
}



$ay=$ay.","."'".trim(t('Toplam'))."'";
	
$toplamuy=0;
$toplamkuy=0;

for($i=$baslangicay;$i<$bitisay;$i++)
{
	  $starttime=strtotime('01-'.($i+1).'-'.$yil.' 01:00:00');

	  if($starttime<$starttime1)
	  {
	  $starttime=$starttime1;
	  }
	
	  $day = cal_days_in_month(CAL_GREGORIAN, $i+1, $yil);
	  $tarih=$day.'-'.($i+1).'-'.$yil.' 24:59:59';
	  $finishtime=strtotime($tarih);

	  if($finishtime>$finishtime1)
	  {
	  $finishtime=$finishtime1;
	  }
	

	if ($ax->firmid ==0)     //adminse
	{ 
	
		$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (date>='.$starttime.' and date<='.$finishtime.')')); // branch

		$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch


	}

	else if($ax->firmid !=0 && $ax->branchid==0)
	{
		

		// $conformitya=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and !(statusid=1 or statusid=2 or statusid=3 or statusid=6) and date>='.$starttime.' and date<='.$finishtime)); // branch

		$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and firmid='.$ax->firmid.' and date>='.$starttime.' and date<='.$finishtime)); // branch

		// $conformityk=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and (statusid=1 or statusid=2 statusid=3 or statusid=6) and date>='.$starttime.' and date<='.$finishtime)); // branch

		$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and firmid='.$ax->firmid.' and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch

	}

		else if($ax->branchid !=0 && $ax->clientid==0)
	{
		

		// $conformitya=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and !(statusid=1 or statusid=2 or statusid=3 or statusid=6) and date>='.$starttime.' and date<='.$finishtime)); // branch

		$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and branchid='.$ax->branchid.' and date>='.$starttime.' and date<='.$finishtime)); // branch

		// $conformityk=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and (statusid=1 or statusid=2 statusid=3 or statusid=6) and date>='.$starttime.' and date<='.$finishtime)); // branch

		$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and branchid='.$ax->branchid.' and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch

	}


	else if($ax->clientid !=0 && $ax->clientbranchid==0)
	{
		
	$where=" and clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";

	//echo 'numberid!="-1" and (date>='.$starttime.' and date<='.$finishtime.')'.$where.'<br>';


		$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (date>='.$starttime.' and date<='.$finishtime.')'.$where)); // branch
	$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (statusid=1 or statusid=2 or statusid=3 or statusid=6 or statusid=4) and (date>='.$starttime.' and date<='.$finishtime.')'.$where)); // branch

		

	}
	else if($ax->clientbranchid!=0)
	{

		// $conformitya=Conformity::model()->findAll(array('condition'=>'clientid='.$ax->clientbranchid.' and !(statusid=1 or statusid=2 or statusid=3 or statusid=6 or statusid=4) and date>='.$starttime.' and date<='.$finishtime)); // branch

		$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and clientid='.$ax->clientbranchid.' and date>='.$starttime.' and date<='.$finishtime)); // branch

		$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and clientid='.$ax->clientbranchid.' and (statusid=1 or statusid=2  or statusid=3  or statusid=4 or statusid=6) and date>='.$starttime.' and date<='.$finishtime)); // branch

	}



$toplamuy=$toplamuy+count($conformitya);
$toplamkuy=$toplamkuy+count($conformityk);
	if($i==$baslangicay)
	{
		
		$acikuy=count($conformitya);
		$kapaliuy=count($conformityk);
		
	}
	else
	{
		$acikuy=$acikuy.','.count($conformitya);
		$kapaliuy=$kapaliuy.','.count($conformityk);
	}

	

}

$acikuy=$acikuy.','.$toplamuy;
$kapaliuy=$kapaliuy.','.$toplamkuy;

?>

 <section id="chartjs-bar-charts">
        <form  action="/site/closeopenconformity" method="post" >
          <!-- Column Chart -->
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <div class="card">
			  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
				<div class="row" style='margin-top:15px'>
			    <div class="col-xl-4 col-lg-4 col-md-4 mb-1" id="gzl">
                            <label id='tarihkisitlama' for="basicSelect"><?=t("Date Range");?></label>
                            <fieldset class="form-group" id='startdate'>
                                <input type="date" class="form-control" id="datetimestart" name="date"
							value="<?=date('Y-m-d',$starttime1)?>">
                            </fieldset>
                        </div>


                  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                            <label for="basicSelect" class="hidden-xs hidden-sm" style="margin-top:15px "></label>
                            <fieldset class="form-group">
                                <input type="date" class="form-control" id="datetimefinish"  name="date1" value="<?=date('Y-m-d',$finishtime1)?>"
							>
                            </fieldset>
                        </div>



                        <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						
                            <label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                            <fieldset class="form-group">
                                <div class="input-group-append" id="button-addon2">
                                    <button class="btn btn-primary" type="submit"><?=t('Report');?></button>
                                </div>
                            </fieldset>
                        </div>
                </div>
              </div>
            </div>
          </div>
		  </div>
		  </form>
          <!-- Bar Stacked Chart -->
      
         
        </section>

    <section id="chartjs-bar-charts">
       
          <!-- Column Chart -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"><?=t("Open and Close Non-Conformity");?></h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                    <canvas id="column-chart" height="300"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Bar Stacked Chart -->
      
         
        </section>







<script>




$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#column-chart");

    // Chart Options
    var chartOptions = {
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each bar to be 2px wide and green
        elements: {
            rectangle: {
                borderWidth: 2,
                borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'bottom'
            }
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'top',
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#3e3e3e",
                    drawTicks: false,

                },
                scaleLabel: {
                    display: true,
                },
			
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }]
        },
        title: {
            display: true,
            text: '<?=t("Kapalı-Açık Uygunsuzluk Durumu");?>'
        },

    };

    // Chart Data
    var chartData = {

	
        labels: [<?=$ay;?>],


           datasets: [{
            label: "<?=trim(t('Açık Uygunsuzluk'));?>",
            data: [<?=$acikuy;?>],
            backgroundColor: "#16D39A",
            hoverBackgroundColor: "rgba(22,211,154,.9)",
            borderColor: "transparent",
        }, {
            label: "<?=trim(t('Kapalı Uygunsuzluk'));?>",
            data: [<?=$kapaliuy;?>],
            backgroundColor: "#dc0000",
            hoverBackgroundColor: "rgba(226, 98, 40, 1)",
            borderColor: "transparent"
        },
		]
    };

    var config = {
        type: 'bar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
});


</script>		 
 <?php
 
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/chart.min.js;';
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