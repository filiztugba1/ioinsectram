<?php
User::model()->login();


?>
	<div class="col-xl-4 col-lg-4">
			<div class="treex well" id="authdiv">
				<ul>
					<li>
						<span> Superadmin</span><a href="?package=Superadmin" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>						
					</li>
				<?php 
					foreach ($authpackages as $item1)
				{				
					?>
						<li>
							<span id="<?=strtr($item1->name, array('.' => '-'))?>"><i style="margin-right:10px;" class="fa fa-folder"></i>  <?=$item1->name?></span><a href="?package=<?=$item1->name?>" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>
							<ul>
					<?php
								AuthItem::model()->writechildlists($item1->name);
					?>
							</ul>
					</li>
					<?php
				}
				?>	
				</ul>
			</div>
		</div>


	<div class="col-xl-8 col-lg-8">
<table class="table display nowrap table-striped table-bordered complex-headers">
				   <thead>
		<tr>
			<th >Modules</th>
			<th >View</th>
			<th >Create</th>
			<th >Update</th>
			<th >Delete</th>
		</tr>
	
	</thead>
	<tbody>
	<?php 
	$package='Package1.Safrangroup';
	Authmodules::model()->createauthtableitems(0,$package);
	?>
	
			
		</tbody>

</table>
		</div>
<script>

function authchange(data,permission,obj){
$(obj).parent().append('<center><div class="ft-refresh-cw icon-spin "></div></center>');
$(obj).parent().find( "input" ).css('display','none');
$.post( "/authsystem/auth/?", { group: data, type: permission })
  .done(function( returns ) {
	dataArr=data.split('|');
	if (returns.trim().split('|')=='success')
	{
		if (permission==0)
		{
			title='Permission "'+dataArr[1]+'" removed from "'+dataArr[0]+'" !';
		}else
		{
			title='Permission "'+dataArr[1]+'" defined to "'+dataArr[0]+'" !';		
		}
		toastr.success("<center>"+title+"</center>", "<center>Successful</center>", {
				positionClass: "toast-top-right",
				containerId: "toast-top-right"
		});
	}
	else
	{			
		toastr.error("<center>"+returns.trim().split('|')[1]+"</center>", "<center>Error</center>", {
				positionClass: "toast-top-right",
				containerId: "toast-top-right"
		});
	}
	
   
		$('.ft-refresh-cw').remove();
$(obj).parent().find( "input" ).css('display','block');
  });
  
	
}
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
	  }	  */
	  
});
	
		$(".checkbox").on('change', function() {
		
	  if ($(this).is(':checked')) {
		  authchange($(this).data("id"),1,$(this));
	  } else {
		  authchange($(this).data("id"),0,$(this));
	  }
	  
	  
});

});
</script>
<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
?>