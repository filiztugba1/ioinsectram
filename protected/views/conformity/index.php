
<?phpUser::model()->login();
$ax= User::model()->userobjecty('');
?>

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>
	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity','',0,'conformity');?>
<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
					<div class="col-md-6">
						<h4  class="card-title"><?=t('Non-Conformity Create');?></h4>
					</div>
					<div class="col-md-6">
						<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
					</div>
				</div>
			</div>
			<form id="conformity-form" action="/conformity/create" method="post" enctype="multipart/form-data">
				<div class="card-content">
					<div class="card-body">
						<div class="row">
						<?php						$workordervarmi=0;
						
						if(isset($_GET['workorderid'])){
							$workorder=Workorder::model()->find(array('condition'=>'id='.$_GET['workorderid']));
							// var_dump($workorder);
							if($workorder)
							{?>
							<input type="hidden" class="form-control" id="firm" name="Conformity[firmid]" value="<?=$workorder->firmid?>">
							<input type="hidden" class="form-control" id="branch" name="Conformity[branchid]" value="<?=$workorder->branchid?>">
							<input type="hidden" class="form-control"  name="Conformity[firmbranchid]" value="<?=$workorder->branchid?>">
							<input type="hidden" class="form-control" id="client" name="Conformity[clientid]" value="<?=$workorder->clientid?>">
							<input type="hidden" class="form-control" id="client" name="Conformity[workorderid]" value="<?=$_GET['workorderid']?>">
								
						<?php						$workordervarmi=1;
						}}
						
						if(!$workordervarmi){
						?>
						
							<?php if($ax->firmid==0){?>
								<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
									<label for="basicSelect"><?=t('Firm');?></label>
									<fieldset class="form-group">
										<select class="select2" style="width:100%" id="firm" name="Conformity[firmid]" onchange="myfirm()">
											<option value="0">Please Chose</option>
												<?php												$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
												 foreach($firm as $firmx){?>
												<option <?php if($firmx->id==$workorder->firmid){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
												 <?php }?>
										</select>
									</fieldset>
								</div>
								<?php }else{?>
									<input type="hidden" class="form-control" id="firm" name="Conformity[firmid]" value="<?=$ax->firmid;?>">
								<?php }?>
								<?php if($ax->branchid==0){?>
									<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?=t('Branch');?></label>
										<fieldset class="form-group">
											<select class="select2" style="width:100%" id="branch" name="Conformity[branchid]" onchange="mybranch()" disabled requred>
											</select>
										</fieldset>
									</div>
									<?php }else{?>
										<input type="hidden" class="form-control" id="branch" name="Conformity[branchid]" value="<?=$ax->branchid;?>">
									<?php }?>
									<?php if($ax->clientbranchid==0){?>
										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">
                          <select class="select2" style="width:100%" id="client" name="Conformity[clientid]" disabled onchange="myFunctionClient()">
														<option value="0"><?=t("Select");?></option>
														<?php														if($workorder->branchid!=0){
															$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$workorder->branchid));
															foreach($client as $clientx)
															{ $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
																	if(count($clientbranchs)>0){?>
																		<optgroup label="<?=$clientx->name;?>">
																		<?php																		foreach($clientbranchs as $clientbranch)
																		{?>
																			<option <?php if($clientbranch->id==$workorder->clientid){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
																		<?php }?>
																	</optgroup>
																	<?php }?>
															<?php }
															$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
															foreach($tclient as $tclientx)
															{
																$tclients=Client::model()->findAll(array('condition'=>'id='.$tclientx->mainclientid));
																foreach($tclients as $tclientsx)
																{?>
																	<optgroup label="<?=$tclientsx->name;?>">
																		<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$workorder->branchid));
																		foreach($tclientbranchs as $tclientbranchsx)
																		{?>
																			<option <?php if($tclientbranchsx->id==$workorder->clientid){echo "selected";}?>  value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
																		<?php }?>
																</optgroup>
																<?php }
															}
														}?>
													</select>
                        </fieldset>
                    	</div>
										<?php }else{?>
												<input type="hidden" class="form-control" id="client" name="Conformity[clientid]" value="<?=$ax->branchid;?>">
										<?php }?>
						<?php }?>
										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
										<label for="basicSelect"><?=t('Department');?></label>
											<fieldset class="form-group">
												<select class="select2" style="width:100%" id="department" name="Conformity[departmentid]" onchange="myFunctionDepartment()" <?!$workordervarmi?'disabled':''?>>
													<option value="0"><?=t('Please Chose');?></option>
												</select>
											</fieldset>
										</div>

										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
												<label for="basicSelect"><?=t('Sub-Department');?></label>
													<fieldset class="form-group">
														<select class="select2" style="width:100%" id="subdepartment" name="Conformity[subdepartmentid]" disabled>
															<option value="0"><?=t('Please Chose');?></option>

															<?php															if($workorder->firmid!=0){
															$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
															 foreach($branch as $branchx){?>
															<option <?php if($branchx->id==$workorder->branchid){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
															<?php }}?>
														</select>
													</fieldset>
											</div>
											<?php											$type=Conformitytype::model()->findAll(array(
														   #'select'=>'',
														   #'limit'=>'5',
														   'order'=>'name ASC',
														   'condition'=>'isactive=1',
													   ));

											?>
											<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											 	<label for="basicSelect"><?=t('Non-Conformity Type');?></label>
						            <fieldset class="form-group">
												  <select class="select2" id="conformitytype" style="width:100%" name="Conformity[type]" disabled>
						                  <option value="0" selected=""><?=t('Please Chose');?></option>
																<?php																	foreach($type as $typex){?>
																		<option value="<?=$typex->id;?>"><?=t($typex->name);?></option>
																<?php }?>
													</select>
						            </fieldset>
						  				</div>
											<input type="hidden"  class="form-control"  name="Conformity[statusid]" value="0">

											<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
												<label for="basicSelect"><?=t('Priority');?></label>
                        <fieldset class="form-group">
                          <select class="select2" style="width:100%" name="Conformity[priority]">
														<option value="1"><?=' '.t('1. Degree');?></option>
														<option value="2"><?=' '.t('2. Degree');?></option>
														<option value="3"><?=' '.t('3. Degree');?></option>
														<option value="4"><?=' '.t('4. Degree');?></option>
													</select>
                        </fieldset>
                    	</div>
											<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
													<label for="basicSelect"><?=t('Date');?></label>
                          	<input type="date"  class="form-control"  placeholder="<?=t('Date');?>" name="Conformity[date]" value="<?=date('Y-m-d');?>">
                        </fieldset>
                    	</div>
											<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
													<label for="basicSelect"><?=t('Upload File');?></label>
                          <input type="file"  class="form-control"  name="Conformity[filesf]">
                        </fieldset>
                    	</div>
						
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
                        <fieldset class="form-group">
													<label for="basicSelect"><?=t('Tamamlama Fotoğrafı');?></label>
                          <input type="file"  class="form-control"  name="Conformity[filesf2]">
                        </fieldset>
                    	</div>
						

											<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
													<label for="basicSelect"><?=t('Definition');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Definition');?>" name="Conformity[definition]"></textarea>
                        </fieldset>
                    	</div>

											<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
                        <fieldset class="form-group">
													<label for="basicSelect"><?=t('Suggestion / Preventative Action');?></label>
                          <textarea  class="form-control"  placeholder="<?=t('Suggestion / Preventative Action');?>" name="Conformity[suggestion]"></textarea>
                        </fieldset>
                    	</div>

					  				  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
	                        <div class="input-group-append" id="button-addon2" style="float:right">
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
<?php if(!isset($_GET['workorderid'])){?>
<section id="html5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
						<div class="col-xl-7 col-lg-9 col-md-9 mb-1">
						 	<h4 class="card-title"><?=t('NON-CONFORMITY LIST');?></h4>
						</div>
						<div class="col-xl-5 col-lg-3 col-md-3 mb-1">
							<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.create') && $ax->clientid==0){ ?>
								<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="createbutton" type="submit"><?=t('Add Non-Conformity');?> <i class="fa fa-plus"></i></a>
							<?php }?>
							<a href='/conformity/reports' target="_blank" style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="reportbutton" type="submit"><?=t('Reports');?> <i class="fa fa-file"></i></a>
					 </div>
					 <div class="col-xl-12 col-lg-12 col-md-12 mb-1" style='background:#e0ebff;padding:12px 10px 12px 0px;    border-radius: 5px;'>
						<?$status=Conformitystatus::model()->findAll(array('order'=>'sira desc'));
								foreach($status as $statusk){?>
								<a data-id="<?=$statusk->id;?>"  class="btn btn-<?=$statusk->btncolor;?> btn-sm statusFiltre" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t($statusk->name);?> </a>
						<?php }?>
						<a data-id="-1" class="btn btn-sm bet-default statusFiltre" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t('All');?> </a>
					 </div>
				 </div>
			 </div>
			 
			 <div class="card-content collapse show">
				 <div class="card-body card-dashboard" id='confotmityListTable'></div>
			 </div>
			
		 </div>
	 </div>
 </div>
</section>
 <?php }?>
        <!--/ HTML5 export buttons table -->

	<!--delelete all start-->

