<?php

/**
 * This is the model class for table "stokkimyasalkullanim".
 *
 * The followings are the available columns in table 'stokkimyasalkullanim':
 * @property integer $id
 * @property integer $firmid
 * @property integer $branchid
 * @property string $kimyasaladi
 * @property string $aktifmaddetanimi
 * @property string $yontem
 * @property integer $ruhsattarih
 * @property integer $ruhsatno
 * @property integer $isactive
 * @property integer $createdtime
 */
class Stokkimyasalkullanim extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stokkimyasalkullanim';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firmid, branchid, kimyasaladi, aktifmaddetanimi, yontem, ruhsattarih, ruhsatno, isactive, createdtime', 'required'),
			array('firmid, branchid, ruhsattarih, isactive, createdtime', 'numerical', 'integerOnly'=>true),
			array('kimyasaladi', 'length', 'max'=>255),
			array('ruhsatno', 'length', 'max'=>100),
			array('aktifmaddetanimi, yontem', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firmid, branchid, kimyasaladi, aktifmaddetanimi, yontem, ruhsattarih, ruhsatno, isactive, createdtime', 'safe', 'on'=>'search'),
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
			'kimyasaladi' => 'Kimyasaladi',
			'aktifmaddetanimi' => 'Aktifmaddetanimi',
			'yontem' => 'Yontem',
			'ruhsattarih' => 'Ruhsattarih',
			'ruhsatno' => 'Ruhsatno',
			'isactive' => 'Isactive',
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
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('kimyasaladi',$this->kimyasaladi,true);
		$criteria->compare('aktifmaddetanimi',$this->aktifmaddetanimi,true);
		$criteria->compare('yontem',$this->yontem,true);
		$criteria->compare('ruhsattarih',$this->ruhsattarih);
		$criteria->compare('ruhsatno',$this->ruhsatno);
		$criteria->compare('isactive',$this->isactive);
		$criteria->compare('createdtime',$this->createdtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function changeactive($id,$isactive)
	{
		$type=Stokkimyasalkullanim::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($type)
		{
			$type->isactive=$isactive;
			if(!$type->update())
			{
				print_r($type->getErrors());
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
	 * @return Stokkimyasalkullanim the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
