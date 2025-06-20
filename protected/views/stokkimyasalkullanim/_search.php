<?php
/* @var $this StokkimyasalkullanimController */
/* @var $model Stokkimyasalkullanim */
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
		<?php echo $form->label($model,'kimyasaladi'); ?>
		<?php echo $form->textField($model,'kimyasaladi',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aktifmaddetanimi'); ?>
		<?php echo $form->textField($model,'aktifmaddetanimi',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ruhsattarih'); ?>
		<?php echo $form->textField($model,'ruhsattarih'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ruhsatno'); ?>
		<?php echo $form->textField($model,'ruhsatno'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->