<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="form-group">
		<div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-danger white">
						<h4 class="modal-title" id="myModalLabel8"><?=t('Non-Conformity Delete');?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

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
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- delete all finish -->

<?php }
?>
<style>
#waypointsTable tr:hover {
    background-color:#ccdcf7;
}
.select2-selection__choice{
	    min-width: 127px !important;
}
</style>

<script>
$("#createpage").hide();
$("#reports").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

$("#reportbutton").click(function(){
        $("#reports").toggle(500);
 });
 $("#cancel1").click(function(){
        $("#reports").hide(500);
 });

<?php if(isset($_GET['workorderid']) && $workordervarmi){?>
	$("#createpage").toggle(500);
	
		$.post( "/conformity/client?id="+document.getElementById("client").value).done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});

	$.post( "/conformity/conformitytype?id="+document.getElementById("client").value+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
	});
	
<?php }?>




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



<?php if($ax->firmid!=0){?>
	$( "#branch" ).prop( "disabled", false );
	$( "#branch2" ).prop( "disabled", false );
	if($("#firm").length>0)
	{
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});
	}


<?php }?>

<?php if($ax->branchid!=0){?>
	if($("#branch").length>0)
	{
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	}

<?php }?>



<?php if($ax->clientid!=0){?>
	if($("#branch").length>0)
	{
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
	}

<?php }?>


