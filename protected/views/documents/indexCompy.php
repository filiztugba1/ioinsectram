<?php
	User::model()->login();
	$ax= User::model()->userobjecty('');

	$categorys=Documentcategory::model()->findAll(array('order'=>'id ASC','condition'=>'isactive=1 and parent=0'));

	$who=User::model()->whopermission();


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





	if (Yii::app()->user->checkAccess('documents.view')){ ?>
	<?=User::model()->geturl('Documents','',0,'documents');?>
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #f3f5f9;">
        <h4 class="card-title"><?=mb_strtoupper(t('Documents'));?></h4>
    </div>
	<div class="card-content">
        <div class="card-body">
            <ul class="nav nav-tabs">
				<?
				$i=0;
				foreach($categorys as $category)
				{
				$i++;
				?>
				<li class="nav-item ">
                    <a class="nav-link category <?if($i==1){echo 'active';}?>" id="<?=$category->id;?>"  data-toggle="tab" onclick="tabs(this)"  data-id="<?=$category->id;?>" data-name='<?=t($category->name);?>' aria-controls="tab<?=$category->id;?>" href="#tab<?=$category->id;?>" aria-expanded="true"><?=t($category->name);?>

						<?
							$altnew=Documentcategory::model()->findAll(array('order'=>'id ASC','condition'=>'isactive=1 and parent='.$category->id));
							$say=0;
							$say=$say+User::model()->newdocument($category->id);
							foreach($altnew as $altnewx)
							{
								$say=$say+User::model()->newdocument($altnewx->id);
							}
						?>


					<?if($say!=0){?>
						<span class="badge badge badge-primary badge-pill float-right mr-2">

							<?echo $say;?>
						</span>

					<?}?>

					</a>
                </li>
				<?}?>
            </ul>
		</div>
    </div>
</div>

		<!-- HTML5 export buttons table -->
<div class="row tablelist" >
    <div class="col-lg-4 col-md-4 col-sm-12" id="documents">
       <div class="card">
			<div class="card-content collapse show">
				<div class="card-body card-dashboard">
					<h4 id='documentsh4' class="card-title"><?=t('Corparate').' '.mb_strtoupper(t('Category List'));?></h4>
				<div class="treex well">
				  <div class="horizontal-scroll scroll-example height-300">
                      <div class="horz-scroll-content">
					<?php  $categorys=Documentcategory::model()->find(array('order'=>'id ASC','condition'=>'isactive=1 and parent=0',));?>
					<?Documents::model()->kategoritabloyaz($categorys->id,0);?>
					</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<div class="col-lg-8 col-md-8 col-sm-12">
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
						<input type="hidden" class="form-control" id="categoriid" value="<?=$categorys->id;?>"  name="Documents[categoryid]">
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('File Upload');?></label>
							<fieldset class="form-group">
								<input type="file" class="form-control" id="basicInput" name="Documents[fileurl][]" id="dosya[]" multiple="multiple">
							</fieldset>
						</div>


						<?if($who->type!=4){?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('View Sub Firm');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" multiple="multiple" id="multi_placehodler" style="width:100%;" name="Documents[viewer][]">
								<!-- <option value="-1">Yanl�zca Sen</option> -->
										<option value="0"><?=t('All');?></option>
										<?

											foreach($firm as $firmx)
											{
												if($who->type==2){
													?><optgroup  label="<?=$firmx->name;?>"></option><?
														$cb=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=:parentid and isdelete=0','params'=>array('parentid'=> $firmx->id)));
													foreach($cb as $cbx)
													{
														if($cbx->firmid==$ax->branchid){?>
														<option value="<?=$cbx->id;?>"> <?=$firmx->name;?> -> <?=$cbx->name;?></option>
													<?}}



													}
												else
												{?>
													<option value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
												<?}

												?>


											<?}
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
															<?}?>
															</optgroup>
															<?}

														}

											}

											?>
								</select>
							</fieldset>
						</div>

						<?}?>
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
	             <fieldset class="form-group">
							<label for="basicSelect"><?=t("Son geçerlilik tarihi");?> </label>
	                <input type="date"  class="form-control" min="<?=date("Y-m-d");?>" placeholder="<?=t('Son geçerlilik tarihi');?>" name="Documents[finishdate]" value="">
	             </fieldset>
	          </div>
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
<?}?>


<div class="col-lg-12 col-md-12 col-sm-12" id="documentlist">

