<?php
/* @var $this AuthmodulesController */
/* @var $data Authmodules */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parentid')); ?>:</b>
	<?php echo CHtml::encode($data->parentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menuurl')); ?>:</b>
	<?php echo CHtml::encode($data->menuurl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menuicon')); ?>:</b>
	<?php echo CHtml::encode($data->menuicon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menuview')); ?>:</b>
	<?php echo CHtml::encode($data->menuview); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menurow')); ?>:</b>
	<?php echo CHtml::encode($data->menurow); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('uniqname')); ?>:</b>
	<?php echo CHtml::encode($data->uniqname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('readpermission')); ?>:</b>
	<?php echo CHtml::encode($data->readpermission); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createpermission')); ?>:</b>
	<?php echo CHtml::encode($data->createpermission); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatepermission')); ?>:</b>
	<?php echo CHtml::encode($data->updatepermission); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deletepermission')); ?>:</b>
	<?php echo CHtml::encode($data->deletepermission); ?>
	<br />

	*/ ?>

</div>