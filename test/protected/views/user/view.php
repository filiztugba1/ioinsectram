<?php
User::model()->login();
 $user=User::model()->findAll(array('condition'=>'id='.$_GET['id'],));
$userinfo=Userinfo::model()->findAll(array('condition'=>'id='.$_GET['id'],));
$id=0;





	?>


	  <?php $users=User::model()->find(array(
						   #'select'=>'title',
							'condition'=>'id=:id',
							'params'=>array(':id'=>$_GET['id']),
						));?>
		  <?php $usersinfo=Userinfo::model()->find(array(
						   #'select'=>'title',
							'condition'=>'id=:id',
							'params'=>array(':id'=>$_GET['id']),
						));?>

	<?php if (Yii::app()->user->checkAccess('staff.detail.view')){


		?>



	<section id="headers">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('Userinfo List');?></h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
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
                  <div class="card-body card-dashboard">
		<div class="row">
		<div class="col-xl-3 col-md-6 col-12">
            <div class="card">
              <div class="text-center">
                <div class="card-body">
				  <img src="<?php if($users->image!=''){echo Yii::app()->baseUrl.'/'.$users->image;}else {if($usersinfo->gender==0){ echo Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mr.png';}else{echo Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }}?>" class="rounded-circle  height-150" alt="User image">




                  <!-- <img src="<?=Yii::app()->theme->baseUrl.'/'?>app-assets/images/portrait/medium/avatar-m-4.png" class="rounded-circle  height-150"
                  alt="Card image">
				  -->
                </div>

				 <?php foreach($user as $userview){?>
                <div class="card-body">
                  <h4 class="card-title"><?=$userview->name.' '.$userview->surname;?></h4>
                  <h6 class="card-subtitle text-muted"><?php if($userview->type!='1'){
					 if($userview->ismaster==0){
					 echo t(Authtypes::model()->find(array('condition'=>'id='.$userview->type))->name);
					 }
					 else
					 {
						if(Authtypes::model()->find(array('condition'=>'id='.$userview->type))->authname=='Admin')
						 {
							echo t('Master Admin');
						}
						else
						 {
							echo t('Master Staff');
						}
					 }

					 
				 }else{echo t('Super Admin');}
				 ?></h6>

                </div>

				<?php }?>
               <!--
			   <div class="text-center">
                  <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
                    <span class="fa fa-facebook"></span>
                  </a>
                  <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                  <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin">
                    <span class="fa fa-linkedin font-medium-4"></span>
                  </a>
                </div>

				-->
              </div>
            </div>
          </div>




		      <div class="col-xl-9 col-lg-12">
              <div class="card">
                  <div class="card-content">
                  <div class="card-body">
                    <ul class="nav nav-tabs nav-underline">
                      <li class="nav-item">
                        <a class="nav-link active" id="baseIcon-tab21" data-toggle="tab" aria-controls="tabIcon21"
                        href="#tabIcon21" aria-expanded="true"><i class="fa fa-address-card"></i></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab22" data-toggle="tab" aria-controls="tabIcon22"
                        href="#tabIcon22" aria-expanded="false"><i class="fa fa-graduation-cap"></i></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="baseIcon-tab23" data-toggle="tab" aria-controls="tabIcon23"
                        href="#tabIcon23" aria-expanded="false"><i class="fa fa-suitcase"></i></a>
                      </li>

                    </ul>
                    <div class="tab-content px-1 pt-1">
                      <div role="tabpanel" class="tab-pane active" id="tabIcon21" aria-expanded="true"
                      aria-labelledby="baseIcon-tab21">

						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Name and Surname');?></h5><p style="color: #bdbdbd;"><?=$users->name.' '.$users->surname;?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Primary Phone');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->primaryphone;?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Secondary Phone');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->secondaryphone;?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('E-mail');?></h5><p style="color: #bdbdbd;"><?=$users->email;?></p></div>

						</div>

						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Birth Date');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->birthdate;?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Birth Place');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->birthplace;?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Identification Number');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->identification_number;?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Gender');?></h5><p style="color: #bdbdbd;"><?php if($usersinfo->gender==0){echo t('Not Gender');}
																	   if($usersinfo->gender==1){echo t('Gender');}?></p></div>

						</div>

						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Country');?></h5> <p style="color: #bdbdbd;"><?php $location=Location::model()->find(array(
																		   #'select'=>'title',
																			'condition'=>'id=:id',
																			'params'=>array(':id'=>$usersinfo->country),
																		));?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Married');?></h5><p style="color: #bdbdbd;"><?php if($usersinfo->marital==0){echo t('Single');}
																		if($usersinfo->marital==1){echo t('Married');}?></p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Children');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->children;?></p></div>

							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Blood');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->blood;?></p></div>




						</div>

						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Address');?></h5><p style="color: #bdbdbd;"><?=$usersinfo->address;?></p></div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Address City');?></h5><p style="color: #bdbdbd;">
							<?php $location=Location::model()->find(array(
								 #'select'=>'title',
								'condition'=>'id=:id',
								'params'=>array(':id'=>$usersinfo->address_city),
								));?></p></div>

						</div>

						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Military');?></h5><p style="color: #bdbdbd;">
							<?php if($usersinfo->military==0){echo t('No');}
								  if($usersinfo->military==1){echo t('Yes');}?>
							</p></div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Driving Licance');?></h5><p style="color: #bdbdbd;">
							<?php if($usersinfo->driving_licance==0){echo t('No');}
								  if($usersinfo->driving_licance==1){echo t('Yes');}?>
								  </p></div>




						</div>


						</div>


						 <div class="tab-pane" id="tabIcon22" aria-labelledby="baseIcon-tab22">



						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">
							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Education');?></h5><p style="color: #bdbdbd;">
									 <?php $education=Education::model()->find(array(
								   #'select'=>'title',
									'condition'=>'id=:id',
									'params'=>array(':id'=>$usersinfo->educationid),
									)); ?>
									<?=$education->name;?>
									</p>
							</div>

							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Speaks');?></h5><p style="color: #bdbdbd;">
										<?php $languages=Languages::model()->find(array(
											'condition'=>'id=:id',
											'params'=>array(':id'=>$usersinfo->speaks),
										));?>
											<?php if($languages){echo $languages->name;}?>
								</p>
							</div>

							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Computer Skills');?></h5><p style="color: #bdbdbd;">
							<?php if($usersinfo->computerskills==0){echo t('No');}
								  if($usersinfo->computerskills==1){echo t('Yes');}?>
								  </p>
							</div>


							<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Certificate');?></h5><p style="color: #bdbdbd;">
									<?php $certificate=Certificate::model()->find(array(
										'condition'=>'id=:id',
										'params'=>array(':id'=>$usersinfo->certificate),
									));?>
										<?php if($certificate){echo $certificate->name;}?>
									</p>
							</div>



						</div>

						<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">

								<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Referance');?></h5><p style="color: #bdbdbd;">
								<?=$usersinfo->referance;?></p>
							</div>

						</div>

							<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">



							<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Projects');?></h5><p style="color: #bdbdbd;">
									<?=$usersinfo->projects;?>
									</p>
						</div>

						</div>



                      </div>



					  <div class="tab-pane" id="tabIcon23" aria-labelledby="baseIcon-tab23">

							<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Travel');?></h5><p style="color: #bdbdbd;">
								<?php if($usersinfo->travel==0){echo t('No');}
								  if($usersinfo->travel==1){echo t('Yes');}?></p>
							</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Health Problem');?></h5><p style="color: #bdbdbd;">
								<?php if($usersinfo->health_problem==0){echo t('No');}
								  if($usersinfo->health_problem==1){echo t('Yes');}?></p>
							</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Health Description');?></h5><p style="color: #bdbdbd;">
								<?=$usersinfo->health_description;?></p>
							</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Smoking');?></h5><p style="color: #bdbdbd;">
								<?php if($usersinfo->smoking==0){echo t('No');}
								  if($usersinfo->smoking==1){echo t('Yes');}?></p>
							</div>

						</div>


								<div class="row" style="border-bottom: #d8d8d8 solid 1px; margin-top: 5px;margin-bottom: 14px;">

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Emergency Name');?></h5><p style="color: #bdbdbd;">
								<?=$usersinfo->emergencyname;?></p>
							</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Emergency Phone');?></h5><p style="color: #bdbdbd;">
								<?=$usersinfo->emergencyphone;?></p>
							</div>

								<div class="col-xl-3 col-lg-3 col-md-3 col-xs-12 col-sm-12" style="border-right: #d8d8d8 1px solid;"><h5><?=t('Leave Date');?></h5><p style="color: #bdbdbd;">
								<?=$usersinfo->leavedate;?></p>
							</div>



						</div>


                      </div>


                    </div>
                  </div>







						<?php if (Yii::app()->user->checkAccess('staff.update')){ ?>
					      <a  class="btn btn-primary" onclick="openmodal(this)"
							 data-id="<?=$users['id'];?>"
							 data-username="<?=$users['username'];?>"
							 data-name="<?=$users['name'];?>"
							 data-surname="<?=$users['surname'];?>"
							 data-email="<?=$users['email'];?>"
							 data-languageid="<?=$users['languageid'];?>" style="float:right;color:#fff;margin-left:5px;"
								  ><?=t('Update');?></a>

						<?php }?>

						<?php if (Yii::app()->user->checkAccess('staff.detail.update')){ ?>

					   <a href="<?=Yii::app()->baseUrl?>/userinfo/index/<?=$usersinfo->id;?>" class="btn btn-primary" style="float:right" type="submit"><?=t('Detail Update');?></a>

					   <?php }?>

                </div>

              </div>
            </div>


		 </div>
     </div>
                </div>
              </div>
            </div>
          </div>
        </section>


