<?php
/* @var $this AuthtypesController */
/* @var $model Authtypes */

$this->breadcrumbs=array(
	'Authtypes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Authtypes', 'url'=>array('index')),
	array('label'=>'Create Authtypes', 'url'=>array('create')),
	array('label'=>'Update Authtypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Authtypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Authtypes', 'url'=>array('admin')),
);
?>

<h1>View Authtypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'authname',
		'parentid',
	),
)); ?>
