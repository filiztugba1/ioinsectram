<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	
	<div class="row" style="margin-top:30px">
	
	
	<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
	 
					 
					 
					  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('Active','active','selectActive',$model->active,'');?>
                     </div>
					 
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('User Name','username','text',$model->username,'User Name');?>
                     </div>
					 
					 <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('Password','password','password',$model->password,'Password');?>
                     </div>
				
				
					 <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('E-Mail','email','email',$model->email,'E-Mail');?>
                     </div>
					 			  
					
					 
					    <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                           <fieldset class="form-group">
                          <label for="basicSelect">User Type</label>
                          <select class="form-control" id="basicSelect" name="type" required>
                            <option>Select</option>
                            <option value="1" <?php if($model->typeid==1){echo "Selected";}?>>Super Admin</option>
                            <option value="2" <?php if($model->typeid==2){echo "Selected";}?>>Admin</option>
                            <option value="3" <?php if($model->typeid==3){echo "Selected";}?>>Staff</option>
                          </select>
                        </fieldset>
					 </div>
					 
					
					 
			</div>
			
			<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
			
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('Name','name','text',$model->name,'Name');?>
                     </div>
					 
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('Surname','surname','text',$model->surname,'Surname');?>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('Authgroup','authgroup','text',$model->authgroup,'Authgroup');?>
                    </div>
					 
					 <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<?php Sector::model()->form('Language','languageid','text',$model->languageid,'Language');?>
                    </div>
					 
					
					 
				</div>	 
					  
				
					 <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					 <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                            <fieldset class="form-group">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Yeni Ekle' : 'Güncelle',array('class'=>'btn btn-success mr-1')); ?>
							</fieldset>
                      </div>
				
					 
					 
	</div>



	<!--<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	-->

<?php $this->endWidget(); ?>

</div><!-- form -->