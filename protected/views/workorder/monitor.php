<?php
$id=$_GET["id"];
$workorder=Workorder::model()->findByPk($id);

$ax= User::model()->userobjecty('');
?>

</div>
<?php

?>

<section id="html5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row" style="border-bottom: 1px solid #e3ebf3;">
                        <div class="col-xl-8 col-lg-8 col-md-8 mb-1">
                            <h4 class="card-title"><?=t('MONITORS');?></h4>

                        </div>
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
							<?php
								/*$kontroletwork=Workorder::model()->findByPk($_GET["id"]);
								if($kontroletwork->status!=3)
								{*/?>
								<a class="btn btn-primary" onclick="finishjob(this)" data-id="<?=$_GET['id']?>" style="color:white;"><?=t('Workorder Finish')?></a>
<a class="btn btn-info" style="color:white; margin-left:8px;" onclick="showBenzerMonitorlerModal()"><?=t('Double QR Test')?></a>
							<?php // } ?>
                <?php // if($ax->id==317 ||$ax->id==1288 ||$ax->id==326 ||$ax->id==662 || $ax->id==739)
      //{?>
       	<a class="btn btn-syccess swq" onclick="openmodalMonitor()"><?=t('Toplu Monitör Güncelle');?></a>
      <?php //}?>


						</div>

					<!--		<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
									<a class="btn btn-warning" onclick="setjob(this)" data-id="<?=$_GET['id']?>" style="color:white;"><?=t('Set Workorder Opened and Closed Times')?></a>

							</div>
 -->

                    </div>
                </div>

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard" id="butonlar">


                            <?php
                            $id=$_GET["id"];
							$say2=0;
                            $mobileworkordermonitors=Mobileworkordermonitors::model()->findAll(array("condition"=>"workorderid=".$id,'order'=>'monitorno asc'));
							//$workorder=Workorder::model()->findByPk($mobileworkordermonitors[0]->workorderid);
                            foreach($mobileworkordermonitors as $mobileworkordermonitor){
								$monitordurumu="secondary";
								$say2++;
								$mobileworkordatas=Mobileworkorderdata::model()->findall(array('condition'=>'mobileworkordermonitorsid='.$mobileworkordermonitor->id));
								$say=0;
								$veriler="";
								$goster="";
								if($mobileworkordermonitor->checkdate==0){ $monitordurumu="danger";}
								foreach ($mobileworkordatas as $mobileworkordata){
									$say++;
									$pet=Pets::model()->findByPk($mobileworkordata->petid);
									if($mobileworkordata->petid==49){
										if($mobileworkordata->value==1){ $val="Lost";}
										if($mobileworkordata->value==2){ $val="Broken";}
										if($mobileworkordata->value==3){ $val="Unreacheble";}
									}
									else{
										$val=$mobileworkordata->value;
									}
						$checkdateRaw = !empty($mobileworkordermonitor->checkdate) && $mobileworkordermonitor->checkdate > 0
    ? $mobileworkordermonitor->checkdate
    : time();

$veriler .= 'data-id' . $say . '="' . $mobileworkordata->id . '" '
          . 'data-petid' . $say . '="' . $mobileworkordata->petid . '" '
          . 'data-petname' . $say . '="' . t($pet->name) . '" '
          . 'data-checkdate="' . date("d/m/Y H:i", $checkdateRaw) . '" '
          . 'data-barcodeno="' . $mobileworkordermonitor->barcodeno . '" '
          . 'data-value' . $say . '="' . $mobileworkordata->value . '" ';
									$goster= $goster .' '. t($pet->name). ' : '.t($val).' <br> ';
								}
                              $texh=User::model()->findbypk($mobileworkordata->saverid);
                              if ($texh){
                                 $goster=$goster.'Tech: '.$texh->name.' '.$texh->surname;
                              }else{
                                  $goster='-';
                              }
                             

								?>

                                    <td>
									<div id="<?='moni'.$say2?>" style="display: inline;">
									<button style="margin:10px;width:62px;height:62px;" type="button" class="btn btn-<?=$monitordurumu?>"
									data-monitorno="<?=$mobileworkordermonitor->monitorno;?>" data-monitortype="<?=Monitoringtype::model()->findbypk($mobileworkordermonitor->monitortype)->name;?>" data-toggle="tooltip" data-placement="right" title="<?=$goster;?>" data-ps="<?='moni'.$say2?>" data-html="true" <?=$veriler;?> <?='data-count='.$say?> onclick="openmodal(this)">
									 <?=$mobileworkordermonitor->monitorno;?>
									</button>
									</div>
									</td>


                            <?php  } ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
						<h4 id="nosu"> </h4>&nbsp;&nbsp;&nbsp;&nbsp;
                            <h4 class="modal-title" id="myModalLabel8"> <?=t('Monitor Data Update');?> </h4>

								&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id="datetimepicker1" name="checkdate">




                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <h4 id="monitortype" style="text-align: center;
    padding: 6px 0 6px 0;
    background: #e8e8e8;"> </h4>
                        <!--form baslang��-->
                        <form id="mobileworkorderdata-form" method="post">
                            <div class="modal-body" id="badi" >
							<input type="hidden" name="anam" value="joe">
                            </div>
                            <div class="modal-footer">
								<!--<span  style="margin-right: 165px;"><a class="btn btn-info" onclick="isaretle();" style="float:left;" id="kntrledilmedi"  style="color:white;" ><?=t('Kontrol Edilmedi');?></a></span>-->
								<a class="btn btn-black" onclick="isaretle(this);" style="color:white;float:left;" data-valuee="2" style="color:white;" ><?=t('Kırık Kutu');?></a>
								<a class="btn btn-black" onclick="isaretle(this);" style="color:white;float:left;" data-valuee="1" style="color:white;" ><?=t('Kayıp Kutu');?></a>
								<a class="btn btn-black" onclick="isaretle(this);" style="color:white;float:left;" data-valuee="3" style="color:white;" ><?=t('Ulaşılamıyor');?></a>

                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                <a class="btn btn-warning"  style="color:white;" id="kydt" onclick="kaydet(); return false;"><?=t('Update');?></a>
                            </div>

                        </form>

                        <!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>


	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <!-- Modal -->
            <div class="modal fade text-left" id="kontrledilmedi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-black white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitor update ');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!--form baslang��-->
                        <form id="mobileworkordermonitorkontrol-form" method="post">
                            <div class="modal-body" id="kontroledmd">
                              <h2><?=t('Monitor update')?></h2>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                <a class="btn btn-danger" style="color:white;" id="kydt" onclick="kaydet2(); return false;"><?=t('Change');?></a>
                            </div>

                        </form>

                        <!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>



	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <!-- Modal -->
            <div class="modal fade text-left" id="workorderbit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-black white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Workorder will be finished');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!--form baslang��-->
                        <form id="workorder-kontrol" method="post">
                            <div class="modal-body" id="kontroledmd">
                              <h2 id="baslikewq"></h2>
								<input type="hidden" value="0" name="id" id="idpxe">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<input type="hidden" class="form-control" id="Wdata'+id+'" name="Wdata'+id+'[id]" value="0">
									<label for="basicSelect"><?=t('Real Open Time')?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control"  id="datetimepicker66" name="realstarttime"  >
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<input type="hidden" class="form-control" id="Wdata'+id+'" name="Wdata'+id+'[id]" value="0">
									<label for="basicSelect"><?=t('Real End Time')?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="datetimepicker77" name="realendtime">
									</fieldset>
								</div>
                              
              <div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="acikMonitorlerhide">
							<label for="basicSelect"><?=t('Açık kalan monitörlerde');?></label>
							<fieldset class="form-group">
								<select class="select2 form-control" id="multi_placehodler" style="width:100%;" name="acikMonitorler">
                   <option value="2"><?=t('Açık kalan monitörler okutuldu olarak işaretlensin');?></option>
                <option value="1"><?=t('Açık kalan monitörler okutulmadı olarak kalsın');?></option>
             <?php if ($ax->id==1 || $ax->id==317 || $ax->firmid==585 || $ax->firmid==542 | 1==1) { ?>   <option value="3"><?=t('Rapor tarih düzeltme (Tüm kapanışlar bitiş tarihine alınır)');?></option><?php } ?>
                 
                </select>
              </fieldset>
                              </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                <a class="btn btn-danger" style="color:white;" id="kydt98" onclick="kaydet3();"><?=t('Finish');?></a>
                            </div>

                        </form>

                        <!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- ISI GUNCELLE GUNCCELE GUNCELLE GUNCLLEEE-->
