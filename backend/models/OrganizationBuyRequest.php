<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%organization_buy_request}}".
 *
 * @property int $id
 * @property string $date
 * @property string $manager_name
 * @property string $manager_lname
 * @property int $manager_ncode
 * @property int $manager_phone
 * @property string $manager_gender
 * @property string|null $manager_email
 * @property string $org_name
 * @property string $org_address
 * @property int $org_phone
 */
class OrganizationBuyRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_buy_request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'manager_name', 'manager_lname', 'manager_ncode', 'manager_phone', 'manager_gender', 'org_name', 'org_address', 'org_phone'], 'required'],
            [['date'], 'safe'],
            [['manager_ncode', 'manager_phone', 'org_phone'], 'integer'],
            [['manager_gender'], 'string'],
            [['manager_name', 'manager_lname', 'manager_email', 'org_name', 'org_address'], 'string', 'max' => 255],
            [['org_name'], 'unique'],
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
            'manager_lname' => 'نام خانوادگی مدیر',
            'manager_ncode' => 'کد ملی مدیر',
            'manager_phone' => 'تلفن همراه مدیر',
            'manager_gender' => 'جنسیت مدیر',
            'manager_email' => 'ایمیل مدیر',
            'org_name' => 'نام سازمان',
            'org_address' => 'آدرس سازمان',
            'org_phone' => 'تلفن سازمان',
        ];
    }
}
