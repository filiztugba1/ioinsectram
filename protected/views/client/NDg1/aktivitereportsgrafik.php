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

$diziay = array("'".trim(t('ocak'))."'","'".trim(t('şubat'))."'","'".trim(t('mart'))."'","'".trim(t('nisan'))."'", "'".trim(t('mayıs'))."'","'".trim(t('haziran'))."'","'".trim(t('temmuz'))."'","'".trim(t('ağustos'))."'","'".trim(t('eylül'))."'","'".trim(t('ekim'))."'","'".trim(t('kasım'))."'","'".trim(t('aralık'))."'");

$baslangisvebitisarray=array();

$ilkayinsongunu=date('m',$_POST['Monitoring']['date']);
$day = cal_days_in_month(CAL_GREGORIAN, $ilkayinsongunu, date('Y',$starttime1));

for($i=intval(date('Y',$starttime1));$i<=intval(date('Y',$finishtime1));$i++)
{
  if($i=intval(date('Y',$starttime1)))
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
        "baslangic"=>"o1-".$j."-".$i,
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
        "baslangic"=>"o1-".$j."-".$i,
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
if(isset($_POST['Report']['dapartmentid']) && $_POST['Report']['dapartmentid'][0]!=0)
{
  $where=' and departmentid in ('.implode(",",$_POST['Report']['dapartmentid']).')';
//  $depandsub=Departments::model()->find(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).')'.));

}

if(isset($_POST['Monitoring']['subid']))
{
  $subdepartmanid=implode(",",$_POST['Monitoring']['subid']);
  if($subdepartmanid!='' && $subdepartmanid!=0)
  {
    $where=$where.' and subdepartmentid in ('.$subdepartmanid.')';
  //  $depandsub=$depandsub.' '.t(Departments::model()->find(array("condition"=>"id=".$_POST['Monitoring']['subid']))['name']);
  }

}


if (isset($_POST['Report']['clientid']))     //adminse
{

for($i=0;$i<count($baslangisvebitisarray);$i++)
{
	  $starttime=strtotime($baslangisvebitisarray[$i]["baslangic"].' 01:00:00');
	  $tarih=$baslangisvebitisarray[$i]["bitis"].' 23:59:59';
	  $finishtime=strtotime($tarih);




    $rmval=0;
      $rmMd=Mobileworkorderdata::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=10 and (petid=37 or petid=38) and createdtime!=0 and createdtime>=".$starttime." and isproduct=0 and createdtime<=".$finishtime.$where));
    foreach($rmMd as $rmMdx)
    {
      $rmval=$rmval+$rmMdx->value;
    }
    $ltMd=Mobileworkorderdata::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=8 and (petid=37 or petid=38) and createdtime!=0 and createdtime>".$starttime." and isproduct=0 and createdtime<=".$finishtime.$where));
    $ltval=0;
    foreach($ltMd as $ltMdx)
    {
      $ltval=$ltval+$ltMdx->value;
    }
    $mtMd=Mobileworkorderdata::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=9 and createdtime!=0 and createdtime>".$starttime." and isproduct=0 and createdtime<=".$finishtime.$where));
    $mtval=0;
    foreach($mtMd as $mtMdx)
    {
      $mtval=$mtval+$mtMdx->value;
    }
    $clMd=Mobileworkorderdata::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=6 and petid!=25 and createdtime!=0 and createdtime>".$starttime." and isproduct=0 and createdtime<=".$finishtime.$where));
    $clval=0;
    foreach($clMd as $clMdx)
    {
      $clval=$clval+$clMdx->value;
    }
    $lftMd=Mobileworkorderdata::model()->findAll(array("condition"=>"clientbranchid=".$_POST['Report']['clientid']." and monitortype=12 and createdtime!=0 and createdtime>".$starttime." and isproduct=0 and createdtime<=".$finishtime.$where));
    $lftval=0;
    foreach($lftMd as $lftMdx)
    {
      $lftval=$lftval+$lftMdx->value;
    }

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
              <table  class="table table-striped table-bordered dataex-html5-export table-responsive">
                <thead>
                  <tr>

                    <th><?=date("Y",$finishtime1).' '.t('yılı');?> </th>
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

                        <td><?=str_replace("'","", $diziay[$baslangisvebitisarray[$i]['ay']-1]);;?></td>
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
            <div class="col-12">
              <div class="card">
                <div class="card-header">

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
            position: 'bottom',
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
            text: '<?=$clientname->name." ".date("Y",$finishtime1)." ".t("YILI HAŞERE AKTİVİTE GRAFİĞİ");?>'
        },

    };

    // Chart Data
    var chartData = {


        labels: [<?=$ay;?>],


           datasets: [{
            label: "<?=trim(t('RM-DIŞ ALAN KEMİRGEN'));?>",
            data: [<?=$rm;?>],
            backgroundColor: "#dc0000",
            hoverBackgroundColor: "rgba(249, 129, 129, 0.9);",
            borderColor: "transparent",
        }, {
            label: "<?=trim(t('LT İÇ ALAN KEMİRGEN'));?>",
            data: [<?=$lt;?>],
            backgroundColor: "#fda534",
            hoverBackgroundColor: "rgba(251, 197, 128, 1)",
            borderColor: "transparent"
        },
        {
         label: "<?=trim(t('MT-DEPOLANMIŞ ÜRÜN ZARARLISI'));?>",
         data: [<?=$mt;?>],
         backgroundColor: "#3a6cfd",
         hoverBackgroundColor: "rgba(130, 160, 247,.9)",
         borderColor: "transparent",
     },
        {
         label: "<?=trim(t('CL-YÜRÜYEN HAŞERE'));?>",
         data: [<?=$cl;?>],
         backgroundColor: "#ce3afd",
         hoverBackgroundColor: "rgba(218, 140, 243,.9)",
         borderColor: "transparent",
     }, {
         label: "<?=trim(t('LFT-UÇAN HAŞERE'));?>",
         data: [<?=$lft;?>],
         backgroundColor: "#16D39A",
         hoverBackgroundColor: "rgba(22,211,154,.9)",
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
			  customize: function(doc) {
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

				});
			  }

        },
        'colvis',
		'pageLength'
    ]


} );
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
