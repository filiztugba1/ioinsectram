<?php
/* @var $this ConformitystatusController */
/* @var $model Conformitystatus */

$this->breadcrumbs=array(
	'Conformitystatuses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Conformitystatus', 'url'=>array('index')),
	array('label'=>'Create Conformitystatus', 'url'=>array('create')),
	array('label'=>'Update Conformitystatus', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Conformitystatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Conformitystatus', 'url'=>array('admin')),
);
?>

<h1>View Conformitystatus #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'isactive',
	),
)); ?>
