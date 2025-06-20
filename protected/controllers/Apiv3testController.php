<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


class Apiv3testController extends Controller
{
    public function filters()
    {
        return ["accessControl", "postOnly + delete"];
    }
    public function actions()
    {
        return [
            "captcha" => [
                "class" => "CCaptchaAction",
                "backColor" => 0xffffff,
            ],
            "page" => [
                "class" => "CViewAction",
            ],
        ];
    }
	
  public function init()
  {
    parent::init();

    //Yii::app()->attachEventHandler('onError',array($this,'handleError'));
    //Yii::app()->attachEventHandler('onException',array($this,'handleError'));
  }

  public function handleError(CEvent $event)
  {        
    if ($event instanceof CExceptionEvent)
    {
			var_dump($event);
      // handle exception
      // ...
    }
    elseif($event instanceof CErrorEvent)
    {
						var_dump($event);
      // handle error
      // ...
    }

    $event->handled = TRUE;
  }

    public function result($errorx = "", $result = "")
    {
        header("Content-type: application/json");
        if ($errorx == "") {
            http_response_code(200);
            $res = "";
            if (is_string($result)) {
                echo '"' . $result . '"';
            } else {
                echo str_replace(
                    "xx!!!xx",
                    "",
                    json_encode(
                        is_array($result) ? (array) $result : (object) $result,
                        JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
                    )
                );
            }
        } elseif ($errorx == "logout") {
            http_response_code(401);
            echo "logout";
        } else {
            http_response_code(400);
            echo str_replace("xx!!!xx", "", $errorx);
        }
        exit();
    }

    ////////////\\\\\\\\\\\\
    public function actionLogin($u = "", $p = "")
    {
        if ($u == "") {
            $this->result("Invalit Code or Username.");
        }
        $auth = $this->getauth($u, $p);
    }

    ////////////\\\\\\\\\\\\
    public function getauth($u = "", $p = "", $onesignalid = "")
    {
        $user = User::model()->find([
            "condition" => "(email=:socialid) or (username=:socialid)",
            "params" => [":socialid" => $u],
        ]);
        if ($user === null) {
            $this->result("User not found.");
        } else {
            if (!CPasswordHelper::verifyPassword($p, $user->password)) {
                $this->result("Wrong Password.");
            } else {
                $send = $this->userinfo($user->id);
                if (isset($_SERVER["HTTP_DEVICEID"])) {
                    $a = Userdeviceid::model()->deleteall([
                        "condition" => "userid=" . $user->id,
                    ]);

                    $a = new Userdeviceid();
                    $a->userid = $user->id;
                    $a->deviceid = $_SERVER["HTTP_DEVICEID"];
                    $a->date = time();
                    $a->save();
                } else {
                    $this->result("Missing device id!");
                }

                $userlog = new Userlog();
                $userlog->userid = $user->id;
                $userlog->username = $user->username;
                $userlog->name = $user->name;
                $userlog->surname = $user->surname;
                $userlog->email = $user->email;
                $userlog->ipno = getenv("REMOTE_ADDR");
                $userlog->ismobilorweb = "mobil";
                $userlog->entrytime = time();
                $userlog->save();

                $this->result(
                    "",
                    array_merge($send, ["auth" => (string) $user->code])
                );
            }
        }
    }

    public function actionErrors()
    {
        $user = $this->autoauth();
        $str = file_get_contents("php://input");

        $model = new AppErrors();
        $model->data = $str;
        $model->createdtime = time();
        if ($model->save()) {
            $this->result("Basarili");
        } else {
            $this->result($model->getErrors());
        }
    }

    public function userinfo($id, $who = null)
    {
        $user = User::model()->findbypk($id);
        if ($user === null) {
            $this->result("User not found.");
        } else {
            if ($who == null) {
                $userclientname = Client::model()->findByPk($user->clientid);

                $auth = AuthAssignment::model()->find([
                    "condition" => "userid=" . $user->id,
                ]);
                $yetki = explode(".", $auth->itemname);
							  $userfirm = Firm::model()->findByPk($user->firmid);
						
							
							
							
							
							        $listmenu=[];
        $listmenu2=[];
        
        ///ilk buton
							/*
         array_push($listmenu2,array(
                      'name'=>'View Recom.',
                      'url'=>'https://instagram.com/',
                      'login'=>true,
                  ));
         array_push($listmenu2,array(
                      'name'=>'Create Recom.',
                      'url'=>'https://google.com/',
                      'login'=>true,
                  ));
        
          array_push($listmenu,array(
                      'name'=>'Recom. Management',
                      'data'=>$listmenu2,
                  ));
        /// 2. buton
        $listmenu2=[];
           array_push($listmenu2,array(
                      'name'=>'View Workorders',
                      'url'=>'https://facebook.com/',
                      'login'=>true,
                  ));
         array_push($listmenu2,array(
                      'name'=>'Create Workorder',
                      'url'=>'https://gmail.com/',
                      'login'=>true,
                  ));
        
          array_push($listmenu,array(
                      'name'=>'Workorders',
                      'data'=>$listmenu2,
                  ));
        
							*/
							
							
                return [
                    "id" => $user->id,
                    "username" => $user->username,
                    "namesurname" => $user->name . " " . $user->surname,
                    "firmid" => $user->firmid,
                    "clientid" => $user->clientid,
                    "clientname" => $userclientname->name,
                    "type" => $yetki[count($yetki) - 1],
                    "loggedIn" => true,
										"country_id"=>	$userfirm->country_id,
										"menu"=>	$listmenu,
                ];
            } else {
                $userclientname = Client::model()->findByPk($user->clientid);
                return [
                    "id" => $user->id,
                    "username" => $user->username,
                    "namesurname" => $user->name . "" . $user->surname,
                    "firmid" => $user->firmid,
                    "clientid" => $user->clientid,
                    "clientname" => $userclientname->name,
                    "clientname" => $listmenu,
                ];
            }
        }
    }

