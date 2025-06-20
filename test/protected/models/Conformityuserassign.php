<?php

/**
 * This is the model class for table "conformityuserassign".
 *
 * The followings are the available columns in table 'conformityuserassign':
 * @property integer $id
 * @property integer $parentid
 * @property integer $conformityid
 * @property integer $senderuserid
 * @property integer $recipientuserid
 * @property integer $returnstatustype
 * @property integer $sendtime
 * @property string $definition
 */
class Conformityuserassign extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conformityuserassign';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentid, conformityid, senderuserid, recipientuserid, returnstatustype, sendtime', 'required'),
			array('parentid, conformityid, senderuserid, recipientuserid, returnstatustype, sendtime', 'numerical', 'integerOnly'=>true),
			array('definition', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parentid, conformityid, senderuserid, recipientuserid, returnstatustype, sendtime, definition', 'safe', 'on'=>'search'),
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
			'parentid' => 'Parentid',
			'conformityid' => 'Conformityid',
			'senderuserid' => 'Gönderici User',
			'recipientuserid' => 'Alıcı User',
			'returnstatustype' => '1 atama-2atamayı kabul geri gönderme',
			'sendtime' => 'Gönderilme zamanı',
			'definition' => 'Definition',
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
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('conformityid',$this->conformityid);
		$criteria->compare('senderuserid',$this->senderuserid);
		$criteria->compare('recipientuserid',$this->recipientuserid);
		$criteria->compare('returnstatustype',$this->returnstatustype);
		$criteria->compare('sendtime',$this->sendtime);
		$criteria->compare('definition',$this->definition,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Conformityuserassign the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
