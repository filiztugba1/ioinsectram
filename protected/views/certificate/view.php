<?php
/* @var $this CertificateController */
/* @var $model Certificate */

$this->breadcrumbs=array(
	'Certificates'=>array('index'),
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

<h1>View Certificate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	  'htmlOptions'=>array(
            'class'=>'table table-xl mb-0'
        ),
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
