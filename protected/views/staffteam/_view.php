<?php
/* @var $this StaffteamController */
/* @var $data Staffteam */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teamname')); ?>:</b>
	<?php echo CHtml::encode($data->teamname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leaderid')); ?>:</b>
	<?php echo CHtml::encode($data->leaderid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff')); ?>:</b>
	<?php echo CHtml::encode($data->staff); ?>
	<br />


</div>