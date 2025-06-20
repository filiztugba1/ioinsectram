<?php

class LocationController extends Controller
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
				'actions'=>array('index','view','deleteall'
                        ,'locationlist','locationcreateupdate','locationdelete','locationdetail','locationdeleteall'),
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

   ///////////. yeni api başlangıç /////////
  public function actionLocationlist()
  {
     $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->locationlist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
   public function actionLocationcreateupdate()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->locationcreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionLocationdelete()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->locationdelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
     public function actionLocationdetail()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->locationdetail($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionLocationdeleteall()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->locationdeleteall($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  

     ///////////. yeni api bitiş /////////
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
		$model=new Location;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

			$location=Location::model()->findAll(array(
								   'condition'=>'name=:name','params'=>array('name'=>$_POST['Location']['name'])
							   ));

		if(isset($_POST['Location']) && count($location)==0)
		{
			$model->attributes=$_POST['Location'];
			$model->save();

			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index','id'=>$model->id));
			
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
			$id=$_POST['Location']['id'];
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
			$model->save();

			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));
				$this->redirect(array('index','id'=>$model->id));
			
				
		}

		$this->render('index',array(
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
			$id=$_POST['Location']['id'];
		}
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index','id'=>$model->id));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Location']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
		
		Yii::app()->SetFlashes->add($model,t('Selected location deleted!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Location');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Location('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Location']))
			$model->attributes=$_GET['Location'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Location the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Location::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Location $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
