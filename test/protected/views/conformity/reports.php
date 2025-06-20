<?php

Yii::app()->db->createCommand(
'UPDATE conformity SET statusid=4 WHERE statusid=2')->execute();
User::model()->login();
$ax= User::model()->userobjecty('');

?>
<?php $col='col-xl-4 col-lg-4 col-md-4 mb-1';

if($ax->firmid!=0 && $ax->branchid!=0){
	$col='col-xl-6 col-lg-6 col-md-6 mb-1';
}?>

<?php if (Yii::app()->user->checkAccess('nonconformitymanagement.view')){ ?>
	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Conformity','',0,'conformity');?>

<div  id='reports'>
	<div class="card">
		<div class="card-header">
			<div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
				<div class="col-md-6">
					<h4  class="card-title"><?=t('Search Conformity Report');?></h4>
				</div>
				<div class="col-md-6">
					<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
				</div>
			</div>
		</div>

		<form id="conformity-form">
			<div class="card-content">
				<div class="card-body">
					<div class="row">
						<?php if($ax->firmid==0){?>
						<div class="<?=$col;?>">
							<label for="basicSelect"><?=t('Firm');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="firm" name="Reports[firmid]" onchange="myfirm()" required>
									<option value=""><?=t('Please Chose');?></option>
									<?php									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
									 foreach($firm as $firmx){?>
									<option <?php if(isset($_POST['Reports']['firmid']) &&$firmx->id==$_POST['Reports']['firmid']){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
									 <?php }?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="firm" name="Reports[firmid]" value="<?=$ax->firmid;?>" >
						<?php						$_POST['Reports']['firmid']=$ax->firmid;
					}?>

					<?php if($ax->branchid==0){?>
						<div class="<?=$col;?>">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Reports[branchid]" onchange="mybranch()" <?php if(!isset($_POST['Reports']['branchid']) && $ax->firmid==0){echo 'disabled';}?>  required>
									<option value=""><?=t("Please Choose")?></option>
									<?php									if((isset($_POST['Reports']['firmid']) && $_POST['Reports']['firmid']!=0)){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$_POST['Reports']['firmid']));
									 foreach($branch as $branchx){?>
									<option <?php if(isset($_POST['Reports']['branchid']) &&$branchx->id==$_POST['Reports']['branchid']){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Reports[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php					$_POST['Reports']['branchid']=$ax->branchid;
				}?>

				<?php				if($ax->branchid==0 || ($ax->branchid!=0 && $ax->clientid==0)){?>
				<div class="<?=$col;?>">
					<label for="basicSelect"><?=t('Client');?></label>
					<fieldset class="form-group">
						<select class="select2" style="width:100%" id="client" name="Reports[clientid]" <?php if((!isset($_POST['Reports']['clientid']) && $ax->branchid==0)){echo 'disabled';}?>   onchange="myFunctionClient()">
								<option value="0"><?=t("Select");?></option>
								<?php									$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$ax->branchid));
									foreach($client as $clientx)
										{
										$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
										if(is_countable($clientbranchs) && count($clientbranchs)>0){?>
											<optgroup label="<?=$clientx->name;?>">
												<?php $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));

													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if(isset($_POST['Reports']['clientid'])&& $clientbranch->id==$_POST['Reports']['clientid']){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }

									$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
									foreach($tclient as $tclientx)
									{

										$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
										foreach($tclients as $tclientsx)
										{?>
											<optgroup label="<?=$tclientsx->name;?>">
											<?php $tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$ax->branchid));
											foreach($tclientbranchs as $tclientbranchsx)
											{?>
												<option <?php if($tclientbranchsx->id==$workorder->clientid){echo "selected";}?>  value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
											<?php }?>
											</optgroup>
										<?php }

									}
									?>
							</select>
												</fieldset>
										</div>
					<?php }else if($ax->clientid!=0 && $ax->clientbranchid==0){?>
				<div class="<?=$col;?>">
					<label for="basicSelect"><?=t('Client');?></label>
          <fieldset class="form-group">
						<select class="select2" style="width:100%" id="client" name="Reports[clientid]" <?php if((!isset($_POST['Reports']['clientid']) && $ax->branchid==0)){echo 'disabled';}?>   onchange="myFunctionClient()">
								<option value="0"><?=t("Select");?></option>
								<?php									$client=Client::model()->findall(array('condition'=>'isdelete=0 and id='.$ax->clientid));
									foreach($client as $clientx)
										{
										$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
										if(is_countable($clientbranchs) && count($clientbranchs)>0){?>
											<optgroup label="<?=$clientx->name;?>">
												<?php $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if(isset($_POST['Reports']['clientid'])&& $clientbranch->id==$_POST['Reports']['clientid']){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }?>
							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client" name="Reports[clientid]" value="<?=$ax->clientbranchid;?>" requred>
					<?php				$_POST['Reports']['clientid']=$ax->clientbranchid;
			}?>






					<?//if($ax->id==317 || $ax->id==1){?>
						<div class="<?=$col;?>">
						<label for="basicSelect"><?=t('Department');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" style="width:100%" id="department" name="Reports[departmentid][]" onchange="myFunctionDepartment()" multiple="multiple"
								<?php if((!isset($_POST['Reports']['clientid']) || $_POST['Reports']['clientid']==null || $_POST['Reports']['clientid']==0 || $_POST['Reports']['clientid']=='') && $ax->clientbranchid==0){?>disabled<?php }?> requred>
									<!--<option value="0"><?=t('Please Chose');?></option> -->
									<?php
									if(isset($_POST['Reports']['clientid']) && $_POST['Reports']['clientid']!='' && $_POST['Reports']['clientid']!=0 && $_POST['Reports']['clientid']!=null)
									{
									$dep=Departments::model()->findall(array('condition'=>'clientid='.$_POST['Reports']['clientid']));
									 foreach($dep as $depx){?>
									<option <?php									if(isset($_POST['Reports']['departmentid']) && Workorder::model()->isnumber($depx->id,Workorder::model()->msplit($_POST['Reports']['departmentid']))){echo "selected";}?> value="<?=$depx->id;?>"><?=$depx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>


					<div class="<?=$col;?>">
						<label for="basicSelect"><?=t('Sub-Department');?></label>
							<fieldset class="form-group">
								<select style="width:100%" class="select2-placeholder-multiple form-control" multiple="multiple"  id="subdepartment" name="Reports[subdepartmentid][]" <?php if(!isset($_POST['Reports']['departmentid'])){?>disabled<?php }?> requred>


									<?php									if(isset($_POST['Reports']['departmentid']))
									{
									$dep=Departments::model()->findall(array('condition'=>'parentid in ('.implode(',',$_POST['Reports']['departmentid']).')'));
									foreach($dep as $depx)
									{?>
										<option <?php										if(isset($_POST['Reports']['subdepartmentid']) && Workorder::model()->isnumber($depx->id,Workorder::model()->msplit($_POST['Reports']['subdepartmentid']))){echo "selected";}?> value="<?=$depx->id;?>"><?=$depx->name;?></option>
									<?php }}?>

								</select>
							</fieldset>
						</div>


					<?php					if(isset($_POST['Reports']['clientid']) && $_POST['Reports']['clientid']!='' && $_POST['Reports']['clientid']!=0 && $_POST['Reports']['clientid']!=null)
					{
					$type=Conformitytype::model()->findAll(array(
										   'order'=>'name ASC',
										   'condition'=>'isactive=1 and (clientid='.$_POST['Reports']['clientid'].' or firmid=0 or (firmid='.$_POST['Reports']['firmid'].' and branchid=0) or (firmid='.$_POST['Reports']['firmid'].' and branchid='.$_POST['Reports']['branchid'].' and clientid=0))',
									   ));
					}
					?>
					<div class="<?=$col;?>">
					 <label for="basicSelect"><?=t('Non-Conformity Type');?></label>
                       <fieldset class="form-group">
						  <select id="conformitytype" class="select2-placeholder-multiple form-control" multiple="multiple" style="width:100%" name="Reports[type][]" <?php if(!isset($_POST['Reports']['clientid']) || $_POST['Reports']['clientid']==null || $_POST['Reports']['clientid']==0 || $_POST['Reports']['clientid']==''){?>disabled<?php }?>>
								<?php								if(is_countable($type) && count($type)>0)
								{
									foreach($type as $typex)
									{?>
										<option <?php										if(isset($_POST['Reports']['type']) && Workorder::model()->isnumber($typex->id,Workorder::model()->msplit($_POST['Reports']['type']))){echo "selected";}?> value="<?=$typex->id;?>"><?=t($typex->name);?> </option>
									<?php }}?>
                          </select>
                        </fieldset>
                    </div>
					<?//}?>


					<div class="<?=$col;?>">
						<label for="basicSelect"><?=t('Status');?></label>
							<fieldset class="form-group">
								<select id='status' class="select2-placeholder-multiple form-control" multiple="multiple" style="width:100%" name="Reports[status][]">
								<!--	<option value=""><?=t('Select');?></option> -->

									<?php $status=Conformitystatus::model()->findall();
									foreach($status as $statusx)
									{?>
										<option <?php										if(isset($_POST['Reports']['status']) && Workorder::model()->isnumber($statusx->id,Workorder::model()->msplit($_POST['Reports']['status']))){echo "selected";}?> value="<?=$statusx->id;?>"><?=t($statusx->name);?></option>
									<?php }?>
								</select>
							</fieldset>
					</div>





					<div class="<?=$col;?>">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Start Date');?></label>
	            <input id='startDate' type="date"  class="form-control"  placeholder="<?=t('Start Date');?>" name="Reports[startdate]" value="<?php if(isset($_POST['Reports']['startdate'])){echo $_POST['Reports']['startdate'];}else{echo date('Y-m-d');}?>">
            </fieldset>
          </div>

					<div class="<?=$col;?>">
          	<fieldset class="form-group">
							<label for="basicSelect"><?=t('Finish Date');?></label>
              <input id='finishDate' type="date"  class="form-control"  placeholder="<?=t('Finish Date');?>" name="Reports[finishdate]" value="<?php if(isset($_POST['Reports']['startdate'])){echo $_POST['Reports']['finishdate'];}else{echo date('Y-m-d');}?>">
            </fieldset>
          </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
          	<fieldset class="form-group">
            	<div class="input-group-append" id="button-addon2" style="float:right">
								<a class="btn btn-primary block-page" id="conformitySearch"><?=t('Search');?></a>
							</div>
            </fieldset>
          </div>
				</div>
			</div>
		</div>
	</form>
</div>
</div><!-- form -->

<section id="html5">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-6 col-lg-9 col-md-9 mb-1">
						 		<h4 class="card-title"><?=mb_strtoupper(t('Reports'));?></h4>
							</div>
							<div class="col-xl-6 col-lg-9 col-md-9 mb-1 text-right" >
								<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="reportbutton" type="submit"><?=t('Search Reports');?> <i class="fa fa-file"></i></a>
							</div>
					</div>
				</div>
				<div class="card-content collapse show">
        	<div class="card-body card-dashboard" id='confotmityListTable'>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ HTML5 export buttons table -->



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
});


 $("#cancel").click(function(){
        $("#reports").hide(500);
 });

 $("#reportbutton").click(function(){
        $("#reports").toggle(500);
 });






 // delete all finish



function myfirm()
{
	$('#department').val('');
	$('#department').select2('destroy');
	$('#department').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#conformitytype').val('');
	$('#conformitytype').select2('destroy');
	$('#conformitytype').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#status').val('');
	$('#status').select2('destroy');
	$('#status').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#subdepartment').val('');
	$('#subdepartment').select2('destroy');
	$('#subdepartment').select2({
		closeOnSelect: false,
			 allowClear: true
	});
	$( "#department" ).prop( "disabled", true );
	$( "#subdepartment" ).prop( "disabled", true );
	var firm=document.getElementById("firm").value;
	if(firm!='' && firm!=0 && firm!=null && firm!=undefined)
  {
		$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
			$( "#branch" ).prop( "disabled", false );
			$('#branch').html(data);
			//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
		});
	}
}

