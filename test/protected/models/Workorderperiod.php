<?php

/**
 * This is the model class for table "workorderperiod".
 *
 * The followings are the available columns in table 'workorderperiod':
 * @property integer $id
 * @property string $code
 * @property string $startfinishdate
 * @property integer $againnumber
 * @property string $dayweekmonthyear
 * @property string $day
 * @property string $monthday
 */
class Workorderperiod extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'workorderperiod';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('againnumber', 'numerical', 'integerOnly'=>true),
			array('code, startfinishdate, dayweekmonthyear, day, monthday', 'length', 'max'=>225),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, startfinishdate, againnumber, dayweekmonthyear, day, monthday', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'startfinishdate' => 'Startfinishdate',
			'againnumber' => 'Againnumber',
			'dayweekmonthyear' => 'Dayweekmonthyear',
			'day' => 'Day',
			'monthday' => 'Monthday',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('startfinishdate',$this->startfinishdate,true);
		$criteria->compare('againnumber',$this->againnumber);
		$criteria->compare('dayweekmonthyear',$this->dayweekmonthyear,true);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('monthday',$this->monthday,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Workorderperiod the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
