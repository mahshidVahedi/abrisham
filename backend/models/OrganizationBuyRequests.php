<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%organization_buy_requests}}".
 *
 * @property int $id
 * @property string|null $create_sale_date
 * @property string|null $manager_name
 * @property string|null $manager_lastname
 * @property string|null $manager_nationality_code
 * @property string $manager_mobile
 * @property string|null $manager_gender
 * @property string|null $manager_email
 * @property string $organization_name
 * @property string|null $organization_address
 * @property string|null $organization_phone
 * @property string $school_type
 * @property string $unique_key
 * @property int|null $created_at
 * @property string $seller_update_date
 * @property string $customer_update_date
 * @property int $seller_user_id
 * @property string $status
 * @property string|null $process_status
 * @property int $pre_school_1
 * @property int $pre_school_2
 * @property int $first
 * @property int $secound
 * @property int $third
 * @property int $pre_primary1_together 
 * @property int $fourth
 * @property int $fifth
 * @property int $sixth
 * @property int $primary1_primary2_together 
 * @property int $seventh
 * @property int $eighth
 * @property int $ninth
 * @property int $tenth_math
 * @property int $tenth_humanities
 * @property int $tenth_empirical
 * @property int $eleventh_math
 * @property int $eleventh_humanities
 * @property int $eleventh_empirical
 * @property int $twelfth_math
 * @property int $twelfth_humanities
 * @property int $twelfth_empirical
 * @property int $high1_high2_together 
 * @property string $final_sale_date
 *
 * @property Users $sellerUser
 */
class OrganizationBuyRequests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

     const SCENARIO_CREATE = 'scenarioCreate';
     const SCENARIO_UPDATE = 'scenarioUpdate';
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
            [['manager_mobile', 'seller_user_id', 'seller_update_date', 'unique_key', 'organization_name'], 'required', 'on' => self::SCENARIO_CREATE],
            [['create_sale_date', 'manager_name', 'manager_lastname', 'manager_nationality_code', 'manager_mobile', 'manager_gender', 'organization_name', 'school_type'], 'safe', 'on' => self::SCENARIO_CREATE],
            [['create_sale_date', 'manager_name', 'manager_lastname', 'manager_nationality_code', 'manager_mobile', 'manager_gender', 'organization_name', 'school_type'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['create_sale_date', 'seller_update_date'], 'safe'],
            [['manager_mobile'], 'match', 'pattern' => '/^(\+98|0)?9\d{9}$/', 'message' => 'شماره موبایل معتبر نیست.', 'on' => self::SCENARIO_CREATE] , 
            [['manager_nationality_code'], 'match', 'pattern'=>'/^\\d{10}$/', 'message'=>'کد ملی معتبر نیست.', 'on'=> self::SCENARIO_UPDATE],
            [['manager_nationality_code'], 'match', 'pattern'=>'/^\\d{10}$/', 'message'=>'کد ملی معتبر نیست.', 'on'=> self::SCENARIO_CREATE],
            [['created_at', 'seller_user_id', 'pre_school_1', 'pre_school_2', 'first', 'secound', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth_math', 'tenth_humanities', 'tenth_empirical', 'eleventh_math', 'eleventh_humanities', 'eleventh_empirical', 'twelfth_math', 'twelfth_humanities', 'twelfth_empirical'], 'integer'],
            [['manager_gender', 'status', 'process_status'], 'string'],
            [['manager_name', 'manager_lastname', 'manager_email', 'organization_name', 'organization_address'], 'string', 'max' => 255],
            [['manager_nationality_code', 'organization_phone'], 'string', 'max' => 11],
            [['unique_key'], 'string', 'max' => 6],
            [['organization_name'], 'unique'],
            [['seller_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['seller_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'create_sale_date' => ' تاریخ فروش (ایجاد فرم)',
            'manager_name' => 'نام مدیر',
            'manager_lastname' => 'نام خانوادگی مدیر',
            'manager_nationality_code' => 'کد ملی مدیر',
            'manager_mobile' => 'تلفن همراه مدیر',
            'manager_gender' => 'جنسیت مدیر',
            'manager_email' => 'ایمیل مدیر',
            'organization_name' => 'نام سازمان',
            'organization_address' => 'آدرس سازمان',
            'organization_phone' => 'تلفن سازمان',
            'school_type' => 'نوع مدرسه',
            'unique_key' => 'کلید یکتا',
            'created_at' => 'Created At',
            'seller_update_date' => 'تاریخ به روزرسانی توسط فروشنده',
            'customer_update_date' => 'تاریخ به روزرسانی توسط مشتری',
            'seller_user_id' => 'فروشنده',
            'status' => 'وضعیت',
            'process_status' => 'فرآیند',
            'pre_school_1' => 'پیش دبستانی یک',
            'pre_school_2' => 'پیش دبستانی دو',
            'first' => 'اول',
            'secound' => 'دوم',
            'third' => 'سوم',
            'fourth' => 'چهارم',
            'fifth' => 'پنجم',
            'sixth' => 'ششم',
            'seventh' => 'هفتم',
            'eighth' => 'هشتم',
            'ninth' => 'نهم',
            'tenth_math' => 'دهم ریاضی',
            'tenth_humanities' => 'دهم انسانی',
            'tenth_empirical' => 'دهم تجربی',
            'eleventh_math' => 'یازدهم ریاضی',
            'eleventh_humanities' => 'یازدهم انسانی',
            'eleventh_empirical' => 'یازدهم تجربی',
            'twelfth_math' => 'دوازدهم ریاضی',
            'twelfth_humanities' => 'دوازدهم انسانی',
            'twelfth_empirical' => 'دوازدهم تجربی',
            'pre_primary1_together'=> 'پیش دبستانی و دبستان دوره اول با هم هستند.',
            'primary1_primary2_together'=>'دبستان دوره اول و دبستان دوره دوم با هم هستند.',
            'high1_high2_together'=>'دبیرستان متوسطه اول و دبیرستان متوسطه دوم با هم هستند.',
            'final_sale_date' => 'تاریخ ثبت نهایی'
        ];
    }

    /**
     * Gets query for [[SellerUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellerUser()
    {
        return $this->hasOne(Users::class, ['id' => 'seller_user_id']);
    }
}
