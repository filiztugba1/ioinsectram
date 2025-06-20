<?php

/**
 * This is the model class for table "sector".
 *
 * The followings are the available columns in table 'sector':
 * @property integer $id
 * @property integer $parentid
 * @property string $name
 */
class Sector extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sector';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentid, name', 'required'),
			array('parentid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parentid, name', 'safe', 'on'=>'search'),
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
			'parentid' => 'Parent ID',
			'name' => 'Sektör Adı',
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
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
		public function changeactive($id,$isactive)
	{
		$sector=Sector::model()->find(array('condition'=>'id=:id','params'=>array('id'=>$id)));
		if($sector)
		{
			$sector->active=$isactive;
			if(!$sector->update())
			{
				print_r($sector->getErrors());
			}
			
			return true;
		}
		else
		{
			echo "bulamadım";exit;
		}
	}
	
	
	
	public function forminput($name,array $array){
		
				echo'<fieldset class="form-group">
                           <label for="User_Username">'.$name.'</label>  
						   <input size="'.$array['size'].'" maxlength="'.$array['maxlength'].'" minlength="'.$array['maxlength'].'" class="'.$array['class'].'"  type="'.$array['type'].'" value="'.$array['value'].'" placeholder="'.$array['placeholder'].'" id="'.$array['id'].'">               
						   </fieldset>
						';
			
		}
	

		public function formselect($name,array $array,array $option){
				$i=1;
				echo'	<fieldset class="form-group">
								  <label for="basicSelect">'.$name.'</label>
								  <select  class="'.$array['class'].'"  type="'.$array['type'].'" value="'.$array['value'].'" placeholder="'.$array['placeholder'].'" id="'.$array['id'].'">
								  <option>Select</option>';
								  
								
				if(count($option)!=0){
					
					foreach($option as $options)
					{?>
						 <option value="'<?php echo $i++;?>'"><?php echo $options;?></option>
					<?php 
					}
				}				
								

				echo'</select>
                        </fieldset>
						';
			
		}
		
	public function form($name,$inputname,$type,$value,$placeholder)
	{
		
		if($type=='text')
		{
		echo'<fieldset class="form-group">
                           <label for="User_Username">'.$name.'</label>  
						   <input size="60" maxlength="128" class="form-control" placeholder="'.$placeholder.'" name="'.$inputname.'" id="'.$inputname.'" type="text" value="'.$value.'">               
						   </fieldset>
						';
		}
		
		if($type=='number')
		{
		echo'<fieldset class="form-group">
                           <label for="User_Username">'.$name.'</label>  
						   <input size="60" maxlength="128" class="form-control" placeholder="'.$placeholder.'" name="'.$inputname.'" id="'.$inputname.'" type="number" value="'.$value.'">               
						   </fieldset>
						';
		}
		
		
			if($type=='selectActive')
		{
			echo'<fieldset class="form-group">
                          <label for="basicSelect">'.$name.'</label>
                          <select class="form-control" id="basicSelect" name="'.$inputname.'" required>
                            <option>Select</option>';
							
							if($value=='1'){
								echo '<option value="1" Selected>Aktive</option>
									  <option value="2" >Passive</option>';
							}
							if($value=='2'){
								echo '<option value="1" >Aktive</option>
									  <option value="2" Selected>Passive</option>';
							}
							
							if($value==''){
								echo '<option value="1" >Aktive</option>
									  <option value="2" >Passive</option>';
							}
                          
							
                  echo'</select>
                        </fieldset>';
			}
		
			if($type=='password')
			{
				echo'<fieldset class="form-group">
							   <label for="User_Username">'.$name.'</label>  
							   <input size="60" maxlength="128" class="form-control" placeholder="'.$placeholder.'" name="'.$inputname.'" id="'.$inputname.'" type="password" value="'.$value.'">               
							   </fieldset>
							';
			}
			
			if($type=='email')
			{
				echo'<fieldset class="form-group">
							   <label for="User_Username">'.$name.'</label>  
							   <input size="60" maxlength="128" class="form-control" placeholder="'.$placeholder.'" name="'.$inputname.'" id="'.$inputname.'" type="email" value="'.$value.'">               
							   </fieldset>
							';
			}
			
			if($type=='date'){
				
				echo '  <div class="form-group">
                              <label for="date1">'.$name.'</label>
                              <input type="date" name="'.$inputname.'" class="form-control" id="date1">
                            </div>';
			}
			
			
			if($type=='textarea')
			{
				echo '<div class="form-group">
                              <label for="decisions1">'.$name.'</label>
                              <textarea name="'.$inputname.'" id="decisions1" rows="4" class="form-control"></textarea>
                            </div>';
							
			}
		
		
	
		return 0;
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sector the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
