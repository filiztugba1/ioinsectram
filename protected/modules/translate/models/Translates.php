<?php

/**
 * This is the model class for table "translates".
 *
 * The followings are the available columns in table 'translates':
 * @property integer $id
 * @property string $title
 * @property string $value
 * @property string $code
 */
class Translates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'translates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('title, value, code', 'required'),
			array('code', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
		//	array('id, title, value, code', 'safe', 'on'=>'search'),
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
/*		return array(
			'id' => 'ID',
			'title' => 'sayfa içlerinde kullanacağımız kısa açıklamalar',
			'value' => 'çeviri içeriği',
			'code' => 'dil kodu',
		);
		*/
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Translates the static model class
	 */

	 public function traslateList()
	 {
		 $where='en.code="en"';
		 $select='en.title as title,en.id as en_id,en.value as en_value,en.code as en_code';
		 $languageArray=["name"=>'en',"title"=>"English"];
		 $translatelanguages=Yii::app()->db->createCommand()
     ->from('translatelanguages')
		 ->where('flag!="en" and show_on_list=1')
     ->queryAll();
		 foreach ($translatelanguages as $translatelanguage) {
			 	$where=$where.' and '.$translatelanguage['name'].'x.code="'.$translatelanguage['name'].'"';
				$select=$select.','.$translatelanguage['name'].'x.id as '.$translatelanguage['name'].'_id ,'
				.$translatelanguage['name'].'x.value as '.$translatelanguage['name'].'_value ,'
				.$translatelanguage['name'].'x.code as '.$translatelanguage['name'].'_code';
				array_push($languageArray,["name"=>$translatelanguage['name'],"title"=>t($translatelanguage['title'])]);
			}
			$traslate=Yii::app()->db->createCommand()
    ->select($select)
    ->from('translates en');
		foreach ($translatelanguages as $translatelanguage) {
				$traslate=$traslate->leftJoin('translates '.$translatelanguage['name'].'x', $translatelanguage['name'].'x.title=en.title');
		}
	  $traslate=$traslate->where($where);
		$traslate=$traslate->group("en.title");
	//	->join('traslates p', 'u.id=p.user_id')
    $traslate=$traslate->queryAll();
		$data=["languages"=>$languageArray,"traslate"=>$traslate];

		return $data;
	 }

	 public function traslateExcelCreate($datam)
	 {
	    
		 $languages=Translatelanguages::model()->traslateLanguageList();
		 $failData=[];
		 for($i=0;$i<count($datam);$i++)
		 {
			 foreach ($languages as $language) {
				 if(isset($datam[$i][$language["name"]]) && $datam[$i][$language["name"]]!='' && $datam[$i][$language["name"]]!='-')
				 {
					 $title=$datam[$i]['title'];
				   $language=$language["name"];
					 $value=$datam[$i][$language];
					 if($title!='')
					 {
					 $traslate=Translates::model()->find(array("condition"=>"title='".$title."' and code='".$language."'"));
				
						if(!isset($traslate))
						{
							$traslate=new Translates;
							$traslate->title=$title;
							$traslate->code=$language;
						}
						$traslate->value=$value;
						if(!$traslate->save())
						{
							array_push($failData,['title'=>$title,'code'=>$language,'value'=>$value]);
						}
					 }
				 }
			 }
		 }
		return $failData;
		 //echo "title=".$title." language=".$language." value=".$value.'<br>';
	 }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
