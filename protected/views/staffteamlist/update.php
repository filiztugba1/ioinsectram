<?php
/* @var $this StaffteamlistController */
/* @var $model Staffteamlist */

$this->breadcrumbs=array(
	'Staffteamlists'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Staffteamlist', 'url'=>array('index')),
	array('label'=>'Create Staffteamlist', 'url'=>array('create')),
	array('label'=>'View Staffteamlist', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Staffteamlist', 'url'=>array('admin')),
);
?>

<h1>Update Staffteamlist <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>