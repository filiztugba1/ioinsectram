<?php
/* @var $this ConformitystatusController */
/* @var $model Conformitystatus */

$this->breadcrumbs=array(
	'Conformitystatuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Conformitystatus', 'url'=>array('index')),
	array('label'=>'Manage Conformitystatus', 'url'=>array('admin')),
);
?>

<h1>Create Conformitystatus</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>