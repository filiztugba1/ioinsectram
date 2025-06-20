<?php

class DocumentsController extends Controller
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
				'actions'=>array('index','view','tabs','fileandtable','create2','create3','documentlist','documentmenu','subview','subfile','documentlist2','update3',"documandetay",'documentstatusupdate','Documentcategories','Documentmenuapi',
                        'index2','categorylist'),
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

  
  public function actionIndex2()
	{
		$this->render('index2');
	}
  
  public function actionCategorylist() // admin girişinde firm listesini çekmek için kullanılır.
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewDocumentModel::model()->documentCategoryList($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  
  /*
   public function actionDocumentList() // admin girişinde firm listesini çekmek için kullanılır.
  {
    $yetki=AuthAssignment::model()->accesstoken();
   
    if($yetki['status'])
    {
      $response=NewDocumentModel::model()->documentList($_POST);
      echo json_encode($response);
      exit;
    }
    json_encode($yetki);
		exit;
  }
  */
  
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



    public function actionDocumandetay()
	{
		$this->render('view');
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$path=Yii::getPathOfAlias('webroot').'/uploads';
		 $temTime=time();


			$model=new Documents;


		 	$model->attributes=$_POST['Documents'];
			$image=CUploadedFile::getInstance($model,'fileurl');
			$image->saveas($path.'/'.$temTime.$image->name);
			$model->fileurl='uploads/'.$temTime.$image->name;
			$model->categoryid=$_POST['Documents']['categoryid'];
			$model->name=$image->name;

			$type=explode('.',$image->name);
			$model->type=$type[1];


			$model->save();

			Logs::model()->logsaction();
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				Yii::app()->SetFlashes->add($model,t('File Upload Success!'),array('index'));

			$this->redirect(array('index','id'=>$model->id));




		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Documents']))
		{
			$model->attributes=$_POST['Documents'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax= User::model()->userobjecty('')->firmid)));
		if($id==0)
		{
			$id=$_POST['Documents']['id'];

		}


		$filepath=Yii::getPathOfAlias('webroot').'/'.$_POST['Documents']['fileurl'];

		if(file_exists($filepath))
		{
			unlink($filepath);
		}


		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Documentviewfirm::model()->DeleteAll(array('condition'=>'documentid=:id','params'=>array('id'=>$_POST['Documents']['id'])));
			Userdocumentview::model()->DeleteAll(array('condition'=>'documentid=:id','params'=>array('id'=>$_POST['Documents']['id'])));
			Logs::model()->logsaction();

			$x='successful';
			echo json_encode($x);
			/* Hatalar� sadece alttaki setflashes class� ile ay�kl�yoruz!!! :)))*/
				//Yii::app()->SetFlashes->add($model,t('File Delete Success!'),array('index'));

			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

		}


	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$dataProvider=new CActiveDataProvider('Documents');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
  
  public function actionDocumentcategories(){
    $categorys=Documentcategory::model()->findAll(array('order'=>'id ASC','condition'=>'isactive=1 and parent=0'));
    $list=[];
    foreach($categorys as $item){
      $list[]=$item->getAttributes();
    }
  api_response($list);
      exit;
  }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Documents('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documents']))
			$model->attributes=$_GET['Documents'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



	public function actionDocumentmenuapi()
	{
    
		Documents::model()->kategoritabloyazapi($_GET['id'],0);

	}


	public function actionDocumentmenu()
	{?>
		<div class="card">
			<div class="card-content collapse show">
                 <div class="card-body card-dashboard">
						<h4 id='documentsh4' class="card-title"><?=mb_strtoupper(t('Category List'));?></h4>
					  <div class="treex well">
					  <div class="horizontal-scroll scroll-example height-300">
                      <div class="horz-scroll-content">

					  <?php						  Documents::model()->kategoritabloyaz($_GET['id'],0);

					  ?>
					</div>
					</div>

					  </div>
                 </div>
            </div>
        </div>
     <?php }



	public function actionDocumentlist2()
	{
		$ax= User::model()->userobjecty('');
		?>
		<div class="card">
            <div class="card-header">
                <div class="row">
					<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
						<h4 id='documentlisth4' class="card-title"><?=t('DOCUMETS LIST');?></h4>
					</div>
					<?php if (Yii::app()->user->checkAccess('documents.create')){ ?>
					<div class="col-xl-3 col-lg-3 col-md-3 mb-1" id='filecreate'>

						<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
							<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add File');?> <i class="fa fa-plus"></i></button>
						</div>
					</div>
					<?php }?>
				</div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
					<table class="table table-striped table-bordered dataex-html5-export ">
						<thead>
							<tr>
								<th><?=mb_strtoupper(t('Name'));?></th>
								<th><?=t('TYPE');?></th>
								<th><?=t('WHO TO');?></th>
							</tr>
						</thead>
                        <tbody>
						<?php
						    $visit= Yii::app()->db->createCommand('SELECT documents.categoryid,documents.name,documents.fileurl,documents.type as documenttype,documentviewfirm.* FROM documents RIGHT JOIN documentviewfirm ON documents.id = documentviewfirm.documentid where documentviewfirm.type='.$_GET['firmtype'].' and documentviewfirm.viewerid='.$_GET['firmid'].' and documents.categoryid='.$_GET['id'])->queryAll();

							for($i=0;$i<count($visit);$i++){?>
							<tr>
								<td><a href="<?=Yii::app()->baseUrl.'/'.$visit[$i]['fileurl'];?>" download><?=$visit[$i]['name'];?></a></td>
								<td><?=$visit[$i]['documenttype'];?></td>
								<td>
									<?php


									if(Documents::model()->subview(2,$visit[$i]['id'])==''){ echo t('Just you');}
									else if(Documents::model()->subview(2,$visit[$i]['id'])=='all'){ echo t('All');}
									else
										{?>

										<?=t('As described')?>

											<!--
											<a href data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=Documents::model()->firmlist($justyou);?>">
											<?=t('As described')?>
											</a>
											-->
										<?php }

								?>
									</td>


							</tr>
							<?php }


						?>
						</tbody>
                        <tfoot>
                          <tr>
							 <th><?=mb_strtoupper(t('Name'));?></th>
							 <th><?=t('TYPE');?></th>
							 <th><?=t('WHO TO');?></th>



                          </tr>
                        </tfoot>
                     </table>
				 </div>
               </div>
             </div>

    <?php }



	public function actionDocumentstatusupdate()
	{
			Yii::app()->db->createCommand('UPDATE documents SET arsivorguncel=0 WHERE categoryid in (35,34) and createdtime<'.strTotime(date('Y').'-01-01 00:00:01'))->execute();
			echo 'ok';
			exit;
	}

	public function actionDocumentlist()
	{


		$ax= User::model()->userobjecty('');
		?>
		<div class="card">
        <div class="card-header">
            <div class="row">
				<div class="col-xl-9 col-lg-9 col-md-9 mb-1">
					<h4 id='documentlisth4' class="card-title"><?=t('Corparate').' '.t('DOCUMETS LIST');?></h4>
				</div>
				<?php if (Yii::app()->user->checkAccess('documents.create')){ ?>
				<div class="col-xl-3 col-lg-3 col-md-3 mb-1">
					<div class="input-group-append" id="button-addon2" style="float: right; text-align: right;">
						<button class="btn btn-info" id="createbutton" type="submit"><?=t('Add File');?> <i class="fa fa-plus"></i></button>
					</div>
				</div>
				<?php }?>
			</div>
        </div>
				<?php if(isset($_GET['id']) && ($_GET['id']==35 || $_GET['id']==34)){?>
					<?php
					//echo 'UPDATE documents SET arsivorguncel=1 WHERE categoryid='.$_GET['id'].' and createdtime<'.strTotime(date('Y').'-01-01 00:00:01');
					?>
					<div class='col-12' style="padding-right: 23px;">
						<a onclick="statusFiltre(this)" data-id="<?=$_GET['id'];?>" data-status="3" class="btn btn-danger btn-sm statusbtn <?=$_GET['status']==0?'active':'';?>" style='float:right;'><?=t('Arşiv');?></a>
						<a onclick="statusFiltre(this)" data-id="<?=$_GET['id'];?>" data-status="1" class="btn btn-success btn-sm statusbtn <?=$_GET['status']==1?'active':'';?>" style='float:right;'><?=t('Güncel');?> </a>
					<!--	<a onclick="statusFiltre(this)" data-id="<?=$_GET['id'];?>" data-status="2" class="btn btn-info btn-sm" style='float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;'><?=t('Hepsi');?> </a> -->
					</div>
				<?php }?>

        <div class="card-content collapse show">
            <div class="card-body">
				<table class="table table-striped table-bordered dataex-html5-export table-responsive">
					<thead>
						<tr>
							<th><?=mb_strtoupper(t('Name'));?></th>
							<th><?=t('DOCUMENT TYPE');?></th>
							<th><?=t('WHO TO');?></th>
							<!--<th><?=t('CREATED TIME');?></th> -->
							<th>
							<?php if (Yii::app()->user->checkAccess('documents.update') && Yii::app()->user->checkAccess('documents.delete')){ ?>
                           <?=mb_strtoupper(t('Process'));?>
							<?php }?>
							</th>
						</tr>
					</thead>
                    <tbody>

					 <?php					 $where='';
					 if(isset($_GET['id']) && ($_GET['id']==35 || $_GET['id']==34))
					 {
						 $where=$_GET['status']==2?' and (documents.arsivorguncel=0 or documents.arsivorguncel=1)':' and documents.arsivorguncel='.(isset($_GET['status'])?$_GET['status']:1);
					 }
					 $document= Yii::app()->db->createCommand('SELECT documents.arsivorguncel as arsivorguncel,
						 documents.id as id,
						 documents.categoryid as categoryid,
						 documents.name as name,
						 documents.fileurl as url,
						 documents.type as type,
						 documents.firmid as dfirmid,
						 documents.branchid as dbranchid,
						 documents.clientid as dclientid,
						 documents.clientbranchid as dclientbranchid,
						 documents.createdtime as createdtime,
						 documentviewfirm.createdtime as vcreatedtime FROM documents
						 INNER JOIN documentviewfirm ON documents.id = documentviewfirm.documentid
						 	where documents.categoryid='.(isset($_GET['id'])?$_GET['id']:0).'
						 and documentviewfirm.firmid='.$ax->firmid.'
						 and documentviewfirm.branchid='.$ax->branchid.'
						 and documentviewfirm.clientid='.$ax->clientid.'
						 and documentviewfirm.clientbranchid='.$ax->clientbranchid.$where.' GROUP BY documentviewfirm.documentid')->queryAll();
					 for($i=0;$i<count($document);$i++){
						  $userdocumentview=Userdocumentview::model()->find(array('condition'=>'documentid='.$document[$i]['id'].' and userid='.$ax->id));
						 $color='';
						 if(!isset($userdocumentview))
						 {
							$userdocument=new Userdocumentview;
							$userdocument->documentid=$document[$i]['id'];
							$userdocument->userid=$ax->id;
							$userdocument->isview=0;
							$userdocument->save();

							 $color='style="color:red"';
						 }
						 ?>
					 <tr>
						<td><a <?=$color;?>  href="<?=Yii::app()->baseUrl.'/'.$document[$i]['url'];?>" download><?=$document[$i]['name'];?></a></td>
						<td><?=$document[$i]['type'];?></td>
						<td><?=Documents::model()->subdocument($document[$i]['id']);?></td>
						<!--<td><?=date('Y-m-d',$document[$i]['createdtime']);?></td> -->
						<td>
						<?php

						 $dosyadurum=0;
							if($document[$i]['dfirmid']==$ax->firmid && $document[$i]['dbranchid']==$ax->branchid && $document[$i]['dclientid']==$ax->clientid && $document[$i]['dclientbranchid']==$ax->clientbranchid)
							{
								$dosyadurum=1;
							}

							if($ax->firmid!=0 && $ax->branchid==0)
							{
								$dosyadurum=1;
							}


						if (Yii::app()->user->checkAccess('documents.update'))
							{

							?>
								<a  class="btn btn-warning btn-sm" onclick="openmodal(this)"
									data-id="<?=$document[$i]['id'];?>"
									data-name="<?=$document[$i]['name'];?>"
									data-categoryid="<?=$document[$i]['categoryid'];?>"
									data-dosyadurum="<?=$dosyadurum;?>"
									data-arsivorguncel='<?=$document[$i]['arsivorguncel'];?>'
									style='border: none !important;'><i style="color:#fff;" class="fa fa-edit"></i>
								</a>

							<?php }
						if (Yii::app()->user->checkAccess('documents.delete') && $dosyadurum==1)
							{ ?>
								<a  class="btn btn-danger btn-sm" style='border: none !important;' onclick="openmodalsil(this)" data-url="<?=$document[$i]['url'];?>" data-id="<?=$document[$i]['id'];?>"><i style="color:#fff;" class="fa fa-trash"></i>
								</a>
							<?php }?>
						<?php if($ax->id==317)
						{?>
						<a class="btn btn-info btn-sm" href="/documents/documandetay?id=<?=$document[$i]['id'];?>"><i style="color:#fff;" class="fa fa-search"></i>
								</a>
						<?php }?>

						</td>
					 </tr>
					<?php }?>

					</tbody>
                    <tfoot>
						<tr>
                            <th><?=mb_strtoupper(t('Name'));?></th>
							<th><?=t('DOCUMENT TYPE');?></th>
							<th><?=t('WHO TO');?></th>
						<!--	<th><?=t('CREATED TIME');?></th> -->
							<th>
							<?php if (Yii::app()->user->checkAccess('documents.update') && Yii::app()->user->checkAccess('documents.delete')){ ?>
                           <?=mb_strtoupper(t('Process'));?>
							<?php }?>
						</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
        </div>
    </div>

    <?php }


	public function actionCreate2()
	{


var_dump($_POST['Documents']);
exit;
		$who=User::model()->whopermission();


		$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax= User::model()->userobjecty('')->firmid)));
		if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
		}


		$ax= User::model()->userobjecty('');
        $model = new Documents;

		$temTime=time();

		// $_POST['Documents']['subtype'];
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $type = isset($_GET['type']) ? $_GET['type'] : 'post';

        if (isset($_POST['Documents'])) {

            $model->attributes = $_POST['Documents'];

            $photos = CUploadedFile::getInstancesByName('Documents[fileurl]');

			$array[]='';
            // proceed if the images have been set
            if (isset($photos) && count($photos) > 0) {

                // go through each uploaded image
                foreach ($photos as $image => $pic) {
					$package=Packages::model()->find(array('condition'=>'code=:code','params'=>array('code'=>$firm->package)));

					$size=$package->maxfile-filesize(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username);
					if($ax->firmid==0 || $package->maxfile==-1 || $package->maxfile+4048>=filesize(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username)+$pic->size)
					{

                    if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$temTime.$pic->name)) {
                        // add it to the main model now
                        $img_add = new Documents();
						$img_add->fileurl='uploads/'.$firm->username.'/'.$temTime.$pic->name;
						$img_add->categoryid=$_POST['Documents']['categoryid'];
						$img_add->firmid=$_POST['Documents']['firmid'];
						$img_add->firmtype=$_POST['Documents']['firmtype'];
						$img_add->createdtime=time();

						$viewer=0;


						for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
						{
							if($_POST['Documents']['viewer'][$i]=='all')
							{
								$viewer=1;
							}
						}

						$img_add->viewer=0;
						$type=explode('.',$pic->name);
						$countt=count($type)-1;
						$img_add->type=$type[$countt];
						$img_add->name=$type[0];


                        if($img_add->save() && $_POST['Documents']['viewer']!='')
						{
							if($viewer==0)
							{
								if($who->type==2)
								{
									for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
									{
										$cb=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_POST['Documents']['viewer'][$i])));
										$parent=Documentviewfirm::model()->find(array('condition'=>'viewerid=:viewerid and type=3 and documentid=:documentid','params'=>array('viewerid'=>$cb->parentid,'documentid'=>$img_add->id)));

										if(count($parent)==0)
										{
											$cbview= new Documentviewfirm();
											$cbview->type=3;
											$cbview->documentid=$img_add->id;
											$cbview->viewerid=$cb->parentid;
											$cbview->viewer=0;
											$cbview->parentid=0;
											$cbview->createdtime=time();
											$cbview->save();
										}
										else
										{
											$cbview=Documentviewfirm::model()->find(array('condition'=>'viewerid=:viewerid and type=3 and documentid=:documentid','params'=>array('viewerid'=>$cb->parentid,'documentid'=>$img_add->id)));
										}

										$view= new Documentviewfirm();
										$view->type=4;
										$view->documentid=$img_add->id;
										$view->viewerid=$_POST['Documents']['viewer'][$i];
										$view->viewer=1;
										$view->parentid=$cbview->id;
										$view->createdtime=time();
										$view->save();
									}
								}
								else
								{
									for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
									{
										$view= new Documentviewfirm();
										$view->type=$_POST['Documents']['subtype'];
										$view->documentid=$img_add->id;
										$view->viewerid=$_POST['Documents']['viewer'][$i];
										$view->viewer=0;
										$view->parentid=0;
										$view->createdtime=time();
										$view->save();
									}
								}
							}

							else
							{
								if($who->type==0)
								{
										$firm=Firm::model()->findAll(array('condition'=>'parentid=0'));
										foreach($firm as $firmx)
										{
											$view= new Documentviewfirm();
											$view->type=1;
											$view->documentid=$img_add->id;
											$view->viewerid=$firmx->id;
											$view->viewer=0;
											$view->parentid=0;
											$view->createdtime=time();
											$view->save();
										}
								}
								if($who->type==1)
								{
									$firm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
										foreach($firm as $firmx)
										{
											$view= new Documentviewfirm();
											$view->type=2;
											$view->documentid=$img_add->id;
											$view->viewerid=$firmx->id;
											$view->viewer=0;
											$view->parentid=0;
											$view->createdtime=time();
											$view->save();
										}
								}

								if($who->type==2)
								{
									$client=Client::model()->findAll(array('condition'=>'firmid='.$ax->branchid));
										foreach($client as $clientx)
										{
											$view= new Documentviewfirm();
											$view->type=3;
											$view->documentid=$img_add->id;
											$view->viewerid=$clientx->id;
											$view->viewer=0;
											$view->parentid=0;
											$view->createdtime=time();
											$view->save();

											$clientbranch=Client::model()->findAll(array('condition'=>'parentid='.$clientx->id));

												foreach($clientbranch as $clientbranchx)
												{
													if($clientbranchx->firmid==$ax->branchid)
													{
														$view2= new Documentviewfirm();
														$view2->type=4;
														$view2->documentid=$img_add->id;
														$view2->viewerid=$clientbranchx->id;
														$view2->viewer=0;
														$view2->parentid=$view->id;
														$view2->createdtime=time();
														$view2->save();
													}
												}
										}



										$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'firmid='.$who->id.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
										foreach($tclient as $tclientx)
										{

											$tclients=Client::model()->findAll(array('condition'=>'id='.$tclientx->mainclientid));
											foreach($tclients as $tclientsx)
											{
												$view= new Documentviewfirm();
												$view->type=3;
												$view->documentid=$img_add->id;
												$view->viewerid=$tclientsx->id;
												$view->viewer=0;
												$view->parentid=0;
												$view->createdtime=time();
												$view->save();

												$tclientbranchs=Client::model()->findAll(array('condition'=>'parentid='.$tclientsx->id.' and firmid='.$who->id));

												foreach($tclientbranchs as $tclientbranchsx)
												{
														$view2= new Documentviewfirm();
														$view2->type=4;
														$view2->documentid=$img_add->id;
														$view2->viewerid=$tclientbranchsx->id;
														$view2->viewer=0;
														$view2->parentid=$view->id;
														$view2->createdtime=time();
														$view2->save();

												}

											}

										}







								}
								if($who->type==3)
								{
											$clientbranch=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
											foreach($clientbranch as $clientbranchx)
												{
													$view= new Documentviewfirm();
													$view->type=4;
													$view->documentid=$img_add->id;
													$view->viewerid=$clientbranchx->id;
													$view->viewer=0;
													$view->parentid=0;
													$view->createdtime=time();
													$view->save();
												}

								}



							}

						}



						$array[]=$pic->size.',1,'.$img_add->name;
                    }
				}

				else
					{
                        $array[]=$size.',2,'.$pic->name;
                    }

                }
            }

			$model->save();
			echo json_encode($array);



        }



    }





