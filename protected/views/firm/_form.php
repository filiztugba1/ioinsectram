<?php
/* @var $this FirmController */
/* @var $model Firm */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'firm-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>



	<?php echo $form->errorSummary($model); ?>

	<div class="row" style="margin-top:30px;">
		<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
			<?php Sector::model()->forminput('Name',array('name'=>'name', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Name','id'=>'name','type'=>'text','value'=>$model->name,));?>
		</div>
		<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
			<?php Sector::model()->forminput('Created Time',array('name'=>'createdtime', 'size'=>'60','maxlength'=>'128','class'=>'form-control','placeholder'=>'Created Time','id'=>'name','type'=>'date','value'=>$model->createdtime,));?>
		</div>
	
		<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
			<?php Sector::model()->formselect('Active',array('name'=>'active', 'size'=>'','maxlength'=>'','class'=>'form-control','placeholder'=>'','id'=>'basicSelect','type'=>'select','value'=>$model->active,),
														  array('active','passive')
														);?>
		</div>
	
	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                            <fieldset class="form-group" style="margin-top:0px;padding-top:0px;">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-success mr-1')); ?>
							</fieldset>
        </div>	
				
	
	</div>

	

		

<?php $this->endWidget(); ?>

</div><!-- form -->