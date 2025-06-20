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
 * @property string $address2
 * @property string $address3
 * @property string $town_or_city
 * @property string $postcode
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
 * @property integer $country_id
  * @property string $client_code
 
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
			array('branchid, parentid, active, isdelete, firmid, iskdv,country_id, productsamount', 'numerical', 'integerOnly'=>true),
			array('client_code,county,name, title, taxoffice, taxno, address,address2,address3,address4,town_or_city,postcode, landphone, email, image, barcode, username, contractstartdate, contractfinishdate', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('client_code,id, branchid, parentid, name, title, taxoffice, taxno, address,address2,address3,address4,town_or_city,postcode, landphone, email, image, active, barcode, isdelete, firmid, username, contractstartdate, contractfinishdate, iskdv,country_id, productsamount,json_notes', 'safe', 'on'=>'search'),
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
			'address2' => 'Address2',
			'address3' => 'Address3',
			'address4' => 'Address4',
			'town_or_city' => 'town or city',
			'postcode' => 'post code',
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
			'country_id' => 'country_id',
			'productsamount' => 'Productsamount',
			'client_code' => 'Client Kodu',
			'json_notes' => 'json_notes',
			
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
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('address3',$this->address3,true);
		$criteria->compare('address4',$this->address4,true);
		$criteria->compare('postcode',$this->postcode,true);
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('productsamount',$this->productsamount);
		$criteria->compare('json_notes',$this->json_notes);

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


public function objectToArray($obj)
{
	$donecek=[];
	if(gettype($obj)=='array' or gettype($obj)=='object')
	{
		foreach($obj as $objx)
		{
			$donecek[]=$objx;
		}
	}
	else {
		$donecek[]=$obj;
	}
	return $donecek;
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
	
		if(intval($ax->firmid)==0)//firm
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

		if(intval($ax->firmid)>0 && intval($ax->branchid)==0)//branch
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

		if(intval($ax->branchid)>0 && intval($ax->clientid==0))//client
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

		if(intval($ax->clientid>0) && intval($ax->clientbranchid==0))//clientbranch
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
						 <img src="<?if($admin[$i]['firmimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['firmimage'];?><?}else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?}?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['firmname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Firm</p>

					</div>
				</div>
			</a>

		<?}
	}


	public function sqlbranch($where)
	{

		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/firm/staff?type=branch&&id=<?=$admin[$i]['firmbranchid'];?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?if($admin[$i]['firmbranchimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['firmbranchimage'];?><?}else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?}?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['firmbranchname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Branch</p>

					</div>
				</div>
			</a>

		<?}
	}



	public function sqlclient($where)
	{

		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/client/detail/<?=$admin[$i]['clientid'];?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?if($admin[$i]['clientimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['clientimage'];?><?}else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?}?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['clientname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Client</p>

					</div>
				</div>
			</a>

		<?}
	}




	public function sqlclientbranch($where)
	{


		$admin=Yii::app()->db->createCommand('SELECT firm.id as firmid,firm.image as firmimage,firm.name as firmname,firmbranch.id as firmbranchid,firmbranch.image as firmbranchimage,firmbranch.name as firmbranchname,client.id as clientid,client.image as clientimage,client.name as clientname,cmm.id as clientbranchid,cmm.image as clientbranchimage,cmm.name as clientbranchname FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as cmm ON cmm.parentid=client.id '.$where)->queryall();

		for($i=0;$i<count($admin);$i++)
		{?>
			<a href='/client/branches/<?=$admin[$i]['clientbranchid'];?>'>
				<div class="media">
					<div class="media-left align-self-center" style='margin-right:10px'>
						 <img src="<?if($admin[$i]['clientbranchimage']!=''){?><?=Yii::app()->baseUrl.'/'.$admin[$i]['clientbranchimage'];?><?}else{?><?=Yii::app()->theme->baseUrl.'/app-assets/images/staff-logo-mrs.png';?><?}?>" style="width: 36px;height: 36px;border-radius: 50%;"  alt="Company image">
					</div>
					<div class="media-body" style='margin-top: 15px;'>
						<h6 class="media-heading">
							<?=$admin[$i]['clientbranchname'];?>

						</h6>
						<p class="notification-text font-small-3 text-muted">Client Branch</p>

					</div>
				</div>
			</a>

		<?}
	}
	
	
	public function sqlaktiviterapor($where,$dep,$sub,$new=0,$debugs=0)
	{
		$response=Yii::app()->db->createCommand()
		->select("sum(value) valx")
		->from('mobileworkordermonitors mwm')
		->leftJoin('mobileworkorderdata mwd','mwd.mobileworkordermonitorsid = mwm.id')
		->leftJoin('firm f','f.id = mwm.firmid')
		->leftJoin('monitoring m','m.id=mwm.monitorid');
		// ->leftJoin('monitoring m','mwd.monitorid = m.id')
		if($dep)
		{
			$response=$response->leftJoin('departments d','mwm.departmentid = d.id');
		}
		if($sub)
		{
			$response=$response->leftJoin('departments sd','mwm.subdepartment = sd.id');
		}
		// 
		// 
		if($new==0)
		{
			$response=$response->where($where.' and IF(f.country_id=2,mwd.petid!=25,1) ');
		}
		else
		{
			$response=$response->where($where);
		}
		 
		// $response=$response->where($where);
		// echo $response=$response->getText();
		// exit;
    if ($debugs==2) 
    {
      echo $debugs; var_dump($response);exit;
    }
		$response=$response->queryAll();
		return intval($response[0]['valx']);
	}
	

		public function clientList($request)
		{
			$ax= User::model()->userobjecty('');
			
		
		$response=Yii::app()->db->createCommand()
		->select("cb.*,IF(cb.simple_client=1,CONCAT(cb.name,' (Lite Client)'),cb.name) cblitename,s.name sector,IF(cb.firmid!=cb.mainfirmid and c.firmid!=cb.firmid,(select fk.name from firm fk where fk.id=cb.firmid),'No Transfer') istransfer
		")
		->from('client cb')
		->leftJoin('client c','c.id=cb.parentid')
		->leftJoin('firm b','b.id=c.firmid')
		->leftJoin('firm f','f.id=b.parentid')
		->leftJoin('sector s','s.id=c.branchid')
		->where('cb.isdelete=0');

		if($ax->firmid!=0 && $ax->branchid==0)
		{
			$response=$response->andwhere('f.id='.$ax->firmid);
		}
		if($ax->branchid!=0 && $ax->clientid==0)
		{
			
			$response=$response->andwhere('(b.id='.$ax->branchid.' or cb.firmid='.$ax->branchid.')');
		}
		if($ax->clientid!=0 && $ax->clientbranchid==0)
		{
			$response=$response->andwhere('c.id='.$ax->clientid);
		}
		if($ax->clientbranchid!=0)
		{
			$response=$response->andwhere('cb.id='.$ax->clientbranchid);
		}

		///kriterlere göre query and where
		if(isset($request['status']) && intval($request['status'])!==0)
		{
			$status=intval($request['status']);
			$response=$response->andwhere('cb.active='.$status);

		}
		if(isset($request['firm']) && $request['firm']!='' && $request['firm']!=0)
		{
				$response=$response->andwhere('f.id='.$request['firm']);
		}
		if(isset($request['branch']) && $request['branch']!='' && $request['branch']!=0)
		{
				$response=$response->andwhere('(b.id='.$request['branch'].' or cb.firmid='.$request['branch'].')');
		}
		
		if(isset($request['client']) && $request['client']!='' && $request['client']!=0)
		{
			$response=$response->andwhere('c.id='.$request['client']);
		}
	
		$response=$response->order("c.id asc")->queryAll();
		return ["response"=>$response,"status"=>"200"];
		}
  
  
  
  	public function createstaff($id,$clientmibranchmi='client',$username,$password,$email,$name,$surname,$active=1)
	{
      
      $username= str_replace(" ","",$username);
    $addstaff=[];
    $addstaff['Staffteamlist']['branchid']= $id;     
    $addstaff['type']=$clientmibranchmi;//branch oslaydı branch yazacaktık
    $addstaff['Staffteamlist']['authtype']=0;
    $addstaff['Staffteamlist']['username']=$username;
    $addstaff['Staffteamlist']['password']=$password;
    $addstaff['Staffteamlist']['email']=$email;
    $addstaff['Staffteamlist']['name']=$name;
    $addstaff['Staffteamlist']['surname']=$surname;
    $addstaff['Staffteamlist']['birthplace']='';
    $addstaff['Staffteamlist']['birthdate']='';
    $addstaff['Staffteamlist']['gender']='-1';
    $addstaff['Staffteamlist']['userlgid']='2';
    $addstaff['Staffteamlist']['phone']='';
    $addstaff['Staffteamlist']['active']=$active;
 
  
	//	$ax= User::model()->userobjecty('');


		$clientid=$addstaff['Staffteamlist']['branchid'];

			$usernames=User::model()->findAll(array(
								   'condition'=>'username=:username','params'=>array('username'=>$addstaff['Staffteamlist']['username'])
							   ));
			$emails=User::model()->findAll(array(
								   'condition'=>'email=:email','params'=>array('email'=>$addstaff['Staffteamlist']['email'])
							   ));

			if($addstaff['type']=='branch')
			{
				$url="branchstaff";
			}
			else
			{
				$url="staff";
			}
     
      if (count($usernames)>0 || count($emails)>0){
    $username=  $addstaff['Staffteamlist']['username'] = $addstaff['Staffteamlist']['username'].'duplicated'.rand(0,10000);
       $addstaff['Staffteamlist']['email'] = $addstaff['Staffteamlist']['email'].'duplicated'.rand(0,10000);
        
        
                	$usernames=User::model()->findAll(array(
								   'condition'=>'username=:username','params'=>array('username'=>$addstaff['Staffteamlist']['username'])
							   ));
			$emails=User::model()->findAll(array(
								   'condition'=>'email=:email','params'=>array('email'=>$addstaff['Staffteamlist']['email'])
							   ));
      }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($addstaff['Staffteamlist']) && count($usernames)==0 && count($emails)==0)
		{

			$userstaff=new User;
			$userstaff->firmid=$ax->firmid;

			if($addstaff['type']=='branch')
			{
				$url="branchstaff";
				$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientid)));
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$client->firmid)));

				$userstaff->firmid=$firm->parentid;
				$userstaff->branchid=$client->firmid;
				$userstaff->mainbranchid=$client->firmid;
				$userstaff->clientid=$client->parentid;
				$userstaff->clientbranchid=$clientid;
				$userstaff->mainclientbranchid=$clientid;

				$firmtype='clientbranch';
			}
			else
			{
				$url="staff";
				$client=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$clientid)));
				$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$client->firmid)));
				$userstaff->firmid=$firm->parentid;
				$userstaff->branchid=$firm->id;
				$userstaff->mainbranchid=$firm->id;
				$userstaff->clientid=$clientid;
				$userstaff->mainclientbranchid=0;

				$firmtype='client';
			}



			$userstaff->username=$addstaff['Staffteamlist']['username'];
			$userstaff->name=$addstaff['Staffteamlist']['name'];
			$userstaff->surname=$addstaff['Staffteamlist']['surname'];
			$userstaff->password=CPasswordHelper::hashPassword($addstaff['Staffteamlist']['password']);
			$userstaff->email=$addstaff['Staffteamlist']['email'];
			$userstaff->createduser=1;//$ax->id;
			$userstaff->userlgid=$addstaff['Staffteamlist']['userlgid'];
			$userstaff->active=$addstaff['Staffteamlist']['active'];

			$userstaff->createdtime=time();
			$userstaff->code=User::model()->authcode(12,1,"lower_case,upper_case,numbers")[0];

			$type="";
			if ($addstaff['authtype']==0 || $addstaff['authtype']==2)
			{
				$type="Admin";
			}
			if ($addstaff['authtype']==1 || $addstaff['authtype']==3)
			{
				$type="Staff";
			}



			if($addstaff['authtype']==2 || $addstaff['authtype']==3)
			{
				$userstaff->ismaster=1;
			}
			else
			{
				$userstaff->ismaster=0;
			}

			if($firmtype=='client')
			{
				 $userstaff->type=Authtypes::model()->find(array('condition'=>"name='Customer ".$type."'"))->id;
			}
			else
			{
				 $userstaff->type=Authtypes::model()->find(array('condition'=>"name='Customer Branch ".$type."'"))->id;
			}

			$userstaff->image='';
			$userstaff->authgroup='';
			$userstaff->languageid=0;
			$userstaff->color="";
			if(!$userstaff->save())
			{
     var_dump($userstaff->geterrors());
      }
      
      		// conformity email eðer admin ise yetki veriliyor
				if ($addstaff['Staffteamlist']['authtype']==0 || $addstaff['Staffteamlist']['authtype']==2){
						$conformityemail=new Generalsettings;
						$conformityemail->type=0;
						$conformityemail->isactive=0;
						$conformityemail->name="conformityemail";
						$conformityemail->userid=$userstaff->id;
					  $conformityemail->save();
	          $conformityemailx=new Generalsettings;
						$conformityemailx->type=0;
						$conformityemailx->isactive=0;
						$conformityemailx->name="serviceemail";
						$conformityemailx->userid=$userstaff->id;
					  $conformityemailx->save();
				}




