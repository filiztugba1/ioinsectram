<?php
/* @var $this TransferlinkController */
/* @var $model transferlink */

$this->breadcrumbs=array(
	'Transferlinks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List transferlink', 'url'=>array('index')),
	array('label'=>'Create transferlink', 'url'=>array('create')),
	array('label'=>'Update transferlink', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete transferlink', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage transferlink', 'url'=>array('admin')),
);
?>

<h1>View transferlink #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'frombranchid',
		'tobranchid',
		'clientid',
		'clientbranchid',
		'status',
	),
)); ?>
