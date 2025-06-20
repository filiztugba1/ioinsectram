<?php


/*

// departman ve sub departmanları ekleme
$cli=Client::model()->findAll(array('condition'=>'parentid=397'));
foreach($cli as $clix)
{
	$isdep=Departments::model()->findAll(array('condition'=>'clientid='.$clix->id.' and parentid=0'));
	if(count($isdep)==0)
	{

		$dep=Departments::model()->findAll(array('condition'=>'clientid=436 and parentid=0'));
		foreach($dep as $depx)
		{
			$depc=new Departments;
			$depc->clientid=$clix->id;
			$depc->parentid=$depx->parentid;
			$depc->name=$depx->name;
			$depc->active=$depx->active;
			if($depc->save())
			{
				$sub=Departments::model()->findAll(array('condition'=>'clientid=436 and parentid='.$depx->id));
				foreach($sub as $subx)
				{
					$sunc=new Departments;
					$sunc->clientid=$clix->id;
					$sunc->parentid=$depc->id;
					$sunc->name=$subx->name;
					$sunc->active=$subx->active;
					$sunc->save();
				}
			}
		}

	}
}


*/
User::model()->login();
$ax= User::model()->userobjecty('');

$who=User::model()->whopermission();
$firm="";
$kime="";

// admin=0,firm=1,branch=2,client=3,clientbranch=4

if($who->type==0)
{
//$firm=Firm::model()->findall(array('condition'=>'parentid=:parentid','params'=>array('parentid'=>0)));
// Yollayamıcak
$tickets=Tickets::model()->findAll(array('condition'=>'towhereid=2'));
}
else if($who->type==1)
{
$type=2;
$firm=0;
$toid=0;
$tickets=Tickets::model()->findAll(array('condition'=>'towhereid=1 and toid='.$ax->firmid));
$name1="SuperAdmin";
// Superadmin'e yollucak
}
else if($who->type==2)
{
$type=1;
$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->branchid)));
$tickets=Tickets::model()->findAll(array('condition'=>'towhereid=0 and toid='.$firm->id));
$toid=$firm->parentid;
$firmn=Firm::model()->findByPk($toid);
$name1=$firmn->name;
}
else if($who->type==3 || $who->type==4)
{
$type=0;
$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->branchid)));
$toid=$firm->id;
$firmn=Firm::model()->findByPk($toid);
$name1=$firmn->name;
}



/////////////////////


/*
<input type="hidden" name="Tickets[tofirmid]" value="<?=$firm[0]->id;?>">
<input type="hidden" name="Tickets[tobranchid]" value="<?=$firm[0]->id;?>">
*/
?>

	<?php if($ax->firmid!=0){ ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('New Ticket');?> <i class="fa fa-plus"></i></button>
								</div>
							<?php } ?>

