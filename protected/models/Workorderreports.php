<?php

/**
 * This is the model class for table "workorderreports".
 *
 * The followings are the available columns in table 'workorderreports':
 * @property integer $workorderid
 * @property integer $monitorid
 * @property integer $monitorno
 * @property integer $monitortype
 * @property string $barcodeno
 * @property integer $barcodestatus
 * @property integer $firmid
 * @property string $firmname
 * @property integer $firmbranchid
 * @property string $firmbranchname
 * @property integer $clientid
 * @property string $clientname
 * @property integer $clientbranchid
 * @property string $clientbranchname
 * @property integer $departmentid
 * @property string $departmentname
 * @property integer $subdepartment
 * @property integer $mwmsaverid
 * @property integer $checkdate
 * @property integer $value
 * @property integer $mwdsaverid
 * @property integer $openedtimestart
 * @property integer $openedtimeend
 * @property integer $petsid
 * @property integer $pettype
 * @property integer $isproduct
 */
class Workorderreports extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'workorderreports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workorderid, monitorid, monitorno, monitortype, barcodeno, barcodestatus, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartment, mwmsaverid, checkdate', 'required'),
			array('workorderid, monitorid, monitorno, monitortype, barcodestatus, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartment, mwmsaverid, checkdate, value, mwdsaverid, openedtimestart, openedtimeend, petsid, pettype, isproduct', 'numerical', 'integerOnly'=>true),
			array('barcodeno, firmname, firmbranchname, clientname, clientbranchname, departmentname', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('workorderid, monitorid, monitorno, monitortype, barcodeno, barcodestatus, firmid, firmname, firmbranchid, firmbranchname, clientid, clientname, clientbranchid, clientbranchname, departmentid, departmentname, subdepartment, mwmsaverid, checkdate, value, mwdsaverid, openedtimestart, openedtimeend, petsid, pettype, isproduct', 'safe', 'on'=>'search'),
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
			'workorderid' => 'Workorderid',
			'monitorid' => 'Monitorid',
			'monitorno' => 'Monitorno',
			'monitortype' => 'Monitortype',
			'barcodeno' => 'Barcodeno',
			'barcodestatus' => 'Barcodestatus',
			'firmid' => 'Firmid',
			'firmname' => 'Firmname',
			'firmbranchid' => 'Firmbranchid',
			'firmbranchname' => 'Firmbranchname',
			'clientid' => 'Clientid',
			'clientname' => 'Müşteri Adı',
			'clientbranchid' => 'Clientbranchid',
			'clientbranchname' => 'Müşteri Adı',
			'departmentid' => 'Departmentid',
			'departmentname' => 'Department Name',
			'subdepartment' => 'Subdepartment',
			'mwmsaverid' => 'Mwmsaverid',
			'checkdate' => 'Checkdate',
			'value' => 'Value',
			'mwdsaverid' => 'Mwdsaverid',
			'openedtimestart' => 'workorder başlangıç tarih saat timestampı',
			'openedtimeend' => 'workorder bitiş tarih saat timestampı',
			'petsid' => 'Petsid',
			'pettype' => 'Pettype',
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

		$criteria->compare('workorderid',$this->workorderid);
		$criteria->compare('monitorid',$this->monitorid);
		$criteria->compare('monitorno',$this->monitorno);
		$criteria->compare('monitortype',$this->monitortype);
		$criteria->compare('barcodeno',$this->barcodeno,true);
		$criteria->compare('barcodestatus',$this->barcodestatus);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('firmname',$this->firmname,true);
		$criteria->compare('firmbranchid',$this->firmbranchid);
		$criteria->compare('firmbranchname',$this->firmbranchname,true);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientname',$this->clientname,true);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('clientbranchname',$this->clientbranchname,true);
		$criteria->compare('departmentid',$this->departmentid);
		$criteria->compare('departmentname',$this->departmentname,true);
		$criteria->compare('subdepartment',$this->subdepartment);
		$criteria->compare('mwmsaverid',$this->mwmsaverid);
		$criteria->compare('checkdate',$this->checkdate);
		$criteria->compare('value',$this->value);
		$criteria->compare('mwdsaverid',$this->mwdsaverid);
		$criteria->compare('openedtimestart',$this->openedtimestart);
		$criteria->compare('openedtimeend',$this->openedtimeend);
		$criteria->compare('petsid',$this->petsid);
		$criteria->compare('pettype',$this->pettype);
		$criteria->compare('isproduct',$this->isproduct);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Workorderreports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
