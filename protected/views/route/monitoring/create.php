<?php
/* @var $this MonitoringController */
/* @var $model Monitoring */

$this->breadcrumbs=array(
	'Monitorings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Monitoring', 'url'=>array('index')),
	array('label'=>'Manage Monitoring', 'url'=>array('admin')),
);
?>

<h1>Create Monitoring</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>