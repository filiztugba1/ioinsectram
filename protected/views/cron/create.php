<?php
/* @var $this CronController */
/* @var $model Cron */

$this->breadcrumbs=array(
	'Crons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cron', 'url'=>array('index')),
	array('label'=>'Manage Cron', 'url'=>array('admin')),
);
?>

<h1>Create Cron</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>