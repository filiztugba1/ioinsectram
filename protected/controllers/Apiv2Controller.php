<?php

class Apiv2Controller extends Controller
{
    //public $layout = 'main';
    /**
     * Declares class-based actions.
     */

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST requesti
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }
    

    public function actionCloseconformity(){
        $str=file_get_contents('php://input');
        $str=json_decode($str);
        $err=false;

        if($str->id)
        {
          $model=Conformity::model()->findByPk($str->id);
          if($model)
          {

              if(isset($str->status))
              {
                $modelActivity=Conformityactivity::model()->find(array('condition'=>'conformityid='.$str->id));
                $modelActivity->isactive=1;

                $model->statusid = $str->status;
                if($str->status==2)
                {
                  // ok baba tamamlandı
                  //$model->statusid=2; // OK COMPLETED
                  $modelActivity->okdate=date('Y-m-d', time());
                }
                else if($str->status==6){
                  // not ok baba tamamlanmadı
                  //$model->statusid=6; // NOK - Completed

                  $modelActivity->nokdefinition=$str->comment;
                  $modelActivity->nokdate=date('Y-m-d', $str->date);


                }
                else if($str->status==3)
                {
                  $modelActivity->okdate=date('Y-m-d', $str->date);
                }

                if($modelActivity->save())
                {
                  if($str->status==3)
                  {
                    $etkinlikTakibi=new Efficiencyevaluation;
                    $etkinlikTakibi->conformityid=$str->id;
                    $etkinlikTakibi->controldate=$str->date;
                    $etkinlikTakibi->activitydefinition=$str->comment;
                    $etkinlikTakibi->save();

                  }

                    $model->closedtime=time();
                  if($model->save())
                  {
                      $this->result('','Eklendi');
                  }
                  else {
                    $err="modeli kaydetmedi";
                  }
                  exit;
                }
                else{
                    $err="modelactivity kaydetmedi";
                }


              }
              else{
                $err="is ok gelmedi";
              }
          }

        }
        else{
          $err="id gelmemis hacim";
        }


        if($err)
        {
          $this->result($err); exit;
        }
    }

    //conformitylerin liste seklinde toptan alınması ve toplu sekilde kapatılmasi
    //yeni mobil versiyonda bu endpoint kullanılacak ve tek tek gonderip cevap beklemektense
    //zaman tasarrufu saglanacak
    public function actionCloseconformities(){
        $strler=file_get_contents('php://input');
        $strler=json_decode($strler);
        $err=false;

        foreach($strler as $str)
        {

            if($str->id)
            {
              $model=Conformity::model()->findByPk($str->id);
              if($model)
              {

                  if(isset($str->status))
                  {
                    $modelActivity=Conformityactivity::model()->find(array('condition'=>'conformityid='.$str->id));
                    $modelActivity->isactive=1;

                    $model->statusid = $str->status;
                    if($str->status==2)
                    {
                      // ok baba tamamlandı
                      //$model->statusid=2; // OK COMPLETED
                      $modelActivity->okdate=date('Y-m-d', time());
                    }
                    else if($str->status==6){
                      // not ok baba tamamlanmadı
                      //$model->statusid=6; // NOK - Completed

                      $modelActivity->nokdefinition=$str->comment;
                      $modelActivity->nokdate=date('Y-m-d', $str->date);


                    }
                    else if($str->status==3)
                    {
                      $modelActivity->okdate=date('Y-m-d', $str->date);
                    }

                    if($modelActivity->save())
                    {
                      if($str->status==3)
                      {
                        $etkinlikTakibi=new Efficiencyevaluation;
                        $etkinlikTakibi->conformityid=$str->id;
                        $etkinlikTakibi->controldate=$str->date;
                        $etkinlikTakibi->activitydefinition=$str->comment;
                        $etkinlikTakibi->save();

                      }

                        $model->closedtime=time();
                      if($model->save())
                      {
                          $this->result('','Eklendi');
                      }
                      else {
                        $err="modeli kaydetmedi";
                      }
                      exit;
                    }
                    else{
                        $err="modelactivity kaydetmedi";
                    }


                  }
                  else{
                    $err="is ok gelmedi";
                  }
              }

            }
            else{
              $err="id gelmemis hacim";
            }

        }

        if($err)
        {
          $this->result($err); exit;
        }
    }


