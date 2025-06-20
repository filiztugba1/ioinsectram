<?php
/* @var $this TreatmenttypeController */
/* @var $model Treatmenttype */

$this->breadcrumbs=array(
	'Treatmenttypes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Treatmenttype', 'url'=>array('index')),
	array('label'=>'Create Treatmenttype', 'url'=>array('create')),
	array('label'=>'View Treatmenttype', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Treatmenttype', 'url'=>array('admin')),
);
?>

<h1>Update Treatmenttype <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>