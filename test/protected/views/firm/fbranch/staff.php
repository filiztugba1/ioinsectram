<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$type=$_GET['type'];


$firm=Firm::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'],  ));

$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid=0 and isdelete=0 and firmid='.$_GET['id'],
							   ));


$staffteams= Staffteam::model()->findAll(array(
									'condition'=>'firmid='.$_GET['id'],
							   ));


$availablefirm=Firm::model()->find(array(  'condition'=>'id=:id','params'=>array('id'=>$_GET['id'])  ));
$baseauthpath=AuthItem::model()->find(array('condition'=>"name Like '%".$availablefirm->username."'"))->name;


$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'firmid='.$_GET['id'].' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));

$firmuseradmin=1;
$firmuserstaff=1;

$firmx=Firm::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
									'condition'=>'id='.$ax->firmid,  ));


if($type=='firm')
{
	$say=User::model()->findAll(array('condition'=>'firmid='.$_GET['id'].' and branchid=0'));


	if($firmx->package=='Standart' || $firmx->package=='Packagelite' || $firmx->package=='Basic')
	{
		if($say)
		{
			$firmuseradmin=0;
			$firmuserstaff=0;

		}else
		{
			$firmuseradmin=1;
			$firmuserstaff=0;
		}
	}

}
else
{
	$say=User::model()->findAll(array('condition'=>'branchid='.$_GET['id'].' and clientid=0'));
	$say2=User::model()->findAll(array('condition'=>'branchid='.$_GET['id'].' and clientid=0 and type!=23'));
		if($firmx->package=='Standart' || $firmx->package=='Packagelite' || $firmx->package=='Basic')
		{
			if($say && !$say2)
			{
				$firmuseradmin=0;
				$firmuserstaff=1;

			}
			else if(!$say && $say2)
		{
			$firmuseradmin=1;
			$firmuserstaff=0;
		}
		else {
			$firmuseradmin=1;
			$firmuserstaff=1;
		}
		}
}
?>




<?php if (Yii::app()->user->checkAccess('firm.branch.view') and Yii::app()->user->checkAccess('firm.staff.view')){ ?>

<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Firm','Staff',$_GET['id'],'firm');?>



<div class="card">
	<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="card">
			<div class="card-header" style="">
				<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('firm.branch.view')){ ?>
					<?php if($type=="firm"){?>
                       <li class="nav-item">
                        <a class="nav-link "  href="/firm/branch?type=<?=$type;?>&&id=<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $firm);?></span><?=t('Branch');?></a></a>
                      </li>
					 <?php }}?>



					<?php if (Yii::app()->user->checkAccess('firm.staff.view')){ ?>
                      <li class="nav-item">
                 		 <a class="nav-link active"  href="/firm/staff?type=<?=$type;?>&&id=<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?=	count($say);?>
							</span> <?=t('Staff');?></a>


                      </li>
					 <?php }?>


					 <?php if($type=="branch" && $ax->branchid==0){?>
						   <li class="nav-item">
							<a class="nav-link"  href="/firm/staffteam?type=<?=$type;?>&&id=<?=$_GET['id'];?>"><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $staffteams);?></span><?=t('Staffteam');?></a></a>
						  </li>
						 <?php }?>


					<?php if($type=="branch" && $ax->branchid==0){?>
                       <li class="nav-item">
                        <a class="nav-link "  href="/firm/client?type=<?=$type;?>&&id=<?=$_GET['id'];?>"><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $client)+count( $tclient);?></span><?=t('Client');?></a></a>
                      </li>
					 <?php }?>
	<?php if($type=="branch" && $ax->branchid==0 && ($ax->id=1 or $ax->id=317)){?>
              <li class="nav-item">
                        <a class="nav-link "  href="/firm/reports?firmid=<?=$_GET['id'];?>&type=branch">
                          <span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Raporlar');?></a>
                      </li>
<?php }?>
                </ul>

				</div>
			</div>
	</div>