<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Support','',0,'tickets');?>
<div class="row" id="createpage" >
	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">
				 <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('New Ticket');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

				<form id="tickets-form" action="/tickets/create" method="post"  enctype="multipart/form-data">
					<input type="hidden" name="Tickets[fromid]" value="<?=$ax->id?>">
					<input type="hidden" name="Tickets[towhereid]" value="<?=$type?>">
					<input type="hidden" name="Tickets[toid]" value="<?=$toid?>">

				<div class="card-content">
					<div class="card-body">


					<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('To');?></label>
	                	<fieldset class="form-group">
	                    	<input type="text" readonly class="form-control" name="name"  placeholder="<?=t('To');?>" value="<?=$name1?>">
	                    </fieldset>
	                </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Subject');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control"  placeholder="<?=t('Subject');?>" name="Tickets[subject]">
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Message');?></label>
                        <fieldset class="form-group">
                          <textarea class="form-control" name="Tickets[body]" value="<?=t('Message');?>"></textarea>
                        </fieldset>
                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Attachment');?></label>
                        <fieldset class="form-group">
                          <input type="file" name="image" />
                        </fieldset>
                    </div>

					 	<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
                    </div>





					</div>
				</div>
				</form>
			</div>

	</div><!-- form -->
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
						 <h4 class="card-title"><?=t('SUPPORT');?></h4>
					 </div>

						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">


						</div>

					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
					  <?php if($tickets){ ?>
						  <div class="card-header">
		  					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
		  					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
		  						 <h4 class="card-title"><?=t('incoming tickets');?></h4>
		  						</div>



		  					</div>
		                  </div>
					  <table class="table table-striped table-bordered dataex-html5-export">
  					  <thead>
  						<tr>
  						   <th><?=t('ID');?></th>
  						   <th><?=t('FROM');?></th>
  						   <th><?=t('SUBJECT');?></th>
  						   <th><?=t('CREATETIME');?></th>
  						   <th><?=t('STATUS');?></th>
  						  <th><?=t('PROCESS');?></th>

  						</tr>
  					  </thead>
  					  <tbody>
  						  <?php

						  foreach($tickets as $ticket):
							  $userr=User::model()->findByPk($ticket->fromid);

							  ?>
  							  <tr>
  								  <td><?=$ticket->id;?></td>
								  <td><?=$userr->name." ".$userr->surname?></td>
  								  <td><?=$ticket->subject;?></td>
  								  <td><?=date("Y-m-d H:i",$ticket->createdat);?></td>
  								  <td><?=$this->getStatus($ticket->status);?></td>
  								  <td>
  									  <a  class="btn btn-secondary btn-sm" onclick="openmodal(this)" data-answer="<?=date("d/m/Y H:i",$ticket->readtime);?>" data-id="<?=$ticket->id;?>" data-subject="<?=$ticket->subject;?>" data-body="<?=$ticket->body;?>" data-atachment="<?=$ticket->atachment;?>" data-readstate="<?=$ticket->readstate;?>" data-readtime="<?=$ticket->readtime;?>" data-note="<?=$ticket->note;?>" data-createdat="<?php echo date('d/m/Y H:i',$ticket->createdat); ?>" ><i style="color:#fff;" class="fa fa-reply"></i></a>
  									  <a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$ticket->id;?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
  								  </td>
  							  </tr>

  							  <?php endforeach;?>

  					  </tbody>
  					  <tfoot>
  						<tr>
  							<th><?=t('ID');?></th>
  							<th><?=t('FROM');?></th>
  							<th><?=t('SUBJECT');?></th>
  							<th><?=t('CREATETIME');?></th>
  							<th><?=t('STATUS');?></th>
  						   <th><?=t('PROCESS');?></th>

  						</tr>
  					  </tfoot>
  					</table>
				<?php }?>

				<?php
				 $tickets=Tickets::model()->findAll(array('condition'=>'fromid='.$ax->id));
				 if($tickets)
				 { ?>
					  <div class="card-header">
	  					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
	  					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
	  						 <h4 class="card-title"><?=t('My tickets');?></h4>
	  						</div>



	  					</div>
	                  </div>


                      <table class="table table-striped table-bordered dataex-html5-export">
                        <thead>
                          <tr>
                             <th><?=t('ID');?></th>
                             <th><?=t('SUBJECT');?></th>
                             <th><?=t('CREATETIME');?></th>
                             <th><?=t('STATUS');?></th>
                            <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>
             				<?php foreach($tickets as $ticket):?>
                                <tr>
                                    <td> <?=$ticket->id;?></td>
									<td><?=$ticket->subject;?></td>
									<td><?=date("d/m/Y",$ticket->createdat);?></td>
									<td><?=$this->getStatus($ticket->status);?></td>
									<td>
										<a  class="btn btn-secondary btn-sm" onclick="openmymodal(this)" data-answer="<?=date("d/m/Y H:i",$ticket->readtime);?>" data-note="<?=$ticket->note;?>" data-id="<?=$ticket->id;?>" data-subject="<?=$ticket->subject;?>" data-body="<?=$ticket->body;?>" data-atachment="<?=$ticket->atachment;?>" data-readstate="<?=$ticket->readstate;?>" data-readtime="<?=$ticket->readtime;?>" data-createdat="<?php echo date('d/m/Y H:i',$ticket->createdat); ?>" ><i style="color:#fff;" class="fa fa-reply"></i></a>
									</td>
                                </tr>

								<?php endforeach;?>

                        </tbody>
                        <tfoot>
                          <tr>
							  <th><?=t('ID');?></th>
							  <th><?=t('SUBJECT');?></th>
							  <th><?=t('CREATETIME');?></th>
							  <th><?=t('STATUS');?></th>
							 <th><?=t('PROCESS');?></th>

                          </tr>
                        </tfoot>
                      </table>
				  	<?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>





<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-6 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Ticket');?> #<span id="windowid" class="modal-title"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="tickets-form" action="/tickets/update/0" method="post">
                            <div class="modal-body">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="statusdrm">

								</div>
								<input type="hidden" class="form-control" id="modalticketsid" name="Tickets[id]" value="0">
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Subject');?></label>
									<fieldset class="form-group">
										<input type="text" readonly class="form-control" id="modalticketssubject" placeholder="<?=t('Subject');?>" name="Tickets[subject]" value="">
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Message');?></label>
									<fieldset class="form-group">
										<textarea type="text" readonly class="form-control" id="modalticketsbody" placeholder="<?=t('Message');?>" name="Tickets[body]" value=""></textarea>
										<label for="basicSelect" id="createdat" style="float:right;"></label>
									</fieldset>
								</div>


								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Attachment');?></label>
									<fieldset class="form-group">
										<a id="resimlink" href="" target="_blank"><img id="imglink" src="" width="150px" ></a>
										<label for="basicSelect" id="createdat" style="float:right;"></label>
									</fieldset>
								</div>

								<div id="cevapvarmi">


								<hr>
								<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="okundu"></div>


								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
								<label for="basicSelect"><?=t('Answer');?></label>
									<fieldset class="form-group">
										<textarea class="form-control" id="modalticketsnote" placeholder="<?=t('Note');?>" name="Tickets[note]" value=""></textarea>
										<label for="basicSelect" id="answertime" style="float:right;"></label>
									</fieldset>
								</div>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                  <button id="cevap" class="btn btn-warning block-page" type="submit"><?=t('Answer');?></button>
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
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Ticket Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="tickets-form" action="/tickets/delete/0" method="post">

						<input type="hidden" class="form-control" id="modalticketsid2" name="Tickets[id]" value="0">

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
	$('#cevap').show();
	$('#modalticketsnote').prop('disabled', false);
	///
	// src link
	$("#resimlink").attr("href",'<?=Yii::app()->baseUrl;?>'+$(obj).data('atachment'));
	$("#imglink").attr("src",'<?=Yii::app()->baseUrl;?>'+$(obj).data('atachment'));
	if ($(obj).data('atachment')==null)
	{
		console.log("resim yok");
	}
	///
	$('#windowid').empty();
	$('#createdat').empty();
	$('#statusdrm').empty();
	$('#answertime').empty();
	$('#modalticketsid').val($(obj).data('id'));
	$('#windowid').append($(obj).data('id'));
	$('#createdat').append("<?=t("Opened on")?> "+$(obj).data('createdat'));
	$('#answertime').append("<?=t("Replied on")?> "+$(obj).data('answer'));
	$('#modalticketsbody').val($(obj).data('body'));
	$('#modalticketssubject').val($(obj).data('subject'));
	$('#modalticketsnote').val($(obj).data('note'));
	if ($(obj).data('note') != "")
	{
		$('#modalticketsnote').prop('disabled', true);
		$('#cevap').hide();
	}
	$('#duzenle').modal('show');

	$.post( "/tickets/setstatus?id="+$(obj).data('id')).done(function(data) {
	});

	$.post( "/tickets/getstatus?id="+$(obj).data('id')).done(function(data) {
		$('#statusdrm').html(data);
	});


}


