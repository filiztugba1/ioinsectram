<?php
/* @var $this FirmController */
/* @var $model Firm */

$this->breadcrumbs=array(
	'Firms'=>array('admin'),
	$model->name,
);

	$this->menu=array(
	array('label'=>'<i class="fa fa-search"></i> Ön İzleme', 'url'=>array('view', 'id'=>$model->id),'active'=>Yii::app()->controller->action->id=='view','itemOptions'=>array('class'=>'li_style')),	
	array('label'=>'<i class="fa fa-plus"></i>Ekle', 'url'=>array('create'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-pencil"></i>Güncelle', 'url'=>array('update', 'id'=>$model->id),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-times"></i>Sil', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-sign-out"></i>Listele', 'url'=>array('admin'),'itemOptions'=>array('class'=>'li_style')),
	
);
?>

<h1 class="baslik_h1">View Firm <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'createdtime',
		'active',
	),
)); ?>