</div>

</div>
<?php }?>


<?php if (Yii::app()->user->checkAccess('firm.staff.view')){ ?>

<?php if (Yii::app()->user->checkAccess('firm.staff.create')){ ?>


<div class="row" id="createpage" >


	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">

			   <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Staff Registration');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

					<form id="staffcreate-form" action="/firm/staffcreate" method="post" autocomplete="new-password">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput1"  name="Firm[firmid]" value="<?=$_GET['id'];?>">
					  <input type="hidden" class="form-control" id="basicInput2" name="Firm[ftype]" value="<?=$type;?>">

					<div class="row">


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Auth Type');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="authtype" >



							<?php if($firmuseradmin==1)
							{?>
							<option value="0"><?=t('Admin');?></option>
							<?php }?>

							<?php if($firmuserstaff==1)
							{?>
							<option value="1"><?=t('Staff');?></option>
							<?php }?>



                          </select>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="username" onkeyup="javascript:kontrol()"  placeholder="<?=t('User Name');?>" name="Firm[username]" required>
                        </fieldset>
                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="password" class="form-control" id="password" placeholder="<?=t('Password');?>" name="Firm[password]"  autocomplete="new-password"  required>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Email');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="email" placeholder="<?=t('Email');?>" name="Firm[email]" required>
                        </fieldset>
                    </div>

					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput3" placeholder="<?=t('Name');?>" name="Firm[name]">
                        </fieldset>
                    </div>


					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
					<label for="basicSelect"><?=t('Surname');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput4" placeholder="<?=t('Surname');?>" name="Firm[surname]">
                        </fieldset>
                    </div>





					<!--
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('ID');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput0" placeholder="<?=t('ID');?>" name="Staffteamlist[id]">
                        </fieldset>
                    </div>
					-->

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Birth Place');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput5" placeholder="<?=t('Birth Place');?>" name="Firm[birthplace]">
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Birth Date');?></label>
                        <fieldset class="form-group">
                          <input type="date" class="form-control" id="basicInput6" placeholder="<?=t('Birth Date');?>" name="Firm[birthdate]">
                        </fieldset>
                    </div>


					<?php $languages=  Languages::model()->findAll();	?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('LANGUAGE');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="userlgid" name="Firm[userlgid]" required>

                            <?php foreach($languages as $language):?>
							<option value="<?=$language->id;?>"><?=t($language->name);?></option>
							<?php endforeach;?>
                          </select>
                        </fieldset>
                    </div>


					<?php					$col='';
					if($type=='branch'){$col=4;}else{$col=6;}
					?>


					<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
						<label for="basicSelect"><?=t('Gender');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Firm[gender]" >
						  <option value="0"><?=t('Mr');?></option>
						  <option value="1"><?=t('Mrs');?></option>

                           </select>
                        </fieldset>

                    </div>

					<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
					<label for="basicSelect"><?=t('Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput7" placeholder="<?=t('Phone');?>" name="Firm[phone]">
                        </fieldset>
                    </div>

					<?php if($type=='branch' || $availablefirm->package=='Packagelite'){?>
					<div class="col-xl-<?=$col;?> col-lg-<?=$col;?> col-md-<?=$col;?> mb-1">
						<label for="basicSelect"><?=t('Color');?></label>
                        <fieldset class="form-group">
                          	<input value="ffcc00" id='color' onchange='colorchange()' class="form-control jscolor {position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"  name="Firm[color]" required>
						</fieldset>
                    </div>
					<?php }?>


						 <input type="hidden" value='1' name="Firm[active]">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float:right">
									<button class="btn btn-primary block-page-create" onclick="clicked(); return false;" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
                    </div>









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
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=$availablefirm->name.' | '.t(' STAFF LIST');?></h4>
						</div>


						<?php

						if (Yii::app()->user->checkAccess('firm.staff.create') &&($firmuseradmin==1 || $firmuserstaff==1)){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Staff');?> <i class="fa fa-plus"></i></button>
								</div>

						</div>
						<?php }
						else
						{?>
							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-danger"  type="submit"><?=t('Your Limit is Full');?></button>
								</div>

						</div>
						<?php }?>


					</div>

					<a href='?type=<?=$_GET['type'];?>&&id=<?=$_GET['id'];?>&&status=2' class="btn btn-danger btn-sm" style='float:right' type="submit"><?=t('Passive');?> </a>

					<a href='?type=<?=$_GET['type'];?>&&id=<?=$_GET['id'];?>&&status=1' class="btn btn-success btn-sm" style='float:right' type="submit"><?=t('Active');?> </a>
					<a href='?type=<?=$_GET['type'];?>&&id=<?=$_GET['id'];?>&&status=0' class="btn btn-warning btn-sm" style='float:right'  type="submit"><?=t('All');?> </a>
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

				<input type="hidden" class="form-control form-control-xl input-xl" id="firmid" value="<?=$_GET['id'];?>">
				<div class="row" id="staffteam">
				  <?php				  if(isset($_GET['type']) && $_GET['type']=='firm')
				  {
					  $where='u.firmid='.$_GET['id'].' and u.branchid=0 and u.clientid=0 and u.clientbranchid=0';
				  }
				  else
				  {
					  $where='u.mainbranchid='.$_GET['id'].' and u.clientid=0 and u.clientbranchid=0';
				  }



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
						->from('user u')
						->join('userinfo i', 'i.userid=u.id')
						->where($where)
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

							  <img src="<?php if($user[$i]['gender']==0){?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mr.png';?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" class="rounded-circle  height-150" alt="<?=$user[$i]['name'].' '.$user[$i]['surname'];?>">
							</div>
							<div class="card-body">
							<div class="card-title" style="background:#<?=$user[$i]['color'];?>;height:5px"></div>
							  <h4 class="card-title"><?=$user[$i]['name'].' '.$user[$i]['surname'];?></h4>
							   <h5 class="card-subtitle"><?php if($user[$i]['type']!='1'){echo t(Authtypes::model()->find(array('condition'=>'id='.$user[$i]['type']))->name);}else{echo t('Super Admin');}?></h5>
							  <h6 class="card-subtitle" style='margin-top: 14px;'><?=$user[$i]['primaryphone'];?></h6>
							</div>

							<?php if (Yii::app()->user->checkAccess('firm.staff.update')){ ?>
							<div class="text-center" style="margin-bottom:10px">
							 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
							 data-id="<?=$user[$i]['userid'];?>"
							 data-username="<?=$user[$i]['username'];?>"
							 data-type="<?=$user[$i]['type'];?>"
							 data-name="<?=$user[$i]['name'];?>"
							 data-surname="<?=$user[$i]['surname'];?>"
							 data-email="<?=$user[$i]['email'];?>"
							 data-birthplace="<?=$user[$i]['birthplace'];?>"
							 data-birthdate="<?=$user[$i]['birthdate'];?>"
							 data-gender="<?=$user[$i]['gender'];?>"
							 data-userlgid="<?=$user[$i]['userlgid'];?>"
							 data-phone="<?=$user[$i]['primaryphone'];?>"
							 data-userid="<?=$user[$i]['userid'];?>"
							 data-active="<?=$user[$i]['active'];?>"
							 data-color="<?=$user[$i]['color'];?>"


				<?php $conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$user[$i]['id'])
							   ));

				?>
					data-conformityemail="<?=$conformityemail->type;?>"


								  ><i style="color:#fff;" class="fa fa-edit"></i></a>

							<?php }?>

							<?php if (Yii::app()->user->checkAccess('firm.staff.update')){
								if($firmid!=0)
								{
								?>
								  	<a href="<?=Yii::app()->baseUrl?>/firm/auth/<?=$user[$i]['id'];?>" class="btn btn-primary btn-sm"><i style="color:#fff;" class="fa fa-user-secret"></i></a>

							<?php }}?>
							<?php if (Yii::app()->user->checkAccess('firm.staff.detail.view')){ ?>

								  	<a href="<?=Yii::app()->baseUrl?>/userinfo/update/<?=$user[$i]['id'];?>" class="btn btn-info btn-sm"><i style="color:#fff;" class="fa fa-info"></i></a>
							<?php }?>

							<?php if (Yii::app()->user->checkAccess('firm.staff.delete')){ ?>
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


<?php if (Yii::app()->user->checkAccess('firm.branch.update')){ ?>
	<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=$availablefirm->name.t('Staff Update');?><span id="staff"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<form id="staffteamlist-form" action="/firm/staffupdate/0" method="post" autocomplete="new-password" >
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput8"  name="Firm[firmid]" value="<?=$_GET['id'];?>">
					   <input type="hidden" class="form-control" id="modalstaffuserid"  name="Firm[userid]">
				 <input type="hidden" class="form-control" id="basicInput9" name="Firm[ftype]" value="<?=$type;?>">
					<input type="hidden" class="form-control" id="auth" name="authtype" value="<?=$type;?>">

					<div class="row">

					<?php if(($_GET['type']=='branch' && $ax->type==13) || ($_GET['type']=='firm' && $ax->type==1) || ($_GET['type']=='branch' && $ax->type==1)){?>
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Auth Type');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modelauth" name="authtype" >

							<option value="0"><?=t('Admin');?></option>
							<option value="1"><?=t('Staff');?></option>

                          </select>
                        </fieldset>
                    </div>
					<?php }else{?>
							  <input type="hidden" class="form-control" id="auth" name="authtype" value="">
							  <?php }?>




					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffusername" onkeyup="javascript:kontrolupdate()"  placeholder="<?=t('User Name');?>" name="Firm[username]" required>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="password"  autocomplete="new-password"  class="form-control"  placeholder="<?=t('Password');?>" name="Firm[password]" >
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Email/User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffemail" placeholder="<?=t('Email/User Name');?>" name="Firm[email]" required>
                        </fieldset>
                    </div>




					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffname" placeholder="<?=t('Name');?>" name="Firm[name]">
                        </fieldset>
                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Surname');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffsurname" placeholder="<?=t('Surname');?>" name="Firm[surname]">
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffphone" placeholder="<?=t('Phone');?>" name="Firm[phone]">
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Birth Place');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffbirthplace" placeholder="<?=t('Birth Place');?>" name="Firm[birthplace]">
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Birth Date');?></label>
                        <fieldset class="form-group">
                          <input type="date" class="form-control" id="modalstaffbirthdate" placeholder="<?=t('Birth Date');?>" name="Firm[birthdate]">
                        </fieldset>
                    </div>


					<?php $languages=  Languages::model()->findAll();	?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('LANGUAGE');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="modaluserlgid" name="Firm[userlgid]" required>
                            <?php foreach($languages as $language):?>
							<option value="<?=$language->id;?>"><?=t($language->name);?></option>
							<?php endforeach;?>
                          </select>
                        </fieldset>
                    </div>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Gender');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalstaffgender" name="Firm[gender]" >
						  <option value="0"><?=t('Mr')?></option>
						  <option value="1"><?=t('Mrs')?></option>

                           </select>
                        </fieldset>

                    </div>

					<?php if($type=='branch' || $availablefirm->package=='Packagelite'){?>
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Color');?></label>
                        <fieldset class="form-group">
                          	<input  id='color2' onchange='colorchange()' class="form-control jscolor {position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}"  name="Firm[color]" required>
						</fieldset>
                    </div>
					<?php }else{?>
						<input type='hidden'  name="Firm[color]" value=''>
					<?php }?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Is Active');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalactive" name="Firm[active]" >
						  <option value="1"><?=t('Active');?></option>
						  <option value="0"><?=t('Passive');?></option>

                           </select>
                        </fieldset>

                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Conformity email is active?');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalconformityemail" name="Conformity[ismail]" >
						  <option value="1"><?=t('Active');?></option>
						  <option value="0"><?=t('Passive');?></option>
                           </select>
                        </fieldset>
                    </div>

					<?php if(isset($_GET['type']) && $_GET['type']=='branch'){?>
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Firm Branch Trasfer');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalconformityemail" name="Firm[usertrasfer]" >
							  <?php $firmtrasfer=Firm::model()->findAll(array('condition'=>'parentid='.$availablefirm->parentid));
							foreach($firmtrasfer as $firmtrasferx){
							?>
							  <option value="<?=$firmtrasferx->id;?>" <?php if($firmtrasferx->id==$availablefirm->id){echo 'selected';}?>><?=$firmtrasferx->name;?></option>
							  <?php }?>
                           </select>
                        </fieldset>
                    </div>
					<?php }?>








					  </div>

					     <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning block-page-update" type="submit"><?=t('Update');?></button>
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
<?php }?>
<?php if (Yii::app()->user->checkAccess('firm.branch.delete')){ ?>

	<!-- GÜNCELLEME BİTİŞ-->
	<!--SİL BAŞLANGIÇ-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=$availablefirm->name.t('Staff Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="staffteamlist-form" action="/firm/staffdelete/0" method="post" autocomplete="new-password">

						<input type="hidden" class="form-control" id="basicInput10"  name="Firm[firmid]" value="<?=$_GET['id'];?>">
					   <input type="hidden" class="form-control" id="modalstaffuserid2"  name="Firm[userid]">
					    <input type="hidden" class="form-control" id="basicInput11" name="Firm[ftype]" value="<?=$type;?>">

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
<?php }?>
<?php }?>
	<!-- SİL BİTİŞ -->





<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}

