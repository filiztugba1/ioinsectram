<?php

class ConformityuserassignController extends Controller
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
				'actions'=>array('index','view','reports','print','printimg',"excel"),
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
		$model=new Conformityuserassign;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Conformityuserassign']))
		{
			$model->attributes=$_POST['Conformityuserassign'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}



	public function actionReports()
	{
		$model=new Conformityuserassign;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);



		$this->render('reports',array(
			'model'=>$model,
		));
	}


	public function actionPrint()
	{

		Yii::import('application.modules.pdf.components.pdf.mpdf');

		 $url = Yii::app()->basepath."/views/conformityuserassign/";
			include($url . "print.php");

			$mpdf = new mpdf();
			$mpdf->AddPage('L');
						$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

						$mpdf->Output();
	}

	public function actionPrintimg()
	{
		$resim=$_POST["resim"];//adresi al

		$isim=rand();//isim yarat

		$yarat=touch($isim.'filiz'.".png");//resim dosyası yarat

		if($yarat){//dosya oluştuğunda

			$oku=file_get_contents($resim);//resmin içeriğini al

			$yaz=file_put_contents('uploads/grafik/'.$isim.'_grafik'.".png",$oku);//oluşturduğumuz dosyaya yaz

			if($yaz and $oku){//işlem başarılı ise

				echo $isim.'_grafik.png';

			}else{

				echo "err";

			}

		}
		exit;
	}

	public function actionExcel()
	{


		Yii::import('application.modules.pdf.components.pdf.mpdf');

		 $url = Yii::app()->basepath."/views/conformityuserassign/";
			include($url . "excel.php");
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

		if(isset($_POST['Conformityuserassign']))
		{
			$model->attributes=$_POST['Conformityuserassign'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Conformityuserassign');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Conformityuserassign('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Conformityuserassign']))
			$model->attributes=$_GET['Conformityuserassign'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Conformityuserassign the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Conformityuserassign::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Conformityuserassign $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='conformityuserassign-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
