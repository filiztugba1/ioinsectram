<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$departments=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
							   ));




	if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
	}

	if($ax->mainclientbranchid==$ax->clientbranchid)
	{
		$departmentk=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
		if(count($departmentk)!=0)
		{
			$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));
		}
	}





						?>

<?php    $monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$_GET['id'],
							   ));


						?>

<?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>
<?=User::model()->geturl('Client','Departments',$_GET['id'],'client');?>

			<div class="card">
		<div class="card-header" style="">
							<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
						  <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?$say=User::model()->findAll(array('condition'=>'clientbranchid='.$_GET['id']));
									echo count($say);?>

							</span><?=t('Staff');?>

							</a></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

						  <li class="nav-item">
							<a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $departments);?></span><?=t('Departments');?></a></a>
						  </li>
					   <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
							<li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

					      <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
						   <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a></a>
						  </li>

					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

					        <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a></a>
						  </li>
						<?php }?>

					<?php// if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a></a>
                      </li>
					 <?//}?>



                    </ul>
				</div>

</div>


<!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('DEPARTMENT LIST');?></h4>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
								</div>

						</div>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

				  <div class="treex well">
						<div class="col-md-12 text-center">
					<?php  $transfer=Client::model()->istransfer($_GET['id']);
					 $tclient=Client::model()->find(array('condition'=>'id='.$_GET['id']));


		 if (Yii::app()->user->checkAccess('client.branch.department.create')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){ ?>
					<a onclick="openmodalcreate(this)" data-id="0" data-name="" class="btn btn-primary"><?=t('NEW DEPARTMENT ADD');?></a>
					<?php }?>
				</div>

								<?
								Departments::model()->kategoritabloyaz(0,$_GET['id']);


								?>
					</div>



                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

<!-- EKLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary white">
                            <h4 class="modal-title" id="h4create"><?=t('Department Create');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="departments-form" action="/departments/create" method="post">
						  <input type="hidden" class="form-control" id="basicInput"  name="Departments[clientid]" value="<?=$_GET['id'];?>">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalcreateparentid" name="Departments[parentid]" value="0">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Name');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" placeholder="<?=t('Name');?>" name="Departments[name]" value="">
									</fieldset>
								</div>

								<input type="hidden" class="form-control"  name="Departments[active]" value="1">


									</div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- EKLEME B�T��-->



<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="h4update"><?=t('Department Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="departments-form" action="/departments/update/0" method="post">
						  <input type="hidden" class="form-control" id="basicInput"  name="Departments[clientid]" value="<?=$_GET['id'];?>">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalupdateid" name="Departments[id]" value="0">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Name');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalupdatename" placeholder="<?=t('Name');?>" name="Departments[name]" value="">
									</fieldset>
								</div>


									<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<label for="basicSelect"><?=t('Active');?></label>
									   <fieldset class="form-group">
										  <select class="custom-select block" id="modalupdateactive" name="Departments[active]">
											<option value="1" selected><?=t('Active');?></option>
											<option value="0"><?=t('Passive');?></option>
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
	<!--S�L BA�LANGI�-->
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="h4delete"><?=t('Department Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="departments-form" action="/departments/delete/0" method="post">
						<input type="hidden" class="form-control" id="basicInput"  name="Departments[clientid]" value="<?=$_GET['id'];?>">
                     	<input type="hidden" class="form-control" id="modaldeleteid" name="Departments[id]" value="0">

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


<script>
$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});


</script>


<script>

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


function openmodalupdate(obj)
{

	$('#h4update').html($(obj).data('name')+' <?=t("Department Update");?>');
	$('#modalupdateid').val($(obj).data('id'));
	$('#modalupdatename').val($(obj).data('name'));
	$('#modalupdateactive').val($(obj).data('active'));
	$('#update').modal('show');

}

function openmodaldelete(obj)
{
	$('#h4delete').html($(obj).data('name')+' <?=t("Department Delete");?>');
	$('#modaldeleteid').val($(obj).data('id'));
	$('#delete').modal('show');

}

function openmodalcreate(obj)
{
	$('#h4create').html('<?=t("New Department Create");?>');
	$('#create').modal('show');

}

function openmodalsubcreate(obj)
{
	$('#h4create').html($(obj).data('name')+' New Sub Create');
	$('#modalcreateparentid').val($(obj).data('id'));
	$('#create').modal('show');

}


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
