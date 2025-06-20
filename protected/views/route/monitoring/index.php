<?php
/* @var $this MonitoringController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Monitorings',
);

$this->menu=array(
	array('label'=>'Create Monitoring', 'url'=>array('create')),
	array('label'=>'Manage Monitoring', 'url'=>array('admin')),
);
?>

<h1>Monitorings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
