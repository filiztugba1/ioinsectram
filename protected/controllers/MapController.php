<?php

class MapController extends Controller
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
				'actions'=>array('index','view','mapcu','mapidlist','monitors','heatmap'),
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
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionMapcu()
	{
		// CORS başlıklarını ekleyin
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type');

		// POST isteğiyle gelen verileri alın
		$id = Yii::app()->request->getPost('id');
		$points = Yii::app()->request->getPost('points');
		$img = Yii::app()->request->getPost('img');

		// Gerekli kontrolleri yapın
		if ($id === null || $points === null) {
			header('HTTP/1.1 400 Bad Request');
			echo json_encode(['response' => 'Eksik veya hatalı parametre', 'status' => 400]);
			return;
		}

		// Modeli bulun
		$model = Maps::model()->findByPk($id);

		// Modeli güncelleyin
		if ($model !== null) {
			
						// Önce belirli bir maps_id'ye ait verileri çekin
			$mapsId = 1; // Silinecek maps_id'yi burada belirtin, örneğin 1.
			$imagesToDelete = MapsImages::model()->findAllByAttributes(array('maps_id' => $id));

			// Ardından, çekilen verileri silebilirsiniz
			foreach ($imagesToDelete as $image) {
				// İlgili dosyayı fiziksel olarak silebilirsiniz, eğer istiyorsanız
				  $filePath = Yii::app()->basePath. $image->img;
					// Dosyanın var olup olmadığını kontrol et
					if (file_exists($filePath)) {
						// Dosyayı sil
						unlink($filePath);
					}
				// Veritabanından silme işlemi
				$image->delete();
			}

			// Alternatif olarak, tek bir sorgu kullanarak da silebilirsiniz
			// MapsImages::model()->deleteAllByAttributes(array('maps_id' => $mapsId));




			$images=json_decode($img,true);
			for($i=0;$i<count($images);$i++)
			{
				list($type, $data) = explode(';', $images[$i]);
			list(, $data)      = explode(',', $data);
			$imageData = base64_decode($data);

			// Resmi bir dosyaya kaydedin (örnek olarak "uploads" klasörüne kaydediyoruz).
			$fileName = uniqid().'_'.time().'_'.$i . '.png'; // Eşsiz bir dosya adı oluşturun.
			$filePath = 'uploads/' . $fileName; // Kaydedilecek klasörü belirtin.

			file_put_contents($filePath, $imageData);
			$url=Yii::app()->baseUrl . '/' . $filePath;
			
				$img=new MapsImages();
				$img->img=$url;
				$img->maps_id=$id;
				$img->save();
			}
			// Veriyi base64'den çıkarın.
			
			
			
			$model->points = $points;
			if ($model->save()) {
				echo json_encode(['response' => 'Başarılı', 'status' => 200]);
				return;
			}
		}

		header('HTTP/1.1 500 Internal Server Error');
		echo json_encode(['response' => 'Başarısız', 'status' => 500]);
		return;
	}


	
	public function actionMapidlist()
	{
		// CORS başlıklarını ekleyin
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type');

		// POST isteğiyle gelen verileri alın
		$id = Yii::app()->request->getPost('id');

		// Gerekli kontrolleri yapın
		if ($id === null) {
			header('HTTP/1.1 400 Bad Request');
			echo json_encode(['response' => 'Eksik veya hatalı parametre', 'status' => 400]);
			return;
		}

		// Modeli bulun
		$model = Maps::model()->findByPk($id);

		// Modeli güncelleyin
		if ($model !== null) {
			echo json_encode(['response' => json_decode($model->points,true), 'status' => 200]);
			exit;
		}

		header('HTTP/1.1 500 Internal Server Error');
		echo json_encode(['response' => 'Başarısız', 'status' => 500]);
		return;
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionMonitors()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('monitors',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionHeatmap()
	{
    
    $this->layout = false;
$this->render('heatmap');

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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
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
