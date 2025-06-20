<?php

class WebController extends Controller
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
				'actions'=>array('index','view','genelicerikkaydet','hizmet','hizmetcreate','hizmetupdate','hizmetdelete','iletisim',
				'iletisimdelete','ziyaretcilog','ziyaretcilogdelete'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new GenelIcerik;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GenelIcerik']))
		{
			$model->attributes=$_POST['GenelIcerik'];
			$model->kayit_tarihi=date('Y-m-d H:i:s');
			if($model->save())
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				$this->redirect(array('index'));
		}
		Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
		$this->redirect(array('index'));

	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionUpdate($id)
	{

		$id=$_POST['GenelIcerik']['id'];
		$model=GenelIcerik::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GenelIcerik']))
		{
			$model->baslik=$_POST['GenelIcerik']['baslik'];
			$model->icerik=$_POST['GenelIcerik']['icerik'];
			if($model->save())
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				$this->redirect(array('index'));
		}

		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
			$this->redirect(array('index'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
			$id=$_POST['GenelIcerik']['id'];

		$model=GenelIcerik::model()->findByPk($id);
			$model->delete();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				$this->redirect(array('index'));
	}

	public function actionHizmet()
	{

				$this->render("hizmet");
	}
	public function actionHizmetcreate()
	{
		$model=new Hizmet;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Hizmet']))
		{
			$model->attributes=$_POST['Hizmet'];
			$model->kayit_tarihi=date('Y-m-d H:i:s');
			$model->durum=1;
			if($model->save())
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('hizmet'));
			$this->render("hizmet");
		}
		Yii::app()->SetFlashes->add($model,t('Create Success!'),array('hizmet'));
		$this->render("hizmet");

	}

	public function actionHizmetupdate($id)
	{

		$id=$_POST['Hizmet']['id'];
		$model=Hizmet::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Hizmet']))
		{
			$model->attributes=$_POST['Hizmet'];
			if($model->save())
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('hizmet'));
				$this->render("hizmet");
		}

		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('hizmet'));
			$this->render("hizmet");
	}

	public function actionHizmetdelete($id)
	{
			$id=$_POST['Hizmet']['id'];

		$model=Hizmet::model()->findByPk($id);
			$model->delete();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('hizmet'));
			$this->render("hizmet");
	}
	public function actionIletisim()
	{

				$this->render("iletisim");
	}
	public function actionIletisimdelete($id)
	{
			$id=$_POST['IletisimFormu']['id'];

		$model=IletisimFormu::model()->findByPk($id);
			$model->delete();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('iletisim'));
			$this->render("iletisim");
	}

	public function actionZiyaretcilog()
	{

				$this->render("ziyaretcilog");
	}
	public function actionZiyaretcilogdelete($id)
	{
			$id=$_POST['ziyaretcilog']['id'];

		$model=Ziyaretcilog::model()->findByPk($id);
			$model->delete();
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('ziyaretcilog'));
			$this->render("ziyaretcilog");
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Web');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Web('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Web']))
			$model->attributes=$_GET['Web'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Web the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Web::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Web $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='web-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
