
<?php


//$_POST['Report']['pests'] zararlı türleri
$kriterler='<div class="row"><div class="col-md-6">';
if(!isset($_POST["Monitoring"]["subid"]) || ( count($_POST['Monitoring']['subid'])==0) ){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'][0] <> 0)
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));
	$kriterler.=t('Departmanlar').' : ';
    foreach($model as $modelx)
    {
      $kriterler .= $modelx->name. " , ";
    }
    if($kriterler!="")
    {
      $kriterler .= " </br>";
    }
    
  }
   else
	  {
		  
		$kriterler.=t('Departmanlar').' : '.t('Tüm departmanlar')." </br>";
	  }
}
else
{
	 if($_POST['Report']['dapartmentid'][0] <> 0)
	  {
		$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));
		$kriterler.=t('Departmanlar').' : ';
		foreach($model as $modelx)
		{
		  $kriterler .= $modelx->name. " , ";
		}
		if($kriterler!="")
		{
		  $kriterler .= " </br>";
		}
		
	  }
   else
	  {
		  
		$kriterler.=t('Departmanlar').' : '.t('Tüm departmanlar')." </br>";
	  }
}

if(isset($_POST["Monitoring"]["subid"]) && count($_POST['Monitoring']['subid'])>1)
{
	$kriterler.=t('Alt Departmanlar').' : ';
	$sql=$sql. " (";
		foreach ($_POST['Monitoring']['subid'] as $item)
		{
			$model=Departments::model()->findByPk($item);
			if($model)
			{
				$kriterler .= " , (".Departments::model()->findByPk($model->parentid)->name." - ".$model->name.")";
			}
			$sql= $sql."subdepartmentid=".$item." or ";
		}
	$kriterler .=" </br>";
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	
}
else
{
	$kriterler.=t('Alt Departmanlar').' : '.t('Tüm alt departmanlar'). " </br>";
}


if(is_countable($_POST['Monitoring']['monitors']) && count($_POST['Monitoring']['monitors'])>0)
{
	$monitors = implode(",",$_POST['Monitoring']['monitors']);
	$sql= $sql.' monitorid in ('.$monitors .') and ';
	
	$allMonitor= Yii::app()->db->createCommand('SELECT * FROM monitoring where id in ('.$monitors.')')->queryAll();
	$arrM=[];
	foreach($allMonitor as $allMonitorx)
	{
		array_push($arrM,$allMonitorx['mno']);
	}
	$kriterler.=t('Monitörler').' : '.implode(",",$arrM). " </br>";

}
else
{
	$kriterler.=t('Monitörler').' : '.t('Tüm monitörler'). " </br>";
}
$kriterler.='</div><div class="col-md-6">';
$thh='';
if(is_countable($_POST['Monitoring']['mtypeid2']) && count($_POST['Monitoring']['mtypeid2'])>0)
{
	$monitors = implode(",",$_POST['Monitoring']['mtypeid2']);
	$sql= $sql.' monitortype in ('.$monitors .') and ';
	
	$allMonitor= Yii::app()->db->createCommand('SELECT * FROM monitoringtype where id in ('.$monitors.')')->queryAll();
	$arrM=[];
	foreach($allMonitor as $allMonitorx)
	{
		array_push($arrM,$allMonitorx['name']);
	}

$thh='<th>'.implode(",",$arrM).' '.t('TÜRLERİ').'</th>';
$kriterler.=t('Monitörler Tipleri').' : '.implode(",",$arrM). " </br>";

}
else
{
	$thh='<th>'.t('TÜM MONİTOR TÜRLERİ').'</th>';
	$kriterler.=t('Monitörler Tipleri').' : '.t('Tüm monitör tipleri'). " </br>";
}


if(is_countable($_POST['Report']['pests']) && count($_POST['Report']['pests'])>0)
{
	$monitors = implode(",",$_POST['Report']['pests']);
	$sql= $sql.' petid in ('.$monitors .') and ';
	
	$allMonitor= Yii::app()->db->createCommand('SELECT * FROM pets where id in ('.$monitors.')')->queryAll();
	$arrM=[];
	foreach($allMonitor as $allMonitorx)
	{
		array_push($arrM,$allMonitorx['name']);
	}
	$kriterler.=t('Haşere Türü').' : '.implode(",",$arrM). " </br>";

}
else
{
	$kriterler.=t('Haşere Türü').' : '.t('Tüm Haşereler'). " </br>";
}


