<?php
if(isset($_GET["id"]))
{
    $model=Servicereport::model()->findByPk($_GET["id"]);

}
?>
<script>
    $(document).ready(function () {

        $("#customSelect7").append("<option> <?=$model->active_ingredient;?></option>");
        $(".inlineCheckbox2").attr('checked', true);
    });
</script>
<div class="content-body">

    <div class="row col-md-12" style="padding-top: 15px">
        <div class="col-md-12">
            <div id="sidebar">
            </div><!-- sidebar -->
        </div>
        <div class="col-md-12">
            <div id="content">
                <div class="row" id="createpage" style="">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
                                    <div class="col-md-6">
                                        <img src="https://insectram.io/images/insectram.png">
                                        <img src="https://insectram.io/images/insectram_.png">
                                    </div>
                                    <div class="col-md-6" style="float: right;">
                                        <h4 class="card-title"><?=t('CUSTOMER SERVICE REPORT')?></h4>
                                    </div>
                                </div>
                            </div>

                            <form id="user-form1" action="/site/servicereport" method="post">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                                <label for="basicSelect"><?=t('Client Name')?></label>
                                                <fieldset class="form-group">
                                                    <input type="text" name="client_name" class="form-control" placeholder="Client Name" value="<?=$model->client_name;?>" readonly>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                                                <label for="basicSelect"><?=t('Date')?></label>
                                                <fieldset class="form-group">
                                                    <input type="text" class="form-control" id="basicInput1" placeholder="dd/mm/YYYY" name="date" value="<?php echo date("d/m/Y H:i",$model->date); ?>" readonly>
                                                </fieldset>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                                                <label for="basicSelect"><?=t('Service Report No')?></label>
                                                <fieldset class="form-group">
                                                    <input type="text" class="form-control" id="basicInput2" placeholder="Report Number" name="reportno" value="<?=$model->reportno;?>" readonly>
                                                </fieldset>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1 white" style="background-color:#00a651; text-align: center; font-size: 20px;">
                                                <?=t('VISIT TYPE')?>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 mb-2">

                                            </div>

                                            <div class="col-xl-2 col-lg-2 col-md-2 mb-2">

                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 mb-2">
                                                <fieldset class="form-group">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="visittype[]" value="option3" checked disabled>
                                                    <label class="form-check-label" for="inlineCheckbox2"><?=t($model->visittype);?></label>
                                                </fieldset>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1 white" style="background-color:#00a651; text-align: center; font-size: 20px;">
                                                <?=t('DETAILS OF SERVICE')?>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">

                                                <fieldset class="form-group">
                                                    <textarea class="form-control" name="servicedetails" rows="3" readonly><?=$model->servicedetails;?></textarea>
                                                </fieldset>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1 white" style="background-color:#00a651; text-align: center; font-size: 20px;">
                                                 <?=t('RODENTICIDE / INSECTICIDE  APPLIED')?>
                                            </div>
                                            <?php
                                            $trades=Activeingredients::model()->findAll(array('condition'=>'workorderid='.$model->reportno));
                                            foreach ($trades as $trade){ ?>
                                                <div class="col-xl-4 col-lg-4 col-md-4 mb-2">
                                                    <label for="basicSelect"> <?=t('Trade Name')?></label>
                                                    <fieldset class="form-group">
                                                        <input value="<?=$trade->trade_name?>" disabled class="form-control">
                                                    </fieldset>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 mb-2">
                                                    <label for="basicSelect"> <?=t('Active Ingredient')?></label>
                                                    <fieldset class="form-group">
                                                        <input selected  class="form-control"  disabled value="<?=$trade->active_ingredient?>">
                                                    </fieldset>
                                                </div>


                                                <div class="col-xl-4 col-lg-4 col-md-4 mb-2">
                                                    <label for="basicSelect"> <?=t('Amount Applied')?></label>
                                                    <fieldset class="form-group">
                                                        <?php $meds=Meds::model()->find(array('condition'=>'name="'.$trade->active_ingredient.'"'));
														$unittype=Units::model()->findByPk($meds->unit);
														
														?>
                                                        <input type="text" class="form-control" name="amount_applied" placeholder="Amount Applied" value="<?=$trade->amount_applied." ".$unittype->name;?>" readonly>
                                                    </fieldset>
                                                </div>
                                            <?php } ?>

                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1 white" style="background-color:#00a651; text-align: center; font-size: 20px;">
                                                 <?=t('RECOMMENDATIONS AND HAZARD / RISK REVIEW')?>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                                                <fieldset class="form-group">
                                                    <textarea class="form-control" name="riskreview" rows="3" readonly><?=$model->riskreview;?></textarea>
                                                </fieldset>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                                                <fieldset>
                                                    <label> <?=t('Techinician Sign')?> : </label>
                                                    <img src="<?=Yii::app()->baseUrl.''.$model->technician_sign?>" width="300px" height="200px">
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                                                <fieldset>
													<input class="form-control" type="text" value="<?=$model->trade_name?>" id="inlineCheckbox2"  disabled>
                                                    <label> <?=t('Client Sign')?> : </label>
                                                    <img src="<?=Yii::app()->baseUrl.''.$model->client_sign?>" width="300px" height="200px">
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div><!-- form -->
                </div>


                <style>
                    .switchery,.switch{
                        margin-left:auto !important;
                        margin-right:auto !important;
                    }
                </style>

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

            </div><!-- content -->
        </div>
    </div>
</div>