<?php

/**
 * This is the model class for table "packages".
 *
 * The followings are the available columns in table 'packages':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $isactive
 */
class Packages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'packages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, isactive', 'required'),
			array('isactive', 'numerical', 'integerOnly'=>true),
			array('name, code', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, code, isactive', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'isactive' => 'Isactive',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('isactive',$this->isactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function changeactive($id,$isactive)
	{
		$package=Packages::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($package)
		{
			$package->isactive=$isactive;
			if(!$package->update())
			{
				print_r($package->getErrors());
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
	 * @return Packages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
