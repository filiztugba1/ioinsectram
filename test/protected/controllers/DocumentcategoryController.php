<?php

class DocumentcategoryController extends Controller
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
				'actions'=>array('index','view'
                        ,'documentcategorylist','documentcategorycreateupdate','documentcategorydelete','documentcategorydetail','documentcategorydeleteall','documentcategoryisactive'),
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
  public function actionDocumentcategorylist()
  {
     $yetki=AuthAssignment::model()->accesstoken();
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->documentcategorylist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
   public function actionDocumentcategorycreateupdate()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->documentcategorycreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionDocumentcategorydelete()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->documentcategorydelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
     public function actionDocumentcategorydetail()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->documentcategorydetail($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionDocumentcategorydeleteall()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->documentcategorydeleteall($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionDocumentcategoryisactive()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->documentcategoryisactive($_POST);
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
		$model=new Documentcategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$categoty=Documentcategory::model()->findAll(array(
								   'condition'=>'name=:name and parent=:parent','params'=>array('name'=>$_POST['Documentcategory']['name'],'parent'=>$_POST['Documentcategory']['parent'])
							   ));


		if(isset($_POST['Documentcategory']) && count($categoty)==0)
		{
			$model->attributes=$_POST['Documentcategory'];
			$model->isactive=$_POST['Documentcategory']['isactive'];
			$model->parent=$_POST['Documentcategory']['parent'];
			$model->save();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				$this->redirect(array('index'));
		}

		//ayn� data eklenmek istendi�inde donecek olan mesaj

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
			$id=$_POST['Documentcategory']['id'];
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Documentcategory']))
		{
			$model->attributes=$_POST['Documentcategory'];
			$model->isactive=$_POST['Documentcategory']['isactive'];
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
			$id=$_POST['Documentcategory']['id'];
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
				if (isset($_POST['categoryid']))
		{			
			$guncelle=Documentcategory::model()->changeactive($_POST['categoryid'],$_POST['isactive']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}


		$dataProvider=new CActiveDataProvider('Documentcategory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Documentcategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documentcategory']))
			$model->attributes=$_GET['Documentcategory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Documentcategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Documentcategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Documentcategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='documentcategory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
