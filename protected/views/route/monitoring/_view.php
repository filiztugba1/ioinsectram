<?php
/* @var $this MonitoringController */
/* @var $data Monitoring */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dapartmentid')); ?>:</b>
	<?php echo CHtml::encode($data->dapartmentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subid')); ?>:</b>
	<?php echo CHtml::encode($data->subid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mno')); ?>:</b>
	<?php echo CHtml::encode($data->mno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mtypeid')); ?>:</b>
	<?php echo CHtml::encode($data->mtypeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mlocationid')); ?>:</b>
	<?php echo CHtml::encode($data->mlocationid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('definationlocation')); ?>:</b>
	<?php echo CHtml::encode($data->definationlocation); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	*/ ?>

</div>