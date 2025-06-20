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
class NewClientModel extends CActiveRecord
{

  public function clientList($parentid=null,$firmid=null,$clientid=null)
  {
      $response=Yii::app()->db->createCommand()
      ->select("c.*,IF(c.active=1,'".t("Aktif")."','".t("Pasif")."') isactiven,s.name sectorname,IF(c.createdtime=0,'',DATE_FORMAT(FROM_UNIXTIME(c.createdtime), '%d / %m / %Y')) time")
      ->from('client c')
     ->leftjoin('sector s','s.id=c.branchid');
     $response=$response->where('c.isdelete=0');
    if($parentid!=null && $parentid==0)
    {
        $response=$response->andwhere('c.parentid=0');
    }
    if($parentid!=null && $parentid>0)
    {
       $response=$response->andwhere('c.parentid='.$parentid);
    }
    
    
    if($clientid!=null && $clientid!=0)
    {
        $response=$response->andwhere('c.id='.$clientid);
    }
     else if($firmid!=null && $firmid!=0)
    {
      	$response=$response->andwhere('c.firmid='.$firmid);
    }
    $response=$response->order("c.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }
  
  public function clientDetail($request)
  {
    return self::clientList(null,null,$request['id']);
  }
  
  
  public function clientCreateUpdate($request)
  {
    Yii::app()->getModule('authsystem');
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Client;
        $model->active=1;
        $username= NewClientModel::model()->ClientUnicNameBul($request['name_cu'],0);
        $model->username=$username;
      }else{
        $model=Client::model()->findByPk($request['id_cu']);
      }
      if($model)
      {
        $model->name=$request['name_cu'];
        $model->active=$request['active_cu'];
        $model->title=$request['title_cu'];
        $model->taxoffice=$request['tax_office_cu'];
        $model->taxno=$request['tax_no_cu'];
        $model->address=$request['email_cu'];
        $model->landphone=$request['land_phone_cu'];
        $model->email=$request['adres_cu'];
        $model->branchid=isset($request['sector_cu'])?$request['sector_cu']:0;
        $model->contractstartdate=$request['contractstartdate_cu'];
        $model->contractfinishdate=$request['contractfinishdate_cu'];
        $model->productsamount=$request['productsamount_cu'];
        $model->iskdv=$request['iskdv_cu'];
         $model->customertype=1;
         $model->firmid=$request['firm_id_cu'];
          $model->mainfirmid=$request['firm_id_cu'];
        	
          $model->parentid=$request['parentid_cu'];

          $model->createdtime=time();
          if($model->save())
          {
            $firmBModel= $parentmodel=Firm::model()->findByPk(intval($request['firm_id_cu']));
             $firmModel= $parentmodel=Firm::model()->findByPk(intval($firmBModel['parentid']));
            $package=$firmModel['package'].'.'.$firmModel['username'].'.'.$firmBModel['username'];
            if($request['parentid_cu']==0 && $request['id_cu']==0)
            {
              $request['parentid_cu']=$model->id;
              $request['name_cu']=$request['name_cu'].' şube';
                AuthItem::model()->createitem($package.'.'.$username,0);
           
                AuthItem::model()->generateparentpermission($package.'.'.$username);
                AuthItem::model()->createnewauth($package,$username,'Customer');
              NewClientModel::model()->clientCreateUpdate($request);
            }
            else if($request['parentid_cu']!=0 && $request['id_cu']==0)
            {
              
               $parentmodel=Client::model()->findByPk(intval($request['parentid_cu']));
                $firmBModel=Firm::model()->findByPk(intval($parentmodel['firmid']));
             $firmModel= Firm::model()->findByPk(intval($firmBModel['parentid']));
            $package=$firmModel['package'].'.'.$firmModel['username'].'.'.$firmBModel['username'];

                AuthItem::model()->createitem($package.'.'.$parentmodel['username'].'.'.$username,0);
           
                AuthItem::model()->generateparentpermission($package.'.'.$parentmodel['username'].'.'.$username);
                AuthItem::model()->createnewauth($package.'.'.$parentmodel['username'],$username,'Branch');
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
  
  public function ClientUnicNameBul($name,$say)
{
     $userName=NewFirmModel::model()->usernameproduce($name);
     $newitem=Client::model()->find(array('condition'=>'username="'.$userName.'"'));
      if($newitem)
      {
        $say++;
         NewClientModel::model()->ClientUnicNameBul($userName.'_'.$say,$say);
      }
      else
      {
        return $userName;
      }
}
  
  public function clientdelete($request)
  {
    if($request['id_delete']!=0 && $request['id_delete']!='')
    {
        $liste=NewClientModel::model()->clientList($request['id_delete']);
          if($liste['status']==true && !empty($liste['data']))
          {
            return ["data"=>"Öncelikle bu şube müşterinin şubelerini silmelisiniz","status"=>500];
          }
          else
          {
             $model=Client::model()->findByPk($request['id']);
            if($model->delete())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
          }
    }
    return ["data"=>"Müşteri Bulunamadı","status"=>500];
  }
  
  public function clientisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Client::model()->findByPk($request['id']);
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
    return ["data"=>"Müşteri Bulunamadı","status"=>500];
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
