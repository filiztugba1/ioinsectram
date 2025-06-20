<?php
/* @var $this DefaultController */
/* @var $model Leftmenu */

$this->breadcrumbs=array(
	'Leftmenus'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Leftmenu', 'url'=>array('index')),
	array('label'=>'Manage Leftmenu', 'url'=>array('admin')),
);
?>

<h1>Create Leftmenu</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>