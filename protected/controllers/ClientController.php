<?php

class ClientController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array(
					'subdepidgetir',
					'depidgetir',
					'mapsuser',
					'workorderreports',
					'visitreports',
					'tumunugetir',
					'clientqr',
					'showbarcodes',
					'peststypes'
					,
					'index',
					'view',
					'view2',
					'clientlist',
					'branches',
					'departments',
					'files',
					'files2',
					'monitoringpoints',
					'maps',
					'mapsupdate',
					'mapsupdate2',
					'offers',
					'reports',
					'branchstaff'
					,
					'subdepartments',
					'reportcreate',
					'chartreports',
					'subdepartments2',
					'staffsearch',
					'detail',
					'staff',
					'pointno',
					'peststype'
					,
					'livesearch',
					'auth',
					'departmentpermission',
					'datetime',
					'atananClient',
					'monitorqryenileme',
					'pdfactiviterapor',
					'pdfactiviteraporingiltere'
					,
					'mapcreate',
					'maplist',
					'mapupdate',
					'mapupdatenew',
					'mapupdatenewpoints',
					'mapmonitorc',
					'mapdelete',
					'mapdeleteall',
					'mapsmonitorcreate',
					'mapheatmap',
					'financials',
					'financialsdetail',
					'financialsdetail2',
					'create2',
					'create3',
					'excelactiviteraporingiltere',
					'issimport'
				),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'users' => array('*'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}





	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	public function actionWorkorderreports()
	{

		$ax = User::model()->userobjecty('');
		if (isset($_GET['firmid']) && $_GET['firmid'] != 0) {
			$ax->branchid = $_GET['firmid'];
		}

		$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id'], ));


		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=' . $_GET['id'] . ' and isdelete=0 and (firmid=' . $clientview->firmid . ' or mainfirmid=' . $clientview->firmid . ')',
		));


		$transferclient = 0;

		if ($ax->branchid > 0) {


			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $_GET['id'] . ' and isdelete=0 and (mainfirmid=' . $ax->branchid . ' or firmid=' . $ax->branchid . ')',
			));


			$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id']));
			if ($clientview->mainfirmid != $ax->branchid) {
				$transferclient = 1;
			}
		}


		if ($ax->clientid > 0) {


			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $ax->clientid . ' and isdelete=0',
			));


		}

		$getidx = $ax->clientbranchid;
		$monitoring = Monitoring::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'condition' => 'clientid=' . $getidx,
		));
		$department = Departments::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=:parent and clientid=:clientid',
			'params' => array('parent' => 0, 'clientid' => $getidx)
		));

		if ($ax->mainclientbranchid != $ax->clientbranchid) {
			$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $getidx . ' and subdepartmentid=0 and userid=' . $ax->id));
		}
		if ($ax->mainclientbranchid == $ax->clientbranchid) {
			$departmentk = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $getidx . ' and subdepartmentid=0 and userid=' . $ax->id));
			if (count($departmentk) != 0) {
				$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $getidx . ' and subdepartmentid=0 and userid=' . $ax->id));
			}
		}

		$clientx = Client::model()->findByPk($_GET["id"]);
		$clientbranchs = Client::model()->findAll(array('condition' => 'isdelete=0 and parentid=' . $clientx->id));

		$this->render("NDg/workorderreports", array(
			'clientview' => $clientview,
			'client' => $client,
			'transferclient' => $transferclient,
			'ax' => $ax,
			'getidx' => $getidx,
			'monitoring' => $monitoring,
			'department' => $department,
			'clientx' => $clientx,
			'clientbranchs' => $clientbranchs
		));
	}

	public function actionVisitreports()
	{
		$this->render("NDg/visitreports");
	}
	public function actionDetail($id)
	{
		$this->render('/site/detail', array(
			'model' => $this->loadModel($id),
		));
	}
	public function actionFinancials($id)
	{
		if (isset($_POST['client'])) {
			if (!is_numeric($_GET['branchid'])) {
				echo 'no';
				exit;
			}

			$json = json_encode($_POST['clientsett']);

			foreach ($_POST['client'] as $id => $item) {
				if (!is_numeric($id)) {
					echo 'no';
					exit;
				}
				$financial = Financialsettings::model()->find(array('condition' => 'clientbranch_id=' . $id));

				if ($financial) {
					$financial->updated_time = time();
				} else {

					$financial = new Financialsettings;
					$financial->created_time = time();
				}


				$financial->clientbranch_id = $id;
				$financial->contract_start_date = $item['contratstartdate'];
				$financial->contract_end_date = $item['contratenddate'];
				$financial->vat = $item['vat'];

				$financial->joint_period = $item['freetype'];
				$financial->joint_limit = $item['maxtotfree'];
				$financial->json_data = $json;
				if ($financial->save()) {
					//   echo 'ok';
				} else {
					//    echo 'no';
				}

			}

			// exit;
		}
		$ax = User::model()->userobjecty('');
		if (isset($_GET['firmid']) && $_GET['firmid'] != 0) {
			$ax->branchid = $_GET['firmid'];
		}

		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;


		$parentid = Client::model()->find(array('condition' => 'id=' . $_GET['id'], ));


		$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id']));

		$countries = Country::model()->findAll();
		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			//	'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (firmid='.$clientview->firmid.' or mainfirmid='.$clientview->firmid.')'.($isActive!=0?' and active='.(intval($isActive)==1?1:0):''),
			'condition' => 'parentid=' . $_GET['id'] . ' and isdelete=0',
		));


		$transferclient = 0;

		if ($ax->branchid > 0) {


			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				//	'condition'=>'parentid='.$_GET['id'].' and isdelete=0 and (mainfirmid='.$ax->branchid.' or firmid='.$ax->branchid.')'.($isActive!=0?' and active='.(intval($isActive)==1?1:0):''),
				'condition' => 'parentid=' . $_GET['id'] . ' and isdelete=0 ',
			));


			$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id'] . ($isActive != 0 ? ' and active=' . (intval($isActive) == 1 ? 1 : 0) : '')));
			if ($clientview->mainfirmid != $ax->branchid) {
				$transferclient = 1;
			}

		}


		if ($ax->clientid > 0) {


			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $ax->clientid . ' and isdelete=0' . ($isActive != 0 ? ' and active=' . (intval($isActive) == 1 ? 1 : 0) : ''),
			));


		}



		$this->render('NDg/financials', array(
			'model' => $this->loadModel($id),
			'clientview' => $clientview,
			'transferclient' => $transferclient,
			'ax' => $ax,
			'isActive' => $isActive,
			'parentid' => $parentid,
			'countries' => $countries,
			'client' => $client,
		));
	}
	public function actionFinancialsdetail($id)
	{
		$this->render('NDg/financialsdetail', array(
			'model' => $this->loadModel($id),
		));
	}
	public function actionFinancialsdetail2($id)
	{
		$this->render('NDg/financialsdetail2', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionDepidgetir()
	{
		if (isset($_GET["id"])) {
			echo json_encode(array("id" => Departments::model()->find(array('condition' => 'clientid=' . $_GET["clientid"] . ' and name="' . $_GET["id"] . '"'))->id));
		}

	}

	public function actionAtananClient()
	{
		$ax = User::model()->userobjecty('');
		$userss = User::model()->findAll(array("condition" => "firmid=" . $ax->firmid . " and branchid=" . $ax->branchid . " and clientid=" . $ax->clientid . " and clientbranchid=" . $_GET['id']));
		$label = '';
		$i = 0;
		$acikuy = '';
		$kapaliuy = '';
		$toplam = '';
		foreach ($userss as $userssx) {
			$aciksay = 0;
			$kapalisay = 0;
			$conformityuserassign = Conformityuserassign::model()->findAll(array("condition" => "recipientuserid=" . $userssx->id . " and returnstatustype=1", "order" => "id desc", "group" => "conformityid"));
			foreach ($conformityuserassign as $conformityuserassignx) {
				$gerigonderme = Conformityuserassign::model()->findAll(array("condition" => "parentid=" . $conformityuserassignx->id));
				$deadlineverme = Conformityactivity::model()->findAll(array("condition" => "conformityid=" . $conformityuserassignx->conformityid));
				if (!$gerigonderme && !$deadlineverme) {
					$aciksay++;
				}

				if (!$gerigonderme && $deadlineverme) {
					$kapalisay++;
				}
			}


			if ($i == 0) {
				if ($userssx->name == '' && $userssx->surname == '') {
					$label = '"' . $userssx->username . '"';
				} else {
					$label = '"' . $userssx->name . ' ' . $userssx->surname . '"';
				}

				$acikuy = $aciksay;
				$kapaliuy = $kapalisay;
				$toplam = $aciksay + $kapalisay;
			} else {
				if ($userssx->name == '' && $userssx->surname == '') {
					$label = $label . ',"' . $userssx->username . '"';
				} else {
					$label = $label . ',"' . $userssx->name . ' ' . $userssx->surname . '"';
				}

				$acikuy = $acikuy . ',' . $aciksay;
				$kapaliuy = $kapaliuy . ',' . $kapalisay;
				$top = $aciksay + $kapalisay;
				$toplam = $toplam . ',' . $top;
			}
			$i++;
		}

		$value = array(
			"label" => $label,
			"acikuy" => $acikuy,
			"kapaliuy" => $kapaliuy,
			"toplam" => $toplam
		);
		$str_json_format = json_encode($value);
		print $str_json_format;
	}


	public function actionSubdepidgetir()
	{
		if (isset($_POST["id"])) {

			echo json_encode(array("id" => Departments::model()->find(array('condition' => 'clientid=' . $_POST["clientid"] . '  and parentid=' . $_POST["departmentid"] . ' and name like "' . $_POST["id"] . '%"'))->id));
		}

	}

	public function actionPdfactiviterapor()
	{
		$tarihAraligi = $_POST['tarihAraligi'];
		$depName = $_POST['depName'];
		$client = Client::model()->findByPk($_POST['Reports']['clientid']);

		Yii::import('application.modules.pdf.components.pdf.mpdf');

		$url = Yii::app()->basepath . "/views/client/NDg/PdfTemplate/";
		include($url . "pdf_aktivite_rapor.php");

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetTitle($client->name . ' ' . $depName . " - " . $tarihAraligi . ' Trend Analizi');
		$mpdf->AddPage('L');
		$mpdf->WriteHTML($html);
		$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

		$mpdf->Output($client->name . ' ' . $depName . " - " . $tarihAraligi . ' Trend Analizi.pdf', 'I');
		//    $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

		exit;


	}

	public function actionPdfactiviteraporingiltere()
	{
		$tarihAraligi = $_POST['tarihAraligi'];
		$depName = $_POST['depName'];
		$client = Client::model()->findByPk($_POST['Reports']['clientid']);

		Yii::import('application.modules.pdf.components.pdf.mpdf');

		$url = Yii::app()->basepath . "/views/client/NDg/PdfTemplate/";

		$ax = User::model()->userobjecty('');
		/*if($ax->id==1 || $ax->id==317)
		{
			*/
		include($url . "pdf_aktivite_rapor_ingiltere_m.php");
		/*}
		else
		{
			include($url . "pdf_aktivite_rapor_ingiltere.php");
		}
		*/


		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetTitle($client->name . ' ' . $depName . " - " . $tarihAraligi . ' Trend Analizi');
		$mpdf->AddPage('L');
		$mpdf->WriteHTML($html);
		$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

		$mpdf->Output($client->name . ' ' . $depName . " - " . $tarihAraligi . ' Trend Analizi.pdf', 'I');
		//    $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

		exit;


	}


	public function actionExcelactiviteraporingiltere()
	{
		$tarihAraligi = $_POST['tarihAraligi'];
		$depName = $_POST['depName'];
		$client = Client::model()->findByPk($_POST['Reports']['clientid']);


		$url = Yii::app()->basepath . "/views/client/NDg/exel/";

		$ax = User::model()->userobjecty('');

		include($url . "excel_activite_rapor_grafik_ingiltere.php");

		exit;


	}

	public function actionIssimport()
	{
		echo 'ok';
		exit;
		$return = Client::model()->issimport();
		print_r($return);
	}
	public function actionYillikkiyasraporu()
	{
		$tarihAraligi = $_POST['tarihAraligi'];
		$depName = $_POST['depName'];
		$client = Client::model()->findByPk($_POST['Reports']['clientid']);

		Yii::import('application.modules.pdf.components.pdf.mpdf');

		$url = Yii::app()->basepath . "/views/client/NDg/PdfTemplate/";
		include($url . "pdf_aktivite_rapor.php");

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetTitle($client->name . ' ' . $depName . " - " . $tarihAraligi . ' Trend Analizi');
		$mpdf->AddPage('L');
		$mpdf->WriteHTML($html);
		$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

		$mpdf->Output($client->name . ' ' . $depName . " - " . $tarihAraligi . ' Trend Analizi.pdf', 'I');
		//    $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

		exit;


	}

	public function actionView($id)
	{
		if (isset($_POST['clientid'])) {
			// 			$guncelle=Client::model()->changeactive($_POST['clientid'],$_POST['active']);
// 			if(!$guncelle){
// 				echo "hata";
// 			}
// 			else{
// 				echo "kaydedildi";
// 			}
			echo 'burada';
			exit;
		}

		$ax = User::model()->userobjecty('');

		if (isset($_GET['firmid']) && $_GET['firmid'] != 0) {
			$ax->branchid = $_GET['firmid'];
		}
		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;
		$parentid = Client::model()->find(array('condition' => 'id=' . $_GET['id'], ));


		$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id']));
		$firmid = isset($_GET['firmid']) && $_GET['firmid'] != 0 ? $_GET['firmid'] : $clientview->firmid;
		$id = isset($_GET['id']) ? $_GET['id'] : $id;
		$transferclient = 0;
		$countries = array();
		if ($clientview->firmid == 799) {
			$countries = Country::model()->findAll(array(
				'order' => 'code asc'
			));
		} else {

			$countries = Country::model()->findAll(array(
				'order' => 'ordering asc'
			));
		}
		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=' . $id . ' and isdelete=0 and (firmid=' . $clientview->firmid . ' or mainfirmid=' . $clientview->firmid . ')' . ($isActive != 0 ? ' and active=' . (intval($isActive) == 1 ? 1 : 0) : ''),
		));

		$transferclient = 0;

		if ($ax->branchid > 0) {
			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $id . ' and isdelete=0 and (mainfirmid=' . $ax->branchid . ' or firmid=' . $ax->branchid . ')' . ($isActive != 0 ? ' and active=' . (intval($isActive) == 1 ? 1 : 0) : ''),
			));
			$clientview = Client::model()->find(array('condition' => 'id=' . $id . ($isActive != 0 ? ' and active=' . (intval($isActive) == 1 ? 1 : 0) : '')));

			if ($clientview && $clientview->mainfirmid != $ax->branchid) {
				$transferclient = 1;
			}
		}
		if ($ax->clientid > 0) {
			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $ax->clientid . ' and isdelete=0' . ($isActive != 0 ? ' and active=' . (intval($isActive) == 1 ? 1 : 0) : ''),
			));
		}

		$availablefirm = Firm::model()->find(array(
			'condition' => 'id=:id',
			'params' => array('id' => $firmid)
		));

		$sector = Sector::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'active=1',
		));
		$this->render('view', array(
			'model' => $this->loadModel($id),
			'ax' => $ax,
			'isActive' => $isActive,
			'parentid' => $parentid,
			'clientview' => $clientview,
			'transferclient' => $transferclient,
			'client' => $client,
			'availablefirm' => $availablefirm,
			'countries' => $countries,
			'sector' => $sector,
			'firmid' => $firmid,
			'id' => $id,
		));
	}
	public function actionView2($id)
	{
		if (isset($_POST['clientid'])) {
			// 			$guncelle=Client::model()->changeactive($_POST['clientid'],$_POST['active']);
// 			if(!$guncelle){
// 				echo "hata";
// 			}
// 			else{
// 				echo "kaydedildi";
// 			}
			echo 'burada';
			exit;
		}

		$this->render('view2', array(
			'model' => $this->loadModel($id),
		));
	}




	/////////yeni uygunsuzluk uygunsuzlukListesi
	public function actionClientlist()
	{

		$request = [];
		if (isset($_GET["id"])) {
			$request['id'] = $_GET["id"];
		}
		if (isset($_GET["fid"])) {
			$request['firm'] = $_GET["fid"];
		}

		if (isset($_GET["bid"])) {
			$request['branch'] = $_GET["bid"];
		}
		if (isset($_GET["cid"])) {
			$request['client'] = $_GET["cid"];
		}
		if (isset($_GET["cbid"])) {
			$request['clientbranch'] = $_GET["cbid"];
		}

		if (isset($_GET["status"])) {
			$request['status'] = $_GET["status"];
		}


		// if (isset($_POST) &&(isset($_POST['firm']) || isset($_POST['branch']) || isset($_POST['client']))) {
		// $request['status']=$_POST["status"];
		// $request['firm']=$_POST["firm"];
		// $request['branch']=$_POST["branch"];
		// $request['client']=$_POST["client"];
		// $request['department']=$_POST["department"];
		// $request['subdepartment']=$_POST["subdepartment"];
		// $request['conformitytype']=$_POST["conformitytype"];
		// $request['status']=$_POST["status"];
		// $request['finishDate']=$_POST["finishDate"];
		// $request['startDate']=$_POST["startDate"];
		// }

		$response = Client::model()->clientList($request);
		echo json_encode($response);
		exit;
	}
	///////// yeni uyunsuzluk listesi bitiş


	public function actionBranches($id)
	{
		$ax = User::model()->userobjecty('');

		if (isset($_GET['type']) && is_numeric($_GET['type'])) {
			$ctypesx = $_GET['type'];
		} else {
			$ctypesx = 1;
		}
		if (isset($_GET['id']) & is_numeric($_GET['id'])) {
			$getidx = $_GET['id'];
		} else {
			$getidx = 0;
		}
		if (isset($_GET['firmid']) && $_GET['firmid'] != 0) {
			$ax->branchid = $_GET['firmid'];
		}

		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=' . $getidx . ' and isdelete=0',
		));

		$clientview = Client::model()->find(array('condition' => 'id=' . $getidx, ));

		$firmidxx = $clientview->mainfirmid;
		$firmxx = Firm::model()->find(array('condition' => 'id=' . $firmidxx));
		$country = $firmxx->country_id;
		if (isset($_POST['mntrs'])) {
			$valmn = json_encode($_POST['mntrs']);
			$clientview->monitor_info = $valmn;
			$clientview->update();
		}
		$mntrinf = [];
		if ($clientview->monitor_info <> '') {
			$mntrinf = json_decode($clientview->monitor_info, true);
		}




		$monitoring = Monitoring::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'condition' => 'clientid=' . $getidx,
		));



		$department = Departments::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=:parent and clientid=:clientid',
			'params' => array('parent' => 0, 'clientid' => $getidx)
		));

		if ($ax->mainclientbranchid != $ax->clientbranchid) {
			$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $getidx . ' and subdepartmentid=0 and userid=' . $ax->id));
		}
		if ($ax->mainclientbranchid == $ax->clientbranchid) {
			$departmentk = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $getidx . ' and subdepartmentid=0 and userid=' . $ax->id));
			if (count($departmentk) != 0) {
				$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $getidx . ' and subdepartmentid=0 and userid=' . $ax->id));
			}
		}

		$this->render('NDg/branches', array(
			'model' => $this->loadModel($id),
			'ax' => $ax,
			'clientview' => $clientview,
			'client' => $client,
			'firmidxx' => $firmidxx,
			'firmxx' => $firmxx,
			'id' => $id,
			'department' => $department,
			'monitoring' => $monitoring,
			'mntrinf' => $mntrinf,
			'ctypesx' => $ctypesx,
			'getidx' => $getidx,
			'country' => $country,
			'monthssett' => null,

		));
	}


	public function actionDatetime()
	{
		if (isset($_GET['time']) && $_GET['time']) {
			$date = date('Y-m-d', strtotime('+6 month', strtotime($_GET['time'])));
			if (strtotime($date) > time()) {
				echo json_encode(date('Y-m-d'));
			} else {
				echo json_encode($date);
			}
		} else {
			echo json_encode(date('Y-m-d'));


		}
	}

	public function actionClientqr()
	{
		$model = Client::model()->findByPk($_GET["id"]);
		$modelP = Client::model()->findByPk($model->parentid);
		file_get_contents('https://' . $_SERVER['HTTP_HOST'] . "/qrcode/qrcode?txt=" . $_GET["id"] . "&size=12");
		$redirectedUrl = 'https://insectram.io/uploads/barcode/temp/' . md5($_GET["id"]) . '.png';
		//Yii::import('application.modules.pdf.components.pdf.mpdf');
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->showImageErrors = true;
		$yaz = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
		$yaz .=
			"<style>.centered{
			padding-left:25%;
			padding-top:45%;
			text-align:center;
			width:50%;
			top:25%;
			position: sticky;justify-content: center;
			}</style>";
		$yaz .= "<div class='centered'><center>" . $modelP->name . "</center><br>";
		$yaz .= "<center>" . $model->name . "</center>";
		//$yaz .= "<center><img src='".$redirectedUrl."'></center>";
		$yaz .= '<center><img src="' . $redirectedUrl . '"></center>';
		$yaz .= '</div></body></html>';

		$mpdf->WriteHTML($yaz);
		$mpdf->Output();
		exit;
	}
	public function actionDepartments($id)
	{
		$ax = User::model()->userobjecty('');
		$departments = Departments::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=:parent and clientid=:clientid',
			'params' => array('parent' => 0, 'clientid' => $_GET['id'])
		));



		$department = [];
		if ($ax->mainclientbranchid != $ax->clientbranchid) {
			$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and subdepartmentid=0 and userid=' . $ax->id));
		}

		if ($ax->mainclientbranchid == $ax->clientbranchid) {
			$departmentk = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and subdepartmentid=0 and userid=' . $ax->id));
			if (count($departmentk) != 0) {
				$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and subdepartmentid=0 and userid=' . $ax->id));
			}
		}
		$monitoring = Monitoring::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'condition' => 'clientid=' . $_GET['id'],
		));

		if((isset($_GET['status']) && $_GET['status']==1) || !isset($_GET['status']))
		{
		$userwhere=' and active=1';
		}
		else if(isset($_GET['status']) && $_GET['status']==2)
		{
		$userwhere=' and active=0';
		}
		else
		{
		 $userwhere='';
		}
		$say=User::model()->findAll(array('condition'=>'type not in (24,22) and clientbranchid='.$_GET['id'].$userwhere));
		$transfer=Client::model()->istransfer($_GET['id']);
		$tclient=Client::model()->find(array('condition'=>'id='.$_GET['id']));
   
		$this->render('NDg/departments', array(
			'model' => $this->loadModel($id),
			'departments' => $departments,
			'department' => $department,
			'monitoring' => $monitoring,
			'id' => $id,
			'ax' => $ax,
			'say' => $say,
			'transfer' => $transfer,
			'tclient' => $tclient,
		));
	}

	public function actionFiles($id)
	{
		$this->render('NDg/files', array(
			'model' => $this->loadModel($id),
		));
	}
	public function actionFiles2($id)
	{
		$this->render('NDg/files2', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionMonitoringpoints($id = 0)
	{
		if (isset($_POST['monitoringid'])) {
			$guncelle = Monitoring::model()->changeactive($_POST['monitoringid'], $_POST['active']);
			if (!$guncelle) {
				echo "hata";
			} else {
				echo "kaydedildi";
			}

		}

		$ax= User::model()->userobjecty('');
		$departments=Departments::model()->findAll(array(
										   #'select'=>'',
										   #'limit'=>'5',
										   'order'=>'name ASC',
										   'condition'=>'parentid=:parent and clientid=:clientid','params'=>array('parent'=>0,'clientid'=>$_GET['id'])
									   ));
		$firmid=$ax->firmid;
		$firm=Firm::model()->find(array('condition'=>'id='.$firmid));
		$country=$firm?$firm->country_id:0;
		
		if (isset($_GET['id']) ){
			if (is_numeric($_GET['id'])){
				
			}else{
				echo 'bad_id';
				exit;
			}
		}
		$where='';
		if(isset($_GET['isactive']))
		{
			$where=' and active='.$_GET['isactive'];
		}
		
		$monitoring=Monitoring::model()->findAll(array(
										   #'select'=>'',
										   #'limit'=>'5',
										   'condition'=>'clientid='.$_GET['id'].$where,
									   ));
		
		
		
		
		
		
		
		$clientbtitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_GET['id'])));
		$clienttitle=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientbtitle->parentid)));
		$branchtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clienttitle->firmid)));
		$firmtitle=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$branchtitle->parentid)));
		
		
		
		$transfer=Client::model()->istransfer($_GET['id']);
		$tclient=Client::model()->find(array('condition'=>'id='.$_GET['id']));
		
		if((isset($_GET['status']) && $_GET['status']==1) || !isset($_GET['status']))
		{
		$userwhere=' and active=1';
		}
		else if(isset($_GET['status']) && $_GET['status']==2)
		{
		$userwhere=' and active=0';
		}
		else
		{
		 $userwhere='';
		}
		$say=User::model()->findAll(array('condition'=>'type not in (24,22) and clientbranchid='.$_GET['id'].$userwhere));
		$monitorcount=Monitoring::model()->find(array(
			'order'=>'mno DESC',
			'condition'=>'clientid='.$_GET['id'],
		));
		$monitoringlocations=Monitoringlocation::model()->findAll();
		$monitoringtypes=null;
					if ($country<>0) {
			$monitoringtypes=Monitoringtype::model()->findAll(array(
					  'condition'=>'country_id='.$country.' or country_id=0 and active=1',
				  ));
	   }else{
				// $monitoringtypes=Monitoringtype::model()->findAll();
				 $monitoringtypes=Monitoringtype::model()->findAll(array(
					  'condition'=>'(country_id=1 or country_id=0) and  active=1',
				  ));
	   }
		$this->render('NDg/monitoringpoints', array(
			'model' => $this->loadModel($id),
			'ax' => $ax,
			'departments' => $departments,
			'firm' => $firm,
			'country' => $country,
			'monitoring' => $monitoring,
			'clientbtitle' => $clientbtitle,
			'clienttitle' => $clienttitle,
			'branchtitle' => $branchtitle,
			'firmtitle' => $firmtitle,
			'transfer' => $transfer,
			'tclient' => $tclient,
			'say' => $say,
			'monitorcount' => $monitorcount,
			'monitoringlocations' => $monitoringlocations,
			'monitoringtypes' => $monitoringtypes,
			'firmid'=>$firmid,
		));
	}

	public function actionOffers($id)
	{
		$this->render('NDg/branches', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionReporst($id)
	{
		$this->render('NDg/branches', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionBranchstaff($id)
	{
		$ax = User::model()->userobjecty('');
		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;
		$monitoring = Monitoring::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'condition' => 'clientid=' . $_GET['id'],
		));

		$departments = Departments::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=:parent and clientid=:clientid',
			'params' => array('parent' => 0, 'clientid' => $_GET['id'])
		));
		$department = [];
		if ($ax->mainclientbranchid != $ax->clientbranchid) {
			$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and subdepartmentid=0 and userid=' . $ax->id));
		}

		if ($ax->mainclientbranchid == $ax->clientbranchid) {
			$departmentk = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and subdepartmentid=0 and userid=' . $ax->id));
			if (count($departmentk) != 0) {
				$department = Departmentpermission::model()->findAll(array('condition' => 'clientid=' . $_GET['id'] . ' and subdepartmentid=0 and userid=' . $ax->id));
			}
		}




		$transfer = Client::model()->istransfer($_GET['id']);
		$tclient = Client::model()->find(array('condition' => 'id=' . $_GET['id']));




		$delisActive = 0;
		if (($ax->firmid == 0 || ($ax->firmid != 0 && $ax->branchid == 0) || ($ax->firmid != 0 && $ax->branchid != 0 && $ax->clientid != 0)) && ($ax->type == 13 || $ax->type == 23)) {

			$delisActive = 1;
		}

		if ((isset($_GET['status']) && $_GET['status'] == 1) || !isset($_GET['status'])) {
			$userisactive = ' and u.active=1';
		} else if (isset($_GET['status']) && $_GET['status'] == 2) {
			$userisactive = ' and u.active=0';
		} else {
			$userisactive = '';
		}


		$where = 'u.type not in (24,22) and u.clientbranchid=' . $_GET['id'] . $userisactive;

		$user = Yii::app()->db->createCommand()
			->select("u.*,u.id userid,i.birthplace,i.birthdate,i.gender,i.primaryphone")
			->from('user u')
			->leftJoin('userinfo i', 'i.id=u.id')
			->where($where)
			->queryall();

		$languages = Languages::model()->findAll();
		$this->render('NDg/branchstaff', array(
			'model' => $this->loadModel($id),
			'ax' => $ax,
			'isActive' => $isActive,
			'monitoring' => $monitoring,
			'departments' => $departments,
			'department' => $department,
			'transfer' => $transfer,
			'tclient' => $tclient,
			'delisActive' => $delisActive,
			'user' => $user,
			'userisactive' => $userisactive,
			'languages' => $languages,
		));
	}

	public function actionStaff($id)
	{
		$ax = User::model()->userobjecty('');
		$isActive = isset($_GET['status']) ? intval($_GET['status']) : 1;
		$parentid = Client::model()->find(array('condition' => 'id=' . $_GET['id'], ));


		$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id'], ));
		$transferclient = 0;

		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=' . $_GET['id'] . ' and isdelete=0 and (firmid=' . $clientview->firmid . ' or mainfirmid=' . $clientview->firmid . ')',
		));


		$transferclient = 0;

		if ($ax->branchid > 0) {


			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $_GET['id'] . ' and isdelete=0 and (mainfirmid=' . $ax->branchid . ' or firmid=' . $ax->branchid . ')',
			));


			$clientview = Client::model()->find(array('condition' => 'id=' . $_GET['id']));
			if ($clientview->mainfirmid != $ax->branchid) {
				$transferclient = 1;
			}





		}


		if ($ax->clientid > 0) {


			$client = Client::model()->findAll(array(
				#'select'=>'',
				#'limit'=>'5',
				'order' => 'name ASC',
				'condition' => 'parentid=' . $ax->clientid . ' and isdelete=0',
			));


		}

		$firm = Firm::model()->find(array('condition' => 'id=' . $ax->firmid));

		if ((isset($_GET['status']) && $_GET['status'] == 1) || !isset($_GET['status'])) {
			$userisactive = ' and u.active=1';
		} else if (isset($_GET['status']) && $_GET['status'] == 2) {
			$userisactive = ' and u.active=0';
		} else {
			$userisactive = '';
		}


		$where = '(u.clientbranchid=0 or u.type in (24,22)) and u.clientid=' . $_GET['id'] . $userisactive;


		$user = Yii::app()->db->createCommand()
			->select('u.*,u.id userid,i.birthplace,i.birthdate,i.gender,i.primaryphone,
	  (select itemname from AuthAssignment a where userid=u.id and a.itemname=IF(u.firmid!=0 and u.branchid=0,CONCAT(f.package,".",f.username,".",at.authname),
	  IF(u.branchid!=0 and u.clientid=0,CONCAT(f.package,".",f.username,".",b.username,".",at.authname),
	  IF(u.clientid!=0 and u.clientbranchid=0,CONCAT(f.package,".",f.username,".",b.username,".",c.username,".",at.authname),
	  CONCAT(f.package,".",f.username,".",b.username,".",c.username,".",cb.username,".",at.authname))))) as itemname,
	  g.type conformityemail,
	  g2.isactive serviceemail'
			)

			->from('user u')
			->leftJoin('userinfo i', 'i.userid=u.id')
			->leftJoin('generalsettings g', 'g.userid=u.id and g.name="conformityemail"')
			->leftJoin('generalsettings g2', 'g2.userid=u.id and g2.name="serviceemail"')
			->leftJoin('firm f', 'f.id=u.firmid')
			->leftJoin('firm b', 'b.id=u.branchid')
			->leftJoin('client c', 'c.id=u.clientid')
			->leftJoin('client cb', 'cb.id=u.clientbranchid')
			->leftJoin('authtypes at', 'at.id=u.type')
			->where($where)
			//->getText();
			->queryAll();

		$delisActive = 0;
		if (($ax->firmid == 0 || ($ax->firmid != 0 && $ax->branchid == 0) || ($ax->firmid != 0 && $ax->branchid != 0 && $ax->clientid != 0)) && ($ax->type == 13 || $ax->type == 23)) {

			$delisActive = 1;
		}

		$this->render('NDg/staff', array(
			'model' => $this->loadModel($id),
			'ax' => $ax,
			'isActive' => $isActive,
			'parentid' => $parentid,
			'clientview' => $clientview,
			'transferclient' => $transferclient,
			'client' => $client,
			'firm' => $firm,
			'user' => $user,
			'delisActive' => $delisActive,
		));
	}

	public function actionReports($id)
	{
		$this->render('NDg/reports', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionChartreports($id)
	{
		$this->render('NDg/chartreports', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionAuth()
	{
		if (isset($_POST['firmid'])) {

			echo $_POST['firmid'];
			if ($_POST['active'] == 1) {
				$auth = new AuthAssignment;
				$data = explode('|', $_POST['firmid']);
				$auth->itemname = $data[0];
				$auth->userid = $data[1];
				if (!$auth->save()) {
					echo t("Error");
				} else {
					echo t("Successful");
				}

			} else if ($_POST['active'] == 0) {
				$data = explode('|', $_POST['firmid']);
				$auth = AuthAssignment::model()->find('itemname="' . $data[0] . '" and userid=' . $data[1]);
				if ($auth) {
					$auth->delete();
					$user = User::model()->findbypk($auth->userid);
					$user->clientbranchid = $user->mainclientbranchid;
					$user->update();

					echo t("Successful");
				}
			}
		}



		if (isset($_POST['clientid'])) {
			$guncelle = Client::model()->departmentpermission($_POST['clientid'], $_POST['department'], $_POST['subdepartment'], $_POST['active'], $_POST['userid']);
			if (!$guncelle) {
				echo "hata";
			} else {
				echo "kaydedildi";
				exit;
			}

		}


		$this->render("NDg/auth");
	}

	public function actionPointno()
	{

		if (isset($_GET['department']) && $_GET['department'] == 0 && isset($_GET['subdepartment']) && $_GET['subdepartment'] == 0) {
			if (isset($_GET["type"]) && $_GET["type"] == 0) {
				$monitoring = Monitoring::model()->findAll(array('condition' => 'active=1 and clientid=' . $_GET["clientid"]));

			} else {
				$monitoring = Monitoring::model()->findAll(array('condition' => 'mtypeid in (' . $_GET["type"] . ') and clientid=' . $_GET["clientid"]));

			}
		} else {
			if (isset($_GET['department']) && $_GET['department'] != 0 && isset($_GET['subdepartment']) && $_GET['subdepartment'] == 0) {


				if (isset($_GET["type"]) && $_GET["type"] == 0) {
					$monitoring = Monitoring::model()->findAll(array(
						'condition' => 'active=1 and dapartmentid in (' . $_GET['department'] . ') '
					));
				} else {
					$monitoring = Monitoring::model()->findAll(array(
						'condition' => 'active=1 and dapartmentid in (' . $_GET['department'] . ') and mtypeid in (' . $_GET['type'] . ')'
					));
				}
			} else if (isset($_GET['department']) && $_GET['department'] != 0 && isset($_GET['subdepartment']) && $_GET['subdepartment'] != 0) {


				if (isset($_GET["type"]) && $_GET["type"] == 0) {
					$monitoring = Monitoring::model()->findAll(array(
						'condition' => 'active=1 and dapartmentid in (' . $_GET['department'] . ') and subid in (' . $_GET['subdepartment'] . ')'
					));
				} else {
					$monitoring = Monitoring::model()->findAll(array(
						'condition' => 'active=1 and dapartmentid in (' . $_GET['department'] . ') and mtypeid  in (' . $_GET['type'] . ') and subid in (' . $_GET['subdepartment'] . ')'
					));
				}
			} else {


				if (isset($_GET["type"]) && $_GET["type"] == 0) {
					$monitoring = Monitoring::model()->findAll(array(
						'condition' => 'active=1 and dapartmentid in (' . $_GET['department'] . ')'
					));
				} else {
					$monitoring = Monitoring::model()->findAll(array(
						'condition' => 'active=1 and dapartmentid in (' . $_GET['department'] . ') and mtypeid  in (' . $_GET['type'] . ')'
					));
				}
			}


		}


		if (count($monitoring) == 0) { ?>
			<option value="null"><?= t('Null'); ?></option>
		<?php } else {

			foreach ($monitoring as $monitoringx) {
				$type = Monitoringtype::model()->findByPk($monitoringx->mtypeid);
				?>
				<option value="<?= $monitoringx->id; ?>"><?= $type->name . " - " . $monitoringx->mno; ?></option>
			<?php }
		} ?>

	<?php }


	public function actionPeststypes()
	{

		$monitortype = $_GET["type"];
		$criteria = new CDbCriteria;
		if (isset($_GET["reptype"]) && ($_GET["reptype"] == 2 || $_GET["reptype"] == 5 || $_GET["reptype"] == 8)) {
			$criteria->condition = '!(petsid in (34,35,36,39,48,49,50)) and monitoringtypeid in (' . $_GET["type"] . ')';
		} else if (isset($_GET["reptype"]) && $_GET["reptype"] == 98) {

			$criteria->condition = '!(petsid in (34,35,36,39,48,49,50)) and monitoringtypeid in (' . $_GET["type"] . ')';

		} else {
			$criteria->condition = 'monitoringtypeid = (' . $_GET["type"] . ')';

		}

		$criteria->group = 'petsid';

		$pests = Monitoringtypepets::model()->findAll($criteria);


		if (isset($_GET["reptype"]) && $_GET["reptype"] == 7) {
			foreach ($pests as $pest) {
				$pet = Pets::model()->findByPk($pest->petsid);
				if ($pet->isproduct == 1) {
					?>
					<option value="<?= $pest->petsid; ?>"><?= t($pet->name); ?></option>
				<?php }
			} ?>
			<option value="49"><?= t("Monitor Status"); ?></option> <?php
		} else {
			if (count($pests) == 0) { ?>
				<option value="null"><?= t('Null'); ?></option>
			<? } else {
				foreach ($pests as $pest) {
					$pet = Pets::model()->findByPk($pest->petsid);
					?>
					<option value="<?= $pest->petsid; ?>"><?= t($pet->name); ?></option>
				<? }
			}
		} ?>

		<?php
	}


	public function actionMonitorqryenileme()
	{
		$ids = array();
		$monitorolurturma = 2;
		$monitorno = array();

		array_push($ids, $_GET['barkode']);
		array_push($monitorno, $_GET['mno']);
		include("./barcode/monitorBarcodeList.php");

	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = 0)
	{
		//$_POST['Client']['branchid']=1;

		$authuser = '';
		$ax = User::model()->userobjecty('');


		$firmname = Client::model()->userfirmname($_POST['Client']['bfirmid']);

		$authuser = Firm::model()->usernameproduce($_POST['Client']['name']);




		Yii::app()->getModule('authsystem');

		$model = new Client;


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$client = Client::model()->findAll(array(
			'condition' => 'firmid=:firmid and name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0',
			'params' => array('firmid' => $_POST['Client']['bfirmid'], 'name' => $_POST['Client']['name'], 'title' => $_POST['Client']['title'], 'taxoffice' => $_POST['Client']['taxoffice'], 'taxno' => $_POST['Client']['taxno'], 'address' => $_POST['Client']['address'], 'landphone' => $_POST['Client']['landphone'], 'email' => $_POST['Client']['email'])
		));


		if (isset($_POST['Client']) && count($client) == 0) {


			$count = count(Client::model()->findAll(array('condition' => "username Like '%" . $authuser . "%'")));
			$username = $authuser . ($count + 1);
			$model->attributes = $_POST['Client'];
			$model->parentid = $id;
			$model->mainclientid = $id;
			$model->createdtime = time();




			if ($_POST['Client']['bfirmid'] > 0) {
				$model->firmid = $_POST['Client']['bfirmid'];
			} else {


				if ($ax->branchid == 0) {
					$model->firmid = Client::model()->find(array('condition' => 'id=' . $id))->firmid;
				} else {
					$model->firmid = $ax->branchid;
				}
			}



			$firmm = Firm::model()->findByPk($model->firmid);
			// $results=Documents::model()->newFCsubdocument($firmm->parentid,$firmm->id,$id,0);///cliente hepsi diye eklenen dokümanlar

			$model->mainfirmid = $model->firmid;
			$model->username = $username;
			$model->save();

			$resultsadd = Documents::model()->newFCsubdocumentAdd($firmm->parentid, $firmm->id, $id == 0 ? $model->id : $id, $id != 0 ? $model->id : 0); ///yeni eklenen client e döküman yetkisi verildi


			if ($id == 0) {
				$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('firmbranch', $model->firmid) . "'"))->name;
			} else {
				$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('client', $id) . "'"))->name;
			}

			AuthItem::model()->createitem($pname . '.' . $username, 0);
			AuthItem::model()->generateparentpermission($pname . '.' . $username);

			if ($id == 0) {
				AuthItem::model()->createnewauth($pname, $username, 'Customer');
			} else {
				AuthItem::model()->createnewauth($pname, $username, 'Branch');
			}


			//post edilen yer clientse onun subeside otomatik kendi verilerinin aynısıyla ekleniyor.
			if ($id == 0) {
				$model2 = new Client;
				$model2->attributes = $_POST['Client'];
				$model2->name = $_POST['Client']['name'] . ' - Branch';
				$model2->parentid = $model->id;
				if ($_POST['Client']['bfirmid'] > 0) {
					$model2->firmid = $model->firmid;
				} else {
					$model2->firmid = $model->firmid;
				}

				$count = count(Client::model()->findAll(array('condition' => "username Like '%" . $username . "%'")));
				$username2 = $authuser . ($count + 1);
				$model2->username = $username2;
				$model2->mainfirmid = $model->firmid;
				$model2->mainclientid = $model->id;
				$model2->createdtime = time();

				// $results=Documents::model()->newFCsubdocument($firmm->parentid,$firmm->id,$model->id,0);///client bracnha hepsi diye eklenen dokümanlar

				$model2->save();
				$resultsadd = Documents::model()->newFCsubdocumentAdd($firmm->parentid, $firmm->id, $model->id, $model2->id); ///yeni eklenen client bracnha e döküman yetkisi verildi

				AuthItem::model()->createitem($pname . '.' . $username . '.' . $username2, 0);
				AuthItem::model()->generateparentpermission($pname . '.' . $username . '.' . $username2);
				AuthItem::model()->createnewauth($pname . '.' . $username, $username2, 'Branch');



				//loglama
				Logs::model()->logsaction();
				/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
				if ($_POST['Client']['bfirmid'] > 0) {
					Yii::app()->SetFlashes->add($model, t('Create Success!'), array('/firm/client?type=branch&&id=' . $_POST['Client']['bfirmid']));
				} else {
					Yii::app()->SetFlashes->add($model, t('Create Success!'), array('index'));
				}
			}


			//loglama
			Logs::model()->logsaction();
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

			Yii::app()->SetFlashes->add($model, t('Create Success!'), array('view?id=' . $id . "&firmid=" . $model->firmid));
		}


		//eger mevcut verinin aynısı post edilirse mevcut data mesajı verilir
		Yii::app()->user->setFlash('error', t('client' . ' previously used'));
		if ($id == 0) {
			if ($_POST['Client']['bfirmid'] > 0) {
				$this->redirect(array('/firm/client?type=branch&&id=' . $_POST['Client']['bfirmid']));
			} else {
				$this->redirect(array('index'));
			}
		} else {
			$this->redirect(array('view?id=' . $id));
		}
	}



	/// 
	public function actionCreate2($id = 0)
	{
		//client branch import
		exit;
		//$_POST['Client']['branchid']=1;
		echo 'ok';


		$authuser = '';
		$ax = User::model()->userobjecty('');

		// print_r($ax);
		$columns = [];
		$columns[] = 'Rsidential main client  ın branchları';
		$columns[] = 'Commercial title';
		$columns[] = 'Tax Office';
		$columns[] = 'Tax No';
		$columns[] = 'Sector';
		$columns[] = 'Office No';
		$columns[] = 'Address';
		$columns[] = 'Town or City';
		$columns[] = 'Post Code';
		$columns[] = 'E-Mail';
		$columns[] = 'Active or passive ( a/p )';
		$columns[] = 'SHOP / COMPANY NAME';
		$columns[] = 'DESCRIPTION / NOTE';
		$columns[] = 'PRICE';
		$columns[] = 'CONTRACT / JOB START DATE';
		$columns[] = 'CONTRACT / WARRANTY FINISH DATE';
		$columns[] = 'VISIT NO / DATE';
		$columns[] = 'LAST VISIT DATE';
		$columns[] = 'PEST CONTROLER';
		$columns[] = 'WHOSE CUSTOMER';

		$file = fopen("a.csv", "r");

		while (($data = fgetcsv($file)) !== FALSE) {
			print_r($data);
			//    echo "email address " . $data[0];



			$firmname = Client::model()->userfirmname($_POST['Client']['bfirmid']);

			$authuser = Firm::model()->usernameproduce($data[0]);




			Yii::app()->getModule('authsystem');

			$model = new Client;


			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			if (trim($data[0]) == '') {
				$xnamexx = 'Residental-' .
					(strlen($data[0]) + strlen($data[1]) + strlen($data[2]) + strlen($data[3]) + strlen($data[4]) + strlen($data[5]) + strlen($data[6]) + strlen($data[7]) + strlen($data[8]) + strlen($data[9]));
				$client = Client::model()->findAll(array(
					'condition' => 'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0',
					'params' => array('name' => $xnamexx, 'title' => $data[1], 'taxoffice' => $data[2], 'taxno' => $data[3], 'address' => $data[6], 'landphone' => $data[5], 'email' => $data[9])
				));

			} else {
				$client = Client::model()->findAll(array(
					'condition' => 'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0',
					'params' => array('name' => $data[0], 'title' => $data[1], 'taxoffice' => $data[2], 'taxno' => $data[3], 'address' => $data[6], 'landphone' => $data[5], 'email' => $data[9])
				));
			}




			if (count($client) == 0) {


				$count = count(Client::model()->findAll(array('condition' => "username Like '%" . $username . "%'")));
				$username = $authuser . ($count + 1);


				//$model->attributes=$_POST['Client'];
				// $model->client_code ='';
				$model->branchid = 14; // Residental tipi
				//$model->firmid =$data[1];
				// $model->mainclientid =$data[1];
				$model->country_id = 2;
				//  https://insectram.io/client/create2/7314
				if (trim($data[0]) == '') {
					$model->name = 'Residental-' .
						(strlen($data[0]) + strlen($data[1]) + strlen($data[2]) + strlen($data[3]) + strlen($data[4]) + strlen($data[5]) + strlen($data[6]) + strlen($data[7]) + strlen($data[8]) + strlen($data[9]));
				} else {
					$model->name = $data[0];
				}

				$model->title = $data[1];
				$model->taxoffice = $data[2];
				$model->taxno = $data[3];
				$model->address = $data[6];
				$model->town_or_city = $data[7];
				$model->postcode = $data[8];
				$model->landphone = $data[5];
				$model->email = $data[9];
				$model->simple_client = 1;
				$model->json_notes = json_encode([$columns, $data]);



				$model->parentid = $id;
				$model->mainclientid = $id;
				$model->createdtime = time();




				if ($_POST['Client']['bfirmid'] > 0) {
					$model->firmid = $_POST['Client']['bfirmid'];
				} else {


					if ($ax->branchid == 0) {
						$model->firmid = Client::model()->find(array('condition' => 'id=' . $id))->firmid;
					} else {
						$model->firmid = $ax->branchid;
					}
				}



				$firmm = Firm::model()->findByPk($model->firmid);
				// $results=Documents::model()->newFCsubdocument($firmm->parentid,$firmm->id,$id,0);///cliente hepsi diye eklenen dokümanlar

				$model->mainfirmid = $model->firmid;
				$model->username = $username;
				$model->save();

				$resultsadd = Documents::model()->newFCsubdocumentAdd($firmm->parentid, $firmm->id, $id == 0 ? $model->id : $id, $id != 0 ? $model->id : 0); ///yeni eklenen client e döküman yetkisi verildi


				if ($id == 0) {
					$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('firmbranch', $model->firmid) . "'"))->name;
				} else {
					$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('client', $id) . "'"))->name;
				}

				AuthItem::model()->createitem($pname . '.' . $username, 0);
				AuthItem::model()->generateparentpermission($pname . '.' . $username);

				if ($id == 0) {
					AuthItem::model()->createnewauth($pname, $username, 'Customer');
				} else {
					AuthItem::model()->createnewauth($pname, $username, 'Branch');
				}


				//post edilen yer clientse onun subeside otomatik kendi verilerinin aynısıyla ekleniyor.
				if ($id == 0) {
					$model2 = new Client;
					$model2->attributes = $_POST['Client'];
					$model2->name = $_POST['Client']['name'] . ' - Branch';
					$model2->parentid = $model->id;
					if ($_POST['Client']['bfirmid'] > 0) {
						$model2->firmid = $model->firmid;
					} else {
						$model2->firmid = $model->firmid;
					}

					$count = count(Client::model()->findAll(array('condition' => "username Like '%" . $username . "%'")));
					$username2 = $authuser . ($count + 1);
					$model2->username = $username2;
					$model2->mainfirmid = $model->firmid;
					$model2->mainclientid = $model->id;
					$model2->createdtime = time();

					// $results=Documents::model()->newFCsubdocument($firmm->parentid,$firmm->id,$model->id,0);///client bracnha hepsi diye eklenen dokümanlar

					$model2->save();
					$resultsadd = Documents::model()->newFCsubdocumentAdd($firmm->parentid, $firmm->id, $model->id, $model2->id); ///yeni eklenen client bracnha e döküman yetkisi verildi

					AuthItem::model()->createitem($pname . '.' . $username . '.' . $username2, 0);
					AuthItem::model()->generateparentpermission($pname . '.' . $username . '.' . $username2);
					AuthItem::model()->createnewauth($pname . '.' . $username, $username2, 'Branch');



					//loglama
					//	Logs::model()->logsaction();
					/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
					if ($_POST['Client']['bfirmid'] > 0) {
						//	Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
					} else {
						//	Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
					}
				}


				//loglama
				//	Logs::model()->logsaction();
				/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

				//	Yii::app()->SetFlashes->add($model,t('Create Success!'),array('view?id='.$id));
			}
			//

			//eger mevcut verinin aynısı post edilirse mevcut data mesajı verilir
			//	Yii::app()->user->setFlash('error', t($error.' previously used'));
			if ($id == 0) {
				if ($_POST['Client']['bfirmid'] > 0) {
					//	$this->redirect(array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
				} else {
					//		$this->redirect(array('index'));
				}
			} else {
				//	$this->redirect(array('view?id='.$id));
			}

		}

		fclose($file);




	}




	/// 
	public function actionCreate3($id = 0)
	{
		//main client import 
		exit;

		//$_POST['Client']['branchid']=1;
		echo 'ok';


		$authuser = '';
		$ax = User::model()->userobjecty('');

		// print_r($ax);
		$columns = [];
		$columns[] = ' main clienı';
		$columns[] = 'Commercial title';
		$columns[] = 'Tax Office';
		$columns[] = 'Tax No';
		$columns[] = 'Sector';
		$columns[] = 'Office No';
		$columns[] = 'Address';
		$columns[] = 'Town or City';
		$columns[] = 'Post Code';
		$columns[] = 'E-Mail';
		$columns[] = 'Active or passive ( a/p )';
		$columns[] = 'CUSTOMER / CONTACT NAME';
		$columns[] = 'CUSTOMER / CONTACT Surname';
		$columns[] = 'branch manager tel';
		$columns[] = 'Schedule';
		$columns[] = 'Description';
		$columns[] = 'Price';
		$columns[] = 'Total';
		$columns[] = 'Locationid';

		$file = fopen("a.csv", "r");

		while (($data = fgetcsv($file)) !== FALSE) {
			print_r($data);
			//    echo "email address " . $data[0];



			$firmname = Client::model()->userfirmname($_POST['Client']['bfirmid']);

			$authuser = Firm::model()->usernameproduce($data[0]);




			Yii::app()->getModule('authsystem');

			$model = new Client;


			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			if (trim($data[0]) == '') {
				$xnamexx = 'Client-' .
					(strlen($data[0]) + strlen($data[1]) + strlen($data[2]) + strlen($data[3]) + strlen($data[4]) + strlen($data[5]) + strlen($data[6]) + strlen($data[7]) + strlen($data[8]) + strlen($data[9]));
				$client = Client::model()->findAll(array(
					'condition' => 'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0',
					'params' => array('name' => $xnamexx, 'title' => $data[1], 'taxoffice' => $data[2], 'taxno' => $data[3], 'address' => $data[6], 'landphone' => $data[5], 'email' => $data[9])
				));

			} else {
				$client = Client::model()->findAll(array(
					'condition' => 'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0',
					'params' => array('name' => $data[0], 'title' => $data[1], 'taxoffice' => $data[2], 'taxno' => $data[3], 'address' => $data[6], 'landphone' => $data[5], 'email' => $data[9])
				));
			}




			if (count($client) == 0) {


				$count = count(Client::model()->findAll(array('condition' => "username Like '%" . $username . "%'")));
				$username = $authuser . ($count + 1);


				//$model->attributes=$_POST['Client'];
				// $model->client_code ='';
				$model->branchid = 19; // other tipi
				//$model->firmid =$data[1];
				// $model->mainclientid =$data[1];
				$model->country_id = 2;
				//  https://insectram.io/client/create2/7314
				if (trim($data[0]) == '') {
					$model->name = 'Client-' .
						(strlen($data[0]) + strlen($data[1]) + strlen($data[2]) + strlen($data[3]) + strlen($data[4]) + strlen($data[5]) + strlen($data[6]) + strlen($data[7]) + strlen($data[8]) + strlen($data[9]));
				} else {
					$model->name = $data[0];
				}

				$model->title = $data[1];
				$model->taxoffice = $data[2];
				$model->taxno = $data[3];
				$model->address = $data[6];
				$model->town_or_city = $data[7];
				$model->postcode = $data[8];
				$model->landphone = $data[5];
				$model->email = $data[9];
				//  $model->simple_client =1;
				$model->simple_client = 0;
				$model->json_notes = json_encode([$columns, $data]);



				$model->parentid = $id;
				$model->mainclientid = $id;
				$model->createdtime = time();




				if ($_POST['Client']['bfirmid'] > 0) {
					$model->firmid = $_POST['Client']['bfirmid'];
				} else {


					if ($ax->branchid == 0) {
						$model->firmid = Client::model()->find(array('condition' => 'id=' . $id))->firmid;
					} else {
						$model->firmid = $ax->branchid;
					}
				}



				$firmm = Firm::model()->findByPk($model->firmid);
				// $results=Documents::model()->newFCsubdocument($firmm->parentid,$firmm->id,$id,0);///cliente hepsi diye eklenen dokümanlar

				$model->mainfirmid = $model->firmid;
				$model->username = $username;
				$model->save();

				$resultsadd = Documents::model()->newFCsubdocumentAdd($firmm->parentid, $firmm->id, $id == 0 ? $model->id : $id, $id != 0 ? $model->id : 0); ///yeni eklenen client e döküman yetkisi verildi

				if ($id == 0) {
					$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('firmbranch', $model->firmid) . "'"))->name;
				} else {
					$pname = AuthItem::model()->find(array('condition' => "name Like '%" . User::model()->itemdelete('client', $id) . "'"))->name;
				}

				AuthItem::model()->createitem($pname . '.' . $username, 0);
				AuthItem::model()->generateparentpermission($pname . '.' . $username);

				if ($id == 0) {
					AuthItem::model()->createnewauth($pname, $username, 'Customer');
				} else {
					AuthItem::model()->createnewauth($pname, $username, 'Branch');
				}



				//post edilen yer clientse onun subeside otomatik kendi verilerinin aynısıyla ekleniyor.
				if ($id == 0) {
					$model2 = new Client;
					$model2->attributes = $model->attributes;
					$model2->name = $model->name . ' - Branch';
					$model2->parentid = $model->id;
					if ($_POST['Client']['bfirmid'] > 0) {
						$model2->firmid = $model->firmid;
					} else {
						$model2->firmid = $model->firmid;
					}

					$count = count(Client::model()->findAll(array('condition' => "username Like '%" . $username . "%'")));
					$username2 = $authuser . ($count + 1);
					$model2->username = $username2;
					$model2->mainfirmid = $model->firmid;
					$model2->mainclientid = $model->id;
					$model2->createdtime = time();
					$model2->json_notes = json_encode([$columns, $data]);

					// $results=Documents::model()->newFCsubdocument($firmm->parentid,$firmm->id,$model->id,0);///client bracnha hepsi diye eklenen dokümanlar

					$model2->save();
					$resultsadd = Documents::model()->newFCsubdocumentAdd($firmm->parentid, $firmm->id, $model->id, $model2->id); ///yeni eklenen client bracnha e döküman yetkisi verildi

					AuthItem::model()->createitem($pname . '.' . $username . '.' . $username2, 0);
					AuthItem::model()->generateparentpermission($pname . '.' . $username . '.' . $username2);
					AuthItem::model()->createnewauth($pname . '.' . $username, $username2, 'Branch');



					//loglama
					//	Logs::model()->logsaction();
					/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
					if ($_POST['Client']['bfirmid'] > 0) {
						//	Yii::app()->SetFlashes->add($model,t('Create Success!'),array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
					} else {
						//	Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index'));
					}
				}


				//loglama
				//	Logs::model()->logsaction();
				/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

				//	Yii::app()->SetFlashes->add($model,t('Create Success!'),array('view?id='.$id));
			}
			//

			//eger mevcut verinin aynısı post edilirse mevcut data mesajı verilir
			//	Yii::app()->user->setFlash('error', t($error.' previously used'));
			if ($id == 0) {
				if ($_POST['Client']['bfirmid'] > 0) {
					//	$this->redirect(array('/firm/client?type=branch&&id='.$_POST['Client']['bfirmid']));
				} else {
					//		$this->redirect(array('index'));
				}
			} else {
				//	$this->redirect(array('view?id='.$id));
			}

		}

		fclose($file);




	}



	public function actionTumunugetir()
	{
		$model = Monitoring::model()->findAll(array('condition' => 'active=1 and clientid=' . $_GET["id"], 'order' => 'mtypeid asc'));
		$yaz = '';
		$bfr = 0;
		foreach ($model as $modelx) {
			$type = Monitoringtype::model()->findByPk($modelx->mtypeid);

			$yaz = $yaz . '<option value="' . $modelx->id . '">' . $modelx->mno . ' - ' . $type->name . '</option>';




		}
		echo $yaz;
	}

	public function actionShowbarcodes()
	{
		$sql = "";
		if (isset($_POST["Monitoring"]["clientid"])) {

			if ($_POST["Monitoring"]["dapartmentid"] != "") {
				$sql = $sql . " and dapartmentid=" . $_POST["Monitoring"]["dapartmentid"];
			}
			if ($_POST["Monitoring"]["subid"] != "" && $_POST["Monitoring"]["subid"] != 0) {
				$sql = $sql . " and subid=" . $_POST["Monitoring"]["subid"];

			}
			if ($_POST["Monitoring"]["mlocationid"] != "") {
				$sql = $sql . " and mlocationid=" . $_POST["Monitoring"]["mlocationid"];

			}
			if ($_POST["Monitoring"]["mtypeid"] != "") {
				$sql = $sql . " and mtypeid=" . $_POST["Monitoring"]["mtypeid"];

			}

			if ($_POST["Monitoring"]["mno"] != "") {
				$aradeger = explode('-', $_POST["Monitoring"]["mno"]);
				if (count($aradeger) == 2) {
					if ($aradeger[0] < $aradeger[1]) {
						$sql = $sql . " and mno>=" . $aradeger[0] . " and mno<=" . $aradeger[1];
					} else if ($aradeger[0] > $aradeger[1]) {
						$sql = $sql . " and mno>=" . $aradeger[1] . " and mno<=" . $aradeger[0];
					} else {
						$sql = $sql . " and mno" . $aradeger[0];
					}

				} else {
					$sql = $sql . " and mno in (" . $_POST["Monitoring"]["mno"] . ')';
				}




			}
			$sql = $sql . " and active=" . $_POST["Monitoring"]["active"];

			// echo $sql;
			$monitors = Monitoring::model()->findAll(array('condition' => 'clientid=' . $_POST["Monitoring"]["clientid"] . $sql, 'order' => 'mno asc'));
			$ids = array();
			$monitorno = array();
			$monitorolurturma = 0;
			foreach ($monitors as $monitor) {
				if ($monitor->barcodeno == '' || $monitor->barcodeno == 0) {
					$model = Monitoring::model()->findByPk($monitor->id);
					$dynamicstring = time() + rand(0, 999999) + round(microtime(true) * 1000);
					$model->barcodeno = Monitoring::model()->barkodeControl($dynamicstring);
					$model->save();
					$monitor->barcodeno = $model->barcodeno;
				}
				array_push($ids, $monitor->barcodeno);
				array_push($monitorno, $monitor->mno);
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



		if ($id == 0) {
			$id = $_POST['Client']['id'];

		}
		$model = $this->loadModel($id);


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Client'])) {
			$model->attributes = $_POST['Client'];
			if (isset($_POST['Client']['simple_client'])) {
				$model->simple_client = $_POST['Client']['simple_client'];
			}
			if ($model->save()) {
				//loglama
				Logs::model()->logsaction();

				if ($_POST['Client']['parentid'] == 0) {
					$client = Client::model()->findByPk($_POST['Client']['id']);
					$firmbranch = Firm::model()->findByPk($client->firmid);
					$firm = Firm::model()->findByPk($firmbranch->parentid);

					$yetki = $firm->package . '.' . $firm->username . '.' . $firmbranch->username . '.' . $client->username;

					$yetkiBul = AuthItem::model()->findAll(array(
						#'select'=>'',
						#'limit'=>'5',
						#'order'=>'name ASC',
						'condition' => 'name="' . $yetki . '"',
					));

					if (empty($yetkiBul)) {
						AuthItem::model()->createitem($yetki, 0);
						AuthItem::model()->generateparentpermission($yetki);
						AuthItem::model()->createnewauth($firm->package . '.' . $firm->username . '.' . $firmbranch->username, $client->username, 'Customer');



					}

					if ($_POST['Client']['bfirmid'] > 0) {
						Yii::app()->SetFlashes->add($model, t('Update Success!'), array('/firm/client?type=branch&&id=' . $_POST['Client']['bfirmid']));
					}

					/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/


					Yii::app()->SetFlashes->add($model, t('Update Success!'), array('index', 'id' => $model->id));
				} else {

					$clientBranch = Client::model()->findByPk($_POST['Client']['id']);
					$client = Client::model()->findByPk($_POST['Client']['parentid']);
					$firmbranch = Firm::model()->findByPk($client->firmid);
					$firm = Firm::model()->findByPk($firmbranch->parentid);

					$yetki = $firm->package . '.' . $firm->username . '.' . $firmbranch->username . '.' . $client->username . '.' . $clientBranch->username;

					$yetkiBul = AuthItem::model()->findAll(array(
						#'select'=>'',
						#'limit'=>'5',
						#'order'=>'name ASC',
						'condition' => 'name="' . $yetki . '"',
					));

					if (empty($yetkiBul)) {
						AuthItem::model()->createitem($yetki, 0);
						AuthItem::model()->generateparentpermission($yetki);
						AuthItem::model()->createnewauth($firm->package . '.' . $firm->username . '.' . $firmbranch->username . '.' . $client->username, $clientBranch->username, 'Branch');


					}

					Yii::app()->SetFlashes->add($model, t('Update Success!'), array('view?id=' . $_POST['Client']['parentid'] . "&firmid=" . $client->firmid));
					/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
					//Yii::app()->SetFlashes->add($model,t('Update Success!'),array('view','id'=>$_POST['Client']['parentid']));

				}
			}
		}


		/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/
		Yii::app()->SetFlashes->add($model, t('Update Success!'), array('index', 'id' => $model->id));
		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		if ($id == 0) {
			$id = $_POST['Client']['id'];

		}


		$post = Client::model()->findByPk($id);


		$client = Client::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			#'order'=>'name ASC',
			'condition' => 'parentid=' . $id,
		));
		$clientIds = array($id); // örn. [6721]
		foreach ($client as $clients) {
			$clientIds[] = $clients->id;
		}
		$placeholders = implode(',', $clientIds);

		$workorder = Workorder::model()->findAll(array(
			'condition' => 'clientid in (' . $placeholders . ')',
		));
		if (count($workorder) > 0) {
			Yii::app()->user->setFlash('error', t('The more active business plan cannot be deleted because it exists.!'));

			if ($_POST['Client']['parentid'] == 0) {
				if ($_POST['Client']['bfirmid'] > 0) {
					$this->redirect(array('/firm/client?type=branch&&id=' . $_POST['Client']['bfirmid']));
				}
				$this->redirect(array('index'));
			} else {
				$this->redirect(array('view', 'id' => $_POST['Client']['parentid']));
			}
		}


		//////////////// workorder yoksa
		$post->isdelete = '1';
		$post->update();
		foreach ($client as $clients) {
			$post = Client::model()->findByPk($clients->id);
			$post->isdelete = '1';
			$post->update();

		}

		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			/* Hataları sadece alttaki setflashes classı ile ayıklıyoruz!!! :)))*/

			if ($_POST['Client']['parentid'] == 0) {

				User::model()->deleteAll(array('condition' => 'clientid=:id', 'params' => array('id' => $id)));

				AuthItem::model()->deleteAll(array('condition' => "name Like '%" . User::model()->itemdelete('client', $id) . "%'"));

				//loglama
				Logs::model()->logsaction();

				if ($_POST['Client']['bfirmid'] > 0) {
					Yii::app()->SetFlashes->add($post, t('Delete Success!'), array('/firm/client?type=branch&&id=' . $_POST['Client']['bfirmid']));
				}

				Yii::app()->SetFlashes->add($post, t('Delete Success!'), array('index'));
			} else {

				User::model()->deleteAll(array('condition' => 'clientbranchid=:id', 'params' => array('id' => $id)));

				AuthItem::model()->deleteAll(array('condition' => "name Like '%" . User::model()->itemdelete('clientbranch', $id) . "%'"));
				//loglama
				Logs::model()->logsaction();
				Yii::app()->SetFlashes->add($post, t('Delete Success!'), array('view', 'id' => $_POST['Client']['parentid']));
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (isset($_POST['clientid'])) {
			$guncelle = Client::model()->changeactive($_POST['clientid'], $_POST['active']);
			if (!$guncelle) {
				echo "hata";
			} else {
				echo "kaydedildi";
			}

		}

		$dataProvider = new CActiveDataProvider('Client');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionReportcreate()
	{
		$url = Yii::app()->basepath . "/views/client/NDg/PdfTemplate/";
		$html = "test";
		$zipname = "test.zip";
		if ($_POST['Report']['type'] == 2) {

			$this->render("NDg/chartreports");

			// $this->redirect('/client/chartreports/2');
		} else if ($_POST['Report']['type'] == 1) {

			Yii::import('application.modules.pdf.components.pdf.mpdf');
			$html = "test";

			$mpdf = new \Mpdf\Mpdf();
			$url = Yii::app()->basepath . "/views/client/NDg/PdfTemplate/";
			set_time_limit(2000);


			ini_set("pcre.backtrack_limit", "1000000");

			if (in_array($_POST['Monitoring']['mtypeid'], [6])) {
				include($url . "pdf-cl.php");
				//$mpdf->SetHTMLHeader('');
				$mpdf->WriteHTML($html);
			}
			// else if (in_array($_POST['Monitoring']['mtypeid'],[27])) {
			// include($url . "pdf-id.php");
			// $mpdf->WriteHTML($html);
			// }
			else if (in_array($_POST['Monitoring']['mtypeid'], [8, 20, 21, 2, 23])) {
				include($url . "pdf-lt.php");
				$mpdf->WriteHTML($html);
			} else if (in_array($_POST['Monitoring']['mtypeid'], [9, 28, 27])) {
				include($url . "pdf-mt.php");
				$mpdf->WriteHTML($html);
			} else if (in_array($_POST['Monitoring']['mtypeid'], [10, 24, 25, 26, -100, 30, 32, 33])) {
				include($url . "pdf-rm.php");
				$mpdf->WriteHTML($html);
			} else if (in_array($_POST['Monitoring']['mtypeid'], [12, 19])) {
				if (isset($_COOKIE["testi"])) {
					include($url . "pdf-efk.php");
				} else {
					include($url . "pdf-efk.php");
				}

				$mpdf->WriteHTML($html);
			}
			// else if ($_POST['Monitoring']['mtypeid'] == 19) {//EFK UK
			// include($url . "pdf-efk-uk.php");
			// $mpdf->WriteHTML($html);
			// }
			// else if ($_POST['Monitoring']['mtypeid'] == 20 || $_POST['Monitoring']['mtypeid'] == 21 || $_POST['Monitoring']['mtypeid'] == 22 || $_POST['Monitoring']['mtypeid'] == 23 ) {// LTler  UK
			// include($url . "pdf-lt.php");
			// $mpdf->WriteHTML($html);
			// }
			// else if ($_POST['Monitoring']['mtypeid'] == 24 || $_POST['Monitoring']['mtypeid'] == 25 || $_POST['Monitoring']['mtypeid'] == 26 ) {// LTler  UK
			// include($url . "pdf-rm.php");
			// $mpdf->WriteHTML($html);
			// }
			// else if ($_POST['Monitoring']['mtypeid'] == 27) {// LTler  UK
			// include($url . "pdf-cl.php");
			// $mpdf->WriteHTML($html);
			// }
			// else if ($_POST['Monitoring']['mtypeid'] == 28) {// LTler  UK
			// include($url . "pdf-mt.php");
			// $mpdf->WriteHTML($html);
			// }
			else if ($_POST['Monitoring']['mtypeid'] == 29) {// LTler  UK
				include($url . "pdf-wp.php");
				$mpdf->WriteHTML($html);
			}


			//$mpdf->setHTMLHeader("das", '', true);

			// Output a PDF file directly to the browser

			//$mpdf->Output("aaa.pdf", "D");
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

			$mpdf->Output();
			exit;
		} else if ($_POST['Report']['type'] == 3) {
			$this->render("NDg/totalnumberofpests");
		} else if ($_POST['Report']['type'] == 4) {
			$this->render("NDg/excelreport");
		} else if ($_POST['Report']['type'] == 5) {
			$this->render("NDg/singlemonitor");
		} else if ($_POST['Report']['type'] == 42) {
			$this->render("NDg/trendanalizi");
		} else if ($_POST['Report']['type'] == 6) {
			Yii::import('application.modules.pdf.components.pdf.mpdf');
			include($url . "pdf-products.php");
			$mpdf = new mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

			$mpdf->Output();
			exit;
		} else if ($_POST['Report']['type'] == 40) {// alan kontrol raporu

			Yii::import('application.modules.pdf.components.pdf.mpdf');
			include($url . "alan_kontrol_raporu.php");
			$mpdf = new mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

			$mpdf->Output();
			exit;

		} else if ($_POST['Report']['type'] == 7) {
			Yii::import('application.modules.pdf.components.pdf.mpdf');
			include($url . "pdf-in-activity.php");
			$mpdf = new mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

			$mpdf->Output();
			exit;
		} else if ($_POST['Report']['type'] == 98) {
			$this->render("NDg/activitybenchmarkreport");
		} else if ($_POST['Report']['type'] == 13) {
			/*	 Yii::import('application.modules.pdf.components.pdf.mpdf');
				 include($url . "pdf-service-reports.php");
				 $mpdf = new mpdf();
				 $mpdf->WriteHTML($html);
				 $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

				 $mpdf->Output();
				 exit;
		  */
			$this->render("NDg/PdfTemplate/pdf-service-reports");
		} else if ($_POST['Report']['type'] == 8) {
			$this->render("NDg/departmentreports");
		} else if ($_POST['Report']['type'] == 9) {
			Yii::import('application.modules.pdf.components.pdf.mpdf');
			include($url . "workorderReport.php");
			$mpdf = new mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

			$mpdf->Output();
			exit;


		} else if ($_POST['Report']['type'] == 21) {
			include(Yii::app()->basepath . "/views/client/NDg/exel/workorderReportexcel.php");

			exit;


		} else if ($_POST['Report']['type'] == 99) {

			$tarih1 = $_POST['Monitoring']['date'];
			$tarih2 = $_POST['Monitoring']['date1'];
			$midnight = strtotime("today", strtotime($tarih1));
			$midnight2 = strtotime("today", strtotime($tarih2) + 3600 * 24);
			$idler = implode(',', $_POST['Report']['clientid']);
			$forms = Workorder::model()->findAll(array('condition' => 'clientid in (' . $idler . ') and (realendtime between ' . $midnight . ' and ' . $midnight2 . ')'));
			$idler = [];
			if (is_countable($forms) && count($forms) > 0) {

			} else {
				$clients = Client::model()->findAll(array('condition' => 'parentid = ' . $_POST['Report']['client']));
				$idler = [];
				foreach ($clients as $item) {
					$idler[] = $item->id;
				}
				if (is_countable($idler) && count($idler) > 0) {
				} else {
					echo 'client bulunamadı!';
					exit;
				}
				$idler = implode(',', $idler);
				$forms = Workorder::model()->findAll(array('condition' => 'clientid in (' . $idler . ') and (realendtime between ' . $midnight . ' and ' . $midnight2 . ')'));
			}
			$idler = [];
			foreach ($forms as $item) {
				$idler[$item->id] = array($item->id, $item->date . '-' . $item->id);
				$idler['ids'][] = $item->id;
			}

			$workidler = $idler['ids'];
			if (is_countable($workidler) && count($workidler) > 0) {

			} else {
				echo 'Seçilen tarih aralığında workorder bulunamadı!';
				exit;
			}

			$workidler = implode(',', $workidler);
			$forms = Servicereport::model()->findAll(array('condition' => 'reportno in (' . $workidler . ') and LENGTH (picture)>5'));
			$files = [];
			foreach ($forms as $item) {
				$files[] = [$item->picture, $idler[$item->reportno][1]];
			}

			if (is_countable($files) && count($files) > 0) {
			} else {
				echo 'Servis formu resmi bulunamadı!';
				exit;
			}

			$zip = new ZipArchive;
			$tmp_file = 'testxxx.zip';
			if (file_exists($tmp_file))
				unlink($tmp_file);
			if ($zip->open($tmp_file, ZipArchive::CREATE)) {
				$i = 0;
				foreach ($files as $file) {
					$i++;
					$zip->addFile('/home/ioinsectram/public_html' . $file[0], $file[1] . '.png');
				}
				$zip->close();
				$file2name = $_POST['Monitoring']['date'] . ' - ' . $_POST['Monitoring']['date1'];
				header("Content-disposition: attachment; filename=$file2name.zip");
				header('Content-type: application/zip');
				readfile($tmp_file);
			} else {
				echo 'Arşiv oluştururken hata!';
				exit;
			}


			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename=' . $zipname);
			header('Content-Length: ' . filesize($zipname));
			readfile('/home/ioinsectram/public_html/' . $zipname);
			exit;


		} else if ($_POST['Report']['type'] == 20) {
			include(Yii::app()->basepath . "/views/firm/NDg/excel/faturaExcel.php");
			exit;
		} else if ($_POST['Report']['type'] == 41) {

			// Yii::import('application.modules.pdf.components.pdf.mpdf');
			// include($url . "pestisitpdf.php");
			// $mpdf = new mpdf();
			// $mpdf->WriteHTML($html);
			// $mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');

			// $mpdf->Output();
			// exit;




			Yii::import('application.modules.pdf.components.pdf.mpdf');
			$html = "test";

			$mpdf = new \Mpdf\Mpdf();
			$url = Yii::app()->basepath . "/views/client/NDg/PdfTemplate/";
			set_time_limit(2000);


			ini_set("pcre.backtrack_limit", "1000000");
			include($url . "pestisitpdf.php");
			//$mpdf->SetHTMLHeader('');
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
			// include(Yii::app()->basepath."/views/client/NDg/exel/pestisitexcel.php");
			// exit;
		} else if ($_POST['Report']['type'] == 10) {



			if (in_array($_POST['Monitoring']['mtypeid'], [6])) {
				include(Yii::app()->basepath . "/views/client/NDg/exel/clexel.php");
				exit;
			} else if (in_array($_POST['Monitoring']['mtypeid'], [8, 20, 21, 2, 23])) {
				include(Yii::app()->basepath . "/views/client/NDg/exel/ltexel.php");
				exit;
			} else if (in_array($_POST['Monitoring']['mtypeid'], [9, 28, 27])) {
				//$this->render("NDg/exel/mtexel");
				include(Yii::app()->basepath . "/views/client/NDg/exel/mtexel.php");

				exit;
			} else if (in_array($_POST['Monitoring']['mtypeid'], [10, 24, 25, 26, -100, 30, 32, 33])) {
				include(Yii::app()->basepath . "/views/client/NDg/exel/rmexel.php");

				exit;
			} else if (in_array($_POST['Monitoring']['mtypeid'], [12, 19])) {
				include(Yii::app()->basepath . "/views/client/NDg/exel/efkexel.php");
				exit;

			}
		} else if ($_POST['Report']['type'] == 11) {
			$client = Client::model()->find(array("condition" => "id=" . $_POST['Report']['clientid']))->parentid;

			$fbid = Client::model()->find(array("condition" => "id=" . $client))->firmid;

			$firmid = Firm::model()->find(array("condition" => "id=" . $fbid))->parentid;

			$country = Firm::model()->find(array("condition" => "id=" . $firmid))->country_id;
			$ax = User::model()->userobjecty('');

			/* if($ax->id==1 || $ax->id==317)
			{
				$this->render("NDg/aktivitereportsgrafik_ingiltere_m");
				}
				*/
			if ($country == 2) {
				$this->render("NDg/aktivitereportsgrafik_ingiltere_m");
			} else {
				$this->render("NDg/aktivitereportsgrafik");
			}

		}
	}




	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Client('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Client']))
			$model->attributes = $_GET['Client'];

		$this->render('admin', array(
			'model' => $model,
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
		$model = Client::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}


	public function actionSubdepartments()
	{
		$departments2 = Departments::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'parentid ASC',
			'condition' => 'parentid in (' . $_GET['id'] . ')',
		));

		$ax = User::model()->userobjecty('');
		if ($ax->mainclientbranchid != $ax->clientbranchid) {
			$departments2 = Yii::app()->db->createCommand(
				'SELECT * FROM departments INNER JOIN departmentpermission ON departmentpermission.clientid=departments.clientid WHERE departmentpermission.departmentid=departments.parentid and departmentpermission.subdepartmentid=departments.id and departments.parentid=' . $_GET['id'] . ' and departmentpermission.userid=' . $ax->id
			)->queryAll();

		}
		?>

		<option value="0"><?= t('Select'); ?></option>
		<?php foreach ($departments2 as $department):
			$departmentname = Departments::model()->find(array(
				'order' => 'parentid ASC',
				'condition' => 'id=' . $department->parentid,
			))->name;
			?>
			<option value="<?= $department['id']; ?>"><?= $department['name'] . ' - ' . $departmentname; ?></option>
		<? endforeach; ?>


		<?

		exit;
	}

	public function actionSubdepartments2()
	{
		$departments2 = Departments::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'name ASC',
			'condition' => 'parentid=' . $_GET['id'],
		));
		?>



		<label for="basicSelect"><?= t('Sub-Department'); ?></label>
		<fieldset class="form-group">
			<select class="custom-select block" id="customSelect" name="Monitoring[subid]">
				<option value="0"><?= t('Select'); ?></option>
				<?php foreach ($departments2 as $department): ?>
					<option value="<?= $department->id; ?>" <? if (isset($_GET['sub']) && $_GET['sub'] == $department->id) {
						  echo 'selected';
					  } ?>><?= $department->name; ?></option>
				<? endforeach; ?>
			</select>
		</fieldset>

		<?

		exit;
	}

	public function actionStaffsearch()
	{
		$user = Yii::app()->db->createCommand()
			->from('staffteamlist l')
			->join('user u', 'u.id=l.userid')
			->join('userinfo i', 'i.id=u.id')
			->where("l.branchid='" . $_GET['id'] . "' and CONCAT_WS(' ',u.name,u.surname ) LIKE '%" . $_GET['ara'] . "%'")
			->queryall();


		for ($i = 0; $i < count($user); $i++) { ?>

			<div class="col-xl-3 col-md-6 col-12">
				<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">
					<div class="text-center">

						<? if ($user[$i]['active'] == 1) { ?>
							<a class="btn btn-success btn-sm" style='float:right;color:#fff'><?= t('Active'); ?> </a>
						<? } else { ?> <a class="btn btn-danger btn-sm" style='float:right;color:#fff'><?= t('Passive'); ?>
							</a><? } ?>


						<div class="card-body">
							<img src="<? if ($user[$i]['gender'] == 0) { ?><?= Yii::app()->theme->baseUrl . '/app-assets/images/staff-logo-mr.png'; ?><? } else { ?><?= Yii::app()->theme->baseUrl . '/app-assets/images/staff-logo-mrs.png'; ?><? } ?>"
								class="rounded-circle  height-150" alt="Card image">
						</div>
						<div class="card-body">
							<h4 class="card-title"><?= $user[$i]['name'] . ' ' . $user[$i]['surname']; ?></h4>
							<h6 class="card-subtitle text-muted"><?= $user[$i]['primaryphone']; ?></h6>
						</div>
						<div class="text-center" style="margin-bottom:10px">
							<a class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?= $user[$i]['userid']; ?>"
								data-username="<?= $user[$i]['username']; ?>" data-name="<?= $user[$i]['name']; ?>"
								data-surname="<?= $user[$i]['surname']; ?>" data-email="<?= $user[$i]['email']; ?>"
								data-password="<?= $user[$i]['password']; ?>" data-birthplace="<?= $user[$i]['birthplace']; ?>"
								data-birthdate="<?= $user[$i]['birthdate']; ?>" data-gender="<?= $user[$i]['gender']; ?>"
								data-phone="<?= $user[$i]['primaryphone']; ?>" data-userid="<?= $user[$i]['userid']; ?>"><i
									style="color:#fff;" class="fa fa-edit"></i></a>

							<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?= $user[$i]['id']; ?>"
								data-userid="<?= $user[$i]['userid']; ?>"><i style="color:#fff;" class="fa fa-trash"></i></a>
						</div>
					</div>
				</div>
			</div>
		<? }

	}


	public function actionLivesearch()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user !== null) {

		} else {
			echo 2;
			Yii::app()->user->logout();
			exit;
		}

		?>

		<div id='show' class="dropdown-menu dropdown-menu-media  vertical-scroll scroll-example height-300">
			<li class="dropdown-menu-header">
				<h6 class="dropdown-header m-0">
					<span class="grey darken-2">Arama Sonuçları</span>


					<span class="notification-tag badge badge-default badge-danger float-right m-0" id="deger1"
						style="display:none;">0 yeni</span>
				</h6>
			</li>

			<?

			Client::model()->urlfirm($_GET["q"]);


			?>

			</ul>


		<? }




	public function actionDepartmentpermission()
	{ ?>

			<div class='row'>
				<? $department = Departments::model()->findAll(array('condition' => 'parentid=0 and clientid=' . $_GET['id']));
				foreach ($department as $departmentx) {

					$dpermission = Departmentpermission::model()->find(array('condition' => 'clientid=' . $_GET['id'] . ' and departmentid=' . $departmentx->id . ' and subdepartmentid=0 and userid=' . $_GET['user']));
					?>

					<div class='col-xl-12 col-lg-12 col-md-12 mb-1 sdepartment'>
						<div class='row department'>
							<div class='col-xl-6 col-lg-6 col-md-6 mb-1 departmentbaslik'>
								<?= $departmentx->name; ?>
							</div>
							<div class='col-xl-6 col-lg-6 col-md-6 mb-1'>
								<input type="checkbox" <? if (!empty($dpermission)) {
									echo 'checked';
								} ?> id="switchery2"
									data-size="sm" data-clientid='<?= $_GET['id']; ?>' data-department='<?= $departmentx->id; ?>'
									data-subdepartment='0' class="switchery2">
							</div>
						</div>

						<? $subdepartment = Departments::model()->findAll(array('condition' => 'parentid=' . $departmentx->id));

						if (!empty($subdepartment)) { ?>
							<div class='col-xl-12 col-lg-12 col-md-12 mb-1'>
								<div class='row'>
									<?
									foreach ($subdepartment as $subdepartmentx) {
										$spermission = Departmentpermission::model()->find(array('condition' => 'clientid=' . $_GET['id'] . ' and departmentid=' . $departmentx->id . ' and subdepartmentid=' . $subdepartmentx->id . ' and userid=' . $_GET['user']));
										?>
										<div class='col-xl-3 col-lg-3 col-md-3 mb-1'>

											<div class='col-xl-12 col-lg-12 col-md-12 mb-1 dpartmentbaslik'>
												<?= $subdepartmentx->name; ?>
											</div>
											<div class='col-xl-12 col-lg-12 col-md-12 mb-1 dpartmentbaslik'>
												<input type="checkbox" <? if (!empty($spermission)) {
													echo 'checked';
												} ?> id="switchery2"
													data-size="sm" class="switchery2" data-clientid='<?= $_GET['id']; ?>'
													data-department='<?= $departmentx->id; ?>'
													data-subdepartment='<?= $subdepartmentx->id; ?>'>
											</div>
										</div>
									<? } ?>
								</div>
							</div>

						<? } ?>
					</div>

				<? } ?>
			</div>

		<? }


	public function actionMaps($id)
	{
		if (isset($_POST['id'])) {
			$guncelle = Maps::model()->changeactive($_POST['id'], $_POST['active']);

			if (!$guncelle) {
				echo "hata";
			} else {
				echo "kaydedildi";
			}
			exit;
		}


		$this->render('NDg/maps', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionMapsuser($id)
	{

		$this->render('NDg/mapsuser', array(
			'model' => $this->loadModel($id),
		));
	}





	public function actionMapsupdate($id)
	{

		if (isset($_POST['Maps']['id'])) {

			$model = Maps::model()->findByPk($_POST['Maps']['id']);
			$model->points = $_POST['Maps']['points'];
			if ($model->save()) {
				echo 'ok';
				exit;

			} else {
				echo 'no';
				exit;
			}
		}


		$this->render('NDg/mapsupdate', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionMapsupdate2($id)
	{

		if (isset($_POST['Maps']['id'])) {

			$model = Maps::model()->findByPk($_POST['Maps']['id']);
			$model->points = $_POST['Maps']['points'];
			if ($model->save()) {
				echo 'ok';
				exit;

			} else {
				echo 'no';
				exit;
			}
		}


		$this->render('NDg/mapsupdate2', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionMaplist($id)
	{
		$ax = User::model()->userobjecty('');
		$maps = array(); // Initialize to empty array
		$maps = Maps::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'condition' => 'client_id=' . $id,
		));

		?>
			<table class="table table-striped table-bordered dataex-html5-export table-responsive">
				<thead>
					<tr>
						<th style='width:1px;'><input type="checkbox" name="select_all" value="1" id="select_all"></th>
						<th><?= mb_strtoupper(t('Map Name')); ?></th>
						<th><?= mb_strtoupper(t('Map Created Date')); ?></th>

						<th><?= t('IS ACTIVE'); ?></th>
						<?php if (Yii::app()->user->checkAccess('client.maps.update') || Yii::app()->user->checkAccess('client.maps.delete') || ($ax->id == 0 || $ax->id = 317 || $ax->id = 588)) { ?>
							<th> <?= mb_strtoupper(t('Process')); ?></th>
						<? } ?>


					</tr>
				</thead>
				<tbody>


					<?php foreach ($maps as $map): ?>




						<tr>
							<td><input type="checkbox" name="Maps[id][]" class='sec' value="<?= $map['id']; ?>"></td>
							<td><?= $map->map_name; ?></td>
							<td><?= $map->created_date; ?></td>



							<td>

								<div class="form-group pb-1">
									<input type="checkbox" data-size="sm" id="switchery" class="switchery"
										data-id="<?= $map['id']; ?>" <? if ($map['is_active'] == 1) {
											  echo "checked";
										  }
										  if (Yii::app()->user->checkAccess('client.maps.update') || ($ax->id == 0 || $ax->id = 317 || $ax->id = 588)) {
										  } else {
											  echo ' disabled';
										  } ?> />
								</div>

							</td>




							<td>


								<?php if (Yii::app()->user->checkAccess('client.maps.update') || ($ax->id == 0 || $ax->id = 317 || $ax->id = 588)) { ?>
									<a class="btn btn-warning btn-sm" onclick="openmodal(this)" data-id="<?= $map['id']; ?>"
										data-name="<?= $map['map_name']; ?>" data-created_date="<?= $map['created_date']; ?>"
										data-is_active="<?= $map['is_active']; ?>" data-toggle="tooltip" data-placement="top" title=""
										data-original-title="<?= t('Update'); ?>"><i style="color:#fff;" class="fa fa-edit"></i></a>

								<? } ?>

								<?php if (Yii::app()->user->checkAccess('client.maps.delete') || ($ax->id == 0 || $ax->id = 317 || $ax->id = 588)) { ?>


									<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-id="<?= $map['id']; ?>"
										data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= t('Delete'); ?>"><i
											style="color:#fff;" class="fa fa-trash"></i></a>

								<? } ?>



							</td>


						</tr>


					<?php endforeach; ?>

				</tbody>
				<tfoot>
					<tr>

						<th style='width:1px;'>
							<?php if (Yii::app()->user->checkAccess('client.map.delete') || ($ax->id == 0 || $ax->id = 317 || $ax->id = 588)) { ?>
								<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
									<button onclick='deleteall()' class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip"
										data-placement="top" title="" data-original-title="<?= t('Delete selected'); ?>"><i
											class="fa fa-trash"></i></button>
								</div>
							<? } ?>
						</th>

						<th><?= mb_strtoupper(t('Map Name')); ?></th>
						<th><?= mb_strtoupper(t('Map Created Date')); ?></th>
						<th><?= t('IS ACTIVE'); ?></th>
						<?php if (Yii::app()->user->checkAccess('client.maps.update') || Yii::app()->user->checkAccess('client.maps.delete') || ($ax->id == 0 || $ax->id = 317 || $ax->id = 588)) { ?>
							<th> <?= mb_strtoupper(t('Process')); ?></th>
						<? } ?>

				</tfoot>
			</table>

			<?
	}


	public function actionMapcreate()
	{
		date_default_timezone_set('Europe/Istanbul');

		$map = Maps::model()->findAll(array(
			#'select'=>'',
			#'limit'=>'5',
			'order' => 'map_name ASC',
			'condition' => 'map_name="' . $_POST['Maps']['name'] . '" and client_id=' . $_POST['Maps']['client_id'],
		));

		if (empty($map)) {
			$model = new Maps();
			$model->map_name = $_POST['Maps']['name'];
			$model->points = '"[]"';
			$model->created_date = date('Y-m-d H:i:s');
			$model->is_active = $_POST['Maps']['is_active'];
			$model->client_id = $_POST['Maps']['client_id'];
			if ($model->save()) {
				echo 'ok';
				exit;
			}
			echo t('Ekleme sırasında hata oluştu');
			exit;
		}
		echo t('Bu harita daha önceden eklenmiş');
		exit;

	}

	public function actionMapupdate()
	{



		$model = Maps::model()->findByPk($_POST['Maps']['id']);
		$model->map_name = $_POST['Maps']['name'];
		$model->is_active = $_POST['Maps']['active'];
		//$model->points=$_POST['Maps']['points'];
		if ($model->save()) {
			//	echo 'ok';exit;

		} else {
			//     echo 'no';exit;
		}

		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/


		Yii::app()->SetFlashes->add(0, t('Bu harita daha önceden eklenmiş'), array('/client/maps?id=' . $_POST['Maps']['client_id']));
		$this->redirect(array('/client/maps?id=' . $_POST['Maps']['client_id']));
	}

	public function actionMapupdatenew()
	{



		$model = Maps::model()->findByPk($_POST['map_id']);
		$model->points = json_encode($_POST['shapes'], true);
		$model->canvasSize = json_encode($_POST['canvasSize'], true);
		$model->mapBackgroundImage = json_encode($_POST['mapBackgroundImage'], true);
		$model->imageSize = json_encode($_POST['imageSize'], true);
		if ($model->save()) {
			echo 'ok';
			exit;

		} else {
			echo 'no';
			exit;
		}

		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/


		Yii::app()->SetFlashes->add(0, t('Bu harita daha önceden eklenmiş'), array('/client/maps?id=' . $_POST['Maps']['client_id']));
		$this->redirect(array('/client/maps?id=' . $_POST['Maps']['client_id']));
	}

	public function actionMapupdatenewpoints()
	{



		$model = Maps::model()->findByPk($_POST['map_id']);
		$model->monitor = json_encode($_POST['points'], true);
		if ($model->save()) {
			echo 'ok';
			exit;

		} else {
			echo 'no';
			exit;
		}

		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/


		Yii::app()->SetFlashes->add(0, t('Bu harita daha önceden eklenmiş'), array('/client/maps?id=' . $_POST['Maps']['client_id']));
		$this->redirect(array('/client/maps?id=' . $_POST['Maps']['client_id']));
	}


	public function actionMapsmonitorcreate($id)
	{
		if (isset($_POST['Maps']['id'])) {

			$model = Maps::model()->findByPk($_POST['Maps']['id']);
			$model->monitor = $_POST['Maps']['monitor'];
			if ($model->save()) {
				echo 'ok';
				exit;

			} else {
				echo 'no';
				exit;
			}
		}


		$this->render('NDg/mapmonitorcreate', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionMapheatmap($id)
	{
		if (isset($_POST['Maps']['id'])) {

			$model = Maps::model()->findByPk($_POST['Maps']['id']);
			$model->monitor = $_POST['Maps']['monitor'];
			if ($model->save()) {
				echo 'ok';
				exit;

			} else {
				echo 'no';
				exit;
			}
		}


		$this->render('NDg/mapmonitorcreate2', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionMapmonitorc()
	{


		$model = Maps::model()->findByPk($_POST['Maps']['id']);
		$model->monitor = $_POST['Maps']['monitor'];
		$model->save();
		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/


		Yii::app()->SetFlashes->add($model, t('Kaydetme Başarılı'), array('/client/mapsmonitorcreate?id=' . $model->client_id . '&&hid=' . $model->id));
		$this->redirect(array('/client/maps?id=' . $_POST['Maps']['client_id']));
	}

	public function actionMapdelete()
	{
		$model = Maps::model()->findByPk($_POST['Maps']['id'])->delete();
		//loglama
		Logs::model()->logsaction();
		/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
		Yii::app()->SetFlashes->add($model, t('Delete Success!'), array('/client/maps?id=' . $_POST['Maps']['client_id']));
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/client/maps?id=' . $_POST['Maps']['client_id']));
	}


	public function actionMapdeleteall()
	{

		$deleteall = explode(',', $_POST['Maps']['id']);

		foreach ($deleteall as $delete) {
			$model = Maps::model()->findByPk($delete)->delete();
			//loglama
			Logs::model()->logsaction();
		}

		Yii::app()->SetFlashes->add($model, t('Delete Success!'), array('/client/maps?id=' . $_POST['Maps']['client_id']));
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/client/maps?id=' . $_POST['Maps']['client_id']));
	}

	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'client-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
