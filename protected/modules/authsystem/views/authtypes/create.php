<?php
/* @var $this AuthtypesController */
/* @var $model Authtypes */

$this->breadcrumbs=array(
	'Authtypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Authtypes', 'url'=>array('index')),
	array('label'=>'Manage Authtypes', 'url'=>array('admin')),
);
?>

<h1>Create Authtypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>