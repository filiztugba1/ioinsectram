<?php

class TicketsController extends Controller
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
				'actions'=>array('index','view','setstatus','getstatus'),
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
		$model=new Tickets;
		$ax= User::model()->userobjecty('');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tickets']))
		{

			$model->attributes=$_POST['Tickets'];
			$model->fromid=$_POST['Tickets']['fromid'];
			$model->towhereid=$_POST['Tickets']['towhereid'];
			$model->toid=$_POST['Tickets']['toid'];
			$model->subject=$_POST['Tickets']['subject'];
			$model->createdat=time();
			$firm=Firm::model()->findByPk($ax->firmid);
			$path =Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/';

   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
	  if($file_name){
		$file_size =$_FILES['image']['size'];
		$file_tmp =$_FILES['image']['tmp_name'];
		$file_type=$_FILES['image']['type'];
		$temTime=time();
		$temp = explode(".", $_FILES["image"]["name"]);
		$newfilename = $temTime. '.' . end($temp);

		  if(move_uploaded_file($file_tmp,$path.$newfilename)){
			 $model->atachment='/uploads/'.$firm->username.'/'.$newfilename;
		  }else{
			 print_r($errors);
		  }
	  }
      
   }


////////////////////////////////////////


					/*	$atachment=CUploadedFile::getInstanceByName('atachment');
						if(isset($atachment))
						{
							$type=explode('.',$atachment->name);
							$atachment->saveas($path.'/'.$temTime.'.'.$type[1]);
							if($atachment!='')
							{
								$filepath=$path.'/'.$atachment;
								unlink($filepath);
							}
							$atachment=$path.'/'.$temTime.'.'.$type[1];
						}/
*/
//////////////////////////////////////

			if($model->save())
			{
					$user=User::model()->findByPk($_POST['Tickets']['fromid']);
			
				Yii::import('application.extensions.phpmailer.JPhpMailer');
				$mail = new JPhpMailer;
				$mail->IsSMTP();
				$mail->CharSet  ="utf-8";
				$mail->Host = 'mail.insectram.io';
				$mail->SMTPAuth = true;
				$mail->Username = 'mailer@insectram.io';
				$mail->Port='587';
				$mail->Password = '@insectram2018';
				$mail->SetFrom('info@insectram.io', 'Insectram Info');
				$mail->Subject = User::model()->dilbul($usermailx->languageid,'Yeni bir destek talebi!');
				$mail->AltBody = Yii::app()->getBaseUrl(true).'/tickets';
				$mail->MsgHTML('<h3>'.$user->name.''.$user->surname.'</h3>
								 '.User::model()->dilbul($usermailx->languageid,'Tarafından bir destek talebi açılmıştır.').'
								<p>'.User::model()->dilbul($usermailx->languageid,'Görmek için lütfen').' <a href="'.Yii::app()->getBaseUrl(true).'/tickets">'.User::model()->dilbul($usermailx->languageid,'Buraya tıklayın').' </a> </p>');
				$mail->AddAddress("mustafa.zorlu@safrangroup.com.tr","Mustafa Zorlu");
				$mail->AddAddress("hande.altintas@purean.co.uk", "Hande Altıntaş");
				$mail->AddAddress("ozgur.karakas@purean.co.uk", "Taylan Özgür Karakaş");
				$mail->AddAddress("support@purean.co.uk", "Support");
				$mail->AddAddress("fcurukcu@gmail.com", "Filiz Çürükcü");
				$mail->AddAddress("alpbarutcu@gmail.com", "Alper Barutçu");
				$mail->Send();
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
			
			}

		}
		Yii::app()->user->setFlash('error', t('Available Data!'));
		$this->redirect(array('index'));

	}

	public function getStatus($type)
	{
		if ($type==0)
		 {
			 return '<span style="color:white;padding:5px 10px;background-color:#1e73be;border-radius:10px;">New </span>';
		 }
		 else if($type==1){
			  return '<span style="color:white;padding:5px 10px ;background-color:#ffc107;border-radius:10px;">Open</span>';
		  }
		 else if ($type==2){
			 return '<span style="color:white;padding:5px 10px;background-color:#5cb85c;border-radius:10px;">Closed </span>';
		 }
	}

	public function setStatus($id)
	{
		$model=Tickets::model()->findByPk($id);
		if ($model->status==0)
		{
			$model->status=1;
			$model->update();
		}
	}

	public function actionSetstatus()
	{
		$model=Tickets::model()->findByPk($_GET["id"]);
		if ($model->status==0)
		{
			$model->status=1;
			$model->readstate=1;
			$model->readtime=time();
			$model->update();
		}

	}

	public function actionGetstatus()
	{
		$model=Tickets::model()->findByPk($_GET["id"]);
		$type=$model->status;
		if ($type==0)
		 {
			 echo 'Status : <span style="color:white;padding:5px 10px;background-color:#1e73be;border-radius:10px;">'.t('New').' </span>';
		 }
		 else if($type==1){
			  echo 'Status : <span style="color:white;padding:5px 10px ;background-color:#ffc107;border-radius:10px;">'.t('Open').' </span>';
		  }
		 else if ($type==2){
			 echo 'Status : <span style="color:white;padding:5px 10px;background-color:#5cb85c;border-radius:10px;">'.t('Closed').'  </span>';
		 }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel($_POST['Tickets']['id']);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tickets']))
		{
			$model->note=$_POST['Tickets']['note'];
			$model->status=2;
			if($model->update())
				Yii::app()->SetFlashes->add($model,t('Success!'),array('index'));
		}

		$this->render('index');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			$id=$_POST['Tickets']['id'];
			$this->loadModel($id)->delete();
			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tickets');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tickets('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tickets']))
			$model->attributes=$_GET['Tickets'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tickets the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tickets::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tickets $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tickets-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
