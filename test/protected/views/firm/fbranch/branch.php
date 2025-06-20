<?php
User::model()->login();
$ax= User::model()->userobjecty('');



$type=$_GET['type'];

$firm=Firm::model()->findAll(array(
								   'condition'=>'parentid=:parentid','params'=>array('parentid'=>$_GET['id'])
							   ));

$availablefirm=Firm::model()->find(array(
								   'condition'=>'id=:id','params'=>array('id'=>$_GET['id'])
							   ));


		?>


<?php if (Yii::app()->user->checkAccess('firm.branch.view') and Yii::app()->user->checkAccess('firm.staff.view')){ ?>





<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Firm','Branch',$_GET['id'],'firm');?>



<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
			<div class="card-header" style="">
						<ul class="nav nav-tabs">

					<?php if (Yii::app()->user->checkAccess('firm.branch.view')){ ?>
						<?php if($type=="firm"){?>
                       <li class="nav-item">
                        <a class="nav-link active"  href="/firm/branch?type=<?=$type;?>&&id=<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $firm);?></span> <?=t('Branch');?></a>
                      </li>
					 <?php }}?>

					<?php if (Yii::app()->user->checkAccess('firm.staff.view')){ ?>
                      <li class="nav-item">
                        <a class="nav-link"  href="/firm/staff?type=<?=$type;?>&&id=<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
						<?php $say=User::model()->findAll(array('condition'=>'firmid='.$_GET['id'].' and branchid=0'));
							echo count($say);?>
							</span> <?=t('Staff');?></a>

                      </li>
					  <?php }?>


                    </ul>
				</div>
			</div>
	</div>
</div>
<?php }?>

