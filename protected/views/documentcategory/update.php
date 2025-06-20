<?php
/* @var $this DocumentcategoryController */
/* @var $model Documentcategory */

$this->breadcrumbs=array(
	'Documentcategories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Documentcategory', 'url'=>array('index')),
	array('label'=>'Create Documentcategory', 'url'=>array('create')),
	array('label'=>'View Documentcategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Documentcategory', 'url'=>array('admin')),
);
?>

<h1>Update Documentcategory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>