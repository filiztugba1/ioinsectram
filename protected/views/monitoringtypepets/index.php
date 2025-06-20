<?php
/* @var $this MonitoringtypepetsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Monitoringtypepets',
);

$this->menu=array(
	array('label'=>'Create Monitoringtypepets', 'url'=>array('create')),
	array('label'=>'Manage Monitoringtypepets', 'url'=>array('admin')),
);
?>

<h1>Monitoringtypepets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
