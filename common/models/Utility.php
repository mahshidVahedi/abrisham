<?php
namespace common\components;
use yii;
use backend\models\PersonalConfig;
use backend\models\Relationship;
use backend\models\Profiles;
use backend\models\Users;
use backend\models\Files;
use backend\models\Comment;
use backend\models\Approve;
use backend\models\JobDetail;
use backend\models\Academic;
use backend\models\FinancialAccountOrganization;
use backend\models\SmsPanels;

class Utility {

    private $arrayCount = 0;

    public static function checkNationalCode($code)
    {
        if(!preg_match('/^[0-9]{10}$/',$code)){
            return false;
        }
        for( $i=0; $i<10; $i++ )
            if( preg_match('/^'.$i.'{10}$/',$code) )
                return false;
            for( $i=0,$sum=0; $i<9; $i++ )
            $sum += ((10-$i) * intval(substr($code, $i,1)) );
        $ret = $sum % 11;
        $parity = intval( substr($code, 9,1) );
        if( ($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
        return false;
    }

    public static function checkMobileNumber($mobileNumber)
    {
        if(!preg_match('/^09[0-9]{9}$/',$mobileNumber)){
            return false;
        }else
            return true;

    }

    public static function generateRandomString($length = 10, $onlyDigits = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($onlyDigits)
            $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function explodText($input ,$indexWanted,$delimiter='_')
    {
        $exp = explode($delimiter,$input);
        if(array_key_exists($indexWanted,$exp))
        {
            return $exp[$indexWanted];
        }
        else return false;
    }

    public static function convertDateToJalali($gregorianDate,$outputSepretor = '-',$returnAsArray = false)
    {
        if(strpos($gregorianDate,'-') !== false)
        {
            $date = explode('-',$gregorianDate);
        }
        else if(strpos($gregorianDate,'/') !== false)
        {
            $date = explode('/',$gregorianDate);
        }
        else die('فرمت تاریخ معتبر نیست!');

        $arrDate = yii::$app->jdate->toJalaliDate($date[0],$date[1],$date[2]);
        return $returnAsArray ? $arrDate : implode($outputSepretor,$arrDate);
    }

    public static function convertDateToGregorian($jalaliDate,$outputSepretor = '-',$returnAsArray = false)
    {
        if(strpos($jalaliDate,'-') !== false)
        {
            $date = explode('-',$jalaliDate);
        }
        else if(strpos($jalaliDate,'/') !== false)
        {
            $date = explode('/',$jalaliDate);
        }
        else die('فرمت تاریخ معتبر نیست!');

        $arrDate = yii::$app->jdate->toGregorian($date[0],$date[1],$date[2]);
        return $returnAsArray ? $arrDate : implode($outputSepretor,$arrDate);
    }

    public static function sendSMS($text,$moblie ,$from = '2166522500' , $returnType = '' , $organization = 0)
    {
        if(!$organization)
            $organization = yii::$app->fcore->getOrganization();

        $smsPanel = SmsPanels::find()->where(['organization_id' => $organization,'is_default' => 1])->one();
        if($smsPanel)
        {
            $username = $smsPanel->username;
            $password = $smsPanel->password;
            $number   = $smsPanel->number;

            switch($smsPanel->sms_panel_api_id)
            {
                case '1': //melli payamak
                    ini_set("soap.wsdl_cache_enabled", "0");
                    try
                    {
                        $parameters['username'] = $username ;
                        $parameters['password'] = $password ;
                        $parameters['from'] = $number ;
                        $parameters['to'] = array($moblie);
                        $parameters['text'] = $text;
                        $parameters['isflash'] = false;
                        $parameters['udh']     = "";
                        $parameters['recId']   = array(0);
                        $parameters['status']  = 0x0;

                        $client = Yii::$app->siteApi;
                        $credit    =    $client->GetCredit(array("username"=>$parameters['username'],"password"=>$parameters['password']))->GetCreditResult;
                        if($credit    > 5 )
                        {
                            $ret       = $client->SendSms($parameters);
                            $recId     = $ret->recId->long;
                            $ret       = $ret->SendSmsResult;
                            if($returnType == 'total'){
                                return ['status' => $ret , 'recId' => $recId];
                            }
                            elseif($ret    ==    1)
                            {
                                if($returnType == 'total'){
                                    return $recId;
                                }
                                else
                                    return 'SUC';
                            }
                            else
                            {
                                return 'ERR';
                            }
                        }
                        else
                        {
                            return 'NEC';
                        }

                        //echo $status;
                    }
                    catch (SoapFault $ex)
                    {
                        return 'ERR';
                        echo $ex->faultstring;
                    }
                break;

                //*******************************************

                case '2': // tiba sms
                    $toNum      = array($moblie);
                    ini_set("soap.wsdl_cache_enabled", "0");
                    try
                    {
                        $client = Yii::$app->tibaSmsApi;
                        $credit    =    $client->GetCredit($username,$password);
                        if($credit    > 5 )
                        {

                            $status = $client->SendSMS($number,$toNum,$text,$username,$password,'',"send");
                            if($status)
                                return 'SUC';
                        }
                        else
                        {
                            return 'NEC';
                        }

                        //echo $status;
                    }
                    catch (SoapFault $ex)
                    {
                        //return 'ERR';
                        echo $ex->faultstring;
                    }
                break;

                //*******************************************

            }

        }
        else return 'ERR';
    }

    public static function getSmsCredit($organizationId)
    {
        $smsPanel = SmsPanels::find()->where(['organization_id' => $organizationId,'is_default' => 1])->one();
        if($smsPanel)
        {
            $username = $smsPanel->username;
            $password = $smsPanel->password;
            ini_set("soap.wsdl_cache_enabled", "0");
            try
            {
                $parameters['password'] = $password;
                $parameters['username'] = $username;

                $client = Yii::$app->siteApi;
                $result = $client->GetCredit($parameters)->GetCreditResult;

                return $result;
            }
            catch (SoapFault $ex)
            {
                return NULL;
            }
        }
        else  return NULL;
    }


    public static function getDeliverySms($ids , $organizationId)
    {


        $smsPanel = SmsPanels::find()->where(['organization_id' => $organizationId,'is_default' => 1])->one();
        if($smsPanel)
        {
            $username = $smsPanel->username;
            $password = $smsPanel->password;
            ini_set("soap.wsdl_cache_enabled", "0");
            try
            {
                $parameters['password'] = $password;
                $parameters['username'] = $username;
                $parameters['recIds'] = $ids;

                $client = Yii::$app->siteApi;
                $result = $client->GetDeliveries($parameters)->GetDeliveriesResult->int;

                return $result;

                //echo $status;
            }
            catch (SoapFault $ex)
            {
                return 'ERR';
                //echo $ex->faultstring;
            }
        }
        else  return 'ERR';
    }

    public static    function sendSMSForceApprove($text,$moblie='9337192916' )  // sendSMSForceByBodyId  اضافه شد
    {
        $orgId     =    yii::$app->fcore->getOrganization();
        if($orgId == 1){
            $bodyId =    5246;
            //$bodyUrl =    "hedayatmizan.ir";
        }elseif($orgId == 22){
            $bodyId =    5249;
            //$bodyUrl =    "mizanedu.com";
        }
        elseif($orgId == 35){
            $bodyId =    5250;
            //$bodyUrl =    "tazkieh2.com";
        }
        elseif($orgId == 28){
            $bodyId =    5247;
            //$bodyUrl =    "meshkatedu.ir";
        }
        elseif($orgId == 49){
            $bodyId =    5248;
            //$bodyUrl =    "arefantoos.ir";
        }
        elseif($orgId == 43){
            $bodyId =    9265;
            //$bodyUrl =    "monjiischool.com";
        }
        else{
            $bodyId =    5251;
            //$bodyUrl =    "erpx.ir";
        }




        // if(!is_array($moblie))
        // $moblie = array($moblie);
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = Yii::$app->smsForceApi;
            $parameters['username'] = "hedayat.mizan";
            $parameters['password'] = "School1376@";
            $parameters['to'] = $moblie;
            $parameters['text'] = $text;
            $parameters['bodyId'] = $bodyId;
            $credit    =    $client->GetCredit(array("username"=>"hedayat.mizan","password"=>"School1376@"))->GetCreditResult;
            if($credit    >5){
                $ret    = $client->SendByBaseNumber($parameters)->SendByBaseNumberResult;
                if(    is_numeric( $ret)){
                    return 'SUC';
                }else{
                    return 'ERR';
                }
            }else{
                return 'NEC';
            }

            //echo $status;
        } catch (SoapFault $ex) {
            return 'ERR';
            //echo $ex->faultstring;
        }

    }

    public static    function sendSMSForce($text,$moblie='9337192916' )  // sendSMSForceByBodyId  اضافه شد
    {
        $orgId     =    yii::$app->fcore->getOrganization();
        if($orgId == 1){
            $bodyId =    4984;
            //$bodyUrl =    "hedayatmizan.ir";
        }elseif($orgId == 22){
            $bodyId =    4987;
            //$bodyUrl =    "mizanedu.com";
        }
        elseif($orgId == 35){
            $bodyId =    4986;
            //$bodyUrl =    "tazkieh2.com";
        }
        elseif($orgId == 28){
            $bodyId =    4985;
            //$bodyUrl =    "meshkatedu.ir";
        }
        elseif($orgId == 49){
            $bodyId =    5243;
            //$bodyUrl =    "meshkatedu.ir";
        }
        elseif($orgId == 43){
            $bodyId =    7502;
            //$bodyUrl =    "meshkatedu.ir";
        }
        else{
            $bodyId =    5244;
            //$bodyUrl =    "meshkatedu.ir";
        }




        // if(!is_array($moblie))
        // $moblie = array($moblie);
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = Yii::$app->smsForceApi;
            $parameters['username'] = "hedayat.mizan";
            $parameters['password'] = "School1376@";
            $parameters['to'] = $moblie;
            $parameters['text'] = $text;
            $parameters['bodyId'] = $bodyId;
            $credit    =    $client->GetCredit(array("username"=>"hedayat.mizan","password"=>"School1376@"))->GetCreditResult;
            if($credit    >5){
                $ret    = $client->SendByBaseNumber($parameters)->SendByBaseNumberResult;
                if(    is_numeric( $ret)){
                    return 'SUC';
                }else{
                    return 'ERR';
                }
            }else{
                return 'NEC';
            }

            //echo $status;
        } catch (SoapFault $ex) {
            return 'ERR';
            //echo $ex->faultstring;
        }

    }

    public static    function sendSMSForceByBodyId($text,$moblie='9337192916',$bodyId)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = Yii::$app->smsForceApi;
            $parameters['username'] = "hedayat.mizan";
            $parameters['password'] = "School1376@";
            $parameters['to']       = $moblie;
            $parameters['text']     = $text;
            $parameters['bodyId']   = $bodyId;
            $credit    =    $client->GetCredit(array("username"=>"hedayat.mizan","password"=>"School1376@"))->GetCreditResult;
            if($credit > 5 )
            {
                $ret    = $client->SendByBaseNumber($parameters)->SendByBaseNumberResult;
                if(    is_numeric( $ret))
                {
                    return 'SUC';
                }else
                {
                    return 'ERR';
                }
            }
            else
            {
                return 'NEC';
            }

            //echo $status;
        } catch (SoapFault $ex) {
            return $ex->faultstring;
        }

    }

    public static function maskEmail($email)
    {
        $em   = explode("@",$email);
        $name = implode(array_slice($em, 0, count($em)-1), '@');
        $len  = floor(strlen($name)/2);

        return substr($name,0, $len) . str_repeat('×', $len) . "@" . end($em);
    }

    public static function maskMobile($number)
    {
        return substr($number, 0, 4) . '××××' . substr($number,  -4);
    }

    public static function generateUniqueKey()
    {
        $randStr = self::generateRandomString(5);
        $user    = Users::find()->where(['unique_key' => $randStr])->one();
        if($user)
            self::generateUniqueKey();
        else return $randStr;
    }

    public static function generateUniqueKeyForApprove($profileDetailId)
    {
        $randStr = self::generateRandomString(4,true);
        $approve    = Approve::find()->where(['approve_code' => $randStr    ,    'profile_detail_id'    =>$profileDetailId])->one();
        if($approve)
            self::generateUniqueKeyForApprove($profileDetailId);
        else return $randStr;
    }

    public static function in_array_nested($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item)
        {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_nested($needle, $item, $strict)))
            {
                return true;
            }
        }
        return false;
    }

    public static function in_array_nested_count($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item)
        {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_nested($needle, $item, $strict)))
            {
                $this->arrayCount++;
            }
            else return false;
        }
        return $this->arrayCount++;
    }


    public static function changeTagAttributeInHtmlStringTags($stringHtmlTags,$tagName,$attribute,$value)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($stringHtmlTags);

        $result = '';
        foreach ($dom->getElementsByTagName($tagName) as $item) {

            $item->setAttribute($attribute, $value);
            $result .= $dom->saveHTML();
        }
        return $result;
    }

    public static function getLastNotNullValueInArray($array)
    {
        $reversed = array_reverse($array);
        foreach($reversed as $arrValue)
        {
            if($arrValue)
                return  $arrValue;
        }
        return false;
    }

    public static function getThumbPic($fileId , $scale = 50 , $quality = 50 , $resultType = 'blob')
    {
        try{
            $file = Files::findOne($fileId);
            if($file->files_type_id == 26){
                $fileP = Files::findOne($file->content_id);
                if($fileP)
                    $commentId = $fileP->comment_id;
            }
            if(empty($commentId))
                $commentId = $file->comment_id;
            $comment = Comment::findOne($commentId);
            $thumb = Files::find()->where(['files_type_id' => 26 , 'content_id' => $file->id])->one();
            if(!$thumb){
                $mime = '';
                $name = $file->fake_name;
                $explode = explode('.',$file->fake_name);
                $imageDir = '';
                if(count($explode) >= 2){
                    $mime = '.'.$explode[count($explode)-1];
                    unset($explode[count($explode)-1]);
                    $name = implode($explode , '.');
                }

                if(is_file(Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name)){
                    $imageDir = Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name;
                }
                elseif(is_file(Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name.$mime)){
                    $imageDir = Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name.$mime;
                }
                $im = new \Imagick();
                $im->readImageBlob(file_get_contents($imageDir));
                if($scale)
                    $im->scaleImage($scale, $scale, true);
                $im->setImageCompressionQuality($quality);
                $thumbFakeName = uniqid().".jpg";
                $mime = '';
                $name = $thumbFakeName;
                //            $explode = explode('.',$file->fake_name);
                //            $thumbDir = '';
                //            if(count($explode) >= 2){
                //                $mime = '.'.$explode[count($explode)-1];
                //                unset($explode[count($explode)-1]);
                //                $name = implode($explode , '.');
                //            }

                $thumbDir = Yii::getAlias('@filesDir') . '/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name;
                $im->writeImage ($thumbDir);
                if(is_file($thumbDir)){
                    $thumb = new Files;
                    $thumb->main_name = 'thumb.jpg';
                    $thumb->fake_name = $thumbFakeName;
                    $thumb->size = $im->getImageLength();
                    $thumb->user_id = $file->user_id;
                    $thumb->files_type_id = 26;
                    $thumb->type = 'image/jpeg';
                    $thumb->is_file_view = 0;
                    $thumb->create_date = date('Y-m-d H:i:s');
                    $thumb->content_id = $file->id;
                    $thumb->save();
                }
            }
            else{
                $mime = '';
                $name = $thumb->fake_name;
                $explode = explode('.',$thumb->fake_name);
                $thumbDir = '';
                if(count($explode) >= 2){
                    $mime = '.'.$explode[count($explode)-1];
                    unset($explode[count($explode)-1]);
                    $name = implode($explode , '.');
                }
                if(is_file(Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name)){
                    $thumbDir = Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name;
                }
                elseif(is_file(Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name.$mime)){
                    $thumbDir = Yii::getAlias('@filesDir').'/'.$comment->content->create_user_id.'/'.$comment->content_id.'/comment/'.$comment->user_id.'/'.$name.$mime;
                }
                else{
                    $thumb->delete();
                    return Utility::getThumbPic($fileId , $scale , $quality , $resultType);
                }

            }
            if($thumb){

                if($resultType == 'blob'){
                    //             if(Yii::$app->user->id == 8){
                    //                echo $thumbDir . '<br>';
                    //                return '';
                    //            }

                    $im = new \Imagick($thumbDir);
                    //                $im->blurImage(5,3);
                    return $im->getimageblob();
                }
                elseif($resultType == 'url')
                    return '/backend/web/users/getfile2?fileId='.$thumb->id;
            }
            //        return '';
            //
        }
        catch(\Exception $e){
            return '';
        }
    }
    public static function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'n') !== false)
            $sets[] = 'b';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }


    public static function sendEmail($user,$password,$org){
        $email     =     $user->email;
        $lname     =     $user->profiles->lname;
        $mailUrl    =    explode('.' , $_SERVER['HTTP_HOST']);
        if($mailUrl[0]    ==    'www'){
            $first        =    $mailUrl[1];
            $second        =    $mailUrl[2];
        }else{
            $first        =    $mailUrl[0];
            $second        =    $mailUrl[1];
        }

        if($first != 'g'){
            $urlPublicYii2    =    'https://new.'.$first.'.'.$second    ;

        }else{
            $urlPublicYii2    =    'https://gnew'.$first.'.'.$second   ;
        }
        $urlPublic = $urlPublicYii2;
        $aparat        =    $org->organization->aparat_url;
        $bale          =    $org->organization->bale_url;
        $twiter        =    $org->organization->twiter_url;
        $telegram      =    $org->organization->telegram_url;
        $instagaram     =    $org->organization->instagaram_url;
        $sorosh          =    $org->organization->sorosh_url;
        $infoEmail      =    $org->organization->info_email;

        $infoTel      =    $org->organization->password_tel;
        if( $org->organization->password_sub_tel != '')
            $infoTel      .=    ' ('.$org->organization->password_sub_tel.')';

        $followHtml    =   '<tr>
        <td>

        <h5 class="">ما را دنبال کنيد:</h5>
        <p class="">
        ';

        if(!empty($aparat))
            $followHtml    .= '<a href="'.$aparat.'" class="soc-btn gp">آپارات</a>';

        if(!empty($telegram))
            $followHtml    .= '<a href="'.$telegram.'" class="soc-btn fb">تلگرام</a>';

        if(!empty($bale))
            $followHtml    .= '<a href="'.$bale.'" class="soc-btn gp">بله</a>';

        if(!empty($twiter))
            $followHtml    .= '<a href="'.$twiter.'" class="soc-btn fb">تویتر</a>';

        if(!empty($instagaram))
            $followHtml    .= '<a href="'.$instagaram.'" class="soc-btn fb">اینستاگرام</a>';

        if(!empty($sorosh))
            $followHtml    .= '<a href="'.$sorosh.'" class="soc-btn fb">سروش</a>';





        $followHtml    .=     '</p></td>  </tr>';

        $urlImage       =    $urlPublic.'/frontend_theme/'.$org->organization_id.'/images/logo-main.png';


        $checkEmail        =    true;
        $exsiteEmail    =    true;

        if($email        ==    'a@a.com' or $email ==''){
            $exsiteEmail    =    false;
        }
        if($exsiteEmail == false){
            return false;
        }else{

            if($exsiteEmail){
                // Yii::app()->mailer->Host = 'mail.hedayatmizan.ir';
                // Yii::app()->mailer->IsSMTP();
                // Yii::app()->mailer->From = 'admin@hedayatmizan.ir';
                // Yii::app()->mailer->FromName = 'میزان';
                // Yii::app()->mailer->CharSet = 'UTF-8';
                // Yii::app()->mailer->getView('change_password' ,array('lname' => $lname,'password'=>$password),'main');
                // Yii::app()->mailer->IsHTML(true);
                // Yii::app()->mailer->AddAddress($email);
                // Yii::app()->mailer->Subject = 'تغییر گذرواژه';
                // $res    =    Yii::app()->mailer->Send();
                $msg = '"<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta name="viewport" content="width=device-width" />

                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title></title>

                <link rel="stylesheet" type="text/css" href="'. yii::getAlias('@yii1Url').'/frontend/main/css/mail/email.css" />
                <style>
                * {
                margin:0;
                padding:0;
                direction : rtl;
                font-family:tahoma !important;
                }
                * { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

                img {
                max-width: 100%;
                float: right;
                }
                .collapse {
                margin:0;
                padding:0;
                }
                body {
                -webkit-font-smoothing:antialiased;
                -webkit-text-size-adjust:none;
                width: 100%!important;
                height: 100%;
                }


                a { color: #2BA6CB;}

                .btn {
                text-decoration:none;
                color: #FFF;
                background-color: #666;
                padding:10px 16px;
                font-weight:bold;
                margin-right:10px;
                text-align:center;
                cursor:pointer;
                display: inline-block;
                }

                p.callout {
                padding:15px;
                background-color:#ECF8FF;
                margin-bottom: 15px;
                }
                .callout a {
                font-weight:bold;
                color: #2BA6CB;
                }

                table.social {

                background-color: #ebebeb;

                }
                .social .soc-btn {
                padding: 3px 7px;
                font-size:12px;
                margin-bottom:10px;
                text-decoration:none;
                color: #FFF;font-weight:bold;
                display:block;
                text-align:center;
                }
                a.fb { background-color: #3B5998!important; }
                a.tw { background-color: #1daced!important; }
                a.gp { background-color: #DB4A39!important; }
                a.ms { background-color: #000!important; }

                .sidebar .soc-btn {
                display:block;
                width:100%;
                }

                table.head-wrap { width: 100%;}

                .header.container table td.logo { padding: 15px; }
                .header.container table td.label { padding: 15px; padding-left:0px;}


                table.body-wrap { width: 100%;}



                table.footer-wrap { width: 100%;    clear:both!important;
                }
                .footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
                .footer-wrap .container td.content p {
                font-size:10px;
                font-weight: bold;

                }


                h1,h2,h3,h4,h5,h6 {
                font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
                }
                h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

                h1 { font-weight:200; font-size: 44px;}
                h2 { font-weight:200; font-size: 37px;}
                h3 { font-weight:500; font-size: 27px;}
                h4 { font-weight:500; font-size: 23px;}
                h5 { font-weight:900; font-size: 17px;}
                h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

                .collapse { margin:0!important;}

                p, ul {
                margin-bottom: 10px;
                font-weight: normal;
                font-size:14px;
                line-height:1.6;
                }
                p.lead { font-size:17px; }
                p.last { margin-bottom:0px;}

                ul li {
                margin-left:5px;
                list-style-position: inside;
                }


                ul.sidebar {
                background:#ebebeb;
                display:block;
                list-style-type: none;
                }
                ul.sidebar li { display: block; margin:0;}
                ul.sidebar li a {
                text-decoration:none;
                color: #666;
                padding:10px 16px;

                margin-right:10px;

                cursor:pointer;
                border-bottom: 1px solid #777777;
                border-top: 1px solid #FFFFFF;
                display:block;
                margin:0;
                }
                ul.sidebar li a.last { border-bottom-width:0px;}
                ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}





                .container {
                display:block!important;
                max-width:600px!important;

                clear:both!important;
                }


                .content {
                padding:15px;
                max-width:600px;
                margin:0 auto;
                display:block;
                }


                .content table { width: 100%; }


                .column {
                width: 300px;
                float:left;
                }
                .column tr td { padding: 15px; }
                .column-wrap {
                padding:0!important;
                margin:0 auto;
                max-width:600px!important;
                }
                .column table { width:100%;}
                .social .column {
                width: 280px;
                min-width: 279px;
                float:left;
                }


                .clear { display: block; clear: both; }



                @media only screen and (max-width: 600px) {

                a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

                div[class="column"] { width: auto!important; float:none!important;}

                table.social div[class="column"] {
                width:auto!important;
                }

                }
                .num{
                float:left;
                direction:ltr;
                }
                </style>

                </head>

                <body bgcolor="#FFFFFF">

                <!-- HEADER -->
                <table class="head-wrap" bgcolor="#999999">
                <tr>
                <td></td>
                <td class="header container" >

                <div class="content">
                <table bgcolor="#999999">
                <tr>
                <td><img src="'.$urlImage .'" /></td>
                <td align="right"><h6 class="collapse">&nbsp;</h6></td>
                </tr>
                </table>
                </div>

                </td>
                <td></td>
                </tr>
                </table><!-- /HEADER -->
                <!-- BODY -->
                <table class="body-wrap">
                <tr>
                <td></td>
                <td class="container" bgcolor="#FFFFFF">
                <div class="content">
                <table>
                <tr>
                <td>
                <h3>سلام، '.$lname .' عزيز</h3>
                <p class="lead">گذرواژه شما با موفقيت تغيير کرد.</p>
                <p>گذرواژه شما: </p>
                <p>    '. $password .'</p>
                <!-- Callout Panel
                <p class="callout">
                Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae. <a href="#">Click it! &raquo;</a>
                </p><!-- /Callout Panel -->

                <!-- social & contact -->
                <table class="social" width="100%">
                <tr>
                <td>

                <!-- column 1 -->
                <table align="left" class="column">
                '. $followHtml.'
                </table><!-- /column 1 -->

                <!-- column 2 -->
                <table align="left" class="column">
                <tr>
                <td>

                <h5 class="">اطلاعات تماس:</h5>
                <p>تلفن: <strong class="num">'. yii::$app->fstring->translateDigits($infoTel).'</strong><br/>
                ايميل: <strong><a href="'.$infoEmail.'" class="num">'.$infoEmail.'</a></strong></p>

                </td>
                </tr>
                </table><!-- /column 2 -->

                <span class="clear"></span>

                </td>
                </tr>
                </table><!-- /social & contact -->

                </td>
                </tr>
                </table>
                </div><!-- /content -->

                </td>
                <td></td>
                </tr>
                </table><!-- /BODY -->


                <!-- FOOTER -->
                <table class="footer-wrap">
                <tr>
                <td></td>
                <td class="container">

                <!-- content -->
                <div class="content">
                <table>
                <tr>
                <td align="center">
                <p>
                <a href="'. yii::getAlias('@yii1Url') .'">تيم ما</a> |
                <a href="'. yii::getAlias('@yii1Url') .'">حريم شخصي</a> |
                <a href="'. yii::getAlias('@yii1Url') .'"><unsubscribe>لغو ارسال</unsubscribe></a>
                </p>
                </td>
                </tr>
                </table>
                </div><!-- /content -->

                </td>
                <td></td>
                </tr>
                </table><!-- /FOOTER -->
                </body>
                </html>
                ';

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $res=    mail($email,"تغییر گذرواژه",$msg,$headers);



            }


        }

    }
    public static function timeToSec ($time){
        $seconds = 0;
        $time = explode(':' , $time);
        if($time[0])
            $seconds += $time[0]*60*60;
        if($time[1])
            $seconds += $time[1]*60;
        if($time[2])
            $seconds += $time[2];
        return $seconds;
    }
    public static function secToTime ($time , $withSec = false){
        $t[0] = str_pad(floor($time/(60*60)), 2, '0', STR_PAD_LEFT);
        $t[1] = str_pad(floor(($time - $t[0]*60*60)/60), 2, '0', STR_PAD_LEFT);
        if($withSec)
            $t[2] = str_pad(round($time - $t[0]*60*60 - $t[1]*60), 2, '0', STR_PAD_LEFT);
        return implode(':',$t);
    }

    function getOrganizationForUser($userId , $academicYear){
        $res =    $this->getOrganizationForUserPartner($userId,'title' , $academicYear);
        if($res    ==    false){
            $res =    $this->getOrganizationForUserParent($userId,'title' , $academicYear);
            if($res    ==    false){
                $res =    $this->getOrganizationForUserAcademic($userId,'title',1 , $academicYear);
                if($res    ==    false){
                    return '--';
                }else
                    return '<small>'.'دانش آموز'.' '.$res.'</small> ';
            }else{
                return '<small>'.'والدین'.' '.$res.'</small> ';
            }
        }else
            return '<small>'.'همکار محترم'.' '.$res.'</small> ';

    }
    function getOrganizationForUserPartner($userId,$field,$academicYear){
        $findJobDetail    =     PersonalConfig::find()->where(['user_id' => $userId , 'academic_year_id' => $academicYear , 'organization_id' => Yii::$app->fcore->getOrganization()])->orderBy("id desc")->one();
        if($findJobDetail){
            if($field == 'id'){
                if( !empty($findJobDetail->organization_id) ) {
                    if ($findJobDetail->organization->organization_id == 0)
                        return $findJobDetail->organization->$field;
                    else
                        return $findJobDetail->organization->organization->$field;
                }
                else
                    return false;

            }
            else{

                if( !empty($findJobDetail->organization_id) ) {
                    if ($findJobDetail->organization->organization_id == 0)
                        return $this->showProfileName($userId ,true,true).' ('.$findJobDetail->organization->$field .')';
                    else
                        return $this->showProfileName($userId ,true,true).' ('.$findJobDetail->organization->organization->$field.')';
                }
                else
                    return false;
            }
        }
        else{
            return false;
        }
    }
    function getOrganizationForUserParent($userId,$field,$academicYear){
        $findRelationship    =     Relationship::find()->where(['relation_user_id' => $userId, 'is_deleted' => 0])->orderBy("id desc")->all();
        if($findRelationship){
            $totalRes = [];
            foreach ($findRelationship as $item) {
                $res    =    $this->getOrganizationForUserAcademic($item->user_id,$field,1,$academicYear);
                if($res    ==    false)
                    $totalRes[] =     $this->getOrganizationForUserPartner($item->user_id,$field,$academicYear);
                else
                    $totalRes[] =     $res;
            }
            return implode(' - ' , $totalRes);
        }else{
            return false;
        }
    }
    function getOrganizationForUserAcademic($userId,$field,$append = 0,$academicYear){
        $findAcademic    =     Academic::find()->where(['user_id' => $userId , 'deleted' => 0 , 'academic_year_id' => $academicYear])->andWhere(['in' , 'status' , [1,4,16,18,19,20]])->andWhere(['in' , 'organization_id' , array_keys(Yii::$app->fcore->getAllOrganization())])->orderBy("id desc")->one();
        if($findAcademic){
            if($append  ===  0)
                return  $findAcademic->organization->organization->$field;
            else {
                if($findAcademic->field_id == 2)
                    return  '('.$findAcademic->organization->small_title  . ' - پایه ' . $findAcademic->base->title.') '.$this->showProfileName($findAcademic->user_id ,true);
                else
                    return '('.$findAcademic->organization->small_title . ' - پایه ' . $findAcademic->base->title.'- رشته ' .$findAcademic->field->title.') '.$this->showProfileName($findAcademic->user_id ,true);
            }
        }else
            return false;
    }
    function showProfileName($userId , $isReal= false ,$onlyLname = false){
        $modelProfile                =    Profiles::find()->where(array('user_id' => $userId ))->one();
        $name   ='';
        if(!empty($modelProfile  )){
            if($isReal == false){
                if($onlyLname == false)
                    $name    =    (!empty($modelProfile->alais_name))?$modelProfile->alais_name:$modelProfile->name . ' ' .$modelProfile->lname ;
                else
                    $name    =    (!empty($modelProfile->alais_name))?$modelProfile->alais_name:$modelProfile->lname ;

            }else{
                if($onlyLname == false)
                    $name    =    $modelProfile->name . ' ' .$modelProfile->lname ;
                else
                    $name    =    $modelProfile->lname ;
            }

        }
        return  $name ;
    }

}
