<?php
/* @var $this PetsController */
/* @var $model Pets */

$this->breadcrumbs=array(
	'Pets'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pets', 'url'=>array('index')),
	array('label'=>'Create Pets', 'url'=>array('create')),
	array('label'=>'View Pets', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pets', 'url'=>array('admin')),
);
?>

<h1>Update Pets <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>