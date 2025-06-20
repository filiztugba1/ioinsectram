<?php
/* @var $this WorkorderController */
/* @var $model Workorder */

$this->breadcrumbs=array(
	'Workorders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Workorder', 'url'=>array('index')),
	array('label'=>'Manage Workorder', 'url'=>array('admin')),
);
?>

<h1>Create Workorder</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>