public function actionCreate3()
{


	$ax= User::model()->userobjecty('');
	$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->firmid)));
	if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
	{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
	}
	$temTime=time();
  $type = isset($_GET['type']) ? $_GET['type'] : 'post';


	// echo isset($_POST['Documents']);
	if (isset($_POST['Documents']))
	{
		$array[]='';
		$photos = CUploadedFile::getInstancesByName('Documents[fileurl]');
		if (isset($photos) && count($photos) > 0)
		{
			foreach ($photos as $image => $pic)
			{
				$type=explode('.',$pic->name);
				$package=Packages::model()->find(array('condition'=>'code=:code','params'=>array('code'=>$firm->package)));
				$size=$package->maxfile-((filesize(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username)+($pic->size))/1024)/1024;
				if($ax->firmid==0 || $package->maxfile==-1 || $size>=0)
				{
					if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$type[0].'-'.date('Y-m-d H:i:s').'.'.$type[1]))
					{
						$img_add = new Documents();
						$img_add->fileurl='uploads/'.$firm->username.'/'.$type[0].'-'.date('Y-m-d H:i:s').'.'.$type[1];
						$img_add->categoryid=$_POST['Documents']['categoryid'];
						$img_add->firmid=$ax->firmid;
						$img_add->branchid=$ax->branchid;
						$img_add->clientid=$ax->clientid;
						$img_add->clientbranchid=$ax->clientbranchid;
						$img_add->firmtype=0;
						$img_add->createdtime=time();
						$viewer=0;
            if (is_countable($_POST['Documents']['viewer'])){
              for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
						{
							if($_POST['Documents']['viewer'][$i]=='-1')
							{
								$viewer=-1;
							}

							if($_POST['Documents']['viewer'][$i]=='0')
							{
								$viewer=1;
							}
						}
              
            }
						

						$img_add->viewer=0;
						$type=explode('.',$pic->name);
						$countt=count($type)-1;
						$img_add->type=$type[$countt];
						$img_add->name=$type[0];
						$img_add->arsivorguncel=1;
						$img_add->finishdate=strTotime($_POST['Documents']['finishdate']);
						$img_add->save();

						if(is_countable($_POST['Documents']['viewer']) && $viewer!=-1 && count($_POST['Documents']['viewer'])!=0)
						{
							// echo 'sdf';
							Documents::model()->documentcreatefunction($img_add->id);
							if($ax->firmid!=0)
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid);
							}
							if($ax->branchid!=0)
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid);
							}
							if($ax->clientid!=0)
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid);
							}
							if($ax->clientbranchid!=0)
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid,$ax->clientbranchid);
							}


								//ALT YETK� VERME KISMI

								////////////////////////////////////////////
								//DOSYAYI EKLEYEN K��� ADM�N �SE F�RMAYA YETK� VEREB�L�R
								if($ax->firmid==0)
								{
									if($viewer==1)
									{
										$firm=Firm::model()->findAll(array('condition'=>'parentid=0'));
									}
									else
									{
										$dizi=implode(",", $_POST['Documents']['viewer']);
										$firm=Firm::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
									}

										foreach($firm as $firmx)
										{
											Documents::model()->documentcreatefunction($img_add->id,$firmx->id);
										}

								}

								/////////////////////////////////////////////
								//DOSYAYI EKLEYEN K��� F�RMA �SE F�RM BRANCH A YETK� VEREB�L�R
								if($ax->firmid!=0 && $ax->branchid==0)
								{
									if($viewer==1)
									{
										$firm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
									}
									else
									{
										$dizi=implode(",", $_POST['Documents']['viewer']);
										$firm=Firm::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
									}
									foreach($firm as $firmx)
										{
											Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id);
											$ispackege=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
											if($ispackege->package!='Package1')
											{
											    $client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$firmx->id));
													$clientbranch=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0 and firmid='.$firmx->id));
													foreach($client as $clientx)
													{
														if($viewer==1)
														{
															Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id,$clientx->id);
														}
														else
														{
															Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id,$clientx->parentid);
														}
													}
													foreach($clientbranch as $clientbranchx)
													{
														Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
													}
											}
										}
								}
								/////////////////////////////////////////////////
								// DOSYAYI EKLEYEN K��� F�RM BRANCH �SE CL�ENT E YETK� VEREB�L�R
								if($ax->branchid!=0 && $ax->clientid==0)
								{
									if($viewer==1)
											{
												$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$ax->branchid));
												$clientbranch=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0 and firmid='.$ax->branchid));
											}
											else
											{
												$dizi=implode(",", $_POST['Documents']['viewer']);
												$clientbranch=Client::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
												$client=Client::model()->findAll(array('condition'=>'id in ('.$dizi.') group by parentid'));
											}
											foreach($client as $clientx)
											{
												if($viewer==1)
												{
												Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientx->id);
												}
												else
												{
													Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientx->parentid);
												}
											}

											foreach($clientbranch as $clientbranchx)
											{
												Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->mainfirmid,$clientbranchx->parentid,$clientbranchx->id);
											    Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->firmid,$clientbranchx->parentid,$clientbranchx->id);
											    
											    Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->mainfirmid,$clientbranchx->parentid);
											    Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->firmid,$clientbranchx->parentid);
											}

										}

								//////////////////////////////////////////
								// DOSYA EKLEYEN K��� CL�ENT �SE CL�ENTBRANCHA YETK� VEREB�L�R.
								if($ax->clientid!=0 && $ax->clientbranchid==0)
								{
									if($viewer==1)
									{
										$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0'));
									}
									else
									{
										$dizi=implode(",", $_POST['Documents']['viewer']);
										$clientbranch=Client::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
									}

										foreach($clientbranch as $clientbranchx)
										{
											Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
										}

								}
								///////////////////////////////////////////
								$array[]=$pic->size.',1,'.$img_add->name;
								echo json_encode($array);
						}
						else
						{
							Documents::model()->documentcreatefunction($img_add->id);

							if($ax->firmid!=0)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid);
								}
								if($ax->branchid!=0)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid);
								}
								if($ax->clientid!=0)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid);
								}
								if($ax->clientbranchid!=0)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid,$ax->clientbranchid);
								}

								///////////////////////////////////////////
								$array[]=$pic->size.',1,'.$img_add->name;
								echo json_encode($array);
						}
					}
				}
			}
		}
	}


}





