<?php
/* @var $this GeneralsettingsController */
/* @var $model Generalsettings */

$this->breadcrumbs=array(
	'Generalsettings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Generalsettings', 'url'=>array('index')),
	array('label'=>'Manage Generalsettings', 'url'=>array('admin')),
);
?>

<h1>Create Generalsettings</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>