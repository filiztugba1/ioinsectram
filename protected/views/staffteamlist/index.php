<?php
/* @var $this StaffteamlistController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staffteamlists',
);

$this->menu=array(
	array('label'=>'Create Staffteamlist', 'url'=>array('create')),
	array('label'=>'Manage Staffteamlist', 'url'=>array('admin')),
);
?>

<h1>Staffteamlists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
