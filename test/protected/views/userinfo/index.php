	<?php 
	User::model()->login();
	$ax= User::model()->userobjecty('');
	
	$userinfo=Userinfo::model()->findAll(array(
								   'condition'=>'userid='.$_GET['id'],
							   ));
                  
						?>
	<?php if (Yii::app()->user->checkAccess('staff.detail.update')){ ?>		
        <!-- Form wizard with number tabs section start -->
        <section id="number-tabs">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"><?=t('Userinfo Update');?></h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-h font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
				 
                    <form id="userinfo-form" action="/userinfo/update/0" method="post" class="number-tab-steps wizard-circle">
                      <!-- Step 1 -->
                      <h6><?=t('Step');?> 1</h6>
                      <fieldset>
                        <div class="row">
                      
					<?php foreach($userinfo as $userinfos):?>
						
					<input type="hidden" class="form-control" id="basicInput" value="<?=$userinfos->id;?>" name="Userinfo[id]">
                      
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Identification Number');?></label>
                          <input type="text" class="form-control" id="basicInput" value="<?=$userinfos->identification_number;?>" placeholder="<?=t('Identification Number');?>" name="Userinfo[identification_number]">
                        </fieldset>
                    </div>
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Birth Place');?></label>
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Birth Place');?>" value="<?=$userinfos->birthplace;?>" name="Userinfo[birthplace]">
                        </fieldset>
                    </div>
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Birth Date');?></label>
                          <input type="date" class="form-control" id="basicInput" placeholder="<?=t('Birth Date');?>" value="<?=$userinfos->birthdate;?>" name="Userinfo[birthdate]">
                        </fieldset>
                    </div>
					
							
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Leave Date');?></label>
                          <input type="date" class="form-control" id="basicInput" placeholder="<?=t('Leave Date');?>" value="<?=$userinfos->leavedate;?>" name="Userinfo[leavedate]">
                        </fieldset>
                    </div>
					
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Leave Description');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Leave Description');?>" name="Userinfo[leave_description]"><?=$userinfos->leave_description;?></textarea>
                        </fieldset>
                    </div>
					
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Referance');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Referance');?>"  name="Userinfo[referance]"><?=$userinfos->referance;?></textarea>
                        </fieldset>
                    </div>
					
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Projects');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Projects');?>"  name="Userinfo[projects]"><?=$userinfos->projects;?></textarea>
                        </fieldset>
                    </div>
                        </div>
                    
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><?=t('Step');?> 2</h6>
                      <fieldset>
                        <div class="row">
                      
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Gender');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[gender]">
								  <option value="1" <?php if($userinfos->gender==1){ echo "selected";}?>><?=t('Mr');?></option>
								  <option value="0" <?php if($userinfos->gender==0){ echo "selected";}?>><?=t('Mrs');?></option>
								  </select>
                        </fieldset>
					</div>
					
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Primary Phone');?></label>
                          <input type="number" class="form-control" id="basicInput" placeholder="<?=t('Primary Phone');?>" value="<?=$userinfos->primaryphone;?>" name="Userinfo[primaryphone]">
                        </fieldset>
                    </div>
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Secondary Phone');?></label>
                          <input type="number" class="form-control" id="basicInput" placeholder="<?=t('Secondary Phone');?>" value="<?=$userinfos->secondaryphone;?>" name="Userinfo[secondaryphone]">
                        </fieldset>
                    </div>
							
							
						<?php    $location=Location::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=0',
							   ));
                  
						?>
							
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								<label for="basicSelect"><?=t('Country');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[country]">
								  <?php foreach($location as $locations):?>
								  <option value="<?=$locations->id;?>" <?php if($userinfos->country==$locations->id){echo "selected";}?>><?=$locations->name;?></option>
								  <?php endforeach;?>
								  </select>
                        </fieldset>
					</div>
					
					
					
					
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Computerskills');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[computerskills]">
								  <option><?=t('Select');?></option>
								  <option value="1" <?php if($userinfos->computerskills==1){echo "selected";}?>><?=t('Yes');?></option>
								  <option value="0" <?php if($userinfos->computerskills==0){echo "selected";}?>><?=t('No');?></option>
								  </select>
								</fieldset>
						</div>
						
						
							
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Emergency Name');?></label>
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Emergency Name');?>" value="<?=$userinfos->emergencyname;?>" name="Userinfo[emergencyname]">
                        </fieldset>
                    </div>
					
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Emergency Phone');?></label>
                          <input type="number" class="form-control" id="basicInput" placeholder="<?=t('Emergency Phone');?>" value="<?=$userinfos->emergencyphone;?>" name="Userinfo[emergencyphone]">
                        </fieldset>
                    </div>
                       
                        </div>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><?=t('Step');?> 3</h6>
                      <fieldset>
                        <div class="row">
                     
                   <div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								<label for="basicSelect"><?=t('Marital');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[marital]">
								  <option value="1" <?php if($userinfos->marital==1){echo "selected";}?>><?=t('Married');?></option>
								  <option value="0" <?php if($userinfos->marital==0){echo "selected";}?>><?=t('Single');?></option>
								  </select>
								</fieldset>
							</div>
							
							
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Children');?></label>
                          <input type="number" class="form-control" id="basicInput" placeholder="Children" value="<?=$userinfos->children;?>" name="Userinfo[children]">
                        </fieldset>
                    </div>
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
							<label for="basicSelect"><?=t('Address');?></label>
                          <input type="text" class="form-control" id="basicInput" placeholder="Address" value="<?=$userinfos->address;?>" name="Userinfo[address]">
                        </fieldset>
                    </div>
					
					
					<?php    $location4=Location::model()->findAll();?>
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								<label for="basicSelect"><?=t('Address Country');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[address_country]">
								  <?php foreach($location4 as $locat):?>
								  <option value="<?=$locat->id;?>" <?php if($userinfos->address_country==$locat->id){echo "selected";}?>><?=$locat->name;?></option>
								  <?php endforeach;?>
								  </select>
                        </fieldset>
					</div>
					
						<?php    $location2=Location::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid!=0',
							   ));
                  
						?>
							
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								<label for="basicSelect"><?=t('Address City');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[address_city]">
								  <?php foreach($location2 as $location3):?>
								  <option value="<?=$location3->id;?>" <?php if($userinfos->address_city==$location3->id){echo "selected";}?>><?=$location3->name;?></option>
								  <?php endforeach;?>
								  </select>
                        </fieldset>
					</div>
					
					
					
								<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Blood');?></label>
                          <input type="text" class="form-control" id="basicInput" placeholder="Blood" value="<?=$userinfos->blood;?>" name="Userinfo[blood]">
                        </fieldset>
                    </div>
					
					
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								<label for="basicSelect"><?=t('Driving Licance');?></label>
								  <select class="form-control" id="basicSelect" name="driving_licance" >
								  <option value="1" <?php if($userinfos->driving_licance==1){echo "selected";}?>><?=t('Yes');?></option>
								  <option value="0" <?php if($userinfos->driving_licance==0){echo "selected";}?>><?=t('No');?></option>
								  </select>
								</fieldset>
						</div>
					
							
				
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Driving Licance Date');?></label>
                          <input type="date" class="form-control" id="basicInput" placeholder="<?=t('Driving Licance Date');?>" value="<?=$userinfos->driving_licance_date;?>" name="Userinfo[driving_licance_date]">
                        </fieldset>
                    </div>
					
					
					
                        </div>
                      </fieldset>
                      <!-- Step 4 -->
                      <h6><?=t('Step');?> 4</h6>
                      <fieldset>
                        <div class="row">
                       
					   
					   		
		
					
					
				<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Military');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[military]" >
								  <option>Select</option>
								  <option value="1" <?php if($userinfos->military==1){echo "selected";}?>><?=t('Yes');?></option>
								  <option value="0" <?php if($userinfos->military==0){echo "selected";}?>><?=t('No');?></option>
								  </select>
								</fieldset>
						</div>
						
				
					<?php $education=  Education::model()->findAll();
						?>
						
						<?php $language=  Languages::model()->findAll();
						?>
						
						<?php $certificate=  Certificate::model()->findAll();
						?>
						
						
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Education');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[educationid]"  >
								  <?php foreach ($education as $educationx):?>
								  <option value="<?=$educationx->id;?>" <?php if($userinfos->educationid==$educationx->id){echo "selected";}?>><?=$educationx->name;?></option>
								  <?php endforeach;?>
								  </select>
								</fieldset>
						</div>
						
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Speaks');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[speaks]"  >
								  <?php foreach ($language as $languagex):?>
								  <option value="<?=$languagex->id;?>" <?php if($userinfos->speaks==$languagex->id){echo "selected";}?>><?php echo $languagex->name;?></option>
								  <?php endforeach;?>
								  </select>
								</fieldset>
							</div>
							
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Certificate');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[certificate]"  >
								  <?php foreach ($certificate as $certificatex):?>
								  <option value="<?=$certificatex->id;?>" <?php if($userinfos->certificate==$certificatex->id){echo "selected";}?>><?=$certificatex->name;?></option>
								  <?php endforeach;?>
								  </select>
								</fieldset>
							</div>
							
							
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Travel');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[travel]" >
								  <option value="1" <?php if($userinfos->travel==1){echo "selected";}?>><?=t('Yes');?></option>
								  <option value="0" <?php if($userinfos->travel==0){echo "selected";}?>><?=t('No');?></option>
								  </select>
								</fieldset>
						</div>
						
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Health Problem');?></label>
								  <select class="form-control" id="basicSelect" name="Userinfo[health_problem]" >
								  <option>Select</option>
								  <option value="1" <?php if($userinfos->health_problem==1){echo "selected";}?>><?=t('Yes');?></option>
								  <option value="0" <?php if($userinfos->health_problem==0){echo "selected";}?>><?=t('No');?></option>
								  </select>
								</fieldset>
						</div>
						
					
					
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Health Description');?></label>
                          <textarea class="form-control" name="Userinfo[health_description]"><?=$userinfos->health_description;?></textarea>
                        </fieldset>
                    </div>
					
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<fieldset class="form-group">
								  <label for="basicSelect"><?=t('Smoking');?></label>
								  <select class="form-control" id="basicSelect" name="smoking">
								  <option value="1" <?php if($userinfos->smoking==1){echo "selected";}?>><?=t('Yes');?></option>
								  <option value="0" <?php if($userinfos->smoking==0){echo "selected";}?>><?=t('No');?></option>
								  </select>
								</fieldset>
						</div>
						
						
					
				<?endforeach;?>
					
                         
                        </div>
                      </fieldset>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		
		
		
<?php }?>
		
		
        <!-- Form wizard with number tabs section end -->
      
      
       
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 <script src="<?=Yii::app()->theme->baseUrl;?>/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
  <script>
$(".number-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: '<?=t('Submit')?>',
        next: "<?=t('Next')?>",
        previous: "<?=t('Previous')?>",
    },
    onFinished: function (event, currentIndex) {
		$('#userinfo-form').submit();
        // alert("Form submittedx.");
    }
});
</script>
  <?php
//Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/extensions/jquery.steps.min.js;';
//Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/wizard-steps.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/plugins/forms/wizard.css;';
?>