<?php
/* @var $this VisittypeController */
/* @var $model Visittype */

$this->breadcrumbs=array(
	'Visittypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Visittype', 'url'=>array('index')),
	array('label'=>'Manage Visittype', 'url'=>array('admin')),
);
?>

<h1>Create Visittype</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>