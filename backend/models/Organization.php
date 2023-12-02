<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "{{%organization}}".
*
* @property int $id
* @property string $title
* @property string $small_title
* @property int $organization_id
* @property int $organization_type_id
*
* @property ApproveType[] $approveTypes
* @property OrganizationToBase[] $organizationToBases
* @property RecognizeOrganization[] $recognizeOrganizations
* @property StudentRegistrationConfig[] $studentRegistrationConfigs
*/
class Organization extends \yii\db\ActiveRecord
{
	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return '{{%organization}}';
	}

	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['title', 'small_title'], 'required'],
			[['org_tel1', 'org_tel2', 'org_tel2_sub', 'org_tel1_sub', 'aparat_url', 'twiter_url','bale_url','telegram_url','info_email','instagaram_url','sorosh_url','register_mobile','page_register_title','page_register_description','page_register_keyword','password_tel','password_sub_tel','register_description','national_code','start_date_for_pay','pay_mobile','map_url','address','national_code','enamad_url','samandehi_url','page_title','page_description','site_access_type','eita_url','rubika_url'], 'safe'],
			[['organization_id', 'organization_type_id' ,'is_on_registration' , 'aboutus_content_id'], 'integer'],
			[['title'], 'string', 'max' => 100],
			[['small_title'], 'string', 'max' => 255],
		];
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'عنوان'),
            'small_title' => Yii::t('app', 'عنوان خلاصه'),
            'organization_id' => Yii::t('app', 'Organization ID'),
            'organization_type_id' => Yii::t('app', 'Organization Type ID'),
            'page_title' => Yii::t('app', 'عنوان صفحه سایت'),
            'page_description' => Yii::t('app', 'توضیحات صفحه سایت'),
            'page_forum_title' => Yii::t('app', 'Page Forum Title'),
            'page_forum_description' => Yii::t('app', 'Page Forum Description'),
            'image' => Yii::t('app', 'Image'),
            'school_type' => Yii::t('app', '0 is gril 1 is boy 2 is togather'),
            'aparat_url' => Yii::t('app', 'آدرس آپارات'),
            'twiter_url' => Yii::t('app', 'آدرس توییتر'),
            'bale_url' => Yii::t('app', 'آدرس بله'),
            'telegram_url' => Yii::t('app', 'آدرس تلگرام'),
            'info_email' => Yii::t('app', 'ایمیل'),
            'instagaram_url' => Yii::t('app', 'آدرس اینستاگرام'),
            'sorosh_url' => Yii::t('app', 'آدرس سروش'),
            'eita_url' => Yii::t('app', 'آدرس ایتا'),
            'rubika_url' => Yii::t('app', 'آدرس روبیکا'),
            'register_mobile' => Yii::t('app', 'Register Mobile'),
            'page_register_title' => Yii::t('app', 'Page Register Title'),
            'page_register_description' => Yii::t('app', 'Page Register Description'),
            'page_register_keyword' => Yii::t('app', 'Page Register Keyword'),
            'password_tel' => Yii::t('app', 'Password Tel'),
            'password_sub_tel' => Yii::t('app', 'Password Sub Tel'),
            'register_description' => Yii::t('app', 'Register Description'),
            'org_tel1' => Yii::t('app', 'شماره تلفن 1'),
            'org_tel1_sub' => Yii::t('app', 'شماره داخلی 1'),
            'org_tel2' => Yii::t('app', 'شماره تلفن 2'),
            'org_tel2_sub' => Yii::t('app', 'شماره داخلی 2'),
            'national_code' => Yii::t('app', 'National Code'),
            'address' => Yii::t('app', 'آدرس'),
            'map_url' => Yii::t('app', 'آدرس نقشه'),
            'map_short_url' => Yii::t('app', 'Map Short Url'),
            'school_number' => Yii::t('app', 'School Number'),
            'school_zone' => Yii::t('app', 'School Zone'),
            'is_on_registration' => Yii::t('app', 'Is On Registration'),
            'postal_code' => Yii::t('app', 'کد پستی'),
            'service_registration_status' => Yii::t('app', 'Service Registration Status'),
            'lang' => Yii::t('app', 'زبان'),
            'school_type_id' => Yii::t('app', 'School Type ID'),
            'aboutus_content_id' => Yii::t('app', 'شماره محتوای درباره ما'),
            'enamad_url' => Yii::t('app', 'آدرس مجوز enamad'),
            'samandehi_url' => Yii::t('app', 'آدرس مجوز وزارت ارشاد'),
            'site_access_type' => Yii::t('app', 'سطح دسترسی کاربران به سایت'),
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getApproveTypes()
	{
		return $this->hasMany(ApproveType::className(), ['organization_id' => 'id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getOrganizationToBases()
	{
		return $this->hasMany(OrganizationToBase::className(), ['organization_id' => 'id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getRecognizeOrganizations()
	{
		return $this->hasMany(RecognizeOrganization::className(), ['organization_id' => 'id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
    public function getStudentRegistrationConfigs()
    {
        return $this->hasMany(StudentRegistrationConfig::className(), ['organization_id' => 'id']);
    }

	public function getOrganization()
	{
		return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
	}

	public static function getAllOrganization($organizationId = 0){
		if($organizationId == 0)
			$organizationId = Yii::$app->fcore->getOrganization();
		$organizations		= self::find()->where("organization_id = $organizationId OR id = $organizationId")->all();
		$organizationArray	= array();
		foreach ($organizations as $organization)
			$organizationArray[] = $organization->id;
		return $organizationArray;
	}
    public static function getAccessOrganization($accessTitle , $isSchool = 1){
        $academicYearInDate 	= Yii::$app->fcore->getAcademicYear();
        $org = Yii::$app->fcore->getOrganization();
        $organizationData			= $isSchool ? Yii::$app->fcore->getAllSchools($org) : Yii::$app->fcore->getAllOrganization($org);
        if(Users::userAceess($accessTitle  , Yii::$app->user->id , $org , $academicYearInDate)['error']) {
            $userAccess = Users::userAceess($accessTitle  , Yii::$app->user->id , array_keys($organizationData) , $academicYearInDate);
            $userOrgs = [];
            if(!empty($userAccess['jobsData']))
            foreach ($userAccess['jobsData'] as $item) {
                $userOrgs[$item['organization_id']] = $item['organization_id'];
            }
            foreach ($organizationData as $organizationId1 => $title) {
                if (!$userOrgs[$organizationId1]) {
                    unset($organizationData[$organizationId1]);
                }
            }
        }
        return $organizationData;
    }


    public static function getAccessBase($accessTitle , $organizationId , $academicYearInDate = 0 , $academicYear = 0 , $key = 'base.id'){

        if($academicYearInDate == 0)
            $academicYearInDate 	= Yii::$app->fcore->getAcademicYear();
        if($academicYear == 0)
            $academicYear 	= Yii::$app->fcore->getAcademicYear();
        if(!$organizationId)
            return [];
        if(!is_array($organizationId))
            $organizationId 	= array($organizationId);
        $findBases = OrganizationToBase::find()->joinWith('base as base')
            ->andOnCondition('organization_id IN ('.implode(',',$organizationId).') AND academic_year_id = :academicYearId',
            array(':academicYearId'=>(int) $academicYear))->orderBy('base.id')->all();
        $baseData =  ArrayHelper::map($findBases,$key,'base.title');
        $rootBaseData = ArrayHelper::map ($findBases,$key,'base.id');

        foreach($baseData as $baseId => $title){

            if(Users::userAceess($accessTitle  , Yii::$app->user->id , $organizationId , $academicYearInDate , $rootBaseData[$baseId])['error']){
                unset($baseData[$baseId]);
            }
        }
        return $baseData;
    }


    public static function getAccessClasses($accessTitle , $organizationToBaseId,$fieldId , $academicYearInDate = 0){
        $organizationToBase = \backend\models\OrganizationToBase::findOne($organizationToBaseId);

        if($academicYearInDate == 0)
            $academicYearInDate 	= Yii::$app->fcore->getAcademicYear();


        $findBases = \backend\models\Classes::find()
            ->andOnCondition('organization_to_base_id = :organizationToBaseId AND
                                field_id = :fieldId and is_deleted = 0',
            array(  ':organizationToBaseId' => (int) $organizationToBaseId,
                    ':fieldId' => (int) $fieldId))
            ->orderBy('id')->all();

        $baseData       =  ArrayHelper::map($findBases,'id','title');

        $rootBaseData   = ArrayHelper::map ($findBases,'id','id');

        foreach($baseData as $classId => $title){

            if(Users::userAceess($accessTitle  , Yii::$app->user->id , $organizationToBase->organization_id ,
                                    $academicYearInDate , $organizationToBase->base_id , $fieldId , $classId)['error']){
                unset($baseData[$classId]);
            }
        }

        return $baseData;
    }


}
