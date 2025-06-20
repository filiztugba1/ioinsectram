<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isdelete=0',
							   ));
							   


	

	// aranacaklar wherede

		
	//echo $where;
   /* $conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'date desc')); */



	$conformity=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id WHERE (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) && conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL '.Conformity::model()->where())->queryAll();




	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
			
		$conformityx=Yii::app()->db->createCommand(
		'SELECT conformity.* FROM conformity INNER JOIN conformityactivity ON conformityactivity.conformityid=conformity.id INNER JOIN departmentpermission ON departmentpermission.clientid=conformity.clientid WHERE conformity.clientid='.$ax->clientbranchid.' GROUP BY conformity.id and (conformity.statusid!=1 && conformity.statusid!=2 && conformity.statusid!=3 && conformity.statusid!=6) &&  conformityactivity.date!="" and conformityactivity.date<"'.date('Y-m-d',time()).'" and conformity.closedtime IS NULL and departmentpermission.departmentid=conformity.departmentid and departmentpermission.subdepartmentid=conformity.subdepartmentid and departmentpermission.userid='.$ax->id)->queryAll();
	}

$yetki=1;

if($ax->mainclientbranchid!=$ax->clientbranchid)
{
	$yetki=0;
}
	
	

?>

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>	
	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity Deadline','',0,'conformity');?>




	 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-6 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('Non-conformities beyond the deadline');?></h4>
						</div>

					

						

						

					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
							<th><?=t('NON-CONFORMITY NO');?></th>
							<th><?=t('WHO');?></th>
                            <th><?=t('TO WHO');?></th>
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('OPENING DATE');?></th>
                            <th><?=t('TYPE');?></th>
                            <th><?=t('DEFINITION');?></th>
                            <th><?=t('SUGGESTION');?></th>

							
                            <th><?=t('PRIORITY');?></th>
							<th><?=t('ACTION DEFINITION');?></th>

							<th><?=t('DEADLINE');?></th>
							<th><?=t('CLOSED TIME');?></th>
                            <th><?=t('STATUS');?></th>
                            <th><?=t('ACTIVITY STATUS');?></th>
							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>
							
                          </tr>
                        </thead>
                        <tbody>
                         
                     
					 		<?php


							for($i=0;$i<count($conformity);$i++){
							$deadline=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformity[$i]['id']));
							$effincy=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$conformity[$i]['id']));
							if($effincy)
							{
								$eff=t("Etkinlik Var").' - '.$effincy->controldate;
							}
							else{
								if($conformity[$i]['status']==1 || $conformity[$i]['status']==2 || $conformity[$i]['status']==6)
								{
									$eff=t("Etkinlik Yok");
								}else{
									$eff='';
								}
							}
								if($deadline)
								{
									$deadt=$deadline->date;
								}
								else{
									$deadt="-";
								}
							$depart=Departments::model()->find(array('condition'=>'id='.$conformity[$i]['departmentid'],));
							if ($depart){ $depart=$depart->name;
							$subdep=Departments::model()->find(array('condition'=>'id='.$conformity[$i]['subdepartmentid'],))->name;
							}else{
							$depart='-';
							$subdep='-';
							
							}
							if($conformity[$i]['closedtime']!='')
								{
									$kpnma=date('Y-m-d',$conformity[$i]['closedtime']);
								}
								else{
									$kpnma="-";
								}

								?> 
							<tr>

								 <td>
									 <?=$conformity[$i]['numberid'];?>
								 </td>
							
								 <td><?$username=User::model()->find(array('condition'=>'id='.$conformity[$i]['userid']));
								 echo $username->name.' '.$username->surname;
								 
								 ?></td>
								 <td><?=Client::model()->find(array('condition'=>'id='.$conformity[$i]['clientid']))->name;?></td>
					<td><?=$depart?></td>
								 <td><?=$subdep?></td>
								 <td>
								 <?=date('Y-m-d',$conformity[$i]['date']);?>
								 <td><?=t(Conformitytype::model()->find(array('condition'=>'id='.$conformity[$i]['type'],))->name);?></td>
								
									 <?//explode(' ',Generalsettings::model()->dateformat($conformity[$i][date];?></td>
								
								 <td><?=$conformity[$i]['definition'];?></td> <!-- sorun -->
								 <td><?=$conformity[$i]['suggestion'];?></td> <!-- �neri -->

								 <td><?=$conformity[$i]['priority'];?><?=t('st Degree');?></td>  <!-- priority -->
								<td><?$activitiondef=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformity[$i]['id'],))->definition;
								if($activitiondef!=''){echo $activitiondef;}else{echo '-';}?></td> 

								 <td><?=$deadt?></td>  <!-- Deadline -->
								<td><?=$kpnma?></td>


								 <td><?=t(Conformitystatus::model()->find(array('condition'=>'id='.$conformity[$i]['statusid'],))->name);?></td>
								

								
								
								
								<td><?=$eff;?></td>	


								<td><?=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformity[$i]['id'],))->nokdefinition;?></td>
								<td><?=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$conformity[$i]['id'],))->activitydefinition;?></td>
					
                       </tr>
						<?php }?>
						 
                        </tbody>
                        <tfoot>
                          <tr>
							<th><?=t('NON-CONFORMITY NO');?></th>
							<th><?=t('WHO');?></th>
                            <th><?=t('TO WHO');?></th>
                            <th><?=t('DEPARTMENT');?></th>
                            <th><?=t('SUB-DEPARTMENT');?></th>
                            <th><?=t('OPENING DATE');?></th>
                            <th><?=t('TYPE');?></th>
                            <th><?=t('DEFINITION');?></th>
                            <th><?=t('SUGGESTION');?></th>

							
                            <th><?=t('PRIORITY');?></th>
							<th><?=t('ACTION DEFINITION');?></th>

							<th><?=t('DEADLINE');?></th>
							<th><?=t('CLOSED TIME');?></th>
                            <th><?=t('STATUS');?></th>
						
							<th><?=t('ACTIVITY STATUS');?></th>

							<th><?=t('NOK - COMPLETED DEFINATION');?></th>
							<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ HTML5 export buttons table -->

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.update')){ ?>
<!-- G�NCELLEME BA�LANGI�-->		
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Management Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
				<form id="conformity-form2" action="/conformity/update/0" method="post" enctype="multipart/form-data">	
                     <div class="modal-body">
					 <input type="hidden" class="form-control" id="modalid" name="Conformity[id]" value="0">





					 

						<?php if($ax->firmid==0){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm2" name="Conformity[firmid]" onchange="myfirm2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?
									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm2" name="Conformity[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>
						
						<?php if($ax->branchid==0){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch2" name="Conformity[branchid]" onchange="mybranch2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									
									<?
									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch2" name="Conformity[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>
					
					<?php if($ax->clientid==0){?>					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">
						
                          <select class="select2" style="width:100%" id="client2" name="Conformity[clientid]" requred onchange="myFunctionClient2()">
								<option value="0">Select</option>
								<?
								if($workorder->branchid!=0){
								$client=Client::model()->findall(array('condition'=>'parentid=0 and firmid='.$workorder->branchid));
								
									foreach($client as $clientx)
										{?>
											<optgroup label="<?=$clientx->name;?>">
												<?$clientbranchs=Client::model()->findAll(array('condition'=>'parentid='.$clientx->id));
													
													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
								<?php }}?>
							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client2" name="Conformity[clientid]" value="<?=$ax->branchid;?>" requred>
					<?php }?>

					
					
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Department');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="department2" name="Conformity[departmentid]" onchange="myFunctionDepartment2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									
									<?
									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						
						
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Sub-department');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="subdepartment2" name="Conformity[subdepartmentid]" requred>
									<option value="0"><?=t('Please Chose');?></option>
									
									<?
									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>


					<?
					$type=Conformitytype::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'isactive=1',
							   ));
							   
					?>
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					 <label for="basicSelect"><?=t('Non-Conformity Type');?></label>
                       <fieldset class="form-group">
						  <select class="select2" id="modaltype" style="width:100%"  name="Conformity[type]">
                            <option value="0" selected=""><?=t('Please Chose');?></option>
							
							<?
								foreach($type as $typex){?>
									<option value="<?=$typex->id;?>"><?=t($typex->name);?></option>
							<?php }?>
                        
                          </select>
                        </fieldset>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					 <label for="basicSelect"><?=t('Non-Conformity Status');?></label>
                       <fieldset class="form-group">
						  <select class="select2" id="modalstatusid" style="width:100%"  name="Conformity[statusid]">
                          </select>
                        </fieldset>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Priority');?></label>
                        <fieldset class="form-group">
						
                          <select class="select2" style="width:100%" id="modalpriority" name="Conformity[priority]">
								<option value="1"><?=t('1. Degree');?></option>
								<option value="2"><?=t('2. Degree');?></option>
								<option value="3"><?=t('3. Degree');?></option>
								<option value="4"><?=t('4. Degree');?></option>
							</select>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Date');?></label>
                          <input type="date"  class="form-control"  placeholder="<?=t('Date');?>" name="Conformity[date]" id="modaldate">
                        </fieldset>
                    </div>
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<div id="img"></div>
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Upload File');?></label>
                          <input type="file"  class="form-control"  name="Conformity[filesf]">
                        </fieldset>
                    </div>
				<input type="hidden"  class="form-control"  name="Conformity[filesfx]" id="modalfilesf">
		
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Definition');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Definition');?>" id="modaldefinition" name="Conformity[definition]"></textarea>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
						<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Conformity[suggestion]" id="modalsuggestion"></textarea>
                        </fieldset>
                    </div>
					
							
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-warning block-page" type="submit"><?=t('Update');?></button>
                                </div>
								
						</form>
									
									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<?php }?>
	<!-- G�NCELLEME B�T��-->

		<!--S�L BA�LANGI�-->
	<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.delete')){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Activity Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslang��-->						
						<form id="user-form" action="/conformity/delete/0" method="post">	
						
					 <input type="hidden" class="form-control" id="modalid2" name="Conformity[id]" value="0">
					 <input type="hidden"  class="form-control"  name="Conformity[filesfx]" id="modalfile">
								
                            <div class="modal-body">
							
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5> <?=t('Do you want to delete?');?></h5>
								</div>
				
								
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>
								
						</form>
									
									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- S�L B�T�� -->

	<!--delelete all start-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
				<!--form baslang��-->						
						<form action="/conformity/deleteall" method="post">	
						
						<input type="hidden" class="form-control" id="modalid3" name="Conformity[id]" value="0">
								
                            <div class="modal-body">
							
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Are you sure you want to delete?');?></h5>
								</div>
				
								
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>
								
						</form>
									
									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<!-- delete all finish -->

