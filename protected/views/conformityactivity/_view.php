<?php
/* @var $this ConformityactivityController */
/* @var $data Conformityactivity */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('definition')); ?>:</b>
	<?php echo CHtml::encode($data->definition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conformityid')); ?>:</b>
	<?php echo CHtml::encode($data->conformityid); ?>
	<br />


</div>