//echo User::model()->itemdelete($firmtype,$clientid);
			 $baseauthpath=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->itemdelete($firmtype,$clientid)."'"))->name;
//echo $baseauthpath;exit;
   $usstaffid=$userstaff->id;
   
		//	AuthAssignment::model()->createassignment($usstaffid,$baseauthpath.'.'.$type);
      	$item=new AuthAssignment;
		    $item->itemname=$baseauthpath.'.'.$type;
		    $item->userid=$usstaffid;
		
     		if(!$item->save())
			{ 
        var_dump($userstaff->geterrors());
      }

				// depertman and sub departman
				//departmaný kullanýcýya yetki verme
				$where='where user.id='.$userstaff->id.' and departments.parentid=0';
				User::model()->departmanpermission($where);
				//sub departmaný kullanýcýya yetki verme
				$where='where user.id='.$userstaff->id;
				User::model()->subdepartmanpermission($where);




			$usertaffinfo=new Userinfo;
			$usertaffinfo->id=$userstaff->id;
			$usertaffinfo->userid=$userstaff->id;
			$usertaffinfo->birthplace=$addstaff['Staffteamlist']['birthplace'];
			$usertaffinfo->birthdate=$addstaff['Staffteamlist']['birthdate'];
			$usertaffinfo->gender=$addstaff['Staffteamlist']['gender'];
			$usertaffinfo->primaryphone=$addstaff['Staffteamlist']['phone'];
			$usertaffinfo->identification_number="";
			$usertaffinfo->secondaryphone="";
			$usertaffinfo->country=0;
			$usertaffinfo->marital=0;
			$usertaffinfo->children=0;
			$usertaffinfo->address="";
			$usertaffinfo->address_country=0;
			$usertaffinfo->address_city=0;
			$usertaffinfo->blood="";
			$usertaffinfo->driving_licance="";
			$usertaffinfo->driving_licance_date="";
			$usertaffinfo->military=0;
			$usertaffinfo->educationid=0;
			$usertaffinfo->speaks="";
			$usertaffinfo->certificate="";
			$usertaffinfo->travel=0;
			$usertaffinfo->health_problem=0;

			$usertaffinfo->health_problem=0;
			$usertaffinfo->health_description="";
			$usertaffinfo->smoking=0;
			$usertaffinfo->emergencyname="";
			$usertaffinfo->emergencyphone="";
			$usertaffinfo->leavedate="";
			$usertaffinfo->leave_description="";
			$usertaffinfo->referance="";
			$usertaffinfo->projects="";
			$usertaffinfo->computerskills="";

			$usertaffinfo->save();


			$model=new Staffteamlist;
			$model->attributes=$addstaff['Staffteamlist'];
			$model->branchid=$clientid;
			$model->userid=$userstaff->id;
			$model->save();



		}else{
      
//echo 'xxxxxx';
    print_r($usernames);
      
     // echo 'yyyyyy'.PHP_EOL.PHP_EOL;
      print_r($emails);

		$error='';
		if(count($usernames)>0){$error='username'.$usernames;}
		if(count($email)>0){
			if($error=='')
			{
			$error='email'.$emails;
			}
			else
			{
				$error=$error.','.'email'.$emails.$usernames;

			}
		}

      
    }

		 //$mesaj=User::model()->dilbul(User::model()->find(array('condition'=>'id='.$ax->id))->languageid,$error.' '.'previously used');


		//Yii::app()->user->setFlash('error', $mesaj);
		//$this->redirect(array('/client/'.$url,'id'=>$clientid));
	}

