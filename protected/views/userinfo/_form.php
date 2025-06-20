<?php
/* @var $this UserinfoController */
/* @var $model Userinfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userinfo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	
					  
					    <div class="row">
						
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Identification Number','identification_number','text',$model->identification_number,'Identification Number');?>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Birth Place','birthplace','text',$model->birthplace,'Birth Place');?>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Birth Date','birthdate','date',$model->birthdate,'Birth Date');?>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Gender</label>
								  <select class="form-control" id="basicSelect" name="gender" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->gender==1){echo 'Selected';}?>>Gender</option>
								  <option value="2" <?php if($model->gender==2){echo 'Selected';}?>>Not Gender</option>
								  </select>
                        </fieldset>
							</div>
				
					   
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Primary phone','primaryphone','number',$model->primaryphone,'Primary Phone');?>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Secondary Phone','secondaryphone','number',$model->secondaryphone,'Secondary Phone');?>
							</div>
							
							
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Country','country','text',$model->country,'Country');?>
							</div>
							
			
								
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Marital</label>
								  <select class="form-control" id="basicSelect" name="marital" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->marital==1){echo 'Selected';}?>>Married</option>
								  <option value="2" <?php if($model->marital==2){echo 'Selected';}?>>Single</option>
								  </select>
								</fieldset>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Children','children','number',$model->children,'Children');?>
							</div>
							
								<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Address','address','text',$model->address,'Address');?>
							</div>
						
						
						
						
					
					   
					   <div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Address Country','address_country','text',$model->address_country,'Address Country');?>
							</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Address City','address_city','text',$model->address_city,'Address City');?>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Blood','blood','text',$model->blood,'Blood');?>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Driving Licance</label>
								  <select class="form-control" id="basicSelect" name="driving_licance" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->driving_licance==1){echo 'Selected';}?>>Yes</option>
								  <option value="2" <?php if($model->driving_licance==2){echo 'Selected';}?>>No</option>
								  </select>
								</fieldset>
						</div>
							
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Driving Licance Date','driving_licance_date','date',$model->driving_licance_date,'Driving Licance Date');?>
						</div>	
							
							
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Military</label>
								  <select class="form-control" id="basicSelect" name="military" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->military==1){echo 'Selected';}?>>Yes</option>
								  <option value="2" <?php if($model->military==2){echo 'Selected';}?>>No</option>
								  </select>
								</fieldset>
						</div>
						
					
						
						
						
						<?php $education=  Education::model()->findAll();
						$educationid=$model->educationid;
						?>
						
						<?php $language=  Languages::model()->findAll();
						$speaks=$model->speaks;
						?>
						
						<?php $certificate=  Certificate::model()->findAll();
						$certificateid=$model->certificate;
						?>
						
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Education</label>
								  <select class="form-control" id="basicSelect" name="educationid" required>
								  <option>Select</option>
								  <?php foreach ($education as $educationx):?>
								  <option value="<?php echo $educationx->id;?>" <?php if($educationx->id==$educationid){echo 'Selected';}?> ><?php echo $educationx->name;?></option>
								  <?php endforeach;?>
								  </select>
								</fieldset>
						</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Speaks</label>
								  <select class="form-control" id="basicSelect" name="speaks" required>
								  <option>Select</option>
								  <?php foreach ($language as $languagex):?>
								  <option value="<?php echo $languagex->id;?>" <?php if($languagex->id==$speaks){echo 'Selected';}?> ><?php echo $languagex->name;?></option>
								  <?php endforeach;?>
								  </select>
								</fieldset>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Certificate</label>
								  <select class="form-control" id="basicSelect" name="certificate" required>
								  <option>Select</option>
								  <?php foreach ($certificate as $certificatex):?>
								  <option value="<?php echo $certificatex->id;?>" <?php if($certificatex->id==$certificateid){echo 'Selected';}?> ><?php echo $certificatex->name;?></option>
								  <?php endforeach;?>
								  </select>
								</fieldset>
							</div>
							
							
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Travel</label>
								  <select class="form-control" id="basicSelect" name="travel" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->travel==1){echo 'Selected';}?>>Yes</option>
								  <option value="2" <?php if($model->travel==2){echo 'Selected';}?>>No</option>
								  </select>
								</fieldset>
						</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Health Problem</label>
								  <select class="form-control" id="basicSelect" name="health_problem" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->health_problem==1){echo 'Selected';}?>>Yes</option>
								  <option value="2" <?php if($model->health_problem==2){echo 'Selected';}?>>No</option>
								  </select>
								</fieldset>
						</div>
						
						
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Health Description','health_description','textarea',$model->health_description,'Health Description');?>
						</div>	
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Smoking</label>
								  <select class="form-control" id="basicSelect" name="smoking" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->smoking==1){echo 'Selected';}?>>Yes</option>
								  <option value="2" <?php if($model->smoking==2){echo 'Selected';}?>>No</option>
								  </select>
								</fieldset>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Emergency Name','emergencyname','text',$model->emergencyname,'Emergency Name');?>
						</div>	
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Emergency Phone','emergencyphone','number',$model->emergencyphone,'Emergency Phone');?>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Leave Date','leavedate','date',$model->leavedate,'Leave Date');?>
							</div>
							
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Leave Description','leave_description','textarea',$model->leave_description,'Health Description');?>
						</div>	
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Referance','referance','textarea',$model->referance,'Referance');?>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<?php Sector::model()->form('Projects','projects','textarea',$model->projects,'Projects');?>
						</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect">Computerskills</label>
								  <select class="form-control" id="basicSelect" name="computerskills" required>
								  <option>Select</option>
								  <option value="1" <?php if($model->computerskills==1){echo 'Selected';}?>>Yes</option>
								  <option value="2" <?php if($model->computerskills==2){echo 'Selected';}?>>No</option>
								  </select>
								</fieldset>
						</div>
						
						
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                            <fieldset class="form-group">
							<label for="User_Username" class="col-lg-12 hidden-sm hidden-xs" style="padding-top:15px"></label> 
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-success mr-1')); ?>
							</fieldset>
                    </div>
						
						</div>
						
		


			

<?php $this->endWidget(); ?>

</div><!-- form -->