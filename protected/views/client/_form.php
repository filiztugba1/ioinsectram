<?php
/* @var $this ClientController */
/* @var $model Client */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'client-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>



	<div class="row">
	
		<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
			<?php Sector::model()->forminput('Name',array('name'=>'name', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Name','id'=>'name','type'=>'text','value'=>$model->name,));?>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
			<?php Sector::model()->forminput('Title',array('name'=>'title', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Title','id'=>'title','type'=>'text','value'=>$model->title,));?>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
			<?php Sector::model()->forminput('Taxoffice',array('name'=>'taxoffice', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Taxoffice','id'=>'title','type'=>'text','value'=>$model->taxoffice,));?>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
			<?php Sector::model()->forminput('Taxno',array('name'=>'taxno', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Taxno','id'=>'title','type'=>'text','value'=>$model->taxno,));?>
		</div>
	
	
			<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                            <fieldset class="form-group">
							<label for="User_Username" class="col-lg-12 hidden-sm hidden-xs" style="padding-top:15px"></label> 
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-success mr-1')); ?>
							</fieldset>
        </div>	
		
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->