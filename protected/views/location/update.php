<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="fa fa-plus"></i>Ekle', 'url'=>array('create'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-pencil"></i>Güncelle', 'url'=>array('update', 'id'=>$model->id),'active'=>Yii::app()->controller->action->id=='update','itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-times"></i>Sil', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-sign-out"></i>Listele', 'url'=>array('admin'),'itemOptions'=>array('class'=>'li_style')),	
);
?>

<h1 class="baslik_h1">Update Location <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>