<?php

/**
 * This is the model class for table "generalsettings".
 *
 * The followings are the available columns in table 'generalsettings':
 * @property integer $id
 * @property string $name
 * @property integer $userid
 * @property integer $type
 * @property integer $isactive
 */
class Generalsettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'generalsettings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, userid, type, isactive', 'required'),
			array('userid, type, isactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, userid, type, isactive', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'type' => 'Type',
			'isactive' => 'Isactive',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('type',$this->type);
		$criteria->compare('isactive',$this->isactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public function defaultcreate($name)
	{	
		$ax= User::model()->userobjecty('');
		$model=new Generalsettings;
		$model->name=$name;
		$model->isactive=1;
		$model->type=1;
		$model->userid=$ax->id;
		
		$model->save();
	}




	public function dateformat($time)
	{

		$ax= User::model()->userobjecty('');
		$date=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'dateformat','userid'=>$ax->id)
										 ));
	
	

		if($date->type==1)
		{
            $time2=date("Y/m/d H:i:s",$time);
		}else
		if($date->type==2)
		{
            $time2=date("d/m/Y H:i:s",$time);
		}else
		if($date->type==3)
		{
			$time2=date('g:ia \o\n l jS F Y',$time);
		}else if ($date->type==0 or $date->type>3){
            $time2=date("d/m/Y H:i:s",$time);

		}
	
		return $time2;
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Generalsettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
