<?php
/* @var $this ConformitytypeController */
/* @var $model Conformitytype */

$this->breadcrumbs=array(
	'Conformitytypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Conformitytype', 'url'=>array('index')),
	array('label'=>'Manage Conformitytype', 'url'=>array('admin')),
);
?>

<h1>Create Conformitytype</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>