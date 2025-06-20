<?php
/* @var $this ConformityController */
/* @var $model Conformity */

$this->breadcrumbs=array(
	'Conformities'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Conformity', 'url'=>array('index')),
	array('label'=>'Create Conformity', 'url'=>array('create')),
	array('label'=>'Update Conformity', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Conformity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Conformity', 'url'=>array('admin')),
);
?>

<h1>View Conformity #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clientid',
		'departmentid',
		'subdepartmentid',
		'type',
		'definition',
		'suggestion',
		'statusid',
		'priority',
		'date',
		'file',
	),
)); ?>
