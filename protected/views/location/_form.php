<?php
/* @var $this LocationController */
/* @var $model Location */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'location-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>

	<div class="row">
			
			
			<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
			<?php Sector::model()->forminput('Name',array('name'=>'name', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Name','id'=>'name','type'=>'date','value'=>$model->name,));?>
		</div>
	
		<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
			<?php Sector::model()->formselect('Type',array('name'=>'type','class'=>'form-control','placeholder'=>'','id'=>'basicSelect','type'=>'select','value'=>$model->type,),
														  array('Country','City')
														);?>
		</div>
			
		
			
				<?php    $location=Location::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=0',
							   ));
                  
					
						$parentid=$model->parentid;
						?>
						

		
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
								<fieldset class="form-group">
											  <label for="basicSelect">Parent</label>
											  <select class="form-control" id="basicSelect" name="parentid" required>
											  <option>Select</option>
											  <?php foreach($location as $locationx):?>
											  <option value="<?php echo $locationx->id;?>" <?php if($locationx->id==$parentid){echo 'Selected';}?>><?php echo $locationx->name;?></option>
											  <?endforeach;?>
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