</style>





<script>
$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});


 function clicked()
  {
	  var color=document.getElementById("color").value;
		 $.post( "/staffteam/color?ara="+color+'&&branch='+<?=$_GET['id'];?>).done(function( data ) {
			//$('#staffteam').html(data);
			if(data==1)
			{
				alert("<?=t('This color is available. Please choose a different color.');?>");
				return false;
			}
			else
			 {
				$("#staffcreate-form").submit();
			}
		 });


  }



   $(document).ready(function() {
      $('.block-page-update').on('click', function() {
		if(document.getElementById("modalstaffusername").value!='' && document.getElementById("modalstaffemail").value!='' && document.getElementById("modaluserlgid").value!='')
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
		if(document.getElementById("email").value!='' && document.getElementById("username").value!=''  && document.getElementById("password").value!='' && document.getElementById("userlgid").value!='')
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




//ekle bölümü baslangıc

function myFunction() {
	yy=document.getElementById("typeselect").value;
		 $.post( "/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient').html(data);

		 });
}
//ekle bölümü bitiş


//Güncelle bölümü baslangıc




function myFunction2() {
	yy=document.getElementById("typeselect2").value;
		 $.post( "/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient2').html(data);

		 });
}
//Güncelle bölümü bitiş



<?php if(isset($_GET['max']))
{?>
	toastr.error("<?=t('Cannot exceed the maximum '.$_GET['max'].' limit');?>");
<?php }
?>

function authchange(data,permission,obj)
{
$.post( "?", { monitoringid: data, active: permission })
  .done(function( returns ) {
	  toastr.success("Success");
});
};

$(document).ready(function(){
	$(".switchery").on('change', function() {

	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }

	  $('#checkbox-value').text($('#checkbox1').val());
});
});


</script>


<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });


