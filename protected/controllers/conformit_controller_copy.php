<?php

class ConformityController extends Controller
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
				'actions'=>array('print','reports','index','view','client','department','updatediv','img','activity','index1','gunsonuemail','conformitytype','conformitystatus','deleteall','conformitystatusbutton','closed','assign','assigncreate','returnassign','uygunsuzlukListesi'),
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


	public function actionPrint(){
		 Yii::import('application.modules.pdf.components.pdf.mpdf');

		  $url = Yii::app()->basepath."/views/conformity/";
			 include($url . "print.php");

			 $mpdf = new mpdf();
			 $mpdf->AddPage('L');
             $mpdf->WriteHTML($html);
			 $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

             $mpdf->Output();

	}


	public function actionGunsonuemail()
	{
		$this->render('gunsonuemail');
	}



	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		$ax= User::model()->userobjecty('');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Conformity']))
		{

			$conformity=Conformity::model()->findAll(array(
								   'condition'=>'clientid=:clientid and departmentid=:departmentid and subdepartmentid=:subdepartmentid and type=:type and definition=:definition and suggestion=:suggestion and statusid=:statusid','params'=>array('clientid'=>$_POST['Conformity']['clientid'],'departmentid'=>$_POST['Conformity']['departmentid'],'subdepartmentid'=>$_POST['Conformity']['subdepartmentid'],'type'=>$_POST['Conformity']['type'],'definition'=>$_POST['Conformity']['definition'],'suggestion'=>$_POST['Conformity']['suggestion'],'statusid'=>$_POST['Conformity']['statusid'])
							   ));


		if(count($conformity)==0)
		{

			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_POST['Conformity']['firmid'])));

			if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
			{
				mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
			}
			$model=new Conformity;
			$model->attributes=$_POST['Conformity'];
			$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username;
			$temTime=time();
			$image=CUploadedFile::getInstance($model,'filesf');

			$model->numberid=$number;
			if(isset($image))
			{
				$type=explode('.',$image->name);
				$image->saveas($path.'/'.$temTime.'.'.$type[1]);
				$model->filesf='/uploads/'.$firm->username.'/'.$temTime.'.'.$type[1];
			}
			else
			{
				$model->filesf="";
			}

			$model->userid=$ax->id;
			$model->firmbranchid=$_POST['Conformity']['branchid'];
			$model->date=strtotime($_POST['Conformity']['date']);

			//guncel number
			$yeniYilDate=strtotime(date("y")."-01-01");
			$cli=Client::model()->find(array('condition'=>'id='.$_POST['Conformity']['clientid']));

			$clix=Conformity::model()->findAll(array('condition'=>'deletecbranch='.$cli->id.' && date>'.$yeniYilDate));

			$say=count($clix)+1;
			$de=date("y",strtotime($_POST['Conformity']['date']));
			 $number=$de.'.'.$cli->id.'.'.$say;

			//guncel number finish

			$model->numberid=$number;
			$model->deletecbranch=$_POST['Conformity']['clientid'];

			$model->save();
			Loglar::model()->create(json_encode($model['attributes']));


				// number create

			/* $conformity=Conformity::model()->find(array(
								   'order'=>'date ASC',
								   'condition'=>'id='.$model->id,
							   ));


			$cli=Client::model()->find(array('condition'=>'id='.$conformity->clientid));
			$clix=Conformity::model()->findAll(array('condition'=>'clientid='.$cli->id,'order'=>'date asc'));
			$say=1;
			foreach($clix as $clixm)
			{
				if($clixm->id==$conformity->id)
				{
					break;
				}
				$say++;
			}
			$de=date("y",$conformity->date);

			$number=$de.'.'.$cli->id.'.'.$say;

			$conformity->numberid=$number;

			$conformity->save();

			*/


			// number finish




				Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				if (!isset($_GET['goback'])){
					Yii::app()->user->setFlash('success', t('Create Success!'));
				 $this->redirect('/conformity');
				}
			}

			if (isset($_GET['goback'])){


			 $this->redirect('/conformity/index1?hdde&alertok');
			}

		}

		//eger mevcut verinin aynısı post edilirse mevcut data mesajı verilir
		Yii::app()->user->setFlash('error', t('previously used'));
	 $this->redirect('/conformity');
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$ax= User::model()->userobjecty('');
		if($id==0)
		{
			$id=$_POST['Conformity']['id'];
		}

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Conformity']))
		{
			$model->attributes=$_POST['Conformity'];

			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_POST['Conformity']['firmid'])));

			if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
			{
				mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
			}
			$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username;
			$temTime=time();
			$image=CUploadedFile::getInstance($model,'filesf');


			if(isset($image))
			{
				$type=explode('.',$image->name);
				$image->saveas($path.'/'.$temTime.'.'.$type[1]);
				$model->filesf='/uploads/'.$firm->username.'/'.$temTime.'.'.$type[1];
			}
			else
			{
				$model->filesf=$_POST['Conformity']['filesfx'];
			}

			 $model->userid=$ax->id;
			 $model->date=strtotime($_POST['Conformity']['date']);


			  if(isset($_POST['Conformity']['closedtime']))
			 {
				$model->closedtime=strtotime($_POST['Conformity']['closedtime']);
				$ca=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$id));
				if($ca->activitydefinition=='')
				 {
					$ca->controldate=$_POST['Conformity']['closedtime'];
				 }
				$ca->save();
				Loglar::model()->create(json_encode($ca['attributes']));
			 }

			$model->save();
			//mail gonderme Nok olunca

			/*
			if($_POST['Conformity']['statusid']==6)
			{
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$model->firmid)));
				$branch=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$model->branchid)));
				$cbranch=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$model->clientid)));

				$senderemail=$firm->email;
				$sendername=$firm->name;
				$subject='Non-Conforminy is not closed';
				$altbody=$cbranch->name.'\'s customer can not be closed again, please check again';
				$msg=$cbranch->name.'\'s customer can not be closed again, please check again';

				$user=User::model()->findAll(array('condition'=>'firmid=:firmid and branchid=:branchid and clientid=0','params'=>array('firmid'=>$model->firmid,'branchid'=>$model->branchid)));
				foreach($user as $userx)
				{
					$buyeremail=$user->email;
					$buyername=$user->name.' '.$user->surname;
					Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
				}
			}

			*/

			Logs::model()->logsaction();

			Loglar::model()->create(json_encode($model['attributes']));

			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/conformity/activity/'.$_POST['Conformity']['id']));
				$this->redirect(array('index','id'=>$model->id));

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}



	public function actionConformitystatusbutton()
	{
		$model=Conformity::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_GET['id'])));


			//mail gonderme Nok olunca
			if(isset($_GET['status']) && ($_GET['status']==6 || $_GET['status']==1))
			{

				/*
				$user=User::model()->findAll(array('condition'=>'firmid=:firmid and branchid=:branchid and clientid=0','params'=>array('firmid'=>$model->firmid,'branchid'=>$model->branchid)));
				*/

				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$model->firmid)));
				$branch=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$model->branchid)));
				$cbranch=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$model->clientid)));
				$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$cbranch->parentid)));

				if(isset($_GET['status']) && $_GET['status']==6)  // conformity nok olunca
				{
					$model->statusid=6;
					$model->closedtime=strtotime($_POST['Conformityactivity']['nokdate']);

					$nok=Conformityactivity::model()->find(array('condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$_GET['id'])));
					$nok->nokdate=$_POST['Conformityactivity']['nokdate'];
					$nok->nokdefinition=$_POST['Conformityactivity']['definition'];
					Loglar::model()->create(json_encode($nok['attributes']));
					$nok->save();


				}
				if(isset($_GET['status']) && $_GET['status']==1) // conformity kacapınca
				{
					$model->statusid=1;
					// $model->closedtime=time();

					//kapatılma butonunda etkinlik değerlendirmesi tarihi değişecek.
					$efficiency=Efficiencyevaluation::model()->find(array('condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$_GET['id'])));

						if(!isset($_POST['Conformityactivity']['closeddate']))
						{
							 $efficiency->controldate=date('Y-m-d',time());
						}
						else
						{
							 $efficiency->controldate=$_POST['Conformityactivity']['closeddate'];
						}
						Loglar::model()->create(json_encode($efficiency['attributes']));
						$efficiency->save();


				}



				$usermodel=User::model()->findAll(array('condition'=>'id=:id','params'=>array('id'=>$model->userid)));
				if($usermodel->clientid==0) //eger conformityi acan kişi admin-firm veya branch ise goncerilecek email
				{

					$senderemail=$firm->email;
					$sendername=$firm->name;

					$user=User::model()->findAll(array('condition'=>'(type=22 or type=23 or type=13 or type=26) and clientbranchid='.$model->clientid.' or (clientbranchid=0 and clientid='.$client->id.')',));
					foreach($user as $userx)
					{
						   $buyeremail=$userx->email;
						// $buyeremail='fcurukcu@gmail.com';
						$buyername=$userx->name.' '.$user->surname;



						if(isset($_GET['status']) && $_GET['status']==6)  // conformity nok olunca
						{
							$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is not closed');

							$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'nonconformity can not be closed, please check again');

							$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'nonconformity can not be closed, please check again').User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_GET['id'].'">'.$model->numberid.'</a>';

						}
						if(isset($_GET['status']) && $_GET['status']==1) // conformity kacapınca
						{


							$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is successfully closed');

							$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the result of the non-comformity activity assessment was closed successfully.');

							$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the result of the non-comformity activity assessment was closed successfully.').'.'.User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_GET['id'].'">'.$model->numberid.'</a>';
						}





						$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid ','params'=>array('name'=>'conformityemail','userid'=>$userx->id)));


						if(count($ismail)==0)
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


					/*	if(!$ismail)
						{
							Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//$buyeremail
						}
					}
					*/
				}
				else //eger conformityi acan cliebt veya client branch ise goncerilecek email
				{
					$senderemail=$client->email;
					$sendername=$client->name;



					$user=User::model()->findAll(array('condition'=>'(type=22 or type=23 or type=13 or type=26) and branchid='.$model->branchid.' or (branchid=0 and firmid='.$model->firmid.')',));
					foreach($user as $userx)
					{

						 $buyeremail=$userx->email;
						//  $buyeremail='fcurukcu@gmail.com';
						$buyername=$userx->name.' '.$user->surname;



						if(isset($_GET['status']) && $_GET['status']==6)  // conformity nok olunca
						{
							$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is not closed');

							$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'nonconformity can not be closed, please check again');

							$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'nonconformity can not be closed, please check again').User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_GET['id'].'">'.$model->numberid.'</a>';

						}
						if(isset($_GET['status']) && $_GET['status']==1) // conformity kacapınca
						{


							$subject=User::model()->dilbul($userx->languageid,'Non-Conforminy is successfully closed');

							$altbody=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the result of the non-comformity activity assessment was closed successfully.');

							$msg=$cbranch->name.' '.$subject.User::model()->dilbul($userx->languageid,'the result of the non-comformity activity assessment was closed successfully.').User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_GET['id'].'">'.$model->numberid.'</a>';
						}




						$ismail=Generalsettings::model()->find(array('condition'=>'name=:name and userid=:userid and ','params'=>array('name'=>'conformityemail','userid'=>$userx->id)));


						if(count($ismail)==0)
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

			}

			if(isset($_GET['status']) && $_GET['status']==2)
			{

				if($model->statusid==4 || $model->statusid==6)
				{
					$model->statusid=2;
				}

				if(!isset($_POST['Conformityactivity']['okdate']))
				{
					 $model->closedtime=time();
				}
				else
				{
					 $model->closedtime=strtotime($_POST['Conformityactivity']['okdate']);
					 $effication=Efficiencyevaluation::model()->find(array('condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$_GET['id'])));
					 if(isset($effication) && $effication->activitydefinition=='')
					 {
						$effication->controldate=$_POST['Conformityactivity']['okdate'];
						Loglar::model()->create(json_encode($effication['attributes']));
						$effication->save();

					 }
				}


			}


			//NOK MAİLİ BİTİŞ
		Loglar::model()->create(json_encode($model['attributes']));
		$model->save();


			Logs::model()->logsaction();


			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/conformity/activity/'.$_GET['id']));

	}






	public function actionReports(){
		$this->render('reports');
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
			$id=$_POST['Conformity']['id'];
		}

		$cactivity=Conformityactivity::model()->find(array('condition'=>'conformityid='.$id));
		Loglar::model()->create(json_encode($cactivity['attributes']));
		$cactivity=Conformityactivity::model()->deleteAll(array('condition'=>'conformityid='.$id));

		$efficiency=Efficiencyevaluation::model()->deleteAll(array('condition'=>'conformityid='.$id));
		Loglar::model()->create(json_encode($efficiency['attributes']));
		$efficiency=Efficiencyevaluation::model()->deleteAll(array('condition'=>'conformityid='.$id));

		$model=$this->loadModel($id);
		Loglar::model()->create(json_encode($model['attributes']));



		$model->userid=-1;
		$model->firmid=-1;
		$model->firmbranchid=-1;
		$model->branchid=-1;
		$model->clientid=-1;
		$model->departmentid=-1;
		$model->subdepartmentid=-1;
		$model->numberid=-1;
		$model->save();




		$url=Yii::app()->baseUrl.'/'.$_POST['Conformity']['filesfx'];
		 unset($url);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

				Yii::app()->user->setFlash('success', t('Delete Success!'));
			 $this->redirect('/conformity');

		}
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Conformity']['id']);

		foreach($deleteall as $delete)
		{
			Conformityactivity::model()->deleteAll(array('condition'=>'conformityid='.$delete));
			Efficiencyevaluation::model()->deleteAll(array('condition'=>'conformityid='.$delete));

			$this->loadModel($delete)->delete();
		}

		Yii::app()->SetFlashes->add($model,t('Selected non-conformity deleted!'),array('index'));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$dataProvider=new CActiveDataProvider('Conformity');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
		public function actionIndex1()
	{
		$dataProvider=new CActiveDataProvider('Conformity');
		$this->render('index1',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Conformity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Conformity']))
			$model->attributes=$_GET['Conformity'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function actionActivity($id)
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


		$this->render('/conformityactivity/index',array(
			'model'=>$this->loadModel($id),
		));
	}




	public function actionClient()
	{
		$department=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'clientid='.$_GET['id'].' and parentid=0',
							   ));

					?>


							<option value="0" selected=""><?=t('Please Chose');?></option>
							<?foreach($department as $departmentx){?>
								<option value="<?=$departmentx->id;?>"><?=$departmentx->name;?></option>
							<?}?>


	<?}



	public function actionDepartment()
	{
		$department=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid='.$_GET['id'],
							   ));
		?>
                            <option value="0" selected=""><?=t('Please Chose');?></option>

							<?

							if(isset($_GET['id']) && $_GET['id']!=0){
								foreach($department as $departmentx){?>
								<option value="<?=$departmentx->id;?>"><?=$departmentx->name;?></option>
							<?}}?>


	<?


	}


	public function actionUpdatediv()
	{
		$department=Departments::model()->findAll(array(
								   'order'=>'name ASC',
								   'condition'=>'clientid='.$_GET['clientid'].' and parentid=0',
							   ));

						?>

		<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="department2">
					<label for="basicSelect"><?=t('Department');?></label>
                        <fieldset class="form-group">

                          <select class="custom-select block" style="width:100%" id="selectdepartment2" onchange="myFunctionDepartment2()" name="Conformity[departmentid]">
								<?

								foreach($department as $departmentx){?>
								<option value="<?=$departmentx->id;?>" <?if(isset($_GET['departmentid']) && $_GET['departmentid']==$departmentx->id){echo "selected";}?>><?=$departmentx->name;?></option>
							<?}?>
							</select>
                        </fieldset>
                    </div>

		<?$subdepartment=Departments::model()->findAll(array(
								   'order'=>'name ASC',
								   'condition'=>'clientid='.$_GET['clientid'].' and parentid='.$_GET['departmentid'],
							   ));

						?>


					<div class="col-xl-12 col-lg-12 col-md-12 mb-1" id="subdepartment2">
					<label for="basicSelect"><?=t('Sub-Department');?></label>
                        <fieldset class="form-group">

                          <select class="custom-select block" style="width:100%" id="modalsubdepartmentid" name="Conformity[subdepartmentid]">
									<?
								foreach($subdepartment as $subdepartmentx){?>
								<option value="<?=$subdepartmentx->id;?>" <?if(isset($_GET['subdepartmentid']) && $_GET['subdepartmentid']==$subdepartmentx->id){echo "selected";}?>><?=$subdepartmentx->name;?></option>
							<?}?>
							</select>
                        </fieldset>
                    </div>



	<?
	}



	public function actionConformitytype()
	{
			$type=Conformitytype::model()->findAll(array(
								   'order'=>'name ASC',
								   'condition'=>'isactive=1 and (clientid='.$_GET['id'].' or firmid=0 or (firmid='.$_GET['firm'].' and branchid=0) or (firmid='.$_GET['firm'].' and branchid='.$_GET['branch'].' and clientid=0))',
							   ));


			foreach($type as $typex)
			{?>
				<option value="<?=$typex->id;?>"><?=t($typex->name);?></option>
			<?}
	}

	public function actionConformitystatus()
	{
			$status=Conformitystatus::model()->findAll(array(
								   'order'=>'name ASC',
								   'condition'=>'isactive=1 and (clientid='.$_GET['id'].' or firmid=0 or (firmid='.$_GET['firm'].' and branchid=0) or (firmid='.$_GET['firm'].' and branchid='.$_GET['branch'].' and clientid=0))',
							   ));


			foreach($status as $statusx)
			{?>
				<option value="<?=$statusx->id;?>"><?=t($statusx->name);?></option>
			<?}
	}


	public function actionClosed()
	{



		$time=Conformity::model()->find(array('condition'=>'id='.$_POST['Conformity']['id']));
		$time->closedtime=strtotime($_POST['Conformity']['closedtime']);
		$time->save();


		Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($time,t('Update Success!'),array('/conformity/activity/'.$_POST['Conformity']['id']));
	}


	public function actionAssign()
	{
		$ax=User::model()->userobjecty('');


		?>

			<option value="0"><?=t('Please Chose');?></option>


			<?
				$model=Conformity::model()->find(array('condition'=>'id='.$_GET['id']));


				$client=Client::model()->find(array('condition'=>'id='.$model->clientid));




				$usermodel=User::model()->findAll(array('condition'=>'id=:id','params'=>array('id'=>$model->userid)));
				if($usermodel->clientid==0) //eger conformityi acan kişi admin-firm veya branch ise goncerilecek email
				{

					$ass=Conformity::model()->assign($model->firmid,$model->branchid,$client->parentid,0,2,2);

					foreach($ass as $assx)
					{
						$userx=User::model()->find(array('condition'=>'id='.$assx->userid));
						if($userx->id!='' && $userx->id!=$ax->id){?>
						<option  value="<?=$userx->id;?>"><?if($userx->name=='' && $userx->surname==''){echo $userx->username;}else{echo $userx->name.' '.$userx->surname;}?></option>
					<?}}


					$ass2=Conformity::model()->assign($model->firmid,$model->branchid,$client->parentid,$client->id,3,2);

					foreach($ass2 as $ass2x)
					{
						$userx=User::model()->find(array('condition'=>'id='.$ass2x->userid));
						if($userx->id!='' && $userx->id!=$ax->id){?>
						<option  value="<?=$userx->id;?>"><?if($userx->name=='' && $userx->surname==''){echo $userx->username;}else{echo $userx->name.' '.$userx->surname;}?></option>
					<?}}

				}
				else //eger conformityi acan cliebt veya client branch ise goncerilecek email
				{

				$ass=Conformity::model()->assign($model->firmid,0,0,0,0,2);

					foreach($ass as $assx)
					{
						$userx=User::model()->find(array('condition'=>'id='.$assx->userid));
						if($userx->id!='' && $userx->id!=$ax->id){?>
						<option  value="<?=$userx->id;?>"><?if($userx->name=='' && $userx->surname==''){echo $userx->username;}else{echo $userx->name.' '.$userx->surname;}?></option>
					<?}}


					$ass2=Conformity::model()->assign($model->firmid,$model->branchid,0,0,1,2);

					foreach($ass2 as $ass2x)
					{
						$userx=User::model()->find(array('condition'=>'id='.$ass2x->userid));
						if($userx->id!='' && $userx->id!=$ax->id){?>
						<option  value="<?=$userx->id;?>"><?if($userx->name=='' && $userx->surname==''){echo $userx->username;}else{echo $userx->name.' '.$userx->surname;}?></option>
					<?}}
				}

	}


	public function actionReturnassign()
	{
		$model=new Conformityuserassign;
		$model->id=0;
		$model->conformityid=$_POST['Conformity']['id'];
		$model->senderuserid=User::model()->userobjecty('')->id;
		$model->recipientuserid=$_POST['Conformity']['senderuserid'];
		$model->sendtime=time();
		$model->returnstatustype=2;
		$model->parentid=$_POST['Conformity']['assignid'];

		if(!isset($_POST['Conformity']['definition']) || $_POST['Conformity']['definition']=='')
		{
					$model->definition='-';

		}else {
				$model->definition=$_POST['Conformity']['definition'];
		}
		$model->save();

		$sender=User::model()->find(array('condition'=>'id='.User::model()->userobjecty('')->id));
		$senderemail=$sender->email;
		$sendername=$sender->name.' '.$sender->surname;
		$buyer=User::model()->find(array('condition'=>'id='.$_POST['Conformity']['senderuserid']));
		$conformity=Conformity::model()->find(array('condition'=>'id='.$_POST['Conformity']['id']));
		$clientname=Client::model()->find(array('condition'=>'id='.$conformity->clientid))->name;

		$buyeremail=$buyer->email;
		//  $buyeremail='fcurukcu@gmail.com';
		$buyername=$buyer->name.' '.$buyer->surname;
		$subject=$sendername.' '.User::model()->dilbul($buyer->languageid,'Uygunsuzluk tanımını kabul etmedi.');
		$altbody=$clientname.' '.$subject;
		$msg=$clientname.' '.$subject.User::model()->dilbul($userx->languageid,'Url').':<a href="https://development.insectram.io/conformity/activity/'.$_POST['Conformity']['id'].'">'.$conformity->numberid.'</a>';

		Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);


		Logs::model()->logsaction();
		/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
		Yii::app()->SetFlashes->add($time,t('User assignment successful'),array('/conformity/activity/'.$_POST['Conformity']['id']));

	}


	public function actionAssigncreate()
	{


		$model=new Conformityuserassign;
		$model->id=0;
		$model->conformityid=$_POST['Conformity']['id'];
		$model->senderuserid=User::model()->userobjecty('')->id;
		$model->recipientuserid=$_POST['Conformity']['recipientuser'];
		$model->sendtime=time();
		$model->returnstatustype=1;
		$model->parentid=0;
		$model->definition="";
		if(!$model->save())
		{
			var_dump($model->geterrors());
		}


		$sender=User::model()->find(array('condition'=>'id='.User::model()->userobjecty('')->id));
		$senderemail=$sender->email;
		$sendername=$sender->name.' '.$sender->surname;
		$buyer=User::model()->find(array('condition'=>'id='.$_POST['Conformity']['recipientuser']));
		$conformity=Conformity::model()->find(array('condition'=>'id='.$_POST['Conformity']['id']));
		$clientname=Client::model()->find(array('condition'=>'id='.$conformity->clientid))->name;

		$buyeremail=$buyer->email;
		//  $buyeremail='fcurukcu@gmail.com';
		$buyername=$buyer->name.' '.$buyer->surname;

		echo $subject=User::model()->dilbul($buyer->languageid,'Uygunsuzluk faliyet-termin tanımı');
		echo $altbody=User::model()->dilbul($buyer->languageid,'Aşağıda bildirilen uygunsuzluk için faliyet tanımı ve termin tarihi tanımlamasını yapınız.');


		$msg=$altbody."<br>".User::model()->dilbul($userx->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$_POST['Conformity']['id'].'">'.$conformity->numberid.'</a>';

		Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);


		Logs::model()->logsaction();
		/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
		Yii::app()->SetFlashes->add($time,t('User assignment successful'),array('/conformity/activity/'.$_POST['Conformity']['id']));

	}

	public function actionUygunsuzlukListesi()
	{
		$ax= User::model()->userobjecty('');
		$where='';

		if(isset($_GET['firmid']) && $_GET['firmid']!='' && $_GET['firmid']!=null && $_GET['firmid']!="null")
		{
			$where="firmid in (".implode(',',Firm::model()->getbranchids($_GET['firmid'])).")";

		}

		if(isset($_GET['branchid']) && $_GET['branchid']!='' && $_GET['branchid']!=null && $_GET['branchid']!='null')
		{
			$exel=$exel.' > '.Firm::model()->find(array('condition'=>'id='.$_GET['branchid']))->name;

			$where="firmbranchid=".$_GET['branchid'];
		}

		if($ax->clientid>0)
		{
			$cl=Client::model()->find(array('condition'=>'id='.$ax->clientid));

			$exel=$exel.' > '.$cl->name;

			$where="clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";
		}

		if(isset($_GET['clientid']) && $_GET['clientid']!=0 && $_GET['clientid']!='' && $_GET['clientid']!=null && $_GET['clientid']!='null')
		{
			$clb=Client::model()->find(array('condition'=>'id='.$_GET['clientid']));
			$cl=Client::model()->find(array('condition'=>'id='.$clb->parentid));

			$exel=$exel.' > '.$cl->name.' > '.$clb->name;

			$where="clientid=".$_GET['clientid'];
		}


		if(isset($_GET['status']) && $_GET['status']!=-1 && $_GET['status']!='' && $_GET['status']!=null && $_GET['status']!='null')
		{

			$statussql='';
			$statusexel='';

		/*	for($i=0;$i<count($_POST["Reports"]["status"]);$i++)
			{
				$stname=Conformitystatus::model()->find(array('condition'=>'id='.$_POST["Reports"]["status"][$i]));
				if($i==0)
				{
					$statussql='statusid='.$_POST["Reports"]["status"][$i];
					$statusexel=$stname->name;
				}
				else
				{
					$statussql=$statussql.' or statusid='.$_POST["Reports"]["status"][$i];
					$statusexel=$statusexel.','.$stname->name;
				}
				$exel=$exel.' ( '.t("Status").'='.$statusexel.')';
			}
			*/
			if($where=='')
			{
				$where= $where." statusid in (".$_GET['status'].')';
			}
			else {
				$where= $where." and statusid in (".$_GET['status'].')';
			}

		}

		if(isset($_GET['startdate']) && $_GET['startdate']!='' && $_GET['startdate']!=null && $_GET['startdate']!='null')
		{
			$midnight = strtotime("today", strtotime($_GET['startdate']));
			$where= $where!=""?$where." and date>=".$midnight:"date>=".$midnight;

			$exel=$exel.'( '.t("Start Date").'='.$_GET['startdate'].')';
		}
		if(isset($_GET['finishdate']) && $_GET['finishdate']!='' && $_GET['finishdate']!=null && $_GET['finishdate']!='null')
		{
			$midnight2 = strtotime("today", strtotime($_GET['finishdate'])+3600*24);
			$where= $where." and date<=".$midnight2;

			$exel=$exel.'( '.t("Finish Date").'='.$_GET['finishdate'].')';
		}

		//echo $where;
		if(($_GET['startdate']=='' || $_GET['startdate']=='null' || $_GET['startdate']==null) && ($_GET['finishdate']=='' || $_GET['finishdate']=='null' || $_GET['finishdate']==null))
		{
			$time =$ax->clientid>0?strtotime("-1 year", time()):strtotime("-3 month", time());
			$where= $where==""?"date>=".$time:$where." and date>=".$time;
		  $_GET['startdate']= date("Y-m-d", $time);
			$exel=$exel.'( '.t("Start Date").'='.$_GET['startdate'].')';


			$midnight2 = time();
			$where= $where." and date<=".$midnight2;
			$_GET['finishdate']=date('Y-m-d',$midnight2);
			$exel=$exel.'( '.t("Finish Date").'='.$_GET['finishdate'].')';

		}

		$conformity=Conformity::model()->findAll(array('condition'=>$where,'order'=>'statusid asc'));
		?>
		<table  class="table table-striped table-bordered dataex-html5-export table-responsive">
			<thead>
				<tr>
					<th><?=t('NON-CONFORMITY NO');?></th>
					<th><?=t('WHO');?></th>
					<th><?=t('TO WHO');?></th>
					<th><?=mb_strtoupper(t('Department'));?></th>
					<th><?=mb_strtoupper(t('Sub-Department'));?></th>
					<th><?=t('OPENING DATE');?></th>
					<th><?=mb_strtoupper(t('Action Definition'));?></th>
					<th><?=mb_strtoupper(t('Deadline'));?></th>
					<th><?=t('CLOSED TIME');?></th>
					<th><?=mb_strtoupper(t('Status'));?></th>
					<th><?=mb_strtoupper(t('Non-Conformity Type'));?></th>
					<th><?=mb_strtoupper(t('Definition'));?></th>
					<th><?=t('NOK - COMPLETED DEFINATION');?></th>
					<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>
				</tr>
			</thead>
		<tbody id='waypointsTable'>
			<?php
					foreach($conformity as $conformityx){
						$depart=Departments::model()->find(array('condition'=>'id='.$conformityx['departmentid'],));
						if ($depart){ $depart=$depart->name;
							$subdep=Departments::model()->find(array('condition'=>'id='.$conformityx['subdepartmentid'],))->name;
						}else{
							$depart='-';
							$subdep='-';
						}
						$status=Conformitystatus::model()->find(array('condition'=>'id='.$conformityx['statusid']));?>
				<tr <?if($status->id==0){echo 'style="background-color: #c8d2f9;"';}?>  <?php if (Yii::app()->user->checkAccess('nonconformitymanagement.activity.view')){?> onclick="window.open('<?=Yii::app()->baseUrl?>/conformity/activity/<?=$conformityx['id'];?>', '_blank')" <?}?>>
					<td><?=$conformityx['numberid'];?></td>
					<td>
						 <?
							$userwho=User::model()->find(array('condition'=>'id='.$conformityx['userid']));
							echo $userwho->name.' '.$userwho->surname;
							?>
					</td>
					<td>
						<?
							if($userwho->clientid==0)
							{
								echo $listclient=Client::model()->find(array('condition'=>'id='.$conformityx['clientid']))->name;
							}
							else
							{
								echo Firm::model()->find(array('condition'=>'id='.$userwho->firmid))->name;
							}
						?>
					 </td>
					 <td><?=$depart?></td>
					 <td><?=$subdep?></td>
					 <td>
					 <?
					 if( gmdate('m',$conformityx['date'])==2)
						{
						 echo gmdate('Y-m-d',$conformityx['date']);
						}
					 else
						{
						 echo date('Y-m-d',$conformityx['date']);
						 };?>
					 </td>
				 <td><?$activitiondef=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->definition;
					if($activitiondef!=''){echo $activitiondef;}else{echo '-';}?>
					</td>
					<td>
					 <?
						 $date=Conformityactivity::model()->find(array('order'=>'date DESC','condition'=>'conformityid='.$conformityx['id']));
						if(isset($date)){
								echo $date->date;
						}else{echo '-';}?></td>
					<?	if($conformityx->closedtime!='')
					{
						$kpnma=date('Y-m-d',$conformityx->closedtime);
					}
					else{
						$kpnma="-";
					}
					if($conformityx->closedtime!='')
					{
						$kpnma=date('Y-m-d',$conformityx->closedtime);
					}
					else{
						$kpnma="-";
					}
					?>
					 <td><?=$kpnma?></td>
					 <td>
						<a class="btn btn-<?=$status->btncolor;?> btn-sm" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t($status->name);?> </a>
					</td>
					 <td><?=t(Conformitytype::model()->find(array('condition'=>'id='.$conformityx['type'],))->name);?></td>
					 <td><?=$conformityx['definition'];?></td>
					 <td><?=Conformityactivity::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->nokdefinition;?></td>
					 <td><?=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$conformityx['id'],))->activitydefinition;?></td>
				 </tr>
				<style>
					<?if($status->id==0){?>
					#waypointsTable tr {
						background-color:#ccdcf7;
					}
					<?}?>
				</style>
			<?}?>
			</tbody>
		<tfoot>
	<tr>
		<th><?=t('NON-CONFORMITY NO');?></th>
		<th><?=t('WHO');?></th>
		<th><?=t('TO WHO');?></th>
		<th><?=mb_strtoupper(t('Department'));?></th>
		<th><?=mb_strtoupper(t('Sub-Department'));?></th>
		<th><?=t('OPENING DATE');?></th>
		<th><?=mb_strtoupper(t('Action Definition'));?></th>
		<th><?=mb_strtoupper(t('Deadline'));?></th>
		<th><?=t('CLOSED TIME');?></th>
		<th><?=mb_strtoupper(t('Status'));?></th>
		<th><?=mb_strtoupper(t('Non-Conformity Type'));?></th>
		<th><?=mb_strtoupper(t('Definition'));?></th>
		<th><?=t('NOK - COMPLETED DEFINATION');?></th>
		<th><?=t('EFFICIENCY FOLLOW-UP DEFINATION');?></th>
	</tr>
	</tfoot>
</table><?

	}




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Conformity the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Conformity::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Conformity $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='conformity-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
