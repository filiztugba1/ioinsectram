<?php
/* @var $this MedsController */
/* @var $data Meds */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inputtype')); ?>:</b>
	<?php echo CHtml::encode($data->inputtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('medfirmid')); ?>:</b>
	<?php echo CHtml::encode($data->medfirmid); ?>
	<br />


</div>