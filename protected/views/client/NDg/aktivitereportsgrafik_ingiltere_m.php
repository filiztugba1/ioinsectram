<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$date = strtotime('-1 month');
$ay='';

							   
			$monitoring=Yii::app()->db->createCommand()
			->select('m.mtypeid,mt.name monitortypename,mt.detailed')
			->from('monitoring m')
			->leftJoin('monitoringtype mt','mt.id=m.mtypeid')
			->where('m.clientid='.$_POST['Report']['clientid'].' and m.active=1')
			->group('mtypeid')
			->queryAll();
			
			
			
							
							   
			$monitorTop=[];
			
			foreach($monitoring as $monitoringx)
			{
				
				if(!in_array($monitoringx['mtypeid'],[26,31,32,33]))
				{
					$monitorTop[$monitoringx['mtypeid']]['top']=0;
					$monitorTop[$monitoringx['mtypeid']]['monitortypename']=$monitoringx['mtypeid'];
					$monitorTop[$monitoringx['mtypeid']]['monitorname']=t($monitoringx['monitortypename'].' - '.$monitoringx['detailed']);
					$monitorTop[$monitoringx['mtypeid']]['orgmonitorname']=$monitoringx['monitortypename'].' - '.$monitoringx['detailed'];
				}
				else{
					$monitorTop['26_25_32_31_4']['top']=0;
					$monitorTop['26_25_32_31_4']['monitortypename']='26_25_32_31_4';
					$monitorTop['26_25_32_31_4']['monitorname']=t('RM - Indoor  Nontoxic+Toxic');
					$monitorTop['26_25_32_31_4']['orgmonitorname']='RM - Indoor  Nontoxic+Toxic';
					
					$monitorTop['26_25_3']['top']=0;
					$monitorTop['26_25_3']['monitortypename']='26_25_3';
					$monitorTop['26_25_3']['monitorname']=t('RM - Outdoor  Nontoxic+Toxic');
					$monitorTop['26_25_3']['orgmonitorname']='RM - Outdoor  Nontoxic+Toxic';
					
					$monitorTop['25_26_31_32_33']['top']=0;
					$monitorTop['25_26_31_32_33']['monitortypename']='25_26_31_32_33';
					$monitorTop['25_26_31_32_33']['monitorname']=t('RM - Indoor  Nontoxic+Toxic + RM - Outdoor  Nontoxic+Toxic');
					$monitorTop['25_26_31_32_33']['orgmonitorname']='RM - Indoor  Nontoxic+Toxic + RM - Outdoor  Nontoxic+Toxic';
				}
			}
			
			
			
			// $monitoringType=Monitoringtype::model()->findAll();
			// foreach($monitoringType as $monitoringTypex)
			// {
				// echo 'name='.$monitoringTypex['name']. ' - id='.$monitoringTypex['id'].'<br>';
			// }
			
			// name=CI - id=6
			// name=LT - id=8
			// name=MT - id=9
			// name=RM - id=10
			// name=LFT - id=12
			// name=Sub Department Pest Control - id=17
			// name=Sub dept Disinfection - id=18
			// name=EFK - id=19
			// name=X-Lure MultiSpecies Trap - id=20
			// name=LT - Toxic - id=21
			// name=LT - NonToxic - id=22
			// name=LT - Glueboard - id=23
			// name=RM - Snaptrap - id=24
			// name=RM - Toxic - id=25
			// name=RM - NonToxic - id=26
			// name=ID - Insect Detector - id=27
			// name=ML - Moth Lure - id=28
			// name=WP - Wasp Pot - id=29
			// name=RM - Latent - id=30
			// name=Multi Purpose Box - id=31
			// name=RM - Mouse Box - id=32
			// name=RM - External Box - id=33
			
		

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
  $where=' and m.dapartmentid in ('.implode(",",$_POST['Report']['dapartmentid']).')';
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
	$where=$where.' and m.subid in ('.$subdepartmanid.')';
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


			foreach($monitorTop as $key=>$monitorTopx)
			{
				if($key==='26_25_32_31_4')
				{
					  $monitorTop['26_25_32_31_4']['val']=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype in (26,25,32,31) and m.mlocationid=4  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub,1);
   
				}
				else if($key==='26_25_3')
				{
					$monitorTop['26_25_3']['val']=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and ( mwd.monitortype in (26,25) and m.mlocationid=3   or mwd.monitortype in (33) )    and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub,1);
				}
				else if($key==='25_26_31_32_33')
				{
					$monitorTop['25_26_31_32_33']['val']=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype in (25,26,31,32,33)  and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub,1,0);
				
				}
				else{
					if(in_array(intval($key),[12,19]))
					{
						$monitorTop[$key]['val']=Client::model()->sqlaktiviterapor("mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=".$key." and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub,1);
					}
					else
					{
						$monitorTop[$key]['val']=Client::model()->sqlaktiviterapor("mwd.petid!=25 and mwd.clientbranchid=".$_POST['Report']['clientid']." and  mwd.value>0 and mwd.monitortype=".$key." and mwd.createdtime!=0 and mwm.checkdate>=".$starttime." and mwd.isproduct=0 and mwm.checkdate<=".$finishtime.$where,$dep,$sub,1);	
					}
					
				}
				
				$monitorTop[$key]['top']=$monitorTop[$key]['top']+$monitorTop[$key]['val'];
				if($i===0)
				{
					$monitorTop[$key]['grafik']=$monitorTop[$key]['val'];
				}
				else
				{
					$monitorTop[$key]['grafik']=$monitorTop[$key]['grafik'].','.$monitorTop[$key]['val'];
				}

			}
		
	
}
}

	foreach($monitorTop as $key=>$monitorTopx)
			{
				$monitorTop[$key]['explode']=explode(',',$monitorTop[$key]['grafik']);
			}

	

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
					
					
					<?php						foreach($monitorTop as $key=>$monitorTopx)
						{
							?><th><?=$monitorTop[$key]['monitorname'];?></th><?php						}
			?>
                  </tr>
                </thead>
                <tbody>
                    <?php                    for($i=0;$i<count($baslangisvebitisarray);$i++)
                    {
                      ?>
                      <tr>

                        <td><?=t(mb_convert_case(str_replace("'","", $diziay[$baslangisvebitisarray[$i]['ay']-1]), MB_CASE_TITLE, "UTF-8"));?></td>
						<?php						foreach($monitorTop as $key=>$monitorTopx)
						{
							
							?><td><?=isset($monitorTopx['explode'][$i]) && $monitorTopx['explode'][$i]!=''?$monitorTopx['explode'][$i]:0;?></td><?php						}
						?>
                      </tr>
                      <?php                    }
                    ?>

                    <tr>

                      <td><?=t('Toplam')?></td>
                     <?php						foreach($monitorTop as $key=>$monitorTopx)
						{
							?><td><?=$monitorTop[$key]['top'];?></td><?php						}
						?>
                    </tr>
                    <tr>

                      <td><?=t('Genel Toplam');?></td>
                      <td><?php					  $genelToplam=0;
					  foreach($monitorTop as $key=>$monitorTopx)
						{
							$genelToplam=intval($genelToplam)+intval($monitorTop[$key]['top']);
						
						}	echo $genelToplam;
						?></td>
						
						<?php						for($i=1;$i<count($monitorTop);$i++)
						{
							echo '<td></td>';
						}
						?>
                    </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</section>
