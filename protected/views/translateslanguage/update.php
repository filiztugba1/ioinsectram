<?php
/* @var $this TranslateslanguageController */
/* @var $model Translateslanguage */

$this->breadcrumbs=array(
	'Translateslanguages'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Translateslanguage', 'url'=>array('index')),
	array('label'=>'Create Translateslanguage', 'url'=>array('create')),
	array('label'=>'View Translateslanguage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Translateslanguage', 'url'=>array('admin')),
);
?>

<h1>Update Translateslanguage <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>