<?php
/* @var $this GeneralsettingsController */
/* @var $model Generalsettings */

$this->breadcrumbs=array(
	'Generalsettings'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Generalsettings', 'url'=>array('index')),
	array('label'=>'Create Generalsettings', 'url'=>array('create')),
	array('label'=>'Update Generalsettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Generalsettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Generalsettings', 'url'=>array('admin')),
);
?>

<h1>View Generalsettings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'userid',
		'type',
		'isactive',
	),
)); ?>
