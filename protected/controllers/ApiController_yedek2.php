<?php

class ApiController extends Controller
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

    public function actionMobileclients()
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
        if($yetki[count($yetki)-1]!="Admin")
        {

            $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$user->branchid)); // client
            if ($clients)
            {
                foreach ( $clients as $client)
                {
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

            $firms=Firm::model()->findAll(array('condition'=>'parentid='.$user->firmid));
            foreach ($firms as $firm)
            {
                $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid=0 and firmid='.$firm->id));
                foreach ($clients as $client)
                {
                    $clientsbranchs=Client::model()->findAll(array('condition'=>'isdelete=0 and active=1 and parentid='.$client->id));
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

    $this->result('',array('Firms'=>$listfirms,'Workorders'=>$listworkorder));

} // action end


public function actionInsectrampackage(){
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
/*
              if(isset($levha))
              {

               $monitor=Mobileworkordermonitors::model()->find(array("condition"=>"id=".$workordermonitor->id));
               if($workorderdata->petid==27 || $workorderdata->petid==26 || $workorderdata->petid==29 || $workorderdata->petid==31 || $workorderdata->petid==30){
               $toplamsinek=Mobileworkorderdata::model()->findAll(array('condition'=>'monitorid='.$monitor->monitorid.' and clientbranchid='.$monitor->clientbranchid.' and petid='.$workorderdata->petid.' and id>'.$levha->id,'order'=>'monitorid asc, id asc'));


                //if($workorderdata->petid==27 || $workorderdata->petid==26 || $workorderdata->petid==29 || $workorderdata->petid==31 || $workorderdata->petid==30){
              //  $toplamsinek=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id.' and petid='.$workorderdata->petid.' and id>'.$levha->id,'order'=>'monitorid asc, id asc'));
                $topla=0;
                foreach($toplamsinek as $toplamsinekx)
                {
                  $topla=$topla+$toplamsinekx->value;
                }

                  $pet=Pets::model()->findByPk($workorderdata->petid);
                  array_push($listdata,array(
                    'id'=>$workorderdata->id,
                    'title'=>$pet->name,
                    'petid'=>$workorderdata->petid,
                    'pettype'=>$workorderdata->pettype,
                    'value'=>$workorderdata->value,
                    'oldvalue'=>$topla,
                    'isproduct'=>$workorderdata->isproduct
                  ));
                  $title='';
                }
                else
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
              else
              {

                $monitor=Mobileworkordermonitors::model()->find(array("condition"=>"id=".$workordermonitor->id));
                if($workorderdata->petid==27 || $workorderdata->petid==26 || $workorderdata->petid==29 || $workorderdata->petid==31 || $workorderdata->petid==30){
                $toplamsinek=Mobileworkorderdata::model()->findAll(array('condition'=>'monitorid='.$monitor->monitorid.' and clientbranchid='.$monitor->clientbranchid.' and petid='.$workorderdata->petid,'order'=>'monitorid asc, id asc'));


              // if($workorderdata->petid==27 || $workorderdata->petid==26 || $workorderdata->petid==29 || $workorderdata->petid==31 || $workorderdata->petid==30){
              //  $toplamsinek=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$workordermonitor->id.' and petid='.$workorderdata->petid,'order'=>'monitorid asc, id asc'));
                $topla=5;
                foreach($toplamsinek as $toplamsinekx)
                {
                  $topla=$topla+$toplamsinekx->value;
                }

                  $pet=Pets::model()->findByPk($workorderdata->petid);
                  array_push($listdata,array(
                    'id'=>$workorderdata->id,
                    'title'=>$pet->name,
                    'petid'=>$workorderdata->petid,
                    'pettype'=>$workorderdata->pettype,
                    'value'=>$workorderdata->value,
                    'oldvalue'=>$topla,
                    'isproduct'=>$workorderdata->isproduct
                  ));
                  $title='';
                }
                else
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
*/


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
  // Clients & Clients Branchs End--
    $this->result('',array('Firms'=>$listfirms,'Workorders'=>$listworkorder));
}


public function actionManuelpackage()
{
	$sure_baslangici = microtime(true);
	if(!isset($_REQUEST['deviceid'])){
		$_REQUEST['deviceid']='0';
	}

	$str=file_get_contents('php://input');

	if(1==1)
	{

    $user=$this->autoauth();


    $gelen=json_decode($str);
    $workorders=$gelen->Workorders;
    for($i=0;$i<count($workorders);$i++)
    { // WorkOrders

        $modelW=Workorder::model()->findByPk($workorders[$i]->id);
		if($modelW)
		{
        if ($workorders[$i]->new_barcode_value!=null) // Workorder Yeni Barcode ile Değiştirme
        {
            $modelW->barcode=$workorders[$i]->new_barcode_value;
        }

		// SERVICE REPORT BEGIN ////////////////////////////////////////////////////////////

		if($workorders[$i]->customer_service_report)
		{
		if($workorders[$i]->customer_service_report->signer_name <> "null" && $workorders[$i]->customer_service_report->riskreview != "null")
        {

			// Daha önce service raporu gelmiş mi diye kontrol ediyoruz :)
			$modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if($modelServiceR)
			{

			}
			else{



				// Techinician sign
				$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
				$content= base64_decode($workorders[$i]->customer_service_report->technician_signature);
				$file = fopen($targetPath, 'w');
				fwrite($file, $content);
				fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
				// Client sign
				$targetPath2="b.txt"; /// json decode edilince içine base64 kodu gelecek
				$content2= base64_decode($workorders[$i]->customer_service_report->client_signature);
				$file2 = fopen($targetPath2, 'w');
				fwrite($file2, $content2);
				fclose($file2); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
        
        // Servis raporu resmi
        if (!empty($workorders[$i]->customer_service_report->service_report_picture)){
				$targetPath3="c.txt"; /// json decode edilince içine base64 kodu gelecek
				$content3= base64_decode($workorders[$i]->customer_service_report->service_report_picture);
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
          if (isset($workorders[$i]->customer_service_report->service_report_picture)){
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
          
          if (isset($workorders[$i]->customer_service_report->service_report_picture)){
            $imagename3=time()."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename('c.txt', $path3);
          }
				}

				$servicereports=$workorders[$i]->customer_service_report->applied_insecticides;
				$modelS=new Servicereport;
				$modelS->client_name=$workorders[$i]->customer_service_report->client_name;
				$modelS->date=time();
				$modelS->reportno=$workorders[$i]->id;
				$modelS->visittype=$workorders[$i]->customer_service_report->visittype;
				$modelS->trade_name=$workorders[$i]->customer_service_report->signer_name;
				$modelS->servicedetails=$workorders[$i]->customer_service_report->servicedetails;

				foreach ($servicereports as $servicereport){
					$modelA=new Activeingredients;
					$modelA->workorderid=$workorders[$i]->id;
					$modelA->trade_name=$servicereport->tradeName;
					$modelA->active_ingredient=$servicereport->activeIngredient;
					$modelA->amount_applied=$servicereport->amountApplied;
					$modelA->save();
				}
				$modelS->riskreview=$workorders[$i]->customer_service_report->riskreview;
				$modelS->technician_sign='/uploads/'.$firm->username.'/'.$imagename;
				$modelS->client_sign='/uploads/'.$firm->username.'/'.$imagename2;
        
        if (isset($workorders[$i]->customer_service_report->service_report_picture)){
				  $modelS->picture='/uploads/'.$firm->username.'/'.$imagename3;
        }
				if($modelS->save())
        {
         print_r($modelS); exit;

        }
        else{
            print_r($modelS->getErrors()); exit;
        }

				$servicereports=array();
			}
        }
		}
		// SERVICE REPORT END ////////////////////////////////////////////////////////////
		if(count($workorders[$i]->workordermonitors)==0)
		{

		$modelW->status=$workorders[$i]->status; // Monitor yoksa gelen statuyu statuyle eşitle
		$modelW->update();
		}

        for($j=0;$j<count($workorders[$i]->workordermonitors);$j++)  // Monitorler Begin
        {	// WorkOrderMonitors

		$sayyyy++;
			if($workorders[$i]->workordermonitors[$j]->monitorStatus<>0)
			{

				$modelMert=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
				if ($modelMert)
				{
					$modelVarmikayip=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
					if(!$modelVarmikayip)
					{
						$DurumluData=new Mobileworkorderdata;
						$DurumluData->mobileworkordermonitorsid=$workorders[$i]->workordermonitors[$j]->id;
						$DurumluData->workorderid=$modelMert->workorderid;
						$DurumluData->monitorid=$modelMert->monitorid;
						$DurumluData->monitortype=$workorders[$i]->workordermonitors[$j]->monitortype;
						$DurumluData->pettype=0;
						$DurumluData->petid=49;
						$DurumluData->value=$workorders[$i]->workordermonitors[$j]->monitorStatus; // 0-Normal 1- Lost 2- Broken 3- Unreacheble
						$DurumluData->saverid=$user->id;
						$DurumluData->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$DurumluData->firmid=$modelMert->firmid;
						$DurumluData->firmbranchid=$modelMert->firmbranchid;
						$DurumluData->clientid=$modelMert->clientid;
						$DurumluData->clientbranchid=$modelMert->clientbranchid;
						$DurumluData->departmentid=$modelMert->departmentid;
						$DurumluData->subdepartmentid=$modelMert->subdepartment;
						$DurumluData->openedtimestart=time();
						$DurumluData->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$DurumluData->isproduct=1;

						if(!$DurumluData->save()){
							//print_r($DurumluData->getErrors());
						}
						else{
						}
					}
				}

			}



            $modelM=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
			if($modelM)
			{
		//"new_barcode_value": "null",
            if($workorders[$i]->workordermonitors[$j]->new_barcode_value!="null") // Monitor Barcode Numarası Değiştir
            {
				$modelMonitoring=Monitoring::model()->findByPk($modelM->monitorid);
				$modelMonitoring->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
				$modelMonitoring->update();
                //$modelM->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
            }
				// Boş monitore checkdate atma

			if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
			{
				$modelM->checkdate=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
				$modelM->saverid=$user->id;
			}
			else
			{

			}
				// Boş monitore checkdate atma end..

            $modelM->update();



			}
            for($k=0;$k<count($workorders[$i]->workordermonitors[$j]->monitorData);$k++)  // Workorder Dataları kaydetme
            { // WorkOrderMonitorData

				$modelD=Mobileworkorderdata::model()->findByPk($workorders[$i]->workordermonitors[$j]->monitorData[$k]->id);
				if ($modelD){
					if ($workorders[$i]->workordermonitors[$j]->monitorData[$k]->value != 0) // 0 olmayan verileri kaydet monitordata
					{
						$modelD->value=$workorders[$i]->workordermonitors[$j]->monitorData[$k]->value;
						$modelD->saverid=$user->id;
						$modelD->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$modelD->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$modelD->update();
					}
					else  // ?????? veriyi üstüne kaydetmeden // createdat ve saveridyi kaydet
					{
						if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
						{
							$modelD->saverid=$user->id;
							$modelD->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
							$modelD->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
							$modelD->update();
						}
					}
				}else
				{ echo $workorders[$i]->workordermonitors[$j]->monitorData[$k]->id.'<br>'; }
            }



        } // Monitorler End

	if(strlen($workorders[$i]->start_time)>9 && strlen($workorders[$i]->finish_time)>9)
	{
		if($modelW->realstarttime){
			$yenibaslangic=substr($workorders[$i]->start_time,0,10);
			if($yenibaslangic < $modelW->realstarttime)
			{
				$modelW->realstarttime=$yenibaslangic;
			}
			else{

			}
		}
		else
		{
			$modelW->realstarttime=substr($workorders[$i]->start_time,0,10);
		}
		$modelW->realendtime=substr($workorders[$i]->finish_time,0,10);
	}
	if(isset($workorders[$i]->skip_service_report_comment))
	{
		$modelW->service_report=$workorders[$i]->skip_service_report_comment;
	}
	if(isset($workorders[$i]->cant_scan_comment))
	{
		$modelW->cantscancomment=$workorders[$i]->cant_scan_comment;
	}

    } /// Workorder varmı if'i


			$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorders[$i]->id.' and checkdate=0'));
			if(!$isbiticekmi)
			{
			    $modelW->status=3;
				$modelW->executiondate=time();
			    /*$modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
    			if($modelServiceR)
    			{
                    
    			}
    			else 
    			{
    			    $modelW->status=5;
    			} */

			}
			else{

				$modelW->status=$workorders[$i]->status;
			}
			$modelW->update();

	} //// Workorder for  end

    $this->result('','Senkronize başarılı..');


	}else{
		 $this->result('','Senkronize başarılı..');
	}

}


public function actionPackage()
{
	$sure_baslangici = microtime(true);
	if(!isset($_REQUEST['deviceid'])){
		$_REQUEST['deviceid']='0';
	}

	$str=file_get_contents('php://input');
	$varmiencrypt=Superlogs::model()->find(array('condition'=>'encrypted="'.md5($str).'" and userid!=0'));
	$sure1 = microtime(true);
	if(!$varmiencrypt)
	{
	$filenamex='apilogs/'.time().'-cache.txt';
    file_put_contents($filenamex, $str);

	$Superlogs= new Superlogs;

	$Superlogs->data=$str;
	$Superlogs->encrypted=md5($str);
	$Superlogs->userid=0;

	$Superlogs->deviceid=$_REQUEST['deviceid'];
	$Superlogs->createdtime=time();
	$Superlogs->save();

    $user=$this->autoauth();

	$Superlogs->userid=$user->id;
	$Superlogs->update();

    file_put_contents('apilogs/'.$user->id.' - '.time().'.txt', $str);
	unlink($filenamex);



    $gelen=json_decode($str);
    $workorders=$gelen->Workorders;

    for($i=0;$i<count($workorders);$i++)
    { // WorkOrders

        $modelW=Workorder::model()->findByPk($workorders[$i]->id);
		if($modelW)
		{
        if ($workorders[$i]->new_barcode_value!=null) // Workorder Yeni Barcode ile Değiştirme
        {
            $modelW->barcode=$workorders[$i]->new_barcode_value;
        }

		// SERVICE REPORT BEGIN ////////////////////////////////////////////////////////////

		if($workorders[$i]->customer_service_report)
		{
		if($workorders[$i]->customer_service_report->signer_name <> "null" && $workorders[$i]->customer_service_report->riskreview != "null")
        {

			// Daha önce service raporu gelmiş mi diye kontrol ediyoruz :)
			$modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if($modelServiceR)
			{

			}
			else{
				// Techinician sign
				$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
				$content= base64_decode($workorders[$i]->customer_service_report->technician_signature);
				$file = fopen($targetPath, 'w');
				fwrite($file, $content);
				fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
				// Client sign
				$targetPath2="b.txt"; /// json decode edilince içine base64 kodu gelecek
				$content2= base64_decode($workorders[$i]->customer_service_report->client_signature);
				$file2 = fopen($targetPath2, 'w');
				fwrite($file2, $content2);
				fclose($file2); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
            // Servis raporu resmi
        if (isset($workorders[$i]->customer_service_report->service_report_picture)){
				$targetPath3="c.txt"; /// json decode edilince içine base64 kodu gelecek
				$content3= base64_decode($workorders[$i]->customer_service_report->service_report_picture);
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
          
            if (isset($workorders[$i]->customer_service_report->service_report_picture)){
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
          
            if (isset($workorders[$i]->customer_service_report->service_report_picture)){
            $imagename3=time()."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename('c.txt', $path3);
          }
				}

				$servicereports=$workorders[$i]->customer_service_report->applied_insecticides;
				$modelS=new Servicereport;
				$modelS->client_name=$workorders[$i]->customer_service_report->client_name;
				$modelS->date=time();
				$modelS->reportno=$workorders[$i]->id;
				$modelS->visittype=$workorders[$i]->customer_service_report->visittype;
				$modelS->trade_name=$workorders[$i]->customer_service_report->signer_name;
				$modelS->servicedetails=$workorders[$i]->customer_service_report->servicedetails;

				foreach ($servicereports as $servicereport){
					$modelA=new Activeingredients;
					$modelA->workorderid=$workorders[$i]->id;
					$modelA->trade_name=$servicereport->tradeName;
					$modelA->active_ingredient=$servicereport->activeIngredient;
					$modelA->amount_applied=$servicereport->amountApplied;
					$modelA->save();
				}
				$modelS->riskreview=$workorders[$i]->customer_service_report->riskreview;
				$modelS->technician_sign='/uploads/'.$firm->username.'/'.$imagename;
				$modelS->client_sign='/uploads/'.$firm->username.'/'.$imagename2;
         
        if (isset($workorders[$i]->customer_service_report->service_report_picture)){
				  $modelS->picture='/uploads/'.$firm->username.'/'.$imagename3;
        }
				$modelS->save();
				$servicereports=array();
			}
        }
		}
		// SERVICE REPORT END ////////////////////////////////////////////////////////////
		if(count($workorders[$i]->workordermonitors)==0)
		{

		$modelW->status=$workorders[$i]->status; // Monitor yoksa gelen statuyu statuyle eşitle
		$modelW->update();
		}

      $kayitKirik=0;
        for($j=0;$j<count($workorders[$i]->workordermonitors);$j++)  // Monitorler Begin
        {	// WorkOrderMonitors

		$sayyyy++;
			if($workorders[$i]->workordermonitors[$j]->monitorStatus<>0)
			{

				$modelMert=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
				if ($modelMert)
				{
          $kayitKirik=1;
					$modelVarmikayip=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
					if(!$modelVarmikayip)
					{
						$DurumluData=new Mobileworkorderdata;
						$DurumluData->mobileworkordermonitorsid=$workorders[$i]->workordermonitors[$j]->id;
						$DurumluData->workorderid=$modelMert->workorderid;
						$DurumluData->monitorid=$modelMert->monitorid;
						$DurumluData->monitortype=$workorders[$i]->workordermonitors[$j]->monitortype;
						$DurumluData->pettype=0;
						$DurumluData->petid=49;
						$DurumluData->value=$workorders[$i]->workordermonitors[$j]->monitorStatus; // 0-Normal 1- Lost 2- Broken 3- Unreacheble
						$DurumluData->saverid=$user->id;
						$DurumluData->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$DurumluData->firmid=$modelMert->firmid;
						$DurumluData->firmbranchid=$modelMert->firmbranchid;
						$DurumluData->clientid=$modelMert->clientid;
						$DurumluData->clientbranchid=$modelMert->clientbranchid;
						$DurumluData->departmentid=$modelMert->departmentid;
						$DurumluData->subdepartmentid=$modelMert->subdepartment;
						$DurumluData->openedtimestart=time();
						$DurumluData->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$DurumluData->isproduct=1;

						if(!$DurumluData->save()){
							//print_r($DurumluData->getErrors());
						}
						else{
						}
					}
				}

			}



     $modelM=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
			if($modelM)
			{
		//"new_barcode_value": "null",
            if($workorders[$i]->workordermonitors[$j]->new_barcode_value!="null") // Monitor Barcode Numarası Değiştir
            {
				$modelMonitoring=Monitoring::model()->findByPk($modelM->monitorid);
				$modelMonitoring->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
				$modelMonitoring->update();
                //$modelM->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
            }
				// Boş monitore checkdate atma
			if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
			{
				$modelM->checkdate=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);

            	//$ax= User::model()->userobjecty('');
                $modelM->saverid=$user->id;
                //$modelM->saverid=$ax->id;

			}
			else
			{

			}
				// Boş monitore checkdate atma end..

            $modelM->update();



			}
         if($kayitKirik==0)
          {
            $modelMert=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
             if(isset($modelMert->id))
             {
               $datam= Mobileworkorderdata::model()->find(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
               if(isset($datam->id))
               {
                 $datam->delete();
               }
             }
          }
            for($k=0;$k<count($workorders[$i]->workordermonitors[$j]->monitorData);$k++)  // Workorder Dataları kaydetme
            { // WorkOrderMonitorData

				$modelD=Mobileworkorderdata::model()->findByPk($workorders[$i]->workordermonitors[$j]->monitorData[$k]->id);
				if ($modelD){
					if ($workorders[$i]->workordermonitors[$j]->monitorData[$k]->value != 0) // 0 olmayan verileri kaydet monitordata
					{
            if($kayitKirik==0)
            {
              $modelD->value=$workorders[$i]->workordermonitors[$j]->monitorData[$k]->value;
            }
            else{
              $modelD->value=0;
            }
						
						$modelD->saverid=$user->id;
						$modelD->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$modelD->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$modelD->update();
					}
					else  // ?????? veriyi üstüne kaydetmeden // createdat ve saveridyi kaydet
					{
						if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
						{
							$modelD->saverid=$user->id;
							$modelD->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
							$modelD->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
							$modelD->update();
						}
					}
				}
				/*else
				{ echo $workorders[$i]->workordermonitors[$j]->monitorData[$k]->id.'<br>'; }*/
            }



        } // Monitorler End

	if(strlen($workorders[$i]->start_time)>9 && strlen($workorders[$i]->finish_time)>9)
	{
		if($modelW->realstarttime){
			$yenibaslangic=substr($workorders[$i]->start_time,0,10);
			if($yenibaslangic < $modelW->realstarttime)
			{
				$modelW->realstarttime=$yenibaslangic;
			}
			else{

			}
		}
		else
		{
			$modelW->realstarttime=substr($workorders[$i]->start_time,0,10);
		}
		$modelW->realendtime=substr($workorders[$i]->finish_time,0,10);
	}
	if(isset($workorders[$i]->skip_service_report_comment))
	{
		$modelW->service_report=$workorders[$i]->skip_service_report_comment;
	}
	if(isset($workorders[$i]->cant_scan_comment))
	{
		$modelW->cantscancomment=$workorders[$i]->cant_scan_comment;
	}

    } /// Workorder varmı if'i


			$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorders[$i]->id.' and checkdate=0'));
			//$servisRaporVarMi = $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if(!$isbiticekmi)
			{
				$modelW->status=3;
				$modelW->executiondate=time();
			}
			else{

				$modelW->status=$workorders[$i]->status;
			}
			$modelW->update();

	} //// Workorder for  end

    $this->result('','Senkronize başarılı..');


	}else{
		 $this->result('','Senkronize başarılı..');
	}

}


public function actionPackage2($id)
{
    $log=Yii::app()->db->createCommand("SELECT data FROM superlogs where id=".$id)->queryRow();

    //$dosya = fopen('ip.php', 'r');
    //$icerik = fread($dosya, filesize('ip.php'));
    $gelen=json_decode($log['data']);

    $workorders=$gelen->Workorders;
    $userid=787;

   
    for($i=0;$i<count($workorders);$i++)
    { // WorkOrders

        $modelW=Workorder::model()->findByPk($workorders[$i]->id);
		if($modelW)
		{
        if ($workorders[$i]->new_barcode_value!=null) // Workorder Yeni Barcode ile Değiştirme
        {
            $modelW->barcode=$workorders[$i]->new_barcode_value;
        }

		// SERVICE REPORT BEGIN ////////////////////////////////////////////////////////////

		if($workorders[$i]->customer_service_report)
		{
		if($workorders[$i]->customer_service_report->signer_name <> "null" && $workorders[$i]->customer_service_report->riskreview != "null")
        {

			// Daha önce service raporu gelmiş mi diye kontrol ediyoruz :)
			$modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if($modelServiceR)
			{

			}
			else{
				// Techinician sign
				$targetPath="a.txt"; /// json decode edilince içine base64 kodu gelecek
				$content= base64_decode($workorders[$i]->customer_service_report->technician_signature);
				$file = fopen($targetPath, 'w');
				fwrite($file, $content);
				fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
				// Client sign
				$targetPath2="b.txt"; /// json decode edilince içine base64 kodu gelecek
				$content2= base64_decode($workorders[$i]->customer_service_report->client_signature);
				$file2 = fopen($targetPath2, 'w');
				fwrite($file2, $content2);
				fclose($file2); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
            // Servis raporu resmi
        if (isset($workorders[$i]->customer_service_report->service_report_picture)){
				$targetPath3="c.txt"; /// json decode edilince içine base64 kodu gelecek
				$content3= base64_decode($workorders[$i]->customer_service_report->service_report_picture);
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
          
            if (isset($workorders[$i]->customer_service_report->service_report_picture)){
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
          
            if (isset($workorders[$i]->customer_service_report->service_report_picture)){
            $imagename3=time()."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename('c.txt', $path3);
          }
				}

				$servicereports=$workorders[$i]->customer_service_report->applied_insecticides;
				$modelS=new Servicereport;
				$modelS->client_name=$workorders[$i]->customer_service_report->client_name;
				$modelS->date=time();
				$modelS->reportno=$workorders[$i]->id;
				$modelS->visittype=$workorders[$i]->customer_service_report->visittype;
				$modelS->trade_name=$workorders[$i]->customer_service_report->signer_name;
				$modelS->servicedetails=$workorders[$i]->customer_service_report->servicedetails;

				foreach ($servicereports as $servicereport){
					$modelA=new Activeingredients;
					$modelA->workorderid=$workorders[$i]->id;
					$modelA->trade_name=$servicereport->tradeName;
					$modelA->active_ingredient=$servicereport->activeIngredient;
					$modelA->amount_applied=$servicereport->amountApplied;
					$modelA->save();
				}
				$modelS->riskreview=$workorders[$i]->customer_service_report->riskreview;
				$modelS->technician_sign='/uploads/'.$firm->username.'/'.$imagename;
				$modelS->client_sign='/uploads/'.$firm->username.'/'.$imagename2;
         
        if (isset($workorders[$i]->customer_service_report->service_report_picture)){
				  $modelS->picture='/uploads/'.$firm->username.'/'.$imagename3;
        }
				$modelS->save();
				$servicereports=array();
			}
        }
		}
		// SERVICE REPORT END ////////////////////////////////////////////////////////////
		if(count($workorders[$i]->workordermonitors)==0)
		{

		$modelW->status=$workorders[$i]->status; // Monitor yoksa gelen statuyu statuyle eşitle
		$modelW->update();
		}

      $kayitKirik=0;
        for($j=0;$j<count($workorders[$i]->workordermonitors);$j++)  // Monitorler Begin
        {	// WorkOrderMonitors

		$sayyyy++;
			if($workorders[$i]->workordermonitors[$j]->monitorStatus<>0)
			{

				$modelMert=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
				if ($modelMert)
				{
          $kayitKirik=1;
					$modelVarmikayip=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
					if(empty($modelVarmikayip))
					{
						$DurumluData=new Mobileworkorderdata;
						$DurumluData->mobileworkordermonitorsid=$workorders[$i]->workordermonitors[$j]->id;
						$DurumluData->workorderid=$modelMert->workorderid;
						$DurumluData->monitorid=$modelMert->monitorid;
						$DurumluData->monitortype=$workorders[$i]->workordermonitors[$j]->monitortype;
						$DurumluData->pettype=0;
						$DurumluData->petid=49;
						$DurumluData->value=$workorders[$i]->workordermonitors[$j]->monitorStatus; // 0-Normal 1- Lost 2- Broken 3- Unreacheble
						$DurumluData->saverid=$userid;
						$DurumluData->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$DurumluData->firmid=$modelMert->firmid;
						$DurumluData->firmbranchid=$modelMert->firmbranchid;
						$DurumluData->clientid=$modelMert->clientid;
						$DurumluData->clientbranchid=$modelMert->clientbranchid;
						$DurumluData->departmentid=$modelMert->departmentid;
						$DurumluData->subdepartmentid=$modelMert->subdepartment;
						$DurumluData->openedtimestart=time();
						$DurumluData->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$DurumluData->isproduct=1;

						if(!$DurumluData->save()){
							print_r($DurumluData->getErrors());
              exit;
						}
						else{
						}
					}
				}

			}



     $modelM=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
			if($modelM)
			{
		//"new_barcode_value": "null",
            if($workorders[$i]->workordermonitors[$j]->new_barcode_value!="null") // Monitor Barcode Numarası Değiştir
            {
				$modelMonitoring=Monitoring::model()->findByPk($modelM->monitorid);
				$modelMonitoring->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
				$modelMonitoring->update();
                //$modelM->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
            }
				// Boş monitore checkdate atma
			if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
			{
				$modelM->checkdate=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);

            	//$ax= User::model()->userobjecty('');
                $modelM->saverid=$userid;
                //$modelM->saverid=$ax->id;

			}
			else
			{

			}
				// Boş monitore checkdate atma end..

            $modelM->save();



			}
         if($kayitKirik==0)
          {
            $modelMert=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
             if(isset($modelMert->id))
             {
               $datam= Mobileworkorderdata::model()->find(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
               if(isset($datam->id))
               {
                 $datam->delete();
               }
             }
          }
            for($k=0;$k<count($workorders[$i]->workordermonitors[$j]->monitorData);$k++)  // Workorder Dataları kaydetme
            { // WorkOrderMonitorData

				$modelD=Mobileworkorderdata::model()->findByPk($workorders[$i]->workordermonitors[$j]->monitorData[$k]->id);
				if ($modelD){
					if ($workorders[$i]->workordermonitors[$j]->monitorData[$k]->value != 0) // 0 olmayan verileri kaydet monitordata
					{
            if($kayitKirik==0)
            {
              $modelD->value=$workorders[$i]->workordermonitors[$j]->monitorData[$k]->value;
            }
            else{
              $modelD->value=0;
            }
						
						$modelD->saverid=$userid;
						$modelD->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$modelD->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
						$modelD->save();
					}
					else  // ?????? veriyi üstüne kaydetmeden // createdat ve saveridyi kaydet
					{
						if($workorders[$i]->workordermonitors[$j]->checkdate!=0)
						{
							$modelD->saverid=$userid;
							$modelD->createdtime=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
							$modelD->openedtimeend=substr($workorders[$i]->workordermonitors[$j]->checkdate,0,10);
							$modelD->save();
						}
					}
				}
				/*else
				{ echo $workorders[$i]->workordermonitors[$j]->monitorData[$k]->id.'<br>'; }*/
            }



        } // Monitorler End

	if(strlen($workorders[$i]->start_time)>9 && strlen($workorders[$i]->finish_time)>9)
	{
		if($modelW->realstarttime){
			$yenibaslangic=substr($workorders[$i]->start_time,0,10);
			if($yenibaslangic < $modelW->realstarttime)
			{
				$modelW->realstarttime=$yenibaslangic;
			}
			else{

			}
		}
		else
		{
			$modelW->realstarttime=substr($workorders[$i]->start_time,0,10);
		}
		$modelW->realendtime=substr($workorders[$i]->finish_time,0,10);
	}
	if(isset($workorders[$i]->skip_service_report_comment))
	{
		$modelW->service_report=$workorders[$i]->skip_service_report_comment;
	}
	if(isset($workorders[$i]->cant_scan_comment))
	{
		$modelW->cantscancomment=$workorders[$i]->cant_scan_comment;
	}

    } /// Workorder varmı if'i


			$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorders[$i]->id.' and checkdate=0'));
			//$servisRaporVarMi = $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if(!$isbiticekmi)
			{
				$modelW->status=3;
				$modelW->executiondate=time();
			}
			else{

				$modelW->status=$workorders[$i]->status;
			}
			$modelW->update();

	} //// Workorder for  end

    $this->result('','Senkronize başarılı..');




}

