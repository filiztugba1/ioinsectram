<?php

class WorkorderperiyodikController extends Controller
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
				'actions'=>array('index','view','workorder','save','departmentdiv','subdepartment','monitoringpointno','addsave','departmentvisited','copy','firmbranch'
				,'staffteam','monitor','data','route','visittype','client','visitedupdate','visiteddelete','change','staff','routeclient','teamcolor','staffcolor','treatmenttype','clientb','workorderlist','toplumonitor','toplumonitoryukle'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','Updatep'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','deleteperiyodik'),
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
		$this->render('application.views.workorder.view',array(
			'model'=>$this->loadModel($id),
		));
	}



	public function karakter($metin)
	{

		$turkce=array('"',"'");
		$duzgun=array(" "," ");
		$metin=str_replace($turkce,$duzgun,$metin);
		return strtolower($metin);


	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
  /*
  public function actionCreate()
	{
		$model=new Workorder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workorder']))
		{

			$model->attributes=$_POST['Workorder'];
			$model->staffid=Workorder::model()->msplit($_POST['Workorder']['staffid']);
			$model->date=date('Y-m-d',strtotime($_POST['Workorder']['date']));
			$model->status=0;
  
			
			$model->isperiod=$_POST['Workorderperiod']['isperiod'];

			$model->todo=$this->karakter($_POST['Workorder']['todo']);

			//randomcode and agein control

			$code=Workorder::model()->randomcodeperiod();

			//randomcode and agein control
			$model->code=$code;
		
			if(isset($_POST['Workorder']['conformity_id']) && $_POST['Workorder']['conformity_id']!='')
			{
         $cn=Conformity::model()->find(array('condition'=>'numberid="'.$_POST['Workorder']['conformity_id'].'"'));               
			     $model->conformity_id=$cn->id;
			}
           
			if($_POST['Workorderperiod']['isperiod']!=1)
			{
				$model->code="";
			}
			if($model->save())
			{
				if($_POST['Workorder']['mavailable']==0 && $_POST['Workorder']['treatmenttypeid']!='')
				{
					$visited=new Departmentvisited;
					$visited->workorderid=$model->id;
					$visited->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
					$visited->save();
				}

				if($_POST['Workorderperiod']['isperiod']==1)
				{
					$period=new Workorderperiod;
					$period->startfinishdate=$_POST['Workorderperiod']['startfinishdate'];
					$period->againnumber=$_POST['Workorderperiod']['againnumber'];
					$period->dayweekmonthyear=$_POST['Workorderperiod']['dayweekmonthyear'];
					$period->code=$code;
					if($_POST['Workorderperiod']['dayweekmonthyear']=='week')
					{
						$period->day=Workorder::model()->msplit($_POST['Workorderperiod']['day']);
						$period->monthday='';
					}
					else if($_POST['Workorderperiod']['dayweekmonthyear']=='month')
					{
						$period->day="";
						$period->monthday=$_POST['Workorderperiod']['monthday'];
					}

					if($period->save())
					{

						Workorder::model()->periodcopy($code,$model->id);
					}


					$copy=Workorder::model()->find(array('condition'=>'id='.$model->id));
					$copy->delete();

					Workorder::model()->monitorupdate($model->id);


					//loglama
					Logs::model()->logsaction();
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder'));

				}

			}
      else
      {
        var_dump($model->getErrors());
        exit;
      }

			Workorder::model()->monitorupdate($model->id);
			//loglama
			Logs::model()->logsaction();
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->id));
		}

		$this->render('application.views.workorder.create',array(
			'model'=>$model,
		));

	}
	*/
  
	public function actionCreate()
	{
		try
		{
		$model=new Workorder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workorder']))
		{

			$model->attributes=$_POST['Workorder'];
			$model->staffid=Workorder::model()->msplit($_POST['Workorder']['staffid']);
			$model->date=date('Y-m-d',strtotime($_POST['Workorder']['date']));
			$model->status=0;
			$model->isperiod=$_POST['Workorderperiod']['isperiod'];
			$model->special_notes=$_POST['Workorder']['special_notes'];

			$model->todo=$this->karakter($_POST['Workorder']['todo']);

			//randomcode and agein control

			$code=Workorder::model()->randomcodeperiod();

			//randomcode and agein control
			$model->code=$code;

			if(intval($_POST['Workorderperiod']['isperiod'])!=1)
			{
				$model->code="";
			}
	
			if($model->save())
			{
				
				if($_POST['Workorder']['mavailable']==0 && $_POST['Workorder']['treatmenttypeid']!='')
				{
					$visited=new Departmentvisited;
					$visited->workorderid=$model->id;
					$visited->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
					$visited->save();
				}

				if($_POST['Workorderperiod']['isperiod']==1)
				{
					$period=new Workorderperiod;
					$period->startfinishdate=$_POST['Workorderperiod']['startfinishdate'];
					$period->againnumber=$_POST['Workorderperiod']['againnumber'];
					$period->dayweekmonthyear=$_POST['Workorderperiod']['dayweekmonthyear'];
					$period->code=$code;
					if($_POST['Workorderperiod']['dayweekmonthyear']=='week')
					{
						$period->day=Workorder::model()->msplit($_POST['Workorderperiod']['day']);
						$period->monthday='';
					}
					else if($_POST['Workorderperiod']['dayweekmonthyear']=='month')
					{
						$period->day="";
						$period->monthday=$_POST['Workorderperiod']['monthday'];
					}

					if($period->save())
					{

						Workorder::model()->periodcopy($code,$model->id);
					}


					$copy=Workorder::model()->find(array('condition'=>'id='.$model->id));
					$copy->delete();

					Workorder::model()->monitorupdate($model->id);
				
						

					//loglama
					Logs::model()->logsaction();
					$codeFirstOldDefault = Workorder::model()->find(array(
							'condition' => 'code=:code',
							'params' => array(':code' => $code),
							'order' => 'id DESC' // veya 'id ASC' neye göre sıralamak istiyorsan
						));
					
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$codeFirstOldDefault->id));

				}

			}
			
  if ($model->visittypeid==62 || $model->visittypeid==31 || $model->visittypeid==26){
           Workorder::model()->addmonitortotifollow($model->id);
       
      }else{
        	Workorder::model()->monitorupdate($model->id);       
      }
      
			//Workorder::model()->monitorupdate($model->id);
			//loglama
			Logs::model()->logsaction();
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->id));
		}

		$this->render('application.views.workorder.create',array(
			'model'=>$model,
		));
		
		}catch(Exception $err) {
			Yii::app()->SetFlashes->add('error', $err->getMessage(),array('workorder/workorder?date='.$_GET['date']));
		}

	}
  






	public function actionCopy()
	{


		 $months=$_POST['Workorder']['month'];
		 $year=$_POST['Workorder']['year'];


		  $dstart=$_POST['Workorder']['dateyear'].'-'.$_POST['Workorder']['datemonth'].'-01';
		 $gun=cal_days_in_month(CAL_GREGORIAN, $_POST['Workorder']['datemonth'], $_POST['Workorder']['dateyear']);

		  $dfinish=$_POST['Workorder']['dateyear'].'-'.$_POST['Workorder']['datemonth'].'-'.$gun;





		$copy=Workorder::model()->findAll(array('condition'=>'branchid='.$_POST['Workorder']['branchid'].' and date BETWEEN "'.$dstart.'"  AND "'.$dfinish.'" and and status="0"'));




		$copydate='';

		for($i=0;$i<count($months);$i++)
		{
			foreach($copy as $copyx)
			{
				$start = new DateTime(Workorder::model()->datecopy($copyx->date,$months[$i],$year));

				$isdate=Workorder::model()->findAll(array('condition'=>'staffid="'.$copyx->staffid.'" and todo="'.$copyx->todo.'" and clientid='.$copyx->clientid.' and routeid='.$copyx->routeid.' and visittypeid='.$copyx->visittypeid.' and start_time="'.$copyx->start_time.'" and finish_time="'.$copyx->finish_time.'" and teamstaffid='.$copyx->teamstaffid.' and branchid='.$_POST['Workorder']['branchid'].' and date="'.$start->format('m/d/Y').'" and status="0"'));



				if(count($isdate)>0)
				{
					if($copydate=='')
					{
						$copydate=$start->format('Y-d-m').'-no,';
					}
					else
					{
						$copydate=$copydate.$start->format('Y-d-m').'-no,';
					}
				}
				else
				{
				$model=new Workorder;
				$model->date=$start->format('Y-m-d');
				$model->start_time=$copyx->start_time;
				$model->finish_time=$copyx->finish_time;
				$model->teamstaffid=$copyx->teamstaffid;
				$model->visittypeid=$copyx->visittypeid;
				$model->routeid=$copyx->routeid;
				$model->clientid=$copyx->clientid;
				$model->status=0;
				$model->todo=$copyx->todo;
				$model->staffid=$copyx->staffid;
				//$model->departmentid=$copyx->departmentid;
				//$model->subdepartmentid=$copyx->subdepartmentid;
				//$model->monitoringpointid=$copyx->monitoringpointid;
				//$model->treatmenttypeid=$copyx->treatmenttypeid;
				//$model->monitoringpoint=$copyx->monitoringpoint;
				$model->firmid=$copyx->firmid;
				$model->branchid=$copyx->branchid;
				if ($model->save())
				{
						$visit=Departmentvisited::model()->find(array('condition'=>'workorderid='.$copyx->id));
						$copyvisit=new Departmentvisited;
						$copyvisit->treatmenttypeid=$visit->treatmenttypeid;
						$copyvisit->monitoringtype=$visit->monitoringtype;
						$copyvisit->workorderid=$model->id;
						$copyvisit->departmentid=$visit->departmentid;
						$copyvisit->subdepartmentid=$visit->subdepartmentid;
						$copyvisit->monitoringno=$visit->monitoringno;
						$copyvisit->mavailable=$visit->mavailable;
						if (!$copyvisit->save()){
							var_dump($copyvisit->geterrors());
							exit;
						}



				}

					if($copydate=='')
					{
						$copydate=$start->format('Y-d-m').'-ok,';
					}
					else
					{
						$copydate=$copydate.$start->format('Y-d-m').'-ok,';
					}
				}


			}



		}

		echo $copydate;


	}

	public function actionChange()
	{
		$model=Workorder::model()->find(array('condition'=>'id='.$_GET['id']));
		if(isset($_GET['date']) && $_GET['date']!="")
			{
				$data=explode('T',$_GET['date']);
			}
		$model->date=$data[0];
		if($model->update())
		{
			echo "ok";
		}
		else
		{
			echo "no";
		}
		exit;
	}




	public function actionAddsave()
	{

		$ax= User::model()->userobjecty('');


		if($_POST['Workorder']['subdepartmentid']==""){$_POST['Workorder']['subdepartmentid']=0;}
		$monitorno=implode(",", $_POST['Workorder']['monitoringno']);
		$where='';
		if($_POST['Workorder']['departmentid']!==null && $_POST['Workorder']['departmentid']!=='' && $_POST['Workorder']['departmentid']!==0)
		{
			$where.=' and departmentid="'.implode(',',$_POST['Workorder']['departmentid']).'"';
		}
		if($_POST['Workorder']['subdepartmentid']!==null && $_POST['Workorder']['subdepartmentid']!=='' && $_POST['Workorder']['subdepartmentid']!==0)
		{
			$where.=' and subdepartmentid="'.implode(',',$_POST['Workorder']['subdepartmentid']).'"';
		}
		if($_POST['Workorder']['monitoringtype']!==null && $_POST['Workorder']['monitoringtype']!=='' && $_POST['Workorder']['monitoringtype']!==0)
		{
			
			if(gettype($_POST['Workorder']['monitoringtype'])=='array')
			{
				$where.=' and monitoringtype in ('.implode($_POST['Workorder']['monitoringtype']).')';
			}
			else
			{
				$where.=' and monitoringtype='.$_POST['Workorder']['monitoringtype'];
			}
		}
		if($_POST['Workorder']['monitoringno']!==null && $_POST['Workorder']['monitoringno']!=='' && $_POST['Workorder']['monitoringno']!==0)
		{
			$where.=' and monitoringno in ('.$monitorno.')';
		}
		
		$visited=Departmentvisited::model()->find(array(
								   'condition'=>'workorderid='.$_POST['Workorder']['workorderid'].' '.$where
													)
									);
	

		if(!$visited || $ax->id=1)
		{

			$model=new Departmentvisited;
			$model->mavailable=$_POST['Workorder']['mavailable'];
			$model->workorderid=$_POST['Workorder']['workorderid'];
			$model->departmentid=Workorder::model()->msplit($_POST['Workorder']['departmentid']);
			$model->subdepartmentid=Workorder::model()->msplit($_POST['Workorder']['subdepartmentid']);
			$model->monitoringtype=Workorder::model()->msplit($_POST['Workorder']['monitoringtype']);
			$model->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
			$model->monitoringno=Workorder::model()->msplit($_POST['Workorder']['monitoringno']);
		  $model->treatmenttypeid="";
			/*if($_POST['Workorder']['mavailable']==0)
			{
					$model->departmentid="";
					$model->subdepartmentid="";
					$model->monitoringtype="";
					$model->monitoringno="";
			}
			if($_POST['Workorder']['mavailable']==1)
			{
					$model->treatmenttypeid="";

			}*/

			 $updateperiodtype=$_POST['workorderisperiod']['updateperiod'];

			if ($model->save())
			{


					if($updateperiodtype!=1 && $updateperiodtype!='')
					{
						// workorder perioda gore code günceleyip silme
						$workorder=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						//Workorder::model()->codeupdate($model->workorderid,$updateperiodtype);

						$wcode=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						 $code=$wcode->code;

            
            
					/*	$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));


						//workordera period code ekleme başlangıç
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;*/

						/*if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$period->startfinishdate=date('m/d/Y',strtotime($workorder->date)).'-'.explode('-',$workorderperiod->startfinishdate)[1];
							$workorderperiod->startfinishdate=explode('-',$workorderperiod->startfinishdate)[0].'-'.date('m/d/Y',strtotime($workorder->date));
							$workorderperiod->save();
						}*/
/*
						$period->againnumber=$workorderperiod->againnumber;
						$period->dayweekmonthyear=$workorderperiod->dayweekmonthyear;
						$period->code=$code;
						$period->day=$workorderperiod->day;
						$period->monthday=$workorderperiod->monthday;
*/
					/*	if($period->save()) //eger workorder period eklendiyse  verilen periodu kopyalama
						{
							//Workorder::model()->periodcopy($code,$model->workorderid,$workorder->code);
						}
*/

					/*	if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

						

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}
              	Workorder::model()->deleteAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));
						}*/

						if($updateperiodtype==2)// eger daha once kopyalanmış bir veri ve guncellenecekse periodu silinecekler
						{
							Workorder::model()->monitorupdate($model->workorderid);
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$model->workorderid.' and code<>"" and status="0" and code="'.$workorder->code.'"'));
					
							foreach($wdelete as $wdeletex)
							{
								$modeldepx=new Departmentvisited;
								$modeldepx->mavailable=$_POST['Workorder']['mavailable'];
								$modeldepx->workorderid=$wdeletex->id;
								$modeldepx->departmentid=Workorder::model()->msplit($_POST['Workorder']['departmentid']);
								$modeldepx->subdepartmentid=Workorder::model()->msplit($_POST['Workorder']['subdepartmentid']);
								$modeldepx->monitoringtype=Workorder::model()->msplit($_POST['Workorder']['monitoringtype']);
								$modeldepx->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
								$modeldepx->monitoringno=Workorder::model()->msplit($_POST['Workorder']['monitoringno']);
								$modeldepx->treatmenttypeid="";
								$modeldepx->save();
                
                /*	$departmentvisitedcopy=Departmentvisited::model()->findAll(array('condition'=>'workorderid='.$model->workorderid));
						foreach($departmentvisitedcopy as $vcopy)
						{
							$dvisit=new Departmentvisited;
							$dvisit->treatmenttypeid=$vcopy->treatmenttypeid;
							$dvisit->monitoringtype=$vcopy->monitoringtype;
							$dvisit->workorderid=$wdeletex->id;
							$dvisit->departmentid=$vcopy->departmentid;
							$dvisit->subdepartmentid=$vcopy->subdepartmentid;
							$dvisit->monitoringno=$vcopy->monitoringno;
							$dvisit->mavailable=$vcopy->mavailable;
							$dvisit->save();
              
						}*/

								Workorder::model()->monitorupdate($wdeletex->id);
							}
	/*	Workorder::model()->deleteAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'"'));
							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();*/
						}


						/*$deletevisit=Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$model->workorderid));
						$copy=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						$copy->delete();*/

					//	Workorder::model()->monitorupdate($model->workorderid);

						//loglama
						Logs::model()->logsaction();
						/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder'));

					}else{
            	Workorder::model()->monitorupdate($model->workorderid);
          }




				/*perioda gore ekleyip sileme finish*/


////////////////

/////////////////////

			}

		
			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->workorderid));
		}

		else
		{
			Yii::app()->SetFlashes->add(0,t('You have already added this data!'),array('/workorder/workorder?id='.$_POST['Workorder']['workorderid']));
		}


	}




	public function actionDepartmentdiv()
	{
		$selectedDepartmentId = null;
		
		// Ziyaret kontrolü
		if (isset($_GET['visit']) && !empty($_GET['visit'])) {
			$visit = Departmentvisited::model()->find(array(
				'condition' => 'id = :visitId',
				'params' => array(':visitId' => $_GET['visit'])
			));
			if ($visit) {
				$selectedDepartmentId = $visit->departmentid;
			}
		}

		// Departmanları getir
		$departments = Departments::model()->findAll(array(
			'condition' => 'parentid = 0 AND clientid = :clientId',
			'params' => array(':clientId' => $_GET['id'])
		));

		// HTML çıktısı
		echo '<option value="0">All</option>';
		
		foreach ($departments as $department) {
			$selected = ($selectedDepartmentId == $department->id) ? 'selected' : '';
			echo '<option value="' . $department->id . '" ' . $selected . '>' 
				. htmlspecialchars($department->name) . '</option>';
		}
	}


	/*
	public function actionSubdepartment()
	{
		// Alt departmanları getir
		$departments = Departments::model()->findAll(array(
			'condition' => 'parentid = :parentId',
			'params' => array(':parentId' => $_GET['id'])
		));

		// HTML çıktısı
		echo '<option value="0">All</option>';
		
		foreach ($departments as $department) {
			echo '<option value="' . $department->id . '">' 
				. htmlspecialchars($department->name) . '</option>';
		}
	}
	*/


	public function actionMonitoringpointno()
	{
			if($_GET['cid']!=0 && $_GET['cid']!='')
			{
			$veri="clientid=".$_GET['cid'];
			}

			if($_GET['d']!=0 && $_GET['d']!='')
			{
				$x=Workorder::model()->serarchsplit('dapartmentid',$_GET['d']);
				$veri=$veri." and (".$x.")";
			}

			if($_GET['sd']!=0 && $_GET['sd']!='')
			{
				$x=Workorder::model()->serarchsplit('subid',$_GET['sd']);
				$veri=$veri." and (".$x.")";
			}

			if($_GET['mpt']!=0 && $_GET['mpt']!='')
			{
				$x=Workorder::model()->serarchsplit('mtypeid',$_GET['mpt']);
				$veri=$veri." and (".$x.")";
			}


			if($veri!='')
			{
				$veri=$veri." and active=1";
			}

				if($veri=='')
			{
				$veri="active=1";
			}





				$no=Monitoring::model()->findAll(array(
								   'condition'=>$veri,
									));



				foreach($no as $nox)
				{?>

					<div class="col-xl-2 col-lg-2 col-md-2 com-sm-3 mb-1 skin skin-square">
					<fieldset>
                          <input type="checkbox" id="input-12" value="<?=$nox->id;?>" name="Workorder[monitoringno][]" checked>
                          <label for="input-12"><?=$nox->mno;?></label>
						 <!-- <label><img src="https://insectram.io/qrcode/qrcode?txt=<?=$nox->id;?>&size=5"></label> -->
                    </fieldset>
					</div>


				<?}

				?>
					<script>
						$(document).ready(function (e) {
						   $('.skin-square input').iCheck({
							checkboxClass: 'icheckbox_square-red',
							radioClass: 'iradio_square-red',
						});
						});
					</script>
				<?




	}


	public function actionVisitedupdate()
	{
			$model=Departmentvisited::model()->find(array('condition'=>'id='.$_GET['id']));
			$model->mavailable=$_POST['Workorder']['mavailable'];
			$model->workorderid=$_POST['Workorder']['workorderid'];
			$model->departmentid=Workorder::model()->msplit($_POST['Workorder']['departmentid']);
			$model->subdepartmentid=Workorder::model()->msplit($_POST['Workorder']['subdepartmentid']);
			$model->monitoringtype=Workorder::model()->msplit($_POST['Workorder']['monitoringtype']);
			$model->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
			$model->monitoringno=Workorder::model()->msplit($_POST['Workorder']['monitoringno']);
			if($model->save())
			{
				 $updateperiodtype=$_POST['workorderisperiod']['updateperiod'];
					if($updateperiodtype!=1 && $updateperiodtype!='')
					{

							// workorder perioda gore code günceleyip silme
							$workorder=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
							Workorder::model()->codeupdate($model->workorderid,$updateperiodtype);

							$wcode=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
							 $code=$wcode->code;

							$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));


						//workordera period code ekleme başlangıç
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$period->startfinishdate=date('m/d/Y',strtotime($workorder->date)).'-'.explode('-',$workorderperiod->startfinishdate)[1];
							$workorderperiod->startfinishdate=explode('-',$workorderperiod->startfinishdate)[0].'-'.date('m/d/Y',strtotime($workorder->date));
							$workorderperiod->save();

						}

						$period->againnumber=$workorderperiod->againnumber;
						$period->dayweekmonthyear=$workorderperiod->dayweekmonthyear;
						$period->code=$code;
						$period->day=$workorderperiod->day;
						$period->monthday=$workorderperiod->monthday;

						if($period->save()) //eger workorder period eklendiyse  verilen periodu kopyalama
						{
							Workorder::model()->periodcopy($code,$model->workorderid,$workorder->code);
						}


						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$wdelete=Workorder::model()->findAll(array('condition'=>'code<>"" and  id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							Workorder::model()->deleteAll(array('condition'=>'code<>"" and id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}


						}

						if($updateperiodtype==2)// eger daha once kopyalanmış bir veri ve guncellenecekse periodu silinecekler
						{
							$wdelete=Workorder::model()->findAll(array('condition'=>'code<>"" and  id!='.$model->workorderid.' and code="'.$workorder->code.'"'));

							Workorder::model()->deleteAll(array('condition'=>'code<>"" and  id!='.$model->workorderid.' and code="'.$workorder->code.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}



							$codedelete=Workorderperiod::model()->find(array('condition'=>'code<>"" and code="'.$workorder->code.'"'));
							$codedelete->delete();
						}



						$deletevisit=Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$model->workorderid));
						$copy=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						$copy->delete();

						Workorder::model()->monitorupdate($model->workorderid);

							//loglama
						Logs::model()->logsaction();
						/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));

					}

			}
			// Workorder::model()->monitorupdate($model->workorderid);

		//	Workorder::model()->monitorupdate($model->workorderid);
		$departmentvisited=Departmentvisited::model()->findByPk($_POST['Departmetvisited']['id']);
		//	$deletemonitors=Mobileworkordermonitors::model()->deleteall(array('condition'=>'workorderid='.$workorderid.' and monitorid in ('.$departmentvisited.')'));
		//	$deletemonitors1=Mobileworkorderdata::model()->deleteall(array('condition'=>'workorderid='.$workorderid.' and monitorid in ('.$departmentvisited.')'));
