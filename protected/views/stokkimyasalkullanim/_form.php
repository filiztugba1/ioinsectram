<?php
/* @var $this StokkimyasalkullanimController */
/* @var $model Stokkimyasalkullanim */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stokkimyasalkullanim-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'kimyasaladi'); ?>
		<?php echo $form->textField($model,'kimyasaladi',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'kimyasaladi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'aktifmaddetanimi'); ?>
		<?php echo $form->textField($model,'aktifmaddetanimi',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'aktifmaddetanimi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ruhsattarih'); ?>
		<?php echo $form->textField($model,'ruhsattarih'); ?>
		<?php echo $form->error($model,'ruhsattarih'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ruhsatno'); ?>
		<?php echo $form->textField($model,'ruhsatno'); ?>
		<?php echo $form->error($model,'ruhsatno'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->