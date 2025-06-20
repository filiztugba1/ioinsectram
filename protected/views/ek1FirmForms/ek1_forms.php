  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable({
		cursor:"pointer",
		update:function(event,ui)
		{
			var siralama=$(this).sortable("serialize");
			$('#defaultform').val(siralama)
			
		}
	});
	
	$( "#sortable2" ).sortable({
		cursor:"pointer",
		update:function(event,ui)
		{
			var siralama=$(this).sortable("serialize");
			$('#defaultform2').val(siralama)
			
		}
	});
  } );
  </script>
<?php
User::model()->login();
	$ax= User::model()->userobjecty('');

	
		$ek1firmformss = Yii::app()->db->createCommand()
		->select("ek.*")
				->from('ek1_forms ek')
				->where($where)
				->queryall();
				

	//$ek1firmformss=Ek1FirmForms::model()->findAll(array('order'=>'name ASC','condition'=>$where));



?>


<?php if (Yii::app()->user->checkAccess('ek1forms.view')){ ?>
<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Servis Raporları','',0,'ek1forms');?>
<?php if (Yii::app()->user->checkAccess('ek1forms.create')){ ?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				    <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Service Raports Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="reatment-form" action="/Ek1FirmForms/ek1formcreate" method="post">
				<div class="card-content">
					<div class="card-body">



					<input type="hidden" class="form-control" id="defaultform" name="ek1forms[json_data]">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect"><?=t('Form Name');?></label>
							<fieldset class="form-group">
								<input type="text" class="form-control" id="name" name="ek1forms[name]">
					
							</fieldset>
						</div>
					
					
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect"><?=t('Forma Kolon Seç');?></label>
							<fieldset class="form-group">
								<select class="select2 form-control" style="width:100%" id="json_data">
									<option value="0"><?=t('Please Chose');?></option>
								</select>
							</fieldset>
						</div>
						
					
						
					  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect" class="hidden-xs hidden-sm" style="margin:10px"></label>
							<fieldset class="form-group">
							<div class="input-group-append" id="button-addon2">
										<a class="btn btn-primary" onclick="kolonEkle()"><?=t('Forma Kolon Ekle');?></a>
							</div>
							</fieldset>
						</div>
						
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Forma seçmiş olduğunuz kolonlar');?></label>
						<ul id="sortable" id='secilenKolonlar' style="background:#dbdbdb;padding:9px;border-radius:5px">
						
							Seçmiş olduğunuz kolon bulunmuyor.
						</ul>
						</div>
						
				

					</div>
					</div>
					
					
					
					  </div>

					</div>
				</div>
				 <div class="modal-footer">
                                 <button class="btn btn-warning block-page" type="submit"><?=t('Ekle');?></button>
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
						 <h4 class="card-title"><?=t('Service Report List');?></h4>
						</div>

						<?php if (Yii::app()->user->checkAccess('ek1forms.create')){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Service Report');?> <i class="fa fa-plus"></i></button>
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
							<th><?=t('Formdaki Özellikler');?></th>
							 <th><?=t('Active');?></th>
                            <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>
             			<?php foreach($ek1firmformss as $ek1firmforms):?>
                                <tr>
                                    <td><?=$ek1firmforms['name'];?></td>

								<td>
								<?
								$ek1=str_replace("[", "", $ek1firmforms["json_data"]);
								$ek1=str_replace("]", "",$ek1);
								$ek1Arr= explode(',',$ek1);
								$ekstrig='';
								if(count($ek1Arr)!=0 && $ek1Arr[0]!='')
								{
									for($i=0;$i<count($ek1Arr);$i++)
									{
										$ek1forms=Ek1Items::model()->findAll(array('condition'=>'id in ('.$ek1Arr[$i].')'));
										foreach($ek1forms as $ek1form)
										{
											echo ($i+1).' - '.$ek1form->name.' , </br>';
											$ekstrig.=intval($ek1form->id).',';
										}
									}
								}
								?>	
								</td>
									
								<td>
									<div class="form-group pb-1">
										<input type="checkbox" id="switchery" data-size="sm"  class="switchery" data-id="<?=$ek1firmforms["id"];?>"  <?php if($ek1firmforms['is_active']==1){echo "checked";}?>  <?php if (Yii::app()->user->checkAccess('ek1forms.update')==0){?>disabled<?php }?> />
									</div>
								</td>
								


									<td>
									<?php if (Yii::app()->user->checkAccess('ek1forms.update')){ ?>
										<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										data-id="<?=$ek1firmforms['id'];?>"
										data-json_data="<?=$ekstrig;?>"
										data-name="<?=$ek1firmforms['name'];?>"
										data-is_active="<?=$ek1firmforms['is_active'];?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update')?>"
										><i style="color:#fff;" class="fa fa-edit"></i></a>
									<?php }?>
									<?php if (Yii::app()->user->checkAccess('ek1forms.delete')){ ?>

									<?php if($ax->firmid==0 || ($ek1firmforms['firmid']==$ax->firmid)|| (($ek1firmforms['firmid']==$ax->firmid) && ($ek1firmforms['branchid']==$ax->branchid))){?>
									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$ek1firmforms['id'];?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete')?>"><i style="color:#fff;" class="fa fa-trash"></i></a>


									<?php }}?>
									</td>
                                </tr>

								<?php endforeach;?>


                        </tbody>
                      
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>





<?php if (Yii::app()->user->checkAccess('ek1forms.update')){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Service Report Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						
					
					<!--form baslang��-->
						<form id="treatment-form" action="/ek1FirmForms/ek1formupdate/0" method="post">
						<input type="hidden" class="form-control" id="defaultform2" name="ek1forms[json_data]">
                            <div class="modal-body">
								<input type="hidden" class="form-control" id="modalid" name="ek1forms[id]" value="0">
							<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
							<label for="basicSelect"><?=t('Form Name');?></label>
							<fieldset class="form-group">
								<input type="text" class="form-control" id="name2" name="ek1forms[name]">
					
							</fieldset>
						</div>
						
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Is Active');?></label>
							<fieldset class="form-group">
								<select class="select2 form-control" style="width:100%" id="is_active2" name="ek1forms[is_active]" >
									<option value="1"><?=t('Active');?></option>
									<option value="0"><?=t('Passive');?></option>
								</select>
							</fieldset>
						</div>
						
					<!--
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Forma Eklenecek Kolonlar');?></label>
							<fieldset class="form-group">
								<select class="select2-placeholder-multiple form-control" style="width:100%" id="json_data2" name="ek1forms[json_data][]" multiple="multiple" >
									<option value="0"><?=t('Please Chose');?></option>
									<?$ek1Forms=Ek1Items::model()->findall(array('condition'=>'is_active=1'));
									 foreach($ek1Forms as $ek1Form){?>
									<option value="<?=$ek1Form->id;?>"><?=$ek1Form->name;?></option>
									<?php }?>
								</select>
							</fieldset>
						</div>
						-->
						
						<div class="row">
						<div class="col-xl-8 col-lg-8 col-md-8 mb-1">
						<label for="basicSelect"><?=t('Forma Kolon Seç');?></label>
							<fieldset class="form-group">
								<select class="select2 form-control" style="width:100%" id="json_data2">
									<?$ek1Forms=Ek1Items::model()->findall(array('condition'=>'is_active=1'));
									   foreach($ek1Forms as $ek1Form){?>
									  <option value="<?=$ek1Form->id;?>"><?=$ek1Form->name;?></option>
									<?php }?>
								</select>
							</fieldset>
						</div>
						
					
						
					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<label for="basicSelect" class="hidden-xs hidden-sm" style="margin:10px"></label>
							<fieldset class="form-group">
							<div class="input-group-append" id="button-addon2">
										<a class="btn btn-primary" onclick="kolonEkle2()"><?=t('Forma Kolon Ekle');?></a>
							</div>
							</fieldset>
						</div>
						
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect"><?=t('Forma seçmiş olduğunuz kolonlar');?></label>
						<ul id="sortable2" id='secilenKolonlar2' style="background:#dbdbdb;padding:9px;border-radius:5px">
						
							Seçmiş olduğunuz kolon bulunmuyor.
						</ul>
						</div>
						
				

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
<?php if (Yii::app()->user->checkAccess('ek1forms.delete')){ ?>
	<!--S�L BA�LANGI�-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Service Report Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="treatment-form" action="/ek1FirmForms/ek1formdelete" method="post">

						<input type="hidden" class="form-control" id="modaldeleteid" name="ek1forms[id]" value="0">

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


	<?php }?>

<?php }?>
	<!-- S�L B�T�� -->



<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

#sortable li {
    margin: 0 3px 3px 3px;
    padding: initial;
    padding-left: 1.5em;
    font-size: inherit;
    height: inherit;
}
</style>
<script>
///  form kolonunu php ile array olarak alıyoruz
var formKolon=[];
	<?$ek1Forms=Ek1Items::model()->findall(array('condition'=>'is_active=1'));
	   foreach($ek1Forms as $ek1Form){?>
	   formKolon.push({"id":"<?=$ek1Form->id;?>","name":"<?=$ek1Form->name;?>"});
	   $("#json_data").append('<option value="<?=$ek1Form->id;?>"><?=$ek1Form->name;?></option>');
	   
	<?php }?>
	
	
		

$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });

