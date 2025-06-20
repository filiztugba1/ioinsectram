<?php
User::model()->login();
$ax= User::model()->userobjecty('');

$firmid=$ax->firmid;
$firm=Firm::model()->find(array('condition'=>'id='.$firmid));

$client=Client::model()->find(array("condition"=>"id=".$_GET['id']))->parentid;

			$fbid=Client::model()->find(array("condition"=>"id=".$client))->firmid;

			$firmid=Firm::model()->find(array("condition"=>"id=".$fbid))->parentid;	

			$country=Firm::model()->find(array("condition"=>"id=".$firmid))->country_id;	
			


$monitoring=Monitoring::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'condition'=>'clientid='.$_GET['id'],
));
?>

<?php    $department=Departments::model()->findAll(array(
    #'select'=>'',
    #'limit'=>'5',
    'order'=>'name ASC',
    'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
));

/*
if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$department=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));

		$monitoring=Yii::app()->db->createCommand(
		'SELECT monitoring.* FROM monitoring INNER JOIN departmentpermission ON departmentpermission.clientid=monitoring.clientid WHERE departmentpermission.departmentid=monitoring.dapartmentid and departmentpermission.subdepartmentid=monitoring.subid'.$where)->queryAll();

	}
*/

$monitoringpoints=Monitoring::model()->findAll(array('condition'=>'clientid='.$_GET["id"],'order'=>'mtypeid asc'));


if($ax->mainclientbranchid!=$ax->clientbranchid)
	{
		$departments=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$_GET['id'].' and subdepartmentid=0 and userid='.$ax->id));

		$monitoring=Yii::app()->db->createCommand(
		'SELECT monitoring.* FROM monitoring INNER JOIN departmentpermission ON departmentpermission.clientid=monitoring.clientid WHERE departmentpermission.departmentid=monitoring.dapartmentid and departmentpermission.subdepartmentid=monitoring.subid and monitoring.clientid='.$_GET['id'].$where)->queryAll();
	}



?>



<?=User::model()->geturl('Client','Reports',$_GET['id'],'client');?>
    <div class="card">
        <div class="card-header" style="">
            <ul class="nav nav-tabs">
                <?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
						<?	if((isset($_GET['status']) && $_GET['status']==1) || !isset($_GET['status']))
								{
								$userwhere=' and active=1';
								}
								else if(isset($_GET['status']) && $_GET['status']==2)
								{
								$userwhere=' and active=0';
								}
								else
								{
								 $userwhere='';
								}
								$say=User::model()->findAll(array('condition'=>'type not in (24,22) and clientbranchid='.$_GET['id'].$userwhere));
									echo count($say);?>
						</span><?=t('Staff');?>

							</a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $department);?></span><?=t('Departments');?></a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a>
                    </li>
                <?php }?>
                <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a>
                    </li>

                <?php }?>
				  <li class="nav-item">
							<a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/visitreports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Visit Reports');?></a></a>
						  </li>
						  
                <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

                    <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files2/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a>
                    </li>
                <?php }?>


					<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a>
                      </li>
					 <?//}?>



            </ul>
        </div>

    </div>





     <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
					<div class="row" style="border-bottom: 1px solid #e3ebf3;">
					   <div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						 <h4 class="card-title"><?=t('VISIT REPORTS');?></h4>
						</div>

					</div>
                </div>

                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
                    

       
                              <th><?=t('VISIT REPORT');?></th>
                              <th><?=t('EXECUTION DATE');?></th>
                            		<th><?=t('Client');?></th>		
                            	<th><?=t('DESCRIPTION');?></th>	
                            	<th><?=t('STAFF/TEAM');?></th>
                            		<th><?=t('Visit Type');?></th>
             
                          </tr>
                        </thead>
                        <tbody >
             <?php


