<?php

/**
 * This is the model class for table "email".
 *
 * The followings are the available columns in table 'email':
 * @property integer $id
 * @property string $smtphost
 * @property integer $port
 * @property string $email
 * @property string $password
 * @property string $fromname
 * @property string $fromemail
 * @property integer $isdefault
 */
class Email extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('smtphost, port, email, password, fromname, fromemail, isdefault', 'required'),
			array('port, isdefault', 'numerical', 'integerOnly'=>true),
			array('smtphost, email, password, fromname, fromemail', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, smtphost, port, email, password, fromname, fromemail, isdefault', 'safe', 'on'=>'search'),
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
			'smtphost' => 'Smtphost',
			'port' => 'Port',
			'email' => 'Email',
			'password' => 'Password',
			'fromname' => 'Fromname',
			'fromemail' => 'Fromemail',
			'isdefault' => 'Isdefault',
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
		$criteria->compare('smtphost',$this->smtphost,true);
		$criteria->compare('port',$this->port);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fromname',$this->fromname,true);
		$criteria->compare('fromemail',$this->fromemail,true);
		$criteria->compare('isdefault',$this->isdefault);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function changeactive($id,$isactive)
	{
		$email=Email::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($email)
		{
			$email->isdefault=$isactive;
			if(!$email->update())
			{
				print_r($email->getErrors());
			}
			else{
				return true;
			}		
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
	 * @return Email the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