public function actionConformities()
{

	 $user=$this->autoauth();

	if($user['type']==13)
	{
		$model=array();
	}
	else
	{

		$model=Yii::app()->db->createCommand('SELECT conformity.*,workorder.date as workorderdate,workorder.finish_time as finishtime,workorder.start_time FROM conformity INNER JOIN workorder ON workorder.clientid=conformity.clientid where
		(conformity.statusid=4 or conformity.statusid=3) and workorder.status!=3 and workorder.branchid='.$user['branchid'].' group by conformity.id')->queryall();
	}

    $array=array();
  
	for($i=0;$i<count($model);$i++)
	{
		//$workorderdate=strtotime($model[$i]['workorderdate'].' '.$model[$i]['finishtime'].':00');
        $workorderdate=time();
		if($workorderdate>=$model[$i]['date'])
		{


      if($model[$i]['statusid']==3)
      {
          $etkinliktarihix=Efficiencyevaluation::model()->find(array('condition'=>'conformityid='.$model[$i]['id']));
        $date=strtotime($etkinliktarihix->controldate);
        if($date<time())
        {
          array_push($array,array(
            'id'=>$model[$i]['id'],
            //'userid'=>$model[$i]['userid'],
            //'firmid'=>$model[$i]['firmid'],
            //'firmbranchid'=>$model[$i]['firmbranchid'],
            //'branchid'=>$model[$i]['branchid'],
            //'clientid'=>$model[$i]['clientid'],
            'clientname'=>Client::model()->findbypk($model[$i]['clientid'])->name,
            //'departmentid'=>$model[$i]['departmentid'],
            //'subdepartmentid'=>$model[$i]['subdepartmentid'],
            'departmentname'=>Departments::model()->findByPk($model[$i]['departmentid'])->name,
            'subdepartmentname'=>Departments::model()->findByPk($model[$i]['subdepartmentid'])->name,
            //'type'=>$model[$i]['type'],
            'typename'=>Conformitytype::model()->findByPk($model[$i]['type'])->name,
            'status'=> $model[$i]['statusid'],
            //'numberid'=> $model[$i]['numberid'],
            'definition'=>$model[$i]['definition'],
            'suggestion'=>$model[$i]['suggestion'],
            'priority'=>$model[$i]['priority'],
            'date'=>date("d-m-Y H:i",$model[$i]['date']),
            'comment'=>"",
            'closed'=>false,
            'image'=>"https://insectram.io".$model[$i]['filesf'],

          ));
        }
      }else {
      array_push($array,array(
        'id'=>$model[$i]['id'],
        //'userid'=>$model[$i]['userid'],
        //'firmid'=>$model[$i]['firmid'],
        //'firmbranchid'=>$model[$i]['firmbranchid'],
        //'branchid'=>$model[$i]['branchid'],
        //'clientid'=>$model[$i]['clientid'],
        'clientname'=>Client::model()->findbypk($model[$i]['clientid'])->name,
        //'departmentid'=>$model[$i]['departmentid'],
        //'subdepartmentid'=>$model[$i]['subdepartmentid'],
        'departmentname'=>Departments::model()->findByPk($model[$i]['departmentid'])->name,
        'subdepartmentname'=>Departments::model()->findByPk($model[$i]['subdepartmentid'])->name,
        //'type'=>$model[$i]['type'],
        'typename'=>Conformitytype::model()->findByPk($model[$i]['type'])->name,
        'status'=> $model[$i]['statusid'],
        //'numberid'=> $model[$i]['numberid'],
        'definition'=>$model[$i]['definition'],
        'suggestion'=>$model[$i]['suggestion'],
        'priority'=>$model[$i]['priority'],
        'comment'=>"",
        'closed'=>false,
        'date'=>date("d-m-Y H:i",$model[$i]['date']),
        'image'=>"https://insectram.io".$model[$i]['filesf'],

      ));
      }

		}
	}


    $this->result('',$array);
}

    public function result($errorx='',$result='')
    {
        header('Content-type: application/json');
        if ($errorx=='')
        {
            http_response_code(200);
            $res='';
            if(is_string($result)) {
                echo '"'.$result.'"';
            }
            else {
                echo str_replace('xx!!!xx','',json_encode(is_array($result)?(array)$result:(object)$result,  JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));
            }
        }
        else if($errorx == 'logout') 
        {
            http_response_code(401);
            echo 'logout';
        }
        else
        {
            http_response_code(400);
            echo str_replace('xx!!!xx','',$errorx);
        }
        exit;
    }

    public function getauth($u='',$p='',$onesignalid='')
    {
    
      
        $user = User::model()->find(
            array('condition' => '(email=:socialid) or (username=:socialid)','params'    => array(':socialid' =>$u))
        );
        if($user===null){
            $this->result('User not found.');
        }else
        {
            if(!CPasswordHelper::verifyPassword($p,$user->password)){
                $this->result('Wrong Password.');
            }
            else
            {
                $send=  $this->userinfo($user->id);
				if (isset($_SERVER['HTTP_DEVICEID']))
				{
					$a=Userdeviceid::model()->deleteall(array('condition'=>'userid='.$user->id));

					$a=new Userdeviceid;
					$a->userid=$user->id;
					$a->deviceid=$_SERVER['HTTP_DEVICEID'];
					$a->date=time();
					$a->save();
				}else
				{
					$this->result('Missing device id!');
				}
				
				$userlog=new Userlog;
                $userlog->userid=$user->id;
                $userlog->username=$user->username;
                $userlog->name=$user->name;
                $userlog->surname=$user->surname;
                $userlog->email=$user->email;
                $userlog->ipno=getenv("REMOTE_ADDR");
                $userlog->ismobilorweb="mobil";
                $userlog->entrytime=time();
                $userlog->save();
				
                $this->result('',array_merge($send,array('auth'=>(string)$user->code)));
            }
        }
    }

	public function actionErrors(){
			$user=$this->autoauth();
			$str=file_get_contents('php://input');


			$model= new AppErrors;
			$model->data=$str;
			$model->createdtime=time();
			if($model->save())
			{
				$this->result('Basarili');
			}
			else{
				$this->result($model->getErrors());
			}
	}

    public function userinfo($id,$who=null)
    {
        $user = User::model()->findbypk($id);
        if($user===null)
        {
            $this->result('User not found.');
        }else
        {
            if ($who==null)
            {
                $userclientname=Client::model()->findByPk($user->clientid);

                $auth=AuthAssignment::model()->find(array('condition'=>'userid='.$user->id));
                $yetki=explode(".",$auth->itemname);
                return array(
                    'id'=>$user->id,
                    'username'=>$user->username,
                    'namesurname'=>$user->name.' '.$user->surname,
                    'firmid'=>$user->firmid,
                    'clientid'=>$user->clientid,
                    'clientname'=>$userclientname->name,
                    'type'=>$yetki[count($yetki)-1],
                    'loggedIn'=>true
                );
            }else
            {
                $userclientname=Client::model()->findByPk($user->clientid);
                return array(
                    'id'=>$user->id,
                    'username'=>$user->username,
                    'namesurname'=>$user->name.''.$user->surname,
                    'firmid'=>$user->firmid,
                    'clientid'=>$user->clientid,
                    'clientname'=>$userclientname->name

                );
            }
        }
    }



    ////////////\\\\\\\\\\\\
    public function auth()
    {
        $code=$_SERVER['HTTP_AUTHORIZATION'];
        $user = User::model()->find(array('condition' => 'code=:code','params'=> array(':code' =>$code)));
        if($user===null)
        {
            $this->result('Authorization problem. Please login.');
        }else
        {



            $info=$this->userinfo($user->id);
            return $info;
        }
    }
    ////////////\\\\\\\\\\\\
    public function getuserid()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])){return 0;}
        $code=$_SERVER['HTTP_AUTHORIZATION'];
        $user =
            User::model()->find(array('condition' => 'code=:code','params'    => array(':code' =>$code)));
        if($user===null)
        {
            return 0;
        }else
        {
            return $user->id;
        }
    }
    ////////////\\\\\\\\\\\\
    public function autoauth()
    {
      
     
        if (isset($_SERVER['HTTP_AUTHORIZATION'])){
            $code=$_SERVER['HTTP_AUTHORIZATION'];

            $user = User::model()->find(
                array(
                    'condition' => 'code=:code',
                    'params'    => array(':code' =>$code)
                )
            );
            if($user===null)
            {
                $this->result('Authorization problem. Please login.'.$code);
                exit;
            }else
            {
					if (isset($_SERVER['HTTP_DEVICEID']))
					{
					$a=Userdeviceid::model()->find(array('condition'=>'userid='.$user->id.' and deviceid="'.$_SERVER['HTTP_DEVICEID'].'"'));
					//if(isset($user->languageid))
					if (isset($_SERVER['HTTP_LANG']))
					{
						if($_SERVER['HTTP_LANG']=="en")
						{
							$ddil="en";
						}
						else{
							$ddil="tr";
						}

					 $dir=dirname(__FILE__);
					 $dir= rtrim($dir,"/controllers");
					 $langfileurl=$dir.'/modules/translate/languages/'.$ddil.'.php';

					 include $langfileurl;
					}
					//$a=Userdeviceid::model()->find(array('condition'=>'userid='.$user->id.' and deviceid like "%'.$_SERVER['HTTP_DEVICEID'].'%"'));
					if (!$a)
					{
						$this->result('logout');
					}
				}
				else
				{
					$this->result('logout');
				}
                return $user;
            }
        }
        else{
            $this->result('Authorization problem. Please login..');
            exit;
        }
    }
    ////////////\\\\\\\\\\\\
    public function actionLogin($u='',$p='')
    { 
        /// user auth code geri d�necek$jsonbody=array();
        if ($u==''){$this->result('Invalit Code or Username.');}
        $auth=$this->getauth($u,$p);
    }
    ////////////\\\\\\\\\\\\
    public function actionLogout()
    {
        $user=$this->autoauth();
        //$model=User::model()->findbypk($user->id);
        //$model->onesignalid='';
        //$model->update();
        $this->result('');
    }
    ////////////\\\\\\\\\\\\
    public function actionUser($id=null)
    {
        if ($id==null)
        {
            $user=$this->auth();
            $this->result('',$user);
        }else {
            $info=$this->userinfo($id,1);
            $this->result('',$info);
        }
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
public function actionWorkorderpackage(){
  $user=$this->autoauth();
      $idlist=[];
	if (isset($_REQUEST['ids']))
  {

    $ids=explode(',',$_REQUEST['ids']);
    if (is_countable($ids) && count($ids)>0){
      foreach ($ids as $item){
        if(is_numeric($item)){
          $idlist[]=$item;
        }else{
          	$this->result('Id eror.','Id eror.');
        }
      }
    }

  }

$ax= User::model()->find(array("condition"=>"id=".$user->id));

  /*  $userlog=new Userlog;
    $userlog->userid=$user->id;
    $userlog->username=$user->username;
    $userlog->name=$user->name;
    $userlog->surname=$user->surname;
    $userlog->email=$user->email;
    $userlog->ipno=getenv("REMOTE_ADDR");
    $userlog->ismobilorweb="mobil";
    $userlog->entrytime=time();
    $userlog->save();*/

  $listworkorder=array();
  $listmonitor=array();
  $listdata=array();
  $arrayClientsids=array();
  $datestart=date("Y-m-d");
  $datefinish=date("Y-m-d",strtotime('+1 week'));
  
    if( is_countable($idlist) && count($idlist)>0){
    $workorders=Workorder::model()->findAll(array('condition'=>'id in('.implode(',',$idlist).') and date<="'.$datefinish.'" and status!=3 and branchid='.$ax->branchid,'order'=>'date ASC, start_time ASC'));
  }else{
        $workorders=Workorder::model()->findAll(array('condition'=>'date<="'.$datefinish.'" and status!=3 and branchid='.$ax->branchid,'order'=>'date ASC, start_time ASC'));
      }
  

 $itfirmlist=[];
if($user->id!=1)
{
  foreach ($workorders as $workorder)
  {

      if ($workorder->teamstaffid || $workorder->teamstaffid!=0)
      {
          $staffteam=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid.' and (leaderid='.$user->id.' or staff like "%'.$user->id.'%")'));
      }
      if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
      {
      $date = strtotime($workorder->date);
      if (($workorder->firmid==1 && $date<= strtotime('+3 days')) || ($workorder->firmid!=1 && $date<= strtotime('+7 days'))){ 
          array_push($arrayClientsids,$workorder->clientid);

          $workordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorder->id,'order'=>'monitorno asc'));
          if ($workordermonitors)
          {
              foreach ($workordermonitors as $workordermonitor)
              {
                  $workorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id,'order'=>'monitorid asc, id asc'));
                  if($workorderdatas)
                  {
         foreach ($workorderdatas as $workorderdata)
                            {
              $pet=Pets::model()->findByPk($workorderdata->petid);
               array_push($listdata,array(
                 'id'=>$workorderdata->id,
                 'title'=>t($pet->name),//alper bura
                 'petid'=>$workorderdata->petid,
                 'pettype'=>$workorderdata->pettype,
                 'value'=>$workorderdata->value,
                 'isproduct'=>$workorderdata->isproduct
               ));
               $title='';

                      }
                      }
                  }

                  array_push($listmonitor,array(
                      'id'=>$workordermonitor->id,
                      'workorderid'=>$workorder->id,
                      'monitorid'=>$workordermonitor->monitorid,
                      'monitorno'=>$workordermonitor->monitorno,
                      'monitortype'=>$workordermonitor->monitortype,
                      'barcodeno'=>'xx!!!xx'.$workordermonitor->barcodeno,
                      'monitorStatus'=>0,
                      'checkdate'=>$workordermonitor->checkdate,
                      'monitorData'=>$listdata
                  ));
                  unset($listdata);
                  $listdata=array();
              }
          }

        
      
          if ($workorder->staffid <> '')
          {
              $staffid=$workorder->staffid;
          }
          else
          {
              $staffid=0;
          }
        
          //array_push($listworkorder,$listmonitor  );
     
        //  unset($listmonitor);
        //  $listmonitor=array();
          //////end

  } // date kontrol end


  }
  //} // staff team staff kontrol end
  // Workorder End

  }







    $this->result('',($listmonitor));
}
    public function actionFirms()
    {
        $user=$this->autoauth();
        $ax= User::model()->find(array("condition"=>"id=".$user->id));
        if($ax->branchid==0)
    	 {
    
    		$Firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
    	 }
    	 else
    	 {
    		 $Firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
    	 }
        $list=array();
        foreach ($Firms as $Firm)
        {
            array_push($list,array(
                'id'=>$Firm->id,
                'parentid'=>0,
                'name'=>$Firm->name,
                'title'=>$Firm->title,
            ));
        }
        $this->result('',$list);
    }

    public function actionClients($firmid)
    {
        $list = array();
        $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firmid,'order'=>'name'));
        if ($clients)
        {
            foreach ( $clients as $client){
                array_push($list,array(
                    'id'=>$client->id,
                    'parentid'=>$client->firmid,
                    'name'=>$client->name,
                    'title'=>$client->title,
                ));
            }
        }
        $this->result('',$list);
    }

    public function actionBranchs($clientid)
    {
        $list = array();
        $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$clientid,'order'=>'name'));
        if ($clientsbranchs) {
            foreach ( $clientsbranchs as $branch){
                array_push($list,array(
                    'id'=>$branch->id,
                    'parentid'=>$branch->parentid,
                    'name'=>$branch->name,
                    'title'=>$branch->title,
                ));
            }
            
        }
        $this->result('',$list);
    }
    
    public function actionDepartments($branchid)
    {
        $Departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$branchid,'order'=>'name'));
        $list=array();
        if ($Departments)
        {
            foreach ($Departments as $Department)
            {
                array_push($list,array(
                    'id'=>$Department->id,
                    'parentid'=>$Department->parentid,
                    'name'=>$Department->name,
                    'title'=>""
                ));
            }
        }
        
        $this->result('',$list);
    }
    
    public function actionSubDepartments($departmentid)
    {
        $Subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and parentid='.$departmentid,'order'=>'name'));
        $list=array();
        if ($Subdepartments)
        {
            foreach ($Subdepartments as $Subdepartment)
            {
                array_push($list,array(
                    'id'=>$Subdepartment->id,
                    'clientid'=>$Subdepartment->clientid,
                    'parentid'=>$Subdepartment->parentid,
                    'name'=>$Subdepartment->name,
                    'title'=>""
                ));
            }
        }
        
        $this->result('',$list);
    }
 public function actionAddconformity()
    {

     $str=file_get_contents('php://input');
  	 $filenamex='apilogs_v2/'.time().'-conformity.txt';
      file_put_contents($filenamex, $str);

  		///
  				$user=$this->autoauth();
  				$str=file_get_contents('php://input');
  				$gelen=json_decode($str);
	        $varmi=Conformity::model()->find(array("condition"=>"
          definition like '%".$gelen->definition."%' and
        	suggestion like '%".$gelen->suggestion."%' and
        	type=".$gelen->type." and
        	branchid=".$gelen->branchid." and
        	clientid=".$gelen->clientid." and
        	departmentid=".$gelen->departmentid." and
        	subdepartmentid=".$gelen->subdepartmentid));
  				if($varmi){
  					$this->result('Zaten Eklendi.');
  				}
  				else{
  					$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
  					$content= base64_decode($gelen->picture);
  					$file = fopen($targetPath, 'w');
  					fwrite($file, $content);
  					fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz

  					$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
  					if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
  					{
  						mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}
  					else{
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}

  					$model=new Conformity;
  					$firmsd=Firm::model()->findByPk($gelen->branchid);
  					$model->firmid=$firmsd->parentid;
  					$model->branchid=$gelen->branchid;
  					$model->firmbranchid=$gelen->branchid;
  					$model->clientid=$gelen->clientid;//$_REQUEST['clientid'];
  					$model->departmentid=$gelen->departmentid;
  					$model->subdepartmentid= $gelen->subdepartmentid;
  					$model->type=$gelen->type;
  					$model->priority= $gelen->priority;
  					$model->date=time();
  					$model->definition= $gelen->definition;
  					$model->suggestion=$gelen->suggestion;
  					$model->filesf='/uploads/'.$firm->username.'/'.$imagename;
  					$model->statusid=0;
  					$model->isefficiencyevaluation=0;
  					$model->endofdayemail=0;
  					$model->userid=$user->id;

  					$model->userid=$user->id;


  					//guncel number
            $yeniYilDate=strtotime(date("y")."-01-01");
            $cli=Client::model()->find(array('condition'=>'id='.$gelen->clientid));

            $clix=Conformity::model()->findAll(array('condition'=>'deletecbranch='.$cli->id.' && date>'.$yeniYilDate));

            if (is_countable($clix) ){
  					$say=count($clix)+1;
            }else{
              $say=1;
            }
  					$de=date("y",time());
  					 $number=$de.'.'.$cli->id.'.'.$say;

  					 $model->numberid=$number;
  					 $model->deletecbranch=$gelen->clientid;

  					//guncel number finish


  					if($model->save())
  					{
  						$this->result('','Eklendi');
  					}
  					else {
  						$this->result($model->getErrors());
  					}
  				}
    }
    public function actionAddconformityyedek()
    {
 
     $str=file_get_contents('php://input');
  	 $filenamex='apilogs_v2/'.time().'-conformity.txt';
      file_put_contents($filenamex, $str);

  		///
  				$user=$this->autoauth();
  				$str=file_get_contents('php://input');
  				$gelen=json_decode($str);
  			
	        $varmi=Conformity::model()->find(array("condition"=>"
          definition like '%".$gelen->definition."%' and
        	suggestion like '%".$gelen->suggestion."%' and
        	type=".$gelen->type." and
        	branchid=".$gelen->branchid." and
        	clientid=".$gelen->clientid." and
        	departmentid=".$gelen->departmentid." and
        	subdepartmentid=".$gelen->subdepartmentid));
  				if($varmi){
  					$this->result('','Zaten Eklendi.');
  				}
  				else{
  					$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
  					$content= base64_decode($gelen->picture);
  					$file = fopen($targetPath, 'w');
  					fwrite($file, $content);
  					fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz

  					$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
  					if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
  					{
  						mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}
  					else{
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}

  					$model=new Conformity;
  					//$firmsd=Firm::model()->findByPk($gelen->branchid);
  					$model->firmid=$gelen->firmid;
  					$model->branchid=$gelen->branchid;
  					$model->firmbranchid=$gelen->branchid;
  					$model->clientid=$gelen->clientid;//$_REQUEST['clientid'];
  					$model->departmentid=$gelen->departmentid;
  					$model->subdepartmentid= $gelen->subdepartmentid;
  					$model->type=$gelen->type;
  					$model->priority= $gelen->priority;
  					$model->date=time();
  					$model->definition= $gelen->definition;
  					$model->suggestion=$gelen->suggestion;
  					$model->filesf='/uploads/'.$firm->username.'/'.$imagename;
  					$model->statusid=0;
  					$model->isefficiencyevaluation=0;
  					$model->endofdayemail=0;
  					$model->userid=$user->id;

  					$model->userid=$user->id;


  					//guncel number
            $yeniYilDate=strtotime(date("y")."-01-01");
            $cli=Client::model()->find(array('condition'=>'id='.$gelen->clientid));

            $clix=Conformity::model()->findAll(array('condition'=>'deletecbranch='.$cli->id.' && date>'.$yeniYilDate));

            if (is_countable($clix) ){
  					$say=count($clix)+1;
            }else{
              $say=1;
            }
  					$de=date("y",time());
  					 $number=$de.'.'.$cli->id.'.'.$say;

  					 $model->numberid=$number;
  					 $model->deletecbranch=$gelen->clientid;

  					//guncel number finish


  					if($model->save())
  					{
  						$this->result('','Eklendi'.$model->id);
  					}
  					else {
  						$this->result($model->getErrors());
  					}
  				}
    }

    public function actionAddconformity2()
    {
        $dosya = fopen('ip2.php', 'r');
        $icerik = fread($dosya, filesize('ip2.php'));
        $gelen=json_decode($icerik);
  			//$user=$this->autoauth();
	        $varmi=Conformity::model()->find(array("condition"=>"
          definition like '%".$gelen->definition."%' and
        	suggestion like '%".$gelen->suggestion."%' and
        	type=".$gelen->type." and
        	branchid=".$gelen->branchid." and
        	clientid=".$gelen->clientid." and
        	departmentid=".$gelen->departmentid." and
        	subdepartmentid=".$gelen->subdepartmentid));
  				if($varmi){
  					$this->result('','Zaten Eklendi.');
  				}
  				else{
  					$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
  					$content= base64_decode($gelen->picture);
  					$file = fopen($targetPath, 'w');
  					fwrite($file, $content);
  					fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz

  					$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
  					if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
  					{
  						mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}
  					else{
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}

  					$model=new Conformity;
  					$firmsd=Firm::model()->findByPk($gelen->branchid);
  					$model->firmid=$firmsd->parentid;
  					$model->branchid=$gelen->branchid;
  					$model->firmbranchid=$gelen->branchid;
  					$model->clientid=$gelen->clientid;//$_REQUEST['clientid'];
  					$model->departmentid=$gelen->departmentid;
  					$model->subdepartmentid= $gelen->subdepartmentid;
  					$model->type=$gelen->type;
  					$model->priority= $gelen->priority;
  					$model->date=time();
  					$model->definition= $gelen->definition;
  					$model->suggestion=$gelen->suggestion;
  					$model->filesf='/uploads/'.$firm->username.'/'.$imagename;
  					$model->statusid=0;
  					$model->isefficiencyevaluation=0;
  					$model->endofdayemail=0;
  					$model->userid=317; //317 mustafa


  					//guncel number
            $yeniYilDate=strtotime(date("y")."-01-01");
  					$cli=Client::model()->find(array('condition'=>'id='.$gelen->clientid));

  					$clix=Conformity::model()->findAll(array('condition'=>'deletecbranch='.$cli->id.' && date>'.$yeniYilDate));

  					if (is_countable($clix) ){
  					$say=count($clix)+1;
            }else{
              $say=1;
            }
  					$de=date("y",time());
  					 $number=$de.'.'.$cli->id.'.'.$say;

  					 $model->numberid=$number;
  					 $model->deletecbranch=$gelen->clientid;

  					//guncel number finish


  					if($model->save())
  					{
  						$this->result('','Eklendi');
  					}
  					else {
  						$this->result($model->getErrors());
  					}
  				}
    }

    //conformitylerin liste seklinde toptan alınması ve toplu sekilde eklenmesi
    //yeni mobil versiyonda bu endpoint kullanılacak ve tek tek gonderip cevap beklemektense
    //zaman tasarrufu saglanacak
    public function actionAddconformities()
    {
        $str=file_get_contents('php://input');
      	$filenamex='apilogs_v2/'.time().'-conformities.txt';
        file_put_contents($filenamex, $str);

  		///
  		$user=$this->autoauth();
  		$str=file_get_contents('php://input');
  		$gelenler=json_decode($str);
  		$errors = null;
  		foreach($gelenler as $gelen)
  		{
    	        $varmi=Conformity::model()->find(array("condition"=>"
              definition like '%".$gelen->definition."%' and
            	suggestion like '%".$gelen->suggestion."%' and
            	type=".$gelen->type." and
            	branchid=".$gelen->branchid." and
            	clientid=".$gelen->clientid." and
            	departmentid=".$gelen->departmentid." and
            	subdepartmentid=".$gelen->subdepartmentid));
  				if(!$varmi){
  					$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
  					$content= base64_decode($gelen->picture);
  					$file = fopen($targetPath, 'w');
  					fwrite($file, $content);
  					fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz

  					$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
  					if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
  					{
  						mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}
  					else{
  						$imagename=time().".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename('a.txt', $path);
  					}

  					$model=new Conformity;
  					$firmsd=Firm::model()->findByPk($gelen->branchid);
  					$model->firmid=$firmsd->parentid;
  					$model->branchid=$gelen->branchid;
  					$model->firmbranchid=$gelen->branchid;
  					$model->clientid=$gelen->clientid;//$_REQUEST['clientid'];
  					$model->departmentid=$gelen->departmentid;
  					$model->subdepartmentid= $gelen->subdepartmentid;
  					$model->type=$gelen->type;
  					$model->priority= $gelen->priority;
  					$model->date=time();
  					$model->definition= $gelen->definition;
  					$model->suggestion=$gelen->suggestion;
  					$model->filesf='/uploads/'.$firm->username.'/'.$imagename;
  					$model->statusid=0;
  					$model->isefficiencyevaluation=0;
  					$model->endofdayemail=0;
  					$model->userid=$user->id;

  					$model->userid=$user->id;


  					//guncel number
            $yeniYilDate=strtotime(date("y")."-01-01");
  					$cli=Client::model()->find(array('condition'=>'id='.$gelen->clientid));

  					$clix=Conformity::model()->findAll(array('condition'=>'deletecbranch='.$cli->id.' && date>'.$yeniYilDate));

  					if (is_countable($clix) ){
  					$say=count($clix)+1;
            }else{
              $say=1;
            }
  					$de=date("y",time());
  					 $number=$de.'.'.$cli->id.'.'.$say;

  					 $model->numberid=$number;
  					 $model->deletecbranch=$gelen->clientid;

  					//guncel number finish


  					if(!$model->save())
  					{
  						$errors = $model->getErrors();
  					}
  				}
  		}
  		
  		if($errors != null) $this->result($errors);
  		else $this->result('','Eklendi');
    }

    public function actionGetsubdepartments($departmentid)
    {
        $list=array();
        $subdepartment=Departments::model()->findAll(array(
            'order'=>'name ASC',
            'condition'=>'parentid='.$departmentid,
        ));
        if ($subdepartment)
        {
            foreach ($subdepartment as $Department)
            {
                array_push($list,array(
                    'id'=>$Department->id,
                    'clientid'=>$Department->clientid,
                    'parentid'=>$Department->parentid,
                    'name'=>$Department->name
                ));
            }
            $this->result('',$list);
        }
        else
        {
            $this->result('Parentid or clientid wrong');
        }
    }

    public function actionNonconformitytypes()
    {
		$user=$this->autoauth();
        $listconformitytypes = array();
        $types=Conformitytype::model()->findAll(array('condition'=>'isactive=1'));
        foreach ( $types as $type){
            array_push($listconformitytypes,array(
                'id'=>$type->id,
                'name'=>t($type->name)
            ));
        }
        $this->result('',$listconformitytypes);
    }

    public function actionNonconformitystatus()
    {
        $listconformitystatu = array();
        $status=Conformitystatus::model()->findAll(array('condition'=>'isactive=1'));
        foreach ( $status as $statu){
            array_push($listconformitystatu,array(
                'id'=>$statu->id,
                'name'=>t($statu->name)
            ));
        }
        $this->result('',$listconformitystatu);
    }


    public function actionFirmsbranch($id)
    {
        $Firms=Firm::model()->findAll(array('condition'=>'parentid='.$id));
        $list=array();
        foreach ($Firms as $Firm)
        {
            array_push($list,array(
                'id'=>$Firm->id,
                'firmid'=>$Firm->parentid,
                'name'=>$Firm->name,
                'username'=>$Firm->username,
                'title'=>$Firm->title,
                'taxoffice'=>$Firm->taxoffice,
                'taxno'=>$Firm->taxno,
                'address'=>$Firm->address,

            ));
        }
        $this->result('',$list);
    }

    public function actionGetmeds()
    {
		$user = $this->autoauth();
        $listfirms=array();
        $meds=array();

        $medfirms=Medfirms::model()->findAll(array('condition'=>'isactive=1 and branchid='.$user->branchid.' or firmid='.$user->firmid));
		if(!$medfirms)
		{
			 $medfirms=Medfirms::model()->findAll(array('condition'=>'isactive=1 and branchid=0 and firmid=0'));
		}
        foreach ($medfirms as $medfirm)
        {
            $medss=Meds::model()->findAll(array('condition'=>'isactive=1 and medfirmid='.$medfirm->id));
            foreach($medss as $med)
            {
				$unit=Units::model()->findByPk($med->unit);
                array_push($meds,array(
                    'id'=>$med->id,
                    'name'=>$med->name,
                    'unit'=>$unit->name
                ));
            }
            array_push($listfirms,array(
                'id'=>$medfirm->id,
                'name'=>$medfirm->name,
                'meds'=>$meds
            ));
            $meds=array();
        }
        $this->result('',$listfirms);
    }
    
      public function actionMenu()
    {
        $user=$this->autoauth();
        $listmenu=[];
        $listmenu2=[];
        
        ///ilk buton
         array_push($listmenu2,array(
                      'name'=>'İş kabul',
                      'url'=>'https://insectram.io/',
                      'login'=>true,
                  ));
         array_push($listmenu2,array(
                      'name'=>'Uygunsuzluklar',
                      'url'=>'https://insectram.io/',
                      'login'=>true,
                  ));
        
          array_push($listmenu,array(
                      'name'=>'Yönetim Butonu',
                      'data'=>$listmenu2,
                  ));
        /// 2. buton
        $listmenu2=[];
           array_push($listmenu2,array(
                      'name'=>'Süt söyle',
                      'url'=>'https://insectram.io/',
                      'login'=>true,
                  ));
         array_push($listmenu2,array(
                      'name'=>'Kola söyle',
                      'url'=>'https://insectram.io/',
                      'login'=>true,
                  ));
        
          array_push($listmenu,array(
                      'name'=>'Eğlence Butonu',
                      'data'=>$listmenu2,
                  ));
        
        
        
        $this->result('',$listmenu);
      }
    public function actionWorkordersold()
    {
        $user=$this->autoauth();
        $datestart=date("Y-m-d");
        $datefinish=date("Y-m-d",strtotime('+1 week'));
        $workorders=Workorder::model()->findAll(array('condition'=>'date<="'.$datefinish.'" and status!=3 and branchid='.$user->branchid,'order'=>'date ASC, start_time ASC'));
        $listworkorder = array();
        
        foreach ($workorders as $workorder)
        {
            if ($workorder->teamstaffid || $workorder->teamstaffid!=0)
             {
                  $staffteam=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid.' and (leaderid='.$user->id.' or staff like "%'.$user->id.'%")'));
             }
             if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
             {
              $date = strtotime($workorder->date);
              if ($date<= strtotime('+3 days')){
                $visittype=Visittype::model()->findByPk($workorder->visittypeid);
                $workclient=Client::model()->findByPk($workorder->clientid);
                $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorder->id));
                array_push($listworkorder,array(
                      'id'=>$workorder->id,
                      'date'=>$workorder->date,
                      'start_time'=>$workorder->start_time,
                      'finish_time'=>$workorder->finish_time,
                      'service_report_ok'=> $modelServiceR != null,
                      'visittypename'=>$visittype->name,
                      'clientname'=>$workclient->name,
                      'todo'=>$workorder->todo,
                      'branchid'=>$workorder->clientid,
                      'branchname'=>$workclient->name,
                      'barcode'=>$workorder->barcode,
                      //'isnewbarcode'=>0,
                      'status'=>$workorder->status,
                      'realstarttime'=>0,
                      'realendtime'=>0,
                      'synced'=>true,
                  ));
                }
             }
        }
        
        $this->result('',$listworkorder);
    }
    
    public function actionMonitors($workorderid)
    {
        //$user=$this->autoauth();
        if (isset($workorderid))
		{
		    $listmonitor = array();
            $workordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorderid,'order'=>'monitorno asc'));
            if ($workordermonitors)
            {
              foreach ($workordermonitors as $workordermonitor)
              {
                  array_push($listmonitor,array(
                      'id'=>$workordermonitor->id,
                      'workorderid'=>$workorderid,
                      'monitorno'=>$workordermonitor->monitorno,
                      'monitortype'=>$workordermonitor->monitortype,
                      'barcodeno'=>'xx!!!xx'.$workordermonitor->barcodeno,
                      'monitorStatus'=>0,
                      'checkdate'=>$workordermonitor->checkdate,
                      'newBarcodeValue'=>null,
                      'synced'=>true
                  ));
              }
            }
            
            $this->result('',$listmonitor);
		}
		else $this->result('workorderid parameter not found.');
    }
    
    public function actionMonitordata($monitorid = null) 
    {
        if (isset($monitorid))
		{
		    $listdata = array();
		    $workorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$monitorid,'order'=>'monitorid asc, id asc'));
            if($workorderdatas)
            {
                foreach ($workorderdatas as $workorderdata)
                {
                    $pet=Pets::model()->findByPk($workorderdata->petid);
                    array_push($listdata,array(
                     'id'=>$workorderdata->id,
                     'monitorid'=>$monitorid,
                     'title'=>$pet->name,
                     'petid'=>$workorderdata->petid,
                     'pettype'=>$workorderdata->pettype,
                     'value'=>$workorderdata->value,
                     'isproduct'=>$workorderdata->isproduct,
                     'synced'=>true
                   ));
                }
            }
            
            $this->result('',$listdata);
		}
		else $this->result('monitorid parameter not found.');
    }
    
    public function actionUpdateWorkorder() {
            
        $str=file_get_contents('php://input');
        $workorder=json_decode($str);
        
        if(!$workorder) return $this->result('workorder gerekli');
    
            $modelW=Workorder::model()->findByPk($workorder->id);
    		if($modelW)
    		{
                /*if ($workorder->new_barcode_value!=null) // Workorder Yeni Barcode ile Değiştirme
                {
                    $modelW->barcode=$workorder->new_barcode_value;
                }*/
    
            	if(strlen($workorder->start_time)>9)
            	{
            		if($modelW->realstarttime){
            			$yenibaslangic=substr($workorder->start_time,0,10);
            			if($yenibaslangic < $modelW->realstarttime)
            			{
            				$modelW->realstarttime=$yenibaslangic;
            			}
            			else{
            
            			}
            		}
            		else
            		{
            			$modelW->realstarttime=substr($workorder->start_time,0,10);
            		}
            		if(strlen($workorder->finish_time)>9) $modelW->realendtime=substr($workorder->finish_time,0,10);
            	}
    
            	if(isset($workorder->cant_scan_comment))
            	{
            		$modelW->cantscancomment=$workorder->cant_scan_comment;
            	}
    
            } /// Workorder varmı if'i
    
    
    		$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorder->id.' and checkdate=0'));
    		//$servisRaporVarMi = $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
    		if(!$isbiticekmi)
    		{
    			$modelW->status=3;
    			$modelW->executiondate=time();
    		}
    		else{
    
    			$modelW->status=$workorder->status;
    		}
    		$modelW->update();
    
    	    return $this->result('','Senkronizasyon başarılı');
    }
    
    public function actionUpdateMonitors(){
        $str=file_get_contents('php://input');
        $monitors =json_decode($str);
        $user=$this->autoauth();
        
        foreach($monitors as $monitor) {
        
            $modelM=Mobileworkordermonitors::model()->findByPk($monitor->id);
        
            if ($modelM)
			{
        
			    if($monitor->monitorStatus<>0)
			    {
				
					$modelVarmikayip=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$modelM->id.' and petid=49'));
					if(!$modelVarmikayip)
					{
						$DurumluData=new Mobileworkorderdata;
						$DurumluData->mobileworkordermonitorsid=$monitor->id;
						$DurumluData->workorderid=$modelM->workorderid;
						$DurumluData->monitorid=$modelM->monitorid;
						$DurumluData->monitortype=$monitor->monitortype;
						$DurumluData->pettype=0;
						$DurumluData->petid=49;
						$DurumluData->value=$monitor->monitorStatus; // 0-Normal 1- Lost 2- Broken 3- Unreacheble
						$DurumluData->saverid=$user->id;
						$DurumluData->createdtime=substr($monitor->checkdate,0,10);
						$DurumluData->firmid=$modelM->firmid;
						$DurumluData->firmbranchid=$modelM->firmbranchid;
						$DurumluData->clientid=$modelM->clientid;
						$DurumluData->clientbranchid=$modelM->clientbranchid;
						$DurumluData->departmentid=$modelM->departmentid;
						$DurumluData->subdepartmentid=$modelM->subdepartment;
						$DurumluData->openedtimestart=time();
						$DurumluData->openedtimeend=substr($monitor->checkdate,0,10);
						$DurumluData->isproduct=1;

						if(!$DurumluData->save()){
							return $this->result('','Kaydetme sırasında bir hata oluştu. '.json_encode($DurumluData->getErrors()));
						}
					}

			    }
			
	
                if($monitor->new_barcode_value!=null) // Monitor Barcode Numarası Değiştir
                {
    				$modelMonitoring=Monitoring::model()->findByPk($modelM->monitorid);
    				$modelMonitoring->barcodeno=$monitor->new_barcode_value;
    				$modelMonitoring->update();
                    //$modelM->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
                }
    				// Boş monitore checkdate atma
    			if($monitor->checkdate!=0)
    			{
    				$modelM->checkdate=substr($monitor->checkdate,0,10);
                    $modelM->saverid=$user->id;
    			}
                $modelM->update();

			}
			else return $this->result($monitor->id.' numarali monitor dbde bulunamadi.');
        }
           
        return $this->result('','Senkronizasyon başarılı');
    }
    
    public function actionUpdateMonitorDatas(){
        $str=file_get_contents('php://input');
        $monitorDatas =json_decode($str);
        $user=$this->autoauth();
        $checkDate = substr($_REQUEST['monitorcheckdate'],0,10);
        
        foreach($monitorDatas as $monitorData)  // Workorder Dataları kaydetme
        { // WorkOrderMonitorData

			    $modelD=Mobileworkorderdata::model()->findByPk($monitorData->id);
				if ($modelD){
					if ($monitorData->value != 0) // 0 olmayan verileri kaydet monitordata
					{
						$modelD->value=$monitorData->value;
						$modelD->saverid=$user->id;
						$modelD->createdtime=$checkDate;
						$modelD->openedtimeend=$checkDate;
						$modelD->update();
					}
					else  // ?????? veriyi üstüne kaydetmeden // createdat ve saveridyi kaydet
					{
						if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
						{
							$modelD->saverid=$user->id;
							$modelD->createdtime=$checkDate;
							$modelD->openedtimeend=$checkDate;
							$modelD->update();
						}
					}
				}
				/*else
				{ echo $workorders[$i]->workordermonitors[$j]->monitorData[$k]->id.'<br>'; }*/
        }
        
        return $this->result('','Senkronizasyon başarılı');
    }
    
    public function actionUpdateMonitorData() {
        $user=$this->autoauth();
        $dataId = $_REQUEST['id'];
        $checkDate = substr($_REQUEST['monitorcheckdate'],0,10);
        $value = $_REQUEST['value'];
        
        $modelD=Mobileworkorderdata::model()->findByPk($dataId);
		if ($modelD){
			if ($value != 0) // 0 olmayan verileri kaydet monitordata
			{
				$modelD->value=$value;
				$modelD->saverid=$user->id;
				$modelD->createdtime=$checkDate;
				$modelD->openedtimeend=$checkDate;
				$modelD->update();
			}
			else  // ?????? veriyi üstüne kaydetmeden // createdat ve saveridyi kaydet
			{
				if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
				{
					$modelD->saverid=$user->id;
					$modelD->createdtime=$checkDate;
					$modelD->openedtimeend=$checkDate;
					$modelD->update();
				}
			}
		}
		else return $this->result('Monitor data bulunamadi.');
		
		return $this->result('','Senkronizasyon başarılı');
    }
    
    public function actionAddservicereport() {
        $user=$this->autoauth();
        $str=file_get_contents('php://input');
        $serviceReport = json_decode($str);
        $workOrderId = $serviceReport->workOrderID;
        
        $workOrder = Workorder::model()->findByPk($workOrderId);
        
        if($workOrder && $serviceReport)
        {
			// Daha önce service raporu gelmiş mi diye kontrol ediyoruz :)
			$modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workOrderId));
			if($modelServiceR)
			{
                $this->result('','Zaten Eklenmiş');
			}
			else{
				// Techinician sign
				$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
				$content= base64_decode($serviceReport->technicianSignature);
				$file = fopen($targetPath, 'w');
				fwrite($file, $content);
				fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
				// Client sign
				$targetPath2="b.txt"; /// json decode edilince içine base64 kodu gelecek
				$content2= base64_decode($serviceReport->clientSignature);
				$file2 = fopen($targetPath2, 'w');
				fwrite($file2, $content2);
				fclose($file2); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
            // Servis raporu resmi
        if (isset($serviceReport->serviceReportPicture)){
				$targetPath3="c.txt"; /// json decode edilince içine base64 kodu gelecek
				$content3= base64_decode($serviceReport->serviceReportPicture);
				$file3 = fopen($targetPath3, 'w');
				fwrite($file3, $content3);
				fclose($file3); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
          }
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
				if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
				{
					mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
					$imagename=time().".png";
					$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
					rename('a.txt', $path);

					$imagename2=time()."1".".png";
					$path2=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename2;
					rename('b.txt', $path2);
          
            if (isset($serviceReport->serviceReportPicture)){
            $imagename3=time()."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename('c.txt', $path3);
          }
				}
				else{
					$imagename=time().".png";
					$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
					rename('a.txt', $path);

					$imagename2=time()."1".".png";
					$path2=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename2;
					rename('b.txt', $path2);
          
            if (isset($serviceReport->serviceReportPicture)){
            $imagename3=time()."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename('c.txt', $path3);
            }
				}

                $visittype=Visittype::model()->findByPk($workOrder->visittypeid);
				//$servicereports=$workorders[$i]->customer_service_report->applied_insecticides;
				$workclient=Client::model()->findByPk($workOrder->clientid);
				$modelS=new Servicereport;
				$modelS->client_name=$workclient->name;
				$modelS->date=time();
				$modelS->reportno=$workOrder->id;
				$modelS->visittype=$visittype->name;
				$modelS->trade_name=$serviceReport->signerName;
				$modelS->servicedetails=$serviceReport->detailsOfService;

				/*foreach ($servicereports as $servicereport){
					$modelA=new Activeingredients;
					$modelA->workorderid=$workorders[$i]->id;
					$modelA->trade_name=$servicereport->tradeName;
					$modelA->active_ingredient=$servicereport->activeIngredient;
					$modelA->amount_applied=$servicereport->amountApplied;
					$modelA->save();
				} */
				$modelS->riskreview=$serviceReport->riskReviewAndRecommendations;
				$modelS->technician_sign='/uploads/'.$firm->username.'/'.$imagename;
				$modelS->client_sign='/uploads/'.$firm->username.'/'.$imagename2;
         
            if (isset($serviceReport->serviceReportPicture)){
				  $modelS->picture='/uploads/'.$firm->username.'/'.$imagename3;
            }
				$modelS->save();
				$this->result('','Senkronizasyon başarılı');
			}
        }
        else $this->result('Service report veya work order bulunamadi.');
    }
    
    public function actionWorkoerderBundle() {
        $user=$this->autoauth();

      $ax= User::model()->find(array("condition"=>"id=".$user->id));
      // Clients & Clients Branchs--
      //giriş logları
        $userlog=new Userlog;
        $userlog->userid=$user->id;
        $userlog->username=$user->username;
        $userlog->name=$user->name;
        $userlog->surname=$user->surname;
        $userlog->email=$user->email;
        $userlog->ipno=getenv("REMOTE_ADDR");
        $userlog->ismobilorweb="mobil";
        $userlog->entrytime=time();
        $userlog->save();

      $listworkorder=array();
      $listmonitor=array();
      $listdata=array();
      $arrayClientsids=array();
    $datestart=date("Y-m-d");
    $datefinish=date("Y-m-d",strtotime('+1 week'));
      $workorders=Workorder::model()->findAll(array('condition'=>'date<="'.$datefinish.'" and status!=3 and branchid='.$ax->branchid,'order'=>'date ASC, start_time ASC'));
      //$workorders=Workorder::model()->findAll(array('condition'=>'branchid='.$user->branchid)); //
    if($user->id!=1)
    {
      foreach ($workorders as $workorder)
      {
          if ($workorder->teamstaffid || $workorder->teamstaffid!=0)
          {
              $staffteam=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid.' and (leaderid='.$user->id.' or staff like "%'.$user->id.'%")'));
          }
          if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
          {
          $date = strtotime($workorder->date);
          if ($date<= strtotime('+3 days')){ //+1 week di
              array_push($arrayClientsids,$workorder->clientid);
              // BEGIN
              $workordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorder->id,'order'=>'monitorno asc'));
              if ($workordermonitors)
              {
                  foreach ($workordermonitors as $workordermonitor)
                  {
                      $workorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id,'order'=>'monitorid asc, id asc'));
                      if($workorderdatas)
                      {
                //$levha=Mobileworkorderdata::model()->find(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id.' and monitortype=12','order'=>'monitorid asc, id asc'));
    
                foreach ($workorderdatas as $workorderdata)
                          {
    
    
                  $pet=Pets::model()->findByPk($workorderdata->petid);
                   array_push($listdata,array(
                     'id'=>$workorderdata->id,
                     'title'=>$pet->name,
                     'petid'=>$workorderdata->petid,
                     'pettype'=>$workorderdata->pettype,
                     'value'=>$workorderdata->value,
                     'isproduct'=>$workorderdata->isproduct
                   ));
                   $title='';
    
    
                          }
                      }
    
                      array_push($listmonitor,array(
                          'id'=>$workordermonitor->id,
                          'monitorid'=>$workordermonitor->monitorid,
                          'monitorno'=>$workordermonitor->monitorno,
                          'monitortype'=>$workordermonitor->monitortype,
                          'barcodeno'=>'xx!!!xx'.$workordermonitor->barcodeno,
                          'monitorStatus'=>0,
                          'checkdate'=>$workordermonitor->checkdate,
                          'monitorData'=>$listdata
                      ));
                      unset($listdata);
                      $listdata=array();
                  }
              }
    
              $branch=Firm::model()->findByPk($workorder->branchid);
              $workclient=Client::model()->findByPk($workorder->clientid);
              //$workclient=[];
              if ($workorder->staffid <> '')
              {
                  $staffid=$workorder->staffid;
              }
              else
              {
                  $staffid=0;
              }
    
              $visittype=Visittype::model()->findByPk($workorder->visittypeid);
              $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorder->id));
    
              array_push($listworkorder,array(
                  'id'=>$workorder->id,
                  'date'=>$workorder->date,
                  'start_time'=>$workorder->start_time,
                  'finish_time'=>$workorder->finish_time,
                  'service_report_ok'=> $modelServiceR != null,
                  'visittypename'=>$visittype->name,
                  'clientname'=>$workclient->name,
                  'todo'=>$workorder->todo,
                  'branchid'=>$workorder->clientid,
                  'branchname'=>$workclient->name,
                  'barcode'=>$workorder->barcode,
                  'status'=>$workorder->status,
                  'workordermonitors'=>$listmonitor,
              ));
              $workclient=null;
              unset($listmonitor);
              $listmonitor=array();
              //////end
    
      } // date kontrol end
    
    
      }
      //} // staff team staff kontrol end
      // Workorder End
    
      }
    }// foreach end
    
    $this->result('',$listworkorder);
    }
    
    /*public function actionPlaceBundle(){
        $user=$this->autoauth();
  
  $listfirms=array();
  $listfirmsbranchs=array();
  $listclients=array();
  $listclientsbranchs=array();
  $listdepartments=array();
  $listsubdepartments=array();

$clientler=array();

  $auth=AuthAssignment::model()->find(array('condition'=>'userid='.$user->id));
  $yetki=explode(".",$auth->itemname);
  // Staff deeeğeel admin
    $ax= User::model()->find(array("condition"=>"id=".$user->id));
        if($ax->branchid==0)
    	 {
    
    		$Firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
    	 }
    	 else
    	 {
    		 $Firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
    	 }
     

  if($yetki[count($yetki)-1]!="Admin")
  {
    
    //  $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$user->branchid)); // client
      if ($clientler)
      {

          foreach ( $clientler as $client)
          {
              $list2=array();
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$user->branchid.' and  parentid='.$client->id,'order'=>'name'));
              if ($clientsbranchs)
              {
                  foreach ($clientsbranchs as $clientsbranch)
                  {
                      // Departmens & Subdepartments
                      $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                      if($departments)
                      {
                          foreach ($departments as $department)
                          {
                              $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                              if($subdepartments)
                              {
                                  foreach ($subdepartments as $subdepartment)
                                  {
                                      array_push($listsubdepartments,array(
                                          'id'=>$subdepartment->id,
                                          'name'=>$subdepartment->name,
                                          'title'=>'',
                                          'parentid'=> $department->id
                                      ));
                                  }
                              }
                              
                              array_push($listdepartments,array(
                                  'id'=>$department->id,
                                  'name'=>$department->name,
                                  'title'=>'',
                                  'parentid'=>$clientsbranch->id,
                                  'subdepartments'=>$listsubdepartments
                              ));
                              unset($listsubdepartments);
                              $listsubdepartments=array();
                          }
                      }
                      
                      // Departmens & Subdepartments End--
                      array_push($list2, array(
                          'id' => $clientsbranch->id,
                          'parentid' => $client->id,
                          'name' => $clientsbranch->name,
                          'title' => $clientsbranch->title,
                          'departments'=>$listdepartments
                      ));

					   unset($listdepartments);
                              $listdepartments=array();
                  }
              }
              array_push($list,array(
                  'id'=>$client->id,
                  'parentid'=>$client->parentid,
                  'name'=>$client->name,
                  'title'=>$client->title,
                  'clientsbranchs'=>$list2
              ));
          }
      }
      $firms1=Firm::model()->findByPk($user->branchid);
      array_push($listfirms,array(
          'id'=>$firms1->id,
          'name'=>$firms1->name,
          'title'=>$firms1->title,
          'parentid'=>0,
          'clients'=>$list
      ));
  }
  else
  { // Elseeeeeexi
	  if($ax->branchid==0)
	  {

		$firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
	  }
	  else
	  {
		 $firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
	  }
      foreach ($firms as $firm)
      {

          $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firm->id,'order'=>'name'));
          foreach ($clients as $client)
          {
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$firm->id.' and active=1 and parentid='.$client->id,'order'=>'name'));
              foreach ($clientsbranchs as $clientsbranch)
              {
                  $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                  if($departments)
                  {
                      foreach ($departments as $department)
                      {
                          $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                          if($subdepartments)
                          {
                              foreach ($subdepartments as $subdepartment)
                              {
                                  array_push($listsubdepartments,array(
                                      'id'=>$subdepartment->id,
                                      'name'=>$subdepartment->name,
                                      'title'=>'',
                                      'parentid'=> $department->id
                                  ));
                              }
                          }
                          else {
                            array_push($listsubdepartments,array(
                                'id'=>0,
                                'name'=>"Sub departman yok",
                                'title'=>'',
                                'parentid'=> $department->id
                            ));
                          }
                          array_push($listdepartments,array(
                              'id'=>$department->id,
                              'name'=>$department->name,
                              'title'=>$clientsbranch->title,
                              'parentid'=> $clientsbranch->id,
                              'subdepartments'=>$listsubdepartments
                          ));
                          unset($listsubdepartments);
                          $listsubdepartments=array();
                      }
                  }
                  
                  array_push($listclientsbranchs,array(
                      'id'=>$clientsbranch->id,
                      'name'=>$clientsbranch->name,
                      'parentid'=>$client->id,
                      'title'=>$clientsbranch->title,
                      'departments'=>$listdepartments
                  ));
                  unset($listdepartments);
                  $listdepartments=array();
              }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'parentid'=>$firm->id,
                  'title'=>$client->title,
                  'clientsbranchs'=>$listclientsbranchs
              ));
              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }


          $trasferc='';
          $say=0;
          $clientbranchtrasfer=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid!=0 and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.') group by parentid'));
          foreach ($clientbranchtrasfer as $clientbranchtrasferx)
          {
            if($say==0)
            {
            $trasferc=$clientbranchtrasferx->parentid;
            }
            else {
              $trasferc=$trasferc.','.$clientbranchtrasferx->parentid;
            }
            $say++;
          }

            //filiiiiz canım iş arkadaşım sorun burda trasferc boş geliyor


          if($trasferc){
            $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and id in ('.$trasferc.')'));

          foreach ($clients as $client)
          {
            $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$client->id.' and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.')'));
            foreach ($clientsbranchs as $clientsbranch)
            {
                $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id));
                if($departments)
                {
                    foreach ($departments as $department)
                    {
                        $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id));
                        if($subdepartments)
                        {
                            foreach ($subdepartments as $subdepartment)
                            {
                                array_push($listsubdepartments,array(
                                    'id'=>$subdepartment->id,
                                    'name'=>$subdepartment->name,
                                    'title'=>'',
                                    'parentid'=>$department->id
                                ));
                            }
                        }
                        array_push($listdepartments,array(
                            'id'=>$department->id,
                            'name'=>$department->name,
                            'title'=>'',
                            'parentid'=>$clientsbranch->id,
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                    }
                }
                array_push($listclientsbranchs,array(
                    'id'=>$clientsbranch->id,
                    'name'=>$clientsbranch->name,
                    'parentid'=>$client->id,
                    'title'=>$clientsbranch->title,
                    'departments'=>$listdepartments
                ));
                unset($listdepartments);
                $listdepartments=array();
            }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'title'=>$client->title,
                  'parentid'=>$firm->id,
                  'clientsbranchs'=>$listclientsbranchs
              ));

              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }
        }



          array_push($listfirms,array(
              'id'=>$firm->id,
              'name'=>$firm->name,
              'title'=>$firm->title,
              'parentid'=>0,
              'clients'=>$listclients
          ));
          unset($listclients);
          $listclients=array();
      }
  }

  // else bitti
  // Clients & Clients Branchs End--
    $this->result('',array('firms'=>$listfirms));
    }*/
    
    public function actionPlaceBundle(){ // departman sub bu çekiyor -- live
        $user=$this->autoauth();
        $ax= User::model()->find(array("condition"=>"id=".$user->id));
   
        $list = array();
        $listdepartments=array();
        $listsubdepartments=array();
    
        $listfirms=array();
        $listfirmsbranchs=array();
        $listclients=array();
        $listclientsbranchs=array();
        $listdepartments=array();
        $listsubdepartments=array();

        $clientler=array();
        $arrayClientsids=array();

        $auth=AuthAssignment::model()->find(array('condition'=>'userid='.$user->id));
        $yetki=explode(".",$auth->itemname);
        // Staff deeeğeel admin
      
        $datestart=date("Y-m-d");
        $datefinish=date("Y-m-d",strtotime('+1 week'));
        $workorders=Workorder::model()->findAll(array('condition'=>'date<="'.$datefinish.'" and status!=3 and branchid='.$ax->branchid,'order'=>'date ASC, start_time ASC'));
        
        if($user->id!=1)
        {
          foreach ($workorders as $workorder)
          {
              
              if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
              {
                  $date = strtotime($workorder->date);
                  if ($date<= strtotime('+3 days')){ //+1 week di
                      array_push($arrayClientsids,$workorder->clientid);
                      
              } // date kontrol end
        
          }
          //} // staff team staff kontrol end
          // Workorder End
        
          }
        }// foreach end
    
      foreach ($arrayClientsids as $motherclient)
      {
          $clients=Client::model()->findByPk($motherclient); // client
          if(!in_array(Client::model()->findByPk($clients->parentid),$clientler))
          {
              array_push($clientler,Client::model()->findByPk($clients->parentid));
          }
      }


  if($yetki[count($yetki)-1]!="Admin")
  {

    //  $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$user->branchid)); // client
      if ($clientler)
      {

          foreach ( $clientler as $client)
          {
              $list2=array();
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$user->branchid.' and  parentid='.$client->id,'order'=>'name'));
              if ($clientsbranchs)
              {
                  foreach ($clientsbranchs as $clientsbranch)
                  {
                      // Departmens & Subdepartments
                      $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                      if($departments)
                      {
                          foreach ($departments as $department)
                          {
                              $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                              if($subdepartments)
                              {
                                  foreach ($subdepartments as $subdepartment)
                                  {
                                      array_push($listsubdepartments,array(
                                          'id'=>$subdepartment->id,
                                          'name'=>$subdepartment->name,
                                          'title'=>"",
                                          'parentid'=>$department->id
                                      ));
                                  }
                              }
                              /*else {
                                array_push($listsubdepartments,array(
                                    'id'=>0,
                                    'name'=>"Sub departman yok",
                                    'title'=>"",
                                    'parentid'=>$department->id
                                ));
                              }
                              array_push($listdepartments,array(
                                  'id'=>$department->id,
                                  'name'=>$department->name,
                                  'parentid'=>$clientsbranch->id,
                                  'subdepartments'=>$listsubdepartments
                              ));
                              unset($listsubdepartments);
                              $listsubdepartments=array();*/
                          }
                      }
                      /*else {

                        array_push($listsubdepartments,array(
                            'id'=>0,
                            'name'=>"Sub departman yok",
                            'title'=>"",
                            'parentid'=>$department->id,
                        ));
                        array_push($listdepartments,array(
                            'id'=>0,
                            'name'=>"Departman Yok",
                            'title'=>"",
                            'parentid'=>$clientsbranch->id,
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                      }*/
                      // Departmens & Subdepartments End--
                      array_push($list2, array(
                          'id' => $clientsbranch->id,
                          'parentid' => $client->id,
                          'name' => $clientsbranch->name,
                          'title' => $clientsbranch->title,
                          'departments'=>$listdepartments
                      ));

					   unset($listdepartments);
                              $listdepartments=array();
                  }
              }
              array_push($list,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'title'=>$client->title,
                  'parentid'=>$client->firmid,
                  'clientsbranchs'=>$list2
              ));
          }
      }
      $firms1=Firm::model()->findByPk($user->branchid);
      array_push($listfirms,array(
          'id'=>$firms1->id,
          'name'=>$firms1->name,
          'parentid'=>0,
          'clients'=>$list
      ));
  }
  else
  { // Elseeeeeexi
	  if($ax->branchid==0)
	  {

		$firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
	  }
	  else
	  {
		 $firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
	  }
      foreach ($firms as $firm)
      {

          $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firm->id,'order'=>'name'));
          foreach ($clients as $client)
          {
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$firm->id.' and active=1 and parentid='.$client->id,'order'=>'name'));
              foreach ($clientsbranchs as $clientsbranch)
              {
                  $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                  $depx=[];
                  if($departments)
                  {
                  
                      foreach ($departments as $department)
                      {
                      
                          $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                          if($subdepartments)
                          {  
                              foreach ($subdepartments as $subdepartment)
                              {
                                
                                  array_push($listsubdepartments,array(
                                      'id'=>$subdepartment->id,
                                      'name'=>$subdepartment->name,
                                      'parent_id'=>$subdepartment->parentid,
                                      'title'=>$subdepartment->name,
                                  ));
                              }
                          }
                    
                          array_push($depx,array(
                      'id'=>$department->id,
                      'name'=>$department->name,
                      'title'=>$department->name,
                      'parentid'=>$clientsbranch->id,
                      'subdepartments'=>$listsubdepartments
                  ));
                        $listsubdepartments=[];
                        
                      }
                    
                    
                  }
               
                  array_push($listclientsbranchs,array(
                      'id'=>$clientsbranch->id,
                      'name'=>$clientsbranch->name,
                      'title'=>$clientsbranch->title,
                      'parentid'=>$client->id,
                      'departments'=>$depx
                  ));
                $depx=[];
                  unset($listsubdepartments);
                  $listsubdepartments=array();
              }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'title'=>$client->title,
                  'parentid'=>$client->firmid,
                  'clientsbranchs'=>$listclientsbranchs
              ));
              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }


          $trasferc='';
          $say=0;
          $clientbranchtrasfer=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid!=0 and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.') group by parentid'));
          foreach ($clientbranchtrasfer as $clientbranchtrasferx)
          {
            if($say==0)
            {
            $trasferc=$clientbranchtrasferx->parentid;
            }
            else {
              $trasferc=$trasferc.','.$clientbranchtrasferx->parentid;
            }
            $say++;
          }

            //filiiiiz canım iş arkadaşım sorun burda trasferc boş geliyor


          if($trasferc){
            $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and id in ('.$trasferc.')'));

          foreach ($clients as $client)
          {
            $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$client->id.' and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.')'));
            foreach ($clientsbranchs as $clientsbranch)
            {
                $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id));
                if($departments)
                {
                    foreach ($departments as $department)
                    {
                        $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id));
                        if($subdepartments)
                        {
                            foreach ($subdepartments as $subdepartment)
                            {
                                array_push($listsubdepartments,array(
                                    'id'=>$subdepartment->id,
                                    'name'=>$subdepartment->name,
                                ));
                            }
                        }
                        array_push($listdepartments,array(
                            'id'=>$department->id,
                            'name'=>$department->name,
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                    }
                }
                array_push($listclientsbranchs,array(
                    'id'=>$clientsbranch->id,
                    'name'=>$clientsbranch->name,
                    'branchid'=>$clientsbranch->branchid,
                    'parentid'=>$clientsbranch->parentid,
                    'title'=>$clientsbranch->title,
                    'firmid'=>$clientsbranch->firmid,
                    'departments'=>$listdepartments
                ));
                unset($listdepartments);
                $listdepartments=array();
            }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$listclientsbranchs
              ));

              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }
        }

          array_push($listfirms,array(
              'id'=>$firm->id,
              'name'=>$firm->name,
              'clients'=>$listclients
          ));
          unset($listclients);
          $listclients=array();
      }
      //$dwqdwqdq=array();
      //$this->result('',array('Firms'=>$listfirms,'Workorders'=>$dwqdwqdq)); exit;
  }
        // else bitti
        // Clients & Clients Branchs End--
        $this->result('',$listfirms);
    }
  
  
