<?php
/* @var $this TransferlinkController */
/* @var $data transferlink */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('frombranchid')); ?>:</b>
	<?php echo CHtml::encode($data->frombranchid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tobranchid')); ?>:</b>
	<?php echo CHtml::encode($data->tobranchid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clientid')); ?>:</b>
	<?php echo CHtml::encode($data->clientid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clientbranchid')); ?>:</b>
	<?php echo CHtml::encode($data->clientbranchid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>