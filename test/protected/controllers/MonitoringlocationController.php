<?php

class MonitoringlocationController extends Controller
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
				'actions'=>array('index','view','deleteall',
                        'monitoringlocationlist','monitoringlocationcreateupdate','monitoringlocationdelete','monitoringlocationdetail','monitoringlocationdeleteall','monitoringlocationisactive'),
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

  
  ////// YENİ APİLER //////
    public function actionMonitoringlocationlist() 
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringlocationlist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
   public function actionMonitoringlocationcreateupdate()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringlocationcreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionMonitoringlocationdelete()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringlocationdelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
     public function actionMonitoringlocationdetail()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringlocationdetail($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionMonitoringlocationdeleteall()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringlocationDeleteAll($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionMonitoringlocationisactive()
  {
     $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringlocationisactive($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  ///// YENİ APİ BİTİŞ /////
  
  
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
		$model=new Monitoringlocation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$location=Monitoringlocation::model()->findAll(array(
								   'condition'=>'name=:name and detailed=:detailed','params'=>array('name'=>$_POST['Monitoringlocation']['name'],'detailed'=>$_POST['Monitoringlocation']['detailed'])
							   ));

		if(isset($_POST['Monitoringlocation']) && count($location)==0)
		{
			$model->attributes=$_POST['Monitoringlocation'];
			$model->save();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				$this->redirect(array('index'));
		}

		Yii::app()->user->setFlash('error', t('Available Data!'));
		$this->redirect(array('index'));
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
			$id=$_POST['Monitoringlocation']['id'];
		}

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Monitoringlocation']))
		{
			$model->attributes=$_POST['Monitoringlocation'];
			$model->save();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
				$this->redirect(array('index'));
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
			$id=$_POST['Monitoringlocation']['id'];
		}

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
				$this->redirect(array('index'));
		}
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Monitoringlocation']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
		
		Yii::app()->SetFlashes->add($model,t('Selected monitoring location deleted!'),array('index'));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['locationid']))
		{			
			$guncelle=Monitoringlocation::model()->changeactive($_POST['locationid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}


		$dataProvider=new CActiveDataProvider('Monitoringlocation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Monitoringlocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Monitoringlocation']))
			$model->attributes=$_GET['Monitoringlocation'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Monitoringlocation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Monitoringlocation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Monitoringlocation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='monitoringlocation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