public function bolumac($depsubmonpackage)
{
  
  foreach ($depsubmonpackage as $cbid=>$depsub){
      //cbid= clientbranch idsi
    foreach($depsub as $depname=>$subs){
      //$depname departman adı
      $departmentinfo['Departments']['clientid']=$cbid;
      $departmentinfo['Departments']['name']=$depname;
      $departmentinfo['Departments']['parentid']=0;
      $departmentinfo['Departments']['active']=1;
      
      $clientid=$departmentinfo['Departments']['clientid'];
      
      $department=Departments::model()->find(array(
                     'condition'=>'name=:name and clientid=:clientid and parentid=:parentid','params'=>array('name'=>$departmentinfo['Departments']['name'],'clientid'=>$departmentinfo['Departments']['clientid'],'parentid'=>$departmentinfo['Departments']['parentid'])
                   ));
      
      if(!$department)
      {
        $model=new Departments;
         $model->attributes=$departmentinfo['Departments'];
        if($model->save())
        {
            $where='where clientbranch.id='.$departmentinfo['Departments']['clientid'].' and departments.parentid=0';
             User::model()->departmanpermission($where);
        }else
        {
       var_dump($model->geterrors());
        }
           $depid=$model->id;
      }else{
        $depid=$department->id;
      }
      
     
        if ($depid==0 || strlen($depid)<1){
             print_r($departmentinfo).PHP_EOL.PHP_EOL.PHP_EOL;
             
           }
  
            $sira=0;
         foreach ($subs as $subname=> $monitors)
         {
           $sira++;
           echo $sira.'/'.$toplammonitor.PHP_EOL;
               $toplammonitor=count($monitors);
      //$subname = subdepartman adı
         
            $departmentinfo1['Departments']['clientid']=$cbid;
            $departmentinfo1['Departments']['name']=$subname;
            $departmentinfo1['Departments']['parentid']=$depid;
            $departmentinfo1['Departments']['active']=1;

            $clientid=$departmentinfo1['Departments']['clientid'];
            $model1=new Departments;
            $departmentx=Departments::model()->findAll(array(
                           'condition'=>'name=:name and clientid=:clientid and parentid=:parentid','params'=>array('name'=>$departmentinfo1['Departments']['name'],'clientid'=>$departmentinfo1['Departments']['clientid'],'parentid'=>$departmentinfo1['Departments']['parentid'])
                         ));
            if(!$departmentx)
            {
              $model1->attributes=$departmentinfo1['Departments'];
              if($model1->save())
              {
                $where='where clientbranch.id='.$departmentinfo1['Departments']['clientid'];
                User::model()->subdepartmanpermission($where);

              }else
              {
                var_dump($model1->geterrors());
              }
               $subdepid=$model1->id;
            }else{
               $subdepid=$departmentx->id;
            }
           
           
                 
           if ($subdepid==0 || strlen($subdepid)<1){
             print_r($departmentinfo1).PHP_EOL.PHP_EOL.PHP_EOL;
             
           }
                      
   /*        Monitoring[clientid]: 7335
Monitoring[active]: 1
Monitoring[dapartmentid]: 31071
Monitoring[subid]: 31072
Monitoring[mno]: 1
Monitoring[mlocationid]: 3
Monitoring[mtypeid]: 19
Monitoring[definationlocation]: açıklama
      */
           foreach ($monitors as $monitoradd){
                     $pmonitor=[];
if ($monitoradd['definationlocation']==''){
  $monitoradd['definationlocation']='.';
}
                     $pmonitor['Monitoring']['clientid']=$cbid;
                     $pmonitor['Monitoring']['active']=1;
                     $pmonitor['Monitoring']['dapartmentid']=$depid;
                     $pmonitor['Monitoring']['subid']=$subdepid;
                     $pmonitor['Monitoring']['mno']=$monitoradd['mno'];
                     $pmonitor['Monitoring']['mlocationid']=$monitoradd['mlocationid'];
                     $pmonitor['Monitoring']['mtypeid']=$monitoradd['mtypeid'];
                     $pmonitor['Monitoring']['definationlocation']=$monitoradd['definationlocation'];
                     $pmonitor['Monitoring']['techdescription']=$monitoradd['techdescription'];



                       $clientid=$pmonitor['Monitoring']['clientid'];

              $modelm=new Monitoring;
              $monitoring2=Monitoring::model()->findAll(array(
                             'condition'=>'mno='.$pmonitor['Monitoring']['mno'].' and clientid='.$cbid,
                           ));




                if(isset($pmonitor['Monitoring']) && count($monitoring2)==0)
                {

                  $modelm->attributes=$pmonitor['Monitoring'];
                  $dynamicstring=Monitoring::model()->barkodeControl(time()+rand(0,999999)+round(microtime(true) * 1000));
                  $modelm->barcodeno=$dynamicstring;
                  $modelm->createdtime=time();
                  $modelm->activetime=time();
                  $modelm->passivetime=0;
                  $modelm->techdescription=$pmonitor['Monitoring']['techdescription'];
                  
                  	if(!$modelm->save())
			{
     var_dump($modelm->geterrors());
      }
                  /*
                  $ids=array();
                  $monitorolurturma=1;
                  array_push($ids,$dynamicstring);
                  include("./barcode/monitorBarcodeList.php");
                  echo json_encode('ok');
                  */
                }

           }
           
           
           

        }
    
    
    
    }
 // $depsubmonpackage
  /*Departments[clientid]: 13437
Departments[parentid]: 0
Departments[name]: test
Departments[active]: 1
  */
  } 
}

