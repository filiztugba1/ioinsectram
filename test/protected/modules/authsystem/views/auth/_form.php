<?php
/* @var $this AuthController */
/* @var $model AuthItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'auth-item-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
		<div class="col-xl-4 col-lg-6 col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create a Permission Type</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
					
						<fieldset>
							<div class="input-group">
							<?php echo $form->textField($model,'name',array('maxlength'=>64,'placeholder'=>'clients.index etc.', 'class'=>'form-control')); ?>
								<div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->