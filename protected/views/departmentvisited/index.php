<?php
/* @var $this DepartmentvisitedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Departmentvisiteds',
);

$this->menu=array(
	array('label'=>'Create Departmentvisited', 'url'=>array('create')),
	array('label'=>'Manage Departmentvisited', 'url'=>array('admin')),
);
?>

<h1>Departmentvisiteds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
