<?php
/* @var $this ConformityuserassignController */
/* @var $model Conformityuserassign */

$this->breadcrumbs=array(
	'Conformityuserassigns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Conformityuserassign', 'url'=>array('index')),
	array('label'=>'Create Conformityuserassign', 'url'=>array('create')),
	array('label'=>'View Conformityuserassign', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Conformityuserassign', 'url'=>array('admin')),
);
?>

<h1>Update Conformityuserassign <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>