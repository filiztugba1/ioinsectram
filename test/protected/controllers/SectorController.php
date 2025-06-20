<?php

class SectorController extends Controller
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
				'actions'=>array('index','view','deleteall'
                        ,'sectorlist','sectors','sectorcreateupdate','sectordelete','sectordetail','sectordeleteall'),
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
  public function actionSectorlist()
  {
     $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->sectorlist($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
    public function actionSectors()
  {
     $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->sectorlist($_POST,1);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
   public function actionSectorcreateupdate()
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->sectorcreateupdate($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  
   public function actionSectordelete()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->sectordelete($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
     public function actionSectordetail()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->sectordetail($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
    public function actionSectordeleteall()
  {
  
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewParamsModel::model()->sectordeleteall($_POST);
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
		$model=new Sector;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$sector=Sector::model()->findAll(array(
								   'condition'=>'name=:name and parentid=:parentid','params'=>array('name'=>$_POST['Sector']['name'],'parentid'=>$_POST['Sector']['parentid'])
							   ));

	

		if(isset($_POST['Sector']) && count($sector)==0)
		{
			$model->attributes=$_POST['Sector'];
			$model->active=$_POST['Sector']['active'];
			   if ($model->save()){
            $data=[];
        $data['id']=$model->id;
         Logs::model()->logsaction();
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
	
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index','id'=>$model->id));
				$this->redirect(array('index'));
		
		}else{
            api_response(t('Available Data!'),false);
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
			$id=$_POST['Sector']['id'];
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sector']))
		{
			$model->attributes=$_POST['Sector'];
			$model->active=$_POST['Sector']['active'];
			      if ($model->save()){
            $data=[];
        $data['id']=$model->id;
         Logs::model()->logsaction();
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }

			//loglama
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));
				$this->redirect(array('index'));
			
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
		
		if($id==0)
		{
			$id=$_POST['Sector']['id'];
		}
		


		$this->loadModel($id)->delete();
     api_response('ok');	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){

      
			//loglama
			Logs::model()->logsaction();
           api_response('ok');	
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
		}
	}

	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Sector']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		}
		     api_response('ok');	
		Yii::app()->SetFlashes->add($model,t('Selected sector deleted!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
			if (isset($_POST['sectorid']))
		{
			$guncelle=Sector::model()->changeactive($_POST['sectorid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}
		
		
		$dataProvider=new CActiveDataProvider('Sector');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Sector('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sector']))
			$model->attributes=$_GET['Sector'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sector the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sector::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sector $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sector-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
