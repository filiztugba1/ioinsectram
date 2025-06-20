<?php

class StaffteamController extends Controller
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
				'actions'=>array('index','view','teamleader','color','deleteall'),
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

	public function staffsplit($staff)
	{
		$dizi="";
		 for($i=0;$i<count($staff);$i++)
		{
			 if($dizi=='')
			{
			 $dizi=$staff[$i];
			 }
			 else
			{
			 $dizi=$dizi.','.$staff[$i];
			 }

		 }

		return $dizi;
	}



	public function isleaderstaff($staff,$leader)
	{
		 for($i=0;$i<count($staff);$i++)
		{
			 if($staff[$i]==$leader)
			{
				return true;
			 }
		 }

		 return false;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		 $staff=$this->staffsplit($_POST['Staffteam']['staff']);


		 $isleaderstaff=$this->isleaderstaff($_POST['Staffteam']['staff'],$_POST['Staffteam']['leaderid']);

		/*
		if(!$isleaderstaff)
		 {
			  $staff=$staff.','.$_POST['Staffteam']['leaderid'];
		 }
		 */

		$model=new Staffteam;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

			$team=Staffteam::model()->findAll(array(
								   'condition'=>'teamname=:teamname and firmid=:firmid','params'=>array('teamname'=>$_POST['Staffteam']['teamname'],'firmid'=>$_POST['Staffteam']['firmid'])
							   ));


		if(isset($_POST['Staffteam']) && count($team)==0)
		{
			$model->attributes=$_POST['Staffteam'];
			$model->staff=$staff;
			$model->save();
					//loglama
				Logs::model()->logsaction();
				if($_POST['Staffteam']['type']!='firm')
				{
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				}
				else
				{
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/firm/staffteam?type=branch&&id='.$_POST['Staffteam']['firmid']));
				}

		}

		 if($staff=='')
		{
			Yii::app()->user->setFlash('error', t('Select at least one staff'));
		}
		else
		{
			Yii::app()->user->setFlash('error', t('Name previously used'));
		}


				if($_POST['Staffteam']['type']!='firm')
				{
					$this->redirect(array('index'));
				}
				else
				{
					$this->redirect(array('/firm/staffteam?type=branch&&id='.$_POST['Staffteam']['firmid']));
				}

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
			$id=$_POST['Staffteam']['id'];
		}

		 $dizi="";
		 $staff=$_POST['Staffteam']['staff'];

		 for($i=0;$i<count($staff);$i++)
		{
			 if($dizi=='')
			{
			 $dizi=$staff[$i];
			 }
			 else
			{
			 $dizi=$dizi.','.$staff[$i];
			 }

		 }


		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Staffteam']))
		{
			$model->attributes=$_POST['Staffteam'];
			$model->staff=$dizi;
			$model->color=$_POST['Staffteam']['color'];
			$model->save();
			if($_POST['Staffteam']['type']!='firm')
				{
					Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
				}
				else
				{
					Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/firm/staffteam?type=branch&&id='.$_POST['Staffteam']['firmid']));
				}
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
		if($id==0)
		{
			$id=$_POST['Staffteam']['id'];
		}

		// $this->loadModel($id)->delete();
		$model=$this->loadModel($id);
		$model->isdelete=1;
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
				if($_POST['Staffteam']['type']!='firm')
				{
					Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
				}
				else
				{
					Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/firm/staffteam?type=branch&&id='.$_POST['Staffteam']['firmid']));
				}
		}
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Staffteam']['id']);

		foreach($deleteall as $delete)
		{
			// $this->loadModel($delete)->delete();
			$model=$this->loadModel($delete);
			$model->isdelete=1;
			$model->save();
		}

		Yii::app()->SetFlashes->add($model,t('Selected staffteams deleted!'),array('index'));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['id']))
			{
				$guncelle=Firm::model()->changeactivestaff($_POST['id'],$_POST['active']);
				if(!$guncelle){
					echo t("Error");
				}
				else{
					echo t("Saved");
				}

			}
			
		$dataProvider=new CActiveDataProvider('Staffteam');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Staffteam('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Staffteam']))
			$model->attributes=$_GET['Staffteam'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function actionTeamleader()
	{

		$ax= User::model()->userobjecty('');
		echo $ax->id;
		echo $_GET['id'];
		if($ax->firmid!=0)
		{
				$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
				if($firm->package=='Packagelite')
				{
					if(isset($_GET['id']) && $_GET['id']!=$ax->id)
					{
						$userlike=User::model()->find(array('condition'=>'id='.$ax->id,));

					?> <option value="<?=$ax->id;?>"><?=$userlike->name.' '.$userlike->surname;?></option><?
					}


				}
		}



		$user=User::model()->findAll(array(
									'condition'=>'clientid=0 and branchid='.$_GET['branch'].' and id!='.$_GET['id'],
							   ));

		foreach($user as $userx){?>
								  <option value="<?=$userx->id;?>"><?=$userx->name.' '.$userx->surname;?></option>
					<?}


		exit;
	}

	public function actionColor()
	{
			$user=User::model()->findAll(array(
									'condition'=>'clientid=0 and branchid='.$_GET['branch'].' and color="'.$_GET['ara'].'"',
							   ));
			$team=Staffteam::model()->findAll(array(
									'condition'=>'firmid='.$_GET['branch'].' and color="'.$_GET['ara'].'"',
							   ));

			if(count($user)>0 || count($team)>0)
			{
				echo 1;
			}
			else
			{
			echo 0;
			}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Staffteam the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Staffteam::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Staffteam $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staffteam-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
