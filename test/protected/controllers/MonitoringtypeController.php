<?php

class MonitoringtypeController extends Controller
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
				'actions'=>array('index','view','pets','typedelete','deleteall'
                        ,'monitoringtypelist','monitoringtypecreateupdate','monitoringtypedelete','monitoringtypedetail','monitoringtypedeleteall','monitoringtypeisactive'),
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
  public function actionMonitoringtypelist()
  {
     $yetki=AuthAssignment::model()->accesstoken();
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringtypelist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
   public function actionMonitoringtypecreateupdate()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringtypecreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionMonitoringtypedelete()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringtypedelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
     public function actionMonitoringtypedetail()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringtypedetail($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionMonitoringtypedeleteall()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringtypedeleteall($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionMonitoringtypeisactive()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->monitoringtypeisactive($_POST);
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
		$model=new Monitoringtype;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$type=Monitoringtype::model()->findAll(array(
								   'condition'=>'name=:name','params'=>array('name'=>$_POST['Monitoringtype']['name'])
							   ));

		if(isset($_POST['Monitoringtype']) && count($type)==0)
		{
			$model->attributes=$_POST['Monitoringtype'];
			$model->save();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				$this->redirect(array('index'));
		}

		//eger mevcut verinin ayn�s� post edilirse mevcut data mesaj� verilir
		Yii::app()->user->setFlash('error', t('Available Data'));
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
			$id=$_POST['Monitoringtype']['id'];
		}

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Monitoringtype']))
		{
			$model->attributes=$_POST['Monitoringtype'];
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
			$id=$_POST['Monitoringtype']['id'];
		}

		

		
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			{	
				Logs::model()->logsaction();
				/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
			}
		
	}

	
	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Monitoringtype']['id']);

		foreach($deleteall as $delete)
		{
			Monitoringtypepets::model()->findAll(array(
								   'condition'=>'monitoringtypeid=:monitoringtypeid','params'=>array('monitoringtypeid'=>$delete)
							   ));
			$this->loadModel($delete)->delete();
		}
		
		Yii::app()->SetFlashes->add($model,t('Selected monitoring type deleted!'),array('index'));
	}



	public function actionTypedelete()
	{
		$pets=Monitoringtypepets::model()->findAll(array(
								   'condition'=>'monitoringtypeid=:monitoringtypeid','params'=>array('monitoringtypeid'=>$_GET['id'])
							   ));

		echo count($pets);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['typeid']))
		{			
			$guncelle=Monitoringtype::model()->changeactive($_POST['typeid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}

		$dataProvider=new CActiveDataProvider('Monitoringtype');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Monitoringtype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Monitoringtype']))
			$model->attributes=$_GET['Monitoringtype'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionPets()
	{
		
		if (isset($_POST['petsid']))
		{			
			$guncelle=Monitoringtypepets::model()->changeactive($_POST['petsid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		exit;
		}

			$this->render('view');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Monitoringtype the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Monitoringtype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Monitoringtype $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='monitoringtype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
