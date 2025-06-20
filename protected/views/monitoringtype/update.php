<?php
/* @var $this MonitoringtypeController */
/* @var $model Monitoringtype */

$this->breadcrumbs=array(
	'Monitoringtypes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Monitoringtype', 'url'=>array('index')),
	array('label'=>'Create Monitoringtype', 'url'=>array('create')),
	array('label'=>'View Monitoringtype', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Monitoringtype', 'url'=>array('admin')),
);
?>

<h1>Update Monitoringtype <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>