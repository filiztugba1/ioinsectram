<?php

class MonitoringController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','monitoringtypecreate','monitoringlocationcreate','monitoringlist','monitoringinput','deleteall'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		 $clientid=$_POST['Monitoring']['clientid'];

		$model=new Monitoring;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//$monitoring=Monitoring::model()->findAll(array(
								  // 'condition'=>'definationlocation=:definationlocation and dapartmentid=:dapartmentid and subid=:subid and clientid=:clientid and mno=:mno and mtypeid=:mtypeid and mlocationid=:mlocationid','params'=>array('definationlocation'=>$_POST['Monitoring']['definationlocation'],'dapartmentid'=>$_POST['Monitoring']['dapartmentid'],'subid'=>$_POST['Monitoring']['subid'],'clientid'=>$_POST['Monitoring']['clientid'],'mno'=>$_POST['Monitoring']['mno'],'mtypeid'=>$_POST['Monitoring']['mtypeid'],'mlocationid'=>$_POST['Monitoring']['mlocationid'])
							//   ));



		$monitoring2=Monitoring::model()->findAll(array(
								   'condition'=>'mno='.$_POST['Monitoring']['mno'].' and clientid='.$clientid,
							   ));




			if(isset($_POST['Monitoring']) && count($monitoring2)==0)
			{
				$model->attributes=$_POST['Monitoring'];
				$dynamicstring=Monitoring::model()->barkodeControl(time()+rand(0,999999)+round(microtime(true) * 1000));
				$model->barcodeno=$dynamicstring;
        
				$model->techdescription=$_POST['Monitoring']['techdescription'];
				$model->createdtime=time();
				$model->activetime=time();
				$model->passivetime=0;
				$model->save();
					//loglama
				Logs::model()->logsaction();
				/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				$ids=array();
				$monitorolurturma=1;
				array_push($ids,$dynamicstring);
				include("./barcode/monitorBarcodeList.php");
				echo json_encode('ok');
				/*
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/client/monitoringpoints','id'=>$clientid));
					$this->redirect(array('/client/monitoringpoints/','id'=>$clientid));
				*/
			}

		else
		{
				echo json_encode('no');
		}
		/*
		Yii::app()->user->setFlash('error', t('Available Data!'));
		$this->redirect(array('index'));
		*/
	}


	public function actionMonitoringtypecreate()
	{

		 $clientid=$_POST['Monitoringtype']['branchid'];



		$model=new Monitoringtype;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Monitoringtype']))
		{
			$model->attributes=$_POST['Monitoringtype'];
			$model->save();
				//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Monitoring Point Type Create Success!'),array('/client/monitoringpoints','id'=>$clientid));
				$this->redirect(array('/client/monitoringpoints/','id'=>$clientid));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}



	public function actionMonitoringlocationcreate()
	{

		 $clientid=$_POST['Monitoringlocation']['branchid'];

		$model=new Monitoringlocation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Monitoringlocation']))
		{
			$model->attributes=$_POST['Monitoringlocation'];
			$model->save();
				//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Monitoring Point Location Create Success!'),array('/client/monitoringpoints','id'=>$clientid));
				$this->redirect(array('/client/monitoringpoints/','id'=>$clientid));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionMonitoringlist()
	{
		 $monitoring=Monitoring::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'clientid='.$_GET['id'],
							   ));

		?>
		<table class="table table-striped table-bordered dataex-html5-export table-responsive">
                        <thead>
                          <tr>
						   <th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
							 <th><?=mb_strtoupper(t('Department'));?></th>
	 <th><?=mb_strtoupper(t('Sub-Department'));?></th>
	 <th><?=t('M.NO');?></th>
	 <th><?=mb_strtoupper(t('Location'));?></th>
	 <th><?=mb_strtoupper(t('Monitoring Type'));?></th>
	 <th><?=t('D.LOCATION');?></th>
							 <th><?=t('IS ACTIVE');?></th>
                            <th><?=t('PROCESS');?></th>

                          </tr>
                        </thead>
                        <tbody>
             				<?php foreach($monitoring as $monitoringx):?>

									<?php    $departmentlists=Departments::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'clientid='.$_GET['id'].' and id='.$monitoringx->dapartmentid,
							   ));

							 $departmentsub=Departments::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitoringx->subid,
							   ));

							   $monitoringlocation=Monitoringlocation::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitoringx->mlocationid,
							   ));



							  $monitoringtype=Monitoringtype::model()->find(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'id='.$monitoringx->mtypeid,
							   ));

							?>


                                <tr>
								<td><input type="checkbox" name="Monitoring[id][]" class='sec' value="<?=$monitoringx->id;?>"></td>
                                <td><?=$departmentlists->name;?></td>
								 <td><?=$departmentsub->name;?></td>
								 <td><?=$monitoringx->mno;?></td>
								 <td><?=t($monitoringlocation->name);?></td>
							     <td><?=$monitoringtype->name;?></td>
							     <td><?=$monitoringx->definationlocation;?></td>
							     <td><?=$monitoringx->techdescription;?></td>
								 <td>
								 <div class="form-group pb-1">
										<input type="checkbox" data-size="sm" id="switchery"  class="switchery" data-id="<?=$monitoringx['id'];?>"  <?if($monitoringx['active']==1){echo "checked";} if(Yii::app()->user->checkAccess('client.branch.monitoringpoints.update')){}else{echo ' disabled';}?>  />
									</div>
								</td>

								<!--
								<td>
									<div class="form-group pb-1">
										<input type="checkbox" data-size="sm" id="switchery"  class="switchery" data-id="<?=$monitoringx->id;?>"  <?if($monitoringx->active==1){echo "checked";} if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.update')){}else{echo 'disabled';}?>  />
									</div>
								</td>
								-->


									<td>
								<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.update')){ ?>
										 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
										 data-id="<?=$monitoringx->id;?>"
										 data-dapartmentid="<?=$monitoringx->dapartmentid;?>"
										 data-subid="<?=$monitoringx->subid;?>"
										 data-mno="<?=$monitoringx->mno;?>"
										 data-mtypeid="<?=$monitoringx->mtypeid;?>"
										 data-mlocationid="<?=$monitoringx->mlocationid;?>"
										 data-definationlocation="<?=$monitoringx->definationlocation;?>"
										 data-techdescription="<?=$monitoringx->techdescription;?>"
										 data-active="<?=$monitoringx->active;?>"
										 data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Update');?>"

										 ><i style="color:#fff;" class="fa fa-edit"></i></a>

								<?}?>

								<?php if (Yii::app()->user->checkAccess('client.branch.monitoringpoints.delete')){ ?>


										<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?=$monitoringx->id;?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete');?>"
										><i style="color:#fff;" class="fa fa-trash"></i></a>

								<?}?>

									</td>
                                </tr>


								<?php endforeach;?>

                        </tbody>
                        <tfoot>
                          <tr>
							<th style='width:1px;'>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=t('Delete selected');?>"><i class="fa fa-trash"></i></button>
								</div>
							</th>
						   <th><?=mb_strtoupper(t('Department'));?></th>
		<th><?=mb_strtoupper(t('Sub-Department'));?></th>
		<th><?=t('M.NO');?></th>
		<th><?=mb_strtoupper(t('Location'));?></th>
		<th><?=mb_strtoupper(t('Monitoring Type'));?></th>
		<th><?=t('D.LOCATION');?></th>
							 <th><?=t('IS ACTIVE');?></th>
                            <th><?=t('PROCESS');?></th>
                          </tr>
                        </tfoot>
                      </table>



		<?
	}


	public function actionMonitoringinput()
	{
		 $monitorcount=Monitoring::model()->find(array(
								   'order'=>'mno DESC',
								   'condition'=>'clientid='.$_GET['id'],
							   ));


		?>

			<input type="number" class="form-control" value="<?=($monitorcount->mno)+1;?>" id="" placeholder="<?=t('Monitoring Point No');?>" name="Monitoring[mno]">
      <?php
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if($id==0)
		{
			$id=$_POST['Monitoring']['id'];
		}



		 $clientid=$_POST['Monitoring']['clientid'];
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Monitoring']))
		{
			$model->attributes=$_POST['Monitoring'];
			if($_POST['Monitoring']['active']==1)
			{
				$model->activetime=time();
			}
			if($_POST['Monitoring']['active']==0)
			{
				$model->passivetime=time();
			}

				$model->techdescription=$_POST['Monitoring']['techdescription'];
			$model->update();
					//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/client/monitoringpoints','id'=>$clientid));
				$this->redirect(array('/client/monitoringpoints/','id'=>$clientid));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$clientid=$_POST['Monitoring']['clientid'];
		if($id==0)
		{
			$id=$_POST['Monitoring']['id'];
		}
		$monitoring=Mobileworkorderdata::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'condition'=>'monitorid='.$id,
							   ));


		if(count($monitoring)>0)
		{
			$ax=User::model()->userobjecty('');
			$buyer=User::model()->find(array('condition'=>'id='.$ax->id));
			Yii::app()->user->setFlash('error',User::model()->dilbul($buyer->languageid,'Bu monitöre iş emri açılmış, bu yüzden silemezsiniz. Lütfen pasife alın!'));
			$this->redirect(array('/client/monitoringpoints', 'id' => $clientid));
		}
		else
		{
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			{
				//loglama
				Logs::model()->logsaction();
				/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/client/monitoringpoints','id'=>$clientid));
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/client/monitoringpoints','id'=>$clientid));
			}
		}
		
	}

	public function actionDeleteall()
	{
		$clientid=$_POST['Monitoring']['clientid'];
		$deleteall=explode(',',$_POST['Monitoring']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}

		//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Selected monitoring deleted!'),array('/client/monitoringpoints','id'=>$clientid));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{



		$dataProvider=new CActiveDataProvider('Monitoring');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Monitoring('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Monitoring']))
			$model->attributes=$_GET['Monitoring'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Monitoring the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Monitoring::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Monitoring $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='monitoring-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
