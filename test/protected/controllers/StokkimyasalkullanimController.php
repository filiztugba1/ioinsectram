<?php

class StokkimyasalkullanimController extends Controller
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
				'actions'=>array('index','index2','view','list',"pagination","delete","monitorpets","hedefzararliekle","hedefzararliguncelle","hedefzararlisil"),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 public function actionMonitorpets()
	 {
		 $id=$_GET['id'];
		$pets=Monitoringtypepets::model()->findAll(array('condition'=>'monitoringtypeid='.$id.' and isactive=1'));
		?><option value="">Seçiniz</option><?php		foreach($pets as $pet)
		{
			?>	<option value="<?=$pet->petsid;?>"><?=Pets::model()->findByPk($pet->petsid)->name;?></option><?php		}

	 }

	 public function actionHedefzararliekle()
	 {

		 $model=new Stokkimyasalhedeflenenzararli;
		 $model->attributes=$_POST['Stokkimyasalkullanim'];
		 $model->monitortype=$_POST['Stokkimyasalkullanim']['mtype'];
		 $model->petsid=$_POST['Stokkimyasalkullanim']['petsid'];
		 $model->stokkimyasalkullanimid=$_POST['Stokkimyasalkullanim']['id'];
		 $model->dozaj=$_POST['Stokkimyasalkullanim']['dozaj'];
		 $model->olcubirimi=$_POST['Stokkimyasalkullanim']['olcubirimi'];
		if ($model->save()){
            $data=[];
        $data['id']=$model->id;
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
		 print_r($model->getErrors());
		 Yii::app()->SetFlashes->add($model,t('Create Success!'),array('stokkimyasalkullanim/view/'.$_POST['Stokkimyasalkullanim']['id']));
	 }

	 public function actionHedefzararliguncelle()
	 {
		 $model=Stokkimyasalhedeflenenzararli::model()->find(array("condition"=>"id=".$_POST['Stokkimyasalhedeflenenzararli']['id']));
		 $model->attributes=$_POST['Stokkimyasalkullanim'];
		 $model->monitortype=$_POST['Stokkimyasalkullanim']['mtype'];
		 $model->petsid=$_POST['Stokkimyasalkullanim']['petsid'];
		 $model->dozaj=$_POST['Stokkimyasalkullanim']['dozaj'];
		 $model->olcubirimi=$_POST['Stokkimyasalkullanim']['olcubirimi'];
		 		if ($model->save()){
            $data=[];
        $data['id']=$model->id;
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
		 print_r($model->getErrors());
		 Yii::app()->SetFlashes->add($model,t('Update Success!'),array('stokkimyasalkullanim/view/'.$_POST['Stokkimyasalkullanim']['id']));
	 }

	 public function actionHedefzararlisil()
	 {
		 $model=Stokkimyasalhedeflenenzararli::model()->find(array("condition"=>"id=".$_POST['Stokkimyasalhedeflenenzararli']['id']));
		 $model->delete();  
     api_response('ok');			
     	
		 Yii::app()->SetFlashes->add($model,t('Update Success!'),array('stokkimyasalkullanim/view/'.$_POST['Stokkimyasalkullanim']['id']));
	 }
	public function actionCreate()
	{
		$model=new Stokkimyasalkullanim;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$ax= User::model()->userobjecty('');
		if(isset($_POST['Stokkimyasalkullanim']))
		{
			$model->attributes=$_POST['Stokkimyasalkullanim'];
			$model->kimyasaladi=$_POST['Stokkimyasalkullanim']['kimyasaladi'];
			$model->ruhsattarih=strtotime($_POST['Stokkimyasalkullanim']['ruhsattarih']);
			$model->ruhsatno=$_POST['Stokkimyasalkullanim']['ruhsatno'];
			$model->aktifmaddetanimi=$_POST['Stokkimyasalkullanim']['aktifmaddetanimi'];
			$model->yontem=$_POST['Stokkimyasalkullanim']['yontem'];
			if($_POST['Stokkimyasalkullanim']['firmid'])
			{
				$model->firmid=$_POST['Stokkimyasalkullanim']['firmid'];
			}
			else {
				$model->firmid=$ax->firmid;
			}
			if($_POST['Stokkimyasalkullanim']['branchid'])
			{
				$model->branchid=$_POST['Stokkimyasalkullanim']['branchid'];
			}
			else {
				$model->branchid=$ax->branchid;
			}

			$model->isactive=1;
			$model->createdtime=time();
				if ($model->save()){
            $data=[];
        $data['id']=$model->id;
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
		}


	//	$stokkimyasalkullanim=Stokkimyasalkullanim::model()->findAll(array("condition"=>"firmid=".$ax->firmid));
	//	$arr = array ('durum'=>$durum,'total'=>count($stokkimyasalkullanim),'page'=>$_POST['package']);
	//	echo json_encode($arr);
		Yii::app()->SetFlashes->add($model,t('Create Success!'),array('index2'));
		exit;

	}

	public function actionList()
	{
		$ax= User::model()->userobjecty('');

		$baslangic=$_POST['kolon']*($_POST['package']-1);
		$stokkimyasal=Stokkimyasalkullanim::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and (kimyasaladi like '%".$_POST['search']."%' or ruhsatno like '%".$_POST['search']."%' or aktifmaddetanimi like '%".$_POST['search']."%' or yontem like '%".$_POST['search']."%') order by id ASC limit ".$baslangic.",".$_POST['kolon']));

		foreach($stokkimyasal as $stokkimyasalx){?>
			<div class="col-xl-6 col-md-6 col-12">
				<div class="card" style="border: solid 1px #e3ebf3;border-radius: 5px;">
					<div class="text-center">
						<?php if($stokkimyasalx->isactive==1){?>
						<a class="btn btn-success btn-sm" style='float:right;color:#fff'><?=t('Active');?> </a>
					 <?php }else{?> <a class="btn btn-danger btn-sm" style='float:right;color:#fff'><?=t('Passive');?> </a><?php }?>
						<div class="card-body">
							<h4 style="margin-bottom: 0px;" class="card-title"><?=mb_strtoupper($stokkimyasalx->kimyasaladi);?></h4>
							<p style="margin-bottom: 0px;"><b>Aktif Madde Tanımı:</b><?=$stokkimyasalx->aktifmaddetanimi;?></p>
							<span  style='margin-top: 5px;'><b>Ruhsat Tarih:</b> <?=date("d-m-Y",$stokkimyasalx->ruhsattarih);?></span> /
							<span  style='margin-top: 5px;'><b>Ruhsat No:</b> <?=$stokkimyasalx->ruhsatno;?></span>
							<a  class=" col-12 btn btn-success btn-sm" style='float:right;border:none'  type="submit" onclick="zararlieklemodal(this)" data-stokkimyasal="<?=$stokkimyasalx->id;?>">Zararlı Ekle</a>

							<table style="width: 100%;font-size: 13px;" id="example2" class="table table-hover table-striped table-bordered tablebg table-responsive">
									<thead>
									<tr>
											<th>Zararlı Adı</th>
											<th>Dozaj</th>
											<th>İşlem</th>
									</tr>
									</thead>
									<tbody id='tableBodyx'>
										<?php										$hedefzararli=Stokkimyasalhedeflenenzararli::model()->findAll(array("condition"=>"stokkimyasalkullanimid=".$stokkimyasalx->id));
										foreach ($hedefzararli as $hedefzararlix) {?>
											<tr>
												<td><?=Pets::model()->findbypk($hedefzararlix->petsid)->name;?></td>
												<td><?=$hedefzararlix->dozaj." ".$hedefzararlix->olcubirimi;?></td>
											</tr>
										<?php }?>

									</tbody>

							</table>

						</div>
						<div class="text-center" style="margin-bottom:10px">

					<?php if (Yii::app()->user->checkAccess('staff.update')){ ?>
					 <a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
					 data-id="<?=$stokkimyasalx->id;?>"
					 data-kimyasaladi="<?=$stokkimyasalx->kimyasaladi;?>"
					 data-aktifmaddetanimi="<?=$stokkimyasalx->aktifmaddetanimi;?>"
					 data-ruhsattarih="<?=date("d-m-Y",$stokkimyasalx->ruhsattarih);?>"
					 data-no="<?=$stokkimyasalx->ruhsatno;?>">
					 <i style="color:#fff;" class="fa fa-edit"></i>
					</a>
					<?php }?>
					<?php if (Yii::app()->user->checkAccess('staff.dateil.view')){ ?>
					<a href="<?=Yii::app()->baseUrl?>/userinfo/update/" class="btn btn-info btn-sm"><i style="color:#fff;" class="fa fa-info"></i></a>

					<?php }?>

					<?php if (Yii::app()->user->checkAccess('staff.delete')){ ?>
					<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)"
					data-id=""
					data-userid=""><i style="color:#fff;" class="fa fa-trash"></i></a>
					<?php }?>
					</div>
				 </div>
				</div>
			 </div>
		<?php }

	}

	public function actionPagination()
	{
		$ax= User::model()->userobjecty('');
			$stokkimyasalkullanim=Stokkimyasalkullanim::model()->findAll(array("condition"=>"firmid=".$ax->firmid));
			$total=count($stokkimyasalkullanim);
			?>
			<li class="page-item"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>
			<?php for($i=1;$i<=ceil($total/$_POST['kolon']);$i++){?>
			<li class="page-item"><a  onclick="pagex(this)" data-id="<?=$i;?>" class="page-link"><?=$i;?></a></li>
			<?php }?>
			<li class="page-item"><a onclick="pagex(this)" data-id="6" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>

			<?php	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=Stokkimyasalkullanim::model()->findByPk($_POST['Stokkimyasalkullanim']['id']);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$ax= User::model()->userobjecty('');
		if(isset($_POST['Stokkimyasalkullanim']))
		{
			$model->attributes=$_POST['Stokkimyasalkullanim'];
			$model->kimyasaladi=$_POST['Stokkimyasalkullanim']['kimyasaladi'];
			$model->ruhsattarih=strtotime($_POST['Stokkimyasalkullanim']['ruhsattarih']);
			$model->ruhsatno=$_POST['Stokkimyasalkullanim']['ruhsatno'];
			$model->aktifmaddetanimi=$_POST['Stokkimyasalkullanim']['aktifmaddetanimi'];
			$model->yontem=$_POST['Stokkimyasalkullanim']['yontem'];
			if($_POST['Stokkimyasalkullanim']['firmid'])
			{
				$model->firmid=$_POST['Stokkimyasalkullanim']['firmid'];
			}
			else {
				$model->firmid=$ax->firmid;
			}
			if($_POST['Stokkimyasalkullanim']['branchid'])
			{
				$model->branchid=$_POST['Stokkimyasalkullanim']['branchid'];
			}
			else {
				$model->branchid=$ax->branchid;
			}

			$model->isactive=1;
			$model->createdtime=time();
				if ($model->save()){
            $data=[];
        $data['id']=$model->id;
		    api_response($data);			
      }else{
          api_response('Check datas!',false);
      }
		}


	//	$stokkimyasalkullanim=Stokkimyasalkullanim::model()->findAll(array("condition"=>"firmid=".$ax->firmid));
	//	$arr = array ('durum'=>$durum,'total'=>count($stokkimyasalkullanim),'page'=>$_POST['package']);
	//	echo json_encode($arr);
		Yii::app()->SetFlashes->add($model,t('Update Success!'),array('index2'));
		exit;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		echo "sdfsdf";

		$id=$_POST['Stokkimyasalkullanim']['id'];
		$this->loadModel($id)->delete();
    api_response('ok');	
		Yii::app()->SetFlashes->add($this,t('Update Success!'),array('index2'));
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	//	if(!isset($_GET['ajax']))
		//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Stokkimyasalkullanim');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionIndex2()
	{
		if (isset($_POST['visittypeid']))
		{
			$guncelle=Stokkimyasalkullanim::model()->changeactive($_POST['visittypeid'],$_POST['active']);
			if(!$guncelle){
				echo "hata";
			}
			else{
				echo "kaydedildi";
			}

		}

		$dataProvider=new CActiveDataProvider('Stokkimyasalkullanim');
		$this->render('index2',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Stokkimyasalkullanim('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stokkimyasalkullanim']))
			$model->attributes=$_GET['Stokkimyasalkullanim'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Stokkimyasalkullanim the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Stokkimyasalkullanim::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Stokkimyasalkullanim $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stokkimyasalkullanim-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
