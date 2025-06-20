<?php

class MobileController extends Controller
{
	public $layout='mobile';

	public function actionIndex()
	{
		//$this->layout='mobile';
		$this->render('index');
	}

	public function actionIndex1()
	{
		$this->layout='';
		$this->render('index1');
	}
		public function actionNc()
	{
		//$this->layout='mobile';
		$this->render('nc');
	}
	
		public function actionJobdetail()
	{
		//$this->layout='mobile';
		$this->render('jobdetail');
	}

		public function actionStartjob()
	{
		//$this->layout='mobile';
		$this->render('startjob');
	}
		public function actionMonitoric()
	{
		//$this->layout='mobile';
		$this->render('monitoric');
	}

	public function actionWorkorderdegistir(){
		$model=Workorder::model()->findByPk($_POST["id"]);
		$model->status=3;


		$dtime = DateTime::createFromFormat("d/m/Y H:i", $_POST["realstarttime"]);
		$timestamp1 = $dtime->getTimestamp();

		$dtime = DateTime::createFromFormat("d/m/Y H:i", $_POST["realendtime"]);
		$timestamp2 = $dtime->getTimestamp();
	

		$model->realstarttime=$timestamp1;
		$model->realendtime=$timestamp2;
		$model->executiondate=$timestamp2;
		if($model->save())
		{
			echo "success";
		}
		else{
			echo "error";
		}
	}

	public function actionWorkordersaatleri(){
		$model=Workorder::model()->findByPk($_GET["id"]);
	
		$dtime = DateTime::createFromFormat("d/m/Y H:i", $_POST["realstarttime3"]);
		$timestamp1 = $dtime->getTimestamp();

		$dtime = DateTime::createFromFormat("d/m/Y H:i", $_POST["realendtime3"]);
		$timestamp2 = $dtime->getTimestamp();
	

		$model->realstarttime=$timestamp1;
		$model->realendtime=$timestamp2;

		$model->executiondate=$timestamp2;
		if($model->save())
		{
			$mobileworkorderdata=Mobileworkorderdata::model()->findAll(array('condition'=>'workorderid='.$_GET["id"]));
			foreach($mobileworkorderdata as $mobileworkorderdatax)
			{
				$mobileworkorderdatak=Mobileworkorderdata::model()->find(array('condition'=>'id='.$mobileworkorderdatax->id));
				$mobileworkorderdatak->createdtime=$timestamp1;
				$mobileworkorderdatak->openedtimestart=$timestamp1;
				$mobileworkorderdatak->openedtimeend=$timestamp2;
				$mobileworkorderdatak->save();
			}

			$mobileworkordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$_GET["id"]));
			foreach($mobileworkordermonitors as $mobileworkordermonitorsx)
			{
				$mobileworkordermonitorsk=Mobileworkordermonitors::model()->find(array('condition'=>'id='.$mobileworkordermonitorsx->id));
				$mobileworkordermonitorsk->checkdate=$timestamp1;
				$mobileworkordermonitorsk->save();
			}
			
