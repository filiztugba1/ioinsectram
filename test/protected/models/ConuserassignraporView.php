<?php

/**
 * This is the model class for table "conuserassignrapor_view".
 *
 * The followings are the available columns in table 'conuserassignrapor_view':
 * @property integer $id
 * @property integer $conformityid
 * @property integer $firmid
 * @property integer $mainbranchid
 * @property integer $branchid
 * @property integer $clientid
 * @property integer $clientbranchid
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property integer $type
 */
class ConuserassignraporView extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conuserassignrapor_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('conformityid, email', 'required'),
			array('id, conformityid, firmid, mainbranchid, branchid, clientid, clientbranchid, type', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>128),
			array('name, surname', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, conformityid, firmid, mainbranchid, branchid, clientid, clientbranchid, email, name, surname, type', 'safe', 'on'=>'search'),
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
			'conformityid' => 'Conformityid',
			'firmid' => 'Firmid',
			'mainbranchid' => 'Mainbranchid',
			'branchid' => 'Branchid',
			'clientid' => 'Clientid',
			'clientbranchid' => 'Clientbranchid',
			'email' => 'Email',
			'name' => 'Name',
			'surname' => 'Surname',
			'type' => 'Super Admin / Firm Admin / Firm Staff / Branch Admin / Branch Staff / Customer Admin / Customer Staff',
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
		$criteria->compare('conformityid',$this->conformityid);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('mainbranchid',$this->mainbranchid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('clientbranchid',$this->clientbranchid);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConuserassignraporView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