<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
            <!-- Modal -->
            <div class="modal fade text-left" id="setjob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-black white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Set workorder start-finish date');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!--form baslang��-->
                        <form id="workorder-saatdegis" method="post">
                            <div class="modal-body" id="kontroledmd">
                              <h2 id="baslikewq"></h2>
								<input type="hidden" value="0" name="id" id="idpxe">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<input type="hidden" class="form-control" id="Wdata'+id+'" name="Wdata'+id+'[id]" value="0">
									<label for="basicSelect"><?=t('Real Open Time')?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control"  id="datetimepicker21" name="realstarttime3"  >
									</fieldset>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<input type="hidden" class="form-control" id="Wdata'+id+'" name="Wdata'+id+'[id]" value="0">
									<label for="basicSelect"><?=t('Real End Time')?></label>
									<fieldset class="form-group">
										<input type="text" class="form-control" id="datetimepicker22" name="realendtime3" >
									</fieldset>
								</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
                                <a class="btn btn-danger" style="color:white;" id="kydt98" onclick="kaydet1233();"><?=t('Finish');?></a>
                            </div>

                        </form>

                        <!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <form id="toplu_monitor_yukle">
       
      
      <div class="modal fade text-left" id="tumMonitorlerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning white">
              <h4 class="modal-title" id="myModalLabel8"> <?=t('Monitor Data Update');?> </h4>
              &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" id="datetimepickerm" name="checkdate">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
             <div class="col-md-12" id="tumMonitorler">
            </div>
            <div class="modal-footer bg-warning white">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"><?=t('Close');?></button>
              <button class="btn btn-info block-page" type="submit"><?=t('Güncelle');?></button>
            </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>

