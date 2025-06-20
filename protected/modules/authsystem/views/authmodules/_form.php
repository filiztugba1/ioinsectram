<?php
/* @var $this AuthmodulesController */
/* @var $model Authmodules */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'authmodules-form',
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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuurl'); ?>
		<?php echo $form->textField($model,'menuurl',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'menuurl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuicon'); ?>
		<?php echo $form->textField($model,'menuicon',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'menuicon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuview'); ?>
		<?php echo $form->textField($model,'menuview'); ?>
		<?php echo $form->error($model,'menuview'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menurow'); ?>
		<?php echo $form->textField($model,'menurow'); ?>
		<?php echo $form->error($model,'menurow'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uniqname'); ?>
		<?php echo $form->textField($model,'uniqname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'uniqname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'readpermission'); ?>
		<?php echo $form->textField($model,'readpermission',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'readpermission'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createpermission'); ?>
		<?php echo $form->textField($model,'createpermission',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'createpermission'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatepermission'); ?>
		<?php echo $form->textField($model,'updatepermission',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'updatepermission'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deletepermission'); ?>
		<?php echo $form->textField($model,'deletepermission',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'deletepermission'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->