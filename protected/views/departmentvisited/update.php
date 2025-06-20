<?php
/* @var $this DepartmentvisitedController */
/* @var $model Departmentvisited */

$this->breadcrumbs=array(
	'Departmentvisiteds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Departmentvisited', 'url'=>array('index')),
	array('label'=>'Create Departmentvisited', 'url'=>array('create')),
	array('label'=>'View Departmentvisited', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Departmentvisited', 'url'=>array('admin')),
);
?>

<h1>Update Departmentvisited <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>