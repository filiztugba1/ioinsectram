<?php

class LogsController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow',  // deny all users
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
		$model=new Logs;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Logs']))
		{
			$model->attributes=$_POST['Logs'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Logs']))
		{
			$model->attributes=$_POST['Logs'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
			 $id=$_POST['Logs']['id'];
		
		}
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index','id'=>$model->id));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Logs');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Logs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Logs']))
			$model->attributes=$_GET['Logs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Logs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Logs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionGetlogs($id=0)
	{

		 $logsdetay=Logs::model()->find(array(
								   'order'=>'createtime DESC',
							   ));
		  $userdetay=User::model()->find(array('condition'=>'id='.$logsdetay->userid));

		  $logs=Logs::model()->findall(array(
								   'order'=>'createtime DESC',
							   ));


		if($id!=0)
		{

			echo count($logs).'|'.$userdetay->name.' '.$userdetay->surname.' '.$logsdetay->place.' '.$logsdetay->operation;
			exit;
		
		}

	
	 
			foreach($logs as $log){?>
                                <tr>
                                    <td><?=$log->operation;?></td>
									<td><?=$log->place;?></td>
									
									<?php  $user=User::model()->find(array('condition'=>'id='.$log->userid));?>
									<td><?=$user->name.' '.$user->surname;?></td>
								
									<td><?=date('d.m.Y H:i:s', $log->createtime);?></td>
									
                                </tr>
						
					<?php }
	}


	public function actionGetlogs2($id=0)
	{
		$id=$_GET['id'];
		if(!$id)
		{
			$array['hata']='id bulunamadư';
		}
		else
		{
			  $logs=Logs::model()->findall(array(
								   'order'=>'createtime DESC',
								   'condition'=>'id>'.$id,
							   ));
			
			foreach($logs as $log)
			{
			$user=User::model()->find(array('condition'=>'id='.$log->userid));
			echo $log->id.'|'.$log->operation.'|'.$log->place.'|'.$user->name.' '.$user->surname.'|'.date('d.m.Y H:i:s', $log->createtime);
		}

			
				
		}
	
	}
	/**
	 * Performs the AJAX validation.
	 * @param Logs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='logs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