public function actionUpdate3()
{


	$ax= User::model()->userobjecty('');
	$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->firmid)));
	if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
	{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
	}

	$temTime=time();
    $type = isset($_GET['type']) ? $_GET['type'] : 'post';


	if (isset($_POST['Documents']))
	{
		$photos = CUploadedFile::getInstancesByName('Documents[fileurl]');
		$array[]='';

        if (isset($photos) && count($photos) > 0)
		{
			$img_add=Documents::model()->find(array('condition'=>'id='.$_POST['Documents']['id']));

			// de�i�tirilecek dosya
			if(isset($_POST['Documents']['id']))
			{

				if(file_exists(Yii::getPathOfAlias('webroot').'/'.$img_add->fileurl))
				{
				unlink(Yii::getPathOfAlias('webroot').'/'.$img_add->fileurl);

				}
			}

			foreach ($photos as $image => $pic)
			{
				$type=explode('.',$pic->name);
				$package=Packages::model()->find(array('condition'=>'code=:code','params'=>array('code'=>$firm->package)));
				$size=$package->maxfile-filesize(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username);
				if($ax->firmid==0 || $package->maxfile==-1 || $package->maxfile+4048>=filesize(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username)+$pic->size)
				{

                    if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$type[0].'-'.date('Y-m-d H:i:s').'.'.$type[1]))
					{
						$img_add->fileurl='uploads/'.$firm->username.'/'.$type[0].'-'.date('Y-m-d H:i:s').'.'.$type[1];
						$img_add->categoryid=$_POST['Documents']['categoryid'];
						if($_POST['Documents']['categoryid']==34 || $_POST['Documents']['categoryid']==35)
						{
							$img_add->arsivorguncel=$_POST['Documents']['arsivorguncel'];
						}

						// $img_add->firmid=$ax->firmid;
						// $img_add->branchid=$ax->branchid;
						// $img_add->clientid=$ax->clientid;
						// $img_add->clientbranchid=$ax->clientbranchid;
						$img_add->firmtype=0;
						$img_add->createdtime=time();

						$viewer=0;
						for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
						{
							if($_POST['Documents']['viewer'][$i]=='-1')
							{
								$viewer=-1;
							}

							if($_POST['Documents']['viewer'][$i]=='0')
							{
								$viewer=1;
							}
						}

						$img_add->viewer=0;
						$type=explode('.',$pic->name);
						$countt=count($type)-1;
						$img_add->type=$type[$countt];
						$img_add->name=$type[0];

						if(isset($_POST['Documents']['name']))
						{

							$img_add->name=$_POST['Documents']['name'];
						}

						Documents::model()->documentcreatefunction($img_add->id);
						if($ax->firmid!=0)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid);
						}
						if($ax->branchid!=0)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid);
						}
						if($ax->clientid!=0)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid);
						}
						if($ax->clientbranchid!=0)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid,$ax->clientbranchid);
						}

                        if($img_add->save() && $viewer!=-1 && count($_POST['Documents']['viewer'])!=0)
						{
						//ALT YETK� VERME KISMI

						////////////////////////////////////////////
						//DOSYAYI EKLEYEN K��� ADM�N �SE F�RMAYA YETK� VEREB�L�R
						if($ax->firmid==0)
						{
							if($viewer==1)
							{


								$firm=Firm::model()->findAll(array('condition'=>'parentid=0'));
							}
							else
							{

								$dizi=implode(",", $_POST['Documents']['viewer']);
								$firm=Firm::model()->findAll(array('condition'=>'id in ('.$dizi.')'));

								Documentviewfirm::model()->deleteAll(array('condition'=>'firmid!=0 and firmid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
							}

							foreach($firm as $firmx)
							{
								Documents::model()->documentcreatefunction($img_add->id,$firmx->id);
							}

						}


						/////////////////////////////////////////////
						//DOSYAYI EKLEYEN K��� F�RMA �SE F�RM BRANCH A YETK� VEREB�L�R
						if($ax->firmid!=0 && $ax->branchid==0)
						{

							if($viewer==1)
							{
								$firm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
							}
							else
							{
								$dizi=implode(",", $_POST['Documents']['viewer']);
								$firm=Firm::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
								Documentviewfirm::model()->deleteAll(array('condition'=>'firmid='.$ax->firmid.' and branchid!=0 and branchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
							}

							foreach($firm as $firmx)
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id);

										$ispackege=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
											if($ispackege->package!='Package1')
											{
											    $client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$firmx->id));
									$clientbranch=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0 and firmid='.$firmx->id));

									foreach($client as $clientx)
								{
									if($viewer==1)
									{
										Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id,$clientx->id);
									}
									else
									{
										Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id,$clientx->parentid);
									}
								}



								foreach($clientbranch as $clientbranchx)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
								}



											}
							}

						}
							/////////////////////////////////////////////////
							// DOSYAYI EKLEYEN K��� F�RM BRANCH �SE CL�ENT E YETK� VEREB�L�R

							if($ax->branchid!=0 && $ax->clientid==0)
							{



								if($viewer==1)
								{
									$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$ax->branchid));
									$clientbranch=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0 and mainfirmid='.$ax->branchid));
								}
								else
								{
									$dizi=implode(",", $_POST['Documents']['viewer']);
									$clientbranch=Client::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
									$client=Client::model()->findAll(array('condition'=>'id in ('.$dizi.') group by parentid'));
									$cli='';
									$l=0;
									foreach($client as $clienty)
									{
										if($l==0)
										{
											$cli=$clienty->parentid;
										}
										else
										{
											$cli=$cli.','.$clienty->parentid;
										}
									}

									Documentviewfirm::model()->deleteAll(array('condition'=>'branchid='.$ax->branchid.' and clientid!=0 and clientbranchid=0 and clientid not in ('.$cli.') and documentid='.$_POST['Documents']['id']));

									Documentviewfirm::model()->deleteAll(array('condition'=>'branchid='.$ax->branchid.' and clientbranchid!=0 and clientbranchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
								}


								foreach($client as $clientx)
								{
									if($viewer==1)
									{
										Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientx->id);
									}
									else
									{
										Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientx->parentid);
									}
								}
              

								foreach($clientbranch as $clientbranchx)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->mainfirmid,$clientbranchx->parentid);
              Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->firmid,$clientbranchx->parentid);
              Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);

            
            }



							}

							//////////////////////////////////////////
							// DOSYA EKLEYEN K��� CL�ENT �SE CL�ENTBRANCHA YETK� VEREB�L�R.
							if($ax->clientid!=0 && $ax->clientbranchid==0)
							{
								Documentviewfirm::model()->deleteAll(array('condition'=>'clientbranchid!=0 and documentid='.$_POST['Documents']['id']));
								if($viewer==1)
								{
									$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0'));
								}
								else
								{
									$dizi=implode(",", $_POST['Documents']['viewer']);
									$clientbranch=Client::model()->findAll(array('condition'=>'id in ('.$dizi.')'));

									Documentviewfirm::model()->deleteAll(array('condition'=>'clientid='.$ax->clientid.' andclientbranchid!=0 and clientbranchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));

								}

								foreach($clientbranch as $clientbranchx)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
								}

							}
								///////////////////////////////////////////
							//	$array[]=$pic->size.',1,'.$img_add->name;
							//	echo json_encode($array);
						}
						else
						{
						/// YANLIZCA SEN KISMI SE��L�SE
							if($ax->firmid==0)
							{
								Documentviewfirm::model()->deleteAll(array('condition'=>'firmid!=0 and documentid='.$_POST['Documents']['id']));
							}

							if($ax->firmid!=0 && $ax->branchid==0)
							{
								Documentviewfirm::model()->deleteAll(array('condition'=>'firmid='.$ax->firmid.' and branchid!=0 and documentid='.$_POST['Documents']['id']));

							}

							if($ax->branchid!=0 && $ax->clientid==0)
							{
								$dizi=implode(",", $_POST['Documents']['viewer']);
								$client=Client::model()->findAll(array('condition'=>'id in ('.$dizi.') group by parentid'));

								foreach($client as $clienty)
								{
									if($l==0)
									{
										$cli=$clienty->parentid;
									}
									else
									{
										$cli=$cli.','.$clienty->parentid;
								}
								}

								Documentviewfirm::model()->deleteAll(array('condition'=>'branchid='.$ax->branchid.' and clientid!=0  and clientid not in ('.$cli.') and documentid='.$_POST['Documents']['id']));

							}

							if($ax->clientid!=0 && $ax->clientbranchid==0)
							{
								$dizi=implode(",", $_POST['Documents']['viewer']);

								Documentviewfirm::model()->deleteAll(array('condition'=>'clientid='.$ax->clientid.' and clientbranchid!=0 and clientbranchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
							}

						}
					}



				}
			}

			$array[]=$pic->size.',1,'.$img_add->name;
			echo json_encode($array);

		}
		else
		{
			$ax= User::model()->userobjecty('');

			if(isset($_POST['Documents']['id']))
			{

				$viewer=0;
        if (is_countable($_POST['Documents']['viewer'])){
          
				for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
				{
					if($_POST['Documents']['viewer'][$i]=='-1')
					{
						$viewer=-1;
					}

					if($_POST['Documents']['viewer'][$i]=='0')
					{
						$viewer=1;
					}
				}

        }


				$img_add=Documents::model()->find(array('condition'=>'id='.$_POST['Documents']['id']));

					if(isset($_POST['Documents']['name']))
						{
							$img_add->name=$_POST['Documents']['name'];
							if($_POST['Documents']['categoryid']==34 || $_POST['Documents']['categoryid']==35)
							{
								$img_add->arsivorguncel=$_POST['Documents']['arsivorguncel'];
							}
							$img_add->save();
						}



				Documents::model()->documentcreatefunction($img_add->id);
				if($ax->firmid!=0)
				{
					Documents::model()->documentcreatefunction($img_add->id,$ax->firmid);
				}
				if($ax->branchid!=0)
				{
					Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid);
				}
				if($ax->clientid!=0)
				{
					Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid);
				}
				if($ax->clientbranchid!=0)
				{
					Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$ax->clientid,$ax->clientbranchid);
				}

				if(is_countable($_POST['Documents']['viewer']) && isset($img_add) && $viewer!=-1 && count($_POST['Documents']['viewer'])!=0)
				{

					//ALT YETK� VERME KISMI

					////////////////////////////////////////////
					//DOSYAYI EKLEYEN K��� ADM�N �SE F�RMAYA YETK� VEREB�L�R
					if($ax->firmid==0)
					{
						if($viewer==1)
						{
							$firm=Firm::model()->findAll(array('condition'=>'parentid=0'));
						}
						else
						{

							$dizi=implode(",", $_POST['Documents']['viewer']);
							$firm=Firm::model()->findAll(array('condition'=>'id in ('.$dizi.')'));

							Documentviewfirm::model()->deleteAll(array('condition'=>'firmid!=0 and firmid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
						}

						foreach($firm as $firmx)
						{
							Documents::model()->documentcreatefunction($img_add->id,$firmx->id);
						}

					}


					/////////////////////////////////////////////
					//DOSYAYI EKLEYEN K��� F�RMA �SE F�RM BRANCH A YETK� VEREB�L�R
					if($ax->firmid!=0 && $ax->branchid==0)
					{

						if($viewer==1)
						{
							$firm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
						}
						else
						{
							$dizi=implode(",", $_POST['Documents']['viewer']);
							$firm=Firm::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
							Documentviewfirm::model()->deleteAll(array('condition'=>'firmid='.$ax->firmid.' and branchid!=0 and branchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
						}

						foreach($firm as $firmx)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id);

									$ispackege=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
											if($ispackege->package!='Package1')
											{
											    $client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$firmx->id));
									$clientbranch=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0 and firmid='.$firmx->id));

									foreach($client as $clientx)
								{
									if($viewer==1)
									{
										Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id,$clientx->id);
									}
									else
									{
										Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$firmx->id,$clientx->parentid);
									}
								}



								foreach($clientbranch as $clientbranchx)
								{
									Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
								}



											}
						}

					}
					/////////////////////////////////////////////////
					// DOSYAYI EKLEYEN K��� F�RM BRANCH �SE CL�ENT E YETK� VEREB�L�R

					if($ax->branchid!=0 && $ax->clientid==0)
					{

						if($viewer==1)
						{
							$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid=0 and firmid='.$ax->branchid));
							$clientbranch=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0 and firmid='.$ax->branchid));
						}
						else
						{
							$dizi=implode(",", $_POST['Documents']['viewer']);
							$clientbranch=Client::model()->findAll(array('condition'=>'id in ('.$dizi.')'));
							$client=Client::model()->findAll(array('condition'=>'id in ('.$dizi.') group by parentid'));
							$cli='';
							$l=0;
							foreach($client as $clienty)
							{
								if($l==0)
								{
									$cli=$clienty->parentid;
								}
								else
								{
									$cli=$cli.','.$clienty->parentid;
								}
							}

							Documentviewfirm::model()->deleteAll(array('condition'=>'branchid='.$ax->branchid.' and clientid!=0 and clientbranchid=0 and clientid not in ('.$cli.') and documentid='.$_POST['Documents']['id']));

							Documentviewfirm::model()->deleteAll(array('condition'=>'branchid='.$ax->branchid.' and clientbranchid!=0 and clientbranchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));
						}


						foreach($client as $clientx)
						{
							if($viewer==1)
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientx->id);
							}
							else
							{
								Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientx->parentid);
							}
						}



						foreach($clientbranch as $clientbranchx)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->mainfirmid,$clientbranchx->parentid);
						Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$clientbranchx->firmid,$clientbranchx->parentid);
						Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
						
            
            }



					}

					//////////////////////////////////////////
					// DOSYA EKLEYEN K��� CL�ENT �SE CL�ENTBRANCHA YETK� VEREB�L�R.
					if($ax->clientid!=0 && $ax->clientbranchid==0)
					{
						Documentviewfirm::model()->deleteAll(array('condition'=>'clientbranchid!=0 and documentid='.$_POST['Documents']['id']));
						if($viewer==1)
						{
							$client=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid!=0'));
						}
						else
						{
							$dizi=implode(",", $_POST['Documents']['viewer']);
							$clientbranch=Client::model()->findAll(array('condition'=>'id in ('.$dizi.')'));

							Documentviewfirm::model()->deleteAll(array('condition'=>'clientid='.$ax->clientid.' and clientbranchid!=0 and clientbranchid not in ('.$dizi.') and documentid='.$_POST['Documents']['id']));

						}

						foreach($clientbranch as $clientbranchx)
						{
							Documents::model()->documentcreatefunction($img_add->id,$ax->firmid,$ax->branchid,$clientbranchx->parentid,$clientbranchx->id);
						}

					}

				}
				else
				{
					$ax= User::model()->userobjecty('');

					$img_add=Documents::model()->find(array('condition'=>'id='.$_POST['Documents']['id']));


					if($ax->firmid==0)
					{

						Documentviewfirm::model()->deleteAll(array('condition'=>'firmid!=0 and documentid='.$_POST['Documents']['id']));
					}
					if($ax->firmid!=0 && $ax->branchid==0)
					{
						Documentviewfirm::model()->deleteAll(array('condition'=>'firmid='.$ax->firmid.' and branchid!=0 and documentid='.$_POST['Documents']['id']));
					}

					if($ax->branchid!=0 && $ax->clientid==0)
					{
						Documentviewfirm::model()->deleteAll(array('condition'=>'branchid='.$ax->branchid.' and clientid!=0 and documentid='.$_POST['Documents']['id']));
					}
					if($ax->clientid!=0 && $ax->clientbranchid==0)
					{
						Documentviewfirm::model()->deleteAll(array('condition'=>'clientid='.$ax->clientid.' and clientbranchid!=0 and documentid='.$_POST['Documents']['id']));
					}


				}

				$array[]=$pic->size.',1,'.$img_add->name;
				echo json_encode($array);

			}

		}
	}


}





