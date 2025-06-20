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
class NewDocumentModel extends CActiveRecord
{

  public function documentCategoryList($request)
  {
       $responseM=Yii::app()->db->createCommand()
        ->select("dc.*,(select count(d.id) from documents d left join userdocumentview ud on ud.documentid=d.id where d.categoryid=dc.id and ud.id is null and ud.userid=1) as say")
        ->from('documentcategory dc')
        ->where('dc.parent=0')
        ->order("id asc")->queryAll();
    
    $kategori=[];
    foreach($responseM as $responseMx)
    {
       $response=Yii::app()->db->createCommand()
        ->select("dc.*,(select count(d.id) from documents d left join userdocumentview ud on ud.documentid=d.id where d.categoryid=dc.id and ud.id is null and ud.userid=1) as say")
        ->from('documentcategory dc')
        ->where('dc.parent='.$responseMx['id'])
        ->order("name asc")->queryAll();
      
        $documents=Yii::app()->db->createCommand()
        ->select("*")
        ->from('documents dc')
        ->where('dc.categoryid='.$responseMx['id'])
        ->order("name asc")->queryAll();
      
       $responseMx['subKategori']=$response;
       $responseMx['documents']=$documents;
      
       foreach($response as $key=>$responsek)
        {
           $documentsSub=Yii::app()->db->createCommand()
          ->select("*")
          ->from('documents dc')
          ->where('dc.categoryid='.$responsek['id'])
          ->order("name asc")->queryAll();
         $responseMx['subKategori'][$key]['documents']=$documentsSub;
       }
      
        array_push($kategori,$responseMx);
     }
    
    
		 return ["data"=>$kategori,"status"=>true];
  }

  public function usercreateupdate($request)
  {
    
			$ax= User::model()->userobjecty('');
      $kayitTipi=0;
      if(isset($request['id_cu']) && $request['id_cu']!=0)
      {
        $model=User::model()->findByPk($request['id_cu']);
        $kayitTipi=1;
        if($request['password_cu']) //şifre bilgisi girilmedi ise şifre yeniden oluşturulmasın
        {
          $model->password=CPasswordHelper::hashPassword($request['password_cu']);
        }
        User::model()->datahanmail($_POST['User']['password']);
      }
      else 
      {
        $model=new User;
        $model->password=CPasswordHelper::hashPassword($request['password_cu']);
      }
			$model->username=$request['username_cu'];
			$model->name=$request['name_cu'];
			$model->surname=$request['surname_cu'];
			
    
			$model->email=$request['email_cu'];
      $model->active=$request['isactive_cu'];
			$model->color=isset($request['color_cu'])?$request['color_cu']:"#000";
			$model->userlgid=$request['language_cu'];
			$model->firmid=$request['firmid'];
    	$model->branchid=isset($request['firmbranchtransfer_cu'])?$request['firmbranchtransfer_cu']:$request['branchid'];
			$model->mainbranchid=$request['clientid'];
			$model->code=User::model()->authcode(12,1,"lower_case,upper_case,numbers")[0];
			$model->createduser=$ax->id;
			$model->createdtime=time();
      $model->type=$request['firmid']=0?1:
           ($request['firmid']!=0 && $request['branchid']==0 && $request['yetki_cu']==0?13:
           ($request['firmid']!=0 && $request['branchid']==0 && $request['yetki_cu']==1?17:
           ($request['branchid']!=0 && $request['clientid']==0 && $request['yetki_cu']==0?23:
           ($request['branchid']!=0 && $request['clientid']==0 && $request['yetki_cu']==1?19:
           ($request['clientid']!=0 && $request['clientbranchid']==0 && $request['yetki_cu']==0?22:
           ($request['clientid']!=0 && $request['clientbranchid']==0 && $request['yetki_cu']==1?24:
           ($request['clientid']!=0 && $request['clientbranchid']!=0 && $request['yetki_cu']==0?26:
           ($request['clientid']!=0 && $request['clientbranchid']!=0 && $request['yetki_cu']==1?27:0))))))));
    
     
			 $availablefirm=Firm::model()->find(array(  'condition'=>'id=:id','params'=>array('id'=>$request['firmid'])));
			 $baseauthpath=AuthItem::model()->find(array('condition'=>"name Like '%".$availablefirm->username."'"))->name;



			if((User::model()->maxuserlimit($baseauthpath,$type)==1 || $request['clientid']!=0) || $kayitTipi)
			{
				if (!$model->save()){   ////kullanıcı kaydı gerçekleşmesse hata uyurısı verilecek
					  return ["data"=>$model->geterrors(),"status"=>500];
				}
        
        if(!$kayitTipi)  ///ekleme isee 
        {
          
            AuthAssignment::model()->createassignment($model->id,$baseauthpath.'.'.($request['yetki_cu']==0?'Admin':'Staff'));

            // depertman and sub departman
            //departmanı kullanıcıya yetki verme
            $where='where user.id='.$model->id.' and departments.parentid=0';
            User::model()->departmanpermission($where);
            //sub departmanı kullanıcıya yetki verme
            $where='where user.id='.$model->id;
            User::model()->subdepartmanpermission($where);

            $usertaffinfo=new Userinfo;
           
        }
        else   ////////eğer güncelleme ise mail ve kullanıcıya detay yeni model açılıyor
        {
        
          $usertaffinfo=Userinfo::model()->findByPk($request['id_cu']);
        }
            $conformityemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'conformityemail','userid'=>$model->id)
							   ));
        if(!isset($conformityemail))
        {
           $conformityemail=new Generalsettings;
        }
        //////////. uygunsuzluk maili aktif pasiflik durumu /////////
         $conformityemail->type=$request['isemailactive_cu'];
         $conformityemail->isactive=1;
         $conformityemail->name="conformityemail";
         $conformityemail->userid=$model->id;
         $conformityemail->save();
        
        /////////// kullanıcı detay bilgileri giriliyor ///////
        $usertaffinfo->id=$model->id;
				$usertaffinfo->userid=$model->id;
				$usertaffinfo->birthplace=$request['birth_place_cu'];
				$usertaffinfo->birthdate=$request['birth_year_cu'];
				$usertaffinfo->gender=$request['genger_cu'];
				$usertaffinfo->primaryphone=$request['phone_cu'];
				$usertaffinfo->save();

				//transfer edilen firmanın kullnıcısına yetki verme
				if($model->branchid!=0)
				{
					User::model()->depsubpertransfer($model->id,$model->branchid);
				}


	
        return ["data"=>$response,"status"=>true];
				
			}

		return ["data"=>t('Maksimum kullanıcı limiti üzerine çıkamazsınız'),"status"=>500];

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
