<?php
/* @var $this DepartmentvisitedController */
/* @var $model Departmentvisited */

$this->breadcrumbs=array(
	'Departmentvisiteds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Departmentvisited', 'url'=>array('index')),
	array('label'=>'Manage Departmentvisited', 'url'=>array('admin')),
);
?>

<h1>Create Departmentvisited</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>