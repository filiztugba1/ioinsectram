<?php

/**
 * This is the model class for table "authmodules".
 *
 * The followings are the available columns in table 'authmodules':
 * @property integer $id
 * @property integer $parentid
 * @property string $name
 * @property string $menuurl
 * @property string $menuicon
 * @property integer $menuview
 * @property integer $menurow
 * @property string $uniqname
 * @property string $readpermission
 * @property string $createpermission
 * @property string $updatepermission
 * @property string $deletepermission
 */
class Authmodules extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'authmodules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentid, name, menuurl, menuicon, menuview, menurow, uniqname, readpermission, createpermission, updatepermission, deletepermission', 'required'),
			array('parentid, menuview, menurow', 'numerical', 'integerOnly'=>true),
			array('name, menuurl, menuicon, uniqname, readpermission, createpermission, updatepermission, deletepermission', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parentid, name, menuurl, menuicon, menuview, menurow, uniqname, readpermission, createpermission, updatepermission, deletepermission', 'safe', 'on'=>'search'),
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
			'parentid' => 'Ust Modül',
			'name' => 'Adı',
			'menuurl' => 'Menuurl',
			'menuicon' => 'Menuicon',
			'menuview' => 'Menuview',
			'menurow' => 'Menurow',
			'uniqname' => 'Dil çevirisi için benzersiz adı',
			'readpermission' => 'Okuma izni örn: client.read / client.list',
			'createpermission' => 'Oluşturma izni örn: client.create',
			'updatepermission' => 'Güncelleme izni örn: client.update',
			'deletepermission' => 'Silme izni örn: client.delete',
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
		$criteria->compare('menuurl',$this->menuurl,true);
		$criteria->compare('menuicon',$this->menuicon,true);
		$criteria->compare('menuview',$this->menuview);
		$criteria->compare('menurow',$this->menurow);
		$criteria->compare('uniqname',$this->uniqname,true);
		$criteria->compare('readpermission',$this->readpermission,true);
		$criteria->compare('createpermission',$this->createpermission,true);
		$criteria->compare('updatepermission',$this->updatepermission,true);
		$criteria->compare('deletepermission',$this->deletepermission,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

public function getmtree($rootid)
{
   $arr = array();

   $result = Authmodules::model()->findall(array('condition'=>'parentid='.$rootid));
   foreach ($result as $row ) { 
     $arr[] = array(
       "id" => $row->id,
       "Title" => $row->name,
       "Children" => $this->getmtree($row->id)
     );
   }
   return $arr;
}
	
	public function issabcategory($id)
	{  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.
			if (count(Authmodules::model()->findall(array('condition'=>'parentid=:id','params'=>array(':id'=>$id)))))
				 {
					 return 1;
				 } else
				 {
					 return 0;
				 }
	}



	public function getparents($id) //leftmenu default sayfasındaki listeleme bölümü
	{
		$liste=	Authmodules::model()->findall(array('order'=>'menurow ASC','condition'=>'parentid='.$id));
		 if ($liste){ return $liste;}else{ return false;}
	}
	
	public function categorytablewrite($id) //leftmenu default sayfasındaki listeleme bölümü
	{
		$liste=	Authmodules::model()->findall(array('order'=>'menurow ASC','condition'=>'parentid='.$id));
		 if ($liste){	echo '<ul>';}
		 if($id!=0){$hidden='style="display: none;"';} else { $hidden='';}

		foreach ($liste as $deger)
		{
			$issabcategory=$this->issabcategory($deger->id);
			$yayindami=1;
			if($issabcategory){$altclass='<i style="margin-right:10px;" class="fa fa-folder-open"> </i> ';}else{$altclass='';}
			if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
			?>
		<li <?php echo $hidden; ?>><span <?php echo  $yayindami ?>><?php echo $altclass; ?><?php echo t($deger->name); ?>
			<?php if (Yii::app()->user->checkAccess('modules.update')){?>
			 <a onclick="openmodal(this)" data-id="<?=$deger->id;?>" data-name="<?=$deger->name;?>"
			 data-parentid="<?=$deger->parentid;?>"
			 data-view="<?=$deger->readpermission;?>"
			 data-create="<?=$deger->createpermission;?>"
			 data-update="<?=$deger->updatepermission;?>"
			 data-delete="<?=$deger->deletepermission;?>"
			 data-url="<?=$deger->menuurl;?>"
			 data-icons="<?=$deger->menuicon;?>"
			 data-manuview="<?=$deger->menuview;?>"
			 data-row="<?=$deger->menurow;?>"
			 class="btn btn-xs"><?=t('UPDATE');?></a>-<?php }?>
			<?php if (Yii::app()->user->checkAccess('modules.delete')){?>
			<a onclick="openmodalsil(this)" data-id="<?=$deger->id;?>" class="btn btn-xs"><?=t('DELETE');?></a></span>
			<?php }?>
			<?php if (Yii::app()->user->checkAccess('modules.create')){?>
			<a onclick="opencreate(this)" data-id="<?=$deger->id;?>" class="btn btn-xs"><?=t('SUB CATEGORY ADD');?></a></span>
			<?php }?>


	<?php	if ($issabcategory) //alt kategorisi varmı
				{
						$this->categorytablewrite($deger->id);
				}
		}
		 if ($liste){	echo '</ul>';}
	}


public function randomColor ($minVal = 0, $maxVal = 255)
{

    // Make sure the parameters will result in valid colours
    $minVal = $minVal < 0 || $minVal > 255 ? 0 : $minVal;
    $maxVal = $maxVal < 0 || $maxVal > 255 ? 255 : $maxVal;

    // Generate 3 values
    $r = mt_rand($minVal, $maxVal);
    $g = mt_rand($minVal, $maxVal);
    $b = mt_rand($minVal, $maxVal);

    // Return a hex colour ID string
    return sprintf('#%02X%02X%02X', $r, $g, $b);
}
	public function checkpermission($package='',$permissions=[])
	{
		//$ax= User::model()->userobjecty('');
		foreach($permissions as $permission){		
			$yaz='';
				if (Yii::app()->user->checkAccess($permission) || $ax->firmid==0)//)
				{
						if( AuthItem::model()->checkgrouppermission($package,$permission))
						{
							$checked='checked';
						}else
						{
							$checked='';
						}
						$yaz= '<input type="checkbox" class="checkbox" id="'.str_replace('.', '', $permission).'" data-id="'.$package.'|'.$permission.'"  '.$checked.' >';
							
				}
				
		echo '<td><center>'.$yaz.'</center></td>';
		}
	}

	public function createauthtableitems($itemid=0,$package='')
	{
	
		$modules=Authmodules::model()->findall(array('order'=>'menurow ASC','condition'=>'parentid='.$itemid));

		foreach ($modules as $item)
		{
			$ax= User::model()->userobjecty('');

			if (Yii::app()->user->checkAccess($item->readpermission) ||$ax->firmid==0)
			{
			
				if ($item->parentid==0 )
				{
					$color=$this->randomColor(170,200);
					$bold='bold';
				} 
				else
				{
					$bold='';
				}

				//	$color='';
				$ii=Authmodules::model()->getparenttree($item->id);
				$a=$a*count($ii);

				$permissions=$item->readpermission.','.$item->createpermission.','.$item->updatepermission.','.$item->deletepermission;
				$uygulamatipi=explode('.', $permissions);
				$permissions=str_replace('.', '', $permissions);
				if ($item->parentid==0 || Authmodules::model()->find(array('select'=>'parentid','condition'=>'parentid='.$item->id)))
				{
					$down='';
					$bold='bold';
					if ($a>=1){$down='<i class="fa fa-long-arrow-right" aria-hidden="true"></i>';}?>
					<tr style="background:<?=$color?>;font-weight:<?=$bold?>;">
						<td style="padding-left:<?=$a?>px;"><?=$down.t($item->name)?>

						


								<span style="float:right;padding-top: 7px; " class="unselectall" data-id="<?=$permissions?>" data-name='<?=$uygulamatipi[0];?>' title="Select All"><i class="fa fa-minus-square-o" aria-hidden="true" ></i> </span>

								<span style="float:right; padding-right:3px;padding-top: 7px;" class="selectall" data-id="<?=$permissions?>"   data-name='<?=$uygulamatipi[0];?>' title="Select All"><i class="fa fa-check-square" aria-hidden="true" ></i> </span>

								
								
								<span style="float:right;padding-right:3px; border: 1px solid #404e67; padding: 7px 10px 7px 10px; margin-right: 6px;
    border-radius: 5px;"  data-id="<?=$item->name?>"  title="Dengine Uygula">Dengine Uygula

	<input style='margin: 4px 0px 0px 8px;' class='sec'  type="checkbox" name="deger[]" value='<?=$uygulamatipi[0];?>'>
	
	
	</span>

							
							
								
								 
								
							

						</td>
						<?=$this->checkpermission($package,array($item->readpermission,$item->createpermission,$item->updatepermission,$item->deletepermission));?>
					</tr>
					<?php Authmodules::model()->createauthtableitems($item->id,$package);
				}
				else
				{ 
				$down='<i class="fa fa-long-arrow-right" aria-hidden="true"></i>';
				?>
				<tr>
					<td><?=$down.t($item->name)?>
						<span style="float:right;"  class="unselectall" data-id="<?=$permissions;?>"  title="Select All"><i class="fa fa-minus-square-o" aria-hidden="true" ></i> </span>
						<span style="float:right;   padding-right:3px;"  class="selectall" data-id="<?=$permissions;?>"><i class="fa fa-check-square" aria-hidden="true" title="Select All"></i> </span>


										<span style="float:right;padding-right:3px; border: 1px solid #404e67; padding: 7px 10px 7px 10px; margin-right: 6px;
    border-radius: 5px;"  data-id="<?=$item->name?>"  title="Dengine Uygula">Dengine Uygula

	<input style='margin: 4px 0px 0px 8px;' class='sec'  type="checkbox" name="deger[]" value='<?=$uygulamatipi[0];?>'>
	
	
	</span>


					
					</td>	
					<?=$this->checkpermission($package,array($item->readpermission,$item->createpermission,$item->updatepermission,$item->deletepermission));
					?>
						
				</tr>
				<?php 
				}
			}
		}
	}
	
	
	public function leftmenu()
	{
		$dizi[0]='';
		$leftmenu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid=0'));
		foreach($leftmenu as $leftmenux)
		{
			//echo $leftmenux->name.'-'.$leftmenux->parentid.'-'.$this->permission($leftmenux->readpermission).'</br>';
			echo $this->menusub($leftmenux->id,1,$array=$leftmenux->id.'-1-'.$this->menupermission($leftmenux->id));
			/*
			if($this->subbul($leftmenux->id))
			{
			echo $leftmenux->name.$dizi[$leftmenux->id]=$this->subbul($leftmenux->id).'</br>';
			}
			*/
			
			echo '</br>';
		
		}
		
		//print_r($dizi);
				
	}

	public function menusub($id,$count,$array)
	{
		$count=$count+1;
		$menu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$id));
		foreach($menu as $manux)
		{
			$array=$array.','.$manux->id.'-'.$count.'-'.$this->menupermission($manux->id);
			$menuy=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$manux->id));
			if(isset($menuy))
			{
				$array=$this->menusub($manux->id,$count,$array);
			}
		}
		return $array;
	}
	
	
	public function menupermission($id)
	{
		$leftmenu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$id));
		foreach($leftmenu as $menu)
		{
			$menuy=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$menu->id));
			
			if(count($menuy)==0)
			{
				if($this->permission($menu->readpermission)==1)
					{
					
					return 1;
					}
			}
			else
			{
				
				return $this->menupermission($menu->id);
			}
			
		}
		if(count($leftmenu)==0)
		{
			$menu=Authmodules::model()->find(array('order'=>'menurow ASC','condition'=>'menuview=1 and id='.$id));
		
			if($this->permission($menu->readpermission)==1)
					{
				
					return 1;
					}
		}
	}
	
	public function header2($id)
	{
		$ax= User::model()->userobjecty('');
		

		$url=$_SERVER['REQUEST_URI'];
		$leftmenu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$id));
		foreach($leftmenu as $leftmenux)
		{
			if($this->menupermission($leftmenux->id)==1 && ($leftmenux->name!='Staff' || ($leftmenux->name=='Staff' && $ax->id!=1  && $ax->type!=13)))
			{
			$menu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$leftmenux->id));
				
					?><li <?php if($url==$leftmenux->menuurl){echo 'class="active"';}
					
					if($url==$leftmenux->menuurl.'/branch?type=firm&&id='.$ax->firmid && $leftmenux->name=='Firm' && $ax->type!=1){echo 'class="active"';}
					if($url==$leftmenux->menuurl.'/branches/'.$ax->clientbranchid && $leftmenux->menuurl=='/client' && $ax->clientbranchid>0){echo 'class="active"';}
					if($url==$leftmenux->menuurl.'/detail/'.$ax->clientid && $leftmenux->menuurl=='/client' && $ax->clientbranchid==0 &&$ax->clientid>0){echo 'class="active"';}
					
					?>>
					<a class="nav-item" href="
					<?php 	if($leftmenux->name=='Firm')
								{if($ax->type==1)
									{echo $leftmenux->menuurl;}
									else
									{
										$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
										$branch=Firm::model()->find(array('condition'=>'parentid='.$ax->firmid));
										if($firm->package=='Packagelite')
										{
											echo $leftmenux->menuurl.'/staff?type=branch&&id='.$branch->id;
										}
										else
										{
											echo $leftmenux->menuurl.'/branch?type=firm&&id='.$ax->firmid;
										}

										
										
									}
								}
								else if($leftmenux->menuurl=='/client')
								{if($ax->clientid>0)
									{if($ax->clientbranchid>0)
										{echo $leftmenux->menuurl.'/branches/'.$ax->clientbranchid;}
										else
										{echo $leftmenux->menuurl.'/detail/'.$ax->clientid;}
									}
									else
									{echo $leftmenux->menuurl;}
								}
								else
								{echo $leftmenux->menuurl;}
					
					?>">
						<i class="<?=$leftmenux->menuicon;?>"></i>
						<span class="menu-title"  style="font-weight:bold;">
							<?php							if($leftmenux->name=='Firm')
							{
								if($ax->type==1){echo t('Firm');}else{
									
									$firm=Firm::model()->find(array('condition'=>'id='.$ax->firmid));
									if($firm->package=='Packagelite')
									{
										echo t('My Company');
									}
									else
									{
										echo t('Branch');
									}
								}
									
							}
														
							else if($leftmenux->menuurl=='/client'||$leftmenux->name=="Client")
							{
								if($ax->clientid!=0)
								{
									echo str_replace(t('Client'), t('My Company'),t($leftmenux->name));
								}
								else
								{
									echo t($leftmenux->name);
								}
							}
							
							else
							{
									echo t($leftmenux->name);
									if($leftmenux->name=='Support')
									{
										if(User::model()->newsupport()!=0)
										{?>
											<span class="badge badge badge-primary badge-pill float-right mr-2">
										<?php echo User::model()->newsupport();?>
											</span>
										<?php }

									}

									if($leftmenux->name=='Documents')
									{
										if(User::model()->newdocument()!=0)
										{?>
											<span class="badge badge badge-primary badge-pill float-right mr-2">
											<?echo User::model()->newdocument();?>
											</span>
										<?php }
									}

									if($leftmenux->name=='Atanan Uygunsuzluk')
									{
										$say=0;
										$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$ax->id." and returnstatustype=1","order"=>"id desc","group"=>"conformityid"));
											foreach($conformityuserassign as $conformityuserassignx){

												$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
												$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
												
												if(!$gerigonderme && !$deadlineverme)
												{
													$say++;
												}
											}
										if($say!=0)
										{?>
											<span class="badge badge badge-primary badge-pill float-right mr-2">
											<?echo $say;?>
											</span>
										<?php }
									}
							}
							?>
						</span>
					</a>
					<?php if(count($menu)>0){?>
					<ul class="menu-content">
						<?php $this->header2($leftmenux->id);?>
					</ul>
					<?php }?>
					</li>
					<?php			}
		}
		
	}
	
	
	
	
	
	
	
	public function subbul($id)
	{
		$leftmenu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'parentid='.$id,));
		foreach($leftmenu as $menu){
			
			 $subcategory=$this->issabcategory2($menu->id);
			if($subcategory==1)
			{
				 return $this->headerissabcategory($menu->id);
			}
			else
			{
			
				if($this->permission($menu->readpermission)==1)
					{
					return 1;
					}
			}
			
		}
		
		if(!isset($leftmenu))
		{
			$menu=Authmodules::model()->find(array('condition'=>'id='.$id));
			if($this->permission($menu->readpermission)==1)
					{
					return 1;
					}
			else
				return 0;
		}
		
	}
	
	
	
	
	
	
	

	

	



	public function headermenu($id) //header.php deki left menunun listelendiği bölüm
	{
		

		$url='/'.Yii::app()->controller->getId();
		$cache=false;
		$new=true;
		$url='/'.Yii::app()->controller->getId();
		
		if($id==0 && Yii::app()->user->id>=1)
		{
			$cachesql=Cache::model()->find(array('condition'=>'userid='.Yii::app()->user->id.' and value="leftmenu"'));
			if ($cachesql)
			{			
				$new=false;
			}else
			{
				$new=true;
			}
			
			if ($cachesql && ($cachesql->createdtime>=time()-24) )
			{ 
				echo 'bas';
				echo $cachesql->data;
				return true;
			}
			else
			{
				
				$cache=true;
			}
		}
		if ($cache)
		{
			ob_start();
		}
		
		$ax= User::model()->userobjecty('');
			$leftmenu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$id));
			
			foreach($leftmenu as $menu)
			{
				$issabcategory=$this->issabcategory2($menu->id);

				if($issabcategory==1)
				{
					if($this->headerissabcategory($menu->id,$atama=''))
					{?>
					

						<li <?php if($url==$menu->menuurl){echo 'class="active"';}?>><a class="nav-item" href="/
							
							<?php								
								
								if($menu->name=='Firm')
								{
									if($ax->type==1)
										{
										echo $menu->menuurl;
										}
									
								}
								
								else if($menu->name=='Client' or $menu->name=='client')
								{
									if($ax->clientid==0)
										{
										echo $menu->menuurl;
										}
									}
								else
								{
									echo $menu->menuurl;
								}
							
							?>
							"><?php if($issabcategory==1){?><i class="<?=$menu->menuicon;?>"></i><?php }?>
							
							<span class="menu-title"  style="font-weight:bold;">
							<?php							if($menu->name=='Firm')
							{
								if($ax->type==1){echo t('Firm');}else{echo t('Branch');}
							}
							else if($menu->name=='Client' or $menu->name=='client')
							{
								if($ax->clientid==0){echo t('Client');}else{echo t('My Company');}
							}
							else
							{
								echo t($menu->name);
							}
							?>
						
							
							</span></a>
						
							<?php 
							if($issabcategory==1)
							 {?>
								  <ul class="menu-content">
									<?php $this->headermenu($menu->id);?>
								  </ul>
							<?php }?>
						</li>
				
				<?php }}
				else
				{
					
					if (Yii::app()->user->checkAccess($menu->readpermission))
					{ ?>

						<li <?php if($url==$menu->menuurl){echo 'class="active"';}?>><a class="nav-item" href="
							<?php								if($menu->name=='Firm')
								{
									if($ax->type==1)
										{
										echo $menu->menuurl;
										}
									else
										{
										echo $menu->menuurl.'/branch?type=firm&&id='.$ax->firmid;
										}
								}
		
								
								else if($menu->menuurl=='/client')
								{
									if($ax->clientid>0)
									{
										if($ax->clientbranchid>0)
										{
											echo $menu->menuurl.'/branches/'.$ax->clientbranchid;
										}
										else
										{
											echo $menu->menuurl.'/detail/'.$ax->clientid;
										}
										
									}
									else
									{
										echo $menu->menuurl;
									}
								
								}
								else
								{
									echo $menu->menuurl;
								}
							
							?>
						"><i class="<?=$menu->menuicon;?>"></i>
						<span class="menu-title"  style="font-weight:bold;">
							<?php							if($menu->name=='Firm')
							{
								if($ax->type==1){echo t('Firm');}else{echo t('Branch');}
							}
														
							else if($menu->menuurl=='/client')
							{
								if($ax->clientid!=0)
								{
									echo str_replace(t('Client'), t('My Company'),t($menu->name));
								}
								else
								{
									echo t($menu->name);
								}
							}
							else
							{
								echo t($menu->name);
							}
							?>
						
							
							</span></a>
							<?php /*<span class="badge badge badge-primary badge-pill float-right mr-2">3</span> */ ?></a>
							
					   </li>
				
					<?php }
				}	
			}

		if ($cache){
		$output = ob_get_contents();
			if ($new)
			{
				$c=new Cache;

			}else
			{
				
				$c=$cachesql;
				
			}
		$c->userid=Yii::app()->user->id;
		$c->value='leftmenu';
		$c->data=$output;	
		$c->createdtime=time();		
			if ($new)
			{
				$c->save();

			}else
			{
				
				$c->update();
				
			}
		
		}
	}


	public function issabcategory2($id){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.
			if (count(Authmodules::model()->findall(array('condition'=>'menuview=1 and parentid=:id','params'=>array(':id'=>$id)))))
				 {
					 return 1;
				 } else
				 {
					 return 0;
				 }
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



	public function headerissabcategory($id){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.

		$leftmenu=Authmodules::model()->findAll(array('order'=>'menurow ASC','condition'=>'menuview=1 and parentid='.$id,));
		foreach($leftmenu as $menu){
			
			 $subcategory=$this->issabcategory2($menu->id);
			if($subcategory==1)
			{
				 return $this->headerissabcategory($menu->id);
			}
			else
			{
			
				if($this->permission($menu->readpermission)==1)
					{
					return 1;
					}
			}
			
		}
		
	}

////////////////////////////

	public function getmodulename($id)
	{
		$type=Authmodules::model()->find(array('order'=>'menurow ASC','condition'=>'id='.$id));
		if ($type)
		{
			return $type->name;
		}else
		{
			return '';
		}
	}

	public function getparent($id)
	{
		$type=Authmodules::model()->find(array('select'=>'parentid','order'=>'menurow ASC','condition'=>'id='.$id));
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
		//return array();
		$type=Authmodules::model()->find(array('select'=>'parentid','order'=>'menurow ASC','condition'=>'id='.$id));
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

//////////////////////////
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Authmodules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
