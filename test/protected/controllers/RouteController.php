<?php

class RouteController extends Controller
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
				'actions'=>array('index','view','clientroute','deleteall'),
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
		$model=new Route;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$route=Route::model()->findAll(array(
								   'condition'=>'name=:name and branchid=:branchid','params'=>array('name'=>$_POST['Route']['name'],'branchid'=>$_POST['Route']['branchid'])
							   ));

		if(isset($_POST['Route']) and count($route)==0)
		{
			$model->attributes=$_POST['Route'];
			$model->routetb=$this->clientsplit($_POST['Route']['routeclient']);
					   if ($model->save()){
            $data=[];
        $data['id']=$model->id;
         Logs::model()->logsaction();
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
				//loglama
				
				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
				
		}

		Yii::app()->user->setFlash('error', t('Available Data!'));
		$this->redirect(array('index'));
	}

	
	public function clientsplit($staff)
	{
		$dizi="";
		 for($i=0;$i<count($staff);$i++)
		{
			 if($dizi=='')
			{
			 $dizi=$staff[$i];
			 }
			 else
			{
			 $dizi=$dizi.','.$staff[$i];
			 }
		 
		 }

		return $dizi;
	}
	
	
	public function actionClientroute()
	{
		 		$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$_GET['id'],));
				foreach($client as $clientx)
				{ $clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
				if(count($clientbranchs)>0){?>
					<optgroup label="<?=$clientx->name;?>">
					<?php					foreach($clientbranchs as $clientbranch)
					{
					?>
						<option value="<?=$clientbranch->id;?>"><?=$clientx->name;?><?=' -> '.$clientbranch->name;?></option>
					<?php }?>
					</optgroup>
				<?php }
				}


				$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$_GET['id'].' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
				foreach($tclient as $tclientx)
				{
									
					$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
					foreach($tclients as $tclientsx)
					{?>
						<optgroup label="<?=$tclientsx->name;?>">
						<?php $tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$workorder->branchid));
						foreach($tclientbranchs as $tclientbranchsx)
						{?>
							<option <?php if($tclientbranchsx->id==$workorder->clientid){echo "selected";}?>  value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
						<?php }?>
						</optgroup>
					<?php }
									
				}


							
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$id=$_POST['Route']['id'];
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Route']))
		{
			$model->attributes=$_POST['Route'];
			$model->routetb=$this->clientsplit($_POST['Route']['routeclient']);
					   if ($model->save()){
            $data=[];
        $data['id']=$model->id;
         Logs::model()->logsaction();
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index'));
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
		$id=$_POST['Route']['id'];
		$this->loadModel($id)->delete();  
    api_response($data);			
		  
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			//loglama
				Logs::model()->logsaction();
				Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function actionDeleteall()
	{
		$deleteall=explode(',',$_POST['Route']['id']);

		foreach($deleteall as $delete)
		{
			$this->loadModel($delete)->delete();
		} 
    api_response('ok');		
    		 
		
		Yii::app()->SetFlashes->add($model,t('Selected route deleted!'),array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Route');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Route('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Route']))
			$model->attributes=$_GET['Route'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Route the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Route::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Route $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='route-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