public function actionConformities()
{

	$ax= User::model()->userobjecty('');
	$ax->branchid;

	 $user=$this->autoauth();

    //var_dump($user);

	if($user['type']==13)
	{
		$model=array();
	}
	else
	{
		// $user['id']=350;
		// $user['branchid']=2;

		// $model=Conformity::model()->findAll(array('condition'=>'statusid=4 and branchid='.$user['branchid'],'limit'=>10,'order'=>'id desc'));
        /*
		$y=Yii::app()->db->createCommand('SELECT id FROM staffteam where leaderid='.$user['id'].' or staff LIKE "%,'.$user['id'].',%" or staff LIKE "'.$user['id'].',%" or staff LIKE "%,'.$user['id'].'"')->queryall();


		$ekip='';
		 for($k=0;$k<count($y);$k++)
		{
			 if($k==0)
			{
				$ekip=$y[$k]['id'];
			}
			else
			{
				$ekip=$ekip.','.$y[$k]['id'];
			}
		 }
        */

		$model=Yii::app()->db->createCommand('SELECT conformity.*,workorder.date as workorderdate,workorder.finish_time as finishtime,workorder.start_time FROM conformity INNER JOIN workorder ON workorder.clientid=conformity.clientid where
		(conformity.statusid=4 or conformity.statusid=3) and workorder.status!=3 and workorder.branchid='.$user['branchid'].' group by conformity.id')->queryall();
        //workorder.teamstaffid in ('.$ekip.') or
	}



    $array=array();
   /* foreach ($model as $conformity) {
      array_push($array,array(
        'id'=>$conformity->id,
        'userid'=>$conformity->userid,
        'firmid'=>$conformity->firmid,
        'firmbranchid'=>$conformity->firmbranchid,
        'branchid'=>$conformity->branchid,
        'clientid'=>$conformity->clientid,
        'clientname'=>Client::model()->findbypk($conformity->clientid)->name,
        'departmentid'=>$conformity->departmentid,
        'subdepartmentid'=>$conformity->subdepartmentid,
        'departmentname'=>Departments::model()->findByPk($conformity->departmentid)->name,
        'subdepartmentname'=>Departments::model()->findByPk($conformity->subdepartmentid)->name,
        'type'=>$conformity->type,
        'typename'=>Conformitytype::model()->findByPk($conformity->type)->name,
        'definition'=>$conformity->definition,
        'suggestion'=>$conformity->suggestion,
        'priority'=>$conformity->priority,
        'date'=>date("d-m-Y H:i",$conformity->date),
        'image'=>"https://insectram.io".$conformity->filesf,

      ));
    }
	*/

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
            'userid'=>$model[$i]['userid'],
            'firmid'=>$model[$i]['firmid'],
            'firmbranchid'=>$model[$i]['firmbranchid'],
            'branchid'=>$model[$i]['branchid'],
            'clientid'=>$model[$i]['clientid'],
            'clientname'=>Client::model()->findbypk($model[$i]['clientid'])->name,
            'departmentid'=>$model[$i]['departmentid'],
            'subdepartmentid'=>$model[$i]['subdepartmentid'],
            'departmentname'=>Departments::model()->findByPk($model[$i]['departmentid'])->name,
            'subdepartmentname'=>Departments::model()->findByPk($model[$i]['subdepartmentid'])->name,
            'type'=>$model[$i]['type'],
            'typename'=>Conformitytype::model()->findByPk($model[$i]['type'])->name,
            'status'=> $model[$i]['statusid'],
            'numberid'=> $model[$i]['numberid'],
            'definition'=>$model[$i]['definition'],
            'suggestion'=>$model[$i]['suggestion'],
            'priority'=>$model[$i]['priority'],
            'date'=>date("d-m-Y H:i",$model[$i]['date']),
            'image'=>"https://insectram.io".$model[$i]['filesf'],

          ));
        }
      }else {
      array_push($array,array(
        'id'=>$model[$i]['id'],
        'userid'=>$model[$i]['userid'],
        'firmid'=>$model[$i]['firmid'],
        'firmbranchid'=>$model[$i]['firmbranchid'],
        'branchid'=>$model[$i]['branchid'],
        'clientid'=>$model[$i]['clientid'],
        'clientname'=>Client::model()->findbypk($model[$i]['clientid'])->name,
        'departmentid'=>$model[$i]['departmentid'],
        'subdepartmentid'=>$model[$i]['subdepartmentid'],
        'departmentname'=>Departments::model()->findByPk($model[$i]['departmentid'])->name,
        'subdepartmentname'=>Departments::model()->findByPk($model[$i]['subdepartmentid'])->name,
        'type'=>$model[$i]['type'],
        'typename'=>Conformitytype::model()->findByPk($model[$i]['type'])->name,
        'status'=> $model[$i]['statusid'],
        'numberid'=> $model[$i]['numberid'],
        'definition'=>$model[$i]['definition'],
        'suggestion'=>$model[$i]['suggestion'],
        'priority'=>$model[$i]['priority'],
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
        $jsonbody=array();
        $error=array();
        if ($errorx=='')
        {
            $success=array('success'=>true);
            $error=array('error'=>null);
        }
        else
        {
            $success=array('success'=>false );
            $error=array('error'=>$errorx);
        }
        $result= array('data'=>$result);
        $jsonbody=array_merge($jsonbody,$success);
        $jsonbody=array_merge($jsonbody,$error);
        $jsonbody=array_merge($jsonbody,$result);
        echo str_replace('xx!!!xx','',json_encode((object)$jsonbody,  JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));
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
				if (isset($_REQUEST['deviceid']))
				{
					$a=Userdeviceid::model()->deleteall(array('condition'=>'userid='.$user->id));

					$a=new Userdeviceid;
					$a->userid=$user->id;
					$a->deviceid=$_REQUEST['deviceid'];
					$a->date=time();
					$a->save();
				}else
				{
					$this->result('Missing device id!');
				}
                $this->result('',array_merge($send,array('auth'=>(string)$user->code)));
            }
        }
    }
    public function jsonyaz($js,$fields)
    {
        header('Content-type: application/json');
        $as=array_map(create_function('$m','return $m->getAttributes(array('.$fields.'));'),$js);
        $this->result('',$as);
        //  echo json_encode($as, JSON_NUMERIC_CHECK);
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
                    'type'=>strtolower($yetki[count($yetki)-1]).$yetki[count($yetki)-1]
                    //'type'=>$auth->itemname
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
					if (isset($_REQUEST['deviceid']))
					{
					$a=Userdeviceid::model()->find(array('condition'=>'userid='.$user->id.' and deviceid="'.$_REQUEST['deviceid'].'"'));
					//if(isset($user->languageid))
					if (isset($_REQUEST['lang']))
					{
						if($_REQUEST['lang']=="en")
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
					//$a=Userdeviceid::model()->find(array('condition'=>'userid='.$user->id.' and deviceid like "%'.$_REQUEST['deviceid'].'%"'));
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
    { /// user auth code geri d�necek$jsonbody=array();
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

    public function actionGetclients()
    {
        $user=$this->autoauth();
        $firm=Firm::model()->findByPk($user->branchid);
        $list = array();
        $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$firm->id)); // client
        if ($clients)
        {
            foreach ( $clients as $client){
                array_push($list,array(
                    'id'=>$client->id,
                    'branchid'=>$client->branchid,
                    'parentid'=>$client->parentid,
                    'name'=>$client->name,
                    'title'=>$client->title,
                    'taxoffice'=>$client->taxoffice,
                    'taxno'=>$client->taxno,
                    'firmid'=>$client->firmid
                ));
            }
            $this->result('',$list);
        }
    }

    public function actionGetclientsbranch($id)
    {
        $list = array();
        $clients=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$id));
        if ($clients) {
            foreach ( $clients as $client){
                array_push($list,array(
                    'id'=>$client->id,
                    'branchid'=>$client->branchid,
                    'parentid'=>$client->parentid,
                    'name'=>$client->name,
                    'title'=>$client->title
                ));
            }
            $this->result('',$list);
        }
        else
        {
            $this->result('Branch Bulunamadı.');
        }
    }
    public function actionGetdepartments($id)
    {
        $Departments=Departments::model()->findAll(array('condition'=>'parentid=0 and clientid='.$id));
        $list=array();
        if ($Departments)
        {
            foreach ($Departments as $Department)
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
            $this->result('Department Not Found');
        }

    }

    public function actionAddconformity()
    {
 
     $str=file_get_contents('php://input');
  	 $filenamex='apilogs/'.time().'-conformity.txt';
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
      	$filenamex='apilogs/'.time().'-conformities.txt';
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

    public function actionFirms()
    {
        $Firms=Firm::model()->findAll(array('condition'=>'parentid=0'));
        $list=array();
        foreach ($Firms as $Firm)
        {
            array_push($list,array(
                'id'=>$Firm->id,
                'parentid'=>$Firm->parentid,
                'name'=>$Firm->name,
                'username'=>$Firm->username,
                'title'=>$Firm->title,
                'taxoffice'=>$Firm->taxoffice,
                'taxno'=>$Firm->taxno,
                'address'=>$Firm->address,
                'landphone'=>$Firm->landphon
            ));
        }
        $this->result('',$list);
    }

    public function actionFirmsbranch($id)
    {
        $Firms=Firm::model()->findAll(array('condition'=>'parentid='.$id));
        $list=array();
        foreach ($Firms as $Firm)
        {
            array_push($list,array(
                'id'=>$Firm->id,
                'parentid'=>$Firm->parentid,
                'name'=>$Firm->name,
                'username'=>$Firm->username,
                'title'=>$Firm->title,
                'taxoffice'=>$Firm->taxoffice,
                'taxno'=>$Firm->taxno,
                'address'=>$Firm->address,
                'landphone'=>$Firm->landphone,

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

}
