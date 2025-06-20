<?php
User::model()->login();

?>

<?php if (Yii::app()->user->checkAccess('client.branch.view')) { ?>
  <?= User::model()->geturl('Client', 'Branch', $_GET['id'], 'client', 0, $ax->branchid); ?>


  <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">

      <div class="card">
        <div class="card-header" style="">
          <ul class="nav nav-tabs">

            <?php if (Yii::app()->user->checkAccess('client.branch.view')) { ?>
              <li class="nav-item">
                <a class="nav-link "
                  href="<?= Yii::app()->baseUrl ?>/client/view?id=<?= $_GET['id']; ?>&firmid=<?= $ax->branchid; ?>"><span
                    class="btn-effect2" style="font-size: 15px;"><?php echo count($client); ?></span><?= t('Branch'); ?></a>
              </li>
            <?php } ?>

            <?php if (Yii::app()->user->checkAccess('client.staff.view') && $transferclient == 0) { ?>
              <li class="nav-item">
                <a class="nav-link"
                  href="<?= Yii::app()->baseUrl ?>/client/staff?id=<?= $_GET['id']; ?>&firmid=<?= $ax->branchid; ?>"><span
                    class="btn-effect2" style="font-size: 15px;"><?php if ((isset($_GET['status']) && $_GET['status'] == 1) || !isset($_GET['status'])) {
                      $userwhere = ' and active=1';
                    } else if (isset($_GET['status']) && $_GET['status'] == 2) {
                      $userwhere = ' and active=0';
                    } else {
                      $userwhere = '';
                    }
                    $say = User::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and (clientbranchid=0 or type in (24,22))' . $userwhere));
                    echo count($say); ?>
                  </span><?= t('Staff'); ?>
                </a>
              </li>

            <?php } ?>
            <?php if ($ax->type == 22 || $ax->type == 17 || $ax->type == 23 || $ax->type == 13 || $ax->type == 13 || $ax->id == 1) { ?>
              <li class="nav-item">
                <a class="nav-link"
                  href="<?= Yii::app()->baseUrl ?>/client/workorderreports?id=<?= $_GET['id']; ?>&firmid=<?= $ax->branchid; ?>"><span
                    class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o"
                      style="font-size: 15px;"></i></span><?= t('Workorder Report'); ?></a>
              </li>
            <?php } ?>

            <?php if ($ax->type == 23 || $ax->type == 13 || $ax->id == 1) { ?>
              <li class="nav-item">
                <a class="nav-link active" href="<?= Yii::app()->baseUrl ?>/client/financials?id=<?= $_GET['id']; ?>"><span
                    class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-text-o"
                      style="font-size: 15px;"></i></span><?= t('Financials'); ?></a>
              </li>

            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <style>
    .alprow {
      min-height: 25px !important;
      width: 70%;
      float: left;
      border: 1px solid #000000;
      font-size: inherit !important;
    }

    .alprow2 {
      min-height: 25px !important;
      width: 50%;
      float: left;
      border: 1px solid #000000;
      padding: 0px;
      text-align: left;
      font-size: inherit !important;
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
      padding: 0px !important;
      font-size: 15px !important;
    }

    .alppad1 {
      padding-right: 15px !important;
      padding-left: 15px !important;
    }

    .alptext {
      line-height: 25px;
      padding-left: 10px !important;
    }

    .alpcoltit {
      line-height: 25px;
      width: 100% !important;
      background: #2196f3;
      color: white;
      font-weight: bold;
      text-align: center;
      border-right: 1px solid #e3ebf3;
      font-size: 15px !important;
    }

    .alpcoltit1 {
      line-height: 25px;
      width: 100% !important;
      background: white; //color:black;
      font-weight: bold;
      text-align: center;
      border-right: 1px solid #e3ebf3;
      font-size: 15px !important;
    }
  </style>

  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12" style=" min-height:250px; background:white; padding:15px;">





        <?php			//php döngü başla
          if ($ax->id == 2504 || $ax->id == 3189 || $ax->id == 3190) {


          } else {
            // $client=[];
            //echo 'Financials Coming Soon... ';
          }



          foreach ($client as $clientrow) {
            $financial = Financialsettings::model()->find(array('condition' => 'clientbranch_id=' . $clientrow->id));

            if ($financial) {

            } else {
              $financial = new Financialsettings;
              $financial->clientbranch_id = $clientrow->id;
              $financial->contract_start_date = '';
              $financial->contract_end_date = '';
              $financial->vat = '';
              $financial->joint_period = '';
              $financial->joint_limit = '';
              $financial->json_data = '';
            }

            ?>
          <form method="POST" action="<?= Yii::app()->baseUrl ?>/client/financials?id=<?= $_GET['id'] ?>&branchid=<?= $financial->clientbranch_id ?>">
            <div class="card">
              <div class="card-header">
                <div class="row" style="border-bottom: 1px solid #e3ebf3;">
                  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                    <h4 class="card-title" style="float:left;">
                      <?= $clientrow->name ?>     <?= t('Financial Settings') ?>
                    </h4>
                    <div style="float:right;">
                      <a class="btn btn-info btn-xs" data-toggle="collapse"
                        data-target="#coll<?= $financial->clientbranch_id ?>"
                        style="color:white;"><?= t('Edit This Branch\'s Financial Settings') ?> <i
                          class="ft-arrow-down"></i></a>
                      <a class="btn btn-primary btn-xs"
                        href="<?= Yii::app()->baseUrl ?>/client/financialsdetail/?id=<?= $_GET['id'] ?>&detail=<?= $financial->clientbranch_id ?>"><?= t('Monthly Control') ?>
                        <i class="ft-calendar"></i></a>
                    </div>

                  </div>


                </div>
              </div>

              <div class="card-content collapse " id="coll<?= $financial->clientbranch_id ?>">
                <div class="card-body card-dashboard">




                  <style>
                    .icedit {
                      width: 100%;
                      max-width: 110px;
                    }
                  </style>
                  <div style="overflow-x:auto;">
                    <table class="table  " style="overflow-x:auto;">
                      <thead>
                        <tr>
                          <th scope="col"
                            style="     vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #2196f3; color:white;">
                            <label for="contratstartdate"><?= t('Contract Start Date') ?></label>
                          </th>
                          <th scope="col"
                            style="     vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #2196f3; color:white;">
                            <label for="contratenddate"><?= t('Contract End Date') ?></label>
                          </th>
                          <th scope="col"
                            style="     vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #2196f3; color:white;">
                            <center><?= t('Vat') ?>:<br></center>
                          </th>
                          <!--  <th scope="col" style="     vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #4CAF50; color:white;">
                              <center><?= t('Free Joint Credit') ?> <br> <?= t('Period') ?> <br></center>
                            </th>
                            <th scope="col" style="     vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #4CAF50; color:white;">
                              <label for="maxtotfree"><?= t('Max Total Free Credit') ?> <?= t('Limit') ?>:<br></label>
                            </th>-->
                          <th scope="col"
                            style="     vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #2196f3; color:white;">
                            <center> </center>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <center><input type="date" id="contratstartdate<?= $financial->clientbranch_id ?>"
                                name="client[<?= $financial->clientbranch_id ?>][contratstartdate]"
                                style="width:100%; max-width:150px;" value="<?= $financial->contract_start_date ?>"></center>
                          </td>
                          <td>
                            <center><input type="date" id="contratenddate<?= $financial->clientbranch_id ?>"
                                name="client[<?= $financial->clientbranch_id ?>][contratenddate]"
                                style="width:100%; max-width:150px;" value="<?= $financial->contract_end_date ?>"></center>
                          </td>
                          <td>
                            <center>
                              <select id="vat<?= $financial->clientbranch_id ?>"
                                name="client[<?= $financial->clientbranch_id ?>][vat]" style="width:100%; max-width:150px;">
                                <option value="exclusive" <?php if ($financial->vat == 'exclusive')
                                  echo 'selected="true"'; ?>><?= t('Exclusive') ?></option>
                                <option value="inclusive" <?php if ($financial->vat == 'inclusive')
                                  echo 'selected="true"'; ?>><?= t('Inclusive') ?></option>
                                <option value="novat" <?php if ($financial->vat == 'novat')
                                  echo 'selected="true"'; ?>>
                                  <?= t('No VAT') ?></option>
                              </select>
                            </center>
                          </td>
                          <!--  <td>
                             <center> <select onchange="freeperiodchange(<?= $financial->clientbranch_id ?>,this)" id="freetype<?= $financial->clientbranch_id ?>" name="client[<?= $financial->clientbranch_id ?>][freetype]" style="width:100%; max-width:150px;">
                              <option value="none" <? if ($financial->joint_period == 'none')
                                echo 'selected="true"'; ?>><?= t('None') ?></option>
                              <option value="monthlyfree" <? if ($financial->joint_period == 'monthlyfree')
                                echo 'selected="true"'; ?>><?= t('Monthly Free') ?></option>
                              <option value="yearlyfree" <? if ($financial->joint_period == 'yearlyfree')
                                echo 'selected="true"'; ?>><?= t('Yearly Free') ?></option>
                            </select>
                              </center>
                            </td>
                            <td>
                              <center><input type="number" id="maxtotfree<?= $financial->clientbranch_id ?>" name="client[<?= $financial->clientbranch_id ?>][maxtotfree]" value="<?= $financial->joint_limit ?>" placeholder="0" style="width:100%; max-width:150px;"></center>
                            </td> -->
                          <td>
                            <center> <button class="btn btn-info btn-xs" style="width:70px;" type="submit"><?= t('Save') ?>
                              </button></center>

                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <table class="table  " style="overflow-x:auto;">
                      <thead>
                        <tr>
                          <th scope="col">
                            <center><?= t('Visit') ?><br> <?= t('Type') ?></center>
                          </th>
                          <th scope="col"
                            style="     vertical-align: middle;border-right: 1px solid black;   border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #2196f3; color:white;">
                            <center><?= t('Visit Period') ?><br></center>
                          </th>
                          <th scope="col"
                            style="    vertical-align: middle;border-right: 1px solid black;   border-top: 1px solid black;border-bottom: 1px solid black;     background: #2196f3;color:white;">
                            <center> <?= t('Number of') ?> <br> <?= t('Visits') ?></center>
                          </th>
                          <th scope="col"
                            style="    vertical-align: middle;  border-right: 1px solid black;   border-top: 1px solid black;  border-bottom: 1px solid black;    background: #2196f3;color:white;">
                            <center><?= t('Unit Price') ?></center>
                          </th>
                          <!--   <th scope="col" style="    vertical-align: middle; border-top: 1px solid black;  border-left: 1px solid black ; border-bottom: 1px solid black;     background: #4CAF50;; color:white;">
                              <center><?= t('Free credit') ?><br> <?= t('Period') ?></center>
                            </th>
                            <th scope="col" style="     vertical-align: middle; border-top: 1px solid black;border-bottom: 1px solid black;     background: #4CAF50;color:white;">
                              <center><?= t('Free credit') ?><br> <?= t('Num.') ?></center>
                            </th>-->

                          <!--  <th scope="col">
                              <center><?= t('Total') ?></center>
                            </th>-->
                        </tr>
                      </thead>
                      <tbody>
                        <? // typelara göre fiyatlar döngüsü başla 
                            $type = Visittype::model()->findall(array('condition' => 'firmid=0 or (firmid=' . $ax->firmid . ' and branchid=' . $clientview->firmid . ')' . ' or ( firmid=' . $ax->firmid . ' and branchid=0 ) order by id = 25 desc, id=75 desc, id=26 desc, id=62 desc, id=31 desc, id=76 desc, id=32 desc, id=41 desc, id=60 desc  '));

                            //$type=Visittype::model()->findall();
                        
                            foreach ($type as $typex) {

                              $visitperiod = '';
                              $visitnumber = '';
                              $unitprice = '';
                              $freecreditperiod = '';
                              $freecreditinayear = '';
                              if ($financial->json_data <> '' && json_decode($financial->json_data)) {
                                $jsondata = json_decode($financial->json_data, true);

                                if (isset($jsondata[$financial->clientbranch_id][$typex->id]['visitperiod'])) {
                                  $visitperiod = $jsondata[$financial->clientbranch_id][$typex->id]['visitperiod'];
                                }
                                if (isset($jsondata[$financial->clientbranch_id][$typex->id]['visitnumber'])) {
                                  $visitnumber = $jsondata[$financial->clientbranch_id][$typex->id]['visitnumber'];
                                }
                                if (isset($jsondata[$financial->clientbranch_id][$typex->id]['unitprice'])) {
                                  $unitprice = $jsondata[$financial->clientbranch_id][$typex->id]['unitprice'];
                                }
                                if (isset($jsondata[$financial->clientbranch_id][$typex->id]['freecreditperiod'])) {
                                  $freecreditperiod = $jsondata[$financial->clientbranch_id][$typex->id]['freecreditperiod'];
                                }
                                if (isset($jsondata[$financial->clientbranch_id][$typex->id]['freecreditinayear'])) {
                                  $freecreditinayear = $jsondata[$financial->clientbranch_id][$typex->id]['freecreditinayear'];
                                }
                                if (isset($jsondata[$financial->clientbranch_id][$typex->id]['month'])) {
                                  $monthssett = $jsondata[$financial->clientbranch_id][$typex->id]['month'];
                                }

                              }

                              ?>
                          <tr id="visittype<?= $typex->id; ?>" style="background:aliceblue !important;">
                            <td>
                              <?= t($typex->name); ?>
                            </td>
                            <td style="  border-left: 1px dotted black; border-bottom: 1px dotted black;">
                              <center>
                                <select id="visitperiod<?= $financial->clientbranch_id ?>"
                                  name="clientsett[<?= $financial->clientbranch_id ?>][<?= $typex->id; ?>][visitperiod]"
                                  class="icedit">
                                  <option value="yearly" <? if ($visitperiod == 'yearly')
                                    echo 'selected="true"'; ?>>
                                    <?= t('Yearly') ?></option>
                                  <option value="monthly" <? if ($visitperiod == 'monthly')
                                    echo 'selected="true"'; ?>>
                                    <?= t('Monthly') ?></option>
                                  <option value="weekly" <? if ($visitperiod == 'weekly')
                                    echo 'selected="true"'; ?>>
                                    <?= t('Weekly') ?></option>
                                </select>
                              </center>
                            </td>
                            <td style="border-bottom: 1px dotted black;">
                              <center><input type="number" class="icedit"
                                  id="visitnumber-<?= $financial->clientbranch_id ?>-<?= $typex->id; ?>"
                                  name="clientsett[<?= $financial->clientbranch_id ?>][<?= $typex->id; ?>][visitnumber]"
                                  value="<?= $visitnumber ?>" placeholder="0"></center>
                            </td>
                            <td style="  border-right: 1px dotted black; border-bottom: 1px dotted black;">
                              <center><input type="number" class="icedit" step="0.01"
                                  id="unitprice-<?= $financial->clientbranch_id ?>-<?= $typex->id; ?>"
                                  name="clientsett[<?= $financial->clientbranch_id ?>][<?= $typex->id; ?>][unitprice]"
                                  value="<?= $unitprice ?>" placeholder="0.00"></center>
                            </td>
                            <!--  <td style="  border-left: 1px dotted  black; border-bottom: 1px dotted black;">
                                <center>
                                  <?php
                                  $freecreditperiodyaz = '';
                                  ?>
                                  <select id="freecreditperiod-<?= $financial->clientbranch_id ?>-<?= $typex->id; ?>" class="freecreditperiod<?= $financial->clientbranch_id ?>" name="clientsett[<?= $financial->clientbranch_id ?>][<?= $typex->id; ?>][freecreditperiod]" data-name="credittype<?= $financial->clientbranch_id ?>" class="icedit" >
                                  <option value="yearly"  <? if ($freecreditperiod == 'yearly') {
                                    echo 'selected="true"';
                                  } ?> ><?= t('Yearly') ?></option>
                                  <option value="monthly" <? if ($freecreditperiod == 'monthly')
                                    echo 'selected="true"'; ?> ><?= t('Monthly') ?></option>
                                  
                                    <?php
                                    if ($financial->joint_period == 'monthlyfree') {
                                      ?>
                                <option value="monthlyjoint" <? if ($freecreditperiod == 'monthlyjoint')
                                  echo 'selected="true"'; ?>><?= t('Monthly Joint') ?></option>
                                    <?php }
                                    ?>  
                                   
                                    <?php
                                    if ($financial->joint_period == 'yearlyfree') {
                                      ?>
                                <option value="yearlyjoint" <? if ($freecreditperiod == 'yearlyjoint')
                                  echo 'selected="true"'; ?>><?= t('Yearly Joint') ?></option>
                                    <?php }
                                    ?>
                            
                                </select>
                                </center>
                              </td>
                              <td style="border-bottom: 1px dotted black;">
                                <center><input type="number" class="icedit" id="freecreditnum-<?= $financial->clientbranch_id ?>-<?= $typex->id; ?>" name="clientsett[<?= $financial->clientbranch_id ?>][<?= $typex->id; ?>][freecreditinayear]" value="<?= $freecreditinayear ?>" placeholder="0"></center>
                              </td> -->

                            <!-- <td>
                                <center> <span class="icedit" id="total<?= $typex->id; ?>" name="total<?= $typex->id; ?>">0</span></center>
                              </td> -->
                          </tr>
                          <tr>

                            <?php $start = new DateTime($financial->contract_start_date);
                            $start->modify('first day of this month');
                            $end = new DateTime($financial->contract_end_date);
                            $end->modify('first day of next month');
                            $interval = DateInterval::createFromDateString('1 month');
                            $period = new DatePeriod($start, $interval, $end);

                            //  print_r($monthssett);exit;
                            $lastyearx = 0;
                            if ($financial->contract_start_date == '') {
                              $period = [];

                            }
                            foreach ($period as $dt) {

                              if ($lastyearx <> $dt->format("Y")) {
                                if ($lastyearx <> 0) {
                                  echo '</td><tr>';
                                }
                                $lastyearx = $dt->format("Y");
                                echo ' <tr> <td colspan="1" style="text-align:right; border-bottom: 1px solid #98A4B8 !important;" >  <b>' . $dt->format("Y") . ' </b> <br> <?=t("Monthly Visit Plan")?></td>';
                                echo ' <td colspan="5" style="border-bottom: 1px solid #98A4B8 !important;"><center>';
                              }
                              ?>
                              <div style="float:left; margin-left:5px;">
                                <?= t($dt->format("F")) ?> <br>
                                <input type="text" id="month-<?= $dt->format("Y-m") ?>"
                                  name="clientsett[<?= $financial->clientbranch_id ?>][<?= $typex->id; ?>][month][<?= $dt->format("Y-m") ?>]"
                                  style=" width:55px;" placeholder="<?= $dt->format("Y-m") ?>" data-date="<?= $dt->format("F") ?>"
                                  value="<?= $monthssett[$dt->format("Y-m")] ?>">
                              </div>
                            <?php
                            }
                            echo '</td></tr>';
                            ?> </center>

                          <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="input-group-append" id="button-addon2"
                    style="float: right; text-align: right;  padding-bottom:20px; width:150px;">
                    <button class="btn btn-info btn-md" style="width:150px;" type="submit"><?= t('Save') ?> </button>
                  </div>
                  <?php


                  ?>
                  <? // typelara göre fiyatlar döngüsü bit ?>
                </div>
              </div>
            </div>
          </form>
        <?php }
          //php döngü bit
          ?>


      </div>
    </div>
  </div>
<?php } ?>



<style>
  .switchery,
  .switch {
    margin-left: auto !important;
    margin-right: auto !important;
  }
</style>
<script>
  $(document).ready(function () {


  });

  function freeperiodchange(id, e) {
    console.log($(e).find(":selected").val());
    $("select[data-name='credittype" + id + "']").find('option').not(':nth-child(1), :nth-child(2)').remove();
    if ($(e).find(":selected").val() === 'monthlyfree') {
      $("select[data-name='credittype" + id + "']").append($('<option>', {
        value: 'monthlyjoint',
        text: '<?= t("Monthly Joint") ?>'
      }));
    }
    if ($(e).find(":selected").val() === 'yearlyfree') {
      $("select[data-name='credittype" + id + "']").append($('<option>', {
        value: 'yearlyjoint',
        text: '<?= t("Yearly Joint") ?>'
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


<?php
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/js/scripts/forms/switch.js;';



Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'] .= Yii::app()->theme->baseUrl . '/assets/css/style.css;';
?>