public function actionWorkorders(){
  $user=$this->autoauth();

  $ax= User::model()->find(array("condition"=>"id=".$user->id));
  // Clients & Clients Branchs--
  //giriş logları
    $userlog=new Userlog;
    $userlog->userid=$user->id;
    $userlog->username=$user->username;
    $userlog->name=$user->name;
    $userlog->surname=$user->surname;
    $userlog->email=$user->email;
    $userlog->ipno=getenv("REMOTE_ADDR");
    $userlog->ismobilorweb="mobil";
    $userlog->entrytime=time();
    $userlog->save();

  $listworkorder=array();
  $listmonitor=array();
  $listdata=array();
  $arrayClientsids=array();
$datestart=date("Y-m-d");
$datefinish=date("Y-m-d",strtotime('+1 week'));
  $workorders=Workorder::model()->findAll(array('condition'=>'date<="'.$datefinish.'" and status!=3 and branchid='.$ax->branchid,'order'=>'date ASC, start_time ASC'));
  //$workorders=Workorder::model()->findAll(array('condition'=>'branchid='.$user->branchid)); //
 $itfirmlist=[];
if($user->id!=1)
{
  foreach ($workorders as $workorder)
  {
    
      if ($workorder->teamstaffid || $workorder->teamstaffid!=0)
      {
          $staffteam=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid.' and (leaderid='.$user->id.' or staff like "%'.$user->id.'%")'));
      }
      if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
      {
      $date = strtotime($workorder->date);
      if (($workorder->firmid==1 && $date<= strtotime('+3 days')) || ($workorder->firmid!=1 && $date<= strtotime('+7 days'))){ //+1 week di
          array_push($arrayClientsids,$workorder->clientid);
          // BEGIN
          $workordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorder->id,'order'=>'monitorno asc'));
          if ($workordermonitors)
          {
              foreach ($workordermonitors as $workordermonitor)
              {
                  $workorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id,'order'=>'monitorid asc, id asc'));
                  if($workorderdatas)
                  {


            foreach ($workorderdatas as $workorderdata)
                      {
              $pet=Pets::model()->findByPk($workorderdata->petid);
               array_push($listdata,array(
                 'id'=>$workorderdata->id,
                 'title'=>t($pet->name),//alper bura
                 'petid'=>$workorderdata->petid,
                 'pettype'=>$workorderdata->pettype,
                 'value'=>$workorderdata->value,
                 'isproduct'=>$workorderdata->isproduct
               ));
               $title='';


                      }
                  }

                  array_push($listmonitor,array(
                      'id'=>$workordermonitor->id,
                      'monitorid'=>$workordermonitor->monitorid,
                      'monitorno'=>$workordermonitor->monitorno,
                      'monitortype'=>$workordermonitor->monitortype,
                      'barcodeno'=>'xx!!!xx'.$workordermonitor->barcodeno,
                      'monitorStatus'=>0,
                      'checkdate'=>$workordermonitor->checkdate,
                    'synced'=>true,  
                    'monitorData'=>$listdata
                  ));
                  unset($listdata);
                  $listdata=array();
              }
          }

          $branch=Firm::model()->findByPk($workorder->branchid);
          $workclient=Client::model()->findByPk($workorder->clientid);
          //$workclient=[];
          if ($workorder->staffid <> '')
          {
              $staffid=$workorder->staffid;
          }
          else
          {
              $staffid=0;
          }

          $visittype=Visittype::model()->findByPk($workorder->visittypeid);
          $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorder->id));

          array_push($listworkorder,array(
              'id'=>$workorder->id,
              'date'=>$workorder->date,
              'start_time'=>$workorder->start_time,
              'finish_time'=>$workorder->finish_time,
              'service_report_ok'=> $modelServiceR != null,
              'visittypename'=>$visittype->name,
              'clientname'=>$workclient->name,
              'todo'=>$workorder->todo,
              'branchid'=>$workorder->clientid,
              'branchname'=>$workclient->name,
              'barcode'=>$workorder->barcode,
              'status'=>$workorder->status,
              'realstarttime'=>0,
              'realendtime'=>0,
              'synced'=>true,
              'workordermonitors'=>$listmonitor,
          ));
          $workclient=null;
          unset($listmonitor);
          $listmonitor=array();
          //////end

  } // date kontrol end


  }
  //} // staff team staff kontrol end
  // Workorder End

  }
}// foreach end



  $list = array();
  $listdepartments=array();
  $listsubdepartments=array();

  $listfirms=array();
  $listfirmsbranchs=array();
  $listclients=array();
  $listclientsbranchs=array();
  $listdepartments=array();
  $listsubdepartments=array();

