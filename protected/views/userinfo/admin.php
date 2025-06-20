<?php
/* @var $this UserinfoController */
/* @var $model Userinfo */

$this->breadcrumbs=array(
	'Userinfos'=>array('index'),
	'Manage',
);

if (Yii::app()->user->checkAccess('userinfo.create')){

$this->menu=array(
	array('label'=>'<i class="fa fa-search"></i> Ön İzleme', 'url'=>array('view', 'id'=>$model->id),'itemOptions'=>array('class'=>'li_style')),	
	array('label'=>'<i class="fa fa-plus"></i>Ekle', 'url'=>array('create'),'itemOptions'=>array('class'=>'li_style')),
	array('label'=>'<i class="fa fa-sign-out"></i>Listele', 'url'=>array('admin'),'active'=>Yii::app()->controller->action->id=='admin','itemOptions'=>array('class'=>'li_style')),
	
);
}
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#userinfo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="baslik_h1">Manage Userinfos</h1>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(
	//'model'=>$model,
// )); ?>
</div>
--><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'userinfo-grid',
	'itemsCssClass'=>'table table-striped table-bordered column-selector dataTable',
        'pagerCssClass'=>'dataTables_paginate paging_simple_numbers',
        'pager'=>array(
            'id'=>'DataTables_Table_3_paginate',
            'htmlOptions'=>array(
                'class'=>'pagination',
            ),
            'header'=>'',
            'firstPageLabel'=>'İlk',
            'prevPageLabel'=>'',
            'nextPageLabel'=>'',
            'lastPageLabel'=>'Son',
            
        ),
        'summaryText'=>'',
        'rowCssClass'=>array('odd gredeX','even gredeC'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		 array(
                   'id'=>'id',
					'class'=>'CCheckBoxColumn',
					'selectableRows' => '50',
                ),
		'userid',
		'identification_number',
		'birthplace',
		'birthdate',
		'gender',
		/*
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
		*/
		 array
                    (
                        'class'=>'CButtonColumn',
                        'afterDelete'=>'function(link,success,data){
                            reloadGrid();
                         }',
                        'template'=>'{update}{view}{delete}',
                        'buttons'=>array
                        (
                            'update' => array
                            (
                                'label'=>'<i class="fa fa-edit"></i>',
                                'imageUrl'=>false,
                                'options'=>array('class'=>'btn btn-success btn-icon btn-sm','style'=>'width: 28px;'),
                            ),
                           'view' => array
                            (
                                'label'=>'<i class="fa fa-search"></i>',
                                'imageUrl'=>false,
                                'options'=>array('class'=>'btn btn-primary btn-icon btn-sm','style'=>'width: 28px;'),
                            ),
                             'delete' => array
                            (
                                'label'=>'<i class="fa fa-trash"></i>',
                                'imageUrl'=>false,
                                'options'=>array('class'=>'btn btn-danger btn-icon btn-sm','style'=>'width: 28px;'),
                            ),
							
                        ),
                    ),
	),
)); ?>
