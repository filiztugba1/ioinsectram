<?php
/* @var $this StokkimyasalkullanimController */
/* @var $model Stokkimyasalkullanim */

$this->breadcrumbs=array(
	'Stokkimyasalkullanims'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Stokkimyasalkullanim', 'url'=>array('index')),
	array('label'=>'Create Stokkimyasalkullanim', 'url'=>array('create')),
	array('label'=>'View Stokkimyasalkullanim', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Stokkimyasalkullanim', 'url'=>array('admin')),
);
?>

<h1>Update Stokkimyasalkullanim <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>