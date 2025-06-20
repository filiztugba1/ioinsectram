<?php

class VisittypeController extends Controller
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
		
		
		if($_POST['Visittype']['branchid']=='')
		{
			$_POST['Visittype']['branchid']=0;
		}
		$model=new Visittype;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$visit=Visittype::model()->findAll(array(
								   'condition'=>'name=:name and branchid=:branchid','params'=>array('name'=>$_POST['Visittype']['name'],'branchid'=>$_POST['Visittype']['branchid'])
							   ));
							   
		if(isset($_POST['Visittype']) && count($visit)==0)
		{
			$model->attributes=$_POST['Visittype'];
      
       if ($model->save()){
            $data=[];
        $data['id']=$model->id;
         Logs::model()->logsaction();
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
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
		$id=$_POST['Visittype']['id'];
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Visittype']))
		{
			$model->attributes=$_POST['Visittype'];
      
         if ($model->save()){
            $data=[];
        $data['id']=$model->id;
         Logs::model()->logsaction();
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
      
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
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
		$id=$_POST['Visittype']['id'];
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Logs::model()->logsaction();
       api_response('ok');	
			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
		}
      api_response('ok');	
	}


	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Visittype']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
    

		    api_response('ok');			
   
		
		Yii::app()->SetFlashes->add($model,t('Selected visit types deleted!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['visittypeid']))
		{			
			$guncelle=Visittype::model()->changeactive($_POST['visittypeid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}

		$dataProvider=new CActiveDataProvider('Visittype');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Visittype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Visittype']))
			$model->attributes=$_GET['Visittype'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Visittype the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Visittype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Visittype $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='visittype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
