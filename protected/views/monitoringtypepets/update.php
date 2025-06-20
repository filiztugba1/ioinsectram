<?php
/* @var $this MonitoringtypepetsController */
/* @var $model Monitoringtypepets */

$this->breadcrumbs=array(
	'Monitoringtypepets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Monitoringtypepets', 'url'=>array('index')),
	array('label'=>'Create Monitoringtypepets', 'url'=>array('create')),
	array('label'=>'View Monitoringtypepets', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Monitoringtypepets', 'url'=>array('admin')),
);
?>

<h1>Update Monitoringtypepets <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>