</div>
</div>
	</div>
 </div>

       <!--S�L BA�LANGI�-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Sector Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->

						<form id='documents-form-delete'>

						<input type="hidden" class="form-control" id="modaldocumentsid2" name="Documents[id]" value="0">
						<input type="hidden" class="form-control" id="modaldocumentsurl" name="Documents[fileurl]" value="0">

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




							<?if($who->type!=4){?>
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('View Sub Firm');?></label>
										<fieldset class="form-group">
											  <select class="select2-placeholder-multiple form-control" multiple="multiple" id="subfiles" style="width:100%;" name="Documents[viewer][]">
													<!-- <option value="-1">Yanl�zca Sen</option> -->
										<option value="0"><?=t('All');?></option>
													<?

													foreach($firm as $firmx)
													{
														if($who->type==2){
															?><optgroup  label="<?=$firmx->name;?>"></option><?
																$cb=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=:parentid and isdelete=0','params'=>array('parentid'=> $firmx->id)));
															foreach($cb as $cbx)
															{?>
																<option value="<?=$cbx->id;?>"> <?=$firmx->name;?> -> <?=$cbx->name;?></option>
															<?}
														}
														else
														{?>
															<option value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
														<?}

														?>


													<?}


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
															<?}?>
															</optgroup>
															<?}

														}

											}




													?>
											  </select>
										</fieldset>
								</div>

                            </div>

							<?}?>
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


<?}?>





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
    padding:5px 5px 0 5px;
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
var ttimes=3000;
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