<?php }?>
<?php }?>

<script>
// $("#reports").hide();


$("#printbutton").click(function(){
	var formdata= $("#conformity-form").serialize();
	var formElement = document.getElementById("conformity-form");
	
		formElement.target="_blank";
        formElement.action="<?=Yii::app()->getbaseUrl(true)?>/conformity/print/";
	
        formElement.submit();

		formElement.target="";
		formElement.action="/conformity/reports";
    //    var request = new XMLHttpRequest();
    
});


 $("#cancel").click(function(){
        $("#reports").hide(500);
 });

 $("#reportbutton").click(function(){
        $("#reports").toggle(500);
 });


 

 //delete all start
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.sec').each(function(){
                this.checked = true;
            });
        }else{
             $('.sec').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.sec').on('click',function(){
        if($('.sec:checked').length == $('.sec').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

 function deleteall()
 {
	var ids = [];
	$('.sec:checked').each(function(i, e) {
		ids.push($(this).val());
	});
	$('#modalid3').val(ids);
	if(ids=='')
	 {
		alert("<?=t('You must select at least one of the checboxes!');?>");
	}
	else
	 {
		$('#deleteall').modal('show');
	 }

 }
 // delete all finish

  $(document).ready(function() {
      $('.block-page').on('click', function() {
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
    });

});
 








function myfirm() 
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}



 function mybranch() 
{
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
}







function myFunctionClient() {

  	$.post( "/conformity/client?id="+document.getElementById("client").value).done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
	
	$.post( "/conformity/conformitytype?id="+document.getElementById("client").value+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
	});
	
}









