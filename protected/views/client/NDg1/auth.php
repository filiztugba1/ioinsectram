<?php


User::model()->login();
$ax= User::model()->userobjecty('');
$staf=$_GET['id'];
$staff=User::model()->findbypk($_GET['id']);
$staffid=$staff->id;
$staffauthlist=User::model()->getauthcb($staffid);	
$staffname=$staff->name.' '.$staff->surname;



User::model()->login();
$ax= User::model()->userobjecty('');
$type=$_GET['type'];
$firm=Client::model()->findAll(array(
								   'condition'=>'parentid=:parentid and isdelete=0','params'=>array('parentid'=>$ax->clientid)
							   ));

$availablefirm=Firm::model()->find(array(
								   'condition'=>'id=:id','params'=>array('id'=>$ax->firmid)
							   ));
	?>




<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Client','Authorizated','','client');?>



<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">
				
			<div class="card">
			<div class="card-header" style="">
						<ul class="nav nav-tabs">
				
                      <li class="nav-item">
                        <a class="nav-link"  ><span style="font-size: 15px;"><i class="fa fa-user-secret" style="font-size: 15px;"></i></span><?=$staffname?> Authorizated List</a></a>
                      </li>
					
					
                    
                    </ul>
				</div>
			</div>
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
						 <h4 class="card-title"><?=$availablefirm->name.' '.t(' Branch List');?></h4>
			
						</div>

						
					</div>
                </div>
				
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                             <th><?=t('NAME');?></th>
							 <th><?=t('ADMIN');?></th>
							  <th><?=t('Department and subdepartment');?></th>
							
                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($firm as $firms){
							  $authok=false;
			 
							  if (User::model()->getauthcbcheck(Authassignment::model()->getclientauthname($firms->id),$staffid))
							  {  
								  $authok=true;
							  }
							
							  ?>
                                <tr>
                                    <td>
									<a ><?=$firms->name;?></a></td>
									<td> 
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=Authassignment::model()->getclientauthname($firms->id).'|'.$staffid?>"  <?if($authok){echo "checked";}?>  
								   <?if( $staff->mainbranchid==$firms->id){echo "disabled";}?>  
								 
								 />
									</div>								
								</td>

									<td>
										<a class="btn btn-warning btn-sm" style='background:#fff;' onclick="opendepartment(this)" 
										data-id="<?=$firms->id;?>"><?=t('Department and subdepartment');?></a>
									</td>


                                </tr>
						
								<?php }?>
                        </tbody>
                        <tfoot>
                          <tr>
                             <th><?=t('NAME');?></th>
							 <th><?=t('ADMIN');?></th>
							  <th><?=t('Department and subdepartment');?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>



		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="department" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Department and Subdepartment Permission');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					<!--form baslangýç-->						
						<form id="staffteamlist-form" action="/staffteamlist/delete/0" method="post">	
						
							
                            <div class="modal-body">
							
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id='subdepartment'>
									
								</div>
				
								
					
                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                </div>
								
						</form>
									
									<!--form bitiþ-->
                    </div>
                </div>
            </div>
        </div>
    </div>

		
	
		


				  
	<!-- SÝL BÝTÝÞ -->				
	


<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.department{
    padding-top: 12px;
    border-bottom: 1px solid #ececec;
	background: #6eec8f;
    color: #fff;
}
.sdepartment{
    border: 1px solid #6eec8f;
    border-radius: 5px;
}

