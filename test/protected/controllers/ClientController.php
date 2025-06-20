<?php

class ClientController extends Controller
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
				'actions'=>array('subdepidgetir','depidgetir','workorderreports','tumunugetir','clientqr','showbarcodes','peststypes','index','view','branches','departments','files','monitoringpoints','offers'
                         ,'reports','branchstaff','subdepartments','reportcreate','chartreports','subdepartments2'
                         ,'staffsearch','detail','staff','pointno','peststype','livesearch','auth',
                         'departmentpermission','datetime','atananClient','monitorqryenileme','pdfactiviterapor'
                        ,'clientlist','clientdetail','clientcreateupdate','clientdelete','clientisactive'
                        
                        ,'index2','branch','clientbranchlist','cdetail'),
				'users'=>array('*'),
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




////////////yeni apilerr //////////
  
  public function actionIndex($id=0)
  {
    
      
     if($id==0)
     {
       $ax= User::model()->userobjecty('');
        $id=$ax->branchid;
     }
   if($id!=0)
   {
     $request['id']=$id;
       $response=NewFirmModel::model()->firmDetail($request);
       $this->render('index2',array(
        'firmbranchid'=>$id,
        'detay'=>$response['data'][0]
      ));
   }
		$this->render('index2');
  }
  
  public function actionBranch($id=0)
  {
      
     if($id==0)
     {
       $ax= User::model()->userobjecty('');
        $id=$ax->clientid;
     }
   if($id!=0)
   {
     $request['id']=$id;
       $response=NewClientModel::model()->clientDetail($request);
     $status=NewParamsModel::model()->conformitystatuslist(null);
 
       $this->render('index2',array(
        'clientid'=>$id,
        'detay'=>$response['data'][0],
         'status'=>$status
      ));
   }
    
    
		$this->render('index2');
  }
  
  public function actionClientlist($id=0)
  {
    
      $yetki=AuthAssignment::model()->accesstoken();
  
    if($yetki['status'])
    {
        
     if($id==0)
     {
       $ax= User::model()->userobjecty('');
        $id=$ax->branchid;
     }
      $response=NewClientModel::model()->clientList(0,intval($id));
     
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  public function actionClientbranchlist($id)
  {
    
      $yetki=AuthAssignment::model()->accesstoken();
  
    if($yetki['status'])
    {
        
      $response=NewClientModel::model()->clientList(intval($id));
     
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  public function actionCdetail($id) // firma ile sisteme giren kişinin firm id si ile firmbranch listesi çekilir
  {
    if($id==0)
     {
       $ax= User::model()->userobjecty('');
        $id=$ax->clientid;
     }
   if($id!=0)
   {
     $request['id']=$id;
     $status=NewParamsModel::model()->conformitystatuslist(null);
       $response=NewClientModel::model()->clientDetail($request);
       $this->render('index2',array(
        'clientid'=>$id,
         'clientdetay'=>true,
        'detay'=>$response['data'][0],
        'status'=>$status
      ));
   }
		$this->render('index2');
  }
  
  public function actionClientdetail() // firma ile sisteme giren kişinin firm id si ile firmbranch listesi çekilir
  {
     $yetki=AuthAssignment::model()->accesstoken();
      if($yetki['status'])
      {
        $response=NewClientModel::model()->clientDetail($_POST);
        echo json_encode($response);
        exit;
      }
      json_encode($yetki);
      exit;
  }
  
  public function actionClientcreateupdate() // firma ile sisteme giren kişinin firm id si ile firmbranch listesi çekilir
  {
     $yetki=AuthAssignment::model()->accesstoken();
      if($yetki['status'])
      {
        $response=NewClientModel::model()->clientCreateUpdate($_POST);
        echo json_encode($response);
        exit;
      }
      json_encode($yetki);
      exit;
  }
  
  public function actionClientdelete() // firma ile sisteme giren kişinin firm id si ile firmbranch listesi çekilir
  {
     $yetki=AuthAssignment::model()->accesstoken();
      if($yetki['status'])
      {
        $response=NewClientModel::model()->clientdelete($_POST);
        echo json_encode($response);
        exit;
      }
      json_encode($yetki);
      exit;
  }
  
  public function actionClientisactive() // firma ile sisteme giren kişinin firm id si ile firmbranch listesi çekilir
  {
     $yetki=AuthAssignment::model()->accesstoken();
      if($yetki['status'])
      {
        $response=NewClientModel::model()->clientisactive($_POST);
        echo json_encode($response);
        exit;
      }
      json_encode($yetki);
      exit;
  }
  
  
  
 /////////////////////////////////
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	 public function actionWorkorderreports() {
	 		$this->render("NDg/workorderreports");
	 }

	 public function actionDetail($id)
	{
		$this->render('/site/detail',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionDepidgetir(){
		if(isset($_GET["id"]))
		{
			echo json_encode(array("id"=>Departments::model()->find(array('condition'=>'clientid='.$_GET["clientid"].' and name="'.$_GET["id"].'"'))->id));
		}

	}

	public function actionAtananClient()
	{
		$ax= User::model()->userobjecty('');
		$userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$_GET['id']));
		$label='';
		$i=0;
		$acikuy='';
		$kapaliuy='';
		$toplam='';
		foreach($userss as $userssx)
		{
			$aciksay=0;
			$kapalisay=0;
			$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1","order"=>"id desc","group"=>"conformityid"));
			foreach($conformityuserassign as $conformityuserassignx)
			{
				$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
				$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
				if(!$gerigonderme && !$deadlineverme)
				{
					$aciksay++;
				}

				if(!$gerigonderme && $deadlineverme)
				{
					$kapalisay++;
				}
			}


			if($i==0)
			{
				if($userssx->name=='' && $userssx->surname=='')
				{
					$label='"'.$userssx->username.'"';
				}
				else{
					$label='"'.$userssx->name.' '.$userssx->surname.'"';
				}

				$acikuy=$aciksay;
				$kapaliuy=$kapalisay;
				$toplam=$aciksay+$kapalisay;
			}
			else
			{
				if($userssx->name=='' && $userssx->surname=='')
				{
						$label=$label.',"'.$userssx->username.'"';
				}
				else{
						$label=$label.',"'.$userssx->name.' '.$userssx->surname.'"';
				}

				$acikuy=$acikuy.','.$aciksay;
				$kapaliuy=$kapaliuy.','.$kapalisay;
				$top=$aciksay+$kapalisay;
				$toplam=$toplam.','.$top;
			}
			$i++;
		}

		$value = array(
    "label"=>$label,
    "acikuy"=>$acikuy,
		"kapaliuy"=>$kapaliuy,
		"toplam"=>$toplam
	);
		$str_json_format = json_encode($value);
		print $str_json_format;
	}


	public function actionSubdepidgetir(){
		if(isset($_GET["id"]))
		{
			echo json_encode(array("id"=>Departments::model()->find(array('condition'=>'clientid='.$_GET["clientid"].'  and parentid='.$_GET["departmentid"].' and name="'.$_GET["id"].'"'))->id));
		}

	}

	public function actionPdfactiviterapor()
	{
    $tarihAraligi=$_POST['tarihAraligi'];
    $depName=$_POST['depName'];
    $client=Client::model()->findByPk($_POST['Reports']['clientid']);
    
		Yii::import('application.modules.pdf.components.pdf.mpdf');

		 $url = Yii::app()->basepath."/views/client/NDg/PdfTemplate/";
			include($url . "pdf_aktivite_rapor.php");

			$mpdf =  new \Mpdf\Mpdf();
    $mpdf->SetTitle($client->name.' '.$depName." - ".$tarihAraligi.' Trend Analizi');
			$mpdf->AddPage('L');
						$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

						$mpdf->Output($client->name.' '.$depName." - ".$tarihAraligi.' Trend Analizi', 'I');
    
    

	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionBranches($id)
	{
		$this->render('NDg/branches',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionDatetime()
	{
		if(isset($_GET['time']) && $_GET['time']!='')
		{
			 $date = date('Y-m-d', strtotime('+2 month', strtotime($_GET['time'])));
			if(strtotime($date)>time())
			{
				echo json_encode(date('Y-m-d'));
			}
			else
			{
				echo json_encode($date);
			}
		}
		else
		{
			echo json_encode(date('Y-m-d'));


		}
	}

	public function actionClientqr()
		{
		$model=Client::model()->findByPk($_GET["id"]);
		$modelP=Client::model()->findByPk($model->parentid);
		file_get_contents('https://'.$_SERVER['HTTP_HOST'] ."/qrcode/qrcode?txt=".$_GET["id"]."&size=12");
		$redirectedUrl = 'https://insectram.io/uploads/barcode/temp/'.md5($_GET["id"]).'.png';
		//Yii::import('application.modules.pdf.components.pdf.mpdf');
        $mpdf = new \Mpdf\Mpdf();
    $mpdf->showImageErrors = true;
		$yaz='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
		$yaz .=
			"<style>.centered{
			padding-left:25%;
			padding-top:45%;
			text-align:center;
			width:50%;
			top:25%;
			position: sticky;justify-content: center;
			}</style>";
		$yaz .= "<div class='centered'><center>".$modelP->name."</center><br>";
		$yaz .= "<center>".$model->name."</center>";
		//$yaz .= "<center><img src='".$redirectedUrl."'></center>";
		$yaz .= '<center><img src="'.$redirectedUrl.'"></center>';
	$yaz .= '</div></body></html>';

		$mpdf->WriteHTML($yaz);
		$mpdf->Output();
		exit;
	}
		public function actionDepartments($id)
	{
		$this->render('NDg/departments',array(
			'model'=>$this->loadModel($id),
		));
	}

		public function actionFiles($id)
	{
		$this->render('NDg/files',array(
			'model'=>$this->loadModel($id),
		));
	}

		public function actionMonitoringpoints($id)
	{
			if (isset($_POST['monitoringid']))
		{
			$guncelle=Monitoring::model()->changeactive($_POST['monitoringid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}

		}



		$this->render('NDg/monitoringpoints',array(
			'model'=>$this->loadModel($id),
		));
	}

		public function actionOffers($id)
	{
		$this->render('NDg/branches',array(
			'model'=>$this->loadModel($id),
		));
	}

		public function actionReporst($id)
	{
		$this->render('NDg/branches',array(
			'model'=>$this->loadModel($id),
		));
	}

		public function actionBranchstaff($id)
	{
		$this->render('NDg/branchstaff',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionStaff($id)
	{
		$this->render('NDg/staff',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionReports($id)
	{
		$this->render('NDg/reports',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionChartreports($id)
	{
		$this->render('NDg/chartreports',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionAuth()
	{
			if (isset($_POST['firmid']))
			{

				echo $_POST['firmid'];
				if ($_POST['active']==1)
				{
					$auth= new AuthAssignment;
					$data=explode('|',$_POST['firmid']);
					$auth->itemname=$data[0];
					$auth->userid=$data[1];
					if(!$auth->save()){
						echo t("Error");
					}
					else
					{
						echo t("Successful");
					}

				}else	if ($_POST['active']==0)
				{
					$data=explode('|',$_POST['firmid']);
					$auth=AuthAssignment::model()->find('itemname="'.$data[0].'" and userid='.$data[1]);
					if ($auth)
					{
						$auth->delete();
						$user=User::model()->findbypk($auth->userid);
						$user->clientbranchid=$user->mainclientbranchid;
						$user->update();

						echo t("Successful");
					}
				}
			}



				if (isset($_POST['clientid']))
				{
					$guncelle=Client::model()->departmentpermission($_POST['clientid'],$_POST['department'],$_POST['subdepartment'],$_POST['active'],$_POST['userid']);
					if(!$guncelle){
						echo "hata";
					}
					else{
						echo "kaydedildi";
						exit;
					}

				}


			$this->render("NDg/auth");
	}

	public function actionPointno()
	{

		if(isset($_GET['department']) && $_GET['department']==0 && isset($_GET['subdepartment']) && $_GET['subdepartment']==0)
		{
				if(isset($_GET["type"]) && $_GET["type"]==0)
			{
				$monitoring=Monitoring::model()->findAll(array('condition'=>'active=1 and clientid='.$_GET["clientid"]));

				}else {
					$monitoring=Monitoring::model()->findAll(array('condition'=>'mtypeid='.$_GET["type"].' and clientid='.$_GET["clientid"]));

				}
		}
		else
		{
			if(isset($_GET['department']) && $_GET['department']!=0 && isset($_GET['subdepartment']) && $_GET['subdepartment']!=0)
			{


				if(isset($_GET["type"]) && $_GET["type"]==0)
				{
					$monitoring=Monitoring::model()->findAll(array(
					 'condition'=>'active=1 and dapartmentid in ('.$_GET['department'].') and subid in ('.$_GET['subdepartment'].')'
					));
					}else {
						$monitoring=Monitoring::model()->findAll(array(
						 'condition'=>'active=1 and dapartmentid in ('.$_GET['department'].') and mtypeid=:mtypeid and subid in ('.$_GET['subdepartment'].')','params'=>array('mtypeid'=>$_GET['type'])
						));
					}
			}
			else{


				if(isset($_GET["type"]) && $_GET["type"]==0)
				{
					$monitoring=Monitoring::model()->findAll(array(
					 'condition'=>'active=1 and dapartmentid in ('.$_GET['department'].')'
					));
					}else {
						$monitoring=Monitoring::model()->findAll(array(
						 'condition'=>'active=1 and dapartmentid in ('.$_GET['department'].') and mtypeid=:mtypeid','params'=>array('mtypeid'=>$_GET['type'])
						));
					}
			}


		}


		if(count($monitoring)==0)
		{?>
			<option value="null"><?=t('Null');?></option>
		<?php }
		else
		{

			foreach($monitoring as $monitoringx)
				{
					$type=Monitoringtype::model()->findByPk($monitoringx->mtypeid);
					?>
					<option value="<?=$monitoringx->id;?>"><?=$type->name." - ".$monitoringx->mno;?></option>
				<?php }
		}?>

	<?php }


	public function actionPeststypes()
	{

		$monitortype=$_GET["type"];
		if(isset($_GET["reptype"]) && ($_GET["reptype"]==2 || $_GET["reptype"]==5 || $_GET["reptype"]==8))
		{
		    $pests=Monitoringtypepets::model()->findAll(array('condition'=>'!(petsid in (34,35,36,39,48,49)) and monitoringtypeid='. $monitortype));
		}
		else
		{
		    $pests=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='. $monitortype));

		}



		if(isset($_GET["reptype"]) && $_GET["reptype"]==7)
		{
			foreach($pests as $pest)
			{
				$pet=Pets::model()->findByPk($pest->petsid);
				if($pet->isproduct==1)
				{
				?>
				<option value="<?=$pest->petsid;?>"><?=t($pet->name);?></option>
			<?php } } ?> <option value="49"><?=t("Monitor Status");?></option>  <?php
		}
		else
		{
		if(count($pests)==0)
		{?>
			<option value="null"><?=t('Null');?></option>
		<?php }
		else



		{
			foreach($pests as $pest)
				{
						$pet=Pets::model()->findByPk($pest->petsid);
				?>
				<option value="<?=$pest->petsid;?>"><?=t($pet->name);?></option>
				<?php }
		} }?>

	<?php
	}


	public function actionMonitorqryenileme()
	{
		$ids=array();
		$monitorolurturma=2;
		$monitorno=array();

		array_push($ids,$_GET['barkode']);
		array_push($monitorno,$_GET['mno']);
		include("./barcode/monitorBarcodeList.php");

	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id=0)
	{
		//$_POST['Client']['branchid']=1;

		$authuser='';
		$ax= User::model()->userobjecty('');


		$firmname=Client::model()->userfirmname($_POST['Client']['bfirmid']);

		$authuser=Firm::model()->usernameproduce($_POST['Client']['name']);




		Yii::app()->getModule('authsystem');

		$model=new Client;


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$client=Client::model()->findAll(array(
								   'condition'=>'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0','params'=>array('name'=>$_POST['Client']['name'],'title'=>$_POST['Client']['title'],'taxoffice'=>$_POST['Client']['taxoffice'],'taxno'=>$_POST['Client']['taxno'],'address'=>$_POST['Client']['address'],'landphone'=>$_POST['Client']['landphone'],'email'=>$_POST['Client']['email'])
							   ));



		if(isset($_POST['Client']) && count($client)==0)
		{


			$count=count(Client::model()->findAll(array('condition'=>"username Like '%".$username."%'")));
			$username=$authuser.($count+1);


			$model->attributes=$_POST['Client'];
			$model->parentid=$id;
			$model->mainclientid=$id;
			$model->createdtime=time();




			if($_POST['Client']['bfirmid']>0)
			{
				$model->firmid=$_POST['Client']['bfirmid'];
			}
			else
			{


				if($ax->branchid==0)
				{
					$model->firmid=Client::model()->find(array('condition'=>'id='.$id))->firmid;
				}
				else
				{
					$model->firmid=$ax->branchid;
				}
			}




			$model->mainfirmid=$model->firmid;
			$model->username=$username;
			$model->save();

			if($id==0)
			{
				$pname=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->itemdelete('firmbranch',$model->firmid)."'"))->name;
			}
			else
			{
				$pname=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->itemdelete('client',$id)."'"))->name;
			}

			AuthItem::model()->createitem($pname.'.'.$username,0);
			AuthItem::model()->generateparentpermission($pname.'.'.$username);

			if($id==0)
			{
				AuthItem::model()->createnewauth($pname,$username,'Customer');
			}
			else
			{
				AuthItem::model()->createnewauth($pname,$username,'Branch');
			}


			//post edilen yer clientse onun subeside otomatik kendi verilerinin aynısıyla ekleniyor.
			if($id==0)
			{
				$model2=new Client;
				$model2->attributes=$_POST['Client'];
				$model2->name=$_POST['Client']['name'].' - Branch';
				$model2->parentid=$model->id;
				if($_POST['Client']['bfirmid']>0)
				{
					$model2->firmid=$model->firmid;
				}
				else
				{
					$model2->firmid=$model->firmid;
				}

				$count=count(Client::model()->findAll(array('condition'=>"username Like '%".$username."%'")));
				$username2=$authuser.($count+1);
				$model2->username=$username2;
				$model2->mainfirmid=$model->firmid;
				$model2->mainclientid=$model->id;
				$model2->createdtime=time();

				$model2->save();

				AuthItem::model()->createitem($pname.'.'.$username.'.'.$username2,0);
				AuthItem::model()->generateparentpermission($pname.'.'.$username.'.'.$username2);
				AuthItem::model()->createnewauth($pname.'.'.$username,$username2,'Branch');



					//loglama
					Logs::model()->logsaction();
					/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
					if($_POST['Client']['bfirmid']>0)
					{
						Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
					}
					else
					{
						Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
					}
			}


			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

			Yii::app()->SetFlashes->add($model,t('Create Success!'),array('view?id='.$id));
		}


		//eger mevcut verinin aynısı post edilirse mevcut data mesajı verilir
		Yii::app()->user->setFlash('error', t($error.' previously used'));
		if($id==0)
		{
				if($_POST['Client']['bfirmid']>0)
					{
						$this->redirect(array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
					}
					else
					{
						$this->redirect(array('index'));
					}
		}
		else
		{
			$this->redirect(array('view?id='.$id));
		}
	}

	public function actionTumunugetir(){
			$model=Monitoring::model()->findAll(array('condition'=>'active=1 and clientid='.$_GET["id"],'order'=>'mtypeid asc'));
			$yaz='';
			$bfr=0;
			foreach($model as $modelx)
			{
				$type=Monitoringtype::model()->findByPk($modelx->mtypeid);

				$yaz = $yaz.'<option value="'.$modelx->id.'">'.$modelx->mno.' - '.$type->name.'</option>';




			}
			echo $yaz;
	}

		public function actionShowbarcodes()
	{
		$sql="";
		if(isset($_POST["Monitoring"]["clientid"]))
		{

			if($_POST["Monitoring"]["dapartmentid"]!="")
			{
				$sql= $sql." and dapartmentid=".$_POST["Monitoring"]["dapartmentid"];
			}
			if($_POST["Monitoring"]["subid"]!="" && $_POST["Monitoring"]["subid"]!=0)
			{
				$sql= $sql." and subid=".$_POST["Monitoring"]["subid"];

			}
			if($_POST["Monitoring"]["mlocationid"]!="")
			{
				$sql= $sql." and mlocationid=".$_POST["Monitoring"]["mlocationid"];

			}
			if($_POST["Monitoring"]["mtypeid"]!="")
			{
				$sql= $sql." and mtypeid=".$_POST["Monitoring"]["mtypeid"];

			}

			if($_POST["Monitoring"]["mno"]!="")
			{
				$aradeger=explode('-',$_POST["Monitoring"]["mno"]);
				if(count($aradeger)==2)
				{
					if($aradeger[0]<$aradeger[1])
					{
							$sql= $sql." and mno>=".$aradeger[0]." and mno<=".$aradeger[1];
					}
					else if($aradeger[0]>$aradeger[1])
					{
						$sql= $sql." and mno>=".$aradeger[1]." and mno<=".$aradeger[0];
					}else {
						$sql= $sql." and mno".$aradeger[0];
					}

				}
				else {
					$sql= $sql." and mno in (".$_POST["Monitoring"]["mno"].')';
				}




			}
			$sql= $sql." and active=".$_POST["Monitoring"]["active"];

			// echo $sql;
			$monitors=Monitoring::model()->findAll(array('condition'=>'clientid='.$_POST["Monitoring"]["clientid"].$sql,'order'=>'mno asc'));
			$ids=array();
			$monitorno=array();
			$monitorolurturma=0;
			foreach ($monitors as $monitor)
			{
				if($monitor->barcodeno=='' || $monitor->barcodeno==0)
				{
					$model=Monitoring::model()->findByPk($monitor->id);
					$dynamicstring=time()+rand(0,999999)+round(microtime(true) * 1000);
					$model->barcodeno=Monitoring::model()->barkodeControl($dynamicstring);
					$model->save();
					$monitor->barcodeno=$model->barcodeno;
				}
				array_push($ids,$monitor->barcodeno);
				array_push($monitorno,$monitor->mno);
			}

			include("./barcode/monitorBarcodeList.php");

		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{



			if($id==0)
		{
			 $id=$_POST['Client']['id'];

		}
		$model=$this->loadModel($id);


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->save())
			{
				//loglama
				Logs::model()->logsaction();

				if($_POST['Client']['parentid']==0)
				{
					if($_POST['Client']['bfirmid']>0)
					{
						Yii::app()->SetFlashes->add($model,t('Update Success!'),array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
					}

				/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));
				}
				else
				{

				/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('Update Success!'),array('view','id'=>$_POST['Client']['parentid']));

				}
			}
		}


		/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
		Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index','id'=>$model->id));
		$this->render('index',array(
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

			if($id==0)
		{
			$id=$_POST['Client']['id'];

		}


		$post=Client::model()->findByPk($id);
								  $post->isdelete='1';
								  $post->update();

		$client=Client::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   #'order'=>'name ASC',
									'condition'=>'parentid='.$id,
							   ));

							foreach($client as $clients)
							{
								  $post=Client::model()->findByPk($clients->id);
								  $post->isdelete='1';
								  $post->update();
							}

		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

			if($_POST['Client']['parentid']==0)
			{

				User::model()->deleteAll(array('condition'=>'clientid=:id','params'=>array('id'=>$id)));

				AuthItem::model()->deleteAll(array('condition'=>"name Like '%".User::model()->itemdelete('client',$id)."%'"));

				//loglama
				Logs::model()->logsaction();

					if($_POST['Client']['bfirmid']>0)
					{
						Yii::app()->SetFlashes->add($model,t('Delete Success!'),array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
					}

				Yii::app()->SetFlashes->add($post,t('Delete Success!'),array('index'));
			}
			else
			{

				User::model()->deleteAll(array('condition'=>'clientbranchid=:id','params'=>array('id'=>$id)));

				AuthItem::model()->deleteAll(array('condition'=>"name Like '%".User::model()->itemdelete('clientbranch',$id)."%'"));
				//loglama
				Logs::model()->logsaction();
				Yii::app()->SetFlashes->add($post,t('Delete Success!'),array('view','id'=>$_POST['Client']['parentid']));
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex2()
	{
		if (isset($_POST['clientid']))
		{
			$guncelle=Client::model()->changeactive($_POST['clientid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}

		}
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

public function actionReportcreate()
	{
		  $url = Yii::app()->basepath."/views/client/NDg/PdfTemplate/";
		   $html = "test";
        if($_POST['Report']['type']==2)
        {

            $this->render("NDg/chartreports");

           // $this->redirect('/client/chartreports/2');
        }
        else if($_POST['Report']['type']==1)
        {

            Yii::import('application.modules.pdf.components.pdf.mpdf');
            $html = "test";
            
			      $mpdf = new \Mpdf\Mpdf();
            $url = Yii::app()->basepath."/views/client/NDg/PdfTemplate/";
			set_time_limit(2000);


ini_set("pcre.backtrack_limit", "1000000");

            if ($_POST['Monitoring']['mtypeid'] == 6) {
                include($url . "pdf-cl.php");
                //$mpdf->SetHTMLHeader('');
                $mpdf->WriteHTML($html);
            } else if ($_POST['Monitoring']['mtypeid'] == 8) {
                include($url . "pdf-lt.php");
                $mpdf->WriteHTML($html);
            } else if ($_POST['Monitoring']['mtypeid'] == 9) {
                include($url . "pdf-mt.php");
                $mpdf->WriteHTML($html);
            } else if ($_POST['Monitoring']['mtypeid'] == 10) {
                include($url . "pdf-rm.php");
                $mpdf->WriteHTML($html);
            } else if ($_POST['Monitoring']['mtypeid'] == 12) {
                include($url . "pdf-efk.php");
                $mpdf->WriteHTML($html);
            }

            //$mpdf->setHTMLHeader("das", '', true);

            // Output a PDF file directly to the browser

            //$mpdf->Output("aaa.pdf", "D");
            $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

            $mpdf->Output();
            exit;
        }
        else if($_POST['Report']['type']==3)
        {
            $this->render("NDg/totalnumberofpests");
        }
        else if($_POST['Report']['type']==4)
        {
            $this->render("NDg/excelreport");
        }
		else if($_POST['Report']['type']==5)
		{
			$this->render("NDg/singlemonitor");
		}
		else if($_POST['Report']['type']==6)
		{
			 Yii::import('application.modules.pdf.components.pdf.mpdf');
			 include($url . "pdf-products.php");
			 $mpdf = new mpdf();
             $mpdf->WriteHTML($html);
			 $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

             $mpdf->Output();
             exit;
		}
		else if($_POST['Report']['type']==7)
		{
			 Yii::import('application.modules.pdf.components.pdf.mpdf');
			 include($url . "pdf-in-activity.php");
			 $mpdf = new mpdf();
             $mpdf->WriteHTML($html);
			 $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

             $mpdf->Output();
             exit;
		}
    else if($_POST['Report']['type']==13)
		{
		/*	 Yii::import('application.modules.pdf.components.pdf.mpdf');
			 include($url . "pdf-service-reports.php");
			 $mpdf = new mpdf();
             $mpdf->WriteHTML($html);
			 $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

             $mpdf->Output();
             exit;
      */
      	$this->render("NDg/PdfTemplate/pdf-service-reports");
		}
		else if($_POST['Report']['type']==8)
		{
			$this->render("NDg/departmentreports");
		}
		else if($_POST['Report']['type']==9)
		{
			Yii::import('application.modules.pdf.components.pdf.mpdf');
			include($url . "workorderReport.php");
			$mpdf = new mpdf();
						$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

						$mpdf->Output();
						exit;


		}
    	else if($_POST['Report']['type']==21)
		{
			  include(Yii::app()->basepath."/views/client/NDg/exel/workorderReportexcel.php");

        exit;


		}
    else if($_POST['Report']['type']==99)
		{

      $tarih1=$_POST['Monitoring']['date'];
$tarih2=$_POST['Monitoring']['date1'];
$midnight = strtotime("today", strtotime($tarih1));
$midnight2 = strtotime("today", strtotime($tarih2)+3600*24);
 $idler=implode(',',$_POST['Report']['clientid']);
$forms=Workorder::model()->findAll(array('condition'=>'clientid in ('.$idler.') and (realendtime between '.$midnight.' and '.$midnight2.')'));
      $idler=[];
      if (is_countable($forms) && count($forms)>0){
        
      }else{
          $clients=Client::model()->findAll(array('condition'=>'parentid = '.$_POST['Report']['client']));
        $idler=[];
        foreach($clients as $item){
          $idler[]=$item->id;
        }
        if (is_countable($idler) && count($idler)>0){
        }else{
          echo 'client bulunamadı!';exit;
        }
        $idler=implode(',',$idler);
        $forms=Workorder::model()->findAll(array('condition'=>'clientid in ('.$idler.') and (realendtime between '.$midnight.' and '.$midnight2.')'));
      }
      $idler=[];
      foreach ($forms as $item){
        $idler[$item->id]= array($item->id,$item->date.'-'.$item->id);
        $idler['ids'][]= $item->id;
      }

      $workidler=$idler['ids'];
        if (is_countable($workidler) && count($workidler)>0){
          
        }else{
          echo 'Seçilen tarih aralığında workorder bulunamadı!';exit;
        }
      
      $workidler=implode(',',$workidler);
$forms=Servicereport::model()->findAll(array('condition'=>'reportno in ('.$workidler.') and LENGTH (picture)>5'));
      $files=[];
     foreach($forms as $item){
       $files[]=[$item->picture,$idler[$item->reportno][1]];
     }

    if (is_countable($files) && count($files)>0){
        }else{
          echo 'Servis formu resmi bulunamadı!';exit;
        }
      
      $zip = new ZipArchive;
      $tmp_file =  'testxxx.zip';
      if (file_exists($tmp_file)) unlink($tmp_file);
    if ($zip->open($tmp_file,  ZipArchive::CREATE)) {
      $i=0;
        foreach ($files as $file) {
          $i++;
          $zip->addFile('/home/ioinsectram/public_html'.$file[0],$file[1].'.png');
        } 
        $zip->close();
      $file2name=$_POST['Monitoring']['date'].' - '.$_POST['Monitoring']['date1'];
        header("Content-disposition: attachment; filename=$file2name.zip");
        header('Content-type: application/zip');
        readfile($tmp_file);
   } else {
       echo 'Arşiv oluştururken hata!';
      exit;
   }
      
      
   header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile('/home/ioinsectram/public_html/'.$zipname);   
			exit;


		}
    else if($_POST['Report']['type']==20)
    {
       include(Yii::app()->basepath."/views/firm/NDg/excel/faturaExcel.php");
                exit;
    }
		else if($_POST['Report']['type']==10)
		{
			if ($_POST['Monitoring']['mtypeid'] == 6) {
				  include(Yii::app()->basepath."/views/client/NDg/exel/clexel.php");
                exit;
            } else if ($_POST['Monitoring']['mtypeid'] == 8) {
                  include(Yii::app()->basepath."/views/client/NDg/exel/ltexel.php");
                exit;
            } else if ($_POST['Monitoring']['mtypeid'] == 9) {
				 //$this->render("NDg/exel/mtexel");
				  include(Yii::app()->basepath."/views/client/NDg/exel/mtexel.php");

                exit;
            } else if ($_POST['Monitoring']['mtypeid'] == 10) {
				  include(Yii::app()->basepath."/views/client/NDg/exel/rmexel.php");

                exit;
            } else if ($_POST['Monitoring']['mtypeid'] == 12) {
                include(Yii::app()->basepath."/views/client/NDg/exel/efkexel.php");

                exit;
            }
		}
		else if($_POST['Report']['type']==11)
		{
			$this->render("NDg/aktivitereportsgrafik");
		}
	}



	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Client('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Client the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function actionSubdepartments()
	{
				  $departments2=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'parentid ASC',
								   'condition'=>'parentid in ('.$_GET['id'].')',
							   ));

				$ax= User::model()->userobjecty('');
				if($ax->mainclientbranchid!=$ax->clientbranchid)
				{
					$departments2=Yii::app()->db->createCommand(
							'SELECT * FROM departments INNER JOIN departmentpermission ON departmentpermission.clientid=departments.clientid WHERE departmentpermission.departmentid=departments.parentid and departmentpermission.subdepartmentid=departments.id and departments.parentid='.$_GET['id'].' and departmentpermission.userid='.$ax->id)->queryAll();

				}
                  ?>

							<option value="0"><?=t('Select');?></option>
                            <?php foreach($departments2 as $department):
															$departmentname=Departments::model()->find(array(
										 								   'order'=>'parentid ASC',
										 								   'condition'=>'id='.$department->parentid,
										 							   ))->name;
															?>
                            <option value="<?=$department['id'];?>"><?=$department['name'].' - '.$departmentname;?></option>
							<?endforeach;?>


					<?php
	exit;
	}

	public function actionSubdepartments2()
	{
				  $departments2=Departments::model()->findAll(array(
								   #'select'=>'',
								   #'limit'=>'5',
								   'order'=>'name ASC',
								   'condition'=>'parentid='.$_GET['id'],
							   ));
                  ?>



						<label for="basicSelect"><?=t('Sub-Department');?></label>
                       <fieldset class="form-group">
                          <select class="custom-select block" id="customSelect" name="Monitoring[subid]">
						  <option value="0"><?=t('Select');?></option>
                            <?php foreach($departments2 as $department):?>
                            <option value="<?=$department->id;?>" <?php if(isset($_GET['sub']) && $_GET['sub']==$department->id){echo 'selected';}?>><?=$department->name;?></option>
							<?endforeach;?>
                          </select>
                        </fieldset>

					<?php
	exit;
	}

public function actionStaffsearch()
	{
					$user = Yii::app()->db->createCommand()
						->from('staffteamlist l')
						->join('user u', 'u.id=l.userid')
						->join('userinfo i', 'i.id=u.id')
						->where("l.branchid='".$_GET['id']."' and CONCAT_WS(' ',u.name,u.surname ) LIKE '%".$_GET['ara']."%'")
						->queryall();


					for($i=0;$i<count($user);$i++)
					{?>

                    <div class="col-xl-3 col-md-6 col-12">
						<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">
						  <div class="text-center">

						   <?php if($user[$i]['active']==1){?>
						  <a class="btn btn-success btn-sm" style='float:right;color:#fff'><?=t('Active');?> </a>
						 <?php }else{?> <a class="btn btn-danger btn-sm" style='float:right;color:#fff'><?=t('Passive');?> </a><?php }?>


							<div class="card-body">
							  <img src="<?php if($user[$i]['gender']==0){?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mr.png';?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" class="rounded-circle  height-150" alt="Card image">
							</div>
							<div class="card-body">
							  <h4 class="card-title"><?=$user[$i]['name'].' '.$user[$i]['surname'];?></h4>
							  <h6 class="card-subtitle text-muted"><?=$user[$i]['primaryphone'];?></h6>
							</div>
							<div class="text-center" style="margin-bottom:10px">
							 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
							 data-id="<?=$user[$i]['userid'];?>"
							 data-username="<?=$user[$i]['username'];?>"
							 data-name="<?=$user[$i]['name'];?>"
							 data-surname="<?=$user[$i]['surname'];?>"
							 data-email="<?=$user[$i]['email'];?>"
							 data-password="<?=$user[$i]['password'];?>"
							 data-birthplace="<?=$user[$i]['birthplace'];?>"
							 data-birthdate="<?=$user[$i]['birthdate'];?>"
							 data-gender="<?=$user[$i]['gender'];?>"
							 data-phone="<?=$user[$i]['primaryphone'];?>"
							 data-userid="<?=$user[$i]['userid'];?>"
								  ><i style="color:#fff;" class="fa fa-edit"></i></a>

							<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)"
							data-id="<?=$user[$i]['id'];?>"
							data-userid="<?=$user[$i]['userid'];?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
							</div>
						  </div>
						</div>
					  </div>
				<?php }

	}


	public function actionLivesearch()
	{?>

			<div id='show' class="dropdown-menu dropdown-menu-media  vertical-scroll scroll-example height-300" >
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Arama Sonuçları</span>


                    <span class="notification-tag badge badge-default badge-danger float-right m-0" id="deger1" style="display:none;">0 yeni</span>
                  </h6>
                </li>

				<?php
				if($ax->firmid==0)
				{
					Client::model()->urlfirm($_GET["q"]);
				}


				?>

             </ul>


	<?php }




	public function actionDepartmentpermission()
	{?>

		<div class='row'>
		<?php $department=Departments::model()->findAll(array('condition'=>'parentid=0 and clientid='.$_GET['id']));
			foreach($department as $departmentx)
			{

				$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$_GET['id'].' and departmentid='.$departmentx->id.' and subdepartmentid=0 and userid='.$_GET['user']));
				?>

			<div class='col-xl-12 col-lg-12 col-md-12 mb-1 sdepartment'>
				<div class='row department'>
					<div class='col-xl-6 col-lg-6 col-md-6 mb-1 departmentbaslik'>
						<?=$departmentx->name;?>
					</div>
					<div class='col-xl-6 col-lg-6 col-md-6 mb-1'>
						<input type="checkbox" <?php if(count($dpermission)>0){echo 'checked';}?> id="switchery2" data-size="sm" data-clientid='<?=$_GET['id'];?>' data-department='<?=$departmentx->id;?>'  data-subdepartment='0' class="switchery2" >
					</div>
				</div>

			<?php $subdepartment=Departments::model()->findAll(array('condition'=>'parentid='.$departmentx->id));

			if(count($subdepartment)){?>
			<div class='col-xl-12 col-lg-12 col-md-12 mb-1'>
				<div class='row'>
				<?php				foreach($subdepartment as $subdepartmentx)
				{
					$spermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$_GET['id'].' and departmentid='.$departmentx->id.' and subdepartmentid='.$subdepartmentx->id.' and userid='.$_GET['user']));
				?>
					<div class='col-xl-3 col-lg-3 col-md-3 mb-1'>

						<div class='col-xl-12 col-lg-12 col-md-12 mb-1 dpartmentbaslik'>
							<?=$subdepartmentx->name;?>
						</div>
						<div class='col-xl-12 col-lg-12 col-md-12 mb-1 dpartmentbaslik'>
							<input type="checkbox" <?php if(count($spermission)>0){echo 'checked';}?> id="switchery2" data-size="sm"  class="switchery2" data-clientid='<?=$_GET['id'];?>' data-department='<?=$departmentx->id;?>'  data-subdepartment='<?=$subdepartmentx->id;?>' >
						</div>
					</div>
				<?php }?>
				</div>
			</div>

			<?php }?>
			</div>

			<?php }?>
		</div>

	<?php }

	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
