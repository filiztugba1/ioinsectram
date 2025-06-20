<?php
/* @var $this TransferlinkController */
/* @var $model transferlink */

$this->breadcrumbs=array(
	'Transferlinks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List transferlink', 'url'=>array('index')),
	array('label'=>'Manage transferlink', 'url'=>array('admin')),
);
?>

<h1>Create transferlink</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>