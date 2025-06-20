<?php
/* @var $this StokkimyasalkullanimController */
/* @var $data Stokkimyasalkullanim */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kimyasaladi')); ?>:</b>
	<?php echo CHtml::encode($data->kimyasaladi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aktifmaddetanimi')); ?>:</b>
	<?php echo CHtml::encode($data->aktifmaddetanimi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruhsattarih')); ?>:</b>
	<?php echo CHtml::encode($data->ruhsattarih); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruhsatno')); ?>:</b>
	<?php echo CHtml::encode($data->ruhsatno); ?>
	<br />


</div>