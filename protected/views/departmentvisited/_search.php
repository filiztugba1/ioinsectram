<?php
/* @var $this DepartmentvisitedController */
/* @var $model Departmentvisited */
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
		<?php echo $form->label($model,'treatmenttypeid'); ?>
		<?php echo $form->textField($model,'treatmenttypeid',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monitoringpoint'); ?>
		<?php echo $form->textField($model,'monitoringpoint',array('size'=>60,'maxlength'=>255)); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->