<style>
  .skinSquare{
        line-height: 4;
    border: 1px;
    background: #efefef;
    border-radius: 5px;
    margin-left:1px
  }
  .icheckbox_square-red{
    margin:0 8px 0 8px;
  }
</style>
<!-- ISI GUNCELLE GUNCCELE GUNCELLE GUNCLLEEE-->


    <style>
        .switchery,.switch{
            margin-left:auto !important;
            margin-right:auto !important;
        }
    </style>
    <script>
		function kaydet1233(){

		}


        $("#createpage").hide();
        $("#createbutton").click(function(){
            $("#createpage").toggle(500);
        });
        $("#cancel").click(function(){
            $("#createpage").hide(500);
        });


		function kaydet3()
		{
			var form_data = $("#workorder-kontrol").serialize();

			$.ajax({
			url : '/mobile/workorderdegistir',
			type: 'POST',
			data : form_data,
			}).done(function( data ) {

				alert(data);
				if(data.indexOf("success") != -1)
				{
						toastr.success("<center><a style='color:#fff'><?=t('Success')?></a></center>" , {
								positionClass: "toast-bottom-right",
								containerId: "toast-top-right"
						});
					$('#workorderbit').modal('hide');
				}
				else if(data=="error")
				{

				}

			});
		}

		function finishjob(obj)
		{
		// $("#kydt98").attr("disabled", "disabled");
		$("#baslikewq").html();

		$("#idpxe").val($(obj).data('id'));
		 $.post( "/mobile/kontrol?id="+$(obj).data('id')+"", function( data ) {
			if(data.indexOf("success") != -1)
			 {
				// $("#kydt98").removeAttr("disabled");
         //$("#kydt98").hide();
         $("#acikMonitorlerhide").hide();
         $("#acikMonitorlerhide").show();
				$("#baslikewq").html("<?=t('Workorder will be finished')?>");
			 }
			 else if(data=="error")
			 {
				// $("#kydt98").attr("disabled", "disabled");
				//$("#kydt98").hide();
         
           $("#acikMonitorlerhide").show();
         $("#baslikewq").html("<?=t('Workorder will be finished')?>");
				//$("#baslikewq").html("<?=t('Missing Monitors.. Please fill in all monitors')?>");
			 }
		 });
		 $('#workorderbit').modal('show');
		// console.log($(obj).data('id'));

		}

		function setjob(){
			 $('#setjob').modal('show');
		}

		function kaydet1233(){
			var data=$("#workorder-saatdegis").serialize();
			$.ajax({
			url : '/mobile/workordersaatleri?id=<?=$_GET["id"]?>',
			type: 'POST',
			data : data,
			}).done(function( data ) {
				if(data.indexOf("success") != -1)
				{
					$('#setjob').modal('hide');
					toastr.success("<center><a style='color:#fff'><?=t('Success')?></a></center>" , {
								positionClass: "toast-bottom-right",
								containerId: "toast-top-right"
					});
				}
				else
				{
						toastr.error("<center><a style='color:#fff'><?=t('Error')?></a></center>" , {
								positionClass: "toast-bottom-right",
								containerId: "toast-top-right"
						});

				}
			})

		}

		function isaretle(obj)
		{
			  $('#kontrledilmedi').modal('show');
			  $('#duzenle').modal('hide');
			  $( "#kontroledmd" ).append('<input type="hidden" name="tur" id="tur" value="'+$(obj).data('valuee')+'">');

		}

		function kaydet2(){
			var row = '#' + $("#monigel").val();
			var button=$(row).children();

		//	button.data('original-title', button.data('original-title')+" <?=t('Monitor Status : -')?>");
			$('#kontrledilmedi').modal('hide');
			var form_data = $("#mobileworkordermonitorkontrol-form").serialize();

			$.ajax({
			url : '/mobile/updatekntrledilmedi/0',
			type: 'POST',
			data : form_data,
			}).done(function( data ) {
					console.log(data);
					var yazilacak='';
					if($("#tur").val()==1){ yazilacak="<?=t('Lost')?>"; }
					if($("#tur").val()==2){ yazilacak="<?=t('Broken')?>"; }
					if($("#tur").val()==3){ yazilacak="<?=t('Unreachable')?>"; }

					// alert(data);


					if(data.indexOf("success") != -1)
					{
						$('#kontrledilmedi').modal('hide');
						var yazi= button.attr("data-original-title");
						button.attr("data-original-title", yazi+"<?=t('Monitor Status :')?>"+yazilacak);
						//$(row).html(data);
						//$("#td_id");
						button.removeClass("btn-danger")
						button.addClass("btn-secondary");

						toastr.success("<center><a style='color:#fff'><?=t('Success')?></a></center>" , {
								positionClass: "toast-bottom-right",
								containerId: "toast-top-right"
						});
					}
					else
					{
						toastr.error("<center><a style='color:#fff'><?=t('Error')?></a></center>" , {
								positionClass: "toast-bottom-right",
								containerId: "toast-top-right"
						});
					}


			});
		}
