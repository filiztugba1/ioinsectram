<?php
User::model()->login();
$ax= User::model()->userobjecty('');

	if($ax->firmid>0)
	{
		if($ax->branchid>0)
		{
			if($ax->clientid>0)
			{
				//buraya ekleme yapamıcak client ve clientbranch
			}
			else
			{
				$where="firmid=0 or (firmid=".$ax->firmid." and branchid=0) or branchid=".$ax->branchid;
			}
		}
		else
		{
			$where="firmid=0 or firmid=".$ax->firmid;
		}
	}
	else
	{
		$where="";
	}



$stokkimyasalkullanims=Stokkimyasalkullanim::model()->findAll(array('order'=>'kimyasaladi ASC','condition'=>$where));
//$visittypes=Visittype::model()->findAll(array('order'=>'name ASC'));?>


<?php if (Yii::app()->user->checkAccess('medfirms.view')){ ?>
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl(t('Biyosidal Ürünler'),'',0,'stokkimyasalkullanim/index2');?>
<?php if (Yii::app()->user->checkAccess('medfirms.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Biyosidal Ürün Ekleme');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="visittype-form" action="/stokkimyasalkullanim/create" method="post">
				<div class="card-content">
					<div class="card-body">

					<div class="row">
						<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Stokkimyasalkullanim[firmid]" onchange="myfirm()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?
									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Stokkimyasalkullanim[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Stokkimyasalkullanim[branchid]" disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?
									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Stokkimyasalkullanim[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>

				  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					    <label for="basicSelect"><?=t('Kimyasal Adı');?></label>
              <fieldset class="form-group">
                <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Kimyasal Adı');?>" name="Stokkimyasalkullanim[kimyasaladi]" requred>
              </fieldset>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Aktif madde tanımı');?></label>
              <fieldset class="form-group">
                  <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Aktif madde tanımı');?>" name="Stokkimyasalkullanim[aktifmaddetanimi]" >
              </fieldset>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Yöntem');?></label>
              <fieldset class="form-group">
                  <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Yöntem');?>" name="Stokkimyasalkullanim[yontem]" >
              </fieldset>
          </div>
		  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect"><?=t("Ruhsat Revizyonu")?></label>
												<fieldset class="form-group">
													<input type="text" class="form-control" id="ruhsat_tarih_basligi" placeholder="<?=t("Ruhsat Revizyonu")?>" name="Stokkimyasalkullanim[ruhsattarihbaslik]" required>
												</fieldset>
										</div>
          <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Ruhsat Tarihi');?></label>
              <fieldset class="form-group">
                  <input type="date" class="form-control" id="basicInput" placeholder="<?=t('Ruhsat Tarihi');?>" name="Stokkimyasalkullanim[ruhsattarih]" >
              </fieldset>
          </div>

	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect"><?=t("Ruhsat Geçerlilik Tarihi")?></label>
												<fieldset class="form-group">
													<input type="date" class="form-control" id="ruhsat_gecerlilik" placeholder="Ruhsat Geçerlilik Tarihi" name="Stokkimyasalkullanim[ruhsatgecerliliktarihi]" required>
												</fieldset>
										</div>
          <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Ruhsat No');?></label>
              <fieldset class="form-group">
                  <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Ruhsat No');?>" name="Stokkimyasalkullanim[ruhsatno]" >
              </fieldset>
          </div>
		  
		  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Ürünün Ambalaj Miktarı');?></label>
              <fieldset class="form-group">
                  <input type="number" step="0.01" min="0" class="form-control" id="basicInput" placeholder="<?=t('Ürünün Ambalaj Miktarı');?>" name="Stokkimyasalkullanim[urunAmbajMiktari]" required>
              </fieldset>
          </div>
		  
		  <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Ürünün Ambalaj Miktarının Birimi');?></label>
              <fieldset class="form-group">
                   <select class="select2" style="width:100%"  name="Stokkimyasalkullanim[urunAmbajBirimi]" required>
                    <option value="0"><?=t('Adet');?></option>
					<option value="1"><?=t('Kilogram');?></option>
					<option value="2"><?=t('Litre');?></option>
					<option value="3"><?=t('Gram');?></option>
					<option value="4"><?=t('Mililitre');?></option>
                  </select>
				  </fieldset>
          </div>
		  
		    <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
              <label for="basicSelect"><?=t('Ürün Antidotu');?></label>
              <fieldset class="form-group">
                  <input type="text" max="500" class="form-control" id="basicInput" placeholder="<?=t('Ürün Antidotu');?>" name="Stokkimyasalkullanim[urunAntidotu]" required>
              </fieldset>
          </div>
		  
          <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect" class="hidden-xs hidden-sm" style="margin:11px"></label>
            <fieldset class="form-group">
                  <div class="input-group-append" id="button-addon2">
									     <button class="btn btn-primary" type="submit"><?=t('Create');?></button>
						      </div>
            </fieldset>
          </div>
			</div>
    </div>
	</div>
</form>
</div>

	</div><!-- form -->
	</div>
<?php }?>


	<!-- HTML5 export buttons table -->
<section id="html5">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						         <h4 class="card-title"><?=t('Biyosidal Ürünler');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('medfirms.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Biyosidal Ürün Ekle');?> <i class="fa fa-plus"></i></button>
								</div>
						</div>
						<?php }?>
					</div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body card-dashboard  ">
              <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                <thead>
                    <tr>
                      <th><?=t('Kimyasal Adı');?></th>
							        <?php if($ax->firmid==0){?><th><?=t('FIRM');?></th><?php }?>
                      <?php if($ax->branchid==0){?><th><?=t('Branch');?></th><?php }?>
							        <th><?=t('Aktif madde tanımı');?></th>
                      <th><?=t('Yöntem');?></th>
                      <th><?=t('Ruhsat Tarihi');?></th>
                      <th><?=t('Ruhsat No');?></th>
                      <th><?=t('Aktif-Pasif');?></th>
                      <th><?=t('PROCESS');?></th>
                    </tr>
                  </thead>
                <tbody>
             		<?php foreach($stokkimyasalkullanims as $stokkimyasalkullanim):?>
                <tr>
                  <td><a href="<?=Yii::app()->baseUrl;?>/stokkimyasalkullanim/view/<?=$stokkimyasalkullanim->id;?>"><?=$stokkimyasalkullanim->kimyasaladi;?></a></td>

								<?php if($ax->firmid==0){?>
								<td><?=$stokkimyasalkullanim->firmid==0?t('All'):Firm::model()->find(array('condition'=>'id='.$stokkimyasalkullanim->firmid))->name;?></td>
								<?php }?>

								<?php if($ax->branchid==0){?>
								<td><?=$stokkimyasalkullanim->branchid==0?t('All'):Firm::model()->find(array('condition'=>'id='.$stokkimyasalkullanim->branchid))->name;?></td>
								<?php }?>
                <td><?=$stokkimyasalkullanim->aktifmaddetanimi;?></td>
                <td><?=$stokkimyasalkullanim->yontem;?></td>
                <td><?=Date('Y-m-d',$stokkimyasalkullanim->ruhsattarih);?></td>
                <td><?=$stokkimyasalkullanim->ruhsatno;?></td>

								<td>
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$stokkimyasalkullanim->id;?>"  <?php if($stokkimyasalkullanim->isactive==1){echo "checked";}?>  <?php if (Yii::app()->user->checkAccess('medfirms.update')==0){?>disabled<?php }?> />
									</div>
								</td>
                <td>
									<?php if (Yii::app()->user->checkAccess('medfirms.update')){ ?>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
                    data-id="<?=$stokkimyasalkullanim->id;?>"
                    data-kimyasaladi="<?=$stokkimyasalkullanim->kimyasaladi;?>"
                    data-firmid="<?=$stokkimyasalkullanim->firmid;?>"
                    data-branchid="<?=$stokkimyasalkullanim->branchid;?>"
                    data-aktifmaddetanimi="<?=$stokkimyasalkullanim->aktifmaddetanimi;?>"
                    data-yontem="<?=$stokkimyasalkullanim->yontem;?>"
                    data-ruhsattarih="<?=Date('Y-m-d',$stokkimyasalkullanim->ruhsattarih);?>"
                    data-ruhsatno="<?=$stokkimyasalkullanim->ruhsatno;?>"
                    data-active="<?=$stokkimyasalkullanim->isactive;?>"
					data-ruhsattarihbaslik="<?=$stokkimyasalkullanim->ruhsattarihbaslik;?>"
					data-ruhsatgecerliliktarihi="<?=$stokkimyasalkullanim->ruhsatgecerliliktarihi;?>"
					data-urunambajmiktari="<?=$stokkimyasalkullanim->urunAmbajMiktari;?>"
					data-urunambajbirimi="<?=$stokkimyasalkullanim->urunAmbajBirimi;?>"
					data-urunantidotu="<?=$stokkimyasalkullanim->urunAntidotu;?>"
                    data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('medfirms.delete')){ ?>

									<?php if($ax->firmid==0 || ($stokkimyasalkullanim->firmid==$ax->firmid)|| (($stokkimyasalkullanim->firmid==$ax->firmid) && ($stokkimyasalkullanim->branchid==$ax->branchid))){?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$stokkimyasalkullanim->id;?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"><i style="color:#fff;" class="fa fa-trash"></i></a>

									<?php }}?>
								</td>
              </tr>
            <?php endforeach;?>
          </tbody>
        <tfoot>
          <tr>
            <th><?=t('Kimyasal Adı');?></th>
            <?php if($ax->firmid==0){?><th><?=t('FIRM');?></th><?php }?>
            <?php if($ax->branchid==0){?><th><?=t('Branch');?></th><?php }?>
            <th><?=t('Aktif madde tanımı');?></th>
            <th><?=t('Yöntem');?></th>
            <th><?=t('Ruhsat Tarihi');?></th>
            <th><?=t('Ruhsat No');?></th>
            <th><?=t('Aktif-Pasif');?></th>
            <th><?=t('PROCESS');?></th>
          </tr>
        </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</section>

<?php if (Yii::app()->user->checkAccess('medfirms.update')){ ?>
<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="guncellemeModal"><?=t('Biyosidal Ürün Güncelle');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
          <form id="visittype-form" action="/stokkimyasalkullanim/update" method="post">
          <div class="card-content">
            <div class="card-body">
              <input type="hidden" class="form-control" id="modalstokid" name="Stokkimyasalkullanim[id]" value="" requred>
            <div class="row">
              <?php if($ax->firmid==0){?>
            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                <label for="basicSelect"><?=t('Firm');?></label>
                <fieldset class="form-group">
                  <select class="select2" style="width:100%" id="modalfirmid" name="Stokkimyasalkullanim[firmid]" onchange="myfirm()" requred>
                    <option value=""><?=t('All');?></option>
                    <?
                    $firm=Firm::model()->findall(array('condition'=>'parentid=0'));
                     foreach($firm as $firmx){?>
                    <option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
                     <?php }?>
                  </select>
                </fieldset>
              </div>
              <?php }else{?>
                <input type="hidden" class="form-control" id="modalfirmid" name="Stokkimyasalkullanim[firmid]" value="<?=$ax->firmid;?>" requred>
              <?php }?>

              <?php if($ax->branchid==0){?>
              <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <label for="basicSelect"><?=t('Branch');?></label>
                <fieldset class="form-group">
                  <select class="select2" style="width:100%" id="modalbranchid" name="Stokkimyasalkullanim[branchid]" disabled requred>
                    <option value=""><?=t('All');?></option>

                    <?
                    if($workorder->firmid!=0){
                    $branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
                     foreach($branch as $branchx){?>
                    <option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
                    <?php }}?>
                  </select>
                </fieldset>
              </div>
              <?php }else{?>
                <input type="hidden" class="form-control" id="modalbranchid" name="Stokkimyasalkullanim[branchid]" value="<?=$ax->branchid;?>" requred>
              <?php }?>

            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                <label for="basicSelect"><?=t('Kimyasal Adı');?></label>
                <fieldset class="form-group">
                  <input type="text" class="form-control" id="modalkimyasaladi" placeholder="<?=t('Kimyasal Adı');?>" name="Stokkimyasalkullanim[kimyasaladi]" requred>
                </fieldset>
            </div>
          <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                <label for="basicSelect"><?=t('Aktif madde tanımı');?></label>
                <fieldset class="form-group">
                    <input type="text" class="form-control" id="modaltaktifmaddetanimi" placeholder="<?=t('Aktif madde tanımı');?>" name="Stokkimyasalkullanim[aktifmaddetanimi]" >
                </fieldset>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                <label for="basicSelect"><?=t('Yöntem');?></label>
                <fieldset class="form-group">
                    <input type="text" class="form-control" id="modalyontem" placeholder="<?=t('Yöntem');?>" name="Stokkimyasalkullanim[yontem]" >
                </fieldset>
            </div>
				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
											<label for="basicSelect"><?=t("Ruhsat Revizyonu")?></label>
												<fieldset class="form-group">
													<input type="text" class="form-control" id="modalruhsatbasligi" placeholder="<?=t("Ruhsat Revizyonu")?>" name="Stokkimyasalkullanim[ruhsattarihbaslik]" required>
												</fieldset>
										</div>
          <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                <label for="basicSelect"><?=t('Ruhsat Tarihi');?></label>
                <fieldset class="form-group">
                    <input type="date" class="form-control" id="modalruhsattarih" placeholder="<?=t('Ruhsat Tarihi');?>" name="Stokkimyasalkullanim[ruhsattarih]" >
                </fieldset>
            </div>
			
				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
											<label for="basicSelect"><?=t("Ruhsat Geçerlilik Tarihi")?></label>
												<fieldset class="form-group">
													<input type="date" class="form-control" id="modalruhsatgecerliliktarihi" placeholder="<?=t("Ruhsat Geçerlilik Tarihi")?>" name="Stokkimyasalkullanim[ruhsatgecerliliktarihi]" required>
												</fieldset>
										</div>

          <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                <label for="basicSelect"><?=t('Ruhsat No');?></label>
                <fieldset class="form-group">
                    <input type="text" class="form-control" id="modalruhsatno" placeholder="<?=t('Ruhsat No');?>" name="Stokkimyasalkullanim[ruhsatno]" >
                </fieldset>
            </div>
			
			
			  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <label for="basicSelect"><?=t('Ürünün Ambalaj Miktarı');?></label>
              <fieldset class="form-group">
                  <input type="number" min="0" step="0.01" class="form-control" id="modalurunAmbajMiktari" placeholder="<?=t('Ürünün Ambalaj Miktarı');?>" name="Stokkimyasalkullanim[urunAmbajMiktari]" required>
              </fieldset>
          </div>
		  
		  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <label for="basicSelect"><?=t('Ürünün Ambalaj Miktarının Birimi');?></label>
              <fieldset class="form-group">
                   <select class="select2" style="width:100%" id="modalurunambajbirimi" name="Stokkimyasalkullanim[urunAmbajBirimi]" required>
                    <option value="0"><?=t('Adet');?></option>
					<option value="1"><?=t('Kilogram');?></option>
					<option value="2"><?=t('Litre');?></option>
					<option value="3"><?=t('Gram');?></option>
					<option value="4"><?=t('Mililitre');?></option>
                  </select>
				  </fieldset>
          </div>
		  
		    <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <label for="basicSelect"><?=t('Ürün Antidotu');?></label>
              <fieldset class="form-group">
                  <input type="text" max="500" class="form-control" id="modalurunAntidotu" placeholder="<?=t('Ürün Antidotu');?>" name="Stokkimyasalkullanim[urunAntidotu]" required >
              </fieldset>
          </div>
		  
		  
		  
			
			   <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <label for="basicSelect"><?=t('Is Active');?></label>
                <fieldset class="form-group">
                  <select class="select2" style="width:100%" id="modalisactive" name="Stokkimyasalkullanim[isactive]">
                    <option value="1"><?=t('Aktif');?></option>
					<option value="0"><?=t('Pasif');?></option>
                  </select>
                </fieldset>
              </div>
			  
			  
          <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
              <label for="basicSelect" class="hidden-xs hidden-sm" style="margin:11px"></label>
              <fieldset class="form-group">
                    <div class="input-group-append" id="button-addon2">
                         <button class="btn btn-primary" type="submit"><?=t('Update');?></button>
                    </div>
              </fieldset>
            </div>
        </div>
      </div>
    </div>
  </form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>


	<!-- GÜNCELLEME BİTİŞ-->
<?php }?>
<?php if (Yii::app()->user->checkAccess('medfirms.delete')){ ?>
	<!--SİL BAŞLANGIÇ-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="modalsilme"><?=t('Stok Kimyasal Silme');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="medfirms-form" action="/stokkimyasalkullanim/delete" method="post">

						<input type="hidden" class="form-control" id="modalid2" name="Stokkimyasalkullanim[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>


		<!-- SİL BİTİŞ -->

	<!--delelete all start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="modaltumunusil"><?=t('Stok Kimyasal Silme');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslangıç-->
						<form action="/stokkimyasalkullanim/deleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Medfirms[id]" value="0">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Are you sure you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- delete all finish -->
	<?php }?>

<?php }?>
	<!-- SİL BİTİŞ -->



<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}
</style>
<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

  //delete all start
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.sec').each(function(){
                this.checked = true;
            });
        }else{
             $('.sec').each(function(){
                this.checked = false;
            });
        }
    });

    $('.sec').on('click',function(){
        if($('.sec:checked').length == $('.sec').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

 function deleteall()
 {
	var ids = [];
	$('.sec:checked').each(function(i, e) {
		ids.push($(this).val());
	});
	$('#modalid3').val(ids);
	if(ids=='')
	 {
		alert("<?=t('You must select at least one of the checboxes!');?>");
	}
	else
	 {
		$('#deleteall').modal('show');
	 }

 }
 // delete all finish


 $(document).ready(function() {
      $('.block-page').on('click', function() {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 20000, //unblock after 20 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });

});



  function myfirm()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}


<?php if($ax->firmid!=0){?>
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
<?php }?>


function openmodal(obj)
{
	$('#modalstokid').val($(obj).data('id'));
	$('#modalkimyasaladi').val($(obj).data('kimyasaladi'));
	$('#modalfirmid').val($(obj).data('firmid'));
  $.post( "/workorder/firmbranch?id="+$(obj).data('firmid')).done(function( data ) {
    $( "#modalbranchid" ).prop( "disabled", false );
    $('#modalbranchid').html(data);
    //$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
      $('#modalbranchid').val($(obj).data('branchid'));
  });


  $('#modaltaktifmaddetanimi').val($(obj).data('aktifmaddetanimi'));
  $('#modalyontem').val($(obj).data('yontem'));
  $('#modalruhsattarih').val($(obj).data('ruhsattarih'));
  $('#modalruhsatno').val($(obj).data('ruhsatno'));
 

  $('#modalruhsatbasligi').val($(obj).data('ruhsattarihbaslik'));
    $('#modalruhsatgecerliliktarihi').val($(obj).data('ruhsatgecerliliktarihi'));
	
	
	 $('#modalurunAmbajMiktari').val($(obj).data('urunambajmiktari'));
	   $('#modalurunAntidotu').val($(obj).data('urunantidotu'));
	   
	   
	   	 $('#modalisactive').val($(obj).data('active'));
				$('#modalisactive').select2('destroy');
				$('#modalisactive').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				
				
			 $('#modalurunambajbirimi').val($(obj).data('urunambajbirimi'));
				$('#modalurunambajbirimi').select2('destroy');
				$('#modalurunambajbirimi').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				
$('#guncellemeModal').html($(obj).data('kimyasaladi')+" <?=t('Update')?>");

	
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modalid2').val($(obj).data('id'));
	$('#sil').modal('show');

}

function authchange(data,permission,obj)
{
$.post( "?", { visittypeid: data, active: permission })
  .done(function( returns ) {
	  toastr.success("Success");
});
};

$(document).ready(function(){
	$(".switchery").on('change', function() {

	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }

	  $('#checkbox-value').text($('#checkbox1').val());
});
});


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
                 columns: [0,1,2]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder (<?=date("d-m-Y H:i:s");?>)\n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [0,1,2]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder (<?=date("d-m-Y H:i:s");?>)\n',
        },



		{
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Workorder MedFirms',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'MedFirms \n',
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
