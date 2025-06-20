<?php

class DepartmentsController extends Controller
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
				'actions'=>array('index','view',
                        'departmentlist','clientdepartmant','departmentcreateupdate','departmentdelete','departmentdeleteall','departmentisactive','departmanlistesi'),
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
  public function actionDepartmentlist()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $response=NewParamsModel::model()->departmentlist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }

     public function actionDepartmentcreateupdate()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $response=NewParamsModel::model()->departmentcreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }

   public function actionDepartmentdelete()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $response=NewParamsModel::model()->departmentdelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }

    public function actionDepartmentdeleteall()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $response=NewParamsModel::model()->departmentdeleteall($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }

  public function actionDepartmentisactive()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $response=NewParamsModel::model()->departmentisactive($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }

  public function actionDepartmanlistesi()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $request['clientid']=$_POST['id'];
      echo json_encode(NewParamsModel::model()->departmanHtmlList($request));
      exit;
    }
    json_encode($yetki);
		exit;
  }

	public function actionClientdepartmant()
  {
     $yetki=AuthAssignment::model()->accesstoken();

    if($yetki['status'])
    {
      $request['clientid']=$_GET['id'];
      echo json_encode(NewParamsModel::model()->departmentlist($request,'select'));
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

	 $clientid=$_POST['Departments']['clientid'];
		$model=new Departments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


		$department=Departments::model()->findAll(array(
								   'condition'=>'name=:name and clientid=:clientid and parentid=:parentid','params'=>array('name'=>$_POST['Departments']['name'],'clientid'=>$_POST['Departments']['clientid'],'parentid'=>$_POST['Departments']['parentid'])
							   ));


			$ax= User::model()->userobjecty('');


		if(isset($_POST['Departments']) && count($department)==0)
		{

			$model->attributes=$_POST['Departments'];


			if($model->save())
			{



				if($_POST['Departments']['parentid']==0)
				{
					//departman� kullan�c�ya yetki verme
					$where='where clientbranch.id='.$_POST['Departments']['clientid'].' and departments.parentid=0';
					 User::model()->departmanpermission($where);

				}
				else
				{
					//sub departman� kullan�c�ya yetki verme
					$where='where clientbranch.id='.$_POST['Departments']['clientid'];
					 User::model()->subdepartmanpermission($where);
				}


				$user=User::model()->findAll(array('condition'=>'firmid='.$ax->firmid));
				foreach($user as $userx)
				{
					// User::model()->depsubpertransfer($userx->id,$ax->branchid);
				}

			}
			//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/client/departments','id'=>$clientid));
				$this->redirect(array('/client/departments/','id'=>$clientid));
		}


		// mevcut datan�n ayn�s�ndan eklenece�inde verilecek olan mesaj
		Yii::app()->user->setFlash('error', t('Available Data!'));
		$this->redirect(array('/client/departments/','id'=>$clientid));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		 $clientid=$_POST['Departments']['clientid'];
		if($id==0)
		{
			$id=$_POST['Departments']['id'];
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Departments']))
		{
			$model->attributes=$_POST['Departments'];
			$model->save();
			//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/client/departments','id'=>$clientid));
				$this->redirect(array('/client/departments','id'=>$clientid));
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
	 $clientid=$_POST['Departments']['clientid'];

		if($id==0)
		{
			$id=$_POST['Departments']['id'];
		}


		// $this->loadModel($id)->delete();

		$dep=$this->loadModel($id);

		if($dep->parentid==0)
		{

			$dpermission=Departmentpermission::model()->deleteAll(array('condition'=>'clientid='.$_POST['Departments']['clientid'].' and departmentid='.$id));
		}
		else
		{
			$dpermission=Departmentpermission::model()->deleteAll(array('condition'=>'clientid='.$_POST['Departments']['clientid'].' and subdepartmentid='.$id));
		}


		$dep->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Departments::model()->deleteAll(array(
								   'condition'=>'parentid=:id','params'=>array('id'=>$_POST['Departments']['id'])
							   ));

			//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/client/departments','id'=>$clientid));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/client/departments','id'=>$clientid));
			}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Departments');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Departments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Departments']))
			$model->attributes=$_GET['Departments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Departments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Departments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Departments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='departments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
