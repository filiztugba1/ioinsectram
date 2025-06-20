<?php

/**
 * This is the model class for table "genel_icerik".
 *
 * The followings are the available columns in table 'genel_icerik':
 * @property integer $genel_icerik_no
 * @property string $baslik
 * @property string $icerik
 * @property string $kayit_tarihi
 */
class GenelIcerik extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'genel_icerik';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('baslik, icerik, kayit_tarihi', 'required'),
			array('baslik', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('genel_icerik_no, baslik, icerik, kayit_tarihi', 'safe', 'on'=>'search'),
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
			'genel_icerik_no' => 'Genel Icerik No',
			'baslik' => 'Baslik',
			'icerik' => 'Icerik',
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

		$criteria->compare('genel_icerik_no',$this->genel_icerik_no);
		$criteria->compare('baslik',$this->baslik,true);
		$criteria->compare('icerik',$this->icerik,true);
		$criteria->compare('kayit_tarihi',$this->kayit_tarihi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GenelIcerik the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
