<?php
/* @var $this MonitoringtypepetsController */
/* @var $model Monitoringtypepets */

$this->breadcrumbs=array(
	'Monitoringtypepets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Monitoringtypepets', 'url'=>array('index')),
	array('label'=>'Manage Monitoringtypepets', 'url'=>array('admin')),
);
?>

<h1>Create Monitoringtypepets</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>