//$sql=rtrim($sql,"and ");
$petler=array();
$veriler1=array();
$tarihler=array();
$gostertarih=array();
$listeveri=array();


$arrold=['01'=>t('Ocak'),
'02'=>t('Şubat'),
'03'=>t('Mart'),
'04'=>t('Nisan'),
'05'=>t('Mayıs'),
'06'=>t('Haziran'),
'07'=>t('Temmuz'),
'08'=>t('Ağustos'),
'09'=>t('Eylül'),
'10'=>t('Ekim'),
'11'=>t('Kasım'),
'12'=>t('Aralık'),
];

$arr=[];

if((isset($_POST['Report']['mounth']) &&count($_POST['Report']['mounth'])!=0) || intval($_POST['Report']['mounthType'][0])==1)
{
	$ucaylik=0;
	foreach($arrold as $key=>$value)
	{
		
		if(intval($_POST['Report']['mounthType'][0])==1)
		{
			if($ucaylik==0)
			{
				$ayKey= (intval($key)+2>9?strval(intval($key)+2):'0'.strval(intval($key)+2));
				$arr[$key]=$value.' - '.$arrold[$ayKey];
			}
			$ucaylik++;
			if($ucaylik==3)
			{
				$ucaylik=0;
			}
		}
		else if(in_array(strval($key),$_POST['Report']['mounth']))
		{
			$arr[$key]=$value;
		}
	}
	if(intval($_POST['Report']['mounthType'][0])==1)
	{
		$kriterler.=t('Kıyaslama Tipi').' : '.t('3 aylık periyotla kıyaslama'). " </br>";
	}
	else
	{
		$kriterler.=t('Kıyaslama Tipi').' : '.t('Seçilen aylara göre kıyaslama'). " </br>";
			 
						  $i=0;
						  $ay="";
								if (isset($_POST['Report']['mounth'])){
						  foreach($_POST['Report']['mounth'] as $m)
						  {
							  if($i!==0)
							  {
								 $ay=$ay.' - '; 
							  }
							  
								  if(intval($m)>0 && intval($m)<10)
								  {
									 
									  $ay=$ay.$arr['0'.$m]; 
								  }
								  else{
									  $ay=$ay.$arr[strval($m)]; 
								  }
							  
							  $i++;
						  }
									}
        $kriterler.=t('Aylar').' : '.$ay. " </br>";
						  
	}
	$kriterler.='</div></div>';
}
else
{
	$arr=$arrold;
}

$years=[
	$_POST['Report']['oneyear'],
	$_POST['Report']['secondyear'],
];

$datas=[];
$useMounth=[];

