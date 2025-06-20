<?php
User::model()->login();


						?>




<?php



?>


<?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>
<?=User::model()->geturl('Client','Monitoring Points',$_GET['id'],'client');?>

			<div class="card">
		<div class="card-header" style="">
							<ul class="nav nav-tabs">
					<?php if (Yii::app()->user->checkAccess('client.branch.staff.view')){ ?>
						  <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/branchstaff/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;">
							<?=count($say);?>

							</span><?=t('Staff');?>

							</a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.department.view')){ ?>

						  <li class="nav-item">
							<a class="nav-link "  href="<?=Yii::app()->baseUrl?>/client/departments/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $departments);?></span><?=t('Departments');?></a>
						  </li>
					   <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.view')){ ?>
							<li class="nav-item">
							<a class="nav-link active"  href="<?=Yii::app()->baseUrl?>/client/monitoringpoints/<?=$_GET['id'];?>" ><span class="btn-effect2" style="font-size: 15px;"><?php echo count( $monitoring);?></span><?=t('Monitoring Points');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.reports.view')){ ?>

					      <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/reports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-bar-chart-o" style="font-size: 15px;"></i></span><?=t('Reports');?></a>
						  </li>
					  <?php }?>
					  <?php if (Yii::app()->user->checkAccess('client.branch.offers.view')){ ?>
						   <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/offers/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Offers');?></a>
						  </li>

					  <?php }?>
					    <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/visitreports/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-envelope-o" style="font-size: 15px;"></i></span><?=t('Visit Reports');?></a></a>
						  </li>
					  <?php if (Yii::app()->user->checkAccess('client.branch.filemanagement.view')){ ?>

					        <li class="nav-item">
							<a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/files2/<?=$_GET['id'];?>" ><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-file-pdf-o" style="font-size: 15px;"></i></span><?=t('File Management');?></a>
						  </li>
						<?php }?>

								<?php //if (Yii::app()->user->checkAccess('client.branch.reports.view') && $ax->clientid==0){ ?>
					        <li class="nav-item">
                        <a class="nav-link"  href="<?=Yii::app()->baseUrl?>/client/clientqr?id=<?=$_GET['id'];?>" target="_blank"><span class="btn-effect" style="font-size: 15px;"><i class="fa fa-qrcode" style="font-size: 15px;"></i></span><?=t('Client QR');?> </a></a>
                      </li>
					 <?//}?>



                    </ul>
				</div>

</div>


  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.create')){ ?>
<div class="row" id="createpage" >


	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">

			   <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Monitoring Points Create');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancel" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

					<!-- <form id="departments-form" action="/monitoring/create" method="post">	-->

				<form id="monitoring-form">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput"  name="Monitoring[clientid]" value="<?=$_GET['id'];?>">
                      <input type="hidden" class="form-control" id="basicInput"  name="Monitoring[active]" value="1">

					<div class="row">

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Departments');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="typeselect" onchange="myFunction()"  name="Monitoring[dapartmentid]" required>
							<option value="" selected><?=t('Select');?></option>
						  <?php foreach($departments as $departmentx){?>
                            <option value="<?=$departmentx->id;?>"><?=$departmentx->name;?></option>
						  <?php }?>
                          </select>
                        </fieldset>
                    </div>



						<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
						<label for="basicSelect"><?=t('Sub-Department');?></label>
                     <fieldset class="form-group">

                          <select class="custom-select block" id="subdepartmentclient" name="Monitoring[subid]" disabled required>
						  <option value=""><?=t('Select');?></option>
                           </select>
                        </fieldset>

                    </div>


					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Monitoring Point No');?></label>
                        <fieldset class="form-group" id='monitorno'>
                          <input type="number"  class="form-control"  value="<?=isset($monitorcount->mno)?$monitorcount->mno+1:1;?>" placeholder="<?=t('Monitoring Point No');?>" name="Monitoring[mno]">
                        </fieldset>
                    </div>



						<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
						<label for="basicSelect"><?=t('Monitoring Point Location');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Monitoring[mlocationid]" >
						  <?php foreach($monitoringlocations as $monitoringlocation){?>
						  <option value="<?=$monitoringlocation->id;?>"><?=t($monitoringlocation->name);?></option>
						  <?php }?>
                           </select>
                        </fieldset>

                    </div>



						

						<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
						<label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Monitoring[mtypeid]" >
						   <?php									if($country==2){?>
									<!--	 <option value="-100"><?=t('RM').' - '.t('All Rodents');?></option>-->
									<?php }
									foreach($monitoringtypes as $monitoringtype){?>
                                        <option value="<?=$monitoringtype->id;?>"><?=t($monitoringtype->name).' - '.t($monitoringtype->detailed);?></option>
                                    <?php }?>
                           </select>
                        </fieldset>

                    </div>

						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Monitoring Point Definiton Location');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Monitoring Point Definiton Location');?>" name="Monitoring[definationlocation]" required>
                        </fieldset>
                    </div>
            
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Monitor Alternative Number');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="basicInput" placeholder="<?=t('Monitor Alternative Number');?>" name="Monitoring[alternativenumber]" >
                        </fieldset>
                    </div>
            
						<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Technician Note');?></label>
                        <fieldset class="form-group">
                          
                             <input type="text" class="form-control" placeholder="<?=t('Technician Note');?>" name="Monitoring[techdescription]">
                      
                        </fieldset>
                    </div>


          


  	<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary" type="submit"><?=t('Create');?></button>
								</div>
                        </fieldset>
                    </div>
					  </div>
					</div>

					</div>
				</div>
				</form>
			</div>

	</div><!-- form -->
	</div>

