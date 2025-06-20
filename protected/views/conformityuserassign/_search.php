<?php
/* @var $this ConformityuserassignController */
/* @var $model Conformityuserassign */
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
		<?php echo $form->label($model,'parentid'); ?>
		<?php echo $form->textField($model,'parentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'conformityid'); ?>
		<?php echo $form->textField($model,'conformityid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'senderuserid'); ?>
		<?php echo $form->textField($model,'senderuserid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recipientuserid'); ?>
		<?php echo $form->textField($model,'recipientuserid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'returnstatustype'); ?>
		<?php echo $form->textField($model,'returnstatustype'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sendtime'); ?>
		<?php echo $form->textField($model,'sendtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'definition'); ?>
		<?php echo $form->textField($model,'definition',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->