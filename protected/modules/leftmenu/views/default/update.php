<?php
/* @var $this DefaultController */
/* @var $model Leftmenu */

$this->breadcrumbs=array(
	'Leftmenus'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Leftmenu', 'url'=>array('index')),
	array('label'=>'Create Leftmenu', 'url'=>array('create')),
	array('label'=>'View Leftmenu', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Leftmenu', 'url'=>array('admin')),
);
?>

<h1>Update Leftmenu <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>