var eklenecekKolonlar=[];
var isKolon=false;
 function kolonEkle(){
	 $("#sortable").html(''); 
	 var eklenecekKolon=formKolon.find(x=>x.id==$("#json_data").val())
	 eklenecekKolonlar.push(eklenecekKolon);
	 var i=1;
	 eklenecekKolonlar.forEach(k=>{
		  $("#sortable").append('<li id="sira-'+k.id+'" class="ui-state-default"><span>'+i+' - </span>'+k.name+'</li>');
		  i++;
	 })
	
        	
 };
 
 
 var eklenecekKolonlar2=[];
var isKolon2=false;
 function kolonEkle2(obj=false){
	 $("#sortable2").html(''); 
	 var eklenecekKolon2=formKolon.find(x=>x.id==$("#json_data2").val())
	 if(obj==false)
	 {
		 eklenecekKolonlar2.push(eklenecekKolon2);
	 }
	 
	 var i=1;
	 var defaultform2="";
	 
	 eklenecekKolonlar2.forEach(k=>{
		  $("#sortable2").append('<li id="sira-'+k.id+'" class="ui-state-default"><span>'+i+' - </span>'+k.name+'</li>');
		  
		  if(i==1)
		  {
			  defaultform2="sira[]="+k.id;
		  }
		  else
		  {
			   defaultform2+="&sira[]="+k.id;
		  }
		  i++;
	 })
	$('#defaultform2').val(defaultform2);
        	
 };

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


