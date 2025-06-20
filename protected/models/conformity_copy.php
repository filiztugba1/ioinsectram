<?php

/**
 * This is the model class for table "conformity".
 *
 * The followings are the available columns in table 'conformity':
 * @property integer $id
 * @property integer $userid
 * @property integer $firmid
 * @property integer $branchid
 * @property integer $clientid
 * @property integer $departmentid
 * @property integer $subdepartmentid
 * @property integer $type
 * @property string $definition
 * @property string $suggestion
 * @property integer $statusid
 * @property integer $priority
 * @property string $date
 * @property integer $isefficiencyevaluation
 * @property string $filesf
 * @property integer $endofdayemail
 */
class Conformity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conformity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, firmid, branchid', 'required'),
			array('userid, firmid, branchid, clientid, departmentid, subdepartmentid, type, statusid, priority, isefficiencyevaluation, endofdayemail', 'numerical', 'integerOnly'=>true),
			array('date', 'length', 'max'=>15),
			array('definition, suggestion, filesf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, firmid, branchid, clientid, departmentid, subdepartmentid, type, definition, suggestion, statusid, priority, date, isefficiencyevaluation, filesf, endofdayemail', 'safe', 'on'=>'search'),
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
			'id' => 'id',
			'userid' => 'Userid',
			'firmid' => 'Firmid',
			'branchid' => 'Branchid',
			'clientid' => 'Firma',
			'departmentid' => 'Bölüm',
			'subdepartmentid' => 'Alt Bölüm',
			'type' => 'Tipi',
			'definition' => 'Açıklama',
			'suggestion' => 'Öneri',
			'statusid' => 'Durum',
			'priority' => 'Derecesi',
			'date' => 'Eklenme Zamanı',
			'isefficiencyevaluation' => 'Isefficiencyevaluation',
			'filesf' => 'Dosya',
			'endofdayemail' => 'Endofdayemail',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('firmid',$this->firmid);
		$criteria->compare('branchid',$this->branchid);
		$criteria->compare('clientid',$this->clientid);
		$criteria->compare('departmentid',$this->departmentid);
		$criteria->compare('subdepartmentid',$this->subdepartmentid);
		$criteria->compare('type',$this->type);
		$criteria->compare('definition',$this->definition,true);
		$criteria->compare('suggestion',$this->suggestion,true);
		$criteria->compare('statusid',$this->statusid);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('isefficiencyevaluation',$this->isefficiencyevaluation);
		$criteria->compare('filesf',$this->filesf,true);
		$criteria->compare('endofdayemail',$this->endofdayemail);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername)
	{

			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;


			try {
				$mail->IsSMTP();


				$mail->Host = 'insectram.io';
				$mail->SMTPAuth = false;
				$mail->Username = 'oneri.uygunsuzluk@insectram.io';
				$mail->Port='587';
				//$mail->SMTPSecure = "ssl";
				/*$mail->SMTPOptions = array(
					'ssl' => [
						'verify_peer' => true,
						'verify_depth' => 3,
						'allow_self_signed' => true,
						'peer_name' => 'insectram.io',
						// 'cafile' => '/etc/ssl/ca_cert.pem',
					],
				);
				*/
				$mail->SetLanguage("tr", "phpmailer/language");
				$mail->CharSet  ="utf-8";
				$mail->Encoding="base64";
				$mail->Password = 'N4tht22*';
				$mail->IsHTML(true);


				$mail->SetFrom($senderemail,$sendername);
				$mail->Subject =$subject;
				$mail->AltBody =$altbody;
				$mail->MsgHTML($msg);

				$mail->AddAddress($buyeremail,$buyername);
				$mail->Send();
  echo "Message Sent OK<br>";
} catch (phpmailerException $e) {
	echo 'hata - '.$buyeremail;
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
		echo 'hata - '.$buyeremail;
}

	}


	public function where()
	{
		$ax= User::model()->userobjecty('');
		$client=Client::model()->findAll(array(
										   #'select'=>'',
										   #'limit'=>'5',
										   'order'=>'name ASC',
										   'condition'=>'isdelete=0',
									   ));

			if($ax->firmid>0)
			{
				if($ax->branchid>0)
				{
					if($ax->clientid>0)
					{
						if($ax->clientbranchid>0)
						{
							$where=" and clientid=".$ax->clientbranchid;


						}
						else
						{
							$where=" and clientid in (".implode(',',Client::model()->getbranchids($ax->clientid)).")";

							/*	$workorder=Client::model()->findAll(array('condition'=>'parentid='.$ax->clientid));
								$i=0;
								foreach($workorder as $workorderx)
								{
									if($i==0)
									{
										$where='clientid='.$workorderx->id;
									}
									else
									{
									$where=$where.' or clientid='.$workorderx->id;
									}

								}*/


						}
					}
					else
					{
						$where=" and branchid=".$ax->branchid;
					}
				}
				else
				{
					$where=" and firmid in (".implode(',',Firm::model()->getbranchids($ax->firmid)).")";
				}
			}
			else
			{
				$where="";
			}


	return $where;
	}


	public function assign($firm=0,$firmbranch=0,$client=0,$clientbrach=0,$gonderen=0,$yetkitype=2)  //gonderen---0 ise firm 1 ise firm branch 2 ise client 3 ise
	{																						//clientbranch
		$firm=Firm::model()->find(array('condition'=>'id='.$firm));							//yetkitype---0 ise admin 1 ise staff 2 ise her ikiside
		$branch=Firm::model()->find(array('condition'=>'id='.$firmbranch));
		$client=Client::model()->find(array('condition'=>'id='.$client));
		$clientbranch=Client::model()->find(array('condition'=>'id='.$clientbrach));

		if($gonderen==0)
		{
			$assigment=$firm->package.'.'.$firm->username;
		}
		else if($gonderen==1)
		{
			$assigment=$firm->package.'.'.$firm->username.'.'.$branch->username;
		}
		else if($gonderen==2)
		{
			$assigment=$firm->package.'.'.$firm->username.'.'.$branch->username.'.'.$client->username;
		}
		else
		{
			$assigment=$firm->package.'.'.$firm->username.'.'.$branch->username.'.'.$client->username.'.'.$clientbranch->username;
		}


Yii::app()->getModule('authsystem');

		if($yetkitype==0)
		{
			$assigment=$assigment.'.Admin';
		}
		else if($yetkitype==1)
		{
			$assigment=$assigment.'.Staff';
		}

		else
		{

			$return=AuthAssignment::model()->findAll(array('condition'=>'itemname like "%'.$assigment.'.Admin%" or itemname like "%'.$assigment.'.Staff%" group by userid'));
			return $return;

		}



		$return=AuthAssignment::model()->findAll(array('condition'=>'itemname like "%'.$assigment.'%" group by userid'));
		return $return;

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Conformity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
