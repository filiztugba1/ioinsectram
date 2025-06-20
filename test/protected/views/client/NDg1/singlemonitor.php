<?php


$sql="";
$pets="";
$products="";
$yeni="";



$monitorpettypes=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='.$_POST['Monitoring']['mtypeid']));
$colspan=count($monitorpettypes);
foreach ($monitorpettypes as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'(isproduct=0 and id='.$monitorpettype->petsid.")"));
    if($pet)
    {
		$ing=t($pet->name);
        $pets= $pets .'<td width="50px" align="center">'.$pet->name.'</td>'; // KAPALI
        // $pets= $pets .'<td>'.$pet->name." ".$pet->id.'</td>'; Test Amaçlı Gelen veriler doğru yere geliyor mu diye AÇIK
    }

}
/*	foreach ($monitorpettypes as $monitorpettype)
{
    $pet=Pets::model()->find(array('condition'=>'isproduct=1 and id='.$monitorpettype->petsid));
    if($pet)
    {
        $pets= $pets .'<td>'.$pet->name.'</td>'; // KAPALI
        // $pets= $pets .'<td>'.$pet->name." ".$pet->id.'</td>'; Test Amaçlı Gelen veriler doğru yere geliyor mu diye AÇIK
    }

}*/
//$pets= $pets .'<td>Durum</td>';

