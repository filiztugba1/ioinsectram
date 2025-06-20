<?php
/* @var $this UserinfoController */
/* @var $data Userinfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userid')); ?>:</b>
	<?php echo CHtml::encode($data->userid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_number')); ?>:</b>
	<?php echo CHtml::encode($data->identification_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthplace')); ?>:</b>
	<?php echo CHtml::encode($data->birthplace); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthdate')); ?>:</b>
	<?php echo CHtml::encode($data->birthdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('primaryphone')); ?>:</b>
	<?php echo CHtml::encode($data->primaryphone); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('secondaryphone')); ?>:</b>
	<?php echo CHtml::encode($data->secondaryphone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('marital')); ?>:</b>
	<?php echo CHtml::encode($data->marital); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('children')); ?>:</b>
	<?php echo CHtml::encode($data->children); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address_country')); ?>:</b>
	<?php echo CHtml::encode($data->address_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address_city')); ?>:</b>
	<?php echo CHtml::encode($data->address_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blood')); ?>:</b>
	<?php echo CHtml::encode($data->blood); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driving_licance')); ?>:</b>
	<?php echo CHtml::encode($data->driving_licance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driving_licance_date')); ?>:</b>
	<?php echo CHtml::encode($data->driving_licance_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('military')); ?>:</b>
	<?php echo CHtml::encode($data->military); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('educationid')); ?>:</b>
	<?php echo CHtml::encode($data->educationid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speaks')); ?>:</b>
	<?php echo CHtml::encode($data->speaks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('certificate')); ?>:</b>
	<?php echo CHtml::encode($data->certificate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('travel')); ?>:</b>
	<?php echo CHtml::encode($data->travel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('health_problem')); ?>:</b>
	<?php echo CHtml::encode($data->health_problem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('health_description')); ?>:</b>
	<?php echo CHtml::encode($data->health_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('smoking')); ?>:</b>
	<?php echo CHtml::encode($data->smoking); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emergencyname')); ?>:</b>
	<?php echo CHtml::encode($data->emergencyname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emergencyphone')); ?>:</b>
	<?php echo CHtml::encode($data->emergencyphone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leavedate')); ?>:</b>
	<?php echo CHtml::encode($data->leavedate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_description')); ?>:</b>
	<?php echo CHtml::encode($data->leave_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('referance')); ?>:</b>
	<?php echo CHtml::encode($data->referance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('projects')); ?>:</b>
	<?php echo CHtml::encode($data->projects); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('computerskills')); ?>:</b>
	<?php echo CHtml::encode($data->computerskills); ?>
	<br />

	*/ ?>

</div>