<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property integer $branchid
 * @property integer $parentid
 * @property string $name
 * @property string $title
 * @property string $taxoffice
 * @property string $taxno
 * @property string $address
 * @property string $landphone
 * @property string $email
 * @property string $image
 * @property integer $active
 * @property string $barcode
 * @property integer $isdelete
 * @property integer $firmid
 * @property string $username
 * @property string $contractstartdate
 * @property string $contractfinishdate
 * @property integer $iskdv
 * @property integer $productsamount
 */
class Client extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentid, name', 'required'),
			array('branchid, parentid, active, isdelete, firmid, iskdv, productsamount', 'numerical', 'integerOnly'=>true),
			array('name, title, taxoffice, taxno, address, landphone, email, image, barcode, username, contractstartdate, contractfinishdate', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, branchid, parentid, name, title, taxoffice, taxno, address, landphone, email, image, active, barcode, isdelete, firmid, username, contractstartdate, contractfinishdate, iskdv, productsamount', 'safe', 'on'=>'search'),
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
			'branchid' => 'SECTOR ID',
			'parentid' => 'Parent ID',
			'name' => 'Müşteri Adı',
			'title' => 'Başlık',
			'taxoffice' => 'Vergi Dairesi',
			'taxno' => 'Vergi Dairesi No',
			'address' => 'Address',
			'landphone' => 'Landphone',
			'email' => 'Email',
			'image' => 'Image',
			'active' => 'Durum',
			'barcode' => 'Barcode',
			'isdelete' => 'Isdelete',
			'firmid' => 'Firmid',
			'username' => 'Username',
			'contractstartdate' => 'Contractstartdate',
			'contractfinishdate' => 'Contractfinishdate',
			'iskdv' => 'Iskdv',
			'productsamount' => 'Productsamount',
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
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('taxoffice',$this->taxoffice,true);
		$criteria->compare('taxno',$this->taxno,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('landphone',$this->landphone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('isdelete',$this->isdelete);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('contractstartdate',$this->contractstartdate,true);
		$criteria->compare('contractfinishdate',$this->contractfinishdate,true);
		$criteria->compare('iskdv',$this->iskdv);
		$criteria->compare('productsamount',$this->productsamount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function changeactive($id,$isactive)
	{
		$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($client)
		{
			$client->active=$isactive;
			if(!$client->update())
			{
				print_r($client->getErrors());
			}
			
			return true;
		}
		else
		{
			echo "bulamadım";exit;
		}
	}
	public function getbranchids($clientid)
	{
		$list=Client::model()->findall(array('condition'=>'parentid='.$clientid));
		$return=array();
		array_push($return,$clientid);
		foreach($list as $item)
		{
			array_push($return,$item->id);
		}
		return $return;

	}


	public function userfirmname($id=0)
	{	
		$ax= User::model()->userobjecty('');
		if($id==0)
		{
			$id=$ax->id;
			$user=User::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$user->firmid)));
		}
		else
		{
			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		}
		
		$firmname=Firm::model()->usernameproduce($firm->name);
		 $firmname=$this->parentfirm($firm->parentid,$firmname);

		return $firmname;

	}

	public function getclientname($id=0)
	{
		$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if ($client){return $client->name;}
			
	}
	public function parentfirm($id,$name)
	{
		if($id!=0)
		{
			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
			$firmname=Firm::model()->usernameproduce($firm->name);
			$name=$firmname.'.'.$name;
			if($firm->parentid!=0)
			{
				return $this->parentfirm($id,$name);
			}

			return $name;

		}

		return $name;
	}



	public function departmentpermission($clientid,$departmentid,$subdepartmentid,$permission,$userid)
	{

		// $clientid.'.'.$departmentid.'.'.$subdepartmentid.'.'.$permission.'.'.$userid;
		$ispermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$clientid.' and departmentid='.$departmentid.' and subdepartmentid='.$subdepartmentid.' and userid='.$userid));
		if($permission==1)
		{
			if(count($ispermission)==0)
			{
				$model=new Departmentpermission;
				$model->clientid=$clientid;
				$model->userid=$userid;
				$model->departmentid=$departmentid;
				$model->subdepartmentid=$subdepartmentid;
				if($model->save())
				{ 
					if($subdepartmentid==0)
					{
						$issubd=Departments::model()->findAll(array('condition'=>'clientid='.$clientid.' and parentid='.$departmentid));
						foreach($issubd as $issubdx)
						{
							$modelk=new Departmentpermission;
							$modelk->clientid=$clientid;
							$modelk->userid=$userid;
							$modelk->departmentid=$departmentid;
							$modelk->subdepartmentid=$issubdx->id;
							$modelk->save();
						}
					}
					return true;
				}
			}
		}
		else
		{
			if(count($ispermission)==1)
			{
				if($ispermission->delete())
				{
					if($subdepartmentid==0)
					{
							Departmentpermission::model()->deleteAll(array('condition'=>'clientid='.$clientid.' and departmentid='.$departmentid.' and userid='.$userid));
					
					}
					return true;
				}
			}
		}


		return false;
	}





	public function subdepartmentpermission($clientid,$userid,$departmentm,$subdepartmentm)
	{
		$departments=Departmentpermission::model()->findAll(array('condition'=>'clientid='.$clientid.' and userid='.$userid));
		
		//echo $clientid;
		$department='';
		$j=0;
		foreach($departments as $departmentsx)
		{
				if($j==0)
				{
					$department='('.$departmentm.'='.$departmentsx->departmentid.' and '.$subdepartmentm.'='.$departmentsx->subdepartmentid.')';
				}
				else
				{
					$department=$department.' or ('.$departmentm.'='.$departmentsx->departmentid.' and '.$subdepartmentm.'='.$departmentsx->subdepartmentid.')';
				}

				$j++;
				
		}

		return $department;

		
		// return $subdepartment;
	}

	public function istransfer($id)
	{
		$clients=Client::model()->find(array('condition'=>'id='.$id));
		$parentclient=Client::model()->find(array('condition'=>'id='.$clients->parentid));
		$transfer=0;
		if($clients->firmid!=$clients->mainfirmid and $parentclient->firmid!=$clients->firmid) 
		{
			  $transfer=1;
		}							
    
		return $transfer;
	}


	public function urlfirm($kelime)
	{
		$ax= User::model()->userobjecty('');
		if($ax->firmid==0)//firm
		{
			//firm dongusu
			$wherefirm='where firm.name LIKE "%'.$kelime.'%" group by firm.id';
			$sql=Client::model()->sqlfirm($wherefirm);
			//firmbranch dongusu
			$wherebranch='where firmbranch.name LIKE "%'.$kelime.'%" group by firmbranch.id';
			$sql=Client::model()->sqlbranch($wherebranch);
			//client dongusu
			$whereclient='where client.isdelete=0 and  client.name LIKE "%'.$kelime.'%" group by client.id';
			$sql=Client::model()->sqlclient($whereclient);
			//clientbranch dongusu
			$whereclientbranch='where cmm.isdelete=0 and cmm.name LIKE "%'.$kelime.'%" group by cmm.id';
			$sql=Client::model()->sqlclientbranch($whereclientbranch);
		
		}

		if($ax->firmid>0 && $ax->branchid==0)//branch
		{
			//firm dongusu
			$wherefirm='where firm.id='.$ax->firmid.' and firm.name LIKE "%'.$kelime.'%" group by firm.id';
			$sql=Client::model()->sqlfirm($wherefirm);
			//firmbranch dongusu
			$wherebranch='where firm.id='.$ax->firmid.' and firmbranch.name LIKE "%'.$kelime.'%" group by firmbranch.id';
			$sql=Client::model()->sqlbranch($wherebranch);
			//client dongusu
			$whereclient='where firm.id='.$ax->firmid.' and client.isdelete=0 and client.name LIKE "%'.$kelime.'%" group by client.id';
			$sql=Client::model()->sqlclient($whereclient);
			//clientbranch dongusu
			$whereclientbranch='where firm.id='.$ax->firmid.' and cmm.isdelete=0 and cmm.name LIKE "%'.$kelime.'%" group by cmm.id';
			$sql=Client::model()->sqlclientbranch($whereclientbranch);
		
		}

		if($ax->branchid>0 && $ax->clientid==0)//client
		{
			//firm dongusu
			$wherefirm='where firmbranch.id='.$ax->branchid.' and firm.name LIKE "%'.$kelime.'%" group by firm.id';
			$sql=Client::model()->sqlfirm($wherefirm);
			//firmbranch dongusu
			$wherebranch='where firmbranch.id='.$ax->branchid.' and firmbranch.name LIKE "%'.$kelime.'%" group by firmbranch.id';
			$sql=Client::model()->sqlbranch($wherebranch);
			//client dongusu
			$whereclient='where firmbranch.id='.$ax->branchid.' and client.isdelete=0 and client.name LIKE "%'.$kelime.'%" group by client.id';
			$sql=Client::model()->sqlclient($whereclient);
			//clientbranch dongusu
			$whereclientbranch='where firmbranch.id='.$ax->branchid.' and cmm.isdelete=0 and cmm.name LIKE "%'.$kelime.'%" group by cmm.id';
			$sql=Client::model()->sqlclientbranch($whereclientbranch);
		
		}

		if($ax->clientid>0 && $ax->clientbranchid==0)//clientbranch
		{
			//firm dongusu
			$wherefirm='where client.isdelete=0 and client.id='.$ax->clientid.' and firm.name LIKE "%'.$kelime.'%" group by firm.id';
			$sql=Client::model()->sqlfirm($wherefirm);
			//firmbranch dongusu
			$wherebranch='where client.isdelete=0 and client.id='.$ax->clientid.' and firmbranch.name LIKE "%'.$kelime.'%" group by firmbranch.id';
			$sql=Client::model()->sqlbranch($wherebranch);
			//client dongusu
			$whereclient='where client.isdelete=0 and client.id='.$ax->clientid.' and client.name LIKE "%'.$kelime.'%" group by client.id';
			$sql=Client::model()->sqlclient($whereclient);
			//clientbranch dongusu
			$whereclientbranch='where client.isdelete=0 and client.id='.$ax->clientid.' and cmm.name LIKE "%'.$kelime.'%" group by cmm.id';
			$sql=Client::model()->sqlclientbranch($whereclientbranch);
		}
	
	}


	public function sqlfirm($where)
	{

		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/firm/branch?type=firm&&id=<?=$admin[$i]['firmid']?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?php if($admin[$i]['firmimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['firmimage'];?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['firmname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Firm</p>

					</div>
				</div>
			</a>

		<?php }
	}


	public function sqlbranch($where)
	{

		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/firm/staff?type=branch&&id=<?=$admin[$i]['firmbranchid'];?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?php if($admin[$i]['firmbranchimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['firmbranchimage'];?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['firmbranchname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Branch</p>

					</div>
				</div>
			</a>

		<?php }
	}



	public function sqlclient($where)
	{

		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/client/detail/<?=$admin[$i]['clientid'];?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?php if($admin[$i]['clientimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['clientimage'];?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['clientname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Client</p>

					</div>
				</div>
			</a>

		<?php }
	}




	public function sqlclientbranch($where)
	{

		
		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/client/branches/<?=$admin[$i]['clientbranchid'];?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?php if($admin[$i]['clientbranchimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['clientbranchimage'];?><?php }else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?php }?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['clientbranchname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Client Branch</p>

					</div>
				</div>
			</a>

		<?php }
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