$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
$kriterler="";
if(!isset($_POST["Monitoring"]["subid"]) || count($_POST['Monitoring']['subid'])==0){  //sub departman yoksa girsin
  if($_POST['Report']['dapartmentid'][0] <> 0)
  {

    if(count($_POST['Report']['dapartmentid'])>1)
    {
      $sql= $sql." departmentid in (".implode(",",$_POST['Report']['dapartmentid']).") and ";
      $model=Departments::model()->findAll(array("condition"=>"id in (".implode(",",$_POST['Report']['dapartmentid']).")"));
    }
    else {
      $sql= $sql." departmentid=".$_POST['Report']['dapartmentid']." and ";
      $model=Departments::model()->findAll(array("condition"=>"id=".$_POST['Report']['dapartmentid']));
    }
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
        $sql= $sql."subdepartment=".$item." or ";
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


///////////////////////////////////////////////////////
if($_POST['Monitoring']['date'])
{
    $sql= $sql." checkdate >=".$midnight." and ";
}
if($_POST['Monitoring']['date1'])
{
    $sql= $sql." checkdate <=".$midnight2." and ";
}




if(isset($_POST["Monitoring"]["monitors"]))
{

	if(count($_POST['Monitoring']['monitors'])>1)
	{
	$sql=$sql. " (";
    foreach ($_POST['Monitoring']['monitors'] as $item)
    {
        if(isset($_POST["rtype"]))
        {
            $monitor=Monitoring::model()->find(array("condition"=>"mno=".$item." and clientid=".$_POST['Report']['clientid']));
            $id=$monitor->id;
        }
        else{
            $id=$item;
        }
        $sql= $sql."monitorid=".$id." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";
	}
	else{
	     if(isset($_POST["rtype"])){
            $monitor=Monitoring::model()->find(array("condition"=>"mno=".$_POST['Monitoring']['monitors'][0]." and clientid=".$_POST['Report']['clientid']));
             $id=$monitor->id;
        }
        else{
            $id=$_POST['Monitoring']['monitors'][0];
        }
		  $sql= $sql."monitorid=".$id." and ";
	}
}




$petler=array();
$veriler1=array();
$tarihler=array();
$gostertarih=array();
$listeveri=array();






$reports=Mobileworkordermonitors::model()->findAll(array('select'=>'*,DATE_FORMAT(FROM_UNIXTIME(`checkdate`), "%Y-%m-%d") AS "timestamp"','condition'=>$sql.'checkdate!=0 and isdelete=0 and clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].'','order'=>'timestamp asc, monitorid asc'));

$bfrdate=213123123;
	foreach ($reports as $report)
	{
		if(!in_array(date("d-m-Y", $report->checkdate),$tarihler))
		{
			array_push($tarihler,date("d-m-Y", $report->checkdate));

		}
		/////////////////// Gösterilecek zamanlar start ////////////////////////
		if(!in_array(date("d/m/Y", $report->checkdate),$gostertarih))
		{
			array_push($gostertarih,date("d/m/Y", $report->checkdate));
		}
		/////////////////// Gösterilecek zamanlar end ////////////////////////

	}





//$_POST['Report']['pests'] zararlı türleri
$sql="";
$sqldata="";

$sql1="";
$sqldata1="";
$tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);

if(isset($_POST["Monitoring"]["subid"]))
{
	if(count($_POST['Monitoring']['subid'])>1)
	{
	$sql=$sql. " (";
	$sql1=$sql1. " (";
    foreach ($_POST['Monitoring']['subid'] as $item)
    {
        $sql= $sql."subdepartmentid=".$item." or ";
		$sql1= $sql1."mobileworkordermonitors.subdepartment=".$item." or ";
    }
    $sql=rtrim($sql,"or ");
    $sql= $sql.") and ";

	 $sql1=rtrim($sql1,"or ");
    $sql1= $sql1.") and ";
	}
	else{
		  $sql= $sql."subdepartmentid=".$_POST['Monitoring']['subid'][0]." and ";
		  $sql1= $sql1."mobileworkordermonitors.subdepartment=".$_POST['Monitoring']['subid'][0]." and ";

	}
}

if($_POST['Report']['dapartmentid'] <> 0)
{
    $sql= $sql." departmentid=".$_POST['Report']['dapartmentid']." and ";
	$sql1= $sql1." mobileworkordermonitors.departmentid=".$_POST['Report']['dapartmentid']." and ";
}
if($_POST['Monitoring']['date'])
{
    $sql= $sql." createdtime >=".$midnight." and ";
	$sql1= $sql1." mobileworkordermonitors.checkdate >=".$midnight." and ";
}
if($_POST['Monitoring']['date1'])
{
    $sql= $sql." createdtime <=".$midnight2." and ";
	$sql1= $sql1." mobileworkordermonitors.checkdate <=".$midnight2." and ";
}
if(isset($_POST["Monitoring"]["monitors"]))
{
	 $monitornn=$_POST["Monitoring"]["monitors"];
	            $monitornn=$monitornn[0];
      if(isset($_POST["rtype"])){
            $monitor=Monitoring::model()->find(array("condition"=>"mno=".$monitornn." and clientid=".$_POST['Report']['clientid']));
             $monitornn=$monitor->id;
        }
}
$secilimi=false;
$birdenfazlami=false;
if(isset($_POST['Report']['pests']))
{
	$sqldata="(";
	$sqldata1="(";
	$secilimi=true;
	if(count($_POST['Report']['pests'])>0)
	{
		$birdenfazlami=true;
		//$arry=explode(",",$arry);
		$yazheyvanlari='"';
		foreach ($_POST['Report']['pests'] as $item)
		{
			$sqldata= $sqldata."petid=".$item." or ";
			$sqldata1= $sqldata1."mobileworkorderdata.petid=".$item." or ";

				$findpet=Pets::model()->findByPk($item);
				$yazheyvanlari= $yazheyvanlari.$findpet->name.", ";



		}
		$yazheyvanlari=rtrim($yazheyvanlari,", ");
							$yazheyvanlari= $yazheyvanlari." ".t("");
							$yazheyvanlari= $yazheyvanlari.'"';

		$sqldata=rtrim($sqldata,"or ");
		$sqldata= $sqldata.") and";

		$sqldata1=rtrim($sqldata1,"or ");
		$sqldata1= $sqldata1.") and";
	}
	else{
		$sqldata=$sqldata."petid!=0 and isproduct!=1";
		$sqldata= $sqldata.") and";

		$sqldata1=$sqldata1."mobileworkorderdata.petid!=0 and mobileworkorderdata.isproduct!=1";
		$sqldata1= $sqldata1.") and";
	}
}





 // $reports=Mobileworkorderdata::model()->findAll(array('condition'=>$sql.$sqldata.' clientbranchid='.$_POST['Report']['clientid'].' and isproduct=0   and createdtime!=0 and monitortype='.$_POST['Monitoring']['mtypeid'],'order'=>'createdtime asc, petid asc'));


 // echo 'SELECT mobileworkorderdata.*,mobileworkordermonitors.id FROM mobileworkorderdata INNER JOIN mobileworkordermonitors ON mobileworkordermonitors.id=mobileworkorderdata.mobileworkordermonitorsid where'.$sql1.$sqldata1.' mobileworkordermonitors.clientbranchid='.$_POST['Report']['clientid'].' and mobileworkorderdata.isproduct=0   and mobileworkorderdata.createdtime!=0 and mobileworkordermonitors.monitortype='.$_POST['Monitoring']['mtypeid'].' order by mobileworkorderdata.createdtime asc, mobileworkorderdata.petid asc';
 // exit;




      $verilerrrr=array();
	  $temproray=array();

	foreach ($tarihler as $tarih)
	{



		$ay=explode("-",$tarih);  // 01-2019 explode 01,2019
		$x1=strtotime(date("$ay[0]-$ay[1]-$ay[2] 00:00:00")); // first day on month
		$x2=strtotime(date("$ay[0]-$ay[1]-$ay[2] 23:59:59")); // last day on  month

	/*	$tarihbasla=strtotime($tarih);
		$tarihbiti=($tarihbasla+(3600*24)) - 1;*/


		/*$reports=Mobileworkorderdata::model()->findAll(array('select'=>'SUM(value) AS total','condition'=>$sql.' clientbranchid='.$_POST['Report']['clientid'].' and isproduct=0 and (createdtime between '.$tarihbasla.' and '.$tarihbiti.')','order'=>'petid asc'));
		*/
		if($secilimi==true)
		{
			$parent= Yii::app()->db->createCommand('SELECT *,sum(value) as total FROM mobileworkorderdata where  '.$sqldata.' clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and isproduct=0 and (createdtime between '.$x1.' and '.$x2.') and monitorid=(SELECT id from monitoring where id='.$monitornn.' and clientid='.$_POST['Report']['clientid'].') ')->queryAll();

			foreach ($parent as $report)
			{

				$heyvan=Pets::model()->findByPk($report['petid']);
				if($heyvan)
				{

					if($birdenfazlami){
						$yazheyvanlari='"';
							foreach ($_POST['Report']['pests'] as $item)
							{
								$findpet=Pets::model()->findByPk($item);
								$yazheyvanlari= $yazheyvanlari.$findpet->name.", ";
							}
							$yazheyvanlari=rtrim($yazheyvanlari,", ");
							$yazheyvanlari= $yazheyvanlari." ".t("");
							$yazheyvanlari= $yazheyvanlari.'"';

							if(!in_array($yazheyvanlari,$petler))
							{
							if(!in_array($yazheyvanlari,$temproray))
							{
								array_push($temproray,$yazheyvanlari);
							}
							array_push($petler,$yazheyvanlari);
							array_push($listeveri,array("name"=>$yazheyvanlari,"data"=>$report['total']));
							}
					}
					else{
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

			}

			$petler=array();

			if (empty($listeveri)) {
				if(strlen($yazheyvanlari) == 0)
				{
					array_push($listeveri,array("name"=>"All pests","data"=>0));
				}
				else{
					array_push($listeveri,array("name"=>$yazheyvanlari,"data"=>0));
				}
			}
			array_push($verilerrrr,$listeveri);


			$listeveri=array();
		}
		else{
			$parent= Yii::app()->db->createCommand('SELECT *,sum(value) as total FROM mobileworkorderdata where  clientbranchid='.$_POST['Report']['clientid'].' and monitortype='.$_POST['Monitoring']['mtypeid'].' and isproduct=0 and (createdtime between '.$x1.' and '.$x2.') and monitorid=(SELECT id from monitoring where id='.$monitornn.' and clientid='.$_POST['Report']['clientid'].')')->queryAll();

				foreach ($parent as $report)
				{

					$heyvan=Pets::model()->findByPk($report['petid']);
					if($heyvan)
					{
						if(!in_array("All pests",$petler))
						{
							if(!in_array("All pests",$temproray))
							{
								array_push($temproray,"All pests");
							}
							array_push($petler,"All pests");
							array_push($listeveri,array("name"=>"All pests","data"=>$report['total']));
						}
					}
				}

				$petler=array();
				if (empty($listeveri)) {
					array_push($listeveri,array("name"=>"All pests","data"=>0));
				}
				array_push($verilerrrr,$listeveri);

				$listeveri=array();
		}



	}



/*print_r($veriler1); echo "<br>";*/
//print_r($temproray); echo "<br><br><br><br>";
//print_r($verilerrrr[0]); echo "<br><br><br><br>";
//print_r($verilerrrr[1]); echo "<br><br><br><br>";

$monitortype=Monitoringtype::model()->findByPk($_POST['Monitoring']['mtypeid']);



$yeni2=array();
$i=0;
foreach($temproray as $x)
{
foreach($verilerrrr as $itemx)
{
		foreach($itemx as $itemy)
		{

				if($itemy["name"]==$x)
				{
					array_push($yeni2,array("id"=>$gostertarih[$i],"key"=>$gostertarih[$i],"value"=>$itemy["data"]));
				}
				$i++;

		}
}
}

//var_dump($yeni2);

?>

<div class="row">
    <!-- column -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title"><?=t('Single Monitor Report')?> <br> <?=t('Monitor No');?>: <?=Monitoring::model()->find(array('condition'=>'id='.$monitornn))->mno;?>  <br> <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?><br>  <?=$monitortype->name.' - '.t($monitortype->detailed);?></h4>
                			<div id="bar-chart" style="width:100%; height:400px;"></div>
            </div>
        </div>

		<table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
							  <td><center><b><?=t('Tarih')?></b></center></td>
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
								<?php							}
							  ?>

                        </tbody>
                        <tfoot>
                          <tr>
							  <td><center><b><?=t('Tarih')?></b></center></td>
							  <td><center><b><?=t('Toplam')?></b></center></td>
							</tr>

                        </tfoot>
                      </table>
    </div>
</div>
<?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/plugins/echarts/echarts-all.js;';

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
                data:[
					<?php
					if($secilimi==false)
					{
						echo t('"All pests"');
					}
					else
					{
						if($birdenfazlami==false)
						{
						$yaz="";
						foreach ($temproray as $pet)
						{
							$yaz= $yaz.'"'.$pet.'"'.",";
						}
						echo rtrim($yaz,",");
						}
						else
						{
							$yazheyvanlari='"';
							foreach ($_POST['Report']['pests'] as $item)
							{
								$findpet=Pets::model()->findByPk($item);
								$yazheyvanlari= $yazheyvanlari.$findpet->name.", ";
							}
							$yazheyvanlari=rtrim($yazheyvanlari,", ");
							$yazheyvanlari= $yazheyvanlari." ".t("");
							$yazheyvanlari= $yazheyvanlari.'"';
							echo $yazheyvanlari;
						}
					}

					?> ]
            },
            toolbox: {
                show : true,
                feature : {

                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            color: ["#00a749","lime","purple"],
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
                        name:<?php
							if($secilimi==false)
							{
								echo t('"All pests"');
							}
							else if($birdenfazlami==true)
							{
								echo $yazheyvanlari;
							}
							else
							{
								echo '"'.$x.'"';
							}

						?>,
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
			title:'<?=t('Single Monitor Report')?><?=t('Monitor No');?>: <?=$monitornn?>  ',
			messageTop:'<?=t('Single Monitor Report')?> <br> <?=t('Monitor No');?>: <?=$monitornn?>  <br> <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?><br>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,1 ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t('Single Monitor Report')?> <?=t('Monitor No');?>: <?=$monitornn?> ',
			messageTop:'<?=t('Single Monitor Report')?> <br> <?=t('Monitor No');?>: <?=$monitornn?>  <br> <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?><br>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [0,1]
            },
			text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: '<?=t('Single Monitor Report')?> <br> <?=t('Monitor No');?>: <?=$monitornn?>  <br> <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?><br>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: '<?=t('Single Monitor Report')?> <br> <?=t('Monitor No');?>: <?=$monitornn?>  <br> <?=$_POST["Monitoring"]["date"];?> / <?=$_POST["Monitoring"]["date1"];?><br>  <?=$monitortype->name.' - '.t($monitortype->detailed);?>\n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=t('Single Monitor Report')?>  <?=t('Monitor No');?>: <?=$monitornn?>  ',
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
<?php $ax= User::model()->userobjecty('');
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
