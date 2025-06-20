<?php
/* @var $this ConformityuserassignController */
/* @var $model Conformityuserassign */

$this->breadcrumbs=array(
	'Conformityuserassigns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Conformityuserassign', 'url'=>array('index')),
	array('label'=>'Create Conformityuserassign', 'url'=>array('create')),
	array('label'=>'Update Conformityuserassign', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Conformityuserassign', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Conformityuserassign', 'url'=>array('admin')),
);
?>

<h1>View Conformityuserassign #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parentid',
		'conformityid',
		'senderuserid',
		'recipientuserid',
		'returnstatustype',
		'sendtime',
		'definition',
	),
)); ?>
