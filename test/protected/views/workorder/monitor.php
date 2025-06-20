<?php
$id=$_GET["id"];
$workorder=Workorder::model()->findByPk($id);

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
                        <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
                            <h4 class="card-title"><?=t('MONITORS');?></h4>

                        </div>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
							<?php
								$kontroletwork=Workorder::model()->findByPk($_GET["id"]);
								if($kontroletwork->status!=3)
								{?>
								<a class="btn btn-primary" onclick="finishjob(this)" data-id="<?=$_GET['id']?>" style="color:white;"><?=t('Workorder Finish')?></a>
							<?php } ?>


						</div>

							<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
									<a class="btn btn-warning" onclick="setjob(this)" data-id="<?=$_GET['id']?>" style="color:white;"><?=t('Set Workorder Opened and Closed Times')?></a>

							</div>


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
									$veriler =$veriler.  'data-id'.$say.'="'.$mobileworkordata->id.'"
												  data-petid'.$say.'="'.$mobileworkordata->petid.'"
												  data-petname'.$say.'="'.t($pet->name).'"
												  data-value'.$say.'="'.$mobileworkordata->value.'"';
									$goster= $goster .' '. t($pet->name). ' : '.t($val).' <br>';
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
		$("#kydt98").attr("disabled", "disabled");
		$("#baslikewq").html();

		$("#idpxe").val($(obj).data('id'));
		 $.post( "/mobile/kontrol?id="+$(obj).data('id')+"", function( data ) {
			if(data.indexOf("success") != -1)
			 {
				$("#kydt98").removeAttr("disabled");
				$("#baslikewq").html("<?=t('Workorder will be finished')?>");
			 }
			 else if(data=="error")
			 {
				$("#kydt98").attr("disabled", "disabled");
				$("#kydt98").hide();
				$("#baslikewq").html("<?=t('Missing Monitors.. Please fill in all monitors')?>");
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

        }
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
