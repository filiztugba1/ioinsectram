<?php

/**
 * This is the model class for table "maps".
 *
 * The followings are the available columns in table 'maps':
 * @property integer $id
 * @property string $map_name
 * @property string $created_date
 * @property integer $is_active
 * @property integer $client_id
 * @property string $points
 * @property string $monitor
 */
class Maps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'maps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('map_name, created_date, client_id', 'required'),
			array('is_active, client_id', 'numerical', 'integerOnly'=>true),
			array('map_name', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, map_name, created_date, is_active, client_id', 'safe', 'on'=>'search'),
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
			'map_name' => 'Map Name',
			'created_date' => 'Created Date',
			'is_active' => 'Is Active',
			'client_id' => 'Client',
			'points' => 'points',
			'monitor' => 'monitor',
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
		$criteria->compare('map_name',$this->map_name,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('points',$this->points,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function changeactive($id,$isactive)
	{
		$map=Maps::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));

		if($map)
		{
			$map->is_active=$isactive;

			if(!$map->update())
			{
				print_r($map->getErrors());
			}

			return true;
		}
		else
		{
			echo "bulamadım";exit;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Maps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