<section id="chartjs-bar-charts">

          <!-- Column Chart -->
        
		  
		  <?php		  foreach($monitorTop as $key=>$monitorTopx)
			{
				
				?>
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
							  <div class="card-body" id="column-chart-<?=$key?>-img">
								<div id="column-chart-<?=$key?>" style="width:600px; height:300px"></div>
															<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
						<fieldset class="form-group">
										<label for="basicSelect"><?=t('Add comments for '.$monitorTop[$key]['orgmonitorname'])?></label>
						  <textarea id="description<?=$key?>" type="text" class="form-control" placeholder="<?=t('Add comments for '.$monitorTop[$key]['orgmonitorname'])?>" value=""></textarea>
						</fieldset>
					  </div>

							  </div>
											
					 
							</div>
						  </div>
						</div>
						</div>
				
				<?php			}
		  ?>
	</section>	  
		  
  <form id="activityRapor-form" action="/client/pdfactiviteraporingiltere"  method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" id="aylar" name="aylar" value="<?=$ay;?>">
		
	
          
          <input type="hidden" class="form-control" id="genelToplam" name="genelToplam" value="<?=$genelToplam;?>">
          <input type="hidden" class="form-control" id="yil" name="yil" value="<?=date("Y",$finishtime1).' '.t('yılı');?>">
          <input type="hidden" class="form-control"  name="Reports[clientid]" value="<?=$_POST['Report']['clientid'];?>">
          <input type="hidden" class="form-control"  name="tarihAraligi" value="<?=Date('d-m-Y',$starttime1).'/ '.Date('d-m-Y',$finishtime1)?>">
          <input type="hidden" class="form-control"  name="depName" value="<?=$depName;?>">
          <input type="hidden" class="form-control" id="aciklama"  name="description" value="">
		  
		  
		  
		   <? foreach($monitorTop as $key=>$monitorTopx)
			{
				?>
				 <input type="hidden" class="form-control" id="Aciklama<?=$key;?>"  name="Aciklama<?=$key;?>" value="">
				 <input type="hidden" class="form-control" id="Image<?=$key;?>"  name="Image<?=$key;?>" value="">
				 <input type="hidden" class="form-control" id="Top<?=$key;?>"  name="Top<?=$key;?>" value="<?=$monitorTopx['top'];?>">
				 <input type="hidden" class="form-control" id="Grafik<?=$key;?>"  name="Grafik<?=$key;?>" value="<?=$monitorTopx['grafik'];?>">
				<?php			}
			?>
			 <input type="hidden" class="form-control" id="tum_veri"  name="tum_veri" value='<?=json_encode($monitorTop)?>'>
		  
		  
        </form>
     


