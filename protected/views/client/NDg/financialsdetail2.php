<?php
if (isset($_POST['client'])){
  if (!is_numeric($_GET['branchid'])){
    echo 'no';
    exit;
  }
  

  $json=json_encode($_POST['clientsett']);

  foreach($_POST['client'] as $id=>$item){
    if (!is_numeric($id)){
      echo 'no';
      exit;
    }
    $financial=Financialsettings::model()->find(array('condition'=>'clientbranch_id='.$id));
    
    if ($financial){
       $financial->updated_time=time();
    }else{
      
         $financial=new Financialsettings;
    $financial->created_time=time();
    }
   
  
  $financial->clientbranch_id=$id;
    $financial->contract_start_date=$item['contratstartdate'];
    $financial->contract_end_date=$item['contratenddate'];
    $financial->vat=$item['vat'];
    
    $financial->joint_period=$item['freetype'];
    $financial->joint_limit=$item['maxtotfree'];
    $financial->json_data=$json;
        if ($financial->save()){
          echo 'ok';
        }else{
          echo 'no';
        }
   
  }
  
  exit;
}
$ax= User::model()->userobjecty('');
if(isset($_GET['firmid']) && $_GET['firmid']!=0)
{
	$ax->branchid=$_GET['firmid'];
}

$isActive=isset($_GET['status'])?intval($_GET['status']):1;
User::model()->login();

$parentid=Client::model()->find(array('condition'=>'id='.$_GET['id'],));


$clientview=Client::model()->find(array('condition'=>'id='.$_GET['id']));
$transferclient=0;
$countries=Country::model()->findAll();
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (firmid='.$clientview->firmid.' or mainfirmid='.$clientview->firmid.')'.($isActive!=0?' and active='.(intval($isActive)==1?1:0):''),
							   ));


$transferclient=0;

if($ax->branchid>0)
{


	$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (mainfirmid='.$ax->branchid.' or firmid='.$ax->branchid.')'.($isActive!=0?' and active='.(intval($isActive)==1?1:0):''),
							   ));


	$clientview=Client::model()->find(array('condition'=>'id='.$_GET['id'].($isActive!=0?' and active='.(intval($isActive)==1?1:0):'')));
		if($clientview->mainfirmid!=$ax->branchid)
		{
			$transferclient=1;
		}





}


if($ax->clientid>0)
{


	$client=Client::model()->findAll(array(
	#'select'=>'',
	 #'limit'=>'5',
	'order'=>'name ASC',
	'condition'=>'parentid='.$ax->clientid.' and isdelete=0'.($isActive!=0?' and active='.(intval($isActive)==1?1:0):''),
	 ));


}



$transfer=0;
if($clients->firmid!=$clients->mainfirmid && $clients->firmid!=$_GET['id'])
{
	 $transfer=1;
}

