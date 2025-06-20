<?php
/* @var $this MedfirmsController */
/* @var $model Medfirms */

$this->breadcrumbs=array(
	'Medfirms'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Medfirms', 'url'=>array('index')),
	array('label'=>'Create Medfirms', 'url'=>array('create')),
	array('label'=>'View Medfirms', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Medfirms', 'url'=>array('admin')),
);
?>

<h1>Update Medfirms <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>