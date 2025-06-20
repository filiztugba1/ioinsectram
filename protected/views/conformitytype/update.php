<?php
/* @var $this ConformitytypeController */
/* @var $model Conformitytype */

$this->breadcrumbs=array(
	'Conformitytypes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Conformitytype', 'url'=>array('index')),
	array('label'=>'Create Conformitytype', 'url'=>array('create')),
	array('label'=>'View Conformitytype', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Conformitytype', 'url'=>array('admin')),
);
?>

<h1>Update Conformitytype <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>