function mybranch()
{

	$('#department').val('');
	$('#department').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#conformitytype').val('');
	$('#conformitytype').select2('destroy');
	$('#conformitytype').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#status').val(-1);
	$('#status').select2('destroy');
	$('#status').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#subdepartment').val('');
	$('#subdepartment').select2('destroy');
	$('#subdepartment').select2({
		closeOnSelect: false,
			 allowClear: true
	});


	$( "#department" ).prop( "disabled", true );
	$( "#subdepartment" ).prop( "disabled", true );
	$(".select2-placeholder-multiple").select2({
		placeholder: "<?=t('Select State');?>",
	});

	var branch=document.getElementById("branch").value;
	if(branch!='' && branch!=0 && branch!=null && branch!=undefined)
  {
		$.post( "/workorder/client?id="+branch).done(function( data ) {
			$( "#client" ).prop( "disabled", false );
			$('#client').html(data);
		});
	}
}

function myFunctionClient() {

	$('#conformitytype').val('');
	$('#conformitytype').select2('destroy');
	$('#conformitytype').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#status').val('');
	$('#status').select2('destroy');
	$('#status').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$('#subdepartment').val('');
	$('#subdepartment').select2('destroy');
	$('#subdepartment').select2({
		closeOnSelect: false,
			 allowClear: true
	});

	$(".select2-placeholder-multiple").select2({
		placeholder: "<?=t('Select State');?>",
	});

	$( "#subdepartment" ).prop( "disabled", true );

	var client=document.getElementById("client").value;
	var branch=document.getElementById("branch").value;
	var firm=document.getElementById("firm").value;
	if(client!='' && client!=0 && client!=null && client!=undefined)
	{
  	$.post( "/conformity/client?id="+client+"&depType=multiselect").done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});

	$.post( "/conformity/conformitytype?id="+client+'&&branch='+branch+'&&firm='+firm).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
	});
}

}

