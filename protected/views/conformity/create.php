<?php
/* @var $this ConformityController */
/* @var $model Conformity */

$this->breadcrumbs=array(
	'Conformities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Conformity', 'url'=>array('index')),
	array('label'=>'Manage Conformity', 'url'=>array('admin')),
);
?>

<h1>Create Conformity</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>