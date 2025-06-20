<?php
/* @var $this StokkimyasalkullanimController */
/* @var $model Stokkimyasalkullanim */

$this->breadcrumbs=array(
	'Stokkimyasalkullanims'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Stokkimyasalkullanim', 'url'=>array('index')),
	array('label'=>'Manage Stokkimyasalkullanim', 'url'=>array('admin')),
);
?>

<h1>Create Stokkimyasalkullanim</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>