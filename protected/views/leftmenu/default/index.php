<?php
/* @var $this DefaultController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leftmenus',
);

$this->menu=array(
	array('label'=>'Create Leftmenu', 'url'=>array('create')),
	array('label'=>'Manage Leftmenu', 'url'=>array('admin')),
);
?>

<h1>Leftmenus</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