function openmodal(obj)
{
	$('#modalstaffid').val($(obj).data('id'));
	$('#modalstaffusername').val($(obj).data('username'));
	$('#modalstaffuserid').val($(obj).data('userid'));
	$('#modalstaffname').val($(obj).data('name'));
	$('#modalstaffsurname').val($(obj).data('surname'));
	$('#modalstaffleaderid').val($(obj).data('leaderid'));
	$('#modalstaffemail').val($(obj).data('email'));
	$('#modalstaffbirthplace').val($(obj).data('birthplace'));
	$('#modalstaffbirthdate').val($(obj).data('birthdate'));
	$('#modalstaffgender').val($(obj).data('gender'));
	$('#modalstaffphone').val($(obj).data('phone'));
	$('#color2').val($(obj).data('color'));
	$('#modaluserlgid').val($(obj).data('userlgid'));
	$('#modalactive').val($(obj).data('active'));
	if($(obj).data('type')==13 || $(obj).data('type')==23)
	{
		$('#modelauth').val('0');
	}
	if($(obj).data('type')==19 || $(obj).data('type')==17)
	{
		$('#modelauth').val('1');
	}

	$('#modalconformityemail').val($(obj).data('conformityemail'));
	$('#duzenle').modal('show');

}



function openmodalsil(obj)
{
	$('#modalstaffid2').val($(obj).data('id'));
	$('#modalstaffuserid2').val($(obj).data('userid'));
	$('#sil').modal('show');

}



