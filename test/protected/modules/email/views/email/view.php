<?php if (Yii::app()->user->checkAccess('email.sending.view')){

	?>

	<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('E-Mail Us');?></h4>
						</div>
					
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
				  <form id="email-form" action="" method="post">

				  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Subject');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Subject');?>" name="Email[subject]" requred>
                        </fieldset>
                    </div>

				
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Message');?></label>
							<fieldset class="form-group">
							 <textarea class="ckeditor" id="editor" name="Email[message]" placeholder="Email message"></textarea>
							
							</fieldset>
					</div>

				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit"><?=t('Send');?></button>
						</div>
                        </fieldset>
                    </div>
				</div>

				</form>
				

                



                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

		<?php }?>

	<?php Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/ckeditor/ckeditor.js;';?>