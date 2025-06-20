<?php
/* @var $this DepartmentvisitedController */
/* @var $model Departmentvisited */

$this->breadcrumbs=array(
	'Departmentvisiteds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Departmentvisited', 'url'=>array('index')),
	array('label'=>'Create Departmentvisited', 'url'=>array('create')),
	array('label'=>'Update Departmentvisited', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Departmentvisited', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Departmentvisited', 'url'=>array('admin')),
);
?>

<h1>View Departmentvisited #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'treatmenttypeid',
		'monitoringpoint',
		'departmentid',
		'subdepartmentid',
		'monitoringpointid',
	),
)); ?>
