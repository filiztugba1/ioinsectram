<?php
/* @var $this LoglarController */
/* @var $model Loglar */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'loglar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
		<?php echo $form->error($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data'); ?>
		<?php echo $form->textArea($model,'data',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tablename'); ?>
		<?php echo $form->textField($model,'tablename',array('size'=>60,'maxlength'=>225)); ?>
		<?php echo $form->error($model,'tablename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'operation'); ?>
		<?php echo $form->textField($model,'operation',array('size'=>60,'maxlength'=>225)); ?>
		<?php echo $form->error($model,'operation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createdtime'); ?>
		<?php echo $form->textField($model,'createdtime'); ?>
		<?php echo $form->error($model,'createdtime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->