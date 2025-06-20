<?php
/* @var $this StaffteamController */
/* @var $model Staffteam */

$this->breadcrumbs=array(
	'Staffteams'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Staffteam', 'url'=>array('index')),
	array('label'=>'Manage Staffteam', 'url'=>array('admin')),
);
?>

<h1>Create Staffteam</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>