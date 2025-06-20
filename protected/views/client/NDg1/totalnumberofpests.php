
<?php


//$_POST['Report']['pests'] zararlı türleri

$sql="";
$tarih1=$_POST['Monitoring']['date']." 00:00:00";
$tarih2=$_POST['Monitoring']['date1']." 23:59:59";

$midnight = strtotime($tarih1);

$midnight2 = strtotime($tarih2);
$kriterler="";





if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'][0] <> 0)
  {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
  	$model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));

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
	if(count($_POST['Monitoring']['subid'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['subid'] as $item)
    {
		$model=Departments::model()->findByPk($item);
		if($model)
		{
			$kriterler .= ", (".Departments::model()->findByPk($model->parentid)->name." - ".$model->name.")";
		}
        $sql= $sql."subdepartmentid=".$item." or ";
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


if($_POST['Report']['subid'] <> 0)
{
    $sql= $sql." subdepartmentid=".$_POST['Report']['subid']." and ";
}


if($_POST['Monitoring']['date'])
{
    $sql= $sql." createdtime >=".$midnight." and ";
}
if($_POST['Monitoring']['date1'])
{
    $sql= $sql." createdtime <=".$midnight2." and ";
}

if(count($_POST['Monitoring']['monitors'])>0)
{
	$monitors = implode(",",$_POST['Monitoring']['monitors']);
	$sql= $sql.' monitorid in ('.$monitors .') and ';
}

//$sql=rtrim($sql,"and ");
$petler=array();
$veriler1=array();
$tarihler=array();
$gostertarih=array();
$listeveri=array();




$reports=Mobileworkorderdata::model()->findAll(array('condition'=>$sql.' clientbranchid='.$_POST['Report']['clientid'].' and isproduct=0   and createdtime!=0 and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'createdtime asc, petid asc'));


	foreach ($reports as $report)
	{
		if(!in_array(date("m-Y", $report->createdtime),$tarihler))
		{
			array_push($tarihler,date("m-Y", $report->createdtime));

		}
		/////////////////// Gösterilecek zamanlar start ////////////////////////
		if(!in_array(date("m/Y", $report->createdtime),$gostertarih))
		{
			array_push($gostertarih,date("m/Y", $report->createdtime));
		}
		/////////////////// Gösterilecek zamanlar end ////////////////////////
	}

      $verilerrrr=array();
	  $temproray=array();
	foreach ($tarihler as $tarih)
	{

		$ay=explode("-",$tarih);  // 01-2019 explode 01,2019
		$x1=strtotime(date("01-$ay[0]-$ay[1]")); // first day on month
		$ayinsondayi = cal_days_in_month(CAL_GREGORIAN, $ay[0], $ay[1]);
		$x2=strtotime(date("Y-m-t", strtotime(date("$ayinsondayi-$ay[0]-$ay[1]")))); // last day on  month
		$x2 =$x2 + 3600*24;
	/*	$tarihbasla=strtotime($tarih);
		$tarihbiti=($tarihbasla+(3600*24)) - 1;*/


		/*$reports=Mobileworkorderdata::model()->findAll(array('select'=>'SUM(value) AS total','condition'=>$sql.' clientbranchid='.$_POST['Report']['clientid'].' and isproduct=0 and (createdtime between '.$tarihbasla.' and '.$tarihbiti.')','order'=>'petid asc'));
		*/

		$parent= Yii::app()->db->createCommand('SELECT *,sum(value) as total FROM mobileworkorderdata where  '.$sql.' clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and isproduct=0 and (createdtime between '.$x1.' and '.$x2.') group by petid')->queryAll();


		foreach ($parent as $report)
        {
			$heyvan=Pets::model()->findByPk($report['petid']);
			if($heyvan)
			{

				if(!in_array($heyvan->name,$petler))
				{
					if(!in_array($heyvan->name,$temproray))
					{
						array_push($temproray,$heyvan->name);
					}
					array_push($petler,$heyvan->name);
					array_push($listeveri,array("name"=>$heyvan->name,"data"=>$report['total']));
				}
			}

		}

		$petler=array();
		array_push($verilerrrr,$listeveri);
		$listeveri=array();


	}

/*print_r($veriler1); echo "<br>";*/
//print_r($temproray); echo "<br><br><br><br>";
//print_r($verilerrrr[0]); echo "<br><br><br><br>";
//print_r($verilerrrr[1]); echo "<br><br><br><br>";

$monitortype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);

//echo "<br>";echo "<br>"; echo "<br>";

$thh='<th>'.$monitortype->name.' '.t('TÜRLERİ').'</th>';
$column='0';
for($i=0;$i<count($gostertarih);$i++)
{

	$column=$column.','.($i+1);

	$yazAy='';
	$x=explode('/',$gostertarih[$i])[0];
	if($x=='01'){ $yazAy="Ocak";}
	if($x=='02'){ $yazAy="Şubat";}
	if($x=='03'){ $yazAy="Mart";}
	if($x=='04'){ $yazAy="Nisan";}
	if($x=='05'){ $yazAy="Mayıs";}
	if($x=='06'){ $yazAy="Haziran";}
	if($x=='07'){ $yazAy="Temmuz";}
	if($x=='08'){ $yazAy="Ağustos";}
	if($x=='09'){ $yazAy="Eylül";}
	if($x=='10'){ $yazAy="Ekim";}
	if($x=='11'){ $yazAy="Kasım";}
	if($x=='12'){ $yazAy="Aralık";}
	$thh=$thh.'<th>'.t($yazAy).'</th>';


}
 //echo $column;
?>




<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						  <h4 class="card-title"><?=t('Total Number of Pests Based on Date');?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?> <br>   <?=$monitortype->name.' - '.t($monitortype->detailed);?>	</h4> <br> <?=t('Rapor Kriterleri')?>:<?=$kriterler?>

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


                          </tr>
                        </thead>
                        <tbody>

							<?php
								foreach($temproray as $x)
								{?>

										<?='<tr><td><center>'.t($x).'</center></td>';?>

										<?php
										foreach($verilerrrr as $itemx)
										{
										foreach($itemx as $itemy)
										{
											if($itemy["name"]==$x)
											echo '<td><center>'.$itemy["data"].'</center></td>';
										}
										}
										?>

									<?="</tr>";?>

								<?php } ?>



                        </tbody>
                        <tfoot>
                          <tr>


                         <?=$thh;?>


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
                data:[<?php $yaz="";foreach ($temproray as $pet){ $yaz= $yaz.'"'.trim(t($pet)).'"'.",";} echo rtrim($yaz,",");?> ]
            },
            toolbox: {
                show : true,
                feature : {

                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            color: ["#F2490C","#7AFFD2","#F27457","#FFF9D2","#65BFBF","#5C5A61","#F2B90C","#0D0D0D","#5FF68E"],
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : [<?php $yaz=""; foreach ($gostertarih as $ay){ $yaz= $yaz.'"'.$ay.'"'.",";} echo rtrim($yaz,",");  ?>]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [

                <?php
					foreach($temproray as $x)
					{?>
						{
                        name:<?='"'.t($x).'"';?>,
                        type:'bar',
                        data:[<?php
							foreach($verilerrrr as $itemx)
							{
								foreach($itemx as $itemy)
								{
									if($itemy["name"]==$x)
									echo ''.$itemy["data"].',';
								}
							}


						?>],
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
				<?php	}

                ?>
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
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=t("Total Number of Pests Based on Date");?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>	<?=t("Rapor Kriterleri")?>:<?=$kriterler?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ <?=$column;?> ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=t("Total Number of Pests Based on Date");?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>	<?=t("Rapor Kriterleri")?>:<?=$kriterler?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ <?=$column;?> ]
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
					text: '<?=t("Total Number of Pests Based on Date");?>   <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>	<?=t("Rapor Kriterleri")?>:<?=$kriterler?>',
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
