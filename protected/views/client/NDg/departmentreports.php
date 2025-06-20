<?php

//$_POST['Report']['pests'] zararlı türleri

$sql="";
$sqldata="(";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

if(!isset($_POST["ayar"])){

	if(isset($_POST['Report']['dapartmentid']))
		{
			if($_POST['Report']['dapartmentid'][0] <> 0)
			{
			  $sqlek="and (";
			  $model=Departments::model()->findAll(array('condition'=>'parentid in ('.implode(",",$_POST['Report']['dapartmentid']).')'));

			  foreach ($model as $value) {
				  $sqlek .= "id=".$value->id." or ";

			  }
			  $sqlek=rtrim($sqlek," or ");
			  $sqlek .= ")";

				$sql= $sql.$sqlek;
			}
		}
}
else{
	if(isset($_POST['Report']['dapartmentid']))
	{
		echo $_POST['Report']['dapartmentid']->id;
			$_POST['Report']['dapartmentid']=json_decode($_POST['Report']['dapartmentid']);

		if(isset($_POST['Report']['dapartmentid']->id))
		{

			if($_POST['Report']['dapartmentid']->id <> 0)
			{
			  $sqlek="and (";
			  $model=Departments::model()->findAll(array('condition'=>'parentid in ('.$_POST['Report']['dapartmentid']->id.')'));

			  foreach ($model as $value) {
				  $sqlek .= "id=".$value->id." or ";

			  }
			  $sqlek=rtrim($sqlek," or ");
			  $sqlek .= ")";

				$sql= $sql.$sqlek;

			}
		}
	}
}

/*
if(isset($_POST["Monitoring"]["subid"]))
{
	if(count($_POST['Monitoring']['subid'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['subid'] as $item)
    {
		$model=Departments::model()->findByPk($item);
		if($model)
		{
			$kriterler .= ",".$model->name;
		}
        $sql= $sql."subdepartment=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
	else{
		$model=Departments::model()->findByPk($_POST['Monitoring']['subid'][0]);
		if($model)
		{
			$kriterler .= " ".$model->name;
		}
			$sql= $sql."subdepartment=".$_POST['Monitoring']['subid'][0]." and ";
	}
}*/



$sqlnew="";
/*if(isset($_POST["Monitoring"]["monitors"]))
{$sqlnew=" and ";

	if(count($_POST['Monitoring']['monitors'])>1)
	{
	$sqlnew=$sqlnew. " (";
    foreach ($_POST['Monitoring']['monitors'] as $item)
    {
        $monitorid=Monitoring::model()->find(array('condition'=>'clientid='.$_POST["Report"]["clientid"].' and mno='.$item));
        $sqlnew= $sqlnew."monitorid=".$monitorid->id." or ";
    }
    $sqlnew=rtrim($sqlnew,"or ");
    $sqlnew= $sqlnew.") ";
	}
	else{
      $monitorid=Monitoring::model()->find(array('condition'=>'clientid='.$_POST["Report"]["clientid"].' and mno='.$_POST['Monitoring']['monitors'][0]));
		  $sqlnew= $sqlnew."monitorid=".$monitorid->id."";
	}
}*/
if($_POST["Report"]["pestsyeni"])
{
	if(isset($_POST['Report']['pestsyeni']))
	{

		$_POST['Report']['pestsyeni']=explode(",",$_POST['Report']['pestsyeni']);
		if(count($_POST['Report']['pestsyeni'])>0)
		{
			$sqlnew .="and  (";
			foreach ($_POST['Report']['pestsyeni'] as $item)
			{
				$sqlnew= $sqlnew."petid=".$item." or ";
				$kriterler .= " ".t(Pets::model()->findByPk($item)->name).",";
			}
			$sqlnew=rtrim($sqlnew,"or ");
			$sqlnew= $sqlnew.")";
		}
		else{
			$sqlnew=" and petid=".$_POST["Report"]["pestsyeni"];
			$kriterler .= " ".t(Pets::model()->findByPk($_POST["Report"]["pestsyeni"])->name).",";
		}
	}
}
else{
	if(isset($_POST['Report']['pests']))
	{
		if(count($_POST['Report']['pests'])>0)
		{
			$sqlnew .="and  (";
			foreach ($_POST['Report']['pests'] as $item)
			{
				$sqlnew= $sqlnew."petid=".$item." or ";
				$kriterler .= " ".t(Pets::model()->findByPk($item)->name).",";
			}
			$sqlnew=rtrim($sqlnew,"or ");
			$sqlnew= $sqlnew.")";
		}
		else{
			$sqlnew=" and petid=".$_POST["Report"]["pests"];
		}
	}
}


