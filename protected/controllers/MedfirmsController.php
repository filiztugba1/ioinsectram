<?php

class MedfirmsController extends Controller
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
		$model=new Medfirms;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Medfirms']))
		{
			$model->attributes=$_POST['Medfirms'];
			if($_POST['Medfirms']["branchid"]==null){
				$model->branchid=0;
			}
			$model->isactive=1;
			if($model->save())
				$this->redirect("index");
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
        $id=$_POST['Medfirms']['id'];
        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Medfirms']))
		{
			$model->name=$_POST['Medfirms']['name'];
			$model->isactive=$_POST['Medfirms']['isactive'];
			if($model->update())
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
	public function actionDelete1($id)
	{
        $id=$_POST['Medfirms']['id'];
        $this->loadModel($id)->delete();


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
        {
            Logs::model()->logsaction();
            /* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
            Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('index'));
        }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['visittypeid']))
		{			
			$guncelle=Medfirms::model()->changeactive($_POST['visittypeid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}
		
		}
		$dataProvider=new CActiveDataProvider('Medfirms');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Medfirms('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Medfirms']))
			$model->attributes=$_GET['Medfirms'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Medfirms the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Medfirms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Medfirms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='medfirms-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