///////////////////////////////


		$where='';

	 $clientid=$_GET["id"];


		$where=$where.' clientid='.$clientid;

 $workorder=Workorder::model()->findAll(array(
								   'condition'=>$where.' and status=3 ',
        
								   'order'=>'executiondate desc',
								   'limit'=>1000
									));

			foreach($workorder as $workorderx){?>
              <tr>

               <!--   
				   <?php if($ax->firmid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->firmid))->name;?>
					  </td>
				  <?php }?>
				    <?php if($ax->branchid==0){?>
					  <td>
						<?echo Firm::model()->find(array('condition'=>'id='.$workorderx->branchid))->name;?>
					  </td>
				  <?php }?>-->
                   
                        <td>
                	<? $idsr= Servicereport::model()->find(array('condition'=>'reportno='.$workorderx->id));
                   if($idsr->id>1){
                     if( $country=='2'){
											 if ($idsr->ti_checklist<>''){
												    ?>
                   
                   <a href="/site/tireport?id=<?=$idsr->id?>&language=en&pdf=ok" target="_blank"> TI_<?=$workorderx->id?></a>
                   <?php											 }else{
												 											 if ($idsr->simple_client==1){
											
												   ?>
                   
                   <a href="/site/servicereport4?id=<?=$idsr->id?>&language=en&pdf=ok" target="_blank"> sVR_<?=$workorderx->id?></a>
                   <? 
																							 }else{
																								 ?>
																								 
                   <a href="/site/servicereport4?id=<?=$idsr->id?>&language=en&pdf=ok" target="_blank"> VR_<?=$workorderx->id?></a>
																								 <?php
																							 }
											 }
											 
                    
                     }else{
                        ?>
                   
                   <a href="/site/servicereport?id=<?=$idsr->id?>" target="_blank"> <?=$workorderx->id?></a>
                   <?php                     }
                    
                   }else{
                     echo '---';
                   }
                   ?>
					  </td>

   <td>
					<?php					   if($workorderx->realendtime!='' && $workorderx->realendtime!=0)
						{
                if($idsr->id>1){
                  echo date("Y/m/d H:i:s", ($idsr->date));
                     ?>
                
                   <?php                   }else{
					    echo date("Y/m/d H:i:s",  $workorderx->realendtime);
				   }
							
						}
						else
						{
							echo t('Continues');
						}
					 ?>
				  </td>
				 

			
				 
				   <td>
				   <?php if($workorderx->clientid!='' && $workorderx->clientid!=0){echo Client::model()->find(array('condition'=>'id='.$workorderx->clientid))->name;}?>
				 </td>
				
				   <td>
					<?=$workorderx->todo;?>
				  </td>
				 
	  <td>
					<?php if($workorderx->staffid!='' && $workorderx->staffid!=0){
						$staffs=explode(',',$workorderx->staffid);

						for($i=0;$i<count($staffs);$i++)
						{
							if($staffs[$i]!='')
							{
								echo User::model()->find(array('condition'=>'id='.$staffs[$i]))->name;
							}
						}
				  }?>
					<?php if($workorderx->teamstaffid!='' && $workorderx->teamstaffid!=0){
						echo Staffteam::model()->find(array('condition'=>'id='.$workorderx->teamstaffid))->teamname;
					}?>
				  </td>
				
             <td>
                 <?php                                       
                                        
                                         if   (is_numeric($workorderx->visittypeid)){
                                            $vt=Visittype::model()->find(array('condition'=>'id='.$workorderx->visittypeid)); 
                                        echo   t($vt->name);
                                         }else{
                                           echo '--';
                                         }
                                         
                                         
				?>
                 </td>    
				</tr>

		<?php		}?>


                        </tbody> 
                        <tfoot>
                          <tr>
