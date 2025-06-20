<?php
User::model()->login();

	if (isset($_GET['package']))
	{
		$rootpackage=$_GET['package'];
	}
//AuthItem::model()->createchild('Default.Admin','documentation.view');
//AuthItem::model()->createitem('test.test','3');

//print_r(AuthItem::model()->findall(array('condition'=>"type<>1 and name  like 'Default.%' ")));
?>
<script>
 var block_ele = $('.content-wrapper');
        $(block_ele).block({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
</script>
<div class="row">
 <?php
	if (Yii::app()->user->checkAccess('auth.superadmin'))
	{
?>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create A Package</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
					
						<fieldset>
							<div class="input-group">
							<input maxlength="64" placeholder="Admin,Moderator etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" />			
							<input  type="hidden" name="AuthItem[type]" value="1" />	
							<div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</form>
	</div><!-- form -->
 <?php
	}
?>
		<div class="col-xl-4 col-lg-6 col-md-12">
		<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create a Permission Type</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
					
						<fieldset>
							<div class="input-group">
							<input maxlength="64" placeholder="clients.index etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" />							
							<input  type="hidden" name="AuthItem[type]" value="3" />		
							<div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</form>
	</div><!-- form -->

 <?php
	if (Yii::app()->user->checkAccess('auth.superadmin'))
	{
?>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create Firm to Package1</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<fieldset>
							<div class="input-group">
							<input maxlength="64" placeholder="Admin,Moderator etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" value="Safran"/>			
							<input  type="hidden" name="AuthItem[type]" value="0" />	
							<input  type="hidden" name="package" value="Package1" />	
							<input  type="hidden" name="authcreate" value="1" />	
								<div class="input-group-append" id="button-addon2">
										<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</form>
	</div><!-- form -->
 <?php
	}
?>

 <?php
	if (Yii::app()->user->checkAccess('auth.superadmin'))
	{
?>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create Branch to Firm Safran</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<fieldset>
							<div class="input-group">
							<input maxlength="64" placeholder="Admin,Moderator etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" value="SafranBursaSube"/>			
							<input  type="hidden" name="AuthItem[type]" value="0" />	
							<input  type="hidden" name="default" value="Branch" />	
							<input  type="hidden" name="package" value="Package1.Safran" />	
							<input  type="hidden" name="authcreate" value="1" />	
								<div class="input-group-append" id="button-addon2">
										<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</form>
	</div><!-- form -->
 <?php
	}
?>

 <?php
	if (Yii::app()->user->checkAccess('auth.superadmin'))
	{
?>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create Customer to Branch SafranBursaSube</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<fieldset>
							<div class="input-group">
							<input maxlength="64" placeholder="Admin,Moderator etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" value="Kerevitas"/>			
							<input  type="hidden" name="AuthItem[type]" value="0" />	
							<input  type="hidden" name="package" value="Package1.Safran.SafranBursaSube" />	
							<input  type="hidden" name="default" value="Customer" />	
							<input  type="hidden" name="authcreate" value="1" />	
								<div class="input-group-append" id="button-addon2">
										<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</form>
	</div><!-- form -->
 <?php
	}
?>


 <?php
	if (Yii::app()->user->checkAccess('auth.superadmin'))
	{
?>
	<div class="col-xl-4 col-lg-6 col-md-12">
		<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Create Branch to Customer Kerevitas</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<fieldset>
							<div class="input-group">
							<input maxlength="64" placeholder="Admin,Moderator etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" value="KerevitasBursaSube"/>			
							<input  type="hidden" name="AuthItem[type]" value="0" />	
							<input  type="hidden" name="package" value="Package1.Safran.SafranBursaSube.Kerevitas" />	
							<input  type="hidden" name="default" value="Branch" />	
							<input  type="hidden" name="authcreate" value="1" />	
								<div class="input-group-append" id="button-addon2">
										<button class="btn btn-primary" type="submit">Create</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</form>
	</div><!-- form -->
 <?php
	}
?>

</div><!-- row -->
<!-- With Bottom Border start -->
<section id="bottom-border">
	<div class="row match-height">

		<div class="col-xl-4 col-lg-4">
			<div class="treex well" id="authdiv">
				<ul>
					<li>
						<span> Superadmin</span><a href="?package=Superadmin" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>						
					</li>
				<?php 
					foreach ($authpackages as $item1)
				{				
					?>
						<li>
							<span id="<?=strtr($item1->name, array('.' => '-'))?>"><i style="margin-right:10px;" class="fa fa-folder"></i>  <?=$item1->name?></span><a href="?package=<?=$item1->name?>" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>
							<ul>
					<?php
								AuthItem::model()->writechildlists($item1->name);
					?>
							</ul>
					</li>
					<?php
				}
				?>	
				</ul>
			</div>
		</div>

		

		

		<div class="col-xl-8 col-lg-8">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
					 <?php
						if (Yii::app()->user->checkAccess('auth.superadmin'))
						{
						?>
							<ul class="nav nav-tabs nav-underline no-hover-bg">	
							<?php 
								if (isset($_GET['package']))
							{
								if (strpos($_GET['package'],'.')>1)
								{


							?>
								<li class="nav-item">
									<a href="?package=<?=$item->name?>" class="nav-link active" id="base-tab<?=$_GET['package']?>" ><?=$_GET['package']?></a>
								</li>
								<?php

								}
							}
								?>
							<li class="nav-item">
									<?php
										$selectedtab=''; // Aþaðýdadaki foreach authpackagesta da kullanýlýyor lütfen silmeyelim
										if ($_GET['package']=='Superadmin')
										{
											$selectedtab=' active ';
										}
									?>
											<a href="?package=Superadmin" class="nav-link <?=$selectedtab?>" id="base-tabSuperadmin" >Superadmin</a>
										</li>
								<?php 
									foreach($authpackages as $item)
									{
										$selectedtab='';
										if (isset($_GET['package']))
										{
											if ($_GET['package']==$item->name)
											{
												$selectedtab=' active ';
											}											
										}
										?>
										<li class="nav-item">
											<a href="?package=<?=$item->name?>" class="nav-link <?=$selectedtab?>" id="base-tab<?=$item->name?>" ><?=$item->name?></a>
										</li>
										<?php
									}
								?>								
							</ul>	
						<?php
						}
						?>
						<div class="tab-content px-1 pt-1">
							<div role="tabpanel" class="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
								<? 
									/*
									Paketlerin Baþlangýcý
									*/	
								?>
								<section id="headers">
								  <div class="row">
									<div class="col-12">
										<?php
														$packagetitle='';
														$pack='';
														if (isset($_GET['package']))
														{
															$pack=$_GET['package'];
															$packagetitle='('.$pack.')';
															if ($pack=='Superadmin')
															{
																$pack='';
															}
														}
											?>
											<?php
											if ($pack=='Default')
											{/// Create Group baþlangýcý
											?>
											<div class="col-xl-12 col-lg-12 col-md-12">
												<form id="auth-item-form" action="/authsystem/auth/create" method="post">		
													<div class="card" style="    border: 1px solid #e3ebf3;">
														<div class="card-header">												

														<h4 class="card-title">Create A Group <?=$packagetitle?></h4>
														</div>
														<div class="card-content">
															<div class="card-body">
																<fieldset>
																	<div class="input-group">
																	<input maxlength="64" placeholder="Admin,Moderator etc." class="form-control" name="AuthItem[name]" id="AuthItem_name" type="text" />
																	<input  type="hidden" name="AuthItem[type]" value="0" />		
																	<input  type="hidden" name="package" value="<?=$pack?>" />	
																	<div class="input-group-append" id="button-addon2">
																	<button class="btn btn-primary" type="submit">Create</button>
																		</div>
																	</div>
																</fieldset>
															</div>
														</div>
													</div>
												</form>
											</div>
											<?php
											}/// Create Group bitiþi
											?>
									  <div class="card">
										<div class="card-header">
										  <h4 class="card-title">Groups And Permissions</h4>
										  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										  <div class="heading-elements">
											<ul class="list-inline mb-0">
											 
											

											   <li> <a class="btn btn-default btn-sm" style="color:#404e67;border: 1px solid #dadada;" data-action="expand" style="float:right;"><i style="color:#404e67;padding-right: 7px;" class="ft-maximize"></i>Full Screen</a></li>

											  <?if($_GET['package']!='Default'&&$_GET['package']!=''){?><li> <a class="btn btn-danger btn-sm" style="color:#fff;" onclick="openmodalpaketsil(this)" data-id="<?=$_GET['package'];?>" style="float:right;"><i style="color:#fff;padding-right: 7px;" class="fa fa-trash"></i>Delete Package</a></li>
											  <?}?>
											</ul>
										  </div>
										</div>
										<div class="card-content collapse show">
										  <div class="card-body card-dashboard">
										  <?php
										  if (Yii::app()->user->checkAccess('homepage.view')){
						//						echo 'homepage.view yetkisi';

											}
										  ?>
										   <table class="table display nowrap table-striped table-bordered complex-headers">
												   <thead>
														<tr>
															<th rowspan="2">Permissions</th>
															<th colspan="<?=count($authgroups)?>">Groups</th>
														</tr>
														<tr>
														 <?php
													foreach ($authgroups as $item){ ?>
															<td>
															<center>
															<span><?=$item->name?></br></span>
															<a class="btn btn-danger btn-sm" style="color:#fff;" onclick="openmodalgrupsil(this)" data-id="<?=$item->name?>" style="float:right;"><i style="color:#fff;padding-right: 7px;" class="fa fa-trash"></i></a>
															</center>
															</td>
													<?php } ?>
														   
														</tr>
													</thead>
													<tbody>
													<?php
													foreach ($authpermissions as $item)
													{ 
														if (!AuthItem::model()->issuperadmin($item->name) || $rootpackage=='Superadmin')
														{
														?>
														<tr>
														 
																	<td><?=t($item->name);?>
														<?Yii::app()->getModule('translate')->language->autoload();?>
																		 <?php $translate=Translates::model()->find(array(
																			   #'select'=>'title',
																				'condition'=>'title=:title',
																				'params'=>array(':title'=>$item->name),
																			));?>

																	<a class="btn btn-info btn-sm" onclick="openmodalinfo(this)" data-name="<?=t($item->name);?>" data-id="<?=$translate->id;?>"  style="float:right; margin-left:10px;"><i style="color:#fff; " class="fa fa-info"></i></a>
																	<?php 

																	  if (Yii::app()->user->checkAccess('Superadmin'))
																	  {
																		?>
																	 <?if($_GET['package']=='Default' ||$_GET['package']=='Superadmin' ){?> <a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-child="<?=$item->name?>" data-parent="<?=$_GET['package'];?>" style="float:right;"><i style="color:#fff; " class="fa fa-trash"></i></a>
																	 <?}?>
																	  <?php 
																	  }
																		?>
																	  </td>
															
															 <?php
																foreach ($authgroups as $item1)
																{
																	if( AuthItem::model()->checkgrouppermission($item1->name,$item->name))
																	{
																		$checked='checked';
																	}else{
																		$checked='';
																	}
																	
																	if (AuthItem::model()->issuperadmin($item->name) && !Yii::app()->user->checkAccess('Superadmin'))
																	{
																		$checked.='  disabled';
																	}
																	else
																	{
																	?>
																		<td>
																				<input type="checkbox" class="switch" data-id="<?=$item1->name.'|'.$item->name?>" data-switch-always <?=$checked?> />
																		</td>
																	<?php 
																	}
																	?>
														<?php } ?>
														</tr>
														<?php
														}
													} ?>
														</tbody>

												</table>
											
										  </div>
										</div>
									  </div>
									</div>
								  </div>
								</section>
								<? 
									/*
									Paketlerin Bitiþi
									*/	
								?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</section>
<!-- With Bottom Border end -->

<!--info BAÞLANGIÇ-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Permission Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangýç-->						
						<form id="leftmenu-form" action="/translate/translates?id=0" method="post">	
							 <div class="modal-body">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<input type="text" class="form-control" id="modalpermissionname" name="AuthItem[name]" value="0" disabled>
								</div>
							 </div>
				
							 <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <div id="languagehref"></div>
                              </div>
								
						</form>
									
									<!--form bitiþ-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- info BÝTÝÞ -->



<!--SÝL BAÞLANGIÇ-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Package Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangýç-->						
						<form id="leftmenu-form" action="/authsystem/auth/delete?id=0" method="post">	
						
						<input type="hidden" class="form-control" id="modalpaketname" name="AuthItem[name]" value="0">
							 <div class="modal-body">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>				
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger" type="submit"><?=t('Delete');?></button>
                             </div>
								
						</form>
									
									<!--form bitiþ-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- SÝL BÝTÝÞ -->

	<!--PACKAGE SÝL BAÞLANGIÇ-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="packagesil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Package Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangýç-->						
						<form id="leftmenu-form" action="/authsystem/auth/groupdelete?id=0" method="post">	
							<input type="hidden" class="form-control" id="modalpaketname2" name="AuthItem[name]" value="0">
							 <div class="modal-body">
								 <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<h5> <?=t('Do you want to delete?');?></h5>
								 </div>
							 </div>
                             <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger" type="submit"><?=t('Delete');?></button>
                             </div>
						</form>									
									<!--form bitiþ-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!--PACKAGE SÝL BÝTÝÞ -->

	<!--SÝL BAÞLANGIÇ-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="permissionsil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Permission Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangýç-->						
						<form id="leftmenu-form" action="/authsystem/auth/deletepermission" method="post">	
						
						<input type="hidden" class="form-control" id="modalchild" name="AuthItem[child]" value="0">
						<input type="hidden" class="form-control" id="modalparent" name="AuthItem[parent]" value="0">
								
                            <div class="modal-body">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>
					        </div>
                            <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger" type="submit"><?=t('Delete');?></button>
                            </div>
								
						</form>
									
									<!--form bitiþ-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- SÝL BÝTÝÞ -->

<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}
</style>

<script>
function openmodalgrupsil(obj)
{
	$('#modalpaketname2').val($(obj).data('id'));
	$('#packagesil').modal('show');
	
}

function openmodalpaketsil(obj)
{
	$('#modalpaketname').val($(obj).data('id'));
	$('#sil').modal('show');
	
}

function openmodalsil(obj)
{
	$('#modalparent').val($(obj).data('parent'));
	$('#modalchild').val($(obj).data('child'));
	$('#permissionsil').modal('show');
	
}

function openmodalinfo(obj)
{
	$('#modalpermissionname').val($(obj).data('name'));
	$.post( "/authsystem/auth/info?id="+$(obj).data('id')).done(function( data ) {

		$('#languagehref').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
	$('#info').modal('show');
	
}


function authchange(data,permission,obj){
$(obj).parent().append('<center><div class="ft-refresh-cw icon-spin "></div></center>');
$(obj).parent().find( "span" ).css('display','none');
$.post( "?", { group: data, type: permission })
  .done(function( returns ) {
	dataArr=data.split('|');
	if (returns.trim().split('|')=='success')
	{
		if (permission==0)
		{
			title='Permission "'+dataArr[1]+'" removed from "'+dataArr[0]+'" !';
		}else
		{
			title='Permission "'+dataArr[1]+'" defined to "'+dataArr[0]+'" !';		
		}
		toastr.success("<center>"+title+"</center>", "<center>Successful</center>", {
				positionClass: "toast-top-right",
				containerId: "toast-top-right"
		});
	}
	else
	{			
		toastr.error("<center>"+returns.trim().split('|')[1]+"</center>", "<center>Error</center>", {
				positionClass: "toast-top-right",
				containerId: "toast-top-right"
		});
	}
	
   
		$('.ft-refresh-cw').remove();
$(obj).parent().find( "span" ).css('display','block');
  });
  
	
}
$(document).ready(function(){
	var elems = Array.prototype.slice.call(document.querySelectorAll('.switch'));
	elems.forEach(function(html) {
	  var switchery = new Switchery(html, { size: 'small' });
	});
	
	$(".switch").on('change', function() {
		
	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }
	  
	  $('#checkbox-value').text($('#checkbox1').val());
});

$(document).ready(function() {
     $(".complex-headers").DataTable({
		 "pageLength": '100',
		scrollX: !0
    })
});
		 	var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
	elems.forEach(function(html) {
		$(html).css('display','none');
		$(html).css('display','block');
	});
});

</script>
<style>
.treex {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
	overflow-x: scroll;
}
.treex li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
	width: 500px;
    //position:relative
}
.treex li::before, .treex li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.treex li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.treex li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.treex li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #999;
    border-radius:5px;  
    display:inline-block;
    padding:3px 8px;
    #text-decoration:none
}
.treex li.parent_li>span {
    cursor:pointer
}
.treex>ul>li::before, .treex>ul>li::after {
    border:0
}
.treex li:last-child::before {
    height:30px
}
.treex li.parent_li>span:hover, .treex li.parent_li>span:hover+ul li span {
    background:#eee;
    border:1px solid #94a0b4;
    color:#000
}
.parent_li
{clear: both;}
.glyphicon-folder-open
{
background:lightgray !important;
}
</style>
<script>
$(function () {
    $('.treex li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
	
    $('.treex li.parent_li > span').on('click', function (e) {
	
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-folder').removeClass('fa-folder-open');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-folder-open').removeClass('fa-folder');
        }
		var elmnt = document.getElementById("authdiv");
		elmnt.scrollLeft = $(this).position().left;
        e.stopPropagation();
    });
	<?php
		if (isset($_GET['package']))
		{
			$ac=$_GET['package'];
		}
		else
		{
			$ac='';
		}
		
		?>
	var clicklist="<?=$ac?>".split(".");
	var clickitem='';
	$.each(clicklist, function( index, value ) {		   
		if (index<1)
		{
			clickitem=value;
		}else{
			clickitem=clickitem+'-'+value;
		}
		$('#'+clickitem).click();//click(); sleep(1000);
	});
});

$( ".content-wrapper" ).ajaxStart($.blockUI).ajaxStop($.unblockUI);
</script>


<?php

/*
	 var block_ele = $('.content-wrapper');
        $(block_ele).block({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
		$(block_ele).unblock();
*/

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/toggle/switchery.min.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';
?>