			echo "success";
		}
		else{
			echo "error";
		}
	}

	public function actionKontrol(){
		$model=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$_GET["id"]));
		$durum=false;
		foreach($model as $modelx)
		{
			if($modelx->checkdate==0)
			{
				$durum=true;
				break;
			}
		}

		if($durum==false)
		{
			echo "success";
		}
		else{
			echo "error";
		}

	}


		public function actionStopjob($id=0)
	{
			$workid=$_GET['id'];

$wo=Workorder::model()->findbypk($workid);
$wo->status=2;
$wo->update();
		//$this->layout='mobile';
		$this->render('index');
	}
	
		public function actionMonitorkaydet($id=0)
	{
			foreach($_POST as $key => $value) {
			  $data=Mobileworkorderdata::model()->findbypk($key);
			  if ($data)
				{
				  $data->value=$value;
				  $data->saverid=Yii::app()->user->id;
				  $data->createdtime=time();
				  $data->update();
				  $ss=Mobileworkordermonitors::model()->find(array('condition'=>'workorderid='. $data->workorderid.' and monitorid='.$data->monitorid));
					 $ss->checkdate=time();
					 $ss->update();
				}
}
			
		//$this->layout='mobile';
		
		 $this->redirect('/mobile/startjob/'.$_GET['workorderid'].'?sp=1');
	}


	public function actionUpdatekntrledilmedi()
	{

		if(isset($_POST['id']))
		{
			
			$modelD=Mobileworkorderdata::model()->findByPk($_POST['id']);
			$check=Mobileworkorderdata::model()->find(array('condition'=>'petid=49 and workorderid='.$modelD->workorderid.'  and monitorid='.$modelD->monitorid." and value=".$_POST['tur']));
			if($check)
			{
				echo "success";
			}
			else
			{
				$modelMon=Mobileworkordermonitors::model()->findByPk($modelD->mobileworkordermonitorsid);
				$modelMon->checkdate=$modelD->openedtimestart;
				$modelMon->saverid=Yii::app()->user->id;
				$modelMon->save();

				$DurumluData=new Mobileworkorderdata;
				$DurumluData->mobileworkordermonitorsid=$modelD->mobileworkordermonitorsid;
				$DurumluData->workorderid=$modelD->workorderid;
				$DurumluData->monitorid=$modelD->monitorid;
				$DurumluData->monitortype=$modelD->monitortype;
				$DurumluData->pettype=0;	
				$DurumluData->petid=49;
				$DurumluData->value=$_POST['tur']; // 0-Normal 1- Lost 2- Broken 3- Unreacheble
				$DurumluData->saverid=Yii::app()->user->id;
				$DurumluData->createdtime=$modelD->openedtimestart;
				$DurumluData->firmid=$modelD->firmid;
				$DurumluData->firmbranchid=$modelD->firmbranchid;	
				$DurumluData->clientid=$modelD->clientid;
				$DurumluData->clientbranchid=$modelD->clientbranchid;
				$DurumluData->departmentid=$modelD->departmentid;
				$DurumluData->subdepartmentid=$modelD->subdepartmentid;
				$DurumluData->openedtimestart=$modelD->openedtimestart;
				$DurumluData->openedtimeend=$modelD->openedtimestart;
				$DurumluData->isproduct=1;

				
				if($DurumluData->save()){
					
					echo "success";
				}
				else{
					print_r($DurumluData->getErrors());
				}
				//$model=Mobileworkordermonitors::
			}
			
		}
		
	}

	public function actionUpdatedata()
    {
			// Wdata1[id]: 498      mobileworkorderdata1[value]: 2
			$date=$_POST["checkdate"];
			$date = str_replace('/', '-', $date);
			$yenitarih=strtotime($date);
			
		for ($i=1;$i<=$_POST["countt"];$i++){
	
			$modelD=Mobileworkorderdata::model()->findByPk($_POST["Wdata".$i]);


			if($modelD->petid==49 && $_POST["mobileworkorderdata".$i]==0)
			{
				$modelD->delete();
			}
			else{
				//print_r($modelD); echo "<br>";echo "<br>";echo "<br>";echo "<br>";
				$modelM=Mobileworkordermonitors::model()->findByPk($modelD->mobileworkordermonitorsid);
				$modelM->checkdate=$yenitarih;
				$modelM->saverid=Yii::app()->user->id;
				$modelM->update();
				///
				$modelD->createdtime=$yenitarih;
				$modelD->saverid=Yii::app()->user->id;
				$modelD->openedtimeend=$yenitarih;
				$modelD->value=$_POST["mobileworkorderdata".$i];
				$modelD->update();
			}
			
		}

		$mobileworkordatas=Mobileworkorderdata::model()->findall(array('condition'=>'mobileworkordermonitorsid='.$modelM->id));
		$say=0;
		$veriler="";
		$goster="";
		$monitorno=0;
		foreach ($mobileworkordatas as $mobileworkordata){
			$say++;
			$monitorno=$modelM->monitorno;
			$pet=Pets::model()->findByPk($mobileworkordata->petid);
			if($mobileworkordata->petid==49){
				if($mobileworkordata->value==1){ $val="Lost";}
				if($mobileworkordata->value==2){ $val="Broken";}
				if($mobileworkordata->value==3){ $val="Unreacheble";}
			}
			else{
				$val=$mobileworkordata->value;
			}

			$veriler =$veriler.  'data-id'.$say.'="'.$mobileworkordata->id.'"
						  data-petid'.$say.'="'.$mobileworkordata->petid.'"
						  data-petname'.$say.'="'.$pet->name.'"  
						  data-value'.$say.'="'.$val.'"';
			$goster= $goster .' '. $pet->name. ' : '.$mobileworkordata->value.' <br>';
		}

		

		echo '<button style="margin:10px;width:62px;height:62px;" id="'.$_POST['moni'].'" type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="'.$goster.'" data-html="true" '.$veriler.' data-count='.$say.' onclick="openmodal(this)">'.$monitorno.'</button>';

       /* if(isset($_POST["mobileworkorderdata"]["id"]))
        {

            $id=$_POST["mobileworkorderdata"]["id"];
            
            
            
            
        }
        else
        {
            $this->redirect("/workorder");
        }*/
		
    }

    public function actionDeletedata()
    {
        if(isset($_POST["mobileworkorderdata"]["id"]))
        {
            $id=$_POST["mobileworkorderdata"]["id"];
            $model=Mobileworkorderdata::model()->findByPk($id);
            $monitorid=$model->mobileworkordermonitorsid;
            $model->delete();
            $this->redirect("/workorder/data?id=".$monitorid);
        }

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