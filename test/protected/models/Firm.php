<?php

/**
 * This is the model class for table "firm".
 *
 * The followings are the available columns in table 'firm':
 * @property integer $id
 * @property integer $parentid
 * @property string $name
 * @property string $username
 * @property string $title
 * @property string $taxoffice
 * @property string $taxno
 * @property string $address
 * @property string $landphone
 * @property string $email
 * @property string $package
 * @property string $image
 * @property integer $createdtime
 * @property integer $active
 */
class Firm extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'firm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentid,username', 'required'),
			array('parentid, createdtime, active', 'numerical', 'integerOnly'=>true),
			array('name, username, title, taxoffice, taxno, address, landphone, email, package, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parentid, name, username, title, taxoffice, taxno, address, landphone, email, package, image, createdtime, active', 'safe', 'on'=>'search'),
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
			'parentid' => 'Parentid',
			'name' => 'Name',
			'username' => 'Username',
			'title' => 'Title',
			'taxoffice' => 'Taxoffice',
			'taxno' => 'Taxno',
			'address' => 'Address',
			'landphone' => 'Landphone',
			'email' => 'Email',
			'package' => 'Package',
			'image' => 'Image',
			'createdtime' => 'Createdtime',
			'active' => 'Active',
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
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('taxoffice',$this->taxoffice,true);
		$criteria->compare('taxno',$this->taxno,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('landphone',$this->landphone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('package',$this->package,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

		public function changeactive($id,$isactive)
	{
		$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($firm)
		{
			$firm->active=$isactive;
			if(!$firm->update())
			{
				print_r($firm->getErrors());
			}
			else{
				return true;
			}
		}
		else
		{
			echo "bulamadım";exit;
		}
	}







	public function changeactivestaff($id,$isactive)
	{
		$firm=Staffteam::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($firm)
		{
			$firm->active=$isactive;
			if(!$firm->update())
			{
				print_r($firm->getErrors());
			}
			else{
				return true;
			}
		}
		else
		{
			echo "bulamadım";exit;
		}
	}




	public function getbranchids($firmid)
	{
		$list=Firm::model()->findall(array('condition'=>'parentid='.$firmid));
		$return=array();
		array_push($return,$firmid);
		foreach($list as $item)
		{
			array_push($return,$item->id);
		}
		return $return;

	}
	public function sef_link($string)
    {
        $turkce=array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ğ", "Ğ", "İ");
        $duzgun=array("s", "s", "i", "u", "u", "o", "o", "c", "c", "g", "g", "i");
        $string = str_replace($turkce, $duzgun, $string);
        $string = trim($string);
        $string = html_entity_decode($string);
        $string = strip_tags($string);
        $string = strtolower($string);
        $string = preg_replace('~[^ a-z0-9_.]~', ' ', $string);
        $string = preg_replace('~ ~', '-', $string);
        $string = preg_replace('~-+~', '-', $string);

        return $string;
}

	public function usernameproduce($name)
	{

		$bul=$name;

		$bulunacak = array('ç','Ç','ı','İ','ğ','Ğ','ü','ö','Ş','ş','Ö','Ü',',',' ','(',')','[',']','.');
		$degistir  = array('c','C','i','I','g','G','u','o','S','s','O','U','','','','','','','');

		$name=str_replace($bulunacak, $degistir, $bul);
		$name=strtolower($name);
		$name=ucfirst($this->sef_link($name));


		//$name=$this->model()->OzelKarakterTemizle($name);

		//$name = strtr("Ç","C",$name);
		//$name = str_replace("/s+/","",$name);
		//$name = str_replace(" ","",$name);
		//$name = str_replace(" ","",$name);
		//$name = str_replace(" ","",$name);
		//$name = str_replace("/s/g","",$name);
		//$name = str_replace("/s+/g","",$name);
		//$name=trim($name);
		//$name=strtolower($name);
		//$name=ucfirst($name);
		//$name=strip_tags($name);

		return $name;
	}


	public function getfirmid($id)
	{
		$firm=Firm::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		return $firm->name;
	}



	public function changePackage($oldpackage,$newpackage,$firmusername)
	{
		$olditem=AuthItem::model()->findAll(array('condition'=>'name like "'.$oldpackage.'.'.$firmusername.'%"'));




		foreach($olditem as $olditemx)
		{
			// echo $olditemx->name.'</br>';
			$newitem=AuthItem::model()->find(array('condition'=>'name="'.$olditemx->name.'"'));
			/*$metin  = $newitem->name;
			$eski   = $oldpackage.'.';
			$yeni   = $newpackage.'.';
			$metin = str_replace($eski, $yeni, $metin);
			$newitem->name=$metin;
			*/
			$newitem->delete();
		}

		$this->firmt($newpackage,$firmusername);
		$this->branch($newpackage,$firmusername);
		$this->client($newpackage,$firmusername);
		$this->clientbranch($newpackage,$firmusername);


	}

	public function clientbranch($firmname)
	{
		Yii::app()->getModule('authsystem');
		$clientbranch=Yii::app()->db->createCommand('SELECT clientbranch.name,clientbranch.username as cbusername,client.username as cusername,firmbranch.username as fbusername,firm.username as fusername FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id INNER JOIN client as clientbranch ON clientbranch.parentid=client.id WHERE firm.username="'.$firmname.'"')->queryall();

		for($i=0;$i<count($clientbranch);$i++)
		{
			AuthItem::model()->createitem($newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername].'.'.$client[$i][cbusername],0);
			AuthItem::model()->generateparentpermission($newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername].'.'.$client[$i][cbusername]);
			AuthItem::model()->createnewauth($newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername].'.'.$client[$i][cbusername],'Branch');
			$clientid=Client::model()->find(array("condition"=>'username="'.$client[$i][cbusername].'"'));
			if($clientid)
			{
				$users=User::model()->findAll(array("condition"=>'clientbranchid='.$clientid->id.' or mainclientbranchid='.$clientid->id));
				foreach ($users as $user) {
					$authtypes=Authtypes::model()->find(array('condition'=>'id='.$user->type));
					$authAssignment=new AuthAssignment();
					$authAssignment->itemname=$newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername].'.'.$client[$i][cbusername].'.'.$authtypes->authname;
					$authAssignment->userid=$user->id;
					$authAssignment->save();
				}
			}
		}

	}

	public function client($newpackage,$firmname)
	{
		Yii::app()->getModule('authsystem');
		$client=Yii::app()->db->createCommand('SELECT client.username as cusername,firmbranch.username as fbusername,firm.username as fusername FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id INNER JOIN client ON client.firmid=firmbranch.id WHERE firm.username="'.$firmname.'"')->queryall();

		for($i=0;$i<count($client);$i++)
		{
			AuthItem::model()->createitem($newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername],0);
			AuthItem::model()->generateparentpermission($newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername]);
			AuthItem::model()->createnewauth($newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername],$client[$i][cusername],'Customer');

			$clientid=Client::model()->find(array("condition"=>'username="'.$client[$i][cusername].'"'));
			if($clientid)
			{
				$users=User::model()->findAll(array("condition"=>'clientid='.$clientid->id.' and clientbranchid=0'));
				foreach ($users as $user) {
					$authtypes=Authtypes::model()->find(array('condition'=>'id='.$user->type));
					$authAssignment=new AuthAssignment();
					$authAssignment->itemname=$newpackage.'.'.$client[$i][fusername].'.'.$client[$i][fbusername].'.'.$client[$i][cusername].'.'.$authtypes->authname;
					$authAssignment->userid=$user->id;
					$authAssignment->save();
				}
			}
		}

	}


	public function branch($newpackage,$firmname)
	{
		Yii::app()->getModule('authsystem');
		$branch=Yii::app()->db->createCommand('SELECT firmbranch.username as fbusername,firm.username as fusername FROM firm INNER JOIN firm as firmbranch ON firmbranch.parentid=firm.id WHERE firm.username="'.$firmname.'"')->queryall();

		for($i=0;$i<count($branch);$i++)
		{
			echo $branch[$i][fbusername];
			AuthItem::model()->createitem($newpackage.'.'.$branch[$i][fusername].'.'.$branch[$i][fbusername],0);
			AuthItem::model()->generateparentpermission($newpackage.'.'.$branch[$i][fusername].'.'.$branch[$i][fbusername]);
			AuthItem::model()->createnewauth($newpackage.'.'.$branch[$i][fusername],$branch[$i][fbusername],'Branch');

			$branchid=Firm::model()->find(array("condition"=>'username="'.$branch[$i][fbusername].'"'));
			if($branchid)
			{
				$users=User::model()->findAll(array("condition"=>'(branchid='.$branchid->id.' or mainbranchid='.$branchid->id.') and clientid=0'));
				foreach ($users as $user) {
					$authtypes=Authtypes::model()->find(array('condition'=>'id='.$user->type));
					$authAssignment=new AuthAssignment();
					$authAssignment->itemname=$newpackage.'.'.$branch[$i][fusername].'.'.$branch[$i][fbusername].'.'.$authtypes->authname;
					$authAssignment->userid=$user->id;
					$authAssignment->save();
				}
			}
		}



	}


	public function firmt($newpackage,$firmname)
	{
			Yii::app()->getModule('authsystem');
			AuthItem::model()->createitem($newpackage.'.'.$firmname,0);
			AuthItem::model()->generateparentpermission($newpackage.'.'.$firmname);
			AuthItem::model()->createnewauth($newpackage,$firmname);

			$firmid=Firm::model()->find(array("condition"=>'username="'.$firmname.'"'));
			if($firmid)
			{
				$users=User::model()->findAll(array("condition"=>'firmid='.$firmid->id.' and branchid=0'));
				foreach ($users as $user) {
					$authtypes=Authtypes::model()->find(array('condition'=>'id='.$user->type));
					$authAssignment=new AuthAssignment();
					$authAssignment->itemname=$newpackage.'.'.$firmname.'.'.$authtypes->authname;
					$authAssignment->userid=$user->id;
					$authAssignment->save();
				}
			}
	}





	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Firm the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
