<?php
/* @var $this MonitoringController */
/* @var $model Monitoring */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'monitoring-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dapartmentid'); ?>
		<?php echo $form->textField($model,'dapartmentid'); ?>
		<?php echo $form->error($model,'dapartmentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subid'); ?>
		<?php echo $form->textField($model,'subid'); ?>
		<?php echo $form->error($model,'subid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mno'); ?>
		<?php echo $form->textField($model,'mno',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mtypeid'); ?>
		<?php echo $form->textField($model,'mtypeid'); ?>
		<?php echo $form->error($model,'mtypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mlocationid'); ?>
		<?php echo $form->textField($model,'mlocationid'); ?>
		<?php echo $form->error($model,'mlocationid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'definationlocation'); ?>
		<?php echo $form->textField($model,'definationlocation',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'definationlocation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->