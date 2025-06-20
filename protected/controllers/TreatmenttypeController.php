<?php

class TreatmenttypeController extends Controller
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
				'actions'=>array('index','view','deleteall'),
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
		$model=new Treatmenttype;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$type=Treatmenttype::model()->findAll(array(
								   'condition'=>'name=:name and branchid=:branchid','params'=>array('name'=>$_POST['Treatmenttype']['name'],'branchid'=>$_POST['Treatmenttype']['branchid'])
							   ));
							   
		

		if(isset($_POST['Treatmenttype']) && count($type)==0)
		{
		
			$ax= User::model()->userobjecty('');
			$model->attributes=$_POST['Treatmenttype'];
			if (Yii::app()->user->checkaccess('Superadmin') or $ax->branchid==0 )
			{
				$model->branchid=0;
			}

			if (!$model->save())
			{
			// print_r($model->geterrors()); exit;
			}
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
		}

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
		$id=$_POST['Treatmenttype']['id'];
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Treatmenttype']))
		{
			$model->attributes=$_POST['Treatmenttype'];
			$model->save();
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
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
		$id=$_POST['Treatmenttype']['id'];
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
		}
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Treatmenttype']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
		
		Yii::app()->SetFlashes->add($model,t('Selected educations deleted!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
			
		if (isset($_POST['typeid']))
		{			
			$guncelle=Treatmenttype::model()->changeactive($_POST['typeid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}


		$dataProvider=new CActiveDataProvider('Treatmenttype');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Treatmenttype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Treatmenttype']))
			$model->attributes=$_GET['Treatmenttype'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Treatmenttype the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Treatmenttype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Treatmenttype $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='treatmenttype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
