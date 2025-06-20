<?php
/* @var $this UserinfoController */
/* @var $model Userinfo */

$this->breadcrumbs=array(
	'Userinfos'=>array('admin'),
	$model->id,
);


$this->menu=array(
	array('label'=>'<i class="fa fa-search"></i> Ön İzleme', 'url'=>array('view', 'id'=>$model->id),'active'=>Yii::app()->controller->action->id=='view','itemOptions'=>array('class'=>'li_style')),	
	array('label'=>'<i class="fa fa-plus"></i>Ekle', 'url'=>array('create'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-pencil"></i>Güncelle', 'url'=>array('update', 'id'=>$model->id),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-times"></i>Sil', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-sign-out"></i>Listele', 'url'=>array('admin'),'itemOptions'=>array('class'=>'li_style')),
	
);


?>

<h1 class="baslik_h1">View Userinfo <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	  'htmlOptions'=>array(
            'class'=>'table table-xl mb-0'
        ),
	'attributes'=>array(
		'id',
		'userid',
		'identification_number',
		'birthplace',
		'birthdate',
		'gender',
		'primaryphone',
		'secondaryphone',
		'country',
		'marital',
		'children',
		'address',
		'address_country',
		'address_city',
		'blood',
		'driving_licance',
		'driving_licance_date',
		'military',
		'educationid',
		'speaks',
		'certificate',
		'travel',
		'health_problem',
		'health_description',
		'smoking',
		'emergencyname',
		'emergencyphone',
		'leavedate',
		'leave_description',
		'referance',
		'projects',
		'computerskills',
	),
)); ?>
