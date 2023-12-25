<?php 
namespace common\components;

use Yii;
use yii\base\BaseObject;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\web\Controller;

use backend\models\Address;
use backend\models\ProfileAccessAssign;
use backend\models\ProfileAccessAssignDefault;
use backend\models\MobileSocialNetworkAssign;
use backend\models\Tel;
use backend\models\ContentsTagAssign;
use backend\models\Profiles;
use backend\models\Academic;
use backend\models\UserImage;
use backend\models\JobDetail;
use backend\models\Users;
use backend\models\Organization;
use backend\models\AcademicYear;
use backend\models\Contents;
use backend\models\Comment;
use backend\models\Files;
use backend\models\ContentRateLike;
use backend\models\CommentLike;
use backend\models\FileLike;
use backend\models\Follow;
use backend\models\ProfileDetail;
use backend\models\Relationship;
use backend\models\ContentUserAccess;
use backend\models\UserChatActivityDate;
use backend\models\UserToTagCvAssign;
use backend\models\AccessPublic;
use backend\models\ContentWorkbookUserAssign;
use backend\models\OrganizationToBase;
use backend\models\OrganizationBaseToField;
use backend\models\AuthAssignment;
use backend\models\Approve;




class FUserComponent extends Component
{
    
    public function getUserId($uiqueId){ 
        $findUsers    =    Users::find()->where(['unique_key' =>    $uiqueId ])->one();
        if(!empty($findUsers))     return   $findUsers->id;
        else '';
        
    }
    
