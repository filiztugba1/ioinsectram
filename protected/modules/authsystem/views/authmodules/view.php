<?php
/* @var $this AuthmodulesController */
/* @var $model Authmodules */

$this->breadcrumbs=array(
	'Authmodules'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Authmodules', 'url'=>array('index')),
	array('label'=>'Create Authmodules', 'url'=>array('create')),
	array('label'=>'Update Authmodules', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Authmodules', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Authmodules', 'url'=>array('admin')),
);
?>

<h1>View Authmodules #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parentid',
		'name',
		'menuurl',
		'menuicon',
		'menuview',
		'menurow',
		'uniqname',
		'readpermission',
		'createpermission',
		'updatepermission',
		'deletepermission',
	),
)); ?>
