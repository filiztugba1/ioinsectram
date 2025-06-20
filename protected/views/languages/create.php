<?php
/* @var $this LanguagesController */
/* @var $model Languages */

$this->breadcrumbs=array(
	'Languages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="fa fa-search"></i> Ön İzleme', 'url'=>array('view', 'id'=>$model->id),'itemOptions'=>array('class'=>'li_style')),	
	array('label'=>'<i class="fa fa-plus"></i>Ekle', 'url'=>array('create'),'active'=>Yii::app()->controller->action->id=='create','itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-sign-out"></i>Listele', 'url'=>array('admin'),'itemOptions'=>array('class'=>'li_style')),
	
);
?>

<h1 class="baslik_h1">Create Languages</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>