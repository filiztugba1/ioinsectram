<?php
/* @var $this ConformityactivityController */
/* @var $model Conformityactivity */

$this->breadcrumbs=array(
	'Conformityactivities'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Conformityactivity', 'url'=>array('index')),
	array('label'=>'Create Conformityactivity', 'url'=>array('create')),
	array('label'=>'Update Conformityactivity', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Conformityactivity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Conformityactivity', 'url'=>array('admin')),
);
?>

<h1>View Conformityactivity #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'definition',
		'conformityid',
	),
)); ?>
