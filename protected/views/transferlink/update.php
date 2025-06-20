<?php
/* @var $this TransferlinkController */
/* @var $model transferlink */

$this->breadcrumbs=array(
	'Transferlinks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List transferlink', 'url'=>array('index')),
	array('label'=>'Create transferlink', 'url'=>array('create')),
	array('label'=>'View transferlink', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage transferlink', 'url'=>array('admin')),
);
?>

<h1>Update transferlink <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>