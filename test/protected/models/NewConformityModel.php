<?php

/**
 * This is the model class for table "firm".
 *
 * The followings are the available columns in table 'firm':
 * @property integer $id
 * @property integer $parentid
 * @property string $name
 * @property string $username
 * @property string $title
 * @property string $taxoffice
 * @property string $taxno
 * @property string $address
 * @property string $landphone
 * @property string $email
 * @property string $package
 * @property string $image
 * @property integer $createdtime
 * @property integer $active
 */
class NewConformityModel extends CActiveRecord
{

  public function conformityList($request)
	{
    
		$ax= User::model()->userobjecty('');
		$response=Yii::app()->db->createCommand()
		->select("cn.id as id,cn.statusid as statusid,
		DATE_FORMAT(FROM_UNIXTIME(cn.date), '%Y-%m-%d') as acilmaTarihi,
		IFNULL(FROM_UNIXTIME(cn.closedtime),'') as closedtime,
		IFNULL(f.name,'') as firmName,
		IFNULL(b.name,'') as branchName,
		c.name as clientName,
		IFNULL(d.name,'') as departmentName,
		IFNULL(sd.name,'') as subName,
		ct.name as conType,
		IF(cn.type=1,'".t('Cracks, Crevices')."',
			IF(cn.type=5,'".t('Environmental Risk')."',
			IF(cn.type=3,'".t('Equipment not Working ')."',
			IF(cn.type=10,'".t('Equipment Missing')."',
			IF(cn.type=11,'".t('Insulation Lack')."',
			IF(cn.type=12,'".t('Cleaning Error')."',
			IF(cn.type=13,'".t('Storage Error')."',
			IF(cn.type=14,'".t('Staff Error')."','".t('Other')."'
			)))))))) as conType,
		IF(cn.statusid=0,'".t('Pending')."',
			IF(cn.statusid=1,'".t('Closed')."',
			IF(cn.statusid=2,'".t('OK - Completed')."',
			IF(cn.statusid=3,'".t('Efficiency Follow-Up')."',
			IF(cn.statusid=4,'".t('Continues')."',
			IF(cn.statusid=5,'".t('Viewed')."','".t('NOK - Completed')."'
			)))))) as conStatus,
		CONCAT(u.name,' ',u.surname) as userName,
		IF(cn.statusid=0,'#c8d2f9','') as color,
		IFNULL(cn.definition,'') as definition,
		IFNULL(cn.suggestion,'') as suggestion,
		CONCAT(cn.priority,' ','".t('Degree')."')  as priority,
		IFNULL(ca.nokdefinition,'') as nokdefinition,
		IFNULL(ca.date,'') as deadline,
		IFNULL(ecv.activitydefinition,'') as etkinlik,
		IFNULL(ca.definition,'') as activitydefinition,
		CONCAT(IFNULL(assign.assignname,''),' ',IFNULL(assign.assignsurname,''))  as assignNameSurname,
		IF((cn.statusid=4 || cn.statusid=5 || cn.statusid=6 || cn.statusid=2 || cn.statusid=0),'',(IF(ecv.activitydefinition=NULL || ecv.activitydefinition='','".t("Etkinlik Yok")."','".t("Etkinlik Var")."'))) as etkinlikDurumu,
		cn.numberid as cnumber,
		cn.filesf as filesf,
    cn.firmid,
    cn.firmbranchid,
    cn.clientid,
    cn.departmentid,
    cn.subdepartmentid,
    cn.type,
    cn.priority,
    ca.okUser,
    ca.nokUser,
    ecv.user_id as etkinlik_user,
    ca.nokdate,
    ca.okdate,
    ca.id as conactivityid
    ")
		->from('conformity cn')
		->leftJoin('user u','u.id=cn.userid')
		->leftJoin('firm f','f.id=cn.firmid')
		->leftJoin('firm b','b.id=cn.branchid')
		->leftJoin('client c','c.id=cn.clientid')
		->leftJoin('departments d','d.id=cn.departmentid')
		->leftJoin('departments sd','sd.id=cn.subdepartmentid')
		->leftJoin('conformitytype ct','ct.id=cn.type')
		->leftJoin('conformityactivity ca','cn.id=ca.conformityid')
		->leftJoin('efficiencyevaluation ecv','ecv.conformityid=cn.id')
		->leftJoin('conformityuserassign cua','cua.conformityid=cn.id')
		->leftJoin('(select u.name as assignname,u.surname as assignsurname, cua.conformityid as assignconformityid,cua.id as assignid from conformityuserassign cua
left join user u on u.id=cua.recipientuserid
where cua.returnstatustype=1 and cua.id not in (SELECT cua.id FROM `conformityuserassign` cua
left join conformityuserassign cua2 on cua2.conformityid=cua.conformityid
left join user u on u.id=cua.recipientuserid
where cua.returnstatustype=1 and cua2.returnstatustype=2 and cua2.parentid=cua.id)) as assign','assign.assignconformityid=cn.id')
		->where('cn.deletecbranch!=0');

		if($ax->firmid!=0 && $ax->branchid==0)
		{
			$response=$response->andwhere('cn.firmid='.$ax->firmid);
		}
		if($ax->branchid!=0 && $ax->clientid==0)
		{
			$response=$response->andwhere('cn.branchid='.$ax->branchid);
		}
		if($ax->clientid!=0 && $ax->clientbranchid==0)
		{
			$clientArray=Yii::app()->db->createCommand()
			->select(["id"])
			->from('client')
			->where('parentid='.$ax->clientid)
			->queryAll();
			$response=$response->andwhere('cn.clientid in ('.implode(',', array_column($clientArray, 'id')).')');
		}
		if($ax->clientbranchid!=0)
		{
			$response=$response->andwhere('cn.clientid='.$ax->clientbranchid);
		}

		///kriterlere göre query and where
		if(isset($request['status']))
		{
			$status=json_decode($request['status']);
			if(gettype($status)=='array' &&  is_countable($status) && count($status)>0)
			{
				$response=$response->andwhere('cn.statusid in ('.implode(",", $status).')');
			}
			if(gettype($status)!='array') {
				$response=$response->andwhere('cn.statusid='.$request['status']);
			}

		}
		if(isset($request['firm']) && $request['firm']!='' && $request['firm']!=0)
		{
				$response=$response->andwhere('cn.firmid='.$request['firm']);
		}
		if(isset($request['client']) && $request['client']!='' && $request['client']!=0)
		{
			$response=$response->andwhere('cn.clientid='.$request['client']);
		}
		else {
			if(isset($request['branch']) && $request['branch']!='' && $request['branch']!=0)
				{
						$response=$response->andwhere('cn.branchid='.$request['branch']);
				}
		}
		if(isset($request['department']))
		{
			$department=json_decode($request['department']);
			if(is_countable($department) &&  count($department)>0)
			{
					$response=$response->andwhere('cn.departmentid in ('.implode(",", $department).')');
			}
		}
		if(isset($request['subdepartment']))
		{
			$subdepartment=json_decode($request['subdepartment']);
			if(is_countable($subdepartment) &&  count($subdepartment)>0)
			{
					$response=$response->andwhere('cn.subdepartmentid in ('.implode(",", $subdepartment).')');
			}
		}
		if(isset($request['conformitytype']))
		{
			$conformitytype=json_decode($request['conformitytype']);
			if(is_countable($conformitytype) &&  count($conformitytype)>0)
			{
					$response=$response->andwhere('cn.type in ('.implode(",", $conformitytype).')');
			}
		}
		if(isset($request['startDate']))
		{
			$response=$response->andwhere('cn.date>='.strtotime($request['startDate'].' 00:00:00'));
		}
		if(isset($request['finishDate']))
		{
			$response=$response->andwhere('cn.date<='.strtotime($request['finishDate'].' 23:59:59'));
		}
    
    	if(isset($request['id']))
		{
			$response=$response->andwhere('cn.id='.intval($request['id']));
		}
    
		$response=$response->order("cn.id asc")->group("cn.id")->queryAll();
    
    if(isset($request['id']))
		{
			$responseAssign=Yii::app()->db->createCommand()
		  ->select("ca.*,CONCAT(usender.name,' ',usender.surname) usenderns,CONCAT(urecipient.name,' ',urecipient.surname) urecipientns,IF(ca.returnstatustype=1,'Atama yapıldı','Atama geri çevrildi') atamaDurumu,DATE_FORMAT(FROM_UNIXTIME(ca.sendtime), '%Y-%m-%d') as tarih",)
      ->from('conformityuserassign ca')
		  ->leftJoin('user usender','usender.id=ca.senderuserid')
      ->leftJoin('user urecipient','urecipient.id=ca.recipientuserid')
      ->where('ca.conformityid='.intval($request['id']));
      $responseAssign=$responseAssign->order("ca.id asc")->queryAll();
      $response[0]['activity']=$responseAssign;
      $ax= User::model()->userobjecty('');
      if($response['statusid']==0 && $ax->clientid!=0)
      {
        $response[0]['deadlineForm']=1;
      }
      else
      {
        $response[0]['deadlineForm']=0;
      }
      
			$cstatus=$response[0]['statusid'];
      $uygunssuzlukAtama=$responseAssign[count($responseAssign)-1];
      $userType='f';
      if($ax->clientid!=0 || $ax->clientbranchid!=0)
      {
       // NewConformityModel::model()->conformityStatusUpdate($id,5);
        $userType='c';
      }
      if($userType=='c' && $cstatus==5 && $uygunssuzlukAtama['returnstatustype']==1 && $uygunssuzlukAtama['recipientuserid']==$ax->id)
      {
        // atama kendisine yapılmış ve geri döndürebilir
        $response[0]['cactivityStatus']=1;
      }
      else  if($userType=='c' && $cstatus==5 && $uygunssuzlukAtama['returnstatustype']==1 && $uygunssuzlukAtama['recipientuserid']!=$ax->id)
      {
        //formlar atamayı beklediğinden kapalı olacak
        $response[0]['cactivityStatus']=2;
      }
      else if($userType=='c' && $cstatus==5)
      {
        //atama yapabilir
        $response[0]['cactivityStatus']=3;
      }
      else if($userType=='f' && $cstatus==5)
      {
        //formlar atamayı beklediğinden kapalı olacak
        $response[0]['cactivityStatus']=2;
      }
    
      else if($userType=='f' && $cstatus==4)
      {
        //ok - nok buttonları aktif olacak
        $response[0]['cactivityStatus']=4;
      }
      else if($userType=='f' && $cstatus==2)
      {
        //ok - nok buttonları aktif olacak /// ok tarihi güncelleme açık olacak
        $response[0]['cactivityStatus']=5;
      }
       else if($userType=='f' && $cstatus==3)
      {
        //ok - nok buttonları aktif olacak
         if($response[0]['okUser']>0)
         {
           $response[0]['cactivityStatus']=6;
         }
         else
         {
           $response[0]['cactivityStatus']=7;
         }
      }
       else if(($userType=='c' && ($cstatus==2 || $cstatus==3 || $cstatus==1)) || ($userType=='f' && $cstatus==1))
      {
         if($response[0]['okUser']>0)
         {
           $response[0]['cactivityStatus']=8;
         }
         else
         {
           $response[0]['cactivityStatus']=9;
         }
       }
      
		}
    
    
		return ["data"=>$response,"status"=>true];

	}
  
  public function conformityDetail($request)
  {
    return self::conformityList($request);
  }
  
  public function conformityStatusUpdate($id,$status)
  {
      $model=Conformity::model()->findByPk($id);
      if($model->statusid==0)
      {
        $model->statusid=$status;
        $model->save();
      }
  }
  public function conformityCreateUpdate($request,$file)
  {
    	$ax= User::model()->userobjecty('');
    if(!empty($request))
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Conformity;
      }else{
        $model=Conformity::model()->findByPk($request['id_cu']);
      }
      if($model)
      {
        //guncel number
        $yeniYilDate=strtotime(date("y")."-01-01");
        $cli=Client::model()->find(array('condition'=>'id='.$request['clientbranch_cu']));

        $clix=Conformity::model()->findAll(array('condition'=>'deletecbranch='.$cli->id.' && date>'.$yeniYilDate));

        $say=count($clix)+1;
        $de=date("y",strtotime($request['date_cu']));
        $number=$de.'.'.$cli->id.'.'.$say;

        //guncel number finish

			  $model->numberid=$number;
        $model->userid=$ax->id;
        $model->firmid=$request['firm_cu'];
        $model->firmbranchid=$request['branch_cu'];
        $model->branchid=$request['branch_cu'];
        $model->clientid=$request['clientbranch_cu'];
        $model->departmentid=$request['department_cu'];
        $model->subdepartmentid=$request['subdepartment_cu'];
        $model->type=$request['type_cu'];
        $model->priority=$request['priority_cu'];
        $model->date=strtotime($request['date_cu']);
        $model->definition=$request['definition_cu'];
        $model->suggestion=$request['suggestion_cu'];
        $model->statusid=0;
        $model->deletecbranch=$request['clientbranch_cu'];
     
        $model->isefficiencyevaluation=0;
        $model->endofdayemail=0;
        $model->closedtime=null;
       
        $model->deneme=0;
        $model->sira=0;
        $firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$request['firm_cu'])));
        $path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/';
        if(isset($file['filesf_cu']))
        {
          if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
          {
            mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
          }
          
          $type=explode('.',$file['filesf_cu']['name']);
          $upload_status = move_uploaded_file($file['filesf_cu']['tmp_name'], ($path.time().'.'.($type[count($type)-1]))); 
          $model->filesf='/uploads/'.$firm->username.'/'.time().'.'.($type[count($type)-1]);
        }
        else
        {
          $model->filesf="";
        }
        
          if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
      }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }
    
  }
  
  public function ConformityUnicNameBul($name,$say)
{
     $userName=NewFirmModel::model()->usernameproduce($name);
     $newitem=Conformity::model()->find(array('condition'=>'username="'.$userName.'"'));
      if($newitem)
      {
        $say++;
         NewConformityModel::model()->ConformityUnicNameBul($userName.'_'.$say,$say);
      }
      else
      {
        return $userName;
      }
}
  
  public function conformitydelete($request)
  {
    if($request['id_delete']!=0 && $request['id_delete']!='')
    {
        $model=Conformity::model()->findByPk($request['id_delete']);
        if($model->delete())
        {
           return ["data"=>[],"status"=>true];
         }
       return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
    }
    return ["data"=>"Müşteri Bulunamadı","status"=>500];
  }
  
  public function conformityisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Conformity::model()->findByPk($request['id']);
      if($model)
      {
          $model->active=$model->active==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Müşteri Bulunamadı","status"=>500];
  }

  
  
  public function conformityAssignUsers($id)
  {
    $ax=User::model()->userobjecty('');
    	$responseAssign=Yii::app()->db->createCommand()
		  ->select("CONCAT(u.name,' ',u.surname) nameSurname,u.id")
      ->from('AuthAssignment aa')
		  ->leftJoin('user u','u.id=aa.userid');
      if($ax->clientid!=0 && $ax->clientbranchid==0)
      {
              $where="itemname in (SELECT CONCAT(f.package,'.',f.username,'.',fb.username,'.',c.username,'.Admin') FROM conformity cn
              left join firm f on f.id=cn.firmid
              left join firm fb on fb.id=cn.firmbranchid
              left join client cb on cb.id=cn.clientid
              left join client c on c.id=cb.parentid
              where cn.id=".$id.")
              OR
              itemname in (SELECT CONCAT(f.package,'.',f.username,'.',fb.username,'.',c.username,'.Staff') FROM conformity cn
              left join firm f on f.id=cn.firmid
              left join firm fb on fb.id=cn.firmbranchid
              left join client cb on cb.id=cn.clientid
              left join client c on c.id=cb.parentid
              where cn.id=".$id.")
              OR
              itemname in (SELECT CONCAT(f.package,'.',f.username,'.',fb.username,'.',c.username,'.',cb.username,'.Admin') FROM conformity cn
              left join firm f on f.id=cn.firmid
              left join firm fb on fb.id=cn.firmbranchid
              left join client cb on cb.id=cn.clientid
              left join client c on c.id=cb.parentid
              where cn.id=".$id.")
              OR
              itemname in (SELECT CONCAT(f.package,'.',f.username,'.',fb.username,'.',c.username,'.',cb.username,'.Staff') FROM conformity cn
              left join firm f on f.id=cn.firmid
              left join firm fb on fb.id=cn.firmbranchid
              left join client cb on cb.id=cn.clientid
              left join client c on c.id=cb.parentid
              where cn.id=".$id.")
              ";
      }
      else if($ax->clientid!=0 && $ax->clientbranchid!=0)
      {
              $where="
              itemname in (SELECT CONCAT(f.package,'.',f.username,'.',fb.username,'.',c.username,'.',cb.username,'.Admin') FROM conformity cn
              left join firm f on f.id=cn.firmid
              left join firm fb on fb.id=cn.firmbranchid
              left join client cb on cb.id=cn.clientid
              left join client c on c.id=cb.parentid
              where cn.id=".$id.")
              OR
              itemname in (SELECT CONCAT(f.package,'.',f.username,'.',fb.username,'.',c.username,'.',cb.username,'.Staff') FROM conformity cn
              left join firm f on f.id=cn.firmid
              left join firm fb on fb.id=cn.firmbranchid
              left join client cb on cb.id=cn.clientid
              left join client c on c.id=cb.parentid
              where cn.id=".$id.")
              ";
      }
       $where="(".$where.") and u.id!=".$ax->id;
       $responseAssign=$responseAssign->where($where);
       $responseAssign=$responseAssign->order("CONCAT(u.name,' ',u.surname) asc")->queryAll();
       array_unshift($responseAssign, ["id"=>"","nameSurname"=>t("Seçiniz")]);
   
    return ["data"=>$responseAssign,"status"=>true];
    
  }
  
  
  public function assignCreate($request)
  {
    $ax=User::model()->userobjecty('');
    $model=new Conformityuserassign;
		$model->id=0;
		$model->conformityid=$request['conformityid_as'];
		$model->senderuserid=$ax->id;
		$model->recipientuserid=$request['conformityassignusers_id'];
		$model->sendtime=time();
		$model->returnstatustype=1;
		$model->parentid=0;
		$model->definition="";
		if(!$model->save())
		{
			return ["data"=>"Atama yapılamadı","status"=>500];
		}


		$sender=User::model()->find(array('condition'=>'id='.$ax->id));
		$senderemail=$sender->email;
		$sendername=$sender->name.' '.$sender->surname;
		$buyer=User::model()->find(array('condition'=>'id='.$request['conformityassignusers_id']));
		$conformity=Conformity::model()->find(array('condition'=>'id='.$request['conformityid_as']));
		$clientname=Client::model()->find(array('condition'=>'id='.$conformity->clientid))->name;

		$buyeremail=$buyer->email;
		//  $buyeremail='fcurukcu@gmail.com';
		$buyername=$buyer->name.' '.$buyer->surname;

		$subject=User::model()->dilbul($buyer->languageid,'Uygunsuzluk faliyet-termin tanımı');
		$altbody=User::model()->dilbul($buyer->languageid,'Aşağıda bildirilen uygunsuzluk için faliyet tanımı ve termin tarihi tanımlamasını yapınız.');


		$msg=$altbody."<br>".User::model()->dilbul($sender->languageid,'Url').':<a href="https://insectram.io/conformity/activity/'.$request['conformityid_as'].'">'.$conformity->numberid.'</a>';

		//Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);
    Conformity::model()->email('fcurukcu@gmail.com',$sendername,$subject,$altbody,$msg,'fcurukcu@gmail.com',$buyername);


		Logs::model()->logsaction();
		/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
	  return ["data"=>[],"status"=>true];
  }
  
  
  public function returnassign($request)
	{
    $ax=User::model()->userobjecty('');
		$model=new Conformityuserassign;
		$model->id=0;
		$model->conformityid=$request['conformityid_as'];
		$model->senderuserid=$ax->id;
		$model->recipientuserid=$request['senderuser_as'];
		$model->sendtime=time();
		$model->returnstatustype=2;
		$model->parentid=$request['returnassign_as'];

		if(!isset($request['returnaassignmessage_as']) || $request['returnaassignmessage_as']=='')
		{
					$model->definition='-';

		}else {
				$model->definition=$request['returnaassignmessage_as'];
		}
    
    if(!$model->save())
		{
			return ["data"=>"Atama geri gönderilemedi","status"=>500];
		}

		$sender=User::model()->find(array('condition'=>'id='.$ax->id));
		$senderemail=$sender->email;
		$sendername=$sender->name.' '.$sender->surname;
		$buyer=User::model()->find(array('condition'=>'id='.$request['senderuser_as']));
		$conformity=Conformity::model()->find(array('condition'=>'id='.$request['conformityid_as']));
		$clientname=Client::model()->find(array('condition'=>'id='.$conformity->clientid))->name;

		$buyeremail=$buyer->email;
		//  $buyeremail='fcurukcu@gmail.com';
		$buyername=$buyer->name.' '.$buyer->surname;
		$subject=$sendername.' '.User::model()->dilbul($buyer->languageid,'Uygunsuzluk tanımını kabul etmedi.');
		$altbody=$clientname.' '.$subject;
		$msg=$clientname.' '.$subject.User::model()->dilbul($userx->languageid,'Url').':<a href="https://development.insectram.io/conformity/activity/'.$request['conformityid_as'].'">'.$conformity->numberid.'</a>';

		Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);

		/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
		return ["data"=>[],"status"=>true];
	}
  
  public function deadlineCreate($request)
  {
    $ax= User::model()->userobjecty('');
		$model=new Conformityactivity;
		$activity=Conformityactivity::model()->findAll(array(
								   'condition'=>'definition=:definition and conformityid=:conformityid and date=:date','params'=>array('definition'=>$request['definition_cu'],'conformityid'=>$request['conformityid_cu'],'date'=>$request['date_cu'])
							   ));
		$conformityupdate=Conformity::model()->find(array(
								   'condition'=>'id=:conformityid','params'=>array('conformityid'=>$request['conformityid_cu'])
							   ));

		
		if(count($activity)==0)
		{
		  $model->definition=$request['definition_cu'];
      $model->conformityid=$request['conformityid_cu'];
      $model->date=$request['date_cu'];
			$model->isactive=1;
			$model->deadlineUser=$ax->id;
      $model->okUser=0;
      $model->nokUser=0;
			if($model->save() && $conformityupdate->statusid==5)
			{
				$conformityupdate->statusid=4;
				$conformityupdate->save();
        return ["data"=>"","status"=>true];
			}
	
    }
	  return ["data"=>"Faliyet tarihi verme sırassında hata ile karşılaşıldı","status"=>500];

  }
 
  
  public function Conformityok($request)
  {
    $ax= User::model()->userobjecty('');
		$activity=Conformityactivity::model()->find(array(
								   'condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$request['okconformityid_cu'])
							   ));
		$conformityupdate=Conformity::model()->find(array(
								   'condition'=>'id=:conformityid','params'=>array('conformityid'=>$request['okconformityid_cu'])
							   ));

		
		if(isset($activity))
		{
      $activity->okdate=$request['okdate_cu'];
			$activity->isactive=1;
			$activity->okUser=$ax->id;
			if($activity->save() && $conformityupdate->statusid==4)
			{
				$conformityupdate->statusid=2;
				$conformityupdate->save();
        return ["data"=>"","status"=>true];
			}
	
    }
	  return ["data"=>"Uygunsuzluk tamamlanamadı","status"=>500];

  }
  
  public function Conformitynok($request)
  {
    $ax= User::model()->userobjecty('');
		$activity=Conformityactivity::model()->find(array(
								   'condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$request['nokconformityid_cu'])
							   ));
		$conformityupdate=Conformity::model()->find(array(
								   'condition'=>'id=:conformityid','params'=>array('conformityid'=>$request['nokconformityid_cu'])
							   ));

		
		if(isset($activity))
		{
      $activity->nokdate=$request['nokdate_cu'];
      $activity->nokdefinition=$request['nokdefinition_cu'];
			$activity->isactive=1;
			$activity->nokUser=$ax->id;
			if($activity->save() && $conformityupdate->statusid==4)
			{
				$conformityupdate->statusid=6;
				$conformityupdate->save();
        return ["data"=>"","status"=>true];
			}
	
    }
	  return ["data"=>"Uygunsuzluk nok-tamamlanmadı olarak kapaatılamadı","status"=>500];

  }
  public function conformitykapat($request)
  {
    $ax= User::model()->userobjecty('');
		$conformityupdate=Conformity::model()->find(array(
								   'condition'=>'id=:conformityid','params'=>array('conformityid'=>$request['kapanmaconformityid_cu'])
							   ));

		  $conformityupdate->statusid=1;
      $conformityupdate->closedtime=$request['kapanmadate_cu'];
    
			if($conformityupdate->save())
			{
        return ["data"=>"","status"=>true];
			}
	  return ["data"=>"Uygunsuzluk kapatılamadı","status"=>500];

  }
  
    
  public function conformityetkinliktanimi($request)
  {
    $ax= User::model()->userobjecty('');
		$activity=Conformityactivity::model()->find(array(
								   'condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$request['etkinlik_conformityid_cu'])
							   ));
		$conformityupdate=Conformity::model()->find(array(
								   'condition'=>'id=:conformityid','params'=>array('conformityid'=>$request['etkinlik_conformityid_cu'])
							   ));
    
    $efficiencyevaluation=Efficiencyevaluation::model()->find(array(
								   'condition'=>'conformityid=:conformityid','params'=>array('conformityid'=>$request['etkinlik_conformityid_cu'])
							   ));
    if(isset($request['yes_no']) && intval($request['yes_no'])==1)
    {
      if(!isset($request['etkinlik_definition_cu']) || intval($request['etkinlik_definition_cu'])==""
        && !isset($request['etkinlik_date_cu']) || intval($request['etkinlik_date_cu'])==""
        )
        {
          return ["data"=>"Etkinklik tarihi ve etkinlik tanımı kısımları zorunlu alanlardır.Lütfen bu alanları doldurunuz.","status"=>500];
        }
       $efficiencyevaluation=new Efficiencyevaluation;
       $efficiencyevaluation->conformityid=$request['etkinlik_conformityid_cu'];
       $efficiencyevaluation->controldate=$request['etkinlik_date_cu'];
       $efficiencyevaluation->activitydefinition=$request['etkinlik_definition_cu'];
       $efficiencyevaluation->user_id=$ax->id;
       if($efficiencyevaluation->save())
        {
          	$conformityupdate->statusid=3;
            $conformityupdate->save();
            return ["data"=>"","status"=>true];
        }
        return ["data"=>"Etkinlik kaydedilemedi","status"=>500];
    }
    if(isset($request['yes_no']) && intval($request['yes_no'])==0)
    {
        $conformityupdate->statusid=3;
				$conformityupdate->save();
        return ["data"=>"","status"=>true];
    }
    
	  return ["data"=>"Etkinlik var veya yok durumu seçmelisiniz.","status"=>500];

  }
  
  


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Firm the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
