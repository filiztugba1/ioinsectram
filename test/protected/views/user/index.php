<?php

User::model()->login();
$ax= User::model()->userobjecty('');
$firmid=User::model()->getuserfirms()[0];
?>

<?php if (Yii::app()->user->checkAccess('staff.view')){ ?>	

<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Staff','',0,'user');?>


<?php	$ax= User::model()->userobjecty('');
	$where='';
	$iscolor='';
		if($ax->firmid>0)
		{
			if($ax->branchid>0)
			{
				if($ax->clientid>0)
				{
					if($ax->clientbranchid>0)
					{
						$where='u.clientbranchid='.$ax->clientbranchid;
					}
					else
					{
						$where='u.clientbranchid=0 and u.clientid='.$ax->clientid;
					}
				}
				else
				{
					$where='u.clientid=0 and u.clientbranchid=0 and u.branchid='.$ax->branchid;
					$iscolor='ok';
				}
			}
			else
			{
				$where='u.branchid=0 and u.clientid=0 and u.clientbranchid=0 and u.firmid='.$ax->firmid;
				
			}
		}
		else
		{
			$where='u.branchid=0 and u.clientid=0 and u.clientbranchid=0 and u.firmid=0';		
		}
		?>


<?php if (Yii::app()->user->checkAccess('staff.create')){ ?>	




<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
				
			<div class="card">
			     <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('New Staff Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>	
						</div>
					 </div>
					 
				<form id="user-form1" action="/user/create" method="post">
				<div class="card-content">
					<div class="card-body">			
					
					<div class="row">
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1" >
						<label for="basicSelect"><?=t('Auth Type');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="authtype" >
							<option value="0"><?=t('Admin');?></option>
							<option value="1"><?=t('Staff');?></option>						
                          </select>
                        </fieldset>
                    </div>
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label for="basicSelect"><?=t('User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="username" onkeyup="javascript:kontrol()" placeholder="<?=t('User Name');?>" name="User[username]" required>
                        </fieldset>
                    </div>
					
					
				
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="password" class="form-control" id="basicInput2" placeholder="<?=t('Password');?>" name="User[password]" autocomplete="new-password">
                        </fieldset>
                    </div>
					
					
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('E-Mail');?></label>
                        <fieldset class="form-group">
                          <input type="email" class="form-control" id="email" placeholder="<?=t('E-Mail');?>" name="User[email]" required>
                        </fieldset>
                    </div>
					
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput4" placeholder="<?=t('Name');?>" name="User[name]">
                        </fieldset>
                    </div>
					
					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label for="basicSelect"><?=t('Surname');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput5" placeholder="<?=t('Surname');?>" name="User[surname]">
                        </fieldset>
                    </div>
					

			
					
		<?php $languages=  Languages::model()->findAll();	?>			
		
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Language');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="userlgid" name="User[userlgid]" required>
						   <option value=''><?=t('Select');?></option>
                            <?php foreach($languages as $language):?>
							<option value="<?=$language->id;?>"><?=$language->name;?></option>
							<?php endforeach;?>
                          </select>
                        </fieldset>
                    </div>
					
					<?php if($iscolor=='ok'){?>
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label for="basicSelect"><?=t('Color');?></label>
                        <fieldset class="form-group">
                          	<input value="ffcc00" id='color' onchange='colorchange()' class="form-control jscolor {position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"  name="User[color]" required>
						</fieldset>
                    </div>
					<?php }?>

					
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<label for="basicSelect"><?=t('Active');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect8" name="User[active]">
                            <option value="1" selected><?=t('Active');?></option>
                            <option value="0"><?=t('Passive');?></option>
                          </select>
                        </fieldset>
                    </div>
					
					
					
					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" style="margin-top:15px"></label>
                        <fieldset class="form-group" style="float:right">
                        <div class="input-group-append" id="button-addon2">
						<?php if($iscolor=='ok'){?>
									<button class="btn btn-primary" onclick="clicked(); return false;"  type="submit"><?=t('Create');?></button>
									<?php }else{?>
							<button class="btn btn-primary block-page-create"  type="submit"><?=t('Create');?></button>
							<?php }?>
								</div>
                        </fieldset>
                    </div>
					  </div>
				
						
						
					</div>
				</div>
			</form>
			</div>
		
	</div><!-- form -->
	</div>
<?php }?>	
	

<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-7 col-lg-7 col-md-7 col-xs-12 mb-1">
						 <h4 class="card-title"><?=t('STAFF LIST');?></h4>
						</div>
						
							<?php 
							if (Yii::app()->user->checkAccess('staffteam.view') || Yii::app()->user->checkAccess('staff.create'))
							{
								$col=4;
							}
							if (Yii::app()->user->checkAccess('staffteam.view') && Yii::app()->user->checkAccess('staff.create'))
							{
								$col=2;
							}
							
							?>

						<div class="col-xl-5 col-lg-5 col-md-5 col-xs-12 mb-1" >
							
						<?php if (Yii::app()->user->checkAccess('staffteam.view')){ ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12" style='float:left'>
									<a href="/staffteam/" style='margin-right: 3px; width: 100%;' class="btn btn-info" type="submit"><?=t('Team Registration');?></a>
							</div>
						<?php }?>


						<?php if (Yii::app()->user->checkAccess('staff.create')){ ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12" style='float:left'>
									<button style='width: 100%;' class="btn btn-info" id="createbutton" type="submit"><?=t('Staff Registration');?> <i class="fa fa-plus"></i></button>
								</div>

						<?php }?>

							</div>

					</div>

					<a href='?type=branch&&id=2&&status=2' class="btn btn-danger btn-sm" style='float:right' type="submit"><?=t('Passive');?> </a>
					
					<a href='?type=branch&&id=2&&status=1' class="btn btn-success btn-sm" style='float:right' type="submit"><?=t('Active');?> </a>
					<a href='?type=branch&&id=2&&status=0' class="btn btn-warning btn-sm" style='float:right'  type="submit"><?=t('All');?> </a>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
				 
					  <fieldset class="form-group position-relative">
						<input type="text" class="form-control form-control-xl input-xl" id="staffsearch" placeholder="<?=t('Search staff ...');?>">
						<div class="form-control-position">
						  <i class="ft-mic font-medium-4"></i>
						</div>
					  </fieldset>
					  <div id="deneme"></div>
				
			
				<div class="row" id="staffteam">
		<?php  
				

				if((isset($_GET['status']) && $_GET['status']==1) || !isset($_GET['status']))
				  {
					$userisactive=' and u.active=1';
				  }
				  else if(isset($_GET['status']) && $_GET['status']==2)
				  {
					$userisactive=' and u.active=0';
				  }
				  else
				  {
					 $userisactive='';
				  }


					$where=$where.$userisactive;
	
		
		$user = Yii::app()->db->createCommand()
				->from('userinfo l')
				->join('user u', 'u.id=l.userid')
				->where($where.' and u.id!='.$ax->id)
				->queryall();
				
					
					
					
					
					for($i=0;$i<count($user);$i++)
					{?>
				
                    <div class="col-xl-3 col-md-6 col-12">
						<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">
						  <div class="text-center">

						  <?php if($user[$i]['active']==1){?>
						  <a class="btn btn-success btn-sm" style='float:right;color:#fff'><?=t('Active');?> </a>
						 <?php }else{?> <a class="btn btn-danger btn-sm" style='float:right;color:#fff'><?=t('Passive');?> </a><?php }?>


							<div class="card-body">
							

							  <img src="<?php if($user[$i]['image']!=''){echo Yii::app()->baseUrl.'/'.$user[$i]['image'];}else {if($user[$i]['gender']==0){ echo Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mr.png';}else{echo Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }}?>" class="rounded-circle  height-150" alt="<?=$user[$i]['name'].' '.$user[$i]['surname'];?>">
							</div>
							<div class="card-body">
							<h4 class="card-title"><?=$user[$i]['name'].' '.$user[$i]['surname'];?></h4>
							<?php if($iscolor=='ok'){?>
							<div class="card-title" style="background:#<?=$user[$i]['color'];?>;height:5px"></div>
							<?php }?>
							  <h4 class="card-title"><?=$user[$i]['name'].' '.$user[$i]['surname'];?></h4>
							   
							     <h5 class="card-subtitle">
	
					
					
					<?php if($user[$i]['type']!='1'){
						if($user[$i]['ismaster']==0){
						 echo t(Authtypes::model()->find(array('condition'=>'id='.$user[$i]['type']))->name);
						 }
						 else
						 {
							if(Authtypes::model()->find(array('condition'=>'id='.$user[$i]['type']))->authname=='Admin')
							 {
								echo t('Master Admin');
							}
							else
							 {
								echo t('Master Staff');
							}
						 }
						 
						 }else{echo t('Super Admin');}?></h5>

							  <h6 class="card-subtitle" style='margin-top: 14px;'><?=$user[$i]['primaryphone'];?></h6>
							</div>
							<div class="text-center" style="margin-bottom:10px">

							<?php if (Yii::app()->user->checkAccess('staff.update')){ ?>	
							 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)" 
							 data-id="<?=$user[$i]['userid'];?>"
							 data-username="<?=$user[$i]['username'];?>"
							 data-name="<?=$user[$i]['name'];?>"
							 data-surname="<?=$user[$i]['surname'];?>"
							 data-email="<?=$user[$i]['email'];?>"
							 data-birthplace="<?=$user[$i]['birthplace'];?>"
							 data-birthdate="<?=$user[$i]['birthdate'];?>"
							 data-gender="<?=$user[$i]['gender'];?>"
							 data-phone="<?=$user[$i]['primaryphone'];?>"
							 data-userid="<?=$user[$i]['userid'];?>"
							  data-type="<?=$user[$i]['type'];?>"
							  data-userlgid="<?=$user[$i]['userlgid'];?>"
							  data-active="<?=$user[$i]['active'];?>"
							  data-color="<?=$user[$i]['color'];?>"

							  	<?php $conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$user[$i]['id'])
							   ));

				?>
					data-conformityemail="<?=$conformityemail->type;?>"


								  ><i style="color:#fff;" class="fa fa-edit"></i></a>

							<?php }?>
							<?php if (Yii::app()->user->checkAccess('staff.dateil.view')){ ?>				 
							<a href="<?=Yii::app()->baseUrl?>/userinfo/update/<?=$user[$i]['id'];?>" class="btn btn-info btn-sm"><i style="color:#fff;" class="fa fa-info"></i></a>

							<?php }?>
									
							<?php if (Yii::app()->user->checkAccess('staff.delete')){ ?>			
							<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" 
							data-id="<?=$user[$i]['id'];?>"
							data-userid="<?=$user[$i]['userid'];?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
							<?php }?>
							</div>
						  </div>
						</div>
					  </div>
				<?php }?>
				</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>


