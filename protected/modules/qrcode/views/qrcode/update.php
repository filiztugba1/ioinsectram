<?php
/* @var $this QrcodeController */
/* @var $model Qrcode */

$this->breadcrumbs=array(
	'Qrcodes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Qrcode', 'url'=>array('index')),
	array('label'=>'Create Qrcode', 'url'=>array('create')),
	array('label'=>'View Qrcode', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Qrcode', 'url'=>array('admin')),
);
?>

<h1>Update Qrcode <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>