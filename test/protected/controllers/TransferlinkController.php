<?php

class TransferlinkController extends Controller
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
				'actions'=>array('index','view','transferclient'),
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


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Transfer']))
		{

	

			$usert=User::model()->findAll(array('condition'=>'mainclientbranchid='.$_POST['Transfer']['clientid']));
			
			foreach($usert as $usertx)
			{
				$usert2=User::model()->find(array('condition'=>'id='.$usertx->id));
				$usert2->mainbranchid=$_POST['Transfer']['tbranchid'];
				$usert2->branchid=$_POST['Transfer']['tbranchid'];
				if (!$usert2->save()){
							var_dump($usert2->geterrors());
							exit;
						}
				
			}


			$tclient=Client::model()->find(array('condition'=>'id='.$_POST['Transfer']['clientid']));
			
			echo $tclient->firmid;
			echo $tclient->mainfirmid;

			if($tclient->firmid!=$tclient->mainfirmid)
			{

				  $firmid=$tclient->firmid;
				  $ters=$tclient->mainfirmid;
			}
			else
			{
				 $firmid=$tclient->mainfirmid;
				  $ters=$tclient->firmid;
			}
			// echo $ters;


		$tasi=Documentviewfirm::model()->findAll(array('condition'=>'clientbranchid='.$_POST['Transfer']['clientid']));

		foreach($tasi as $tasix)
		{			
			$firmadocumantadd=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$tasix->documentid.' and branchid='.$_POST['Transfer']['tbranchid'].' and clientid=0'));
			if(!$firmadocumantadd)
			{
				$tbranchdocument=new Documentviewfirm;
				$tbranchdocument->documentid=$tasix->documentid;
				$tbranchdocument->viewerid=$tasix->viewerid;
				$tbranchdocument->type=23;
				$tbranchdocument->firmid=$tasix->firmid;
				$tbranchdocument->branchid=$_POST['Transfer']['tbranchid'];
				$tbranchdocument->clientid=0;
				$tbranchdocument->clientbranchid=0;
				$tbranchdocument->createdtime=time();
						if (!$tbranchdocument->save()){
							var_dump($tbranchdocument->geterrors());
							echo '1. deneme';
							exit;
						}
			}

			$clientadocumantadd=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$tasix->documentid.' and branchid='.$_POST['Transfer']['tbranchid'].' and clientbranchid=0'));
			if(!$firmadocumantadd)
			{
				$tbranchdocument=new Documentviewfirm;
				$tbranchdocument->documentid=$tasix->documentid;
				$tbranchdocument->viewerid=$tasix->viewerid;
				$tbranchdocument->type=23;
				$tbranchdocument->firmid=$tasix->firmid;
				$tbranchdocument->branchid=$_POST['Transfer']['tbranchid'];
				$tbranchdocument->clientid=$tasix->clientid;
				$tbranchdocument->clientbranchid=0;
				$tbranchdocument->createdtime=time();
				if (!$tbranchdocument->save()){
							var_dump($tbranchdocument->geterrors());
							echo '2. deneme';
							exit;
						}

			}

				$cbranchdocument=new Documentviewfirm;
				$cbranchdocument->documentid=$tasix->documentid;
				$cbranchdocument->viewerid=$tasix->viewerid;
				$cbranchdocument->type=23;
				$cbranchdocument->firmid=$tasix->firmid;
				$cbranchdocument->branchid=$_POST['Transfer']['tbranchid'];
				$cbranchdocument->clientid=$tasix->clientid;
				$cbranchdocument->clientbranchid=$tasix->clientbranchid;
				$cbranchdocument->createdtime=time();
				if (!$cbranchdocument->save()){
							var_dump($cbranchdocument->geterrors());
							echo '3. deneme';
							exit;
						}

		}

		$tclient->firmid=$_POST['Transfer']['tbranchid'];
			$tclient->mainclientid=$tclient->parentid;
			$tclient->save();




			$dep=Departments::model()->findAll(array('condition'=>'parentid=0 and clientid='.$tclient->id));
			$userper=User::model()->findAll(array('condition'=>'(mainbranchid='.$tclient->firmid.' or branchid='.$tclient->firmid.') and clientid=0'));
			foreach($userper as $userperk)
			{
				foreach($dep as $depx)
				{
						$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$tclient->id.' and departmentid='.$depx->id.' and subdepartmentid=0 and userid='.$userperk->id));

						if(!$dpermission)
						{
							$newper=new Departmentpermission;
							$newper->clientid=$tclient->id;
							$newper->userid=$userperk->id;
							$newper->departmentid=$depx->id;
							$newper->subdepartmentid=0;
							$newper->save();
						}

						$sub=Departments::model()->findAll(array('condition'=>'parentid='.$depx->id));

						foreach($sub as $subx)
						{
							$dpermissionx=Departmentpermission::model()->find(array('condition'=>'clientid='.$tclient->id.' and departmentid='.$depx->id.' and subdepartmentid='.$subx->id.' and userid='.$userperk->id));

								if(!$dpermissionx)
								{
									$newper=new Departmentpermission;
									$newper->clientid=$tclient->id;
									$newper->userid=$userperk->id;
									$newper->departmentid=$depx->id;
									$newper->subdepartmentid=$subx->id;
									$newper->save();
								}
						}
				}
			}





		Logs::model()->logsaction();
		
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($tclient,t('Transfer Success!'),array('/transferlink'));

			exit;

			 echo 'SELECT documents.categoryid,documents.name,documents.fileurl,documents.type as documenttype,documentviewfirm1.viewerid,documentviewfirm2.viewerid ,documentviewfirm.* FROM documents 
			INNER JOIN documentviewfirm ON documents.id = documentviewfirm.documentid 
			INNER JOIN documentviewfirm as documentviewfirm1 ON documentviewfirm1.parentid = documentviewfirm.id
			INNER JOIN documentviewfirm as documentviewfirm2 ON documentviewfirm2.parentid = documentviewfirm1.id
			where documentviewfirm.type=2 and documentviewfirm.viewerid='.$firmid.' and documentviewfirm2.type=4 and documentviewfirm2.viewerid='.$tclient->id;
			exit;

			
			//transfer edilince dosyalar�n da transfer i�lemi
			$document= Yii::app()->db->createCommand('SELECT documents.categoryid,documents.name,documents.fileurl,documents.type as documenttype,documentviewfirm1.viewerid,documentviewfirm2.viewerid ,documentviewfirm.* FROM documents 
			INNER JOIN documentviewfirm ON documents.id = documentviewfirm.documentid 
			INNER JOIN documentviewfirm as documentviewfirm1 ON documentviewfirm1.parentid = documentviewfirm.id
			INNER JOIN documentviewfirm as documentviewfirm2 ON documentviewfirm2.parentid = documentviewfirm1.id
			where documentviewfirm.type=2 and documentviewfirm.viewerid='.$firmid.' and documentviewfirm2.type=4 and documentviewfirm2.viewerid='.$tclient->id)->queryAll();

		/*	echo 'SELECT documents.categoryid,documents.name,documents.fileurl,documents.type as documenttype,documentviewfirm1.viewerid,documentviewfirm2.viewerid ,documentviewfirm.* FROM documents 
			INNER JOIN documentviewfirm ON documents.id = documentviewfirm.documentid 
			INNER JOIN documentviewfirm as documentviewfirm1 ON documentviewfirm1.parentid = documentviewfirm.id
			INNER JOIN documentviewfirm as documentviewfirm2 ON documentviewfirm2.parentid = documentviewfirm1.id
			where documentviewfirm.type=2 and documentviewfirm.viewerid='.$firmid.' and documentviewfirm2.type=4 and documentviewfirm2.viewerid='.$tclient->id;

		*/


		// echo count($document);
			if (is_countable($document))	{	
			for($i=0;$i<count($document);$i++)
			{		
				$model=Documentviewfirm::model()->find(array('condition'=>'id='.$document[$i]['id']));


				$isdocument=Documentviewfirm::model()->find(array('condition'=>'documentid='.$model->documentid.' and viewerid='.$_POST['Transfer']['tbranchid'].' and type=2'));
				
				// echo 'document'.count($isdocument);

				if($isdocument)
				{
					$tclientx=Client::model()->find(array('condition'=>'id='.$tclient->parentid));

					// echo 'parentdocuman'.$isdocument->id;
					if($tclientx)
					{
						$isdocumentclient=Documentviewfirm::model()->find(array('condition'=>'documentid='.$model->documentid.' and viewerid='.$tclientx->id.' and type=3'));

						$newmodel2id=0;

						echo 'clientid'.$tclientx->id;

						if($isdocumentclient)
						{
							$newmodel2id=$isdocumentclient->id;
							echo 'mevcut'.$isdocumentclient->parentid=$isdocument->id;
							$isdocumentclient->save();
						}
						else
						{
							$newmodel2=new Documentviewfirm;
							$newmodel2->documentid=$model->documentid;
							echo 'mevcutd'.$newmodel2->parentid=$isdocument->id;
							$newmodel2->viewerid=$tclientx->id;
							$newmodel2->type=3;
							$newmodel2->viewer=0;
							$newmodel2->save();

							$newmodel2id=$newmodel2->id;
						}

						$isdocumentalt=Documentviewfirm::model()->find(array('condition'=>'documentid='.$model->documentid.' and viewerid='.$_POST['Transfer']['clientid'].' and type=4'));

						if($isdocumentalt)
						{
							echo 'clientbranch'.$isdocumentalt->parentid=$newmodel2id;
							$isdocumentalt->save();
						}
							
					}
				
				}
				else
				{

					$newmodel=new Documentviewfirm;
					$newmodel->documentid=$model->documentid;
					$newmodel->parentid=0;
					$newmodel->viewerid=$_POST['Transfer']['tbranchid'];
					$newmodel->type=2;
					$newmodel->viewer=0;
					$newmodel->save();
						
					$tclientx=Client::model()->find(array('condition'=>'id='.$tclient->parentid));
					if($tclientx)
					{
						$isdocumentclient=Documentviewfirm::model()->find(array('condition'=>'documentid='.$model->documentid.' and viewerid='.$tclientx->id.' and type=3'));

						$newmodel2id=0;
						if($isdocumentclient)
						{
							$newmodel2id=$isdocumentclient->id;
						}
						else
						{
							

							$newmodel2=new Documentviewfirm;
							$newmodel2->documentid=$model->documentid;
							$newmodel2->parentid=$newmodel->id;
							$newmodel2->viewerid=$tclientx->id;
							$newmodel2->type=3;
							$newmodel2->viewer=0;
							$newmodel2->save();

							$newmodel2id=$newmodel2->id;
						}


						$isdocumentalt=Documentviewfirm::model()->find(array('condition'=>'documentid='.$model->documentid.' and viewerid='.$_POST['Transfer']['clientid'].' and type=4'));

						if($isdocumentalt)
						{
							$isdocumentalt->parentid=$newmodel2id;
							$isdocumentalt->save();
						}
							
					}

				
				}


				if($tclient->firmid!=$tclient->mainfirmid)
				{
				

					// echo 'ergergerg';


					$isters=Documentviewfirm::model()->find(array('condition'=>'documentid='.$model->documentid.' and viewerid='.$ters.' and type=2'));//branch
					if($isters)
					{
						
						$isters2=Documentviewfirm::model()->findAll(array('condition'=>'parentid='.$isters->id)); //client

						echo count($isters2);
						if(count($isters2)==0)
						{
							$isters->delete();
						}

					}

					
				}
				
			}
    }

			$tclient->firmid=$_POST['Transfer']['tbranchid'];
			$tclient->mainclientid=$tclient->parentid;
			$tclient->save();




			$dep=Departments::model()->findAll(array('condition'=>'parentid=0 and clientid='.$tclient->id));
			$userper=User::model()->findAll(array('condition'=>'(mainbranchid='.$tclient->firmid.' or branchid='.$tclient->firmid.') and clientid=0'));
			foreach($userper as $userperk)
			{
				foreach($dep as $depx)
				{
						$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$tclient->id.' and departmentid='.$depx->id.' and subdepartmentid=0 and userid='.$userperk->id));

						if(!$dpermission)
						{
							$newper=new Departmentpermission;
							$newper->clientid=$tclient->id;
							$newper->userid=$userperk->id;
							$newper->departmentid=$depx->id;
							$newper->subdepartmentid=0;
							$newper->save();
						}

						$sub=Departments::model()->findAll(array('condition'=>'parentid='.$depx->id));

						foreach($sub as $subx)
						{
							$dpermissionx=Departmentpermission::model()->find(array('condition'=>'clientid='.$tclient->id.' and departmentid='.$depx->id.' and subdepartmentid='.$subx->id.' and userid='.$userperk->id));

								if(!$dpermissionx)
								{
									$newper=new Departmentpermission;
									$newper->clientid=$tclient->id;
									$newper->userid=$userperk->id;
									$newper->departmentid=$depx->id;
									$newper->subdepartmentid=$subx->id;
									$newper->save();
								}
						}
				}
			}



		

			// exit;

			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($tclient,t('Transfer Success!'),array('/transferlink'));
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

		if(isset($_POST['transferlink']))
		{
			$model->attributes=$_POST['transferlink'];
					   if ($model->save()){
            $data=[];
        $data['id']=$model->id;
		    api_response($data);		
               	$this->redirect(array('view','id'=>$model->id));
      }else{
          api_response('Check datas!',false);
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
		$this->loadModel($id)->delete();
		
		    api_response('ok');			
   
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('transferlink');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new transferlink('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['transferlink']))
			$model->attributes=$_GET['transferlink'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return transferlink the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=transferlink::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function actionTransferclient()
	{
		$parent=Client::model()->find(array('condition'=>'id='.$_GET['client']));
		
		$branch=Firm::model()->findall(array('condition'=>'parentid='.$_GET['id'].' and id!='.$parent->firmid));
		foreach($branch as $branchx){?>
		<option value="<?=$branchx->id;?>"><?=$branchx->name;?></option>
									<?php }

	}




	/**
	 * Performs the AJAX validation.
	 * @param transferlink $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transferlink-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
