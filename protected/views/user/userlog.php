<?php

$ax= User::model()->userobjecty('');
$where='';
$iscolor='';
  if($ax->firmid>0)
  {
    if($ax->branchid>0)
    {
      if($ax->clientid>0)
      {
        if($ax->clientbranchid>0)
        {
          $where='u.clientbranchid='.$ax->clientbranchid;
        }
        else
        {
          $where='u.clientid='.$ax->clientid;
        }
      }
      else
      {
        $where='u.branchid='.$ax->branchid;
      }
    }
    else
    {
      $where='u.firmid='.$ax->firmid;

    }
  }
  else
  {
    $where='';
  }


if(isset($_POST['Reports']['firmid']) && $_POST['Reports']['firmid']!='')
{
	$exel=Firm::model()->find(array('condition'=>'id='.$_POST['Reports']['firmid']))->name;
	$where="u.firmid in (".implode(',',Firm::model()->getbranchids($_POST['Reports']['firmid'])).")";
}



if(isset($_POST['Reports']['branchid']) && $_POST['Reports']['branchid']!='')
{
	$exel=$exel.' > '.Firm::model()->find(array('condition'=>'id='.$_POST['Reports']['branchid']))->name;

	$where="u.branchid=".$_POST['Reports']['branchid'];
}

if($ax->clientid>0)
{
	$cl=Client::model()->find(array('condition'=>'id='.$ax->clientid));

	$exel=$exel.' > '.$cl->name;

	$where="u.clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";
}

if(isset($_POST['Reports']['clientid']) && $_POST['Reports']['clientid']!='')
{
	$clb=Client::model()->find(array('condition'=>'id='.$_POST['Reports']['clientid']));
	$cl=Client::model()->find(array('condition'=>'id='.$clb->parentid));

	$exel=$exel.' > '.$cl->name.' > '.$clb->name;

	$where="u.clientid=".$_POST['Reports']['clientid'];
}

if(isset($_POST['Reports']['startdate']))
{
	$midnight = strtotime("today", strtotime($_POST['Reports']['startdate']));
	$where= $where!=''?$where." and l.entrytime>=".$midnight:"l.entrytime>=".$midnight;

	$exel=$exel.'( '.t("Start Date").'='.$_POST['Reports']['startdate'].')';
}
else {
  $midnight = strtotime("today");
  $where= $where!=''?$where." and l.entrytime>=".$midnight:"l.entrytime>=".$midnight;

  $exel=$exel.'( '.t("Start Date").'='.date('d-m-Y H:i:s',$midnight).')';
}

if(isset($_POST['Reports']['finishdate']))
{
	$midnight2 = strtotime("today", strtotime($_POST['Reports']['finishdate'])+3600*24);
  $where= $where!=''?$where." and l.entrytime<=".$midnight2:"l.entrytime>=".$midnight2;

	$exel=$exel.'( '.t("Finish Date").'='.$_POST['Reports']['finishdate'].')';
}
else {

  $where= $where!=''?$where." and l.entrytime<=".time():"l.entrytime>=".time();

  $exel=$exel.'( '.t("Start Date").'='.date('d-m-Y H:i:s',$midnight2).')';
}
//echo $where;



    $userlog = Yii::app()->db->createCommand()
        ->from('userlog l')
        ->join('user u', 'u.id=l.userid')
        ->where($where.' order by l.entrytime desc')
        ->queryall();
      

?>

	<!-- Sayfada neredeyiz -->
