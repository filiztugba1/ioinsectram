<?php

class StaffteamlistController extends Controller
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


		$ax= User::model()->userobjecty('');


		$clientid=$_POST['Staffteamlist']['branchid'];

			$username=User::model()->findAll(array(
								   'condition'=>'username=:username','params'=>array('username'=>$_POST['Staffteamlist']['username'])
							   ));
			$email=User::model()->findAll(array(
								   'condition'=>'email=:email','params'=>array('email'=>$_POST['Staffteamlist']['email'])
							   ));

			if($_POST['type']=='branch')
			{
				$url="branchstaff";
			}
			else
			{
				$url="staff";
			}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Staffteamlist']) && count($username)==0 && count($email)==0)
		{

			$userstaff=new User;
			$userstaff->firmid=$ax->firmid;

			if($_POST['type']=='branch')
			{
				$url="branchstaff";
				$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientid)));
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$client->firmid)));

				$userstaff->firmid=$firm->parentid;
				$userstaff->branchid=$client->firmid;
				$userstaff->mainbranchid=$client->firmid;
				$userstaff->clientid=$client->parentid;
				$userstaff->clientbranchid=$clientid;
				$userstaff->mainclientbranchid=$clientid;

				$firmtype='clientbranch';
			}
			else
			{
				$url="staff";
				$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientid)));
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$client->firmid)));
				$userstaff->firmid=$firm->parentid;
				$userstaff->branchid=$firm->id;
				$userstaff->mainbranchid=$firm->id;
				$userstaff->clientid=$clientid;
				$userstaff->mainclientbranchid=0;

				$firmtype='client';
			}



			$userstaff->username=$_POST['Staffteamlist']['username'];
			$userstaff->name=$_POST['Staffteamlist']['name'];
			$userstaff->surname=$_POST['Staffteamlist']['surname'];
			$userstaff->password=CPasswordHelper::hashPassword($_POST['Staffteamlist']['password']);
			$userstaff->email=$_POST['Staffteamlist']['email'];
			$userstaff->createduser=$ax->id;
			$userstaff->userlgid=$_POST['Staffteamlist']['userlgid'];
			$userstaff->active=$_POST['Staffteamlist']['active'];

			$userstaff->createdtime=time();
			$userstaff->code=User::model()->authcode(12,1,"lower_case,upper_case,numbers")[0];

			$type="";
			if ($_POST['authtype']==0 || $_POST['authtype']==2)
			{
				$type="Admin";
			}
			if ($_POST['authtype']==1 || $_POST['authtype']==3)
			{
				$type="Staff";
			}



			if($_POST['authtype']==2 || $_POST['authtype']==3)
			{
				$userstaff->ismaster=1;
			}
			else
			{
				$userstaff->ismaster=0;
			}

			if($firmtype=='client')
			{
				echo $userstaff->type=Authtypes::model()->find(array('condition'=>"name='Customer ".$type."'"))->id;
			}
			else
			{
				echo $userstaff->type=Authtypes::model()->find(array('condition'=>"name='Customer Branch ".$type."'"))->id;
			}

			$userstaff->image='';
			$userstaff->authgroup='';
			$userstaff->languageid=0;
			$userstaff->color="";
			if(!$userstaff->save())
			{var_dump($userstaff->geterrors());exit;}


				// conformity email eðer admin ise yetki veriliyor
				if ($_POST['authtype']==0 || $_POST['authtype']==2){
						$conformityemail=new Generalsettings;
						$conformityemail->type=1;
						$conformityemail->isactive=1;
						$conformityemail->name="conformityemail";
						$conformityemail->userid=$userstaff->id;

					$conformityemail->save();

				}




			 $baseauthpath=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->itemdelete($firmtype,$clientid)."'"))->name;

			AuthAssignment::model()->createassignment($userstaff->id,$baseauthpath.'.'.$type);

				// depertman and sub departman
				//departmaný kullanýcýya yetki verme
				$where='where user.id='.$userstaff->id.' and departments.parentid=0';
				User::model()->departmanpermission($where);
				//sub departmaný kullanýcýya yetki verme
				$where='where user.id='.$userstaff->id;
				User::model()->subdepartmanpermission($where);




			$usertaffinfo=new Userinfo;
			$usertaffinfo->id=$userstaff->id;
			$usertaffinfo->userid=$userstaff->id;
			$usertaffinfo->birthplace=$_POST['Staffteamlist']['birthplace'];
			$usertaffinfo->birthdate=$_POST['Staffteamlist']['birthdate'];
			$usertaffinfo->gender=$_POST['Staffteamlist']['gender'];
			$usertaffinfo->primaryphone=$_POST['Staffteamlist']['phone'];
			$usertaffinfo->identification_number="";
			$usertaffinfo->secondaryphone="";
			$usertaffinfo->country=0;
			$usertaffinfo->marital=0;
			$usertaffinfo->children=0;
			$usertaffinfo->address="";
			$usertaffinfo->address_country=0;
			$usertaffinfo->address_city=0;
			$usertaffinfo->blood="";
			$usertaffinfo->driving_licance="";
			$usertaffinfo->driving_licance_date="";
			$usertaffinfo->military=0;
			$usertaffinfo->educationid=0;
			$usertaffinfo->speaks="";
			$usertaffinfo->certificate="";
			$usertaffinfo->travel=0;
			$usertaffinfo->health_problem=0;

			$usertaffinfo->health_problem=0;
			$usertaffinfo->health_description="";
			$usertaffinfo->smoking=0;
			$usertaffinfo->emergencyname="";
			$usertaffinfo->emergencyphone="";
			$usertaffinfo->leavedate="";
			$usertaffinfo->leave_description="";
			$usertaffinfo->referance="";
			$usertaffinfo->projects="";
			$usertaffinfo->computerskills="";

			$usertaffinfo->save();


			$model=new Staffteamlist;
			$model->attributes=$_POST['Staffteamlist'];
			$model->branchid=$clientid;
			$model->userid=$userstaff->id;
			$model->save();



			//loglama
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/client/'.$url,'id'=>$clientid));

				$this->redirect(array('/client/'.$url,'id'=>$clientid));

		}


		$error='';
		if(count($username)>0){$error='username';}
		if(count($email)>0){
			if($error=='')
			{
			$error='email';
			}
			else
			{
				$error=$error.','.'email';

			}
		}

		 $mesaj=User::model()->dilbul(User::model()->find(array('condition'=>'id='.$ax->id))->languageid,$error.' '.'previously used');


		Yii::app()->user->setFlash('error', $mesaj);
		$this->redirect(array('/client/'.$url,'id'=>$clientid));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
    $id=$_POST['Staffteamlist']['id'];
		$ax= User::model()->userobjecty('');
			if($_POST['type']=='branch')
			{
				$url="branchstaff";
			}
			else
			{
				$url="staff";
			}


		$clientid=$_POST['Staffteamlist']['branchid'];
			$staff=Staffteamlist::model()->find(array(
								   'condition'=>'branchid=:branchid and userid=:userid','params'=>array('branchid'=>$clientid,'userid'=>$_POST['Staffteamlist']['userid'])
							   ));

			 $id=$staff->id;
		$model=$staff;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Staffteamlist']))
		{	$userstaff=User::model()->findByPk($_POST['Staffteamlist']['userid']);
			$userstaff->username=$_POST['Staffteamlist']['username'];
			$userstaff->name=$_POST['Staffteamlist']['name'];
			$userstaff->surname=$_POST['Staffteamlist']['surname'];
			 if($_POST['Staffteamlist']['password']!='')
			 {
				 $userstaff->password=CPasswordHelper::hashPassword($_POST['Staffteamlist']['password']);
			 }
			$userstaff->email=$_POST['Staffteamlist']['email'];
			$userstaff->createduser=$ax->id;
			$userstaff->createdtime=time();
			$userstaff->branchid=$userstaff->branchid;
			$userstaff->userlgid=$_POST['Staffteamlist']['userlgid'];
			$userstaff->active=$_POST['Staffteamlist']['active'];





			if($_POST['type']=='branch')
					{
						$url="branchstaff";


						if($_POST['authtype']=='Admin')
							{
								$userstaff->type=26;
							}
							else
							{
								$userstaff->type=27;
							}
						$auth=AuthAssignment::model()->findAll(array('condition'=>'userid='.$_POST['Staffteamlist']['userid']));
						foreach($auth as $authx)
						{
							$modelauth=AuthAssignment::model()->find(array('condition'=>'itemname="'.$authx->itemname.'" and userid='.$_POST['Staffteamlist']['userid']));


							$authuser=explode('.',$modelauth->itemname);



							$modelauth->itemname=$authuser[0].'.'.$authuser[1].'.'.$authuser[2].'.'.$authuser[3].'.'.$authuser[4].'.'.$_POST['authtype'];

							$modelauth->save();

						}

					}
					else
					{

							if($_POST['authtype']=='Admin')
							{
								$userstaff->type=22;
							}
							else
							{
								$userstaff->type=24;
							}
						$auth=AuthAssignment::model()->find(array('condition'=>'userid='.$_POST['Staffteamlist']['userid']));
						$authuser=explode('.',$auth->itemname);
						$auth->itemname=$authuser[0].'.'.$authuser[1].'.'.$authuser[2].'.'.$authuser[3].'.'.$_POST['authtype'];

						$auth->save();

					}

            $ismail=User::model()->find(array("condition"=>"id!=".$_POST['Staffteamlist']['userid']." and email='".$_POST['Staffteamlist']['email']."'"));
            if(!$ismail)
            {
			$userstaff->save();
            }



			//conformity email is active start
			$conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$userstaff->id)
							   ));

			if(isset($conformityemail))
			{
				$conformityemail->type=$_POST['Conformity']['ismail'];
				$conformityemail->isactive=1;
			}
			else
			{

				$conformityemail=new Generalsettings;
				$conformityemail->type=$_POST['Conformity']['ismail'];
				$conformityemail->isactive=1;
				$conformityemail->name="conformityemail";
				$conformityemail->userid=$userstaff->id;
			}

			$conformityemail->save();

			//finish




			$usertaffinfo=Userinfo::model()->findByPk($_POST['Staffteamlist']['userid']);
			$usertaffinfo->birthplace=$_POST['Staffteamlist']['birthplace'];
			$usertaffinfo->birthdate=$_POST['Staffteamlist']['birthdate'];
			$usertaffinfo->gender=$_POST['Staffteamlist']['gender'];
			$usertaffinfo->primaryphone=$_POST['Staffteamlist']['phone'];
			$usertaffinfo->save();


			$model->attributes=$_POST['Staffteamlist'];
			$model->save();
			//loglama
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
			if(!$ismail)
			{
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/client/'.$url,'id'=>$clientid));
				$this->redirect(array('/client/'.$url,'id'=>$clientid));
			}
			else
			{
			    Yii::app()->user->setFlash('error', t("E-Mail Daha Önce Kullanılmıs!"));
		        $this->redirect(array('/client/'.$url,'id'=>$clientid));
			}


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
		if($_POST['type']=='branch')
			{
				$url="branchstaff";
			}
			else
			{
				$url="staff";
			}

		$clientid=$_POST['Staffteamlist']['branchid'];
		if($id==0)
		{
			$staff=Staffteamlist::model()->find(array(
								   'condition'=>'branchid=:branchid and userid=:userid','params'=>array('branchid'=>$clientid,'userid'=>$_POST['Staffteamlist']['userid'])
							   ));

			 $id=$staff->id;

		}

		$this->loadModel($id)->delete();

		Departmentpermission::model()->deleteAll(array('condition'=>'userid='.$_POST['Staffteamlist']['userid']));  // kullanýcý silinince yetkisini de silme


		$user=User::model()->findByPk($_POST['Staffteamlist']['userid']);
        $user->delete();

		$userinfo=Userinfo::model()->findByPk($_POST['Staffteamlist']['userid']);
        $userinfo->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			//loglama
			Logs::model()->logsaction();
			/* Hatalarý sadece alttaki setflashes classý ile ayýklýyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/client/'.$url,'id'=>$clientid));
				$this->redirect(array('/client/'.$url,'id'=>$clientid));

		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Staffteamlist');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Staffteamlist('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Staffteamlist']))
			$model->attributes=$_GET['Staffteamlist'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Staffteamlist the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Staffteamlist::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Staffteamlist $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staffteamlist-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