$clientler=array();

  $auth=AuthAssignment::model()->find(array('condition'=>'userid='.$user->id));
  $yetki=explode(".",$auth->itemname);
  // Staff deeeğeel admin

  foreach ($arrayClientsids as $motherclient)
  {
      $clients=Client::model()->findByPk($motherclient); // client
      if(!in_array(Client::model()->findByPk($clients->parentid),$clientler))
      {
          array_push($clientler,Client::model()->findByPk($clients->parentid));
      }
  }


  if($yetki[count($yetki)-1]!="Admin")
  {

    //  $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$user->branchid)); // client
      if ($clientler)
      {

          foreach ( $clientler as $client)
          {
           
              $list2=array();
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$user->branchid.' and  parentid='.$client->id,'order'=>'name'));
              if ($clientsbranchs)
              {
                  foreach ($clientsbranchs as $clientsbranch)
                  {
                      // Departmens & Subdepartments
                      $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                      if($departments)
                      {
                          foreach ($departments as $department)
                          {
                              $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                              if($subdepartments)
                              {
                                  foreach ($subdepartments as $subdepartment)
                                  {
                                      array_push($listsubdepartments,array(
                                          'id'=>$subdepartment->id,
                                          'name'=>$subdepartment->name
                                      ));
                                  }
                              }
                              else {
                                array_push($listsubdepartments,array(
                                    'id'=>0,
                                    'name'=>"Sub departman yok"
                                ));
                              }
                              array_push($listdepartments,array(
                                  'id'=>$department->id,
                                  'name'=>$department->name,
                                  'subdepartments'=>$listsubdepartments
                              ));
                              unset($listsubdepartments);
                              $listsubdepartments=array();
                          }
                      }
                      else {

                        array_push($listsubdepartments,array(
                            'id'=>0,
                            'name'=>"Sub departman yok"
                        ));
                        array_push($listdepartments,array(
                            'id'=>0,
                            'name'=>"Departman Yok",
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                      }
                      // Departmens & Subdepartments End--
                      array_push($list2, array(
                          'id' => $clientsbranch->id,
                          'branchid' => $clientsbranch->branchid,
                          'parentid' => $clientsbranch->parentid,
                          'name' => $clientsbranch->name,
                          'title' => $clientsbranch->title,
                          'departments'=>$listdepartments
                      ));

					   unset($listdepartments);
                              $listdepartments=array();
                  }
              }
              array_push($list,array(
                  'id'=>$client->id,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'name'=>$client->name,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$list2
              ));
          }
      }
      $firms1=Firm::model()->findByPk($user->branchid);
      array_push($listfirms,array(
          'id'=>$firms1->id,
          'name'=>$firms1->name,

          'clients'=>$list
      ));
  }
  else
  { // Elseeeeeexi

	  if($ax->branchid==0)
	  {

		$firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
	  }
	  else
	  {
		 $firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
	  }
      foreach ($firms as $firm)
      {

          $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firm->id,'order'=>'name'));
          foreach ($clients as $client)
          {
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$firm->id.' and active=1 and parentid='.$client->id,'order'=>'name'));
              foreach ($clientsbranchs as $clientsbranch)
              {
                  $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                  if($departments)
                  {
                      foreach ($departments as $department)
                      {
                          $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                          if($subdepartments)
                          {
                              foreach ($subdepartments as $subdepartment)
                              {
                                  array_push($listsubdepartments,array(
                                      'id'=>$subdepartment->id,
                                      'name'=>$subdepartment->name,
                                  ));
                              }
                          }
                          else {
                            array_push($listsubdepartments,array(
                                'id'=>0,
                                'name'=>"Sub departman yok",
                            ));
                          }
                          array_push($listdepartments,array(
                              'id'=>$department->id,
                              'name'=>$department->name,
                              'subdepartments'=>$listsubdepartments
                          ));
                          unset($listsubdepartments);
                          $listsubdepartments=array();
                      }
                  }
                  else {

                    array_push($listsubdepartments,array(
                        'id'=>0,
                        'name'=>"Sub departman yok",
                    ));
                    array_push($listdepartments,array(
                        'id'=>0,
                        'name'=>"Departman Yok",
                        'subdepartments'=>$listsubdepartments
                    ));
                    unset($listsubdepartments);
                    $listsubdepartments=array();
                  }
                  array_push($listclientsbranchs,array(
                      'id'=>$clientsbranch->id,
                      'name'=>$clientsbranch->name,
                      'branchid'=>$clientsbranch->branchid,
                      'parentid'=>$clientsbranch->parentid,
                      'title'=>$clientsbranch->title,
                      'firmid'=>$clientsbranch->firmid,
                      'departments'=>$listdepartments
                  ));
                  unset($listdepartments);
                  $listdepartments=array();
              }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$listclientsbranchs
              ));
              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }


          $trasferc='';
          $say=0;
          $clientbranchtrasfer=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid!=0 and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.') group by parentid'));
          foreach ($clientbranchtrasfer as $clientbranchtrasferx)
          {
            if($say==0)
            {
            $trasferc=$clientbranchtrasferx->parentid;
            }
            else {
              $trasferc=$trasferc.','.$clientbranchtrasferx->parentid;
            }
            $say++;
          }

            //filiiiiz canım iş arkadaşım sorun burda trasferc boş geliyor


          if($trasferc){
            $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and id in ('.$trasferc.')'));

          foreach ($clients as $client)
          {
            $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$client->id.' and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.')'));
            foreach ($clientsbranchs as $clientsbranch)
            {
                $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id));
                if($departments)
                {
                    foreach ($departments as $department)
                    {
                        $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id));
                        if($subdepartments)
                        {
                            foreach ($subdepartments as $subdepartment)
                            {
                                array_push($listsubdepartments,array(
                                    'id'=>$subdepartment->id,
                                    'name'=>$subdepartment->name,
                                ));
                            }
                        }
                        array_push($listdepartments,array(
                            'id'=>$department->id,
                            'name'=>$department->name,
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                    }
                }
                array_push($listclientsbranchs,array(
                    'id'=>$clientsbranch->id,
                    'name'=>$clientsbranch->name,
                    'branchid'=>$clientsbranch->branchid,
                    'parentid'=>$clientsbranch->parentid,
                    'title'=>$clientsbranch->title,
                    'firmid'=>$clientsbranch->firmid,
                    'departments'=>$listdepartments
                ));
                unset($listdepartments);
                $listdepartments=array();
            }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$listclientsbranchs
              ));

              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }
        }



          array_push($listfirms,array(
              'id'=>$firm->id,
              'name'=>$firm->name,
              'clients'=>$listclients
          ));
          unset($listclients);
          $listclients=array();
      }
      //$dwqdwqdq=array();
      //$this->result('',array('Firms'=>$listfirms,'Workorders'=>$dwqdwqdq)); exit;
  }







  // else bitti
  // Clients & Clients Branchs End--$



    $this->result('',$listworkorder);
}
  
  
   public function actionMobileclients($arrayClientsids=false)
    {
        $user=$this->autoauth();
        // Clients & Clients Branchs--
        $list = array();
        $listdepartments=array();
        $listsubdepartments=array();

        $listfirms=array();
        $listfirmsbranchs=array();
        $listclients=array();
        $listclientsbranchs=array();
        $listdepartments=array();
        $listsubdepartments=array();




        $auth=AuthAssignment::model()->find(array('condition'=>'userid='.$user->id));
        $yetki=explode(".",$auth->itemname);
        // Staff deeeğeel admin
////////////////
        $isclient_x=0;
if ($user->type==22 || $user->type==24 || $user->type==25  || $user->type==26 || $user->type==27){
  $isclient_x=1;
  $clients=Client::model()->findAll(array('condition'=>'parentid=0 and id='.$user->clientid));

}else{
   $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$user->branchid));
}
           if($yetki[count($yetki)-1]!="Admin" )
        {

           // client
            if ($clients)
            {
                foreach ( $clients as $client)
                {
                  if ($user->id==1673){
                     if (   $arrayClientsids!=false && array_search($client->id,$arrayClientsids) ){
                

            }else{
              continue;
            }
                    }
                    $list2=array();
                    $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and  parentid='.$client->id));
                    if ($clientsbranchs)
                    {
                        foreach ($clientsbranchs as $clientsbranch)
                        {
                            // Departmens & Subdepartments
                            $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id));
                            if($departments)
                            {
                                foreach ($departments as $department)
                                {
                                    $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id));
                                    if($subdepartments)
                                    {
                                        foreach ($subdepartments as $subdepartment)
                                        {
                                            array_push($listsubdepartments,array(
                                                'id'=>$subdepartment->id,
                                                'name'=>$subdepartment->name
                                            ));
                                        }
                                    }
                                    array_push($listdepartments,array(
                                        'id'=>$department->id,
                                        'name'=>$department->name,
                                        'subdepartments'=>$listsubdepartments
                                    ));
                                    unset($listsubdepartments);
                                    $listsubdepartments=array();
                                }
                            }
                            // Departmens & Subdepartments End--
                            array_push($list2, array(
                                'id' => $clientsbranch->id,
                                'branchid' => $clientsbranch->branchid,
                                'parentid' => $clientsbranch->parentid,
                                'name' => $clientsbranch->name,
                                'title' => $clientsbranch->title,
                                'departments'=>$listdepartments
                            ));
                        }
                    }
                    array_push($list,array(
                        'id'=>$client->id,
                        'branchid'=>$client->branchid,
                        'parentid'=>$client->parentid,
                        'name'=>$client->name,
                        'title'=>$client->title,
                        'firmid'=>$client->firmid,
                        'clientsbranchs'=>$list2
                    ));
                }
            }
            $firms1=Firm::model()->findByPk($user->branchid);
            array_push($listfirms,array(
                'id'=>$firms1->id,
                'name'=>$firms1->name,

                'clients'=>$list
            ));

        }
        else
        { // Elseeeee

            // $firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid));

            $ax= User::model()->find(array("condition"=>"id=".$user->id));
            if($ax->branchid==0)
            {

            $firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
            }
            else
            {
             $firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
            }

   if($isclient_x==1){
      $firms=Firm::model()->findAll(array('condition'=>'id='.$user->firmid));

   }
            foreach ($firms as $firm)
            {
              if($isclient_x==1){
                $clients=Client::model()->findAll(array('condition'=>'parentid=0 and id='.$user->clientid));

              }else{
                /// leftJoin eklenecek
                  // $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firm->id));

                  $clients=Yii::app()->db->createCommand()
                  ->select('c.*')
                  ->from('client c')
                  ->leftJoin('client cb','cb.parentid=c.id')
                  ->where('c.isdelete=0 and c.active=1 and c.parentid=0 and cb.firmid='.$firm->id)
                  ->group('c.id');
                  $clients=$clients->queryAll();

              }

                foreach ($clients as $client)
                {
                    $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$client['id'].' and firmid='.$firm->id));

                                      // $clientsbranchs=Yii::app()->db->createCommand()
                                      // ->select('cb.*')
                                      // ->from('client c')
                                      // ->leftJoin('client cb','cb.parentid=c.id')
                                      // ->where('cb.isdelete=0 and cb.active=1 and cb.parentid='.$client['id'].' and cb.firmid='.$firm->id);
                                      // $clientsbranchs=$clientsbranchs->queryAll();

                    foreach ($clientsbranchs as $clientsbranch)
                    {
                        $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id));
                        if($departments)
                        {
                            foreach ($departments as $department)
                            {
                                $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id));
                                if($subdepartments)
                                {
                                    foreach ($subdepartments as $subdepartment)
                                    {
                                        array_push($listsubdepartments,array(
                                            'id'=>$subdepartment->id,
                                            'name'=>$subdepartment->name,
                                        ));
                                    }
                                }
                                array_push($listdepartments,array(
                                    'id'=>$department->id,
                                    'name'=>$department->name,
                                    'subdepartments'=>$listsubdepartments
                                ));
                                unset($listsubdepartments);
                                $listsubdepartments=array();
                            }
                        }
                        // array_push($listclientsbranchs,array(
                        //     'id'=>$clientsbranch['id'],
                        //     'name'=>$clientsbranch['name'],
                        //     'branchid'=>$clientsbranch['branchid'],
                        //     'parentid'=>$clientsbranch['parentid'],
                        //     'title'=>$clientsbranch['title'],
                        //     'firmid'=>$clientsbranch['firmid'],
                        //     'departments'=>$listdepartments
                        // ));
                        array_push($listclientsbranchs,array(
                            'id'=>$clientsbranch->id,
                            'name'=>$clientsbranch->name,
                            'branchid'=>$clientsbranch->branchid,
                            'parentid'=>$clientsbranch->parentid,
                            'title'=>$clientsbranch->title,
                            'firmid'=>$clientsbranch->firmid,
                            'departments'=>$listdepartments
                        ));

                        unset($listdepartments);
                        $listdepartments=array();
                    }
                    array_push($listclients,array(
                        'id'=>$client['id'],
                        'name'=>$client['name'],
                        'branchid'=>$client['branchid'],
                        'parentid'=>$client['parentid'],
                        'title'=>$client['title'],
                        'firmid'=>$client['firmid'],
                        'clientsbranchs'=>$listclientsbranchs
                    ));
                    // array_push($listclients,array(
                    //     'id'=>$client->id,
                    //     'name'=>$client->name,
                    //     'branchid'=>$client->branchid,
                    //     'parentid'=>$client->parentid,
                    //     'title'=>$client->title,
                    //     'firmid'=>$client->firmid,
                    //     'clientsbranchs'=>$listclientsbranchs
                    // ));

                    unset($listclientsbranchs);
                    $listclientsbranchs=array();
                }
                array_push($listfirms,array(
                    'id'=>$firm->id,
                    'name'=>$firm->name,
                    'clients'=>$listclients
                ));
                unset($listclients);
                $listclients=array();
            }
            //$dwqdwqdq=array();
            //$this->result('',array('Firms'=>$listfirms,'Workorders'=>$dwqdwqdq)); exit;
        }      // else bitti