<?=User::model()->geturl('Kullanıcı Logları','',0,'userlog');?>

	<div  id='reports'>
    <div class="card">
			<div class="card-header">
			     <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title">Kullanıcı Log Listesi</h4>
							 </div>
							 <div class="col-md-6">
								         <button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
							 </div>
						</div>
			</div>
      <form id="conformity-form" action="/user/userlog"  method="post" enctype="multipart/form-data">
				<div class="card-content">
					<div class="card-body">
					    <div class="row">
    						<?
    						$col='col-xl-4 col-lg-4 col-md-4 mb-1';
    						if($ax->firmid!=0 && $ax->branchid!=0){
    							$col='col-xl-6 col-lg-6 col-md-6 mb-1';
    						}?>

  						<?php if($ax->firmid==0){?>
  						<div class="<?=$col;?>">
  							<label for="basicSelect"><?=t('Firm');?></label>
  							<fieldset class="form-group">
  								<select class="select2" style="width:100%" id="firm" name="Reports[firmid]" onchange="myfirm()" >
  									<option value="0"><?=t('Please Chose');?></option>
  									<?
  									$firm=Firm::model()->findall(array('condition'=>'parentid=0'));
  									 foreach($firm as $firmx){?>
  									<option <?php if(isset($_POST['Reports']['firmid']) &&$firmx->id==$_POST['Reports']['firmid']){echo "selected";}?> value="<?=$firmx->id;?>"><?=$firmx->name;?></option>
  									 <?php }?>
  								</select>
  							</fieldset>
  						</div>
  						<?php }else{?>
  							<input type="hidden" class="form-control" id="firm" name="Reports[firmid]" value="<?=$ax->firmid;?>" >
  						<?php }?>

						<?php if($ax->branchid==0){?>
						<div class="<?=$col;?>">
						<label for="basicSelect"><?=t('Branch');?></label>
							<fieldset class="form-group">
								<select class="select2" style="width:100%" id="branch" name="Reports[branchid]" onchange="mybranch()" <?php if(!isset($_POST['Reports']['branchid'])){echo 'disabled';}?> >
									<option value="0"><?=t("Please Choose")?></option>

									<?
									if($workorder->firmid!=0){
									$branch=Firm::model()->findall(array('condition'=>'parentid='.$workorder->firmid));
									 foreach($branch as $branchx){?>
									<option <?php if(isset($_POST['Reports']['branchid']) &&$branchx->id==$_POST['Reports']['branchid']){echo "selected";}?> value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }}?>
								</select>
							</fieldset>
						</div>
						<?php }else{?>
							<input type="hidden" class="form-control" id="branch" name="Reports[branchid]" value="<?=$ax->branchid;?>" requred>
						<?php }?>

					<?php if($ax->clientbranchid==0){?>
					<div class="<?=$col;?>">
					<label for="basicSelect"><?=t('Client');?></label>
                        <fieldset class="form-group">

                          <select class="select2" style="width:100%" id="client" name="Reports[clientid]" <?php if(!isset($_POST['Reports']['clientid'])){echo 'disabled';}?>   onchange="myFunctionClient()">
								<option value="0"><?=t("Select");?></option>
								<?
								if($ax->branchid!=0 && $ax->clientid==0){
								$client=Client::model()->findall(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$ax->branchid));

									foreach($client as $clientx)
										{
										$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
										if(count($clientbranchs)>0){?>
											<optgroup label="<?=$clientx->name;?>">
												<?$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));

													foreach($clientbranchs as $clientbranch)
													{?>
														<option <?php if(isset($_POST['Reports']['clientid'])&& $clientbranch->id==$_POST['Reports']['clientid']){echo "selected";}?> value="<?=$clientbranch->id;?>"><?=$clientx->name;?> -> <?=$clientbranch->name;?></option>
													<?php }?>
											</optgroup>
											<?php }?>
								<?php }

									$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$ax->branchid.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
									foreach($tclient as $tclientx)
									{

										$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
										foreach($tclients as $tclientsx)
										{?>
											<optgroup label="<?=$tclientsx->name;?>">
											<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$ax->branchid));
											foreach($tclientbranchs as $tclientbranchsx)
											{?>
												<option <?php if($tclientbranchsx->id==$workorder->clientid){echo "selected";}?>  value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
											<?php }?>
											</optgroup>
										<?php }

									}

									}?>
							</select>
                        </fieldset>
                    </div>
					<?php }else{?>
							<input type="hidden" class="form-control" id="client" name="Reports[clientid]" value="<?=$ax->clientbranchid;?>" requred>
					<?php }?>





					<div class="<?=$col;?>">
            <fieldset class="form-group">
						<label for="basicSelect"><?=t('Start Date');?></label>
            <input type="date"  class="form-control"  placeholder="<?=t('Start Date');?>" name="Reports[startdate]" value="<?php if(isset($_POST['Reports']['startdate'])){echo $_POST['Reports']['startdate'];}else{echo date('Y-m-d');}?>">
            </fieldset>
          </div>

					<div class="<?=$col;?>">
            <fieldset class="form-group">
						<label for="basicSelect"><?=t('Finish Date');?></label>
            <input type="date"  class="form-control"  placeholder="<?=t('Finish Date');?>" name="Reports[finishdate]" value="<?php if(isset($_POST['Reports']['startdate'])){echo $_POST['Reports']['finishdate'];}else{echo date('Y-m-d');}?>">
            </fieldset>
          </div>
				  <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
            <fieldset class="form-group">
              <div class="input-group-append" id="button-addon2" style="float:right">
									<button class="btn btn-primary block-page" type="submit"><?=t('Search');?></button>
							</div>
            </fieldset>
          </div>
				</div>



					</div>
				</div>
				</form>
			</div>

	</div><!-- form -->


	 <!-- HTML5 export buttons table -->
        <section id="html5">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-6 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('REPORTS');?></h4>
						</div>

						<div class="col-xl-6 col-lg-9 col-md-9 mb-1 text-right" >
							<a style='color:#fff;float:right;text-align:right;margin-left:3px' class="btn btn-info" id="reportbutton" type="submit"><?=t('Search Reports');?> <i class="fa fa-file"></i></a>
						</div>
					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                							<th>Firma Adı</th>
                              <th>Firma Şube Adı</th>
                              <th>Müşteri Adı</th>
                              <th>Müşteri Şube Adı</th>
                              <th>Kullanıcı Adı</th>
                              <th>Adı-Soyadı</th>
                              <th>Email</th>
                              <th>Mobil-Web</th>
                              <th>Login Olma Zamanı</th>
                              <th>Ip Adresi</th>
                          </tr>
                        </thead>
                        <tbody>


					 		<?php

							for($i=0;$i<count($userlog);$i++){?>

                <td><?=Firm::model()->findbypk($userlog[$i]['firmid'])->name;?></td>
                <td><?=Firm::model()->findbypk($userlog[$i]['branchid'])->name;?></td>
                <td><?=Client::model()->findbypk($userlog[$i]['clientid'])->name;?></td>
                <td><?=Client::model()->findbypk($userlog[$i]['clientbranchid'])->name;?></td>
                <td><?=$userlog[$i]['username'];?></td>
                <td><?=$userlog[$i]['name']." ".$userlog[$i]['surname'];?></td>
                <td><?=$userlog[$i]['email'];?></td>
                <td><?=$userlog[$i]['ismobilorweb'];?></td>
                <td><?=date("d-m-Y H:i:s",$userlog[$i]['entrytime']);?></td>
                <td><?=$userlog[$i]['ipno'];?></td>

              </tr>
						<?php }?>

                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Firma Adı</th>
                            <th>Firma Şube Adı</th>
                            <th>Müşteri Adı</th>
                            <th>Müşteri Şube Adı</th>
                            <th>Kullanıcı Adı</th>
                            <th>Adı-Soyadı</th>
                            <th>Email</th>
                            <th>Mobil-Web</th>
                            <th>Login Olma Zamanı</th>
                            <th>Ip Adresi</th>

                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ HTML5 export buttons table -->