<?php
if ($workorder->date>2){
  
}else{
  
}
  ?>
        $(document).ready(function() {
				$('#datetimepicker1').datetimepicker({
					format: 'DD/MM/Y HH:mm',
					defaultDate:"<?=$workorder->date.' '.$workorder->start_time?>",
				});

					$('#datetimepicker66').datetimepicker({
					format: 'DD/MM/Y HH:mm',
					defaultDate:"<?=$workorder->realstarttime ? date("Y-m-d H:i",$workorder->realstarttime) : date("Y-m-d H:i",time())?>",
				});

					$('#datetimepicker77').datetimepicker({
					format: 'DD/MM/Y HH:mm',
					defaultDate:"<?=$workorder->realendtime ? date("Y-m-d H:i",$workorder->realendtime) : date("Y-m-d H:i",time()) ?>",
				});

						$('#datetimepicker21').datetimepicker({
					format: 'DD/MM/Y HH:mm',
					defaultDate:new Date() ,
				});

						$('#datetimepicker22').datetimepicker({
					format: 'DD/MM/Y HH:mm',
					defaultDate:new Date(),
				});
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
			$( "#badi" ).empty();
			var c=$(obj).data('count');
			$( "#badi" ).append('<input type="hidden" name="countt" id="kactane" value="'+c+'">');
			$( "#badi" ).append('<input type="hidden" name="moni" id="monigel" value="'+$(obj).data("ps")+'">');

			$('#kontroledmd').html('');
			$( "#kontroledmd" ).append('<input type="hidden" name="id" id="idp" value="'+$(obj).data('id1')+'">');


			$('#countt').val(c);
				for(var id=1;id<=c;id++)
			{
				$( "#badi" ).append('<div class="col-xl-12 col-lg-12 col-md-12 mb-1"><input type="hidden" class="form-control" id="Wdata'+id+'" name="Wdata'+id+'[id]" value="0"><label for="basicSelect" id="modalmobileworkorderdatapet'+id+'"></label><fieldset class="form-group"><input type="text" class="form-control" id="modalmobileworkorderdatavalue'+id+'" placeholder="<?=t('Value');?>" name="mobileworkorderdata'+id+'" value=""></fieldset></div>');
			}

			for(var id=0;id<=c;id++)
			{
			$('#modalmobileworkorderdatapet'+id+'').empty();
            $('#Wdata'+id+'').val($(obj).data('id'+id));
            $('#modalmobileworkorderdatavalue'+id+'').val($(obj).data('value'+id));
            $('#modalmobileworkorderdatapet'+id+'').append($(obj).data('petname'+id));
			}
			$("#nosu").html($(obj).data('monitorno'));
      $("#monitortype").html($(obj).data('monitortype'));
            $('#duzenle').modal('show');
			$("#kydt").data("moni",$(obj).attr("id"));
          console.log($(obj).data('checkdate'));
          console.log(id);
          
            $('#datetimepicker1').val($(obj).data('checkdate'));
        }
        //  $("#datetimepicker1").datetimepicker("option", { defaultDate:$(obj).data('checkdate')});

        
        function openmodalsil(obj)
        {
            $('#modalpetsid2').val($(obj).data('id'));
            $('#sil').modal('show');

        }

		function kaydet()
		{
			var postgitcek=$("#datetimepicker1").val();
			$( "#badi" ).append('<input type="hidden" name="checkdate" id="chckdt" value="'+postgitcek+'">');
			//$("#monigel").val($("#kydt").data("moni"));

			//$("#mobileworkorderdata-form").ajaxForm({url: '/mobile/updatedata/0', type: 'POST'})

			var form_data = $("#mobileworkorderdata-form").serialize();
			$.ajax({
			url : '/mobile/updatedata/0',
			type: 'POST',
			data : form_data,
			}).done(function( data ) {
				//$($("#"+$("#kydt")).data("moni")).html();
				var row = '#' + $("#monigel").val();
				$('#duzenle').modal('hide');
				$(row).html(data);
				///.log(row);
				//console.log($(row).data("original-title"));
				//$(row).empty();
				//$(row).html(data);

			/*

				$("#"+$("kydt").data("moni")).html(data);
*/
				//$("'#"+$("#kydt").data("moni")+"'");
			});
		}
      <?php
  $date = date("Y-m-d H:i");
          
?>
 function openmodalMonitor()
  {
       $('#datetimepickerm').datetimepicker({
					format: 'DD/MM/Y HH:mm',
					defaultDate:"<?=$date?>",
				});
    $("#backgroundLoading").removeClass("loadingDisplay");
    $.get( "/workorder/topluMonitor/<?=$_GET['id'];?>").done(function( data ) {
      datam=JSON.parse(data);
          if(datam.status=="200")
             {
					  
               var monitorHtml="";
               $('#tumMonitorler').html("");
               ssasyy=0;
               
                datam.response.monitor.forEach(x=>{
                  data="data-id:'"+x.id+"'";
                  $('#tumMonitorler').append("<div class='row' id='monitor_"+x.id+"'><div class='col-md-12'><h4 id='nosu' style='text-align: center;padding: 6px 0 6px 0;color:#fff;background:"+(x.monitordurumu=="danger"?"#fd7588":"#404e67")+";'>"+x.monitorno+" - "+x.name+"</h4></div></div>");
                  monitorBul=datam.response.monitorData.filter(monitor=>monitor.id==x.id);
                  id=1;
                  petsId=[];
                  minitorr=0;
                  monitorTipi=0; //49 ise krık kayıp flndir.
                  
                  krikKayipKutu=monitorBul.filter(kku=>kku.petid==49);
               
                  monitorBul.forEach(m=>{
                   minitorr=m.monitorid;
                     if(m.petid==49)
                       {
                       monitorTipi=krikKayipKutu[0].valuem;
                       }
                    else{
                      $('#monitor_'+x.id).append('<div class="col-xl-2 col-lg-2 col-md-2 mb-1"><label for="basicSelect" id="modalmobileworkorderdatapet'+id+'">'+m.petname+'</label><fieldset class="form-group"><input type="text" class="form-control" id="'+m.id+'_'+m.petid+'" placeholder="<?=t('Value');?>" '+(krikKayipKutu.length>0?'disabled':'')+' name="mobileworkorderdata['+m.id+'][99]['+m.monitorid+']" value="'+m.valuem+'"></fieldset></div>');
                    // monitorHtml+="<div class="col-xl-12 col-lg-12 col-md-12 mb-1"><input type="hidden" class="form-control" id="Wdata'+id+'" name="Wdata'+id+'[id]" value="0"><label for="basicSelect" id="modalmobileworkorderdatapet'+id+'"></label><fieldset class="form-group"><input type="text" class="form-control" id="modalmobileworkorderdatavalue'+id+'" placeholder="<?=t('Value');?>" name="mobileworkorderdata'+id+'" value=""></fieldset></div>"
                    //  $('#modalmobileworkorderdatapet'+id+'').empty();
                    //  $('#Wdata'+id+'').val(m.id);
                     // $('#modalmobileworkorderdatavalue'+id+'').val(m.valuem);
                     // $('#modalmobileworkorderdatapet'+id+'').append(m.petname);
                  petsId.push(m.petid);
                    id++;
                    }
                  });
                  data+=" data-pets:"+petsId;
                  $('#monitor_'+x.id).append(
                                          '<div class="col-xl-4 col-lg-4 col-md-4">'+
                                            '<div class="row">'+
                                             '<div class="col-xl-4 col-lg-4 col-md-4 com-sm-3 mb-1 skin skin-square">'+
                                              '<label for="'+x.id+'_100"><?=t('Kırık Kutu');?></label>'+
                  
                                             '<fieldset  class="skinSquare" >'+
                                              '<input '+(monitorTipi==2?'checked':'')+' '+data+' data-type:"100" onclick="isaretlex(100,'+x.id+',['+petsId+'])" style="margin: 0 8px 0 8px;width:20px;height:20px" type="checkbox" id="'+x.id+'_100"  name="mobileworkorderdata['+minitorr+'][100]">'+
                                              
                                             '</fieldset>'+
                                            
                                             '</div>'+
                                              
                                            '<div class="col-xl-4 col-lg-4 col-md-4 com-sm-3 mb-1 skin skin-square">'+
                                            '<label for="'+x.id+'_101"><?=t('Kayıp Kutu');?></label>'+
                                             
                                              '<fieldset class="skinSquare">'+
                                             '<input  '+(monitorTipi==1?'checked':'')+' '+data+' data-type:"101" onclick="isaretlex(101,'+x.id+',['+petsId+'])" style="margin: 0 8px 0 8px;width:20px;height:20px"   type="checkbox" id="'+x.id+'_101" name="mobileworkorderdata['+minitorr+'][101]">'+
                                             '</fieldset>'+
                                             '</div>'+
                                               '<div class="col-xl-4 col-lg-4 col-md-4 com-sm-3 mb-1 skin skin-square">'+
                                             '<label for="'+x.id+'_102"><?=t('Ulaşılamıyor');?></label>'+
                                            
                                             '<fieldset class="skinSquare">'+
                                             '<input '+(monitorTipi==3?'checked':'')+' '+data+' data-type:"102" onclick="isaretlex(102,'+x.id+',['+petsId+'])" style="margin: 0 8px 0 8px;width:20px;height:20px"  type="checkbox" id="'+x.id+'_102" name="mobileworkorderdata['+minitorr+'][102]">'+
                                              '</fieldset>'+
                                             '</div>'+
                  '</div>'+
                  '</div>');
                  	
                  if(monitorTipi!=0)
                     {
                      if( monitorTipi==2)
                         {
                              isaretlex(100,x.id,[petsId]);
                         }
                       if( monitorTipi==1)
                         {
                              isaretlex(101,x.id,[petsId]);
                         }
                       if( monitorTipi==3)
                         {
                              isaretlex(102,x.id,[petsId]);
                         }
                     }
               });
                 $('#tumMonitorlerModal').modal('show');
      
            /*    $('.skin-square input').iCheck({
							checkboxClass: 'icheckbox_square-red',
							radioClass: 'iradio_square-red'
						});
       $(document).on('click', '#1045869_100', function() {
    alert('hello');
});
*/
               $("#backgroundLoading").addClass("loadingDisplay");
             }
          else{
$("#backgroundLoading").addClass("loadingDisplay");
          }
     
			});
  }
     
 function isaretlex(type,id,pets)
  {
    if(type==100)
       {
        if ($('#'+id+'_'+type).is(':checked')) {
          $('#'+id+'_'+101).prop('disabled', true);
           $('#'+id+'_'+102).prop('disabled', true);
          for(let i=0;i<pets.length;i++)
              {
             $('#'+id+'_'+pets[i]).prop('disabled', true);
          }
        }
         else
           {
                $('#'+id+'_'+101).prop('disabled', false);
           $('#'+id+'_'+102).prop('disabled', false);
          for(let i=0;i<pets.length;i++)
              {
             $('#'+id+'_'+pets[i]).prop('disabled', false);
          }
           }
       }
   if(type==101)
       {
        if ($('#'+id+'_'+type).is(':checked')) {
          $('#'+id+'_'+100).prop('disabled', true);
           $('#'+id+'_'+102).prop('disabled', true);
          for(let i=0;i<pets.length;i++)
              {
             $('#'+id+'_'+pets[i]).prop('disabled', true);
          }
        }
         else
           {
                $('#'+id+'_'+100).prop('disabled', false);
           $('#'+id+'_'+102).prop('disabled', false);
          for(let i=0;i<pets.length;i++)
              {
             $('#'+id+'_'+pets[i]).prop('disabled', false);
          }
           }
       }
     if(type==102)
       {
        if ($('#'+id+'_'+type).is(':checked')) {
          $('#'+id+'_'+101).prop('disabled', true);
           $('#'+id+'_'+100).prop('disabled', true);
          for(let i=0;i<pets.length;i++)
              {
             $('#'+id+'_'+pets[i]).prop('disabled', true);
          }
        }
         else
           {
                $('#'+id+'_'+101).prop('disabled', false);
           $('#'+id+'_'+100).prop('disabled', false);
          for(let i=0;i<pets.length;i++)
              {
             $('#'+id+'_'+pets[i]).prop('disabled', false);
          }
           }
       }
  }

  $("#toplu_monitor_yukle").submit(function (e) {
    $("#backgroundLoading").removeClass("loadingDisplay");
    $.ajax({
      url: "/workorder/toplumonitoryukle",
      data: new FormData(this),
      cache: false,
      type: 'POST', // For jQuery < 1.9
      contentType: false,
      processData: false,
      success: function (data) {
        	toastr.success("<center><a style='color:#fff'><?=t('Success')?></a></center>" , {
								positionClass: "toast-bottom-right",
								containerId: "toast-top-right"
						});
        $("#backgroundLoading").addClass("loadingDisplay");
          $('#tumMonitorlerModal').modal('hide');
        window.location.reload();
      }
    })
    return false;
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
?>

<!-- Double QR Test Modal -->
<div class="modal fade text-left" id="benzerMonitorlerModal" tabindex="-1" role="dialog" aria-labelledby="benzerMonitorlerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info white">
        <h4 class="modal-title" id="benzerMonitorlerLabel"><?=t('Double QR Test')?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="benzerMonitorlerListesi"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=t('Close')?></button>
      </div>
    </div>
  </div>
</div>
<script>
function showBenzerMonitorlerModal() {
  // Sayfadaki tüm butonları bul
  var buttons = document.querySelectorAll('button[data-barcodeno]');
  var barcodeMap = {};
  // Her butonun barcodeno'sunu topla
  buttons.forEach(function(btn) {
    var barcode = btn.getAttribute('data-barcodeno');
    if (!barcode) return;
    if (!barcodeMap[barcode]) barcodeMap[barcode] = [];
    barcodeMap[barcode].push(btn);
  });
  // List those with the same barcode
  var html = '';
  var found = false;
  Object.keys(barcodeMap).forEach(function(barcode) {
    if (barcodeMap[barcode].length > 1) {
      found = true;
      html += '<div class="alert alert-info"><b>'+ <?=json_encode(t('Barcode No'))?> + ': ' + barcode + '</b><ul>';
      barcodeMap[barcode].forEach(function(btn) {
        html += '<li>'+ <?=json_encode(t('Monitor No'))?> + ': ' + (btn.getAttribute('data-monitorno') || '-') + '</li>';
      });
      html += '</ul></div>';
    }
  });
  if (!found) {
    html = '<div class="alert alert-success">'+ <?=json_encode(t('No monitors have the same barcode number.'))?> +'</div>';
  }
  document.getElementById('benzerMonitorlerListesi').innerHTML = html;
  $('#benzerMonitorlerModal').modal('show');
}
</script>

<?php

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/toggle/switchery.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/datatables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';?>
