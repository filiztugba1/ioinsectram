<?php

class CronController extends Controller
{
	public function actionIndex()
	{
		$this->layout='login';
		$this->render('index');
	}

	public function actionCustomermonthly()
	{
		$this->render('customermonthly');
	}
	public function actionDocumentfinishdate()
	{
		$this->render('documentfinishdate');
	}
	public function actionAtananuygunsuzluk()
	{
		$this->render('atananuygunsuzluk');
	}
	public function actionBilgilendirme()
	{
		$this->render('bilgilendirme');
	}
	public function actionRaporcron(){

		echo "ok";
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
