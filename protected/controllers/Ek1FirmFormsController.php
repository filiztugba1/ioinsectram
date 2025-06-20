<?php

class Ek1FirmFormsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionDefaultforms()
	{
		$ek1=Ek1Forms::model()->find(array('condition'=>'id='.intval($_GET['id'])));
	
		$ek2=str_replace("[", "", $ek1->json_data);
		$ek2=str_replace("]", "",$ek2);
		$ek1Arr= explode(',',$ek2);
		
		$arr=[];
			if(count($ek1Arr)!=0 && $ek1Arr[0]!='')
			{
				for($i=0;$i<count($ek1Arr);$i++)
				{
					$ek1forms=Ek1Items::model()->findAll(array('condition'=>'id in ('.$ek1Arr[$i].')'));
					foreach($ek1forms as $ek1form)
					{
						array_push($arr,["id"=>$ek1form->id,"name"=>$ek1form->name]);
					}
				}

			}
			echo json_encode($arr);
			exit;
	}
	
	public function actionCreate()
	{
		$ek1form=new Ek1FirmForms();
		$ek1form->ek1_form_id=intval($_POST['ek1firmforms']['formname']);
		$ek1form->defaults_json_data=json_encode($_POST['ek1firmforms']['defaultform']);
		$ek1form->firm_id=intval($_POST['ek1firmforms']['firmid']);
		$ek1form->firm_branch_id=intval($_POST['ek1firmforms']['branchid']);
		$ek1form->save();
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($ek1form,t('Create Success!'),array('index'));
	}

	public function actionUpdate()
	{
		
		$ek1form=Ek1FirmForms::model()->find(array('condition'=>'id='.intval($_POST['ek1firmforms']['id'])));
	
		$ek1form->ek1_form_id=intval($_POST['ek1firmforms']['formname']);
		$ek1form->defaults_json_data=json_encode($_POST['ek1firmforms']['defaultform']);
		$ek1form->firm_id=intval($_POST['ek1firmforms']['firmid']);
		$ek1form->firm_branch_id=intval($_POST['ek1firmforms']['branchid']);
		$ek1form->save();
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($ek1form,t('Update Success!'),array('index'));
	}
	public function actionDelete()
	{
		$ek1form=Ek1FirmForms::model()->deleteAll(array('condition'=>'id='.intval($_POST['ek1firmforms']['id'])));
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($ek1form,t('Delete Success!'),array('index'));
	}
	
	public function actionEk1forms()
	{
		$this->render('ek1_forms');
	}
	
	public function actionEk1formcreate()
	{
		
		$ek2=str_replace("sira[]=", "", $_POST['ek1forms']['json_data']);
		$ek2=explode('&',$ek2);
		
		$ek1form=new Ek1Forms();
		$ek1form->name=$_POST['ek1forms']['name'];
		$ek1form->json_data=json_encode($ek2);
		$ek1form->is_active=1;
		$ek1form->save();
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($ek1form,t('Create Success!'),array('ek1forms'));
	}
	
	public function actionEk1formupdate()
	{
		$ek2=str_replace("sira[]=", "", $_POST['ek1forms']['json_data']);
		$ek2=explode('&',$ek2);
	
		$ek1form=Ek1Forms::model()->find(array('condition'=>'id='.intval($_POST['ek1forms']['id'])));
		$ek1form->name=$_POST['ek1forms']['name'];
		$ek1form->json_data=json_encode($ek2);
		$ek1form->is_active=$_POST['ek1forms']['is_active'];
		$ek1form->save();
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($ek1form,t('Update Success!'),array('ek1forms'));
	}
	
	public function actionEk1formdelete()
	{
		$ek1form=Ek1Forms::model()->deleteAll(array('condition'=>'id='.intval($_POST['ek1forms']['id'])));
		Logs::model()->logsaction();
		Yii::app()->SetFlashes->add($ek1form,t('Delete Success!'),array('ek1forms'));
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