<script>
// $("#reports").hide();


$("#printbutton").click(function(){
	var formdata= $("#conformity-form").serialize();
	var formElement = document.getElementById("conformity-form");

		formElement.target="_blank";
        formElement.action="<?=Yii::app()->getbaseUrl(true)?>/conformity/print/";

        formElement.submit();

		formElement.target="";
		formElement.action="/conformity/reports";
    //    var request = new XMLHttpRequest();

});


 $("#cancel").click(function(){
        $("#reports").hide(500);
 });

 $("#reportbutton").click(function(){
        $("#reports").toggle(500);
 });




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


<?php if($ax->firmid!=0){?>
	$( "#branch" ).prop( "disabled", false );
	$.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
<?php }?>

<?php if($ax->branchid!=0 &&$ax->clientid==0){?>
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
<?php }?>

<?php if($ax->clientid!=0){?>
	$.post( "/workorder/clientb?id=<?=$ax->clientid;?>").done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);

	});
<?php }?>


<?php if($ax->clientbranchid!=0){?>
		$.post( "/conformity/client?id="+document.getElementById("client").value).done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});

	$.post( "/conformity/conformitytype?id="+document.getElementById("client").value+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
	});


<?php }?>



function myfirm()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm").value).done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}



 function mybranch()
{
	$.post( "/workorder/client?id="+document.getElementById("branch").value).done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);
	});
}