<?php }?>


<div class="row" id="barcodesearch" >


	<div class="col-xl-12 col-lg-12 col-md-12">

			<div class="card">

			   <div class="card-header">
						 <div class="row" style="padding-bottom: 10px;border-bottom: 1px solid #f8f8f9;">
							 <div class="col-md-6">
								  <h4  class="card-title"><?=t('Show Client Bar/QR Code');?></h4>
									</div>
									 <div class="col-md-6">
								<button id="cancelb" class="btn btn-danger btn-xs" style="float:right" type="submit"><i class="fa fa-times"></i></button>
								</div>
						</div>
					 </div>

					<!-- <form id="departments-form" action="/monitoring/create" method="post">	-->

				<form id="monitoring-form5" action="<?=Yii::app()->baseUrl?>/client/showbarcodes" method="post" target="_blank">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control" id="basicInput5"  name="Monitoring[clientid]" value="<?=$_GET['id'];?>">
                       <input type="hidden" class="form-control" id="basicInput5"  name="Monitoring[active]" value="1">
					<div class="row">


						<?php    $departments=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=0 and clientid='.$_GET['id'],
							   ));


						?>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Departments');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="typeselect5" onchange="myFunction5()"  name="Monitoring[dapartmentid]" >
							<option value="" selected><?=t('Select');?></option>
						  <?php foreach($departments as $departmentx){?>
                            <option value="<?=$departmentx->id;?>"><?=$departmentx->name;?></option>
						  <?php }?>
                          </select>
                        </fieldset>
                    </div>



						<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
						<label for="basicSelect"><?=t('Sub-Department');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="subdepartmentclient5" name="Monitoring[subid]" disabled >
						  <option value=""><?=t('Select');?></option>
                           </select>
                        </fieldset>

                    </div>



					<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
					<label for="basicSelect"><?=t('Monitoring Point Location');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Monitoring[mlocationid]" >
							  <option value=""><?=t('Select');?></option>
						  <?php foreach($monitoringlocations as $monitoringlocation){?>
						  <option value="<?=$monitoringlocation->id;?>"><?=t($monitoringlocation->name);?></option>
						  <?php }?>
                           </select>
                        </fieldset>
                    </div>



						<?php   // $monitoringtypes=Monitoringtype::model()->findAll();?>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1" >
					<label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Monitoring[mtypeid]" >
							  <option value=""><?=t('Select');?></option>
						     <?php									if($country==2){?>
										 <option value="-100"><?=t('RM').' - '.t('All Rodents');?></option>
									<?php }
																																							if ($monitoringtypes)				{	
									foreach($monitoringtypes as $monitoringtype){?>
                                        <option value="<?=$monitoringtype->id;?>"><?=t($monitoringtype->name).' - '.t($monitoringtype->detailed);?></option>
                                    <?php } } ?>
                           </select>
                        </fieldset>

                    </div>

					<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
					<label for="basicSelect"><?=t('Monitoring Point Numbers');?></label>
                        <fieldset class="form-group" id='monitorno' >
							<input type="text" class="form-control" name='Monitoring[mno]'>
							<span style="font-size: 10px;
    color: #d32f2f;"><?=t("örnek:1,10 şeklinde arama yaparsanız 1 ve 10 numaralı monitorleri aramış olursunuz.");?><br>
		<?=t("örnek:1-10 şeklinde arama yaparsanız 1 den 10 a kadar olan monitorleri 1 ve 10 dahil aramış olursunuz.");?>

							</span>
                        </fieldset>
                    </div>



										<div class="col-xl-4 col-lg-4 col-md-4 mb-1">
											<label for="basicSelect"><?=t('Active');?></label>
						                       <fieldset class="form-group">
						                          <select class="custom-select block" id="customSelect8" name='Monitoring[active]'>
						                            <option value="1" selected><?=t('Active');?></option>
						                            <option value="0"><?=t('Passive');?></option>
						                          </select>
						                        </fieldset>
																		</div>

							  	<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
										<div class="input-group-append" id="button-addon2">
											<button class="btn btn-primary" type="submit"><?=t('Show');?></button>
										</div>
							    </div>
					  </div>
					</div>

					</div>
				</div>
				</form>
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
						 <h4 class="card-title"><?=t('Client Monitoring Point List');?></h4>
						</div>





					<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.create') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add Monitoring Point');?> <i class="fa fa-plus"></i></button>
								</div>


						</div>
					<?php }?>

					</div>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1" style='padding-top: 10px;background: #ececec; padding-bottom: 0px;border: 1px solid #d0d0d0;'>
					<div class="row">

						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
							<a id="all" href="<?=Yii::app()->baseUrl?>/client/monitoringpoints?id=<?=$_GET['id'];?>" class="btn btn-info"><?=t('All Monitors');?></a>
							<a id="active" href="<?=Yii::app()->baseUrl?>/client/monitoringpoints?id=<?=$_GET['id'];?>&&isactive=1" class="btn btn-success"><?=t('Active Monitors');?></a>
							<a id="passive" href="<?=Yii::app()->baseUrl?>/client/monitoringpoints?id=<?=$_GET['id'];?>&&isactive=0" class="btn btn-danger"><?=t('Passive Monitors');?></a>
						</div>

						<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
							<div class="input-group-append" style="float: right; text-align: right;">
								<!--href="/barcode/monitorBarcodeList.php?clientid=<?=$_GET['id']?>"-->
								<a id="openbarcode" href="#" class="btn btn-black"><?=t('Monitoring Points Barcodes');?></a>
							</div>
						</div>
					</div>
				</div>



                </div>



                <div class="card-content collapse show">
                  <div class="card-body card-dashboard" id='list'>

                      <table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
						  <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
							<!-- <th><?=t('M.NO');?></th>-->
                               <th><?=t('Department');?></th>
							 <th><?=t('Sub-Department');?></th>
							 <th><?=t('M.ID');?></th>
							 <th><?=t('Location');?></th>
							 <th><?=t('Monitoring Type');?></th>
							 <th><?=t('D.LOCATION');?></th>
                                          <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete') ){ ?>
							
							 <th><?=t('Alternative Number');?></th>
							 <th><?=t('Tech Description');?></th>
                            <?php } ?>

							<?php if($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid ||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid)){?>
							 <th><?=t('IS ACTIVE');?></th>
                          <th>  <?=t('Process');?></th>
							<?php }?>

                          </tr>
                        </thead>
                        <tbody>


             				<?php foreach($monitoring as $monitoringx):?>

									<?php    $departmentlists=Departments::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'clientid='.$_GET['id'].' and id='.$monitoringx['dapartmentid'],
							   ));

							 $departmentsub=Departments::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitoringx['subid'],
							   ));

							   $monitoringlocation=Monitoringlocation::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitoringx['mlocationid'],
							   ));



							  $monitoringtype=Monitoringtype::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitoringx['mtypeid'],
							   ));

							?>


                                <tr>
								<td><input type="checkbox" name="Monitoring[id][]" class='sec' value="<?=$monitoringx['id'];?>"></td>
								<!-- <td><?=$monitoringx['id'];?></td> -->
                                <td><?=$departmentlists->name;?></td>
								 <td><?=$departmentsub->name;?></td>
								 <td><?=$monitoringx['mno'];?></td>
								 <td><?=t($monitoringlocation->name);?></td>
							     <td><?=t($monitoringtype->name);?></td>
							     <td><?=$monitoringx['definationlocation'];?></td>
                   <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete') ){ ?> 
							      <td><?=$monitoringx['alternativenumber'];?></td>
							      <td><?=$monitoringx['techdescription'];?></td>
                   <?php } ?>


								<?php if(($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){?>
									<td>

									<div class="form-group pb-1">
										<input type="checkbox" data-size="sm" id="switchery"  class="switchery" data-id="<?=$monitoringx['id'];?>"  <?php if($monitoringx['active']==1){echo "checked";} if(Yii::app()->user->checkAccess('client.branch.monitoringpoints.update')){}else{echo ' disabled';}?>  />
										<?php if($monitoringx['active']==1){echo '<span style="color:white">A</span>';}else{echo '<span style="color:white">P</span>';}?>
									</div>

								</td>




									<td>


								<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.update')){ ?>
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										 data-id="<?=$monitoringx['id'];?>"
										 data-dapartmentid="<?=$monitoringx['dapartmentid'];?>"
										 data-subid="<?=$monitoringx['subid'];?>"
										 data-mno="<?=$monitoringx['mno'];?>"
										 data-mtypeid="<?=$monitoringx['mtypeid'];?>"
										 data-mlocationid="<?=$monitoringx['mlocationid'];?>"
										 data-alternativenumber="<?=$monitoringx['alternativenumber'];?>"
										 data-definationlocation="<?=$monitoringx['definationlocation'];?>"
                           <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete') ){ ?> 
							    			 data-techdescription="<?=$monitoringx['techdescription'];?>"
                   <?php } ?>							
										 data-active="<?=$monitoringx['active'];?>"
										 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"

										 ><i style="color:#fff;" class="fa fa-edit"></i></a>

								<?php }?>

								<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete')){ ?>


										<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$monitoringx['id'];?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"
										><i style="color:#fff;" class="fa fa-trash"></i></a>

								<?php }?>



									</td>

								<?php }?>
                                </tr>


								<?php endforeach;?>

                        </tbody>
                        <tfoot>
                          <tr>

						  <th style='width:1px;'>
						  <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete') && $transfer!=1){ ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete selected');?>"><i class="fa fa-trash"></i></button>
								</div>
						<?php }?>
							</th>
							<!-- <th><?=t('M.NO');?></th> -->

                         <th><?=t('Department');?></th>
							 <th><?=t('Sub-Department');?></th>
							 <th><?=t('M.ID');?></th>
							 <th><?=t('Location');?></th>
							 <th><?=t('Monitoring Type');?></th>
							 <th><?=t('D.LOCATION');?></th>
                            <?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete') ){ ?>
							
							 <th><?=t('Alternative Number');?></th>
							 <th><?=t('Tech Description');?></th>
                            
                       <?php }     ?>

							 <?php if($transfer!=1 || $ax->branchid==0 ||$ax->clientid==0 || $ax->branchid==$tclient->firmid ||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid)){?>
							 <th><?=t('IS ACTIVE');?></th>
                          <th>  <?=t('Process');?></th>
							<?php }?>

                        </tfoot>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>




