<?php
/* @var $this EmailController */
/* @var $data Email */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('smtphost')); ?>:</b>
	<?php echo CHtml::encode($data->smtphost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('port')); ?>:</b>
	<?php echo CHtml::encode($data->port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromname')); ?>:</b>
	<?php echo CHtml::encode($data->fromname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromemail')); ?>:</b>
	<?php echo CHtml::encode($data->fromemail); ?>
	<br />


</div>