<?php

/**
 * This is the model class for table "documents".
 *
 * The followings are the available columns in table 'documents':
 * @property integer $id
 * @property string $name
 * @property string $fileurl
 * @property string $type
 * @property integer $categoryid
 * @property integer $viewer
 * @property integer $firmtype
 * @property integer $firmid
 * @property integer $branchid
 * @property integer $clientid
 * @property integer $clientbranchid
 * @property integer $createdtime
 * @property integer $arsiv_date
 */
class Documents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, fileurl, type', 'required'),
			array('categoryid, viewer, firmtype, firmid, branchid, clientid, clientbranchid, createdtime,arsiv_date', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>300),
			array('fileurl, type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, fileurl, type, categoryid, viewer, firmtype, firmid, branchid, clientid, clientbranchid, createdtime,arsiv_date', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'fileurl' => 'Fileurl',
			'type' => 'Type',
			'categoryid' => 'Categoryid',
			'viewer' => 'Viewer',
			'firmtype' => 'admin=0,firm=1,branch=2,client=3,clientbranch=4',
			'firmid' => 'Firmid',
			'branchid' => 'branchid',
			'clientid' => 'Clientid',
			'clientbranchid' => 'Clientbranchid',
			'createdtime' => 'Createdtime',
			'arsiv_date' => 'arsiv_date',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('fileurl',$this->fileurl,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('categoryid',$this->categoryid);
		$criteria->compare('viewer',$this->viewer);
		$criteria->compare('firmtype',$this->firmtype);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('arsiv_date',$this->arsiv_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function altkategorivarmi($id){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.
			if (count(Documentcategory::model()->findall(array('condition'=>'parent=:id and isactive=1','params'=>array(':id'=>$id)))))
				 {
					 return 1;
				 } else
				 {
					 return 0;
				 }
	}

	public function kategoritabloyaz($id,$gelen,$cbid=0) //leftmenu default sayfasındaki listeleme bölümü
	{
		$ax= User::model()->userobjecty('');
		$liste=	Documentcategory::model()->findall(array('order'=>'id ASC','condition'=>'parent='.$id));
		 if ($liste){	echo '<ul><div id="main-class">';}
		 if($gelen!=0){$hidden='style="display: none;"';} else { $hidden='';}
		
		
		foreach ($liste as $deger)
		{
			if(($deger->id!=35 && $deger->id!=34 && $ax->type==27) || $ax->type!=27)
			{
			$altkategorivarmi=$this->altkategorivarmi($deger->id);
			$yayindami=	$deger->isactive;
			if($altkategorivarmi){$altclass='<i style="margin-right:10px;" class="fa fa-folder-open"> </i> ';}else{$altclass='';}
			if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
			?>
		<li <?php echo $hidden; ?>><a class="btn btn-default category" id="<?=$deger->id;?>x" onclick="category(this),aktif('<?=$deger->id;?>x');" data-id="<?=$deger->id;?>" data-name='<?=t($deger->name);?>' <?php echo  $yayindami ?>><?php echo $altclass; ?><?php echo t($deger->name); ?>
		<?php				$say=0;
				$say=$say+User::model()->newdocument($deger->id,$cbid);
				if($say!=0){?>
						<span class="badge badge badge-primary badge-pill float-right mr-2">
					
							<?echo $say;?>
						</span>

					<?php }?></a>


	<?php	if ($altkategorivarmi) //alt kategorisi varmı
				{
						$this->kategoritabloyaz($deger->id,1,$cbid);
				}
		}
	}
		 if ($liste){	echo '</div></ul>';}
		 ?>
		 <style>
		 .active
		 {
			background-color: #7777778a;
		 }
  </style>
  <script>
  function aktif(id)
  {
  $('a').removeClass('active');
  $('#'+id+'').addClass('active');
  };
</script>
  <?php
	}


	public function parentdocument()
	{
		
		$who=User::model()->whopermission();
		$sqlwhere='';
		$parentwhere='';

		
		if($who->type==1)
		{
			$sqlwhere=' where firm.id='.$who->id;
		}
		else if($who->type==2)
		{
			$sqlwhere=' where branch.id='.$who->id;
		}
		else if($who->type==3)
		{
			$sqlwhere=' where client.id='.$who->id;
		}
		else if($who->type==4)
		{
			$sqlwhere=' where clientbranch.id='.$who->id;
		}
						$parent= Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.name,branch.id as branchid,branch.name,client.id as clientid,client.name,clientbranch.id as clientbranchid,clientbranch.name FROM firm INNER JOIN firm as branch ON firm.id = branch.parentid INNER JOIN client ON branch.id = client.firmid INNER JOIN client as clientbranch ON client.id = clientbranch.parentid'.$sqlwhere)->queryAll();


						for($i=0;$i<count($parent);$i++)
						{

							
							if($who->type==1)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=1 and firmid='.$parent[$i]['firmid'].') or (firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].') or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=1 and firmid='.$parent[$i]['firmid'].') or (firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].') or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
							}

							else if($who->type==2)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].') or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].') or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
							}

							else if($who->type==3)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=3 and firmid='.$parent[$i]['clientid'].') or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=3 and firmid='.$parent[$i]['clientid'].') or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
							}

							else if($who->type==4)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=4 and firmid='.$parent[$i]['clientbranchid'].')';
								}
							}


						}

					if($who->type<4)
					{
						//clientbranchı yoksa
							$parent= Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.name,branch.id as branchid,branch.name,client.id as clientid,client.name FROM firm INNER JOIN firm as branch ON firm.id = branch.parentid INNER JOIN client ON branch.id = client.firmid'.$sqlwhere)->queryAll();


						for($i=0;$i<count($parent);$i++)
						{

							
							if($who->type==1)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=1 and firmid='.$parent[$i]['firmid'].') or (firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=1 and firmid='.$parent[$i]['firmid'].') or (firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].')';
								}
							}

							else if($who->type==2)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=2 and firmid='.$parent[$i]['branchid'].') or (firmtype=3 and firmid='.$parent[$i]['clientid'].')';
								}
							}

							else if($who->type==3)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=3 and firmid='.$parent[$i]['clientid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=3 and firmid='.$parent[$i]['clientid'].')';
								}
							}

						}
					}

					if($who->type<3)
					{
						//client yoksa
							$parent= Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.name,branch.id as branchid,branch.name FROM firm INNER JOIN firm as branch ON firm.id = branch.parentid'.$sqlwhere)->queryAll();


						for($i=0;$i<count($parent);$i++)
						{

							
							if($who->type==1)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=1 and firmid='.$parent[$i]['firmid'].') or (firmtype=2 and firmid='.$parent[$i]['branchid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=1 and firmid='.$parent[$i]['firmid'].') or (firmtype=2 and firmid='.$parent[$i]['branchid'].')';
								}
							}

							else if($who->type==2)
							{

								if($i==0)
								{
									$parentwhere='(firmtype=2 and firmid='.$parent[$i]['branchid'].')';
								}
								else
								{
									$parentwhere=$parentwhere.' or (firmtype=2 and firmid='.$parent[$i]['branchid'].')';
								}
							}

						}
					}




					if($parentwhere!='')
					{
						$parentwhere=' and ('.$parentwhere.')';
					}

				

			return $parentwhere;
		
	}


	public function Subview($dview,$did)
	{
	

		if($dview==2)
		{
					$post=Documentviewfirm::model()->findByPk($did);
					$documentid=$post->documentid;
		}
		else
		{
					
					$documentid=$did;
		}

		
		
		$who=User::model()->whopermission();
		$ax= User::model()->userobjecty('');
		$list='';

		$mevcut='ok';


		$say=0;

		if($who->type==0)
		{
			$document= Yii::app()->db->createCommand('SELECT firm.*,documentviewfirm.* FROM firm
			INNER JOIN documentviewfirm ON firm.id=documentviewfirm.viewerid
			WHERE documentviewfirm.type=4 and documentviewfirm.documentid='.$documentid.' and firm.parentid=0')->queryAll();
			
			
			$firm=Firm::model()->findAll(array('condition'=>'parentid=0'));
			
			if(count($document)==0)
			{
				$list='';
			}
			else if(count($document)==count($firm))
			{
				$list='all';
			}
			else
			{
				$list='mevcut';
			}

		}

		
		if($who->type==1)
		{

			$document= Yii::app()->db->createCommand('SELECT firm.*,documentviewfirm.* FROM firm
			INNER JOIN documentviewfirm ON firm.id=documentviewfirm.viewerid
			WHERE documentviewfirm.type=2 and documentviewfirm.documentid='.$documentid.' and firm.parentid='.$ax->firmid)->queryAll();

			
			$firm=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
			
			if(count($document)==0)
			{
				$list='';
			}
			else if(count($document)==count($firm))
			{
				$list='all';
			}
			else
			{
				$list='mevcut';
			}
		}

		if($who->type==3)
		{

			$document= Yii::app()->db->createCommand('SELECT client.*,documentviewfirm.* FROM client
			INNER JOIN documentviewfirm ON client.id=documentviewfirm.viewerid
			WHERE documentviewfirm.type=4 and documentviewfirm.documentid='.$documentid.' and client.parentid='.$ax->clientid)->queryAll();


			$client= Yii::app()->db->createCommand('SELECT * FROM client WHERE  parentid='.$ax->clientid)->queryAll();
			
			if(count($document)==0)
			{
				$list='';
			}
			else if(count($document)==count($client))
			{
				$list='all';
			}
			else
			{
				$list='mevcut';
			}
		}

	

		if($who->type==2)
		{
			
		
			/*
			$document= Yii::app()->db->createCommand('SELECT client.*,clientbranch.*,documentviewfirm.* FROM client
			INNER JOIN client as clientbranch ON client.id=clientbranch.parentid
			INNER JOIN documentviewfirm ON clientbranch.id=documentviewfirm.viewerid
			WHERE documentviewfirm.type=3 and documentviewfirm.documentid='.$documentid.' and client.firmid='.$ax->branchid)->queryAll();
			*/

			// echo $ax->branchid;
			// echo $documentid;

			$document= Yii::app()->db->createCommand('SELECT client.*,documentviewfirm.* FROM documentviewfirm
			INNER JOIN client ON client.id=documentviewfirm.viewerid
			WHERE client.firmid='.$ax->branchid.' and documentviewfirm.type=3 and documentviewfirm.documentid='.$documentid)->queryAll();

	
			$documentt= Yii::app()->db->createCommand('SELECT client.*,clientbranch.*,documentviewfirm.* FROM client
			INNER JOIN client as clientbranch ON client.id=clientbranch.parentid
			INNER JOIN documentviewfirm ON documentviewfirm.viewerid=clientbranch.id
			WHERE documentviewfirm.type=4 and clientbranch.firmid='.$ax->branchid.' and clientbranch.firmid!=clientbranch.mainfirmid and documentviewfirm.documentid='.$documentid.' group by client.id')->queryAll();


		



			$client= Yii::app()->db->createCommand('SELECT client.*,clientbranch.* FROM client
			INNER JOIN client as clientbranch ON client.id=clientbranch.parentid
			WHERE client.firmid='.$ax->branchid.' and clientbranch.firmid='.$ax->branchid.' group by client.id')->queryAll();


			$clientt= Yii::app()->db->createCommand('SELECT client.*,clientbranch.* FROM client
			INNER JOIN client as clientbranch ON client.id=clientbranch.parentid
			WHERE clientbranch.firmid='.$ax->branchid.' group by client.id')->queryAll();

			 $clientc=count($clientt)+count($client);
			 $documentc=count($document)+count($documentt);

			 
			// echo count($document);
			// echo count($client);

		

			
			if($documentc==0)
			{
				$list='';
			}
			else if($documentc==$clientc)
			{
				$list='all';
			}
			else
			{
				$list='mevcut';
			}

			return $list;

		}


		return $list;

		
	}


	public function firmlist($data)
	{
		
			$who=User::model()->whopermission();
			$ax= User::model()->userobjecty('');
			$name='';

			if($who->type==0 || $who->type==1)
			{
				$view=Firm::model()->findAll(array('condition'=>Workorder::model()->serarchsplit('id',$data)));
				foreach($view as $viewx)
				{
					$name=$viewx->name.',';
				}
				
			}
			
			if($who->type==2 || $who->type==3)
			{
				$view=Client::model()->findAll(array('condition'=>Workorder::model()->serarchsplit('id',$data)));
				foreach($view as $viewx)
				{
					$name=$viewx->name.',';
				}
				
			}

			
		return $name;
	}






	public function documentcreatefunction($documanid,$firmid=0,$branchid=0,$clientid=0,$clientbranchid=0)
	{
		$ax= User::model()->userobjecty('');

		$serch=Documentviewfirm::model()->find(array('condition'=>'documentid='.$documanid.' and firmid='.$firmid.' and branchid='.$branchid.' and clientid='.$clientid.' and clientbranchid='.$clientbranchid));
		if( !$serch)
		{
			$cbview= new Documentviewfirm();
			$cbview->type=$ax->type;
			$cbview->documentid=$documanid;
			$cbview->viewerid=$ax->id;
			$cbview->firmid=$firmid;
			$cbview->branchid=$branchid;
			$cbview->clientid=$clientid;
			$cbview->clientbranchid=$clientbranchid;
			$cbview->createdtime=time();
			$cbview->save();
		}
	
	}

	

	public function subdocument($documentid)
	{
		
		$list=t('Just you');
		$ax= User::model()->userobjecty('');
		$kim='';
		if($ax->firmid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'firmid!=0 and branchid=0 and documentid='.$documentid));
			$toplam=Firm::model()->findAll(array('condition'=>'parentid=0'));
			$kim='firmid';
		}
		else if($ax->firmid!=0 && $ax->branchid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'firmid='.$ax->firmid.' and branchid!=0 and clientid=0 and documentid='.$documentid));
			$toplam=Firm::model()->findAll(array('condition'=>'parentid='.$ax->firmid));
			$kim='branchid';
		}
		else if($ax->branchid!=0 && $ax->clientid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$documentid.' and clientid!=0 and branchid='.$ax->branchid));
			$toplam=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$ax->branchid));
			$kim='clientid';
		}
		else if($ax->clientid!=0 && $ax->clientbranchid==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$documentid.' and clientid='.$ax->clientid.' and clientbranchid!=0'));
			$toplam=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$ax->clientid));
			$kim='clientbranchid';
		}
    $topview=0;
		if ( is_countable($view)){
       $topview=count($view);
    }
    $toptoplam=0;
    	if ( is_countable($toplam)){
       $toptoplam=count($toplam);
    }
		

		
		if($topview!=0 && $topview>=$toptoplam)
		{
			return 'All';
		}
		
		
		
		if($topview!=0 && $topview<$toptoplam)
		{
			return 'As described';
		}

	
		

		return $list;

	}
	
	
	
	public function subdocumentClient($firm,$firmbranch,$client,$clientbranch,$documentid)
	{
		
		$list=t('Just you');
		$kim='';
		if($firm!=0 && $firmbranch==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'firmid!=0 and branchid=0 and documentid='.$documentid));
			$toplam=Firm::model()->findAll(array('condition'=>'parentid=0 and id!='.$firm));
			$kim='firmid';
		}
		else if($firm!=0 && $firmbranch!=0 && $client==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'firmid='.$firm.' and branchid!=0 and clientid=0 and documentid='.$documentid));
			$toplam=Firm::model()->findAll(array('condition'=>'parentid='.$firm.' and id!='.$firmbranch));
			$kim='branchid';
		}
		else if($firmbranch!=0 && $client!=0 && $clientbranch==0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$documentid.' and clientid!=0 and branchid='.$firmbranch));
			$toplam=Client::model()->findAll(array('condition'=>'isdelete=0 and firmid='.$firmbranch.' and id!='.$client));
			$kim='clientid';
		}
		else if($client!=0 && $clientbranch!=0)
		{
			$view=Documentviewfirm::model()->findAll(array('condition'=>'documentid='.$documentid.' and clientid='.$client.' and clientbranchid!=0'));
			$toplam=Client::model()->findAll(array('condition'=>'isdelete=0 and parentid='.$client.' and id!='.$clientbranch));
			$kim='clientbranchid';
		}
		

    $topview=0;
		if ( is_countable($view)){
       $topview=count($view);
    }
    $toptoplam=0;
    	if ( is_countable($toplam)){
       $toptoplam=count($toplam);
    }
		

		
		if($topview!=0 && $topview>=$toptoplam)
		{
			return 1;
		}
		
		
		
		if($topview!=0 && $topview<$toptoplam)
		{
			return 0;
		}

	
		

		return 0;

	}
	
	
	// public function newFCsubdocument($firm,$firmbranch,$client,$clientbranch)
	// {
		// $firm=intval($firm);
		// $firmbranch=intval($firmbranch);
		// $client=intval($client);
		// $clientbranch=intval($clientbranch);
		
		// $firm_yetki=$firm==0;
		// $branch_yetki=$firm>0 && $firmbranch==0;
		// $client_yetki=$firmbranch!=0 && $client==0;
		// $clientb_yetki=$client!=0 && $clientbranch==0;
		// if($firm==0)
		// {
			// $sql = "select * from ( SELECT d.id,(SELECT COUNT(*) FROM documentviewfirm dwf WHERE dwf.firmid != 0 AND dwf.branchid = 0 AND dwf.clientid = 0 AND dwf.documentid = d.id) AS verilen_yetki, (SELECT COUNT(*) FROM firm f WHERE f.parentid = 0) AS firm_count FROM documents d) s where s.verilen_yetki=s.firm_count";
		// }
		// else if($branch_yetki)
		// {
			// $sql = "select * from (SELECT documentid id,count(branchid) badet FROM `documentviewfirm` where firmid=".$firm." and branchid in (SELECT id FROM `firm` where parentid=".$firm." and active=1) and clientid=0 GROUP by (documentid)) x where x.badet=(SELECT count(f.id) FROM `firm` f where f.parentid=".$firm." and f.active=1)";
		// }
		// else if($client_yetki)
		// {
			// $sql = "select * from (SELECT documentid id,count(branchid) badet,firmid FROM `documentviewfirm` where firmid=".$firm." and branchid=".$firmbranch." and clientid in (SELECT c.id FROM `client` c where c.parentid=0 and c.active=1 and c.firmid=".$firmbranch.") and clientbranchid=0 GROUP by (documentid)) x where x.badet=(SELECT count(c.id) FROM `client` c where c.parentid=0 and c.active=1 and c.firmid=".$firmbranch.")";
		// }
		// else if($clientb_yetki)
		// {
			// $sql = "select * from ( SELECT d.id,(SELECT COUNT(*) FROM documentviewfirm dwf WHERE dwf.clientid = ".$client." AND dwf.clientbranchid!= 0 AND dwf.documentid = d.id) AS verilen_yetki, (SELECT COUNT(*) FROM client c WHERE c.isdelete=0 and c.parentid=".$client.") AS firm_count FROM documents d) s where s.verilen_yetki=s.firm_count";			
		// }
		// $results = Yii::app()->db->createCommand($sql)->queryAll();
		// return $results;
	// }
	
	public function newFCsubdocumentAdd($firm=0,$firmbranch=0,$client=0,$clientbranch=0)
	{
		$firm=intval($firm);
		$firmbranch=intval($firmbranch);
		$client=intval($client);
		$clientbranch=intval($clientbranch);
	
		if($firm!=0 && $firmbranch==0)
		{
			$sql = "select * from (select d.*, 
			(select count(dw2.id) from documentviewfirm dw2 where dw2.firmid!=0 and dw2.branchid=0 and dw.documentid=dw2.documentid) verilen_yetki,
			(select count(f.id) from firm f where f.isdelete=0 and f.parentid=0 and f.id!=".$firm." )
			toplam_musteri from documentviewfirm dw left join documents d on d.id=dw.documentid group by documentid)k 
			where verilen_yetki>=toplam_musteri;";	
		}
		else if($firmbranch!=0 && $client==0)
		{
			$sql = "select * from (select d.*, 
			(select count(dw2.id) from documentviewfirm dw2 wheredw2.firmid=".$firm." and dw2.branchid!=0 and dw2.clientid=0 and dw.documentid=dw2.documentid) verilen_yetki,
			(select count(f.id) from firm f where f.isdelete=0 and f.parentid=".$firm." and f.id!=".$firmbranch.")
			toplam_musteri from documentviewfirm dw left join documents d on d.id=dw.documentid where dw.firmid=".$firm." group by documentid)k 
			where verilen_yetki>=toplam_musteri;";
		}
		else if($client!=0 && $clientbranch==0)
		{
			
			$sql = "select * from (select d.*, 
			(select count(dw2.id) from documentviewfirm dw2 where dw2.firmid!=0 and dw2.branchid=".$firmbranch." and dw2.clientid!=0 and dw2.clientbranchid=0 and dw.documentid=dw2.documentid) verilen_yetki,
			(select count(c.id) from client c where c.isdelete=0 and c.firmid=".$firmbranch." and c.id!=".$client." and c.parentid=0)
			toplam_musteri from documentviewfirm dw left join documents d on d.id=dw.documentid where dw.branchid=".$firmbranch." group by documentid)k 
			where verilen_yetki>=toplam_musteri;";
			
		}
		else if($client!=0 && $clientbranch!=0)
		{
			
			$sql = "select * from (select d.*, 
			(select count(dw2.id) from documentviewfirm dw2 where dw2.firmid!=0 and dw2.clientid=".$client." and dw2.clientbranchid!=0 and dw.documentid=dw2.documentid) verilen_yetki,
			(select count(c.id) from client c where c.isdelete=0 and c.parentid=".$client." and c.id!=".$clientbranch.")
			toplam_musteri from documentviewfirm dw left join documents d on d.id=dw.documentid where dw.clientid=".$client." group by documentid)k 
			where verilen_yetki>=toplam_musteri;";
		}
		
				
	    $results = Yii::app()->db->createCommand($sql)->queryAll();
		$ax= User::model()->userobjecty('');
		foreach($results as $resultsx)
		{
			
				$newDocument=new Documentviewfirm();
				$newDocument->documentid=$resultsx['id'];
				$newDocument->viewerid=$ax->id;
				$newDocument->type=$ax->type;
				$newDocument->firmid=$firm;
				$newDocument->branchid=$firmbranch;
				$newDocument->clientid=$client;
				$newDocument->clientbranchid=$clientbranch;
				$newDocument->createdtime=time();
				$newDocument->save();
			
		}
	}
	
	
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Documents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}