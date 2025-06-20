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
                <div class="card-header">
                  <div class="row" style="border-bottom: 1px solid #e3ebf3;">
                    <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                      <h4 class="card-title">
                        <?=$clientrow->name?> <?=t('Workorder Plans')?></h4>
                    </div>
                  </div>

                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                    
                  <!--  Start<input type="date" id="contratstartdate3062" name="client[3062][contratstartdate]" style="width:100%; max-width:150px;" value="2024-10-07">
                   End<input type="date" id="contratstartdate3062" name="client[3062][contratstartdate]" style="width:100%; max-width:150px;" value="2024-10-30">-->
                    <form action="?" method="get">

                    <label for="month"><?=t('Choose a month')?>:</label>

<select name="month" id="month">

                
                    
                       <?php   
  $start    = new DateTime($financial->contract_start_date);
      //  $start    =new DateTime('now');
$start->modify('first day of this month');
            $end      = new DateTime($financial->contract_end_date);
//$end      = new DateTime('now');
$end->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start, $interval, $end);
$selectedmonthx=new DateTime('now');
            $selectedmonth=$selectedmonthx->format("Y-m-d");
            if (isset($_GET['month'])){
                  $selectedmonth=$_GET['month'];
            }else{
                          $selectedmonth=$selectedmonthx->format("Y-m");
            }
        $tarihvar=0;
foreach ($period as $dt) {
  if ($selectedmonth==$dt->format("Y-m")){
    $selectedok= 'selected ';
    $tarihvar=1;
  }else{
    $selectedok= '';
  }
  ?>
                      <option value="<?=$dt->format("Y-m")?>" <?=$selectedok?> ><?=$dt->format("Y-m")?> / <?=$dt->format("F")?></option>
         <!--  <input type="text" id="fname" name="fname" style=" width:55px;" placeholder="<?=$dt->format("Y-m")?>" data-date=" <?=$dt->format("F")?>">              -->       
                                <?php   
}
            
            if ($tarihvar==0){
        $type=[];
              ?>
      <option value="" disabled selected><?=t('Please Select a Month')?></option>

  <?php            }
                 ?>  
                    
           </select>
<input type="hidden"  name="id" value="<?=$_GET['id']?>">

<input type="hidden"  name="detail" value="<?=$_GET['detail']?>">

  <input type="submit" value="<?=t('Submit')?>">
</form>
                    
                    <br>
                    <br>
                          <?  if ($tarihvar==0){
       echo t('Please select a month!');
            }
                 ?> 
                    <br>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Visit Type</th>
                          <th><?=t('Contract Period')?></th>
                          <th><?=t('Contracted Visits')?></th>
                          <th><?=t('Planned Visits')?></th>
                          <th><?=t('Completed Visits')?></th>
                          <th><?=t('Unit Price')?></th>
                          <th><?=t('Total')?></th>
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
                                   $start_date=$selectedmonth;
                                   $start_time=strtotime($start_date.' 00:00:00');
                                   
                                   
                                   
                                   $start_datex    = new DateTime($selectedmonth);
                                   $start_datex->modify('last day of this month');
                                   if ($start_datex->format("Y-m-d") > $financial->contract_end_date ){
                                     $end_date=$financial->contract_end_date;
                                   }else{
                                       $end_date=$start_datex->format("Y-m-d");
                                
                                   }
                                   $end_time=strtotime($end_date.' 23:59:59');
                                  
                                   
                                   
                             //   echo 'status>0 and date>="'.$financial->contract_start_date.'"  and date>="'.$start_date.'" and date<="'.$start_datex->format("Y-m-d").'" and date<="'.$financial->contract_end_date.'" and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc ';exit;
                  $plannedworkorder=Workorder::model()->findAll(array('condition'=>'status>=0 and  date>="'.$start_date.'" and date<="'.$end_date.'"  and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc '));
                  $closedworkorder=Workorder::model()->findAll(array('condition'=>'status=3 and realendtime>="'.$start_time.'" and realendtime<="'.$end_time.'" and (clientid='.$financial->clientbranch_id.') and visittypeid='.$typex->id.' ORDER BY date asc '));
                                   $plannedworkordercount=0;
									foreach($plannedworkorder as $workorderp){
                    $plannedworkordercount++;
                  }         
                                   $closedworkordercount=0;
									foreach($closedworkorder as $workorderp){
                    $closedworkordercount++;
                  }
                       
                        if ($plannedworkordercount==0 && $closedworkordercount==0 && ($visitnumber=='' || $visitnumber==0) && $monthssett[$start_datex->format("Y-m")]=='' && $unitprice==''  ) continue; // hiç bir şey yoksa kalabalık etmeden geçiyoruz
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
                          <td><?=$plannedworkordercount?> <?=t('Planned')?></td>
                          <td><?=$closedworkordercount?> <?=t('Completed')?></td>
                          <td>£<?=number_format($unitprice,2)?></td>
                          <td>£<?=number_format(($total)*1,2)?></td>
                        </tr>
                     <?php                                   
                                   
                                 }
            ?>
                        <tr>
                           <td><?=t('Total')?></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td><b>£<?=number_format(($grandtotal)*1,2)?></b></td>
                   
                        </tr>
                      </tbody>
                    </table>
                    <?=$selectedmonth?> - <?=$end_date?>;
                    
                    
                    <!-- buradan başla -->
                    
    </div>
                  
                  
                </div>
              </div>
                   
                    
                    
            
            <?php					}
			//php döngü bit
			?>


        </div>
      </div>
