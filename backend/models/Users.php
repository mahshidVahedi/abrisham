<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property int $username
 * @property string|null $name
 * @property string|null $lname
 * @property string|null $gender
 * @property string $password
 * @property string|null $email
 * @property string|null $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property int $superuser
 * @property int $status
 * @property int $fault_count
 * @property string $fault_at
 * @property string $unique_key
 *
 * @property OrganizationBuyRequests[] $organizationBuyRequests
 * @property Sellers[] $sellers
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'create_at', 'lastvisit_at', 'fault_at'], 'required'],
            [['username', 'superuser', 'status', 'fault_count'], 'integer'],
            [['gender'], 'string'],
            [['create_at', 'lastvisit_at', 'fault_at'], 'safe'],
            [['name', 'lname'], 'string', 'max' => 255],
            [['password', 'email', 'activkey'], 'string', 'max' => 128],
            [['unique_key'], 'string', 'max' => 6],
            [['username'], 'unique'],
            [['unique_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'نام کاربری',
            'name' => 'نام',
            'lname' => 'نام خانوادگی',
            'gender' => 'جنسیت',
            'password' => 'رمز عبور',
            'email' => 'ایمیل',
            'activkey' => 'Activkey',
            'create_at' => 'Create At',
            'lastvisit_at' => 'Lastvisit At',
            'superuser' => 'Superuser',
            'status' => 'Status',
            'fault_count' => 'Fault Count',
            'fault_at' => 'Fault At',
            'unique_key' => 'Unique Key',
        ];
    }

    /**
     * Gets query for [[OrganizationBuyRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBuyRequests()
    {
        return $this->hasMany(OrganizationBuyRequests::class, ['seller_user_id' => 'id']);
    }

    /**
     * Gets query for [[Sellers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellers()
    {
        return $this->hasMany(Sellers::class, ['user_id' => 'id']);
    }
}
