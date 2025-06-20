<?php
$ax= User::model()->userobjecty('');
User::model()->login();

$parentid=Client::model()->find(array('condition'=>'id='.$_GET['id'],));


$clientview=Client::model()->find(array('condition'=>'id='.$_GET['id'],));
 $transferclient=0;

$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (firmid='.$clientview->firmid.' or mainfirmid='.$clientview->firmid.')',
							   ));


$transferclient=0;

if($ax->branchid>0)
{


	$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
									'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (mainfirmid='.$ax->branchid.' or firmid='.$ax->branchid.')',
							   ));


	$clientview=Client::model()->find(array('condition'=>'id='.$_GET['id']));
		if($clientview->mainfirmid!=$ax->branchid)
		{
			$transferclient=1;
		}





}


if($ax->clientid>0)
{


	$client=Client::model()->findAll(array(
	#'select'=>'',
	 #'limit'=>'5',
	'order'=>'name ASC',
	'condition'=>'parentid='.$ax->clientid.' and isdelete=0',
	 ));


}





$transfer=0;
if($clients->firmid!=$clients->mainfirmid && $clients->firmid!=$_GET['id'])
{
	 $transfer=1;
}


?>

<?php if (Yii::app()->user->checkAccess('client.staff.view')){ ?>
<?=User::model()->geturl('Client','Staff',$_GET['id'],'client');?>
			<div class="card">
		<div class="card-header" style="">
					<ul class="nav nav-tabs">

					<?php if (Yii::app()->user->checkAccess('client.branch.view')){ ?>
                       <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/view/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $client);?></span><?=t('Branch');?></a>
                      </li>
					<?php }?>
					<?php if (Yii::app()->user->checkAccess('client.staff.view')){ ?>
                      <li class="nav-item">
                        <a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/staff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
						<?php $say=User::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and clientbranchid=0'));
									echo count($say);?>
							</span><?=t('Staff');?>





							</a>
                      </li>
					<?php }?>

                    </ul>
				</div>

</div>

