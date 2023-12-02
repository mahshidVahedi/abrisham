<?php

namespace backend\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use backend\models\Academic;
use backend\models\Relationship;
use backend\models\PersonalConfig;
use yii\web\User;

/**
* This is the model class for table "{{%users}}".
*
* @property int $id
* @property string $username
* @property string $password
* @property string $email
* @property string $activkey
* @property string $create_at
* @property string $lastvisit_at
* @property int $superuser
* @property int $status
* @property int $fault_count
* @property string $fault_at
* @property string $unique_key
* @property int $created_at
* @property int $updated_at
*
* @property AuthAssignment[] $authAssignments
* @property AuthItem[] $itemnames
* @property Approve[] $approves
* @property Profiles $profiles
* @property Relationship[] $relationships
* @property Relationship[] $relationships0
* @property Users[] $relationUsers
* @property Users[] $users
* @property Workflow[] $workflows
*/
class Users extends \yii\db\ActiveRecord
{
    const SCENARIO_ADD_BY_ADMIN = 'admin';
    public $allAccess;
    private $allAccessFinded;


    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['username', 'password'], 'required','except' => self::SCENARIO_ADD_BY_ADMIN],
            [['username'], 'required', 'on' => self::SCENARIO_ADD_BY_ADMIN],
            [['create_at', 'lastvisit_at', 'fault_at'], 'safe'],
            [['superuser', 'status', 'fault_count', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 20],
            [['email'], 'email'],
            [['password', 'email', 'activkey'], 'string', 'max' => 128],
            [['unique_key'], 'string', 'max' => 6],
            [['username'], 'unique'],
            [['unique_key'], 'unique'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'کد ملی'),
            'password' => Yii::t('app', 'کلمه‌ی عبور'),
            'email' => Yii::t('app', 'رایانامه/ایمیل'),
            'activkey' => Yii::t('app', 'Activkey'),
            'create_at' => Yii::t('app', 'Create At'),
            'lastvisit_at' => Yii::t('app', 'Lastvisit At'),
            'superuser' => Yii::t('app', 'Superuser'),
            'status' => Yii::t('app', 'Status'),
            'fault_count' => Yii::t('app', 'Fault Count'),
            'fault_at' => Yii::t('app', 'Fault At'),
            'unique_key' => Yii::t('app', 'Unique Key'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['userid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getItemnames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'itemname'])->viaTable('AuthAssignment', ['userid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getApproves()
    {
        return $this->hasMany(Approve::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProfiles()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRelationships()
    {
        return $this->hasMany(Relationship::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRelationships0()
    {
        return $this->hasMany(Relationship::className(), ['relation_user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRelationUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'relation_user_id'])->viaTable('{{%relationship}}', ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('{{%relationship}}', ['relation_user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getWorkflows()
    {
        return $this->hasMany(Workflow::className(), ['creator_id' => 'id']);
    }

    public static function isAdmin ()
    {
        $adminAccess    =    array(1,941,963,8);
        $userId            =    Yii::$app->user->id;
        if(in_array($userId ,$adminAccess)){
            return true;
        }else{
            return false;
        }
    }
    public static function isStudentNewYear()    {		$id = Yii::$app->user->id;		$acdemicYear = yii::$app->fcore->getRegistrationAcademicYear();		$academic = Academic::find()->where(['user_id' => $id,'academic_year_id' => $acdemicYear,'deleted' => 0])					->andWhere(['IN','status',[1,18]])					->andWhere(['IN','organization_id',array_keys(yii::$app->fcore->getAllSchools())])					->all();                                                    if($academic)            return true;        else  return false;    }

    public static function isStudent($id    =    0 , $acdemicYear = 0)
    {
        if($id == 0)
            $id = Yii::$app->user->id;
        if($acdemicYear == 0)
            $acdemicYear = AcademicYear::getAcademicYear();

        $academic = Academic::find()->where(['user_id' => $id,'academic_year_id' => $acdemicYear,'deleted' => 0])
        ->andWhere(['IN','status',[1,18]])
        ->andWhere(['IN','organization_id',array_keys(yii::$app->fcore->getAllSchools())])
        ->all();

        if($academic)
            return true;
        else  return false;
    }
    public static function isExsiteAcademic($id    =    0 )
    {
        if($id == 0)
            $id = Yii::$app->user->id;


        $academic = Academic::findAll(['user_id' => $id]);
        if($academic)
            return true;
        else  return false;
    }
    public static function getDetailStudent($id    =    0 )
    {
        if($id == 0)
            $id = Yii::$app->user->id;

        $academic = Academic::find()->where(['user_id' => $id])->orderBy(['academic_year_id' => SORT_DESC])->one();
        if($academic){
            $appendFiled =    ($academic->field->id != 2) ?    '::'.$academic->field->title : ''; // 2  
            return '<b>دانش‌آموز::</b>'.$academic->academicYear->title.'::'.$academic->base->title.$appendFiled ;
        }

        else  return false;

    }
    public static function getDetailRelation($id    =    0 )
    {
        if($id == 0)
            $id = Yii::$app->user->id;

        $relationship = Relationship::find()->where(['relation_user_id' => $id])->one();
        if($relationship){            
            return '<b>'.$relationship->relationshipType->title.'</b>' .'&nbsp;'.self::getDetailStudent($relationship->user_id) ;
        }

        else  return false;

    }
    public static function isStudentAll($id    =    0 )
    {
        if($id == 0)
            $id = Yii::$app->user->id;


        $academic = Academic::find()->where(['user_id' => $id])->one();
        if($academic)
            return $academic->id;
        else  return false;
    }
    public static function isRelation($id    =    0)
    {
        if($id == 0)
            $id = Yii::$app->user->id;

        $relationship = Relationship::findAll(['user_id' => $id]);
        if($relationship)
            return true;
        else  return false;
    }
    public static function getWorkbookStatus($role)    
    {   
        $result = [];      
        if($role == 'parent')        
        {       
            $relationship  = Relationship::findAll(['relation_user_id' => Yii::$app->user->id,'is_deleted' => 0]);          
            if($relationship)            
            {   

                foreach($relationship as $relation) 
                {                   
                    $academic = Academic::find()->where(['user_id' => $relation->user_id,'academic_year_id' => yii::$app->fcore->getAcademicYear(),'deleted' => 0])                    
                    ->andWhere(['IN','organization_id',array_keys(yii::$app->fcore->getAllOrganization())])                    
                    ->one();  
                    if($academic)                    
                    {                    
                        $organizationBaseFieldObj = OrganizationBaseToField::find()->alias('obf')->joinWith('organizationToBase ob')->where([
                            'ob.organization_id' => $academic->organization_id,                                
                            'ob.base_id' => $academic->base_id,                                
                            'ob.academic_year_id' => $academic->academic_year_id,                                
                            'obf.field_id' => $academic->field_id,                            
                        ])->one();                        
                        $checkStatus        = yii::$app->festimate->checkMaxPixelAndAvgCount($organizationBaseFieldObj,true);                        
                        $profesinalWorkbook = $checkStatus['profesinalWorkbookToStudent'];                               
                        $termicWorkbook     = $checkStatus['profesinalWorkbookToStudent'];                        
                        $result[] = ['academic_id' => $academic->id,'user_id' => $academic->user_id, 'profesinalWorkbook' => $profesinalWorkbook,'termicWorkbook' => $termicWorkbook];                     
                    }                
                }            
            }          
        }        
        else if($role == 'student')        
        {            
            $academic = Academic::findOne([                
                'user_id' => yii::$app->user->id,                
                'academic_year_id' => yii::$app->fcore->getAcademicYear()   ,                
                'organization_id' => array_keys(yii::$app->fcore->getAllOrganization()) ,                
                'deleted' => 0 ,            ]);            
            if($academic)            
            {                                
                $organizationBaseFieldObj = OrganizationBaseToField::find()                
                ->alias('obf')                
                ->joinWith('organizationToBase ob')                
                ->where([                    
                    'ob.organization_id' => $academic->organization_id,                    
                    'ob.base_id' => $academic->base_id,                    
                    'ob.academic_year_id' => $academic->academic_year_id,                    
                    'obf.field_id' => $academic->field_id,                
                ])->one();  

            }           
            $checkStatus        = yii::$app->festimate->checkMaxPixelAndAvgCount($organizationBaseFieldObj,true);            
            $profesinalWorkbook = $checkStatus['profesinalWorkbookToStudent'];                   
            $termicWorkbook     = $checkStatus['termicWorkbookToStudent'];            
            $result = ['profesinalWorkbook' => $profesinalWorkbook,'termicWorkbook' => $termicWorkbook];               
        }        
        return $result;    
    } 


    public static function isPersonal ($userId = 0 , $academicYearId = 0 , $access =    array()){
        if($academicYearId == 0)
            $academicYearId = AcademicYear::getAcademicYear();

        if(!is_array($academicYearId))        $academicYearId        =    array($academicYearId);    

        if($userId == 0)
            $userId = Yii::$app->user->id ? Yii::$app->user->id : 0;    
        if($userId  != 1 ){

            $personal = PersonalConfig::find()->where('organization_id = '.Yii::$app->fcore->getOrganization().' AND user_id = '.$userId.' AND academic_year_id in ('.implode(',' , $academicYearId).')')->one();

            if(!empty($personal)){
                if(empty($access))     return true;
                else{
                    $arrOrgs    =    self::getUserOrganization($userId    ,$academicYearId);
                    $arrJobs    =    self::userAceess($access, $userId    ,array_keys($arrOrgs) ,$academicYearId);
                    if($arrJobs['error'] == true)    return false;
                    else return true;                        
                }
            }else
                return false;
        }elseif($userId  == 1)
            return true;
        else
            return false;



    }

    public static function getUserOrganization($userId ,$academicYearId = 3){
        $jobDetail = JobDetail::find()->where(['user_id'=> $userId,'academic_year_id'=> $academicYearId])->all();
        if(!empty($jobDetail))
            return  ArrayHelper::map($jobDetail, 'organization.id', 'organization.title');
        else
            return array();

    }

    public function setAllUserAccess($userId)
    {
        if(empty($_SESSION['accessDataFinded'])){
            $arrAccess    =    array();
            $userId = $userId ? $userId : 0;

            $mainOrganizationId  =    Yii::$app->fcore->getOrganization();

            $academicYearId      =    array(yii::$app->fcore->getAcademicYear());


            $arrOrgs    =     ArrayHelper::map(Organization::find()->where(" id = $mainOrganizationId Or organization_id = $mainOrganizationId" )->all() , 'id' ,'organization_id');
            $jobDetail = JobDetail::find()->joinWith('organization')->joinWith('job')->where(
                '(({{%job_detail}}.type = 2 AND {{%job_detail}}.enable = 1) || ({{%job_detail}}.type IN (0,1,3))) and user_id='.$userId.' and academic_year_id in ('.implode(',' , $academicYearId).' ) and   ( {{%job_detail}}.organization_id  in('.implode(',' , array_keys($arrOrgs )).' ) ) and `tbl_jobs`.title_en != ""'    )->all();
            $data = [];
            foreach($jobDetail as $job){
                $classes[$job->id] = [];
                if(in_array($job->type , [0,1,2])){
//                    $childJobs = JobDetail::model()->findAll('parent_id = :id and t.type = 3 and t.enable = 1' , [':id' => $job->id]);
//                    foreach ($childJobs as $childJob) {
                    if($job->class_id)
                        $classes[$job->id][$job->class_id] = $job->class_id;
//                    }
                }
                if($job->parent_id){
                    $classes[$job->id] = !empty($classes[$job->parent_id]) ? $classes[$job->parent_id] : [];
                }

                $data[] = [
                    'en_title' => $job->job->title_en,
                    'base_id' => $job->base_id,
                    'class_id' => $classes[$job->id],
                    'job_id' => $job->job_id,
                    'organization_id' => $job->organization_id,
                    'field_id' => $job->field_id,
                    'academic_year_id' => $job->academic_year_id,
                    'data' => $job,
                ];
            }
            $_SESSION['accessData'] = $data;
            $_SESSION['accessDataFinded'] = true;
        }


        $this->allAccessFinded = true;

        return $this->allAccess = $_SESSION['accessData'];

    }

    public function userAceess2($jobTitle ,$mainOrganizationId = 0,$baseId=0,$fieldId=0)
    {
        //        if(!Yii::$app->fuser->getOrganizationDayValid()){
        //            $arrAccess['error']    =    true;
        //            return     $arrAccess;
        //        } 
        $arrAccess = ['error' => false];
        if(!Yii::$app->fuser->getOrganizationDayValid()){
            $arrAccess['error']    =    true;
            return     $arrAccess;
        }


        //if(empty($mainOrganizationId) OR empty($jobTitle) ) 
        //        {
        //            $arrAccess['error']    =    true;
        //            return     $arrAccess;    
        //        }
        if(empty($mainOrganizationId))    $mainOrganizationId  =    yii::$app->fcore->getOrganization();

        if(!in_array($mainOrganizationId , array_keys(Yii::$app->fcore->getAllOrganization()))){
            $arrAccess['error']    =    true;
            return     $arrAccess;
        }

        if(!is_array($jobTitle))       $jobTitle     =    array($jobTitle);
        if(!is_array($fieldId))        if($fieldId) $fieldId    =    array($fieldId); else $fieldId = [];
        if(!is_array($baseId))         if($baseId) $baseId      =    array($baseId); else $baseId = [];
        $arrOrgs    =     ArrayHelper::map(Organization::find()
            ->where(" id = $mainOrganizationId Or organization_id = $mainOrganizationId" )
            ->all() , 'id' ,'organization_id');
        if(Yii::$app->user->id == 1)
            return ['error' => false];
        if(!$this->allAccessFinded)
            $this->setAllUserAccess(Yii::$app->user->id);
        $access =  $this->allAccess;
        foreach($access as $info){
            if(in_array($info['en_title'] , $jobTitle) || $info['en_title'] == 'cio'){
                if(in_array($info['organization_id'] , array_keys($arrOrgs)) or $info['organization_id'] == Yii::$app->fcore->getOrganization()){
                    if(in_array($info['base_id'] , $baseId) || !$baseId || !$info['base_id']){
                        $arrAccess['orgs'][]    =    $info['data'];
                    }
                } 
            }
        }

        if(empty($arrAccess['orgs']))
            $arrAccess['error'] = true;

        return $arrAccess;  
    }

    public static function userAceess($jobTitle , $userId = 0,$mainOrganizationId = 0,$academicYearId = 0,$baseId=0,$fieldId=0,$classId=0)
    {
        if(!Yii::$app->fuser->getOrganizationDayValid()){
            $arrAccess['error']    =    true;
            return     $arrAccess;
        }


        if($userId == 0){
            $userId = Yii::$app->user->id;
        }

        if($academicYearId == 0){
            $academicYearId = yii::$app->fcore->getAcademicYear();
        }

        if(empty($mainOrganizationId))    $mainOrganizationId  =    array_keys(Yii::$app->fcore->getAllOrganization());
        if(!is_array($mainOrganizationId))    $mainOrganizationId  =    [$mainOrganizationId];

        if(!in_array($mainOrganizationId[0] , array_keys(Yii::$app->fcore->getAllOrganization()))){
            $arrAccess['error']    =    true;
            return     $arrAccess;
        }

        if(!is_array($jobTitle))       $jobTitle     =    array($jobTitle);
        if(!is_array($fieldId))        if($fieldId) $fieldId    =    array($fieldId); else $fieldId = [];
        if(!is_array($baseId))         if($baseId) $baseId      =    array($baseId); else $baseId = [];
        $arrOrgs    =     $mainOrganizationId; /*ArrayHelper::map(Organization::find()
            ->where(["or" , ["id" => $mainOrganizationId] , ["organization_id" => $mainOrganizationId] ])
            ->all() , 'id' ,'organization_id');*/
        if(Yii::$app->user->id == 1) {
            $fakeJob = new JobDetail();
            $fakeJob->organization_id = Yii::$app->fcore->getOrganization();
            $fakeJob->field_id = 0;
            $fakeJob->base_id = 0;
            $fakeJob->class_id = 0;
            return ['error' => false, 'orgs' => [$fakeJob] , 'jobsData' => [['organization_id'=>Yii::$app->fcore->getOrganization()]]];

        }

        $users = new Users();
        $access = $users->setAllUserAccess($userId);

        foreach($access as $info){
            if(in_array($info['en_title'] , $jobTitle) || $info['en_title'] == 'cio'){
                if(in_array($info['organization_id'] , $arrOrgs) or $info['organization_id'] == Yii::$app->fcore->getOrganization()){
                    if(in_array($info['base_id'] , $baseId) || !$baseId || !$info['base_id']){
                        if(in_array($info['field_id'] , $fieldId) || !$fieldId || (!$info['field_id'])){
                            if(in_array($classId , $info['class_id']) || !$classId || !$info['class_id']){
                                $arrAccess['orgs'][]    =    $info['data'];
                                $arrAccess['jobsData'][]    =    $info;
                            }
                        }
                    }
                }
            }
        }
        if(empty($arrAccess['orgs']))
            $arrAccess['error'] = true;

        return $arrAccess;



//        $arrAccess    =    array();
//
//        if(!Yii::$app->fuser->getOrganizationDayValid()){
//            $arrAccess['error']    =    true;
//            return     $arrAccess;
//        }
//
//        if($baseId == 0){
//            $baseId = ArrayHelper::map(Base::find()->all() , 'id','id');
//        }
//        if($userId == 0){
//            $userId = Yii::$app->user->id;
//        }
//
//        if(!is_array($mainOrganizationId))    $mainOrganizationId  =    array($mainOrganizationId);
//        if(!is_array($jobTitle))            $jobTitle            =    array($jobTitle);
//        if(!is_array($academicYearId))        $academicYearId      =    array($academicYearId);
//        if(!is_array($baseId))                $baseId                =    array($baseId);
//
//        if(empty($mainOrganizationId) OR empty($jobTitle) )
//        {
//            $arrAccess['error']    =    true;
//            return     $arrAccess;
//        }
//        //  organization_id in ( ".implode(',' ,$mainOrganizationId ). ")   OR
//        $arrOrgs    =     ArrayHelper::map(Organization::find()->where(" id in ( ".implode(',' ,$mainOrganizationId ). " ) " )->all() , 'id' ,'organization_id');
//        $baseCondition = '' ;
//        $baseCondition = ' AND ({{%job_detail}}.base_id = 0 or {{%job_detail}}.base_id in (' . implode(',' , $baseId) . ') )' ;
//        $jobDetail = JobDetail::find()->joinWith('organization')->joinWith('job')->where(
//            '(({{%job_detail}}.type = 2 AND {{%job_detail}}.enable = 1) || ({{%job_detail}}.type IN (0,1))) AND ({{%jobs}}.title_en in( \''.implode("','" ,$jobTitle ).'\' ) OR {{%jobs}}.title_en = "cio") and  user_id='.$userId.' and academic_year_id in ('.implode(',' , $academicYearId).' ) and   ( {{%job_detail}}.organization_id  in('.implode(',' , array_keys($arrOrgs )).' ) OR {{%job_detail}}.organization_id in ('.implode(',' , $arrOrgs ).' )  )'.$baseCondition    )->all();
//
//        if(!empty($jobDetail))
//        {
//            $arrAccess['error']    =    false;
//            foreach($jobDetail as $arrData)
//            {
//                $arrAccess['orgs'][]    =    $arrData;
//            }
//        }
//        elseif(!Yii::$app->fuser->getUserIdValidAll()){
//            $arrAccess['error']    =    true;
//        }
//        else{
//            $arrAccess['error']    =    false;
//
//        }
//        return     $arrAccess;
    }   


    public static function userAccessOnly($jobTitle , $userId,$mainOrganizationId = 1,$academicYearId = 3,$baseId=0,$fieldId=0)
    { 
        $arrAccess    =    array();

        if(!Yii::$app->fuser->getOrganizationDayValid()){
            $arrAccess['error']    =    true;
            return     $arrAccess;
        }


        if($baseId == 0){
            $baseId = ArrayHelper::map(Base::find()->all() , 'id','id');
        }
        if(!is_array($mainOrganizationId))    $mainOrganizationId  =    array($mainOrganizationId);            
        if(!is_array($jobTitle))            $jobTitle            =    array($jobTitle);    
        if(!is_array($academicYearId))        $academicYearId      =    array($academicYearId);
        if(!is_array($baseId))                $baseId                =    array($baseId);

        if(empty($mainOrganizationId) OR empty($jobTitle) ) 
        {
            $arrAccess['error']    =    true;
            return     $arrAccess;    
        }
        //  organization_id in ( ".implode(',' ,$mainOrganizationId ). ")   OR  
        $arrOrgs    =     ArrayHelper::map(Organization::find()->where(" id in ( ".implode(',' ,$mainOrganizationId ). " ) " )->all() , 'id' ,'organization_id');
        $baseCondition = '' ;
        $baseCondition = ' AND ({{%job_detail}}.base_id = 0 or {{%job_detail}}.base_id in (' . implode(',' , $baseId) . ') )' ;
        $jobDetail = JobDetail::find()->joinWith('organization')->joinWith('job')->where(
            '(({{%job_detail}}.type = 2 AND {{%job_detail}}.enable = 1) || ({{%job_detail}}.type IN (0,1))) AND ({{%jobs}}.title_en in( \''.implode("','" ,$jobTitle ).'\' ) ) and  user_id='.$userId.' and academic_year_id in ('.implode(',' , $academicYearId).' ) and   ( {{%job_detail}}.organization_id  in('.implode(',' , array_keys($arrOrgs )).' ) OR {{%job_detail}}.organization_id in ('.implode(',' , $arrOrgs ).' )  )'.$baseCondition    )->all();

        if(!empty($jobDetail))
        {
            $arrAccess['error']    =    false;    
            foreach($jobDetail as $arrData)
            {
                $arrAccess['orgs'][]    =    $arrData;
            }
        }
        elseif(Yii::$app->user->id != 1){
            $arrAccess['error']    =    true;    
        }
        else{
            $arrAccess['error']    =    false;
        }
        return     $arrAccess;        
    } 

}
