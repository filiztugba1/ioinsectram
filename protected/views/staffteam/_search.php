<?php
/* @var $this StaffteamController */
/* @var $model Staffteam */
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
		<?php echo $form->label($model,'teamname'); ?>
		<?php echo $form->textField($model,'teamname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leaderid'); ?>
		<?php echo $form->textField($model,'leaderid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff'); ?>
		<?php echo $form->textArea($model,'staff',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->