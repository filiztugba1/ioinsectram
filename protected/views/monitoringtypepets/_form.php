<?php
/* @var $this MonitoringtypepetsController */
/* @var $model Monitoringtypepets */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'monitoringtypepets-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'petsid'); ?>
		<?php echo $form->textField($model,'petsid'); ?>
		<?php echo $form->error($model,'petsid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isactive'); ?>
		<?php echo $form->textField($model,'isactive'); ?>
		<?php echo $form->error($model,'isactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->