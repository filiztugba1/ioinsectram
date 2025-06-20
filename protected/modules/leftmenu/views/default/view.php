<?php
/* @var $this DefaultController */
/* @var $model Leftmenu */

$this->breadcrumbs=array(
	'Leftmenus'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Leftmenu', 'url'=>array('index')),
	array('label'=>'Create Leftmenu', 'url'=>array('create')),
	array('label'=>'Update Leftmenu', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Leftmenu', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Leftmenu', 'url'=>array('admin')),
);
?>

<h1>View Leftmenu #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'parent',
		'url',
		'icon',
		'permissions',
		'isactive',
	),
)); ?>
