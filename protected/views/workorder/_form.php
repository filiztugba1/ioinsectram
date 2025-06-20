<?php
/* @var $this WorkorderController */
/* @var $model Workorder */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workorder-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_time'); ?>
		<?php echo $form->textField($model,'start_time',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'finish_time'); ?>
		<?php echo $form->textField($model,'finish_time',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'finish_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'teamstaffid'); ?>
		<?php echo $form->textField($model,'teamstaffid'); ?>
		<?php echo $form->error($model,'teamstaffid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visittypeid'); ?>
		<?php echo $form->textField($model,'visittypeid'); ?>
		<?php echo $form->error($model,'visittypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'routeid'); ?>
		<?php echo $form->textField($model,'routeid'); ?>
		<?php echo $form->error($model,'routeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clientid'); ?>
		<?php echo $form->textField($model,'clientid'); ?>
		<?php echo $form->error($model,'clientid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'todo'); ?>
		<?php echo $form->textField($model,'todo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'todo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'departmentid'); ?>
		<?php echo $form->textField($model,'departmentid'); ?>
		<?php echo $form->error($model,'departmentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subdepartmentid'); ?>
		<?php echo $form->textField($model,'subdepartmentid'); ?>
		<?php echo $form->error($model,'subdepartmentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monitoringpointid'); ?>
		<?php echo $form->textField($model,'monitoringpointid'); ?>
		<?php echo $form->error($model,'monitoringpointid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'treatmenttypeid'); ?>
		<?php echo $form->textField($model,'treatmenttypeid'); ?>
		<?php echo $form->error($model,'treatmenttypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monitoringpoint'); ?>
		<?php echo $form->textField($model,'monitoringpoint',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'monitoringpoint'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->