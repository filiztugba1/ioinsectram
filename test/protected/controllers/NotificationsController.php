<?php

class NotificationsController extends Controller
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

		$ax= User::model()->userobjecty('');
		for($i=0;$i<count($_POST[recurdays]);$i++)
		{
			$model=new Notifications;
		
			if(isset($_POST['Notifications']))
			{
				$model->attributes=$_POST['Notifications'];
				$model->sender=$ax->id;
				$model->userid=$_POST[recurdays][$i];
				$model->createdtime=time();
				$model->type=0;
				$model->urlid=0;
			if ($model->save()){
            $data=[];
         $data['id']=$model->id;
         Logs::model()->logsaction();
		     api_response($data);			
      }else{
          api_response('Check datas!',false);
      }

				//loglama
				
				
			}

		
		}
		Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index','id'=>$model->id));
		$this->redirect(array('index','id'=>$model->id));
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

	

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

		if(isset($_POST['Notifications']))
		{
			$model->attributes=$_POST['Notifications'];
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
			$id=$_POST['Notifications']['id'];
		
		}
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			//loglama
			Logs::model()->logsaction();

			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index','id'=>$model->id));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$ax= User::model()->userobjecty('');

		  $notificates=Notifications::model()->findAll(array(
								   'condition'=>'userid=:userid and readtime=:readtime','params'=>array('userid'=>$ax->id,'readtime'=>0)
							   ));
			foreach($notificates as $notificate)
			{
			$notificate->readtime=time();
			$notificate->update(); 
			}
		

		$dataProvider=new CActiveDataProvider('Notifications');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notifications('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notifications']))
			$model->attributes=$_GET['Notifications'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notifications the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notifications::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notifications $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notifications-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}



	public function actionGetn($id=0)
	{
		$ax= User::model()->userobjecty('');

	if($id!=0)
	{
		 $count=Notifications::model()->findAll(array(
			 						'select'=>'id',
								   'condition'=>'userid=:userid and readtime=:readtime','params'=>array('userid'=>$ax->id,'readtime'=>0)
							   ));	

		  $subject=Notifications::model()->find(array(
									'order'=>'createdtime DESC',
								   'condition'=>'userid=:userid and readtime=:readtime','params'=>array('userid'=>$ax->id,'readtime'=>0)
							   ));	
		if ($subject)
		{
				$sub=$subject->subject;
		}else
		{
			$sub='';
		}
		
		 echo count($count).'|'.$sub;
		 exit;
	}
		 


			//notification okundu
			$notificates=Notifications::model()->findAll(array(
								   'condition'=>'userid=:userid and readtime=:readtime','params'=>array('userid'=>$ax->id,'readtime'=>0)
							   ));
			foreach($notificates as $notificate)
			{
			$notificate->readtime=time();
			$notificate->update(); 
			}

			//notification okundu



		 $notifications=Notifications::model()->findAll(array(
								   #'select'=>'',
								   'limit'=>'5',
								   'order'=>'createdtime DESC',
								   'condition'=>'userid=:userid','params'=>array('userid'=>$ax->id)
							   ));
		 foreach($notifications as $notificatex){?>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">
							<?php  $sender=User::model()->find(array('condition'=>'id='.$notificatex->sender));?>
							<?=$sender->name.' '.$sender->surname;?>
						
						</h6>
                        <p class="notification-text font-small-3 text-muted"><?=$notificatex->subject;?></p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00"><?=date('d.m.Y H:i:s', $notificationx->createdtime);?></time>
                        </small>
                      </div>
                    </div>
                  </a>

<?php

		 }
	}
}
