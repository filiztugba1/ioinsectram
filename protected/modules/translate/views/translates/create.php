<?php $translatelanguages=Translatelanguages::model()->findAll();	?>
	<?php $translates=Translates::model()->findAll(array('condition'=>'code="en"'));	?>
	<div class="col-xl-12 col-lg-12 col-md-12">
				
			<div class="card">
			     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('New Tag Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>	
						</div>
					 </div>
					 
				<form id="translates-form" action="/translate/translates/create" method="post">
				<div class="card-content">
					<div class="card-body">
					
					
					<div class="row">
					
						<div class="col-xl-12 col-lg-12 col-md-12 ">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1"><?=t('Tag');?></div>
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<fieldset class="form-group">
								  <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Tag');?>" name="title" required="required">
								</fieldset>
							</div>
						</div>
				
					
					
				<?foreach($translatelanguages as $translatet){?>
				
					<div class="col-xl-12 col-lg-12 col-md-12 ">
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1"><?=$translatet->name?></div>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<fieldset class="form-group">
							 <textarea class="ckeditor" id="editor<?=$translatet->name?>" name="<?=$translatet->name?>" placeholder="Translate value"></textarea>
                        <script>
						CKEDITOR.replace( 'editor<?=$translatet->name?>',
                              {
                                toolbar : 'MyToolbar'
                              });
                        </script>
							 	</fieldset>
						</div>
					</div>
				<?php }?>
				
					</div>
					
					
					  	<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
                    </div>
					  </div>
				
						
						
					</div>
				</div>
			</form>
			</div>
		
	</div><!-- form -->
	
		<?php
	Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/ckeditor/ckeditor.js;';
	?>