<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.update')){ ?>
<!-- G�NCELLEME BA�LANGI�-->
	<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="duzenle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitoring Points Update');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
							<form id="departments-form" action="<?=Yii::app()->baseUrl?>/monitoring/update/0" method="post">
				<div class="card-content">
					<div class="card-body">

					  <input type="hidden" class="form-control"  name="Monitoring[clientid]" value="<?=$_GET['id'];?>">
					   <input type="hidden" class="form-control" id="modalmonitorid"  name="Monitoring[id]" value="">
						<input type="hidden" class="form-control" id="modalmonitorsubid">


					<div class="row">


						<?php    $departments=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid=0 and clientid='.$_GET['id'],
							   ));


						?>



					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Departments');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="typeselect2" onchange="myFunction2()"  name="Monitoring[dapartmentid]">
							<option value="0" selected><?=t('Select');?></option>
						  <?php foreach($departments as $departmentx){?>
                            <option value="<?=$departmentx->id;?>"><?=$departmentx->name;?></option>
						  <?php }?>
                          </select>
                        </fieldset>
                    </div>





						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="subdepartmentclient2">
						<label for="basicSelect"><?=t('Sub-Department');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="modalmonitorsubid" name="Monitoring[subid]">

                           </select>
                        </fieldset>

                    </div>

					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Monitoring Point No');?></label>
                        <fieldset class="form-group">
                          <input type="text" readonly class="form-control" id="modalmonitormno" placeholder="<?=t('Monitoring Point No');?>" name="Monitoring[mno]">
                        </fieldset>
                    </div>


						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Monitoring Point Location');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="modalmonitormlocationid" name="Monitoring[mlocationid]" >
						  <?php foreach($monitoringlocations as $monitoringlocation){?>
						  <option value="<?=$monitoringlocation->id;?>"><?=t($monitoringlocation->name);?></option>
						  <?php }?>
                           </select>
                        </fieldset>

                    </div>



						<?php    //$monitoringtypes=Monitoringtype::model()->findAll();
						//bura
								$disabledx='disabled';	