    public function getUiqueId($userId){ 
        $findUsers    =    Users::find()->where(['id' =>    $userId ])->one();
        if(!empty($findUsers))     return   $findUsers->unique_key;
        else '';
        
    }
    public function checkProfileAccess($userId    ,    $profileAccessId    ,    $profileAccessTypeId    ){ 
        $findProfileAccessAssign            =    ProfileAccessAssign::find()->where([
                                                                'user_id'                     =>    $userId    ,    
                                                                'profile_access_id'            =>    $profileAccessId,
                                                                'profile_access_type_id'    =>    $profileAccessTypeId])->one();
        if(empty($findProfileAccessAssign)){
            $findProfileAccessAssignDefault    =     ProfileAccessAssignDefault::find()->where([
                                                                'profile_access_id'            =>    $profileAccessId,
                                                                'profile_access_type_id'    =>    $profileAccessTypeId])->one();
            if(empty($findProfileAccessAssignDefault)){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }       
        
    }
    
    public function getCountUserTagCv($tagId){ 
        $findUserToTagCvAssign    =    UserToTagCvAssign::find()->where(['tag_cv_id' =>    $tagId ])->all();
        return count( $findUserToTagCvAssign );
        
    }
    public function getCountContentTag($tagId){ 
        $findUserToTagCvAssign    =    ContentsTagAssign::find()->where(['tag_id' =>    $tagId ])->all();
        return count( $findUserToTagCvAssign );
        
    }
    
    public function getMobile($userId){ 
        $mobile    =    ProfileDetail::find()->where(['user_id' =>    $userId ,'profile_detail_type_id'=>1 ,'is_default' => 1])->one();
        if(!empty($mobile))     return   $mobile->title;
        else return '';
        
    }
    public function getMobileId($userId){
        $mobile    =    ProfileDetail::find()->where(['user_id' =>    $userId ,'profile_detail_type_id'=>1 ,'is_default' => 1])->one();
        if(!empty($mobile))     return   $mobile->id;
        else return '';

    }

    public function getSocialNetworkForUser($mobileId){
        if(!empty($mobileId)) {
            $mySocialNetwork = MobileSocialNetworkAssign::find()->asArray()->where(['profile_detail_id' => $mobileId])->all();
            if (!empty($mySocialNetwork))
            {
                return $mySocialNetwork;

            }

            else return '';
        }else{
            return '';
        }


    }
    public function getMobileFather($userId){ 
        $findRelationship    =     Relationship::find()->where(['user_id' =>    $userId ,'relationship_type_id'=> 1 ,'is_deleted' => 0])->one();
        if(!empty($findRelationship))     return   $this->getMobile($findRelationship->relation_user_id);
        else '';
        
    }
    public function getMobileMother($userId){ 
        $findRelationship    =     Relationship::find()->where(['user_id' =>    $userId ,'relationship_type_id'=> 2 ,'is_deleted' => 0])->one();
        if(!empty($findRelationship))     return   $this->getMobile($findRelationship->relation_user_id);
        else '';
        
    }
    public function getFullname($userId){ 
        $profile    =    Profiles::find()->where(['user_id' =>    $userId ])->one();
        if(!empty($profile))     return   $profile->name .' '.$profile->lname;
        else '';
        
    }
    public function getImageAcademic($userId){ 
        
        $academic    =    Academic::find()
                        ->where(['user_id' =>    $userId , 'organization_id'    =>    array_keys(yii::$app->fcore->getAllOrganization()) ,'deleted'    =>    0])
                        ->orderBy(['academic_year_id' => SORT_DESC])
                        ->one();
        if(!empty($academic)){
            if(is_null($academic->image))
                return  '';
            else{
                return   '<img width="50" class="img-circle" src="'.Yii::$app->fcore->getImageAcademicUrl($academic->user_id,$academic->id,$academic->image).'" />';
            }
                
        }else '';
        
    }
    public function getUserImageProfile($userImageId,$type = 'profile',$typeReturn='img'){
        $userImage    =    UserImage::find()    ->where(['id' =>    $userImageId ])    ->one();
        if(!empty($userImage)){
            if($type == 'profile') {
                if($typeReturn== 'img')
                    return '<img width="50" class="img-circle" src="' . Yii::$app->fcore->getUserImageProfileUrl($userImage->user_id, $userImage->file->fake_name) . '" />';
                elseif($typeReturn== 'link')
                    return Yii::$app->fcore->getUserImageProfileUrl($userImage->user_id, $userImage->file->fake_name);
            }elseif($type == 'attach') {
                if($typeReturn== 'img')
                    return '<img width="50" class="img-circle" src="' . Yii::$app->fcore->getUserImageProfileUrl($userImage->user_id, $userImage->file->fake_name, 'attach') . '" />';
                elseif($typeReturn== 'link')
                    return Yii::$app->fcore->getUserImageProfileUrl($userImage->user_id, $userImage->file->fake_name, 'attach');
                elseif($typeReturn== 'user'){
                    $hmtl 	=	$userImage->profile->name .' '. $userImage->profile->lname ;	

					if(Users::isStudentAll($userImage->profile->user_id))
						$hmtl	.=	'<br>'.Users::getDetailStudent($userImage->profile->user_id);
					elseif(Users::isPersonal($userImage->profile->user_id))
						$hmtl	.=	'<br>'.'<b>همکار</b>';
					else
						$hmtl	.=	'<br>'.Users::getDetailRelation($userImage->profile->user_id);
						
					return $hmtl;
                }
                    
                    
            }else {
                if($typeReturn== 'img')
                    return '<img width="50" class="img-circle" src="' . Yii::$app->fcore->getUserImageProfileUrl($userImage->user_id, $userImage->file->fake_name) . '" />';
                elseif($typeReturn== 'link')
                    Yii::$app->fcore->getUserImageProfileUrl($userImage->user_id, $userImage->file->fake_name);
            }

        }else return '';

    }
    public function getMother($userId,$justName = false)
    { 
        $relation    =    Relationship::find()->where(['user_id' =>    $userId ,'relationship_type_id'    =>   2 ,'is_deleted' => 0])->one();
        if(!empty($relation))     
            return  $justName ? $relation->relationUserProfiles->name :   $relation->relationUserProfiles->name .' '. $relation->relationUserProfiles->lname;
        else '-';
        
    }
    
    public function getFather($userId,$justName = false)
    { 
        $relation    =    Relationship::find()->where(['user_id' =>    $userId ,'relationship_type_id'    =>    1,'is_deleted' => 0])->one();
        if(!empty($relation))     
            return  $justName ? $relation->relationUserProfiles->name : $relation->relationUserProfiles->name .' '. $relation->relationUserProfiles->lname;
        else '-';
        
    }
    
    public function getHomeTelByStudentId($userId)
    { 
         $parents  = $this->getParentId($userId);
         $homeTels = '';
         if($parents)
         {
            $tel = Tel::find()
                    ->alias('t')
                    ->joinWith('address a')
                    ->where(['IN','a.return_id',$parents])
                    ->andWhere(['a.type' => 0])
                    ->andWhere(['t.is_active' => 1])
                    ->one();
            if($tel)
                return $tel->main_tel;
            else return $homeTels;
         }
         return $homeTels;
    }

    public  function getOrganizationDayRemained()
    {
        $dateNow        =    date('Y-m-d');
        $organizationCurrent    =    Yii::$app->fcore->getOrganization(true);
        $dateStartOrg   =   $organizationCurrent['organization']['start_date_for_pay'];
        $interval        =    date_diff(date_create($dateStartOrg),date_create($dateNow));
        return $interval->days;
    }
    public  function getOrganizationDayValid(){
        if($this->getOrganizationDayRemained() < 395)
            return true;
        else
            return false;
    }
    public  function getOrganizationDayAlarm(){
        if($this->getOrganizationDayRemained()  > 335 )
            return true;
        else
            return false;
    }
    
    
    
    
    public function getParentId($userId)
    {
        $father    =    Relationship::find()->where(['user_id' =>    $userId ,'relationship_type_id'    =>    1,'is_deleted' => 0])->one();
        $mother    =    Relationship::find()->where(['user_id' =>    $userId ,'relationship_type_id'    =>    2,'is_deleted' => 0])->one();
        $parent = [];
        if(!empty($father))
            $parent['father'] = $father->relation_user_id;
        if(!empty($mother))
            $parent['mother'] = $mother->relation_user_id;
        return $parent;
    }
    public function getUserIdValidAll(){
        $orgId    =    Yii::$app->fcore->getOrganization();
        $userId    =    Yii::$app->user->id;
        $modelAccessPublic =    AccessPublic::find()->where(" ( organization_id is null or  organization_id = $orgId ) and user_id = $userId  ")->one();
        if(!empty($modelAccessPublic)) return true;
        else return false;    
        
    }
    
    public function userAccess($arrAccess){
        if(Users::userAceess($arrAccess ,
                   Yii::$app->user->id,
                    Organization::getAllOrganization()   ,
                    AcademicYear::getAcademicYear(date('Y-m-d'))
                )['error'] )    return Yii::$app->response->redirect(['site/forbidden'])->send(); 
            

    }
    public function userAccessOnly($arrAccess , $menu=0){ 
        $check    =    Users::userAccessOnly($arrAccess ,
                       Yii::$app->user->id,
                        Organization::getAllOrganization()   ,
                        AcademicYear::getAcademicYear(date('Y-m-d'))
                    )['error'];
        if ($menu    ==    0    )
            if( $check    )    return Yii::$app->response->redirect(['site/forbidden'])->send(); 
                
        if ($menu    ==    1    )
            return !$check;            

    }
    

    public function userForbiden(){
             return Yii::$app->response->redirect(['site/forbidden'])->send(); 
    }
    public function getCount($id , $type ){
        
        if($type == 'countWorkbookmeNotVisit'){
            $userId = $id;
            if(!empty($userId)){
				$date			=	yii::$app->fcore->getAcademicYearDate();
				$dateAcademic	=	date( "Y-m-d", strtotime( "$date -15 day" ) );
				
                $count                = ContentWorkbookUserAssign::find()
                ->alias('cwua')
                ->joinWith('content as content') 
                ->where(['content.is_publish'=>1, 'content.cat_id'=>17 ,'cwua.is_delete'    =>    0 , 'cwua.user_id'    =>    $userId , 'cwua.is_visit'=>0 , 'cwua.is_send_comment'=>0 , 'cwua.is_pass'=>0 ])
                ->andWhere(['<=','content.publish_date',date('Y-m-d 23:59:59') ])
                ->andWhere(['>=','content.create_date',$dateAcademic ])
                ->count();
            }else
                $count                = 0;
                return $count  ;
        }elseif($type == 'countLessonmeNotVisit'){
            $userId = $id;
            if(!empty($userId)){
                $count                = ContentWorkbookUserAssign::find()
                ->alias('cwua')
                ->joinWith('content as content') 
                ->where(['content.is_publish'=>1, 'content.cat_id'=>6 ,'cwua.is_delete'    =>    0 , 'cwua.user_id'    =>    $userId , 'cwua.is_visit'=>0 , 'cwua.is_send_comment'=>0 , 'cwua.is_pass'=>0 ])
                ->andWhere(['<=','content.publish_date',date('Y-m-d H:i:s') ])
                ->count();
            }else
                $count                = 0;
                return $count  ;
        }elseif($type == 'countWorkbookmeNotPostComment'){
            $userId = $id;
            if(!empty($userId)){
				$date			=	yii::$app->fcore->getAcademicYearDate();
				$dateAcademic	=	date( "Y-m-d", strtotime( "$date -15 day" ) );
                $count                = ContentWorkbookUserAssign::find()
                ->alias('cwua')
                ->joinWith('content as content') 
                ->where([	
							'content.is_publish'		=>	1 ,
							'content.cat_id'		=>	17 ,
							'cwua.is_delete'    		=>  0 ,
							'cwua.user_id'   			=>  $userId , 
							'cwua.is_send_comment'		=>	0 ,
							'cwua.is_visit'				=>	1 ,
							'cwua.is_pass'				=>	0 
						])
                ->andWhere(['<=','content.publish_date',date('Y-m-d 23:59:59') ])
                ->andWhere(['>=','content.create_date',$dateAcademic])
                ->count();
            }else
                $count                = 0;
                return $count  ;
        

        }elseif($type == 'countWorkbookmeNotPostCommentNotExpireDate'){
            $userId = $id;
            if(!empty($userId)){
				$date			=	yii::$app->fcore->getAcademicYearDate();
				$dateAcademic	=	date( "Y-m-d", strtotime( "$date -15 day" ) );
                $count                = ContentWorkbookUserAssign::find()
                ->alias('cwua')
                ->joinWith('content as content') 
                ->where([	
							'content.is_publish'		=>	1 ,
							'content.cat_id'		=>	17 ,
							'cwua.is_delete'    		=>  0 ,
							'cwua.user_id'   			=>  $userId , 
							'cwua.is_send_comment'		=>	0 ,
							'cwua.is_visit'				=>	1 ,
							'cwua.is_pass'				=>	0 
						])
                ->andWhere(['<=','content.publish_date',date('Y-m-d 23:59:59') ])
                ->andWhere(['>=','content.create_date',$dateAcademic])				
				->andWhere(" content.expire_date_for_send_comment  is  null")
                ->count();
            }else
                $count                = 0;
                return $count  ;
        

        }elseif($type == 'countWorkbookmeNotPostComment2WeekSoExpireDate'){
            $userId = $id;
            if(!empty($userId)){
				$date			=	yii::$app->fcore->getAcademicYearDate();
				$dateAcademic	=	date( "Y-m-d", strtotime( "$date -15 day" ) );
				$date	=	date('Y-m-d');
				$date2Week	=	date( "Y-m-d", strtotime( "$date -15 day" ) );
                $count                = ContentWorkbookUserAssign::find()
                ->alias('cwua')
                ->joinWith('content as content') 
                ->where([	
							'content.is_publish'		=>	1 ,
							'content.cat_id'		=>	17 ,
							'cwua.is_delete'    		=>  0 ,
							'cwua.user_id'   			=>  $userId , 
							'cwua.is_send_comment'		=>	0 ,
							'cwua.is_visit'				=>	1 ,
							'cwua.is_pass'				=>	0 
						])
                ->andWhere(['<=','content.publish_date',date('Y-m-d 23:59:59') ])
                ->andWhere(['>=','content.create_date',$dateAcademic])
				->andWhere(['>=','content.expire_date_for_send_comment',$date2Week])
				->andWhere(" content.expire_date_for_send_comment  is not null")
                ->count();
            }else
                $count                = 0;
                return $count  ;
        

        }
		
		elseif($type == 'content'){
            $count                =    Contents::find()
                ->where(['create_user_id'=>$id ,'is_publish'    =>    1 ])
                ->andWhere(['<>','cat_id',7 ])
                ->count();

        }elseif($type == 'comment'){
            $count                =    Comment::find()
                                        ->joinWith('content as content')
                                        ->where(['user_id'=>$id  ])
                                        ->andWhere(['<>','content.cat_id',7 ])
                                    ->count();

        }elseif($type == 'picture'){
            $count                =    Files::find()
                                        ->joinWith('content as content')
                                        ->where(['user_id'=>$id ,'files_type_id' =>[1,2,3]  ])
                                         ->andWhere(['<>','content.cat_id',7 ])
                                        ->count();

        }elseif($type == 'media'){
            $count                =    Files::find()
                                        ->joinWith('content as content')
                                        ->where(['user_id'=>$id ,'files_type_id' =>[4,6]  ])
                                        ->andWhere(['<>','content.cat_id',7 ])
                                        ->count();

        }elseif($type == 'attach'){
            $count                =    Files::find()
                                    ->joinWith('content as content')
                                    ->where(['user_id'=>$id ,'files_type_id' =>[5]  ])
                                   ->andWhere(['<>','content.cat_id',7 ])
                                 ->count();

        }elseif($type == 'likeforuser'){
            $countLikeForContent        =    ContentRateLike::find()
                                            ->joinWith('content as content')
                                            ->where([ 'like_type' => 1 , 'content.create_user_id'=>$id ,'is_publish' => 1 ])
                                            ->andWhere(['<>','content.cat_id',7 ])
                                            ->count();
            $countCommentLike           =    CommentLike::find()->joinWith('comment as comment')->where(['like_type' => 1 ,'comment.user_id'=>$id])->count();
            $countFileLike                =    FileLike::find()->joinWith('file as file')->where(['like_type' => 1 ,'file.user_id' => $id])->count();
             $count    =     $countLikeForContent    +    $countCommentLike    +        $countFileLike    ;
        
        }elseif($type == 'likeforcontent'){
            $count                        =    ContentRateLike::find()
                                                ->joinWith('content as content')->where(['like_type' => 1 , 'content_id'=>$id])
                                                 ->andWhere(['<>','content.cat_id',7 ])
                                                ->count();
        }elseif($type == 'followforuser'){
            $type_id    =    2;    
            $count     = Follow::find()->where(['return_id' => $id , 'type' =>$type_id  ])->count();
        }elseif($type == 'followforcontent'){
            $type_id    =    1;    
            $count     = Follow::find()->where(['return_id' => $id , 'type' =>$type_id  ])->count();
            
        }elseif($type == 'likedoforuser'){
            $countLikeForContent        =    ContentRateLike::find()
                                            ->joinWith('content as content')
                                            ->where(['like_type' => 1 , 'user_id'=>$id ,'content.is_publish' => 1 ])
                                            ->andWhere(['<>','content.cat_id',7 ])
                                            ->count();
            $countCommentLike           =    CommentLike::find()->where(['like_type' => 1 ,'user_id'=>$id])->count();
            $countFileLike                =    FileLike::find()->where(['like_type' => 1 ,'user_id' => $id])->count();
            $count    =     $countLikeForContent    +    $countCommentLike    +        $countFileLike    ;
        
        }elseif($type == 'followforuserme'){
            $type_id   =    2;
            $count     =    Follow::find()->where([ 'type' =>$type_id ,'user_id' => $id ])->count();

        }
        if($count > 1000){
            $count    =    round($count / 1000).'k';
        }
        return  yii::$app->fstring->translateDigits($count);
        
        
    }

    public function getImageUrl($userId,$image,$isFemale = 0,$academicId = 0,$dirSlave  =   0)
    {
        if($image != '')
        {
            if(!$academicId){ 
                if(!$dirSlave)
                    $path     =    __DIR__ .'/../../../server/php/files/'.$userId.'/profile/'.$image;
                else
                    $path     =    __DIR__ .'/../../../server/php/files/'.$userId.'/profile/'.$dirSlave.'/'.$image;
            
            }else   $path     =    __DIR__ .'/../../../server/php/files/'.$userId.'/profile/'.$academicId.'/'.$image;
            
            if(file_exists($path))
            {
                if(!$academicId){
                    if(!$dirSlave)
                        $url    =     yii::getAlias('@yii1Url') .'/server/php/files/'.$userId.'/profile/'.$image;
                    else
                        $url    =     yii::getAlias('@yii1Url') .'/server/php/files/'.$userId.'/profile/'.$dirSlave.'/'.$image;
                    
                }else  $url    =     yii::getAlias('@yii1Url') .'/server/php/files/'.$userId.'/profile/'.$academicId.'/'.$image;
            }
            else
                $url    =     yii::getAlias('@yii1Url') .'/images/no_pic.jpg';
            
        }
        else
        {
            if($isFemale == 1)
                $url = 'https://hedayatmizan.ir/'.'images/users/female.jpg';
            else
                $url = 'https://hedayatmizan.ir/'.'images/users/male.jpg';

        }
        return $url;
    }

    public function getAcademicFolder($userId,$academicId)
    {
        $basePath    =    Yii::getAlias('@filesDir');
        $dirMain     =    'profile';
        $dir         =    $basePath  .'/'. $userId ;
        if ( ! is_dir($dir ) ) 
            mkdir($dir, 0777);            

        $dir        =    $basePath  .'/'. $userId .'/' .$dirMain ;

        if ( ! is_dir($dir ) ) 
            mkdir($dir, 0777);            

        $dir        =    $basePath .'/'. $userId .'/' .$dirMain . '/' . $academicId ;

        if ( ! is_dir($dir ) ) 
            mkdir($dir, 0777);            
        return $dir;

    }   
    public function getProfileFolder($userId,$dirSlave  =   0)    {     
       
        $basePath    =    Yii::getAlias('@filesDir');        
        $dirMain     =    'profile';       
        $dir         =    $basePath  .'/'. $userId ;       
        if ( ! is_dir($dir ) )            
            mkdir($dir, 0777);                    
        $dir        =    $basePath  .'/'. $userId .'/' .$dirMain ;      
        if ( ! is_dir($dir ) )     
            mkdir($dir, 0777);

        if($dirSlave){
             $dir        =    $basePath  .'/'. $userId .'/' .$dirMain .'/' .$dirSlave;      
            if ( ! is_dir($dir ) )     
                mkdir($dir, 0777);
        }

        
        return $dir;  
    }

    public  function getUserContactInfo($userId)
    {   
        $telString         = 'شماره تماسی ثبت نگردیده است!';
        $address         = Address::find()->where(['return_id' => $userId , 'type' => 0] )->one();
        if($address)
        {
            $addressTitle      = $address->title;
            $tels             = Tel::find()->where(['address_id' => $address->id])->all();
            $telsCount         = count($tels);
            if($tels)
            {
                foreach($tels as $tel)
                {
                    $telString = $tel->main_tel;
                    if($telsCount > 1)
                        $telString .= ',';
                }
            }
        }
        else $addressTitle      = 'آدرس محل سکونت ثبت نگردیده است!';


        $profile                 = Profiles::findOne($userId);

        $mobile                  = $profile->mobile_one; 
        $type                    = $profile->is_female ? 'خانم ' : 'آقای ';
        $natioanlCode            = $profile->user->username;

        $result                 = array();
        $result['mobile']       = yii::$app->fstring->translateDigits($mobile);
        $result['type']         = $type;
        $result['natioanlCode'] = yii::$app->fstring->translateDigits($natioanlCode);
        $result['address']      = $addressTitle;
        $result['tel']          = yii::$app->fstring->translateDigits($telString);

        return $result;
    }
    public function getAcademicCurrent($userId){
        $academic       = Academic::find()->where(['user_id' => $userId,'academic_year_id' => yii::$app->fcore->getAcademicYear() , 'organization_id' => array_keys(yii::$app->fcore->getAllOrganization()),'deleted'=>0])->one();
        return $academic;
    }
    public function getAcademicRegister($userId){
        $academic       = Academic::find()->where(['user_id' => $userId,'academic_year_id' => yii::$app->fcore->getRegistrationAcademicYear() , 'organization_id' => array_keys(yii::$app->fcore->getAllOrganization()),'deleted'=>0])->one();
        return $academic;
    }
    
    public function getAcademicRegisterOBF($userId){
        $academic       =   $this->getAcademicRegister($userId);
        if(!empty($academic )){
            $organizationToBase         = OrganizationToBase::findOne(['academic_year_id' => $academic->academic_year_id,'organization_id' => $academic->organization_id, 'base_id' => $academic->base_id]);
            if(!empty($organizationToBase)){
                $organizationBaseToField    = OrganizationBaseToField::findOne(['organization_to_base_id' => $organizationToBase->id,'field_id' => $academic->field_id]);
                return $organizationBaseToField;
            }else
                return '';
        }else
            return '';
    }
    
    public function getAcademicUploadFile($userId){
        $academicOBF        =   $this->getAcademicRegisterOBF($userId);
        $arrRes['error']            =   false;
        $arrRes['student_error']    =   false;
        $arrRes['father_error']     =   false;
        $arrRes['mother_error']     =   false;
        $arrRes['data']     =   array();
        $arrParent  =   yii::$app->fuser->getParentId($userId);
        

        if(!empty($academicOBF)){
                if($academicOBF->is_upload_student_photo    ==  1){
					$findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $userId , 'fileType.type'	=>	1 ,'file.files_type_id' => 21 ])->all(); // 3 is user attach		
                    if(empty($findUserImage)){
                        $arrRes['data']['fa'][]  =   'تصویر دانش آموز آپلود نشده است.';
                        $arrRes['data']['en'][]  =   'no_upload_student_photo';
                        $arrRes['error']   =    true;
                        $arrRes['student_error']    =   true;
                        $arrRes['student_data']['fa'][]  =   'تصویر دانش آموز آپلود نشده است.';
                        $arrRes['student_data']['en'][]  =   'no_upload_student_photo';
                        
                    }
                }
                if($academicOBF->is_upload_student_last_certificate    ==  1){
                    $academicCurrent = yii::$app->fuser->getAcademicCurrent($_GET['userId']); 
                    $checkUpload    =   true;
                    if(empty($academicCurrent)){
                        $academicRegister = yii::$app->fuser->getAcademicRegister($_GET['userId']); 
                        if(!empty($academicRegister)){
                            if($academicRegister->base_id <=3)
                                $checkUpload =  false;
                            }else
                                $checkUpload =  false;
                    }else{
                        $checkUpload =  false;
                    }
                    if($checkUpload){
    					$findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $userId , 'fileType.type'	=>	3 ,'file.files_type_id' => 29  ])->all(); // 3 is user attach		
                        if(empty($findUserImage)){
                            $arrRes['data']['fa'][]  =   'تصوير آخرين مدرکي تحصيلي براي دانش آموزان جديد آپلود نشده است';
                            $arrRes['data']['en'][]  =   'no_upload_student_last_certificate';
                            $arrRes['error']   =    true;
                            $arrRes['student_error']    =   true;
                            $arrRes['student_data']['fa'][]  =   'تصوير آخرين مدرکي تحصيلي براي دانش آموزان جديد آپلود نشده است';
                            $arrRes['student_data']['en'][]  =   'no_upload_student_last_certificate';

                            
                        }
                    }
                    
                }
                if($academicOBF->is_upload_student_first_page_sh    ==  1){
        		    $findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $_GET['userId'] , 'fileType.type'	=>	3 ,'file.files_type_id' => 9 ])->all(); // 3 is user attach
				     if(empty($findUserImage)){
                        $arrRes['data']['fa'][]  =   'تصوير صفحه اول شناسنامه دانش آموز آپلود نشده است.';
                        $arrRes['data']['en'][]  =   'no_upload_student_first_page_sh';
                        $arrRes['error']   =    true;
                        $arrRes['student_error']    =   true;
                        $arrRes['student_data']['fa'][]  =   'تصوير صفحه اول شناسنامه دانش آموز آپلود نشده است.';
                        $arrRes['student_data']['en'][]  =   'no_upload_student_first_page_sh';
                    }
                }
                if($academicOBF->is_upload_student_father_cardmeli    ==  1){
                    if( isset($arrParent['father'])){
    				    $findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $arrParent['father'] , 'fileType.type'	=>	3 ,'file.files_type_id' => 7 ])->all(); // 3 is user attach
    				     if(empty($findUserImage)){
                            $arrRes['data']['fa'][]  =   'تصوير کارت ملي پدر دانش آموز آپلود نشده است.';
                            $arrRes['data']['en'][]  =   'no_upload_student_father_cardmeli';
                            $arrRes['error']   =    true;
                            $arrRes['father_error']    =   true;
                            $arrRes['father_data']['fa'][]  =   'تصوير کارت ملي پدر دانش آموز آپلود نشده است.';
                            $arrRes['father_data']['en'][]  =   'no_upload_student_father_cardmeli';
                        }
                        
                        
                    }
                }
                if($academicOBF->is_upload_father_first_page_sh    ==  1){
                    if( isset($arrParent['father'])){
    				    $findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $arrParent['father'] , 'fileType.type'	=>	3 ,'file.files_type_id' => 9 ])->all(); // 3 is user attach
    				     if(empty($findUserImage)){
                          $arrRes['data']['fa'][]  =   'تصوير صفحه اول شناسنامه پدر دانش آموز آپلود نشده است.';
                             $arrRes['data']['en'][]  =   'no_upload_student_father_sh_cardmeli';
                            $arrRes['error']   =    true;
                            $arrRes['father_error']    =   true;
                             $arrRes['father_data']['fa'][]  =   'تصوير صفحه اول شناسنامه پدر دانش آموز آپلود نشده است.';


                            $arrRes['father_data']['en'][]  =   'no_upload_student_father_sh_cardmeli';
                        }
                        
                        
                    }
                }
                if($academicOBF->is_upload_student_mother_cardmeli    ==  1){
                    if( isset($arrParent['mother'])){
    				    $findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $arrParent['mother'] , 'fileType.type'	=>	3 ,'file.files_type_id' => 7 ])->all(); // 3 is user attach
    				     if(empty($findUserImage)){
                            $arrRes['data']['fa'][]  =  'تصویر کارت ملی مادر دانش آموز آپلود نشده است.';
                            $arrRes['data']['en'][]  =   'no_upload_student_mother_cardmeli';
                            $arrRes['error']   =    true;
                            $arrRes['mother_error']    =   true;
                            $arrRes['mother_data']['fa'][]  =  'تصویر کارت ملی مادر دانش آموز آپلود نشده است.';
                            $arrRes['mother_data']['en'][]  =   'no_upload_student_mother_cardmeli';
                            
                        }
                        
                        
                    }
                }
                
             if($academicOBF->is_upload_mother_first_page_sh    ==  1){
                    if( isset($arrParent['mother'])){
    				    $findUserImage	=	UserImage::find()->alias('t')->joinWith('file as file')->joinWith('file.fileType as fileType')->where(['t.user_id'=> $arrParent['mother'] , 'fileType.type'	=>	3 ,'file.files_type_id' => 9 ])->all(); // 3 is user attach
    				     if(empty($findUserImage)){
							
							$arrRes['data']['fa'][]  =  'تصوير صفحه اول شناسنامه مادر دانش آموز آپلود نشده است.';
                            $arrRes['data']['en'][]  =   'no_upload_student_mother_cardmeli';
                            $arrRes['error']   =    true;
                            $arrRes['mother_error']    =   true;
                            $arrRes['mother_data']['fa'][]  =  'تصوير صفحه اول شناسنامه مادر دانش آموز آپلود نشده است.';
                            $arrRes['mother_data']['en'][]  =   'no_upload_student_mother_cardmeli';
                            
                        }
                        
                        
                    }
                }
            
            
        }
            
        return $arrRes;
    }

    public  function getUserImage($userId,$academicYearId,$isPersonal=false)
    {   
        if($isPersonal)
        {
            $profile  = Profiles::findOne($userId);
            $imageUrl = $this->getImageUrl($profile->user_id,$profile->image,$profile->is_female);
        }
        else
        {  
            $academic       = Academic::find()->where(['user_id' => $userId,'academic_year_id' => $academicYearId ,'deleted'=>0])->one();
            if($academic)
            {
                if($academic->image)
                {
                    $dir            = $this->getAcademicFolder($userId,$academic->id); 
                    $file           = $dir.'/'.$academic->image;
                    $profileFolder  = Utility::explodText($file,1,'/server/');
                    $imageUrl       = yii::getAlias('@yii1Url') . '/server/' . $profileFolder; 
                }
                else
                {
                    $profile  = Profiles::findOne($userId); 
                    $imageUrl = $this->getImageUrl($profile->user_id,$profile->image,$profile->is_female);
                }
            }
            else 
            {
                 $profile  = Profiles::findOne($userId); 
                 $imageUrl = $this->getImageUrl($profile->user_id,$profile->image,$profile->is_female);
            }
        }  
        return $imageUrl;
    }
    public  function getUserProfileImage($userId , $type='defaultIfNull')
    {
        $dir='';
        $findUserImage   =   UserImage::find()
                                ->alias('t')
                                ->joinWith('file as file')
                                ->where(" t.user_id = $userId AND file.files_type_id = 21 and is_default = 1")->one(); //21 is profile
        $profile  = Profiles::findOne($userId); 
        if(!empty($findUserImage))
              $dir   = yii::getAlias('@yii1Url') . '/server/php/files/' .$userId.'/profile/'. $findUserImage->file->fake_name;
        elseif($type=='defaultIfNull'){
            if($profile->is_female  ==  0)
                 $dir   = yii::getAlias('@yii1Url') .'/images/users/male.jpg';
            else    
                 $dir   = yii::getAlias('@yii1Url') .'/images/users/female.jpg';
        }  
        return  $dir;
    }
    
    public function getTeacherLessons($academicYear,$organization,$base,$field,$user)
    {
        $lessons = array();
        $jobDetail = JobDetail::find()->asArray()->where([
                                                'organization_id'   => $organization,
                                                'academic_year_id'  => $academicYear,
                                                'base_id'           => $base,
                                                'user_id'           => $user,
                                                'field_id'          => $field,
                                            ])->all();
        foreach($jobDetail as $jobRow)
        {
             array_push($lessons,$jobRow['lesson_id']);
        } 
        return array_filter($lessons);
    }
    
    public function isUserAccessToContent($id , $type = 'content' , $userId = '')
    {
        $access = [
            'is_admin' => false,
            'is_super_admin' => false,
            'is_owner' => false,
            'show_message' => false,
            'send_message' => false,
            'add_user' => false,
            'delete_user' => false,
            'change_avatar' => false,
            'change_name' => false,
            'delete_all_message' => false,
            'is_joined' => false
        ];

        $content = '';
        if(!$userId)
            $userId = Yii::$app->user->id;
        if($type == 'comment'){
            $comment = Comment::findOne($id);
            if($comment){
                $content = Contents::findOne($comment->content_id);
            }
        }
        elseif($type == 'content'){
            $content = Contents::findOne(['id' => $id , 'is_delete' => 0]);
        }
        if ($content) {
            $isContent = Contents::find()
                ->where([
                    'id' => $content->id,
                    'create_user_id' => $userId,
                    'is_delete' => 0,
                ])->one();
            $contentUserAccess = ContentUserAccess::find()
                ->joinWith(['content as content'])
                ->alias('t')
                ->where([
                    'content.is_delete' => 0,
                    'content.is_publish' => 1,
                    'content.is_close' => 0,
                    't.user_id' => $userId,
                    'content.id' => $content->id,
                    'content.cat_id' => 7
                ])->one();
            if($isContent || $contentUserAccess)
            {
                $access['is_admin'] = $isContent ? true : ($contentUserAccess->is_admin ? true : false);
                $access['is_super_admin'] = $isContent ? true : ($contentUserAccess->is_admin == 2 ? true : false);
                $access['is_owner'] = $isContent ? true : false;
                $access['show_message'] = true;
                $access['is_joined'] = true;
                if($content->is_channel == 0){
                    $access['send_message'] = true;
                }
                else{
                    $access['delete_user']          = $access['is_super_admin'];
                    $access['delete_all_message']   = $access['is_super_admin'];
                    $access['add_user']             = $isContent ? true : ($contentUserAccess->is_admin ? true : false);
                    if($content->is_channel == 2){
                        $access['send_message'] = true;
//                        if($content->chat_status == 2){
//
//                        }
                    }
                    elseif($content->is_channel == 1){
                        $access['send_message'] = $isContent ? true : ($contentUserAccess->is_admin ? true : false);
                    }
                }
            }
            else{
                if(!$content->is_private && $content->is_channel != 0)
                    $access['show_message'] = true;
            }
        }
        return $access;
    }

    public function isUserAccessToComment($id , $userId = '')
    {
        $access = [
            'is_delete' => false,
            'is_edit' => false,
        ];
        if(!$userId)
            $userId = Yii::$app->user->id;
        $comment = Comment::findOne($id);
        if($comment){
            $access['comment'] = $comment;
            $content = Contents::findOne($comment->content_id);
            if ($content) {
                if($content->is_channel == 0){
                    if($userId == $comment->user_id){
                        $access['is_delete']    = true;
                        $access['is_edit']      = true;
                    }
                }
                else{
                    $contentUserAccess = ContentUserAccess::find()
                        ->joinWith(['content as content'])
                        ->alias('t')
                        ->where([
                            'content.is_delete' => 0,
                            'content.is_publish' => 1,
                            'content.is_close' => 0,
                            't.user_id' => $userId,
                            'content.id' => $content->id,
                            'content.cat_id' => 7
                        ])->one();
                    if($content->is_channel == 1) {
                        if(
                            (
                                $contentUserAccess and
                                (
                                    $contentUserAccess->is_admin == 2 or
                                    (
                                        $contentUserAccess->is_admin and
                                        $userId == $comment->user_id
                                    )
                                )
                            ) or $userId == $content->create_user_id
                        ){
                                $access['is_delete']    = true;
                                $access['is_edit']      = true;
                        }
                    }
                    elseif ($content->is_channel == 2){
                        if($userId == $comment->user_id){
                            $access['is_delete']    = true;
                            $access['is_edit']      = true;
                        }
                        elseif(
                            ($contentUserAccess and $contentUserAccess->is_admin == 2) or $userId == $content->create_user_id
                        ){
                            $access['is_delete']    = true;
                        }
                    }
                }
            }
        }
        return $access;
    }


    public function chatActivityDate($userId , $type = 'get')
    {
        $activity = UserChatActivityDate::find()->where(['user_id' => $userId , 'organization_id' => Yii::$app->fcore->getOrganization()])->one();
        if($type == 'get'){
            if($activity){
                $date = $activity->date;
            }
            else{
                $date = '2015-01-01';
            }
            return $date;
        }
        elseif ($type == 'set'){
            if($activity){
                $activity->date = date('Y-m-d H:i:s');
                $activity->save();
            }
            else{
                $activity = new UserChatActivityDate;
                $activity->user_id = $userId;
                $activity->organization_id = Yii::$app->fcore->getOrganization();
                $activity->date = date('Y-m-d H:i:s');
                $activity->save();
            }
        }
    }

    public function isUserAccess($arrayJobTitles,$userId,$academicYear)
    {

        $accessError = Users::userAceess($arrayJobTitles,$userId,array_keys(yii::$app->fcore->getAllOrganization()),$academicYear)['error'];
        if($accessError)
        {
            return false;
        }
        else return true;
    }
    
    public function isMotherOrFather($user_id)
    {
        $result   =   Relationship::find()->where(['relation_user_id' => $user_id])->all();
        if(!empty($result))
        {
            return $result;
        }
        else
        {
            return [];
        }
    }

    public function getAllPersonals($academicYear = false)
    {

        $jobDetail = JobDetail::find()->select('user_id')->where(['IN','organization_id',array_keys(yii::$app->fcore->getAllOrganization())])
            ->andWhere(['academic_year_id' => $academicYear ?  $academicYear : yii::$app->fcore->getAcademicYear()]);
        $profiles  = Profiles::find()->where(['IN', 'user_id', $jobDetail])->orderBy(new \yii\db\Expression('lname COLLATE utf8_persian_ci'))->all();


        return ArrayHelper::map($profiles,'user_id',function($data){
            return $data->lname . ' ' . $data->name;
        }) ;
    }


    public function setUser($data){
        $transaction        = yii::$app->db->beginTransaction();
        $user               = new Users();
        $user->username     = $data['username'];
        $user->status       = 1;
        $user->password     = md5($data['password']);
        $user->unique_key   = Utility::generateUniqueKey();
        $user->email           = empty($data['email'])?'a@a.com':$data['email'];
        if($user->save(true))
        {
            // insert into profile
            $profile                    = new Profiles();
            $profile->user_id           = $user->id;
            $profile->name               = $data['name'];
//            $profile->selected_base_to_child_registration             = $data['selectedBase'];
            $profile->lname               = $data['lname'];
            $profile->is_female         = $data['is_female'];
            $profile->user_type         = $data['user_type'];
//            $profile->followcode_old    = Yii::$app->request->post('password');
            if($profile->save())
            {
                $authAssign = new AuthAssignment;
                $authAssign->userid = $user->id;
                $authAssign->itemname = 'EnterData';
                $authAssign->bizrule = NULL;
                $authAssign->data =  'N;';
                if($authAssign->save(true))
                {
                    $modelProfileDetail = new ProfileDetail;
                    $modelProfileDetail->title                        =    $data['mobile'];
                    $modelProfileDetail->profile_detail_type_id        =    1;//1 is mobile
                    $modelProfileDetail->user_id                    =    $user->id ;
                    $modelProfileDetail->create_user_id             =    $user->id;
                    $modelProfileDetail->create_date                  =    date('Y-m-d H:i:s');
                    $modelProfileDetail->is_default                  =    1;
                    if($modelProfileDetail->save(true))
                    {
                        $modelApprove    =    new Approve;
                        $modelApprove->user_id                 = $user->id ;
                        $modelApprove->approve_type_id         = 3; // 3 is mobile
                        $modelApprove->approve_code         = "1"; // 1
                        $modelApprove->send_type             = 4; // 4 is manual
                        $modelApprove->is_approve             = 1;
                        $modelApprove->profile_detail_id     = $modelProfileDetail->id;
                        if($modelApprove->save(true))
                        {
                            $transaction->commit();
                            $res['user_id'] = $user->id;
                        }else{
                            $transaction->rollBack();
                            $res['error']   =   true;
                            $res['message'] =   'a';
                        }
                    }else{
                        $transaction->rollBack();
                        $res['error']   =   true;
                        $res['message'] =   'b';
                    }
                }else{

                    $transaction->rollBack();
                    $res['error']   =   true;
                    $res['message'] =   'c';
                }
            }else
            {
                $transaction->rollBack();
                $res['error']   =   true;
                $res['message'] =   'd';
            }
        }else
        {
            $transaction->rollBack();
            $res['error']   =   true;
            $res['message'] =   'e';
        }
        return $res;

    }
}

?>