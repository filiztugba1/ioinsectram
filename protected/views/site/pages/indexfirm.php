<?php
/*
User::model()->login();

$ax= User::model()->userobjecty('');

$firmid=$ax->firmid;
$firm=Firm::model()->find(array('condition'=>'id='.$firmid));
$country=$firm?$firm->country_id:0;

$date = strtotime('-1 month');

$conformity=0;
$saonamonth=0;
$allfirm=0;
$conformitya=0;
$conformityk=0;

	 $yil=date('Y');
$starttime=strtotime('01-01-'.$yil.' 03:00:00');
$tarih='01-01-'.($yil+1).' 00:00:00';
$finishtime=strtotime($tarih);

if ($ax->firmid ==0)     // if ($ax->type ==1)
{ // 1-superadmin 2-firm-admin  4-branch-admin  6-customer-admin
	$title=t('New Firm / Total Firm');
    $saonamonth=Firm::model()->findAll(array('condition'=>'parentid=0 and createdtime>='.$date)); // branch
	$allfirm=Firm::model()->findAll(array('condition'=>'parentid=0')); // branch


	$conformitya=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (date>='.$starttime.' and date<='.$finishtime.')')); // branch
	$conformityk=Conformity::model()->findAll(array('condition'=>'numberid!="-1" and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch
$year = date('Y') ; // Get current year and subtract 1
 $start = mktime(0, 0, 0, 1, 1, $year);
  
$end = mktime(0, 0, 0, 12, 31, $year);
  
  //echo 'startx'.$start;
	$workorder=Workorder::model()->findAll(array('condition'=>' status=3 and realendtime>'.$start.' and realendtime<'.$end)); // branch

}

else if($ax->firmid !=0 && $ax->branchid==0)
{
$title=t('New Firm Branch / Total Firm Branch');
	$saonamonth=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid.' and createdtime>='.$date)); // branch
	$allfirm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid)); // branch
	// $conformitya=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and !(statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch

	$conformitya=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and (date>='.$starttime.' and date<='.$finishtime.')')); // branch

	$conformityk=Conformity::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch
$year = date('Y') ; // Get current year and subtract 1
 $start = mktime(0, 0, 0, 1, 1, $year);
  
$end = mktime(0, 0, 0, 12, 31, $year);
  
  //echo 'startx'.$start;
	$workorder=Workorder::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and status=3 and realendtime>'.$start.' and realendtime<'.$end)); // branch
  
}
else
{
	$title=t('New Customer / Total Customer');
	$saonamonth=Client::model()->findAll(array('condition'=>'parentid=0 and isdelete=0 and ( firmid='.$ax->branchid.') and createdtime>='.$date)); // client
	$allfirm=Client::model()->findAll(array('condition'=>'parentid=0 and isdelete=0 and ( firmid='.$ax->branchid.')')); // client
	$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainclientid!=firmid group by mainclientid'));

	// $conformitya=Conformity::model()->findAll(array('condition'=>'firmbranchid='.$ax->branchid.' and !(statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); //

	$conformitya=Conformity::model()->findAll(array('condition'=>'firmbranchid='.$ax->branchid.' and (date>='.$starttime.' and date<='.$finishtime.')')); // branch

	$conformityk=Conformity::model()->findAll(array('condition'=>'firmbranchid='.$ax->branchid.' and (statusid=1 or statusid=2 or statusid=3 or statusid=6) and (date>='.$starttime.' and date<='.$finishtime.')')); // branch
$year = date('Y') ; // Get current year and subtract 1
 $start = mktime(0, 0, 0, 1, 1, $year);
  
$end = mktime(0, 0, 0, 12, 31, $year);
  
  //echo 'startx'.$start;
	$workorder=Workorder::model()->findAll(array('condition'=>'branchid='.$ax->branchid.' and status=3 and realendtime>'.$start.' and realendtime<'.$end)); // branch
}

$ocak=0;$subat=0;$mart=0;$nisan=0;$mayis=0;$haziran=0;$temmuz=0;$agustos=0;$eylul=0;$ekim=0;$kasim=0;$aralik=0;
$ocaka=0;$subata=0;$marta=0;$nisana=0;$mayisa=0;$hazirana=0;$temmuza=0;$agustosa=0;$eylula=0;$ekima=0;$kasima=0;$aralika=0;
foreach($workorder as $workorderx)
{



	if($workorderx->executiondate!='')
	{
    $x=$workorderx->executiondate;
		$mounth=date('m',$x);

		if($mounth=='01')
		{
			$ocak++;
			if($workorderx->visittypeid==26)
			{
				$ocaka++;
			}
		}
		else if($mounth=='02')
		{
			$subat++;
			if($workorderx->visittypeid==26)
			{
				$subata++;
			}
		}
		else if($mounth=='03')
		{
			$mart++;
			if($workorderx->visittypeid==26)
			{
				$marta++;
			}
		}
		else if($mounth=='04')
		{
			$nisan++;
			if($workorderx->visittypeid==26)
			{
				$nisana++;
			}
		}
		else if($mounth=='05')
		{
			$mayis++;
			if($workorderx->visittypeid==26)
			{
				$mayisa++;
			}
		}
		else if($mounth=='06')
		{
			$haziran++;
			if($workorderx->visittypeid==26)
			{
				$hazirana++;
			}
		}
		else if($mounth=='07')
		{
			$temmuz++;
			if($workorderx->visittypeid==26)
			{
				$temmuza++;
			}
		}
		else if($mounth=='08')
		{
			$agustos++;
			if($workorderx->visittypeid==26)
			{
				$agustosa++;
			}
		}
		else if($mounth=='09')
		{
			$eylul++;
			if($workorderx->visittypeid==26)
			{
				$eylula++;
			}
		}
		else if($mounth=='10')
		{
			$ekim++;
			if($workorderx->visittypeid==26)
			{
				$ekima++;
			}
		}
		else if($mounth=='11')
		{
			$kasim++;
			if($workorderx->visittypeid==26)
			{
				$kasima++;
			}
		}
		else if($mounth=='12')
		{
			$aralik++;
			if($workorderx->visittypeid==26)
			{
				$aralika++;
			}
		}
	}
}





?>
<div class="row">

<?php $class='col-xl-4 col-lg-4';
if($ax->firmid==0)
{
	$qr=Workorder::model()->findAll(array("condition"=>"(cantscancomment='' or cantscancomment='null')"));
	$notqr=Workorder::model()->findAll(array("condition"=>"cantscancomment!='' and cantscancomment!='null'"));
	$class='col-xl-4 col-lg-4';
}
if($ax->firmid!=0 && $ax->branchid==0)
{

		$qr=Workorder::model()->findAll(array("condition"=>"(cantscancomment='' or cantscancomment='null') and firmid=".$ax->firmid));
	$notqr=Workorder::model()->findAll(array("condition"=>"cantscancomment!='' and cantscancomment!='null' and firmid=".$ax->firmid));
	$class='col-xl-4 col-lg-4';
}
if($ax->branchid!=0 &&$ax->clientid==0)
{

	$qr=Workorder::model()->findAll(array("condition"=>"(cantscancomment='' or cantscancomment='null') and branchid=".$ax->branchid));
	$notqr=Workorder::model()->findAll(array("condition"=>"cantscancomment!='' and cantscancomment!='null' and branchid=".$ax->branchid));

}



?>



   <div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="row">
		<?php if(($ax->firmid!=0 && $ax->branchid!=0)){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>
		<div class="<?=$class;?> col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">
						<div class="p-2 text-center bg-info bg-darken-2">
							<i class="icon-user font-large-2 white"></i>
						</div>
						<div class="p-2 bg-gradient-x-info white media-body">
							<h5><?=$title;?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($saonamonth);?> / <?=count($tclient);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

<?php if(($ax->firmid!=0 && $ax->branchid==0) || $ax->firmid==0)
{
?>
		<div class="<?=$class;?> col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">

						<div class="p-2 text-center bg-info bg-darken-2" style='background-color: #d21f1f !important; border-right: 1px solid #e85555;'>

							<a href='/site/conformityqrreports'>
								<i class="fa fa-cloud-upload white" style='font-size: 40px;'></i>
								<div style='font-size: 15px;color: #fff;'><?=t('Rapor Al');?></div>

							</a>
						</div>

						<div class="p-2 bg-gradient-x-info white media-body" style='background-image: linear-gradient(to right, #d21f1f 0%, #ec5d5d 100%);'>
							<h5><?=t('Monitor read qr / not read qr');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="fa fa-check"> <?=count($qr);?> / <i class="fa fa-times"> <?=count($notqr);?></i></i></h5>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php }?>

				<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6) ?>


		<div class="<?=$class;?> col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">

						<div class="p-2 text-center bg-info bg-darken-2" style='background-color: #21c2dc !important; border-right: 1px solid #6bddeb;;'>

							<a href='/site/closeopenconformity'>
								<i class="fa fa-cloud-upload white" style='font-size: 40px;'></i>
								<div style='font-size: 15px;color: #fff;'><?=t('Rapor Al');?></div>

							</a>
						</div>

						<div class="p-2 bg-gradient-x-info white media-body" style='background-image: linear-gradient(to right, #21c2dc 0%, #6bddeb 100%);'>
							<h5><?=t('Opened / Closed Non-Conformities');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformitya);?> / <?=count($conformityk);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php } ?>


		<?php if(1==1){ //if($ax->type==1 || $ax->type==2 || $ax->type==4 || $ax->type==6)

	$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id WHERE (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) && conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL '.Conformity::model()->where())->queryAll();





	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{

		$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) && conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL and departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and departmentpermission.userid='.$ax->id)->queryAll();
	}?>



		<div class="<?=$class;?> col-sm-12 col-xs-12">
			<div class="card">
				<div class="card-content">
					<div class="media align-items-stretch">

						<div class="p-2 text-center bg-info bg-darken-2" style='background-color: #d21f1f !important; border-right: 1px solid #e85555;'>

							<a href='/site/conformitydeadline'>
								<i class="fa fa-cloud-upload white" style='font-size: 40px;'></i>
								<div style='font-size: 15px;color: #fff;'><?=t('Rapor Al');?></div>

							</a>
						</div>

						<div class="p-2 bg-gradient-x-info white media-body" style='background-image: linear-gradient(to right, #d21f1f 0%, #ec5d5d 100%);'>
							<h5><?=t('Non-conformities beyond the deadline');?></h5>
							<h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?=count($conformity);?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>


<?php }?>




    </div>
    </div>

<!--Product sale & buyers -->
    <div class="col-xl-8 col-lg-12 col-sm-12 col-xs-12"  class="height-300">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?=t('Callouts/Total Visits');?></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div id="products-sales"></div>
                </div>
            </div>
        </div>
    </div>

<div class="col-xl-4 col-lg-12 col-sm-12 col-xs-12"  class="height-300">
        <div class="card" >
            <div class="card-content">
                <div class="card-body sales-growth-chart">
                    <div id="monthly-sales"></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="chart-title mb-1 text-center">
                    <h6><?=t('Total monthly Visits.');?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<?php





///////////////////////////////


		$where='';

		 if($ax->firmid>0){
			 $firmid=$ax->firmid;
		 }

		 if($ax->branchid>0){
			 $branchid=$ax->branchid;
		 }

		  if($ax->clientbranchid>0){
			 $clientid=$ax->clientbranchid;
		 }






		if($firmid==0)
		{

			$where='';

			if(isset($startdate) && $startdate!='' && isset($finishdate) && $finishdate!='')
			{
				$where='date between "'.$startdate.'" and "'.$finishdate.'"';
			}
			if(isset($startdate) && $startdate=='' && isset($finishdate) && $finishdate!='')
			{
				$where='date<="'.$finishdate.'"';
			}
			if(isset($startdate) && $startdate!='' && isset($finishdate)	 && $finishdate=='')
			{
				$where='date>="'.$startdate.'"';
			}

		}
		else if($firmid>0)
		{

			$where='firmid='.$firmid;
			if($branchid!=0 || $branchid!='')
			{
				$where=$where.' and branchid='.$branchid;
			}
			if($team!=0 || $team!='')
			{
				$where=$where.' and teamstaffid='.$team;
			}
			if($staff!=0 || $staff!='')
			{
				$sarray=explode(',',$staff);
				$swhere='';
				for($i=0;$i<count($sarray);$i++)
				{
					if($i==0)
					{
						$swhere='staffid="'.$sarray[$i].'" or staffid LIKE "'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].'"';
					}
					else
					{
						$swhere=$swhere.' or (staffid="'.$sarray[$i].'" or staffid LIKE "'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].',%" or staffid LIKE "%,'.$sarray[$i].'")';
					}
				}

				$where=$where.' and ('.$swhere.')';
			}

			if($routeid!=0 || $routeid!='')
			{
				$where=$where.' and routeid='.$routeid;
			}
			if($clientid!=0 || $clientid!='')
			{
				$where=$where.' and clientid='.$clientid;
			}
			if($visittypeid!=0 || $visittypeid!='')
			{
				$where=$where.' and visittypeid='.$visittypeid;
			}

			if(isset($startdate) && $startdate!='' && isset($finishdate) && $finishdate!='')
			{
				$where=$where.' and date between "'.$startdate.'" and "'.$finishdate.'"';
			}
			if(isset($startdate) && $startdate=='' && isset($finishdate) && $finishdate!='')
			{
				$where=$where.' and date<="'.$finishdate.'"';
			}
			if(isset($startdate) && $startdate!='' && isset($finishdate)	 && $finishdate=='')
			{
				$where=$where.' and date>="'.$startdate.'"';
			}

		}


if($where==''){
  $where='1=1 ';
  $workorder=[];

}else{
  $workorder=Workorder::model()->findAll(array(
								   'condition'=>$where.' and status=3 and visittypeid<>109 ',
        
								   'order'=>'executiondate desc',
								   'limit'=>3000
									));

}

		


//$workorder=Workorder::model()->findAll(array(
					//			   'condition'=>'id > 1000 and id<1001',
					//				));

?>

<div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('VISIT REPORTS');?></h4>
						</div>

					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                    

       
                              <th><?=t('VISIT REPORT');?></th>
                              <th><?=t('EXECUTION DATE');?></th>
                            		<th><?=t('Client');?></th>		
                            	<th><?=t('DESCRIPTION');?></th>	
                            	<th><?=t('STAFF/TEAM');?></th>
                            		<th><?=t('Visit Type');?></th>
             
                          </tr>
                        </thead>
                        <tbody >
             <?php
			foreach($workorder as $workorderx){?>
              <tr>

               <!--   
				   <?php if($ax->firmid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->firmid))->name;?>
					  </td>
				  <?php }?>
				    <?php if($ax->branchid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->branchid))->name;?>
					  </td>
				  <?php }?>-->
                   
				  <td>
    <?php 
    $idsr = Servicereport::model()->find(array('condition'=>'reportno='.$workorderx->id));
    if($idsr->id > 1) {
        if($country == '2') {
            if($idsr->ti_checklist != '') {
                ?>
                <a href="/site/tireport?id=<?=$idsr->id?>&pdf=ok" target="_blank">TI_<?=$workorderx->id?></a>
                <?php
            } else {
                if($idsr->simple_client == 1) {
                    ?>
                    <a href="/site/servicereport4?id=<?=$idsr->id?>&pdf=ok" target="_blank">sVR_<?=$workorderx->id?></a>
                    <?php
                } else {
                    ?>
                    <a href="/site/servicereport4?id=<?=$idsr->id?>&pdf=ok" target="_blank">VR_<?=$workorderx->id?></a>
                    <?php
                }
            }
        } else {
            ?>
            <a href="/site/servicereport?id=<?=$idsr->id?>" target="_blank"><?=$workorderx->id?></a>
            <?php
        }
    } else {
        echo '---';
    }
    ?>
</td>

   <td>
					<?php					   if($workorderx->realendtime!='' && $workorderx->realendtime!=0)
						{
                if($idsr->id>1){
                  echo date("Y/m/d H:i:s", ($idsr->date));
                   }
				   else
				   {
					    echo date("Y/m/d H:i:s", ($workorderx->realendtime));
				   }
							
						}
						else
						{
							echo t('Continues');
						}
					 ?>
				  </td>
				 

			
				 
				   <td>
				   <?php if($workorderx->clientid!='' && $workorderx->clientid!=0){echo Client::model()->find(array('condition'=>'id='.$workorderx->clientid))->name;}?>
				 </td>
				
				   <td>
					<?=$workorderx->todo;?>
				  </td>
				 
	  <td>
					<?php if($workorderx->staffid!='' && $workorderx->staffid!=0){
						$staffs=explode(',',$workorderx->staffid);

						for($i=0;$i<count($staffs);$i++)
						{
							if($staffs[$i]!='')
							{
                $username= User::model()->find(array('condition'=>'id='.$staffs[$i]));
								echo $username->name.' '.$username->surname;//User::model()->find(array('condition'=>'id='.$staffs[$i]))->name.' ';
							}
						}
				  }?>
					<?php if($workorderx->teamstaffid!='' && $workorderx->teamstaffid!=0){
						echo Staffteam::model()->find(array('condition'=>'id='.$workorderx->teamstaffid))->teamname;
					}?>
				  </td>
				
             <td>
                 <?php                                       
                                        
                                         if   (is_numeric($workorderx->visittypeid)){
                                            $vt=Visittype::model()->find(array('condition'=>'id='.$workorderx->visittypeid)); 
                                        echo   t($vt->name);
                                         }else{
                                           echo '--';
                                         }
                                         
                                         
				?>
                 </td>    
				</tr>

		<?php		}?>


                        </tbody> 
                        <tfoot>
                          <tr>
<!--
						    <?php if($ax->firmid==0){?>
									<th><?=t('Firm');?></th>
									<?php }?>

									<?php if($ax->branchid==0){?>
									<th><?=t('Branch');?></th>
									<?php }?>-->


					
                      
       
                              <th><?=t('VISIT REPORT');?></th>
                              <th><?=t('EXECUTION DATE');?></th>
                            		<th><?=t('Client');?></th>		
                            	<th><?=t('DESCRIPTION');?></th>	
                            	<th><?=t('STAFF/TEAM');?></th>
                            		<th><?=t('Visit Type');?></th>
             
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
<script>


<?$sayilar = array("$ocak", "$subat", "$mart", "$nisan", "$nisan", "$mayis", "$haziran", "$temmuz", "$agustos", "$eylul", "$ekim", "$kasim", "$aralik"); ?>
$(window).on("load", function() {

    var e = ["<?=t('Jan');?>", "<?=t('Feb');?>", "<?=t('Mar');?>", "<?=t('Apr');?>", "<?=t('May');?>", "<?=t('Jun');?>", "<?=t('Jul');?>", "<?=t('Aug');?>", "<?=t('Sep');?>", "<?=t('Oct');?>", "<?=t('Nov');?>", "<?=t('Dec');?>"];
    Morris.Area({
        element: "products-sales",
        data: [
            {
            month: "2019-01",
            Visits: <?=$ocak;?>,
            Callouts: <?=$ocaka;?>,
            },
            {
            month: "2019-02",
            Visits: <?=$subat;?>,
            Callouts: <?=$subata;?>,
            },
            {
            month: "2019-03",
            Visits: <?=$mart;?>,
            Callouts: <?=$marta;?>,
            },
            {
            month: "2019-04",
            Visits:<?=$nisan;?>,
            Callouts: <?=$nisana;?>,
            },
            {
            month: "2019-05",
            Visits: <?=$mayis;?>,
            Callouts: <?=$mayisa;?>,
            },
            {
            month: "2019-06",
            Visits: <?=$haziran;?>,
            Callouts: <?=$hazirana;?>,
            },
            {
            month: "2019-07",
            Visits: <?=$temmuz;?>,
            Callouts: <?=$temmuza;?>,
            },
            {
            month: "2019-08",
            Visits:<?=$agustos;?>,
            Callouts: <?=$agustosa;?>,
            },
            {
            month: "2019-09",
            Visits: <?=$eylul;?>,
            Callouts: <?=$eylula;?>,
            },
            {
            month: "2019-10",
            Visits: <?=$ekim;?>,
            Callouts: <?=$ekima;?>,
            },
            {
            month: "2019-11",
            Visits: <?=$kasim;?>,
            Callouts: <?=$kasima;?>,
            },
            {
            month: "2019-12",
            Visits: <?=$aralik;?>,
            Callouts:  <?=$aralika;?>,
            },

        ],
        xkey: "<?='month';?>",
        ykeys: ["<?='Visits';?>","Callouts"],
        labels: ["<?='Visits'?>","Callouts"],
        xLabelFormat: function(r) {
            return e[r.getMonth()]
        },
        dateFormat: function(r) {
            return e[new Date(r).getMonth()]
        },
        behaveLikeLine: !0,
        ymax: <?=max($sayilar);?>,
        resize: !0,
        pointSize: 1,
        pointStrokeColors: ["#00B5B8", "#FA8E57", "#F25E75"],
        smooth: !0,
        gridLineColor: "#E4E7ED",
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 1,
        fillOpacity: .9,
        hideHover: "auto",
        lineColors: ["#00B5B8", "#FA8E57", "#F25E75"]
    }), Morris.Bar.prototype.fillForSeries = function(e) {
        return "0-#fff-#f00:20-#000"
    }, Morris.Bar({
        element: "monthly-sales",
        data: [{
            month: "<?=t('Jan');?>",
            sales: <?=$ocak;?>
        }, {
            month: "<?=t('Feb');?>",
            sales: <?=$subat;?>
        }, {
            month: "<?=t('Mar');?>",
            sales: <?=$mart;?>
        }, {
            month: "<?=t('Apr');?>",
            sales: <?=$nisan;?>
        }, {
            month: "<?=t('May');?>",
            sales: <?=$mayis;?>
        }, {
            month: "<?=t('Jun');?>",
            sales: <?=$haziran;?>
        }, {
            month: "<?=t('Jul');?>",
            sales: <?=$temmuz;?>
        }, {
            month: "<?=t('Aug');?>",
            sales: <?=$agustos;?>
        }, {
            month: "<?=t('Sep');?>",
            sales: <?=$eylul;?>
        }, {
            month: "<?=t('Oct');?>",
            sales: <?=$ekim;?>
        }, {
            month: "<?=t('Nov');?>",
            sales: <?=$kasim;?>
        }, {
            month: "<?=t('Dec');?>",
            sales: <?=$aralik;?>
        }],
        xkey: "<?='month';?>",
        ykeys: ["<?='sales';?>"],
        ymax: <?=max($sayilar);?>,
        labels: ["<?='Sales';?>"],
        barGap: 4,
        barSizeRatio: .3,
        gridTextColor: "#bfbfbf",
        gridLineColor: "#E4E7ED",
        numLines: 5,
        gridtextSize: 14,
        resize: !0,
        barColors: ["#00B5B8"],
        hideHover: "auto"
    });


            // Block Element
            $('.card s').block({
                message: '<?=t('Insufficient Data')?>',
                timeout: 20000, //unblock after 2 seconds
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none',
                }
            });

 });


$(document).ready(function() {

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
        "order": [],

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
                     //"sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
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
                 columns: [ 2,3,4,5,6,7,8,9]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t("Reports")?> (<?=date("d-m-Y H:i:s");?>)\n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [ 2,3,4,5,6,7,8,9]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'<?=t("Reports")?> (<?=date("d-m-Y H:i:s");?>)\n',
        },



		{
             extend: 'pdfHtml5',
			orientation: 'landscape',
            pageSize: 'LEGAL',
			 exportOptions: {
				 <?php if($ax->firmid==0){?>
                columns: [ 0,1,2,3,4,5,6,7,8,9],
				<?php }
				 else if($ax->branch==0){?>
                columns: [ 1,2,3,4,5,6,7,8,9],
				<?php }
				 else{?>
                columns: [ 2,3,4,5,6,7,8,9],
				<?php }?>
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: '<?=t("Reports")?>',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, { 
				  text: [{
					text: '<?=t("Reports")?> \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },

					{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 10,
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
  
  function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}
  
  
  
  var userLang = navigator.language || navigator.userLanguage; 
  if (userLang==='tr' && getCookie('crmlanguage')!=='tr'){
    let text = "Diliniz Türkçe değil, dilinizi Türkçe yapmak ister misiniz?";
  if (confirm(text) == true) {
    text = "Y";
    window.location.href = "/?language=tr";
  } else {
    text = "N";
  }
 // document.getElementById("demo").innerHTML = text;
    console.log(userLang);
  }
  
} );
</script>
<STYLE>.blockOverlay,.blockMsg{
z-index:10 !important;
}

</STYLE>


<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/switch.js;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

?>

<?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/morris.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/charts/raphael-min.js;';


?>