//staff search	start
	$(function(){
	$('#staffsearch').keyup(function(){
		staff=document.getElementById("staffsearch").value;
		firmid=document.getElementById("firmid").value;
		 $.post( "/firm/staffsearch?id="+firmid+'&&ara='+staff+'&&type=<?=$_GET['type'];?>').done(function( data ) {
			$('#staffteam').html(data);

		 });
		});
	});
//staff search finish

//color change	start

	function colorchange()
	{
		var color=document.getElementById("color").value;
		 $.post( "/staffteam/color?ara="+color+'&&branch='+<?=$_GET['id'];?>).done(function( data ) {
			//$('#staffteam').html(data);
			if(data==1)
			{
				alert("<?=t('This color is available. Please choose a different color.');?>");
			}
		 });

	}

	function colorchange2()
	{
		var color=document.getElementById("color2").value;
		 $.post( "/staffteam/color?ara="+color+'&&branch='+<?=$_GET['id'];?>).done(function( data ) {
			//$('#staffteam').html(data);
			if(data==1)
			{
				alert("<?=t('This color is available. Please choose a different color.');?>");
			}
		 });

	}
//color change finish





</script>



<script language="javascript">
	function kontrol()
	{
		var veri = document.getElementById("username").value;
		var uzunluk=veri.length;
		var sonkarakter=veri[uzunluk-1];


		var karaktersiz = new Array('İ','Ü','Ğ','Ş','Ç','Ö','ğ','ı','ü','ş','ö','ç');


		for(i=0;i<karaktersiz.length;i++)
		{
			// alert(karaktersiz[i]+'...'+sonkarakter);
				 if (karaktersiz[i]==sonkarakter) {
					alert("<?=t('Hatalı Karakterler Girildi.Türkçe Karakterler Girilemez');?>");
					document.getElementById('username').value="";
					return false;
				  }
		}

}



	function kontrolupdate()
	{
		var veri = document.getElementById("modalstaffusername").value;
		var uzunluk=veri.length;
		var sonkarakter=veri[uzunluk-1];


		var karaktersiz = new Array('İ','Ü','Ğ','Ş','Ç','Ö','ğ','ı','ü','ş','ö','ç');


		for(i=0;i<karaktersiz.length;i++)
		{
			// alert(karaktersiz[i]+'...'+sonkarakter);
				 if (karaktersiz[i]==sonkarakter) {
					alert("<?=t('Hatalı Karakterler Girildi.Türkçe Karakterler Girilemez');?>");
					document.getElementById('modalstaffusername').value="";
					return false;
				  }
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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/assets/js/jscolor.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
