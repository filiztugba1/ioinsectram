<?php

/**
 * This is the model class for table "ek1_firm_forms".
 *
 * The followings are the available columns in table 'ek1_firm_forms':
 * @property integer $id
 * @property integer $ek1_form_id
 * @property string $defaults_json_data
 * @property integer $firm_id
 * @property integer $firm_branch_id
 */
class Ek1FirmForms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ek1_firm_forms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ek1_form_id, defaults_json_data, firm_id', 'required'),
			array('ek1_form_id, firm_id, firm_branch_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ek1_form_id, defaults_json_data, firm_id, firm_branch_id', 'safe', 'on'=>'search'),
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
			'ek1_form_id' => 'Ek1 Form',
			'defaults_json_data' => 'Defaults Json Data',
			'firm_id' => 'Firm',
			'firm_branch_id' => 'Firm Branch',
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
		$criteria->compare('ek1_form_id',$this->ek1_form_id);
		$criteria->compare('defaults_json_data',$this->defaults_json_data,true);
		$criteria->compare('firm_id',$this->firm_id);
		$criteria->compare('firm_branch_id',$this->firm_branch_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ek1FirmForms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