//$sql=rtrim($sql,"and ");
$departmanlar=array();
$veriler1=array();
$toplam=0;
$parentsql="";


if(!isset($_POST["ayar"])){
  $departments=Departments::model()->findAll(array('condition'=>'clientid='.$_POST["Report"]["clientid"].' and active=1 and parentid=0'));
  $parentsql = 'departmentid';
}
else{
  $departments=Departments::model()->findAll(array('condition'=>'clientid='.$_POST["Report"]["clientid"].' and active=1 '.$sql));
  $parentsql = 'subdepartmentid';
}

// $departments=Departments::model()->findAll(array('condition'=>'clientid='.$_POST["Report"]["clientid"].' and active=1 and parentid=0'));
// $parentsql = 'departmentid';
  if(intval($_POST['Monitoring']['mtypeid'])==-100)
{
	$monitortypexx=' in (24,25,26,30)';
}
else
{
	$monitortypexx=' in ('.$_POST['Monitoring']['mtypeid'].')';
}
foreach ($departments as $department) {
  if(!in_array($department->name,$departmanlar))
  {
      array_push($departmanlar,$department->name);
  }
	// echo 'SELECT *,sum(value) as total FROM mobileworkorderdata where '.$parentsql.'='.$department->id.' and subdepartmentid!=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and isproduct=0 and (createdtime between '.$midnight.' and '.$midnight2.') '.$sqlnew.'<br>';
  $parent= Yii::app()->db->createCommand('SELECT *,sum(value) as total FROM mobileworkorderdata_view where '.$parentsql.'='.$department->id.' and clientbranchid='.$_POST['Report']['clientid'].' and monitortype'.$monitortypexx.' and isproduct=0 and (createdtime between '.$midnight.' and '.$midnight2.') '.$sqlnew)->queryAll();
	//echo 'SELECT *,sum(value) as total FROM mobileworkorderdata where '.$parentsql.'='.$department->id.' and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and isproduct=0 and (createdtime between '.$midnight.' and '.$midnight2.') '.$sqlnew.'<br>';
	 if($parent)
    {
      $reportyaz=$parent[0];
      array_push($veriler1,array("id"=>$department->id,"key"=>$department->name,"value"=>$reportyaz["total"]));
    }

  }

// echo print_r($veriler1);
//print_r($veriler1); exit;
//print_r($departmanlar); exit;
$monitortype=Monitoringtype::model()->findAll(array('condition'=>'id '.$monitortypexx));

?>



<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						  <h4 class="card-title"><?=t('Department Reports')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> <br>     
						  <?php 
						  foreach($monitortype as $monitortypek)
						  {
							 echo $monitortypek->name.' - '.t($monitortypek->detailed).', '; 
						  }
						  
						  
						  ?></h4>
							<?php

								if($_POST['Report']['dapartmentid'] != 0){
					 echo 	Client::model()->findByPk($_POST["Report"]["clientid"])->name." >>> ".Departments::model()->findByPk($_POST['Report']['dapartmentid']->id)->name;
								}
								else{
									echo 	Client::model()->findByPk($_POST["Report"]["clientid"])->name;
								}

								 ?>
				 <br> <?=t('Rapor Kriterleri')?>:<b style="font-size:14px;"> <?=$kriterler?></b>



						</div>

					</div>

                </div>



                <div class="card-content collapse show">
                  <div class="card-body card-dashboard" id='list'>

				  <div id="bar-chart" style="width:100%; height:400px;"></div>
								<!--	<div class="col-md-2 text-right" style="float:right"><a onclick="printDiv(x)" class=""><i class="fa fa-save"></i></a></div> -->


                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
							  <td><center><b><?=t('Department')?></b></center></td>
							  <td><center><b><?=t('Toplam')?></b></center></td>
							</tr>
                        </thead>
                        <tbody>

						   <?php foreach ($veriler1 as $key => $value) {
								  $val=0;
								if($value["value"])
								{
								  $val=$value["value"];
								}
								?>
								  <tr>


									<td style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$value["key"]?></td>
									<td><?=$val?></td>
								  </tr>
							   <?php  }?>



                        </tbody>
                        <tfoot>
                          <tr>
							  <td><center><b><?=t('Department')?></b></center></td>
							  <td><center><b><?=t('Toplam')?></b></center></td>
							</tr>

                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>


