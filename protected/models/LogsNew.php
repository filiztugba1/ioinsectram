<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property integer $id
 * @property integer $userid
 * @property string $operation
 * @property string $place
 * @property integer $createtime
 */
class LogsNew extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'logs_new';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id', 'safe', 'on'=>'search'),
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
    'user_id' => 'User ID',
    'user_name' => 'User Name',
    'user_ip' => 'User IP',
    'url' => 'URL',
    'post_data' => 'Post Data',
    'get_data' => 'Get Data',
    'old_db_data' => 'Old DB Data',
    'new_db_data' => 'New DB Data',
    'diff_db_data' => 'diff_db_data',
    'created_time' => 'Created Time',
    'created_date' => 'Created Date',
    'user_device' => 'User Device',
    'save_action' => 'Save Action',
    'operation' => 'Operation',
    'notes' => 'notes',
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
$criteria->compare('user_id', $this->user_id); // int
$criteria->compare('user_name', $this->user_name, true); // varchar
$criteria->compare('user_ip', $this->user_ip, true); // varchar
$criteria->compare('url', $this->url, true); // varchar
$criteria->compare('post_data', $this->post_data, true); // text
$criteria->compare('get_data', $this->get_data, true); // text
$criteria->compare('old_db_data', $this->old_db_data, true); // text
$criteria->compare('new_db_data', $this->new_db_data, true); // text
$criteria->compare('diff_db_data', $this->diff_db_data, true); // text
$criteria->compare('created_time', $this->created_time); // int
$criteria->compare('created_date', $this->created_date, true); // varchar
$criteria->compare('user_device', $this->user_device, true); // varchar
$criteria->compare('save_action', $this->save_action, true); // varchar
$criteria->compare('operation', $this->operation, true); // varchar
$criteria->compare('notes', $this->notes, true); // varchar

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function getUserDeviceDetails()
{
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    $browser = 'Unknown';
    $version = '';
    $platform = 'Unknown';
    $deviceType = 'Desktop';

    if (preg_match('/linux/i', $agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $agent)) {
        $platform = 'Mac';
    } elseif (preg_match('/windows|win32/i', $agent)) {
        $platform = 'Windows';
    }

    if (preg_match('/MSIE/i', $agent) && !preg_match('/Opera/i', $agent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Firefox/i', $agent)) {
        $browser = 'Firefox';
    } elseif (preg_match('/Chrome/i', $agent)) {
        $browser = 'Chrome';
    } elseif (preg_match('/Safari/i', $agent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Opera/i', $agent)) {
        $browser = 'Opera';
    } elseif (preg_match('/Edge/i', $agent)) {
        $browser = 'Edge';
    }

    preg_match_all('/' . $browser . '[\/ ]+([0-9.|a-zA-Z.]*)/', $agent, $matches);
    if (!empty($matches[1][0])) {
        $version = $matches[1][0];
    }

    if (preg_match('/mobile/i', $agent)) {
        $deviceType = 'Mobile';
    } elseif (preg_match('/tablet|ipad/i', $agent)) {
        $deviceType = 'Tablet';
    }

    return sprintf(
        '%s %s on %s (%s) | UA: %s',
        $browser,
        $version,
        $platform,
        $deviceType,
        $agent
    );
}
  
public function logsaction(
    $model_or_data = null,
    $notes = null,
    $table_name = null,
    $record_id = null
)
{
    $old_db_data = null;

    if (is_object($model_or_data) && method_exists($model_or_data, 'tableName')) {
        $old_db_data = json_encode($model_or_data->attributes,JSON_PRETTY_PRINT);
        $table_name = $table_name ?? $model_or_data->tableName();
        $record_id = $record_id ?? $model_or_data->primaryKey;
    } elseif (is_array($model_or_data)) {
        $old_db_data = json_encode($model_or_data,JSON_PRETTY_PRINT);
    }

    $user_id = (Yii::app()->user && !Yii::app()->user->isGuest) ? Yii::app()->user->id : null;
    $user_name = (Yii::app()->user && !Yii::app()->user->isGuest) ? Yii::app()->user->name : null;

    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $user_ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $user_ip = trim($ips[0]);
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $user_ip = null;
    }

    $url = $_SERVER['REQUEST_URI'] ?? null;
    $post_data = json_encode($_POST,JSON_PRETTY_PRINT);
    $get_data = json_encode($_GET,JSON_PRETTY_PRINT);

    $new_db_data = null;
    if ($table_name && $record_id) {
        $db = Yii::app()->db;
        $command = $db->createCommand()
            ->select('*')
            ->from($table_name)
            ->where('id = :id', [':id' => $record_id])
            ->queryRow();
        if ($command) {
            $new_db_data = json_encode($command,JSON_PRETTY_PRINT);
        }
    }
  
 $old = json_decode($old_db_data, true);
$new = json_decode($new_db_data, true);

$diff = [];

foreach ($old as $key => $oldVal) {
    if (array_key_exists($key, $new)) {
        $newVal = $new[$key];
        if ((string)$oldVal !== (string)$newVal) {
            $diff[$key] = [
                'old' => $oldVal,
                'new' => $newVal
            ];
        }
    }
}

$diff_json = json_encode($diff, JSON_PRETTY_PRINT);
  
$model=new LogsNew;
    $user_device = $model->getUserDeviceDetails();

    $model->user_id = $user_id;
    $model->user_name = $user_name;
    $model->user_ip = $user_ip;
    $model->url = $url;
    $model->post_data = $post_data;
    $model->get_data = $get_data;
    $model->old_db_data = $old_db_data;
    $model->new_db_data = $new_db_data;
    $model->diff_db_data = $diff_json;
    $model->created_time = time();
    $model->created_date = date("Y-m-d H:i:s T");
    $model->user_device = $user_device;
    $model->save_action = Yii::app()->controller->action->id;
    $model->operation = Yii::app()->controller->id;
    $model->notes = $notes;

    $model->save(false);
}
  
  
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Logs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
