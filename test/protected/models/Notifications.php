<?php

/**
 * This is the model class for table "notifications".
 *
 * The followings are the available columns in table 'notifications':
 * @property integer $id
 * @property integer $sender
 * @property integer $userid
 * @property string $subject
 * @property integer $type
 * @property integer $urlid
 * @property integer $createdtime
 * @property integer $readtime
 */
class Notifications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender, userid', 'required'),
			array('sender, userid, type, urlid, createdtime, readtime', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sender, userid, subject, type, urlid, createdtime, readtime', 'safe', 'on'=>'search'),
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
			'sender' => 'Gönderen Kişi',
			'userid' => 'Alan Kişi',
			'subject' => 'Açıklama',
			'type' => 'Dışarıdan Çekilecek(ör:profil mi ürün mü?)',
			'urlid' => 'Url id',
			'createdtime' => 'Göderilme Zamanı',
			'readtime' => 'Görülme Zamanı',
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
		$criteria->compare('sender',$this->sender);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('urlid',$this->urlid);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('readtime',$this->readtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
