<?php

/**
 * This is the model class for table "monitoring".
 *
 * The followings are the available columns in table 'monitoring':
 * @property integer $id
 * @property integer $dapartmentid
 * @property integer $subid
 * @property integer $clientid
 * @property integer $mno
 * @property string $barcodeno
 * @property integer $mtypeid
 * @property integer $mlocationid
 * @property string $definationlocation
 * @property integer $active
 * @property integer $createdtime
 * @property integer $activetime
 * @property integer $passivetime
 */
class Monitoring extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'monitoring';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dapartmentid, subid, clientid, mno, mtypeid, mlocationid, definationlocation, active, createdtime, activetime, passivetime', 'required'),
			array('dapartmentid, subid, clientid, mno, mtypeid, mlocationid, active, createdtime, activetime, passivetime', 'numerical', 'integerOnly'=>true),
			array('barcodeno, definationlocation,alternativenumber', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dapartmentid, subid, clientid, mno, barcodeno, mtypeid, mlocationid, definationlocation, active, createdtime, activetime, passivetime,techdescription', 'safe', 'on'=>'search'),
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
			'dapartmentid' => 'Dapartmentid',
			'subid' => 'Subid',
			'clientid' => 'Clientid',
			'mno' => 'Mno',
			'barcodeno' => 'Barcodeno',
			'mtypeid' => 'Mtypeid',
			'mlocationid' => 'Mlocationid',
			'definationlocation' => 'Definationlocation',
			'alternativenumber' => 'alternativenumber',
			'active' => 'Active',
			'createdtime' => 'Createdtime',
			'activetime' => 'Activetime',
			'passivetime' => 'Passivetime',
			'techdescription' => 'techdescription',
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
		$criteria->compare('dapartmentid',$this->dapartmentid);
		$criteria->compare('subid',$this->subid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('mno',$this->mno);
		$criteria->compare('barcodeno',$this->barcodeno,true);
		$criteria->compare('mtypeid',$this->mtypeid);
		$criteria->compare('mlocationid',$this->mlocationid);
		$criteria->compare('definationlocation',$this->definationlocation,true);
		$criteria->compare('alternativenumber',$this->alternativenumber,true);
		$criteria->compare('techdescription',$this->techdescription,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('createdtime',$this->createdtime);
		$criteria->compare('activetime',$this->activetime);
		$criteria->compare('passivetime',$this->passivetime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getmonitorno($id=0)
	{
		$a=$this->findbypk($id);
		if ($a)
		{
			return $a->mno;
		}
	}
		public function changeactive($id,$isactive)
	{
		$monitoring=Monitoring::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($monitoring)
		{
			$monitoring->active=$isactive;
			if($isactive==1)
			{
				$monitoring->activetime=time();
			}
			if($isactive==0)
			{
				 $monitoring->passivetime=time();
			}

			if(!$monitoring->update())
			{
				print_r($monitoring->getErrors());
			}

			return true;
		}
		else
		{
			echo "bulamadım";exit;
		}
	}

	public function barkodeControl($barcode)
	{
		$mbarkod=Monitoring::model()->findAll(array(
									 'condition'=>'barcodeno="'.$barcode.'"',
								 ));
		$dynamicstring=time()+rand(0,999999)+round(microtime(true) * 1000);
		if($mbarkod)
		{
			return Monitoring::model()->barkodeControl($dynamicstring);
		}
		else
		{
			return $dynamicstring;
		}
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Monitoring the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
