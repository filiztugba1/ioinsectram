<?php
/* @var $this TranslateslanguageController */
/* @var $model Translateslanguage */

$this->breadcrumbs=array(
	'Translateslanguages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Translateslanguage', 'url'=>array('index')),
	array('label'=>'Manage Translateslanguage', 'url'=>array('admin')),
);
?>

<h1>Create Translateslanguage</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>