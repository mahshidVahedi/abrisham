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
 * @property int $seller_user_id *
 * @property string $status
 * @property string $process_status
 * @property Users $seller
 */
class OrganizationBuyRequests extends \yii\db\ActiveRecord

{
    const SCENARIO_CREATE = 'scenarioCreate';
    const SCENARIO_UPDATE = 'scenarioUpdate';

    public function getCustomScenarios()
    {
        return [
            self::SCENARIO_CREATE => ['manager_mobile', 'seller_user_id', 'sale_date', 'unique_key', 'organization_name'],
            self::SCENARIO_UPDATE => ['date', 'manager_name', 'manager_lastname', 'manager_nationality_code', 'manager_mobile', 'manager_gender', 'organization_name'],
        ];
    }
    // get scenarios
    public function scenarios()
    {
        $scenarios = $this->getCustomScenarios();
        return $scenarios;
    }

    // modify items required for rules
    public function ModifyRequired()
    {
        $allScenarios = $this->getCustomScenarios();
        // published not required
        $allScenarios[self::SCENARIO_CREATE] = array_diff($allScenarios[self::SCENARIO_CREATE], ['published']);
        return $allScenarios;
    }
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
        // get scenarios
        $allScenarios = $this->ModifyRequired();
        return [
            [$allScenarios[self::SCENARIO_CREATE], 'required', 'on' => self::SCENARIO_CREATE],
            [$allScenarios[self::SCENARIO_UPDATE], 'required', 'on' => self::SCENARIO_UPDATE],
            [['date', 'sale_date'], 'safe'],
            [['manager_nationality_code', 'manager_mobile', 'organization_phone', 'created_at', 'seller_user_id'], 'integer'],
            [['manager_gender'], 'string'],
            [['manager_name', 'manager_lastname', 'manager_email', 'organization_name', 'organixation_address'], 'string', 'max' => 255],
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
            'unique_key' => 'کلید یکتا',
            'created_at' => 'Created At',
            'sale_date' => 'تاریخ فروش',
            'seller_user_id' => 'فروشنده',
            'status' => 'وضعیت',
            'process_status' => 'فرآیند'
        ];
    }

    /**
     * Gets query for [[Seller]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Users::class, ['id' => 'seller_user_id']);
    }
}