    ////////////\\\\\\\\\\\\
    public function auth()
    {
        $code = $_SERVER["HTTP_AUTHORIZATION"];
        $user = User::model()->find([
            "condition" => "code=:code",
            "params" => [":code" => $code],
        ]);
        if ($user === null) {
            $this->result("Authorization problem. Please login.");
        } else {
            $info = $this->userinfo($user->id);
            return $info;
        }
    }
    ////////////\\\\\\\\\\\\
    public function getuserid()
    {
        if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
            return 0;
        }
        $code = $_SERVER["HTTP_AUTHORIZATION"];
        $user = User::model()->find([
            "condition" => "code=:code",
            "params" => [":code" => $code],
        ]);
        if ($user === null) {
            return 0;
        } else {
            return $user->id;
        }
    }
    ////////////\\\\\\\\\\\\
    public function autoauth()
    {
        if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
            $code = $_SERVER["HTTP_AUTHORIZATION"];

            $user = User::model()->find([
                "condition" => "code=:code",
                "params" => [":code" => $code],
            ]);
            if ($user === null) {
                $this->result("Authorization problem. Please login." . $code);
                exit();
            } else {
                if (isset($_SERVER["HTTP_DEVICEID"])) {
                    $a = Userdeviceid::model()->find([
                        "condition" =>
                            "userid=" .
                            $user->id .
                            ' and deviceid="' .
                            $_SERVER["HTTP_DEVICEID"] .
                            '"',
                    ]);
                    if (isset($_SERVER["HTTP_LANG"])) {
                        if ($_SERVER["HTTP_LANG"] == "en") {
                            $ddil = "en";
                        } else {
                            $ddil = "tr";
                        }

                        $dir = dirname(__FILE__);
                        $dir = rtrim($dir, "/controllers");
                        $langfileurl =
                            $dir .
                            "/modules/translate/languages/" .
                            $ddil .
                            ".php";

                        include $langfileurl;
                    }
                    if (!$a) {
                        $this->result("logout");
                    }
                } else {
                    $this->result("logout");
                }
                return $user;
            }
        } else {
            $this->result("Authorization problem. Please login..");
            exit();
        }
    }

    ////////////\\\\\\\\\\\\
    public function actionLogout()
    {
        $user = $this->autoauth();
        //$model=User::model()->findbypk($user->id);
        //$model->onesignalid='';
        //$model->update();
        $this->result("");
    }
    ////////////\\\\\\\\\\\\

    public function actionWorkorders()
    {
        $user = $this->autoauth();
        $ax = User::model()->find(["condition" => "id=" . $user->id]);
        $userlog = new Userlog();
        $userlog->userid = $user->id;
        $userlog->username = $user->username;
        $userlog->name = $user->name;
        $userlog->surname = $user->surname;
        $userlog->email = $user->email;
        $userlog->ipno = getenv("REMOTE_ADDR");
        $userlog->ismobilorweb = "mobil";
        $userlog->entrytime = time();
        $userlog->save();
        $listworkorder = [];
        $listmonitor = [];
        $listdata = [];
        $arrayClientsids = [];
        $datestart = date("Y-m-d");
        $datefinish = date("Y-m-d", strtotime("+1 week"));
        $workorders = Workorder::model()->findAll([
            "condition" =>
                'date<="' .
                $datefinish .
                '" and status!=3 and branchid=' .
                $ax->branchid,
            "order" => "date ASC, start_time ASC",
        ]);
        $itfirmlist = [];
        if ($user->id != 1) {
            foreach ($workorders as $workorder) {
					
                if ($workorder->teamstaffid || $workorder->teamstaffid != 0) {
                    $staffteam = Staffteam::model()->find([
                        "condition" =>
                            "id=" .
                            $workorder->teamstaffid .
                            " and (leaderid=" .
                            $user->id .
                            ' or staff like "%' .
                            $user->id .
                            '%")',
                    ]);
									
                }
												
                if (
                    ( ($workorder->staffid == null ||  $workorder->staffid == 0) &&
                      $staffteam &&  $staffteam->id == $workorder->teamstaffid) ||
                    ($workorder->staffid == $user->id &&
                        ($workorder->teamstaffid == null ||
                            $workorder->teamstaffid == 0))
                ) {
					
                    $date = strtotime($workorder->date);
                    if (
                        ($workorder->firmid == 1 && ///safran için 3 gün geliyor
                            $date <= strtotime("+3 days")) ||
                        ($workorder->firmid != 1 && //diğer firmalar için 1 haftalık geliyor
                            $date <= strtotime("+7 days"))
                    ) {
                        array_push($arrayClientsids, $workorder->clientid);
											if ($workorder->visittypeid==62 || $workorder->visittypeid==31){
												  $workordermonitors = Mobileworkordermonitorsti::model()->findAll(
                            [
                                "condition" => "workorderid=" . $workorder->id,
                                "order" => "monitorno asc",
                            ]
                        );
											}else{
												  $workordermonitors = Mobileworkordermonitors::model()->findAll(
                            [
                                "condition" => "workorderid=" . $workorder->id,
                                "order" => "monitorno asc",
                            ]
                        );
												
											}
                      
                        if ($workordermonitors) {
                            foreach ($workordermonitors as $workordermonitor) {
																if ($workorder->visittypeid==62 || $workorder->visittypeid==31){
																	  $workorderdatas = Mobileworkorderdatati::model()->findAll(
                                    [
                                        "condition" =>
                                            "mobileworkordermonitorsid=" .
                                            $workordermonitor->id,
                                        "order" => "monitorid asc, id asc",
                                    ]
                                );
																}else{
																	  $workorderdatas = Mobileworkorderdata::model()->findAll(
                                    [
                                        "condition" =>
                                            "mobileworkordermonitorsid=" .
                                            $workordermonitor->id,
                                        "order" => "monitorid asc, id asc",
                                    ]
                                );
																}
															
                              
                                if ($workorderdatas) {
                                    foreach (
                                        $workorderdatas
                                        as $workorderdata
                                    ) {
                                        $pet = Pets::model()->findByPk(
                                            $workorderdata->petid
                                        );
                                        array_push($listdata, [
                                            "id" => $workorderdata->id,
                                            "title" => t($pet->name), //alper bura
                                            "petid" => $workorderdata->petid,
                                            "pettype" =>
                                                $workorderdata->pettype,
                                            "value" => $workorderdata->value,
                                            "isproduct" =>
                                                $workorderdata->isproduct,
                                        ]);
                                        $title = "";
                                    }
                                }
															$mtypename=Monitoringtype::model()->findByPk(
                                            $workordermonitor->monitortype
                                        );
															if ($mtypename){
																$mtypename=$mtypename->name;
															}else{
																$mtypename='Not Found!';
															}
                                array_push($listmonitor, [
                                    "id" => $workordermonitor->id,
                                    "monitorid" => $workordermonitor->monitorid,
                                    "monitorno" => $workordermonitor->monitorno,
                                   // "monitortype" =>
                                       // $workordermonitor->monitortype,
                                    "monitortypename" =>
                                        $mtypename,
                                    "barcodeno" =>
                                        "xx!!!xx" .
                                        $workordermonitor->barcodeno,
                                    "monitorStatus" => 0,
                                    "checkdate" => $workordermonitor->checkdate,
                                    "synced" => true,
                                    "monitorData" => $listdata,
                                ]);
                                unset($listdata);
                                $listdata = [];
                            }
                        }
                        $branch = Firm::model()->findByPk($workorder->branchid);
                        $workclient = Client::model()->findByPk(
                            $workorder->clientid
                        );
                        if ($workorder->staffid != "") {
                            $staffid = $workorder->staffid;
                        } else {
                            $staffid = 0;
                        }

                        $visittype = Visittype::model()->findByPk(
                            $workorder->visittypeid
                        );
                        $modelServiceR = Servicereport::model()->find([
                            "condition" => "reportno=" . $workorder->id,
                        ]);
											$tilist=null;
											if ($workorder->visittypeid==62){
										
													  $tilistarr = 	Tichecklists::model()->findAll([
                "condition" => "firm_id=" . $workorder->firmid,
            ]);
												foreach($tilistarr as $ixtrm){
													$tilist[]=['id'=>$ixtrm->id,
																		 'item_name'=>$ixtrm->item_name,
																	//	 'item_type'=>$ixtrm->item_type,
																		 'value'=>-1];
												}
											}
											$clientinfo=[];
											$clientinfo['address']=$workclient->address;
											$clientbranchid=$workclient->id;
											   $phoneuser = User::model()->find([
                            "condition" => "type= 26 and clientbranchid=" . $clientbranchid,
                        ]);
															/// 26 = type clientbranchid 
											$clientinfo['client_admin']='';//'Client Yetkili Adı';
											//$clientinfo['client_admin_phone']='a07493392335';
											$clientinfo['client_admin_phone']='a0';
											if($phoneuser){
												
												$clientinfo['client_admin']=$phoneuser->name.' '.$phoneuser->surname;
												   $phoneuser = Userinfo::model()->find([
                            "condition" => "userid=" . $phoneuser->id,
                        ]);
												if ($phoneuser && $phoneuser->primaryphone<>''){
															$clientinfo['client_admin_phone']='a'.$phoneuser->primaryphone;
												}
												
											}
							
                        array_push($listworkorder, [
                            "id" => $workorder->id,
                            "date" => $workorder->date,
                            "start_time" => $workorder->start_time,
                            "finish_time" => $workorder->finish_time,
                            "service_report_ok" => $modelServiceR != null,
                            "visittypename" => t($visittype->name),
                            "clientname" => $workclient->name,
                            "address" => $workclient->address,
                            "clientinfo" => $clientinfo,
                            "todo" => $workorder->todo,
                            "branchid" => $workorder->clientid,
                            "branchname" => $workclient->name,
                            "barcode" => $workorder->clientid,//$workorder->barcode,
                            "status" => $workorder->status,
                            "realstarttime" => 0,
                            "realendtime" => 0,
                            "synced" => true,
                            "riskmanagement" => 1,
                            "ti_check_list" => $tilist,
                            // 'cant_scan_comment'=>'',
                            "workordermonitors" => $listmonitor,
                        ]);
											
											
                        $workclient = null;
                        unset($listmonitor);
                        $listmonitor = [];
                    }
                }
            }
        }
        $this->result("", $listworkorder);
    }
    ////////////\\\\\\\\\\\\
    public function actionMobileclients($arrayClientsids = false)
    {
        $user = $this->autoauth();
        $list = [];
        $listdepartments = [];
        $listsubdepartments = [];

        $listfirms = [];
        $listfirmsbranchs = [];
        $listclients = [];
        $listclientsbranchs = [];
        $listdepartments = [];
        $listsubdepartments = [];

        $auth = AuthAssignment::model()->find([
            "condition" => "userid=" . $user->id,
        ]);
        $yetki = explode(".", $auth->itemname);
        $isclient_x = 0;
        if (
            $user->type == 22 ||
            $user->type == 24 ||
            $user->type == 25 ||
            $user->type == 26 ||
            $user->type == 27
        ) {
            $isclient_x = 1;
            $clients = Client::model()->findAll([
                "condition" => "parentid=0 and id=" . $user->clientid,
            ]);
        } else {
            $clients = Client::model()->findAll([
                "condition" => "parentid=0 and firmid=" . $user->branchid,
            ]);
        }
        if ($yetki[count($yetki) - 1] != "Admin") {
            if ($clients) {
                foreach ($clients as $client) {
                    if ($user->id == 1673) {
                        if (
                            $arrayClientsids != false &&
                            array_search($client->id, $arrayClientsids)
                        ) {
                        } else {
                            continue;
                        }
                    }
                    $list2 = [];
                    $clientsbranchs = Client::model()->findAll([
                        "condition" =>
                            "isdelete=0 and  parentid=" . $client->id,
                    ]);
                    if ($clientsbranchs) {
                        foreach ($clientsbranchs as $clientsbranch) {
                            $departments = Departments::model()->findAll([
                                "condition" =>
                                    "active=1 and parentid=0 and clientid=" .
                                    $clientsbranch->id,
                            ]);
													$listdepartments=[];
                            if ($departments) {
                                foreach ($departments as $department) {
                                    $subdepartments = Departments::model()->findAll(
                                        [
                                            "condition" =>
                                                "active=1 and clientid=" .
                                                $clientsbranch->id .
                                                " and parentid=" .
                                                $department->id,
                                        ]
                                    );$listsubdepartments=[];
                                    if ($subdepartments) {
                                        foreach (
                                            $subdepartments
                                            as $subdepartment
                                        ) {
                                            array_push($listsubdepartments, [
                                                "id" => $subdepartment->id,
                                                "name" => $subdepartment->name,
                                            ]);
                                        }
                                    }
                                    array_push($listdepartments, [
                                        "id" => $department->id,
                                        "name" => $department->name,
                                        "subdepartments" => $listsubdepartments,
                                    ]);
                                    unset($listsubdepartments);
                                    $listsubdepartments = [];
                                }
                            }
                            array_push($list2, [
                                "id" => $clientsbranch->id,
                                "branchid" => $clientsbranch->branchid,
                                "parentid" => $clientsbranch->parentid,
                                "name" => $clientsbranch->name,
                                "title" => $clientsbranch->title,
                        "client_audited" => $clientsbranch->simple_client,
                        "simple_client" => $clientsbranch->simple_client,
                                "departments" => $listdepartments,
                            ]);
                        }
                    }
                    array_push($list, [
                        "id" => $client->id,
                        "branchid" => $client->branchid,
                        "parentid" => $client->parentid,
                        "name" => $client->name,
                        "title" => $client->title,
                        "firmid" => $client->firmid,
                        "client_audited" => $client->simple_client,
                        "simple_client" => $client->simple_client,
                        "clientsbranchs" => $list2,
                    ]);
                }
            }
            $firms1 = Firm::model()->findByPk($user->branchid);
            array_push($listfirms, [
                "id" => $firms1->id,
                "name" => $firms1->name,

                "clients" => $list,
            ]);
        } else {
            $ax = User::model()->find(["condition" => "id=" . $user->id]);
            if ($ax->branchid == 0) {
                $firms = Firm::model()->findAll([
                    "condition" => "parentid=" . $user->firmid,
                    "order" => "name",
                ]);
            } else {
                $firms = Firm::model()->findAll([
                    "condition" => "id=" . $user->branchid,
                    "order" => "name",
                ]);
            }

            if ($isclient_x == 1) {
                $firms = Firm::model()->findAll([
                    "condition" => "id=" . $user->mainbranchid,
                ]);
            }
            foreach ($firms as $firm) {
                if ($isclient_x == 1) {
                    $clients = Client::model()->findAll([
                        "condition" => "parentid=0 and id=" . $user->clientid,
                    ]);
                } else {
                    $clients = Yii::app()
                        ->db->createCommand()
                        ->select("c.*")
                        ->from("client c")
                        ->leftJoin("client cb", "cb.parentid=c.id")
                        ->where(
                            "c.isdelete=0 and c.active=1 and c.parentid=0 and cb.firmid=" .
                                $firm->id
                        )
                        ->group("c.id");
                    $clients = $clients->queryAll();
                }

                foreach ($clients as $client) {
                    $clientsbranchs = Client::model()->findAll([
                        "condition" =>
                            "isdelete=0 and active=1 and parentid=" .
                            $client["id"] .
                            " and firmid=" .
                            $firm->id,
                    ]);
					
                    foreach ($clientsbranchs as $clientsbranch) {
										  if ($isclient_x == 1 && $user->mainclientbranchid<>0) {
												if($clientsbranch->id<>$user->mainclientbranchid){
													continue;
												}
												
											}
											
                        $departments = Departments::model()->findAll([
                            "condition" =>
                                "active=1 and parentid=0 and clientid=" .
                                $clientsbranch->id,
                        ]);
                        if ($departments) {
                            foreach ($departments as $department) {
                                $subdepartments = Departments::model()->findAll(
                                    [
                                        "condition" =>
                                            "active=1 and clientid=" .
                                            $clientsbranch->id .
                                            " and parentid=" .
                                            $department->id,
                                    ]
                                );
                                if ($subdepartments) {
                                    foreach (
                                        $subdepartments
                                        as $subdepartment
                                    ) {
                                        array_push($listsubdepartments, [
                                            "id" => $subdepartment->id,
                                            "name" => $subdepartment->name,
                                        ]);
                                    }
                                }
                                array_push($listdepartments, [
                                    "id" => $department->id,
                                    "name" => $department->name,
                                    "subdepartments" => $listsubdepartments,
                                ]);
                                unset($listsubdepartments);
                                $listsubdepartments = [];
                            }
                        }
                        array_push($listclientsbranchs, [
                            "id" => $clientsbranch->id,
                            "name" => $clientsbranch->name,
                            "branchid" => $clientsbranch->branchid,
                            "parentid" => $clientsbranch->parentid,
                            "title" => $clientsbranch->title,
                            "firmid" => $clientsbranch->firmid,
                            "departments" => $listdepartments,
                        ]);
									

                        unset($listdepartments);
                        $listdepartments = [];
                    }
                    array_push($listclients, [
                        "id" => $client["id"],
                        "name" => $client["name"],
                        "branchid" => $client["branchid"],
                        "parentid" => $client["parentid"],
                        "title" => $client["title"],
                        "firmid" => $client["firmid"],
                        "clientsbranchs" => $listclientsbranchs,
                    ]);
                    unset($listclientsbranchs);
                    $listclientsbranchs = [];
                }
                array_push($listfirms, [
                    "id" => $firm->id,
                    "name" => $firm->name,
                    "clients" => $listclients,
                ]);
                unset($listclients);
                $listclients = [];
            }
            //$dwqdwqdq=array();
            //$this->result('',array('Firms'=>$listfirms,'Workorders'=>$dwqdwqdq)); exit;
        } // else bitti
        ////////////////
        // Clients & Clients Branchs End--

        // Workorder
        $listworkorder = [];
        $listmonitor = [];
        $listdata = [];

        $workorders = Workorder::model()->findAll([
            "condition" => "status!=3",
            "order" => "date ASC, start_time ASC",
        ]);
        //$workorders=Workorder::model()->findAll(array('condition'=>'branchid='.$user->branchid)); //
    
        return $listfirms;
        $this->result("", [
            "Firms" => $listfirms,
            "Workorders" => $listworkorder,
        ]);
    } // action end
    ////////////\\\\\\\\\\\\

    public function actionClientlists()
    {
        $user = $this->autoauth();
        $ax = User::model()->find(["condition" => "id=" . $user->id]);
        $userlog = new Userlog();
        $userlog->userid = $user->id;
        $userlog->username = $user->username;
        $userlog->name = $user->name;
        $userlog->surname = $user->surname;
        $userlog->email = $user->email;
        $userlog->ipno = getenv("REMOTE_ADDR");
        $userlog->ismobilorweb = "mobil";
        $userlog->entrytime = time();
        $userlog->save();
        $listworkorder = [];
        $listmonitor = [];
        $listdata = [];
        $arrayClientsids = [];
        $itfirmlist = [];
        $list = [];
        $listdepartments = [];
        $listsubdepartments = [];
        $listfirms = [];
        $listfirmsbranchs = [];
        $listclients = [];
        $listclientsbranchs = [];
        $listdepartments = [];
        $listsubdepartments = [];
        $clientler = [];
        $auth = AuthAssignment::model()->find([
            "condition" => "userid=" . $user->id,
        ]);
        $yetki = explode(".", $auth->itemname);/*
        foreach ($arrayClientsids as $motherclient) {
            $clients = Client::model()->findByPk($motherclient); // client
            if (
                !in_array(
                    Client::model()->findByPk($clients->parentid),
                    $clientler
                )
            ) {
                array_push(
                    $clientler,
                    Client::model()->findByPk($clients->parentid)
                );
            }
        }
        if ($yetki[count($yetki) - 1] != "Admin") {
		
            //  $clients=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$user->branchid)); // client
            if ($clientler) {
                foreach ($clientler as $client) {
                    $list2 = [];
                    $clientsbranchs = Client::model()->findAll([
                        "condition" =>
                            "isdelete=0 and firmid=" .
                            $user->branchid .
                            " and  parentid=" .
                            $client->id,
                        "order" => "name",
                    ]);
                    if ($clientsbranchs) {
                        foreach ($clientsbranchs as $clientsbranch) {
                            // Departmens & Subdepartments
                            $departments = Departments::model()->findAll([
                                "condition" =>
                                    "active=1 and parentid=0 and clientid=" .
                                    $clientsbranch->id,
                                "order" => "name",
                            ]);
                            if ($departments) {
                                foreach ($departments as $department) {
                                    $subdepartments = Departments::model()->findAll(
                                        [
                                            "condition" =>
                                                "active=1 and clientid=" .
                                                $clientsbranch->id .
                                                " and parentid=" .
                                                $department->id,
                                            "order" => "name",
                                        ]
                                    );
                                    if ($subdepartments) {
                                        foreach (
                                            $subdepartments
                                            as $subdepartment
                                        ) {
                                            array_push($listsubdepartments, [
                                                "id" => $subdepartment->id,
                                                "name" => $subdepartment->name,
                                            ]);
                                        }
                                    } else {
                                        array_push($listsubdepartments, [
                                            "id" => 0,
                                            "name" => "Sub departman yok",
                                        ]);
                                    }
                                    array_push($listdepartments, [
                                        "id" => $department->id,
                                        "name" => $department->name,
                                        "subdepartments" => $listsubdepartments,
                                    ]);
                                    unset($listsubdepartments);
                                    $listsubdepartments = [];
                                }
                            } else {
                                array_push($listsubdepartments, [
                                    "id" => 0,
                                    "name" => "Sub departman yok",
                                ]);
                                array_push($listdepartments, [
                                    "id" => 0,
                                    "name" => "Departman Yok",
                                    "subdepartments" => $listsubdepartments,
                                ]);
                                unset($listsubdepartments);
                                $listsubdepartments = [];
                            }
                            // Departmens & Subdepartments End--
                            array_push($list2, [
                                "id" => $clientsbranch->id,
                                "branchid" => $clientsbranch->branchid,
                                "parentid" => $clientsbranch->parentid,
                                "name" => $clientsbranch->name,
                                "title" => $clientsbranch->title,
                                "departments" => $listdepartments,
                            ]);
                            unset($listdepartments);
                            $listdepartments = [];
                        }
                    }
                    array_push($list, [
                        "id" => $client->id,
                        "branchid" => $client->branchid,
                        "parentid" => $client->parentid,
                        "name" => $client->name,
                        "title" => $client->title,
                        "firmid" => $client->firmid,
                        "clientsbranchs" => $list2,
                    ]);
                }
            }
            $firms1 = Firm::model()->findByPk($user->branchid);
            array_push($listfirms, [
                "id" => $firms1->id,
                "name" => $firms1->name,
                "clients" => $list,
            ]);
        } else {
							
            if ($ax->branchid == 0) {
                $firms = Firm::model()->findAll([
                    "condition" => "parentid=" . $user->firmid,
                    "order" => "name",
                ]);
					
            } else {
							
                $firms = Firm::model()->findAll([
                    "condition" => "id=" . $user->branchid,
                    "order" => "name",
                ]);
            }
            foreach ($firms as $firm) {
                $clients = Client::model()->findAll([
                    "condition" =>
                        "isdelete=0 and active=1 and parentid=0 and firmid=" .
                        $firm->id,
                    "order" => "name",
                ]);
							
                foreach ($clients as $client) {
						
                    $clientsbranchs = Client::model()->findAll([
                        "condition" =>
                            "isdelete=0 and firmid=" .
                            $firm->id .
                            " and active=1 and parentid=" .
                            $client->id,
                        "order" => "name",
                    ]);
										
                    foreach ($clientsbranchs as $clientsbranch) {
								
                        $departments = Departments::model()->findAll([
                            "condition" =>
                                "active=1 and parentid=0 and clientid=" .
                                $clientsbranch->id,
                            "order" => "name",
                        ]);
                        if ($departments) {
													
                            foreach ($departments as $department) {
                                $subdepartments = Departments::model()->findAll(
                                    [
                                        "condition" =>
                                            "active=1 and clientid=" .
                                            $clientsbranch->id .
                                            " and parentid=" .
                                            $department->id,
                                        "order" => "name",
                                    ]
                                );
                                if ($subdepartments) {
                                    foreach (
                                        $subdepartments
                                        as $subdepartment
                                    ) {
                                        array_push($listsubdepartments, [
                                            "id" => $subdepartment->id,
                                            "name" => $subdepartment->name,
                                        ]);
                                    }
                                } else {
                                    array_push($listsubdepartments, [
                                        "id" => 0,
                                        "name" => "Sub departman yok",
                                    ]);
                                }
                                array_push($listdepartments, [
                                    "id" => $department->id,
                                    "name" => $department->name,
                                    "subdepartments" => $listsubdepartments,
                                ]);
                                unset($listsubdepartments);
                                $listsubdepartments = [];
                            }
                        } else {
                            array_push($listsubdepartments, [
                                "id" => 0,
                                "name" => "Sub departman yok",
                            ]);
                            array_push($listdepartments, [
                                "id" => 0,
                                "name" => "Departman Yok",
                                "subdepartments" => $listsubdepartments,
                            ]);
												
                            unset($listsubdepartments);
                            $listsubdepartments = [];
                        }
											
																		
                        array_push($listclientsbranchs, [
                            "id" => $clientsbranch->id,
                            "name" => $clientsbranch->name,
                            "branchid" => $clientsbranch->branchid,
                            "parentid" => $clientsbranch->parentid,
                            "title" => $clientsbranch->title,
                            "firmid" => $clientsbranch->firmid,
                            "departments" => $listdepartments,
                        ]);
											
                        unset($listdepartments);
                        $listdepartments = [];
                    }
                    array_push($listclients, [
                        "id" => $client->id,
                        "name" => $client->name,
                        "branchid" => $client->branchid,
                        "parentid" => $client->parentid,
                        "title" => $client->title,
                        "firmid" => $client->firmid,
                        "clientsbranchs" => $listclientsbranchs,
                    ]);
				
                    unset($listclientsbranchs);
                    $listclientsbranchs = [];
                }
                $trasferc = "";
                $say = 0;
                $clientbranchtrasfer = Client::model()->findAll([
                    "condition" =>
                        "isdelete=0 and active=1 and parentid!=0 and firmid!=mainfirmid and (firmid=" .
                        $firm->id .
                        " or mainfirmid=" .
                        $firm->id .
                        ") group by parentid",
                ]);
                foreach ($clientbranchtrasfer as $clientbranchtrasferx) {
                    if ($say == 0) {
                        $trasferc = $clientbranchtrasferx->parentid;
                    } else {
                        $trasferc =
                            $trasferc . "," . $clientbranchtrasferx->parentid;
                    }
                    $say++;
                }
                if ($trasferc) {
                    $clients = Client::model()->findAll([
                        "condition" =>
                            "isdelete=0 and active=1 and parentid=0 and id in (" .
                            $trasferc .
                            ")",
                    ]);

                    foreach ($clients as $client) {
                        $clientsbranchs = Client::model()->findAll([
                            "condition" =>
                                "isdelete=0 and active=1 and parentid=" .
                                $client->id .
                                " and firmid!=mainfirmid and (firmid=" .
                                $firm->id .
                                " or mainfirmid=" .
                                $firm->id .
                                ")",
                        ]);
                        foreach ($clientsbranchs as $clientsbranch) {
                            $departments = Departments::model()->findAll([
                                "condition" =>
                                    "active=1 and parentid=0 and clientid=" .
                                    $clientsbranch->id,
                            ]);
                            if ($departments) {
                                foreach ($departments as $department) {
                                    $subdepartments = Departments::model()->findAll(
                                        [
                                            "condition" =>
                                                "active=1 and clientid=" .
                                                $clientsbranch->id .
                                                " and parentid=" .
                                                $department->id,
                                        ]
                                    );
                                    if ($subdepartments) {
                                        foreach (
                                            $subdepartments
                                            as $subdepartment
                                        ) {
                                            array_push($listsubdepartments, [
                                                "id" => $subdepartment->id,
                                                "name" => $subdepartment->name,
                                            ]);
                                        }
                                    }
                                    array_push($listdepartments, [
                                        "id" => $department->id,
                                        "name" => $department->name,
                                        "subdepartments" => $listsubdepartments,
                                    ]);
                                    unset($listsubdepartments);
                                    $listsubdepartments = [];
                                }
                            }
                            array_push($listclientsbranchs, [
                                "id" => $clientsbranch->id,
                                "name" => $clientsbranch->name,
                                "branchid" => $clientsbranch->branchid,
                                "parentid" => $clientsbranch->parentid,
                                "title" => $clientsbranch->title,
                                "firmid" => $clientsbranch->firmid,
                                "departments" => $listdepartments,
                            ]);
                            unset($listdepartments);
                            $listdepartments = [];
                        }
                        array_push($listclients, [
                            "id" => $client->id,
                            "name" => $client->name,
                            "branchid" => $client->branchid,
                            "parentid" => $client->parentid,
                            "title" => $client->title,
                            "firmid" => $client->firmid,
                            "clientsbranchs" => $listclientsbranchs,
                        ]);
                        unset($listclientsbranchs);
                        $listclientsbranchs = [];
                    }
                }
					
                array_push($listfirms, [
                    "id" => $firm->id,
                    "name" => $firm->name,
                    "clients" => $listclients,
                ]);
                unset($listclients);
                $listclients = [];
            }
        }
*/
        $listfirms = $this->actionMobileclients($arrayClientsids);

        $this->result("", $listfirms);
    }
    ////////////\\\\\\\\\\\\

    public function actionNonconformitytypes()
    {
        $user = $this->autoauth();
        $listconformitytypes = [];
        $types = Conformitytype::model()->findAll([
            "condition" => "(firmid=0 or firmid=".$user->firmid.") and isactive=1",
        ]);
        foreach ($types as $type) {
            array_push($listconformitytypes, [
                "id" => $type->id,
                "name" => t($type->name),
            ]);
        }
        $this->result("", $listconformitytypes);
    }

    ////////////\\\\\\\\\\\\

    public function actionMeds()
    {
        $user = $this->autoauth();
        $listfirms = [];
        $meds = [];

        $medfirms = Stokkimyasalkullanim::model()->findAll([
            "condition" =>
                "isactive=1 and branchid=" .
                $user->branchid .
                " or firmid=" .
                $user->firmid,
        ]);
        if (!$medfirms) {
            $medfirms = Stokkimyasalkullanim::model()->findAll([
                "condition" => "isactive=1 and branchid=0 and firmid=0",
            ]);
        }
        foreach ($medfirms as $medfirm) {
            $unit = Units::model()->findByPk($medfirm->urunAmbajBirimi);
            array_push($meds, [
                "id" => $medfirm->id,
                "name" => $medfirm->aktifmaddetanimi,
                "unit" =>
                    $medfirm->urunAmbajBirimi == 0
                        ? t("Adet")
                        : ($medfirm->urunAmbajBirimi == 1
                            ? "gr"
                            : ($medfirm->urunAmbajBirimi == 2
                                ? "ml"
                                : ($medfirm->urunAmbajBirimi == 3
                                    ? "gr"
                                    : ($medfirm->urunAmbajBirimi == 4
                                        ? "ml"
                                        : "")))),
            ]);
            array_push($listfirms, [
                "id" => $medfirm->id,
                "name" => $medfirm->kimyasaladi,
                "meds" => $meds,
            ]);
            $meds = [];
        }
        $this->result("", $listfirms);
    }

	
    ////////////\\\\\\\\\\\\

    public function actionConformities()
    {
        $ax = User::model()->userobjecty("");
        $ax->branchid;

        $user = $this->autoauth();

        if ($user["type"] == 13) {
            $model = [];
        } else {

            $model = Yii::app()
                ->db->createCommand(
                    'SELECT conformity.*,workorder.date as workorderdate,workorder.finish_time as finishtime,workorder.start_time FROM conformity INNER JOIN workorder ON workorder.clientid=conformity.clientid where
			(conformity.statusid=4 or conformity.statusid=3) and workorder.status!=3 and workorder.branchid=' .
                        $user["branchid"] .
                        " group by conformity.id"
                )
                ->queryall();
        }
        $array = [];
        for ($i = 0; $i < count($model); $i++) {
            $workorderdate = time();
            if ($workorderdate >= $model[$i]["date"]) {
                if ($model[$i]["statusid"] == 3) {
                    $etkinliktarihix = Efficiencyevaluation::model()->find([
                        "condition" => "conformityid=" . $model[$i]["id"],
                    ]);
                    $date = strtotime($etkinliktarihix->controldate);
                    if ($date < time()) {
                        array_push($array, [
                            "id" => $model[$i]["id"],
                            "userid" => $model[$i]["userid"],
                            "firmid" => $model[$i]["firmid"],
                            "firmbranchid" => $model[$i]["firmbranchid"],
                            "branchid" => $model[$i]["branchid"],
                            "clientid" => $model[$i]["clientid"],
                            "clientname" => Client::model()->findbypk(
                                $model[$i]["clientid"]
                            )->name,
                            "departmentid" => $model[$i]["departmentid"],
                            "subdepartmentid" => $model[$i]["subdepartmentid"],
                            "departmentname" => Departments::model()->findByPk(
                                $model[$i]["departmentid"]
                            )->name,
                            "subdepartmentname" => Departments::model()->findByPk(
                                $model[$i]["subdepartmentid"]
                            )->name,
                            "type" => $model[$i]["type"],
                            "typename" => Conformitytype::model()->findByPk(
                                $model[$i]["type"]
                            )->name,
                            "status" => $model[$i]["statusid"],
                            "numberid" => $model[$i]["numberid"],
                            "definition" => $model[$i]["definition"],
                            "suggestion" => $model[$i]["suggestion"],
                            "priority" => $model[$i]["priority"],
                            //"date" => date("d-m-Y H:i", $model[$i]["date"]),
                            "date" => date("d-m-Y", $model[$i]["date"]),
                            "image" =>
                                "https://insectram.io" . $model[$i]["filesf"],
                        ]);
                    }
                } else {
                   array_push($array, [
                        "id" => $model[$i]["id"],
                        "userid" => $model[$i]["userid"],
                        "firmid" => $model[$i]["firmid"],
                        "firmbranchid" => $model[$i]["firmbranchid"],
                        "branchid" => $model[$i]["branchid"],
                        "clientid" => $model[$i]["clientid"],
                        "clientname" => Client::model()->findbypk(
                            $model[$i]["clientid"]
                        )->name,
                        "departmentid" => $model[$i]["departmentid"],
                        "subdepartmentid" => $model[$i]["subdepartmentid"],
                        "departmentname" => Departments::model()->findByPk(
                            $model[$i]["departmentid"]
                        )->name,
                        "subdepartmentname" => Departments::model()->findByPk(
                            $model[$i]["subdepartmentid"]
                        )->name,
                        "type" => $model[$i]["type"],
                        "typename" => Conformitytype::model()->findByPk(
                            $model[$i]["type"]
                        )->name,
                        "status" => $model[$i]["statusid"],
                        "numberid" => $model[$i]["numberid"],
                        "definition" => $model[$i]["definition"],
                        "suggestion" => $model[$i]["suggestion"],
                        "priority" => $model[$i]["priority"],
                       // "date" => date("d-m-Y H:i", $model[$i]["date"]),
                        "date" => date("d-m-Y", $model[$i]["date"]),
                        "image" =>
                            "https://insectram.io" . $model[$i]["filesf"],
                    ]);
                }
            }
        }
        $this->result("", $array);
    }
	
	
	
	   public function actionAddconformity()
    {

     $str=file_get_contents('php://input');
			 $rand1=rand(0,1000000);
			 $rand2=rand(1000000,2000000);
			 $rand3=rand(2000000,3000000);
			 $rand4=rand(3000000,4000000);
  	 $filenamex='apiv3-logs/'.time().'-'.$rand1.'-conformity.txt';
  //	 $filenamex='apiv3-logs/'.md5($str).'-conformity.txt';
			if (file_exists($filenamex)) {
				//echo 'duplicate data!';exit;
			}
      file_put_contents($filenamex, $str);

  		///
	
  				$user=$this->autoauth();
  				$str=file_get_contents('php://input');
  				$gelen=json_decode($str);
			 		 if (!isset($gelen->departmentid)){
				 $gelen->departmentid=0;
			 }
			 if (!isset($gelen->subdepartmentid)){
				 $gelen->subdepartmentid=0;
			 }
	        $varmi=Conformity::model()->find(array("condition"=>"
          definition like '".addslashes(nl2br($gelen->definition))."' and
        	suggestion like '".addslashes(nl2br($gelen->suggestion))."' and
        	type=".$gelen->type." and
        	branchid=".$gelen->branchid." and
        	clientid=".$gelen->clientid." and
        	departmentid=".$gelen->departmentid." and
        	subdepartmentid=".$gelen->subdepartmentid));
			 
	     
  				if($varmi){
  					$this->result('Zaten Eklendi.');exit;
  				}
  				else{
  					$targetPath=$rand3."a.txt"; /// json decode edilince içine base64 kodu gelecek
  					$content= base64_decode($gelen->picture);
  					$file = fopen($targetPath, 'w');
  					fwrite($file, $content);
  					fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz

  					$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
  					if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
  					{
  						mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
  						$imagename=time().'-'.$rand2.".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename($rand3.'a.txt', $path);
  					}
  					else{
  						$imagename=time().'-'.$rand2.".png";
  						$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
  						rename($rand3.'a.txt', $path);
  					}
						if(file_exists($rand3.'a.txt'))
  					{
							unlink($rand3.'a.txt');
						}
  					$model=new Conformity;
  					$firmsd=Firm::model()->findByPk($gelen->firmid);
  					$model->firmid=$firmsd->parentid;
  					//$model->firmid=$gelen->firmid;
  					$model->branchid=$gelen->firmid;
  					$model->firmbranchid=$gelen->firmid;
  					$model->clientid=$gelen->branchid;//$gelen->firmid;//$gelen->branchid;//$gelen->clientid;//$_REQUEST['clientid'];
						if (isset($gelen->departmentid)){
							$model->departmentid=$gelen->departmentid;
						}else{
							$model->departmentid=0;
						}
  					if(isset($gelen->subdepartmentid)){
								$model->subdepartmentid= $gelen->subdepartmentid;
						}else{
								$model->subdepartmentid= 0;
						}
  				
  					$model->type=$gelen->type;
  					$model->priority= $gelen->priority;
  					$model->date=time();
  					$model->definition= nl2br($gelen->definition);
  					$model->suggestion=nl2br($gelen->suggestion);
  					$model->filesf='/uploads/'.$firm->username.'/'.$imagename;
  					$model->statusid=0;
  					$model->isefficiencyevaluation=0;
  					$model->endofdayemail=0;
  					$model->userid=$user->id;
						if(isset($gelen->workOrderId)){
									$model->workorderid=$gelen->workOrderId;
						}
  			
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
							print_r($model->getErrors());
  					$this->result($model->getErrors());
  					}
  				}
    }

  
    ////////////\\\\\\\\\\\\
public function actionAddworkorders()
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
	$filenamex='apiv3-logs/'.time().'-cache.txt';
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

    file_put_contents('apiv3-logs/'.$user->id.' - '.time().'.txt', $str);
	unlink($filenamex);



    $gelen=json_decode($str);
   // $workorders=$gelen->Workorders;
    $workorders=$gelen;

    for($i=0;$i<count($workorders);$i++)
    { // WorkOrders

        $modelW=Workorder::model()->findByPk($workorders[$i]->id);

			
			  for($j=0;$j<count($workorders[$i]->workordermonitors);$j++)  // Monitorler Begin
        {	// WorkOrderMonitors

		
			if($workorders[$i]->workordermonitors[$j]->monitorStatus<>0)
			{
		if ($modelW->visittypeid==62 ){
							$modelMert=Mobileworkordermonitorsti::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
		}else{
							$modelMert=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
		}
				

				if ($modelMert)
				{
						if ($modelW->visittypeid==62 ){
					$modelVarmikayip=Mobileworkorderdatati::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
						}
					else{
					$modelVarmikayip=Mobileworkorderdata::model()->findAll(array('condition'=>'mobileworkordermonitorsid='.$modelMert->id.' and petid=49'));
						
					}
					if(!$modelVarmikayip)
					{
										if ($modelW->visittypeid==62 ){
						$DurumluData=new Mobileworkorderdatati;
										}
						else{
								$DurumluData=new Mobileworkorderdata;
						}
						$DurumluData->mobileworkordermonitorsid=$workorders[$i]->workordermonitors[$j]->id;
						$DurumluData->workorderid=$modelMert->workorderid;
						$DurumluData->monitorid=$modelMert->monitorid;
						$DurumluData->monitortype=$modelMert->monitortype;
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
							print_r($DurumluData->getErrors());
						}
						else{
						}
					}
				}

			}


								if ($modelW->visittypeid==62 ){
            $modelM=Mobileworkordermonitorsti::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
								}else{
            $modelM=Mobileworkordermonitors::model()->findByPk($workorders[$i]->workordermonitors[$j]->id);
									
								}
			if($modelM)
			{
		//"new_barcode_value": "null",
				if(isset($workorders[$i]->workordermonitors[$j]->new_barcode_value)){
            if($workorders[$i]->workordermonitors[$j]->new_barcode_value!="null") // Monitor Barcode Numarası Değiştir
            {
				$modelMonitoring=Monitoring::model()->findByPk($modelM->monitorid);
				$modelMonitoring->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
				$modelMonitoring->update();
                //$modelM->barcodeno=$workorders[$i]->workordermonitors[$j]->new_barcode_value;
            }
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
            for($k=0;$k<count($workorders[$i]->workordermonitors[$j]->monitorData);$k++)  // Workorder Dataları kaydetme
            { // WorkOrderMonitorData
								if ($modelW->visittypeid==62 ){
				$modelD=Mobileworkorderdatati::model()->findByPk($workorders[$i]->workordermonitors[$j]->monitorData[$k]->id);
								}else {
				$modelD=Mobileworkorderdata::model()->findByPk($workorders[$i]->workordermonitors[$j]->monitorData[$k]->id);
									
								}
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
				}
				/*else
				{ echo $workorders[$i]->workordermonitors[$j]->monitorData[$k]->id.'<br>'; }*/
            }



        } // Monitorler End
/*
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
      
	
			
      
	if( strlen($workorders[$i]->finish_time)>9)
	{
		
		$modelW->realendtime=substr($workorders[$i]->finish_time,0,10);
	}
      */
			
			
					
				if(strlen($workorders[$i]->realstarttime)>9 )
	{
			
						
							$yenibaslangic=substr($workorders[$i]->realstarttime,0,10);
							if($yenibaslangic < $modelW->realstarttime || $modelW->realstarttime=='0')
							{
							
								$modelW->realstarttime=$yenibaslangic;
							}
							else{

							}
			
	}
			
					/*
				if(strlen($workorders[$i]->realendtime)>9 )
	{
								
						
							$yenibaslangic=substr($workorders[$i]->realendtime,0,10);
							if($yenibaslangic > $modelW->realendtime || $modelW->realendtime=='0')
							{
								$modelW->realendtime=$yenibaslangic;
							}
							else{

							}
				
					
					
	}*/
	
			
			if ($modelW->visittypeid==62 ){
			$isbiticekmi=Mobileworkordermonitorsti::model()->findAll(array('condition'=>'workorderid='.$workorders[$i]->id.' and checkdate=0'));
			}else{
			$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorders[$i]->id.' and checkdate=0'));
				
			}
			$servisRaporVarMi = $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if(!$isbiticekmi && $servisRaporVarMi)
			{
				$modelW->status=3;
				$modelW->executiondate=time();
			}else
			if(!$isbiticekmi && !$servisRaporVarMi)
			{
				$modelW->status=5;
				$modelW->executiondate=time();
			}else{

			if ( ($modelW->visittypeid==62 ) && $servisRaporVarMi){
							$modelW->status=3;
				$modelW->executiondate=time();
			}else{
					$modelW->status=$workorders[$i]->status;
			}
			
			}
			$modelW->update();

	} //// Workorder for  end

    $this->result('','Senkronize başarılı..');


	}else{
		 $this->result('','Senkronize başarılı..');
	}

}
  
	
	
	
    ////////////\\\\\\\\\\\\
	  
