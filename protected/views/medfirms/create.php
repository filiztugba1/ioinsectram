<?php
/* @var $this MedfirmsController */
/* @var $model Medfirms */

$this->breadcrumbs=array(
	'Medfirms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Medfirms', 'url'=>array('index')),
	array('label'=>'Manage Medfirms', 'url'=>array('admin')),
);
?>

<h1>Create Medfirms</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>