$.post( "/documents/documentlist?id="+document.getElementById("categoriid").value+'&&firmid=<?=$who->id;?>&&firmtype=<?=$who->type;?>').done(function( list ) {
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
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );
		<?
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
		var table = $('.dataex-html5-export').DataTable();
		table.page.len( <?=$pageLength;?> ).draw();
		var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
		var info = table.page.info();
		var lengthMenuSetting = info.length; //The value you want
		// alert(table.page.info().length);

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
		// alert(data);
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
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );
		<?
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
		var table = $('.dataex-html5-export').DataTable();
		table.page.len( <?=$pageLength;?> ).draw();
		var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
		var info = table.page.info();
		var lengthMenuSetting = info.length; //The value you want
		// alert(table.page.info().length);

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
		console.log(data);
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
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );
		<?
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
		var table = $('.dataex-html5-export').DataTable();
		table.page.len( <?=$pageLength;?> ).draw();
		var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
		var info = table.page.info();
		var lengthMenuSetting = info.length; //The value you want
		// alert(table.page.info().length);

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
		console.log(data);
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





   $("#documents-form-create2").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
          url:"/documents/create2",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
          cache: false,
      processData:false,
      success: function(data)
        {
			  //alert(data);

				$.post( "/documents/documentlist?id="+document.getElementById("categoriid").value+'&&firmid=<?=$who->id;?>&&firmtype=<?=$who->type;?>').done(function( list ) {


				 $('#documentlist').html(list);
				 // Tooltip Initialization
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
                // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );
		<?
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
		var table = $('.dataex-html5-export').DataTable();
		table.page.len( <?=$pageLength;?> ).draw();
		var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
		var info = table.page.info();
		var lengthMenuSetting = info.length; //The value you want
		// alert(table.page.info().length);

				$('.dataex-html5-export').removeClass('dataTable');


					$("#createbutton").click(function(){
							$("#createpage").toggle(500);
					 });
					 $("#cancel").click(function(){
							$("#createpage").hide(500);
					 });


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


				 var value = jQuery.parseJSON( data );

				// alert(value.length);

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
 //documents create post finish


  //documents update post start
   $("#documents-form-update2").on('submit',(function(e) {
    e.preventDefault();
	var timestamp = new Date().getTime();

    $.ajax({
          url:"/documents/subfile/0?"+timestamp,
      type: "POST",
	  enctype: 'multipart/form-data',
      data:  new FormData(this),
      contentType: false,
          cache: false,
      processData:false,
	timeout: ttimes ,
    error: function(){
			  $("#documents-form-update").submit();
        // will fire when timeout is reached
    },
      success: function(data)
        {
			 // alert(data);

			$.post( "/documents/documentlist?id="+document.getElementById("categoriid").value+'&&firmid=<?=$who->id;?>&&firmtype=<?=$who->type;?>').done(function( list ) {


				 $('#documentlist').html(list);

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
               // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );
		<?
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


					$("#createbutton").click(function(){
							$("#createpage").toggle(500);
					 });
					 $("#cancel").click(function(){
							$("#createpage").hide(500);
					 });
				 });
				// alert(data);
				 var value = jQuery.parseJSON( data );
				 if(value=='')
				 {
						 toastr.success("<center><?=t('Update succesful');?></center>", "<center><?=t('Successful');?></center>", {
						 positionClass: "toast-top-right",
						 containerId: "toast-top-right"
							});

				 }
				 else
				 {
					 toastr.error("<center><?=t('Cannot upload!');?></center>", "<center><?=t('Error');?></center>", {
					 positionClass: "toast-top-right",
					 containerId: "toast-top-right"
		            });

				 }
				 $.unblockUI();
			$('#duzenle').modal('hide');

        }
     });
  }));
 //documents update post finish

  //documents delete post start
   $("#documents-form-delete").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
          url:"/documents/delete/0",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
          cache: false,
      processData:false,
      success: function(data)
        {

				$.post( "/documents/documentlist?id="+document.getElementById("categoriid").value+'&&firmid=<?=$who->id;?>&&firmtype=<?=$who->type;?>').done(function( list ) {
					$('#documentlist').html(list);

					// Tooltip Initialization
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
               // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );

		<?
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
		var table = $('.dataex-html5-export').DataTable();
		table.page.len( <?=$pageLength;?> ).draw();
		var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
		var info = table.page.info();
		var lengthMenuSetting = info.length; //The value you want
		// alert(table.page.info().length);

				$('.dataex-html5-export').removeClass('dataTable');




					$("#createbutton").click(function(){
							$("#createpage").toggle(500);
					 });
					 $("#cancel").click(function(){
							$("#createpage").hide(500);
					 });
				 });



				 var value = jQuery.parseJSON( data );
				 if(value=='successful')
				 {
						 toastr.success("<center><?=t('Delete succesful');?></center>", "<center><?=t('Successful');?></center>", {
						 positionClass: "toast-top-right",
						 containerId: "toast-top-right"
							});

				 }
				 else
				 {
					 toastr.error("<center><?=t('Cannot upload!');?></center>", "<center><?=t('Error');?></center>", {
					 positionClass: "toast-top-right",
					 containerId: "toast-top-right"
		            });

				 }
			$('#sil').modal('hide');
    	 $.unblockUI();
        }
     });
  }));
 //documents delete post finish




   $(document).ready(function() {
      $('.block-page-create').on('click', function() {
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
    });

});



   $(document).ready(function() {
      $('.block-page').on('click', function() {
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
    });


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







function opencreate(obj)
{
	$('#modalcreateid').val($(obj).data('id'));
	$("#createpage").show(500);

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

		//alert(value);

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




function category(obj)
{


	$('#categoriid').val($(obj).data('id'));
	$.post( "/documents/documentlist?id="+$(obj).data('id')+'&&firmid=<?=$who->id;?>&&firmtype=<?=$who->type;?>').done(function( data ) {

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

		<?
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

/*
$(document).ready(function(){

	$("#documentsform").on('submit',(function(e) {
		e.preventDefault();
	$.ajax({
      url: "/documents/create2",
      type: "POST",
      data:  new FormData(this),
      contentType:'multipart/form-data',
      cache: false,
      processData:false,
      success: function(data)
        {
		 alert('dferf');

				//window.location="https://insectram.io/workorder";

        }
     });


  }));

});
*/


function tabs(obj)
{


	$('#categoriid').val($(obj).data('id'));


	  $.post( "/documents/documentmenu?id="+$(obj).data('id')).done(function( data ) {

			$('#documents').html(data);

			$('#documentsh4').html($(obj).data('name')+' <?=t("Category List");?>');


				 // Tooltip Initialization
				$('[data-toggle="tooltip"]').tooltip({
					container:'body'
				});

			$('.horizontal-scroll').perfectScrollbar({
				suppressScrollY : true,
				theme: 'dark',
				wheelPropagation: true
			});





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
				 $.unblockUI();

	 });


	 $.post( "/documents/documentlist?id="+$(obj).data('id')+'&&firmid=<?=$who->id;?>&&firmtype=<?=$who->type;?>').done(function( data ) {

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
               // "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
			]
		} );

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
				<?
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
				var table = $('.dataex-html5-export').DataTable();
				table.page.len( <?=$pageLength;?> ).draw();
				var table = $('.dataex-html5-export').DataTable(); //note that you probably already have this call
				var info = table.page.info();
				var lengthMenuSetting = info.length; //The value you want
				// alert(table.page.info().length);
	 });

}


function openmodalsil(obj)
{
	$('#modaldocumentsid2').val($(obj).data('id'));
	$('#modaldocumentsurl').val($(obj).data('url'));
	$('#sil').modal('show');

}





</script>


<script type="text/javascript">
    $('.confirmation').on('click', function () {
        return confirm('Emin misiniz?');
    });
</script>
<script>

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
</script>





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
