<?php
/* @var $this CronController */
/* @var $model Cron */

$this->breadcrumbs=array(
	'Crons'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cron', 'url'=>array('index')),
	array('label'=>'Create Cron', 'url'=>array('create')),
	array('label'=>'View Cron', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cron', 'url'=>array('admin')),
);
?>

<h1>Update Cron <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>