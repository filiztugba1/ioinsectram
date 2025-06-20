<?php
User::model()->login();
	$ax= User::model()->userobjecty('');

	if($ax->firmid>0)
	{
		if($ax->branchid>0)
		{
			if($ax->clientid>0)
			{
				//buraya ekleme yapam�cak client ve clientbranch
			}
			else
			{
				$where="firm_id=0 or (firm_id=".$ax->firmid." and firm_branch_id=0) or firm_branch_id=".$ax->branchid;
			}
		}
		else
		{
			$where="firm_id=0 or firm_id=".$ax->firmid;
		}
	}
	else
	{
		$where="";
	}


	
		$ek1firmformss = Yii::app()->db->createCommand()
		->select("ek.id ekid,ek.name,ek.json_data ek_json_data,ek.is_active,ekf.*")
				->from('ek1_firm_forms ekf')
				->leftJoin('ek1_forms ek', 'ek.id=ekf.ek1_form_id')
				->where($where)
				->queryall();
				

	//$ek1firmformss=Ek1FirmForms::model()->findAll(array('order'=>'name ASC','condition'=>$where));



?>


<?php if (Yii::app()->user->checkAccess('ek1firmforms.view')){ ?>
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Firma Servis Raporları','',0,'ek1firmforms');?>
<?php if (Yii::app()->user->checkAccess('ek1firmforms.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Firm Service Raports Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="reatment-form" action="/Ek1FirmForms/create" method="post">
				<div class="card-content">
					<div class="card-body">




					<div class="row">


						<?php if($ax->firmid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="ek1firmforms[firmid]" onchange="myfirm()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="ek1firmforms[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="ek1firmforms[branchid]" disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="ek1firmforms[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Form Adı');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="formname" name="ek1firmforms[formname]" onchange="mydefaultform()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?$ek1Forms=Ek1Forms::model()->findall(array('condition'=>'is_active=1'));
									 foreach($ek1Forms as $ek1Form){?>
									<option value="<?=$ek1Form->id;?>"><?=$ek1Form->name;?></option>
									<?php }?>
								</select>
							</fieldset>
						</div>
						
					
						
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1" id='departmanblog'>
                            <label for="basicSelect"><?=t('Formdaki Default Gelecek Özellikler');?></label>
                            <fieldset class="form-group">

                                <select class="select2-placeholder-multiple form-control" style="width:100%" id="defaultform" multiple="multiple"   name="ek1firmforms[defaultform][]" disabled>
                                    <option value="0"><?=t('All');?></option>
                                  

                                </select>
                            </fieldset>
                        </div>
						
					  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect" class="hidden-xs hidden-sm" style="margin:10px"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
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
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('Firm Service Report List');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('ek1firmforms.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Service Report');?> <i class="fa fa-plus"></i></button>
								</div>
						</div>
						<?php }?>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                             <th><?=t('Name');?></th>
							 <?php if($ax->firmid==0){?>
								<th><?=t('Firm');?></th>
								<?php }?>

								<?php if($ax->branchid==0){?>
								<th><?=t('Branch');?></th>
								<?php }?>
							<th><?=t('Formdaki Özellikler');?></th>
							<th><?=t('Formdaki Default Gelecek Özellikler');?></th>
							<!-- <th><?=t('Active');?></th> -->
                            <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($ek1firmformss as $ek1firmforms):?>
                                <tr>
                                    <td><?=$ek1firmforms['name'];?></td>


								<?php if($ax->firmid==0){?>
								<td><?=Firm::model()->find(array('condition'=>'id='.$ek1firmforms["firm_id"]))->name;?></td>
								<?php }?>

								<?php if($ax->branchid==0){?>
								<td><?=Firm::model()->find(array('condition'=>'id='.$ek1firmforms["firm_branch_id"]))->name;?></td>
								<?php }?>
								<td>
								<?php								$ek1=str_replace("[", "", $ek1firmforms["ek_json_data"]);
								$ek1=str_replace("]", "",$ek1);
								$ek1Arr= explode(',',$ek1);
								if(count($ek1Arr)!=0 && $ek1Arr[0]!='')
								{
									for($i=0;$i<count($ek1Arr);$i++)
									{
										$ek1forms=Ek1Items::model()->findAll(array('condition'=>'id in ('.$ek1Arr[$i].')'));
										foreach($ek1forms as $ek1form)
										{
											echo ($i+1).' - '.$ek1form->name.' , </br>';
										}
									}
								}
								?>	
								</td>
									<td>
									<?php								$ek2=str_replace("[", "", $ek1firmforms["defaults_json_data"]);
								$ek2=str_replace("]", "",$ek2);
								$ek1Arr= explode(',',$ek2);
								$ekstrig='';
								if(count($ek1Arr)!=0 && $ek1Arr[0]!='')
								{
									for($i=0;$i<count($ek1Arr);$i++)
									{
										$ek1forms=Ek1Items::model()->findAll(array('condition'=>'id in ('.$ek1Arr[$i].')'));
										foreach($ek1forms as $ek1form)
										{
											echo ($i+1).' - '.$ek1form->name.' , </br>';
											$ekstrig.=intval($ek1form->id).',';
										}
									}

								}
								?>	
								</td>
								<!-- <td>
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$ek1firmforms["id"];?>"  <?php if($ek1firmforms['is_active']==1){echo "checked";}?>  <?php if (Yii::app()->user->checkAccess('ek1firmforms.update')==0){?>disabled<?php }?> />
									</div>
								</td>
								-->


									<td>
									<?php if (Yii::app()->user->checkAccess('ek1firmforms.update')){ ?>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										data-id="<?=$ek1firmforms['id'];?>"
										data-ek1_form_id="<?=$ek1firmforms['ek1_form_id'];?>"
										data-defaults_json_data='<?=$ekstrig;?>'
										data-firm_id ="<?=$ek1firmforms['firm_id'];?>"
										data-firm_branch_id  ="<?=$ek1firmforms['firm_branch_id'];?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update')?>"
										><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('ek1firmforms.delete')){ ?>

									<?php if($ax->firmid==0 || ($ek1firmforms['firmid']==$ax->firmid)|| (($ek1firmforms['firmid']==$ax->firmid) && ($ek1firmforms['branchid']==$ax->branchid))){?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$ek1firmforms['id'];?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete')?>"><i style="color:#fff;" class="fa fa-trash"></i></a>


									<?php }}?>
									</td>
                                </tr>

								<?php endforeach;?>


                        </tbody>
                      
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>





<?php if (Yii::app()->user->checkAccess('ek1firmforms.update')){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Firm Service Report Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					
					<!--form baslang��-->
						<form id="treatment-form" action="/ek1FirmForms/update/0" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalid" name="ek1firmforms[id]" value="0">

								<?php if($ax->firmid==0){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm2" name="ek1firmforms[firmid]" onchange="myfirm2()" requred>
									<option value="0"><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm2" name="ek1firmforms[firmid]" value="<?=$ax->firmid;?>" requred>
						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch2" name="ek1firmforms[branchid]" disabled requred>
									<option value="0"><?=t('Please Chose');?></option>

									<?php									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch2" name="ek1firmforms[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>


						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Form Adı');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="formname2" name="ek1firmforms[formname]" onchange="mydefaultform2()">
									<option value="0"><?=t('Please Chose');?></option>
									<?$ek1Forms=Ek1Forms::model()->findall(array('condition'=>'is_active=1'));
									 foreach($ek1Forms as $ek1Form){?>
									<option value="<?=$ek1Form->id;?>"><?=$ek1Form->name;?></option>
									<?php }?>
								</select>
							</fieldset>
						</div>
						
					
						
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                            <label for="basicSelect"><?=t('Formdaki Default Gelecek Özellikler');?></label>
                            <fieldset class="form-group">

                                <select class="select2-placeholder-multiple form-control" style="width:100%" id="defaultform2" multiple="multiple"   name="ek1firmforms[defaultform][]" disabled>
                                    <option value="0"><?=t('All');?></option>
                                  

                                </select>
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


	<!-- G�NCELLEME B�T��-->
<?php }?>
<?php if (Yii::app()->user->checkAccess('ek1firmforms.delete')){ ?>
	<!--S�L BA�LANGI�-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Firm Service Report Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="treatment-form" action="/ek1FirmForms/delete" method="post">

						<input type="hidden" class="form-control" id="modaldeleteid" name="ek1firmforms[id]" value="0">

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


	<?php }?>

<?php }?>
	<!-- S�L B�T�� -->



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

 function myfirm2()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

 function mydefaultform()
{
  $.post( "/Ek1FirmForms/defaultforms?id="+document.getElementById("formname").value).done(function( data ) {
		$("#defaultform" ).prop( "disabled", false );
		$('#defaultform').html('');
		var d=JSON.parse(data);
		$('#defaultform').append("<option value='0'><?=t('Seçiniz')?></option>");
		for(let i=0;i<d.length;i++)
		{
			$('#defaultform').append("<option value='"+d[i].id+"'>"+d[i].name+"</option>");
		}
		
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

 function mydefaultform2()
{
  $.post( "/Ek1FirmForms/defaultforms?id="+document.getElementById("formname2").value).done(function( data ) {
		$("#defaultform2" ).prop( "disabled", false );
		$('#defaultform2').html('');
		var d=JSON.parse(data);
		$('#defaultform2').append("<option value='0'><?=t('Seçiniz')?></option>");
		for(let i=0;i<d.length;i++)
		{
			$('#defaultform2').append("<option value='"+d[i].id+"'>"+d[i].name+"</option>");
		}
		
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}


<?php if($ax->firmid!=0){?>
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
<?php }?>

function openmodal(obj)
{


	$('#modalid').val($(obj).data('id'));
	$('#firm2').val($(obj).data('firm_id'));
	$('#firm2').select2('destroy');
	$('#firm2').select2({
			closeOnSelect: false,
			allowClear: true
	});

	  $.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		$('#branch2').val($(obj).data('firm_branch_id'));
		$('#branch2').select2('destroy');
		$('#branch2').select2({
				closeOnSelect: false,
				allowClear: true
		});

	});
	
	
	$('#formname2').val($(obj).data('ek1_form_id'));
	$('#formname2').select2('destroy');
	$('#formname2').select2({
			closeOnSelect: false,
			allowClear: true
	});


	
	
	$.post( "/Ek1FirmForms/defaultforms?id="+document.getElementById("formname2").value).done(function( datak ) {
		$("#defaultform2" ).prop( "disabled", false );
		$('#defaultform2').html('');
		var d=JSON.parse(datak);
		$('#defaultform2').append("<option value='0'><?=t('Seçiniz')?></option>");
		
		for(let i=0;i<d.length;i++)
		{
			var datamm=$(obj).data('defaults_json_data').split(',').find(k=>k==d[i].id);
			console.log('dsfsdf'+datamm);
			$('#defaultform2').append("<option "+(datamm!=-1 && datamm!=undefined?'selected':'')+" value='"+d[i].id+"'>"+d[i].name+"</option>");
		}
		
	
	});
	
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modaldeleteid').val($(obj).data('id'));
	$('#sil').modal('show');

}

function authchange(data,permission,obj)
{
$.post( "?", { typeid: data, active: permission })
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
 buttons: [
        {
            extend: 'copyHtml5',
          exportOptions: {
                 columns: [0,1,2]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder Treatment Type (<?=date("d-m-Y H:i:s");?>)\n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [0,1,2]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder Treatment Type (<?=date("d-m-Y H:i:s");?>)\n',
        },



		{
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Workorder Treatment Type',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Treatment Type \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },

					{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 10,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]

				});
			  }

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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';



?>
