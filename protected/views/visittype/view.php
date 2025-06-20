<?php
/* @var $this VisittypeController */
/* @var $model Visittype */

$this->breadcrumbs=array(
	'Visittypes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Visittype', 'url'=>array('index')),
	array('label'=>'Create Visittype', 'url'=>array('create')),
	array('label'=>'Update Visittype', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Visittype', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Visittype', 'url'=>array('admin')),
);
?>

<h1>View Visittype #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'isactive',
		'firmaid',
	),
)); ?>