<!-- HTML5 export buttons table -->
<!--
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('USER LIST');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add User');?> <i class="fa fa-plus"></i></button>
								</div>
							   
						</div>
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                             <th><?=t('USER NAME');?></th>
							 <th><?=t('NAME AND SURNAME');?></th>
							 <th><?=t('TYPE');?></th>
							 <th><?=t('LANGUAGE');?></th>
							 <th><?=t('ACTIVE');?></th>
                            <th><?=t('PROCESS');?></th>
							
							 
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($user as $users):?>
                                <tr>
                                    <td><?=$users->username;?></td>
									<td><?=$users->name.' '.$users->surname;?></td>
									
									<td>
										<?php if($users->type==0){?> 
										<button type="button" class="btn btn-danger btn-sm"><?=t('Super Admin');?></button>
										<?php }?>
										<?php if($users->type==1){?> 
										<button type="button" class="btn btn-success btn-sm"><?=t('Admin');?></button>
										<?php }?>
										<?php if($users->type==2){?> 
										<button type="button" class="btn btn-warning btn-sm"><?=t('Staff');?></button>
										<?php }?>
										
									</td>
										
									<td>
									   <?php $language=Languages::model()->find(array(
												   #'select'=>'title',
													'condition'=>'id=:id',
													'params'=>array(':id'=>$users->userlgid),
												));?>
									<?=$language->name;?></td>
									
										<td> 
									<div class="form-group pb-1">
										<input type="checkbox" data-size="sm" id="switchery"  class="switchery" data-id="<?=$users->id;?>"  <?php if($users->active==1){echo "checked";}?> <?php if (Yii::app()->user->checkAccess('user.list.active')==0){?>disabled<?php }?> />
									</div>								
								</td>
									
									
									
									 
									 
									<td>
									<?php if (Yii::app()->user->checkAccess('user.update')){ ?>	
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)" 
										 data-id="<?=$users->id;?>"
										 data-username="<?=$users->username;?>"
										 data-password="<?=$users->password;?>"
										 data-email="<?=$users->email;?>"
										 data-name="<?=$users->name;?>"
										 data-surname="<?=$users->surname;?>"
										 data-type="<?=$users->type;?>"
										 data-userlgid="<?=$users->userlgid;?>"
										 data-active="<?=$users->active;?>"><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('user.detail')){ ?>	
										 
										  <a href="<?=Yii::app()->baseUrl?>/userinfo/update/<?=$users->id;?>" class="btn btn-info btn-sm"><i style="color:#fff;" class="fa fa-info"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('user.delete')){ ?>	
										 <a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$users->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>
									</td>
                                </tr>
						
								<?php endforeach;?>
						 
                        </tbody>
                        <tfoot>
                          <tr>
                           <th><?=t('USER NAME');?></th>
							 <th><?=t('NAME AND SURNAME');?></th>
							 <th><?=t('TYPE');?></th>
							 <th><?=t('LANGUAGE');?></th>
							 <th><?=t('ACTIVE');?></th>
                            <th><?=t('PROCESS');?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
	-->	
		
		
	
		

<?php if (Yii::app()->user->checkAccess('staff.update')){ ?>	
<!-- GÜNCELLEME BAŞLANGIÇ-->		
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('User Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangıç-->						
						<form id="user-form2" action="/user/update/0" method="post">	
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modaluserid" name="User[id]" value="0">
							
				
				<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('User Name');?></label>
                          <input type="text" class="form-control" id="modaluserusername" onkeyup="javascript:kontrolupdate()" placeholder="<?=t('User Name');?>" name="User[username]" required>
                        </fieldset>
                    </div>
					
					
				
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('Password');?></label>
                          <input type="password" class="form-control" placeholder="<?=t('Password');?>" name="User[password]" autocomplete="new-password">
                        </fieldset>
                    </div>


					
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicInput"><?=t('E-Mail');?></label>
                          <input type="email" class="form-control" id="modaluseremail" placeholder="<?=t('E-Mail');?>" name="User[email]" required>
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
                          <select class="custom-select block" id="modaluseruserlgid" name="User[userlgid]" required>
						   <option value=''><?=t('Select');?></option>
                            <?php foreach($languages as $language):?>
							<option value="<?=$language->id;?>"><?=$language->name;?></option>
							<?php endforeach;?>
                          </select>
                        </fieldset>
                    </div>
					
					
					<?php if($iscolor=='ok'){?>
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Color');?></label>
                        <fieldset class="form-group">
                          	<input value="ffcc00" id='color2' onchange='colorchange2()' class="form-control jscolor {position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"  name="User[color]" required>
						</fieldset>
                    </div>
					<?php }else{?>
						<input type='hidden' value="" name="User[color]" >
					
					<?php }?>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicInput"><?=t('Active');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="modaluseractive" name="User[active]">
                            <option value="1" selected><?=t('Active');?></option>
                            <option value="0"><?=t('Passive');?></option>
                          </select>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Conformity email is active?');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalconformityemail" name="Conformity[ismail]" >
						  <option value="1"><?=t('Active');?></option>
						  <option value="0"><?=t('Passive');?></option>
                           </select>
                        </fieldset>
                    </div>


					
							
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning block-page-update" type="submit"><?=t('Update');?></button>
                                </div>
								
						</form>
									
									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
	<!-- GÜNCELLEME BİTİŞ-->
<?php }?>	
<?php if (Yii::app()->user->checkAccess('staff.delete')){ ?>		
	<!--SİL BAŞLANGIÇ-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('User Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangıç-->						
						<form id="user-form" action="/user/delete/0" method="post">	
						
						<input type="hidden" class="form-control" id="modaluserid2" name="User[id]" value="0">
								
                            <div class="modal-body">
							
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>
				
								
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page-delete" type="submit"><?=t('Delete');?></button>
                                </div>
								
						</form>
									
									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- SİL BİTİŞ -->	
<?php }?>	
<?php }?>



<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}
</style>
<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });


  function clicked()
  {

       if (document.getElementById("color").value!='FFCC00') {
           $("#user-form1").submit();
       } else {
		   alert("<?=t('This color is available. Please choose a different color.');?>");
           return false;
       }
  }

