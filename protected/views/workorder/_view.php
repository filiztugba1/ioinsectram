<?php
/* @var $this WorkorderController */
/* @var $data Workorder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finish_time')); ?>:</b>
	<?php echo CHtml::encode($data->finish_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teamstaffid')); ?>:</b>
	<?php echo CHtml::encode($data->teamstaffid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visittypeid')); ?>:</b>
	<?php echo CHtml::encode($data->visittypeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('routeid')); ?>:</b>
	<?php echo CHtml::encode($data->routeid); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('clientid')); ?>:</b>
	<?php echo CHtml::encode($data->clientid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('todo')); ?>:</b>
	<?php echo CHtml::encode($data->todo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('departmentid')); ?>:</b>
	<?php echo CHtml::encode($data->departmentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subdepartmentid')); ?>:</b>
	<?php echo CHtml::encode($data->subdepartmentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monitoringpointid')); ?>:</b>
	<?php echo CHtml::encode($data->monitoringpointid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treatmenttypeid')); ?>:</b>
	<?php echo CHtml::encode($data->treatmenttypeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monitoringpoint')); ?>:</b>
	<?php echo CHtml::encode($data->monitoringpoint); ?>
	<br />

	*/ ?>

</div>