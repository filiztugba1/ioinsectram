<?php
/* @var $this GeneralsettingsController */
/* @var $model Generalsettings */

$this->breadcrumbs=array(
	'Generalsettings'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Generalsettings', 'url'=>array('index')),
	array('label'=>'Create Generalsettings', 'url'=>array('create')),
	array('label'=>'View Generalsettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Generalsettings', 'url'=>array('admin')),
);
?>

<h1>Update Generalsettings <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>