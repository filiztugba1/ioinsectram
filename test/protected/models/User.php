<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $firmid
 * @property integer $branchid
 * @property integer $clientid
 * @property integer $clientbranchid
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $image
 * @property integer $type
 * @property string $authgroup
 * @property integer $userlgid
 * @property string $color
 * @property integer $active
 * @property integer $createduser
 * @property integer $createdtime
 * @property string $code
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
			array('firmid, branchid, clientid, clientbranchid, type, userlgid, active, createduser, createdtime', 'numerical', 'integerOnly'=>true),
			array('username, password, email', 'length', 'max'=>128),
			array('name, surname', 'length', 'max'=>30),
			array('image, authgroup, code', 'length', 'max'=>255),
			array('color', 'length', 'max'=>225),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firmid, branchid, clientid, clientbranchid, username, password, email, name, surname, image, type, authgroup, userlgid, color, active, createduser, createdtime, code', 'safe', 'on'=>'search'),
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
			'firmid' => 'Firmid',
			'mainbranchid' => 'mainbranchid',
			'branchid' => 'Branchid',
			'clientid' => 'Clientid',
			'clientbranchid' => 'Clientbranchid',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'name' => 'Name',
			'surname' => 'Surname',
			'image' => 'Image',
			'type' => 'Super Admin / Firm Admin / Firm Staff / Branch Admin / Branch Staff / Customer Admin / Customer Staff',
			'authgroup' => 'Authgroup',
			'userlgid' => 'Userlgid',
			'color' => 'Color',
			'active' => 'Active',
			'createduser' => 'Createduser',
			'createdtime' => 'Createdtime',
			'code' => 'Code',
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
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('mainbranchid',$this->mainbranchid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('authgroup',$this->authgroup,true);
		$criteria->compare('userlgid',$this->userlgid);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('createduser',$this->createduser);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


  public function getuserauths(){
     $yetkicache=filecached('yetki'.Yii::app()->user->id);
    if (!$yetkicache){
  		$items=AuthAssignment::model()->findall(array('condition'=>'userid='.Yii::app()->user->id, 'limit'=>'1','order'=>'data desc'));
      $yetkiname='';
      $topluizin=false;
      $yetkilistesi=[];
			if ($items)
			{
				foreach($items as $ite)
				{
          $yetkiname= $ite->itemname;
        }
        if ($yetkiname=='Superadmin'){
          $topluizin=true;
        }
        if ($yetkiname<>'' && $yetkiname<>'Superadmin'){
          			$access=AuthItemChild::model()->findAll(array('condition'=>'parent="'.$yetkiname.'"'));	
          	$access=AuthItemChild::model()->findAll(array('condition'=>'', 'group'=>'child'));	
                if ($access){
                  foreach ($access as $acc){
                    $yetkilistesi[$acc->child]=$acc->child;
                  }
                }
        }
        
        if ($yetkiname=='Superadmin'){
          	$access=AuthItemChild::model()->findAll(array('condition'=>' group by child'));	
                if ($access){
                  foreach ($access as $acc){
                    $yetkilistesi[$acc->child]=$acc->child;
                  }
                }
        }
      
      }
      if(is_countable($yetkilistesi) && count($yetkilistesi)>0){
        setfilecached('yetki'.Yii::app()->user->id,$yetkilistesi,8);
      }
   
    
  }else{
    $yetkilistesi=$yetkicache;
  }
    return $yetkilistesi;
  }

		public function getdata($id,$field)
	{	// field değeribe ne girilirse onu çeker
		$ax= User::model()->userobjecty('');

		if ( $id==0)
		{
			$id=$ax->id;
		}
		$user=$this->findbypk($id);
		if ($user)
		{
			return $user->$field;
		}
	}


	public function maxuserlimit($yetki,$type)
	{

		$package=explode('.',$yetki);
		$izin=1;




		$maxuser=Packages::model()->find(array('condition'=>'code="'.$package[0].'"'));

		$baseauthpath=AuthAssignment::model()->findAll(array('condition'=>"itemname='".$yetki.'.'.$type."'"));
		if($package[1]=='Entokorumailaclamafumigasyondanismanlikhizmltdsti11' && $package[0]=='Pro')
		{
		    $maxuser->maxtech++;
		}

		$baseauthpathffirm=AuthAssignment::model()->findAll(array('condition'=>"itemname='".$package[0].'.'.$package[1].'.'.$type."'"));
		$firmid=Firm::model()->find(array('condition'=>'username="'.$package[1].'"'));
		$firmBranchs=Firm::model()->findAll(array('condition'=>'parentid='.$firmid->id));
		$userLimitBranch=0;
		foreach($firmBranchs as $firmBranch)
		{
			$baseauthpathfbranch=AuthAssignment::model()->findAll(array('condition'=>"itemname='".$package[0].'.'.$package[1].'.'.$firmBranch->username.".Admin'"." or itemname='".$package[0].'.'.$package[1].'.'.$firmBranch->username.".Staff'"));
			$userLimitBranch=$userLimitBranch+count($baseauthpathfbranch);
		}


	/*	if(count($package)==2)
		{
			if($type=='Admin')
			{

				if(count($baseauthpath)>=$maxuser->maxfirmadmin && $maxuser->maxfirmadmin!=-1)
				{
					$izin=0;
				}
			}
			else
			{

				if(count($baseauthpath)>=$maxuser->maxtech && $maxuser->maxtech!=-1)
				{
					$izin=0;
				}

			}

		}
		else if(count($package)==3)
		{

			$baseauthpath=AuthAssignment::model()->findAll(array('condition'=>'itemname="'.$yetki.'.Admin"'.'or itemname="'.$yetki.'.Staff"'));


			if(count($baseauthpath)>=$maxuser->maxtech && $maxuser->maxtech!=-1)
				{
					$izin=0;
				}

		}
		*/

		if(count($package)==3)
		{
		$toplam=$userLimitBranch;
		if($toplam>=$maxuser->maxtech && $maxuser->maxtech!=-1)
			{
				$izin=0;
			}
		}

		return $izin;
	}


	public function maxuserlimitbranch($yetki,$type)
	{

		$package=explode('.',$yetki);
		$izin=1;

		$maxuser=Packages::model()->find(array('condition'=>'code="'.$package[0].'"'));


		if($package[1]=='Entokorumailaclamafumigasyondanismanlikhizmltdsti11' && $package[0]=='Pro')
		{
		    $maxuser->maxtech++;
		}

		return $maxuser->maxtech;
	}

	public function maxuserlimitfirm($yetki,$type)
	{

		$package=explode('.',$yetki);
		$izin=1;

		$maxuser=Packages::model()->find(array('condition'=>'code="'.$package[0].'"'));

        if($package[1]=='Entokorumailaclamafumigasyondanismanlikhizmltdsti11' && $package[0]=='Pro')
		{
		    $maxuser->maxfirmstaff++;
		}

		if($type=='Admin')
		{
			return $maxuser->maxfirmadmin;
		}
		else
		{
			return $maxuser->maxfirmstaff;
		}


	}



		public function getusername($id=0)
	{	// userin usernameini alır
		return	$this->getdata($id,'username');
	}

		public function getuseremail($id=0)
	{	// userin emailini alır
		return	$this->getdata($id,'email');
	}

		public function getuserid($id=0)
	{	// userin emailini alır
		return	$this->getdata($id,'id');
	}
		public function getuserfirms($id=0)
	{	// userin emailini alır
		if ($id==0)
		{
			$id=$this->getdata($id,'id');
		}
		$firm=AuthAssignment::model()->findall(array('condition'=>'userid='.$id));
		$list=array();
		foreach ($firm as $item)
		{	$firmusername=explode('.',$item->itemname);
			$firmid=Firm::model()->find(array('condition'=>'username="'.$firmusername[1].'"'));
			array_push($list,$firmid->id);
		}
		return $list;
	}

	public function getuserbranchs($id=0)
	{	// userin emailini alır
		if ($id==0)
		{
			$id=$this->getdata($id,'id');
		}
		$firm=AuthAssignment::model()->findall(array('condition'=>'userid='.$id));
		$list=array();
		foreach ($firm as $item)
		{	$firmusername=explode('.',$item->itemname);
			$firmid=Firm::model()->find(array('condition'=>'username="'.$firmusername[2].'"'));
			array_push($list,$firmid->id);
		}
		return $list;
	}



	public function getfirmclient($id=0)
	{	// userin emailini alır
		if ($id==0)
		{
			$id=$this->getdata($id,'id');
		}
		$client=AuthAssignment::model()->findall(array('condition'=>'userid='.$id));
		$list=array();
		foreach ($client as $item)
		{	$clientusername=explode('.',$item->itemname);
			$clientid=Client::model()->find(array('condition'=>'username="'.$clientusername[3].'"'));
			array_push($list,$clientid->id);
		}
		return $list;
	}


	public function getclientbranch($id=0)
	{	// userin emailini alır
		if ($id==0)
		{
			$id=$this->getdata($id,'id');
		}
		$client=AuthAssignment::model()->findall(array('condition'=>'userid='.$id));
		$list=array();
		foreach ($client as $item)
		{	$clientusername=explode('.',$item->itemname);
			$clientid=Client::model()->find(array('condition'=>'username="'.$clientusername[4].'"'));
			array_push($list,$clientid->id);
		}
		return $list;
	}





		public function changeactive($id,$isactive)
	{
		$user=User::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($user)
		{
			$user->active=$isactive;
			if(!$user->update())
			{
				print_r($user->getErrors());
			}

			return true;
		}
		else
		{
			echo "bulamadım";exit;
		}
	}


	public function usertypes($type)
	{

		$types=Authtypes::model()->findall(array('condition'=>'parentid=:id','params'=>array('id'=>$type)));
		foreach($types as $type){
		?>
		<option value="<?=$type->id;?>" selected><?=$type->name;?></option>
		<?php
			if($this->issubtype($type->id))
			{
				$this->usertypes($type->id);
			}
		}

	}

	static function issubtype($id)
	{
		$types=Authtypes::model()->findall(array('condition'=>'parentid=:id','params'=>array('id'=>$id)));
		if(count($types)!=0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	public function userobjecty($name='')
	{

		 $user=User::model()->find(array(
								   'condition'=>'id=:id','params'=>array('id'=>Yii::app()->user->id)
							   ));
		 if ($user)
		{
			$a=array('id'=> $user->id,
					'name'=>$user->name.' '.$user->surname,
					'username'=>$user->username,
					'firmid'=>$user->firmid,
					'branchid'=>$user->branchid,
					'clientid'=>$user->clientid,
					'clientbranchid'=>$user->clientbranchid,
					'type'=>$user->type,
					'mainclientbranchid'=>$user->mainclientbranchid,);
					return  (object)$a;
		}else
		{return false;}
		// return $user->$name;
	}


	public function itemdelete($type,$id)
	{

		if($type=='clientbranch')
		{
			$cb=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
			$c=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$cb->parentid)));
			$fb=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$c->firmid)));
			$f=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$fb->parentid)));

			$name=$f->username.'.'.$fb->username.'.'.$c->username.'.'.$cb->username;
		}


		if($type=='client')
		{
			$c=Client::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
			$fb=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$c->firmid)));
			$f=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$fb->parentid)));

			$name=$f->username.'.'.$fb->username.'.'.$c->username;
		}

		if($type=='firmbranch')
		{
			$fb=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
			$f=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$fb->parentid)));

			$name=$f->username.'.'.$fb->username;
		}

		if($type=='firm')
		{
			$f=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
			$name=$f->username;
		}


		return $name;


	}


	public function sqlcompany()
	{


		$ax= User::model()->userobjecty('');
		$name=$this->whopermission()->who;


		if($name=='admin'){$id=1; $sql='User';}
		if($name=='firm'){$id=$ax->firmid; $sql='Firm';}
		if($name=='branch'){$id=$ax->branchid; $sql='Firm';}
		if($name=='client'){$id=$ax->clientid; $sql='Client';}
		if($name=='clientbranch'){$id=$ax->clientbranchid; $sql='Client';}


		$company=$sql::model()->find(array('condition'=>'id='.$id));



		if($name=="admin")
		{
			 $a=array('id'=> $company->id,
				'username'=>$company->username,
				'password'=>$company->password,
				'email'=>$company->email,
				'name'=>$company->name,
				'image'=>$company->image,
				'sql'=>$sql,
				'surname'=>$company->surname);

		}
		else
		{

	    $a=array('id'=> $company->id,
				'name'=>$company->name,
				'title'=>$company->title,
				'taxoffice'=>$company->taxoffice,
				'taxno'=>$company->taxno,
				'address'=>$company->address,
				'landphone'=>$company->landphone,
				'email'=>$company->email,
				'sql'=>$sql,
				'image'=>$company->image);
		}


	return  (object)$a;
}

	public function userpackagename()
	{
		$ax= User::model()->userobjecty('');
		$name='';
		if($ax->firmid==0){$name='Superadmin';}
		if($ax->firmid>0){$name=Firm::model()->find(array('condition'=>'id='.$ax->firmid))->username;}
		if($ax->branchid>0){$name=$name.'.'.Firm::model()->find(array('condition'=>'id='.$ax->branchid))->username;}
		if($ax->clientid>0){$name=$name.'.'.Client::model()->find(array('condition'=>'id='.$ax->clientid))->username;}
		if($ax->clientbranchid>0){$name=$name.'.'.Client::model()->find(array('condition'=>'id='.$ax->clientbranchid))->username;}
		return $name;
	}


	public function whopermission()
	{

		$ax= User::model()->userobjecty('');
		$who='';
		if($ax->firmid==0 && $ax->branchid==0 && $ax->clientid==0 && $ax->clientbranchid==0)
		{
			$who='admin';
			$id=$ax->id;
			$type=0;
			$subtype=1;
		}
		else if($ax->firmid!=0 && $ax->branchid==0 && $ax->clientid==0 && $ax->clientbranchid==0)
		{
			$who='firm';
			$id=$ax->firmid;
			$type=1;
			$subtype=2;
		}
		else if($ax->firmid!=0 && $ax->branchid!=0 && $ax->clientid==0 && $ax->clientbranchid==0)
		{
			$who='branch';
			$id=$ax->branchid;
			$type=2;
			$subtype=3;
		}
		else if($ax->firmid!=0 && $ax->branchid!=0 && $ax->clientid!=0 && $ax->clientbranchid==0)
		{
			$who='client';
			$id=$ax->clientid;
			$type=3;
			$subtype=4;
		}
		else if($ax->firmid!=0 && $ax->branchid!=0 && $ax->clientid!=0 && $ax->clientbranchid!=0)
		{
			$who='clientbranch';
			$id=$ax->clientbranchid;
			$type=4;
			$subtype=0;
		}

		 $a=array('id'=>$id,
				'who'=>$who,
				'type'=>$type,
				'subtype'=>$subtype
			 );

		return  (object)$a;
	}


	public function geturl($name,$subname='',$id=0,$url1='',$tip=0,$firmidx=0)
	{
		if($tip!=1)
		{
			$subname=t($subname);
		}

		$ax= User::model()->userobjecty('');
		$where='branch';
		$type='firm';
		$url='<a href="/">'.t('Homepage').'</a>';
		if($name=='Firm'){if($ax->firmid==0){ $url=$url.' > <a href="/'.strtolower($url1).'">'.t($name).'</a>';}}
		else if($name=='Client'){if($ax->branchid==0){ $url=$url.' > <a href="/'.strtolower($url1).'">'.t($name).'</a>';}}
		else{ $url=$url.' > <a href="/'.strtolower($url1).'">'.t($name).'</a>';}
		if($id>0)
		{
			if($name=='Firm'){

			$firm=$name::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));


			if($firm->parentid>0)
			{
				$firm2=$name::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$firm->parentid)));




				if($firm2->package=='Packagelite')
					{
						$url=$url.' > <a href="/'.strtolower($name).'/branch?type=firm&&id='.$firm2->id.'" >'.$firm2->name.'</a>';
					}
				else
					{
						$url=$url.' > <a href="/'.strtolower($name).'/branch?type=firm&&id='.$firm2->id.'" >'.$firm2->name.'</a> > <a href="/'.strtolower($name).'/branch?type=branch&&id='.$firm->id.'" >'.$firm->name.'</a>';
					}


			}
			else
			{
				$url=$url.' > <a href="/'.strtolower($name).'/branch?type=firm&&id='.$firm->id.'" >'.$firm->name.'</a>';
			}

			}
			if($name=='Client')
			{

					$firm=$name::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
					if($firm->parentid==0)
					{
						$url=$url.' > <a href="/'.strtolower($name).'/detail?id='.$firm->id.'&firmid='.$firmidx.'" >'.$firm->name.'</a>';
					}
					else
					{
						$firm2=$name::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$firm->parentid)));
						if($ax->clientbranchid==0)
						{
						$url=$url.' > <a href="/'.strtolower($name).'/detail?id='.$firm2->id.'&firmid='.$firmidx.'" >'.$firm2->name.'</a>';
						}
						else
						{
							$url=$url.' > '.$firm2->name;
						}
						$url=$url.' > <a href="/'.strtolower($name).'/branches?id='.$firm->id.'&firmid='.$firmidx.'" >'.$firm->name.'</a>';
					}
					// $url=$url.' > '.t($subname);


			}

			if($name=='Conformity')
			{
				$firm=$name::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
				$url=$url.'  <a href="/conformity/activity/'.$firm->id.'" ><?=t("Activity")?></a>';

			}


		}

		if($subname!='')
			{
				$url=$url.' > '.$subname;
			}

		$logbutton='';
		if($ax->id==1 && $url1=='conformity')
		{
		$logbutton='<a href="/loglar?table='.$url1.'" class="btn btn-success btn-sm" style="float:right;color:#404e67;margin:0px 1px 0px 1px;border: 1px solid #404e67 !important;">'.t($url1.' Logs').'</a>';
		}

		$div='<div class=" row card">
				 <div class="card-header" style="padding-top: 10px;padding-bottom: 0;">
				 '.$logbutton.'
					<div class="row" style="">
						<p style="margin-left:16px">'.$url.'</p>

					</div>
				</div>
			</div>';

		return $div;
	}