function myFunctionClient() {

  	$.post( "/conformity/client?id="+document.getElementById("client").value).done(function( data ) {
		$( "#department" ).prop( "disabled", false );
		$('#department').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});

	$.post( "/conformity/conformitytype?id="+document.getElementById("client").value+'&&branch='+document.getElementById("branch").value+'&&firm='+document.getElementById("firm").value).done(function( data ) {
		$( "#conformitytype" ).prop( "disabled", false );
		$('#conformitytype').html(data);
	});

}



<?php if(isset($_POST['Reports']['firmid'])){?>

	$("#reports").show();


	  $.post( "/workorder/firmbranch?id=<?=$_POST['Reports']['firmid'];?>").done(function( data ) {
		$( "#branch" ).prop( "disabled", false );
		$('#branch').html(data);

		<?php if(isset($_POST['Reports']['branchid'])){?>

			$('#branch').val(<?=$_POST['Reports']['branchid'];?>);
			$('#branch').select2('destroy');
			$('#branch').select2({
				closeOnSelect: false,
				allowClear: true
			});

			<?php }?>
	});
<?php }?>

 <?php if(isset($_POST['Reports']['branchid'])){?>
	 	$.post( "/workorder/client?id=<?=$_POST['Reports']['branchid'];?>").done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);

		<?php if(isset($_POST['Reports']['clientid'])){?>

			$('#client').val(<?=$_POST['Reports']['clientid'];?>);
			$('#client').select2('destroy');
			$('#client').select2({
				closeOnSelect: false,
				allowClear: true
			});

			<?php }?>
	});
<?php }?>
<?
$clientid=0;
if(isset($_POST['Reports']['clientid'])&& $_POST['Reports']['clientid']!=''){
    //$clientid=Client::model()->find(array('condition'=>'parentid'=$_POST['Reports']['clientid']))->id;
		$clientid=Client::model()->find(array('condition'=>'parentid='.$_POST['Reports']['clientid']))->id;
    }
if($ax->clientid>0){

		    $clientid=$ax->clientid;
		    }

		?>

 <?php if($clientid!=0){?>
	 	$.post( "/workorder/clientb?id=<?=$clientid?>").done(function( data ) {
		$( "#client" ).prop( "disabled", false );
		$('#client').html(data);

		<?php if(isset($_POST['Reports']['clientid'])){?>

			$('#client').val(<?=$_POST['Reports']['clientid'];?>);
			$('#client').select2('destroy');
			$('#client').select2({
				closeOnSelect: false,
				allowClear: true
			});

			<?php }?>
	});
<?php }?>






