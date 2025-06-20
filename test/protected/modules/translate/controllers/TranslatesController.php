<?php
class TranslatesController extends Controller
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
				'actions'=>array('index','view','traslatelist','traslatelangulagelist','traslateexcelimport'),
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

				$model=new Translates;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['title']))
		{
			$title=$_POST['title'];
			$languages=Translatelanguages::model()->findall();
			foreach ($languages as $item)
			{

				$model=new Translates;
				if (isset($_POST["$item->name"]))
				{
					$model->value=$_POST[$item->name];
				}else{
					$model->value='';
				}
				$model->title=$_POST['title'];

				$model->code=$item->name;
				$kontrol=Translates::model()->find(array(
											'condition'=>'title= BINARY :title and code= BINARY :code',
											'params'=>array(':title'=>$_POST['title'],':code'=>$item->name),
										));
				if($kontrol)
				{
					$model->save();
				}

			}
			Yii::app()->controller->module->language->createtagfiles();

				Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index','id'=>$model->id));
				$this->redirect(array('index'));
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

		$model=new Translates;

		if(isset($_POST['title']))
		{
			$title=$_POST['title'];


			$languages=Translatelanguages::model()->findall();

			foreach ($languages as $item)
			{

				$titles=Translates::model()->find(array('condition'=>'code= BINARY :dil and title= BINARY :title','params'=>array('dil'=>$item->name,'title'=>$title)));
				if(isset($titles))
				{
					if($_POST["$item->name"]=='')
					{
						$titles->value="-";
					}
					else
					{
						$titles->value=$_POST["$item->name"];
					}
                    $titles->update();
				}
				else
				{
					$model=new Translates;
					if (isset($_POST["$item->name"]))
					{
						$model->value=$_POST[$item->name];
					}
					else
					{
						$model->value='';
					}
					$model->title=$_POST['title'];

					$model->code=$item->name;
					$model->save();
				}
			}
			Yii::app()->controller->module->language->createtagfiles();
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));
				$this->redirect(array('index','id'=>$model->id));
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
		Yii::app()->controller->module->language->createtagfiles();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Translates');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function actionTraslatelist()
	{
		$response=Translates::model()->traslateList();
		echo json_encode($response);
		exit;
		// var_dump($response);
		exit;
	}

	public function actionTraslateexcelimport()
	{
		// var_dump($_POST['datam']);
		 $datam=json_decode($_POST['datam'], true);
		 echo json_encode(Translates::model()->traslateExcelCreate($datam));
		 exit;
	}

	public function actionTraslatelangulagelist()
	{
		$response=Translatelanguages::model()->traslateLanguageList();
		var_dump($response);
		exit;
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Translates('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Translates']))
			$model->attributes=$_GET['Translates'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Translates the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Translates::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Translates $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='translates-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
