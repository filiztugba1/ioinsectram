<?php

class WorkorderController extends Controller
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
				'actions'=>array('clientqr','index','view','workorder','save','departmentdiv','subdepartment','monitoringpointno','addsave','departmentvisited','copy','firmbranch'
				,'staffteam','monitor','data','route','visittype','client','visitedupdate','visiteddelete','change','staff','routeclient','teamcolor','staffcolor','treatmenttype'),
				'users'=>array('@'),
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
	public function actionClientqr(){
		$model=Client::model()->findByPk($_GET["id"]);
		echo "<center>".$model->name."</center>";
		echo '<center><img src="https://insectram.io/qrcode/qrcode?txt='.$_GET["id"].'&size=25"></center>';
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
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
		
			//randomcode and agein control
			
			$code=Workorder::model()->randomcodeperiod();
		
			//randomcode and agein control
			$model->code=$code;
			
			if($_POST['Workorderperiod']['isperiod']!=1)
			{
				$model->code="";
			}
			if($model->save())
			{
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
					/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder'));
				
				}
				
			}
			
			Workorder::model()->monitorupdate($model->id);
			//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	
	}






	public function actionCopy()
	{
		
	
		 $months=$_POST['Workorder']['month'];
		 $year=$_POST['Workorder']['year'];

		
		  $dstart=$_POST['Workorder']['dateyear'].'-'.$_POST['Workorder']['datemonth'].'-01';
		 $gun=cal_days_in_month(CAL_GREGORIAN, $_POST['Workorder']['datemonth'], $_POST['Workorder']['dateyear']);
		
		  $dfinish=$_POST['Workorder']['dateyear'].'-'.$_POST['Workorder']['datemonth'].'-'.$gun;
		

	

		
		$copy=Workorder::model()->findAll(array('condition'=>'branchid='.$_POST['Workorder']['branchid'].' and date BETWEEN "'.$dstart.'"  AND "'.$dfinish.'"'));


		

		$copydate='';

		for($i=0;$i<count($months);$i++)
		{
			foreach($copy as $copyx)
			{
				$start = new DateTime(Workorder::model()->datecopy($copyx->date,$months[$i],$year));

				$isdate=Workorder::model()->findAll(array('condition'=>'staffid="'.$copyx->staffid.'" and todo="'.$copyx->todo.'" and clientid='.$copyx->clientid.' and routeid='.$copyx->routeid.' and visittypeid='.$copyx->visittypeid.' and start_time="'.$copyx->start_time.'" and finish_time="'.$copyx->finish_time.'" and teamstaffid='.$copyx->teamstaffid.' and branchid='.$_POST['Workorder']['branchid'].' and date="'.$start->format('m/d/Y').'"'));

				

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
		$visited=Departmentvisited::model()->find(array(
								   'condition'=>'workorderid=:workorderid and departmentid=:departmentid and subdepartmentid=:subdepartmentid and monitoringno=:monitoringno and monitoringtype=:monitoringtype',
									'params'=>array('workorderid'=>$_POST['Workorder']['workorderid'],
													'departmentid'=>$_POST['Workorder']['departmentid'],
													'subdepartmentid'=>$_POST['Workorder']['subdepartmentid'],
													'monitoringtype'=>$_POST['Workorder']['monitoringtype'],
													'monitoringno'=>$_POST['Workorder']['monitoringno'])
									));
								
		
		if(count($visit)==0)
		{
			
			$model=new Departmentvisited;
			$model->mavailable=$_POST['Workorder']['mavailable'];
			$model->workorderid=$_POST['Workorder']['workorderid'];
			$model->departmentid=Workorder::model()->msplit($_POST['Workorder']['departmentid']);
			$model->subdepartmentid=Workorder::model()->msplit($_POST['Workorder']['subdepartmentid']);
			$model->monitoringtype=Workorder::model()->msplit($_POST['Workorder']['monitoringtype']);
			$model->treatmenttypeid=Workorder::model()->msplit($_POST['Workorder']['treatmenttypeid']);
			$model->monitoringno=Workorder::model()->msplit($_POST['Workorder']['monitoringno']);
			
			if($_POST['Workorder']['mavailable']==0)
			{
					$model->departmentid="";
					$model->subdepartmentid="";
					$model->monitoringtype="";
					$model->monitoringno="";
			}
			if($_POST['Workorder']['mavailable']==1)
			{
					$model->treatmenttypeid="";
			
			}

			 $updateperiodtype=$_POST['workorderisperiod']['updateperiod'];

			if ($model->save())
			{

				
					if($updateperiodtype!=1 && $updateperiodtype!='')
					{
						// workorder perioda gore code g�nceleyip silme
						$workorder=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						Workorder::model()->codeupdate($model->workorderid,$updateperiodtype);

						$wcode=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						 $code=$wcode->code;

						$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
					
					
						//workordera period code ekleme ba�lang��
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
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

						
						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
						{
							 
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							Workorder::model()->deleteAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}
						}

						if($updateperiodtype==2)// eger daha once kopyalanm�� bir veri ve guncellenecekse periodu silinecekler
						{
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'"'));
							Workorder::model()->deleteAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'"'));

							
							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}
							
							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();
						}


						$deletevisit=Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$model->workorderid));
						$copy=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						$copy->delete();

						Workorder::model()->monitorupdate($model->workorderid);
						
						//loglama
						Logs::model()->logsaction();
						/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder'));

					}


				

				/*perioda gore ekleyip sileme finish*/


