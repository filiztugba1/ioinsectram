<?php

/**
 * This is the model class for table "servicereport".
 *
 * The followings are the available columns in table 'servicereport':
 * @property integer $id
 * @property integer $client_name
 * @property string $date
 * @property string $reportno
 * @property string $visittype
 * @property string $servicedetails
 * @property string $trade_name
 * @property string $active_ingredient
 * @property string $amount_applied
 * @property string $riskreview
 * @property string $technician_sign
 * @property string $client_sign
 */
class Servicereport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'servicereport';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, reportno, visittype, servicedetails, trade_name, active_ingredient, amount_applied, riskreview, technician_sign, client_sign', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_name, date, reportno, visittype, servicedetails, trade_name, active_ingredient, amount_applied, riskreview, technician_sign, client_sign', 'safe', 'on'=>'search'),
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
			'client_name' => 'Client Name',
			'date' => 'Date',
			'reportno' => 'Reportno',
			'visittype' => 'Visittype',
			'servicedetails' => 'Servicedetails',
			'trade_name' => 'Trade Name',
			'active_ingredient' => 'Active Ingredient',
			'amount_applied' => 'Amount Applied',
			'riskreview' => 'Riskreview',
			'technician_sign' => 'Technician Sign',
			'client_sign' => 'Client Sign',
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
		$criteria->compare('client_name',$this->client_name);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('reportno',$this->reportno,true);
		$criteria->compare('visittype',$this->visittype,true);
		$criteria->compare('servicedetails',$this->servicedetails,true);
		$criteria->compare('trade_name',$this->trade_name,true);
		$criteria->compare('active_ingredient',$this->active_ingredient,true);
		$criteria->compare('amount_applied',$this->amount_applied,true);
		$criteria->compare('riskreview',$this->riskreview,true);
		$criteria->compare('technician_sign',$this->technician_sign,true);
		$criteria->compare('client_sign',$this->client_sign,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Servicereport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