foreach($years as $keyYear=>$yearx)
	{
		$ucaylik==0;
		foreach($arrold as $key=>$value)
		{
	
		
		$year=$yearx[0];
		$basDate=strtotime($year.'-'.$key.'-01 00:00:00');
		
		if(intval($_POST['Report']['mounthType'][0])==1)
		{
			if($ucaylik==0)
			{
				$bitDatex=(intval($key)+3>12?(intval($year)+1):$year).'-'.(intval($key)+3>12?'01':((10>(intval($key)+3) && (intval($key)+3)>1)?'0'.(intval($key)+3):(intval($key)+3))).'-01';
				$date=date_create($bitDatex);
				 date_modify($date,"-1 day");
				 $bitDate=strtotime(date_format($date,"Y-m-d").' 23:59:59');
				 $parent= Yii::app()->db->createCommand('SELECT *,sum(value) as total FROM mobileworkorderdata_view where '.$sql.' clientbranchid='.$_POST['Report']['clientid'].'  and isproduct=0 and (checkdate between '.$basDate.' and '.$bitDate.')')->queryAll();
				
				 // $datas[$year][$key]=  $bitDate>date('Y-m-d')?0:$parent[0]['total'];
				 $datas[$year][$key]=  $basDate>time()|| $bitDate>time()?0:($parent[0]['total']==null?0:$parent[0]['total']);
				 $ayKey= (intval($key)+2>9?strval(intval($key)+2):'0'.strval(intval($key)+2));
				 $useMounth[$key]=$value.' - '.$arrold[$ayKey];
				  // echo 'SELECT *,sum(value) as total FROM mobileworkorderdata_view where '.$sql.' clientbranchid='.$_POST['Report']['clientid'].'  and isproduct=0 and (checkdate between '.$basDate.' and '.$bitDate.')<br>';
		
			}
			$ucaylik++;
			if($ucaylik==3)
			{
				$ucaylik=0;
			}
			
		
		}
		else if(empty($_POST['Report']['mounth']) || in_array(strval($key),$_POST['Report']['mounth']))
		{
			$bitDatex=($key=='12'?(intval($year)+1):$year).'-'.($key=='12'?'01':((10>(intval($key)+1) && (intval($key)+1)>1)?'0'.(intval($key)+1):(intval($key)+1))).'-01';
			$date=date_create($bitDatex);
			 date_modify($date,"-1 day");
			 $bitDate=strtotime(date_format($date,"Y-m-d").' 23:59:59');
			 $parent= Yii::app()->db->createCommand('SELECT *,sum(value) as total FROM mobileworkorderdata_view where '.$sql.' clientbranchid='.$_POST['Report']['clientid'].'  and isproduct=0 and (checkdate between '.$basDate.' and '.$bitDate.')')->queryAll();
			
			  $datas[$year][$key]=  $basDate>time()|| $bitDate>time()?0:$parent[0]['total'];
			  // $datas[$year][$key]=  $parent[0]['total'];
			 $useMounth[$key]=$value;
			 // // // echo 'SELECT *,sum(value) as total FROM mobileworkorderdata_view where '.$sql.' clientbranchid='.$_POST['Report']['clientid'].'  and isproduct=0 and (checkdate between '.$basDate.' and '.$bitDate.')<br>';
		}
	
		
		 
		
	}
}

// exit;
?>



<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						  <h4 class="card-title"><?=t('Aktivite Kıyas Raporu');?>   <?=$_POST["Report"]["oneyear"][0];?> / <?=$_POST["Report"]["secondyear"][0].' ';?>
						  <?
						  $i=0;
						  $ay="";
								if (isset($_POST['Report']['mounth'])){
						  foreach($_POST['Report']['mounth'] as $m)
						  {
							  if($i!==0)
							  {
								 $ay=$ay.' - '; 
							  }
							  
								  if(intval($m)>0 && intval($m)<10)
								  {
									 
									  $ay=$ay.$arr['0'.$m]; 
								  }
								  else{
									  $ay=$ay.$arr[strval($m)]; 
								  }
							  
							  $i++;
						  }
									}
						  echo $ay;
						  ?>
						  <br>	</h4> <br> <b><?=t('Rapor Kriterleri'). "</b> </br>"?><?=$kriterler?>

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
                            <?=$thh;?>
							<?
							foreach($useMounth as $value)
							{
								echo '<th>'.$value.'</th>';
							}
							echo '<th>'.t('Toplam').'</th>';
							?>

                          </tr>
                        </thead>
                        <tbody>

							<?php
								foreach($years as $keyYear=>$yearx)
								{
									echo '<tr>';
									echo '<td>'.$yearx[0].'</td>';
									$toplam=0;
									foreach($useMounth as $key=>$value)
									{
										echo '<td>'.intval($datas[$yearx[0]][$key]).'</td>';
										$toplam=$toplam+intval($datas[$yearx[0]][$key]);
									}
									echo '<td>'.$toplam.'</td>';
									echo '</tr>';
								} 
							?>



                        </tbody>
                        <tfoot>
                          <tr>


                        <?=$thh;?>
							<?
							$column=[];
							$say=0;
							foreach($useMounth as $value)
							{
								echo '<th>'.$value.'</th>';
								array_push($column,$say);
								$say++;
							}
							echo '<th>'.t('Toplam').'</th>';
							array_push($column,$say);
							$column=implode(',', $column);
							?>


						</tr>

                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>






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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/plugins/echarts/echarts-all.js;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/html2canvas.js;';

