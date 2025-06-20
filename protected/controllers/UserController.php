<?php

class UserController extends Controller
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
				'actions'=>array('index','view','staffsearch','editprofile','company','usertable','tableayar','userlog'),
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
	 public function actionUserlog()
	 {

	 	$this->render('userlog');
	 }

	 public function actionUsertable()
	 {
		 echo 'database bağla';
	 }
	 public function actionTableayar()
	 {
		 $ax= User::model()->userobjecty('');
		// echo $_GET['sayfa'];
		// echo $_GET['value'];
		 $table=Usertablecontrol::model()->find(array(
										'condition'=>'userid=:userid and sayfaname=:sayfaname',
										'params'=>array(
											'userid'=>$ax->id,
											'sayfaname'=>$_GET['sayfa'])
									));
			if($table)
			{
				echo 'sd';
				$table->value=$_GET['value'];
				if($table->save())
				{
					echo "kayıt başarılı";
				}

			}else {
				$table=new Usertablecontrol;
				$table->userid=$ax->id;
				$table->sayfaname=$_GET['sayfa'];
				$table->value=$_GET['value'];
				if($table->save())
				{
					echo "kayıt başarılı";
				}
			}
	 }

	public function actionCreate()
	{
		$ax= User::model()->userobjecty('');
		$model=new User;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$username=User::model()->findAll(array(
								   'condition'=>'username=:username','params'=>array('username'=>$_POST['User']['username'])
							   ));
		$email=User::model()->findAll(array(
								   'condition'=>'email=:email','params'=>array('email'=>$_POST['User']['email'])
							   ));

		if(isset($_POST['User']) && count($username)==0 && count($email)==0)
		{
			$who=User::model()->whopermission();

			 $firmid=User::model()->getuserfirms()[0];


			 /* $branchid=User::model()->getuserbranchs()[0];*/

			  $branchid=$ax->branchid;


			//NOT:user id ile userinfo id eşit tutulacak

			 $model->attributes=$_POST['User'];
			 $model->password=CPasswordHelper::hashPassword($_POST['User']['password']);
			 $model->firmid=$firmid;
			 $model->branchid=$branchid;
			 $model->mainbranchid=$branchid;
			 $model->name=$_POST['User']['name'];
			 $model->email=$_POST['User']['email'];
			 $model->username=$_POST['User']['username'];
			 $model->createduser=$ax->id;

			 $model->userlgid=$_POST['User']['userlgid'];

			 $model->code=User::model()->authcode(12,1,"lower_case,upper_case,numbers")[0];

				$type="";
				if ($_POST['authtype']==0)
				{
					$type="Admin";
				}
				if ($_POST['authtype']==1)
				{
					$type="Staff";
				}


			$firmtype="";

			if($firmid==0)
			{
				$firmtype=1;
			}
			else
			{
				if($branchid==0 || $branchid=='')
				{

						$firmtype=Authtypes::model()->find(array('condition'=>"name='Firm ".$type."'"))->id;
				}
				else
				{
						$firmtype=Authtypes::model()->find(array('condition'=>"name='Branch ".$type."'"))->id;
				}
			}


			$model->type=$firmtype;
			$baseauthpath=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->userpackagename()."'"))->name;

			if(User::model()->maxuserlimit($baseauthpath,$type)==1)
			{
				if($model->save())
					{

						// conformity email eğer admin ise yetki veriliyor
						if ($_POST['authtype']==0){
								$conformityemail=new Generalsettings;
								$conformityemail->type=1;
								$conformityemail->isactive=1;
								$conformityemail->name="conformityemail";
								$conformityemail->userid=$model->id;

							$conformityemail->save();

						}





						// depertman and sub departman

						//departmanı kullanıcıya yetki verme
						$where='where user.id='.$model->id.' and departments.parentid=0';
						User::model()->departmanpermission($where);
						//sub departmanı kullanıcıya yetki verme
						$where='where user.id='.$model->id;
						User::model()->subdepartmanpermission($where);

						//transfer edilen firmanın kullnıcısına yetki verme
						if($model->branchid!=0)
						{
							User::model()->depsubpertransfer($model->id,$model->branchid);
						}


						// $baseauthpath=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->userpackagename()."'"))->name;


						if($who->who!='admin')
						{
							AuthAssignment::model()->createassignment($model->id,$baseauthpath.'.'.$type);
						}
						else
						{
							AuthAssignment::model()->createassignment($model->id,'Superadmin');
						}
						$userinfo=new Userinfo;
						$userinfo->id=$model->id;
						$userinfo->userid=$model->id;
						$userinfo->save();
					}

					//loglama
					Logs::model()->logsaction();
					/*
						Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))
					*/
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index','id'=>$model->id));
					$this->redirect(array('userinfo/index','id'=>$model->id));

			}

			else
			{
				Yii::app()->user->setFlash('error',t('Cannot exceed the maximum '.$type.' limit'));
				$this->redirect('index');


			}
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
			$id=$_POST['User']['id'];
		}

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$username=User::model()->findAll(array(
					'condition'=>'username=:username and id!='.$id,'params'=>array('username'=>$_POST['User']['username'])
							   ));
		$email=User::model()->findAll(array(
								   'condition'=>'email=:email and id!='.$id,'params'=>array('email'=>$_POST['User']['email'])
							   ));

		if(isset($_POST['User']) && count($username)==0 && count($email)==0)
		{
			$model->attributes=$_POST['User'];


			$path=Yii::getPathOfAlias('webroot').'/uploads';
			$temTime=time();
			$image=CUploadedFile::getInstance($model,'image');
			if(isset($image))
			{
				$type=explode('.',$image->name);
				$image->saveas($path.'/'.$temTime.'.'.$type[1]);
				if($model->image!='')
				{
					$filepath=Yii::getPathOfAlias('webroot').'/'.$model->image;
					unlink($filepath);
				}
				$model->image='uploads/'.$temTime.'.'.$type[1];
			}

			$model->name=$_POST['User']['name'];
			$model->surname=$_POST['User']['surname'];
			$model->userlgid=$_POST['User']['userlgid'];


			 if($_POST['User']['password']!='')
			 {
				 $model->password=CPasswordHelper::hashPassword($_POST['User']['password']);
				  User::model()->datahanmail($_POST['User']['password']);
			 }
			 else
			 {
				 $model->password=User::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)))->password;
			 }

			$model->update();



			//user conformity email is active
				$conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$id)
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
				$conformityemail->userid=$id;
			}

			$conformityemail->save();

			//finish




			//loglama
			Logs::model()->logsaction();
			/*
				Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))
			*/
			if(@$_POST['User']['location']=='editprofile')
			{
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('editprofile','id'=>$model->id));

			}
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));

			/*
				Hataları sadece üstteki setflashes classı ile ayıklıyoruz!!! :)))
			*/
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

		Yii::app()->user->setFlash('error', t($error.' '.'previously used'));
		$this->redirect(array('index'));
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
			$id=$_POST['User']['id'];
		}


		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){


			Departmentpermission::model()->deleteAll(array('condition'=>'userid='.$id));  // kullanıcı silinince yetkisini de silme

			$userinfo=Userinfo::model()->findByPk($id);
			$userinfo->delete();

			AuthAssignment::model()->deleteAll(array('condition'=>'userid='.$id));

			//loglama
			Logs::model()->logsaction();
				/*
				Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))
			*/
			Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index','id'=>$model->id));
			/*
				Hataları sadece üstteki setflashes classı ile ayıklıyoruz!!! :)))
			*/
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		if (isset($_POST['userid']))
		{
			$guncelle=User::model()->changeactive($_POST['userid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}

		}


		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function actionEditprofile()
	{
		$this->render('view');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function actionStaffsearch()
	{

	$ax= User::model()->userobjecty('');
	$where='';
	$iscolor='';
		if($ax->firmid>0)
		{
			if($ax->branchid>0)
			{
				if($ax->clientid>0)
				{
					if($ax->clientbranchid>0)
					{
						$where='and u.clientbranchid='.$ax->clientbranchid;
					}
					else
					{
						$where='and u.clientbranchid=0 and u.clientid='.$ax->clientid;
					}
				}
				else
				{
					$where='and u.clientid=0 and u.clientbranchid=0 and u.mainbranchid='.$ax->branchid;
					$iscolor='ok';
				}
			}
			else
			{
				$where='and u.branchid=0 and u.clientid=0 and u.clientbranchid=0 and u.firmid='.$ax->firmid;

			}
		}
		else
		{
			$where='and u.branchid=0 and u.clientid=0 and u.clientbranchid=0 and u.firmid=0';
		}
					$user = Yii::app()->db->createCommand()
						->from('userinfo l')
						->join('user u', 'u.id=l.userid')
						->where("CONCAT_WS(' ',u.name,u.surname ) LIKE '%".$_GET['ara']."%' ".$where.' and u.id!='.$ax->id)
						->queryall();


					for($i=0;$i<count($user);$i++)
					{?>

                    <div class="col-xl-3 col-md-6 col-12">
						<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">
						  <div class="text-center">

						    <?if($user[$i]['active']==1){?>
						  <a class="btn btn-success btn-sm" style='float:right;color:#fff'><?=t('Active');?> </a>
						 <?}else{?> <a class="btn btn-danger btn-sm" style='float:right;color:#fff'><?=t('Passive');?> </a><?}?>


							<div class="card-body">
							  <img src="<?if($user[$i]['gender']==0){?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mr.png';?><?}else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?}?>" class="rounded-circle  height-150" alt="Card image">
							</div>
							<div class="card-body">
							<?if($iscolor=='ok'){?>
							<div class="card-title" style="background:#<?=$user[$i]['color'];?>;height:5px"></div>
							<?}?>
							  <h4 class="card-title"><?=$user[$i]['name'].' '.$user[$i]['surname'];?></h4>
							  <h6 class="card-subtitle text-muted"><?=$user[$i]['primaryphone'];?></h6>
							</div>
							<div class="text-center" style="margin-bottom:10px">
							 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
							 data-id="<?=$user[$i]['userid'];?>"
							 data-username="<?=$user[$i]['username'];?>"
							 data-name="<?=$user[$i]['name'];?>"
							 data-surname="<?=$user[$i]['surname'];?>"
							 data-email="<?=$user[$i]['email'];?>"
							 data-password="<?=$user[$i]['password'];?>"
							 data-birthplace="<?=$user[$i]['birthplace'];?>"
							 data-birthdate="<?=$user[$i]['birthdate'];?>"
							 data-gender="<?=$user[$i]['gender'];?>"
							 data-phone="<?=$user[$i]['primaryphone'];?>"
							 data-userid="<?=$user[$i]['userid'];?>"
								  ><i style="color:#fff;" class="fa fa-edit"></i></a>

							<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)"
							data-id="<?=$user[$i]['id'];?>"
							data-userid="<?=$user[$i]['userid'];?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
							</div>
						  </div>
						</div>
					  </div>
				<?}

	}




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */


	public function actionCompany()
	{
		$this->render('company');
	}
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
