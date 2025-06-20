<?php
/* @var $this ConformityactivityController */
/* @var $model Conformityactivity */

$this->breadcrumbs=array(
	'Conformityactivities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Conformityactivity', 'url'=>array('index')),
	array('label'=>'Manage Conformityactivity', 'url'=>array('admin')),
);
?>

<h1>Create Conformityactivity</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>