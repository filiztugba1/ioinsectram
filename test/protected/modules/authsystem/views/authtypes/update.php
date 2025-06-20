<?php
/* @var $this AuthtypesController */
/* @var $model Authtypes */

$this->breadcrumbs=array(
	'Authtypes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Authtypes', 'url'=>array('index')),
	array('label'=>'Create Authtypes', 'url'=>array('create')),
	array('label'=>'View Authtypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Authtypes', 'url'=>array('admin')),
);
?>

<h1>Update Authtypes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>