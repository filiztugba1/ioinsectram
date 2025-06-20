<?php
/* @var $this UserinfoController */
/* @var $model Userinfo */
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
		<?php echo $form->label($model,'identification_number'); ?>
		<?php echo $form->textField($model,'identification_number',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'birthplace'); ?>
		<?php echo $form->textField($model,'birthplace',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'birthdate'); ?>
		<?php echo $form->textField($model,'birthdate',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gender'); ?>
		<?php echo $form->textField($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'primaryphone'); ?>
		<?php echo $form->textField($model,'primaryphone',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'secondaryphone'); ?>
		<?php echo $form->textField($model,'secondaryphone',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country'); ?>
		<?php echo $form->textField($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'marital'); ?>
		<?php echo $form->textField($model,'marital'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'children'); ?>
		<?php echo $form->textField($model,'children'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address_country'); ?>
		<?php echo $form->textField($model,'address_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address_city'); ?>
		<?php echo $form->textField($model,'address_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'blood'); ?>
		<?php echo $form->textField($model,'blood',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driving_licance'); ?>
		<?php echo $form->textField($model,'driving_licance'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'driving_licance_date'); ?>
		<?php echo $form->textField($model,'driving_licance_date',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'military'); ?>
		<?php echo $form->textField($model,'military'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'educationid'); ?>
		<?php echo $form->textField($model,'educationid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'speaks'); ?>
		<?php echo $form->textField($model,'speaks',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'certificate'); ?>
		<?php echo $form->textField($model,'certificate',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'travel'); ?>
		<?php echo $form->textField($model,'travel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'health_problem'); ?>
		<?php echo $form->textField($model,'health_problem'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'health_description'); ?>
		<?php echo $form->textField($model,'health_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'smoking'); ?>
		<?php echo $form->textField($model,'smoking'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emergencyname'); ?>
		<?php echo $form->textField($model,'emergencyname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emergencyphone'); ?>
		<?php echo $form->textField($model,'emergencyphone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leavedate'); ?>
		<?php echo $form->textField($model,'leavedate',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_description'); ?>
		<?php echo $form->textField($model,'leave_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'referance'); ?>
		<?php echo $form->textField($model,'referance',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'projects'); ?>
		<?php echo $form->textField($model,'projects',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'computerskills'); ?>
		<?php echo $form->textField($model,'computerskills',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->