//color change	start

	function colorchange()
	{
		var color=document.getElementById("color").value;
		 $.post( "/staffteam/color?ara="+color+'&&branch='+<?=$ax->branchid;?>).done(function( data ) {
			//$('#staffteam').html(data);
			if(data==1)
			{
				alert("<?=t('This color is available. Please choose a different color.');?>");
			}
		 });
		
	}

	function colorchange2()
	{
		var color=document.getElementById("color").value;
		 $.post( "/staffteam/color?ara="+color+'&&branch='+<?=$ax->branchid;?>).done(function( data ) {
			//$('#staffteam').html(data);
			if(data==1)
			{
				alert("<?=t('This color is available. Please choose a different color.');?>");
			}
		 });
		
	}
//color change finish
	

 



 
 
 
   $(document).ready(function() {
      $('.block-page-update').on('click', function() {
		if(document.getElementById("modaluserusername").value!='' && document.getElementById("modaluseruseremail").value!='' && document.getElementById("modaluseruserlgid").value!='')
		  {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 5000, //unblock after 20 seconds
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


   $(document).ready(function() {
      $('.block-page-create').on('click', function() {
		if(document.getElementById("email").value!='' && document.getElementById("username").value!='' && document.getElementById("userlgid").value!='')
		  {
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 5000, //unblock after 20 seconds
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


   $(document).ready(function() {
      $('.block-page-delete').on('click', function() {
		
        $.blockUI({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 5000, //unblock after 20 seconds
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
		  
    });

});


 
function openmodal(obj)
{
	$('#modaluserid').val($(obj).data('id'));
	$('#modaluserusername').val($(obj).data('username'));
	$('#modaluseremail').val($(obj).data('email'));
	$('#modalusername').val($(obj).data('name'));
	$('#modalusersurname').val($(obj).data('surname'));
	$('#modalusertype').val($(obj).data('type'));
	$('#modaluseruserlgid').val($(obj).data('userlgid'));
	$('#modaluseractive').val($(obj).data('active'));
	$('#color2').val($(obj).data('color'));
	$('#modalconformityemail').val($(obj).data('conformityemail'));
	$('#duzenle2').modal('show');
	
}

function openmodalsil(obj)
{
	$('#modaluserid2').val($(obj).data('id'));
	$('#sil2').modal('show');
	
}


//staff search	start
	$(function(){
	$('#staffsearch').keyup(function(){
		staff=document.getElementById("staffsearch").value;
		 $.post( "/user/staffsearch?ara="+staff).done(function( data ) {
			$('#staffteam').html(data);
			
		 });
		});
	});
//staff search finish	





</script>


<script language="javascript">
function kontrol()
{
var reg=new RegExp("\[İÜĞŞÇÖğıüşöç]");
if(reg.test(document.getElementById('username').value,reg))
{
alert("<?=t('Hatalı Karakterler Girildi.Türkçe Karakterler Girilemez');?>");
document.getElementById('username').value="";
}
} 


function kontrolupdate()
{
var reg=new RegExp("\[İÜĞŞÇÖğıüşöç]");
if(reg.test(document.getElementById('username').value,reg))
{
alert("<?=t('Hatalı Karakterler Girildi.Türkçe Karakterler Girilemez');?>");
document.getElementById('modaluserusername').value="";
}
} 
</script>





<style>
@media (max-width: 991.98px) { 

.hidden-xs,.buttons-collection{
display:none;
}
 div.dataTables_wrapper div.dataTables_filter label{
 white-space: normal !important;
 }
div.dataTables_wrapper div.dataTables_filter input{
margin-left:0px !important;
}

 }
</style>


<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/switch.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/js/jscolor.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';