.departmentbaslik{

	text-align: right;
	font-size: 17px;
	font-weight: 700;

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


 function opendepartment(obj)
{
	$('#modalstaffid2').val($(obj).data('id'));
	$('#modalstaffuserid2').val($(obj).data('userid'));

	 $.post( "/client/departmentpermission?id="+$(obj).data('id')+'&&user=<?=$_GET["id"]?>').done(function( data ) {
		
			$('#subdepartment').html(data);

				$(".switchery2").on('change', function() {
					if ($(this).is(':checked')) {

						
						  authchangex2($(this).data("clientid"),$(this).data("department"),$(this).data("subdepartment"),1,$(this));
					  } else {
						 
						  authchangex2($(this).data("clientid"),$(this).data("department"),$(this).data("subdepartment"),0,$(this));
					  }
					  
					  $('#checkbox-value').text($('#checkbox1').val());
				});



			    // Switchery
    var i = 0;
    if (Array.prototype.forEach) {

        var elems = $('.switchery2');
        $.each( elems, function( key, value ) {
            var $size="", $color="",$sizeClass="", $colorCode="";
            $size = $(this).data('size');
            var $sizes ={
                'lg' : "large",
                'sm' : "small",
                'xs' : "xsmall"
            };
            if($(this).data('size')!== undefined){
                $sizeClass = "switchery switchery-"+$sizes[$size];
            }
            else{
                $sizeClass = "switchery";
            }

            $color = $(this).data('color');
            var $colors ={
                'primary' : "#967ADC",
                'success' : "#37BC9B",
                'danger' : "#DA4453",
                'warning' : "#F6BB42",
                'info' : "#3BAFDA"
            };
            if($color !== undefined){
                $colorCode = $colors[$color];
            }
            else{
                $colorCode = "#37BC9B";
            }

            var switchery = new Switchery($(this)[0], { className: $sizeClass, color: $colorCode });
        });
    } else {
        var elems1 = document.querySelectorAll('.switchery2');

        for (i = 0; i < elems1.length; i++) {
            var $size = elems1[i].data('size');
            var $color = elems1[i].data('color');
            var switchery = new Switchery(elems1[i], { color: '#37BC9B' });
        }
    }

			
	});



	$('#department').modal('show');
	
}
 
 
 
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




function authchangex2(clientid,department,subdepartment,permission,obj)
{

	var userid="<?=$_GET['id']?>";

	// alert(clientid+' '+department+' '+subdepartment+' '+permission+" "+userid);

		$.post( "?", { clientid: clientid, department: department,subdepartment:subdepartment,active:permission,userid:userid})
		  .done(function( returns ) {
			   $.post( "/client/departmentpermission?id="+clientid+'&&user=<?=$_GET["id"]?>').done(function( data ) {

				    
						toastr.success("Success");
					


					$('#subdepartment').html(data);

						$(".switchery2").on('change', function() {
					if ($(this).is(':checked')) {

						
						  authchangex2($(this).data("clientid"),$(this).data("department"),$(this).data("subdepartment"),1,$(this));
					  } else {
						 
						  authchangex2($(this).data("clientid"),$(this).data("department"),$(this).data("subdepartment"),0,$(this));
					  }
					  
					  $('#checkbox-value').text($('#checkbox1').val());
				});

								    // Switchery
    var i = 0;
    if (Array.prototype.forEach) {

        var elems = $('.switchery2');
        $.each( elems, function( key, value ) {
            var $size="", $color="",$sizeClass="", $colorCode="";
            $size = $(this).data('size');
            var $sizes ={
                'lg' : "large",
                'sm' : "small",
                'xs' : "xsmall"
            };
            if($(this).data('size')!== undefined){
                $sizeClass = "switchery switchery-"+$sizes[$size];
            }
            else{
                $sizeClass = "switchery";
            }

            $color = $(this).data('color');
            var $colors ={
                'primary' : "#967ADC",
                'success' : "#37BC9B",
                'danger' : "#DA4453",
                'warning' : "#F6BB42",
                'info' : "#3BAFDA"
            };
            if($color !== undefined){
                $colorCode = $colors[$color];
            }
            else{
                $colorCode = "#37BC9B";
            }

            var switchery = new Switchery($(this)[0], { className: $sizeClass, color: $colorCode });
        });
    } else {
        var elems1 = document.querySelectorAll('.switchery2');

        for (i = 0; i < elems1.length; i++) {
            var $size = elems1[i].data('size');
            var $color = elems1[i].data('color');
            var switchery = new Switchery(elems1[i], { color: '#37BC9B' });
        }
    }
			   });
		});	
};







function authchangex(data,permission,obj)
{
$.post( "?", { firmid: data, active: permission })
  .done(function( returns ) {
	  toastr.success("Success");
});	
};

$(document).ready(function(){
	$(".switchery").on('change', function() {
		

	  if ($(this).is(':checked')) {
		  authchangex($(this).data("id"),1,$(this));
	  } else {
		  authchangex($(this).data("id"),0,$(this));
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
                     //"sInfo": "_TOTAL_ kayýttan _START_ - _END_ arasýndaki kayýtlar gösteriliyor",
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