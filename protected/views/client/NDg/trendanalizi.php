<?php


//$_POST['Report']['pests'] zararlı türleri

$sql="";
$sqldata="(";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

$client=Client::model()->find(array("condition"=>"id = ".$_POST['Report']['clientid']));


$kriterler .='</br><b>'.t("Client Brach").' : </b>'.$client->name;


if(!isset($_POST["Monitoring"]["subid"]) || !empty($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'][0]!=0 && empty($_POST["Monitoring"]["subid"]) && $_POST['Report']['dapartmentid']!=null)
  {
	  $kriterler .='</br><b>'.t("Departments").' : </b>';
	  
	  if(is_string($_POST['Report']['dapartmentid']))
	  {
		  $sql= $sql." departmentid = ".$_POST['Report']['dapartmentid']." and ";
			$model=Departments::model()->findAll(array("condition"=>"id = ".$_POST['Report']['dapartmentid']));
	  }
	  else
	  {
		   $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
			$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).')'));
	  }
     

    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. ",";
    }
  }
  if(isset($_POST["Monitoring"]["subid"]) && intval($_POST["Monitoring"]["subid"][0])!=0)
{

	if(is_countable($_POST['Monitoring']['subid']) && count($_POST['Monitoring']['subid'])>0)
	{
		$kriterler .='</br><b>'.t("Subdepartments").' : </b>';
	$sql=$sql. " (";

  for($i=0;$i<count($_POST['Monitoring']['subid']);$i++)
    {

		$model=Departments::model()->findByPk($_POST['Monitoring']['subid'][$i]);
		if($model)
		{
			$kriterler .= ", (".Departments::model()->findByPk($model->parentid)->name." - ".$model->name.")";
		}
        $sql= $sql."subdepartment=".$_POST['Monitoring']['subid'][$i]." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
/*	else{
		$model=Departments::model()->findByPk($_POST['Monitoring']['subid'][0]);
		if($model)
		{
		//	$kriterler .= " ".$model->name;
		}
		$sql= $sql."subdepartment=".$_POST['Monitoring']['subid'][0]." and ";
	}
  */
}
}
 



if($_POST['Monitoring']['date'])
{
    $sql= $sql." checkdate >=".$midnight." and ";
	$kriterler .='</br><b>'.t("Start Date").' : </b>'.$_POST['Monitoring']['date'];
}
if($_POST['Monitoring']['date1'])
{
    $sql= $sql." checkdate <=".$midnight2." and ";
	$kriterler .='</br><b>'.t("Finish Date").' : </b>'.$_POST['Monitoring']['date1'];
}

$kriterler .= "<br>";

if($_POST["Report"]["pestsyeni"])
{
	if(isset($_POST['Report']['pestsyeni']))
	{

		$_POST['Report']['pestsyeni']=explode(",",$_POST['Report']['pestsyeni']);
		if(is_countable($_POST['Report']['pestsyeni']) && count($_POST['Report']['pestsyeni'])>0)
		{

			foreach ($_POST['Report']['pestsyeni'] as $item)
			{
				$sqldata= $sqldata."mwm.petid=".$item." or ";
				$kriterler .= " ".t(Pets::model()->findByPk($item)->name).",";
			}
			$sqldata=rtrim($sqldata,"or ");
			$sqldata= $sqldata.") and ";
		}
		else{
			$sqldata=" and mwm.petid=".$_POST["Report"]["pestsyeni"] ;

			$kriterler .= " ".t(Pets::model()->findByPk($_POST["Report"]["pestsyeni"])->name);
		}
	}
}
else{


	if(is_countable($_POST['Report']['pests']) && count($_POST['Report']['pests'])>0)
	{

	    //$arry=explode(",",$arry);
	    foreach ($_POST['Report']['pests'] as $item)
	    {
			$model=Pets::model()->findByPk($item);
			if($model)
			{
				$kriterler .= ",".t($model->name);
			}
	        $sqldata= $sqldata."mwm.petid=".$item." or ";
	    }
	    $sqldata=rtrim($sqldata,"or ");
	    $sqldata= $sqldata.") and";
	}
	else{
		$sqldata=$sqldata."mwm.petid!=0 and mwm.isproduct!=1";
		$sqldata= $sqldata.") and";
	}
}

//$sql=rtrim($sql,"and ");
$monitorler=array();
$veriler1=array();
$veriler2=array();
$toplam=0;
  if(intval($_POST['Monitoring']['mtypeid'])==-100)
{
	$monitortypexx=' in (24,25,26,30)';
}
else
{
	$monitortypexx=' in ('.$_POST['Monitoring']['mtypeid'].')';
}

$monitors=MobileworkordermonitorsView::model()->findAll(array("condition"=>$sql." checkdate!=0 and isdelete=0 and clientbranchid=".$_POST['Report']['clientid'].' and monitortype '.$monitortypexx,"order"=>"monitorid asc"));


foreach ($monitors as $monitor)
{

        if(!in_array($monitor->monitorno,$monitorler))
        {	array_push($veriler1,"-");
            array_push($monitorler,$monitor->monitorno);
        }
			//echo $sqldata.' createdtime!=0 and mobileworkordermonitorsid='.$monitor->id; exit;
        // $reports=MobileworkorderdataView::model()->findAll(array('condition'=>$sqldata.' createdtime!=0 and mobileworkordermonitorsid='.$monitor->id));

$reports=Yii::app()->db->createCommand()
		->select("mwm.*,p.name pet_name,p.color")
		->from('mobileworkorderdata_view mwm')
		->leftJoin('pets p','p.id = mwm.petid')
		->where($sqldata.' createdtime!=0 and mobileworkordermonitorsid='.$monitor->id)
		->queryAll();
		
		
        foreach ($reports as $report)
        {

			if($report['petid']!=49)
			{
					array_push($veriler1,$report['value']);
					
					array_push($veriler2,array("id"=>$monitor->id,"key"=>$monitor->monitorno,"value"=>$report['value'],"petid"=>$report['petid'],"petname"=>$report['pet_name'],"color"=>$report['color']));
			}
            //$toplam=$toplam+$report->value;
        }
		 //echo "Monitorid= ".$monitor->monitorid; print_r($reports); echo "<br>";echo "<br>"; echo "<br>";

        $toplam=0;


}

$monitortype=Monitoringtype::model()->findAll(array('condition'=>'id '.$monitortypexx));
//echo "<br>";echo "<br>"; echo "<br>";

$veriler1=array_slice($veriler1,1,count($veriler1));

array_push($veriler1,"-");


$yeni=array();
$topla=0;
foreach ($veriler1 as $item)
{
    if($item=="-")
    {
        array_push($yeni,$topla);

        $topla=0;
    }
    else{
        $topla=$topla+$item;
    }
}

$yeni2=array();
$pets=[];
$colors=[];
for($i=0;$i<count($veriler2);$i++)
{
	$yeni2[$veriler2[$i]['key']][$veriler2[$i]['petid']]['all'][]=$veriler2[$i];
	$yeni2[$veriler2[$i]['key']]['toplam']=intval($yeni2[$veriler2[$i]['key']]['toplam'])+$veriler2[$i]['value'];
	$pets[$veriler2[$i]['petid']]=$veriler2[$i]['petname'];
	$colors[$veriler2[$i]['petid']]=$veriler2[$i]['color'];
	$yeni2[$veriler2[$i]['key']][$veriler2[$i]['petid']]['petname']=$veriler2[$i]['petname'];
	$yeni2[$veriler2[$i]['key']][$veriler2[$i]['petid']]['val']=intval($yeni2[$veriler2[$i]['key']][$veriler2[$i]['petid']]['val'])+$veriler2[$i]['value'];
}
?>

  <div class="row">
    <!-- column -->
    <div class="col-lg-12">
      <div class="card">
        <div class="card-block">
         
          <br>
          

         
			  
			   
              
			    <div class="card-header ">
				   <h4 class="card-title">

				 <? 

				 $monitoringtype=Monitoringtype::model()->find(array(
								   'condition'=>'id='.$_POST['Monitoring']['mtypeid'],
							   ));
							   ?>
				 <?php				 // echo t($monitoringtype->name).' - '.t($monitoringtype->detailed).' Control Units Activity Trend Graph';
				 echo t('Pest Trend By Units');
				 ?> <br>
              </h4>
			  </br>
				 <b><?=t('Rapor Kriterleri')?> : </b>
            <?=$kriterler?>
			
								 	<div class="col-md-2 text-right" style="float:right"><a onclick="printDiv(x)" class=""><i class="fa fa-save"></i></a></div>

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
                <div class="card-content collapse show col-12">
                  <div class="card-body" id='cartcolumn'>
                    <canvas id="column-chart" height="300"></canvas>
                  </div>
				  
				   <table class="table table-striped table-bordered dataex-html5-export table-responsive" >
      <thead>
        <tr>
          <td>
            <center><b><?=t('Monitor')?></b></center>
          </td>
		  <?php foreach($pets as $key=>$pet)
		  {?>
		  <td>
			  <center><b><?=t($pet)?></b></center>
			   </td>
		  <?php }?>
          <td>
            <center><b><?=t('Toplam')?></b></center>
          </td>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($yeni2 as $keym=>$yenidata)
		  {?>
		  <tr>
			  <td style="text-align:left;">
				<?=$keym;?>
			  </td>
			   <?php foreach($pets as $key=>$pet)
			  {?>
				  <td style="text-align:left;">
					<?=$yeni2[$keym][$key]['val'];?>
				  </td>
			  <?php }?>
			  <td style="text-align:left;">
				<?=$yenidata['toplam'];?>
			  </td>
			  
			  </tr>
		  <?php }?>
      </tbody>
    </table>
                </div>
        </div>
      </div>
    </div>


   


  </div>
  
  
  
    <?php

// Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/plugins/echarts/echarts-all.js;';


// Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.min.js;';
// Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.js;';

?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
	
    <!--<script src="/assets/plugins/echarts/echarts-init.js"></script>-->

    <script>
      $("#seccc").change(function() {
        if ($("#seccc").val()!=='Max'){
          
        $("#monitornumara").val($("#seccc").val());
        $("#formm").submit();
          
        }
      });

      function monidetay(id) {
 if ($("#seccc").val()!=='Max'){
          
        $("#monitornumara").val($("#seccc").val());
        $("#formm").submit();
          
        }
      }

       /*$(document).ready(function() {
        // ==============================================================
        // Bar chart option
        // ==============================================================
        var myChart = echarts.init(document.getElementById('bar-chart'));

        // specify chart configuration item and data
        option = {
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            data: ['Total number of pest activity']
          },
          toolbox: {
            show: true,
            feature: {

              magicType: {
                show: true,
                type: ['line', 'bar']
              },
              restore: {
                show: true
              },
              saveAsImage: {
                show: true
              }
            }
          },
          color: ["#533ecf"],
          calculable: true,
          xAxis: [{
            type: 'category',
            data: [<?php $yaz=""; foreach ($monitorler as $item){ $yaz= $yaz.$item.",";} echo rtrim($yaz,",");  ?>]

          }],
          yAxis: [{
            type: 'value'
          }],
          series: [{
            name: 'Number of Activities',
            type: 'bar',
            data: [<?php $yaz=""; foreach ($yeni as $item){ $yaz= $yaz.$item.",";} echo rtrim($yaz,",");?>],
            markPoint: {
              data: [{
                  type: 'max',
                  name: 'Max'
                },
                {
                  type: 'min',
                  name: 'Min'
                }
              ]
            },
            markLine: {
              data: [{
                type: 'average',
                name: 'Average'
              }]
            }
          }]
        };

        // use configuration item and data specified to show chart
        myChart.on('click', function(params) {
          console.log(params.name);
           if (params.name!=='Max' && params.name!=='Min'){
   $("#monitornumara").val(params.name);
          $("#formm").submit();
          
        }
          
         
        });


        // use configuration item and data specified to show chart
        myChart.setOption(option, true), $(function() {
          function resize() {
            setTimeout(function() {
              myChart.resize()
            }, 100)
          }
          $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
        });

      });
    
	*/
	
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
        responsiveAnimationDuration: 500,
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
                ticks: {
                    padding: 10 // X axis labels padding
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                },
                ticks: {
                    padding: 10 // Y axis labels padding
                }
            }]
        },
        title: {
            display: true,
            text: '<?=t("Trapped Insects");?>'
        },
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: function(value, context) {
                    return value;
                },
                font: {
                    weight: 'bold'
                }
            }
        }
    };

