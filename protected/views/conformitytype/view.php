<?php
/* @var $this ConformitytypeController */
/* @var $model Conformitytype */

$this->breadcrumbs=array(
	'Conformitytypes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Conformitytype', 'url'=>array('index')),
	array('label'=>'Create Conformitytype', 'url'=>array('create')),
	array('label'=>'Update Conformitytype', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Conformitytype', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Conformitytype', 'url'=>array('admin')),
);
?>

<h1>View Conformitytype #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'isactive',
	),
)); ?>
