<?php
/* @var $this AuthmodulesController */
/* @var $model Authmodules */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menuurl'); ?>
		<?php echo $form->textField($model,'menuurl',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menuicon'); ?>
		<?php echo $form->textField($model,'menuicon',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menuview'); ?>
		<?php echo $form->textField($model,'menuview'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menurow'); ?>
		<?php echo $form->textField($model,'menurow'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'uniqname'); ?>
		<?php echo $form->textField($model,'uniqname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'readpermission'); ?>
		<?php echo $form->textField($model,'readpermission',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createpermission'); ?>
		<?php echo $form->textField($model,'createpermission',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updatepermission'); ?>
		<?php echo $form->textField($model,'updatepermission',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deletepermission'); ?>
		<?php echo $form->textField($model,'deletepermission',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->