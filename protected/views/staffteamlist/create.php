<?php
/* @var $this StaffteamlistController */
/* @var $model Staffteamlist */

$this->breadcrumbs=array(
	'Staffteamlists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Staffteamlist', 'url'=>array('index')),
	array('label'=>'Manage Staffteamlist', 'url'=>array('admin')),
);
?>

<h1>Create Staffteamlist</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>