<!--
						    <?php if($ax->firmid==0){?>
									<th><?=t('Firm');?></th>
									<?php }?>

									<?php if($ax->branchid==0){?>
									<th><?=t('Branch');?></th>
									<?php }?>-->


					
                      
       
                              <th><?=t('VISIT REPORT');?></th>
                              <th><?=t('EXECUTION DATE');?></th>
                            		<th><?=t('Client');?></th>		
                            	<th><?=t('DESCRIPTION');?></th>	
                            	<th><?=t('STAFF/TEAM');?></th>
                            		<th><?=t('Visit Type');?></th>
             
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>





    <style>
        .switchery,.switch{
            margin-left:auto !important;
            margin-right:auto !important;
        }

        .table tr{
            cursor: pointer;
        }
        .hiddenRow{
            padding: 0 4px !important;
            background-color: #eeeeee;
            font-size: 13px;
        }

    </style>

    <script>
	$(document).ready(function() {
	$('.dataex-html5-export').DataTable( {
    dom: 'Bfrtip',
		lengthMenu: [[3,10,20,50,100, -1], [3,10,20,50,100, "<?=t('All');?>"]],
	    language: {
        buttons: {
            pageLength: {
                _: "<?=t('Show');?> %d <?=t('rows');?>",
                '-1': "<?=t('Tout afficher');?>",
				className: 'd-none d-sm-none d-md-block',
            },
			html:true,
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
			 "order": [[ 5, 'desc' ]],
			// "order": [[ 4, 'asc' ]],



	 buttons: [

		 <?php if($yetki==1){?>
        {
            extend: 'copyHtml5',
            exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [ 0,1,2,3,4,5,6,7]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Non-Conformity (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?php if($whotable->isactive==1){echo $whotable->name;}?>'
		 },
        {
             extend: 'pdfHtml5',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			   exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7]
            },
				   text:'<?=t('PDF');?>',
			  title: 'Export',
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
					text: '<?php if($whotable->isactive==1){echo $whotable->name;}?> \n',
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

} );
		function validateForm() {
			if(+$('#reptype').val()===98)
			{
				console.log($('#mounth').val());
				console.log($('#mounth').val().length);
				if(+($('#mounth').val().length)>0) {
					return true;
				} else {
					if ($("#mounthType").val()==='0'){
						
					toastr.error("<?=t("Raporlanacak ay seçmelisiz.")?>","<center><?=t("Hata")?></center>" , {
										positionClass: "toast-bottom-right",
										containerId: "toast-top-right"

			
										});	
							return false;
					}
				
	
				}
			}
			return true;
			
		}

        //ekle b�l�m� baslang�c

        $( "#subdepartment" ).prop( "disabled", true );


        //ekle b�l�m� biti�




        //monitoring point no
    /*    department=document.getElementById("typeselect").value;
        subdepartment=document.getElementById("subdepartment").value;
        type=document.getElementById("type").value;
        $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function( data ) {
            $('#pointno').html(data);
        });
*/

        //monitoring point no bitis
	
		function oneyearSelect(){
			var oneselect=+($('#oneyear').val());
			var secondselect=+($('#secondyear').val());
			if(oneselect>=secondselect)
			{
				var newSelect=oneselect+1;
				
				$('#secondyear').val(newSelect)
				$('#secondyear').select2('destroy');
				$('#secondyear').select2({
					closeOnSelect: false,
						 allowClear: true
				});
			}
		}
		function secondyearSelect(){
			var oneselect=+($('#oneyear').val());
			var secondselect=+($('#secondyear').val());
			if(oneselect>=secondselect)
			{
				var newSelect=oneselect+1;
				
				$('#secondyear').val(newSelect);
				$('#secondyear').select2('destroy');
				$('#secondyear').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				alert('<?=t("seçmiş olduğunuz 2. yıl 1. yıldan büyük olmalıdır")?>');
			}

		}
		
		function mounthTypeSelect(){
			var select=+($('#mounthType').val());
			if(select==0)
			{
				$("#ismounth").show("slow");
			}
			else
			{
				
				$("#ismounth").hide("slow");
			}
		}
		
		var beforemounth=['0'];
		function mounthSelect(e){
			var select=$('#mounth').val();
			if(select.find(k=>k=='0') && beforemounth.find(k=>k!='0'))
			{
				
				beforemounth=['0'];
				
			}
			else
			{
				beforemounth=[];
				select.forEach(k=>{
					if(k!='0')
					{
						beforemounth.push(k);
					}
				});
			}
			
				$('#mounth').val(beforemounth);
				$('#mounth').select2('destroy');
				$('#mounth').select2({
					closeOnSelect: false,
						 allowClear: true
				});
				
		}
		
		
		
$("#startEndDate").hide("slow");
$("#typex2").hide("slow");
        $(document).ready(function() {

            $('.select2-placeholder-multiple').select2({
                closeOnSelect: false,
                allowClear: true
            });
        });

        $("#gzl3").hide();

        $("#reptype").change(function () {
			 $( '#pointno' ).attr("multiple","multiple");
			$( '#pointno' ).val(0);
			$("#type").trigger("change");

			if($("#reptype").val()==1)
			{
				// alert(document.getElementById("datetimestart").value);
				$("#tarihkisitlama").html('<?=t("Date Range (En fazla iki (6) ay tarih aralığı seçiniz.)");?>');
				 $.post( "/client/datetime?time="+document.getElementById("datetimestart").value).done(function( data ) {
				// alert(data);;
				var value = jQuery.parseJSON( data );
				// alert(value)
						$('#datetimefinish').val(value);
						var x = document.getElementById("datetimefinish").max =value;
					});
					$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
          $("#typex").show();
			}
      else if($("#reptype").val()==11)
      {
        var tarih = new Date(document.getElementById("datetimestart").value);
        var y = tarih.getFullYear();
        tarih.setFullYear(tarih.getFullYear()+1, 1, 0);
         // tarih.setDate(-1);
        var d = tarih.getDate();
        var m =  12;
        document.getElementById("datetimefinish").max =y + "-" + m + "-" + d;
        document.getElementById("datetimefinish").min=document.getElementById("datetimestart").value;

        $("#tarihkisitlama").html('<?=t("Date Range (Aktivite raporu alabilmek için tarihler aynı yıl içinde olmalıdır.)");?>');
        $("#departmanblog").show("slow");
               $("#gzl").show("slow");
          $("#subdepartmentblok").show("slow");
          $("#typex").hide();
               $("#gzl2").hide("slow");
               $("#gzl3").hide("slow");
               $("#type").prepend("<option value='0' selected='selected'>Select</option>");
               $("[name='Monitoring[date]']").show("slow");
               $("[name='Monitoring[mtypeid]']").hide("slow");
               $("[name='Monitoring[date1]']").show("slow");
                $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("#pointno").hide("slow");

        $("#typeselect").show("slow");
        $("#subdepartment").show("slow");

        $("#pointno").hide();
		$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
        return;
      }
			else
			{
				$("#tarihkisitlama").html('<?=t("Date Range");?>');
				document.getElementById("datetimefinish").max='<?=date("Y-m-d",time());?>';
         $("#typex").show();
			}


            if($("#reptype").val()==4)
            {
				 $("#departmanblog").show("slow");
                $("#gzl").hide("slow");
					 $("#subdepartmentblok").show("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                $("#type").prepend("<option value='0' selected='selected'>Select</option>");
                $("[name='Monitoring[date]']").hide("slow");
                $("[name='Monitoring[date1]']").hide("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
            else if($("#reptype").val()==2)
            {
				 $("#departmanblog").show("slow");
                $("#gzl3").show("slow");
					 $("#subdepartmentblok").show("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
			
			else if($("#reptype").val()==42)
            {
				 $("#departmanblog").show("slow");
                $("#gzl3").hide("slow");
				 $("#gzl2").hide("slow");
					 $("#subdepartmentblok").show("slow");
                 $("#pesttypeChange").html("<?=t('Pest Type')?>");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
			
			else if($("#reptype").val()==5)
			{
				 $("#departmanblog").show("slow");
				$("#gzl3").show("slow");
					 $("#subdepartmentblok").show("slow");
				$("#gzl").show("slow");
                $("#gzl2").show("slow");
 $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
				$("#pointno").removeAttr("multiple")
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
			}
			else if($("#reptype").val()==7)
			{
				 $("#departmanblog").show("slow");
				 $("#gzl3").show("slow");
				 	 $("#subdepartmentblok").show("slow");
         $("#pesttypeChange").html("<?=t('Report Criterion')?>");
		 $("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
				$("#startEndTime").show("slow");
				$("#typex2").hide("slow");

			}
			else if($("#reptype").val()==8)
			{
					$("#gzl3").show("slow");
					$("#gzl2").hide("slow");
				 $("#subdepartmentblok").hide("slow");
				 $("#typeselect").val(0);
				  $("#typeselect").trigger("change");
				   $("#departmanblog").hide("slow");
				
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
			}
				else if($("#reptype").val()==98)
			{
				$("#departmanblog").show("slow");
			   $("#subdepartmentblok").show("slow");
               $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("#gzl").show("slow");
                $("#gzl2").show("slow");
                $("#gzl3").show("slow");
                if($("#type option:selected").text()=="Select")
                    $("#type").find("option").eq(0).remove();

                $("[name='Monitoring[date]']").hide("slow");
                $("[name='Monitoring[date1]']").hide("slow");
				$("#startEndTime").hide("slow");
				$("#startEndDate").show("slow");
				$("#typex").hide("slow");
				$("#typex2").show("slow");
			}

            else
            {
				 $("#departmanblog").show("slow");
				 $("#subdepartmentblok").show("slow");
               $("#pesttypeChange").html("<?=t('Pest Type')?>");
                $("#gzl").show("slow");
                $("#gzl2").show("slow");
                $("#gzl3").hide("slow");
                if($("#type option:selected").text()=="Select")
                    $("#type").find("option").eq(0).remove();

                $("[name='Monitoring[date]']").show("slow");
                $("[name='Monitoring[date1]']").show("slow");
				
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
				
            }

          if($("#reptype").val()==13)
            {
               $("#departmanblog").hide("slow");
					       $("#subdepartmentblok").hide("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                 $("#typex").hide("slow");
                $("#datetimefinish").show("slow");
                $("#datetimestart").show("slow");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }
			
			  if($("#reptype").val()==41)
            {
               $("#departmanblog").hide("slow");
			   $("#subdepartmentblok").hide("slow");
                $("#gzl2").hide("slow");
                $("#gzl3").hide("slow");
                 $("#typex").hide("slow");
                $("#datetimefinish").show("slow");
                $("#datetimestart").show("slow");
				$("#startEndTime").show("slow");
				$("#startEndDate").hide("slow");
				$("#typex2").hide("slow");
            }


        })

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


<script>
function test(a){
// alert(a);
	if($("#reptype").val()==1)
	{
	 $.post( "/client/datetime?time="+a).done(function( data ) {
		// alert(data);
		var value = jQuery.parseJSON( data );
		// alert(value)
                $('#datetimefinish').val(value);
				var x = document.getElementById("datetimefinish").max =value;
            });
	}
  else if($("#reptype").val()==11)
  {
    var tarih = new Date(document.getElementById("datetimestart").value);
    var y = tarih.getFullYear();
    tarih.setFullYear(tarih.getFullYear()+1, 1, 0);
     // tarih.setDate(-1);
     // tarih.setDate(+1);
    var d = tarih.getDate();
    var m =  12;
    document.getElementById("datetimefinish").max =y + "-" + m + "-" + d;
    document.getElementById("datetimefinish").min=document.getElementById("datetimestart").value;
    document.getElementById("datetimefinish").value =y + "-" + m + "-" + d;
  }
	else
	{
		document.getElementById("datetimefinish").max='<?=date("Y-m-d",time());?>';
	}
}

      function myFunction() {

 department="";
			if($("#typeselect").val()==0)
			{
									$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );
				$.post( "/client/tumunugetir?id="+<?=$_GET["id"]?>).done(function( data ) {
					$('#pointno').html(data);
					$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
				});
					$( "#subdepartment" ).prop( "disabled", true );
					$( "#subdepartment" ).val( 0);
			}
			else
			{
				// yy=document.getElementById("typeselect").value;
        var selected1=$("#typeselect option:selected").map(function(){ return this.value }).get();
        selected1.push(document.getElementById("typeselect").value);// 2 is the val I set for Dog
        department=selected1.join();
				$.post( "/client/subdepartments?id="+department).done(function( data ) {
					$('#subdepartment').html(data);

				});
	
				// department=document.getElementById("typeselect").value;
				subdepartment=document.getElementById("subdepartment").value;
				type=document.getElementById("type").value;
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );
								$( "#pointno" ).prop( "disabled", true );			$( "#subdepartment" ).prop( "disabled", true );
				$.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function( data ) {
								$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
					$('#pointno').html(data);
				});
			}
        }

			function myReport(){
            // department=document.getElementById("typeselect").value;
            var selected1=$("#typeselect option:selected").map(function(){ return this.value }).get();
          selected1.push(document.getElementById("typeselect").value);// 2 is the val I set for Dog
        department =selected1.join();
            var selected=$("#subdepartment option:selected").map(function(){ return this.value }).get();
    selected.push(document.getElementById("subdepartment").value);// 2 is the val I set for Dog
   subdepartment=selected.join();

//console.log(selected.join());
					$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );

            type=document.getElementById("type").value;
            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type).done(function(data) {
												$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pointno').html(data);
            });
        }


		  function myType(){
            department=document.getElementById("typeselect").value;
            subdepartment=document.getElementById("subdepartment").value;
            type=document.getElementById("type").value;
			reptype=document.getElementById("reptype").value;

			var client=<?=$_GET["id"]?>;
						$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );

            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type+"&&clientid="+client).done(function( data ) {
										$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pointno').html(data);
            });

             //Zararlıları getir
            $.post( "/client/peststypes?type="+type+"&reptype="+reptype).done(function( data ) {
													$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pests').html(data);
            });

        }
		
		  function myType2(){
            department=document.getElementById("typeselect").value;
            subdepartment=document.getElementById("subdepartment").value;
            type=document.getElementById("type2").value;
			reptype=document.getElementById("reptype").value;
			
			
			  var select = document.getElementById('type2');
    var selectedValues = [];

    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].selected) {
            selectedValues.push(select.options[i].value);
        }
    }
	type=selectedValues.join(',')
			var client=<?=$_GET["id"]?>;
							$( "#pointno" ).prop( "disabled", true );
								$( "#subdepartment" ).prop( "disabled", true );
								$( "#type" ).prop( "disabled", true );$( "#type2" ).prop( "disabled", true );$( "#pests" ).prop( "disabled", true );

            $.post( "/client/pointno?department="+department+"&&subdepartment="+subdepartment+"&&type="+type+"&&clientid="+client).done(function( data ) {
										$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pointno').html(data);
            });

             //Zararlıları getir
            $.post( "/client/peststypes?type="+type+"&reptype="+reptype).done(function( data ) {
																		$( "#pointno" ).prop( "disabled", false );
								$( "#subdepartment" ).prop( "disabled", false );
								$( "#type" ).prop( "disabled", false );$( "#type2" ).prop( "disabled", false );$( "#pests" ).prop( "disabled", false );
                $('#pests').html(data);
            });

        }

</script>
<?php
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/datatables.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js;';

Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/icheck/icheck.min.js;';
//Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/checkbox-radio.js;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/icheck/icheck.css;';


Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/forms/select/select2.full.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/js/scripts/forms/select/form-select2.js;';



Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js;';
Yii::app()->params['scripts'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/js/pickers/daterange/daterangepicker.js;';




Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/forms/selects/select2.min.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/css/app.css;';


Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/daterange/daterangepicker.css;';
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
