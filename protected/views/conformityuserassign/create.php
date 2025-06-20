<?php
/* @var $this ConformityuserassignController */
/* @var $model Conformityuserassign */

$this->breadcrumbs=array(
	'Conformityuserassigns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Conformityuserassign', 'url'=>array('index')),
	array('label'=>'Manage Conformityuserassign', 'url'=>array('admin')),
);
?>

<h1>Create Conformityuserassign</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>