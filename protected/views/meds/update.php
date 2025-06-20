<?php
/* @var $this MedsController */
/* @var $model Meds */

$this->breadcrumbs=array(
	'Meds'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Meds', 'url'=>array('index')),
	array('label'=>'Create Meds', 'url'=>array('create')),
	array('label'=>'View Meds', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Meds', 'url'=>array('admin')),
);
?>

<h1>Update Meds <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>