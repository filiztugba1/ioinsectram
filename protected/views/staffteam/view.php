<?php
/* @var $this StaffteamController */
/* @var $model Staffteam */

$this->breadcrumbs=array(
	'Staffteams'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Staffteam', 'url'=>array('index')),
	array('label'=>'Create Staffteam', 'url'=>array('create')),
	array('label'=>'Update Staffteam', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Staffteam', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Staffteam', 'url'=>array('admin')),
);
?>

<h1>View Staffteam #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'teamname',
		'leaderid',
		'staff',
	),
)); ?>
