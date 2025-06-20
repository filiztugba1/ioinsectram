<?php

/**
 * This is the model class for table "iletisim_formu".
 *
 * The followings are the available columns in table 'iletisim_formu':
 * @property integer $iletisim_formu_no
 * @property string $firma
 * @property string $ad_soyad
 * @property string $mail
 * @property string $telefon
 * @property string $mesaj
 * @property integer $paket
 * @property integer $okundu
 * @property string $ip
 * @property string $kayit_tarihi
 */
class IletisimFormu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iletisim_formu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firma, ad_soyad, mail, telefon, mesaj, paket, ip, kayit_tarihi', 'required'),
			array('paket, okundu', 'numerical', 'integerOnly'=>true),
			array('firma, ad_soyad, mail', 'length', 'max'=>150),
			array('telefon', 'length', 'max'=>50),
			array('mesaj', 'length', 'max'=>500),
			array('ip', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iletisim_formu_no, firma, ad_soyad, mail, telefon, mesaj, paket, okundu, ip, kayit_tarihi', 'safe', 'on'=>'search'),
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
			'iletisim_formu_no' => 'Iletisim Formu No',
			'firma' => 'Firma',
			'ad_soyad' => 'Ad Soyad',
			'mail' => 'Mail',
			'telefon' => 'Telefon',
			'mesaj' => 'Mesaj',
			'paket' => 'Paket',
			'okundu' => 'Okundu',
			'ip' => 'Ip',
			'kayit_tarihi' => 'Kayit Tarihi',
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

		$criteria->compare('iletisim_formu_no',$this->iletisim_formu_no);
		$criteria->compare('firma',$this->firma,true);
		$criteria->compare('ad_soyad',$this->ad_soyad,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('mesaj',$this->mesaj,true);
		$criteria->compare('paket',$this->paket);
		$criteria->compare('okundu',$this->okundu);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('kayit_tarihi',$this->kayit_tarihi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IletisimFormu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