public function actionAddservicereport()
{
	$sure_baslangici = microtime(true);
		 $rand1=rand(0,1000000);
			 $rand2=rand(1000000,2000000);
			 $rand3=rand(2000000,3000000);
			 $rand4=rand(3000000,4000000);
	if(!isset($_REQUEST['deviceid'])){
		$_REQUEST['deviceid']='0';
	}

	$str=file_get_contents('php://input');
	$str= str_replace("data:image/png;base64,","",$str);

	$varmiencrypt=Superlogs::model()->find(array('condition'=>'encrypted="'.md5($str).'" and userid!=0'));
	$sure1 = microtime(true);
	//if(!$varmiencrypt)
	//{
	$filenamex='apiv3-logs/'.time().'-cache.txt';
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

    file_put_contents('apiv3-logs/'.$user->id.' - '.time().'.txt', $str);
	unlink($filenamex);



    $gelen=json_decode($str);

    $workorders=$gelen;

        $modelW=Workorder::model()->findByPk($gelen->workOrderId);
		if($modelW)
		{
  

		// SERVICE REPORT BEGIN ////////////////////////////////////////////////////////////

		if($gelen)
		{
	//	if($gelen->signer_name <> "null" && $gelen->riskreview != "null")
		if($gelen->signer_name <> "null")
        {

			// Daha önce service raporu gelmiş mi diye kontrol ediyoruz :)
			$modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$gelen->workOrderId));
			if($modelServiceR)
			{

			}
			else{
				// Techinician sign
				$targetPath=$rand1."a.txt"; /// json decode edilince içine base64 kodu gelecek
				$content= base64_decode($gelen->technician_signature);
				$file = fopen($targetPath, 'w');
				fwrite($file, $content);
				fclose($file); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
				// Client sign
				$targetPath2=$rand2."b.txt"; /// json decode edilince içine base64 kodu gelecek
				$content2= base64_decode($gelen->client_signature);
				$file2 = fopen($targetPath2, 'w');
				fwrite($file2, $content2);
				fclose($file2); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
            // Servis raporu resmi
        if (isset($gelen->photo)){
				$targetPath3=$rand3."c.txt"; /// json decode edilince içine base64 kodu gelecek
				$content3= base64_decode($gelen->photo);
				$file3 = fopen($targetPath3, 'w');
				fwrite($file3, $content3);
				fclose($file3); // bitince işi fileın adını .png olarak değiştirip istediğimiz gibi kaydedebiliriz
          }
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
				if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
				{
					mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
					$imagename=time().$rand1.".png";
					$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
					rename($rand1.'a.txt', $path);

					$imagename2=time().$rand2."1".".png";
					$path2=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename2;
					rename($rand2.'b.txt', $path2);

            if (isset($gelen->photo)){
            $imagename3=time().$rand3."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename($rand3.'c.txt', $path3);
          }
				}
				else{
					$imagename=time().$rand1.".png";
					$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename;
					rename($rand1.'a.txt', $path);

					$imagename2=time().$rand2."1".".png";
					$path2=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename2;
					rename($rand2.'b.txt', $path2);

            if (isset($gelen->photo)){
            $imagename3=time().$rand3."2".".png";
            $path3=Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$imagename3;
            rename($rand3.'c.txt', $path3);
          }
				}

				$servicereports=$gelen->applied_insecticides;
				$modelS=new Servicereport;
				$modelS->client_name=$gelen->client_name;
				$modelS->date=time();
				$modelS->reportno=$gelen->workOrderId;
				$modelS->visittype=$gelen->visittype;
				$modelS->trade_name=$gelen->signer_name;
				$modelS->servicedetails=nl2br($gelen->servicedetails);
   			$modelS->pr_name_surname='';
							$modelS->signature_date='';
							$modelS->team_leader='';
							$modelS->pest_types='';
							$modelS->workplace_and_soon='';
							$modelS->number_of_flats='';
							$modelS->pr_area_ground='';
							$modelS->security_precautions='';
							$modelS->treatment_and_observations='';
							$modelS->housekeeping='';
							$modelS->proofing='';
							$modelS->visit_report_summary='';
        
        
                      if (isset($gelen->pr_name_surname)){
                       // echo $gelen->pr_name_surname;
				                $modelS->pr_name_surname=$gelen->pr_name_surname;
                        }
                      if (isset($gelen->signature_date)){
                       // echo $gelen->signature_date;
				                $modelS->signature_date=$gelen->signature_date;
                        }
        
        
                      if (isset($gelen->treatment_and_observations)){
                       // echo $gelen->treatment_and_observations;
				                $modelS->treatment_and_observations=nl2br($gelen->treatment_and_observations);
                        }
       
                      if (isset($gelen->housekeeping)){
                      //  echo $gelen->housekeeping;
				                $modelS->housekeeping=nl2br($gelen->housekeeping);
                        }
        
                      if (isset($gelen->proofing)){
                       // echo $gelen->proofing;
				                $modelS->proofing=nl2br($gelen->proofing);
                        }
                      if (isset($gelen->visit_report_summary)){
                        //echo $gelen->visit_report_summary;
				                $modelS->visit_report_summary=$gelen->visit_report_summary;
                        }
        
        
                      if (isset($gelen->team_leader)){
                       // echo $gelen->team_leader;
				                $modelS->team_leader=$gelen->team_leader;
                               
                       

                        }
        

                    
                      if (isset($gelen->pest_types)){
                      //  echo $gelen->pest_types;
				                $modelS->pest_types=$gelen->pest_types;
                        }
                      if (isset($gelen->workplace_and_soon)){
                       // echo $gelen->workplace_and_soon;
				                $modelS->workplace_and_soon=$gelen->workplace_and_soon;
                        }
                    
                      if (isset($gelen->number_of_flats)){
                       // echo $gelen->number_of_flats;
				                $modelS->number_of_flats=$gelen->number_of_flats;
                        }
                      if (isset($gelen->pr_area_ground)){
                      //  echo $gelen->pr_area_ground;
				                $modelS->pr_area_ground=$gelen->pr_area_ground;
                        }
                      if (isset($gelen->security_precautions)){
                      //  echo $gelen->security_precautions;
				                $modelS->security_precautions=$gelen->security_precautions;
                        }
        foreach ($servicereports as $servicereport){
                          $modelA=new Activeingredients;
                          $modelA->workorderid=$gelen->workOrderId;
                          $modelA->trade_name=$servicereport->tradeName;
                          $modelA->active_ingredient=$servicereport->activeIngredient;
                          $modelA->amount_applied=$servicereport->amountApplied;
                          if (isset($servicereport->ingredientId)){
                              $modelA->ingredientId=$servicereport->ingredientId;
                              $modelA->tradeId=$servicereport->tradeId;
                              $modelA->save();
                          }

         }
        
				$modelS->riskreview=$gelen->riskreview;
				$modelS->saver_id=$user->id;
				$modelS->technician_sign='/uploads/'.$firm->username.'/'.$imagename;
				$modelS->client_sign='/uploads/'.$firm->username.'/'.$imagename2;
				   if (isset($gelen->visit_report_summary)){
				
						 
						 $modelS->visit_report_summary=json_encode($gelen->visit_report_summary,true);
						 
					 }	  
				if (isset($gelen->ti_check_list)){
				
						 
						 $modelS->ti_checklist=json_encode($gelen->ti_check_list,true);
						 
					 }
				
				
				
				

        if (isset($gelen->photo)){
				  $modelS->picture='/uploads/'.$firm->username.'/'.$imagename3;
        }
				if ($modelS->save()){
					    $starttime='08:00';
            $endtime='09:00';
					     if (isset($gelen->follow_up_date) && $gelen->follow_up_date<>'') {
                         $duplicate=Workorder::model()->find('id=:ID',array(':ID'=>$gelen->workOrderId));
                    
          if(isset($gelen->follow_up_start_time) && $gelen->follow_up_start_time==''){
            $starttime='08:00';
            $endtime='09:00';
          }else{
						      $starttime='08:00';
            $endtime='09:00';
					}
          
          if(isset($gelen->follow_up_end_time) && $gelen->follow_up_end_time==''){
            $starttime='08:00';
            $endtime='09:00';
          }else{
						      $starttime='08:00';
            $endtime='09:00';
					}
          
					$modelwork=new Workorder;
					$modelwork->attributes=$duplicate->attributes;
					$modelwork->teamstaffid=0;
					$modelwork->staffid=$user->id;
					$modelwork->date=date('Y-m-d', substr($gelen->follow_up_date, 0,10));
					$modelwork->start_time=$starttime;
					$modelwork->finish_time=$endtime;
					$modelwork->realstarttime=0;
					$modelwork->realendtime=0;
					$modelwork->service_report='';
					$modelwork->cantscancomment='';
					$modelwork->executiondate=0;
					$modelwork->status=0;
					$modelwork->barcode='';
					$modelwork->todo='Follow Up';
					$modelwork->visittypeid=31;
					$modelwork->save();
                      
                       }
				}
				
				
				
				
				$servicereports=array();
			}
        }
		}
			
			
      $modelW=Workorder::model()->findByPk($gelen->workOrderId);

			$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$gelen->workOrderId.' and checkdate=0'));
			$servisRaporVarMi = $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$gelen->workOrderId));
			if(!$isbiticekmi && $servisRaporVarMi)
			{
				$modelW->status=3;
				$modelW->executiondate=time();
			}else
			if(!$isbiticekmi && !$servisRaporVarMi)
			{
				$modelW->status=5;
				$modelW->executiondate=time();
			}else{
				$modelW->status=$modelW->status;
			}
			
			if ( ($modelW->visittypeid==62 ) && $servisRaporVarMi){
							$modelW->status=3;
				$modelW->executiondate=time();
			}
			
			
			if ($gelen->realendtime){
						if(strlen($gelen->realendtime)>9 )
	{
								
						
							$yenibaslangic=substr($gelen->realendtime,0,10);
							$modelW->realendtime=$yenibaslangic;
				
	}else{
							
								 $modelW->realendtime=time();
}
			}else{
	 $modelW->realendtime=time();
			}
			
			
			$modelW->update();
		// SERVICE REPORT END ////////////////////////////////////////////////////////////
	

	/*if(strlen($workorders[$i]->start_time)>9 && strlen($workorders[$i]->finish_time)>9)
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
      
      
	if( strlen($workorders[$i]->finish_time)>9)
	{
		
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
*/
    } /// Workorder varmı if'i