////////////////
        // Clients & Clients Branchs End--

        // Workorder
        $listworkorder=array();
        $listmonitor=array();
        $listdata=array();

        $workorders=Workorder::model()->findAll(array('condition'=>'status!=3','order'=>'date ASC, start_time ASC'));
        //$workorders=Workorder::model()->findAll(array('condition'=>'branchid='.$user->branchid)); //
        foreach ($workorders as $workorder)
        {
            if ($workorder->teamstaffid || $workorder->teamstaffid!=0)
            {
                $staffteam=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid.' and (leaderid='.$user->id.' or staff like "%'.$user->id.'%")'));
            }
            if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
            {
            $date = strtotime($workorder->date);
            if ($date<= strtotime('+3 day')){
                // BEGIN
                $workordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorder->id,'order'=>'monitorno asc'));
                if ($workordermonitors)
                {
                    foreach ($workordermonitors as $workordermonitor)
                    {
                        $workorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id,'order'=>'monitorid asc, id asc'));
                        if($workorderdatas)
                        {
                            foreach ($workorderdatas as $workorderdata)
                            {
                                $pet=Pets::model()->findByPk($workorderdata->petid);
                                array_push($listdata,array(
                                    'id'=>$workorderdata->id,
                                    'title'=>$pet->name,
                                    'petid'=>$workorderdata->petid,
                                    'pettype'=>$workorderdata->pettype,
                                    'value'=>$workorderdata->value,
                                    'isproduct'=>$workorderdata->isproduct
                                ));
                                $title='';
                            }
                        }

                        array_push($listmonitor,array(
                            'id'=>$workordermonitor->id,
                            'monitorid'=>$workordermonitor->monitorid,
                            'monitorno'=>$workordermonitor->monitorno,
                            'monitortype'=>$workordermonitor->monitortype,
                            'barcodeno'=>'xx!!!xx'.$workordermonitor->barcodeno,
							'monitorStatus'=>0,
                            'checkdate'=>$workordermonitor->checkdate,
                            'monitorData'=>$listdata
                        ));
                        unset($listdata);
                        $listdata=array();
                    }
                }

                $branch=Firm::model()->findByPk($workorder->branchid);
                $workclient=Client::model()->findByPk($workorder->clientid);
                if ($workorder->staffid <> '')
                {
                    $staffid=$workorder->staffid;
                }
                else
                {
                    $staffid=0;
                }

                $visittype=Visittype::model()->findByPk($workorder->visittypeid);

                array_push($listworkorder,array(
                    'id'=>$workorder->id,
                    'date'=>$workorder->date,
                    'start_time'=>$workorder->start_time,
                    'finish_time'=>$workorder->finish_time,
                    'visittypename'=>$visittype->name,
                    'clientname'=>$workclient->name,
                    'todo'=>$workorder->todo,
                    'branchid'=>$workorder->clientid,
                    'branchname'=>$workclient->name,
					'barcode'=>$workorder->barcode,
                    'status'=>$workorder->status,
                    'workordermonitors'=>$listmonitor
                ));
                $workclient=null;
                unset($listmonitor);
                $listmonitor=array();
                //////end

        } // date kontrol end


}
    //} // staff team staff kontrol end
        // Workorder End

    } // foreach end
