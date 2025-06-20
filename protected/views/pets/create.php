<?php
/* @var $this PetsController */
/* @var $model Pets */

$this->breadcrumbs=array(
	'Pets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pets', 'url'=>array('index')),
	array('label'=>'Manage Pets', 'url'=>array('admin')),
);
?>

<h1>Create Pets</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>