<?php

/**
 * This is the model class for table "staffteam".
 *
 * The followings are the available columns in table 'staffteam':
 * @property integer $id
 * @property string $teamname
 * @property integer $leaderid
 * @property string $staff
 * @property integer $firmid
 * @property string $color
 */
class Map extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teamname, staff, firmid', 'required'),
			array('leaderid, firmid', 'numerical', 'integerOnly'=>true),
			array('teamname, color', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, teamname, leaderid, staff, firmid, color', 'safe', 'on'=>'search'),
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
			'teamname' => 'Teamname',
			'leaderid' => 'Leaderid',
			'staff' => 'Staff',
			'firmid' => 'Firmid',
			'color' => 'Color',
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
		$criteria->compare('teamname',$this->teamname,true);
		$criteria->compare('leaderid',$this->leaderid);
		$criteria->compare('staff',$this->staff,true);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('color',$this->color,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staffteam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