<button id="printButton">Görseli Bastır</button>  


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
		<?php		 foreach($monitorTop as $key=>$monitorTopx)
			{
				?>
				grafik('column-chart-<?=$key;?>',"<?=trim($monitorTopx['monitorname']);?>",[<?=$monitorTopx['grafik'];?>],true);
				<?php			}
		?>
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
    $("#aciklama").val($("#description").val());
    
    // Açıklamaları kaydet
    <? foreach($monitorTop as $key=>$monitorTopx) { ?>
        $("#Aciklama<?=$key;?>").val($("#description<?=$key;?>").val());
    <?php } ?>

    // Tüm grafikleri oluştur ve resimlerini al
    const captureCharts = async () => {
        <? foreach($monitorTop as $key=>$monitorTopx) { ?>
            try {
                // Grafiği başlat
                const myChart = echarts.init(document.getElementById('column-chart-<?=$key?>'));
                
                // Grafik options
                const option = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ["<?=trim($monitorTopx['monitorname']);?>"]
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {show: true, type: ['line', 'bar']},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    color: ["#F2490C"],
                    calculable: true,
                    xAxis: [{
                        type: 'category',
                        data: [<?=$ay;?>]
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series: [{
                        name: "<?=trim($monitorTopx['monitorname']);?>",
                        type: 'line',
                        data: [<?=$monitorTopx['grafik'];?>],
                        markPoint: {
                            data: [
                                {type: 'max', name: 'Max'},
                                {type: 'min', name: 'Min'}
                            ]
                        },
                        markLine: {
                            data: [
                                {type: 'average', name: 'Average'}
                            ]
                        }
                    }]
                };

                // Grafik options'ları uygula
                myChart.setOption(option);

                // Grafiğin yüklenmesini bekle
                await new Promise(resolve => setTimeout(resolve, 1500));

                // Grafiğin resmini al
                const dataURL = myChart.getDataURL({
                    type: 'jpeg',
                    pixelRatio: 2,
                    backgroundColor: '#fff'
                });

                // Resmi input'a kaydet
                $("#Image<?=$key?>").val(dataURL);

                console.log('Chart <?=$key?> captured successfully');
            } catch (error) {
                console.error('Error capturing chart <?=$key?>:', error);
            }
        <?php } ?>
    };

    // Grafikleri yakala ve formu gönder
    captureCharts().then(() => {
        setTimeout(() => {
            var formElement = document.getElementById("activityRapor-form");
            formElement.target = "_blank";
            formElement.action = "<?=Yii::app()->getbaseUrl(true)?>/client/pdfactiviteraporingiltere/";
            formElement.submit();
        }, 500);
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
