<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%profiles}}".
 *
 * @property int $user_id
 * @property string $name
 * @property string $lname
 * @property int $period
 * @property string $birthday
 * @property int $is_left_hand
 * @property int $register_job_id
 * @property string $desc_job_resgister
 * @property int $education_id
 * @property string $desc_education
 * @property string $national_code
 * @property string $past_school_name
 * @property string $past_school_address
 * @property string $past_school_tel
 * @property int $user_id_old
 * @property string $followcode_old
 * @property string $image
 * @property int $is_female
 * @property int $code_personality
 * @property string $mobile_one
 * @property string $father_name
 * @property int $birth_place_id
 * @property int $issuance_place_id
 * @property string $birth_certificate_number
 * @property int $certificate_serial
 * @property string $certificate_seri
 * @property int $child_number
 * @property int $is_maried
 * @property double $service_years_other_related_managerial
 * @property double $service_years_other_unrelated
 * @property double $service_years_before_system
 * @property double $month_war_presence
 * @property double $service_years_other_related_unmanagerial
 * @property double $all_service_years_other
 * @property double $period_score
 * @property string $alais_name
 * @property int $person_type_id
 * @property int $country_id
 * @property string $death_date
 *
 * @property Users $user
 */
class Profiles extends \yii\db\ActiveRecord
{
    const SCENARIO_ADD_BY_ADMIN = 'admin';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profiles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ 
            [['name', 'lname'], 'required', 'on' => self::SCENARIO_ADD_BY_ADMIN],
            [['period', 'is_left_hand', 'register_job_id', 'education_id', 'user_id_old', 'is_female', 'code_personality', 'birth_place_id', 'issuance_place_id', 'certificate_serial', 'child_number', 'is_maried', 'person_type_id', 'country_id'], 'integer'],
            [['birthday', 'death_date', 'certificate_seri_word' ,'life_type','life_reason','biography','selected_base_to_child_registration','card_number','sheba_number','familiar_desc','familiar_desc','children_count','numberـofـchildren'], 'safe'],
            [['desc_job_resgister', 'past_school_address'], 'string'],
            [['service_years_other_related_managerial', 'service_years_other_unrelated', 'service_years_before_system', 'month_war_presence', 'service_years_other_related_unmanagerial', 'all_service_years_other', 'period_score'], 'number'],
            [['name', 'lname'], 'string', 'max' => 50],
            [['card_number'], 'string', 'min' => 16, 'max' => 16],
            [['sheba_number'], 'string', 'min' => 24, 'max' => 24],

            [['desc_education', 'past_school_name', 'past_school_tel', 'followcode_old', 'image', 'mobile_one', 'father_name', 'certificate_seri', 'alais_name'], 'string', 'max' => 255],
            [['national_code', 'birth_certificate_number'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'شناسه'),
            'name' => Yii::t('app', 'نام'),
            'lname' => Yii::t('app', 'نام‌خانوادگی'),
            'period' => Yii::t('app', 'دوره'),
            'birthday' => Yii::t('app', 'تاریخ تولد'),
            'is_left_hand' => Yii::t('app', 'چپ دست'),
            'register_job_id' => Yii::t('app', 'شغل'),
            'desc_job_resgister' => Yii::t('app', 'سمت و توضیحات شغلی'),
            'education_id' => Yii::t('app', 'تحصیلات'),
            'desc_education' => Yii::t('app', 'رشته/سایر توضیحات'),
            'national_code' => Yii::t('app', 'کد ملی'),
            'past_school_name' => Yii::t('app', 'نام مدرسه‌ی قبلی'),
            'past_school_address' => Yii::t('app', 'آدرس یا منطقه آموزش و پروش مدرسه قبلی'),
            'last_school_avg' => Yii::t('app', 'آخرین معدل در مدرسه قبلی'),
            'past_school_tel' => Yii::t('app', 'تلفن مدرسه‌ی قبلی'),
            'user_id_old' => Yii::t('app', 'User Id Old'),
            'followcode_old' => Yii::t('app', 'Followcode Old'),
            'image' => Yii::t('app', 'تصویر'),
            'is_female' => Yii::t('app', 'جنسیت'),
            'code_personality' => Yii::t('app', 'کد پرسنلی'),
            'mobile_one' => Yii::t('app', 'تلفن همراه'),
            'father_name' => Yii::t('app', 'نام پدر'),
            'birth_place_id' => Yii::t('app', 'محل تولد'),
            'issuance_place_id' => Yii::t('app', 'محل صدور'),
            'birth_certificate_number' => Yii::t('app', 'شماره شناسنامه'),
            'certificate_serial' => Yii::t('app', 'شماره سریال'),
            'certificate_seri' => Yii::t('app', 'عدد سری'),
            'certificate_seri_word' => Yii::t('app', 'حرف سری'),
            'child_number' => Yii::t('app', 'Child Number'),
            'is_maried' => Yii::t('app', 'متاهل'),
            'service_years_other_related_managerial' => Yii::t('app', 'Service Years Other Related Managerial'),
            'service_years_other_unrelated' => Yii::t('app', 'Service Years Other Unrelated'),
            'service_years_before_system' => Yii::t('app', 'Service Years Before System'),
            'month_war_presence' => Yii::t('app', 'Month War Presence'),
            'service_years_other_related_unmanagerial' => Yii::t('app', 'Service Years Other Related Unmanagerial'),
            'all_service_years_other' => Yii::t('app', 'All Service Years Other'),
            'period_score' => Yii::t('app', 'Period Score'),
            'alais_name' => Yii::t('app', 'نام مستعار'),
            'person_type_id' => Yii::t('app', 'Person Type ID'),
            'death_date' => Yii::t('app', 'Death Date'),
            'biography' => Yii::t('app', 'بیوگرافی'),
    
             'sheba_number' => Yii::t('app', 'شماره شبا 24 رقمی'),
              'card_number' => Yii::t('app', 'شماره کارت  فعال 16 رقمی '),
			'familiar_desc' => Yii::t('app', 'معرف'),
			'country_id' => Yii::t('app', 'کشور'),

    
    
           ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public function getCityBirth()
    {
        return $this->hasOne(City::className(), ['id' => 'birth_place_id']);
    }
    public function getCityIssuance()
    {
        return $this->hasOne(City::className(), ['id' => 'issuance_place_id']);
    }
    public function getEducation()
    {
        return $this->hasOne(Education::className(), ['id' => 'education_id']);
    }
    public function getJob()
    {
        return $this->hasOne(RegisterJob::className(), ['id' => 'register_job_id']);
    }
    public function getLifeType()
    {
        return $this->hasOne(LifeType::className(), ['id' => 'life_type']);
    }
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
