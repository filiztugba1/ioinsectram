<?php

class ConformityactivityController extends Controller
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
				'actions'=>array('index','view','efficiencyevaluation'),
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
	    $ax= User::model()->userobjecty('');
		$model=new Conformityactivity;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$activity=Conformityactivity::model()->findAll(array(
								   'condition'=>'definition=:definition and conformityid=:conformityid and date=:date','params'=>array('definition'=>$_POST['Conformityactivity']['definition'],'conformityid'=>$_POST['Conformityactivity']['conformityid'],'date'=>$_POST['Conformityactivity']['date'])
							   ));
		$conformityupdate=Conformity::model()->find(array(
								   'condition'=>'id=:conformityid','params'=>array('conformityid'=>$_POST['Conformityactivity']['conformityid'])
							   ));

		
		if(isset($_POST['Conformityactivity']) && count($activity)==0)
		{
			$model->attributes=$_POST['Conformityactivity'];
			$model->isactive=1;
			$model->deadlineUser=$ax->id;
			if($model->save() && $conformityupdate->statusid==5)
			{
				$conformityupdate->statusid=4;
				$conformityupdate->save();
			}
				Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index?id='.$_POST['Conformityactivity']['conformityid']));
		}

		//eger mevcut verinin ayn�s� post edilirse mevcut data mesaj� verilir
		Yii::app()->user->setFlash('error', t($error.' previously used'));
		$this->redirect(array('index?id='.$_POST['Conformityactivity']['conformityid']));
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
			$id=$_POST['Conformityactivity']['id'];
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Conformityactivity']))
		{
			$model->attributes=$_POST['Conformityactivity'];
			$model->save();
				Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index?id='.$_POST['Conformityactivity']['conformityid']));
			
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionEfficiencyevaluation()
	{

		
		$efficiencyevaluation=Efficiencyevaluation::model()->find(array(
										   'condition'=>'conformityid='.$_POST['Conformityactivity']['conformityid'],
									   ));
		
		if($_POST['yes_no']==0)
		{
			
				$conformity=Conformity::model()->find(array(
								   'condition'=>'id=:id','params'=>array('id'=>$_POST['Conformityactivity']['conformityid'])
							   ));
				$conformity->statusid=1;
				
				// $conformity->closedtime=time();
				if($conformity->save())
				{
					//mail gonderme Nok olunca 
					
							$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$conformity->firmid)));
							$branch=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$conformity->branchid)));
							$cbranch=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$conformity->clientid)));
							$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$cbranch->parentid)));
							
							$usermodel=User::model()->findAll(array('condition'=>'id=:id','params'=>array('id'=>$conformity->userid)));


							if($usermodel->clientid==0)  //eger conformityi acan ki�i admin-firm veya branch ise goncerilecek email
							{

								
								
								$senderemail=$firm->email;
								$sendername=$firm->name;

							

								$user=User::model()->findAll(array('condition'=>'(type=22 or type=23 or type=13 or type=26) and (clientbranchid='.$cbranch->id.' or (clientbranchid=0 and clientid='.$client->id.'))',));


							


								foreach($user as $userx)
									{

									$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is successfully closed');
									$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the test customer non-comformity was not evaluated.').' '.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_POST['Conformityactivity']['conformityid'].'">'.$conformity->numberid.'</a>';
									$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the test customer non-comformity was not evaluated.').' '.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_POST['Conformityactivity']['conformityid'].'">'.$conformity->numberid.'</a>';

							


										 $buyeremail=$userx->email;
										// $buyeremail='fcurukcu@gmail.com';
										$buyername=$userx->name.' '.$user->surname;

											$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid ','params'=>array('name'=>'conformityemail','userid'=>$userx->id)));
						

											if(empty($ismail))
											{
																
												Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
											}
											else
											{
												if($ismail->type==0)
												{
													Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
												}
															
											}
									}

							}
							else //eger conformityi acan cliebt veya client branch ise goncerilecek email
							{
								$senderemail=$client->email;
								$sendername=$client->name;

								$user=User::model()->findAll(array('condition'=>'(type=22 or type=23 or type=13 or type=26) and ((clientid=0 and branchid='.$branch->id.') or (branchid=0 and firmid='.$model->firmid.'))',));
								foreach($user as $userx)
								{


									
									$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is successfully closed');
									$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the test customer non-comformity was not evaluated.').' '.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_POST['Conformityactivity']['conformityid'].'">'.$conformity->numberid.'</a>';
									$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the test customer non-comformity was not evaluated.').' '.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_POST['Conformityactivity']['conformityid'].'">'.$conformity->numberid.'</a>';


									 $buyeremail=$userx->email;

									 // $buyeremail='fcurukcu@gmail.com';
									$buyername=$userx->name.' '.$user->surname;

									$conformityemail=Generalsettings::model()->find(array(
											   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$userx->id)
										   ));
									if(empty($conformityemail))
									{
										
										Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
									}
									else
									{
										if($conformityemail->type==0)
										{
											Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
										}
									
									}
								}
							}
					//nok mail biti�
				}






				if(!isset($efficiencyevaluation))
				{
					$model=new Efficiencyevaluation;
					$model->conformityid=$_POST['Conformityactivity']['conformityid'];
					$model->activitydefinition='';
					$model->controldate=date('Y-m-d',$conformity->closedtime);
					$model->save();
					Logs::model()->logsaction();
					/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/conformity/activity?id='.$_POST['Conformityactivity']['conformityid']));
					
					
				}
				else
				{
					$efficiencyevaluation->controldate=date('Y-m-d',$conformity->closedtime);
					$efficiencyevaluation->save();
					Logs::model()->logsaction();
					/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
						Yii::app()->SetFlashes->add($efficiencyevaluation,t('Update Success!'),array('/conformity/activity?id='.$_POST['Conformityactivity']['conformityid']));
				}




					/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($efficiencyevaluation,t('Closed Success!'),array('/conformity/activity?id='.$_POST['Conformityactivity']['conformityid']));
			
		}
		
		if($_POST['yes_no']!=0)
		{
			$conformity=Conformity::model()->find(array(
								   'condition'=>'id=:id','params'=>array('id'=>$_POST['Conformityactivity']['conformityid'])
							   ));
				$conformity->statusid=3;
				if($conformity->save())
				{
					//etkinlik de�erlendirmesi ok olunca 
					
							$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$conformity->firmid)));
							$branch=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$conformity->branchid)));
							$cbranch=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$conformity->clientid)));
							$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$cbranch->parentid)));
							
							$usermodel=User::model()->findAll(array('condition'=>'id=:id','params'=>array('id'=>$conformity->userid)));

							if($usermodel->clientid==0)  //eger conformityi acan ki�i admin-firm veya branch ise goncerilecek email
							{
								
								$senderemail=$firm->email;
								$sendername=$firm->name;

							

								$user=User::model()->findAll(array('condition'=>'(type=22 or type=23 or type=13 or type=26) and (clientbranchid='.$cbranch->id.' or (clientbranchid=0 and clientid='.$client->id.'))',));
								foreach($user as $userx)
									{

									$subject=$cbranch->name.User::model()->dilbul($userx->languageid,'Activity evaluation started');
									$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'Activity evaluation started');
									$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'Activity evaluation started').'<br>'.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_GET['id'].'">'.$conformity->numberid.'</a>';



										 $buyeremail=$userx->email;
										 // $buyeremail='fcurukcu@gmail.com';
										$buyername=$userx->name.' '.$user->surname;

										$conformityemail=Generalsettings::model()->find(array(
												   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$userx->id)
											   ));
										if(empty($conformityemail))
										{
											
											Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
										}
										else
										{
											if($conformityemail->type==0)
											{
												Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
											}
										
										}
									}
							}
							else //eger conformityi acan cliebt veya client branch ise goncerilecek email
							{
								$senderemail=$client->email;
								$sendername=$client->name;

								$user=User::model()->findAll(array('condition'=>'(type=22 or type=23 or type=13 or type=26) and ((clientid=0 and branchid='.$branch->id.') or (branchid=0 and firmid='.$model->firmid.'))',));
								foreach($user as $userx)
								{

									$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is successfully closed');
									$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'activity evaluation started');
									$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'activity evaluation started').'<br>'.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_GET['id'].'">'.$conformity->numberid.'</a>';


									  $buyeremail=$userx->email;
									  // $buyeremail='fcurukcu@gmail.com';
									$buyername=$userx->name.' '.$user->surname;

									$conformityemail=Generalsettings::model()->find(array(
											   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$userx->id)
										   ));
									if(empty($conformityemail))
									{
										
										Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
									}
									else
									{
										if($conformityemail->type==0)
										{
											Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
										}
									
									}
								}
							}
					//etkinlik de�erlendirmesi mail biti�
				}








				
			if(!isset($efficiencyevaluation))
			{
				$model=new Efficiencyevaluation;
				$model->conformityid=$_POST['Conformityactivity']['conformityid'];
				$model->activitydefinition=$_POST['Conformityactivity']['activitydefinition'];
				$model->controldate=$_POST['Conformityactivity']['controldate'];
				$model->save();
				Logs::model()->logsaction();
				/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/conformity/activity?id='.$_POST['Conformityactivity']['conformityid']));
				
				
			}
			else
			{
				$efficiencyevaluation->activitydefinition=$_POST['Conformityactivity']['activitydefinition'];
				$efficiencyevaluation->controldate=$_POST['Conformityactivity']['controldate'];
				$efficiencyevaluation->save();
				Logs::model()->logsaction();
				/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($efficiencyevaluation,t('Update Success!'),array('/conformity/activity?id='.$_POST['Conformityactivity']['conformityid']));
				
				
			}
		}
		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($efficiencyevaluation,t('Non-Conformiyt Successful Closed!'),array('/conformity'));
			
			
	}
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($id==0)
		{
			$id=$_POST['Conformityactivity']['id'];
		}

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
				Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index?id='.$_POST['Conformityactivity']['conformityid']));
		
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{



		if (isset($_POST['activityid']))
		{			
			$guncelle=Conformityactivity::model()->changeactive($_POST['activityid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}
	

		$dataProvider=new CActiveDataProvider('Conformityactivity');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Conformityactivity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Conformityactivity']))
			$model->attributes=$_GET['Conformityactivity'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Conformityactivity the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Conformityactivity::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Conformityactivity $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='conformityactivity-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
