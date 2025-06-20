<?php

/**
 * This is the model class for table "activeingredients".
 *
 * The followings are the available columns in table 'activeingredients':
 * @property integer $id
 * @property integer $workorderid
 * @property string $trade_name
 * @property string $active_ingredient
 * @property string $amount_applied
 */
class Activeingredients extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'activeingredients';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('workorderid, trade_name, active_ingredient, amount_applied', 'required'),
            array('id, workorderid', 'numerical', 'integerOnly'=>true),
            array('trade_name, active_ingredient, amount_applied', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, workorderid, trade_name, active_ingredient, amount_applied', 'safe', 'on'=>'search'),
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
            'workorderid' => 'Workorderid',
            'trade_name' => 'Trade Name',
            'active_ingredient' => 'Active Ingredient',
            'amount_applied' => 'Amount Applied',
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
        $criteria->compare('workorderid',$this->workorderid);
        $criteria->compare('trade_name',$this->trade_name,true);
        $criteria->compare('active_ingredient',$this->active_ingredient,true);
        $criteria->compare('amount_applied',$this->amount_applied,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activeingredients the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
