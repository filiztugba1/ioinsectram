<?php

/**
 * This is the model class for table "AuthItem".
 *
 * The followings are the available columns in table 'AuthItem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren1
 */
class AuthItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'AuthItem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'unique'),
			array('type,superadmin', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description, bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
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
			'authAssignments' => array(self::HAS_MANY, 'AuthAssignment', 'itemname'),
			'authItemChildren' => array(self::HAS_MANY, 'AuthItemChild', 'parent'),
			'authItemChildren1' => array(self::HAS_MANY, 'AuthItemChild', 'child'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Authorization Name',
			'type' => 'Type',
			'description' => 'Description',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
			'superadmin' => 'Super Admin',
		);
	}


	public function getauthitems($typetip='permission',$package='')
	{
		/*
			getauthitems Fonksiyonu $typetip ( permisson | group ) değişkenine göre izinlerin listesini alır
			Bu bölüme daha sonra bu listeden alıp alamaycağı izinlerin de yetkilendirme kısıtlaması eklenecek.
				örn. Superadmin olmayan bir user superadmin yetkilerini ve guruplarını göremeyecek.
		*/
		$type=0;
		if ($typetip=='permission'){$type=3;}
		if ($typetip=='group')
			{
				$type=0;	
				if ($package<>'')
				{
						
					$param=$package.'%';
					return $this->findall(array('condition'=>'type='.$type.' and (name like :part) ','params'=>array('part'=>$param),'order'=>'superadmin desc,name asc'));
					
				}
			}	
		if ($typetip=='package')
		{
			$type=1;
		}
		return	$this->findall(array('condition'=>'type='.$type,'order'=>'superadmin desc,name asc'));
	}
	public function createitem($name,$type)
	{	
		/*
			Bu fonksiyon bir authitem oluşturmak için gerekli işlemleri yapar.
		*/
			$check=AuthItem::model()->find(array('condition'=>'name=:name','params'=>array('name'=>$name)));
			if ($check){
				//İşlem yapmayalım zaten böyle bir şey var
			}else
			{
				$item= new AuthItem;
				$item->name=$name;
				$item->type=$type;
				$item->save();
			}		
	}
	public function deleteauthitem($name)
	{
		$item=AuthItem::model()->find(array('condition'=>'name=:name','params'=>array('name'=>$name)));
		if ( $item) 
		{
			$item->delete();
		}
	}

		public function createchild($parent,$child)
	{	
		/*
			Bu fonksiyon bir iteme diğer itemi child olarak tanımlamak için gerekli işlemleri yapar.
		*/
			$check=AuthItemChild::model()->find(array('condition'=>'parent=:parent and child=:child','params'=>array('parent'=>$parent,'child'=>$child)));
			if ($check)
			{
				//İşlem yapmayalım zaten böyle bir şey var
			}else
			{
				$item= new AuthItemChild;
				$item->parent=$parent;
				$item->child=$child;
				$item->save(); 
			}
	}

	public function clonegrouppermissions($source,$target)
	{
		//echo $source.' Yetkileri toplanıyor: source: '.$source.' -  Target:'.$target.'<br>';
		$defaultgroups=$this->findall(array('condition'=>"type=0 and name like '$source.%'"));

		////////////////////////////Main Permissions
			$clearname=$target;
			$permissions=AuthItemChild::model()->findall(array('condition'=>'parent=:name','params'=>array('name'=> $source)));
			foreach ($permissions as $particule)
			{
				//echo '<br>'.$particule->parent.'=>'.$particule->child;
				//$this->createchild($clearname,$particule->child);	
				if (!$this->issuperadmin($particule->child) && !$this->isgroup($particule->child))
				{
					//echo $clearname.'  => '.$particule->child.' yetkisi verildi<br>';
					$this->changepermission($clearname,$particule->child,1);
				}
			}

		//////////////////////////////////////////////
		foreach($defaultgroups as $item)
		{
			$clearname=$target.str_replace($source,'',$item->name);
			//echo 'Itemname= '.$item->name.' - Clearname : '.$clearname.'<br>';
			$permissions=AuthItemChild::model()->findall(array('condition'=>'parent=:name','params'=>array('name'=> $item->name)));
			foreach ($permissions as $particule)
			{
				//echo '<br>'.$particule->parent.'=>'.$particule->child;
				//$this->createchild($clearname,$particule->child);	
				if (!$this->issuperadmin($particule->child) && !$this->isgroup($particule->child))
				{
					//echo $clearname.'  => '.$particule->child.' yetkisi verildi<br>';
					$this->changepermission($clearname,$particule->child,1);
				}
			}
		}
		//exit;
	}

	public function createnewpackage($name)
	{
		/*
			Bu fonksiyon paket oluşturmak için gerekli işlemleri yapar.
		*/
				$clearname=$name.'.Default';
				$this->createitem($clearname,0);	
				$this->generateparentpermission($clearname);
			$defaultgroups=$this->findall(array('condition'=>"type<>1 and name like 'Default.%'"));
			foreach ($defaultgroups as $item)
		{
				//$clearname=str_replace('Default',$name,$item->name);
				$clearname=$name.'.'.$item->name;
				$this->createitem($clearname,0);	
				$this->generateparentpermission($clearname);
		}
			$this->clonegrouppermissions('Default',$name.'.Default');
	}

	public function createnewauth($package,$name,$default='Default')
	{
		/*
			Bu fonksiyon firma oluşturmak için gerekli işlemleri yapar.
		*/
	//	echo $package.' -- '.$name;
			$defaultgroups=$this->findall(array(
										'condition' => "type<>1 and name LIKE '".$package.'.'.$default.".%'", 
										'params'    => array(':match' => $package.'.'.$default.'.%')
									));
		
			foreach ($defaultgroups as $item)
		{
				$clearname=str_replace($package.'.'.$default.'.','',$item->name);
				$clearname=$package.'.'.$name.'.'.$clearname;
				$this->createitem($clearname,0);				
				$this->generateparentpermission($clearname);
		}
		//echo $package.'.Default  -  ';
		//echo $package.'.'.$name;
		//exit;
			$this->clonegrouppermissions($package.'.'.$default,$package.'.'.$name);
	}

	public function issuperadmin($name)
	{
		/*
			Bu fonksiyon bir yetki gurubunun ya da iznin superadmin düzeyinde olup olmadığını kontrol eder.
		*/
		if ($this->find(array('condition'=>'name=:name and superadmin=1','params'=>array('name'=>$name))))
		{
			return true;
		}else{
			return false;
		}
	}

		public function isgroup($name)
	{
		/*
			Bu fonksiyon bir yetki gurubunun ya da iznin superadmin düzeyinde olup olmadığını kontrol eder.
		*/
		if ($this->find(array('condition'=>'name=:name and type=0','params'=>array('name'=>$name))))
		{
			return true;
		}else{
			return false;
		}
	}

		public function ispermission($name)
	{
		/*
			Bu fonksiyon bir yetki gurubunun ya da iznin superadmin düzeyinde olup olmadığını kontrol eder.
		*/
		if ($this->find(array('condition'=>'name=:name and type=3','params'=>array('name'=>$name))))
		{
			return true;
		}else{
			return false;
		}
	}

	public function checkgrouppermission($group,$permission)
	{
		$item=AuthItemChild::model()->find(array('select'=>'parent','condition'=>'parent=:group and child=:child','params'=>array('group'=>$group,'child'=>$permission)));
		/*
			Bu fonksiyon bir yetki gurubunun bir izne sahip olup olup olmadığını kontrol eder.
		*/
		if ($item) {
			return true;
		}else{
			return false;
		}
		
	}


	public function getchilds($group,$withoutpermissions=false)
	{
		/*
			Bu fonksiyon bir yetki gurubunun altındaki gurupları 1 level  getirir.
		*/
		//$return=AuthItemChild::model()->findall(array('condition'=>'parent=:group ','params'=>array('group'=>$group)));
		$return=Yii::app()->db->createCommand(
		'SELECT AuthItemChild.*,AuthItem.type FROM AuthItemChild INNER JOIN AuthItem ON AuthItemChild.child = AuthItem.name where AuthItemChild.parent="'.$group.'" ')->queryAll();
		if ($return) {
			if ($withoutpermissions)
			{
				foreach ($return as $item)
				{
					$item=(object)$item;
					if ($item->type==0)
					{
						return 	$return;
					}
				}
				return 	$false;
			}else
			{
				return 	$return;
			}
			
		}else{
			return false;
		}
		
	}
		public function writechildlists($parent)
	{
		/*
			Bu fonksiyon bir yetki gurubunun altındaki gurupları 1 level  getirir.
		*/
		//$return=AuthItemChild::model()->findall(array('condition'=>'parent=:parent ','params'=>array('parent'=>$parent)));
		$return=Yii::app()->db->createCommand(
		'SELECT AuthItemChild.*,AuthItem.type FROM AuthItemChild INNER JOIN AuthItem ON AuthItemChild.child = AuthItem.name where AuthItemChild.parent="'.$parent.'" and AuthItem.type<>3')->queryAll();

		if ($return) {
			foreach ($return as $i)
			{
				$i=(object)$i;
				//if (!$this->ispermission($i->child))//yavaşlatıyor
				//{
					$mainname=explode('.',$i->child);
					$mainname=array_pop($mainname);
					//$parentname=implode('.',$mainname);//str_replace( ".".$items[$count-1],'', $itemname);
					if (count($mainname)>1){
						
						$parentname=implode('.',$mainname);//str_replace( ".".$items[$count-1],'', $itemname);
						}else
						{
							$parentname=$mainname;
						}
					$haschild='';
					$getchilds=$this->getchilds($i->child,true);
					if ($getchilds){$haschild='class="fa fa-folder-open"';}
					


					if(!strstr($i->child, "Default.") && !strstr($i->child, ".Default"))
					{
						echo '	
						<li style="display: none;">
						<span  id="'.strtr($i->child, array('.' => '-')).'"><i style="margin-right:10px;" '.$haschild.'> </i>'.str_replace($i->child,'',$parentname).'</span>';
						
						$name=str_replace($i->child,'',$parentname);
						if($name!="Admin" && $name!="Branch" && $name!="Staff" && $name!='Customer'){
					
						echo '<a class="btn btn-danger btn-sm" onclick="openmodalsil(this)" data-child="'.str_replace($i->child,'',$parentname).'" data-name="'.$i->child.'"><i style="color:#fff;" class="fa fa-trash"></i></a>';
						}
						echo '<a href="?package='.$i->child.'" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>';
						if($getchilds){echo '<ul>';}
						$this->writechildlists($i->child);				
						if($getchilds){echo '</ul>';}
						echo '</li>';
					}
					else
					{
						echo '	
						<li style="display: none;">
						<span  id="'.strtr($i->child, array('.' => '-')).'"><i style="margin-right:10px;" '.$haschild.'> </i>'.str_replace($i->child,'',$parentname).'</span>
						<a href="?package='.$i->child.'" ><i style="margin-left:10px;" class="fa fa-eye"></i></a>';
						if($getchilds){echo '<ul>';}
						$this->writechildlists($i->child);				
						if($getchilds){echo '</ul>';}
						echo '</li>';
					}
				//}
			}
		
			//return 	$return;
		}else{
			return false;
		}
		
	}

	public function generateparentpermission($itemname='')
	{
		$items=explode('.',$itemname);
		$count=count($items);
		if ($count>1)
		{
			$child=$itemname;
			array_pop($items);
			$parent=implode('.',$items);//str_replace( ".".$items[$count-1],'', $itemname);
			//echo 'Parent= '.$parent.' --  Child '.$itemname.' ilişki child düzeyde kuruldu.<br>';
			$this->changepermission($parent,$itemname,1);
		}

	}



	public function denklik($group='',$permission='',$uygulamatipi='',$cu='')
	{



		
		//denklik için 
			$denklik=false;
			for($i=0;$i<count($uygulamatipi);$i++)
			{
				if(explode('.',$permission)[0]==$uygulamatipi[$i])
				{
					$denklik=true;
					break;
				}
			}

			
			
			if($denklik==true)
			{
				$denkpermission=explode('.',$group);

				$boyut=count($denkpermission);

				$yetkiboyutu=$denkpermission[$boyut-1];

				$aranacak='';


			

				for($i=0;$i<$boyut-2;$i++)
				{
					if($i==0)
					{
						$aranacak=$denkpermission[$i];
					}
					else
					{
						$aranacak=$aranacak.'.'.$denkpermission[$i];
					}
				}

				$denklikler='name like "'.$aranacak.'.%" and name like "%.'.$yetkiboyutu.'"';

				// echo $denklikler;

				if($boyut>1)
				{

					

					$return=Yii::app()->db->createCommand(
					 'SELECT * FROM AuthItem  where '.$denklikler)->queryAll();


				//print_r($return);

			


				
					for($j=0;$j<count($return);$j++)
					{
						
						
						$veri=explode('.',$return[$j]['name']);

						
						if(count($veri)==$boyut)
						{

							// echo $return[$j]['name'];

						

						if($cu==1)
							{
						
								$returnx=Yii::app()->db->createCommand(
								'SELECT * FROM AuthItemChild  where parent="'.$return[$j]['name'].'" and child="'.$permission.'"')->queryAll();

								
								// echo count($returnx);

								if(count($returnx)==0)
								{
									
									$item2=	new AuthItemChild();
									$item2->parent=$return[$j]['name'];
									$item2->child=$permission;
									if ($item2->save()){
										// echo 'basarılı';
										}
								}

							}
							else
							{
							
								//$returnx=Yii::app()->db->createCommand(
								// 'Delete * FROM AuthItemChild  where parent="'.$return[$j]['name'].'" and child="'.$permission.'"')->queryAll();

								AuthItemChild::model()->deleteAll(array('condition'=>'parent="'.$return[$j]['name'].'" and child="'.$permission.'"'));


							}

						}
					}


					 //AuthItemChild::model()->find(array('condition'=>'(Like parent=:group and parent=:groupson) and child=:child','params'=>array('group'=>$denklikler,'child'=>$permission)));
				
				}
				
			}

		//denklik için
	

}

	public function creategrouppermission($group,$permission,$uygulamatipi='')
	{
	
	
			
		$this->denklik($group,$permission,$uygulamatipi,1);

		
		
		/*
			Bu fonksiyon child izin oluşturur.
		*/
		if ( AuthItemChild::model()->find(array('condition'=>'parent=:group and child=:child','params'=>array('group'=>$group,'child'=>$permission)))) 
		{

		
			return true;
		}
		else
		{
			$item=	new AuthItemChild();
			$item->parent=$group;
			$item->child=$permission;
			if ($item->save()){return true;}else{return false;}
		}
	}
	public function deletegrouppermission($group,$permission,$uygulamatipi)
	{

		$this->denklik($group,$permission,$uygulamatipi,0);
		/*
			Bu fonksiyon bir yetki gurubunun ya da iznin superadmin düzeyinde olup olmadığını kontrol eder.
		*/
		
		$item=AuthItemChild::model()->find(array('condition'=>'parent=:group and child=:child','params'=>array('group'=>$group,'child'=>$permission)));
		
			if ($item)
			{
				if ($item->delete()){return true;}else{return false; }
			}else
			{
				return true;
			}
	}

	public function changepermission($group,$permission,$type,$uygulamatipi='')
	{
		/*
			Bu fonksiyon bir izinin bir guruba tanımlanmasını ya da tanımdan çıkarılmasını sağlar.
			$type değişkeni 0 ve 1 durummunda olabilir. 0 izni siler, 1 izni tanımlar.
			Burayı çağıran "https://insectram.io/authsystem/auth/" sayfası, ajax ile yollanan veri ayrıştırılarak gönderir, sonucu boolean cinsi geri almalıdır.
			Ekstra güvenlik önlemleri eklenmesi gerekiyor.
				örn. superadmin olmayan bir kullanıcı superadmin düzeyinde izin veya guruba işlem yapamayacak.
				örn. permissions.change tipinde bir izin tanımlanıp bu izin değişiklik yapmak isteyen kullanıcıya tanımlı değilse işlem gerçekleşmeyecek.
		*/
		if ($type==1)
		{
			if ($this->checkgrouppermission($group,$permission)){
				return true;
			}else
			{
				return $this->creategrouppermission($group,$permission,$uygulamatipi);
			}
		}
		if ($type==0)
		{
			return $this->deletegrouppermission($group,$permission,$uygulamatipi);
		}
	}
	public function getownauths()
	{
		$a=AuthAssignment::model()->findall(array('condition'=>'userid='.Yii::app()->user->id));
		$auths=array();
		foreach($a as $item)
		{
			array_push($auths,$item->itemname);			
		}
		return $auths;
	}
	
	
	


	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('superadmin',$this->superadmin);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
