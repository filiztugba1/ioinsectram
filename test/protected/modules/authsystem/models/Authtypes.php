<?php

/**
 * This is the model class for table "authtypes".
 *
 * The followings are the available columns in table 'authtypes':
 * @property integer $id
 * @property string $name
 * @property string $authname
 * @property integer $parentid
 */
class Authtypes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'authtypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, authname, parentid', 'required'),
			array('parentid', 'numerical', 'integerOnly'=>true),
			array('name, authname', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, authname, parentid', 'safe', 'on'=>'search'),
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
			'name' => 'isim',
			'authname' => 'yetki adı örn : Branch',
			'parentid' => 'parent type id',
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
		$criteria->compare('authname',$this->authname,true);
		$criteria->compare('parentid',$this->parentid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function altkategorivarmi($id){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.
			if (count(Authtypes::model()->findall(array('condition'=>'parentid=:id','params'=>array(':id'=>$id)))))
				 {
					 return 1;
				 } else
				 {
					 return 0;
				 }
	}


	
	
	public function kategoritabloyaz($id) //leftmenu default sayfasındaki listeleme bölümü
	{
		$liste=	Authtypes::model()->findall(array('order'=>'id ASC','condition'=>'parentid='.$id));
		 if ($liste){	echo '<ul>';}
		 if($id!=0){$hidden='style="display: none;"';} else { $hidden='';}

		foreach ($liste as $deger)
		{
			$altkategorivarmi=$this->altkategorivarmi($deger->id);
			$yayindami=1;
			if($altkategorivarmi){$altclass='<i style="margin-right:10px;" class="fa fa-folder-open"> </i> ';}else{$altclass='';}
			if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
			?>
		<li <?php echo $hidden; ?>><span <?php echo  $yayindami ?>><?php echo $altclass; ?><?php echo $deger->name; ?>
			 <a onclick="openmodal(this)" data-id="<?=$deger->id;?>" data-name="<?=$deger->name;?>"
			 data-parentid="<?=$deger->parentid;?>"
			 data-authname="<?=$deger->authname;?>"
			 class="btn btn-xs">UPDATE</a>-
			<a onclick="openmodalsil(this)" data-id="<?=$deger->id;?>" class="btn btn-xs">DELETE</a></span>
			<a onclick="opencreate(this)" data-id="<?=$deger->id;?>" class="btn btn-xs">SUB CATEGORY ADD</a></span>


	<?php	if ($altkategorivarmi) //alt kategorisi varmı
				{
						$this->kategoritabloyaz($deger->id);
				}
		}
		 if ($liste){	echo '</ul>';}
	}
		public function getauthname($id)
	{
		$type=Authtypes::model()->find(array('condition'=>'id='.$id));
		if ($type)
		{
			return $type->authname;
		}else
		{
			return '';
		}
	}
	public function getparent($id)
	{
		$type=Authtypes::model()->find(array('condition'=>'id='.$id));
		if ($type)
		{
			return $type->parentid;
		}else
		{
			return 0;
		}
	}
	public function getparenttree($id)
	{

		$type=Authtypes::model()->find(array('condition'=>'id='.$id));
		if ($type)
		{
			$parent=$type->parentid;
			if ($parent<>0)
			{
				$arr=array();
				while($parent > 0) {
				array_push($arr,$parent);
				$parent=$this->getparent($parent);
				}
				return $arr;
				}else
			{
				return array();
			}
		}
	}


	public function createauthtype($id)
	{
		$authname=$this->getauthname($id);
		$tree=$this->getparenttree($id);
		foreach ($tree as $item)
		{
			$authname=$this->getauthname($item).'.'.$authname;
		}
		$authname='Default.'.$authname;

		$check=AuthItem::model()->find(array('condition'=>'name=:name','params'=>array('name'=>$authname)));
		if ($check){
			//İşlem yapmayalım zaten böyle bir şey var
		}else
		{
			AuthItem::model()->createitem($authname,0);				
			AuthItem::model()->generateparentpermission($authname);
		}	
		/*if($id!=0)
		{
		 $liste=Authtypes::model()->find(array('condition'=>'id='.$id));
		 $authname=$liste->authname.'.'.$authname;

		 if($liste->parentid!=0)
			{
				$this->toptype($liste->parentid,$authname);
			
			}
			else
			{
				$authname='Default.'.$authname;
				$check=AuthItem::model()->find(array('condition'=>'name=:name','params'=>array('name'=>$authname)));
				if ($check){
					//İşlem yapmayalım zaten böyle bir şey var
				}else
				{
					$item= new AuthItem;
					$item->name=$authname;
					$item->type=0;
					$item->save();
				}	
			}
			
		}*/
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Authtypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