function myFunctionDepartment() {
  	$.post( "/conformity/department?id="+document.getElementById("department").value).done(function( data ) {
		$( "#subdepartment" ).prop( "disabled", false );
		$('#subdepartment').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}


/*


function myfirm2()
{
  $.post( "/workorder/firmbranch?id="+document.getElementById("firm2").value).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

 function mybranch2()
{
	$.post( "/workorder/client?id="+document.getElementById("branch2").value).done(function( data ) {
		$( "#client2" ).prop( "disabled", false );
		$('#client2').html(data);
	});
}


function myFunctionClient2() {
  	$.post( "/conformity/client?id="+document.getElementById("client2").value).done(function( data ) {
		$( "#department2" ).prop( "disabled", false );
		$('#department2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}

function myFunctionDepartment2() {
  	$.post( "/conformity/department?id="+document.getElementById("department2").value).done(function( data ) {
		$( "#subdepartment2" ).prop( "disabled", false );
		$('#subdepartment2').html(data);
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");

	});
}



 function openmodal(obj)
{
	$('#firm2').val($(obj).data('firmid'));

	  $.post( "/workorder/firmbranch?id="+$(obj).data('firmid')).done(function( data ) {
		$( "#branch2" ).prop( "disabled", false );
		$('#branch2').html(data);
		$('#branch2').val($(obj).data('branchid'));
		//$("#"+$(obj).data('id')+"x").css("background-color", "yellow");
	});
	$.post( "/workorder/client?id="+$(obj).data('branchid')).done(function( data ) {
		$( "#client2" ).prop( "disabled", false );
		$('#client2').html(data);
		$('#client2').val($(obj).data('clientid'));
	});
	$.post( "/conformity/client?id="+$(obj).data('clientid')).done(function( data ) {
		$( "#department2" ).prop( "disabled", false );
		$('#department2').html(data);
		$('#department2').val($(obj).data('departmentid'));
	});
	$.post( "/conformity/department?id="+$(obj).data('departmentid')).done(function( data ) {
		$( "#subdepartment2" ).prop( "disabled", false );
		$('#subdepartment2').html(data);
		$('#subdepartment2').val($(obj).data('subdepartmentid'));
	});

	$.post( "/conformity/conformitytype?id="+$(obj).data('clientid')+'&&branch='+$(obj).data('branchid')+'&&firm='+$(obj).data('firmid')).done(function( data ) {
		$( "#modaltype" ).prop( "disabled", false );
		$('#modaltype').html(data);
		$('#modaltype').val($(obj).data('type'));
	});

	$.post( "/conformity/conformitystatus?id="+$(obj).data('clientid')+'&&branch='+$(obj).data('branchid')+'&&firm='+$(obj).data('firmid')).done(function( data ) {
		$( "#modalstatusid" ).prop( "disabled", false );
		$('#modalstatusid').html(data);
		$('#modalstatusid').val($(obj).data('statusid'));
	});



	$('#modalid').val($(obj).data('id'));




	$('#modaldefinition').val($(obj).data('definition'));
	$('#modalsuggestion').val($(obj).data('suggestion'));
	$('#modalstatusid').val($(obj).data('statusid'));
	$('#modalpriority').val($(obj).data('priority'));
	$('#modaldate').val($(obj).data('date'));
	$('#modalfilesf').val($(obj).data('filesf'));
	$('#duzenle').modal('show');

}


 function openmodalsil(obj)
{
	$('#modalid2').val($(obj).data('id'));
	$('#modalfile').val($(obj).data('file'));
	$('#sil').modal('show');

}
*/

$(document).ready(function() {


	// Multiple Select Placeholder
    $(".select2-placeholder-multiple").select2({
      placeholder: "<?=t('Select State');?>",
    });

/******************************************
*       js of HTML5 export buttons        *
******************************************/

<?$whotable=User::model()->iswhotable();
$whotable->name='';?>

$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[5,10,50,100, -1], [5,10,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>"
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
	"columnDefs": [ {
	"searchable": false,
	"orderable": false,
	// "targets": 0
	} ],
	//"order": [[ 4, 'desc' ]],

	"order": [[ 0, 'asc' ]],

	 buttons: [
		  <?php if($yetki==1){?>
        {


            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0,1]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=$exel;?>'
        },




        {
            extend: 'excelHtml5',

			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=$exel;?>'
		 },
        {
             extend: 'pdfHtml5',
			 orientation: 'landscape',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,3,4,5,6,7]
            },





			  text:'<?=t('PDF');?>',
			  title: 'Export',

			  action: function ( e, dt, node, config ) {
                   /* window.location = '/conformity/print'; */

					var formdata= $("#conformity-form").serialize();
					var formElement = document.getElementById("conformity-form");

						formElement.target="_blank";
						formElement.action="<?=Yii::app()->getbaseUrl(true)?>/conformity/print/";

						formElement.submit();

						formElement.target="";
						formElement.action="/conformity/reports";
					//    var request = new XMLHttpRequest();
                },
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Non-Conformity \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=$exel;?>\n',
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

			<?php }?>
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
 <?php

 Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';



Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

?>
