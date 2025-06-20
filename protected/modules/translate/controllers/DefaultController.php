<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{		
		Yii::app()->controller->module->language->createtagfiles();
		//$this->render('index');
	}
}