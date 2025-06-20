<?php

class MonitoringtypepetsController extends Controller
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
		$model=new Monitoringtypepets;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		

			$pets=Monitoringtypepets::model()->findAll(array(
								   'condition'=>'petsid=:petsid and monitoringtypeid=:monitoringtypeid','params'=>array('petsid'=>$_POST['Monitoringtypepets']['petsid'],'monitoringtypeid'=>$_POST['Monitoringtypepets']['monitoringtypeid'])
							   ));

		

		if(isset($_POST['Monitoringtypepets']) && count($pets)==0)
		{
			$model->attributes=$_POST['Monitoringtypepets'];
			$model->monitoringtypeid=$_POST['Monitoringtypepets']['monitoringtypeid'];
			$model->save();
			//loglama
			Logs::model()->logsaction();
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/monitoringtype/pets?id='.$_POST['Monitoringtypepets']['monitoringtypeid']));
				
		}

		Yii::app()->user->setFlash('error', t('Available Data!'));
		$this->redirect(array('/monitoringtype/pets?id='.$_POST['Monitoringtypepets']['monitoringtypeid']));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$id=$_POST['Monitoringtypepets']['id'];

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Monitoringtypepets']))
		{
			$model->attributes=$_POST['Monitoringtypepets'];
			$model->save();
			//loglama
			Logs::model()->logsaction();
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/monitoringtype/pets?id='.$_POST['Monitoringtypepets']['monitoringtypeid']));
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
		$id=$_POST['Monitoringtypepets']['id'];
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			{
			Logs::model()->logsaction();
			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/monitoringtype/pets?id='.$_POST['Monitoringtypepets']['monitoringtypeid']));
			}
	}

	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Monitoringtypepets']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
		
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($model,t('Selected monitoring type pets deleted!'),array('/monitoringtype/pets?id='.$_POST['Monitoringtypepets']['monitoringtypeid']));
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Monitoringtypepets');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Monitoringtypepets('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Monitoringtypepets']))
			$model->attributes=$_GET['Monitoringtypepets'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Monitoringtypepets the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Monitoringtypepets::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Monitoringtypepets $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='monitoringtypepets-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
