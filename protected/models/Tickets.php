<?php

/**
 * This is the model class for table "tickets".
 *
 * The followings are the available columns in table 'tickets':
 * @property integer $id
 * @property string $to
 * @property string $from
 * @property integer $status
 * @property string $subject
 * @property string $body
 * @property string $atachment
 * @property integer $readstate
 * @property string $readtime
 * @property string $note
 * @property integer $createdat
 */
class Tickets extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tickets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' createdat', 'required'),
			array('status, readstate, createdat', 'numerical', 'integerOnly'=>true),
			array('readtime', 'length', 'max'=>15),
			array('body, atachment, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, subject, body, atachment, readstate, readtime, note, createdat', 'safe', 'on'=>'search'),
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
			'status' => '0-bekliyor 1-işlemde 2-kapalı',
			'subject' => 'Subject',
			'body' => 'Body',
			'atachment' => 'Atachment',
			'readstate' => 'Readstate',
			'readtime' => 'Readtime',
			'note' => 'Note',
			'createdat' => 'Createdat',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('atachment',$this->atachment,true);
		$criteria->compare('readstate',$this->readstate);
		$criteria->compare('readtime',$this->readtime,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('createdat',$this->createdat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getStatus($type)
	{
		if ($type==0)
		 {
			 return t('New');
		 }
		 elseif($type==1){
			  return t("Open");
		  }
		 else{
			 return t("Closed");
		 }
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tickets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
