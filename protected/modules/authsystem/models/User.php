<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $firmid
 * @property integer $branchid
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property integer $type
 * @property string $authgroup
 * @property integer $languageid
 * @property integer $active
 * @property integer $createduser
 * @property integer $createdtime
 * @property string $code
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firmid, branchid, username, password, email, name, surname, type, authgroup, languageid, active, createduser, createdtime', 'required'),
			array('firmid, branchid, type, languageid, active, createduser, createdtime', 'numerical', 'integerOnly'=>true),
			array('username, password, email', 'length', 'max'=>128),
			array('name, surname', 'length', 'max'=>30),
			array('authgroup', 'length', 'max'=>255),
			array('code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firmid, branchid, username, password, email, name, surname, type, authgroup, languageid, active, createduser, createdtime, code', 'safe', 'on'=>'search'),
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
			'firmid' => 'Firmid',
			'branchid' => 'Branchid',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'name' => 'Name',
			'surname' => 'Surname',
			'type' => 'Super Admin / Firm Admin / Firm Staff / Branch Admin / Branch Staff / Customer Admin / Customer Staff',
			'authgroup' => 'Authgroup',
			'languageid' => 'Languageid',
			'active' => 'Active',
			'createduser' => 'Createduser',
			'createdtime' => 'Createdtime',
			'code' => 'Code',
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
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('authgroup',$this->authgroup,true);
		$criteria->compare('languageid',$this->languageid);
		$criteria->compare('active',$this->active);
		$criteria->compare('createduser',$this->createduser);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