?>

  <?php if (Yii::app()->user->checkAccess('client.branch.view')){ ?>
  <?=User::model()->geturl('Client','Branch',$_GET['id'],'client',0,$ax->branchid);?>


    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12">

        <div class="card">
          <div class="card-header" style="">
            <ul class="nav nav-tabs">

              <?php if (Yii::app()->user->checkAccess('client.branch.view')){ ?>
              <li class="nav-item">
                <a class="nav-link " href="<?=Yii::app()->baseUrl?>/client/view?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>"><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $client);?></span><?=t('Branch');?></a>
              </li>
              <?php }?>

                <?php if (Yii::app()->user->checkAccess('client.staff.view')  && $transferclient==0){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?=Yii::app()->baseUrl?>/client/staff?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>"><span class="btn-effect2" style="font-size: 15px;"><?php								$say=User::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and clientbranchid=0'));
							echo count($say);?>
						</span><?=t('Staff');?>
						</a>
                </li>

                <?php }?>
                  <?php if ($ax->type==22 || $ax->type==17 || $ax->type==23 || $ax->type==13 || $ax->type==13 || $ax->id==1){ ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?=Yii::app()->baseUrl?>/client/workorderreports?id=<?=$_GET['id'];?>&firmid=<?=$ax->branchid;?>"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Workorder Report');?></a>
                  </li>
                  <?php }?>

                    <?php if ($ax->type==23 || $ax->type==13 || $ax->id==1){ ?>
                    <li class="nav-item">
                      <a class="nav-link active" href="<?=Yii::app()->baseUrl?>/client/financials?id=<?=$_GET['id'];?>"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-text-o" style="font-size: 15px;"></i></span><?=t('Financials');?></a>
                    </li>

                    <?php }?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <style>
      .alprow {
        min-height: 25px!important;
        width: 70%;
        float: left;
        border: 1px solid #000000;
        font-size: inherit!important;
      }

      .alprow2 {
        min-height: 25px!important;
        width: 50%;
        float: left;
        border: 1px solid #000000;
        padding: 0px;
        text-align: left;
        font-size: inherit!important;
      }

      .alptitle {
        background: #2196f3;
        color: white;
        font-weight: bold;
        text-align: right;
        padding-top: 2px;
        padding-bottom: 1px;
        width: 30% !important;
      }

      .alptitle2 {
        background: #2196f3;
        color: white;
        font-weight: bold;
        text-align: right;
        padding-top: 2px;
        padding-bottom: 1px;
        width: 50% !important;
      }

      .alppad0 {
        padding: 0px!important;
        font-size: 15px!important;
      }

      .alppad1 {
        padding-right: 15px!important;
        padding-left: 15px!important;
      }

      .alptext {
        line-height: 25px;
        padding-left: 10px!important;
      }

      .alpcoltit {
        line-height: 25px;
        width: 100% !important;
        background: #2196f3;
        color: white;
        font-weight: bold;
        text-align: center;
        border-right: 1px solid #e3ebf3;
        font-size: 15px!important;
      }

      .alpcoltit1 {
        line-height: 25px;
        width: 100% !important;
        background: white; //color:black;
        font-weight: bold;
        text-align: center;
        border-right: 1px solid #e3ebf3;
        font-size: 15px!important;
      }
      .table th, .table td {
    //padding: 0.75rem 2rem;
    padding: 7px !important;
}
    </style>

    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12" style=" min-height:250px; background:white; padding:15px;">





          <?php			//php döngü başla
																						 
			
					
 
					foreach($client as $clientrow)
					{
            if ($clientrow->id<>$_GET['detail']) continue;
					    $financial=Financialsettings::model()->find(array('condition'=>'clientbranch_id='.$clientrow->id));
    
    if ($financial){
       
    }else{
     $financial=new Financialsettings;
     $financial->clientbranch_id=$clientrow->id;
     $financial->contract_start_date='';
     $financial->contract_end_date='';
     $financial->vat='';
     $financial->joint_period='';
     $financial->joint_limit='';
     $financial->json_data='';
    }
						
            
            		$type=Visittype::model()->findall(array('condition'=>'firmid=0 or (firmid='.$ax->firmid.' and branchid='.$clientview->firmid.')'.' or ( firmid='.$ax->firmid.' and branchid=0 ) order by id = 25 desc, id=75 desc, id=26 desc, id=62 desc, id=31 desc, id=76 desc, id=32 desc, id=41 desc, id=60 desc  '));

            
            
			?>
          
                       <div class="card">
        

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
       
                    <br>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Visit Type</th>
                          <th>Contract Period </th>
                          <th>Contracted Visits</th>
                          <th>Planned Visits</th>
                          <th>Completed Visits</th>
                          <th>Unit Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php            $grandtotal=0;
            $basilanlar=[];
                        				 foreach($type as $typex){
                          
                               $visitperiod='';
                               $visitnumber='0';
                               $unitprice='';
                               $freecreditperiod='';
                               $freecreditinayear='';
                     if ($financial->json_data<>'' && json_decode($financial->json_data)){
                        $jsondata=json_decode($financial->json_data,true);
                       
                       if (isset($jsondata[$financial->clientbranch_id][$typex->id]['visitperiod'])){
                         $visitperiod=$jsondata[$financial->clientbranch_id][$typex->id]['visitperiod'];
                       }  
                       if (isset($jsondata[$financial->clientbranch_id][$typex->id]['visitnumber'])){
                         $visitnumber=$jsondata[$financial->clientbranch_id][$typex->id]['visitnumber'];
                       }
                       if (isset($jsondata[$financial->clientbranch_id][$typex->id]['unitprice'])){
                         $unitprice=$jsondata[$financial->clientbranch_id][$typex->id]['unitprice'];
                       }
                       if (isset($jsondata[$financial->clientbranch_id][$typex->id]['freecreditperiod'])){
                         $freecreditperiod=$jsondata[$financial->clientbranch_id][$typex->id]['freecreditperiod'];
                       }
                       if (isset($jsondata[$financial->clientbranch_id][$typex->id]['freecreditinayear'])){
                         $freecreditinayear=$jsondata[$financial->clientbranch_id][$typex->id]['freecreditinayear'];
                       }
                        if (isset($jsondata[$financial->clientbranch_id][$typex->id]['month'])){
                         $monthssett=$jsondata[$financial->clientbranch_id][$typex->id]['month'];
                
                             
                       }
 
                     }
                                   if ($visitnumber=='') {
                                     $visitnumber=0;
                                   }
                                   if ($unitprice=='') {
                                     $unitprice=0;
                                   }
                                   
                                   
                                   if ($financial->contract_start_date>$selectedmonth){
                                     $selectedmonth=$financial->contract_start_date;
                                   }
                                   
                                   $start_date=$financial->contract_start_date;
                                   //$start_date=$selectedmonth;
                                   $start_time=strtotime($start_date.' 00:00:00');
                                   
                                   
                                   
                                   $start_datex    = new DateTime($selectedmonth);
                                   $start_datex->modify('last day of this month');
                                   if ($start_datex->format("Y-m-d") > $financial->contract_end_date ){
                                     $end_date=$financial->contract_end_date;
                                   }else{
                                       $end_date=$start_datex->format("Y-m-d");
                                
                                   }
                                        $end_date=$financial->contract_end_date;
                                   $end_time=strtotime($end_date.' 23:59:59');
                                  
                                   
                                   
                             //   echo 'status>0 and date>="'.$financial->contract_start_date.'"  and date>="'.$start_date.'" and date<="'.$start_datex->format("Y-m-d").'" and date<="'.$financial->contract_end_date.'" and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc ';exit;
                  $plannedworkorder=Workorder::model()->findAll(array('condition'=>'status>=0 and  date>="'.$financial->contract_start_date.'" and date<="'.$financial->contract_end_date.'"  and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc '));
                  $closedworkorder=Workorder::model()->findAll(array('condition'=>'status=3 and realendtime>="'.$start_time.'" and realendtime<="'.$end_time.'" and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc '));
                                   $plannedworkordercount=0;
									foreach($plannedworkorder as $workorderp){
                    $plannedworkordercount++;
                  }         
                                   $closedworkordercount=0;
									foreach($closedworkorder as $workorderp){
                    $closedworkordercount++;
                  }
                       
                        if ($plannedworkordercount==0 && $closedworkordercount==0 && ($visitnumber=='' || $visitnumber==0) ) continue; // hiç bir şey yoksa kalabalık etmeden geçiyoruz
                  $total=$unitprice*$closedworkordercount;
                                   $grandtotal+=$total;
                                   $thisclass='';
                                   if ($plannedworkordercount>$closedworkordercount){
                                     $thisclass='table-danger';
                                   }
                                   
                                          $basilanlar[]=[t($typex->name),number_format($unitprice,2),$closedworkordercount,number_format(($total)*1,2)];
                          ?>
                          
                        <tr class="<?=$thisclass?>"  id="visittype<?=$typex->id;?>">
                          <td > <?=t($typex->name);?></td>
                          <td><?=ucfirst($visitperiod)?> / <?=$visitnumber?> </td>
                          <td> <? if ( $monthssett[$start_datex->format("Y-m")] =='') {echo '0'; }else { echo $monthssett[$start_datex->format("Y-m")]; } ?></td>
                          <td><?=$plannedworkordercount?> Planned</td>
                          <td><?=$closedworkordercount?> Completed</td>
                          <td>£<?=number_format($unitprice,2)?></td>
                          <td>£<?=number_format(($total)*1,2)?></td>
                        </tr>
                     <?php                                   
                                   
                                 }
            ?>
                        <tr>
                           <td>Total</td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td><b>£<?=number_format(($grandtotal)*1,2)?></b></td>
                   
                        </tr>
                      </tbody>
                    </table>
                Contracted Date : <?=$selectedmonth?> - <?=$end_date?>;
                    
                    
                    <!-- buradan başla -->
                    
    </div>
                  
                  
                </div>
              </div>
                   
                    
                    
            
            <?php					}
			//php döngü bit
			?>


        </div>
      </div>
    </div>
    <?php }?>
			<?php
	
Yii::app()->params['scripts'].='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js;';
Yii::app()->params['scripts'].='https://html2canvas.hertzen.com/dist/html2canvas.js;';
	?>

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

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';

?>