<?php
/* @var $this MonitoringlocationController */
/* @var $model Monitoringlocation */

$this->breadcrumbs=array(
	'Monitoringlocations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Monitoringlocation', 'url'=>array('index')),
	array('label'=>'Create Monitoringlocation', 'url'=>array('create')),
	array('label'=>'View Monitoringlocation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Monitoringlocation', 'url'=>array('admin')),
);
?>

<h1>Update Monitoringlocation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>