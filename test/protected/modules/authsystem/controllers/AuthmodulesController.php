<?php

class AuthmodulesController extends Controller
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
				'actions'=>array('index','view','delete'),
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


	public function bulkaydet($name)
	{
			$itemread=AuthItem::model()->find(array(
								   'condition'=>'name=:name','params'=>array('name'=>$name)
							   ));


			
			if(empty($itemread))
			{
				$items=new AuthItem;
				$items->name=$name;
				$items->type=3;
				$items->superadmin=0;
				if($items->save())
				{
					AuthItem::model()->createchild('Superadmin',$items->name);
				}
			}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->bulkaydet($_POST['Authmodules']['readpermission']);
		$this->bulkaydet($_POST['Authmodules']['updatepermission']);
		$this->bulkaydet($_POST['Authmodules']['createpermission']);
		$this->bulkaydet($_POST['Authmodules']['deletepermission']);
		
		
		if($_POST['Authmodules']['parentid']=='')
		{
			$_POST['Authmodules']['parentid']=0;
		}

		$model=new Authmodules;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authmodules']))
		{
			$model->attributes=$_POST['Authmodules'];
			$model->uniqname=Firm::model()->usernameproduce($_POST['Authmodules']['name']);
			
			$model->save();
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
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
		$this->bulkaydet($_POST['Authmodules']['readpermission']);
		$this->bulkaydet($_POST['Authmodules']['updatepermission']);
		$this->bulkaydet($_POST['Authmodules']['createpermission']);
		$this->bulkaydet($_POST['Authmodules']['deletepermission']);

		if($id==0)
		{
			$id=$_POST['Authmodules']['id'];
		}

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authmodules']))
		{
			$model->attributes=$_POST['Authmodules'];
			$model->save();
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
			$this->redirect(array('index','id'=>$model->id));
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
			$id=$_POST['Authmodules']['id'];
		}

		$a=$this->loadModel($id);
		$read=$a->readpermission;
		$upate=$a->updatepermission;
		$create=$a->createpermission;
		$delete=$a->deletepermission;
		AuthItem::model()->deleteauthitem($read);
		AuthItem::model()->deleteauthitem($upate);
		AuthItem::model()->deleteauthitem($create);
		AuthItem::model()->deleteauthitem($delete);
		$a->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Authmodules');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Authmodules('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Authmodules']))
			$model->attributes=$_GET['Authmodules'];
			$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Authmodules the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Authmodules::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Authmodules $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='authmodules-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
