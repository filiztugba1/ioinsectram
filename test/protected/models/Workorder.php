<?php

/**
 * This is the model class for table "workorder".
 *
 * The followings are the available columns in table 'workorder':
 * @property integer $id
 * @property string $code
 * @property integer $isperiod
 * @property string $date
 * @property string $start_time
 * @property string $finish_time
 * @property integer $teamstaffid
 * @property integer $visittypeid
 * @property integer $routeid
 * @property integer $clientid
 * @property string $todo
 * @property integer $firmid
 * @property integer $branchid
 * @property string $staffid
 * @property string $barcode
 * @property integer $status
 * @property integer $realstarttime
 * @property integer $realendtime
 * @property string $service_report
 * @property string $cantscancomment
 * @property string $executiondate
 */
class Workorder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'workorder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, firmid, branchid, status', 'required'),
			array('isperiod, teamstaffid, visittypeid, routeid, clientid, firmid, branchid, status, realstarttime, realendtime', 'numerical', 'integerOnly'=>true),
			array('code, staffid', 'length', 'max'=>225),
			array('date, start_time, finish_time, todo, barcode, executiondate', 'length', 'max'=>255),
			array('service_report, cantscancomment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, isperiod, date, start_time, finish_time, teamstaffid, visittypeid, routeid, clientid, todo, firmid, branchid, staffid, barcode, status, realstarttime, realendtime, service_report, cantscancomment, executiondate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'isperiod' => 'Isperiod',
			'date' => 'Date',
			'start_time' => 'Start Time',
			'finish_time' => 'Finish Time',
			'teamstaffid' => 'Teamstaffid',
			'visittypeid' => 'Visittypeid',
			'routeid' => 'Routeid',
			'clientid' => 'Clientid',
			'todo' => 'Todo',
			'firmid' => 'Firmid',
			'branchid' => 'Branchid',
			'staffid' => 'Staffid',
			'barcode' => 'Barcode',
			'status' => '0-active 1-doing 2-paused 3-done',
			'realstarttime' => 'Realstarttime',
			'realendtime' => 'Realendtime',
			'service_report' => 'Service Report',
			'cantscancomment' => 'Cantscancomment',
			'executiondate' => 'Gerçekleştirilme Tarihi',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('isperiod',$this->isperiod);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('finish_time',$this->finish_time,true);
		$criteria->compare('teamstaffid',$this->teamstaffid);
		$criteria->compare('visittypeid',$this->visittypeid);
		$criteria->compare('routeid',$this->routeid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('todo',$this->todo,true);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('staffid',$this->staffid,true);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('realstarttime',$this->realstarttime);
		$criteria->compare('realendtime',$this->realendtime);
		$criteria->compare('service_report',$this->service_report,true);
		$criteria->compare('cantscancomment',$this->cantscancomment,true);
		$criteria->compare('executiondate',$this->executiondate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



		public function msplit($id)
	{
		if ($id)
		{
		$dizi="";
		 for($i=0;$i<count($id);$i++)
		{
			 if($dizi=='')
			{
			 $dizi=$id[$i];
			 }
			 else
			{
			 $dizi=$dizi.','.$id[$i];
			 }

		 }

		return $dizi;
		}
	}


	public function serarchsplit($name,$data)
	{
				$data=explode(',',$data);
				$x="";
				for($i=0;$i<count($data);$i++)
				{
					if(is_numeric($data[$i]))
						{
							if($i==0)
							{
								$x=$name."=".$data[$i];
							}
							else
							{
								$x=$x." or ".$name."=".$data[$i];
							}
						}
				}
			return $x;
	}




	public function isnumber($number,$data)
	{
			$data=explode(',',$data);
				for($i=0;$i<count($data);$i++)
				{
					if($data[$i]==$number)
					{
						return true;
					}
				}
			return false;

	}

	public function datecopy($date,$months,$year)
	{

		$gelentarih=explode ("-",$date);
		$day=date("l",mktime(0,0,0,$gelentarih[1],$gelentarih[2],$gelentarih[0]));
		 $day=strtolower($day);


		$date=explode('-',$date);
		$week=ceil($date[1]/7);
		if($week==1){$week='first';}
		else if($week==2){$week='second';}
		else if($week==3){$week='third';}
		else if($week==4){$week='fourth';}
		if($week==5)
		{

				if($date[1]>cal_days_in_month(CAL_GREGORIAN, $months, $year))
				{
					 $date=$months.cal_days_in_month(CAL_GREGORIAN, $months, $year).$year;
				}
				else
				{
					$date='fifth '.$day.' of '.$months.' '.$year;
				}

		}
		else
		{
			  $date=$week.' '.$day.' of '.$months.' '.$year;

		}

		return $date;
	}


	public function sql()
	{
		if($ax->firmid>0)
		{
			if($ax->branchid>0)
			{
				if($ax->clientid>0)
				{
					if($ax->clientbranchid>0)
						{
							$where='and clientid='.$ax->clientbranchid;
						}
						else
						{
						$workorder=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
						$i=0;
						foreach($workorder as $workorderx)
						{
							if($i==0)
							{
								$where='and clientid='.$workorderx->id;
							}
							else
							{
								$where=$where.' or clientid='.$workorderx->id;
							}

						}
					}

				}
				else
				{
					$where="and branchid=".$ax->branchid;
				}
			}
			else
			{
				$where="and firmid=".$ax->firmid;
			}
		}
		else
		{
			$where="";
		}

		return $where;
	}

	public function getmonitorsecere($monitorid)
	{
		$firmid=0;
		$firmbranchid=0;//
		$clientid=0;//
		$clientbranchid=0;//
		$departmentid=0;//
		$subdepartmentid=0;//
		$monitorlocation=0;//
		$monitor=Monitoring::model()->findbypk($monitorid);
		if ($monitor)
		{
			$departmentid=$monitor->dapartmentid;
			$subdepartmentid=$monitor->subid;
			$clientbranchid=$monitor->clientid;
			$monitorlocation=$monitor->mlocationid;
			$clientid=Client::model()->findbypk($clientbranchid)->parentid;
			$firmbranchid=Client::model()->findbypk($clientid)->firmid;
			$firmid=Firm::model()->findbypk($firmbranchid)->parentid;
		}
		return (object)array(
		'firmid'=>$firmid,
		'firmbranchid'=>$firmbranchid,
		'clientid'=>$clientid,
		'monitorlocation'=>$firmid,
		'clientbranchid'=>$clientbranchid,
		'subdepartmentid'=>$subdepartmentid,
		'departmentid'=>$departmentid);

	}
  
	public function monitorupdate($workorderid)
	{
				$workorder=Workorder::model()->findbypk($workorderid);
				if ($workorder)
				{
				$start=strtotime($workorder->date.' '. str_replace(' ', '', $workorder->start_time));
				$end=strtotime($workorder->date.' '. str_replace(' ', '', $workorder->finish_time));
				}else
				{
					$start=0;
					$end=0;
				}


				$deletemonitors=Mobileworkordermonitors::model()->deleteall(array('condition'=>'workorderid='.$workorderid));
				$deletemonitors1=Mobileworkorderdata::model()->deleteall(array('condition'=>'workorderid='.$workorderid));
			//	$this->mobileworkorderadd($workorderid);
			
				$jobs=Departmentvisited::model()->findall(array('condition'=>'workorderid='.$workorderid));
		if ($jobs)
		{
			foreach ($jobs as $model)
			{
				$monitors=explode(',',$model->monitoringno);
				foreach ($monitors as $item)
				{
					$monitordata=Monitoring::model()->findbypk($item);
					$info=Workorder::model()->getmonitorsecere($item);
					$m=new Mobileworkordermonitors;
					$m->workorderid=$workorderid;
					$m->monitorid=$item;
					$m->monitorno=Monitoring::model()->getmonitorno($item);//monitornoget
					$m->monitortype=$monitordata->mtypeid;//monitoritemget
					$m->pettypes=$item;//monitorpettypes
					$m->barcodeno=$monitordata->barcodeno;//getbarcodeno
					$m->barcodestatus=0;//okundu okunamadı
					$m->firmid=$info->firmid;//getfirm
					$m->firmbranchid=$info->firmbranchid;//getbranch
					$m->clientid=$info->clientid;//getclient
					$m->clientbranchid=$info->clientbranchid;//getclientbranchid
					$m->departmentid=$info->departmentid;//getmonitordepertmant
					$m->subdepartment=$info->subdepartmentid;//getmonitorsubdepertmant
					$m->saverid=Yii::app()->user->id;//getuserid
					$m->checkdate=0;//finishtime
					if ($m->save())
					{
						$id=$m->monitorid;
						$monitor=Monitoring::model()->findbypk($id);
						$monitortype=$monitor->mtypeid;
						$controls=Monitoringtypepets::model()->findall(array('condition'=>'monitoringtypeid='.$monitortype));

						foreach ($controls as $a)
						{
							$mdata=new Mobileworkorderdata;
							$mdata->mobileworkordermonitorsid=$m->id;
							$mdata->workorderid	=$m->workorderid;
							$mdata->monitorid=$id;
							$mdata->monitortype=$monitortype;
							$mdata->petid=$a->petsid;
							$mdata->pettype=$a->isactive;
							$mdata->value=0;
							$mdata->saverid=0;
							$mdata->createdtime=0;
							$mdata->firmid=$info->firmid;
							$mdata->firmbranchid=$info->firmbranchid;
							$mdata->clientid=$info->clientid;
							$mdata->clientbranchid=$info->clientbranchid;
							$mdata->departmentid=$info->departmentid;
							$mdata->subdepartmentid=$info->subdepartmentid;
							$mdata->openedtimestart=$start;
							$mdata->openedtimeend=$end;
							$mdata->isproduct=Pets::model()->findbypk($a->petsid)->isproduct;
							$mdata->save();
						}


					}
				}
			}
		}
		
				return true;

	}

	public function mobileworkorderadd($workorderid)
	{
		$jobs=Departmentvisited::model()->findall(array('condition'=>'workorderid='.$workorderid));
		if ($jobs)
		{
			foreach ($jobs as $model)
			{
				$monitors=explode(',',$model->monitoringno);
				foreach ($monitors as $item)
				{
					$monitordata=Monitoring::model()->findbypk($item);
					$info=Workorder::model()->getmonitorsecere($item);
					$m=new Mobileworkordermonitors;
					$m->workorderid=$workorderid;
					$m->monitorid=$item;
					$m->monitorno=Monitoring::model()->getmonitorno($item);//monitornoget
					$m->monitortype=$monitordata->mtypeid;//monitoritemget
					$m->pettypes=$item;//monitorpettypes
					$m->barcodeno=$monitordata->barcodeno;//getbarcodeno
					$m->barcodestatus=0;//okundu okunamadı
					$m->firmid=$info->firmid;//getfirm
					$m->firmbranchid=$info->firmbranchid;//getbranch
					$m->clientid=$info->clientid;//getclient
					$m->clientbranchid=$info->clientbranchid;//getclientbranchid
					$m->departmentid=$info->departmentid;//getmonitordepertmant
					$m->subdepartment=$info->subdepartmentid;//getmonitorsubdepertmant
					$m->saverid=Yii::app()->user->id;//getuserid
					$m->checkdate=0;//finishtime
					if ($m->save())
					{
						$id=$m->monitorid;
						$monitor=Monitoring::model()->findbypk($id);
						$monitortype=$monitor->mtypeid;
						$controls=Monitoringtypepets::model()->findall(array('condition'=>'monitoringtypeid='.$monitortype));

						foreach ($controls as $a)
						{
							$mdata=new Mobileworkorderdata;
							$mdata->mobileworkordermonitorsid=$m->id;
							$mdata->workorderid	=$m->workorderid;
							$mdata->monitorid=$id;
							$mdata->monitortype=$monitortype;
							$mdata->petid=$a->petsid;
							$mdata->pettype=$a->isactive;
							$mdata->value=0;
							$mdata->saverid=0;
							$mdata->createdtime=0;
							$mdata->firmid=$info->firmid;
							$mdata->firmbranchid=$info->firmbranchid;
							$mdata->clientid=$info->clientid;
							$mdata->clientbranchid=$info->clientbranchid;
							$mdata->departmentid=$info->departmentid;
							$mdata->subdepartmentid=$info->subdepartmentid;
							$mdata->openedtimestart=$start;
							$mdata->openedtimeend=$end;
							$mdata->isproduct=Pets::model()->findbypk($a->petsid)->isproduct;
							$mdata->save();
						}


					}
				}
			}
		}
	}


	public function periodcopy($code,$id,$oldcode='')
	{
		$date=Workorderperiod::model()->find(array('condition'=>'code="'.$code.'"'));

		$pdate=explode('-',$date->startfinishdate);
		$sdate=date('Y-m-d',strtotime(trim($pdate[0])));
		$fdate=date('Y-m-d',strtotime(trim($pdate[1])));
		$period='';
		if($date->dayweekmonthyear=='day'){$period='D';}
		else if($date->dayweekmonthyear=='week'){$period='W';}
		else if($date->dayweekmonthyear=='month'){$period='M';}
		else if($date->dayweekmonthyear=='year'){$period='Y';}

		if($date->day!='' && $date->dayweekmonthyear=='week')
		{
			$day=explode(',',$date->day);
			for($i=0;$i<count($day);$i++)
			{
				$test = new DateTime($sdate);
				$sdate1=$test->modify(ucwords($day[$i]).' this week')->format('Y-m-d');

				if($this->tarihkarsilastir($sdate,$sdate1))
				{
					$test->modify( '+1 week');
					$sdate1=$test->format('Y-m-d');
				}

				$this->period($sdate1,$fdate,$period,$date->againnumber,$date->dayweekmonthyear,$id,$oldcode);
			}
		}

		if($date->monthday!='' && $date->dayweekmonthyear=='month')
		{
			$start= new DateTime($sdate);
			$start->modify('first day of this month');
			$start->modify('+'.($date->monthday-1).' day');
			$lastdate=$start->format('Y-m-d');



			if($this->tarihkarsilastir($sdate,$lastdate))
			{
				$start->modify( '+1 month');
				$lastdate=$start->format('Y-m-d');
			}



			$this->period($lastdate,$fdate,$period,$date->againnumber,$date->dayweekmonthyear,$id,$oldcode);
		}

		if(($date->monthday==NULL ||$date->monthday=='') && ($date->day==NULL || $date->day==''))
		{
			$this->period($sdate,$fdate,$period,$date->againnumber,$date->dayweekmonthyear,$id,$oldcode);
		}



	}


	 public function tarihkarsilastir($ilk_tarih,$son_tarih)
	 {
		$ilk = strtotime($ilk_tarih);
		$son = strtotime($son_tarih);
		if ($ilk-$son > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function period($sdate,$fdate,$period,$againnumber,$type,$id,$oldcode)
	{
			//PERIOD DATE COPY START

				$begin = new DateTime($sdate);
				$end = new DateTime($fdate);
				$end = $end->modify( '+'.$againnumber.' '.$type);


				$interval = new DateInterval('P'.$againnumber.$period);
				$daterange = new DatePeriod($begin, $interval ,$end);

				foreach($daterange as $date)
				{
					echo $date->format("Y-m-d").'</br>';
					echo $sdate.'</br>';
					echo $fdate.'</br>';
					echo $oldcode;

					if($this->tarihkarsilastir($fdate,$date->format("Y-m-d")) || $fdate==$date->format("Y-m-d"))
					{
						 $datetime=$date->format("Y-m-d");
						if($oldcode=='')
						{
							$this->workorderperiodcopy($id,$date->format("Y-m-d"));
						}
						else
						{
							$copy4=Workorder::model()->findAll(array('condition'=>'(code="'.$oldcode.'" and date="'.$datetime.'") or (id='.$id.' and date="'.$datetime.'")'));
							echo count($copy4);
							if(count($copy4)!=0)
							{
								 $this->workorderperiodcopy($id,$date->format("Y-m-d"));
							}
						}

					}
				}



			//PERIOD DATE COPY FINISH
	}



	public function workorderperiodcopy($id,$date)//perioddan gelen date değerlerini
	{

					$copy=Workorder::model()->find(array('condition'=>'id='.$id));

					$wperiod=new Workorder;
					$wperiod->code=$copy->code;
					$wperiod->isperiod=$copy->isperiod;
					$wperiod->date=$date;
					$wperiod->start_time=$copy->start_time;
					$wperiod->finish_time=$copy->finish_time;
					$wperiod->teamstaffid=$copy->teamstaffid;
					$wperiod->visittypeid=$copy->visittypeid;
					$wperiod->routeid=$copy->routeid;
					$wperiod->clientid=$copy->clientid;

					$wperiod->todo=$copy->todo;
					$wperiod->firmid=$copy->firmid;
					$wperiod->branchid=$copy->branchid;
					$wperiod->staffid=$copy->staffid;
					$wperiod->status=0;

					if ($wperiod->save())
					{

						$departmentvisitedcopy=Departmentvisited::model()->findAll(array('condition'=>'workorderid='.$id));
						foreach($departmentvisitedcopy as $vcopy)
						{
							$dvisit=new Departmentvisited;
							$dvisit->treatmenttypeid=$vcopy->treatmenttypeid;
							$dvisit->monitoringtype=$vcopy->monitoringtype;
							$dvisit->workorderid=$wperiod->id;
							$dvisit->departmentid=$vcopy->departmentid;
							$dvisit->subdepartmentid=$vcopy->subdepartmentid;
							$dvisit->monitoringno=$vcopy->monitoringno;
							$dvisit->mavailable=$vcopy->mavailable;
							$dvisit->save();
						}

							/*
							var_dump($wperiod->geterrors());
							exit;
							*/
					}

					Workorder::model()->monitorupdate($id);


	}


	public function codeupdate($id,$period)
	{
				$model=Workorder::model()->find(array('condition'=>'id='.$id));
				if($period==1)
				{
					$model->code='';
				}

				else
				{

					$model->code=$this->randomcodeperiod();
				}

				$model->save();
	}


	public function randomcodeperiod()
	{
			//randomcode and agein control

					$code=User::model()->authcode(12,1,"lower_case,upper_case,numbers")[0];
					$periodcode=Workorderperiod::model()->find(array('condition'=>'code="'.$code.'"'));
					while($periodcode==1)
					{
						$code=User::model()->authcode(12,1,"lower_case,upper_case,numbers")[0];
						$periodcode=Workorderperiod::model()->find(array('condition'=>'code="'.$code.'"'));
					}

			//randomcode and agein control
			return $code;
	}

	public function workorderList($request)
	{
		$select='';
		$ax= User::model()->userobjecty('');
		if(Yii::app()->user->checkAccess('workorder.update')){
			$select="w.id as id,cb.name as title,CONCAT(w.date,'T',w.start_time,':00') as start,CONCAT(w.date,'T',w.finish_time,':00') as finish,CONCAT('/workorder/workorder?id=',w.id) AS url,
			IF(w.status=3,'#c8c9cc',IF((w.teamstaffid!=0 && w.teamstaffid!='NULL'),CONCAT('#',st.color),CONCAT('#',u.color))) as color,
			IFNULL(CONCAT('<b>".t('Start Time').":</b>',w.start_time,'<br>',
			'<b>".t('Finish Time').":</b>',w.finish_time,'<br>',
			'<b>',IF((w.teamstaffid!=0 && w.teamstaffid!='NULL'),CONCAT('".t("Team Name").":',st.teamname),CONCAT('".t("User Name").":',CONCAT(u.name,' ',u.surname))),'<br>',
			'<b>".t("Route").":</b>',IF(w.routeid!=0,r.name,''),'<br>',
			'<b>".t("Client").":</b>',IF(w.clientid!=0,cb.name,'')
		),'') as description";
		}
		else {
			$select="w.id as id,cb.name as title,CONCAT(w.date,'T',w.start_time,':00') as start,CONCAT(w.date,'T',w.finish_time,':00') as finish,CONCAT('/workorder/workorder?id=',w.id) AS url,
			IF(w.status=3,'#c8c9cc',IF((w.teamstaffid!=0 && w.teamstaffid!='NULL'),CONCAT('#',st.color),CONCAT('#',u.color))) as color,
			IFNULL(CONCAT('<b>".t('Start Time').":</b>',w.start_time,'<br>',
			'<b>".t('Finish Time').":</b>',w.finish_time,'<br>',
			'<b>',IF((w.teamstaffid!=0 && w.teamstaffid!='NULL'),CONCAT('".t("Team Name").":',st.teamname),CONCAT('".t("User Name").":',CONCAT(u.name,' ',u.surname))),'<br>',
			'<b>".t("Route").":</b>',IF(w.routeid!=0,r.name,''),'<br>',
			'<b>".t("Client").":</b>',IF(w.clientid!=0,cb.name,'')
		),'') as description";
		}
		$response=Yii::app()->db->createCommand()
		->select($select)
		->from('workorder w')
		->leftJoin('staffteam as st','st.id=w.teamstaffid')
		->leftJoin('visittype as vt','vt.id=w.visittypeid')
		->leftJoin('route as r','r.id=w.routeid')
		->leftJoin('client as cb','cb.id=w.clientid')
		->leftJoin('client as c','c.id=cb.parentid')
		->leftJoin('firm as f','f.id=w.firmid')
		->leftJoin('firm as fb','fb.id=w.branchid')
		->leftJoin('user as u','u.id=w.staffid');


		if($ax->firmid!=0 && $ax->branchid==0)
		{
			$response=$response->where('w.firmid='.$ax->firmid);
		}
		if($ax->branchid!=0 && $ax->clientid==0)
		{
			$response=$response->andwhere('w.branchid='.$ax->branchid);
		}

		///kriterlere göre query and where

		if(isset($request['firm']) && $request['firm']!='' && $request['firm']!=0)
		{
				$response=$response->where('w.firmid='.$request['firm']);
		}
		if(isset($request['branch']) && $request['branch']!='' && $request['branch']!=0)
		{
				$response=$response->andwhere('w.branchid='.$request['branch']);
		}
		if(isset($request['team']) && $request['team']!='' && $request['team']!=0)
		{
					$response=$response->andwhere('st.id='.$request['team']);
		}
		if(isset($request['staff']) && $request['staff']!='' && $request['staff']!=0)
		{

					$response=$response->andwhere('u.id in ('.$request['staff'].')');

		}


		$response=$response->queryAll();
		return ["response"=>$response,"status"=>"200"];

	}
  
  public static function toplumonitor($id)
  {
  		$select="
      mwd.id monitorid,
      mwm.id id,
      mwd.petid petid,
      mwd.value valuem,
      p.name petname,
      IF(mwd.value=1,'Lost',IF(mwd.value=2,'Broken',IF(mwd.value=3,'Unreacheble',mwd.value))) val,
      IF(mwm.checkdate=0,'danger','secondary') monitordurumu,
      mwm.monitorno monitorno,
      mt.name,
      mwm.monitorno";
		$response=Yii::app()->db->createCommand()
		->select($select)
		->from('mobileworkordermonitors mwm')
		->leftJoin('mobileworkorderdata as mwd','mwd.mobileworkordermonitorsid=mwm.id')
		->leftJoin('pets p','p.id=mwd.petid')
		->leftJoin('monitoringtype mt','mwm.monitortype=mt.id');
     $responseMonitor=$response->where('mwm.workorderid='.$id.' order by mwm.monitorno asc')->queryAll();
     $responseGroup=Yii::app()->db->createCommand()
		->select("mwm.id id,mwm.monitorno monitorno,mt.name,IF(mwm.checkdate=0,'danger','secondary') monitordurumu")
		->from('mobileworkordermonitors mwm')
       ->leftJoin('monitoringtype mt','mwm.monitortype=mt.id')
       ->where('mwm.workorderid='.$id.' group by mwm.id order by mwm.monitorno asc')->queryAll();
    
    return ["response"=>['monitorData'=>$responseMonitor,'monitor'=>$responseGroup],"status"=>"200"];
  }
  
  public static function toplumonitoryukle($request)
  {
    if(isset($request))
    {
      foreach($request['mobileworkorderdata'] as $mobileworkorderdataid=>$monitor)
      {
        if(isset($monitor[100]) && $monitor[100]=='on')
        {
          Workorder::model()->monitorKontrol($request['checkdate'],$mobileworkorderdataid,2);
        }
        else if(isset($monitor[101]) && $monitor[101]=='on')
        {
          Workorder::model()->monitorKontrol($request['checkdate'],$mobileworkorderdataid,1);
        }
        else if(isset($monitor[102]) && $monitor[102]=='on')
        {
          Workorder::model()->monitorKontrol($request['checkdate'],$mobileworkorderdataid,3);
        }
        else
        {
              foreach($monitor[99] as $mobileworkordermonitorsid=>$monitorrvalue)
              {
               
                Workorder::model()->monitorUpdateData($request['checkdate'],$mobileworkordermonitorsid,$monitorrvalue);
              }
        }
    
      }
    }
  }
  
  public static function monitorKontrol($checkDate,$id,$value)
  {
   
    if(isset($id) && $id!=null && $id!='')
		{
			
			$modelD=Mobileworkorderdata::model()->findByPk($id);
			$check=Mobileworkorderdata::model()->find(array('condition'=>'petid=49 and workorderid='.$modelD->workorderid.'  and monitorid='.$modelD->monitorid." and value=".$value));
				$modelMon=Mobileworkordermonitors::model()->findByPk($modelD->mobileworkordermonitorsid);
      	$date=$checkDate;
          $date = str_replace('/', '-', $date);
          $yenitarih=strtotime($date);
        
      if($check)
			{
				$modelMon->checkdate=!isset($modelMon->checkdate) || intval($modelMon->checkdate)==0?$yenitarih:$modelMon->checkdate; //// sorulacak Mustafa Beye
				$modelMon->saverid=Yii::app()->user->id;
				$modelMon->save();
			}
			else
			{
        
				$modelMon->checkdate=!isset($modelMon->checkdate) || intval($modelMon->checkdate)==0?$yenitarih:$modelMon->checkdate; //// sorulacak Mustafa Beye
				$modelMon->saverid=Yii::app()->user->id;
				$modelMon->save();

				$DurumluData=new Mobileworkorderdata;
				$DurumluData->mobileworkordermonitorsid=$modelD->mobileworkordermonitorsid;
				$DurumluData->workorderid=$modelD->workorderid;
				$DurumluData->monitorid=$modelD->monitorid;
				$DurumluData->monitortype=$modelD->monitortype;
				$DurumluData->pettype=0;	
				$DurumluData->petid=49;
				$DurumluData->value=$value; // 0-Normal 1- Lost 2- Broken 3- Unreacheble
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
  
  public static function monitorUpdateData($checkdate,$mobileworkordermonitorsid,$value)
  {
    	// Wdata1[id]: 498      mobileworkorderdata1[value]: 2
			$date=$checkdate;
			$date = str_replace('/', '-', $date);
			$yenitarih=strtotime($date);
	
			$modelD=Mobileworkorderdata::model()->findByPk($mobileworkordermonitorsid);
    

			if($modelD->petid==49)
			{
				$modelD->delete();
			}
			else{
				//print_r($modelD); echo "<br>";echo "<br>";echo "<br>";echo "<br>";
				$modelM=Mobileworkordermonitors::model()->findByPk($modelD->mobileworkordermonitorsid);
			  $modelM->checkdate=$modelM->checkdate==0?$yenitarih:$modelM->checkdate; //// sorulacak Mustafa Beye
				$modelM->saverid=Yii::app()->user->id;
				$modelM->update();
				///
				$modelD->createdtime=$yenitarih;
				$modelD->saverid=Yii::app()->user->id;
				$modelD->openedtimeend=$yenitarih;
				$modelD->value=$value;
				$modelD->update();
       $check=Mobileworkorderdata::model()->find(array('condition'=>'petid=49 and workorderid='.intval($modelD['workorderid']).'  and mobileworkordermonitorsid='.intval($modelD['mobileworkordermonitorsid'])));
        if(isset($check->id) && $check->id>0)
        {
          $deletemonitors1=Mobileworkorderdata::model()->deleteall(array('condition'=>'id='.$check->id));
        }
			}
  }
  
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Workorder the static model class
	 */
  
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
