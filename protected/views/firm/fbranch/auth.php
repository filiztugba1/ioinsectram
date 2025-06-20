<?php

User::model()->login();
$ax= User::model()->userobjecty('');
$staf=$_GET['id'];
$staff=User::model()->findbypk($_GET['id']);
$staffid=$staff->id;
$staffauthlist=User::model()->getauthcb($staffid);
$staffname=$staff->name.' '.$staff->surname;
?>

<?php
User::model()->login();
$ax= User::model()->userobjecty('');
$type=$_GET['type'];
$firm=Firm::model()->findAll(array(
								   'condition'=>'parentid=:parentid','params'=>array('parentid'=>$ax->firmid)
							   ));

$availablefirm=Firm::model()->find(array(
								   'condition'=>'id=:id','params'=>array('id'=>$ax->firmid)
							   ));
		?>


<?php if (Yii::app()->user->checkAccess('firm.branch.view') and Yii::app()->user->checkAccess('firm.staff.view')){ ?>





<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Firm','Branch',$ax->firmid,'firm');?>



<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
			<div class="card-header" style="">
						<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('firm.staff.view')){ ?>
                      <li class="nav-item">
                        <a class="nav-link"  ><span style="font-size: 15px;"><i class="fa fa-user-secret" style="font-size: 15px;"></i></span><?=$staffname?> Authorizated List</a></a>
                      </li>
					  <?php }?>


                    </ul>
				</div>
			</div>
	</div>
</div>
<?php }?>

<?php if (Yii::app()->user->checkAccess('firm.branch.view')){ ?>





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

                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($firm as $firms){
							  $authok=false;

							  if (User::model()->getauthcbcheck(Authassignment::model()->getfirmauthname($firms->id),$staffid))
							  {
								  $authok=true;
							  }

							  ?>
                                <tr>
                                    <td>
									<a ><?=$firms->name;?></a></td>
									<td>
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=Authassignment::model()->getfirmauthname($firms->id).'|'.$staffid?>"  <?php if($authok){echo "checked";}?>
								   <?php if( $staff->mainbranchid==$firms->id){echo "disabled";}?>

								 />
									</div>
								</td>
                                </tr>

								<?php }?>
                        </tbody>
                        <tfoot>
                          <tr>
                             <th><?=t('NAME');?></th>
							 <th><?=t('ADMIN');?></th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>






<?php }?>
	<!-- SİL BİTİŞ -->



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

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';

?>
