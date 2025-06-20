<?php

/**
 * This is the model class for table "meds".
 *
 * The followings are the available columns in table 'meds':
 * @property integer $id
 * @property integer $firmid
 * @property integer $branchid
 * @property string $name
 * @property string $unit
 * @property integer $medfirmid
 * @property integer $isactive
 */
class Financialsettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'financial_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clientbranch_id	', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, workorder_id', 'safe', 'on'=>'search'),
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
			'clientbranch_id	' => 'clientbranch_id	',
			'contract_start_date' => 'contract_start_date',
			'contract_end_date' => 'contract_end_date',
			'vat' => 'vat',
			'vat_perc' => 'vat_perc',
			'currency' => 'currency',
			'joint_period' => 'joint_period',
			'joint_limit' => 'joint_limit',
			'created_time' => 'created_time',
			'json_data' => 'json_data',
			'updated_time' => 'updated_time',
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
		$criteria->compare('clientbranch_id',$this->clientbranch_id);
		$criteria->compare('contract_start_date',$this->contract_start_date);
		$criteria->compare('contract_end_date',$this->contract_end_date);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('vat_perc',$this->vat_perc);
		$criteria->compare('currency',$this->currency);
		$criteria->compare('joint_period',$this->joint_period);
		$criteria->compare('joint_limit',$this->joint_limit);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('json_data',$this->json_data);
		$criteria->compare('updated_time',$this->updated_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Meds the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