return $listfirms;
    $this->result('',array('Firms'=>$listfirms,'Workorders'=>$listworkorder));

} // action end

  
public function actionClientlists(){
  $user=$this->autoauth();

  $ax= User::model()->find(array("condition"=>"id=".$user->id));
  // Clients & Clients Branchs--
  //giriş logları
    $userlog=new Userlog;
    $userlog->userid=$user->id;
    $userlog->username=$user->username;
    $userlog->name=$user->name;
    $userlog->surname=$user->surname;
    $userlog->email=$user->email;
    $userlog->ipno=getenv("REMOTE_ADDR");
    $userlog->ismobilorweb="mobil";
    $userlog->entrytime=time();
    $userlog->save();

  $listworkorder=array();
  $listmonitor=array();
  $listdata=array();
  $arrayClientsids=array();
$datestart=date("Y-m-d");
$datefinish=date("Y-m-d",strtotime('+1 week'));
  $workorders=Workorder::model()->findAll(array('condition'=>'date<="'.$datefinish.'" and status!=3 and branchid='.$ax->branchid,'order'=>'date ASC, start_time ASC'));
  //$workorders=Workorder::model()->findAll(array('condition'=>'branchid='.$user->branchid)); //
 $itfirmlist=[];
if($user->id!=1)
{
  foreach ($workorders as $workorder)
  {
    
      if ($workorder->teamstaffid || $workorder->teamstaffid!=0)
      {
          $staffteam=Staffteam::model()->find(array('condition'=>'id='.$workorder->teamstaffid.' and (leaderid='.$user->id.' or staff like "%'.$user->id.'%")'));
      }
      if (($workorder->staffid==null && $staffteam->id==$workorder->teamstaffid) || ($workorder->staffid==$user->id && ($workorder->teamstaffid==null || $workorder->teamstaffid==0)))
      {
      $date = strtotime($workorder->date);
      if (($workorder->firmid==1 && $date<= strtotime('+3 days')) || ($workorder->firmid!=1 && $date<= strtotime('+7 days'))){ //+1 week di
          array_push($arrayClientsids,$workorder->clientid);
          // BEGIN
          $workordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorder->id,'order'=>'monitorno asc'));
          if ($workordermonitors)
          {
              foreach ($workordermonitors as $workordermonitor)
              {
                  $workorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id,'order'=>'monitorid asc, id asc'));
                  if($workorderdatas)
                  {
         

            foreach ($workorderdatas as $workorderdata)
                      {


              $pet=Pets::model()->findByPk($workorderdata->petid);
               array_push($listdata,array(
                 'id'=>$workorderdata->id,
                 'title'=>t($pet->name),//alper bura
                 'petid'=>$workorderdata->petid,
                 'pettype'=>$workorderdata->pettype,
                 'value'=>$workorderdata->value,
                 'isproduct'=>$workorderdata->isproduct
               ));
               $title='';


                      }
                  }

                  array_push($listmonitor,array(
                      'id'=>$workordermonitor->id,
                      'monitorid'=>$workordermonitor->monitorid,
                      'monitorno'=>$workordermonitor->monitorno,
                      'monitortype'=>$workordermonitor->monitortype,
                      'barcodeno'=>'xx!!!xx'.$workordermonitor->barcodeno,
                      'monitorStatus'=>0,
                      'checkdate'=>$workordermonitor->checkdate,
                      'monitorData'=>$listdata
                  ));
                  unset($listdata);
                  $listdata=array();
              }
          }

          $branch=Firm::model()->findByPk($workorder->branchid);
          $workclient=Client::model()->findByPk($workorder->clientid);
          //$workclient=[];
          if ($workorder->staffid <> '')
          {
              $staffid=$workorder->staffid;
          }
          else
          {
              $staffid=0;
          }

          $visittype=Visittype::model()->findByPk($workorder->visittypeid);
          $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorder->id));

          array_push($listworkorder,array(
              'id'=>$workorder->id,
              'date'=>$workorder->date,
              'start_time'=>$workorder->start_time,
              'finish_time'=>$workorder->finish_time,
              'service_report_ok'=> $modelServiceR != null,
              'visittypename'=>$visittype->name,
              'clientname'=>$workclient->name,
              'todo'=>$workorder->todo,
              'branchid'=>$workorder->clientid,
              'branchname'=>$workclient->name,
              'barcode'=>$workorder->barcode,
              'status'=>$workorder->status,
              'workordermonitors'=>$listmonitor,
          ));
          $workclient=null;
          unset($listmonitor);
          $listmonitor=array();
          //////end

  } // date kontrol end


  }
  //} // staff team staff kontrol end
  // Workorder End

  }
}// foreach end



  $list = array();
  $listdepartments=array();
  $listsubdepartments=array();

  $listfirms=array();
  $listfirmsbranchs=array();
  $listclients=array();
  $listclientsbranchs=array();
  $listdepartments=array();
  $listsubdepartments=array();

