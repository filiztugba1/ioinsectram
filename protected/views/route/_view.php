<?php
/* @var $this RouteController */
/* @var $data Route */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branchid')); ?>:</b>
	<?php echo CHtml::encode($data->branchid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firmid')); ?>:</b>
	<?php echo CHtml::encode($data->firmid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>