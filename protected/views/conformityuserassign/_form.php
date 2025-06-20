<?php
/* @var $this ConformityuserassignController */
/* @var $model Conformityuserassign */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'conformityuserassign-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parentid'); ?>
		<?php echo $form->textField($model,'parentid'); ?>
		<?php echo $form->error($model,'parentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conformityid'); ?>
		<?php echo $form->textField($model,'conformityid'); ?>
		<?php echo $form->error($model,'conformityid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'senderuserid'); ?>
		<?php echo $form->textField($model,'senderuserid'); ?>
		<?php echo $form->error($model,'senderuserid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recipientuserid'); ?>
		<?php echo $form->textField($model,'recipientuserid'); ?>
		<?php echo $form->error($model,'recipientuserid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'returnstatustype'); ?>
		<?php echo $form->textField($model,'returnstatustype'); ?>
		<?php echo $form->error($model,'returnstatustype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sendtime'); ?>
		<?php echo $form->textField($model,'sendtime'); ?>
		<?php echo $form->error($model,'sendtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'definition'); ?>
		<?php echo $form->textField($model,'definition',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'definition'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->