if ($firmid==542 || $firmid==626){
		$disabledx='';	
}	
						?>

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                     <fieldset class="form-group">
                          <select <?=$disabledx?>  class="custom-select block" id="modalmonitormtypeid" name="Monitoring[mtypeid]" >
						       <?php									if($country==2){?>
										<!-- <option value="-100"><?=t('RM').' - '.t('All Rodents');?></option>-->
									<?php }
															if ($monitoringtypes)				{																		
									foreach($monitoringtypes as $monitoringtype){
														?>
                                        <option value="<?=$monitoringtype->id;?>"><?=t($monitoringtype->name).' - '.t($monitoringtype->detailed);?></option>
                                    <?php } }				?>
                           </select>
                        </fieldset>

                    </div>

						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Monitoring Point Definiton Location');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalmonitordefinationlocation" placeholder="<?=t('Monitoring Point Definiton Location');?>" name="Monitoring[definationlocation]">
                        </fieldset>
                    </div>
            
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Alternative Number');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalmonitoralternativenumber" placeholder="<?=t('Alternative Number');?>" name="Monitoring[alternativenumber]">
                        </fieldset>
                    </div>
            
						<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
					<label for="basicSelect"><?=t('Technician Note');?></label>
                        <fieldset class="form-group">
                          <input type="text" class="form-control" id="modalmonitortechdescription" placeholder="<?=t('Technician Note');?>" name="Monitoring[techdescription]">
                        </fieldset>
                    </div>



							<div class="col-xl-12 col-lg-12 col-md-12 mb-1" >
						<label for="basicSelect"><?=t('Monitoring Point Type');?></label>
                     <fieldset class="form-group">
                          <select class="custom-select block" id="modalmonitoractive" name="Monitoring[active]" >

						  <option value="1"><?=t('Active');?></option>
						  <option value="0"><?=t('Passive');?></option>

                           </select>
                        </fieldset>

  					<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
						<label for="basicSelect" style="margin-top:15px" class="hidden-sm hidden-xs"></label>
                        <fieldset class="form-group">
                        <div class="input-group-append" id="button-addon2">
									<button class="btn btn-primary block-page" type="submit"><?=t('Update');?></button>
								</div>
                        </fieldset>
                    </div>
					  </div>
					</div>

					</div>
				</div>
				</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<?php }?>
	<!-- G�NCELLEME B�T��-->
	<!--S�L BA�LANGI�-->
	<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete')){ ?>
		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="sil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitoring Points Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

					<!--form baslang��-->
						<form id="departments-form" action="<?=Yii::app()->baseUrl?>/monitoring/delete/0" method="post">
						<input type="hidden" class="form-control" id="basicInput"  name="Monitoring[clientid]" value="<?=$_GET['id'];?>">


						<input type="hidden" class="form-control" id="modalmonitorid2" name="Monitoring[id]" value="0">

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

	<!--delelete all start-->

		<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-group">
                           <!-- Modal -->
            <div class="modal fade text-left" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8"
                          aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h4 class="modal-title" id="myModalLabel8"><?=t('Monitoring Point Delete');?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
                            </button>
                        </div>

				<!--form baslang��-->
						<form action="<?=Yii::app()->baseUrl?>/monitoring/deleteall" method="post">

						<input type="hidden" class="form-control" id="modalid3" name="Monitoring[id]" value="0">
						<input type="hidden" class="form-control" id="basicInput"  name="Monitoring[clientid]" value="<?=$_GET['id'];?>">

                            <div class="modal-body">

								<div class="col-xl-12 col-lg-12 col-md-12 mb-1">
									<h5><?=t('Are you sure you want to delete?');?></h5>
								</div>



                            </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary " data-dismiss="modal"><?=t('Close');?></button>
                                 <button class="btn btn-danger block-page" type="submit"><?=t('Delete');?></button>
                                </div>

						</form>

									<!--form biti�-->
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- delete all finish -->

