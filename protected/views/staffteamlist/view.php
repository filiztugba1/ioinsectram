<?php
/* @var $this StaffteamlistController */
/* @var $model Staffteamlist */

$this->breadcrumbs=array(
	'Staffteamlists'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Staffteamlist', 'url'=>array('index')),
	array('label'=>'Create Staffteamlist', 'url'=>array('create')),
	array('label'=>'Update Staffteamlist', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Staffteamlist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Staffteamlist', 'url'=>array('admin')),
);
?>

<h1>View Staffteamlist #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'leaderid',
		'name',
		'surname',
		'email',
		'password',
		'birdplace',
		'birddate',
		'genger',
		'phone',
	),
)); ?>
