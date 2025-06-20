<?php   

User::model()->login();		



$firm=User::model()->sqlcompany();
$name=User::model()->whopermission()->who;
$sql=$firm->sql;

if($name!='admin')
{
?>

	<section id="headers">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						 <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('My Company Update');?></h4>
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

							<form action="/firm/profileupdate" method="post" enctype="multipart/form-data">
							<div class="row">	  
							
		  
								<div class="col-xl-12 col-lg-12">
									<div class="card">
										<div class="card-content">
											<div class="card-body">
												<div class="row">
												<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
																		<div class="text-center">
											<div class="card-body">
												<div class="col-xl-12 col-md-12 col-12">
												<img src="<?php if($firm->image!=''){?><?=Yii::app()->baseUrl.'/'.$firm->image;?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 100%;    max-width: 70px;"  alt="Company Logo">
												</div>
											</div>

											<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
												<label for="basicSelect"><?=t('Logo Update');?></label>
												<fieldset class="form-group">
													<input type="file" class="form-control" id="basicInput1" name="<?=$sql;?>[image]">
												</fieldset>
											</div>

										 </div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
												<div class="text-center">
											<div class="card-body">
												<div class="col-xl-12 col-md-12 col-12">
												<img src="<?php if($firm->image2!=''){?><?=Yii::app()->baseUrl.'/'.$firm->image2;?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 100%;    max-width: 70px;"  alt="Company Logo 2">
												</div>
											</div>

											<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
												<label for="basicSelect"><?=t('Logo2 Update');?></label>
												<fieldset class="form-group">
													<input type="file" class="form-control" id="basicInput1" name="<?=$sql;?>[image2]">
												</fieldset>
											</div>

										 </div>
												</div>
												<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
												<div class="text-center">
											<div class="card-body">
												<div class="col-xl-12 col-md-12 col-12">
												<img src="<?php if($firm->image_footer!=''){?><?=Yii::app()->baseUrl.'/'.$firm->image_footer;?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 100%;    max-width: 70px;"  alt="Company Footer Image">
												</div>
											</div>

											<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
												<label for="basicSelect"><?=t('Footer image footer');?></label>
												<fieldset class="form-group">
													<input type="file" class="form-control" id="basicInput1" name="<?=$sql;?>[image_footer]">
												</fieldset>
											</div>

										 </div>
												</div>
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Name');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput2" placeholder="<?=t('Name');?>" name="Firm[name]" value="<?=$firm->name;?>" requred>
														</fieldset>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Commercial Title');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput3" placeholder="<?=t('Commercial Title');?>" value="<?=$firm->title;?>"name="Firm[title]" >
														</fieldset>
													</div>
					
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Tax Office');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput4" placeholder="<?=t('Tax Office');?>" value="<?=$firm->taxoffice;?>" name="Firm[taxoffice]" >
														</fieldset>
													</div>
					
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Tax No');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput5" placeholder="<?=t('Tax No');?>" value="<?=$firm->taxno;?>"  name="Firm[taxno]" >
														</fieldset>
													</div>
					
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Address');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput6" placeholder="<?=t('Address');?>" value="<?=$firm->address;?>" name="Firm[address]" >
														</fieldset>
													</div>
													
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Land Phone');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput7" placeholder="<?=t('Land Phone');?>" value="<?=$firm->landphone;?>"  name="Firm[landphone]" >
														</fieldset>
													</div>
													
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('E-mail');?></label>
														<fieldset class="form-group">
														  <input type="email" class="form-control" id="basicInput8" placeholder="<?=t('E-mail');?>" value="<?=$firm->email;?>"  name="Firm[email]" >
														</fieldset>
													</div>
                 								
												         <?php
 $renk='#00a748';
if ($firm->servicereport_color<>'')
{
  $renk=$firm->servicereport_color;
}
// echo $firm->servicereport_color;
 ?>
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Company Colour');?></label>
														<fieldset class="form-group">
													<input type="color" id="Firm[servicereport_color]" name="Firm[servicereport_color]" value="<?=$renk?>">
														</fieldset>
													</div>


													<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
														<fieldset class="form-group">
															<div class="input-group-append" id="button-addon2" style="float: right;">
																		<button class="btn btn-primary" type="submit"><?=t('Update');?></button>
															</div>
														</fieldset>
													</div>
												</div>
											</div>
										 </div>
									 </div>
								</div>
							</div>		
							</form>
						</div>
					</div>
				</div>
            </div>
        </div>
 </section>

 <?php }else{?>
 

 	<section id="headers">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						 <h4 style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;" class="card-title"><?=t('My Company Update');?></h4>
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

							<form action="/firm/adminupdate" method="post" enctype="multipart/form-data" autocomplete="off">
							<div class="row">	  
								<div class="col-xl-3 col-md-6 col-12">
									<div class="card">
										<div class="text-center">
											<div class="card-body">
												<div class="col-xl-12 col-md-12 col-12">
												<img src="<?php if($firm->image!=''){?><?=Yii::app()->baseUrl.'/'.$firm->image;?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 100%;"  alt="User image">
												</div>
											</div>

											<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
												<label for="basicSelect"><?=t('Image Update');?></label>
												<fieldset class="form-group">
													<input type="file" class="form-control" id="basicInput9" name="User[image]">
												</fieldset>
											</div>

										 </div>
									 </div>
								</div>
		  
								<div class="col-xl-9 col-lg-12">
									<div class="card">
										<div class="card-content">
											<div class="card-body">
												<div class="row">
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Username');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput10" placeholder="<?=t('Username');?>" name="User[username]" value="<?=$firm->username;?>" requred>
														</fieldset>
													</div>
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Password');?></label>
														<fieldset class="form-group">
														  <input type="password" class="form-control" id="basicInput11" placeholder="<?=t('Password');?>" autocomplete="new-password" name="User[password]"  >
														</fieldset>
													</div>
					
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Email');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput12" placeholder="<?=t('Email');?>" value="<?=$firm->email;?>" name="User[email]" >
														</fieldset>
													</div>
					
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Name');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput13" placeholder="<?=t('Name');?>" value="<?=$firm->name;?>"  name="User[name]" >
														</fieldset>
													</div>
					
													<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
														<label for="basicSelect"><?=t('Surname');?></label>
														<fieldset class="form-group">
														  <input type="text" class="form-control" id="basicInput14" placeholder="<?=t('Surname');?>" value="<?=$firm->surname;?>" name="User[surname]" >
														</fieldset>
													</div>
					


													<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
														<fieldset class="form-group">
															<div class="input-group-append" id="button-addon2" style="float: right;">
																		<button class="btn btn-primary" type="submit"><?=t('Update');?></button>
															</div>
														</fieldset>
													</div>
												</div>
											</div>
										 </div>
									 </div>
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