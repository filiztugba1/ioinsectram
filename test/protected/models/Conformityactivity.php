<?php

/**
 * This is the model class for table "conformityactivity".
 *
 * The followings are the available columns in table 'conformityactivity':
 * @property integer $id
 * @property string $date
 * @property string $definition
 * @property integer $conformityid
 */
class Conformityactivity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conformityactivity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, definition, conformityid', 'required'),
			array('conformityid', 'numerical', 'integerOnly'=>true),
			array('date', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, definition, conformityid', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'definition' => 'Definition',
			'conformityid' => 'Conformityid',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('definition',$this->definition,true);
		$criteria->compare('conformityid',$this->conformityid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}




	public function changeactive($id,$isactive)
	{
		$activity=Conformityactivity::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($activity)
		{
			$activity->isactive=$isactive;
			if(!$activity->update())
			{
				print_r($activity->getErrors());
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
	 * @return Conformityactivity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
