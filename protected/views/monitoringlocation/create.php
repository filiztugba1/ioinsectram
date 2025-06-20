<?php
/* @var $this MonitoringlocationController */
/* @var $model Monitoringlocation */

$this->breadcrumbs=array(
	'Monitoringlocations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Monitoringlocation', 'url'=>array('index')),
	array('label'=>'Manage Monitoringlocation', 'url'=>array('admin')),
);
?>

<h1>Create Monitoringlocation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>