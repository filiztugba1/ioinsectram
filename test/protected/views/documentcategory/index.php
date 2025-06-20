<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$documentcategory=Documentcategory::model()->findAll();?>

<?php if (Yii::app()->user->checkAccess('documentcategory.view')){ ?>
<?=User::model()->geturl('Document Category','',0,'documentcategory');?>
<?php if (Yii::app()->user->checkAccess('documentcategory.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				 <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('New Category Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="documentcategory-form" action="/documentcategory/create" method="post">
				<div class="card-content">
					<div class="card-body">


					<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Name');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Category Name');?>" name="Documentcategory[name]">
                        </fieldset>
                    </div>


				    <input type="hidden" class="form-control" id="modalcreateid" name="Documentcategory[parent]">





					<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
						<label for="basicSelect"><?=t('Active');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Documentcategory[isactive]" >
						  <option value="0"><?=t('Passive');?></option>
						  <option value="1" selected><?=t('Active');?></option>

                           </select>
                        </fieldset>

                    </div>






					  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
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
						 <h4 class="card-title"><?=t('DOCUMENT CATEGORY LIST');?></h4>
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
					<?php if (Yii::app()->user->checkAccess('documentcategory.create')){ ?>
					<a onclick="opencreate(this)" data-id="0" style='color: #fff;' class="btn btn-primary"><?=t('NEW CATEGORY ADD');?></a>
					<?php }?>
				</div>

								<?php Documentcategory::model()->kategoritabloyaz(0);?>

					</div>



                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>






<?php if (Yii::app()->user->checkAccess('documentcategory.update')){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Category Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="leftmenu-form" action="/documentcategory/update?id=0" method="post">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalcategoryid" name="Documentcategory[id]" value="0">



								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Name');?></label>
									<fieldset class="form-group">
									  <input type="text" class="form-control" id="modalcategoryname" placeholder="<?=t('Category Name');?>" name="Documentcategory[name]">
									</fieldset>
								</div>




					<input type="hidden" class="form-control" id="modalcategoryparent"  name="Documentcategory[parent]">





					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Active');?></label>
						<fieldset class="form-group">
                          <select class="custom-select block" id="modalcategoryactive" name="Documentcategory[isactive]" >
						  <option value="0"><?=t('Passive');?></option>
						  <option value="1" selected><?=t('Active');?></option>

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

<?php }?>
	<!-- G�NCELLEME B�T��-->


	<!--S�L BA�LANGI�-->
<?php if (Yii::app()->user->checkAccess('documentcategory.delete')){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Category Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="leftmenu-form" action="/documentcategory/delete?id=0" method="post">

						<input type="hidden" class="form-control" id="modalcategoryid2" name="Documentcategory[id]" value="0">

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
<?php }?>

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



function opencreate(obj)
{
	$('#modalcreateid').val($(obj).data('id'));
	$("#createpage").show(500);

}


function openmodal(obj)
{
	$('#modalcategoryid').val($(obj).data('id'));
	$('#modalcategoryname').val($(obj).data('name'));
	$('#modalcategoryactive').val($(obj).data('active'));
	$('#modalcategoryparent').val($(obj).data('parent'));
	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modalcategoryid2').val($(obj).data('id'));
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



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';?>
