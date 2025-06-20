<?php
/* @var $this VisittypeController */
/* @var $model Visittype */

$this->breadcrumbs=array(
	'Visittypes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Visittype', 'url'=>array('index')),
	array('label'=>'Create Visittype', 'url'=>array('create')),
	array('label'=>'View Visittype', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Visittype', 'url'=>array('admin')),
);
?>

<h1>Update Visittype <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>