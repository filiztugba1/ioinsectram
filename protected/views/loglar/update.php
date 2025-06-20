<?php
/* @var $this LoglarController */
/* @var $model Loglar */

$this->breadcrumbs=array(
	'Loglars'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Loglar', 'url'=>array('index')),
	array('label'=>'Create Loglar', 'url'=>array('create')),
	array('label'=>'View Loglar', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Loglar', 'url'=>array('admin')),
);
?>

<h1>Update Loglar <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>