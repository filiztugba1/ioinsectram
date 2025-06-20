<?php
	User::model()->login();
	$ax= User::model()->userobjecty('');
	$documentCatulkewhere='';
	$who=User::model()->whopermission();
	if($who->type!=0)
	{
		$country=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->firmid)));
		  if(intval($country['country_id'])==1)
		  {
			  $documentCatulkewhere=' and id!=45';
		  }
	}
	$categorys=Documentcategory::model()->findAll(array('order'=>'id ASC','condition'=>'isactive=1 and parent=0'.$documentCatulkewhere));
	
						?>

<?php $clientbtitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_GET['id'])));


$monitoring=Monitoring::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'condition'=>'clientid='.$_GET['id'],
));



$department=Departments::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'order'=>'name ASC',
    'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
));


if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
	}

if($who->type==0)
	{
	$firm=Firm::model()->findall(array('condition'=>'parentid=:parentid','params'=>array('parentid'=>0)));
	}
	else if($who->type==1)
	{
	$firm=Firm::model()->findall(array('condition'=>'parentid=:parentid','params'=>array('parentid'=>$ax->firmid)));

	}

	else if($who->type==2)
	{
	$firm=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid=:firmid and isdelete=0','params'=>array('firmid'=>$ax->branchid)));

	}
	else if($who->type==3)
	{
	$firm=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=:parentid and isdelete=0','params'=>array('parentid'=>$ax->clientid)));

	}

?>


<?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>
<?=User::model()->geturl('Client','Documents',$_GET['id'],'files');?>

			<div class="card">
		<div class="card-header" style="">
							<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
						  <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?$say=User::model()->findAll(array('condition'=>'clientbranchid='.$_GET['id']));
									echo count($say);?>
									</span><?=t('Staff');?>

							</a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

						  <li class="nav-item">
							<a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $department);?></span><?=t('Departments');?></a>
						  </li>
					   <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
							<li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

					      <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
						   <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a>
						  </li>

					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

					        <li class="nav-item">
							<a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/files/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a></a>
						  </li>
						<?php }?>

								<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a></a>
                      </li>
					 <?//}?>



                    </ul>
				</div>

</div>


		<!-- HTML5 export buttons table -->
<div class="row tablelist" >
    <div class="col-lg-4 col-md-4 col-sm-12" id="documents">
       <div class="card">
			<div class="card-content collapse show">
				<div class="card-body card-dashboard">
					<h4 id='documentsh4' class="card-title"><?=t('Müşteri Dosyaları').' '.mb_strtoupper(t('Category List'));?></h4>
				<div class="treex well">
				  <div class="horizontal-scroll scroll-example height-300">
                      <div class="horz-scroll-content">
					<?Documents::model()->kategoritabloyaz(33,0,$_GET['id']);?>
					</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>


<?php if (Yii::app()->user->checkAccess('documents.create')){ ?>
	<div class="col-lg-12 col-md-12 col-sm-12" id="createpage">
		<div class="card">
			<div class="card-header">
				<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					<div class="col-md-6">
						<h4  class="card-title"><?=t('Document Create');?></h4>
					</div>
				<div class="col-md-6">
					<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
            <div class="heading-elements"></div>
        </div>
        <div class="card-content collapse show">
			<div class="card-body">
				<form id="documents-form-create" >
					<div class="row">
						<input type="hidden" class="form-control" id="categoriid" value="33"  name="Documents[categoryid]">
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('File Upload');?></label>
							<fieldset class="form-group">
								<input type="file" class="form-control" id="basicInput" name="Documents[fileurl][]" id="dosya[]" multiple="multiple">
							</fieldset>
						</div>


						<?php if($who->type!=4){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('View Sub Firm');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" multiple="multiple" id="multi_placehodler" style="width:100%;" name="Documents[viewer][]">
								<!-- <option value="-1">Yanlızca Sen</option> -->
										<option value="0"><?=t('All');?></option>
										<?php
											foreach($firm as $firmx)
											{
												if($who->type==2){
													?><optgroup  label="<?=$firmx->name;?>"></option><?php														$cb=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=:parentid and isdelete=0','params'=>array('parentid'=> $firmx->id)));
													foreach($cb as $cbx)
													{
														if($cbx->firmid==$ax->branchid){?>
														<option value="<?=$cbx->id;?>"> <?=$firmx->name;?> -> <?=$cbx->name;?></option>
													<?php }}



													}
												else
												{?>
													<option value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
												<?php }

												?>


											<?php }
											if($who->type==2){
												$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and  firmid='.$who->id.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
														foreach($tclient as $tclientx)
														{

															$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and  id='.$tclientx->mainclientid));
															foreach($tclients as $tclientsx)
															{?>
															<optgroup label="<?=$tclientsx->name;?>">
															<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and  parentid='.$tclientsx->id.' and firmid='.$who->id));
															foreach($tclientbranchs as $tclientbranchsx)
															{?>
																<option value="<?=$tclientbranchsx->id;?>"> <?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
															<?php }?>
															</optgroup>
															<?php }

														}

											}

											?>
								</select>
							</fieldset>
						</div>

						<?php }?>

					  	<div class="col-xl-5 col-lg-5 col-md-5 mb-1">
							<label for="basicSelect" style="margin-top:15px"></label>
							<fieldset class="form-group">
								<div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page-create" type="submit"><?=t('Submit');?></button>
								</div>
							</fieldset>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>
<?php }?>



