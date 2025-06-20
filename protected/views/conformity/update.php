<?php
/* @var $this ConformityController */
/* @var $model Conformity */

$this->breadcrumbs=array(
	'Conformities'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Conformity', 'url'=>array('index')),
	array('label'=>'Create Conformity', 'url'=>array('create')),
	array('label'=>'View Conformity', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Conformity', 'url'=>array('admin')),
);
?>

<h1>Update Conformity <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>