<!--
<button class="btn btn-primary" style="float:right;" onclick="$('#invoice-template').show();" type="submit">+ New Invoice</button>
<button class="btn btn-primary" style="float:right;" type="submit">Payment Received</button>  -->
    </div>
    <?php }?>
<?php
  $billclientbranch = Client::model()->findByPk($_GET['detail']); 
  $billfirmbranchid = Firm::model()->findByPk($billclientbranch->firmid); 
  $billfirm = Firm::model()->findByPk($billfirmbranchid->parentid);   

?>

<div class="content-body">
        <section class="card">
          <div id="invoice-template" class="card-body" style="display:none;"  >
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row" style="padding:50px; ">
              <div class="col-md-6 col-sm-12 text-center text-md-left">
                <div class="media">
                  <img src="https://insectram.io/images/insectram.png" alt="company logo" class="">
                  <div class="media-body">
                    <ul class="ml-2 px-0 list-unstyled">
                      <li class="text-bold-800"><?=$billfirm->name?></li>
                      <li><?=$billfirm->address?></li>
                      <li>United Kingdom</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 text-center text-md-right">
                <h2><?=t('INVOICE')?></h2>
                <p class="pb-3"><input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="#INV-001001" style="width:200px; float:right;"> </p>
                <ul class="px-0 list-unstyled">
                  <li><?=t('Balance Due')?></li>
                  <li class="lead text-bold-800"><input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="£<?=number_format( (($grandtotal)*1.2),2)?>" style="width:120px; float:right;"></li>
                </ul>
              </div>
            </div>
            <!--/ Invoice Company Details -->
            <!-- Invoice Customer Details -->
            <div id="invoice-customer-details" class="row pt-2">
              <div class="col-sm-12 text-center text-md-left">
                <p class="text-muted"><?=t('Bill To')?></p>
              </div>
              <div class="col-md-6 col-sm-12 text-center text-md-left">
                <ul class="px-0 list-unstyled">
                 <li class="text-bold-800"><?=$billclientbranch->name?></li>
                      <li><?=$billclientbranch->address?></li>
                      <li><?=$billclientbranch->town_or_city?> <?=$billclientbranch->postcode?>,</li>
                      <li>United Kingdom</li>
                </ul>
              </div>
              <div class="col-md-6 col-sm-12 text-center text-md-right">
                <p>
                  <span class="text-muted"><?=t('Invoice Date')?> :</span><input type="date" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="<?= date('Y-m-d', time())?>" style="width:150px; float:right;"></p><br>
                <p>
                  <span class="text-muted"><?=t('Terms')?> :</span> <select class="custom-select block" id="customSelect" name="Staffteamlist[gender]" style="width:150px; float:right;">
						  <option value="0"><?=t('Due on Receipt')?></option>
						  <option value="30"><?=t('Net 30')?></option>
						  <option value="60"><?=t('Net 60')?></option>
						  <option value="90"><?=t('Net 90')?></option>

                  </select></p> <br>
                <p>  <span class="text-muted"><?=t('Due Date')?> :</span><input type="date" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="<?= date('Y-m-d', time())?>" style="width:150px; float:right;"></p>
              <br>  <p>  <span class="text-muted"><?=t('Amounts are')?> :</span><select class="custom-select block" id="customSelect" name="Staffteamlist[gender]" style="width:150px; float:right;">
						  <option value="ex"><?=t('Exclusive of TAX')?></option>
						  <option value="inc"><?=t('Inclusive of TAX')?></option>
						  <option value="novat"><?=t('No VAT')?></option>

                  </select></p>
                
              </div>
            </div>
            <!--/ Invoice Customer Details -->
            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
              <div class="row">
                <div class="table-responsive col-sm-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Visit Type</th>
                        <th class="text-right"><?=t('Unit Price')?></th>
                        <th class="text-right"><?=t('Completed Job')?></th>
                        <th class="text-right"><?=t('Amount')?></th>
                        <th class="text-right"><?=t('Delete')?></th>
                      </tr>
                    </thead>
                    <tbody>
                   
                        <?php  $sira=0;
