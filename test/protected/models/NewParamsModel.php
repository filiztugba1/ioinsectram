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
class NewParamsModel extends CActiveRecord
{

    ////////////. certificate başlangıç ////////
  public function certificatelist($id=null)
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
		->from('certificate c');
    if($id!=null)
    {
        $response=$response->where('c.id='.$id);
    }
    $response=$response->order("c.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }

  public function certificatecreateupdate($request)
  {

    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Certificate;
      }else{
        $model=Certificate::model()->findByPk($request['id_cu']);
      }

        $model->name=$request['name_cu'];
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function certificatedetail($request)
  {
    return self::certificatelist($request['id']);
  }

  public function certificatedelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Certificate::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Sertifika Bulunamadı","status"=>500];
    }

   public function certificatedeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::certificatedelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek sertifikayı seçmelisiniz","status"=>500];
    }



  ////////////. certificate biişş ////////
 ////////////. uygunsuzluk durumları başlangıç ////////
  public function conformitystatuslist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("cs.*,IFNULL(f.name,'') firmname,IFNULL(b.name,'') branchname,IFNULL(cb.name,'') clientbranchname,IFNULL(c.name,'') clientname")
    ->leftjoin('firm f','f.id=cs.firmid')
    ->leftjoin('firm b','b.id=cs.branchid')
    ->leftjoin('client cb','cb.id=cs.clientid')
    ->leftjoin('client c','c.id=cb.parentid')
		->from('conformitystatus cs');
    if(isset($request['id']) && $request['id']!=null)
    {
        $response=$response->where('cs.id='.$request['id']);
    }
    if(isset($request['firmid']) && $request['firmid']!=null)
    {
          $response= $response->where('cs.firmid='.$request['firmid']);
    }
    if(isset($request['branchid']) && $request['branchid']!=null)
    {
           $response= $response->andwhere('cs.branchid='.$request['branchid']);
    }
     if(isset($request['clientid']) && $request['clientid']!=null)
    {
           $response= $response->andwhere('cs.clientid='.$request['clientid']);
    }
    $response=$response->order("cs.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }

  public function conformitystatusdetail($request)
  {
    return self::conformitystatuslist($request);
  }

  public function conformitystatuscreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Conformitystatus;
      }else{
        $model=Conformitystatus::model()->findByPk($request['id_cu']);
      }
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->firmid=isset($request['firm_cu'])?$request['firm_cu']:$model->firmid;
       $model->branchid=isset($request['branch_cu'])?$request['branch_cu']:$model->branchid;
       $model->clientid=isset($request['clientbranch_cu'])?$request['clientbranch_cu']:$model->clientid;
       $model->isactive=isset($request['isactive_cu'])?$request['isactive_cu']:$model->isactive;
       $model->btncolor=isset($request['btncolor_cu'])?$request['btncolor_cu']:$model->btncolor;
       $model->sira=10;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


    public function conformitystatusdelete($request)
    {

      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Conformitystatus::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Uygunsuzluk Durumu Bulunamadı","status"=>500];
    }

   public function conformitystatusdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::conformitystatusdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek uygunsuzluk durumunu seçmelisiniz","status"=>500];
    }


  public function conformitystatusisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Conformitystatus::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Uygunsuzluk Durumu Bulunamadı","status"=>500];
  }

  ////////////. uygunsuzluk durumları bitiş ////////

  ////////////. uygunsuzluk tipi başlangıç ////////
  public function conformitytypelist($request)
  {
    $response=Yii::app()->db->createCommand()
	  ->select("ct.*,IFNULL(f.name,'') firmname,IFNULL(b.name,'') branchname,IFNULL(cb.name,'') clientbranchname,IFNULL(c.name,'') clientname")
   	->from('conformitytype ct')
    ->leftjoin('firm f','f.id=ct.firmid')
    ->leftjoin('firm b','b.id=ct.branchid')
    ->leftjoin('client cb','cb.id=ct.clientid')
    ->leftjoin('client c','c.id=cb.parentid');

    if(isset($request['id']) && $request['id']!=null)
    {
        $response=$response->where('ct.id='.$request['id']);
    }

    else if(isset($request['firmid']) && $request['firmid']!=null && isset($request['branchid']) && $request['branchid']!=null)
    {
          $response= $response->where('ct.firmid='.$request['firmid']);
           $response= $response->andwhere('ct.branchid='.$request['branchid'])
          ->andwhere('ct.clientid='.$request['clientid']);
    }
    $response=$response->order("ct.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }

 public function conformitytypedetail($request)
  {
    return self::conformitytypelist($request);
  }

  public function conformitytypecreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Conformitytype;
      }else{
        $model=Conformitytype::model()->findByPk($request['id_cu']);
      }
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->firmid=isset($request['firm_cu'])?$request['firm_cu']:$model->firmid;
       $model->branchid=isset($request['branch_cu'])?$request['branch_cu']:$model->branchid;
       $model->clientid=isset($request['clientbranch_cu'])?$request['clientbranch_cu']:$model->clientid;
       $model->isactive=isset($request['isactive_cu'])?$request['isactive_cu']:$model->isactive;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function conformitytypedelete($request)
    {

      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Conformitytype::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Uygunsuzluk Tipi Bulunamadı","status"=>500];
    }

   public function conformitytypedeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::conformitytypedelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek uygunsuzluk tipini seçmelisiniz","status"=>500];
    }


  public function conformitytypeisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Conformitytype::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Uygunsuzluk Tipi Bulunamadı","status"=>500];
  }

  ////////////. uygunsuzluk tipi bitiş ////////


   ////////////. departman başlangıç ////////
  public function departmentlist($request,$type='list')
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
		->from('departments d');


    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('d.id='.$request['id']);
    }
    else if(isset($request['clientid']) && $request['clientid']!=null && $request['clientid']!=0)
    {
      if(isset($request['parentid']) && $request['parentid']!=null)
      {
        $response=$response->where('d.clientid='.$request['clientid'].' and d.parentid='.$request['parentid']);
      }
      else
      {
         $response=$response->where('d.clientid='.$request['clientid']);
      }
    }
    else if(isset($request['parentid']) && $request['parentid']!=null && $request['parentid']!=0)
    {
        $response=$response->where('d.parentid='.$request['parentid']);
    }
    $response=$response->order("d.name asc")->queryAll();
    if($type!='list')
    {
      return $response;
    }
		return ["data"=>$response,"status"=>true];
  }

  public function departmentcreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Departments;
      }else{
        $model=Departments::model()->findByPk($request['id_cu']);
      }
       $model->clientid=isset($request['clientid_cu'])?$request['clientid_cu']:$model->clientid;
       $model->parentid=isset($request['parentid_cu'])?$request['parentid_cu']:$model->parentid;
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->active=isset($request['active_cu'])?$request['active_cu']:$model->active;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function departmentdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Departments::model()->findByPk($request['id_delete']);
        if($model)
        {
         $response=Yii::app()->db->createCommand('delete from departments where parentid='.$request['id_delete'].' and clientid='.$model->clientid)
           ->execute(); /// alt departmanı varsa onlarda silinecek

          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Departman Bulunamadı","status"=>500];
    }

   public function departmentdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::departmentdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek departmanı seçmelisiniz","status"=>500];
    }


  public function departmentisactive($request)
  {

     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Departments::model()->findByPk($request['id']);
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
    return ["data"=>"Departman Bulunamadı","status"=>500];
  }

  public function departmanHtmlList($request)
  {
    $ax= User::model()->userobjecty('');
    $client_id=$request['clientid'];
     $transfer=Client::model()->istransfer($client_id);
		 $tclient=Client::model()->find(array('condition'=>'id='.$client_id));
    $departmans=self::departmentlist($request);
    $deps=array_filter($departmans['data'], function($k) {
        return intval($k['parentid'] )== 0;
      });

    $list= '<ul>';
    foreach($deps as $dep)
    {
      $subs=array_filter($departmans['data'], function($k) use($dep){
        return intval($dep['id'])==intval($k['parentid']);
      });
      $yayindami=	$dep['active'];
      if(!empty($subs)){$altclass='<i style="margin-right:10px;" class="fa fa-folder-open"> </i> ';}else{$altclass='';}
			if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
      $dpermission=Departmentpermission::model()->find(array('condition'=>'clientid='.$client_id.' and departmentid='.$dep['id'].' and subdepartmentid=0'));
     // if($dpermission)
			// {
          $list.="<li class='parent_li'><span ".$yayindami.">".$altclass.$dep['name'];

          $list.="</span>";
			    if (Yii::app()->user->checkAccess('client.branch.department.update') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
             $list.="<a style='margin-left: 10px;'  data-id='".$dep['id']."' data-name='".$dep['name']."' data-parent='".$dep['parentid']."' data-active='".$dep['active']."' class='btn btn-warning btn-sm depupdate'><i style='color:#fff;' class='fa fa-edit'></i></a>";
            }
			    if (Yii::app()->user->checkAccess('client.branch.department.delete')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
                $list.="<a style='margin-left: 10px;'   data-id='".$dep['id']."' data-name='".$dep['name']."'  data-parent='".$dep['parentid']."' data-active='".$dep['active']."'  class='btn btn-danger btn-sm depdelete'><i style='color:#fff;' class='fa fa-trash'></i></a>";
            }
			   if (Yii::app()->user->checkAccess('client.branch.department.create')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
            $list.="<a style='margin-left: 10px;'  data-id='".$dep['id']."' data-name='".$dep['name']."'  data-parent='".$dep['parentid']."' data-active='".$dep['active']."'  class='btn btn-info btn-sm subcreate'><i style='color:#fff;' class='fa fa-plus'></i></a>";
            }
		//	}
      $hidden='style="display: none;"';
      $list.= '<ul>';
         foreach($subs as $sub)
          {
          $yayindami=	$sub['active'];
          $altclass='';
          if($yayindami==1){$yayindami='';}else{ $yayindami='style="color:red;"';}
             //var_dump($sub);
             // exit;
          $dpermissions=Departmentpermission::model()->find(array('condition'=>'clientid='.$client_id.' and departmentid='.$dep['id'].' and subdepartmentid='.$sub['id'].' and userid='.$ax->id));
          // if($dpermissions)
          // {
              $list.="<li ".$hidden."><span ".$yayindami.">".$altclass.$sub['name'];

              $list.="</span>";
              if (Yii::app()->user->checkAccess('client.branch.department.update') && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
                 $list.="<a style='margin-left: 10px;'  data-id=".$sub['id']." data-name='".$sub['name']."'  data-parent='".$sub['parentid']."' data-active='".$sub['active']."'  data-parent='".$sub['parentid']."' data-active='".$sub['active']."' class='btn btn-warning btn-sm subupdate'><i style='color:#fff;' class='fa fa-edit'></i></a>";
                }
              if (Yii::app()->user->checkAccess('client.branch.department.delete')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
                    $list.="<a style='margin-left: 10px;'  data-id='".$sub['id']."' data-name='".$sub['name']."' data-parent='".$sub['parentid']."' data-active='".$sub['active']."' class='btn btn-danger btn-sm subdelete'><i style='color:#fff;' class='fa fa-trash'></i></a>";
                }
           //  if (Yii::app()->user->checkAccess('client.branch.department.create')  && ($transfer!=1 || $ax->branchid==0 || $ax->branchid==$tclient->firmid||($ax->clientbranchid==0 && $ax->clientid==$tclient->mainclientid))){
             //   $list.="<a style='margin-left: 10px;'  data-id='".$sub['id']."' data-name='".$sub['name']."' data-parent='".$sub['parentid']."' data-active='".$sub['active']."' class='btn btn-info btn-sm'><i style='color:#fff;' class='fa fa-plus'></i></a>";
               // }

          // }
        }
      $list.= '</ul>';
    }
    $list.= '</ul>';
    return ['data'=>$list,'depSay'=>count($deps),"status"=>true];
  }

  ////////////. departman  bitiş ////////




   ////////////. staffteam başlangıç ////////
  public function staffteamlist($request)
  {

    $response=Yii::app()->db->createCommand()
		->select("st.*,CONCAT(u.username,' - ',u.name,' ',u.surname) leadername")
		->from('staffteam st')
    ->leftJoin('user u','u.id=st.leaderid');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('st.id='.$request['id']);
    }
    else if(isset($request['branchid']) && $request['branchid']!=null && $request['branchid']!=0)
    {
        $response=$response->where('st.isdelete=0 and st.firmid='.$request['branchid']);
    }
    $response=$response->order("st.teamname asc")->queryAll();
    $array=[];
    foreach($response as $responsex)
    {
      $responsex['staffnamelist'][]=self::stafflist($responsex['staff']);
      array_push($array,$responsex);
    }
 		return ["data"=>$array,"status"=>true];
  }

  public function stafflist($list)
  {
     return $response=Yii::app()->db->createCommand()
		->select("CONCAT(u.username,' - ',u.name,' ',u.surname) staff")
		->from('user u')
    ->where('u.id in ('.$list.')')
    ->order("CONCAT(u.name,' ',u.surname) asc")->queryAll();
  }

  public function teamuserlist($request)
  {
     $response=Yii::app()->db->createCommand()
		->select("CONCAT(u.username,' - ',u.name,' ',u.surname) staff,u.id")
		->from('user u')
    ->where('u.active=1 &&firmid!=0 && u.clientid=0 && u.branchid='.$request['firmid']);
    if(isset($request['leaderid']) && $request['leaderid']!=0 && $request['leaderid']!='')
    {
        $response=$response->andwhere('u.id!='.$request['leaderid']);
    }
    $response=$response->order("CONCAT(u.username,' - ',u.name,' ',u.surname) asc")->queryAll();
    return ['data'=>$response,'status'=>true];
  }

  public function staffteamcreateupdate($request)
  {

    if(!empty($request) && isset($request['teamname_cu']) && $request['teamname_cu']!=''
      && isset($request['leaderid_cu']) && $request['leaderid_cu']!=''
      && isset($request['staff_cu']) && $request['staff_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Staffteam;
        $model->active=1;
        $model->isdelete=0;
      }else{
        $model=Staffteam::model()->findByPk($request['id_cu']);
      }

       $model->teamname=$request['teamname_cu'];
       $model->leaderid=$request['leaderid_cu'];
       $model->staff=$request['staff_cu'];
       $model->firmid=$request['firmid_cu'];
       $model->color=$request['color_cu'];
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function staffteamdetail($request)
  {
    return self::staffteamlist($request['id']);
  }

  public function staffteamdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Staffteam::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Takım Bulunamadı","status"=>500];
    }

   public function staffteamdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::staffteamdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek sertifikayı seçmelisiniz","status"=>500];
    }

    public function staffteamisactive($request)
  {

     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Staffteam::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Sertifikayı bulunamadı","status"=>500];
  }

  /////////// staffteam bitiş /////////////


   ////////////. dokuman kategory başlangıç ////////
  public function documentcategorylist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
		->from('documentcategory d');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('d.id='.$request['id']);
    }
    else if(isset($request['parentid']))
    {
        $response=$response->where('d.parent='.$request['parentid']);
    }

    if(isset($request['documentactive']) && $request['documentactive']=1 )
    {
      $response=$response->andwhere('isactive=1');
    }
    $response=$response->order("d.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }

  public function documentcategorydetail($request)
  {
    return self::documentcategorylist($request);
  }

  public function documentcategorycreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Documentcategory;
        $model->isactive=1;
      }else{
        $model=Documentcategory::model()->findByPk($request['id_cu']);
      }

       $model->parent=isset($request['parent_cu'])?$request['parent_cu']:$model->parent;
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;

       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function documentcategorydelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Documentcategory::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Döküman Kategorisi Bulunamadı","status"=>500];
    }

   public function documentcategorydeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::documentcategorydelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek doküman kategorisini seçmelisiniz","status"=>500];
    }


  public function documentcategoryisactive($request)
  {

     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Documentcategory::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Doküman kategorisi bulunamadı","status"=>500];
  }

  ////////////. dokuman kategory  bitiş ////////


   ////////////. education başlangıç ////////
  public function educationlist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
		->from('education e');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('e.id='.$request['id']);
    }

    $response=$response->order("e.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }


  public function educationdetail($request)
  {
    return self::educationlist($request);
  }


  public function educationcreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Education;
      }else{
        $model=Education::model()->findByPk($request['id_cu']);
      }

       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;

       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


   public function educationdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Education::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Eğitim Bulunamadı","status"=>500];
    }

   public function educationdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::educationdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek eğitimi seçmelisiniz","status"=>500];
    }

  ////////////. education  bitiş ////////


   ////////////. languages başlangıç ////////
  public function languageslist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
		->from('languages e');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('e.id='.$request['id']);
    }

    $response=$response->order("e.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }


  public function languagesdetail($request)
  {
    return self::languageslist($request);
  }


  public function languagescreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Languages;
      }else{
        $model=Languages::model()->findByPk($request['id_cu']);
      }

       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;

       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


   public function languagesdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Languages::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Dil Bulunamadı","status"=>500];
    }

   public function languagesdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::languagesdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek dili seçmelisiniz","status"=>500];
    }



  ////////////. languages  bitiş ////////



   ////////////. location başlangıç ////////
  public function locationlist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("e.*,IF(e.type=0,'".t('Ülke')."','".t('Şehir')."') as typem")
		->from('location e');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('e.id='.$request['id']);
    }

    $response=$response->order("e.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }

  public function locationdetail($request)
  {
    return self::locationlist($request);
  }

  public function locationcreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Location;
      }else{
        $model=Location::model()->findByPk($request['id_cu']);
      }

       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
        $model->parentid=0;
        $model->type=isset($request['type_cu'])?$request['type_cu']:$model->type;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function locationdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Location::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Lokasyon Bulunamadı","status"=>500];
    }

   public function locationdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::locationdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek lokasyonu seçmelisiniz","status"=>500];
    }

  ////////////. location  bitiş ////////


   ////////////. monitör tipi başlangıç ////////
  public function monitoringtypelist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
		->from('monitoringtype mt');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('mt.id='.$request['id']);
    }

    $response=$response->order("mt.name asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }


  public function monitoringtypedetail($request)
  {
    return self::monitoringtypelist($request);
  }


  public function monitoringtypecreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Monitoringtype;
      }else{
        $model=Monitoringtype::model()->findByPk($request['id_cu']);
      }

       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
      $model->detailed=isset($request['detailed_cu'])?$request['detailed_cu']:$model->detailed;
      $model->type=isset($request['type_cu'])?$request['type_cu']:$model->type;
      $model->active=isset($request['active_cu'])?$request['active_cu']:$model->active;

       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

   public function monitoringtypedelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Monitoringtype::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Monitör Tipi Bulunamadı","status"=>500];
    }

   public function monitoringtypedeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::monitoringtypedelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek monitör tipini seçmelisiniz","status"=>500];
    }


  public function monitoringtypeisactive($request)
  {

     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Monitoringtype::model()->findByPk($request['id']);
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
    return ["data"=>"Monitör tipi bulunamadı","status"=>500];
  }


  ////////////. monitör tipi  bitiş ////////




   ////////////. firma ilaç başlangıç ////////
  public function medfirmslist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("mf.*")
		->from('medfirms mf')
    ->leftjoin('firm f','f.id=mf.firmid')
    ->leftjoin('firm b','b.id=mf.branchid');
    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('mf.id='.$request['id']);
    }
     $response=$response->order("mf.name asc")->queryAll();

		return ["data"=>$response,"status"=>true];
  }


  public function medfirmsdetail($request)
  {
    return self::medfirmslist($request);
  }


  public function medfirmscreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Medfirms;
      }else{
        $model=Medfirms::model()->findByPk($request['id_cu']);
      }
      $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->isactive=isset($request['active_cu'])?intval($request['active_cu']):$model->isactive;
      $model->firmid=isset($request['firmid_cu'])?intval($request['firmid_cu']):$model->firmid;
      $model->branchid=isset($request['branchid_cu'])?intval($request['branchid_cu']):$model->branchid;
      $model->comment=isset($request['comment_cu'])?$request['comment_cu']:$model->comment;


       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }



   public function medfirmsdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Medfirms::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Firma ilacı Bulunamadı","status"=>500];
    }

   public function medfirmsdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::medfirmsdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek firma ilacını seçmelisiniz","status"=>500];
    }


  public function medfirmsisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Medfirms::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Firma ilaçı bulunamadı","status"=>500];
  }


  public function medslist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("mf.name medsfirmname,f.name firmname,b.name branchname,m.*")
    ->from('meds m')
    ->leftjoin('medfirms mf','mf.id=m.medfirmid')
    ->leftjoin('firm f','f.id=mf.firmid')
    ->leftjoin('firm b','b.id=mf.branchid');
    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('m.id='.$request['id']);
    }
    if(isset($request['medfirmid']) && $request['medfirmid']!=null && $request['medfirmid']!=0)
    {
        $response=$response->where('m.medfirmid='.$request['medfirmid']);
    }
     $response=$response->order("m.name asc")->queryAll();

		return ["data"=>$response,"status"=>true];
  }


  public function medsdetail($request)
  {
    return self::medslist($request);
  }


  public function medscreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='' && isset($request['medfirmid_cu']) && $request['medfirmid_cu']!='' && $request['medfirmid_cu']!=0)
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Meds;
      }else{
        $model=Meds::model()->findByPk($request['id_cu']);
      }
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->firmid=isset($request['firmid_cu'])?$request['firmid_cu']:$model->firmid;
       $model->branchid=isset($request['branchid_cu'])?$request['branchid_cu']:$model->branchid;
       $model->brand=isset($request['brand_cu'])?$request['brand_cu']:$model->brand;
       $model->unit=isset($request['unit_cu'])?$request['unit_cu']:$model->unit;
       $model->medfirmid=isset($request['medfirmid_cu'])?$request['medfirmid_cu']:$model->medfirmid;
       $model->isactive=isset($request['isactive_cu'])?$request['isactive_cu']:$model->isactive;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

  public function medsisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Meds::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Firma ilaçı bulunamadı","status"=>500];
  }

   public function medsdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Meds::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Firma ilacı Bulunamadı","status"=>500];
    }

   public function medsdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::medsdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek firma ilacını seçmelisiniz","status"=>500];
    }

  ////////////. firma ilaç  bitiş ////////


  //////////////// monitörr bilhileri başlangıc ///////////

  public function monitorlist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("f.name firmname,b.name branchname,c.name clientname,cb.name clientbrancname,d.name departmentname,sd.name subdepartmentname,mt.name monitoringtypeid,ml.name monitoringlocationname,ml.name monitoringlocationdetail,m.*")
    ->from('monitoring m')
    ->leftjoin('client cb','cb.id=m.clientid')
    ->leftjoin('client c','c.id=cb.parentid')
    ->leftjoin('firm b','b.id=c.firmid')
    ->leftjoin('firm f','f.id=b.parentid')
    ->leftjoin('departments d','d.id=m.dapartmentid')
    ->leftjoin('departments sd','sd.id=m.subid')
    ->leftjoin('monitoringtype mt','mt.id=m.mtypeid')
    ->leftjoin('monitoringlocation ml','ml.id=m.mlocationid');

    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('m.id='.$request['id']);
    }
    if(isset($request['clientid']) && $request['clientid']!=null && $request['clientid']!=0)
    {
        $response=$response->where('m.clientid='.$request['clientid']);
    }
     if(isset($request['mno']) && $request['mno']!=null && $request['mno']!=0)
    {
        $response=$response->where('m.mno='.$request['mno']);
    }

     $response=$response->order("m.mno asc")->queryAll();
		return ["data"=>$response,"status"=>true];
  }


  public function monitordetail($request)
  {
    return self::monitorlist($request);
  }


  public function monitorcreateupdate($request)
  {
    if(!empty($request) && isset($request['mno_cu']) && $request['mno_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $req['clientid']=$request['clientid_cu'];
        $req['mno']=$request['mno_cu'];
        $monitor=self::monitorlist($req);
        if(!empty($monitor))
        {
          return ["data"=>"Daha önceden bu monitör numarası girilmiş","status"=>500];
        }
        $model=new Monitoring;
        $model->createdtime=time();
      }else{
        $model=Monitoring::model()->findByPk($request['id_cu']);
      }
      	$dynamicstring=Monitoring::model()->barkodeControl(time()+rand(0,999999)+round(microtime(true) * 1000));
        $model->dapartmentid=isset($request['dapartmentid_cu'])?intval($request['dapartmentid_cu']):$model->dapartmentid;
        $model->subid=isset($request['subid_cu'])?intval($request['subid_cu']):$model->subid;
        $model->clientid=isset($request['clientid_cu'])?intval($request['clientid_cu']):$model->clientid;
        $model->mno=isset($request['mno_cu'])?$request['mno_cu']:$model->mno;
        $model->barcodeno=isset($request['barcodeno_cu'])?$dynamicstring:$model->barcodeno;
        $model->mtypeid=isset($request['mtypeid_cu'])?intval($request['mtypeid_cu']):$model->mtypeid;
        $model->mlocationid=isset($request['mlocationid_cu'])?intval($request['mlocationid_cu']):$model->mlocationid;
        $model->definationlocation=isset($request['definationlocation_cu'])?$request['definationlocation_cu']:$model->definationlocation;
        $model->active=isset($request['active_cu'])?$request['active_cu']:$model->active;

        if($_POST['active_cu']==1)
        {
          $model->activetime=time();
        }
      else{
        $model->activetime=0;
      }
        if($_POST['active_cu']==0)
        {
          $model->passivetime=time();
        }
      else{
        $model->passivetime=0;
      }
        if($request['id_cu']=='' || $request['id_cu']==0)
        {
          $ids=array();
          $monitorolurturma=1;
          include("./barcode/newBarcode.php");
          $barcode=barcode($dynamicstring);
          if($barcode['status']==500)
          {
            return ["data"=>$barcode['data'],"status"=>500];
          }
        }

       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }

    public function monitorisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Monitoring::model()->findByPk($request['id']);
      if($model)
      {
          $model->active=$model->active==0?1:0;
          if($model->active==1)
          {
            $model->activetime=time();
          }
        else{
          $model->passivetime=time();
        }
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Monitör bulunamadı","status"=>500];
  }

   public function monitordelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Monitoring::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Monitör Bulunamadı","status"=>500];
    }

   public function monitordeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::monitordelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek firma ilacını seçmelisiniz","status"=>500];
    }

  public function monitornumber($request)
  {
     $monitorcount=Monitoring::model()->find(array(
								   'order'=>'mno DESC',
								   'condition'=>'clientid='.$request['clientid'],
							   ));
    return ["status"=>true,"data"=>(($monitorcount->mno)+1)];
  }
  //////////// monitor bitiş ////////


  ///// monitör lokasyon başlangıç //////

  public function monitoringlocationlist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("ml.*")
    ->from('monitoringlocation ml');
    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('ml.id='.$request['id']);
    }
     $response=$response->order("ml.name asc")->queryAll();

		return ["data"=>$response,"status"=>true];
  }


  public function monitoringlocationdetail($request)
  {
    return self::monitoringlocationlist($request);
  }


  public function monitoringlocationcreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Monitoringlocation;
      }else{
        $model=Monitoringlocation::model()->findByPk($request['id_cu']);
      }
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->detailed=isset($request['detailed_cu'])?$request['detailed_cu']:$model->detailed;
       $model->active=isset($request['isactive_cu'])?$request['isactive_cu']:$model->active;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


    public function monitoringlocationisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Monitoringlocation::model()->findByPk($request['id']);
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
    return ["data"=>"Monitör lokasyonu bulunamadı","status"=>500];
  }

   public function monitoringlocationdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Monitoringlocation::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Monitör Lokasyonu Bulunamadı","status"=>500];
    }

   public function monitoringlocationdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::monitoringlocationdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek monitör lokasyonu seçmelisiniz","status"=>500];
    }

  ////////////. monitör lokasyon  bitiş ////////



  ///// monitör tipi ve haşere eşleştirme başlangıç //////

  public function monitoringtypepetslist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("mtp.*,mt.name typename,p.name petsname")
    ->from('monitoringtypepets mtp')
    ->leftjoin('monitoringtype mt','mt.id=mtp.monitoringtypeid')
    ->leftjoin('pets p','p.id=mtp.petsid');
    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('mtp.id='.$request['id']);
    }
     $response=$response->order("p.name asc")->queryAll();

		return ["data"=>$response,"status"=>true];
  }


  public function monitoringtypepetsdetail($request)
  {
    return self::monitoringtypepetslist($request);
  }


  public function monitoringtypepetscreateupdate($request)
  {
    if(!empty($request) && isset($request['petsid_cu']) && $request['petsid_cu']!='' && isset($request['monitoringtypeid_cu']) && $request['monitoringtypeid_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Monitoringtypepets;
      }else{
        $model=Monitoringtypepets::model()->findByPk($request['id_cu']);
      }
       $model->petsid=isset($request['petsid_cu'])?$request['petsid_cu']:$model->petsid;
       $model->isactive=isset($request['isactive_cu'])?$request['isactive_cu']:$model->isactive;
       $model->monitoringtypeid=isset($request['monitoringtypeid_cu'])?$request['monitoringtypeid_cu']:$model->monitoringtypeid;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


    public function monitoringtypepetsisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Monitoringtypepets::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Monitör tip-haşere bulunamadı","status"=>500];
  }

   public function monitoringtypepetsdelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Monitoringtypepets::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Monitör tip-haşere Bulunamadı","status"=>500];
    }

   public function monitoringtypepetsdeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::monitoringtypepetsdelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek monitör tip-haşere seçmelisiniz","status"=>500];
    }

  ////////////. monitör tipi ve haşere eşleştirme  bitiş ////////


   ///// iş emri uygulama tipi başlangıç //////

  public function treatmenttypelist($request)
  {
    $response=Yii::app()->db->createCommand()
		->select("tt.*,f.name firmname,b.name branchname")
    ->from('treatmenttype tt')
    ->leftjoin('firm f','f.id=tt.firmid')
    ->leftjoin('firm b','b.id=tt.branchid');
    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('tt.id='.$request['id']);
    }
     $response=$response->order("tt.name asc")->queryAll();

		return ["data"=>$response,"status"=>true];
  }


  public function treatmenttypedetail($request)
  {
    return self::treatmenttypelist($request);
  }


  public function treatmenttypecreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Treatmenttype;
      }else{
        $model=Treatmenttype::model()->findByPk($request['id_cu']);
      }
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->isactive=isset($request['isactive_cu'])?$request['isactive_cu']:$model->isactive;
       $model->firmid=isset($request['firm_cu'])?$request['firm_cu']:$model->firmid;
      $model->branchid=isset($request['branch_cu'])?$request['branch_cu']:$model->branchid;
       if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


    public function treatmenttypeisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Treatmenttype::model()->findByPk($request['id']);
      if($model)
      {
          $model->isactive=$model->isactive==0?1:0;
           if($model->save())
            {
              return ["data"=>[],"status"=>true];
            }
            return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
      }
    }
    return ["data"=>"Uygulama tipi bulunamadı","status"=>500];
  }

   public function treatmenttypedelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Treatmenttype::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Uygulama tipi bulunamadı","status"=>500];
    }

   public function treatmenttypedeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::treatmenttypedelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek uygulama tipiniseçmelisiniz","status"=>500];
    }

  ////////////. iş emri uygulama tipi  bitiş ////////




   ///// sektör başlangıç //////

  public function sectorlist($request,$type=0)
  {
    $response=Yii::app()->db->createCommand()
		->select("*")
    ->from('sector s');
    if(isset($request['id']) && $request['id']!=null && $request['id']!=0)
    {
        $response=$response->where('s.id='.$request['id']);
    }
     $response=$response->order("s.name asc")->queryAll();

    if($type)
    {
      array_unshift($response,['id'=>'','name'=>t("Seçiniz")]);
      return $response;
    }
		return ["data"=>$response,"status"=>true];
  }


  public function sectordetail($request)
  {
    return self::sectorlist($request);
  }


  public function sectorcreateupdate($request)
  {
    if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
    {
      if($request['id_cu']=='' || $request['id_cu']==0)
      {
        $model=new Sector;
      }else{
        $model=Sector::model()->findByPk($request['id_cu']);
      }
       $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
       $model->active=isset($request['active_cu'])?$request['active_cu']:$model->active;
       $model->parentid=isset($request['parent_cu'])?$request['parent_cu']:$model->parentid;
      if($model->save())
          {
             return ["data"=>[],"status"=>true];
          }
          else{
             return ["data"=>$model->errors,"status"=>500];
          }
    }
    else
    {
       return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
    }

  }


    public function sectorisactive($request)
  {
     if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
    {
       $model=Sector::model()->findByPk($request['id']);
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
    return ["data"=>"Uygulama tipi bulunamadı","status"=>500];
  }

   public function sectordelete($request)
    {
      if($request['id_delete']!=0 && $request['id_delete']!='')
      {
         $model=Sector::model()->findByPk($request['id_delete']);
        if($model)
        {
          if($model->delete())
              {
                return ["data"=>[],"status"=>true];
              }
              return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
        }
      }
      return ["data"=>"Sektör bulunamadı","status"=>500];
    }
  /*
   public function sectordeleteall($request)
    {
       if($request['id_delete']!=0 && $request['id_delete']!='')
        {
        $deleteall=explode(',',$request['id_delete']);
        foreach($deleteall as $delete)
        {
          $id['id_delete']=$delete;
          $silinenData=self::sectordelete($id);
          if($silinenData['status']==500){
            return ["data"=>$silinenData['data'],"status"=>500];
          }
        }
        return ["data"=>[],"status"=>true];
       }
        return ["data"=>"Silinecek sektör seçmelisiniz","status"=>500];
    }
    */

  ////////////.sektör uygulama tipi  bitiş ////////





//   public function departmentcreateupdate($request)
//   {
//     if(!empty($request) && isset($request['name_cu']) && $request['name_cu']!='')
//     {
//       if($request['id_cu']=='' || $request['id_cu']==0)
//       {
//         $model=new Departments;
//       }else{
//         $model=Departments::model()->findByPk($request['id_cu']);
//       }
//        $model->clientid=isset($request['clientid_cu'])?$request['clientid_cu']:$model->clientid;
//        $model->parentid=isset($request['parentid_cu'])?$request['parentid_cu']:$model->parentid;
//        $model->name=isset($request['name_cu'])?$request['name_cu']:$model->name;
//        $model->active=isset($request['active_cu'])?$request['active_cu']:$model->active;
//        if($model->save())
//           {
//              return ["data"=>[],"status"=>true];
//           }
//           else{
//              return ["data"=>$model->errors,"status"=>500];
//           }
//     }
//     else
//     {
//        return ["data"=>"Lütfen zorunlu alanları doldurun","status"=>500];
//     }

//   }

//    public function departmentdelete($request)
//     {
//       if($request['id_delete']!=0 && $request['id_delete']!='')
//       {
//          $model=Departments::model()->findByPk($request['id_delete']);
//         if($model)
//         {
//           if($model->delete())
//               {
//                 return ["data"=>[],"status"=>true];
//               }
//               return ["data"=>"Silme işlemi sırasında hata oluştu","status"=>500];
//         }
//       }
//       return ["data"=>"Departman Bulunamadı","status"=>500];
//     }

//    public function departmentdeleteall($request)
//     {
//        if($request['id_delete']!=0 && $request['id_delete']!='')
//         {
//         $deleteall=explode(',',$request['id_delete']);
//         foreach($deleteall as $delete)
//         {
//           $id['id_delete']=$delete;
//           $silinenData=self::departmentdelete($id);
//           if($silinenData['status']==500){
//             return ["data"=>$silinenData['data'],"status"=>500];
//           }
//         }
//         return ["data"=>[],"status"=>true];
//        }
//         return ["data"=>"Silinecek departmanı seçmelisiniz","status"=>500];
//     }


//   public function departmentisactive($request)
//   {

//      if(isset($request['id']) && $request['id']!=0 && $request['id']!='')
//     {
//        $model=Departments::model()->findByPk($request['id']);
//       if($model)
//       {
//           $model->active=$model->active==0?1:0;
//            if($model->save())
//             {
//               return ["data"=>[],"status"=>true];
//             }
//             return ["data"=>"Güncelleme işlemi sırasında hata oluştu","status"=>500];
//       }
//     }
//     return ["data"=>"Departman Bulunamadı","status"=>500];
//   }


  ////////////. staffteam  bitiş ////////





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
