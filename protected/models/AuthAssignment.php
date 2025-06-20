<?php

/**
 * This is the model class for table "AuthAssignment".
 *
 * The followings are the available columns in table 'AuthAssignment':
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property AuthItem $itemname0
 */
class AuthAssignment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'AuthAssignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max'=>255),
			array('bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('itemname, userid, bizrule, data', 'safe', 'on'=>'search'),
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
			'itemname0' => array(self::BELONGS_TO, 'AuthItem', 'itemname'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemname' => 'Itemname',
			'userid' => 'Userid',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
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
	 public function createassignment($userid,$auth)
	{
		$item=new AuthAssignment;
		$item->itemname=$auth;
		$item->userid=$userid;
		
     		if(!$item->save())
			{
   var_dump($userstaff->geterrors());
      }
    // exit;

	}

	public function getfirmauthname($firmid)
	{
		$authname='';
		$firm=Firm::model()->findbypk($firmid);
		if ($firm->parentid==0){
		$authname=$firm->package.'.'.$firm->username.'.Admin';
		}else
		{
		
		$firm2=Firm::model()->findbypk($firm->parentid);
		$authname=$firm2->package.'.'.$firm2->username.'.'.$firm->username.'.Admin';
		}
		return $authname;
	}



	public function getclientauthname($firmid)
	{

		$client=Client::model()->findbypk($firmid);
		$name='';

		if($client->parentid==0)
		{
			
			$branch=Firm::model()->findbypk($client->firmid);
			$firm=Firm::model()->findbypk($branch->parentid);

			$name=$firm->package.'.'.$firm->username.'.'.$branch->username.'.'.$client->username;
		}
		else
		{
			$clientx=Client::model()->findbypk($client->parentid);

			$branch=Firm::model()->findbypk($clientx->firmid);
			$firm=Firm::model()->findbypk($branch->parentid);

			$name=$firm->package.'.'.$firm->username.'.'.$branch->username.'.'.$clientx->username.'.'.$client->username;
		}


		$authname=$name.'.Admin';
		return $authname;
	}



	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
