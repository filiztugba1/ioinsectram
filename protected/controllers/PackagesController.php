<?php

class PackagesController extends Controller
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		 $code=Firm::model()->usernameproduce($_POST['Packages']['name']);
	

		$model=new Packages;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

			$packages=Packages::model()->findAll(array(
								   'condition'=>'name=:name','params'=>array('name'=>$_POST['Packages']['name'])
							   ));

		

		if(isset($_POST['Packages']) && count($packages)==0)
		{
			$model->attributes=$_POST['Packages'];
			$model->code=$code;
			$model->maxtech=$_POST['Packages']['maxtech'];
			$model->maxadmin=$_POST['Packages']['maxadmin'];
			$model->maxfile=$_POST['Packages']['maxfile'];
			$model->maxfirmadmin=$_POST['Packages']['maxfirmadmin'];
			$model->maxfirmstaff=$_POST['Packages']['maxfirmstaff'];

			if ($model->save())
			{

				Yii::app()->getModule('authsystem');
				
				AuthItem::model()->createitem($code,1);
				AuthItem::model()->createnewpackage($code);
			}
			//loglama
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
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
			$id=$_POST['Packages']['id'];
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Packages']))
		{
			$model->attributes=$_POST['Packages'];
			$model->maxtech=$_POST['Packages']['maxtech'];
			$model->maxadmin=$_POST['Packages']['maxadmin'];
			$model->maxfile=$_POST['Packages']['maxfile'];
			$model->maxfirmadmin=$_POST['Packages']['maxfirmadmin'];
			$model->maxfirmstaff=$_POST['Packages']['maxfirmstaff'];
			$model->save();
			//loglama
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
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
			$id=$_POST['Packages']['id'];
		}


		$this->loadModel($id)->delete();



		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			//loglama
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));

			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Packages']['id']);
	
		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
		
		Yii::app()->SetFlashes->add($model,t('Selected packages deleted!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['packageid']))
		{			
			$guncelle=Packages::model()->changeactive($_POST['packageid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}


		$dataProvider=new CActiveDataProvider('Packages');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function loadModel($id)
	{
		$model=Packages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}
