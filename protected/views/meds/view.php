<?php
/* @var $this MedsController */
/* @var $model Meds */

$this->breadcrumbs=array(
	'Meds'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Meds', 'url'=>array('index')),
	array('label'=>'Create Meds', 'url'=>array('create')),
	array('label'=>'Update Meds', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Meds', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Meds', 'url'=>array('admin')),
);
?>

<h1>View Meds #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'inputtype',
		'medfirmid',
	),
)); ?>
