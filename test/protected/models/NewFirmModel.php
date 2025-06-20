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
class NewFirmModel extends CActiveRecord
{

  public function firmList($parentid=null,$firmid=null) // $parentid=0 ise  firm branh listesi // 0 dan farklı ise firmbranch listesi gelir
  {
		$response=Yii::app()->db->createCommand()
		->select("*,DATE_FORMAT(FROM_UNIXTIME(`createdtime`), '%d / %m / %Y') time")
		->from('firm f');
    if($firmid!=null)
    {
        $response=$response->where('f.id='.$firmid);
    }
    else
    {
      	$response=$response->where('f.parentid='.$parentid);
    }
	
    $response=$response->order("f.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }
  
  public function firmTransferList($firmid)
  {
     $model=Firm::model()->findByPk($firmid);
     return self::firmList($model['parentid'],null)['data'];
  }
  
  public function firmDetail($request)
  {
    return self::firmList(null,$request['id']);
  }
  
  public function firmCreateUpdate($request)
  {
    	Yii::app()->getModule('authsystem');
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Firm;
        $model->active=1;
        $username=NewFirmModel::model()->FirmUnicNameBul($request['name_cu'],0);
        $model->username= $username;
      }else{
        $model=Firm::model()->findByPk($request['id_cu']);
      }
        $package='';
      if($model)
      {
        $package=$model->package;
        $model->name=$request['name_cu'];
        // $model->active=$request['Firm']['active'];
        $model->title=$request['title_cu'];
        $model->taxoffice=$request['tax_office_cu'];
        $model->taxno=$request['tax_no_cu'];
        $model->address=$request['email_cu'];
        $model->landphone=$request['land_phone_cu'];
        $model->email=$request['adres_cu'];
        	 if($request['parentid_cu']==0 && isset($request['package_cu']))
          {
           // Firm::model()->changePackage($model->package,$request['package_cu'],$model->username);
            $model->package=$request['package_cu'];
          } 
          $model->parentid=$request['parent_cu'];

          $model->createdtime=time();
          if($model->save())
          {
            if($request['parent_cu']==0 && $request['id_cu']==0)
            {
              $request['parent_cu']=$model->id;
              $request['name_cu']=$request['name_cu'].' şube';
                AuthItem::model()->createitem($request['package_cu'].'.'.$username,0);
                AuthItem::model()->generateparentpermission($request['package_cu'].'.'.$username);
                AuthItem::model()->createnewauth($request['package_cu'],$username);
                NewFirmModel::model()->firmCreateUpdate($request);
            }
            else if($request['parent_cu']!=0 && $request['id_cu']==0)
            {
            
               $parentmodel=Firm::model()->findByPk(intval($request['parent_cu']));
                AuthItem::model()->createitem($parentmodel['package'].'.'.$parentmodel['username'].'.'.$username,0);
                AuthItem::model()->generateparentpermission($parentmodel['package'].'.'.$parentmodel['username'].'.'.$username);
                AuthItem::model()->createnewauth($parentmodel['package'].'.'.$parentmodel['username'],$username,'Branch');
            }
            else if($request['parent_cu']==0 && $request['id_cu']!=0)
            {
              $request['parent_cu']=$model->id;
              $request['name_cu']=$request['name_cu'].' şube';
              if($package!=$request['package_cu'])
              {
                if(!self::firmPackageUpdate($package,$request['package_cu'],$model->username))
                {
                 return ["data"=>'Paket değiştirme sırasında hata ile karşılaşıldı',"status"=>500];
                }
              }
                
            }
            
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
      }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }
    
  }
  
  public function firmPackageUpdate($oldPackage,$newPackage,$firmUserName)
  {
    try{
    $AuthItem=Yii::app()->db->createCommand()
		->select("*")
		->from('AuthItem aa');
    $AuthItem=$AuthItem->where("name like '".$oldPackage.'.'.$firmUserName."%'");
    $AuthItem=$AuthItem->queryAll();
    foreach($AuthItem as $AuthItemx)
    {
      $aa_new=new AuthItem();
      $ayir=explode('.',$AuthItemx['name']);
     if(!empty($ayir))
     {
       for($i=1;$i<count($ayir);$i++)
       {
         $newPackage=$newPackage.'.'.$ayir[$i];
       }
     }
      $oldPackageAuthItem=$aa_new->name;
      $aa_new->name=$newPackage;
      $aa_new->type=$AuthItemx['type'];
      $aa_new->description=$AuthItemx['description'];
      $aa_new->bizrule=$AuthItemx['bizrule'];
      $aa_new->data=$AuthItemx['data'];
      $aa_new->superadmin=$AuthItemx['superadmin'];
      if($aa_new->save())
      {
        
        /////// user yetkileri güncellenmesi gerekiyor
          $AuthAssignment=Yii::app()->db->createCommand()
          ->select("*")
          ->from('AuthAssignment aa');
          $AuthAssignment=$AuthAssignment->where("itemname='".$oldPackageAuthItem."'");
         $AuthAssignment=$AuthAssignment->queryAll();
          foreach($AuthAssignment as $AuthAssignmentx)
          {
            $aa_new=new AuthAssignment();
            $aa_new->itemname=$newPackage;
            $aa_new->userid=$AuthAssignmentx['userid'];
            $aa_new->bizrule=$AuthAssignmentx['bizrule'];
            $aa_new->data=$AuthAssignmentx['data'];
            if($aa_new->save())
            {
              $AuthAssignmentD=Yii::app()->db->createCommand()
              ->select("*")
              ->from('AuthAssignment aa')->where("itemname='".$oldPackageAuthItem."' and userid=".$AuthAssignmentx['userid'])->delete();
            }
          }
        
         /////// sayfa yetkileri ayarlanıyor
          $AuthItemChild=Yii::app()->db->createCommand()
          ->select("*")
          ->from('AuthItemChild aa');
          $AuthItemChild=$AuthItemChild->where("parent='".$oldPackageAuthItem."'");
         $AuthItemChild=$AuthItemChild->queryAll();
          foreach($AuthItemChild as $AuthItemChildx)
          {
            $aa_new=new AuthItemChild();
            $aa_new->parent=$newPackage;
            $aa_new->child=$AuthAssignmentx['child'];
            if($aa_new->save())
            {
              $AuthItemChildup=Yii::app()->db->createCommand()
              ->select("*")
              ->from('AuthItemChild aa')
              ->where("parent='".$oldPackageAuthItem."' and child='".$AuthAssignmentx['child'])
              ->delete();
            }
          }
        
        $AuthAssignmentD=Yii::app()->db->createCommand()
        ->select("*")
        ->from('AuthItem aa')->where("name='".$AuthItemx['name']."'")->delete();
      }
      
    }
    
    return 1;
    }
    catch (LyricsFinderHTTPException $e)
    {
      return 0;
    }
  }
  
  public function newfirmdelete($request)
  {
    if($request['id_delete']!=0 && $request['id_delete']!='')
    {
       $model=Firm::model()->findByPk($request['id_delete']);
      if($model)
      {
        if($model->parentid==0)
        {
          $liste=self::firmList($model->id);
          if($liste['status']==true && !empty($liste['data']))
          {
            return ["data"=>"Öncelikle bu firmanın şubelerini silmelisiniz","status"=>500];
          }
          else
          {
            if($model->delete())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
          }
        }
        else
        {
           $liste=NewClientModel::model()->clientList(null,$model->id);
          if($liste['status']==true && !empty($liste['data']))
          {
            return ["data"=>"Öncelikle bu şube firmanın müşterilerini silmelisiniz","status"=>500];
          }
          else
          {
            if($model->delete())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
          }
        }
      }
    }
    return ["data"=>"Firma Bulunamadı","status"=>500];
  }
  
  public function firmisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Firm::model()->findByPk($request['id']);
      if($model)
      {
          $model->active=$model->active==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Firma Bulunamadı","status"=>500];
  }
    

public function FirmUnicNameBul($name,$say)
{
     $userName=NewFirmModel::model()->usernameproduce($name);
     $newitem=Firm::model()->find(array('condition'=>'username="'.$userName.'"'));
      if($newitem)
      {
        $say++;
         NewFirmModel::model()->FirmUnicNameBul($userName.'_'.$say,$say);
      }
      else
      {
        return $userName;
      }
}

public function usernameproduce($name)
	{

		$bul=$name;
		$bulunacak = array('ç','Ç','ı','İ','ğ','Ğ','ü','ö','Ş','ş','Ö','Ü',',',' ','(',')','[',']','.');
		$degistir  = array('c','C','i','I','g','G','u','o','S','s','O','U','','','','','','','');
		$name=str_replace($bulunacak, $degistir, $bul);
		$name=strtolower($name);
		$name=ucfirst($name);
		return $name;
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