/*


	public function actionCreate2()
	{



		$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax= User::model()->userobjecty('')->firmid)));
		if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/');
		}


        $model = new Documents;

		$temTime=time();

		// $_POST['Documents']['subtype'];
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $type = isset($_GET['type']) ? $_GET['type'] : 'post';

        if (isset($_POST['Documents'])) {

            $model->attributes = $_POST['Documents'];

            $photos = CUploadedFile::getInstancesByName('Documents[fileurl]');

			$array='';
            // proceed if the images have been set
            if (isset($photos) && count($photos) > 0) {

                // go through each uploaded image
                foreach ($photos as $image => $pic) {
                    if ($pic->saveAs(Yii::getPathOfAlias('webroot').'/uploads/'.$firm->username.'/'.$temTime.$pic->name)) {
                        // add it to the main model now
                        $img_add = new Documents();
						$img_add->fileurl='uploads/'.$firm->username.'/'.$temTime.$pic->name;
						$img_add->categoryid=$_POST['Documents']['categoryid'];
						$img_add->firmid=$_POST['Documents']['firmid'];
						$img_add->firmtype=$_POST['Documents']['firmtype'];

						$viewer=0;


						for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
						{
							if($_POST['Documents']['viewer'][$i]=='all')
							{
								$viewer=1;
							}
						}

						$img_add->viewer=$viewer;
						$type=explode('.',$pic->name);
						$img_add->type=$type[1];
						$img_add->name=$type[0];

                        if($img_add->save() && $img_add->viewer==0 && $_POST['Documents']['viewer']!='')
						{
							for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
							{
								$view= new Documentviewfirm();
								$view->type=$_POST['Documents']['subtype'];
								$view->documentid=$img_add->id;
								$view->viewerid=$_POST['Documents']['viewer'][$i];
								$view->viewer=1;
								$view->parentid=0;
								$view->save();
							}

						}


						$array=$array.','.$img_add->name;
                    }

                }
            }

			$model->save();
			echo $array;

        }


    }


*/

	public function actionSubview()
	{
		$id=$_GET['id'];
		$list='-1';
		$ax= User::model()->userobjecty('');
		$kim='';
		if($ax->firmid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$id.' and firmid!=0 and branchid=0'));
			$toplam=Firm::model()->findAll(array('condition'=>'parentid=0'));
			$kim='firmid';
		}
		else if($ax->firmid!=0 && $ax->branchid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$id.' and firmid='.$ax->firmid.' and branchid!=0 and clientid=0'));
			$toplam=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
			$kim='branchid';
		}
		else if($ax->branchid!=0 && $ax->clientid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$id.' and clientid!=0 and branchid='.$ax->branchid));
			$toplam=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$ax->branchid));
			$kim='clientid';
		}
		else if($ax->clientid!=0 && $ax->clientbranchid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$id.' and clientid='.$ax->clientid.' and clientbranchid!=0'));
			$toplam=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$ax->clientid));
			$kim='clientbranchid';
		}

		$topview=count($view);
		$toptoplam=count($toplam);

		if($topview!=0 && $topview>=$toptoplam)
		{
			$list='0';
		}

		$i=0;


		if($topview!=0 && $topview<$toptoplam)
		{
			foreach($view as $viewx)
			{
				if($i==0)
				{
					if($viewx->clientbranchid!=0)
					{
						$list=$viewx->clientbranchid;
					}
					else
					{
						$list=$viewx->$kim;
					}
				}
				else
				{
					if($viewx->clientbranchid!=0)
					{
						$list=$list.','.$viewx->clientbranchid;
					}
					else
					{
						$list=$list.','.$viewx->$kim;
					}


				}
				$i++;
			}
		}




		$list=rtrim($list,',');



		echo json_encode($list);
	}





	public function actionSubfile()
	{

		$who=User::model()->whopermission();
		$viewer=0;
		for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
		{
			if($_POST['Documents']['viewer'][$i]=='all')
			{
				$viewer=1;
			}
		}

		$sonuc='';

		if(isset($_POST['Documents']['viewer']))
		{
			if($viewer==0)
			{
				$parentid=0;
				if($_POST['Documents']['documenttype']==2)
				{
					$post=Documentviewfirm::model()->findByPk($_POST['Documents']['id']);
					$post->viewer=0;
                    $post->save();

					$parentid=$post->id;
					$documentid=$post->documentid;
				}
				else
				{

					$post=Documents::model()->findByPk($_POST['Documents']['id']);
                    $post->viewer=0;
					$post->name=$_POST['Documents']['name'];
                    $post->save();

					$documentid=$post->id;
				}



					$where="";
					for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
					{
						if($who->type==2)
						{
							$cb=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$_POST['Documents']['viewer'][$i])));

							$parent=Documentviewfirm::model()->find(array('condition'=>'viewerid=:viewerid and type=3 and parentid=:parentid','params'=>array('viewerid'=>$cb->parentid,'parentid'=>$parentid)));


							if(count($parent)==0)
							{
								$cbview= new Documentviewfirm();
								$cbview->type=3;
								$cbview->viewerid=$cb->parentid;
								$cbview->viewer=0;
								$cbview->createdtime=time();
								if($_POST['Documents']['documenttype']==2)
								{
									$cbview->parentid=$parentid;
									$cbview->documentid=$post->documentid;
								}
								else
								{
									$cbview->parentid=0;
									$cbview->documentid=$post->id;
								}
								if (!$cbview->save()){
									$sonuc='no';
								}

							}
							else
							{
								$cbview=Documentviewfirm::model()->find(array('condition'=>'viewerid=:viewerid and type=3 and parentid=:parentid','params'=>array('viewerid'=>$cb->parentid,'parentid'=>$parentid)));
							}


							$cbranchview=Documentviewfirm::model()->find(array('condition'=>'viewerid=:viewerid and type=4 and parentid=:parentid','params'=>array('viewerid'=>$_POST['Documents']['viewer'][$i],'parentid'=>$cbview->id)));

							if(count($cbranchview)==0)
							{
								$view= new Documentviewfirm();
								$view->type=4;
								$view->documentid=$cbview->documentid;
								$view->viewerid=$_POST['Documents']['viewer'][$i];
								$view->viewer=0;
								$view->createdtime=time();
								$view->parentid=$cbview->id;

								if (!$view->save()){
									$sonuc='no';
								}

							}






						}
						else
						{

							$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid=:documentid and viewerid=:viewerid and type=:type','params'=>array('documentid'=>$documentid,'viewerid'=>$_POST['Documents']['viewer'][$i],'type'=>$who->subtype)));



							if(count($view)==0)
							{
								$cbview= new Documentviewfirm();
								$cbview->type=$who->subtype;

								if($_POST['Documents']['documenttype']==2)
								{
									$cbview->parentid=$parentid;
									$cbview->documentid=$documentid;
								}
								else
								{
									$cbview->parentid=0;
									$cbview->documentid=$documentid;
								}
								$cbview->createdtime=time();

								$cbview->viewerid=$_POST['Documents']['viewer'][$i];
								$cbview->viewer=0;
								if (!$cbview->save()){
									$sonuc='no';
								}
							}
						}



							if($i==0)
							{
								$where='viewerid!='.$_POST['Documents']['viewer'][$i];
							}
							else if($i!=0)
							{
								$where=$where.' and viewerid!='.$_POST['Documents']['viewer'][$i];
							}
					}






					if($who->type==2)
					{
						$deleteview=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$documentid.' and type=4 and '.$where));


					}
					else
					{
						$deleteview=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$documentid.' and type='.$_POST['Documents']['subtype'].' and '.$where));
					}

					foreach($deleteview as $deleteviewx)
					{
						$deleteview1=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$documentid.' and parentid='.$deleteviewx->id));
						foreach($deleteview1 as $deleteview1x)
						{
							$deleteview2=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$documentid.' and parentid='.$deleteview1x->id));
							foreach($deleteview2 as $deleteview2x)
							{
								$deleteview3=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$documentid.' and parentid='.$deleteview2x->id));
							}
							$deleteview2=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$documentid.' and parentid='.$deleteview1x->id));
						}
						$deleteview1=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$documentid.' and parentid='.$deleteviewx->id));
					}

					if($who->type==2)
					{
						$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$documentid.' and type=4 and '.$where));

						$dtype=Documentviewfirm::model()->findAll(array('condition'=>'type=3 and documentid='.$documentid));
						foreach($dtype as $dtypex)
						{
							$parentdelete=Documentviewfirm::model()->findAll(array('condition'=>'parentid='.$dtypex->id));
							if(count($parentdelete)==0)
							{
								$parentdelete=Documentviewfirm::model()->deleteAll(array('condition'=>'id='.$dtypex->id));

							}
						}

					}
					else
					{
						$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$documentid.' and type='.$_POST['Documents']['subtype'].' and '.$where));
					}

			}
			else
			{
				if($_POST['Documents']['documenttype']==2)
				{
					$post=Documentviewfirm::model()->findByPk($_POST['Documents']['id']);

					$documentid=$post->documentid;
				}
				else
				{

					$post=Documents::model()->findByPk($_POST['Documents']['id']);

					$documentid=$post->id;
				}



				$ax= User::model()->userobjecty('');
								if($who->type==0)
								{

										$firm=Firm::model()->findAll(array('condition'=>'parentid=0'));
										foreach($firm as $firmx)
										{
											$isfirm=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$firmx->id.' and type=1'));

											$parent=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$ax->id.' and type=0'));
											$dparent=0;
											if(count($parent)){ $dparent=$parent->id;}


											if(count($isfirm)==0)
											{
												$view= new Documentviewfirm();
												$view->type=1;
												$view->documentid=$documentid;
												$view->viewerid=$firmx->id;
												$view->viewer=0;
												$view->parentid=$dparent;
												$view->createdtime=time();
												$view->save();
												if (!$view->save()){
														$sonuc='no';
													}
											}
										}
								}

								if($who->type==1)
								{
									$firm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
										foreach($firm as $firmx)
										{


											$isfirm=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$documentid.' and type=2 and viewerid='.$firmx->id));

											$parent=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$ax->firmid.' and type=1'));
											$dparent=0;
											if(count($parent)){ $dparent=$parent->id;}

											if(count($isfirm)==0)
											{
												$view= new Documentviewfirm();
												$view->type=2;
												$view->documentid=$documentid;
												$view->viewerid=$firmx->id;
												$view->viewer=0;
												$view->parentid=$dparent;
												$view->createdtime=time();
												if (!$view->save()){
														$sonuc='no';
													}
											}
										}
								}

								if($who->type==2)
								{
									$client=Client::model()->findAll(array('condition'=>'parentid=0 and firmid='.$ax->branchid));


										foreach($client as $clientx)
										{
											 $isfirm=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$clientx->id.' and type=3'));
											// echo 'documentid='.$documentid.' and viewerid='.$clientx->id.' and type=3';
											// echo 'documentid='.$documentid.' and viewerid='.$ax->branchid.' and type=2';
											$parent=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$ax->branchid.' and type=2'));
											$dparent=0;
											if(count($parent)){ $dparent=$parent->id;}


											if(count($isfirm)==0)
											{
												$isfirm= new Documentviewfirm();
												$isfirm->type=3;
												$isfirm->documentid=$documentid;
												$isfirm->viewerid=$clientx->id;
												$isfirm->viewer=0;
												$isfirm->parentid=$dparent;
												$isfirm->createdtime=time();
												if (!$isfirm->save()){
														$sonuc='no';
													}

											}


											$clientbranch=Client::model()->findAll(array('condition'=>'parentid='.$clientx->id));



													foreach($clientbranch as $clientbranchx)
													{
														if($clientbranchx->firmid==$ax->branchid)
														{

															$viewx= new Documentviewfirm();
															$viewx->type=4;
															$viewx->documentid=$documentid;
															$viewx->viewerid=$clientbranchx->id;
															$viewx->viewer=0;
															$viewx->createdtime=time();
															$viewx->parentid=$isfirm->id;
															if (!$viewx->save()){
															$sonuc='no';
															}
														}
													}


										}


										$tclient=Client::model()->findAll(array('order'=>'name ASC','condition'=>'firmid='.$who->id.' and mainclientid!=0 and mainfirmid!=firmid group by mainclientid'));
										foreach($tclient as $tclientx)
										{

											$tclients=Client::model()->findAll(array('condition'=>'id='.$tclientx->mainclientid));
											foreach($tclients as $tclientsx)
											{


												$isfirm=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$tclientsx->id.' and type=3'));

												$parent=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$ax->branchid.' and type=2'));
												$dparent=0;
												if(count($parent)){ $dparent=$parent->id;}


												if(count($isfirm)==0)
												{
													$isfirm= new Documentviewfirm();
													$isfirm->type=3;
													$isfirm->documentid=$documentid;
													$isfirm->viewerid=$tclientsx->id;
													$isfirm->viewer=0;
													$isfirm->createdtime=time();
													$isfirm->parentid=$dparent;
													$isfirm->save();

												}


												$tclientbranchs=Client::model()->findAll(array('condition'=>'parentid='.$tclientsx->id.' and firmid='.$who->id));

												foreach($tclientbranchs as $tclientbranchsx)
												{
														$view2= new Documentviewfirm();
														$view2->type=4;
														$view2->documentid=$documentid;
														$view2->viewerid=$tclientbranchsx->id;
														$view2->viewer=0;
														$view2->createdtime=time();
														$view2->parentid=$isfirm->id;
														$view2->save();

												}

											}

										}


								}
								if($who->type==3)
								{
											$clientbranch=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
											foreach($clientbranch as $clientbranchx)
												{
													$isfirm=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$ax->clientid.' and type=4'));


												$parent=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documentid.' and viewerid='.$firmx->id.' and type=3'));
												$dparent=0;
												if(count($parent)){ $dparent=$parent->id;}

													if(count($isfirm)==0)
													{
														$view= new Documentviewfirm();
														$view->type=4;
														$view->documentid=$documentid;
														$view->viewerid=$clientbranchx->id;
														$view->viewer=0;
														$view->createdtime=time();
														$view->parentid=$dparent;
														if (!$view->save()){
														$sonuc='no';
														}
											}
									}

						}
				}
		}

		else
		{
			if($_POST['Documents']['documenttype']!=2)
			{
				$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$_POST['Documents']['id']));
			}
			else
			{

					$deleteview=Documentviewfirm::model()->findall(array('condition'=>'parentid='.$_POST['Documents']['id']));

						foreach($deleteview as $deleteviewx)
						{
							$deleteview1=Documentviewfirm::model()->findall(array('condition'=>'parentid='.$deleteviewx->id));
							foreach($deleteview1 as $deleteview1x)
							{
								$deleteview2=Documentviewfirm::model()->findall(array('condition'=>'parentid='.$deleteview1x->id));
								foreach($deleteview2 as $deleteview2x)
								{
									$deleteview3=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$deleteview2x->id));
								}
								$deleteview2=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$deleteview1x->id));
							}
							$deleteview1=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$deleteviewx->id));
						}
					$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$_POST['Documents']['id']));

			}
		}

		/*
		$dtype=Documentviewfirm::model()->findAll(array('condition'=>'type=3'));
		foreach($dtype as $dtypex)
		{
			$parentdelete=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$dtypex->id));
			if(count($parentdelete)==0)
			{
				$parentdelete=Documentviewfirm::model()->deleteAll(array('condition'=>'id='.$dtypex->id));

			}
		}
		*/


		// update file upload

		$ax= User::model()->userobjecty('');

		$firmname=Firm::model()->find(array('condition'=>'id='.$ax->firmid))->name;

		if(!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'.$firmname.'/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/'.$firmname.'/');
		}

		$fileupload=Documents::model()->find(array('condition'=>'id='.$_POST['Documents']['id']));

		$path=Yii::getPathOfAlias('webroot').'/uploads/'.$firmname;

		$temTime=time();
		$image=CUploadedFile::getInstance($fileupload,'fileurl');

		// echo isset($image).'deneme';

		if(isset($image))
		{
			$url=$fileupload->fileurl;

			$type=explode('.',$image->Name);
			$countt=count($type)-1;
			$image->saveas($path.'/'.$temTime.$type['0'].'.'.$type[$countt]);
			$fileupload->fileurl='uploads/'.$firmname.'/'.$temTime.$type['0'].'.'.$type[$countt];

			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$url))
			{
				unlink(Yii::getPathOfAlias('webroot').'/'.$url);
			}

			$fileupload->save();
		}





		echo json_encode( $sonuc);
		//Yii::app()->SetFlashes->add($post,t('Update Success!'),array('index'));
	}



