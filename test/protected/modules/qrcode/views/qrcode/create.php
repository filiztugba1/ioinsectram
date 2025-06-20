<?php
/* @var $this QrcodeController */
/* @var $model Qrcode */

$this->breadcrumbs=array(
	'Qrcodes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Qrcode', 'url'=>array('index')),
	array('label'=>'Manage Qrcode', 'url'=>array('admin')),
);
?>

<h1>Create Qrcode</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>