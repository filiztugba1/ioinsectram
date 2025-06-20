<?php

/**
 * This is the model class for table "audit_categories".
 */
class AuditCategory extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return AuditCategory the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'audit_categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('parent_id', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            array('description', 'safe'),
            array('id, name, description, parent_id, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'AuditCategory', 'parent_id'),
            'children' => array(self::HAS_MANY, 'AuditCategory', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'parent_id' => 'Parent Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Creates the audit_categories table if it doesn't exist
     */
    public static function createTable()
    {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("
            CREATE TABLE IF NOT EXISTS `audit_categories` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `description` text,
                `parent_id` int(11) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `parent_id` (`parent_id`),
                CONSTRAINT `audit_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `audit_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $command->execute();
    }

    /**
     * Get all categories as a hierarchical array
     * @return array
     */
    public static function getCategoryTree($parentId = null)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'parent_id ' . ($parentId === null ? 'IS NULL' : '=' . $parentId);
        $criteria->order = 'name ASC';
        
        $categories = self::model()->findAll($criteria);
        $result = array();
        
        foreach ($categories as $category) {
            $node = array(
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'children' => self::getCategoryTree($category->id)
            );
            $result[] = $node;
        }
        
        return $result;
    }

    /**
     * Get categories as a flat array for dropdowns
     * @return array
     */
    public static function getCategoriesForDropdown()
    {
        $categories = self::model()->findAll(array('order' => 'name ASC'));
        $result = array('' => 'No Parent (Root Category)');
        
        foreach ($categories as $category) {
            $result[$category->id] = $category->name;
        }
        
        return $result;
    }

    /**
     * Before save operations
     */
    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }
        $this->updated_at = new CDbExpression('NOW()');
        
        return parent::beforeSave();
    }
}