<?php if (Yii::app()->user->checkAccess('client.staff.create')){ ?>
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

					<form id="staffteamlist-form" action="/staffteamlist/create" method="post">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput"  name="Staffteamlist[branchid]" value="<?=$_GET['id'];?>">
					<input type="hidden" class="form-control" id="basicInput"  name="type" value="client">
					<div class="row">


					<?php if($ax->firmid!=''){
						 $firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
						  if($firm->package=='Packagelite')
						  {?>
							<input type="hidden" class="form-control" name="authtype" value="0">
						  <?php		}
						  else{?>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Auth Type');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="authtype" >
							<option value="0"><?=t('Admin');?></option>
							<option value="1"><?=t('Staff');?></option>
                          </select>
                        </fieldset>
					 </div>
					<?php	 }?>

					<?php	 }else{?>

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Auth Type');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="authtype" >
							<option value="0"><?=t('Admin');?></option>
							<option value="1"><?=t('Staff');?></option>
                          </select>
                        </fieldset>
					 </div>

					<?php	 }?>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="username" onkeyup="javascript:kontrol()"  placeholder="<?=t('User Name');?>" name="Staffteamlist[username]" required>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="password" class="form-control" id="password" placeholder="<?=t('Password');?>" name="Staffteamlist[password]" autocomplete="new-password">
                        </fieldset>
                    </div>

						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Email');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="email" placeholder="<?=t('Email');?>" name="Staffteamlist[email]" required>
                        </fieldset>
                    </div>




					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Name');?>" name="Staffteamlist[name]">
                        </fieldset>
                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Surname');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Surname');?>" name="Staffteamlist[surname]">
                        </fieldset>
                    </div>





					<!--
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('ID');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('ID');?>" name="Staffteamlist[id]">
                        </fieldset>
                    </div>
					-->

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Bird Place');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Birth Place');?>" name="Staffteamlist[birthplace]">
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Bird Date');?></label>
                        <fieldset class="form-group">
                          <input type="date" class="form-control" id="basicInput" placeholder="<?=t('Birth Date');?>" name="Staffteamlist[birthdate]">
                        </fieldset>
                    </div>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
						<label for="basicSelect"><?=t('Gender');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Staffteamlist[gender]" >
						  <option value="0"><?=t('Mr');?></option>
						  <option value="1"><?=t('Mrs');?></option>

                           </select>
                        </fieldset>

                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Phone');?>" name="Staffteamlist[phone]">
                        </fieldset>
                    </div>


					 <input type="hidden" value='1' name="Staffteamlist[active]">

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page-create" type="submit"><?=t('Create');?></button>
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
						 <h4 class="card-title"><?=t('STAFF LIST');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('client.staff.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Staff');?> <i class="fa fa-plus"></i></button>
								</div>

						</div>
						<?php }?>
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

				<input type="hidden" class="form-control form-control-xl input-xl" id="branchid" value="<?=$_GET['id'];?>">
				<div class="row" id="staffteam">
				  <?php
					 if((isset($_GET[status]) && $_GET[status]==1) || !isset($_GET[status]))
					  {
						$userisactive=' and u.active=1';
					  }
					  else if(isset($_GET[status]) && $_GET[status]==2)
					  {
						$userisactive=' and u.active=0';
					  }
					  else
					  {
						 $userisactive='';
					  }


					$where='l.branchid='.$_GET['id'].$userisactive;


					$user = Yii::app()->db->createCommand()
						->from('staffteamlist l')
						->join('user u', 'u.id=l.userid')
						->join('userinfo i', 'i.id=u.id')
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
								 <h4 class="card-title"><?=$user[$i]['name'].' '.$user[$i]['surname'];?></h4>
								 <h5 class="card-subtitle"><?php if($user[$i]['type']!='1'){echo t(Authtypes::model()->find(array('condition'=>'id='.$user[$i]['type']))->name);}else{echo t('Super Admin');}?></h5>
							  <h6 class="card-subtitle" style='margin-top: 14px;'><?=$user[$i]['primaryphone'];?></h6>
							</div>
							<div class="text-center" style="margin-bottom:10px">
							<?php if (Yii::app()->user->checkAccess('client.staff.update')){ ?>
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
							 data-active="<?=$user[$i]['active'];?>"


							<?php $authuser=explode('.',AuthAssignment::model()->find(array('condition'=>'userid='.$user[$i]['userid']))->itemname);?>


							data-auth="<?=$authuser[4];?>"

							 	<?php $conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$user[$i]['id'])
							   ));

				?>
					data-conformityemail="<?php if(!$conformityemail){echo "1";}else{echo $conformityemail->type;}?>"



								  ><i style="color:#fff;" class="fa fa-edit"></i></a>
							<?php }?>



								  	<a href="<?=Yii::app()->baseUrl?>/client/auth/<?=$user[$i]['id'];?>" class="btn btn-primary btn-sm"><i style="color:#fff;" class="fa fa-user-secret"></i></a>


							<?php if (Yii::app()->user->checkAccess('client.staff.delete')){ ?>

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


<?php if (Yii::app()->user->checkAccess('client.staff.update')){ ?>
	<!-- GÜNCELLEME BAŞLANGIÇ-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Staff Update');?><span id="staff"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<form id="staffteamlist-form" action="/staffteamlist/update/0" method="post">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput"  name="Staffteamlist[branchid]" value="<?=$_GET['id'];?>">
					   <input type="hidden" class="form-control" id="modalstaffid"  name="Staffteamlist[id]">
						<input type="hidden" class="form-control" id="basicInput"  name="type" value="client">
					   <input type="hidden" class="form-control" id="modalstaffuserid"  name="Staffteamlist[userid]">

					<div class="row">


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Auth Type');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalauth" name="authtype" >
							<option value="Admin"><?=t('Admin');?></option>
							<option value="Staff"><?=t('Staff');?></option>
                          </select>
                        </fieldset>
					 </div>




					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffusername" onkeyup="javascript:kontrolupdate()"  placeholder="<?=t('User Name');?>" name="Staffteamlist[username]" required>
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Password');?></label>
                        <fieldset class="form-group">
                          <input type="password" class="form-control" autocomplete="new-password" placeholder="<?=t('Password');?>" name="Staffteamlist[password]">
                        </fieldset>
                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Email/User Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffemail" placeholder="<?=t('Email');?>" name="Staffteamlist[email]" required>
                        </fieldset>
                    </div>




					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffname" placeholder="<?=t('Name');?>" name="Staffteamlist[name]">
                        </fieldset>
                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Surname');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffsurname" placeholder="<?=t('Surname');?>" name="Staffteamlist[surname]">
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffphone" placeholder="<?=t('Phone');?>" name="Staffteamlist[phone]">
                        </fieldset>
                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Bird Place');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalstaffbirthplace" placeholder="<?=t('Birth Place');?>" name="Staffteamlist[birthplace]">
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Bird Date');?></label>
                        <fieldset class="form-group">
                          <input type="date" class="form-control" id="modalstaffbirthdate" placeholder="<?=t('Birth Date');?>" name="Staffteamlist[birthdate]">
                        </fieldset>
                    </div>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Gender');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalstaffgender" name="Staffteamlist[gender]" >
						  <option value="0"><?=t('Mr');?></option>
						  <option value="1"><?=t('Mrs');?></option>

                           </select>
                        </fieldset>

                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicInput"><?=t('Active');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="modalactive" name="Staffteamlist[active]">
                            <option value="1" selected><?=t('Active');?></option>
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
	<!-- GÜNCELLEME BİTİŞ-->
	<!--SİL BAŞLANGIÇ-->
	<?php if (Yii::app()->user->checkAccess('client.staff.delete')){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Staff Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslangıç-->
						<form id="staffteamlist-form" action="/staffteamlist/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalstaffid2" name="Staffteamlist[id]">
						<input type="hidden" class="form-control" id="modalstaffuserid2" name="Staffteamlist[userid]">
						<input type="hidden" class="form-control" id="basicInput"  name="Staffteamlist[branchid]" value="<?=$_GET['id'];?>">
						<input type="hidden" class="form-control" id="basicInput"  name="type" value="client">
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


<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

   $(document).ready(function() {
      $('.block-page-update').on('click', function() {
		if(document.getElementById("modalstaffusername").value!='' && document.getElementById("modalstaffemail").value!='')
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
		if(document.getElementById("email").value!='' && document.getElementById("username").value!='' && document.getElementById("password").value!='')
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
	$('#modalactive').val($(obj).data('active'));
	$('#modalconformityemail').val($(obj).data('conformityemail'));
	$('#modalauth').val($(obj).data('auth'));
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
		branchid=document.getElementById("branchid").value;
		 $.post( "/client/staffsearch?id="+branchid+'&&ara='+staff).done(function( data ) {
			$('#staffteam').html(data);

		 });
		});
	});
//staff search finish




$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			colvis: "<?=t('Columns Visibility');?>",

        },
				     "sDecimal": ",",
                     "sEmptyTable": "<?=t('Data is not available in the table');?>",
                     //"sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                     "sInfo": "<?=t('Total number of records');?> : _TOTAL_",
                     "sInfoEmpty": "<?=t('No records found');?> ! ",
                     "sInfoFiltered": "(_MAX_ <?=t('records');?>)",
                     "sInfoPostFix": "",
                     "sInfoThousands": ".",
                     "sLengthMenu": "<?=t('Top of page');?> _MENU_ <?=t('record');?>",
                     "sLoadingRecords": "<?=t('Loading');?>...",
                     "sProcessing": "<?=t('Processing');?>...",
                     "sSearch": "<?=t('Search');?>:",
                     "sZeroRecords": "<?=t('No records found');?> !",
                     "oPaginate": {
                         "sFirst": "<?=t('First page');?>",
                         "sLast": "<?=t('Last page');?>",
                         "sNext": "<?=t('Next');?>",
                         "sPrevious": "<?=t('Previous');?>"
                     },
    },
	 buttons: [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [ 0, ':visible' ]
            },
			text:'<?=t('Pdf');?>',
			className: 'd-none d-sm-none d-md-block',
        },
        'colvis',
		'pageLength'
    ]


} );
<?php $ax= User::model()->userobjecty('');
$pageUrl=explode('?',$_SERVER['REQUEST_URI'])[0];
$pageLength=5;
$table=Usertablecontrol::model()->find(array(
							 'condition'=>'userid=:userid and sayfaname=:sayfaname',
							 'params'=>array(
								 'userid'=>$ax->id,
								 'sayfaname'=>$pageUrl)
						 ));
if($table){
	$pageLength=$table->value;
}
?>
var table = $('.dataex-html5-export').DataTable();
table.page.len( <?=$pageLength;?> ).draw();
var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
var info = table.page.info();
var lengthMenuSetting = info.length; //The value you want
// alert(table.page.info().length);
} );
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



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