$clientler=array();

  $auth=AuthAssignment::model()->find(array('condition'=>'userid='.$user->id));
  $yetki=explode(".",$auth->itemname);
  // Staff deeeğeel admin

  foreach ($arrayClientsids as $motherclient)
  {
      $clients=Client::model()->findByPk($motherclient); // client
      if(!in_array(Client::model()->findByPk($clients->parentid),$clientler))
      {
          array_push($clientler,Client::model()->findByPk($clients->parentid));
      }
  }


  if($yetki[count($yetki)-1]!="Admin")
  {


      if ($clientler)
      {

          foreach ( $clientler as $client)
          {
           
              $list2=array();
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$user->branchid.' and  parentid='.$client->id,'order'=>'name'));
              if ($clientsbranchs)
              {
                  foreach ($clientsbranchs as $clientsbranch)
                  {
                      // Departmens & Subdepartments
                      $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                      if($departments)
                      {
                          foreach ($departments as $department)
                          {
                              $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                              if($subdepartments)
                              {
                                  foreach ($subdepartments as $subdepartment)
                                  {
                                      array_push($listsubdepartments,array(
                                          'id'=>$subdepartment->id,
                                          'name'=>$subdepartment->name
                                      ));
                                  }
                              }
                              else {
                                array_push($listsubdepartments,array(
                                    'id'=>0,
                                    'name'=>"Sub departman yok"
                                ));
                              }
                              array_push($listdepartments,array(
                                  'id'=>$department->id,
                                  'name'=>$department->name,
                                  'subdepartments'=>$listsubdepartments
                              ));
                              unset($listsubdepartments);
                              $listsubdepartments=array();
                          }
                      }
                      else {

                        array_push($listsubdepartments,array(
                            'id'=>0,
                            'name'=>"Sub departman yok"
                        ));
                        array_push($listdepartments,array(
                            'id'=>0,
                            'name'=>"Departman Yok",
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                      }
                      // Departmens & Subdepartments End--
                      array_push($list2, array(
                          'id' => $clientsbranch->id,
                          'branchid' => $clientsbranch->branchid,
                          'parentid' => $clientsbranch->parentid,
                          'name' => $clientsbranch->name,
                          'title' => $clientsbranch->title,
                          'departments'=>$listdepartments
                      ));

					   unset($listdepartments);
                              $listdepartments=array();
                  }
              }
              array_push($list,array(
                  'id'=>$client->id,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'name'=>$client->name,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$list2
              ));
          }
      }
      $firms1=Firm::model()->findByPk($user->branchid);
      array_push($listfirms,array(
          'id'=>$firms1->id,
          'name'=>$firms1->name,

          'clients'=>$list
      ));
  }
  else
  { // Elseeeeeexi

	  if($ax->branchid==0)
	  {

		$firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid,'order'=>'name'));
	  }
	  else
	  {
		 $firms=Firm::model()->findAll(array('condition'=>'id='.$user->branchid,'order'=>'name'));
	  }
      foreach ($firms as $firm)
      {

          $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firm->id,'order'=>'name'));
          foreach ($clients as $client)
          {
              $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$firm->id.' and active=1 and parentid='.$client->id,'order'=>'name'));
              foreach ($clientsbranchs as $clientsbranch)
              {
                  $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id,'order'=>'name'));
                  if($departments)
                  {
                      foreach ($departments as $department)
                      {
                          $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id,'order'=>'name'));
                          if($subdepartments)
                          {
                              foreach ($subdepartments as $subdepartment)
                              {
                                  array_push($listsubdepartments,array(
                                      'id'=>$subdepartment->id,
                                      'name'=>$subdepartment->name,
                                  ));
                              }
                          }
                          else {
                            array_push($listsubdepartments,array(
                                'id'=>0,
                                'name'=>"Sub departman yok",
                            ));
                          }
                          array_push($listdepartments,array(
                              'id'=>$department->id,
                              'name'=>$department->name,
                              'subdepartments'=>$listsubdepartments
                          ));
                          unset($listsubdepartments);
                          $listsubdepartments=array();
                      }
                  }
                  else {

                    array_push($listsubdepartments,array(
                        'id'=>0,
                        'name'=>"Sub departman yok",
                    ));
                    array_push($listdepartments,array(
                        'id'=>0,
                        'name'=>"Departman Yok",
                        'subdepartments'=>$listsubdepartments
                    ));
                    unset($listsubdepartments);
                    $listsubdepartments=array();
                  }
                  array_push($listclientsbranchs,array(
                      'id'=>$clientsbranch->id,
                      'name'=>$clientsbranch->name,
                      'branchid'=>$clientsbranch->branchid,
                      'parentid'=>$clientsbranch->parentid,
                      'title'=>$clientsbranch->title,
                      'firmid'=>$clientsbranch->firmid,
                      'departments'=>$listdepartments
                  ));
                  unset($listdepartments);
                  $listdepartments=array();
              }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$listclientsbranchs
              ));
              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }


          $trasferc='';
          $say=0;
          $clientbranchtrasfer=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid!=0 and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.') group by parentid'));
          foreach ($clientbranchtrasfer as $clientbranchtrasferx)
          {
            if($say==0)
            {
            $trasferc=$clientbranchtrasferx->parentid;
            }
            else {
              $trasferc=$trasferc.','.$clientbranchtrasferx->parentid;
            }
            $say++;
          }

            //filiiiiz canım iş arkadaşım sorun burda trasferc boş geliyor


          if($trasferc){
            $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and id in ('.$trasferc.')'));

          foreach ($clients as $client)
          {
            $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$client->id.' and firmid!=mainfirmid and (firmid='.$firm->id.' or mainfirmid='.$firm->id.')'));
            foreach ($clientsbranchs as $clientsbranch)
            {
                $departments=Departments::model()->findAll(array('condition'=>'active=1 and parentid=0 and clientid='.$clientsbranch->id));
                if($departments)
                {
                    foreach ($departments as $department)
                    {
                        $subdepartments=Departments::model()->findAll(array('condition'=>'active=1 and clientid='.$clientsbranch->id.' and parentid='.$department->id));
                        if($subdepartments)
                        {
                            foreach ($subdepartments as $subdepartment)
                            {
                                array_push($listsubdepartments,array(
                                    'id'=>$subdepartment->id,
                                    'name'=>$subdepartment->name,
                                ));
                            }
                        }
                        array_push($listdepartments,array(
                            'id'=>$department->id,
                            'name'=>$department->name,
                            'subdepartments'=>$listsubdepartments
                        ));
                        unset($listsubdepartments);
                        $listsubdepartments=array();
                    }
                }
                array_push($listclientsbranchs,array(
                    'id'=>$clientsbranch->id,
                    'name'=>$clientsbranch->name,
                    'branchid'=>$clientsbranch->branchid,
                    'parentid'=>$clientsbranch->parentid,
                    'title'=>$clientsbranch->title,
                    'firmid'=>$clientsbranch->firmid,
                    'departments'=>$listdepartments
                ));
                unset($listdepartments);
                $listdepartments=array();
            }
              array_push($listclients,array(
                  'id'=>$client->id,
                  'name'=>$client->name,
                  'branchid'=>$client->branchid,
                  'parentid'=>$client->parentid,
                  'title'=>$client->title,
                  'firmid'=>$client->firmid,
                  'clientsbranchs'=>$listclientsbranchs
              ));

              unset($listclientsbranchs);
              $listclientsbranchs=array();
          }
        }



          array_push($listfirms,array(
              'id'=>$firm->id,
              'name'=>$firm->name,
              'clients'=>$listclients
          ));
          unset($listclients);
          $listclients=array();
      }

  }







  // else bitti

  $listfirms=$this->actionMobileclients($arrayClientsids);

    $this->result('',$listfirms);
}


}