<?php if($ax->clientbranchid!=0){?>
	if($("#client").length>0)
	{
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

<?php }?>

function myfirm()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

 function mybranch()
{
	if(document.getElementById("branch").value)
	{
		$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
			$( "#client" ).prop( "disabled", false );
			$('#client').html(data);
		});
	}
	if(document.getElementById("branch2").value)
	{
		$.post( "/workorder/client?id="+document.getElementById("branch2").value).done(function( data ) {
			$( "#client2" ).prop( "disabled", false );
			$('#client2').html(data);
		});
	}
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


function aramaClick()
{
	var selected = [];
	 for (var option of document.getElementById('status2').options) {
		 if (option.selected) {
			 selected.push(option.value);
		 }
	 }
	uygunsuzlukListeGetir();
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


<script>

$(document).ready(function(){
//YoksisListe(); 

var listTable = []; 
function document(classname,columns,pdfbaslik,columnsData,url,data)  {
		$("#backgroundLoading").removeClass("loadingDisplay");  
	$('.'+classname+' tbody').empty(); 
	dataTable = $("." + classname).DataTable({
    dom: 'Bfrtip',
		"order": [[5, 'desc']],
		"scrollX": true,
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
	/*	select: {
					 style:    'os',
					 selector: 'td:first-child'
			 },
			 */
			 select:true ,

	 buttons: [
      /*  {
					extend: "excelHtml5", 
					exportOptions: { columns: columns },
 text: '<?=t("Excel");?>', 
					className: "d-none d-sm-none d-md-block", 
					title: pdfbaslik+"-<?=date("d/m/Y");?>",
 messageTop: pdfbaslik
        },
				{ 
					 extend: "pdfHtml5",
					 exportOptions: { 
						  columns: columns 
						}, 
						 text: "<?=t('Pdf');?>", 
						 title: pdfbaslik+'<?=date("d/m/Y");?>', 
						 header: true, 
						 customize: function (doc) { 
							 doc.content.splice(0, 1, { 
								 text: [{ 
									 text: "\n", 
									 bold: true, 
									 fontSize: 16, 
									 alignment: "center" 
								 }, 
								 { 
									 text: pdfbaslik + "\n", 
								   bold: true, 
									 fontSize: 12, 
									 alignment: "center" 
								 }, 
								 { 
									 text: '<?=date("d/m/Y");?>', 
									  bold: true, 
										fontSize: 11,
										alignment: center 
									}], 
									 margin: [0, 0, 0, 12] 
								  });
						} 
					}, */
        'colvis',
		'pageLength',


	],
		"columns": columnsData, 
		"ajax": {
					 "type" : "GET",
					 "url" : url,
					 "dataSrc": function ( json ) {
							 //Make your callback here.
							 	$("#backgroundLoading").addClass("loadingDisplay"); 
								if(json.status==200)
								{
									return json.response;
								}
								else {
									alert("hata");
									return [];
								}

					 },
            error: function (xhr, error, code)
            {
                console.log(xhr);
                console.log(code);
            }
				 },
		"rowCallback": function (row, data) {
			$(row).addClass("trUrl");
			if (data.color != "" && data.color != undefined && data.color != null) { 
				$(row).css("backgroundColor", data.color);

			} }



} );
isDataTableIndex = listTable.findIndex(x => x.class == classname); 
if (isDataTableIndex != undefined && isDataTableIndex != null) { 
	listTable.splice(isDataTableIndex, 1); 
} 
	listTable.push({"class": classname, "value": dataTable});
}
//// liste çekiliş başlıyor //////
 var freeListColumnArray = [ 
	{"key": "cnumber", "value": "<?=mb_strtoupper(t('NON-CONFORMITY NO'));?>"}, 
	{"key": "userName", "value": "<?=mb_strtoupper(t('WHO'));?>"}, 
	{"key": "clientName", "value": "<?=mb_strtoupper(t('TO WHO'));?>"}, 
	{"key": "departmentName", "value": "<?=mb_strtoupper(t('Department'));?>"}, 
	{"key": "subName", "value": "<?=mb_strtoupper(t('Sub-Department'));?>"}, 
	{"key": "acilmaTarihi", "value": "<?=mb_strtoupper(t('OPENING DATE'));?>"}, 
	{"key": "activitydefinition", "value": "<?=mb_strtoupper(t('Action Definition'));?>"}, 
	{"key": "deadline", "value": "<?=mb_strtoupper(t('Deadline'));?>"}, 
	{"key": "closedtime", "value": "<?=mb_strtoupper(t('CLOSED TIME'));?>"}, 
	{"key": "conStatus", "value": "<?=mb_strtoupper(t('Status'));?>"}, 
	{"key": "conType", "value": "<?=mb_strtoupper(t('Non-Conformity Type'));?>"}, 
	{"key": "definition", "value": "<?=mb_strtoupper(t('Definition'));?>"}, 
	{"key": "nokdefinition", "value": "<?=mb_strtoupper(t('NOK - COMPLETED DEFINATION'));?>"}, 
	{"key": "etkinlik", "value": "<?=mb_strtoupper(t('EFFICIENCY FOLLOW-UP DEFINATION'));?>"}, 
];
<?php if(!isset($_GET['workorderid'])){?>
tableList("confotmityListTable", "confotmityList", freeListColumnArray, null, "/conformity/newConformityList", "GET", null,"Liste","");
<?php }?>
$('#confotmityList').on( 'select.dt', function ( e, dt, type, indexes ) {
       var data = dt.rows(indexes).data();
				window.open('<?=Yii::app()->baseUrl?>/conformity/activity/'+data["0"]["id"], '_blank');
} );

$('.statusFiltre').on( 'click', function ( e) {

	var data=e.target.dataset.id;
	isDataTableIndex = listTable.findIndex(x => x.class == 'confotmityList'); 
	var table=listTable[isDataTableIndex].value;
	// table.ajax.url= "/conformity/newConformityList?status="+data;
//	table.ajax.reload();
  //table.destroy();
	$("#backgroundLoading").removeClass("loadingDisplay");  
	table.ajax.url( "/conformity/newConformityList?status="+data).load();
  table.draw();
	// tableList("confotmityListTable", "confotmityList", freeListColumnArray, null, "/conformity/newConformityList?status="+data, "GET", null,"Liste","");
});



function tableList(listId, tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = ''){
       tableHtml = '<table class="table table-striped table-bordered ' + tableClass + '" id="'+tableClass+'">' + '<thead>';  
					   if (columnArray[0][0] != undefined && columnArray[0][0] != null)
						 { 
							 for (let i = 0; i < columnArray.length; i++)
							 {
								 tableHtml = tableHtml + '<tr>';
								 if (i == columnArray.length - 1 && listButtonArray != null && listButtonArray != undefined && listButtonArray != '' && listButtonArray.length > 0)
								 { 
									  tableHtml = tableHtml + '<th>İşlem</th>'; 
								 }  
								 for (let j = 0;j < columnArray[i].length;j++)
								 { 
										var colspan=columnArray[i][j]["colspan"]; 
										colspan1=colspan!=null && colspan!=undefined&& colspan!=""?"colspan='"+colspan+"'":"";
										var rowspan=columnArray[i][j]["rowspan"]; 
										rowspan1=rowspan!=null && rowspan!=undefined&& rowspan!=""?"rowspan='"+rowspan+"'":""; 
										tableHtml = tableHtml + '<th '+rowspan1+' '+colspan1+'>' + columnArray[i][j]['value'] + '</th>'; 
								 } 
								 tableHtml = tableHtml + '</tr>';
							 } 
						 }
						 else
						 { 
							 tableHtml = tableHtml + '<tr>'; 
							 if (listButtonArray != null && listButtonArray != undefined && listButtonArray != '' && listButtonArray.length > 0)
							 {
								 tableHtml = tableHtml + '<th>İşlem</th>'; 
							 }  
							 for (var i = 0; i < columnArray.length; i++)
							 { 
								 tableHtml = tableHtml + '<th><a class="column_sort" id="' + columnArray[i]['key'] + '" >' + columnArray[i]['value'] + '</a></th>'; 
							 } 
							  tableHtml = tableHtml + '</tr>';
						}  
							tableHtml = tableHtml +  '</thead>' +'</table>';   
							$('#' + listId).html(tableHtml);
							ApiListeFunc(tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata);
 }

   function ApiListeFunc(tableClass, columnArray, listButtonArray, ajaxUrl, ajaxMethod, formData, pdfName, tabledata = '')
		{     // var namesurname = $(this).data("namesurname"); 

			var columnsData = [];
			var pdfArray = [];
			var defaultContent = '';
			if (listButtonArray != '' && listButtonArray != null && listButtonArray.length != 0 && listButtonArray != undefined)
			{ 
				for (let i = 0; i < listButtonArray.length; i++)
				{ 
					defaultContent += listButtonArray[i]; 
				} 
				if (defaultContent != '')
				 { 
					columnsData.push({ 
						"data": null, 
						className: "center", 
						defaultContent: defaultContent 
					}); 
				}  
			} 
			if (columnArray[0][0] != undefined && columnArray[0][0] != null)
			{ 
				columnArray=columnArray[columnArray.length-1];
			} 
			for (let i = 0; i < columnArray.length; i++)
			{ 
				columnsData.push({"data": columnArray[i]['key']});
				pdfArray.push(i);
			} 
			document(tableClass, pdfArray, pdfName, columnsData, ajaxUrl,null );
  }

});

	 $(document).ready(function() {
    $('#confotmityListTable>.dataTables_scroll>.confotmityList tbody').on('click', 'tr', function () {

        alert( 'You clicked on' );
    } );
} );
function edititem(obj) {
	var url=$(obj).data("url");
	var isurl=$(obj).data("isurl");
	var tableclassname=$(obj).data("tableclassname");
	var ismodal=$(obj).data("ismodal");
			    jQuery('.'+tableclassname+' tr').click(function(e) {
			        e.stopPropagation();
			        var $this = jQuery(this);
			        var trid = $this.closest('tr').attr('id');
			        var x = 0, y = 0; // default values
			    x = window.screenX +5;
			    y = window.screenY +275;
					if(isurl===true)
					{
						window.open(url+"?id="+trid, '_blank');
					}
		 });
}
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