function openmymodal(obj)   // Durum değiştirmicek
{
	$('#cevap').show();

	 // src link
	$("#resimlink").attr("href",'<?=Yii::app()->baseUrl;?>'+$(obj).data('atachment'));
	$("#imglink").attr("src",'<?=Yii::app()->baseUrl;?>'+$(obj).data('atachment'));

	$('#modalticketsnote').prop('disabled', false);
	$('#windowid').empty();
	$('#createdat').empty();
	$('#statusdrm').empty();
	$('#answertime').empty();
	$('#modalticketsid').val($(obj).data('id'));
	$('#windowid').append($(obj).data('id'));
	$('#createdat').append("<?=t("Opened on")?> "+$(obj).data('createdat'));
	$('#answertime').append("<?=t("Replied on")?> "+$(obj).data('answer'));
	$('#modalticketsbody').val($(obj).data('body'));
	$('#modalticketssubject').val($(obj).data('subject'));
	$('#modalticketsnote').val($(obj).data('note'));
	$('#cevap').hide();
	$('#cevapvarmi').hide();
	if ($(obj).data('note') != "")
	{
		$('#cevapvarmi').show();
		$('#modalticketsnote').prop('disabled', true);

	}
	$('#duzenle').modal('show');

	$.post( "/tickets/getstatus?id="+$(obj).data('id')).done(function(data) {
		$('#statusdrm').html(data);
	});


}

function openmodalsil(obj)
{
	$('#modalticketsid2').val($(obj).data('id'));
	$('#sil').modal('show');

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
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';?>