<?php }?>
<?php }?>
<style>
.switchery,.switch{
margin-left:auto !important;
margin-right:auto !important;
}

.table tr {
    cursor: pointer;
}
.hiddenRow {
    padding: 0 4px !important;
    background-color: #eeeeee;
    font-size: 13px;
}

</style>

<script>


$('.accordian-body').on('show.bs.collapse', function () {
    $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
});



 //delete all start
$(document).ready(function(){
	$("#barcodesearch").hide();
	$("#openbarcode").on('click',function(){
		$("#barcodesearch").show("slow");
	})


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


//ekle b�l�m� baslang�c

function myFunction() {
	yy=document.getElementById("typeselect").value;
		 $.post( "<?=Yii::app()->baseUrl?>/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient').html(data);
			$("#subdepartmentclient" ).prop( "disabled", false );

		 });
}


function myFunction5() {
	yy=document.getElementById("typeselect5").value;
		 $.post( "<?=Yii::app()->baseUrl?>/client/subdepartments?id="+yy).done(function( data ) {
			$('#subdepartmentclient5').html(data);
			$("#subdepartmentclient5" ).prop( "disabled", false );

		 });
}
//ekle b�l�m� biti�


//G�ncelle b�l�m� baslang�c




function myFunction2() {
	yy=document.getElementById("typeselect2").value;
		 $.post( "<?=Yii::app()->baseUrl?>/client/subdepartments2?id="+yy).done(function( data ) {
			$('#subdepartmentclient2').html(data);

		 });
}


//G�ncelle b�l�m� biti�



function authchange(data,permission,obj)
{
$.post( "?id=<?=$_GET['id']?>&firmid=<?=$firmid?>", { monitoringid: data, active: permission })
  .done(function( returns ) {
	  toastr.success("<?=t('Update Successful');?>");
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


</script>


<script>
$("#createpage").hide();
$("#createbutton").click(function(){
        $("#createpage").toggle(500);
 });
 $("#cancel").click(function(){
        $("#createpage").hide(500);
 });
 $("#cancelb").click(function(){
        $("#barcodesearch").hide(500);
 });
 $(document).ready(function(){

	$("#monitoring-form").on('submit',(function(e) {
	e.preventDefault();
	 $.ajax({
      url: "<?=Yii::app()->baseUrl?>/monitoring/create",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data)
        {
			if(data.trim()=='ok')
			{

				toastr.success("<?=t('Monitoring is create successful!');?>","<center><?=t('Successful');?></center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				});

				$.post("<?=Yii::app()->baseUrl?>/monitoring/monitoringlist?id="+<?=$_GET['id'];?>).done(function( data ) {
					$('#list').html(data);
					<?php					 $monitorcount=Monitoring::model()->find(array(
								   'order'=>'mno DESC',
								   'condition'=>'clientid='.$_GET['id'],
							   ));
							   ?>
					$('#monitorno').val(<?=isset($monitorcount->mno)?$monitorcount->mno+2:2;?>);


							$(".switchery").on('change', function() {

								  if ($(this).is(':checked')) {
									  authchange($(this).data("id"),1,$(this));
								  } else {
									  authchange($(this).data("id"),0,$(this));
								  }

								  $('#checkbox-value').text($('#checkbox1').val());
							});




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
											columns: [ 0,1,2,3,4,5,6,7 ]
										},
										text:'<?=t('Copy');?>',
										className: 'd-none d-sm-none d-md-block',
										title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
										messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
									},
									{
										extend: 'excelHtml5',
										exportOptions: {
											columns: [ 0,1,2,3,4,5,6,7 ]
										},
										text:'<?=t('Excel');?>',
										className: 'd-none d-sm-none d-md-block',
										title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
										messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
									},
										 {
										 extend: 'pdfHtml5',
										 exportOptions: {
											columns: [ 0,1,2,3,4,5,6,7 ]
										},
										text:'<?=mb_strtoupper(t('Pdf'));?>',
										  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
										  title: 'Export',
										  header: true,
										  customize: function(doc) {
											doc.content.splice(0, 1, {
											  text: [{
												text: 'Client Branch \n',
												bold: true,
												fontSize: 16,
													alignment: 'center'
											  },
											 {
												text: '<?=User::model()->table('clientbranch',$_GET['id']);?> \n',
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
								]
							} );
				});

				$.post("/monitoring/monitoringinput?id="+<?=$_GET['id'];?>).done(function( datax ) {
					$('#monitorno').html(datax);
				});


			}
			if(data.trim()=='no')
			{
				toastr.error("<?=t('Available Data!');?>","<center><?=t('Error');?></center>" , {
					positionClass: "toast-bottom-right",
					containerId: "toast-top-right"
				});
			}
        }
     });


  }));





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


	$('#modalmonitorid').val($(obj).data('id'));
	$('#typeselect2').val($(obj).data('dapartmentid'));

	$('#modalmonitormno').val($(obj).data('mno'));
	$('#modalmonitormtypeid').val($(obj).data('mtypeid'));
	$('#modalmonitormlocationid').val($(obj).data('mlocationid'));
	$('#modalmonitordefinationlocation').val($(obj).data('definationlocation'));
	$('#modalmonitortechdescription').val($(obj).data('techdescription'));
	$('#modalmonitoralternativenumber').val($(obj).data('alternativenumber'));
	$('#modalmonitoractive').val($(obj).data('active'));
		yy=$(obj).data('dapartmentid');
		sub=$(obj).data('subid');
		 $.post( "/client/subdepartments2?id="+yy+"&&sub="+sub).done(function( data ) {
			$('#subdepartmentclient2').html(data);
			 $('#modalmonitorsubid').val($(obj).data('subid'));

		 });




	$('#duzenle').modal('show');

}



function openmodalsil(obj)
{
	$('#modalmonitorid2').val($(obj).data('id'));
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
                columns: [ 0,1,2,3,4,5,6,7 ]
            },
			text:'<?=t('Copy');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8 ]
            },
			text:'<?=t('Excel');?>',
			className: 'd-none d-sm-none d-md-block',
			title:'Monitoring Points (<?=date('d-m-Y H:i:s');?>)',
			messageTop:'<?=User::model()->table('clientbranch',$_GET['id']);?>'
        },
     		 {
             extend: 'pdfHtml5',
			 exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7 ]
            },
			text:'<?=mb_strtoupper(t('Pdf'));?>',
			  //message: "Made: 20_05-17\nMade by whom: User232\n" + "Custom message",
			  title: 'Export',
			  header: true,
			  customize: function(doc) {
				doc.content.splice(0, 1, {
				  text: [{
					text: 'Client Branch \n',
					bold: true,
					fontSize: 16,
						alignment: 'center'
				  },
				 {
					text: '<?=User::model()->table('clientbranch',$_GET['id']);?> \n',
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
Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css;';

Yii::app()->params['css'].=Yii::app()->theme->baseUrl.'/assets/css/style.css;';?>