<div class="col-lg-7 col-md-7 col-sm-12" id="documentlist">

</div>

</div>


	<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Document Sub View');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id='documents-form-update'>
                            <div class="modal-body">
							<input type="hidden" class="form-control" id="modaldocumentid" name="Documents[id]" value="0">
							<input type="hidden" class="form-control" id="modaldocumenttype" name="Documents[documenttype]">
							<input type="hidden" class="form-control" id="gcategoriid" value="<?=$categorys->id;?>"  name="Documents[categoryid]">

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="modaldocumentname">

						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="modalurl">

						</div>




							<?php if($who->type!=4){?>
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('View Sub Firm');?></label>
										<fieldset class="form-group">
											  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="subfiles" style="width:100%;" name="Documents[viewer][]">
													<!-- <option value="-1">Yanl�zca Sen</option> -->
										<option value="0"><?=t('All');?></option>
													<?php
													foreach($firm as $firmx)
													{
														if($who->type==2){
															?><optgroup  label="<?=$firmx->name;?>"></option><?php																$cb=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=:parentid and isdelete=0','params'=>array('parentid'=> $firmx->id)));
															foreach($cb as $cbx)
															{?>
																<option value="<?=$cbx->id;?>"> <?=$firmx->name;?> -> <?=$cbx->name;?></option>
															<?php }
														}
														else
														{?>
															<option value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
														<?php }

														?>


													<?php }


												if($who->type==2){
												$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$who->id.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
														foreach($tclient as $tclientx)
														{

															$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
															foreach($tclients as $tclientsx)
															{?>
															<optgroup label="<?=$tclientsx->name;?>">
															<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$who->id));
															foreach($tclientbranchs as $tclientbranchsx)
															{?>
																<option value="<?=$tclientbranchsx->id;?>"> <?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
															<?php }?>
															</optgroup>
															<?php }

														}

											}




													?>
											  </select>
										</fieldset>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id='arsivorguncelid'>
								<label for="basicSelect"><?=t('Arşiv or güncel');?></label>
									<fieldset class="form-group">
										 <select class="custom-select block" id="arsivorguncel" name="Documents[arsivorguncel]">
											<option value="0"><?=t('Arşiv');?></option>
											<option value="1"><?=t('Güncel');?></option>
										 </select>
									</fieldset>
								</div>

                            </div>

							<?php }?>
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
<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}





</style>


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
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.treex li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
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
    text-decoration:none
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
			$("#subdepartmentclient" ).prop( "disabled", false );

		 });
}
//ekle bölümü bitiş


//Güncelle bölümü baslangıc




