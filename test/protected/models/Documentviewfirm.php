<?php

/**
 * This is the model class for table "documentviewfirm".
 *
 * The followings are the available columns in table 'documentviewfirm':
 * @property integer $id
 * @property integer $documentid
 * @property integer $viewerid
 * @property integer $type
 * @property integer $firmid
 * @property integer $branchid
 * @property integer $clientid
 * @property integer $clientbranchid
 * @property integer $createdtime
 */
class Documentviewfirm extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documentviewfirm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firmid, branchid, clientid, clientbranchid, createdtime', 'required'),
			array('documentid, viewerid, type, firmid, branchid, clientid, clientbranchid, createdtime', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, documentid, viewerid, type, firmid, branchid, clientid, clientbranchid, createdtime', 'safe', 'on'=>'search'),
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
			'documentid' => 'Documentid',
			'viewerid' => 'Viewerid',
			'type' => 'admin=0,firm=1,branch=2,client=3,clientbranch=4	',
			'firmid' => 'Firmid',
			'branchid' => 'Branchid',
			'clientid' => 'Clientid',
			'clientbranchid' => 'Clientbranchid',
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
		$criteria->compare('documentid',$this->documentid);
		$criteria->compare('viewerid',$this->viewerid);
		$criteria->compare('type',$this->type);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('createdtime',$this->createdtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Documentviewfirm the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
