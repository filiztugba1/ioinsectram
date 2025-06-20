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
class Findings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'findings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workorder_id', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, workorder_id, unique_id, note, picture_url', 'safe', 'on'=>'search'),
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
			'workorder_id' => 'workorder_id',
			'unique_id' => 'unique_id',
			'note' => 'note',
			'picture_url' => 'picture_url',
			'file_size' => 'file_size',
			'saver_id' => 'saver_id',
			'created_time' => 'created_time',
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
		$criteria->compare('workorder_id',$this->workorder_id);
		$criteria->compare('unique_id',$this->unique_id);
		$criteria->compare('note',$this->note);
		$criteria->compare('picture_url',$this->picture_url);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('saver_id',$this->saver_id);
		$criteria->compare('created_time',$this->created_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function isencrypt($workorder_id,$unique_id='',$length = 8)
	{
		if($unique_id=='')
		{
			$unic_name=substr(bin2hex(random_bytes($length)), 0, $length);
		}
		$varmiencrypt=Findings::model()->find(array('condition'=>'workorder_id="'.$workorder_id.'" and unique_id="'.$unic_name.'"'));
		 if (!$varmiencrypt){
			 return $unic_name;
		 }
		return isencrypt($workorder_id,'',8);
		
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