function myFunctionDepartment() {
  	$.post( "/conformity/department?id="+document.getElementById("department").value).done(function( data ) {
		$( "#subdepartment" ).prop( "disabled", false );
		$('#subdepartment').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}


/*


function myfirm2() 
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}

 function mybranch2() 
{
	$.post( "/workorder/client?id="+document.getElementById("branch2").value).done(function( data ) {
		$( "#client2" ).prop( "disabled", false );
		$('#client2').html(data);
	});
}


function myFunctionClient2() {
  	$.post( "/conformity/client?id="+document.getElementById("client2").value).done(function( data ) {
		$( "#department2" ).prop( "disabled", false );
		$('#department2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}

function myFunctionDepartment2() {
  	$.post( "/conformity/department?id="+document.getElementById("department2").value).done(function( data ) {
		$( "#subdepartment2" ).prop( "disabled", false );
		$('#subdepartment2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	
	});
}

 

 function openmodal(obj)
{
	$('#firm2').val($(obj).data('firmid'));
	
	  $.post( "/workorder/firmbranch?id="+$(obj).data('firmid')).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		$('#branch2').val($(obj).data('branchid'));
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});
	$.post( "/workorder/client?id="+$(obj).data('branchid')).done(function( data ) {
		$( "#client2" ).prop( "disabled", false );
		$('#client2').html(data);
		$('#client2').val($(obj).data('clientid'));
	});
	$.post( "/conformity/client?id="+$(obj).data('clientid')).done(function( data ) {
		$( "#department2" ).prop( "disabled", false );
		$('#department2').html(data);
		$('#department2').val($(obj).data('departmentid'));
	});
	$.post( "/conformity/department?id="+$(obj).data('departmentid')).done(function( data ) {
		$( "#subdepartment2" ).prop( "disabled", false );
		$('#subdepartment2').html(data);
		$('#subdepartment2').val($(obj).data('subdepartmentid'));
	});
	
	$.post( "/conformity/conformitytype?id="+$(obj).data('clientid')+'&&branch='+$(obj).data('branchid')+'&&firm='+$(obj).data('firmid')).done(function( data ) {
		$( "#modaltype" ).prop( "disabled", false );
		$('#modaltype').html(data);
		$('#modaltype').val($(obj).data('type'));
	});
	
	$.post( "/conformity/conformitystatus?id="+$(obj).data('clientid')+'&&branch='+$(obj).data('branchid')+'&&firm='+$(obj).data('firmid')).done(function( data ) {
		$( "#modalstatusid" ).prop( "disabled", false );
		$('#modalstatusid').html(data);
		$('#modalstatusid').val($(obj).data('statusid'));
	});
	

										 
	$('#modalid').val($(obj).data('id'));
	
	
	
	
	$('#modaldefinition').val($(obj).data('definition'));
	$('#modalsuggestion').val($(obj).data('suggestion'));
	$('#modalstatusid').val($(obj).data('statusid'));
	$('#modalpriority').val($(obj).data('priority'));
	$('#modaldate').val($(obj).data('date'));
	$('#modalfilesf').val($(obj).data('filesf'));
	$('#duzenle').modal('show');
	
}


 function openmodalsil(obj)
{
	$('#modalid2').val($(obj).data('id'));
	$('#modalfile').val($(obj).data('file'));
	$('#sil').modal('show');
	
}
*/

$(document).ready(function() {


	// Multiple Select Placeholder
    $(".select2-placeholder-multiple").select2({
      placeholder: "<?=t('Select State');?>",
    });

/******************************************
*       js of HTML5 export buttons        *
******************************************/

<?$whotable=User::model()->iswhotable();
$whotable->name='';?>

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>"
            },
			colvis: "<?=t('Columns Visibility');?>",
        },
				     "sDecimal": ",",
                     "sEmptyTable": "<?=t('Data is not available in the table');?>",
                     //"sInfo": "_TOTAL_ kay�ttan _START_ - _END_ aras�ndaki kay�tlar g�steriliyor",
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
	"columnDefs": [ {
	"searchable": false,
	"orderable": false,
	// "targets": 0
	} ],
	"order": [[ 5, 'desc' ]],

	 buttons: [
		  <?php if($yetki==1){?>
        {

		
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=$exel;?>'
        },

		


        {
            extend: 'excelHtml5',
            
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=$exel;?>'
		 },
        {
             extend: 'pdfHtml5',
			 orientation: 'landscape',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,3,4,5,6,7]
            },

			


				
			  text:'<?=t('PDF');?>',
			  title: 'Export',

			  action: function ( e, dt, node, config ) {
                   /* window.location = '/conformity/print'; */

					var formdata= $("#conformity-form").serialize();
					var formElement = document.getElementById("conformity-form");
					
						formElement.target="_blank";
						formElement.action="<?=Yii::app()->getbaseUrl(true)?>/conformity/print/";
					
						formElement.submit();

						formElement.target="";
						formElement.action="/conformity/reports";
					//    var request = new XMLHttpRequest();
                },
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Non-Conformity \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  }, 
				 {
					text: '<?=$exel;?>\n',
					bold: true,
					fontSize: 12,
						alignment: 'center'
				  }, 
					
						{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 11,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]
				  
				});
			  }

        },

			<?php }?>
        'colvis',
		'pageLength'
    ]
	

} );
} );


</script>		 
 <?php
 
 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

?>