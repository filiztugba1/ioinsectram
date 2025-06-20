<?php
$ax= User::model()->userobjecty('');
if(isset($_GET["id"]))
{
    $model=Servicereport::model()->findByPk($_GET["id"]);
    $workorder=Workorder::model()->findByPk($model->reportno);
	 $cb=Client::model()->findByPk($workorder->clientid);
	
	 $permission=User::model()->userpagepermission($workorder->firmid,$workorder->branchid,$cb->parentid,$workorder->clientid);
		 if($permission==0)
		 {
			 header('Location: /site/notpages');
			 exit;
		 }
}
?>
<script>
    $(document).ready(function () {

        $("#customSelect7").append("<option> <?=t($model->active_ingredient);?></option>");
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
                                              $stokKimyasalmodelx = Yii::app()->db->createCommand()
  ->select('*')
		->from('activeingredients')
		->where('workorderid='.$model->reportno)
		->queryall();

                                 foreach($stokKimyasalmodelx as $stokKimyasalmodelt)
{
																	 $eskitip=0;
                                          $stokKimyasalmodel=Stokkimyasalkullanim::model()->findbypk($stokKimyasalmodelt['tradeId']);
																					if ($stokKimyasalmodel){
																						
																					}else{
																						$stokKimyasalmodel=(object)'';
																						$stokKimyasalmodel->kimyasaladi=$stokKimyasalmodelt['trade_name'];
																						$stokKimyasalmodel->aktifmaddetanimi=$stokKimyasalmodelt['active_ingredient'];
																								 $eskitip=1;
																					}
                                          ?>
                                                <div class="col-xl-4 col-lg-4 col-md-4 mb-2">
                                                    <label for="basicSelect"> <?=t('Trade Name')?></label>
                                                    <fieldset class="form-group">
                                                        <input value="<?=$stokKimyasalmodel->kimyasaladi?>" disabled class="form-control">
                                                    </fieldset>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 mb-2">
                                                    <label for="basicSelect"> <?=t('Active Ingredient')?></label>
                                                    <fieldset class="form-group">
                                                        <input selected  class="form-control"  disabled value="<?=$stokKimyasalmodel->aktifmaddetanimi?>">
                                                    </fieldset>
                                                </div>


                                                <div class="col-xl-4 col-lg-4 col-md-4 mb-2">
                                                    <label for="basicSelect"> <?=t('Amount Applied')?></label>
                                                    <fieldset class="form-group">
                                                        <?php $meds=Meds::model()->find(array('condition'=>'name="'.$trade->active_ingredient.'"'));
																	 if ($eskitip==1){
															
																		 $meds=Stokkimyasalkullanim::model()->find(array('condition'=>'kimyasaladi="'.$stokKimyasalmodel->kimyasaladi.'"'));
																		 		
																				//	$unittype=Units::model()->findByPk($meds->urunAmbajBirimi);	 
																		 $stokKimyasalmodel->urunAmbajBirimi=$meds->urunAmbajBirimi;
																		 $stokKimyasalmodel->urunAmbajMiktari=$meds->urunAmbajMiktari;
																	 }else{
																		 						$unittype=Units::model()->findByPk($meds->unit);
																	 }
										
														
														?>
                                                        <input type="text" class="form-control" name="amount_applied" placeholder="Amount Applied" value="<?=$stokKimyasalmodel->urunAmbajMiktari.' '.($stokKimyasalmodel->urunAmbajBirimi==0?'Adet':
	($stokKimyasalmodel->urunAmbajBirimi==1?'kg':
	($stokKimyasalmodel->urunAmbajBirimi==2?'lt':
	($stokKimyasalmodel->urunAmbajBirimi==3?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==4?'ml':'')
	)
	)
	)).'/'.$stokKimyasalmodelt['amount_applied'].' '.($stokKimyasalmodel->urunAmbajBirimi==0?'Adet':
	($stokKimyasalmodel->urunAmbajBirimi==1?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==2?'ml':
	($stokKimyasalmodel->urunAmbajBirimi==3?'gr':
	($stokKimyasalmodel->urunAmbajBirimi==4?'ml':'')
	)
	)
	))?>" readonly>
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
													<?php if($workorder->firmid==538)
													{?>
												<img src="<?=Yii::app()->baseUrl.'/uploads/Tepetesisyonetimi1/tepe_imza.jpg'?>" width="300px" height="200px">
												<?php }else{?>
												<img src="<?=Yii::app()->baseUrl.''.$model->technician_sign?>" width="300px" height="200px">
												<?php }?>
                                                    
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                                                <fieldset>
													<input class="form-control" type="text" value="<?=$model->trade_name?>" id="inlineCheckbox2"  disabled>
                                                    <label> <?=t('Client Sign')?> : </label>
                                                   <img src="<?=Yii::app()->baseUrl.''.$model->client_sign?>" width="300px" height="200px">
                                                </fieldset>
                                            </div>
                                          <?php
                                          if(strlen($model->picture)>2){
                                            
  
                                          ?>
                                          <div class="col-xl-12 col-lg-12 col-md-12">
                                                <fieldset>
                                                    <label> <?=t('Service Form')?> : </label>
                                                    <img src="<?=Yii::app()->baseUrl.''.$model->picture?>" width="300px" height="200px">
                                                </fieldset>
                                            </div>
                                          <?php
                                            
                                          }
                                            
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div><!-- form -->
                </div>
<?php
              
              $ax= User::model()->userobjecty('');
              if ($ax->id==9991732 ){
                
                ?>
              <div class="input-group-append" id="button-addon2" style="float: left; text-align: right;">
									<a class="btn btn-info" id="createbutton" type="submit" target="_Blank" href="/site/Servicereport?id=<?=$_GET['id']?>">Servis Formunu Mail Olarak Gönder <i class="fa fa-send"></i></a>
								</div>
              
                  <div class="input-group-append" id="button-addon2" style="float: left; text-align: right;">
									<a class="btn btn-info" id="createbutton" type="submit" target="_Blank" href="/site/Servicereport?id=<?=$_GET['id']?>&pdf">Servis Formunu Pdf Olarak Göster <i class="fa fa-download"></i></a>
								</div>
              <?php
              }
              ?>

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

	<style>
	.bosluk{
		    padding-bottom: 0px;
    margin-bottom: 0px !important;
	}
	.form-control {
    display: block;
    width: 100%;
    padding: 0.30rem 0.50rem;
    font-size: 1rem;
    line-height: 2.25;
    color: #4E5154;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #BABFC7;
    border-radius: 0.25rem;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}</style>
