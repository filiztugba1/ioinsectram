<?php
/* @var $this LoglarController */
/* @var $model Loglar */

$this->breadcrumbs=array(
	'Loglars'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Loglar', 'url'=>array('index')),
	array('label'=>'Create Loglar', 'url'=>array('create')),
	array('label'=>'Update Loglar', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Loglar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Loglar', 'url'=>array('admin')),
);
?>

<h1>View Loglar #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userid',
		'data',
		'tablename',
		'operation',
		'createdtime',
	),
)); ?>
