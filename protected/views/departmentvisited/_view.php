<?php
/* @var $this DepartmentvisitedController */
/* @var $data Departmentvisited */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treatmenttypeid')); ?>:</b>
	<?php echo CHtml::encode($data->treatmenttypeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monitoringpoint')); ?>:</b>
	<?php echo CHtml::encode($data->monitoringpoint); ?>
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


</div>