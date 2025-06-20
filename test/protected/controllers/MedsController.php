<?php

class MedsController extends Controller
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

  
  
   ////// YENİ APİLER //////
    public function actionMedslist() 
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->medslist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
   public function actionMedscreateupdate()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->medscreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionMedsdelete()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->medsdelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
     public function actionMedsdetail()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->medsdetail($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionmedsdeleteall()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->medsDeleteAll($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionMedsisactive()
  {
     $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->medsisactive($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  ///// YENİ APİ BİTİŞ /////
  
  
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */


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
		$model=new Meds;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Meds']))
		{
			$model->attributes=$_POST['Meds'];
			$model->unit=$_POST['Meds']["unit"];
			if($_POST['Meds']["branchid"]==null){
				$model->branchid=0;
			}
			$model->isactive=1;
			if(!$model->brand)
			{
			$model->brand=$_POST['Meds']["brand"];
			}
			if($model->save())
				$this->redirect(array('Medfirms/view/'.$_POST["Meds"]["medfirmid"]));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        $id=$_POST['Meds']['id'];
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Meds']))
		{
			$model->name=$_POST['Meds']['name'];
			$model->isactive=$_POST['Meds']['isactive'];
			$model->unit=$_POST['Meds']["unit"];
			$model->brand=$_POST['Meds']["brand"];

			if($model->update())
                $this->redirect(array('medfirms/view/'.$model->medfirmid));
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
	public function actionDelete1($id)
	{
        $id=$_POST['Meds']['id'];
        $model=Meds::model()->findByPk($id);
        $tut=$model->medfirmid;
		
		$this->loadModel($id)->delete();
        Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('medfirms/view/'.$tut));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
        {

            $this->redirect(array('Medfirms/view/'.$tut));
        }


	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['visittypeid']))
		{			
			$guncelle=Meds::model()->changeactive($_POST['visittypeid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}
		$dataProvider=new CActiveDataProvider('Meds');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Meds('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Meds']))
			$model->attributes=$_GET['Meds'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Meds the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Meds::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Meds $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='meds-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
