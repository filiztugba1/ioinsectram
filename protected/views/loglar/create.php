<?php
/* @var $this LoglarController */
/* @var $model Loglar */

$this->breadcrumbs=array(
	'Loglars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Loglar', 'url'=>array('index')),
	array('label'=>'Manage Loglar', 'url'=>array('admin')),
);
?>

<h1>Create Loglar</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>