<?php if(1==1){ ?>
<form action="../client/reportcreate" method="post" id="submitliform" target="_blank">
<input type="hidden" name="Report[clientid]" value="<?=$_POST["Report"]["clientid"]?>"/>
<input type="hidden" id="depidnew"  name="Report[dapartmentid]" value="<?=isset($_POST["ayar"]) ? $_POST['Report']['dapartmentid']->id : "0"?>"/>
<?php if(isset($_POST["ayar"])){ ?>

	<input type="hidden" id="subdepidnew"  name="Monitoring[subid][]" value="0"/>
<?php } ?>
<input type="hidden" name="Report[type]" value="<?=isset($_POST["ayar"]) ? "2"  : $_POST["Report"]["type"]?>"/>
<input type="hidden" name="Monitoring[mtypeid]" value="<?=$_POST["Monitoring"]["mtypeid"]?>"/>
<input type="hidden" name="Monitoring[date]" value="<?=$_POST["Monitoring"]["date"]?>"/>
<input type="hidden" name="Monitoring[date1]" value="<?=$_POST["Monitoring"]["date1"]?>"/>

<?php



if(!isset($_POST["ayar"]))
{

	if(isset($_POST['Report']['pests']))
	{
		$yaz="";
		if(count($_POST['Report']['pests'])>0)
		{
			foreach ($_POST['Report']['pests'] as $item)
			{
			$yaz .= $item.",";
			}
			$yaz=trim($yaz,",");
		}
		else{
			$yaz=$_POST['Report']['pests'];
		}
	}
?>
<input type="hidden" name="Report[pestsyeni]" value="<?=$yaz?>">

<input type="hidden" name="ayar" value="1" />
</form>
<?php } ?>



<?php
if(isset($_POST["ayar"]))
{
	if($_POST["Report"]["pestsyeni"])
	if(isset($_POST['Report']['pestsyeni']))
	{
		$yaz="";


		if(count($_POST['Report']['pestsyeni'])>0)
		{
			foreach ($_POST['Report']['pestsyeni'] as $item)
			{
			$yaz .= $item.",";
			}
			$yaz=trim($yaz,",");
		}
		else{
				$yaz=$_POST['Report']['pestsyeni'];
		}
	}


?>
<input type="hidden" name="Report[pestsyeni]" value="<?=$yaz?>">

</form>
<?php } } ?>



<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}

</style>


<?php


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.js;';

?>

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
			grid: { y2:150},
            xAxis : [
                {
                    type : 'category',
                    data : [<?php $yaz=""; foreach ($veriler1 as $item){ $yaz= $yaz."'".$item["key"]."'".",";} echo rtrim($yaz,",");  ?>],
					axisLabel:{rotate:30}
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
					clickable:true,
                    data:[<?php $yaz=""; foreach ($veriler1 as $item){ $yaz= $yaz.$item["value"].",";} echo rtrim($yaz,",");?>],
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
	myChart.setOption(option, true), $(function() {
		function resize() {
			setTimeout(function() {
				myChart.resize()
			}, 100)
		}
		$(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
	});


<?php if(!isset($_POST["ayar"])){ ?>
	myChart.on('click', function (params) {
		if(params.name!='Min' && params.name!='Max')
		{
			var name= "../client/depidgetir?id=" + params.name+"&clientid="+<?=$_POST["Report"]["clientid"]?>;
			$.get( name, function( data ) {
				var veri=jQuery.parseJSON(data);
				$("#depidnew").val(JSON.stringify(veri));

				 event.preventDefault();
				$("#submitliform").submit();
			});
			

		}
	});
<?php }else{ ?>

	myChart.on('click', function (params) {
		console.log(params);
		
		var url = "../client/subdepidgetir";
		var dataToSend = {
		  id: params.name,
		  clientid: <?=$_POST["Report"]["clientid"]?>,
		  departmentid: <?=$_POST["Report"]["dapartmentid"]->id?>,
		};

		$.post(url, dataToSend, function(data) {
		  var veri = jQuery.parseJSON(data);
		  $("#subdepidnew").val(veri.id);

		  event.preventDefault();
		  $("#submitliform").submit();
		});

	});

<?php  } ?>


});







</script>


<script>



$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[50,5,10,100, -1], [50,5,10,100, "<?=t('All');?>"]],
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
	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=t('Department Reports')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> <br>     <?=$monitortype->name.' - '.t($monitortype->detailed);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,1 ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=t('Department Reports')?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> <br>     <?=$monitortype->name.' - '.t($monitortype->detailed);?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [0,1]
            },
			text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Client Branch \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=t("Total Number of Pests Based on Date");?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>	',
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
<!--  <?=t("Rapor Kriterleri")?>:<?=trim($kriterler)?>  pdf de-->
<style>
@media (max-width: 991.98px) {

.hidden-xs,.buttons-collection{
display:none;
}
 div.dataTables_wrapper div.dataTables_filter label{
 white-space: normal !important;
 }
div.dataTables_wrapper div.dataTables_filter input{
margin-left:0px !important;
}

 }
</style>



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
