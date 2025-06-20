<?php
/* @var $this MonitoringlocationController */
/* @var $model Monitoringlocation */

$this->breadcrumbs=array(
	'Monitoringlocations'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Monitoringlocation', 'url'=>array('index')),
	array('label'=>'Create Monitoringlocation', 'url'=>array('create')),
	array('label'=>'Update Monitoringlocation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Monitoringlocation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Monitoringlocation', 'url'=>array('admin')),
);
?>

<h1>View Monitoringlocation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'active',
	),
)); ?>
