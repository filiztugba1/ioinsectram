<?php
/* @var $this TreatmenttypeController */
/* @var $model Treatmenttype */

$this->breadcrumbs=array(
	'Treatmenttypes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Treatmenttype', 'url'=>array('index')),
	array('label'=>'Create Treatmenttype', 'url'=>array('create')),
	array('label'=>'Update Treatmenttype', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Treatmenttype', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Treatmenttype', 'url'=>array('admin')),
);
?>

<h1>View Treatmenttype #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'isactive',
		'firmid',
	),
)); ?>
