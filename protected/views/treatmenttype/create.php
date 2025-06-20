<?php
/* @var $this TreatmenttypeController */
/* @var $model Treatmenttype */

$this->breadcrumbs=array(
	'Treatmenttypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Treatmenttype', 'url'=>array('index')),
	array('label'=>'Manage Treatmenttype', 'url'=>array('admin')),
);
?>

<h1>Create Treatmenttype</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>