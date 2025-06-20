<?php
/* @var $this MonitoringtypeController */
/* @var $model Monitoringtype */

$this->breadcrumbs=array(
	'Monitoringtypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Monitoringtype', 'url'=>array('index')),
	array('label'=>'Manage Monitoringtype', 'url'=>array('admin')),
);
?>

<h1>Create Monitoringtype</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>