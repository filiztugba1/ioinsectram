<?php
/* @var $this ConformityactivityController */
/* @var $model Conformityactivity */

$this->breadcrumbs=array(
	'Conformityactivities'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Conformityactivity', 'url'=>array('index')),
	array('label'=>'Create Conformityactivity', 'url'=>array('create')),
	array('label'=>'View Conformityactivity', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Conformityactivity', 'url'=>array('admin')),
);
?>

<h1>Update Conformityactivity <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>