<?php
/* @var $this SectorController */
/* @var $model Sector */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sector-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<!--
	<div class="row">
		<?php // echo $form->labelEx($model,'parentid'); ?>
		<?php // echo $form->textField($model,'parentid'); ?>
		<?php // echo $form->error($model,'parentid'); ?>
	</div>
-->
		<div class="row" style="margin-top:30px">
		 
					 <div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<?php Sector::model()->form('Active','active','selectActive',$model->active,'');?>
                     </div>
					 
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<?php Sector::model()->form('Name','name','text',$model->name,'Name');?>
                     </div>
					
					
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                            <fieldset class="form-group">
							<label for="User_Username" class="col-lg-12 hidden-sm hidden-xs" style="padding-top:15px"></label> 
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-success mr-1')); ?>
							</fieldset>
                    </div>
	    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->