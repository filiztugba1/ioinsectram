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
class NewPackageModel extends CActiveRecord
{

  public function packageList($id=null,$type) // id değeri gelirse detayını çekeceğiz
  {
		$response=Yii::app()->db->createCommand()
		->select("*")
		->from('packages p');
    if($id!=null)
    {
        $response=$response->where('.id='.$id);
    }
    $response=$response->order("p.name asc")->queryAll();
    
    if(isset($type['type']) && $type['type']=='select')
    {
       return $response;
    }
		
     return ["data"=>$response,"status"=>true];
  }
  
  public function packageDetail($request)
  {
    return self::firmList(null,$request['id']);
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
