<?php

/**
 * This is the model class for table "ziyaretci_log".
 *
 * The followings are the available columns in table 'ziyaretci_log':
 * @property integer $ziyaretci_log_no
 * @property string $ip
 * @property string $sayfa
 * @property string $sayfa_no
 * @property string $url
 * @property string $anahtar
 * @property string $ziyaret_tarihi
 */
class ZiyaretciLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ziyaretci_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip, sayfa, url, ziyaret_tarihi', 'required'),
			array('ip', 'length', 'max'=>15),
			array('sayfa', 'length', 'max'=>20),
			array('sayfa_no', 'length', 'max'=>50),
			array('anahtar', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ziyaretci_log_no, ip, sayfa, sayfa_no, url, anahtar, ziyaret_tarihi', 'safe', 'on'=>'search'),
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
			'ziyaretci_log_no' => 'Ziyaretci Log No',
			'ip' => 'Ip',
			'sayfa' => 'Sayfa',
			'sayfa_no' => 'Sayfa No',
			'url' => 'Url',
			'anahtar' => 'Anahtar',
			'ziyaret_tarihi' => 'Ziyaret Tarihi',
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

		$criteria->compare('ziyaretci_log_no',$this->ziyaretci_log_no);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('sayfa',$this->sayfa,true);
		$criteria->compare('sayfa_no',$this->sayfa_no,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('anahtar',$this->anahtar,true);
		$criteria->compare('ziyaret_tarihi',$this->ziyaret_tarihi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ZiyaretciLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
