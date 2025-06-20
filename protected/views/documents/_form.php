<?php
/* @var $this DocumentsController */
/* @var $model Documents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>

<?
$this->widget('ext.euploadmam.EuploadmamWidget',array(
							'model'=>$model,
							'attribute' => 'url', 
							'actionUpload'=>Yii::app()->createUrl('site/upload'),
							'actionRemoveFile'=>Yii::app()->createUrl('site/removeFile'),
							'limit'=>4,
							'maxSize'=>4, //4MB,
							#'extensions'=>array('jpg','png','gif'),//etc
							'uploadDir'=>'uploads/',
							'view'=>'default',//dragdrop,instant
							#'title'=>array('auto',10),
							#'removeConfirmation'=>false,
						));
						?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->