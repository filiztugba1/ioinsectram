<?php
/* @var $this MedsController */
/* @var $model Meds */

$this->breadcrumbs=array(
	'Meds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Meds', 'url'=>array('index')),
	array('label'=>'Manage Meds', 'url'=>array('admin')),
);
?>

<h1>Create Meds</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>