/*
			$isbiticekmi=Mobileworkordermonitors::model()->findAll(array('condition'=>'workorderid='.$workorders[$i]->id.' and checkdate=0'));
			$servisRaporVarMi = $modelServiceR=Servicereport::model()->find(array('condition'=>'reportno='.$workorders[$i]->id));
			if(!$isbiticekmi && $servisRaporVarMi)
			{
				$modelW->status=3;
				$modelW->executiondate=time();
			}
			else{

				$modelW->status=$workorders[$i]->status;
			}
			$modelW->update();
*/

    $this->result('','Senkronize başarılı..');


	////}else{
	///	 $this->result('','Senkronize başarılı..');
	//}

}
	
	
	 public function actionCloseconformity(){
        $str=file_get_contents('php://input');
		 
	
	$filenamex='apiv3-logs/'.time().'-closeconf.txt';
    file_put_contents($filenamex, $str);

		
		
        $str=json_decode($str);
        $err=false;
		 if ($str->checkDate){
			 $str->checkDate=substr($str->checkDate, 0, 10);
			// 		echo $str->checkDate.'-';
		 }
		  if ($str->followUpDate){
			 $str->followUpDate=substr($str->followUpDate, 0, 10);
//echo $str->followUpDate.'-!';
		 }

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
                  $modelActivity->okdate=date('Y-m-d', $str->checkDate);
                }
                else if($str->status==6){
                  // not ok baba tamamlanmadı
                  //$model->statusid=6; // NOK - Completed
                  $modelActivity->nokdefinition=$str->comment;
                 // $modelActivity->nokdate=date('Y-m-d', $str->date);
                  $modelActivity->nokdate=date('Y-m-d', $str->checkDate);
                }
                else if($str->status==3)
                {
                  $modelActivity->okdate=date('Y-m-d', $str->checkDate);
								//	echo  'okdate'.$modelActivity->okdate.'!!--!!';
                }

                if($modelActivity->save())
                {
                  if($str->status==3)
                  {
                    $etkinlikTakibi=new Efficiencyevaluation;
                    $etkinlikTakibi->conformityid=$str->id;
                    $etkinlikTakibi->controldate=date('Y-m-d', $str->followUpDate);
                    $etkinlikTakibi->activitydefinition=$str->comment;
                    $etkinlikTakibi->save();
                  }
                    $model->closedtime= $str->checkDate;
                  if($model->save())
                  {
                      $this->result('','Eklendi');
                  }
                  else {
                    $err="modeli kaydetmedi";
                  }
                 // exit;
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
          $err="no id!";
        }


        if($err)
        {
          $this->result($err); exit;
        }else{
					      $this->result('','Eklendi'); exit;
				}
    }
  


    ////////////\\\\\\\\\\\\
	
	
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
    /**
     * This is the action to handle external exceptions.
     */
}
