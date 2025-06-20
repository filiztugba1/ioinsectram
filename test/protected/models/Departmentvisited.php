<?php

/**
 * This is the model class for table "departmentvisited".
 *
 * The followings are the available columns in table 'departmentvisited':
 * @property integer $id
 * @property string $treatmenttypeid
 * @property string $monitoringtype
 * @property integer $workorderid
 * @property string $departmentid
 * @property string $subdepartmentid
 * @property string $monitoringno
 * @property integer $mavailable
 */
class Departmentvisited extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'departmentvisited';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('', 'required'),
			array('workorderid, mavailable', 'numerical', 'integerOnly'=>true),
			array('treatmenttypeid, monitoringtype, departmentid, subdepartmentid', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, treatmenttypeid, monitoringtype, workorderid, departmentid, subdepartmentid, monitoringno, mavailable', 'safe', 'on'=>'search'),
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
			'treatmenttypeid' => 'Treatmenttypeid',
			'monitoringtype' => 'Monitoringtype',
			'workorderid' => 'Workorderid',
			'departmentid' => 'Departmentid',
			'subdepartmentid' => 'Subdepartmentid',
			'monitoringno' => 'Monitoringno',
			'mavailable' => 'Mavailable',
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
		$criteria->compare('treatmenttypeid',$this->treatmenttypeid,true);
		$criteria->compare('monitoringtype',$this->monitoringtype,true);
		$criteria->compare('workorderid',$this->workorderid);
		$criteria->compare('departmentid',$this->departmentid,true);
		$criteria->compare('subdepartmentid',$this->subdepartmentid,true);
		$criteria->compare('monitoringno',$this->monitoringno,true);
		$criteria->compare('mavailable',$this->mavailable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Departmentvisited the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
