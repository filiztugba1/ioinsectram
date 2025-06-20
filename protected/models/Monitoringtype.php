<?php

/**
 * This is the model class for table "monitoringtype".
 *
 * The followings are the available columns in table 'monitoringtype':
 * @property integer $id
 * @property string $name
 * @property string $detailed
 * @property integer $type
 * @property integer $active
 * @property integer $country_id
 */
class Monitoringtype extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'monitoringtype';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, detailed, type, active', 'required'),
			array('type, active', 'numerical', 'integerOnly'=>true),
			array('name, detailed', 'length', 'max'=>255),
      array('monitorbordercolor, monitorbackgroundcolor', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, detailed, type, active', 'safe', 'on'=>'search'),
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
			'detailed' => 'Detailed',
			'type' => 'Type',
			'active' => 'Active',
			'country_id' => 'country_id',
      'monitorbordercolor' => 'monitorbordercolor',
      'monitorbackgroundcolor' => 'monitorbackgroundcolor',
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
	
		public function clientmytpecheck($client_id,$mtype_id,$mlocationid=0)
	{
      	//	return true;
			if ($mlocationid<>0){
				$type=Monitoring::model()->find(array('condition'=>'clientid=:id and mtypeid=:mid and mlocationid=:mlid','params'=>array('id'=>$client_id,'mid'=>$mtype_id,'mlid'=>$mlocationid)));
			}else{
				$type=Monitoring::model()->find(array('condition'=>'clientid=:id and mtypeid=:mid','params'=>array('id'=>$client_id,'mid'=>$mtype_id)));
			}
			
			if($type)
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('detailed',$this->detailed,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('active',$this->active);
		$criteria->compare('country_id',$this->country_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function changeactive($id,$isactive)
	{
		$type=Monitoringtype::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($type)
		{
			$type->active=$isactive;
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
			echo "bulamad�m";exit;
		}
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Monitoringtype the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
