<?php

class AuthController extends Controller
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
		$model=new AuthItem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AuthItem']))
		{
			$model->attributes=$_POST['AuthItem'];
			if($model->type==0) // Grup Olu�turma
			{
				$model->name=$_POST['package'].'.'.$model->name;
				
			}

			if($model->save())
			{
				if($model->type==0) // Grup Olu�turduktan sonra Pakete gurubu child ekleyelim
				{				
						
					AuthItem::model()->generateparentpermission($model->name); // otomatik olu�tur
					//AuthItem::model()->createchild($_POST['package'],$model->name);
				}
				if($model->type==1) // paket olu�turma 
				{
					AuthItem::model()->createnewpackage($model->name);
				}
				
				if(isset($_POST['authcreate'])) // Firma Olu�turma
				{
					if(isset($_POST['default']))
					{
						$default=$_POST['default'];
					}
					else
					{
						$default='Default';
					}
					AuthItem::model()->createnewauth($_POST['package'],$_POST['AuthItem']['name'],$default);
				}
				/*if(isset($_POST['branchcreate'])) // Firma Olu�turma
				{
					AuthItem::model()->createnewbranch($_POST['firm'],$_POST['AuthItem']['name']);
				}
				if(isset($_POST['customerreate'])) // Firma Olu�turma
				{
					AuthItem::model()->createnewbranch($_POST['branch'],$_POST['AuthItem']['name']);
				}*/
				
				
				
				exit;
				$this->redirect(array('index'));
			}
		}
		if (count($model->getErrors())>0)
		{
		Yii::app()->user->setFlash('error','ss');

			$axt='';         
			foreach($model->getErrors() as $row => $innerArray){
				foreach($innerArray as $innerRow => $value)
				{
					$axt.= $value . "<br/>";
				}
			}
		Yii::app()->user->setFlash('error',$axt);
		}

			$this->redirect(array('index'));
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

		if(isset($_POST['AuthItem']))
		{
			$model->attributes=$_POST['AuthItem'];
			if($model->save())
				$this->redirect(array('index'));
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
		$q = new CDbCriteria( array(
							'condition' => "name LIKE :match",      // DON'T do it this way!
							'params'    => array(':match' => $_POST['AuthItem']['name'].'.%')
						) );

		$comments = AuthItem::model()->findAll( $q ); 

		foreach($comments as $comment)
		{	
				$model=AuthItem::model()->deleteAll(array('condition' => "name=:name",'params'=> array(':name' => $comment->name)));
		}

		$model=AuthItem::model()->deleteAll(array('condition' => "name=:name",'params'=> array(':name' =>$_POST['AuthItem']['name'])));
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
				$this->redirect(array('index'));

	}

		public function actionGroupdelete($id)
	{-
		
		$model=AuthItem::model()->deleteAll(array('condition' => "name=:name",'params'=> array(':name' =>$_POST['AuthItem']['name'])));
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
				$this->redirect(array('index'));

	}


	public function actionDeletepermission()
	{
		$data=explode('.',$_POST['AuthItem']['name']);
	
		$delete='';
		$conformityactivity=false;
		$conformity=false;
		$monitoring=false;
		$departments=false;
		$clientbranch=false;
		$client=false;
		$departmentvisited=false;
		$workorder=false;
		$branch=false;
		$firm=false;
		$route=false;
		$documentclientbranch=false;
		$dcbselect=false;
		$documentclient=false;
		$dcselect=false;
		$documentbranch=false;
		$dbselect=false;
		$documentfirm=false;
		$dfselect=false;
		$documentviewcb=false;
		$documentviewc=false;
		$documentviewb=false;
		$documentviewf=false;
		
		
		
		
		if(count($data)==1)
		{
			//document delete start
			//giren ki�i paket ise ve clientbranch document eklediyse
			$documentclientbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.*,ccm.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.package="'.$data[0].'"')->execute();
			$dcbselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=4 and ffm.package="'.$data[0].'"')->queryAll();
			foreach ($dcbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcbselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.*,ccm.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=4 and ffm.package="'.$data[0].'"')->execute();
			
			//giren ki�i paket ise ve client document eklediyse
			$documentclient=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.package="'.$data[0].'"')->execute();
			$dcselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.package="'.$data[0].'"')->queryAll();
			foreach ($dcselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.package="'.$data[0].'"')->execute();
			//giren ki�i paket ise ve branch document eklediyse
			$documentbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN firm ON firm.id=documents.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=2 and ffm.package="'.$data[0].'"')->execute();
			$dbselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN firm ON firm.id=documents.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=2 and ffm.package="'.$data[0].'"')->queryAll();
			foreach ($dbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dbselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.* FROM documents INNER JOIN firm ON firm.id=documents.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=2 and ffm.package="'.$data[0].'"')->execute();
			//giren ki�i paket ise ve firm document eklediyse
			$documentfirm=Yii::app()->db->createCommand('DELETE firm.*,documents.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=1 and firm.package="'.$data[0].'"')->execute();
			$dfselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents  INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=1 and firm.package="'.$data[0].'"')->queryAll();
			foreach ($dfselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dfselect=Yii::app()->db->createCommand('DELETE firm.*,documents.* FROM documents  INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=1 and firm.package="'.$data[0].'"')->execute();
			//document delete finish
			
			
			//documentviewfirm start
			$documentviewcb=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.*,dw2.*,dw3.* From documentviewfirm INNER JOIN documentviewfirm as dw3 ON dw3.parentid=documentviewfirm.id INNER JOIN documentviewfirm as dw2 ON dw2.parentid=dw3.id INNER JOIN documentviewfirm as dw1 ON dw1.parentid=dw2.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.package="'.$data[0].'"')->execute();
			$documentviewc=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.*,dw2.* From documentviewfirm INNER JOIN documentviewfirm as dw2 ON dw2.parentid=documentviewfirm.id INNER JOIN documentviewfirm as dw1 ON dw1.parentid=dw2.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.package="'.$data[0].'"')->execute();
			$documentviewb=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.* From documentviewfirm INNER JOIN documentviewfirm as dw1 ON dw1.parentid=documentviewfirm.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.package="'.$data[0].'"')->execute();
			$documentviewf=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.* From documentviewfirm INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.package="'.$data[0].'"')->execute();
			
			//documentviewfirm finish
			
			
			$conformityactivity=Yii::app()->db->createCommand('DELETE conformityactivity.*,conformity.*,client.*,cmm.*,firm.*,ffm.* FROM conformityactivity INNER JOIN conformity ON conformity.id=conformityactivity.conformityid INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid
where ffm.package="'.$data[0].'"')->execute();
			$conformity=Yii::app()->db->createCommand('DELETE conformity.*,client.*,cmm.*,firm.*,ffm.* FROM conformity INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[0].'"')->execute();
			$monitoring=Yii::app()->db->createCommand('DELETE monitoring.*,client.*,cmm.*,firm.*,ffm.* FROM monitoring INNER JOIN client ON client.id=monitoring.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[0].'"')->execute();
			$departments=Yii::app()->db->createCommand('DELETE departments.*,client.*,cmm.*,firm.*,ffm.* FROM departments INNER JOIN client ON client.id=departments.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[0].'"')->execute();
			$clientbranch=Yii::app()->db->createCommand('DELETE client.*,cmm.*,firm.*,ffm.* FROM client INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[1].'"')->execute();
			$client=Yii::app()->db->createCommand('DELETE client.*,firm.*,ffm.* FROM client INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[1].'"')->execute();
			$departmentvisited=Yii::app()->db->createCommand('DELETE departmentvisited.*,workorder.*,firm.*,ffm.* FROM departmentvisited INNER JOIN workorder ON workorder.id=departmentvisited.workorderid INNER JOIN firm ON firm.id=workorder.branchid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[0].'"')->execute();
			$workorder=Yii::app()->db->createCommand('DELETE workorder.*,firm.*,ffm.* FROM workorder INNER JOIN firm ON firm.id=workorder.branchid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[0].'"')->execute();
			$route=Yii::app()->db->createCommand('DELETE route.*,firm.*,ffm.* FROM route INNER JOIN firm ON firm.id=route.branchid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[1].'"')->execute();
			$branch=Yii::app()->db->createCommand('DELETE firm.*,ffm.* FROM firm INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.package="'.$data[1].'"')->execute();
			$firm=Yii::app()->db->createCommand('DELETE FROM firm WHERE package="'.$data[0].'"')->execute();
			
		}
		else if(count($data)==2)
		{
			
			//document delete start
			//giren ki�i ise ve clientbranch document eklediyse
			$documentclientbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.*,ccm.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.username="'.$data[1].'"')->execute();
			$dcbselect=Yii::app()->db->createCommand(
			'SELECT firm.*,documents.*,ffm.*,client.*,ccm.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=4 and ffm.username="'.$data[1].'"')->queryAll();
			foreach ($dcbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcbselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.*,ccm.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=4 and ffm.username="'.$data[1].'"')->execute();
			
			//giren ki�i ise ve client document eklediyse
			$documentclient=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.username="'.$data[1].'"')->execute();
			$dcselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.username="'.$data[1].'"')->queryAll();
			foreach ($dcselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			
			$dcselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,client.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=3 and ffm.username="'.$data[1].'"')->execute();
			
			//giren ki�i ise ve branch document eklediyse
			$documentbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN firm ON firm.id=documents.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=2 and ffm.username="'.$data[1].'"')->execute();
			$dbselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN firm ON firm.id=documents.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=2 and ffm.username="'.$data[1].'"')->queryAll();
			foreach ($dbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dbselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,ffm.* FROM documents INNER JOIN firm ON firm.id=documents.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where documents.firmtype=2 and ffm.username="'.$data[1].'"')->execute();
			//giren ki�i ise ve firm document eklediyse
			$documentfirm=Yii::app()->db->createCommand('DELETE firm.*,documents.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=1 and firm.username="'.$data[1].'"')->execute();
			$dfselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents  INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=1 and firm.username="'.$data[1].'"')->queryAll();
			foreach ($dfselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dfselect=Yii::app()->db->createCommand('DELETE firm.*,documents.* FROM documents  INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=1 and firm.username="'.$data[1].'"')->execute();
			
			
			//document delete finish
			
			//documentviewfirm start
			$documentviewcb=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.*,dw2.*,dw3.* From documentviewfirm INNER JOIN documentviewfirm as dw3 ON dw3.parentid=documentviewfirm.id INNER JOIN documentviewfirm as dw2 ON dw2.parentid=dw3.id INNER JOIN documentviewfirm as dw1 ON dw1.parentid=dw2.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.username="'.$data[1].'"')->execute();
			$documentviewc=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.*,dw2.* From documentviewfirm INNER JOIN documentviewfirm as dw2 ON dw2.parentid=documentviewfirm.id INNER JOIN documentviewfirm as dw1 ON dw1.parentid=dw2.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.username="'.$data[1].'"')->execute();
			$documentviewb=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.* From documentviewfirm INNER JOIN documentviewfirm as dw1 ON dw1.parentid=documentviewfirm.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.username="'.$data[1].'"')->execute();
			$documentviewf=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.* From documentviewfirm INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=1 and firm.username="'.$data[1].'"')->execute();
			
			//documentviewfirm finish
			
			
			$conformityactivity=Yii::app()->db->createCommand('DELETE conformityactivity.*,conformity.*,client.*,cmm.*,firm.*,ffm.* FROM conformityactivity INNER JOIN conformity ON conformity.id=conformityactivity.conformityid INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid
where ffm.username="'.$data[1].'"')->execute();
			$conformity=Yii::app()->db->createCommand('DELETE conformity.*,client.*,cmm.*,firm.*,ffm.* FROM conformity INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$monitoring=Yii::app()->db->createCommand('DELETE monitoring.*,client.*,cmm.*,firm.*,ffm.* FROM monitoring INNER JOIN client ON client.id=monitoring.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$departments=Yii::app()->db->createCommand('DELETE departments.*,client.*,cmm.*,firm.*,ffm.* FROM departments INNER JOIN client ON client.id=departments.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$clientbranch=Yii::app()->db->createCommand('DELETE client.*,cmm.*,firm.*,ffm.* FROM client INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$client=Yii::app()->db->createCommand('DELETE client.*,firm.*,ffm.* FROM client INNER JOIN firm ON firm.id=client.firmid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$departmentvisited=Yii::app()->db->createCommand('DELETE departmentvisited.*,workorder.*,firm.*,ffm.* FROM departmentvisited INNER JOIN workorder ON workorder.id=departmentvisited.workorderid INNER JOIN firm ON firm.id=workorder.branchid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$workorder=Yii::app()->db->createCommand('DELETE workorder.*,firm.*,ffm.* FROM workorder INNER JOIN firm ON firm.id=workorder.branchid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$route=Yii::app()->db->createCommand('DELETE route.*,firm.*,ffm.* FROM route INNER JOIN firm ON firm.id=route.branchid INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$branch=Yii::app()->db->createCommand('DELETE firm.*,ffm.* FROM firm INNER JOIN firm as ffm ON ffm.id=firm.parentid where ffm.username="'.$data[1].'"')->execute();
			$firm=Yii::app()->db->createCommand('DELETE FROM firm WHERE username="'.$data[1].'"')->execute();
		}
		else if(count($data)==3)
		{
			//document delete start
			//giren ki�i clientbranch document eklediyse
			$documentclientbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.*,client.*,ccm.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=ccm.firmid where documents.firmtype=4 and firm.username="'.$data[2].'"')->execute();
			$dcbselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid where documents.firmtype=4 and firm.username="'.$data[2].'"')->queryAll();
			foreach ($dcbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcbselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,client.*,ccm.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid INNER JOIN firm ON firm.id=client.firmid where documents.firmtype=4 and firm.username="'.$data[2].'"')->execute();
			
			//giren ki�i client document eklediyse
			$documentclient=Yii::app()->db->createCommand('DELETE firm.*,documents.*,client.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid where documents.firmtype=3 and firm.username="'.$data[2].'"')->execute();
			$dcselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid where documents.firmtype=3 and firm.username="'.$data[2].'"')->queryAll();
			foreach ($dcselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcselect=Yii::app()->db->createCommand('DELETE firm.*,documents.*,client.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN firm ON firm.id=client.firmid where documents.firmtype=3 and firm.username="'.$data[2].'"')->execute();
			//giren ki�i branch document eklediyse
			$documentbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=2 and firm.username="'.$data[2].'"')->execute();
			$dcbranch=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=2 and firm.username="'.$data[2].'"')->queryAll();
			foreach ($dcbranch as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcbranch=Yii::app()->db->createCommand('DELETE firm.*,documents.* FROM documents INNER JOIN firm ON firm.id=documents.firmid where documents.firmtype=2 and firm.username="'.$data[2].'"')->execute();
			
			//document delete finish
			
			
			//documentviewfirm start
			$documentviewcb=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.*,dw2.* From documentviewfirm INNER JOIN documentviewfirm as dw2 ON dw2.parentid=documentviewfirm.id INNER JOIN documentviewfirm as dw1 ON dw1.parentid=dw2.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=2 and firm.username="'.$data[2].'"')->execute();
			$documentviewc=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.*,dw1.* From documentviewfirm INNER JOIN documentviewfirm as dw1 ON dw1.parentid=documentviewfirm.id INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=2 and firm.username="'.$data[2].'"')->execute();
			$documentviewb=Yii::app()->db->createCommand('DELETE firm.*,documentviewfirm.* From documentviewfirm INNER JOIN firm ON firm.id=documentviewfirm.viewerid where documentviewfirm.type=2 and firm.username="'.$data[2].'"')->execute();
			
			//documentviewfirm finish
			
		
			$conformityactivity=Yii::app()->db->createCommand('DELETE conformityactivity.*,conformity.*,client.*,cmm.*,firm.* FROM conformityactivity INNER JOIN conformity ON conformity.id=conformityactivity.conformityid INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid where firm.username="'.$data[2].'"')->execute();
			$conformity=Yii::app()->db->createCommand('DELETE conformity.*,client.*,cmm.*,firm.* FROM conformity INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid where firm.username="'.$data[2].'"')->execute();
			$monitoring=Yii::app()->db->createCommand('DELETE monitoring.*,client.*,cmm.*,firm.* FROM monitoring INNER JOIN client ON client.id=monitoring.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid where firm.username="'.$data[2].'"')->execute();
			$departments=Yii::app()->db->createCommand('DELETE departments.*,client.*,cmm.*,firm.* FROM departments INNER JOIN client ON client.id=departments.clientid INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid where firm.username="'.$data[2].'"')->execute();
			$clientbranch=Yii::app()->db->createCommand('DELETE client.*,cmm.*,firm.* FROM client INNER JOIN client as cmm ON cmm.id=client.parentid INNER JOIN firm ON firm.id=cmm.firmid where firm.username="'.$data[2].'"')->execute();
			$client=Yii::app()->db->createCommand('DELETE client.*,firm.* FROM client INNER JOIN firm ON firm.id=client.firmid where firm.username="'.$data[2].'"')->execute();
			$departmentvisited=Yii::app()->db->createCommand('DELETE departmentvisited.*,workorder.*,firm.* FROM departmentvisited INNER JOIN workorder ON workorder.id=departmentvisited.workorderid INNER JOIN firm ON firm.id=workorder.branchid where firm.username="'.$data[2].'"')->execute();
			$workorder=Yii::app()->db->createCommand('DELETE workorder.*,firm.* FROM workorder INNER JOIN firm ON firm.id=workorder.branchid where firm.username="'.$data[2].'"')->execute();
			$route=Yii::app()->db->createCommand('DELETE route.*,firm.* FROM route INNER JOIN firm ON firm.id=route.branchid where firm.username="'.$data[2].'"')->execute();
			$branch=Yii::app()->db->createCommand('DELETE FROM firm WHERE username="'.$data[2].'"')->execute();
			
		}
		else if(count($data)==4)
		{
			//document delete start
			//giren ki�i clientbranch document eklediyse
			$documentclientbranch=Yii::app()->db->createCommand('DELETE  documents.*,client.*,ccm.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid where documents.firmtype=4 and ccm.username="'.$data[3].'"')->execute();
			$dcbselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid where documents.firmtype=4 and ccm.username="'.$data[3].'"')->queryAll();
			foreach ($dcbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcbselect=Yii::app()->db->createCommand('DELETE documents.*,client.*,ccm.* FROM documents INNER JOIN client ON client.id=documents.firmid INNER JOIN client as ccm ON ccm.id=client.parentid where documents.firmtype=4 and ccm.username="'.$data[3].'"')->execute();
			
			//giren ki�i client document eklediyse
			$documentclient=Yii::app()->db->createCommand('DELETE documents.*,client.*,documentviewfirm.* FROM documentviewfirm INNER JOIN documents ON documents.id=documentviewfirm.documentid INNER JOIN client ON client.id=documents.firmid where documents.firmtype=3 and client.username="'.$data[3].'"')->execute();
			$dcselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid where documents.firmtype=3 and client.username="'.$data[3].'"')->queryAll();
			foreach ($dcselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcselect=Yii::app()->db->createCommand('DELETE documents.*,client.* FROM documents INNER JOIN client ON client.id=documents.firmid where documents.firmtype=3 and client.username="'.$data[3].'"')->execute();
			
			
			//documentviewfirm start
			$documentviewcb=Yii::app()->db->createCommand('DELETE client.*,documentviewfirm.*,dw1.* From documentviewfirm INNER JOIN documentviewfirm as dw1 ON dw1.parentid=documentviewfirm.id INNER JOIN client ON client.id=documentviewfirm.viewerid where documentviewfirm.type=3 and client.username="'.$data[3].'"')->execute();
			$documentviewc=Yii::app()->db->createCommand('DELETE client.*,documentviewfirm.* From documentviewfirm INNER JOIN client ON client.id=documentviewfirm.viewerid where documentviewfirm.type=3 and client.username="'.$data[3].'"')->execute();
			
			//documentviewfirm finish
			
			$conformityactivity=Yii::app()->db->createCommand('DELETE conformityactivity.*,conformity.*,client.*,cmm.* FROM conformityactivity INNER JOIN conformity ON conformity.id=conformityactivity.conformityid INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid  where cmm.username="'.$data[3].'"')->execute();
			$conformity=Yii::app()->db->createCommand('DELETE conformity.*,client.*,cmm.* FROM conformity INNER JOIN client ON client.id=conformity.clientid INNER JOIN client as cmm ON cmm.id=client.parentid where cmm.username="'.$data[3].'"')->execute();
			$monitoring=Yii::app()->db->createCommand('DELETE monitoring.*,client.*,cmm.* FROM monitoring INNER JOIN client ON client.id=monitoring.clientid INNER JOIN client as cmm ON cmm.id=client.parentid where cmm.username="'.$data[3].'"')->execute();
			$departments=Yii::app()->db->createCommand('DELETE departments.*,client.*,cmm.* FROM departments INNER JOIN client ON client.id=departments.clientid INNER JOIN client as cmm ON cmm.id=client.parentid where cmm.username="'.$data[3].'"')->execute();
			$clientbranch=Yii::app()->db->createCommand('DELETE client.*,cmm.* FROM client INNER JOIN client as cmm ON cmm.id=client.parentid where cmm.username="'.$data[3].'"')->execute();
			$client=Yii::app()->db->createCommand('DELETE FROM client WHERE username="'.$data[3].'"')->execute();
			
		}
		else if(count($data)==5)
		{
			//document delete start
			$dcbselect=Yii::app()->db->createCommand(
			'SELECT documents.fileurl as url FROM documents INNER JOIN client ON client.id=documents.firmid where documents.firmtype=4 and client.username="'.$data[4].'"')->queryAll();
			foreach ($dcbselect as $item)
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$item[url];
				unlink($filepath);
			}
			$dcbselect=Yii::app()->db->createCommand('DELETE documents.*,client.* FROM documents INNER JOIN client ON client.id=documents.firmid where documents.firmtype=4 and client.username="'.$data[4].'"')->execute();
			//document delete finish
			
			
			//documentviewfirm start
			$documentviewcb=Yii::app()->db->createCommand('DELETE client.*,documentviewfirm.* From documentviewfirm INNER JOIN client ON client.id=documentviewfirm.viewerid where documentviewfirm.type=4 and client.username="'.$data[4].'"')->execute();
			//documentviewfirm finish
			
			
			//conformity Activity delete sql
			$conformityactivity=Yii::app()->db->createCommand('DELETE conformityactivity.*,conformity.*,client.* FROM conformityactivity INNER JOIN conformity ON conformity.id=conformityactivity.conformityid INNER JOIN client ON client.id=conformity.clientid where client.username="'.$data[4].'"')->execute();
			$conformity=Yii::app()->db->createCommand('DELETE  conformity.*,client.* FROM conformity INNER JOIN client ON client.id=conformity.clientid where client.username="'.$data[4].'"')->execute();
			$monitoring=Yii::app()->db->createCommand('DELETE  monitoring.*,client.* FROM monitoring INNER JOIN client ON client.id=monitoring.clientid where client.username="'.$data[4].'"')->execute();
			$departments=Yii::app()->db->createCommand('DELETE  departments.*,client.* FROM departments INNER JOIN client ON client.id=departments.clientid where client.username="'.$data[4].'"')->execute();
			$clientbranch=Yii::app()->db->createCommand('DELETE FROM client WHERE username="'.$data[4].'"')->execute();
			
		}
		
		if(isset($conformityactivity))
		{	$delete=$delete.'conformityactivity,';}
		if(isset($conformity))
		{	$delete=$delete.'conformity,';}
		if(isset($monitoring))
		{	$delete=$delete.'monitoring,';}
		if(isset($departments))
		{	$delete=$delete.'departments,';}
		if(isset($clientbranch))
		{	$delete=$delete.'clientbranch,';}
		if(isset($client))
		{	$delete=$delete.'client,';}
		if(isset($departmentvisited))
		{	$delete=$delete.'departmentvisited,';}
		if(isset($workorder))
		{	$delete=$delete.'workorder,';}
		if(isset($route))
		{	$delete=$delete.'route,';}
		if(isset($branch))
		{	$delete=$delete.'branch,';}
		if(isset($firm))
		{	$delete=$delete.'firm,';}
		if(isset($documentclientbranch))
		{	$delete=$delete.'documentclientbranch,';}
		if(isset($dcbselect))
		{	$delete=$delete.'dcbselect,';}
		if(isset($documentclient))
		{	$delete=$delete.'documentclient,';}
		if(isset($dcselect))
		{	$delete=$delete.'dcselect,';}
		if(isset($documentbranch))
		{	$delete=$delete.'documentbranch,';}
		if(isset($dbselect))
		{	$delete=$delete.'dbselect,';}
		if(isset($documentfirm))
		{	$delete=$delete.'documentfirm,';}
		if(isset($dfselect))
		{	$delete=$delete.'dfselect,';}
		if(isset($documentviewcb))
		{	$delete=$delete.'documentviewcb,';}
		if(isset($documentviewc))
		{	$delete=$delete.'documentviewc,';}
		if(isset($documentviewb))
		{	$delete=$delete.'documentviewb,';}
		if(isset($documentviewf))
		{	$delete=$delete.'documentviewf,';}
		
		
		
		
		//Userinfo delete sql
		$userinfo=Yii::app()->db->createCommand('DELETE userinfo.*,user.*,AuthAssignment.* FROM userinfo INNER JOIN user ON user.id=userinfo.id INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id WHERE AuthAssignment.itemname LIKE "'.$_POST['AuthItem']['name'].'"')->execute();
		
		if(isset($userinfo))
		{	$delete=$delete.'userinfo,';}
		
		//User delete sql
		
		$user=Yii::app()->db->createCommand('DELETE AuthAssignment.*,user.* FROM user INNER JOIN AuthAssignment ON AuthAssignment.userid=user.id WHERE AuthAssignment.itemname LIKE "'.$_POST['AuthItem']['name'].'%"')->execute();
		if(isset($user))
		{	$delete=$delete.'user,';}
		
	
		//$user=Yii::app()->db->createCommand('DELETE from user where id=251')->execute();
		$model=AuthItem::model()->deleteAll(array('condition'=>"name  like '".$_POST['AuthItem']['name']."%' or '".$_POST['AuthItem']['name']."' "));
		if(isset($model))
		{	$delete=$delete.'Permission,';}
		$package=Packages::model()->find(array('condition'=>"code='".$_POST['AuthItem']['name']."'"));
		if(isset($package))
		{	$delete=$delete.'package,';}
		
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t($delete.' Delete Success!'),array('?package='.$_POST['AuthItem']['parent']));
				$this->redirect(array('?package='.$_POST['AuthItem']['parent']));

	}

	/**
	 * Lists all models.
	 */

	public function actionIndex()
	{
		//AuthItem::model()->createnewpackage('Deneme');
		//exit;

	
		
			if (isset($_POST['group'])){
			
			$data=explode('|',$_POST['group']);
			if (AuthItem::model()->changepermission($data[0],$data[1],$_POST['type'],$_POST['utype'])){
			echo 'success';
			} else {
			echo 'error|Sorry, you can not do this!';
			}
			exit;
		}
		if (isset($_GET['package']))
		{
			$package=$_GET['package'];
			if (!Yii::app()->user->checkAccess($package) && !Yii::app()->user->checkAccess('Superadmin'))
			{
				// Bu k�s�m paketi de�i�tirmeye yetkisi varsa devam ettirir yoksa hata verir
				
				Yii::app()->user->setFlash('error','Sorry, you cant see this page!');
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				exit;
			}
		}else
		{
			$package='';
		}
	
		$this->render('index',array(
			//'authgroups'=>AuthItem::model()->getauthitems('group',$package),
			//'authpermissions'=>AuthItem::model()->getauthitems('permission'),
			'authpackages'=>AuthItem::model()->getauthitems('package'),
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AuthItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AuthItem']))
			$model->attributes=$_GET['AuthItem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionInfo()
	{?>
		<a  href="/translate/translates/update?id=<?=$_GET['id'];?>"  target="_blank" class="btn btn-primary" type="button"  onclick="$('.modal').modal('hide');" ><?=t('Update');?></a>   
	<?php }

	public function actionNewauth()
	{
			$this->render('newauth');
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AuthItem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AuthItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AuthItem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='auth-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