////////////////
				
/////////////////////
			
			}

			Workorder::model()->monitorupdate($model->workorderid);	
			//loglama
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->workorderid));
		}		
									
		else
		{
			Yii::app()->SetFlashes->add($model,t('Pre-added!'),array('/workorder/workorder?id='.$model->workorderid));
		}	
	
			
	}




	public function actionDepartmentdiv()
	{
		if(isset($_GET['visit']) && $_GET['visit']!=""){$visit=Departmentvisited::model()->find(array('condition'=>'id='.$_GET['visit']));}

		$departments=Departments::model()->findAll(array('condition'=>'parentid=0 and clientid='.$_GET['id'],));
		?> <option value="0">All</option><?php		foreach($departments as $department)
		{?>
			<option value="<?=$department->id;?>" <?php if(isset($_GET['visit']) && $_GET['visit']!=""){if($department->id==$visit->departmentid){echo "selected";}}?>><?=$department->name;?></option>
		<?php }
	}



	/*public function actionSubdepartment()
	{
		$departments=Departments::model()->findAll(array('condition'=>'parentid='.$_GET['id'],));
		?> <option value="0">All</option><?php		foreach($departments as $department)
		{?>
			<option value="<?=$department->id;?>"><?=$department->name;?></option>
		<?php }
	}
	*/


	public function actionMonitoringpointno()
	{
			$veri="";
			if(isset($_GET['cid']) && $_GET['cid']!=0 && $_GET['cid']!='')
			{
			$veri="clientid=".$_GET['cid'];
			}

			if(isset($_GET['d']) && $_GET['d']!=0 && $_GET['d']!='')
			{
				$x=Workorder::model()->serarchsplit('dapartmentid',$_GET['d']);
				$veri=$veri." and (".$x.")";
			}

			if(isset($_GET['sd']) && $_GET['sd']!=0 && $_GET['sd']!='')
			{  
				$x=Workorder::model()->serarchsplit('subid',$_GET['sd']);
				$veri=$veri." and (".$x.")";
			}
			
			if(isset($_GET['mpt']) && $_GET['mpt']!=0 && $_GET['mpt']!='')
			{  
				$x=Workorder::model()->serarchsplit('mtypeid',$_GET['mpt']);
				$veri=$veri." and (".$x.")";
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
					
					
				<?php }
				
				?>
					<script>
						$(document).ready(function (e) {
						   $('.skin-square input').iCheck({
							checkboxClass: 'icheckbox_square-red',
							radioClass: 'iradio_square-red',
						});
						});
					</script>
				<?php				
				

			
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
						
							// workorder perioda gore code g�nceleyip silme
							$workorder=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
							Workorder::model()->codeupdate($model->workorderid,$updateperiodtype);

							$wcode=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
							 $code=$wcode->code;

							$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
					
					
						//workordera period code ekleme ba�lang��
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
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

						
						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
						{
							 
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));
							
							Workorder::model()->deleteAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}
							

						}

						if($updateperiodtype==2)// eger daha once kopyalanm�� bir veri ve guncellenecekse periodu silinecekler
						{
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'"'));
							
							Workorder::model()->deleteAll(array('condition'=>'id!='.$model->workorderid.' and code="'.$workorder->code.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}


							
							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();
						}


						
						$deletevisit=Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$model->workorderid));
						$copy=Workorder::model()->find(array('condition'=>'id='.$model->workorderid));
						$copy->delete();

						Workorder::model()->monitorupdate($model->workorderid);
						
							//loglama
						Logs::model()->logsaction();
						/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));

					}

			}
			// Workorder::model()->monitorupdate($model->workorderid);
			
			Workorder::model()->monitorupdate($model->workorderid);
			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/workorder/workorder?id='.$model->workorderid));
	
		
		
	}
	
	public function actionVisiteddelete()
	{
		$model=Departmentvisited::model()->findByPk($_POST['Departmetvisited']['id']); 
		if ($model)
		{
			 $id=$model->workorderid;
			
			
			if($model->delete())
			{
					
					$updateperiodtype=$_POST['workorderisperiod']['updateperiod'];
					if($updateperiodtype!=1 && $updateperiodtype!='')
					{
						
					// workorder perioda gore code g�nceleyip silme
					$workorder=Workorder::model()->find(array('condition'=>'id='.$id));
					Workorder::model()->codeupdate($id,$updateperiodtype);

					$wcode=Workorder::model()->find(array('condition'=>'id='.$id));
					 $code=$wcode->code;

					$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
					
					
						//workordera period code ekleme ba�lang��
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
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

							if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
						{
							 
							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));
							
							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}
							

						}

						if($updateperiodtype==2)// eger daha once kopyalanm�� bir veri ve guncellenecekse periodu silinecekler
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
							/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
							Yii::app()->SetFlashes->add($post,t('Delete Success!'),array('/workorder'));

					}
				
			}
		}

		
		
		Workorder::model()->monitorupdate($id);
		Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/workorder/workorder?id='.$id));
		
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
		
	

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workorder']))
		{
		
			$model->attributes=$_POST['Workorder'];
			if (!isset($_POST['Workorder']['teamstaffid'])){
			$model->teamstaffid=0;
			}
			
			$model->staffid=Workorder::model()->msplit($_POST['Workorder']['staffid']);
			$model->date=date("Y-m-d", strtotime($_POST['Workorder']['date']));	

			$updateperiodtype=$_POST['workorderisperiod']['updateperiod'];
			if($updateperiodtype==1)
			{
				$model->code="";
				$model->isperiod=0;
			}
			
				
					
					
			if($model->save())
			{
				
				
				if($_POST['Workorderperiod']['isperiod']==1)
				{
					// workorder perioda gore code g�nceleyip silme
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
					/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
					Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));

					
				}
				else
				{
					
				
					if($updateperiodtype!=1 && $updateperiodtype!='')
					{
						
						// workorder perioda gore code g�nceleyip silme
					Workorder::model()->codeupdate($id,$updateperiodtype);

					$wcode=Workorder::model()->find(array('condition'=>'id='.$id));
					$code=$wcode->code;

					$workorderperiod=Workorderperiod::model()->find(array('condition'=>'code="'.$model->code.'"'));
					
						//workordera period code ekleme ba�lang��
						$period=new Workorderperiod;
						$period->startfinishdate=$workorderperiod->startfinishdate;

						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
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


						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
						{
							
							 $wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$model->code.'" and date>="'.$model->date.'"'));


							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$model->code.'" and date>="'.$model->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}
							

						}

						if($updateperiodtype==2)// eger daha once kopyalanm�� bir veri ve guncellenecekse periodu silinecekler
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
						/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder'));
					

					}
					
					
					
				}


					
				Workorder::model()->monitorupdate($model->id);
			
			}

		

		
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/workorder/workorder?id='.$model->id));
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
		$id=$_POST['Workorder']['id'];
	
					$updateperiodtype=$_POST['Workorderisperiod']['id'];
						$workorder=Workorder::model()->deleteAll(array('condition'=>'id='.$id));
						if($updateperiodtype==3)// eger kendi tarihinden sonrakilere g�ncelleme yapacaksa
						{
							 

							$wdelete=Workorder::model()->findAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));
							
							Workorder::model()->deleteAll(array('condition'=>'id!='.$id.' and code="'.$workorder->code.'" and date>="'.$workorder->date.'"'));

							foreach($wdelete as $wdeletex)
							{
								Workorder::model()->monitorupdate($wdeletex->id);
							}

							$codedelete=Workorderperiod::model()->find(array('condition'=>'code="'.$workorder->code.'"'));
							$codedelete->delete();
							
						}

						else if($updateperiodtype==2)// eger daha once kopyalanm�� bir veri ve guncellenecekse periodu silinecekler
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

						else
						{
								$wdelete=Workorder::model()->deleteAll(array('condition'=>'id='.$id));
								Departmentvisited::model()->deleteAll(array('condition'=>'workorderid='.$id));
								Workorder::model()->monitorupdate($id);
						
						}
			
			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
			Yii::app()->SetFlashes->add($wdelete,t('Delete Success!'),array('/workorder'));
			
			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Workorder');
		$this->render('index',array(
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

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function actionWorkorder()
	{
		
		$this->render('view');
	}

    public function actionMonitor()
    {

        $this->render('monitor');
    }
    public function actionData()
    {

        $this->render('data');
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
		?><option value="" hidden><?=t('Select');?></option><?php		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=$branchs->name;?></option>
		<?php }
		
		exit;
	}
	
	public function actionStaffteam()
	{
		$branch=Staffteam::model()->findAll(array('condition'=>'firmid='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?php		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=$branchs->teamname;?></option>
		<?php }
		
		exit;
	}

	public function actionTeamcolor()
	{
		$branch=Staffteam::model()->find(array('condition'=>'id='.$_GET['id']));
		
		?>
			<?=$branch->teamname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
		<?php		exit;
	}


	public function actionStaffcolor()
	{
		

		$staff=explode(',',$_GET['id']);
		?><div class='row'><?php		
		for($i=0;$i<count($staff);$i++){

			$branch=User::model()->find(array('condition'=>'id='.$staff[$i]));
			?>
			<div class='col-xl-3 col-lg-3 col-md-3'>
				<?=$branch->name.' '.$branch->surname;?><div style="width: 52px;height: 18px; border-radius: 5px;background:<?='#'.$branch->color;?>"></div>
			</div>
		<?php }
			?></div><?php		exit;
	}


	
	public function actionVisittype()
	{
		$firm=Firm::model()->find(array('condition'=>'id='.$_GET['id']));
		//$branch=Visittype::model()->findAll(array('condition'=>'firmid=0 or (branchid=0 and firmid='.$firm->parentid.') or branchid='.$_GET['id']));
		$branch=Visittype::model()->findAll(array('condition'=>'firmid=0 or firmid='.$_GET['id']));
		//$branch=Visittype::model()->findAll();
		?><option value="" hidden><?=t('Select');?></option><?php		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=t($branchs->name);?></option>
		<?php }
		
		exit;
	}



	public function actionTreatmenttype()
	{
		 //$treatmenttypes=Treatmenttype::model()->findAll(array('order'=>'name ASC','condition'=>'branchid='.$workorder->branchid,));
		$treatmenttypes=Treatmenttype::model()->findAll();
		foreach($treatmenttypes as $treatmenttype){?>
			<option value="<?=$treatmenttype->id;?>"
				<?php if(isset($_GET['visitid']) && $dvisit->treatmenttypeid!=''){if(Workorder::model()->isnumber($treatmenttype->id,$dvisit->treatmenttypeid)){echo "selected";}}?>
					 ><?=$treatmenttype->name;?></option>
				<?php }
	}


	
	public function actionRoute()
	{
		$branch=Route::model()->findAll(array('condition'=>'branchid='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?php		foreach($branch as $branchs)
		{?>
			<option value="<?=$branchs->id;?>"><?=$branchs->name;?></option>
		<?php }
		
		exit;
	}

	public function actionRouteclient()
	{
		
		
		if(isset($_GET['route']) && $_GET['route']!=0)
		{
		$route=Route::model()->find(array('condition'=>'id='.$_GET['route']));
		$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$_GET['branch']));
			foreach($client as $clientx)
			{
				$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0  and '.Workorder::model()->serarchsplit('parentid='.$clientx->id.' and id',$route->routetb)));

					if(count($clientbranchs)!=0){?><optgroup label="<?=$clientx->name;?>"><?php }
						foreach($clientbranchs as $clientbranch)
						{?>
							<option value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
						<?php }?>
				</optgroup>
			<?php }
			
			exit;
		
		}
		else
		{
			$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$_GET['branch']));
			foreach($client as $clientx)
			{?>
				<optgroup label="<?=$clientx->name;?>">
					<?$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
						foreach($clientbranchs as $clientbranch)
						{?>
							<option value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
						<?php }?>
				</optgroup>
			<?php }
		}
		
	}
	
	public function actionClient()
	{
		$client=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$_GET['id']));
		?><option value="" hidden><?=t('Select');?></option><?php		foreach($client as $clientx)
			{?>
				<optgroup label="<?=$clientx->name;?>">
					<?$clientbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$clientx->id));
						foreach($clientbranchs as $clientbranch)
						{?>
							<option value="<?=$clientbranch->id;?>"><?='&nbsp;--> '.$clientbranch->name;?></option>
						<?php }?>
				</optgroup>
			<?php }
								
		
		exit;
	}
	
	
	public function actionSubdepartment()
	{
		if(isset($_GET['id']) && $_GET['id']!='')
		{
			$data=explode(',',$_GET['id']);
			for($i=0;$i<count($data);$i++)
			{
				$subdepartment=Departments::model()->findAll(array('order'=>'name ASC','condition'=>'parentid='.$data[$i]));
				foreach($subdepartment as $subdepartment){?>
					<option value="<?=$subdepartment->id;?>"><?=$subdepartment->name;?></option>
				<?php }
			}
		}
	}


	
	public function actionStaff()
	{
		if(isset($_GET['id']) && $_GET['id']!='')
		{
			?><option value="" hidden><?=t('Select');?></option><?php				$user=User::model()->findAll(array('order'=>'name ASC','condition'=>'clientid=0 and clientbranchid=0 and branchid='.$_GET['id']));
				foreach($user as $userx){?>
					<option value="<?=$userx->id;?>"><?=$userx->name.' '.$userx->surname;?></option>
				<?php }
			
		}
	}
	
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='workorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