function myFunctionDepartment() {
	/*
	var department=document.getElementById("department").value;
	if(department!='' && department!=0 && department!=null && department!=undefined)
	{
  	$.post( "/conformity/department?id="+department).done(function( data ) {
		$( "#subdepartment" ).prop( "disabled", false );
		$('#subdepartment').html(data);
		});
 	}
*/


	 department="";
				if($("#department").val()==0)
				{
					$.post( "/client/tumunugetir?id="+$("#client").val()).done(function( data ) {
						$('#pointno').html(data);

					});
						$( "#subdepartment" ).prop( "disabled", true );
						$( "#subdepartment" ).val( 0);
				}
				else
				{
					// yy=document.getElementById("typeselect").value;
	        var selected1=$("#department option:selected").map(function(){ return this.value }).get();
	        selected1.push(document.getElementById("department").value);// 2 is the val I set for Dog
	        department=selected1.join();
					$.post( "/client/subdepartments?id="+department+'&depType=multiselect').done(function( data ) {
						$('#subdepartment').html(data);

					});
					$( "#subdepartment" ).prop( "disabled", false );

				}
}

$(document).ready(function() {
	// Multiple Select Placeholder
    $(".select2-placeholder-multiple").select2({
      placeholder: "<?=t('Select State');?>",
    });

/******************************************
*       js of HTML5 export buttons        *
******************************************/

<?php $whotable=User::model()->iswhotable();
$whotable->name='';
$ax= User::model()->userobjecty('');
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
/*
var table = $('.dataex-html5-export').DataTable();
table.page.len( <?=$pageLength;?> ).draw();
var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
var info = table.page.info();
var lengthMenuSetting = info.length; //The value you want
*/
// alert(table.page.info().length);
} );


