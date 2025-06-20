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
<!-- With Bottom Border start -->
<section id="bottom-border">
	<div class="row match-height">
					<h4 class="card-title"><?=t('Auth Tree')?></h4>
			

		<div class="col-xl-12 col-lg-12">
			<div class="treex well" id="authdiv">
				<ul>
			<?php
				if (Yii::app()->user->checkAccess('auth.superadmin'))
				{
			?>
					<li>
						<span> Superadmin</span><a href="?package=Superadmin" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>						
					</li>
					<?php 
						foreach ($authpackages as $item1)
					{				if (isset($_GET['package'])){
            $ppm=explode('.',$_GET['package']);
            if ($ppm[0]<>$item1->name) continue;
          }
						?>
							<li>
								<span id="<?=strtr($item1->name, array('.' => '-'))?>"><i style="margin-right:10px;" class="fa fa-folder"></i>  <?=$item1->name?></span>
								<?if($item1->name!='Default'){?>
								<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-name="<?=$item1->name;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
								<?}?>
								<a href="?package=<?=$item1->name?>" ><i style="margin-left:10px;" class="fa fa-eye"></i></a> 
								<ul>
						<?php
									AuthItem::model()->writechildlists($item1->name);
						?>
								</ul>
						
						</li>
						<?php
					}					
				}else{ 
					
					
					//superadmin
					$auths=Authitem::model()->getownauths();
					foreach($auths as $itemauth)
					{
						$mainname=explode('.',$itemauth);
						//var_Dump($mainname);
						$mainname=array_pop($mainname);		
						if (count($mainname)>1)
						{
						$parent=implode('.',$mainname);//str_replace( ".".$items[$count-1],'', $itemname);
						}
						else
						{
							$parent=$mainname;
						}
					?>
					<li>
					<span id="<?=strtr($itemauth, array('.' => '-'))?>"><i style="margin-right:10px;" class="fa fa-folder"></i>  <?=t(str_replace($itemauth,'',$parent))?></span>
					<?if (Yii::app()->user->checkAccess('auth.superadmin'))
					{?>
						<a href="?package=<?=$itemauth?>" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>
					<?}?>
					<ul>
						<?php AuthItem::model()->writechildlists($itemauth); ?>
					</ul>
					
					</li>
					<?php
					}
				}
				?>
			</ul>
		</div>
	</div>

		

		<?php
		if($_GET['package']<>'' && !isset($_GET['fast']))
		{
			?>

		<div class="col-xl-12 col-lg-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="tab-content px-1 pt-1">
							<div role="tabpanel" class="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
								<section id="headers">
								  <div class="row">
									<div class="col-12">
									
									  <div class="card">
										<div class="card-header">
										 <h4 class="card-title"><?=$_GET['package']; ?>/ <?=t('Permissions')?></h4>
										  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										 
										</div>
										<div class="card-content collapse show">
										  <div class="card-body card-dashboard">
										 
										 <table class="table display nowrap table-striped table-bordered complex-headers">
				   <thead>
		<tr>
			<th ><?=t('Modules')?></th>
			<th ><?=t('Viewing')?></th>
			<th ><?=t('Create')?></th>
			<th ><?=t('Update')?></th>
			<th ><?=t('Delete')?></th>
		</tr>
	
	</thead>
	<tbody>
	<?php 
//	$package='Package1.Safrangroup';
	Authmodules::model()->createauthtableitems(0,$_GET['package']);
	?>
	
			
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
									Paketlerin Bitişi
									*/	
								?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</section>
<!-- With Bottom Border end -->

<!--info BAŞLANGIÇ-->
	
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
						
					<!--form baslangıç-->						
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
									
									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- info BİTİŞ -->



<!--SİL BAŞLANGIÇ-->
	
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
						
					<!--form baslangıç-->						
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
									
									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!-- SİL BİTİŞ -->

	<!--PACKAGE SİL BAŞLANGIÇ-->
	
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
						
					<!--form baslangıç-->						
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
									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>
					  
	<!--PACKAGE SİL BİTİŞ -->

	<!--SİL BAŞLANGIÇ-->
	
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="permissionsil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Package Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangıç-->						
						<form id="leftmenu-form" action="/authsystem/auth/deletepermission" method="post">	
						
						<input type="hidden" class="form-control" id="modalname" name="AuthItem[name]" value="0">
						<input type="hidden" class="form-control" id="modalchild" name="AuthItem[child]" value="0">		
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
									
									<!--form bitiş-->
                    </div>
                </div>
            </div>
        </div>
    </div>


	
					  
	<!-- SİL BİTİŞ -->

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
	$('#modalname').val($(obj).data('name'));
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

</script>

<script>

function authchange(data,permission,obj,utype){
$(obj).parent().append('<center><div class="ft-refresh-cw icon-spin "></div></center>');
$(obj).parent().find( "input" ).css('display','none');


$.post( "/authsystem/auth/?", { group: data, type: permission ,utype:utype})
  .done(function( returns ) {

	 // alert(returns);
	dataArr=data.split('|');
	if (returns.trim().split('|')=='success')
	{
		if (permission==0)
		{
			title='<?=t('Permission')?> "'+dataArr[1]+'" <?=t('removed from')?> "'+dataArr[0]+'" !';
		}else
		{
			title='<?=t('Permission')?> "'+dataArr[1]+'" <?=t('defined to')?> "'+dataArr[0]+'" !';		
		}
		toastr.success("<center>"+title+"</center>", "<center><?=t('Successful')?></center>", {
				positionClass: "toast-top-right",
				containerId: "toast-top-right"
		});
	}
	else
	{			
		toastr.error("<center>"+returns.trim().split('|')[1]+"</center>", "<center><?=t('Error')?></center>", {
				positionClass: "toast-top-right",
				containerId: "toast-top-right"
		});
	}
	
   
		$('.ft-refresh-cw').remove();
$(obj).parent().find( "input" ).css('display','block');
  });
  
	
}


var ids = [];
$(document).ready(function() {
     $(".complex-headers").DataTable({
		 "pageLength": '100',
		"ordering": false,
		scrollX: !0,
	
    });

	

	$(".selectall").on('click', function() {
		
		$.each( $(this).data('id').split(','), function( key, value ) {
			 if ($('#'+value).is(':checked')) {
			 }else{
			$('#'+value).prop('checked', true).trigger("change");
			 }


			
			
			
			

			



});




		/* if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }	 
	  
	  	$.each( $('.selectall'), function( key, value ) {
			$(this).trigger('click');
});*/


	  
});

	$(".unselectall").on('click', function() {
		
		$.each( $(this).data('id').split(','), function( key, value ) {
			 if ($('#'+value).is(':checked')) {
				 
			$('#'+value).prop('checked', false).trigger("change");
			 }else{
			 }
});


	

	

});




	
		$(".checkbox").on('change', function() {

		$('.sec:checked').each(function(i, e) {
				ids.push($(this).val());
			});

		
	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this),ids);
	  } else {
		  authchange($(this).data("id"),0,$(this),ids);
	  }
	  
	  
});

});
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



 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';





?>
