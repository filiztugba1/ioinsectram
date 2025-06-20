<?php
/* @var $this DocumentcategoryController */
/* @var $model Documentcategory */

$this->breadcrumbs=array(
	'Documentcategories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Documentcategory', 'url'=>array('index')),
	array('label'=>'Create Documentcategory', 'url'=>array('create')),
	array('label'=>'Update Documentcategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Documentcategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Documentcategory', 'url'=>array('admin')),
);
?>

<h1>View Documentcategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