</script>

<script>

$(document).ready(function(){
//YoksisListe(); 

var listTable = []; 
function document(classname,columns,pdfbaslik,columnsData,url,data,formType)  {
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
		"columnDefs": [ {
		"searchable": false,
		"orderable": false,
		} ],

		"order": [[ 0, 'asc' ]],

		 buttons: [

	        {


	            extend: 'copyHtml5',
	            exportOptions: {
	                columns: columns 
	            },
				text:'<?=t('Copy');?>',
				className: 'd-none d-sm-none d-md-block',
				title:pdfbaslik,
				messageTop:''
	        },
	        {
	            extend: 'excelHtml5',
							exportOptions: {
						 		 columns: columns 
						  },
				text:'<?=t('Excel');?>',
				className: 'd-none d-sm-none d-md-block',
				title:pdfbaslik,
				messageTop:''
			 },
	        {
	             extend: 'pdfHtml5',
				 orientation: 'landscape',
				   exportOptions: {
	               columns: columns 
	            },
				  text:'<?=mb_strtoupper(t('Pdf'));?>',
				  title: 'Export',

				  action: function ( e, dt, node, config ) {
						var formData={
							firm:$('#firm').val(),
							branch:$('#branch').val(),
							client:$('#client').val(),
							department:JSON.stringify($('#department').val()),
							subdepartment:JSON.stringify($('#subdepartment').val()),
							conformitytype:JSON.stringify($('#conformitytype').val()),
							status:JSON.stringify($('#status').val()),
							finishDate:$('#finishDate').val(),
							startDate:$('#startDate').val()
						}
						window.open('<?=Yii::app()->getbaseUrl(true)?>/conformity/print?data='+JSON.stringify(formData), '_blank');
	        },
				  header: true,
				  customize: function(doc) {
					doc.content.splice(0, 1, {
					  text: [{
						text: pdfbaslik,
						bold: true,
						fontSize: 16,
							alignment: 'center'
					  },
					 {
						text: '\n',
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

	        'colvis',
			'pageLength'
		],
		"columns": columnsData, 
		"ajax": {
					 "type" : formType,
					 "url" : url,
					 "data":data,
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
				 }
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
	{"key": "conType", "value": "<?=mb_strtoupper(t('Non-Conformity Type'));?>"},
	{"key": "definition", "value": "<?=mb_strtoupper(t('Definition'));?>"}, 
	{"key": "suggestion", "value": "<?=mb_strtoupper(t('SUGGESTION'));?>"}, 
	{"key": "priority", "value": "<?=mb_strtoupper(t('Priority'));?>"}, 
	{"key": "activitydefinition", "value": "<?=mb_strtoupper(t('Action Definition'));?>"}, 
	{"key": "deadline", "value": "<?=mb_strtoupper(t('Deadline'));?>"}, 
	{"key": "assignNameSurname", "value": "<?=mb_strtoupper(t('ASSIGNED AUTHORIZED'));?>"}, 
	{"key": "closedtime", "value": "<?=mb_strtoupper(t('CLOSED TIME'));?>"}, 
	{"key": "conStatus", "value": "<?=mb_strtoupper(t('Status'));?>"}, 
	{"key": "etkinlikDurumu", "value": "<?=mb_strtoupper(t('ACTIVITY STATUS'));?>"}, 
	{"key": "nokdefinition", "value": "<?=mb_strtoupper(t('NOK - COMPLETED DEFINATION'));?>"}, 
	{"key": "etkinlik", "value": "<?=mb_strtoupper(t('EFFICIENCY FOLLOW-UP DEFINATION'));?>"},
];
var formData={
	firm:$('#firm').val(),
	branch:$('#branch').val(),
	client:$('#client').val(),
	department:JSON.stringify($('#department').val()),
	subdepartment:JSON.stringify($('#subdepartment').val()),
	conformitytype:JSON.stringify($('#conformitytype').val()),
	status:JSON.stringify($('#status').val()),
	finishDate:$('#finishDate').val(),
	startDate:$('#startDate').val()
}
tableList("confotmityListTable", "confotmityList", freeListColumnArray, null, "/conformity/newConformityList", "POST", formData,"<?=t('Non-Conformity-Report')?> (<?=date('d-m-Y H:i:s');?>)","");

$('#conformitySearch').on( 'click', function ( e) {
	var formData={
		firm:$('#firm').val(),
		branch:$('#branch').val(),
		client:$('#client').val(),
		department:JSON.stringify($('#department').val()),
		subdepartment:JSON.stringify($('#subdepartment').val()),
		conformitytype:JSON.stringify($('#conformitytype').val()),
		status:JSON.stringify($('#status').val()),
		finishDate:$('#finishDate').val(),
		startDate:$('#startDate').val()
	}
	tableList("confotmityListTable", "confotmityList", freeListColumnArray, null, "/conformity/newConformityList", "POST", formData,"<?=t('Non-Conformity-Report')?> (<?=date('d-m-Y H:i:s');?>)","");
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
			document(tableClass, pdfArray, pdfName, columnsData, ajaxUrl,formData,ajaxMethod);
  }

});
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