<?php if (Yii::app()->user->checkAccess('firm.branch.view')){ ?>
<?php if (Yii::app()->user->checkAccess('firm.branch.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=$availablefirm->name.' '.t('Branch Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="firm-form" action="/firm/create" method="post">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput"  name="Firm[type]"  value="<?=$type;?>">

					<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" value='<?=$availablefirm->name;?>' placeholder="<?=t('Name');?>" name="Firm[name]" requred>
                        </fieldset>
                    </div>





					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Active');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Firm[active]">
                            <option selected=""><?=t('Select');?></option>
                            <option value="1" selected><?=t('Active');?></option>
                            <option value="0"><?=t('Passive');?></option>
                          </select>
                        </fieldset>
                    </div>

						<input type="hidden" class="form-control" id="basicInput" name="Firm[parentid]" value="<?=$_GET['id']?>" >
						<input type="hidden" class="form-control" id="basicInput" name="Firm[location]" value="branch" >



				<!--
				<?php					Yii::app()->getModule('AuthItem');
					$packages=AuthItem::model()->findAll(array(
								   'order'=>'name ASC',
								   'condition'=>'type=:type','params'=>array('type'=>1)
							   ));

				?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Package');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Firm[package]" requred>
							 <?php foreach($packages as $package){?>
								  <option value="<?=$package->name;?>" selected><?=$package->name;?></option>
							<?php }?>
                          </select>
                        </fieldset>
                    </div>

				-->



						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Commercial Title');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" value='<?=$availablefirm->title;?>' placeholder="<?=t('Commercial Title');?>" name="Firm[title]" >
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Tax Office');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Tax Office');?>" value='<?=$availablefirm->taxoffice;?>'  name="Firm[taxoffice]" >
                        </fieldset>
                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Tax No');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Tax No');?>" value='<?=$availablefirm->taxno;?>' name="Firm[taxno]" >
                        </fieldset>
                    </div>


						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Land Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Land Phone');?>" value='<?=$availablefirm->landphone;?>' name="Firm[landphone]" >
                        </fieldset>
                    </div>

					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
					<label for="basicSelect"><?=t('E-mail');?></label>
                        <fieldset class="form-group">
                          <input type="email" class="form-control" id="basicInput" placeholder="<?=t('E-mail');?>" value='<?=$availablefirm->email;?>' name="Firm[email]" >
                        </fieldset>
                    </div>

					<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
					<label for="basicSelect"><?=t('Address');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Address');?>" value='<?=$availablefirm->address;?>' name="Firm[address]" >
                        </fieldset>
                    </div>



					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2" style="float: right;">
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
						 <h4 class="card-title"><?=$availablefirm->name.' '.t('Branch');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('firm.branch.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Branch');?> <i class="fa fa-plus"></i></button>
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
							 <th><?=t('CREATE TIME');?></th>
							 <th><?=t('Active');?></th>
                            <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($firm as $firms):?>
                                <tr>
                                    <td><a href="/firm/staff?type=branch&&id=<?=$firms->id;?>"><?=$firms->name;?></a></td>

									<td><?php
										echo date('Y-m-d',$firms->createdtime);

									// Generalsettings::model()->dateformat($firms->createdtime); ?></td>



								<td>
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$firms->id;?>"  <?php if($firms->active==1){echo "checked";}?>  <?php if($clients->active==1){echo "checked";}?> <?php if (Yii::app()->user->checkAccess('firm.branch.update')==0){?>disabled<?php }?> />
									</div>
								</td>

									<td>
									<?php if (Yii::app()->user->checkAccess('firm.branch.update')){ ?>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										data-id="<?=$firms->id;?>"
										data-name="<?=$firms->name;?>"
										data-active="<?=$firms->active;?>"
										data-title="<?=$firms->title;?>"
										data-taxno="<?=$firms->taxno;?>"
										data-taxoffice="<?=$firms->taxoffice;?>"
										data-address="<?=$firms->address;?>"
										data-landphone="<?=$firms->landphone;?>"
										data-email="<?=$firms->email;?>"
										><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('firm.branch.delete')){ ?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$firms->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
									<?php }?>
									</td>
                                </tr>

								<?php endforeach;?>


                        </tbody>
                        <tfoot>
                          <tr>
														<th><?=t('Name');?></th>
 						 <th><?=t('CREATE TIME');?></th>
 						 <th><?=t('Active');?></th>
 													<th><?=t('PROCESS');?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>





<?php if (Yii::app()->user->checkAccess('firm.branch.update')){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=$availablefirm->name.' '.t('Branch Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="firm-form" action="/firm/update/0" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalfirmid" name="Firm[id]" value="0">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Name');?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="modalfirmname" placeholder="<?=t('Name');?>" name="Firm[name]" value="">
									</fieldset>
								</div>

								<input type="hidden" class="form-control" id="basicInput" name="Firm[parentid]" value="<?=$_GET['id']?>" >
								<input type="hidden" class="form-control" id="basicInput" name="Firm[location]" value="branch" >

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Active');?></label>
									<fieldset class="form-group">
										 <select class="custom-select block" id="modalfirmactive" name="Firm[active]">
											<option value="1"><?=t('Active');?></option>
											<option value="0"><?=t('Passive');?></option>
										 </select>
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Commercial Title');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalfirmtitle" placeholder="<?=t('Commercial Title');?>" name="Firm[title]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Tax Office');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalfirmtaxoffice" placeholder="<?=t('Tax Office');?>" name="Firm[taxoffice]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Tax No');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalfirmtaxno" placeholder="<?=t('Tax No');?>" name="Firm[taxno]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Address');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalfirmaddress" placeholder="<?=t('Address');?>" name="Firm[address]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Land Phone');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalfirmlandphone" placeholder="<?=t('Land Phone');?>" name="Firm[landphone]" >
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('E-mail');?></label>
                        <fieldset class="form-group">
                          <input type="email" class="form-control" id="modalfirmemail" placeholder="<?=t('E-mail');?>" name="Firm[email]" >
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
<?php if (Yii::app()->user->checkAccess('firm.branch.delete')){ ?>
	<!--S�L BA�LANGI�-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Firm Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="firm-form" action="/firm/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalfirmid2" name="Firm[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput" name="Firm[location]" value="branch" >

						<input type="hidden" class="form-control" id="basicInput" name="Firm[parentid]" value="<?=$_GET['id'];?>" >

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5 id="delete"> <?=t('Do you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer" id="btn-delete">
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



function openmodal(obj)
{
	$('#modalfirmid').val($(obj).data('id'));
	$('#modalfirmname').val($(obj).data('name'));
	$('#modalfirmactive').val($(obj).data('active'));
	$('#modalfirmtitle').val($(obj).data('title'));
	$('#modalfirmtaxno').val($(obj).data('taxno'));
	$('#modalfirmtaxoffice').val($(obj).data('taxoffice'));
	$('#modalfirmaddress').val($(obj).data('address'));
	$('#modalfirmlandphone').val($(obj).data('landphone'));
	$('#modalfirmemail').val($(obj).data('email'));
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	var id=$(obj).data('id');
	var x='';

	 $.post( "/firm/firmdelete?id="+$(obj).data('id')+'&&user=Client&&type=branch').done(function( data ) {
			if(data>0)
			{
				$('#delete').html('<?=t("You must delete customers from the branch to delete!");?>');
				$('#btn-delete').html('<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t("Close");?></button>');
			}
			else
			{
				$('#delete').html('<?=t("Do you want to delete?");?>');
				$('#btn-delete').html('<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t("Close");?></button><button  class="btn btn-danger block-page" type="submit"><?=t("Delete");?></button>');
			}

		 });


	$('#modalfirmid2').val($(obj).data('id'));
	$('#sil').modal('show');

}

function authchange(data,permission,obj)
{
$.post( "?", { firmid: data, active: permission })
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
                 columns: [ 0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Branches (<?=date('d-m-Y');?>)',
			messageTop:'<?=User::model()->table('firm',$_GET['id']);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [ 0,1]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Branches (<?=date('d-m-Y');?>)',
			messageTop:'<?=User::model()->table('firm',$_GET['id']);?>'
        },

		{
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1 ]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Branches \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				  {
					text: '<?=User::model()->table('firm',$_GET['id']);?> \n',
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

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';

?>
