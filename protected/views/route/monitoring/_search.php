<?php
/* @var $this MonitoringController */
/* @var $model Monitoring */
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
		<?php echo $form->label($model,'dapartmentid'); ?>
		<?php echo $form->textField($model,'dapartmentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subid'); ?>
		<?php echo $form->textField($model,'subid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mno'); ?>
		<?php echo $form->textField($model,'mno',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mtypeid'); ?>
		<?php echo $form->textField($model,'mtypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mlocationid'); ?>
		<?php echo $form->textField($model,'mlocationid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'definationlocation'); ?>
		<?php echo $form->textField($model,'definationlocation',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->