<?php if (Yii::app()->user->checkAccess('staff.detail.update')){ ?>

		<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('User Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="user-form2" action="/user/update/0" method="post" enctype="multipart/form-data">	
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modaluserid" name="User[id]" value="0">


				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('User Name');?></label>
                          <input type="text" class="form-control" id="modaluserusername" placeholder="<?=t('User Name');?>" name="User[username]">
                        </fieldset>
                    </div>



					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('Password');?></label>
                          <input type="password" class="form-control" autocomplete="new-password" placeholder="<?=t('Password');?>" name="User[password]">
                        </fieldset>
                    </div>





					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('E-Mail');?></label>
                          <input type="email" class="form-control" id="modaluseremail" placeholder="<?=t('E-Mail');?>" name="User[email]">
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('Image');?></label>
							<fieldset class="form-group">
								<input type="file" class="form-control" id="basicInput" name="User[image]">
							</fieldset>
					</div>


				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('Name');?></label>
                          <input type="text" class="form-control" id="modalusername" placeholder="<?=t('Name');?>" name="User[name]">
                        </fieldset>
                    </div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('Surname');?></label>
                          <input type="text" class="form-control" id="modalusersurname" placeholder="<?=t('Surname');?>" name="User[surname]">
                        </fieldset>
                    </div>
						<?php $languages=  Languages::model()->findAll();	?>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicInput"><?=t('Language');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="modaluserlanguageid" name="User[languageid]">
						  <option value="">Seçiniz</option>
                            <?php foreach($languages as $language):?>
							<option value="<?=$language->id;?>"><?=$language->name;?></option>
							<?php endforeach;?>
                          </select>
                        </fieldset>
                    </div>

				




					 <input type="hidden" class="form-control" id="modalusersurname" value="editprofile" name="User[location]">






                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning block-page-update" type="submit"><?=t('Update');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php }?>
	<?php }?>
	<!-- G�NCELLEME B�T��-->

<script>

function openmodal(obj)
{
	$('#modaluserid').val($(obj).data('id'));
	$('#modaluserusername').val($(obj).data('username'));
	$('#modaluseremail').val($(obj).data('email'));
	$('#modalusername').val($(obj).data('name'));
	$('#modalusersurname').val($(obj).data('surname'));
	$('#modaluserlanguageid').val($(obj).data('languageid'));

	$('#duzenle').modal('show');

}


   $(document).ready(function() {
      $('.block-page-update').on('click', function() {
		  if(document.getElementById("modaluserusername").value!='' && document.getElementById("modaluseremail").value!='')
		  {

        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 20000, //unblock after 20 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
		  }

    });

});

</script>
