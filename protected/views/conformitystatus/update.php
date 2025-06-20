<?php
/* @var $this ConformitystatusController */
/* @var $model Conformitystatus */

$this->breadcrumbs=array(
	'Conformitystatuses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Conformitystatus', 'url'=>array('index')),
	array('label'=>'Create Conformitystatus', 'url'=>array('create')),
	array('label'=>'View Conformitystatus', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Conformitystatus', 'url'=>array('admin')),
);
?>

<h1>Update Conformitystatus <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>