<?php
/* @var $this StaffteamController */
/* @var $model Staffteam */

$this->breadcrumbs=array(
	'Staffteams'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Staffteam', 'url'=>array('index')),
	array('label'=>'Create Staffteam', 'url'=>array('create')),
	array('label'=>'View Staffteam', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Staffteam', 'url'=>array('admin')),
);
?>

<h1>Update Staffteam <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>