if (is_array($basilanlar) && count($basilanlar)>0)     {     
  foreach($basilanlar as $item){
   if ($item[2]=='0') continue;
    $sira++;
  
  
  ?>                  <tr class="tabloitem">
                        <th scope="row"><?=$sira?></th>
                        <td>
                          <p> <input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="<?=$item[0]?>" style="width:100%; float:right;"> </p>
                        </td>
                        <td class="text-right"> <input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="£<?=$item[1]?>" style="width:120px; float:right;"> </td>
                        <td id="itemid<?=$sira?>" onclsick="loadDATAtoCHANGE('itemid<?=$sira?>')" class="text-right"><input type="number" min="1" class="form-control" id="invoiceid" onkeyup=""  name="invoiceid" required="" value="<?=$item[2]?>" style="width:75px; float:right;">  </td>
                        <td class="text-right">£<?=$item[3]?></td>
                        <td class="text-right"><a style="color:red";><b><?=t('Delete')?></b></a></td>
                      </tr>
                  <?php    
}
              }              ?>
                      <tr class="donot">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>   <button type="button" class="btn btn-primary btn-x my-1"  onclick="addnewcolumn()"><i class="fa fa-plus"></i> </button></td>
                      </tr>
                     <!-- <div id="hot"></div> -->
                    </tbody>
                  </table>
                </div>
              </div>
              <script>
              function addnewcolumn()
                {
            
                  $('.donot').before('<tr><td></td><td></td><td></td><td></td><td></td><td>delete</td></tr>');
   

                }
              </script>
              <div class="row">
                <div class="col-md-7 col-sm-12 text-center text-md-left">
                  <p class="lead"><?=t('Payment Methods')?>:</p>
                  <div class="row">
                    <div class="col-md-8">
                      <table class="table table-borderless table-sm">
                        <tbody>
                          <tr>
                            <td><?=t('Bank name')?>:</td>
                            <td class="text-right"><input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="" style="width:200px;"></td>
                          </tr>
                          <tr>
                            <td><?=t('Acc name')?>:</td>
                            <td class="text-right"><input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="" style="width:200px;"></td>
                          </tr>
                          <tr>
                            <td><?=t('IBAN')?>:</td>
                            <td class="text-right"><input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="" style="width:200px;"></td>
                          </tr>
                          <tr>
                            <td><?=t('SWIFT code')?>:</td>
                            <td class="text-right"><input type="text" class="form-control" id="invoiceid" onkeyup="javascript:kontrol()"  name="invoiceid" required="" value="" style="width:200px;"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-5 col-sm-12">
                  <p class="lead"><?=t('Total due')?></p>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td><?=t('Sub Total')?></td>
                          <td class="text-right">£<?=number_format( (($grandtotal)*1),2)?></td>
                        </tr>
                        <tr>
                          <td><select class="custom-select block" id="customSelect" name="Staffteamlist[gender]" style="width:150px; ">
						  <option value="20"><?=t('TAX (20%)')?></option>
						  <option value="10"><?=t('TAX (10%)')?></option>
						  <option value="0"><?=t('No TAX')?></option>

                  </select></td>
                          <td class="text-right">£<?=number_format( (($grandtotal)*0.2),2)?></td>
                        </tr>
                        <tr>
                          <td class="text-bold-800"><?=t('Total')?></td>
                          <td class="text-bold-800 text-right">£<?=number_format( (($grandtotal)*1.2),2)?></td>
                        </tr>
                    
                      </tbody>
                    </table>
                  </div>
                  <? 
                  /*
                  <div class="text-center">
                    <p>Authorized person</p>
                    <img src="../../../app-assets/images/pages/signature-scan.png" alt="signature" class="height-100">
                    <h6>Amanda Orton</h6>
                    <p class="text-muted">Managing Director</p>
                  </div>
                  */ 
                  ?>
                </div>
              </div>
            </div>
            <!-- Invoice Footer -->
            <div id="invoice-footer">
              <div class="row">
                <div class="col-md-7 col-sm-12">
                  <!--<h6>Terms &amp; Condition</h6>-->
                  <p></p>
                </div>
                <div class="col-md-5 col-sm-12 text-center">
                <!--  <button type="button" class="btn btn-primary btn-lg my-1"  onclick="CreatePDFfromHTML2()"><i class="fa fa-download"></i> Download</button> -->
                  
                  <button type="button" class="btn btn-primary btn-lg my-1"  onclick="dsgdCreatePDFfromHTML2()"><i class="fa fa-save"></i> Save</button>
                </div>
                
              </div>
            </div>
            <!--/ Invoice Footer -->
          </div>
        </section>
      </div>




    <style>
      .switchery,
      .switch {
        margin-left: auto !important;
        margin-right: auto !important;
      }
    </style>
    <script>
      function loadDATAtoCHANGE(id) {
    let dataToChange = id;
    document.getElementById(dataToChange).innerHTML = 
    "<div class='tooltipLEFT'>&#x1F6C8;<span class='tooltiptext'>nome</span></div><input type='text' name='save1' id='enteringCONTACTname' placeholder='name' onkeyup='updateCONTACTname(id)' value='"+document.getElementById(dataToChange).innerHTML+"' /></br>";
}
 
      
      function freeperiodchange(id,e){
         console.log($(e).find(":selected").val());
             $("select[data-name='credittype"+id+"']").find('option').not(':nth-child(1), :nth-child(2)').remove();
        if ($(e).find(":selected").val() === 'monthlyfree'){
             $("select[data-name='credittype"+id+"']").append($('<option>', {
            value: 'monthlyjoint',
            text: 'Monthly Joint'
        }));
        }
            if ($(e).find(":selected").val() === 'yearlyfree'){
             $("select[data-name='credittype"+id+"']").append($('<option>', {
            value: 'yearlyjoint',
            text: 'Yearly Joint'
        }));
        }
 
    
        
      }
    </script>


    <style>
      @media (max-width: 991.98px) {
        .hidden-xs,
        .buttons-collection {
          display: none;
        }
        div.dataTables_wrapper div.dataTables_filter label {
          white-space: normal !important;
        }
        div.dataTables_wrapper div.dataTables_filter input {
          margin-left: 0px !important;
        }
      }

      .isActive {
        box-shadow: 0px 0px 4px 0px #000;
      }
    </style>

<script>
 function CreatePDFfromHTML2() {
						
										 
										 							 $("#invoice-footer").hide();
										 $("#invoice-template").attr('style', 'width:28cm !important');

										
    var HTML_Width = $("#invoice-template").width();
    var HTML_Height = $("#invoice-template").height();
										 
										  $("textarea").each(function(){
												 $( this ).replaceWith( "<div>" + this.value + "</div>" );
       // this.value = this.value.replace("AFFURL",producturl);
    });
										 
    var top_left_margin = 25;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("#invoice-template")[0], {
    scale: 2,
}).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save("invoice_<?=$billclientbranch->name?>.pdf");
											 $("#invoice-template").attr('style', 'width:100%;');
			  setInterval(function() {
  window.location.reload(true);
  }, 4000);
        //$("#content").hide();
    });
}
  



  
</script>
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