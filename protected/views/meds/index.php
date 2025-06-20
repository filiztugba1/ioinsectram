<?php
/* @var $this MedsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Meds',
);

$this->menu=array(
	array('label'=>'Create Meds', 'url'=>array('create')),
	array('label'=>'Manage Meds', 'url'=>array('admin')),
);
?>

<h1>Meds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
