<?php
/* @var $this QrcodeController */
/* @var $model Qrcode */

$this->breadcrumbs=array(
	'Qrcodes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Qrcode', 'url'=>array('index')),
	array('label'=>'Create Qrcode', 'url'=>array('create')),
	array('label'=>'Update Qrcode', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Qrcode', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Qrcode', 'url'=>array('admin')),
);
?>

<h1>View Qrcode #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
