<?php

/**
 * This is the model class for table "loglar".
 *
 * The followings are the available columns in table 'loglar':
 * @property integer $id
 * @property integer $userid
 * @property string $data
 * @property string $tablename
 * @property string $operation
 * @property integer $createdtime
 */
class Loglar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'loglar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, data, tablename, operation, createdtime', 'required'),
			array('userid, createdtime', 'numerical', 'integerOnly'=>true),
			array('tablename, operation', 'length', 'max'=>225),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, data, tablename, operation, createdtime', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'data' => 'Data',
			'tablename' => 'Tablename',
			'operation' => 'Operation',
			'createdtime' => 'Createdtime',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('tablename',$this->tablename,true);
		$criteria->compare('operation',$this->operation,true);
		$criteria->compare('createdtime',$this->createdtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

		public function create($data)
	{
		
		$ax= User::model()->userobjecty('');
		
		
		if($data!='null')
		{
		$model=new Loglar;
		$model->userid=$ax->id;
		$model->data=$data; // json_encode
		$model->tablename=Yii::app()->controller->id;
		$model->operation=Yii::app()->controller->action->id;
		$model->createdtime=time();
		if (!$model->save()){
							var_dump($model->geterrors());
							exit;
						}
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Loglar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
