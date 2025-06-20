<?php
/* @var $this WorkorderController */
/* @var $model Workorder */

$this->breadcrumbs=array(
	'Workorders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Workorder', 'url'=>array('index')),
	array('label'=>'Create Workorder', 'url'=>array('create')),
	array('label'=>'View Workorder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Workorder', 'url'=>array('admin')),
);
?>

<h1>Update Workorder <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>