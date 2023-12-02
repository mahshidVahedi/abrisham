<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%organization_buy_requests}}".
 *
 * @property int $id
 * @property string $date
 * @property string $manager_name
 * @property string $manager_lastname
 * @property int $manager_nationality_code
 * @property int $manager_mobile
 * @property string $manager_gender
 * @property string|null $manager_email
 * @property string $organization_name
 * @property string|null $organixation_address
 * @property int|null $organization_phone
 * @property string $unique_key
 * @property int|null $created_at
 * @property string $sale_date
 * @property int $seller_id
 *
 * @property Users $seller
 */
class OrganizationBuyRequests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_buy_requests}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'manager_name', 'manager_lastname', 'manager_nationality_code', 'manager_mobile', 'manager_gender', 'organization_name', 'unique_key', 'sale_date', 'seller_id'], 'required'],
            [['date', 'sale_date'], 'safe'],
            [['manager_nationality_code', 'manager_mobile', 'organization_phone', 'created_at', 'seller_id'], 'integer'],
            [['manager_gender'], 'string'],
            [['manager_name', 'manager_lastname', 'manager_email', 'organization_name', 'organixation_address'], 'string', 'max' => 255],
            [['unique_key'], 'string', 'max' => 6],
            [['organization_name'], 'unique'],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['seller_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'date' => 'تاریخ',
            'manager_name' => 'نام مدیر',
            'manager_lastname' => 'نام خانوادگی مدیر',
            'manager_nationality_code' => 'کد ملی مدیر',
            'manager_mobile' => 'تلفن همراه مدیر',
            'manager_gender' => 'جنسیت مدیر',
            'manager_email' => 'ایمیل مدیر',
            'organization_name' => 'نام سازمان',
            'organixation_address' => 'آدرس سازمان',
            'organization_phone' => 'تلفن سازمان',
            'unique_key' => 'Unique Key',
            'created_at' => 'Created At',
            'sale_date' => 'تاریخ فروش',
            'seller_id' => 'فروشنده',
        ];
    }

    /**
     * Gets query for [[Seller]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Users::class, ['id' => 'seller_id']);
    }
}
