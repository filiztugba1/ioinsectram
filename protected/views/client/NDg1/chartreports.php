<?php


//$_POST['Report']['pests'] zararlı türleri

$sql="";
$sqldata="(";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'][0]!=0)
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).')'));

    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. ",";
    }
    /*if($kriterler!="")
    {
      $kriterler .=$kriterler. " - ";
    }
    */
  }
}
if(isset($_POST["Monitoring"]["subid"]))
{

	if(count($_POST['Monitoring']['subid'])>0)
	{
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


if($_POST['Monitoring']['date'])
{
    $sql= $sql." checkdate >=".$midnight." and ";
}
if($_POST['Monitoring']['date1'])
{
    $sql= $sql." checkdate <=".$midnight2." and ";
}

$kriterler .= "<br>";


if($_POST["Report"]["pestsyeni"])
{
	if(isset($_POST['Report']['pestsyeni']))
	{

		$_POST['Report']['pestsyeni']=explode(",",$_POST['Report']['pestsyeni']);
		if(count($_POST['Report']['pestsyeni'])>0)
		{

			foreach ($_POST['Report']['pestsyeni'] as $item)
			{
				$sqldata= $sqldata."petid=".$item." or ";
				$kriterler .= " ".t(Pets::model()->findByPk($item)->name).",";
			}
			$sqldata=rtrim($sqldata,"or ");
			$sqldata= $sqldata.") and ";
		}
		else{
			$sqldata=" and petid=".$_POST["Report"]["pestsyeni"] ;

			$kriterler .= " ".t(Pets::model()->findByPk($_POST["Report"]["pestsyeni"])->name);
		}
	}
}
else{


	if(count($_POST['Report']['pests'])>0)
	{

	    //$arry=explode(",",$arry);
	    foreach ($_POST['Report']['pests'] as $item)
	    {
			$model=Pets::model()->findByPk($item);
			if($model)
			{
				$kriterler .= ",".$model->name;
			}
	        $sqldata= $sqldata."petid=".$item." or ";
	    }
	    $sqldata=rtrim($sqldata,"or ");
	    $sqldata= $sqldata.") and";
	}
	else{
		$sqldata=$sqldata."petid!=0 and isproduct!=1";
		$sqldata= $sqldata.") and";
	}
}



if(isset($_POST["Monitoring"]["monitors"]))
{
	if(count($_POST['Monitoring']['monitors'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['monitors'] as $item)
    {
        $sql= $sql."monitorid=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
	else{
		  $sql= $sql."monitorid=".$_POST['Monitoring']['monitors'][0]." and ";
	}
}

//$sql=rtrim($sql,"and ");
$monitorler=array();
$veriler1=array();
$veriler2=array();
$toplam=0;

$monitors=Mobileworkordermonitors::model()->findAll(array("condition"=>$sql." checkdate!=0 and isdelete=0 and clientbranchid=".$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'],"order"=>"monitorid asc"));

foreach ($monitors as $monitor)
{

        if(!in_array($monitor->monitorno,$monitorler))
        {	array_push($veriler1,"-");
            array_push($monitorler,$monitor->monitorno);
        }
			//echo $sqldata.' createdtime!=0 and mobileworkordermonitorsid='.$monitor->id; exit;
        $reports=Mobileworkorderdata::model()->findAll(array('condition'=>$sqldata.' createdtime!=0 and mobileworkordermonitorsid='.$monitor->id));

        foreach ($reports as $report)
        {

			if($report->petid!=49)
			{
					array_push($veriler1,$report->value);
					array_push($veriler2,array("id"=>$monitor->id,"key"=>$monitor->monitorno,"value"=>$report->value));
			}
            //$toplam=$toplam+$report->value;
        }
		 //echo "Monitorid= ".$monitor->monitorid; print_r($reports); echo "<br>";echo "<br>"; echo "<br>";

        $toplam=0;


}



$monitortype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);

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
for($i=0;$i<count($veriler2);$i++)
{
	$veriler2[$i]=array_slice($veriler2[$i],1,count($veriler2[$i]));

	array_push($veriler2[$i],"-");
}

$topla2=0;

for($i=0;$i<count($veriler2);$i++)
{
	if($veriler2[$i]['key']==$veriler2[$i+1]['key'])
	{
		$topla2=$topla2+$veriler2[$i]['value'];

	}
	else
	{
		$topla2=$topla2+$veriler2[$i]['value'];
		array_push($yeni2,array("id"=>$veriler2[$i]['id'],"key"=>$veriler2[$i]['key'],"value"=>$topla2));
		$topla2=0;
	}

}


?>

<div class="row">
    <!-- column -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title"><?=t('Regional Trend Analysis')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> <br>     <?=$monitortype->name.' - '.t($monitortype->detailed);?></h4>
				 <br> <?=t('Rapor Kriterleri')?>:<?=$kriterler?>

				<div id="bar-chart" style="width:100%; height:400px;"></div>
				<div class="col-md-12 text-center">


					<!-- <select class="form-control" id="seccc">
					<option value="0" disabled selected><?=t('Select')?></option>
					<?php
					foreach ($monitorler as $item){ ?>
					<option  onclick="monidetay(<?=$item?>);"> <?=$item?> </button>
					<?php } ?>

					</select>
					-->


				</div>
            </div>
        </div>
    </div>


	<table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
							  <td><center><b><?=t('Monitor')?></b></center></td>
							  <td><center><b><?=t('Toplam')?></b></center></td>
							</tr>
                        </thead>
                        <tbody>

						   <?php

										//var_dump($veriler2);
								for($i=0;$i<count($yeni2);$i++)
							{
								?>
									<tr>


									<td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$yeni2[$i]['key']?></td>
									<td><?=$yeni2[$i]['value']?></td>
								  </tr>
								<?
							}
							  ?>







                        </tbody>
                        <tfoot>
                          <tr>
							  <td><center><b><?=t('Monitor')?></b></center></td>
							  <td><center><b><?=t('Toplam')?></b></center></td>
							</tr>

                        </tfoot>
                      </table>


</div>

<?$subid=$_POST["Monitoring"]["subid"][0];?>
<form method="post" id="formm" action="/client/reportcreate" target="_blank">
<input type="hidden" name="Report[clientid]" id="clientid" value="<?=$_POST["Report"]["clientid"]?>">
<input type="hidden" name="Report[dapartmentid]" id="clientid" value="<?=$_POST["Report"]["dapartmentid"]?>">
<input type="hidden" name="rtype" value="1">
<input type="hidden" name="Monitoring[date]" id="date" value="<?=$_POST['Monitoring']['date']?>">
<input type="hidden" name="Monitoring[date1]" id="date1" value="<?=$_POST["Monitoring"]["date1"]?>">
<input type="hidden" name="Monitoring[monitors][]" id="monitornumara" value="0">

<select hidden name="Report[pests][] "class="select2-placeholder-multiple form-control select2-hidden-accessible" multiple="multiple"
>
<?php if(isset($_POST['Report']['pests'])){ foreach($_POST['Report']['pests'] as $item){?>
<option selected value="<?=$item?>"></option>
<?php }}else{
	if($_POST['Report']['pestsyeni'])
	foreach($_POST['Report']['pestsyeni'] as $item){
	?>
	<option selected value="<?=$item?>"></option>
<?php } } ?>
</select>

<input type="hidden" name="Report[type]" value="5">
<input type="hidden" name="Monitoring[mtypeid]" value="<?=$_POST['Monitoring']['mtypeid']?>">
</form>
<?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/plugins/echarts/echarts-all.js;';

?>
<!--<script src="/assets/plugins/echarts/echarts-init.js"></script>-->

<script>
	$("#seccc").change(function() {
		$("#monitornumara").val($("#seccc").val());
		$("#formm").submit();
});

	function monidetay(id){

		$("#monitornumara").val(id);
		$("#formm").submit();
	}

    $(document).ready(function() {
        // ==============================================================
// Bar chart option
// ==============================================================
        var myChart = echarts.init(document.getElementById('bar-chart'));

// specify chart configuration item and data
        option = {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['Total number of pest activity']
            },
            toolbox: {
                show : true,
                feature : {

                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            color: ["#533ecf"],
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : [<?php $yaz=""; foreach ($monitorler as $item){ $yaz= $yaz.$item.",";} echo rtrim($yaz,",");  ?>]

                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'Number of Activities',
                    type:'bar',
                    data:[<?php $yaz=""; foreach ($yeni as $item){ $yaz= $yaz.$item.",";} echo rtrim($yaz,",");?>],
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
                }
            ]
        };

// use configuration item and data specified to show chart
       myChart.on('click', function (params) {
		console.log(params.name);
		$("#monitornumara").val(params.name);
		$("#formm").submit();
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

</script>

<script>



$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
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
		"columnDefs": [ {
				"searchable": false,
				"orderable": false,
			} ],
					"ordering": false,
	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Regional Trend Analysis')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> ',
			messageTop:'<?=$monitortype->name.' - '.t($monitortype->detailed);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,1 ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Regional Trend Analysis')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> ',
			messageTop:'<?=$monitortype->name.' - '.t($monitortype->detailed);?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [0,1]
            },
			text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: '<?=t('Regional Trend Analysis')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t('Regional Trend Analysis')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>\n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=$monitortype->name.' - '.t($monitortype->detailed);?> ',
					bold: true,
					fontSize: 12,
						alignment: 'center'
				  },

						{
					text: '<?=date('d-m-Y H:i:s');?>',
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
<?
$ax= User::model()->userobjecty('');
$pageUrl=explode('?',$_SERVER['REQUEST_URI'])[0];
$pageLength=5;
$table=Usertablecontrol::model()->find(array(
							 'condition'=>'userid=:userid and sayfaname=:sayfaname',
							 'params'=>array(
								 'userid'=>$ax->id,
								 'sayfaname'=>$pageUrl)
						 ));
if($table){
	$pageLength=$table->value;
}
?>
var table = $('.dataex-html5-export').DataTable();
table.page.len( <?=$pageLength;?> ).draw();
var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
var info = table.page.info();
var lengthMenuSetting = info.length; //The value you want
// alert(table.page.info().length);
} );
</script>


<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/switch.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
