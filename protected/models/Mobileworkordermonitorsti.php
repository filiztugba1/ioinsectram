<?php

/**
 * This is the model class for table "mobileworkordermonitorsti".
 *
 * The followings are the available columns in table 'mobileworkordermonitorsti':
 * @property integer $id
 * @property integer $workorderid
 * @property integer $monitorid
 * @property integer $monitorno
 * @property integer $monitortype
 * @property string $pettypes
 * @property integer $barcodeno
 * @property integer $barcodestatus
 * @property integer $firmid
 * @property integer $firmbranchid
 * @property integer $clientid
 * @property integer $clientbranchid
 * @property integer $departmentid
 * @property integer $subdepartment
 * @property string $cantscancomment
 * @property integer $saverid
 * @property integer $checkdate
 */
class Mobileworkordermonitorsti extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mobileworkordermonitorsti';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workorderid, monitorid, monitorno, monitortype, pettypes, barcodeno, barcodestatus, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartment, saverid, checkdate', 'required'),
			array('workorderid, monitorid, monitorno, monitortype,  barcodestatus, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartment, saverid, checkdate', 'numerical', 'integerOnly'=>true),
			array('pettypes', 'length', 'max'=>255),
			array('cantscancomment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, workorderid, monitorid, monitorno, monitortype, pettypes, barcodeno, barcodestatus, firmid, firmbranchid, clientid, clientbranchid, departmentid, subdepartment, cantscancomment, saverid, checkdate', 'safe', 'on'=>'search'),
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
			'workorderid' => 'Workorderid',
			'monitorid' => 'Monitorid',
			'monitorno' => 'Monitorno',
			'monitortype' => 'Monitortype',
			'pettypes' => 'Pettypes',
			'barcodeno' => 'Barcodeno',
			'barcodestatus' => 'Barcodestatus',
			'firmid' => 'Firmid',
			'firmbranchid' => 'Firmbranchid',
			'clientid' => 'Clientid',
			'clientbranchid' => 'Clientbranchid',
			'departmentid' => 'Departmentid',
			'subdepartment' => 'Subdepartment',
			'cantscancomment' => 'Cantscancomment',
			'saverid' => 'Saverid',
			'checkdate' => 'Checkdate',
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
		$criteria->compare('workorderid',$this->workorderid);
		$criteria->compare('monitorid',$this->monitorid);
		$criteria->compare('monitorno',$this->monitorno);
		$criteria->compare('monitortype',$this->monitortype);
		$criteria->compare('pettypes',$this->pettypes,true);
		$criteria->compare('barcodeno',$this->barcodeno);
		$criteria->compare('barcodestatus',$this->barcodestatus);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('firmbranchid',$this->firmbranchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('departmentid',$this->departmentid);
		$criteria->compare('subdepartment',$this->subdepartment);
		$criteria->compare('cantscancomment',$this->cantscancomment,true);
		$criteria->compare('saverid',$this->saverid);
		$criteria->compare('checkdate',$this->checkdate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mobileworkordermonitorsti the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
