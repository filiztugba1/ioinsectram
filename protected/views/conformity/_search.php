<?php
/* @var $this ConformityController */
/* @var $model Conformity */
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
		<?php echo $form->label($model,'clientid'); ?>
		<?php echo $form->textField($model,'clientid'); ?>
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
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'definition'); ?>
		<?php echo $form->textArea($model,'definition',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'suggestion'); ?>
		<?php echo $form->textArea($model,'suggestion',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'statusid'); ?>
		<?php echo $form->textField($model,'statusid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'priority'); ?>
		<?php echo $form->textField($model,'priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file'); ?>
		<?php echo $form->textArea($model,'file',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->