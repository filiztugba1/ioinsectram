<?php
/* @var $this WorkorderController */
/* @var $model Workorder */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_time'); ?>
		<?php echo $form->textField($model,'start_time',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'finish_time'); ?>
		<?php echo $form->textField($model,'finish_time',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'teamstaffid'); ?>
		<?php echo $form->textField($model,'teamstaffid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visittypeid'); ?>
		<?php echo $form->textField($model,'visittypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'routeid'); ?>
		<?php echo $form->textField($model,'routeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clientid'); ?>
		<?php echo $form->textField($model,'clientid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'todo'); ?>
		<?php echo $form->textField($model,'todo',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'departmentid'); ?>
		<?php echo $form->textField($model,'departmentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subdepartmentid'); ?>
		<?php echo $form->textField($model,'subdepartmentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monitoringpointid'); ?>
		<?php echo $form->textField($model,'monitoringpointid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'treatmenttypeid'); ?>
		<?php echo $form->textField($model,'treatmenttypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monitoringpoint'); ?>
		<?php echo $form->textField($model,'monitoringpoint',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->