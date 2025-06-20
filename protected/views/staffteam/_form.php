<?php
/* @var $this StaffteamController */
/* @var $model Staffteam */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staffteam-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'teamname'); ?>
		<?php echo $form->textField($model,'teamname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'teamname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leaderid'); ?>
		<?php echo $form->textField($model,'leaderid'); ?>
		<?php echo $form->error($model,'leaderid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff'); ?>
		<?php echo $form->textArea($model,'staff',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'staff'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->