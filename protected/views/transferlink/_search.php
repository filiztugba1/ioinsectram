<?php
/* @var $this TransferlinkController */
/* @var $model transferlink */
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
		<?php echo $form->label($model,'frombranchid'); ?>
		<?php echo $form->textField($model,'frombranchid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tobranchid'); ?>
		<?php echo $form->textField($model,'tobranchid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clientid'); ?>
		<?php echo $form->textField($model,'clientid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clientbranchid'); ?>
		<?php echo $form->textField($model,'clientbranchid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->