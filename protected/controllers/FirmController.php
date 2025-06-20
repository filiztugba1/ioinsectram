<?php

class FirmController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view', 'branch', 'staff', 'staffcreate', 'staffsearch', 'staffupdate', 'staffdelete', 'client', 'staffteam', 'profileupdate', 'firmdelete', 'adminupdate', 'teamdeleteall', 'auth', 'reports'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'users' => array('*'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionFirms()
	{
		$res = Yii::app()->db->createCommand()
			->select('c.*')
			->from('client c')
			->leftJoin('client cb', 'cb.parentid=c.id')
			->where('c.isdelete=0 and c.active=1 and c.parentid=0 and cb.firmid=12')
			->group('c.id');
		$res = $res->queryAll();
		var_dump($res);
		exit;
	}
	public function actionCreate()
	{

		$firm = Firm::model()->findAll(array(
			'condition' => 'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email',
			'params' => array('name' => $_POST['Firm']['name'], 'title' => $_POST['Firm']['title'], 'taxoffice' => $_POST['Firm']['taxoffice'], 'taxno' => $_POST['Firm']['taxno'], 'address' => $_POST['Firm']['address'], 'landphone' => $_POST['Firm']['landphone'], 'email' => $_POST['Firm']['email'])
		));




		$username = Firm::model()->usernameproduce($_POST['Firm']['name']);
		$authuser = $username;
		$count = count(Firm::model()->findAll(array('condition' => "username Like '" . $username . "%'")));
		$username = $authuser . ($count + 1);
		$model = new Firm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Firm']) && count($firm) == 0) {
			$parentid = intval($_POST['Firm']['parentid']);
			$model->attributes = $_POST['Firm'];
			$model->username = $username;
			$model->createdtime = time();
			$model->package = $_POST['Firm']['package'];
			$model->country_id = $_POST['Firm']['country_id'];
			// $results=Documents::model()->newFCsubdocument($parentid,0,0,0);///firmaya hepsi diye eklenen dokümanlar
			$model->save();
			// $resultsadd=Documents::model()->newFCsubdocumentAdd($parentid==0?$model->id:$parentid,$parentid!=0?$model->id:0,0,0); ///yeni eklenen firmaya e döküman yetkisi verildi




			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

			Yii::app()->getModule('authsystem');


			if ($_POST['Firm']['location'] == "branch") {

				$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('firm', $_POST['Firm']['parentid']) . "'"))->name;
				if ($username != '') {
					AuthItem::model()->createitem($pname . '.' . $username, 0);
					AuthItem::model()->generateparentpermission($pname . '.' . $username);
					AuthItem::model()->createnewauth($pname, $username, 'Branch');
				}





				Yii::app()->user->setFlash('success', t('Create Success!'));
				$this->redirect('/firm/branch?type=firm&&id=' . $_POST['Firm']['parentid']);

			} else {


				if ($username != '') {
					AuthItem::model()->createitem($_POST['Firm']['package'] . '.' . $username, 0);
					//AuthItem::model()->createitem($_POST['Firm']['package'].'.'.$username.'.Admin',0);
					//AuthItem::model()->createitem($_POST['Firm']['package'].'.'.$username.'.Staff',0);
					AuthItem::model()->generateparentpermission($_POST['Firm']['package'] . '.' . $username);
					AuthItem::model()->createnewauth($_POST['Firm']['package'], $username);


					$count = count(Firm::model()->findAll(array('condition' => "username Like '" . $username . "%'")));
					$username2 = $authuser . ($count + 1);

					$model2 = new Firm;
					$model2->name = $model->name . ' - ' . t('Branch');
					$model2->title = $model->title;
					$model2->taxoffice = $model->taxoffice;
					$model2->taxno = $model->taxno;
					$model2->address = $model->address;
					$model2->landphone = $model->landphone;
					$model2->email = $model->email;
					$model2->image = $model->image;
					$model2->active = $model->active;
					$model2->country_id = $model->country_id;
					$model2->username = $username2;
					$model2->createdtime = time();
					$model2->parentid = $model->id;
					// $results=Documents::model()->newFCsubdocument($model->id,0,0,0);///firmaya hepsi diye eklenen dokümanlar
					if ($model2->save()) {
						// $resultsadd=Documents::model()->newFCsubdocumentAdd($model->id,$model2->id,0,0); ///yeni eklenen firmaya e döküman yetkisi verildi

						AuthItem::model()->createitem($_POST['Firm']['package'] . '.' . $username . '.' . $username2, 0);
						AuthItem::model()->generateparentpermission($_POST['Firm']['package'] . '.' . $username . '.' . $username2);
						AuthItem::model()->createnewauth($_POST['Firm']['package'] . '.' . $username, $username2, 'Branch');

						//loglama
						Logs::model()->logsaction();


					}

				}

				Yii::app()->user->setFlash('success', t('Create Success!'));
				$this->redirect(array('index'));

			}


		}

		Yii::app()->user->setFlash('error', t('Available Data!'));
		if ($_POST['Firm']['location'] == "branch") {
			$this->redirect('/firm/branch?type=firm&&id=' . $_POST['Firm']['parentid']);
		} else {
			$this->redirect(array('index'));
		}




		exit;

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if ($id == 0) {
			$id = $_POST['Firm']['id'];
		}

		$model = $this->loadModel($id);
		$oldPackage = $model->package;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_POST['Firm'])) {


			$model->attributes = $_POST['Firm'];

			if ($_POST['Firm']['location'] != "branch" && $_POST['Firm']['package'] <> $oldPackage) {

				Firm::model()->changePackage($oldPackage, $_POST['Firm']['package'], $model->username);
				$model->package = $_POST['Firm']['package'];
			}
			$model->createdtime = time();
			$model->country_id = $_POST['Firm']['country_id'];
			$model->save();

			//loglama
			Logs::model()->logsaction();


			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			if ($_POST['Firm']['location'] == "branch") {
				Yii::app()->SetFlashes->add($model, t('Update Success!'), array('branch?type=firm&&id=' . $_POST['Firm']['parentid']));
			} else {
				Yii::app()->SetFlashes->add($model, t('Update Success!'), array('index'));
			}


		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if ($id == 0) {
			$id = $_POST['Firm']['id'];
		}
		$model = $this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {

			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			if ($_POST['Firm']['location'] == "branch") {
				User::model()->deleteAll(array('condition' => 'branchid=:id', 'params' => array('id' => $id)));

				//AuthItem::model()->deleteAll(array('condition'=>"name Like '%".User::model()->itemdelete('firmbranch',$id)."%'"));

				Yii::app()->SetFlashes->add($model, t('Delete Success'), array('branch?type=firm&&id=' . $_POST['Firm']['parentid']));
			} else {
				User::model()->deleteAll(array('condition' => 'firmid=:id', 'params' => array('id' => $id)));

				//AuthItem::model()->deleteAll(array('condition'=>"name Like '%".User::model()->itemdelete('firm',$id)."%'"));

				Yii::app()->SetFlashes->add($model, t('Delete Success'), array('index'));
			}

		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		if (isset($_POST['firmid'])) {
			$guncelle = Firm::model()->changeactive($_POST['firmid'], $_POST['active']);
			if (!$guncelle) {
				echo "hata";
			} else {
				echo "kaydedildi";
			}

		}

		$firm = Firm::model()->findAll(array(
			'condition' => 'parentid=:parentid',
			'params' => array('parentid' => 0)
		));
		$countries = Country::model()->findAll();
		Yii::app()->getModule('AuthItem');
		$packages = AuthItem::model()->findAll(array(
			'order' => 'name ASC',
			'condition' => 'type=:type',
			'params' => array('type' => 1)
		));


		$dataProvider = new CActiveDataProvider('Firm');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'firm' => $firm,
			'countries' => $countries,
			'packages' => $packages,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Firm('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Firm']))
			$model->attributes = $_GET['Firm'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Firm the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Firm::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function actionBranch()
	{
		if (isset($_POST['firmid'])) {
			$guncelle = Firm::model()->changeactive($_POST['firmid'], $_POST['active']);
			if (!$guncelle) {
				echo t("Error");
			} else {
				echo t("Saved");
			}

		}

		$type = $_GET['type'];
		$ax = User::model()->userobjecty('');

		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;

		if ($isActive == 0) {
			$firm = Firm::model()->findAll(array(
				'condition' => 'parentid=:parentid',
				'params' => array('parentid' => $_GET['id'])
			));
		} else {
			$firm = Firm::model()->findAll(array(
				'condition' => 'parentid=:parentid and active=:active',
				'params' => array(
					'parentid' => $_GET['id'],
					'active' => (intval($isActive) == 1 ? 1 : 0)
				)
			));
		}


		$availablefirm = Firm::model()->find(array(
			'condition' => 'id=:id',
			'params' => array('id' => $_GET['id'])
		));

		$countries = Country::model()->findAll();
		$this->render('fbranch/branch', array(
			'type' => $type,
			'firm' => $firm,
			'countries' => $countries,
			'availablefirm' => $availablefirm,
			'isActive' => $isActive,
		));
	}
	public function actionReports()
	{
		$ax = User::model()->userobjecty('');

		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=0 and isdelete=0 and firmid=' . $_GET['firmid'],
		));
		$type = $_GET['type'];
		$say = 0;
		$say2 = 0;
		if ($type == 'firm') {
			$say = User::model()->findAll(array('condition' => 'firmid=' . $_GET['firmid'] . ' and branchid=0'));


		

		} else {
			$say = User::model()->findAll(array('condition' => 'branchid=' . $_GET['firmid'] . ' and clientid=0'));
			$say2 = User::model()->findAll(array('condition' => 'branchid=' . $_GET['firmid'] . ' and clientid=0 and type!=23'));
		}

		$staffteams = Staffteam::model()->findAll(array(
			'condition' => 'firmid=' . $_GET['firmid'],
		));
		$tclient = Client::model()->findAll(array('order' => 'name ASC', 'condition' => 'firmid=' . $_GET['firmid'] . ' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
		$clientx = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'isdelete=0 and parentid=0 and firmid=' . $_GET["firmid"],
		));
		$this->render(
			'fbranch/reports',
			array(
				'client' => $client,
				'type' => $type,
				'say' => $say,
				'ax' => $ax,
				'tclient' => $tclient,
				'say2' => $say2,
				'staffteams' => $staffteams,
				'clientx' => $clientx,
			)
		);
	}


	public function actionAuth()
	{
		if (isset($_POST['firmid'])) {
			if ($_POST['active'] == 1) {
				$auth = new AuthAssignment;
				$data = explode('|', $_POST['firmid']);
				$auth->itemname = $data[0];
				$auth->userid = $data[1];
				if (!$auth->save()) {
					echo t("Error");
				} else {
					echo t("Successful");
				}

			} else if ($_POST['active'] == 0) {
				$data = explode('|', $_POST['firmid']);
				$auth = AuthAssignment::model()->find('itemname="' . $data[0] . '" and userid=' . $data[1]);
				if ($auth) {
					$auth->delete();
					$user = User::model()->findbypk($auth->userid);
					$user->branchid = $user->mainbranchid;
					$user->update();

					echo t("Successful");
				}
			}
		}


		$this->render('fbranch/auth');
	}
	public function actionStaff()
	{
		$ax = User::model()->userobjecty('');

		$type = $_GET['type'];


		$firm = Firm::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=' . $_GET['id'],
		));

		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=0 and isdelete=0 and firmid=' . $_GET['id'],
		));


		$staffteams = Staffteam::model()->findAll(array(
			'condition' => 'firmid=' . $_GET['id'],
		));


		$availablefirm = Firm::model()->find(array('condition' => 'id=:id', 'params' => array('id' => $_GET['id'])));
		$baseauthpath = AuthItem::model()->find(array('condition' => "name Like '%" . $availablefirm->username . "'"))->name;


		$tclient = Client::model()->findAll(array('order' => 'name ASC', 'condition' => 'firmid=' . $_GET['id'] . ' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));

		$firmuseradmin = 1;
		$firmuserstaff = 1;
		$firmx = null;
		if ($type == 'branch') {

			$firmx = Firm::model()->find(array(
				#'select'=>'',
				#'limit'=>'5',
				'condition' => 'id=' . $_GET['id'],
			));
		} else {
			$firmx = Firm::model()->find(array('condition' => 'id=' . $_GET['id']));
		}

		$say2 = 0;
		if ($type == 'firm') {
			$say = User::model()->findAll(array('condition' => 'firmid=' . $_GET['id'] . ' and branchid=0'));


			if ($firmx->package == 'Standart' || $firmx->package == 'Packagelite' || $firmx->package == 'Basic') {
				if ($say) {
					$firmuseradmin = 0;
					$firmuserstaff = 0;

				} else {
					$firmuseradmin = 1;
					$firmuserstaff = 0;
				}
			}

		} else {
			$say = User::model()->findAll(array('condition' => 'firmid=' . $firmx->parentid . ' and branchid=' . $_GET['id'] . ' and clientid=0'));
			$say2 = User::model()->findAll(array('condition' => 'firmid=' . $firmx->parentid . ' and branchid=' . $_GET['id'] . ' and clientid=0 and type!=23'));
			
			if ($firmx->package == 'Standart' || $firmx->package == 'Packagelite' || $firmx->package == 'Basic') {
				if ($say && !$say2) {
					$firmuseradmin = 0;
					$firmuserstaff = 1;

				} else if (!$say && $say2) {
					$firmuseradmin = 1;
					$firmuserstaff = 0;
				} else {
					$firmuseradmin = 1;
					$firmuserstaff = 1;
				}
			}
		}



		if ($_GET['type'] == 'firm') {
			$where = 'u.firmid=' . $_GET['id'] . ' and u.branchid=0 and u.clientid=0 and u.clientbranchid=0';
		} else {
			$where = 'u.mainbranchid=' . $_GET['id'] . ' and u.clientid=0 and u.clientbranchid=0';
		}



		if ((isset($_GET['status']) && $_GET['status'] == 1) || !isset($_GET['status'])) {
			$userisactive = ' and u.active=1';
		} else if (isset($_GET['status']) && $_GET['status'] == 2) {
			$userisactive = ' and u.active=0';
		} else {
			$userisactive = '';
		}


		$where = $where . $userisactive;

		$upisActive = 0;
		$delisActive = 0;
		if ($ax->firmid == 0) {
			$upisActive = 1;
			$delisActive = 1;
		} else if ($_GET['type'] == 'firm' && $ax->firmid != 0 && $ax->brachid == 0) {
			$upisActive = 0;
			$delisActive = 0;
		} else if ($_GET['type'] == 'branch' && $ax->firmid != 0 && $ax->brachid == 0) {
			$upisActive = 1;
			$delisActive = 1;
		}
		$upisActive = 1;                                                               // $delisActive=1;
		$user = Yii::app()->db->createCommand()
			->select('u.*,i.*,g.type as conformityemail')
			->from('user u')
			->leftJoin('userinfo i', 'i.userid=u.id')
			->leftJoin('generalsettings g', 'g.userid=u.id and g.name="conformityemail"')
			->where($where)
			//->gettext();
			->queryall();

		$languages = Languages::model()->findAll();
		$firmtrasfer = Firm::model()->findAll(array('condition' => 'parentid=' . $availablefirm->parentid));


		$this->render('fbranch/staff', array(
			'type' => $type,
			'firm' => $firm,
			'client' => $client,
			'staffteams' => $staffteams,
			'availablefirm' => $availablefirm,
			'firmuseradmin' => $firmuseradmin,
			'firmuserstaff' => $firmuserstaff,
			'firmx' => $firmx,
			'tclient' => $tclient,
			'ax' => $ax,
			'say' => $say,
			'say2' => $say2,
			'user' => $user,
			'languages' => $languages,
			'firmtrasfer' => $firmtrasfer,
			'delisActive' => $delisActive,
			'upisActive' => $upisActive,
		));
	}

	public function actionStaffteam()
	{
		if (isset($_POST['id'])) {
			$guncelle = Firm::model()->changeactivestaff($_POST['id'], $_POST['active']);
			if (!$guncelle) {
				echo t("Error");
			} else {
				echo t("Saved");
			}

		}
		$ax = User::model()->userobjecty('');
		$user = User::model()->findAll(array(
			'condition' => 'clientid=0  and mainbranchid=' . $_GET['id'],
		));


		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;
		$userisactive = '';
		if ((isset($_GET['status']) && $_GET['status'] == 1) || !isset($_GET['status'])) {
			$userisactive = ' and s.active=1';
		} else if (isset($_GET['status']) && $_GET['status'] == 2) {
			$userisactive = ' and s.active=0';
		} else {
			$userisactive = '';
		}




		$staffteams = Yii::app()->db->createCommand()
			->select('s.*,u.name,u.surname,(select GROUP_CONCAT(name," ",surname) from user bs where FIND_IN_SET(bs.id, s.staff)) as staff')
			->from('staffteam s')
			->leftJoin('user u', 'u.id=s.leaderid')
			->where('s.firmid=' . $_GET['id'] . $userisactive)
			->queryall();



		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=0 and isdelete=0 and firmid=' . $_GET['id'],
		));
		$type = $_GET['type'];

		if ($type == 'firm') {
			$say = User::model()->findAll(array('condition' => 'firmid=' . $_GET['id'] . ' and branchid=0'));


		} else {
			$say = User::model()->findAll(array('condition' => 'branchid=' . $_GET['id'] . ' and clientid=0'));
		}


		$tclient = Client::model()->findAll(array('order' => 'name ASC', 'condition' => 'firmid=' . $_GET['id'] . ' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));


		$this->render('fbranch/staffteam', array(
			'type' => $type,
			'client' => $client,
			'staffteams' => $staffteams,
			'user' => $user,
			'say' => $say,
			'tclient' => $tclient,
			'isActive' => $isActive,
			'ax' => $ax,
			'userisactive' => $userisactive
		));
	}

	public function actionStaffcreate()
	{


		$username = User::model()->findAll(array(
			'condition' => 'username=:username',
			'params' => array('username' => $_POST['Firm']['username'])
		));
		$email = User::model()->findAll(array(
			'condition' => 'email=:email',
			'params' => array('email' => $_POST['Firm']['email'])
		));



		if (count($username) == 0 && count($email) == 0) {

			$firm = "";
			$ax = User::model()->userobjecty('');


			$userstaff = new User;
			$userstaff->username = $_POST['Firm']['username'];
			$userstaff->name = $_POST['Firm']['name'];
			$userstaff->surname = $_POST['Firm']['surname'];
			$userstaff->password = CPasswordHelper::hashPassword($_POST['Firm']['password']);
			$userstaff->email = $_POST['Firm']['email'];
			$userstaff->color = $_POST['Firm']['color'];

			$userstaff->active = $_POST['Firm']['active'];

			$userstaff->userlgid = $_POST['Firm']['userlgid'];

			if ($_POST['Firm']['ftype'] == "firm") {
				$firm = $userstaff->firmid = $_POST['Firm']['firmid'];
			} else {
				if ($ax->firmid == 0) {
					$parent = Firm::model()->find(array('condition' => 'id=:id', 'params' => array('id' => $_POST['Firm']['firmid'])));
					$userstaff->firmid = $parent->parentid;
				} else {
					$userstaff->firmid = $ax->firmid;
				}
				$firm = $userstaff->branchid = $_POST['Firm']['firmid'];
				$firm = $userstaff->mainbranchid = $_POST['Firm']['firmid'];
			}

			$userstaff->code = User::model()->authcode(12, 1, "lower_case,upper_case,numbers")[0];
			$userstaff->createduser = $ax->id;
			$userstaff->createdtime = time();








			$type = "";

			if ($_POST['authtype'] == 0) {
				$type = "Admin";
			}
			if ($_POST['authtype'] == 1) {
				$type = "Staff";
			}

			if ($userstaff->branchid == 0) {
				echo $userstaff->type = Authtypes::model()->find(array('condition' => "name='Firm " . $type . "'"))->id;
			} else {
				echo $userstaff->type = Authtypes::model()->find(array('condition' => "name='Branch " . $type . "'"))->id;
			}


			$availablefirm = Firm::model()->find(array('condition' => 'id=:id', 'params' => array('id' => $firm)));
			$baseauthpath = AuthItem::model()->find(array('condition' => "name Like '%" . $availablefirm->username . "'"))->name;

			if (User::model()->maxuserlimit($baseauthpath, $type) == 1) {
				if (!$userstaff->save()) {
					var_dump($userstaff->geterrors());
					exit;
				}



				// conformity email eğer admin ise yetki veriliyor
				if ($_POST['authtype'] == 0) {
					$conformityemail = new Generalsettings;
					$conformityemail->type = 1;
					$conformityemail->isactive = 1;
					$conformityemail->name = "conformityemail";
					$conformityemail->userid = $userstaff->id;

					$conformityemail->save();

				}



				AuthAssignment::model()->createassignment($userstaff->id, $baseauthpath . '.' . $type);

				// depertman and sub departman
				//departmanı kullanıcıya yetki verme
				$where = 'where user.id=' . $userstaff->id . ' and departments.parentid=0';
				User::model()->departmanpermission($where);
				//sub departmanı kullanıcıya yetki verme
				$where = 'where user.id=' . $userstaff->id;
				User::model()->subdepartmanpermission($where);


				//transfer edilen firmanın kullnıcısına yetki verme
				if ($userstaff->branchid != 0) {
					User::model()->depsubpertransfer($userstaff->id, $userstaff->branchid);
				}


				$usertaffinfo = new Userinfo;
				$usertaffinfo->id = $userstaff->id;
				$usertaffinfo->userid = $userstaff->id;
				$usertaffinfo->birthplace = $_POST['Firm']['birthplace'];
				$usertaffinfo->birthdate = $_POST['Firm']['birthdate'];
				$usertaffinfo->gender = $_POST['Firm']['gender'];
				$usertaffinfo->primaryphone = $_POST['Firm']['phone'];
				$usertaffinfo->save();

				if ($_POST['Firm']['ftype'] != "firm") {
					Yii::app()->SetFlashes->add($userstaff, t('Create Success!'), array('staff?type=branch&&id=' . $_POST['Firm']['firmid']));
				} else {
					Yii::app()->SetFlashes->add($userstaff, t('Create Success!'), array('staff?type=firm&&id=' . $_POST['Firm']['firmid']));
				}
			} else {

				if ($_POST['Firm']['ftype'] != "firm") {

					Yii::app()->user->setFlash('error', t('Cannot exceed the maximum ' . User::model()->maxuserlimitbranch($baseauthpath, $type) . ' limit'));
					$this->redirect('staff?type=branch&&id=' . $_POST['Firm']['firmid']);

					/*
					Yii::app()->user->setFlash('error',t('Cannot exceed the maximum '.$type.' limit'));
					$this->redirect('staff?type=branch&&id='.$_POST['Firm']['firmid']);
					*/

				} else {
					Yii::app()->user->setFlash('error', t('Cannot exceed the maximum ' . User::model()->maxuserlimitfirm($baseauthpath, $type) . ' limit'));
					$this->redirect('staff?type=firm&&id=' . $_POST['Firm']['firmid']);
				}

			}
		}

		$error = '';

		if (count($username) > 0) {
			$error = 'username';
		}
		if (count($email) > 0) {
			if ($error == '') {
				$error = 'email';
			} else {
				$error = $error . ',' . 'email';

			}
		}


		Yii::app()->user->setFlash('error', t($error . ' previously used'));
		if ($_POST['Firm']['ftype'] != "firm") {

			$this->redirect(array('staff?type=branch&&id=' . $_POST['Firm']['firmid']));
		} else {
			$this->redirect(array('staff?type=firm&&id=' . $_POST['Firm']['firmid']));
		}



	}



	public function actionStaffupdate()
	{
		$ax = User::model()->userobjecty('');
		$userstaff = User::model()->findByPk($_POST['Firm']['userid']);
		$userstaff->username = $_POST['Firm']['username'];
		$userstaff->name = $_POST['Firm']['name'];
		$userstaff->surname = $_POST['Firm']['surname'];
		$userstaff->color = $_POST['Firm']['color'];

		if (isset($_POST['Firm']['usertrasfer'])) {

			$firm = Firm::model()->find(array('condition' => 'id=' . $userstaff->firmid));
			$firmbranch = Firm::model()->find(array('condition' => 'id=' . $userstaff->branchid));

			$name = $firm->package . '.' . $firm->username . '.' . $firmbranch->username;
			$yetki = AuthAssignment::model()->find(array('condition' => 'userid=' . $userstaff->id . ' and itemname like "%' . $name . '%"'));

			$firmbranchtrasfer = Firm::model()->find(array('condition' => 'id=' . $_POST['Firm']['usertrasfer']));

			// $n$_POST['Firm']['usertrasfer']ame=$firm->package.'.'.$firm->username.'.'.$firmbranchtrasfer->username;
			if ($yetki) {

				$degistir = explode('.', $yetki->itemname);
				$yetki->itemname = $degistir[0] . '.' . $degistir[1] . '.' . $firmbranchtrasfer->username . '.' . $degistir[3];
				if (isset($_POST['authtype'])) {

					if ($_POST['authtype'] == 0) {
						$degistir[3] = 'Admin';
						if ($userstaff->firmid != 0 && $userstaff->branchid == 0) {
							$userstaff->type = 13;
						} else {
							$userstaff->type = 23;
						}
					} else {
						$degistir[3] = 'Staff';
						if ($userstaff->firmid != 0 && $userstaff->branchid == 0) {
							$userstaff->type = 17;
						} else {
							$userstaff->type = 19;
						}
					}

					$yetki->itemname = $degistir[0] . '.' . $degistir[1] . '.' . $firmbranchtrasfer->username . '.' . $degistir[3];

				}
				$yetki->save();
			}

			$userstaff->branchid = $_POST['Firm']['usertrasfer'];
			$userstaff->mainbranchid = $_POST['Firm']['usertrasfer'];

		}

		if ($_POST['Firm']['password'] != '') {
			$userstaff->password = CPasswordHelper::hashPassword($_POST['Firm']['password']);
		}

		$userstaff->email = $_POST['Firm']['email'];
		$userstaff->createduser = $ax->id;
		$userstaff->createdtime = time();
		$userstaff->userlgid = $_POST['Firm']['userlgid'];
		$userstaff->active = $_POST['Firm']['active'];
		$userstaff->save();


		$conformityemail = Generalsettings::model()->find(array(
			'condition' => 'name=:name and userid=:userid',
			'params' => array('name' => 'conformityemail', 'userid' => $_POST['Firm']['userid'])
		));

		if (isset($conformityemail)) {
			$conformityemail->type = $_POST['Conformity']['ismail'];
			$conformityemail->isactive = 1;
		} else {

			$conformityemail = new Generalsettings;
			$conformityemail->type = $_POST['Conformity']['ismail'];
			$conformityemail->isactive = 1;
			$conformityemail->name = "conformityemail";
			$conformityemail->userid = $_POST['Firm']['userid'];
		}

		$conformityemail->save();




		$usertaffinfo = Userinfo::model()->find(array('condition' => 'userid=' . $_POST['Firm']['userid']));

		$usertaffinfo->birthplace = $_POST['Firm']['birthplace'];

		$usertaffinfo->birthdate = $_POST['Firm']['birthdate'];
		$usertaffinfo->gender = $_POST['Firm']['gender'];
		$usertaffinfo->primaryphone = $_POST['Firm']['phone'];
		$usertaffinfo->save();


		Yii::app()->user->setFlash('success', t('Update Success!'));
		if ($_POST['Firm']['ftype'] != "firm") {
			$this->redirect(array('staff?type=branch&&id=' . $_POST['Firm']['firmid']));
		} else {
			$this->redirect(array('staff?type=firm&&id=' . $_POST['Firm']['firmid']));
		}

	}

	public function actionStaffdelete()
	{
		$userstaff = User::model()->findByPk($_POST['Firm']['userid']);


		Departmentpermission::model()->deleteAll(array('condition' => 'userid=' . $_POST['Firm']['userid']));  // kullanıcı silinince yetkisini de silme
		if ($userstaff->delete()) {
			$userinfo = Userinfo::model()->findByPk($_POST['Firm']['userid']);
			$userinfo->delete();
			AuthAssignment::model()->deleteAll(array('condition' => 'userid=' . $_POST['Firm']['userid']));
		}

		Yii::app()->user->setFlash('success', t('Delete Success'));
		if ($_POST['Firm']['ftype'] != "firm") {
			$this->redirect(array('staff?type=branch&&id=' . $_POST['Firm']['firmid']));
		} else {
			$this->redirect(array('staff?type=firm&&id=' . $_POST['Firm']['firmid']));
		}

	}




	public function actionStaffsearch()
	{
		$ax = User::model()->userobjecty('');
		$upisActive = 0;
		$delisActive = 0;
		if ($ax->firmid == 0) {
			$upisActive = 1;
			$delisActive = 1;
		} else if (isset($_GET['type']) && $_GET['type'] == 'firm' && $ax->firmid != 0 && $ax->brachid == 0) {
			$upisActive = 0;
			$delisActive = 0;
		} else if (isset($_GET['type']) && $_GET['type'] == 'branch' && $ax->firmid != 0 && $ax->brachid == 0) {
			$upisActive = 1;
			$delisActive = 1;
		}

		if (isset($_GET['type']) && $_GET['type'] == 'firm') {
			$where = 'u.firmid=' . $_GET['id'] . ' and u.branchid=0 and u.clientid=0 and u.clientbranchid=0';
		} else {
			$where = 'u.mainbranchid=' . $_GET['id'] . ' and u.clientid=0 and u.clientbranchid=0';
		}



		$user = Yii::app()->db->createCommand()
			->from('user u')
			->join('userinfo i', 'i.id=u.id')
			->where($where . " and CONCAT_WS(' ',u.name,u.surname ) LIKE '%" . $_GET['ara'] . "%'")
			->queryall();


		for ($i = 0; $i < count($user); $i++) {

			?>

			<div class="col-xl-3 col-md-6 col-12">
				<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">
					<div class="text-center">

						<? if ($user[$i]['active'] == 1) { ?>
							<a class="btn btn-success btn-sm" style='float:right;color:#fff'><?= t('Active'); ?> </a>
						<? } else { ?> <a class="btn btn-danger btn-sm" style='float:right;color:#fff'><?= t('Passive'); ?>
							</a><? } ?>

						<div class="card-body">
							<img src="<? if ($user[$i]['gender'] == 0) { ?><?= Yii::app()->theme->baseUrl . '/app-assets/images/staff-logo-mr.png'; ?><? } else { ?><?= Yii::app()->theme->baseUrl . '/app-assets/images/staff-logo-mrs.png'; ?><? } ?>"
								class="rounded-circle  height-150" alt="Card image">
						</div>
						<div class="card-body">
							<? if (isset($_GET['type']) && $_GET['type'] == 'branch') { ?>
								<div class="card-title" style="background:#<?= $user[$i]['color']; ?>;height:5px"></div>
							<? } ?>
							<h4 class="card-title"><?= $user[$i]['name'] . ' ' . $user[$i]['surname']; ?></h4>
							<h6 class="card-subtitle text-muted"><?= $user[$i]['primaryphone']; ?></h6>
						</div>
						<? if (($upisActive || $user[$i]['id'] == $ax->id)) { ?>
							<div class="text-center" style="margin-bottom:10px">
								<a class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?= $user[$i]['userid']; ?>"
									data-username="<?= $user[$i]['username']; ?>" data-name="<?= $user[$i]['name']; ?>"
									data-surname="<?= $user[$i]['surname']; ?>" data-email="<?= $user[$i]['email']; ?>"
									data-password="<?= $user[$i]['password']; ?>" data-birthplace="<?= $user[$i]['birthplace']; ?>"
									data-birthdate="<?= $user[$i]['birthdate']; ?>" data-gender="<?= $user[$i]['gender']; ?>"
									data-phone="<?= $user[$i]['primaryphone']; ?>" data-userid="<?= $user[$i]['userid']; ?>"><i
										style="color:#fff;" class="fa fa-edit"></i></a>
							<? } ?>
							<? if ($delisActive) { ?>
								<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?= $user[$i]['id']; ?>"
									data-userid="<?= $user[$i]['userid']; ?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
							<? } ?>
						</div>
					</div>
				</div>
			</div>
		<? }

	}



	public function actionClient()
	{
		if (isset($_POST['clientid'])) {
			$guncelle = Client::model()->changeactive($_POST['clientid'], $_POST['active']);
			if (!$guncelle) {
				echo "hata";
			} else {
				echo "kaydedildi";
			}
			exit;
		}
		$ax = User::model()->userobjecty('');
		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;
		$staffteams = Staffteam::model()->findAll(array(
			'condition' => 'firmid=' . $_GET['id'],
		));

		$countries = Country::model()->findAll();
		$type = $_GET['type'];
		if ($isActive == 0) {
			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=0 and isdelete=0 and firmid=' . $_GET['id'],
			));
			$tclient = Client::model()->findAll(array('order' => 'name ASC', 'condition' => 'firmid=' . $_GET['id'] . ' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
			if ($type == 'firm') {
				$say = User::model()->findAll(array('condition' => 'firmid=' . $_GET['id'] . ' and branchid=0'));


			} else {
				$say = User::model()->findAll(array('condition' => 'branchid=' . $_GET['id'] . ' and clientid=0'));
			}

		} else {
			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=0 and isdelete=0 and active=' . (intval($isActive) == 1 ? 1 : 0) . ' and firmid=' . $_GET['id'],
			));
			$tclient2 = Client::model()->findAll(array('order' => 'name ASC', 'condition' => 'firmid=' . $_GET['id'] . ' and mainclientid!=0 and mainfirmid!=firmid and active=' . (intval($isActive) == 1 ? 1 : 0) . ' group by mainclientid'));
			$tcarr = [];
			foreach ($tclient2 as $tclientx) {
				$tcarr[] = $tclientx['mainclientid'];
			}
			$tclient = [];
			if (!empty($tcarr)) {
				$tclient = Client::model()->findAll(array('order' => 'name ASC', 'condition' => 'id in (' . implode(',', $tcarr) . ') and active=' . (intval($isActive) == 1 ? 1 : 0)));

			}
			if ($type == 'firm') {
				$say = User::model()->findAll(array('condition' => 'firmid=' . $_GET['id'] . ' and branchid=0'  ));
			} else {
				$say = User::model()->findAll(array('condition' => 'branchid=' . $_GET['id'] . ' and clientid=0' ));
			}
		}


		$availablefirm = Firm::model()->find(array(
			'condition' => 'id=:id',
			'params' => array('id' => $_GET['id'])
		));

		$this->render(
			'fbranch/client',
			array(
				'client' => $client,
				'tclient' => $tclient,
				'staffteams' => $staffteams,
				'availablefirm' => $availablefirm,
				'isActive' => $isActive,
				'type' => $type,
				'say' => $say,
				'ax' => $ax,
				'countries' => $countries,
				'tclient2' => $tclient2
			)
		);
	}

	public function actionProfileupdate()
	{



		$path = Yii::getPathOfAlias('webroot') . '/uploads';
		$temTime = time();
		$firm = User::model()->sqlcompany();

		$sql = $firm->sql;

		if ($sql == 'Client') {
			$model = Client::model()->find(array('condition' => 'id=1'));
		}
		if ($sql == 'Firm') {
			$model = Firm::model()->find(array('condition' => 'id=' . $firm->id));
		}



		$image = CUploadedFile::getInstance($model, 'image');


		if (isset($image)) {
			$type = explode('.', $image->name);
			$image->saveas($path . '/' . $temTime . 'logo.' . $type[1]);
			if ($model->image != '') {
				$filepath = Yii::getPathOfAlias('webroot') . '/' . $model->image;
				unlink($filepath);
			}
			$model->image = 'uploads/' . $temTime . 'logo.' . $type[1];
		}

		$image_footer = CUploadedFile::getInstance($model, 'image_footer');


		if (isset($image_footer)) {
			$type_f = explode('.', $image_footer->name);
			$image_footer->saveas($path . '/' . $temTime . 'img_footer.' . $type_f[1]);
			if ($model->image_footer != '') {
				$filepath = Yii::getPathOfAlias('webroot') . '/' . $model->image_footer;
				unlink($filepath);
			}
			$model->image_footer = 'uploads/' . $temTime . 'img_footer.' . $type_f[1];
		}

		$image2 = CUploadedFile::getInstance($model, 'image2');


		if (isset($image2)) {
			$type2 = explode('.', $image2->name);
			$image2->saveas($path . '/' . $temTime . 'image2.' . $type2[1]);
			if ($model->image2 != '') {
				$filepath = Yii::getPathOfAlias('webroot') . '/' . $model->image2;
				unlink($filepath);
			}
			$model->image2 = 'uploads/' . $temTime . 'image2.' . $type2[1];
		}


		$model->name = $_POST['Firm']['name'];
		$model->title = $_POST['Firm']['title'];
		$model->taxoffice = $_POST['Firm']['taxoffice'];
		$model->taxno = $_POST['Firm']['taxno'];
		$model->address = $_POST['Firm']['address'];
		$model->landphone = $_POST['Firm']['landphone'];
		$model->email = $_POST['Firm']['email'];
		if (isset($_POST['Firm']['servicereport_color'])) {
			$model->servicereport_color = $_POST['Firm']['servicereport_color'];
		}


		$model->save();


		Yii::app()->SetFlashes->add($model, t('Update Success!'), array('/user/company'));




	}

	public function actionFirmdelete()
	{
		$tablename = '';
		$isdelete = '';
		if (isset($_GET['type']) && $_GET['type'] == 'firm') {
			$tablename = 'parentid';
		}
		if (isset($_GET['type']) && $_GET['type'] == 'branch') {
			$tablename = 'firmid';
			$isdelete = ' and isdelete=0';

		}
		if (isset($_GET['type']) && $_GET['type'] == 'client') {
			$tablename = 'parentid';
			$isdelete = ' and isdelete=0';
		}
		if (is_countable($_GET['user']::model()->find(array('condition' => $tablename . '=:id' . $isdelete, 'params' => array('id' => $_GET['id']))))) {
			echo count($_GET['user']::model()->find(array('condition' => $tablename . '=:id' . $isdelete, 'params' => array('id' => $_GET['id']))));
		} else {
			echo 0;
		}

	}

	public function actionAdminupdate()
	{

		$path = Yii::getPathOfAlias('webroot') . '/uploads';
		$temTime = time();



		$model = User::model()->find(array('condition' => 'id=1'));

		$image = CUploadedFile::getInstance($model, 'image');
		if (isset($image)) {
			$type = explode('.', $image->name);
			$image->saveas($path . '/' . $temTime . '.' . $type[1]);
			if ($model->image != '') {
				$filepath = Yii::getPathOfAlias('webroot') . '/' . $model->image;
				unlink($filepath);
			}
			$model->image = 'uploads/' . $temTime . '.' . $type[1];
		}
		$model->username = $_POST['User']['username'];
		if ($model->password != $_POST['User']['password']) {
			$model->password = CPasswordHelper::hashPassword($_POST['User']['password']);
		}


		$model->email = $_POST['User']['email'];
		$model->name = $_POST['User']['name'];
		$model->surname = $_POST['User']['surname'];
		$model->save();
		Yii::app()->SetFlashes->add($model, t('Update Success!'), array('/user/company'));
		exit;



	}


	public function actionTeamdeleteall()
	{

		$deleteall = explode(',', $_POST['Staffteam']['id']);

		foreach ($deleteall as $delete) {
			$staff = Staffteam::model()->find(array('condition' => 'id=:id', 'params' => array('id' => $delete)));
			$staff->delete();
		}

		Yii::app()->SetFlashes->add($deleteall, t('Delete Success'), array('staffteam?type=branch&&id=' . $_POST['Staffteam']['firmid']));
	}


	/**
	 * Performs the AJAX validation.
	 * @param Firm $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'firm-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
