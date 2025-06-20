<?php

/**
 * This is the model class for table "userinfo".
 *
 * The followings are the available columns in table 'userinfo':
 * @property integer $id
 * @property integer $userid
 * @property string $identification_number
 * @property string $birthplace
 * @property string $birthdate
 * @property integer $gender
 * @property string $primaryphone
 * @property string $secondaryphone
 * @property integer $country
 * @property integer $marital
 * @property integer $children
 * @property string $address
 * @property integer $address_country
 * @property integer $address_city
 * @property string $blood
 * @property integer $driving_licance
 * @property string $driving_licance_date
 * @property integer $military
 * @property integer $educationid
 * @property string $speaks
 * @property string $certificate
 * @property integer $travel
 * @property integer $health_problem
 * @property string $health_description
 * @property integer $smoking
 * @property string $emergencyname
 * @property string $emergencyphone
 * @property string $leavedate
 * @property string $leave_description
 * @property string $referance
 * @property string $projects
 * @property string $computerskills
 */
class Userinfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'userinfo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'required'),
			array('userid, gender, country, marital, children, address_country, address_city, driving_licance, military, educationid, travel, health_problem, smoking', 'numerical', 'integerOnly'=>true),
			array('identification_number', 'length', 'max'=>30),
			array('birthplace', 'length', 'max'=>50),
			array('birthdate, blood, driving_licance_date', 'length', 'max'=>10),
			array('primaryphone, secondaryphone', 'length', 'max'=>25),
			array('address, health_description, emergencyname, emergencyphone, leave_description, referance, projects, computerskills', 'length', 'max'=>255),
			array('speaks, certificate', 'length', 'max'=>150),
			array('leavedate', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, identification_number, birthplace, birthdate, gender, primaryphone, secondaryphone, country, marital, children, address, address_country, address_city, blood, driving_licance, driving_licance_date, military, educationid, speaks, certificate, travel, health_problem, health_description, smoking, emergencyname, emergencyphone, leavedate, leave_description, referance, projects, computerskills', 'safe', 'on'=>'search'),
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
			'userid' => 'User ID',
			'identification_number' => 'TC Kimlik No',
			'birthplace' => 'Doğum Yeri',
			'birthdate' => 'Doğum Tarihi',
			'gender' => 'Cinsiyet',
			'primaryphone' => 'Telefon no1',
			'secondaryphone' => 'Telefon no2',
			'country' => 'Ülke',
			'marital' => 'Evlilik Durumu',
			'children' => 'Çocuk Sayısı',
			'address' => 'Adres',
			'address_country' => 'Adres Ülke',
			'address_city' => 'Adres İl',
			'blood' => 'Kan Grubu',
			'driving_licance' => 'Sürücü Ehliyeti var/yok',
			'driving_licance_date' => 'Sürücü Ehliyeti Alış Tarihi',
			'military' => 'Askerlik Durumu',
			'educationid' => 'education tablosundaki karşılık gelen id',
			'speaks' => 'konuştuğu dillerin idleri örn. = 1,5,7 ',
			'certificate' => 'certificate tablosundaki idler gelecek örn: 1,5,48',
			'travel' => 'Seyehat Edilen Yerler',
			'health_problem' => 'Sağlık Problemi',
			'health_description' => 'Sağlık Problemi Açıklaması',
			'smoking' => 'Sigara İçme Durumu',
			'emergencyname' => 'İsim',
			'emergencyphone' => 'Telefon',
			'leavedate' => 'İşden Ayrılma Tarihi',
			'leave_description' => 'İşden Ayrılma Nedeni',
			'referance' => 'Referanslar',
			'projects' => 'Projeler',
			'computerskills' => 'Bilgisayar Kullanma Derecesi',
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
		$criteria->compare('identification_number',$this->identification_number,true);
		$criteria->compare('birthplace',$this->birthplace,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('primaryphone',$this->primaryphone,true);
		$criteria->compare('secondaryphone',$this->secondaryphone,true);
		$criteria->compare('country',$this->country);
		$criteria->compare('marital',$this->marital);
		$criteria->compare('children',$this->children);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('address_country',$this->address_country);
		$criteria->compare('address_city',$this->address_city);
		$criteria->compare('blood',$this->blood,true);
		$criteria->compare('driving_licance',$this->driving_licance);
		$criteria->compare('driving_licance_date',$this->driving_licance_date,true);
		$criteria->compare('military',$this->military);
		$criteria->compare('educationid',$this->educationid);
		$criteria->compare('speaks',$this->speaks,true);
		$criteria->compare('certificate',$this->certificate,true);
		$criteria->compare('travel',$this->travel);
		$criteria->compare('health_problem',$this->health_problem);
		$criteria->compare('health_description',$this->health_description,true);
		$criteria->compare('smoking',$this->smoking);
		$criteria->compare('emergencyname',$this->emergencyname,true);
		$criteria->compare('emergencyphone',$this->emergencyphone,true);
		$criteria->compare('leavedate',$this->leavedate,true);
		$criteria->compare('leave_description',$this->leave_description,true);
		$criteria->compare('referance',$this->referance,true);
		$criteria->compare('projects',$this->projects,true);
		$criteria->compare('computerskills',$this->computerskills,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Userinfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