function openmodal(obj)
{


	$('#modalid').val($(obj).data('id'));
	
	$('#name2').val($(obj).data('name'));
	

	
	var json_datam=$(obj).data('json_data').split(',')
	
	

	  json_datam.forEach(k=>{
		   	var eklenecekKolon=formKolon.find(x=>x.id==k)
			if(eklenecekKolon!==undefined)
				eklenecekKolonlar2.push(eklenecekKolon);
	 })
	 console.log(eklenecekKolonlar2);
	  kolonEkle2(true);
	 
	$('#is_active2').val($(obj).data('is_active'));
	$('#is_active2').select2('destroy');
	$('#is_active2').select2({
			closeOnSelect: false,
			allowClear: true
	});

	$('#duzenle').modal('show');

}

function openmodalsil(obj)
{
	$('#modaldeleteid').val($(obj).data('id'));
	$('#sil').modal('show');

}

function authchange(data,permission,obj)
{
$.post( "?", { typeid: data, active: permission })
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
                 columns: [0,1,2]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder Treatment Type (<?=date("d-m-Y H:i:s");?>)\n',
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                 columns: [0,1,2]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Workorder Treatment Type (<?=date("d-m-Y H:i:s");?>)\n',
        },



		{
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2]
            },
					text:'<?=t('PDF');?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Workorder Treatment Type',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Treatment Type \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },

					{
					text: '<?=date('d-m-Y H:i:s');?>',
					bold: true,
					fontSize: 10,
					alignment: 'center'
				  }],
				  margin: [0, 0, 0, 12]

				});
			  }

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

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';



?>
