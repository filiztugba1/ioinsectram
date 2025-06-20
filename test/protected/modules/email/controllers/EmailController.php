<?php

class EmailController extends Controller
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
				'actions'=>array('index','view','emailgo'),
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
		$model=new Email;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Email']))
		{
			$model->attributes=$_POST['Email'];
			$model->save();
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index','id'=>$model->id));
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
	public function actionUpdate()
	{
		$id=$_POST['Email']['id'];
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Email']))
		{
			$model->attributes=$_POST['Email'];
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));
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
	public function actionDelete()
	{
		$id=$_POST['Email']['id'];
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index','id'=>$model->id));
		}
	}

	public function actionEmailgo()
	{
		if(isset($_POST['Email']))
		{
			$this->emailsend($_POST['Email']['message'],$_POST['Email']['subject']);
		}
		$this->render('view');
	}


		public function emailsend($message,$subject)
	{
		$user=User::model()->find(array('condition'=>'id=:id','params'=>array('id'=>Yii::app()->user->id)));

		$emails=Email::model()->findall(array('condition'=>'isdefault=:isdefault','params'=>array('isdefault'=>1)));

		foreach($emails as $email)
			{		
			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->IsSMTP();
			$mail->Host = $email->smtphost;
			$mail->SMTPAuth = true;
			$mail->Username = $email->fromemail;
			$mail->Port=$email->port;
			$mail->Password = $email->password;
			$mail->SetFrom($user->email, $user->name.' '.$user->surname);
			$mail->Subject =$subject;
			$mail->AltBody =$subject;
			$mail->MsgHTML('<p>'.$message.'</p>');
			$mail->AddAddress($email->fromemail, $email->fromname);
			$mail->Send();

		}
			
			
	}




	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['emailid']))
		{			
			$guncelle=Email::model()->changeactive($_POST['emailid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}


		$dataProvider=new CActiveDataProvider('Email');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Email('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Email']))
			$model->attributes=$_GET['Email'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Email the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Email::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Email $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='email-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
