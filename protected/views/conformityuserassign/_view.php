<?php
/* @var $this ConformityuserassignController */
/* @var $data Conformityuserassign */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parentid')); ?>:</b>
	<?php echo CHtml::encode($data->parentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conformityid')); ?>:</b>
	<?php echo CHtml::encode($data->conformityid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('senderuserid')); ?>:</b>
	<?php echo CHtml::encode($data->senderuserid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipientuserid')); ?>:</b>
	<?php echo CHtml::encode($data->recipientuserid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('returnstatustype')); ?>:</b>
	<?php echo CHtml::encode($data->returnstatustype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sendtime')); ?>:</b>
	<?php echo CHtml::encode($data->sendtime); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('definition')); ?>:</b>
	<?php echo CHtml::encode($data->definition); ?>
	<br />

	*/ ?>

</div>