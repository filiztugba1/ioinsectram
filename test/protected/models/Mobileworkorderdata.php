<?php

/**
 * This is the model class for table "mobileworkorderdata".
 *
 * The followings are the available columns in table 'mobileworkorderdata':
 * @property integer $id
 * @property integer $mobileworkordermonitorsid
 * @property integer $workorderid
 * @property integer $monitorid
 * @property integer $monitortype
 * @property integer $petid
 * @property integer $pettype
 * @property integer $value
 * @property integer $saverid
 * @property integer $createdtime
 * @property integer $firmid
 * @property integer $firmbranchid
 * @property integer $clientid
 * @property integer $clientbranchid
 * @property integer $departmentid
 * @property integer $subdepartmentid
 * @property integer $openedtimestart
 * @property integer $openedtimeend
 * @property integer $isproduct
 */
class Mobileworkorderdata extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mobileworkorderdata';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobileworkordermonitorsid, workorderid, monitorid, monitortype, petid, pettype, value, saverid, createdtime, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartmentid, openedtimestart, openedtimeend, isproduct', 'required'),
			array('mobileworkordermonitorsid, workorderid, monitorid, monitortype, petid, pettype, value, saverid, createdtime, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartmentid, openedtimestart, openedtimeend, isproduct', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mobileworkordermonitorsid, workorderid, monitorid, monitortype, petid, pettype, value, saverid, createdtime, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartmentid, openedtimestart, openedtimeend, isproduct', 'safe', 'on'=>'search'),
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
			'mobileworkordermonitorsid' => 'Mobileworkordermonitorsid',
			'workorderid' => 'Workorderid',
			'monitorid' => 'Monitorid',
			'monitortype' => 'Monitortype',
			'petid' => 'Petid',
			'pettype' => 'Pettype',
			'value' => 'Value',
			'saverid' => 'Saverid',
			'createdtime' => 'Createdtime',
			'firmid' => 'monitörün ait olduğu firma',
			'firmbranchid' => 'monitörün ait olduğu firma branchı',
			'clientid' => 'monitörün ait olduğu müşteri',
			'clientbranchid' => 'monitörün ait olduğu müşteri şube',
			'departmentid' => 'monitörün departman idsi',
			'subdepartmentid' => 'monitörün subdepartmant idsi',
			'openedtimestart' => 'workorder başlangıç tarih saat timestampı',
			'openedtimeend' => 'workorder bitiş tarih saat timestampı',
			'isproduct' => 'gluebord ya da lamba mı ya da yem mi',
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
		$criteria->compare('mobileworkordermonitorsid',$this->mobileworkordermonitorsid);
		$criteria->compare('workorderid',$this->workorderid);
		$criteria->compare('monitorid',$this->monitorid);
		$criteria->compare('monitortype',$this->monitortype);
		$criteria->compare('petid',$this->petid);
		$criteria->compare('pettype',$this->pettype);
		$criteria->compare('value',$this->value);
		$criteria->compare('saverid',$this->saverid);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('firmbranchid',$this->firmbranchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('departmentid',$this->departmentid);
		$criteria->compare('subdepartmentid',$this->subdepartmentid);
		$criteria->compare('openedtimestart',$this->openedtimestart);
		$criteria->compare('openedtimeend',$this->openedtimeend);
		$criteria->compare('isproduct',$this->isproduct);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mobileworkorderdata the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