public function issimport()
{
 
  error_reporting (1);
  //amgen=>2209
  //veritabanına bağlan
  $dbh = new PDO('mysql:host=localhost;dbname=ioinsectram_issimport', 'ioinsectram_issimport', 'Alper.1234');
  $dbh->exec("SET NAMES 'utf8'");
  //// Clientları çek    
  $stmt = $dbh->prepare("SELECT * FROM `customers` where is_import=0 order by idCustomer asc  "); 
  $stmt->execute([]); 
  $clients  = $stmt->fetchAll();

  foreach ($clients as $client) 
  {
   echo 'girdi'.$client['CustomerName'];
    
      $stmtx = $dbh->prepare( "UPDATE `customers` SET `is_import` = '2'  where idCustomer=".$client['idCustomer']); 		
    $stmtx->execute([]); 
  
   
    // Client Contact bilgileri çekelim
    $stmtx = $dbh->prepare("SELECT * FROM `contacts` where idContact=".$client['idContact']); 		
    $stmtx->execute([]); 
    $contact  = $stmtx->fetch();

    //Client userlarını çekelim
    $stmty = $dbh->prepare("SELECT * FROM `systemusers` where idCustomer=".$client['idCustomer']); 		
    $stmty->execute([]); 
    $clientusers  = $stmty->fetchAll();

    //client Branchlarını çekelim
    $stmtz = $dbh->prepare("SELECT * FROM `sites` where idCustomer=".$client['idCustomer']); 		
    $stmtz->execute([]); 
    $clientbranchs  = $stmtz->fetchAll();
    
   
    $sector=Sector::model()->find(array('condition'=>'name="'.$client['CustomerIndustryType'].'"','params'=>array('')));
    if (!$sector){
      $sector=19;//other;
    }else{
      $sector=$sector->id;
    }
    $fid=800;// firmid
    $branchacilsinmi=0;
    if (count($clientbranchs)>0){
      $branchacilsinmi=1;
    }
    $id=0; // client branch yok id
    $name=$client['CustomerName'];
    $title=$client['CustomerName'];
    $taxoffice='';
    $taxno='';
    $sectorid=$sector;
    $officeno='';
     $email='';
    if (isset($contact['idContact']) ){
      $email=$contact['ContactEmail'];
    }
    $address='';
    $towncity='';
    $postcode='';
    $issimple=0;
    $contact_json=$contact;
    $jsonnotes=$client;
    $active=1;
    if ($client['CustomerAccountClosed']=='Y')
    {
      $active=0;        
    }
    $authuser='';
    $authuser=Firm::model()->usernameproduce($name);
    Yii::app()->getModule('authsystem');
    $model=new Client;
    if ( trim($name)==''){
      $xnamexx ='Client-'.(strlen($name)+strlen($title) +strlen($taxoffice) +strlen($taxno) +strlen($sectorid) +strlen($officeno) +strlen($address) +strlen($towncity) +strlen($postcode)+strlen($email) );
      $clientxx=Client::model()->findAll(array('condition'=>'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0','params'=>array('name'=>$xnamexx,'title'=>$title,'taxoffice'=>$taxoffice,'taxno'=>$taxno,'address'=>$address,'landphone'=>$officeno,'email'=>$email)));
    }else{
      $clientxx=Client::model()->findAll(array('condition'=>'name=:name and title=:title and taxoffice=:taxoffice and taxno=:taxno and 	address=:address and landphone=:landphone and email=:email and isdelete=0','params'=>array('name'=>$name,'title'=>$title,'taxoffice'=>$taxoffice,'taxno'=>$taxno,'address'=>$address,'landphone'=>$officeno,'email'=>$email)));
    }
    if(count($clientxx)==0)
    {
      $count=count(Client::model()->findAll(array('condition'=>"username Like '%".$username."%'")));
      $username=$authuser.($count+1);
      $model->branchid =$sectorid; // other tipi sektör
      $model->country_id =2;
      if ( trim($name)==''){
        $model->name ='Client-'.(strlen($name)+strlen($title) +strlen($taxoffice) +strlen($taxno) +strlen($sectorid) +strlen($officeno) +strlen($address) +strlen($towncity) +strlen($postcode)+strlen($email)  );
      }else{
        $model->name =$name;
      }
      $model->title =$title;
      $model->taxoffice =$taxoffice;
      $model->taxno =$taxno;
      $model->address =$address;
      $model->town_or_city =$towncity;
      $model->postcode =$postcode;
      $model->landphone =$officeno;
      $model->email =$email;
      $model->simple_client =$issimple;
      $model->json_notes=json_encode($jsonnotes,true);
      $model->contact_json=json_encode($contact_json,true);
      $model->parentid=0;
      $model->mainclientid=$id;
      $model->createdtime=time();
      $model->firmid=$fid;
      $firmm=Firm::model()->findByPk($model->firmid);			
      $model->mainfirmid=$fid;
      $model->username=$username;
      $model->active=$active;
      $model->save();
      $resultsadd=Documents::model()->newFCsubdocumentAdd($firmm->parentid,$firmm->id,$id==0?$model->id:$id,$id!=0?$model->id:0); 
      if($id==0)
      {
        $pname=AuthItem::model()->find(array('condition'=>"name Like '%".User::model()->itemdelete('firmbranch',$model->firmid)."'"))->name;
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
      
        
      foreach ($clientusers as $cuser)
      {
        Client::model()->createstaff($model->id,'client',strtolower($cuser['SystemUserFirstName'].'.'.$cuser['SystemUserSurname']).'','123456'.strtolower($cuser['SystemUserFirstName'][0].$cuser['SystemUserSurname'][0]),$cuser['SystemUserEmail'].'',$cuser['SystemUserFirstName'].'',$cuser['SystemUserSurname'],1);
        
      }
      
      
      $branchidx=0;
      if (count($clientbranchs)>0){
              $branchacilsinmi=0;//mecbur açacağız
      }else{
              $branchacilsinmi=1;//mecbur açacağız
      }
      
      foreach ($clientbranchs as $clientbranch){
        
        //Client userlarını çekelim
        $stmtynm = $dbh->prepare("SELECT * FROM `systemusers` where idSite=".$clientbranch['idSite']); 		
        $stmtynm->execute([]); 
        $clienbtusers  = $stmtynm->fetchAll();
        
        $stmta = $dbh->prepare("SELECT * FROM `locations` where idSite=".$clientbranch['idSite']); 		
        $stmta->execute([]); 
        $monitors  = $stmta->fetchAll();
        
        $model2=new Client;
        $model2->attributes=$model->attributes;
        $model2->name=$clientbranch['SiteName'].'';
        $model2->parentid=$model->id;
        $model2->firmid=$model->firmid;
        $count=count(Client::model()->findAll(array('condition'=>"username Like '%".$username."%'")));
        $username2=$authuser.($count+1);
        $model2->username=$username2;
        $model2->mainfirmid=$model->firmid;
        $model2->mainclientid=$model->id;
        $model2->address =$clientbranch['SiteAddress1'];
        $model2->address2 =$clientbranch['SiteAddress2'];
        $model2->address3 =$clientbranch['SiteAddress3'];
        $model2->address4 =$clientbranch['SiteAddress4'];
        $model2->county =$clientbranch['SiteCounty'];
        $model2->country =$clientbranch['SiteCountry'];
        $model2->postcode =$clientbranch['SitePostcode'];
        $model2->createdtime=time();
        $model2->json_notes=json_encode($clientbranch,true);
        $model2->monitor_json=json_encode($monitors,true);
        if ($clientbranch['SiteAccountClosed']=='Y'){
           $model2->active =0;
        }        
        $model2->save();
                  
                
        $resultsadd=Documents::model()->newFCsubdocumentAdd($firmm->parentid,$firmm->id,$model->id,$model2->id); 
         
        AuthItem::model()->createitem($pname.'.'.$username.'.'.$username2,0);
         
        AuthItem::model()->generateparentpermission($pname.'.'.$username.'.'.$username2);
          
        AuthItem::model()->createnewauth($pname.'.'.$username,$username2,'Branch');
          
                
        
        // client branch userleri ekle
        

        foreach ($clienbtusers as $cbuser)
        {
          Client::model()->createstaff($model2->id,'branch',strtolower($cbuser['SystemUserFirstName'].'.'.$cbuser['SystemUserSurname']).'','123456'.strtolower($cbuser['SystemUserFirstName'][0].$cbuser['SystemUserSurname'][0]),$cbuser['SystemUserEmail'].'',$cbuser['SystemUserFirstName'].'',$cbuser['SystemUserSurname'],1);

        }
        
        
     
        $depsubmonpackage=[];
       $barcodebase=time();
        $monitorid=0; 
        
        foreach ($monitors as $monitor) {
          if ($monitor['LocationRemoved']<>'') continue;
     
          $stmtr = $dbh->prepare("SELECT * FROM `assets` where idLocation=".$monitor['idLocation']); 		
          $stmtr->execute([]); 
          $montyp  = $stmtr->fetch();
					$montypx='???';
          $assettype=$montyp['idAssetType'];
          
          if ($assettype=='2') continue;
               $monitorid++;
          $realassettype=0;
          $locationType=$monitor['LocationType'];
          if ($locationType=='External'){
            $locationType='3';
          }
          if ($locationType=='Internal'){
            $locationType='4';
          }
          if ($locationType=='High Risk'){
            $locationType='4';
          }
          switch ($assettype) {
            case "1":
              $realassettype=27;
              break;
            case "2":
                   $realassettype=-2;
              break;
            case "3":
                   $realassettype=29;
              break;
            case "4":
                   $realassettype=19;
              break;
            case "5":
                   $realassettype=33;
              break;
            case "6":
                   $realassettype=9;
              break;
            case "7":
                   $realassettype=24;
              break;
            case "8":
                   $realassettype=24;
              break;
            case "9":
                   $realassettype=32;
              break;
            case "10":
                   $realassettype=33;
              break;
            case "11":
                   $realassettype=24;
              break;
            case "12":
                   $realassettype=27;
              break;
            case "13":
                   $realassettype=29;
              break;
            case "14":
                   $realassettype=29;
              break;
            default:
                   $realassettype=-1;
          }

          
          $bolum='other';
          $altbolum='other';
          
          $monitor['LocationArea']=trim(ucwords(strtolower($monitor['LocationArea']) ));
          $monitor['LocationDescription']=trim(ucwords(strtolower($monitor['LocationDescription'])));
          if ($monitor['LocationArea']<>''){
            $bolum=$monitor['LocationArea'];
            $altbolum=$monitor['LocationArea'];
          }else{
            $bolum=$monitor['LocationDescription'];
           
            
          }
          
          $altbolum=$monitor['LocationDescription'];
          $packs=[];
          $packs['mno']=$monitorid;
          $packs['barcodeno']=$barcodebase+$monitorid;
          $packs['mtypeid']=$realassettype;
          $packs['mlocationid']=$locationType;
          $packs['definationlocation']=$monitor['LocationReference'];
          $packs['techdescription']=$monitor['LocationIssDescription'];
          $packs['active']=1;
          $packs['createdtime']=$barcodebase;
          $packs['activetime']=$barcodebase;
            
          $depsubmonpackage[$model2->id][$bolum][$altbolum][]=$packs;
          
          
          
          //$depsubmonpackage
       
         /* if (isset($montyp['idAssetType'])) {
              $stmtsr = $dbh->prepare("SELECT * FROM `assettypes` where idAssetType=".$montyp['idAssetType']); 		
              $stmtsr->execute([]); 
              $montyps  = $stmtsr->fetch();
              $montypx=$montyps['AssetDescription'];
          }*/
        }
     // print_r($depsubmonpackage);
        $this->bolumac($depsubmonpackage);
  echo time().'finish'.PHP_EOL;
       // 
        //client bracnh bölüm, altbölümleri ekle, monitör tanımla
        
        
      
        
        
        
        
        
        
      }
        
      $stmtx = $dbh->prepare( "UPDATE `customers` SET `is_import` = '1'  where idCustomer=".$client['idCustomer']); 		
    $stmtx->execute([]); 
  
   

      if($branchacilsinmi==1)
      {
        $model2=new Client;
        $model2->attributes=$model->attributes;
        $model2->name=$model->name.' - Branch';
        $model2->parentid=$model->id;
        $model2->firmid=$model->firmid;
        $count=count(Client::model()->findAll(array('condition'=>"username Like '%".$username."%'")));
        $username2=$authuser.($count+1);
        $model2->username=$username2;
        $model2->mainfirmid=$model->firmid;
        $model2->mainclientid=$model->id;
        $model2->createdtime=time();
        $model2->json_notes=json_encode([]);
        $model2->save();
         $resultsadd=Documents::model()->newFCsubdocumentAdd($firmm->parentid,$firmm->id,$model->id,$model2->id); 
        AuthItem::model()->createitem($pname.'.'.$username.'.'.$username2,0);
        AuthItem::model()->generateparentpermission($pname.'.'.$username.'.'.$username2);
        AuthItem::model()->createnewauth($pname.'.'.$username,$username2,'Branch');
      }
      
      
      
      
    
    }
  }
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
