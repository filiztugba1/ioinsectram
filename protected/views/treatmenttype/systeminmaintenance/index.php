<?php
/* @var $this SysteminmaintenanceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Systeminmaintenances',
);

$this->menu=array(
	array('label'=>'Create Systeminmaintenance', 'url'=>array('create')),
	array('label'=>'Manage Systeminmaintenance', 'url'=>array('admin')),
);
?>

<h1>Systeminmaintenances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
