<?php
/* @var $this TransferlinkController */
/* @var $model transferlink */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transferlink-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'frombranchid'); ?>
		<?php echo $form->textField($model,'frombranchid'); ?>
		<?php echo $form->error($model,'frombranchid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tobranchid'); ?>
		<?php echo $form->textField($model,'tobranchid'); ?>
		<?php echo $form->error($model,'tobranchid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clientid'); ?>
		<?php echo $form->textField($model,'clientid'); ?>
		<?php echo $form->error($model,'clientid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clientbranchid'); ?>
		<?php echo $form->textField($model,'clientbranchid'); ?>
		<?php echo $form->error($model,'clientbranchid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->