/*

	public function actionSubfile()
	{

		$who=User::model()->whopermission();
		$viewer=0;
		for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
		{
			if($_POST['Documents']['viewer'][$i]=='all')
			{
				$viewer=1;
			}
		}

	 if(isset($_POST['Documents']['viewer']))
	{
       if($viewer==0)
	   {

				if($_POST['Documents']['documenttype']==2)
				{
					$post=Documentviewfirm::model()->findByPk($_POST['Documents']['id']);
					$post->viewer=0;
                    $post->save();
				}
				else
				{

					$post=Documents::model()->findByPk($_POST['Documents']['id']);
                    $post->viewer=0;
					$post->name=$_POST['Documents']['name'];
                    $post->save();
				}


		   $where="";
			for($i=0;$i<count($_POST['Documents']['viewer']);$i++)
			{
				$view=Documentviewfirm::model()->findall(array('condition'=>'parentid=:documentid and viewerid=:viewerid and type=:type','params'=>array('documentid'=>$_POST['Documents']['id'],'viewerid'=>$_POST['Documents']['viewer'][$i],'type'=>$who->subtype)));
				// $view=Documentviewfirm::model()->findall(array('condition'=>'documentid=:documentid and viewerid=:viewerid and type=:type','params'=>array('documentid'=>$_POST['Documents']['id'],'viewerid'=>$_POST['Documents']['viewer'][$i],'type'=>$who->subtype)));

				if(count($view)==0)
				{
					$view= new Documentviewfirm();
					$view->type=$who->subtype;

					if($_POST['Documents']['documenttype']==2)
					{
						$parent=Documentviewfirm::model()->find(array('condition'=>'id='.$_POST['Documents']['id']));
						$view->documentid=$parent->documentid;

						 $view->parentid=$_POST['Documents']['id'];
					}
					else
					{
						$view->documentid=$_POST['Documents']['id'];
						 $view->parentid=0;
					}
					$view->viewer=1;
					$view->viewerid=$_POST['Documents']['viewer'][$i];

					if (!$view->save()){
							var_dump($img_add->geterrors());
							exit;
						}
				}

				if($i==0)
				{
					$where='viewerid!='.$_POST['Documents']['viewer'][$i];
				}
				else if($i!=0)
				{
					$where=$where.' and viewerid!='.$_POST['Documents']['viewer'][$i];
				}


			}


			$deleteview=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$_POST['Documents']['id'].' and type='.$_POST['Documents']['subtype'].' and '.$where));

			foreach($deleteview as $deleteviewx)
			{
				$deleteview1=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$_POST['Documents']['id'].' and parentid='.$deleteviewx->id));
				foreach($deleteview1 as $deleteview1x)
				{
					$deleteview2=Documentviewfirm::model()->findall(array('condition'=>'documentid='.$_POST['Documents']['id'].' and parentid='.$deleteview1x->id));
					foreach($deleteview2 as $deleteview2x)
					{
						$deleteview3=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$_POST['Documents']['id'].' and parentid='.$deleteview2x->id));
					}
					$deleteview2=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$_POST['Documents']['id'].' and parentid='.$deleteview1x->id));
				}
				$deleteview1=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$_POST['Documents']['id'].' and parentid='.$deleteviewx->id));
			}
			$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$_POST['Documents']['id'].' and type='.$_POST['Documents']['subtype'].' and '.$where));


		}
		else
		{
				if($_POST['Documents']['documenttype']==2)
				{
					$post=Documentviewfirm::model()->findByPk($_POST['Documents']['id']);
					$post->viewer=1;
                    $post->save();

				}
				else
				{
					$post=Documents::model()->findByPk($_POST['Documents']['id']);
                    $post->viewer=1;
					$post->name=$_POST['Documents']['name'];
                     $post->save();


				}
		}

	}


		else
		{
			if($_POST['Documents']['documenttype']!=2)
			{
				$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'documentid='.$_POST['Documents']['id']));
			}
			else
			{

					$deleteview=Documentviewfirm::model()->findall(array('condition'=>'parentid='.$_POST['Documents']['id']));

						foreach($deleteview as $deleteviewx)
						{
							$deleteview1=Documentviewfirm::model()->findall(array('condition'=>'parentid='.$deleteviewx->id));
							foreach($deleteview1 as $deleteview1x)
							{
								$deleteview2=Documentviewfirm::model()->findall(array('condition'=>'parentid='.$deleteview1x->id));
								foreach($deleteview2 as $deleteview2x)
								{
									$deleteview3=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$deleteview2x->id));
								}
								$deleteview2=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$deleteview1x->id));
							}
							$deleteview1=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$deleteviewx->id));
						}
					$deleteview=Documentviewfirm::model()->deleteAll(array('condition'=>'parentid='.$_POST['Documents']['id']));

			}
		}




		echo 'successful';
		//Yii::app()->SetFlashes->add($post,t('Update Success!'),array('index'));
	}


*/





	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Documents the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Documents::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}




	/**
	 * Performs the AJAX validation.
	 * @param Documents $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='documents-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
