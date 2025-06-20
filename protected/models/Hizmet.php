<?php

/**
 * This is the model class for table "hizmet".
 *
 * The followings are the available columns in table 'hizmet':
 * @property integer $hizmet_no
 * @property string $fiyat
 * @property string $indirim_orani
 * @property string $yillik_fiyat
 * @property string $baslik
 * @property string $ozellik
 * @property string $icerik
 * @property string $sef
 * @property string $keywords
 * @property integer $sira_no
 * @property integer $anasayfa
 * @property integer $yazar
 * @property string $kayit_tarihi
 * @property integer $durum
 */
class Hizmet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hizmet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('baslik, ozellik, icerik, sef, keywords, sira_no, yazar, kayit_tarihi', 'required'),
			array('sira_no, anasayfa, yazar, durum', 'numerical', 'integerOnly'=>true),
			array('fiyat, yillik_fiyat', 'length', 'max'=>7),
			array('indirim_orani', 'length', 'max'=>3),
			array('baslik, sef', 'length', 'max'=>100),
			array('keywords', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hizmet_no, fiyat, indirim_orani, yillik_fiyat, baslik, ozellik, icerik, sef, keywords, sira_no, anasayfa, yazar, kayit_tarihi, durum', 'safe', 'on'=>'search'),
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
			'hizmet_no' => 'Hizmet No',
			'fiyat' => 'Fiyat',
			'indirim_orani' => 'Indirim Orani',
			'yillik_fiyat' => 'Yillik Fiyat',
			'baslik' => 'Baslik',
			'ozellik' => 'Ozellik',
			'icerik' => 'Icerik',
			'sef' => 'Sef',
			'keywords' => 'Keywords',
			'sira_no' => 'Sira No',
			'anasayfa' => 'Anasayfa',
			'yazar' => 'Yazar',
			'kayit_tarihi' => 'Kayit Tarihi',
			'durum' => 'Durum',
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

		$criteria->compare('hizmet_no',$this->hizmet_no);
		$criteria->compare('fiyat',$this->fiyat,true);
		$criteria->compare('indirim_orani',$this->indirim_orani,true);
		$criteria->compare('yillik_fiyat',$this->yillik_fiyat,true);
		$criteria->compare('baslik',$this->baslik,true);
		$criteria->compare('ozellik',$this->ozellik,true);
		$criteria->compare('icerik',$this->icerik,true);
		$criteria->compare('sef',$this->sef,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('sira_no',$this->sira_no);
		$criteria->compare('anasayfa',$this->anasayfa);
		$criteria->compare('yazar',$this->yazar);
		$criteria->compare('kayit_tarihi',$this->kayit_tarihi,true);
		$criteria->compare('durum',$this->durum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hizmet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
