<?php

/**
 * This is the model class for table "treatmenttype".
 *
 * The followings are the available columns in table 'treatmenttype':
 * @property integer $id
 * @property string $name
 * @property integer $isactive
 * @property integer $firmid
 * @property integer $branchid
 */
class Treatmenttype extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'treatmenttype';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, branchid', 'required'),
			array('isactive, firmid, branchid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, isactive, firmid, branchid', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'isactive' => 'Isactive',
			'firmid' => 'Firmid',
			'branchid' => 'Branchid',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('isactive',$this->isactive);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public function changeactive($id,$isactive)
	{
		$type=Treatmenttype::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($type)
		{
			$type->isactive=$isactive;
			if(!$type->update())
			{
				print_r($type->getErrors());
			}
			else{
				return true;
			}		
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
	 * @return Treatmenttype the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
