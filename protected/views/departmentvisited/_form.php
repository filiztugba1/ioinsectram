<?php
/* @var $this DepartmentvisitedController */
/* @var $model Departmentvisited */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'departmentvisited-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'treatmenttypeid'); ?>
		<?php echo $form->textField($model,'treatmenttypeid',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'treatmenttypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monitoringpoint'); ?>
		<?php echo $form->textField($model,'monitoringpoint',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'monitoringpoint'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->