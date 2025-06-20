<?php

/**
 * This is the model class for table "departments".
 *
 * The followings are the available columns in table 'departments':
 * @property integer $id
 * @property integer $clientid
 * @property integer $parentid
 * @property string $name
 * @property integer $active
 */
class Departments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'departments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clientid,name', 'required'),
			array('clientid, parentid, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, clientid, parentid, name, active', 'safe', 'on'=>'search'),
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
			'clientid' => 'Clientid',
			'parentid' => 'Parent Department',
			'name' => 'Department Name',
			'active' => 'Department Active',
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
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	

	public function altkategorivarmi($id,$client){  //kullanıdıgımız left menünün alt kategorisi var-yok kontrolü yapılıyor.
    $a=Departments::model()->findall(array('condition'=>'clientid='.$client.' and parentid=:id','params'=>array(':id'=>$id)));
			if (is_countable($a) && count($a))
				 {
					 return 1;
				 } else
				 {
					 return 0;
				 }
	}

	
	
	
public function kategoritabloyaz($id,$client,$list="") //leftmenu default sayfasındaki listeleme bölümü
{


		 $transfer=Client::model()->istransfer($client);
		 $tclient=Client::model()->find(array('condition'=>'id='.$client));


		$ax= User::model()->userobjecty('');


		$liste=	Departments::model()->findall(array('order'=>'id ASC','condition'=>'clientid='.$client.' and parentid='.$id));
		 if ($liste){	$list.= '<ul>';}
		 if($id!=0){$hidden='style="display: none;"';} else { $hidden='';}


		

		foreach ($liste as $deger)
		{
			
			
			$altkategorivarmi=$this->altkategorivarmi($deger->id,$client);
			$yayindami=	$deger->active;
			if($altkategorivarmi){$altclass='<i style="margin-right:10px;" class="fa fa-folder-open"> </i> ';}else{$altclass='';}
			if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
			

			
			// $ax->id!=1 && ($ax->mainclientbranchid!=$ax->clientbranchid || $ax->mainclientbranchid==$ax->clientbranchid);

			// if($ax->id!=1 && ($ax->mainclientbranchid!=$ax->clientbranchid || $ax->mainclientbranchid==$ax->clientbranchid))



			if($ax->id!=1 && $ax->clientid!=0 && ($ax->mainclientbranchid!=$ax->clientbranchid || $ax->mainclientbranchid==$ax->clientbranchid))
			{
				
				
				if($id==0)
				{
					$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$client.' and departmentid='.$deger->id.' and subdepartmentid=0 and userid='.$ax->id));
					// echo count($dpermission);

					
				}
				else
				{
					$dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$client.' and departmentid='.$id.' and subdepartmentid='.$deger->id.' and userid='.$ax->id));
				
				}    
				if($dpermission)
				{
          $list.="<li ".$hidden."><span ".$yayindami.">".$altclass.$deger->name;
			    if (Yii::app()->user->checkAccess('client.branch.department.update') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
             $list.="<a style='margin-left: 10px;' onclick='openmodalupdate(this)' data-id='".$deger->id."' data-name='".$deger->name."' data-parent='".$deger->parentid."' data-active='".$deger->active."' class='btn btn-warning btn-sm'><i style='color:#fff;' class='fa fa-edit'></i></a>";
            }
			    if (Yii::app()->user->checkAccess('client.branch.department.delete')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
                $list.="<a style='margin-left: 10px;' onclick='openmodaldelete(this)' data-id='".$deger->id."' data-name='".$deger->name."' class='btn btn-danger btn-sm'><i style='color:#fff;' class='fa fa-trash'></i></a>";
            }
          $list.="</span>";
			   if (Yii::app()->user->checkAccess('client.branch.department.create')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
           if($deger->parentid==0){
            $list.="<a style='margin-left: 10px;' onclick='openmodalsubcreate(this)' data-id='".$deger->id."' data-name='".$deger->name."' class='btn btn-info btn-sm'><i style='color:#fff;' class='fa fa-plus'></i></a>";
            }}
            if ($altkategorivarmi) //alt kategorisi varmı
            {
                $this->kategoritabloyaz($deger->id,$client,$list);
            }

				}
			
			}
			else
			{
		   $list.="<li ".$hidden."><span ".$yayindami.">".$altclass.$deger->name;
			
			if (Yii::app()->user->checkAccess('client.branch.department.update') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){	
			  $list.="<a style='margin-left: 10px;' onclick='openmodalupdate(this)' data-id='".$deger->id."' data-name='".$deger->name."' data-parent='".$deger->parentid."' data-active='".$deger->active."' class='btn btn-warning btn-sm'><i style='color:#fff;' class='fa fa-edit'></i></a>";
      }
			if (Yii::app()->user->checkAccess('client.branch.department.delete') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){	

				 $list.="<a style='margin-left: 10px;' onclick='openmodaldelete(this)' data-id='".$deger->id."' data-name='".$deger->name."' class='btn btn-danger btn-sm'><i style='color:#fff;' class='fa fa-trash'></i></a>";
			}
      $list.="</span>";
			if (Yii::app()->user->checkAccess('client.branch.department.create') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
        if($deger->parentid==0){
          $list.="<a style='margin-left: 10px;' onclick='openmodalsubcreate(this)' data-id='".$deger->id."' data-name='".$deger->name."' class='btn btn-info btn-sm'><i style='color:#fff;' class='fa fa-plus'></i></a>";
        }
      }

      if ($altkategorivarmi) //alt kategorisi varmı
				{
        echo $list;
        exit;
						$this->kategoritabloyaz($deger->id,$client,$list);
				}
		}
		}
		 if ($liste){	$list.='</ul>';}
      
      return $list;
	}

public function getname($i=0)
	{
	$a= $this->model()->findbypk($i);
	return $a->name;

	}



	public function depsuboto($name,$client,$parent)
	{
		$model=new Departments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


		$department=Departments::model()->findAll(array(
								   'condition'=>'name=:name and clientid=:clientid and parentid=:parentid','params'=>array('name'=>$name,'clientid'=>$client,'parentid'=>$parent)
							   ));

			
		if(!$department)
		{
			
			$model->name=$name;
			$model->clientid=$client;
			$model->parentid=$parent;
			$model->active=1;
			if($model->save())
			{
				if($parent==0)
				{
					//departmanı kullanıcıya yetki verme
					$where='where clientbranch.id='.$client.' and departments.parentid=0';
					User::model()->departmanpermission($where);
				}
				else
				{
					//sub departmanı kullanıcıya yetki verme
					$where='where clientbranch.id='.$client;
					User::model()->subdepartmanpermission($where);
				}
			
			}
			//loglama
			Logs::model()->logsaction();


			return $model->id;
		}
	
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Departments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
