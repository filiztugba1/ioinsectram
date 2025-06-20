<?php
/* @var $this MonitoringtypepetsController */
/* @var $model Monitoringtypepets */

$this->breadcrumbs=array(
	'Monitoringtypepets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Monitoringtypepets', 'url'=>array('index')),
	array('label'=>'Create Monitoringtypepets', 'url'=>array('create')),
	array('label'=>'Update Monitoringtypepets', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Monitoringtypepets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Monitoringtypepets', 'url'=>array('admin')),
);
?>

<h1>View Monitoringtypepets #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'petsid',
		'isactive',
	),
)); ?>