/*
			public function staff()
			{
							$ax= User::model()->userobjecty('');

							$users=User::model()->findAll(array(
										   'condition'=>'firmid='.$ax->firmid,
									   ));

							foreach($users as $user)
							{
								$teams=Staffteam::model()->findAll();
								foreach($teams as $team)
								{
									if($this->isteamuser($user->id,$team->staff))
									{?>
										<option value="<?=$team->id;?>"><?=$team->teamname;?></option>
									<?php }
								}

							}

			}

			public function isteamuser($userid,$teamstaff)
			{
							$staff = explode(",",$teamstaff);
									for($i=0;$i<count($staff);$i++)
									{
										if($staff[$i]==$userid)
										{
											return true;
										}
									}
							return false;
			}
*/






	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */



	 	public function authcode($length,$count, $characters) {	//auth code


		// $length - the length of the generated password
		// $count - number of passwords to be generated
		// $characters - types of characters to be used in the password

		// define variables used within the function
			$symbols = array();
			$passwords = array();
			$used_symbols = '';
			$pass = '';

		// an array of different character types
			$symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
			$symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$symbols["numbers"] = '1234567890';
			$symbols["special_symbols"] = '!?~@#-_+<>[]{}';

			$characters = explode(",",$characters); // get characters types to be used for the passsword
			foreach ($characters as $key=>$value) {
				$used_symbols .= $symbols[$value]; // build a string with all characters
			}
			$symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

			for ($p = 0; $p < $count; $p++) {
				$pass = '';
				for ($i = 0; $i < $length; $i++) {
					$n = rand(0, $symbols_length); // get a random character from the string with all characters
					$pass .= $used_symbols[$n]; // add the character to the password string
				}
				$passwords[] = $pass;
			}

			return $passwords; // return the generated password
	}

	public function login()
	{
		$ax= $this->userobjecty('');
		if(!isset($ax->id))
		{?>
			<script type="text/javascript">
			window.location = "/site/login";
			</script>


		<?php		exit;
		}
	}

	public function permission($permission)
	{

		Yii::app()->getModule('authsystem');
		$auth=AuthAssignment::model()->find(array(
								   'condition'=>'userid=:id','params'=>array('id'=>Yii::app()->user->id)
							   ));





		$authpermission=AuthItemChild::model()->findall(array(
								   'condition'=>'child=:child','params'=>array('child'=>$permission)
							   ));

		return count($authpermission);

	}


	public function color($sayi)
	{
		$sayac=$sayi;

		while( ($sayi/1000)<=4 ) {
			$sayi=$sayi+$sayac;
		}
	return '#'.$sayi;
	}


	public function sqlwhere()
	{
		$ax= User::model()->userobjecty('');
		if($ax->firmid>0)
		{
			if($ax->branchid>0)
			{
				if($ax->clientid>0)
				{
					if($ax->clientbranchid>0)
					{
						$where="clientid=".$ax->clientbranchid;
					}
					else
					{
							$workorder=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
							$i=0;
							foreach($workorder as $workorderx)
							{
							if($i==0)
							{
								$where='clientid='.$workorderx->id;
							}
							else
							{
							$where=$where.' or clientid='.$workorderx->id;
							}

						}
					}
				}
				else
				{
					$where="branchid=".$ax->branchid;
				}
			}
			else
			{
				$where="firmid=".$ax->firmid;
			}
		}
		else
		{
			$where="";
		}

		return $where;

	}

	public function table($who,$id)
	{

		if($who=='firm')
		{
			$name=Firm::model()->find(array('condition'=>'id='.$id))->name;
		}
		else if($who=='branch')
		{
			$bname=Firm::model()->find(array('condition'=>'id='.$id));
			$fname=Firm::model()->find(array('condition'=>'id='.$bname->parentid));
			$name=$fname->name.' > '.$bname->name;
		}
		else if($who=='client')
		{
			$cname=Client::model()->find(array('condition'=>'id='.$id));
			$bname=Firm::model()->find(array('condition'=>'id='.$cname->firmid));
			$fname=Firm::model()->find(array('condition'=>'id='.$bname->parentid));

			$name=$fname->name.' > '.$bname->name.' > '.$cname->name;
		}
		else if($who=='clientbranch')
		{

			$cbname=Client::model()->find(array('condition'=>'id='.$id));
			$cname=Client::model()->find(array('condition'=>'id='.$cbname->parentid));
			$bname=Firm::model()->find(array('condition'=>'id='.$cname->firmid));
		$fname=Firm::model()->find(array('condition'=>'id='.$bname->parentid));


			$name=$fname->name.' > '.$bname->name.' > '.$cname->name.' > '.$cbname->name;
		}

		return $name;


	}


	public function iswhotable()
	{
		$who=$this->whopermission();
		$name='';
		$isactive=1;
		if($who->who=='firm')
		{
			$name=$this->table('firm',$who->id);
		}
		else if($who->who=='branch')
		{
			$name=$this->table('branch',$who->id);
		}
		else if($who->who=='client')
		{
			 $name=$this->table('client',$who->id);

		}
		else if($who->who=='clientbranch')
		{
			 $name=$this->table('clientbranch',$who->id);

		}
		 $a=array('isactive'=>$isactive,
				'name'=>$name
			 );

		return  (object)$a;

	}

	public function getauthcb($userid='0')
	{
		if ($userid==0)
		{
			$userid=Yii::app()->user->id;
		}
		$auths=AuthAssignment::model()->findall(array('condition'=>'userid='.$userid));
		if ($auths)
		{
			$returnauths=array();
			foreach ($auths as $auth)
			{
				array_push($returnauths,$auth->itemname);
			}
			return $returnauths;
		}
		return array();
	}

	public function getauthcbcheck($itemname,$userid='0')
	{
		if ($userid==0)
		{
			$userid=Yii::app()->user->id;
		}
		$auths=AuthAssignment::model()->find(array('condition'=>'userid='.$userid.' and itemname="'.$itemname.'"'));
		if ($auths)
		{
			return true;
		}else
		{return false;}
	}

	public function getauthstaffjsarr($userid='0')
	{
		$prm=$this->getauthcb($userid);
		foreach ($prm as $item)
		{

		}
	}

	public function getidfromauthname($name,$type)
	{
		if ($type=='firm')
		{
			$a=Firm::model()->find(array('condition'=>'username="'.$name.'"'));
			if ($a){ return $a->id;}
		}
		if ($type=='client')
		{
			$a=Client::model()->find(array('condition'=>'username="'.$name.'"'));
			if ($a){ return $a->id;}

		}
		return 0;

	}
	public function getnamefromauthname($name,$type)
	{
		if ($type=='firm')
		{
			$a=Firm::model()->find(array('condition'=>'username="'.$name.'"'));
			if ($a){ return $a->name;}
		}
		if ($type=='client')
		{
			$a=Client::model()->find(array('condition'=>'username="'.$name.'"'));
			if ($a){ return $a->name;}

		}
		return '';

	}



	public function setauthdefault($active)
	{
		$userid=Yii::app()->user->id;
		$auths=AuthAssignment::model()->find(array('condition'=>'userid='.$userid.' and itemname="'.$active.'"'));
		if ($auths)
		{
				$parts=explode('.',$active);
				 array_shift($parts);//ilk itemi sildik
				$level=count($parts);
				$firm=0;
				$branch=0;
				$client=0;
				$clientbranch=0;

				if($level>1){$firm=$this->getidfromauthname($parts[0],'firm');}
				if($level>2){$branch=$this->getidfromauthname($parts[1],'firm');}
				if($level>3){$client=$this->getidfromauthname($parts[2],'client');}
				if($level>4){$clientbranch=$this->getidfromauthname($parts[3],'client');}

				$user=User::model()->findbypk($userid);
				if ($user)
				{
					$user->firmid=$firm;
					$user->branchid=$branch;
					$user->clientid=$client;
					$user->clientbranchid=$clientbranch;
					if ($user->update()){
						$asx=AuthAssignment::model()->findall(array('condition'=>'userid='.$userid));
						foreach ($asx as $im)
						{
							if ($im->itemname<>$active){
									$im->data=null;
							}else{
									$im->data=1;
							}

									$im->update();
						}
					}

					header('Location: '. Yii::app()->request->getbaseUrl(true));
				}
		}
		return array();
	}
	public function getauthxname($active)
	{
		$userid=Yii::app()->user->id;
		$auths=AuthAssignment::model()->find(array('condition'=>'userid='.$userid.' and itemname="'.$active.'"'));
		if ($auths)
		{
				$parts=explode('.',$active);
				 array_shift($parts);//ilk itemi sildik
				$level=count($parts);
				$firm=0;
				$branch=0;
				$client=0;
				$clientbranch=0;

				if($level>1){$firm=$this->getnamefromauthname($parts[0],'firm');}
				if($level>2){$branch=$this->getnamefromauthname($parts[1],'firm');}
				if($level>3){$client=$this->getnamefromauthname($parts[2],'client');}
				if($level>4){$clientbranch=$this->getnamefromauthname($parts[3],'client');}
				if ($clientbranch<>'')
				{
					return $clientbranch;
				}else if ($client<>'')
				{
					return $client;
				}else if ($branch<>'')
				{
					return $branch;
				}else if ($firm<>'')
				{
					return $firm;
				}
				return '';
		}
	}


	public function datahanmail($password)
	{
			$ax= User::model()->userobjecty('');
			$user=User::model()->find(array('condition'=>'id='.$ax->id));

			$senderemail='info@insectram.io';//$firm->email;
			$sendername='insectram';
			$subject='Admin şifre değişikliği';
			$altbody='Değiştiren kişinin;id='.$user->id.' - Name and surname='.$user->name.' '.$user->surname.' - yeni şifre='.$password;
			// $msg='<b>Opened nonconformities:</b><br>'.$msg2;
			$msg='Değiştiren kişinin;id='.$user->id.' - Name and surname='.$user->name.' '.$user->surname.' - yeni şifre='.$password;

			$buyeremail='alperb@datahan.com';
			$buyername='Alper Barutçu';

			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//$buyeremail

			$buyeremail='fcurukcu@gmail.com';
			$buyername='Filiz Curukcu';

			Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//$buyeremail
	}




	public function newsupport()
	{
		$ax= User::model()->userobjecty('');
		$who=User::model()->whopermission();
		if($who->type==0)
			{
			//$firm=Firm::model()->findall(array('condition'=>'parentid=:parentid','params'=>array('parentid'=>0)));
			// Yollayamıcak
			$tickets=Tickets::model()->findAll(array('condition'=>'towhereid=2 and status=0'));
			}
			else if($who->type==1)
			{
			$type=2;
			$firm=0;
			$toid=0;
			$tickets=Tickets::model()->findAll(array('condition'=>'status=0 and towhereid=1 and toid='.$ax->firmid));
			$name1="SuperAdmin";
			// Superadmin'e yollucak
			}
			else if($who->type==2)
			{
			$type=1;
			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->branchid)));
			$tickets=Tickets::model()->findAll(array('condition'=>'towhereid=0 and status=0 and toid='.$firm->id));
			$toid=$firm->parentid;
			$firmn=Firm::model()->findByPk($toid);
			$name1=$firmn->name;
			}
			else if($who->type==3 || $who->type==4)
			{
			$type=0;
			$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$ax->branchid)));
			$toid=$firm->id;
			$firmn=Firm::model()->findByPk($toid);
			$name1=$firmn->name;
			}


		// $ticked=Tickets::model()->findAll(array('condition'=>'status=0'));
    if (is_countable($tickets)){
		return count($tickets);
      
    }else{
      
      return 0;
    }

	}


	/*
	public function newdocument($categoryid='')
	{
		$ax= User::model()->userobjecty('');
		$who=User::model()->whopermission();

		 $time=strtotime('-1 months');

		 if($categoryid!='')
		{
			$categoryid2=' and categoryid='.$categoryid;
		 }



		$documentsx=Documents::model()->findAll(array('order'=>'name ASC','condition'=>'createdtime>='.$time.$categoryid2.Documents::model()->parentdocument(),));







		if($who->type!=0){
			$whereview='';
			if($who->type==1)
			{
				$whereview='viewer=1 and firmtype=0 and createdtime>'.$time.$categoryid2;
			}
			else if($who->type==2)
			{
				$whereview='viewer=1 and firmtype=1 and firmid='.$ax->firmid.' and createdtime>'.$time.$categoryid2;
			}
			else if($who->type==3)
			{
				$whereview='viewer=1 and firmtype=2 and firmid='.$ax->branchid.' and createdtime>'.$time.$categoryid2;
			}
			else if($who->type==4)
			{
				$whereview='viewer=1 and firmtype=3 and firmid='.$ax->clientid.' and createdtime>'.$time.$categoryid2;
			}

				$documenty=Documents::model()->findAll(array('order'=>'name ASC','condition'=>$whereview));
			}

		 if($categoryid!='')
		{
			$categoryid2=' and documents.categoryid='.$categoryid;
		 }



		 $visit= Yii::app()->db->createCommand('SELECT documents.categoryid,documents.name,documents.fileurl,documents.type as documenttype,documentviewfirm.* FROM documents RIGHT JOIN documentviewfirm ON documents.id = documentviewfirm.documentid where documentviewfirm.type='.$who->type.' and documentviewfirm.viewerid='.$who->id.' and documentviewfirm.createdtime>'.$time.$categoryid2)->queryAll();


		  $newdocumnet=count($documentsx)+count($documenty)+count($visit);


		 return $newdocumnet;

	}
	*/

	public function newdocument($categoryid=0)
	{

		$ax= User::model()->userobjecty('');

		if($categoryid==0)
		{
			$categoryid='';
		}
		else
		{
			$categoryid=' and documents.categoryid='.$categoryid;
		}

		$document= Yii::app()->db->createCommand('SELECT documents.id as id,documents.categoryid as categoryid,documents.name as name,documents.fileurl as url,documents.type as type,documents.firmid as dfirmid,documents.branchid as dbranchid,documents.clientid as dclientid,documents.clientbranchid as dclientbranchid,documents.createdtime as createdtime,documentviewfirm.createdtime as vcreatedtime FROM documents INNER JOIN documentviewfirm ON documents.id = documentviewfirm.documentid where documentviewfirm.firmid='.$ax->firmid.' and documentviewfirm.branchid='.$ax->branchid.' and documentviewfirm.clientid='.$ax->clientid.' and documentviewfirm.clientbranchid='.$ax->clientbranchid.$categoryid.' GROUP BY documentviewfirm.documentid')->queryAll();


		$user= Yii::app()->db->createCommand('SELECT documents.id as id,documents.categoryid as categoryid FROM documents INNER JOIN userdocumentview ON documents.id = userdocumentview.documentid where userdocumentview.userid='.$ax->id.$categoryid)->queryAll();


		$newdocumnet=count($document)-count($user);
		if($newdocumnet<0)
		{
			$newdocumnet=0;

		}
		return $newdocumnet;

	}




	public function departmanpermission($where)
	{
		$select=Yii::app()->db->createCommand('SELECT user.id as userid,clientbranch.id as clientbranchid,departments.id as departmentsid from firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id INNER JOIN departments ON departments.clientid=clientbranch.id INNER JOIN user ON user.firmid=firm.id '.$where.' and ((user.branchid=0 and firm.id=user.firmid) or (user.clientid=0 and firmbranch.id=user.branchid) or (user.clientbranchid=0 and client.id=user.clientid) or (user.clientbranchid!=0 and user.clientbranchid=clientbranch.id))')->queryAll();
		foreach ($select as $item)
		{
			$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$item['clientbranchid'].' and departmentid='.$item['departmentsid'].' and subdepartmentid=0 and userid='.$item['userid']));
			if(!$dpermission)
			{
				$newper=new Departmentpermission;
				$newper->clientid=$item['clientbranchid'];
				$newper->userid=$item['userid'];
				$newper->departmentid=$item['departmentsid'];
				$newper->subdepartmentid=0;
				$newper->save();
			}
		}

	}


	public function subdepartmanpermission($where)
	{

			$select=Yii::app()->db->createCommand('SELECT user.id as userid,clientbranch.id as clientbranchid,departments.id as departmentsid,subdepartment.id as subdepartmentid from firm
			INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id
			INNER JOIN client ON client.firmid=firmbranch.id
			INNER JOIN client as clientbranch ON clientbranch.parentid=client.id
			INNER JOIN departments ON departments.clientid=clientbranch.id
			INNER JOIN departments as subdepartment ON subdepartment.parentid=departments.id
			INNER JOIN user ON user.firmid=firm.id '.$where.' and ((user.branchid=0 and firm.id=user.firmid) or (user.clientid=0 and firmbranch.id=user.branchid) or (user.clientbranchid=0 and client.id=user.clientid) or (user.clientbranchid!=0 and user.clientbranchid=clientbranch.id))')->queryAll();
			foreach ($select as $item)
			{
				$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$item['clientbranchid'].' and departmentid='.$item['departmentsid'].' and subdepartmentid='.$item['subdepartmentid'].' and userid='.$item['userid']));

				if(!$dpermission)
				{
					$newper=new Departmentpermission;
					$newper->clientid=$item['clientbranchid'];
					$newper->userid=$item['userid'];
					$newper->departmentid=$item['departmentsid'];
					$newper->subdepartmentid=$item['subdepartmentid'];
					$newper->save();
				}
			}

	}



	public function depsubpertransfer($id,$firmbranch)
	{
		$ax= $this->userobjecty('');


			$client=Client::model()->findAll(array('condition'=>'parentid!=0 and isdelete=0 and firmid='.$firmbranch));
			foreach($client as $clientx)
			{
				$dep=Departments::model()->findAll(array('condition'=>'parentid=0 and clientid='.$clientx->id));
				foreach($dep as $depx)
				{
						$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$clientx->id.' and departmentid='.$depx->id.' and subdepartmentid=0 and userid='.$id));

						if(!$dpermission)
						{
							$newper=new Departmentpermission;
							$newper->clientid=$clientx->id;
							$newper->userid=$id;
							$newper->departmentid=$depx->id;
							$newper->subdepartmentid=0;
							$newper->save();
						}

						$sub=Departments::model()->findAll(array('condition'=>'parentid='.$depx->id));

						foreach($sub as $subx)
						{
							$dpermissionx=Departmentpermission::model()->find(array('condition'=>'clientid='.$clientx->id.' and departmentid='.$depx->id.' and subdepartmentid='.$subx->id.' and userid='.$id));

								if(!$dpermissionx)
								{
									$newper=new Departmentpermission;
									$newper->clientid=$clientx->id;
									$newper->userid=$id;
									$newper->departmentid=$depx->id;
									$newper->subdepartmentid=$subx->id;
									$newper->save();
								}
						}
				}
			}

	}




	public function dilbul($userid,$cevrilecek)
	{

		if($userid==0)
		{
			$userid=1;
		}
		Yii::app()->getModule('translate');
		$lg=Translatelanguages::model()->find(array('condition'=>'id='.$userid));
		$t=Translates::model()->find(array('condition'=>'code="'.$lg->name.'" and title="'.$cevrilecek.'"'));
		return $t->value;
	}






	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
