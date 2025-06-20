<?php
/* @var $this AuthmodulesController */
/* @var $model Authmodules */

$this->breadcrumbs=array(
	'Authmodules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Authmodules', 'url'=>array('index')),
	array('label'=>'Manage Authmodules', 'url'=>array('admin')),
);
?>

<h1>Create Authmodules</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>