?>
<!--<script src="/assets/plugins/echarts/echarts-init.js"></script>-->

<script>

    $(document).ready(function() {
        var myChart = echarts.init(document.getElementById('bar-chart'));
        option = {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:[]
            },
            toolbox: {
                show : true,
                feature : {

                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            color: ["#F2490C","#0338fb"],
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data: [<?php
					$yaz=""; foreach ($useMounth as $item){ $yaz= $yaz."'".$item."',";} echo rtrim($yaz,",");  ?>]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series :  [
			<?php
					foreach($years as $keyYear=>$yearx)
					{
						$year=$yearx[0];
						$toplam="";
						$say=0;
									foreach($useMounth as $key=>$value)
									{
										if($say==0)
										{
											$toplam=intval($datas[$year][$key]);
										}
										else
										{
											$toplam=$toplam.','.intval($datas[$year][$key]);
										}
										$say++;
									}
									
			?>
			
			{
            name: '<?=$year?>',
            type: 'bar',
            data: [<?=$toplam?>],
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
          },
					<?php }?>
		  
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

    });



		function printDiv(divName) {



			    html2canvas(document.querySelector('#table1')).then(function(canvas) {

			        console.log(canvas);
			        saveAs(canvas.toDataURL(), 'grafik-tablo.png');
			    });



			function saveAs(uri, filename) {

			    var link = document.createElement('a');

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


		 $(document).ready(function(){

		//	$("#table1").css("witdh", "+="+$("#table1").witdh())

		 })


</script>


<script>



$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[50,5,10,100, -1], [50,100,5,10, "<?=t('All');?>"]],
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
                columns: [ <?=$column;?> ]
             },
			 text:'<?=t('Copy');?>',
			 className: 'd-none d-sm-none d-md-block',
			 title:'<?=t("Yıllık Aktivite Kıyas Raporu");?> (<?=date('d-m-Y H:i:s');?>)',
			 messageTop:'<?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"].'\n';?>  <?=$monitortype->name.' - '.$monitortype->detailed;?>	<?=t("Rapor Kriterleri")?>:<?='\n'.str_replace('</br>', '\n', $kriterler)?>'
         },
         {
             extend: 'excelHtml5',
             exportOptions: {
               columns: [ <?=$column;?> ]
             },
			 text:'<?=t('Excel');?>',
			 className: 'd-none d-sm-none d-md-block',
			 title:'<?=t("Yıllık Aktivite Kıyas Raporu");?> (<?=date('d-m-Y H:i:s');?>)',
			 messageTop:'<?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"].'\n';?>  <?=$monitortype->name.' - '.$monitortype->detailed;?>	<?=t("Rapor Kriterleri")?>:<?='\n'.str_replace('</br>', '\n', $kriterler)?>'
         },
     		  {
              extend: 'pdfHtml5',
			  exportOptions: {
                // columns: [ <?=$column;?> ]
             },
			 text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   title: '<?=t("Yıllık Aktivite Kıyas Raporu");?>',
			    orientation: 'landscape', 
			   
			   header: true,
			   customize: function(doc) {
				 doc.content.splice(0, 1, {
				   text: [{
					text: '<?=t("Yıllık Aktivite Kıyas Raporu");?> \n',
					 bold: true,
					 fontSize: 16,
						 alignment: 'center'
				   },
				  {
					 text: '<?=t("Rapor Kriterleri")?>:<?='\n'.strip_tags(str_replace('</br>', '\n', $kriterler))?>',
					 bold: true,
					 fontSize: 12,
						 // alignment: 'center'
				   },

						 // {
					 // text: '<?=date('d-m-Y H:i:s');?>',
					 // bold: true,
					 // fontSize: 11,
					 // alignment: 'center'
				   // }
				   ],
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