function myFunction2() {
	yy=document.getElementById("typeselect2").value;
		 $.post( "/client/subdepartments2?id="+yy).done(function( data ) {
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


<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

 $(document).ready(function(){


$.post( "/documents/documentlist?id="+document.getElementById("categoriid").value+'&&firmid=<?=$who->id;?>&&cbid=<?=$_GET['id'];?>&&firmtype=<?=$who->type;?>').done(function( list ) {
	   	$.unblockUI();
			$('#documentlist').html(list);
			$('[data-toggle="tooltip"]').tooltip({
				container:'body'
			});

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

				'pageLength'
			],
			columnDefs: [
            {
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );

		$('.dataex-html5-export').removeClass('dataTable');
		$("#createbutton").click(function()
		{
			$("#createpage").toggle(500);
		});
		$("#cancel").click(function()
		{
			$("#createpage").hide(500);
		});

		$('.category').on('click', function()
		{
			var block_ele = $('.tablelist');
			$(block_ele).block({
			message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
			timeout: 100, //unblock after 2 seconds
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



 //documents create post start
 $("#documents-form-create").on('submit',(function(e) {
    e.preventDefault();

	jQuery.ajax({
   url:"/documents/create3",
    data: new FormData(this),
    cache: false,
    contentType: false,
    processData: false,
    method: 'POST',
    type: 'POST', // For jQuery < 1.9
    success: function(data)
	{
       $.post( "/documents/documentlist?id="+document.getElementById("categoriid").value).done(function( list )
		{
		   	$.unblockUI();
			$('#documentlist').html(list);
			$('[data-toggle="tooltip"]').tooltip({
				container:'body'
			});

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

				'pageLength'
			],
			columnDefs: [
            {
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );

		$('.dataex-html5-export').removeClass('dataTable');
		$("#createbutton").click(function()
		{
			$("#createpage").toggle(500);
		});
		$("#cancel").click(function()
		{
			$("#createpage").hide(500);
		});

		$('.category').on('click', function()
		{
			var block_ele = $('.tablelist');
			$(block_ele).block({
			message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
			timeout: 100, //unblock after 2 seconds
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
		var value = jQuery.parseJSON( data );
		for(i=1;i<value.length;i++)
		{
			if(value[i]!='')
			{
				var ayir=value[i].split(',');
				if(ayir[1]==1)
				{
					toastr.success("<center>"+ayir[2]+' '+'<?=t('add successful!');?>'+"</center>", "<center><?=t('Successful!');?></center>", {
					positionClass: "toast-top-right",
					containerId: "toast-top-right"
					});
				}
				else
				{
					toastr.error("<center>"+ayir[2]+" <?=t('document not add.');?><?=t('Max document limit')?>"+ayir[0]+"</center>", "<center><?=t('Error!');?></center>", {
					positionClass: "toast-top-right",
					containerId: "toast-top-right"
					});

				}
			}
		}
		$.unblockUI();

    }
	});
 }));


 //documents create post start
 $("#documents-form-update").on('submit',(function(e) {
    e.preventDefault();

	jQuery.ajax({
    url:"/documents/update3",
    data: new FormData(this),
    cache: false,
    contentType: false,
    processData: false,
    method: 'POST',
    type: 'POST', // For jQuery < 1.9
    success: function(data)
	{	// alert(data);
       $.post( "/documents/documentlist?id="+document.getElementById("categoriid").value).done(function( list )
		{
			$('#documentlist').html(list);
			$('[data-toggle="tooltip"]').tooltip({
				container:'body'
			});

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

				'pageLength'
			],
			columnDefs: [
            {
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );

		$('.dataex-html5-export').removeClass('dataTable');
		$("#createbutton").click(function()
		{
			$("#createpage").toggle(500);
		});
		$("#cancel").click(function()
		{
			$("#createpage").hide(500);
		});

		$('.category').on('click', function()
		{
			var block_ele = $('.tablelist');
			$(block_ele).block({
			message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
			timeout: 2000, //unblock after 2 seconds
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
		var value = jQuery.parseJSON( data );
		for(i=1;i<value.length;i++)
		{
			if(value[i]!='')
			{
				var ayir=value[i].split(',');
				if(ayir[1]==1)
				{
					toastr.success("<center>"+ayir[2]+' '+'<?=t('add successful!');?>'+"</center>", "<center><?=t('Successful!');?></center>", {
					positionClass: "toast-top-right",
					containerId: "toast-top-right"
					});
				}
				else
				{
					toastr.error("<center>"+ayir[2]+" <?=t('document not add.');?><?=t('Max document limit')?>"+ayir[0]+"</center>", "<center><?=t('Error!');?></center>", {
					positionClass: "toast-top-right",
					containerId: "toast-top-right"
					});

				}
			}
		}
		$.unblockUI();
		$('#duzenle').modal('hide');
    }
	});
 }));




	$("#monitoring-form").on('submit',(function(e) {
	e.preventDefault();
	 $.ajax({
      url: "/monitoring/create",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data)
        {
			if(data=='ok')
			{
				toastr.success("Monitoring is create successful!","<center>Successful</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				});

				$.post("/monitoring/monitoringlist?id="+<?=$_GET['id'];?>).done(function( data ) {
					$('#list').html(data);
					<?php					 $monitorcount=Monitoring::model()->find(array(
								   'order'=>'mno DESC',
								   'condition'=>'clientid='.$_GET['id'],
							   ));
							   ?>
					$('#monitorno').val(<?=($monitorcount->mno)+2;?>);
				});

				$.post("/monitoring/monitoringinput?id="+<?=$_GET['id'];?>).done(function( datax ) {
					$('#monitorno').html(datax);
				});


			}
			if(data=='no')
			{
				toastr.error("Available Data!","<center>Error</center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				});
			}
        }
     });


  }));
 });



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
var arsivStatus=1;

function statusFiltre(obj)
{
	arsivStatus=$(obj).data('status')==3?0:$(obj).data('status');
	$.blockUI({
			message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
			timeout: 200000, //unblock after 200 seconds
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
	category(obj);
}
  function category(obj)
{
var status=1;
if($(obj).data('status'))
{
	status=$(obj).data('status')==3?0:$(obj).data('status');
}

	$('#categoriid').val($(obj).data('id'));
	$.post( "/documents/documentlist?id="+$(obj).data('id')+'&&firmid=<?=$who->id;?>&&cbid=<?=$_GET['id'];?>&&firmtype=<?=$who->type;?>&status='+status).done(function( data ) {

			$('#documentlist').html(data);
			$('#documentlisth4').html($(obj).data('name'));


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

				'pageLength'
			],
			columnDefs: [
            {
               // "targets": [ 4],
                "visible": false,
                "searchable": false
            },
			]
		} );

		<?php		$ax= User::model()->userobjecty('');
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

				$('.dataex-html5-export').removeClass('dataTable');


		// Tooltip Initialization
        $('[data-toggle="tooltip"]').tooltip({
            container:'body'
        });


			$("#createpage").hide();
			$("#createbutton").click(function(){
					$("#createpage").toggle(500);
			 });
			 $("#cancel").click(function(){
					$("#createpage").hide(500);
			 });
			 	 $.unblockUI();


				 	 // Block sidebar
					$('.category').on('click', function() {
						var block_ele = $('.tablelist');
						$(block_ele).block({
							message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
							timeout: 2000, //unblock after 2 seconds
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

}

function openmodal(obj)
{

	$('#modaldocumentid').val($(obj).data('id'));
		$('#gcategoriid').val(document.getElementById("categoriid").value);


	if($(obj).data('dosyadurum')==1)
	{
	$('#modaldocumentname').html("<label for='basicSelect'><?=t('Name');?></label><fieldset class='form-group'><input type='text' class='form-control' id='basicInput' name='Documents[name]' value='"+$(obj).data('name')+"'></fieldset>");
	$('#modalurl').html("<label for='basicSelect'><?=t('Update File Upload');?></label><fieldset class='form-group'><input type='file' class='form-control' id='basicInput' name='Documents[fileurl][]' id='dosya[]' multiple='multiple'></fieldset>");
	}
	else
	{
	$('#modaldocumentname').html("");
	$('#modalurl').html("");
	}


	 $.post( "/documents/subview?id="+$(obj).data('id')+'&&subtype=<?=$who->subtype;?>&&firmid=<?=$who->id;?>&&type=<?=$who->type;?>&&documenttype='+$(obj).data('documenttype')+'&&categoryid='+$(obj).data('categoryid')).done(function( data ) {

		 var value = jQuery.parseJSON( data );



		//alert(value);
		// if($(obj).data('categoryid')==34 || $(obj).data('categoryid')==35)
		// {
		// 	$('#arsivorguncelid').show();
		//
    //   $('#arsivorguncel').val($(obj).data('arsivorguncel'));
    //   	/*
		// 	$('#arsivorguncel').select2('destroy');
		// 	$('#arsivorguncel').select2({
		// 		closeOnSelect: false,
		// 			 allowClear: true
		// 	});
    //   */
		//
		// }else {
		// 	$('#arsivorguncelid').hide();
		// }

			$('#subfiles').val(value.split(','));
			 $('#subfiles').select2('destroy');
			$('#subfiles').select2({
				closeOnSelect: false,
					 allowClear: true
			});

					 $.unblockUI();
	 });


	$('#duzenle').modal('show');

}

function tabs(obj)
{


	$('#categoriid').val($(obj).data('id'));

	  $.post( "/documents/documentmenu?id="+$(obj).data('id')).done(function( data ) {

			$('#documents').html(data);

			$(function () {
				$('.treex li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
				$('.treex li.parent_li > span').on('click', function (e) {
					var children = $(this).parent('li.parent_li').find(' > ul > li');
					if (children.is(":visible")) {
						children.hide('fast');
						$(this).attr('title', 'Expand this branch').find(' > i').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
					} else {
						children.show('fast');
						$(this).attr('title', 'Collapse this branch').find(' > i').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
					}
					e.stopPropagation();
				});
			});


	 });


	 $.post( "/documents/documentlist2?id="+$(obj).data('id')).done(function( data ) {
			$('#documentlist').html(data);

		$("#createpage").hide();
			$("#createbutton").click(function(){
					$("#createpage").toggle(500);
			 });
			 $("#cancel").click(function(){
					$("#createpage").hide(500);
			 });
	 });


}



function openmodalsil(obj)
{
	$('#modalmonitorid2').val($(obj).data('id'));
	$('#sil').modal('show');

}







$(document).ready(function() {

/******************************************
*       js of HTML5 export buttons        *
******************************************/

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },

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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/ui/scrollable.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