Yii::app()->db->createCommand('DELETE FROM mobileworkordermonitors
	INNER JOIN mobileworkorderdata ON mobileworkorderdata.mobileworkordermonitorsid=mobileworkordermonitors.id
	where mobileworkorderdata.value==0 and monitorid in ('.$departmentvisited.')')->execute();

			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->workorderid));



	}

	public function actionVisiteddelete()
	{
   
 
		$model=Departmentvisited::model()->findByPk($_POST['Departmetvisited']['id']);

     		if ($model)
		{
          $redirid=$model->workorderid;
          	$updateperiodtype=$_POST['workorderisperiod']['updateperiod'];
					if($updateperiodtype==2 && $updateperiodtype!='')
					{
            $mode='hepsi';
          }
          if ($mode=='hepsi'){
          $workorder= Workorder::model()->findByPk($model->workorderid);
    $workorders=Workorder::model()->findAll(array('condition'=>'status=0 and code<>"" and code="'.$workorder->code.'"'));
          $ids=[];
          $ids[]=0;
          foreach( $workorders as $ww ){
             $ids[]=$ww->id;
            
          }
      $visiteds=Departmentvisited::model()->findAll(array('condition'=>'monitoringno="'.$model->monitoringno.'" and `workorderid` IN ('.implode(',',$ids).')'));
	foreach ($visiteds as $delvis){
    $idt=$delvis->workorderid;
    		if($delvis->delete())
			{
						Workorder::model()->monitorupdate($idt);
      
    }
    
    
  }
        }
        else {
          		if($model->delete())
			{
						Workorder::model()->monitorupdate($id);
      
    }
        }
          
          
          
        }
    
	/*	if ($model)
		{
      
      
      
			 $id=$model->workorderid;


			if($model->delete())
			{

					$updateperiodtype=$_POST['workorderisperiod']['updateperiod'];
					if($updateperiodtype!=1 && $updateperiodtype!='')
					{

					// workorder perioda gore code günceleyip silme
					$workorder=Workorder::model()->find(array('condition'=>'id='.$id));
					Workorder::model()->codeupdate($id,$updateperiodtype);

					$wcode=Workorder::model()->find(array('condition'=>'id='.$id));
					 $code=$wcode->code;

					$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));


						//workordera period code ekleme başlangıç
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$period->startfinishdate=date('m/d/Y',strtotime($workorder->date)).'-'.explode('-',$workorderperiod->startfinishdate)[1];
							$workorderperiod->startfinishdate=explode('-',$workorderperiod->startfinishdate)[0].'-'.date('m/d/Y',strtotime($workorder->date));
							$workorderperiod->save();

						}


						$period->againnumber=$workorderperiod->againnumber;
						$period->dayweekmonthyear=$workorderperiod->dayweekmonthyear;
						$period->code=$code;
						$period->day=$workorderperiod->day;
						$period->monthday=$workorderperiod->monthday;

						if($period->save()) //eger workorder period eklendiyse  verilen periodu kopyalama
						{
							Workorder::model()->periodcopy($code,$id,$workorder->code);
						}

							if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}


						}

						if($updateperiodtype==2)// eger daha once kopyalanmış bir veri ve guncellenecekse periodu silinecekler
						{
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'"'));

							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}

							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();
						}



						$deletevisit=Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$id));
						$copy=Workorder::model()->find(array('condition'=>'id='.$id));
						$copy->delete();

						Workorder::model()->monitorupdate($id);

							Logs::model()->logsaction();
							Yii::app()->SetFlashes->add($post,t('Delete Success!'),array('/workorder'));

					}

			}
		}*/



	
		Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/workorder/workorder?id='.$redirid));

	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		$id=$_GET['id'];
		$model=$this->loadModel($id);
		$modelxxyy=$this->loadModel($id);
		$changeperiyod=intval($_POST['Workorderperiod']['isperiod']);
		$oldcode=$model->code;
		if(isset($_POST['Workorder']) || $changeperiyod==1 )
		{
			if($changeperiyod==1) //// periyot var ve ona göre bi değişiklik yapılacak
			{
				echo '1';
				$periyot=intval($_POST['Workorderisperiod']['updateperiod']);
				
				//////////// periyodik olarak silme işlemi tamamlandı //////
				///// tekrar periyodik olarak ekleme işlemine devam edilecek //////
				
					
						$oldworkorder=Workorder::model()->find(array('condition'=>'id='.$id));
						
						$model->attributes=$_POST['Workorder'];
						$model->staffid=Workorder::model()->msplit($_POST['Workorder']['staffid']);
						
						$model->status=0;
						$model->isperiod=$_POST['Workorderperiod']['isperiod'];

						$model->todo=$this->karakter($_POST['Workorder']['todo']);
						$model->special_notes=$this->karakter($_POST['Workorder']['special_notes']);
						$modelxxyy->special_notes=$this->karakter($_POST['Workorder']['special_notes']);

						//randomcode and agein control

						$code=Workorder::model()->randomcodeperiod();

						//randomcode and agein control8
						$model->code=$code;

						if($periyot==1)
						{
				echo '2';
							$model->code="";
							$model->date=date("Y-m-d", strtotime($_POST['Workorder']['date']));
						}
						if($model->save())
						{
							
				echo '3';
							if($_POST['Workorder']['mavailable']==0 && $_POST['Workorder']['treatmenttypeid']!='')
							{
								$visited=new Departmentvisited;
								$visited->workorderid=$model->id;
								$visited->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
								$visited->save();
							}

							if($_POST['Workorderperiod']['isperiod']==1)
							{
								$period=new Workorderperiod;
								if($periyot==3)
								{
									$period->startfinishdate=$_POST['Workorderperiod']['startfinishdate'];
								}
								else
								{
									$oldcode=$model->code;
									$olddate= $_POST['Workorderperiod']['startfinishdate'];
									$newdate= date('m/d/Y',strtotime($model->date)).' - '.(explode(' - ',$olddate)[1]);
		
									$period->startfinishdate=$newdate;
								}
									
								
								$period->againnumber=$_POST['Workorderperiod']['againnumber'];
								$period->dayweekmonthyear=$_POST['Workorderperiod']['dayweekmonthyear'];
								$period->code=$code;
								if($_POST['Workorderperiod']['dayweekmonthyear']=='week')
								{
									$period->day=Workorder::model()->msplit($_POST['Workorderperiod']['day']);
									$period->monthday='';
								}
								else if($_POST['Workorderperiod']['dayweekmonthyear']=='month')
								{
									$period->day="";
									$period->monthday=$_POST['Workorderperiod']['monthday'];
								}

								if($period->save())
								{									
                  echo 'code bu şekilde gidiyor...'.$code.' - model id='.$model->id;
									Workorder::model()->periodcopy($code,$model->id);						
								}
                
                $modelxxyy->is_deleted=1;
                $modelxxyy->id=(-1*$modelxxyy->id);
                
                $modelxxyy->clientid=(-1*$modelxxyy->clientid);
                $modelxxyy->firmid=(-1*$modelxxyy->firmid);
                $modelxxyy->branchid=(-1*$modelxxyy->branchid);
                $modelxxyy->staffid=(-1*$modelxxyy->staffid);
                
                
                
                if ($modelxxyy->save()){
                  			//$copy=Workorder::model()->deleteAll(array('condition'=>'id='.$model->id));
                  							Workorder::model()->monitorupdate($model->id);
                  
                }
					
	
							}
								if($periyot==2)
								{
									
				echo '4';
									$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$oldcode.'" and id not in (select reportno from servicereport )'));
									foreach($wdeleteAll as $wdeletex)
									{
				echo '5';
                    $idxass=$wdeletex->id;
                            $wdeletex->is_deleted=1;
                $wdeletex->id=(-1*$wdeletex->id);
                    
                $wdeletex->clientid=(-1*$wdeletex->clientid);
                $wdeletex->firmid=(-1*$wdeletex->firmid);
                $wdeletex->branchid=(-1*$wdeletex->branchid);
                $wdeletex->staffid=(-1*$wdeletex->staffid);
                          if ($wdeletex->save()){
										//  $wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$wdeletex->id));
										  Workorder::model()->monitorupdate($idxass);
                          }else{
                            	var_dump($wdeletex->geterrors());
							exit;
                          }
									}		
								}
								
								else if($periyot==3)
								{
				echo '6';
									$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and  code="'.$oldcode.'" and date>="'.$oldworkorder->date.'" and id not in (select reportno from servicereport )'));
									
								
									foreach($wdeleteAll as $wdeletex)
									{
                    
				echo '7';
                       $idxass=$wdeletex->id;
                            $wdeletex->is_deleted=1;
                $wdeletex->id=(-1*$wdeletex->id);
                    
                $wdeletex->clientid=(-1*$wdeletex->clientid);
                $wdeletex->firmid=(-1*$wdeletex->firmid);
                $wdeletex->branchid=(-1*$wdeletex->branchid);
                $wdeletex->staffid=(-1*$wdeletex->staffid);
                  
                          if ($wdeletex->save()){
                            
				echo '8';
										  //$wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$wdeletex->id));
										  Workorder::model()->monitorupdate($idxass);
                          }else{
                            	var_dump($wdeletex->geterrors());
					
                          }
									}		
								}
				

				echo '9';
						}
						else{
							var_dump($model->geterrors());
							exit;
						}

						Workorder::model()->monitorupdate($model->id);
						//loglama
						Logs::model()->logsaction();
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));
								
					
			}
			else /// periyot yok ve bu periyotlama kaldırma olaylarında değişiklik yapılacak veya aynı periyotlar üzerinde sadece değişiklik yapılacak saat gibi
			{
				
		
				echo '10';
				if(intval($model->isperiod)==1)  //// periyotlu olan workorderda sadece bu workorderda işlem yapılacağı için periyot kodu siliniyor
					{
						
				echo '11';
						$model->attributes=$_POST['Workorder'];
					
						$model->todo=$this->karakter($_POST['Workorder']['todo']);
						$model->special_notes=$this->karakter($_POST['Workorder']['special_notes']);
		
						if (!isset($_POST['Workorder']['teamstaffid']))
						{
							$model->teamstaffid=0;
						}

						$model->todo=$this->karakter($_POST['Workorder']['todo']);

						$model->staffid=Workorder::model()->msplit($_POST['Workorder']['staffid']);
						

						$updateperiodtype=$_POST['Workorderisperiod']['updateperiod'];
						$code=0;
						$oldcode=$model->code;
						
						if($updateperiodtype==1)
						{
						//	$model->code="";
						//	$model->isperiod=$code;
							$model->date=date("Y-m-d", strtotime($_POST['Workorder']['date']));
							Workorder::model()->monitorupdate($model->id);
						}
						else
						{
							Workorder::model()->codeupdate($id,$updateperiodtype);

							$wcode=Workorder::model()->find(array('condition'=>'id='.$id));
							$code=$wcode->code;
						}
						
						if($model->save()) ///// kaydetme işlemi tamam ve periyot kısmında farklılık varsa
						{
              
				echo '12';
							if($updateperiodtype==2) /// açık olan workorderlar için yapılacak
							{
                
				echo '13';
								$wupdateAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$oldcode.'" and id not in (select reportno from servicereport )'));
							}
							if($updateperiodtype==3) /// bu tarihten sonraki workorderlara uygulanacak
							{
                
				echo '14';
								$wupdateAll=Workorder::model()->findAll(array('condition'=>'code="'.$oldcode.'" and date>="'.$model->date.'" and id not in (select reportno from servicereport )'));
								
							}
							if(in_array(intval($updateperiodtype),[2,3])) 
							{
                
				echo '15';
								foreach($wupdateAll as $wupx)
								{
                  
				echo '16';
									  $wup=Workorder::model()->find(array('condition'=>'id='.$wupx->id));
                  			if($changeperiyod==0)
						{
									
                        }else{
                            $wup->code=$code;
                        }
									  $wup->start_time=$model->start_time;
									  // $wup->date=$model->date;
									  $wup->finish_time=$model->finish_time;
									  $wup->teamstaffid=$model->teamstaffid;
									  $wup->visittypeid=$model->visittypeid;
									  $wup->routeid=$model->routeid;
									  $wup->clientid=$model->clientid;
									  $wup->todo=$model->todo;
									  $wup->special_notes=$model->special_notes;
									  $wup->firmid=$model->firmid;
									  $wup->branchid=$model->branchid;
									  $wup->staffid=$model->staffid;
									  $wup->barcode=$model->barcode;
									  $wup->save();
									  Workorder::model()->monitorupdate($wup->id);
								}	
								
							}
							
						}else{
              
				echo '17';
              	var_dump($model->geterrors());
							exit;
            }

					}
			
			}
		}
    
				echo '18';

			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder/workorder?id='.$model->id));

		exit;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workorder']))
		{
			if($model->isperiod==0)
				{
    
						$model->attributes=$_POST['Workorder'];
						if (!isset($_POST['Workorder']['teamstaffid'])){
						$model->teamstaffid=0;
						}

						$model->todo=$this->karakter($_POST['Workorder']['todo']);

						$model->special_notes=$this->karakter($_POST['Workorder']['special_notes']);
						$model->staffid=Workorder::model()->msplit($_POST['Workorder']['staffid']);
						$model->date=date("Y-m-d", strtotime($_POST['Workorder']['date']));

						$updateperiodtype=$_POST['workorderisperiod']['updateperiod'];
						if($updateperiodtype==1)
						{
							$model->code="";
							$model->isperiod=0;
						}

				}


			if($model->save())
			{
			




				if($model->isperiod==1)
				{
          
          
							$wdelete=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$model->code.'"'));
					
							foreach($wdelete as $wdeletex)
							{
			 
							if (!isset($_POST['Workorder']['teamstaffid'])){
						$wdeletex->teamstaffid=0;
								}else{
								$wdeletex->teamstaffid=$_POST['Workorder']['teamstaffid'];
								 $wdeletex->staffid=0;
							}
                
								if(isset($_POST['Workorder']['staffid'])){
								  $wdeletex->teamstaffid=0;
							 
									  $wdeletex->staffid=$_POST['Workorder']['staffid'][0];
								}
             
		            $wdeletex->save();

                
                
                
              }
          
          /*
					// workorder perioda gore code günceleyip silme
					Workorder::model()->codeupdate($id,2);

					$wcode=Workorder::model()->find(array('condition'=>'id='.$id));
					$code=$wcode->code;


					$wdelete=Workorder::model()->findAll(array('condition'=>'code="'.$model->code.'" and id!='.$id));
					Workorder::model()->deleteAll(array('condition'=>'code="'.$model->code.'" and id!='.$id));

					foreach($wdelete as $wdeletex)
					{
								Workorder::model()->monitorupdate($wdeletex->id);
					}


					Workorderperiod::model()->deleteAll(array('condition'=>'code="'.$model->code.'"'));

					$period=new Workorderperiod;
					$period->startfinishdate=$_POST['Workorderperiod']['startfinishdate'];
					$period->againnumber=$_POST['Workorderperiod']['againnumber'];
					$period->dayweekmonthyear=$_POST['Workorderperiod']['dayweekmonthyear'];
					$period->code=$code;
					if($_POST['Workorderperiod']['dayweekmonthyear']=='week')
					{
						$period->day=Workorder::model()->msplit($_POST['Workorderperiod']['day']);
						$period->monthday='';
					}
					else if($_POST['Workorderperiod']['dayweekmonthyear']=='month')
					{
						$period->day="";
						$period->monthday=$_POST['Workorderperiod']['monthday'];
					}

					if($period->save())
					{
						Workorder::model()->periodcopy($code,$id);
					}

					//loglama
					Logs::model()->logsaction();
					/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				
          /*Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));
*/

				}
				else
				{
	Departmentvisited::model()->deleteAll(array('condition'=>'treatmenttypeid!="" and workorderid='.$id));

				if($_POST['Workorder']['mavailable']==0 && $_POST['Workorder']['treatmenttypeid']!='')
				{
					$visited=new Departmentvisited;
					$visited->workorderid=$id;
					$visited->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
					$visited->save();
				}

				if($_POST['Workorder']['mavailable']==1)
				{
					Departmentvisited::model()->deleteAll(array('condition'=>'treatmenttypeid!="" and workorderid='.$id));
				}


					if($updateperiodtype!=1 && $updateperiodtype!='')
					{

						// workorder perioda gore code günceleyip silme
					Workorder::model()->codeupdate($id,$updateperiodtype);

					$wcode=Workorder::model()->find(array('condition'=>'id='.$id));
					$code=$wcode->code;

					$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$model->code.'"'));

						//workordera period code ekleme başlangıç
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							$period->startfinishdate=date('m/d/Y',strtotime($wcode->date)).'-'.explode('-',$workorderperiod->startfinishdate)[1];

							$workorderperiod->startfinishdate=explode('-',$workorderperiod->startfinishdate)[0].'-'.date('m/d/Y',strtotime($wcode->date));
							$workorderperiod->save();

						}


						$period->againnumber=$workorderperiod->againnumber;
						$period->dayweekmonthyear=$workorderperiod->dayweekmonthyear;
						$period->code=$code;
						$period->day=$workorderperiod->day;
						$period->monthday=$workorderperiod->monthday;

						if($period->save()) //eger workorder period eklendiyse  verilen periodu kopyalama
						{
							Workorder::model()->periodcopy($code,$id,$model->code);
						}


						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{

							 $wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$model->code.'" and date>="'.$model->date.'"'));


							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$model->code.'" and date>="'.$model->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}


						}

						if($updateperiodtype==2)// eger daha once kopyalanmış bir veri ve guncellenecekse periodu silinecekler
						{
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$model->code.'"'));

							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$model->code.'"'));
							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}


							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$model->code.'"'));
							$codedelete->delete();
						}



						$deletevisit=Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$id));
						$copy=Workorder::model()->find(array('condition'=>'id='.$id));
						$copy->delete();

						Workorder::model()->monitorupdate($model->id);
						//loglama
						Logs::model()->logsaction();
						/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));


					}


				Workorder::model()->monitorupdate($model->id);


				}



			}




			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder/workorder?id='.$model->id));
		}

		$this->render('application.views.workorder.update',array(
			'model'=>$model,
		));
	}

  
  
  
  	public function actionUpdatep($id)
	{

		$id=$_GET['id'];
		$model=$this->loadModel($id);
		$modelxxyy=$this->loadModel($id);
		$changeperiyod=intval($_POST['Workorderperiod']['isperiod']);
		$oldcode=$model->code;
		if(isset($_POST['Workorder']) || $changeperiyod==1 )
		{
			if($changeperiyod==1) //// periyot var ve ona göre bi değişiklik yapılacak
			{
				echo '1';
				$periyot=intval($_POST['Workorderisperiod']['updateperiod']);
				
				//////////// periyodik olarak silme işlemi tamamlandı //////
				///// tekrar periyodik olarak ekleme işlemine devam edilecek //////
				
					
						$oldworkorder=Workorder::model()->find(array('condition'=>'id='.$id));
						
					//	$model->attributes=$_POST['Workorder'];
					//	$model->staffid=Workorder::model()->msplit($oldworkorder->staffid);
						
					//	$model->status=0;
					//	$model->isperiod=$_POST['Workorderperiod']['isperiod'];

					//	$model->todo=$this->karakter($_POST['Workorder']['todo']);

						//randomcode and agein control

						$code=Workorder::model()->randomcodeperiod();

						//randomcode and agein control8
						$model->code=$code;
            $modelxxyy->special_notes=  $model->special_notes= $_POST['Workorder']['special_notes'];

		
						if($model->save())
						{
							
				echo '3';
							if($_POST['Workorder']['mavailable']==0 && $_POST['Workorder']['treatmenttypeid']!='')
							{
								$visited=new Departmentvisited;
								$visited->workorderid=$model->id;
								$visited->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
								$visited->save();
							}

					
								$period=new Workorderperiod;
								if($periyot==3)
								{
									$period->startfinishdate=$_POST['Workorderperiod']['startfinishdate'];
								}
								else
								{
									//$oldcode=$model->code;
									$olddate= $_POST['Workorderperiod']['startfinishdate'];
									$newdate= date('m/d/Y',strtotime($model->date)).' - '.(explode(' - ',$olddate)[1]);
		            //  $_POST['Workorderperiod']['startfinishdate']=$newdate;
								//	$period->startfinishdate=$newdate;
                  	$period->startfinishdate=$_POST['Workorderperiod']['startfinishdate'];
							
								}
									
								
								$period->againnumber=$_POST['Workorderperiod']['againnumber'];
								$period->dayweekmonthyear=$_POST['Workorderperiod']['dayweekmonthyear'];
								$period->code=$code;
								if($_POST['Workorderperiod']['dayweekmonthyear']=='week')
								{
									$period->day=Workorder::model()->msplit($_POST['Workorderperiod']['day']);
									$period->monthday='';
								}
								else if($_POST['Workorderperiod']['dayweekmonthyear']=='month')
								{
									$period->day="";
									$period->monthday=$_POST['Workorderperiod']['monthday'];
								}

								if($period->save())
								{
                  echo 'code bu şekilde gidiyor...'.$code.' - model id='.$model->id;
									Workorder::model()->periodcopy($code,$model->id);						
								}
                   if ($modelxxyy->id>0){
                $modelxxyy->is_deleted=1;
                $modelxxyy->id=(-1*$modelxxyy->id);
                
                $modelxxyy->clientid=(-1*$modelxxyy->clientid);
                $modelxxyy->firmid=(-1*$modelxxyy->firmid);
                $modelxxyy->branchid=(-1*$modelxxyy->branchid);
                $modelxxyy->staffid=(-1*$modelxxyy->staffid);
                
             
                
                if ($modelxxyy->save()){
                  			//$copy=Workorder::model()->deleteAll(array('condition'=>'id='.$model->id));
                  							Workorder::model()->monitorupdate($model->id);
                  
                }else{
                   	var_dump($wdeletex->geterrors());
					
                }
					
	      }
			
					
				echo '6 ';
              		if($periyot==3)
								{
									$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and  code="'.$oldcode.'" and date>="'.$oldworkorder->date.'" and id not in (select reportno from servicereport )'));
									
                  }else{
                    
                    		$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and  code="'.$oldcode.'" and id not in (select reportno from servicereport )'));
									
                  }
									foreach($wdeleteAll as $wdeletex)
									{
                    
				echo '7 ';
                    if ($wdeletex->id>0){
                       $idxass=$wdeletex->id;
                            $wdeletex->is_deleted=1;
                $wdeletex->id=(-1*$wdeletex->id);
                    
                $wdeletex->clientid=(-1*$wdeletex->clientid);
                $wdeletex->firmid=(-1*$wdeletex->firmid);
                $wdeletex->branchid=(-1*$wdeletex->branchid);
                $wdeletex->staffid=(-1*$wdeletex->staffid);
                  
                          if ($wdeletex->save()){
                            
				echo '8 ';
										  //$wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$wdeletex->id));
										  Workorder::model()->monitorupdate($idxass);
                          }else{
                            	var_dump($wdeletex->geterrors());
					
                          }
                      }
									}		
              
              if ($model->id>0){
                $model->is_deleted=1;
                $model->id=(-1*$model->id);
                    
                $model->clientid=(-1*$model->clientid);
                $model->firmid=(-1*$model->firmid);
                $model->branchid=(-1*$model->branchid);
                $model->staffid=(-1*$model->staffid);
                  
                          if ($model->save()){
                            
                            
                          }
                            }
								
				

				echo '9 ';	
						}
						else{
							var_dump($model->geterrors());
							exit;
						}

						Workorder::model()->monitorupdate($model->id);
						//loglama
						$codeFirstOldDefault = Workorder::model()->find(array(
							'condition' => 'code=:code',
							'params' => array(':code' => $code),
							'order' => 'id DESC' // veya 'id ASC' neye göre sıralamak istiyorsan
						));
						
						Logs::model()->logsaction();
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder/workorder?id='.$codeFirstOldDefault->id));
								
					
			}
			
		}


			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder/workorder?id='.$model->id));

		exit;

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$id=$_POST['Workorder']['id'];
		$model=$this->loadModel($id);
				if($model->isperiod==1)
				{
							$wdelete=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$model->code.'"'));
					
							foreach($wdelete as $wdeletex)
							{
                  $wdeletex->teamstaffid=$wdeletex->teamstaffid-100000000;
                  $wdeletex->clientid=$wdeletex->clientid-100000000;
                  $wdeletex->firmid=$wdeletex->firmid-100000000;
                  $wdeletex->branchid=$wdeletex->branchid-100000000;
                  $wdeletex->staffid=$wdeletex->staffid-100000000;
                  $wdeletex->save();
              }
                
                
          //      Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$wdeletex->id));
			//monitörleri silme eklenecek
              
          

				}else{

					$updateperiodtype=$_POST['Workorderisperiod']['id'];
						$workorder=Workorder::model()->deleteAll(array('condition'=>'id='.$id));
						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						{/*


							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}

							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();*/

						}

						else if($updateperiodtype==2)// eger daha once kopyalanmış bir veri ve guncellenecekse periodu silinecekler
						{
					/*		$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'"'));

							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}

							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();*/
						}

						else
						{
								$wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$id));
								Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$id));
								Workorder::model()->monitorupdate($id);

						}
    
  }

			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			Yii::app()->SetFlashes->add($wdelete,t('Delete Success!'),array('/workorder'));


	}
  	public function actionDeleteperiyodik($id)
	{
		$id=$_POST['Workorder']['id'];
		$model=$this->loadModel($id);
		$periyot=intval($_POST['Workorderisperiod']['updateperiod']);
		
		if($periyot==2)
		{
			$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$model->code.'" and id not in (select reportno from servicereport )'));
			foreach($wdeleteAll as $wdeletex)
			{
              //    $wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$wdeletex->id));
        $oids=$wdeletex->id;
         $wdeletex->id=$wdeletex->id-100000000;
         $wdeletex->teamstaffid=$wdeletex->teamstaffid-100000000;
                  $wdeletex->clientid=$wdeletex->clientid-100000000;
                  $wdeletex->firmid=$wdeletex->firmid-100000000;
                  $wdeletex->branchid=$wdeletex->branchid-100000000;
                  $wdeletex->staffid=$wdeletex->staffid-100000000;
                  $wdeletex->save();
        
        
				  Workorder::model()->monitorupdate($oids);
            }		
		}
		
		else if($periyot==3)
		{
			$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$model->code.'" and date>="'.$model->date.'" and id not in (select reportno from servicereport )'));
			
		
			foreach($wdeleteAll as $wdeletex)
			{
                $oids=$wdeletex->id;
         $wdeletex->id=$wdeletex->id-100000000;
         $wdeletex->teamstaffid=$wdeletex->teamstaffid-100000000;
                  $wdeletex->clientid=$wdeletex->clientid-100000000;
                  $wdeletex->firmid=$wdeletex->firmid-100000000;
                  $wdeletex->branchid=$wdeletex->branchid-100000000;
                  $wdeletex->staffid=$wdeletex->staffid-100000000;
                  $wdeletex->save();
        
        
				  Workorder::model()->monitorupdate($oids);
            }		
		}
		else
		{
			$wdeleteAll=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and id='.$id.' and id not in (select reportno from servicereport )'));
			foreach($wdeleteAll as $wdeletex)
			{
                  $oids=$wdeletex->id;
         $wdeletex->id=$wdeletex->id-100000000;
         $wdeletex->teamstaffid=$wdeletex->teamstaffid-100000000;
                  $wdeletex->clientid=$wdeletex->clientid-100000000;
                  $wdeletex->firmid=$wdeletex->firmid-100000000;
                  $wdeletex->branchid=$wdeletex->branchid-100000000;
                  $wdeletex->staffid=$wdeletex->staffid-100000000;
                  $wdeletex->save();
        
        
				  Workorder::model()->monitorupdate($oids);
            }
			 // $wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$id.' and id not in (select reportno from servicereport )'));
				  // Workorder::model()->monitorupdate($id);
		}
		
				// if($model->isperiod==1)
				// {
							// $wdelete=Workorder::model()->findAll(array('condition'=>' code<>"" and status="0" and code="'.$model->code.'"'));
					
							// foreach($wdelete as $wdeletex)
							// {
                  // $wdeletex->teamstaffid=$wdeletex->teamstaffid-100000000;
                  // $wdeletex->clientid=$wdeletex->clientid-100000000;
                  // $wdeletex->firmid=$wdeletex->firmid-100000000;
                  // $wdeletex->branchid=$wdeletex->branchid-100000000;
                  // $wdeletex->staffid=$wdeletex->staffid-100000000;
                  // $wdeletex->save();
              // }
                
                
          //      Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$wdeletex->id));
			//monitörleri silme eklenecek
              
          

				// }else{

					// $updateperiodtype=$_POST['Workorderisperiod']['id'];
						// $workorder=Workorder::model()->deleteAll(array('condition'=>'id='.$id));
						// if($updateperiodtype==3)// eger kendi tarihinden sonrakilere güncelleme yapacaksa
						// {/*


							// $wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							// Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							// foreach($wdelete as $wdeletex)
							// {
								// Workorder::model()->monitorupdate($wdeletex->id);
							// }

							// $codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							// $codedelete->delete();*/

						// }

						// else if($updateperiodtype==2)// eger daha once kopyalanmış bir veri ve guncellenecekse periodu silinecekler
						// {
					// /*		$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'"'));

							// Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'"'));

							// foreach($wdelete as $wdeletex)
							// {
								// Workorder::model()->monitorupdate($wdeletex->id);
							// }

							// $codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							// $codedelete->delete();*/
						// }

						// else
						// {
								// $wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$id));
								// Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$id));
								// Workorder::model()->monitorupdate($id);

						// }
    
  // }

			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
			Yii::app()->SetFlashes->add($wdelete,t('Delete Success!'),array('/workorder'));


	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Workorder');
		$this->render('application.views.workorder.index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Workorder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workorder']))
			$model->attributes=$_GET['Workorder'];

		$this->render('application.views.workorder.admin',array(
			'model'=>$model,
		));
	}


	public function actionWorkorder()
	{

		$this->render('application.views.workorder.view');
	}

    public function actionMonitor()
    {

        $this->render('application.views.workorder.monitor');
    }
    public function actionData()
    {

        $this->render('application.views.workorder.data');
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Workorder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Workorder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,t('The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Workorder $model the model to be validated
	 */



	public function actionFirmbranch()
	{
		$branch=Firm::model()->findAll(array('condition'=>'parentid='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?
		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=$branchs->name;?></option>
		<?}

		exit;
	}

	public function actionStaffteam()
	{
		$branch=Staffteam::model()->findAll(array('condition'=>'active=1 and isdelete=0 and firmid='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?
		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=$branchs->teamname;?></option>
		<?}

		exit;
	}

	public function actionTeamcolor()
	{
		$branch=Staffteam::model()->find(array('condition'=>'id='.$_GET['id']));

		?>
			<?=$branch->teamname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
		<?
		exit;
	}


	public function actionStaffcolor()
	{


		$staff=explode(',',$_GET['id']);
		?><div class='row'><?

		for($i=0;$i<count($staff);$i++){

			$branch=User::model()->find(array('condition'=>'id='.$staff[$i]));
			?>
			<div class='col-xl-3 col-lg-3 col-md-3'>
				<?=$branch->name.' '.$branch->surname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
			</div>
		<?}
			?></div><?
		exit;
	}



	public function actionVisittype()
	{
		$firm=Firm::model()->find(array('condition'=>'id='.$_GET['id']));
		//$branch=Visittype::model()->findAll(array('condition'=>'firmid=0 or (branchid=0 and firmid='.$firm->parentid.') or branchid='.$_GET['id']));
		$branch=Visittype::model()->findAll(array('condition'=>'firmid=0 or firmid='.$_GET['id']));
		//$branch=Visittype::model()->findAll();
		?><option value="" hidden><?=t('Select');?></option><?
		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=t($branchs->name);?></option>
		<?}

		exit;
	}



	public function actionTreatmenttype()
	{
		 $treatmenttypes=Treatmenttype::model()->findAll(array('order'=>'name ASC','condition'=>'firmid=0 or(firmid='.$_GET['firm'].' and branchid=0) or branchid='.$_GET['id'],));
		// $treatmenttypes=Treatmenttype::model()->findAll();
		foreach($treatmenttypes as $treatmenttype){?>
			<option value="<?=$treatmenttype->id;?>"
				<?if(isset($_GET['visitid']) && $dvisit->treatmenttypeid!=''){if(Workorder::model()->isnumber($treatmenttype->id,$dvisit->treatmenttypeid)){echo "selected";}}?>
					 ><?=$treatmenttype->name;?></option>
				<?}
	}



	public function actionRoute()
	{
		$branch=Route::model()->findAll(array('condition'=>'branchid='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?
		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=$branchs->name;?></option>
		<?}

		exit;
	}

	public function actionRouteclient()
	{


		if($_GET['route']!=0)
		{
		$route=Route::model()->find(array('condition'=>'id='.$_GET['route']));

		$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$_GET['branch']));
		?><option value="" hidden><?=t('Select');?></option><?
		foreach($client as $clientx)
			{
				$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and '.Workorder::model()->serarchsplit('parentid='.$clientx->id.' and id',$route->routetb)));
				if(count($clientbranchs)>0){?>
				<optgroup label="<?=$clientx->name;?>">

						<?foreach($clientbranchs as $clientbranch)
						{?>
							<?$transfer=Client::model()->istransfer($clientbranch->id);
							if($transfer!=1){?>
							<option value="<?=$clientbranch->id;?>"><?=$clientx->name;?><?=' -> '.$clientbranch->name;?></option>
							<?}?>
						<?}?>
				</optgroup>
				<?}?>
			<?}


			$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$_GET['branch'].' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
			foreach($tclient as $tclientx)
			{

				$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
				foreach($tclients as $tclientsx)
				{?>
				<optgroup label="<?=$tclientsx->name;?>">
				<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$_GET['branch'].' and '.Workorder::model()->serarchsplit('parentid='.$tclientsx->id.' and id',$route->routetb)));
				foreach($tclientbranchs as $tclientbranchsx)
				{?>
					<option value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -> <?=$tclientbranchsx->name;?></option>
				<?}?>
				</optgroup>
				<?}

			}





			exit;

		}
		else
		{
			$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$_GET['branch']));
			foreach($client as $clientx)
			{$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));

			if(count($clientbranchs)>0){?>

				<optgroup label="<?=$clientx->name;?>">
					<?
						foreach($clientbranchs as $clientbranch)
						{?>
							<option value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
						<?}?>
				</optgroup>
				<?}?>
			<?}


				$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and irmid='.$_GET['branch'].' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
				foreach($tclient as $tclientx)
				{

					$tclients=Client::model()->findAll(array('condition'=>'isdelete=0 and id='.$tclientx->mainclientid));
					foreach($tclients as $tclientsx)
					{?>
					<optgroup label="<?=$tclientsx->name;?>">
					<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$_GET['branch']));
					foreach($tclientbranchs as $tclientbranchsx)
					{?>
						<option value="<?=$tclientbranchsx->id;?>"><?=$tclientbranchsx->name;?></option>
					<?}?>
					</optgroup>
					<?}

				}
		}

	}

	public function actionClient()
	{



		$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$_GET['id']));
		?>
		<option value="" hidden><?=t('Select');?></option><?
		foreach($client as $clientx)
			{
			$clientbranchs=Client::model()->findAll(array('condition'=>'firmid='.$_GET['id'].' and isdelete=0 and parentid='.$clientx->id));
			if(count($clientbranchs)>0){?>
				<optgroup label="<?=$clientx->name;?>">

						<?foreach($clientbranchs as $clientbranch)
						{?>
							<?$transfer=Client::model()->istransfer($clientbranch->id);
							if($transfer!=1){?>
							<option value="<?=$clientbranch->id;?>"><?=$clientx->name;?><?=' -> '.$clientbranch->name;?></option>
							<?}?>
						<?}?>
				</optgroup>
			<?}?>
			<?}


			$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'isdelete=0 and firmid='.$_GET['id'].' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
			foreach($tclient as $tclientx)
			{

				$tclients=Client::model()->findAll(array('condition'=>'id='.$tclientx->mainclientid));
				foreach($tclients as $tclientsx)
				{?>
				<optgroup label="<?=$tclientsx->name;?>">
				<?$tclientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$tclientsx->id.' and firmid='.$_GET['id']));
				foreach($tclientbranchs as $tclientbranchsx)
				{?>
					<option value="<?=$tclientbranchsx->id;?>"><?=$tclientsx->name;?> -><?=$tclientbranchsx->name;?></option>
				<?}?>
				</optgroup>
				<?}

			}




		exit;
	}


	public function actionClientb()
	{
		$client=Client::model()->findAll(array('condition'=>'id='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?
		foreach($client as $clientx)
			{?>
				<optgroup label="<?=$clientx->name;?>">
					<?$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
						foreach($clientbranchs as $clientbranch)
						{?>
							<option value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
						<?}?>
				</optgroup>
			<?}


		exit;
	}


	public function actionSubdepartment()
	{
		if($_GET['id']!='')
		{
			$data=explode(',',$_GET['id']);
			for($i=0;$i<count($data);$i++)
			{
				$subdepartment=Departments::model()->findAll(array('order'=>'name ASC','condition'=>'parentid='.$data[$i]));
				foreach($subdepartment as $subdepartment){?>
					<option value="<?=$subdepartment->id;?>"><?=$subdepartment->name;?></option>
				<?}
			}
		}
	}



	public function actionStaff()
	{
		$ax= User::model()->userobjecty('');
		if($_GET['id']!='')
		{

			?><option value="" hidden><?=t('Select');?></option><?
				//lite paket için
				if($ax->firmid!=0)
				{
					$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
					$liteuser=User::model()->find(array('condition'=>'active=1 and branchid=0 and firmid='.$ax->firmid));
					if($firm->package=='Packagelite')
					{
						?><option  value="<?=$ax->id;?>"><?=$liteuser->name;?></option><?
					}
				}



				$user=User::model()->findAll(array('order'=>'name ASC','condition'=>'clientid=0 and clientbranchid=0 and branchid='.$_GET['id']));
				foreach($user as $userx){?>
					<option value="<?=$userx->id;?>"><?=$userx->name.' '.$userx->surname;?></option>
				<?}

		}
	}


public function actionWorkorderlist()
{
	$request=[];
	if (isset($_GET) &&(isset($_GET['f']) || isset($_GET['b']))) {
		$request['firm']=$_GET["f"];
		$request['branch']=$_GET["b"];
		$request['team']=$_GET["t"];
		$request['staff']=$_GET["s"];
	}
	$response=Workorder::model()->workorderList($request);
	echo json_encode($response);
	exit;
}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='workorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
  
  public function actionToplumonitor($id)
  {
    $response=Workorder::model()->toplumonitor($id);
	  echo json_encode($response);
  }
  
  public function actionToplumonitoryukle()
  {
    $response=Workorder::model()->toplumonitoryukle($_POST);
	  echo json_encode($response);
  }
  
}


