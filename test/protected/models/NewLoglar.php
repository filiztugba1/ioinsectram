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
  public function LogCreate($data)  ///gelen data formatı string olmalı
  {
    	$ax= User::model()->userobjecty('');
      if($data!='null')
      {
      $model=new Loglar;
      $model->userid=$ax->id;
      $model->data=$data; // json_encode
      $model->tablename=Yii::app()->controller->id;
      $model->operation=Yii::app()->controller->action->id;
      $model->createdtime=time();
      if (!$model->save()){
                 return ["data"=>$model->geterrors(),"status"=>500];
              }
         return ["data"=>[],"status"=>true];
      }
  }
  

  	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}