<?php
function randomColor() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

// $colors = [];
$data = [];
// foreach ($pets as $keyp=>$pet){
	// $colors[$keyp]=randomColor();
// }
?>

        // Chart Data
    var chartData = {
        labels: [<?php $yaz=""; foreach ($yeni2 as $key=>$yeni){ $yaz= $yaz."'".$key."(".t("Total : ").$yeni['toplam'].")',";} echo rtrim($yaz,","); ?>],
        datasets: [
            <?php foreach ($pets as $keyp => $pet) { ?>
                {
                    label: "<?= t($pet) ?>",
                    data: [<?php $yaz=""; foreach ($yeni2 as $keyy => $item) { $yaz= $yaz.$yeni2[$keyy][$keyp]['val'].","; } echo rtrim($yaz,","); ?>],
                    backgroundColor: '<?php echo '#'.$colors[$keyp]; ?>',
                    hoverBackgroundColor: '<?php echo '#'.$colors[$keyp].'90'; ?>',
                    borderColor: "transparent",
                },
            <?php } ?>
        ]
    };

    var config = {
        type: 'bar',
        options: chartOptions,
        data: chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
});

	
	</script>

    <script>
      $(document).ready(function() {

        /******************************************
         *       js of HTML5 export buttons        *
         ******************************************/

        $('.dataex-html5-export').DataTable({
          dom: 'Bfrtip',
          lengthMenu: [
            [5, 10, 50, 100, -1],
            [5, 10, 50, 100, "<?=t('All');?>"]
          ],
          language: {
            buttons: {
              pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
                className: 'd-none d-sm-none d-md-block',
              },
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
          "columnDefs": [{
            "searchable": false,
            "orderable": false,
          }],
          "ordering": false,
          buttons: [{
              extend: 'copyHtml5',
              exportOptions: {
                columns: [0, 1]
              },
              text: '<?=t('
              Copy ');?>',
              className: 'd-none d-sm-none d-md-block',
              title: '<?=t('
              Regional Trend Analysis ')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> ',
              messageTop: ' <?php 
						  foreach($monitortype as $monitortypek)
						  {
							 echo $monitortypek->name.' - '.t($monitortypek->detailed).'_ '; 
						  }
						  
						  
						  ?>'
            },
            {
              extend: 'excelHtml5',
              exportOptions: {
                columns: [0, 1]
              },
              text: '<?=t('
              Excel ');?>',
              className: 'd-none d-sm-none d-md-block',
              title: '<?=t('
              Regional Trend Analysis ')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> ',
              messageTop: ' <?php 
						  foreach($monitortype as $monitortypek)
						  {
							 echo $monitortypek->name.' - '.t($monitortypek->detailed).'_ '; 
						  }
						  
						  
						  ?>'
            },
            {
              extend: 'pdfHtml5',
              exportOptions: {
               // columns: [0, 1]
              },
              text: '<?=t('
              PDF ');?>',
              //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
              title: '<?=t('
              Regional Trend Analysis ')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>',
              header: true,
              customize: function(doc) {
                doc.content.splice(0, 1, {
                  text: [{
                      text: '<?=t('Regional Trend Analysis ')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>\n',
                      bold: true,
                      fontSize: 16,
                      alignment: 'center'
                    },
                    {
                      text: ' <?php 
						  foreach($monitortype as $monitortypek)
						  {
							 echo $monitortypek->name.' - '.t($monitortypek->detailed).'_ '; 
						  }
						  
						  
						  ?>',
                      bold: true,
                      fontSize: 12,
                      alignment: 'center'
                    },

                    {
                      text: '<?=date('d - m - Y H: i: s ');?>',
                      bold: true,
                      fontSize: 11,
                      alignment: 'center'
                    }
                  ],
                  margin: [0, 0, 0, 12]

                });
              }

            },





            'colvis',
            'pageLength'
          ]
        }); <?php        $ax = User::model()->userobjecty('');
        $pageUrl = explode('?', $_SERVER['REQUEST_URI'])[0];
        $pageLength = 5;
        $table = Usertablecontrol::model()-> find(array(
          'condition' => 'userid=:userid and sayfaname=:sayfaname',
          'params' => array(
            'userid' => $ax->id,
            'sayfaname' => $pageUrl)
        ));
        if ($table) {
          $pageLength = $table->value;
        } ?>
        var table = $('.dataex-html5-export').DataTable();
        table.page.len(<?=$pageLength;?>).draw();
        var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
        var info = table.page.info();
        var lengthMenuSetting = info.length; //The value you want
        // alert(table.page.info().length);
      });
    </script>


    <?php
  Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/vendors.min.js;';
// Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/chart.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/core/app-menu.js;';



 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>