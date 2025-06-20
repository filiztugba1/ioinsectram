<?php
/* @var $this LoglarController */
/* @var $model Loglar */
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
		<?php echo $form->label($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data'); ?>
		<?php echo $form->textArea($model,'data',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tablename'); ?>
		<?php echo $form->textField($model,'tablename',array('size'=>60,'maxlength'=>225)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operation'); ?>
		<?php echo $form->textField($model,'operation',array('size'=>60,'maxlength'=>225)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createdtime'); ?>
		<?php echo $form->textField($model,'createdtime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->