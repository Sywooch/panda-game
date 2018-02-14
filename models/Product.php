<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $cost
 * @property int $quantity
 * @property int $quantity_max
 * @property int $is_team
 * @property string $image
 * @property int $created_user
 * @property string $dcreated
 *
 * @property User $createdUser
 * @property ProductEmployee[] $productEmployees
 * @property Employee[] $employees
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cost', 'quantity', 'quantity_max', 'created_user'], 'required'],
            [['description'], 'string'],
            [['cost', 'quantity', 'quantity_max', 'is_team', 'created_user'], 'integer'],
            [['dcreated'], 'safe'],
            [['name', 'image'], 'string', 'max' => 255],
            [['created_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'cost' => Yii::t('app', 'Cost'),
            'quantity' => Yii::t('app', 'Quantity'),
            'quantity_max' => Yii::t('app', 'Quantity Max'),
            'is_team' => Yii::t('app', 'Is Team'),
            'image' => Yii::t('app', 'Image'),
            'created_user' => Yii::t('app', 'Created User'),
            'dcreated' => Yii::t('app', 'Dcreated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductEmployees()
    {
        return $this->hasMany(ProductEmployee::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id'])->viaTable('product_employee', ['product_id' => 'id']);
    }
}
