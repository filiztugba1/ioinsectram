<?php

/**
 * This is the model class for table "leftmenu".
 *
 * The followings are the available columns in table 'leftmenu':
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property string $url
 * @property string $icon
 * @property string $permissions
 * @property integer $isactive
 */
class Leftmenu extends CActiveRecord
{
	public $deneme=0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'leftmenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, parent, url, icon, permissions, isactive', 'required'),
			array('parent, isactive', 'numerical', 'integerOnly'=>true),
			array('name, url, icon', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent, url, icon, permissions, isactive', 'safe', 'on'=>'search'),
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
			'parent' => 'Parent ',
			'url' => 'Url',
			'icon' => 'İcon',
			'permissions' => 'Yetkiler',
			'isactive' => 'Active-Passive',
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
		$criteria->compare('parent',$this->parent);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('permissions',$this->permissions,true);
		$criteria->compare('isactive',$this->isactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



public function headermenu($id) //header.php deki left menunun listelendiği bölüm
{
		$leftmenu=Leftmenu::model()->findAll(array('order'=>'id ASC','condition'=>'parent='.$id,));
		
		foreach($leftmenu as $menu){
			$altkategorivarmi=$this->altkategorivarmi($menu->id);

			if($altkategorivarmi==1)
			{
				if($this->headeraltkategorivarmi($menu->id,$atama=''))
				{?>
				

					<li class="nav-item"><a href="/<?=$menu->url;?>"><?if($altkategorivarmi==1){?><i class="<?=$menu->icon;?>"></i><?}?><span class="menu-title"  style="font-weight:bold;"><?=$menu->name;?></span></a>
					
						<?php $leftmenualt=Leftmenu::model()->findAll(array( 'order'=>'id ASC','condition'=>'parent='.$menu->id,));
						if($altkategorivarmi==1)
						 {?>
							  <ul class="menu-content">
								<?$this->headermenu($menu->id);?>
							  </ul>
						<?}?>
					</li>
			
			<?}}
			else
			{
				if ($this->permission($menu->permissions))
				{ ?>

					<li class="nav-item"><a href="/<?=$menu->url;?>"><i class="<?=$menu->icon;?>"></i><span class="menu-title"  style="font-weight:bold;"><?=$menu->name;?></span><?php /*<span class="badge badge badge-primary badge-pill float-right mr-2">3</span> */ ?></a>
						
				   </li>
			
				<?}
			}	
		}
	
}




	public function headeraltkategorivarmi($id){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.

		$leftmenu=Leftmenu::model()->findAll(array('order'=>'id ASC','condition'=>'parent='.$id,));
		foreach($leftmenu as $menu){
			
			 $altkategori=$this->altkategorivarmi($menu->id);
			if($altkategori==1)
			{
				$this->headeraltkategorivarmi($menu->id);
			}
			else
			{
			
				if($this->permission($menu->permissions)==1)
					{
					return 1;
					}
			}
			
		}
		
	}


		
	public function altkategorivarmi($id){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.
			if (count(Leftmenu::model()->findall(array('condition'=>'parent=:id and isactive=1','params'=>array(':id'=>$id)))))
				 {
					 return 1;
				 } else
				 {
					 return 0;
				 }
	}





	
	
	
public function kategoritabloyaz($id) //leftmenu default sayfasındaki listeleme bölümü
	{
		$liste=	Leftmenu::model()->findall(array('order'=>'id ASC','condition'=>'parent='.$id));
		 if ($liste){	echo '<ul>';}
		 if($id!=0){$hidden='style="display: none;"';} else { $hidden='';}

		foreach ($liste as $deger)
		{
			$altkategorivarmi=$this->altkategorivarmi($deger->id);
			$yayindami=	$deger->isactive;
			if($altkategorivarmi){$altclass='<i style="margin-right:10px;" class="fa fa-folder-open"> </i> ';}else{$altclass='';}
			if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
			?>
		<li <?php echo $hidden; ?>><span <?php echo  $yayindami ?>><?php echo $altclass; ?><?php echo $deger->name; ?>
			 <a onclick="openmodal(this)" data-id="<?=$deger->id;?>" data-name="<?=$deger->name;?>" data-url="<?=$deger->url;?>" data-dataicon="<?=$deger->icon;?>" data-permissions="<?=$deger->permissions;?>" data-parent="<?=$deger->parent;?>" data-active="<?=$deger->isactive;?>" class="btn btn-xs">UPDATE</a>-
			<a onclick="openmodalsil(this)" data-id="<?=$deger->id;?>" class="btn btn-xs">DELETE</a></span>
			<a onclick="opencreate(this)" data-id="<?=$deger->id;?>" class="btn btn-xs">SUB CATEGORY ADD</a></span>


	<?php	if ($altkategorivarmi) //alt kategorisi varmı
				{
						$this->kategoritabloyaz($deger->id);
				}
		}
		 if ($liste){	echo '</ul>';}
	}
	




	public function permission($permission=''){ // headerdaki left menude yetki kontrolünün virgüle gore ayrılması ve bir tanesini sağlıyorsa 
		$bolunmus = explode(",", $permission);	//girişe izin vermesi
		for($i=0;$i<count($bolunmus);$i++){
			if(Yii::app()->user->checkAccess($bolunmus[$i]))
			{
				return true;
			}
		}
		return false;
	}	





	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Leftmenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
