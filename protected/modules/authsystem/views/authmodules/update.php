<?php
/* @var $this AuthmodulesController */
/* @var $model Authmodules */

$this->breadcrumbs=array(
	'Authmodules'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Authmodules', 'url'=>array('index')),
	array('label'=>'Create Authmodules', 'url'=>array('create')),
	array('label'=>'View Authmodules', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Authmodules', 'url'=>array('admin')),
);
?>

<h1>Update Authmodules <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>