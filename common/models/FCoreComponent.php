<?php
namespace common\components;

use backend\models\Academic;
use backend\models\AcademicToZoneAcademicYearDetail;
use backend\models\AcademicYear;
use backend\models\ConnectToGatewayBank;
use backend\models\ContentToOrganizationBaseFieldDetail;
use backend\models\FinancialDocumentDetail;
use backend\models\FinancialDocuments;
use backend\models\Organization;
use backend\models\OrganizationUrl;
use backend\models\Payment;
use backend\models\PaymentGateways;
use backend\models\Profiles;
use backend\models\Sms;
use backend\models\SmsBody;
use backend\models\SmsSend;
use backend\models\TuitionsToFinancialHeadingDetail;
use backend\models\Zones;
use common\models\LoginForm;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class FCoreComponent extends Component
{
    public $zoneTitle = '';

    public function getImageTagUrl($tagCvId, $image)
    {
        $path = __DIR__ . '/../../../server/php/files/tagcv/' . $tagCvId . '/' . $image;
        if (file_exists($path)) {
            $url = yii::getAlias('@yii1Url') . '/server/php/files/tagcv/' . $tagCvId . '/' . $image;

        } else
            $url = yii::getAlias('@yii1Url') . '/backend/web/nadiya_assets/images/small/plus.png';


        return $url;
    }

    public function getTagCvFolder($tagCvId)
    {

        $basePath = Yii::getAlias('@filesDir');
        $dir = $basePath . '/tagcv/';
        if (!is_dir($dir))
            mkdir($dir, 0777);

        $dir = $basePath . '/tagcv/' . $tagCvId;
        if (!is_dir($dir))
            mkdir($dir, 0777);


        return $dir;
    }

    public function getAcademicFolder($userId, $academicId)
    {

        $basePath = Yii::getAlias('@filesDir');
        $dir = $basePath . "/$userId/";
        if (!is_dir($dir))
            mkdir($dir, 0777);

        $dir = $basePath . "/$userId/profile/";
        if (!is_dir($dir))
            mkdir($dir, 0777);

        $dir = $basePath . "/$userId/profile/$academicId";
        if (!is_dir($dir))
            mkdir($dir, 0777);


        return $dir;
    }

    public function getProfileFolder($userId)
    {

        $basePath = Yii::getAlias('@filesDir');
        $dir = $basePath . "/$userId/";
        if (!is_dir($dir))
            mkdir($dir, 0777);

        $dir = $basePath . "/$userId/profile";
        if (!is_dir($dir))
            mkdir($dir, 0777);


        return $dir;
    }

    public function getImageAcademicUrl($userId, $academicId, $image)
    {

        $path = __DIR__ . "/../../../server/php/files/$userId/profile/$academicId/" . $image;
        if (file_exists($path) && $image) {
            $url = yii::getAlias('@yii1Url') . "/server/php/files/$userId/profile/$academicId/" . $image;
        } else {
            $academic = Academic::findOne($academicId);
            $url = $academic->profile->is_female ? yii::getAlias('@yii1Url') . '/server/php/files/images/female_avatar.jpg' : yii::getAlias('@yii1Url') . '/server/php/files/images/male_avatar.jpg';
            //             $url    =     yii::getAlias('@yii1Url') .'/backend/web/nadiya_assets/images/no_pic.jpg';
        }


        return $url;
    }

    public function getUserImageProfileUrl($userId, $image, $type = 'profile')
    {
        if ($type == 'profile') {
            $path = __DIR__ . "/../../../server/php/files/$userId/profile/" . $image;
            if (file_exists($path)) {
                $url = yii::getAlias('@yii1Url') . "/server/php/files/$userId/profile/" . $image;

            } else
                $url = yii::getAlias('@yii1Url') . '/backend/web/nadiya_assets/images/no_pic.jpg';
        } elseif ($type == 'attach') {
            $path = __DIR__ . "/../../../server/php/files/$userId/profile/attachs/" . $image;
            if (file_exists($path)) {
                $url = yii::getAlias('@yii1Url') . "/server/php/files/$userId/profile/attachs/" . $image;

            } else
                $url = yii::getAlias('@yii1Url') . '/backend/web/nadiya_assets/images/no_pic.jpg';
        } else {
            $path = __DIR__ . "/../../../server/php/files/$userId/profile/" . $image;
            if (file_exists($path)) {
                $url = yii::getAlias('@yii1Url') . "/server/php/files/$userId/profile/" . $image;

            } else
                $url = yii::getAlias('@yii1Url') . '/backend/web/nadiya_assets/images/no_pic.jpg';

        }

        return $url;
    }


    public function getUserImageUrl($userId, $academicId, $image)
    {
        $path = __DIR__ . "/../../../server/php/files/$userId/profile/$academicId/" . $image;
        if (file_exists($path)) {
            $url = yii::getAlias('@yii1Url') . "/server/php/files/$userId/profile/$academicId/" . $image;

        } else
            $url = yii::getAlias('@yii1Url') . '/backend/web/nadiya_assets/images/no_pic.jpg';


        return $url;
    }

    public function maintenance()
    {
        $urlPublicYii2 = Yii::getAlias('@yii2Url');
        $url = $urlPublicYii2 . '/backend/web/site/bridge?url=users/maintenance';
        header('Location: ' . $url);
        die;
    }

    public function getZarinpalErrors($id)
    {
        switch ($id) {
            case '-1':
                return 'اطلاعات ارسال شده ناقص است.';
                break;
            case '-2':
                return 'آی پی یا مرچنت کد پذیرنده صحیح نیست';
                break;
            case '-3':
                return 'با توجه به محدودیت های شاپرک امکان پرداخت با رقم درخواست شده میسر نمی باشد.';
                break;
            case '-4':
                return 'سطح تایید پذیرنده پایین تر از صطح نقره ای است.';
                break;
            case '-11':
                return 'درخواست مورد نظر یافت نشد.';
                break;
            case '-12':
                return 'امکان ویرایش درخواست میسر نمی باشد.';
                break;
            case '-21':
                return 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد.';
                break;
            case '-22':
                return 'تراکنش نا موفق می باشد.';
                break;
            case '-33':
                return 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد.';
                break;
            case '-34':
                return 'سقف تقسیم تراکنش از لحاظ تعداد با رقم عبور نموده است.';
                break;
            case '-40':
                return 'اجازه دسترسی به متد مربوطه وجود ندارد.';
                break;
            case '-41':
                return 'اطلاعات ارسال شده مربوط به AdditionalData غیر معتر می باشد.';
                break;
            case '-42':
                return 'مدت زمان معتبر طول عمر شناسه پرداخت بین 30 دقیقه تا 40 روز می باشد.';
                break;
            case '-54':
                return 'درخواست مورد نظر آرشیو شده است.';
                break;
            case '100':
                return 'عملیات با موفقیت انجام گردیده است.';
                break;
            case '101':
                return 'عملیات پرداخت موفق بوده و قبلا Payment Verification تراکنش انجام شده است';
                break;
            default:
                return $id;
                break;
        }
    }

    public function getSepGateWayErrorsBeforeVerify($ResCode = '')
    {
        switch ($ResCode) {
            case '-1':
                $prompt = "تراکنش توسط خریدار کنسل شده است.";
                break;
            case '79':
                $prompt = "مبلغ سند برگشتی، از مبلغ تراکنش اصلی بیشتر است.";
                break;
            case '12':
                $prompt = "درخواست برگشت یک تراکنش رسیده است، در حالی که تراکنش اصلی پیدا نمیشود.";
                break;
            case '14':
                $prompt = "شماره کارت نامعتبراست.";
                break;
            case '15':
                $prompt = "چنین صادر کننده کارتی وجود ندارد.";
                break;
            case '33':
                $prompt = "ز تاریخ انقضای کارت گذشته است و کارت دیگر معتبر نیست";
                break;
            case '38':
                $prompt = "رمز کارت (PIN )3مرتبه اشتباه وارد شده است در نتیجه کارت غیر فعال خواهد ش";
                break;
            case '55':
                $prompt = "خریدار رمز کارت (PIN) را اشتباه وارد کرده است.";
                break;
            case '61':
                $prompt = "مبلغ بیش از سقف برداشت می باشد.";
                break;
            case '93':
                $prompt = "تراکنش Authorizeشده است (شتاره PINو PANدرست هستند) ولی امکان سند خوردن وجود ندارد.";
                break;
            case '68':
                $prompt = "تراکنش در شبکه بانکی  Timeoutخورده است";
                break;
            case '34':
                $prompt = "خریدار یا فیلد CVV2و یا فیلد ExpDateرا اشتباه وارد کرده است (یا اصلا وارد نکرده است).";
                break;
            case '51':
                $prompt = "موجودی حساب خریدار، کافی نیست.";
                break;
            case '64':
                $prompt = "حداقل مبلغ برداشتی از کارت رعایت نشده است.";
                break;
            case '84':
                $prompt = "سیستم بانک صادر کننده کارت خریدار، در وضعیت عملیاتی نیست";
                break;
            case '96':
                $prompt = "خطای داخلی در بانک اتفاق افتاده و تراکنش شما نیز انجام نشده است.";
                break;
            default:
                $prompt = "خطاي نامشخص.";
        }
        return "خطا ({$ResCode}) : {$prompt}";
    }

    public function getSepGateWayErrors($ResCode = '')
    {
        switch ($ResCode) {
            case '-1':
                $prompt = "خطا درپردازش اطلاعات ارسالی";
                break;
            case '-3':
                $prompt = "ورودی حاوی کارکتر غیرمجاز";
                break;
            case '-4':
                $prompt = "کلمه عبور یا کد فروشنده اشتباه است.";
                break;
            case '-6':
                $prompt = "سند قبلا برگشت کامل یافته است.";
                break;
            case '-7':
                $prompt = "رسید دیجیتال خالی است.";
                break;
            case '-8':
                $prompt = "طول ورودی بیشتر از حد مجاز است";
                break;
            case '-9':
                $prompt = "وجود کاراکترهای غیرمجاز در مبلغ بازگشتی";
                break;
            case '-10':
                $prompt = "رسید دیجیتال بصورت Base64 نیست.";
                break;
            case '-11':
                $prompt = "طول ورودی ها کمتر از حد مجاز است.";
                break;
            case '-12':
                $prompt = "مبلغ برگشتی منفی است.";
                break;
            case '-13':
                $prompt = "مبلغ برگشتی برای برگشت جزئی بیش از مبلغ برگشت خورده ی رسید دیجیتال است.";
                break;
            case '-14':
                $prompt = "چنین تراکنشی تعریف نشده است.";
                break;
            case '-15':
                $prompt = "مبلغ برگشتی بصورت اعشاری داده شده است.";
                break;
            case '-16':
                $prompt = "خطای داخلی سیستم";
                break;
            case '-17':
                $prompt = "برگشت زدن جزوی تراکنش مجاز نمیباشد.";
                break;
            case '-18':
                $prompt = "ای پی سرور فروشنده نامعتبر است.";
                break;
            default:
                $prompt = "خطاي نامشخص.";
        }
        return "خطا ({$ResCode}) : {$prompt}";
    }


    public function getOrganization($getInfo = false)
    {
        if(Yii::$app->user->id == -1){
            if(!$getInfo and isset(Yii::$app->session['getOrganization']))
                return Yii::$app->session['getOrganization'];
            elseif($getInfo and isset(Yii::$app->session['getOrganizationInfoYii2']))
                return Yii::$app->session['getOrganizationInfoYii2'];
        }

        $organization_detail = OrganizationUrl::find()
            ->alias('t')
            ->select('t.organization_id,
            t.url,
            t.theme_organization_id,
            o.title,
            o.national_code,
            o.small_title,
            o.address,
            o.password_tel,
            o.national_code,
            o.register_mobile,o.info_email,
            o.page_register_title,
            o.page_register_description,
            o.page_title,o.page_register_keyword ,
            o.register_description,
            o.start_date_for_pay,
            o.pay_mobile '
            )
            ->joinWith('organization o')
            ->asArray()
            ->where(['url' => $_SERVER['HTTP_HOST']])
            ->one();
        if (!empty($organization_detail)) {

            Yii::$app->session->set('getOrganization' , $organization_detail['organization_id']);
            Yii::$app->session->set('getOrganizationInfoYii2' , $organization_detail);


            if (!$getInfo)
                return $organization_detail['organization_id'];
            else return $organization_detail;
        }
        return 0;
    }

    public function getAllOrganization($organizationId = 0, $getAllInfo = false)
    {
        if (!$organizationId)
            $organizationId = $this->getOrganization();

        if ($organizationId == $this->getOrganization() && !$getAllInfo) {
            if (isset(Yii::$app->session['getAllOrganizationHasTitle']))
                return Yii::$app->session['getAllOrganizationHasTitle'];
        }

        $organizations = Organization::find()->where(['OR', "organization_id  = $organizationId", "id = $organizationId"])->all();
        if ($organizationId == $this->getOrganization()) {
            if (empty(Yii::$app->session['getAllOrganizationHasTitle']) && !$getAllInfo)
                Yii::$app->session['getAllOrganizationHasTitle'] = ArrayHelper::map($organizations, 'id', 'small_title');
        }
        if ($getAllInfo) {
            return $organizations;
        }
        else {
            return ArrayHelper::map($organizations, 'id', 'title');
        }
    }

    public function checkSchoolsTypes()
    {
        $organizations = $this->getAllOrganization(false,true);
        $types = [];
        foreach ($organizations as $organization) {
            array_push($types,$organization->school_type);
        }
        return array_unique($types);
    }

    public function getGraduatesYear()
    {
        $years = [];
        $toYear = yii::$app->fdate->getYear();
        for ($i = 1340;$i <= $toYear; $i++){
            $years[$i."-".($i+1)] = $i."-".($i+1);
        }
        return $years;
    }


    public function getAllAcademicYear()
    {
        $academicYear = AcademicYear::find()->orderBy(['id' => SORT_DESC])->all();
        return ArrayHelper::map($academicYear, 'id', 'title');
    }

    public function getAllSchools($organizationId = 0)
    {
        if (!$organizationId)
            $organizationId = $this->getOrganization();

        $organizations = Organization::find()
            ->where(['OR', "organization_id  = $organizationId", "id = $organizationId"])
            ->andWhere(['organization_type_id' => 1])
            ->all();

        return ArrayHelper::map($organizations, 'id', 'title');
    }


    public function getAcademicYearDate($date = 0)
    {
        if ($date == 0) $date = date('Y-m-d');
        $academicYearInDate = 0;
        $academicYear = AcademicYear::find()->where("'$date' >= start_date ORDER BY start_date DESC")->one();
        if (!empty($academicYear)) $academicYearInDate = $academicYear->start_date;
        return $academicYearInDate;
    }

    public function getAcademicYear($date = 0)
    {
        if ($date == 0)
            $date = date('Y-m-d');
        $academicYearInDate = 0;

        $academicYear = AcademicYear::find()->where("'$date' >= start_date ORDER BY start_date DESC")->one();

        if (!empty($academicYear))
            $academicYearInDate = $academicYear->id;
        return $academicYearInDate;
    }

    public function getAcademicYearLast()
    {
        $academicYear = AcademicYear::find()->orderBy('id desc')->one();
        return $academicYear->id;
    }

    public function getOrganizationMainUrl()
    {
        $organizationUrl = OrganizationUrl::findOne(['organization_id' => $this->getOrganization(), 'is_main' => 1]);
        if (!empty($organizationUrl))
            return $organizationUrl->url;
        else
            return '';
    }

    public function getAllMainOrganizations()
    {
        return Organization::findAll(['organization_id' => 0, 'organization_type_id' => 0]);
    }

    public function getPaymentGatewaysZaripal()
    {
        $paymentGateways = PaymentGateways::findOne(['organization_id' => $this->getOrganization(), 'bank_id' => 78, 'is_disabled' => 0]);
        if ($paymentGateways)
            return $paymentGateways->marchent_id;
        else
            return false;

    }

    public function existPaymentGateways()
    {
        $paymentGateways = PaymentGateways::findOne(['organization_id' => $this->getOrganization(), 'is_disabled' => 0]);
        if ($paymentGateways)
            return true;
        else
            return false;

    }

    public function getRegistrationAcademicYear()
    {
        $academicyear = AcademicYear::findOne(['is_registration' => 1]);
        return $academicyear->id;
    }


    public function doLocalActionsForPayment($uniqId)
    {
        $connectToGatewayBank = ConnectToGatewayBank::findOne(['unique_key' => yii::$app->request->get('unid')]);

        switch ($connectToGatewayBank->paymentGateway->bank_id) {
            case 78: //zarinpal

                switch ($connectToGatewayBank->action) {
                    case 'registerFinancialDocs':

                        $checkIsRegistered = FinancialDocumentDetail::findOne(['payment_type_id' => 9, 'documnet_code' => $connectToGatewayBank->payment->id]);
                        if (!$checkIsRegistered) {
                            $detail = ContentToOrganizationBaseFieldDetail::findOne([
                                'content_to_organization_base_field_id' => Utility::explodText($connectToGatewayBank->payment->return_id, 0, ','),
                                'payment_type_id' => 9,
                            ]);
                            if ($detail) {
                                $tuitionsToFinancialHeadingDetail = TuitionsToFinancialHeadingDetail::findOne(['organization_id' => yii::$app->fcore->getOrganization()]);
                                if ($tuitionsToFinancialHeadingDetail)
                                    $financialHeadingDeptor = $tuitionsToFinancialHeadingDetail->financial_heading_detail_id;
                                else {
                                    $financialHeadingDeptor = 23;
                                    $additionalMsg = ' سرفصل شهریه تعریف نشده است!';
                                }
                                $register = FinancialDocuments::registerOnlineFinancialDocs($connectToGatewayBank->user_id,
                                    yii::$app->fcore->getOrganization(),
                                    $financialHeadingDeptor,
                                    $detail->return_id,
                                    $detail->return_type_id,
                                    $detail->financial_heading_detail_id,
                                    $connectToGatewayBank->amount . '0',
                                    $connectToGatewayBank->payment->id,
                                    $connectToGatewayBank->payment->return_id);
                                if (!$register) {
                                    die('پرداخت شما ثبت شد ولی از مبلغ شهریه کسر نگردید! لطفا با مدرسه جهت بررسی این موضوع تماس بگیرید.');
                                } else {
                                    $academic = Academic::find()->where(
                                        [
                                            'user_id' => $connectToGatewayBank->user_id,
                                            'academic_year_id' => yii::$app->fcore->getRegistrationAcademicYear()
                                        ]
                                    )
                                        ->andWhere(['IN', 'organization_id', array_keys(yii::$app->fcore->getAllSchools())])
                                        ->one();

                                    if ($academic) {
                                        $academic->status = 18;
                                        $academic->save();
                                    }

                                    $profile = Profiles::findOne(['user_id' => $connectToGatewayBank->user_id]);
                                    $payment = new Payment;
                                    $payment->user_id = $connectToGatewayBank->user_id;
                                    $payment->amount = $connectToGatewayBank->amount;
                                    $payment->is_success = 1;
                                    $payment->type = 4;
                                    $payment->description = 'کسر از موجودی کیف پول ' . $profile->name . ' ' . $profile->lname . ' بابت پرداخت شهریه';
                                    $payment->create_date = date('Y-m-d H:i:s');
                                    $payment->organization_id = yii::$app->fcore->getOrganization();
                                    $payment->create_user_id = $connectToGatewayBank->create_user_id;
                                    if ($payment->save(true))
                                        return true;
                                    else {
                                        print_r($payment->getErrors());
                                        return false;
                                    }
                                }
                            } else die('سرفصل مالی برای پرداخت آنلاین این شهریه در سامانه ثبت نگردیده است! لطفا این موضوع را جهت پیگیری با مدرسه درمیان بگذارید!');
                        }
                        break;
                    case 'inventory_increase':
                        $profile = Profiles::findOne(['user_id' => $connectToGatewayBank->user_id]);
                        $payment = new Payment;
                        $payment->user_id = $connectToGatewayBank->user_id;
                        $payment->amount = $connectToGatewayBank->amount;
                        $payment->is_success = 1;
                        $payment->type = 3;
                        $payment->description = 'افزایش موجودی کیف پول ' . $profile->name . ' ' . $profile->lname;
                        $payment->create_date = date('Y-m-d H:i:s');
                        $payment->organization_id = yii::$app->fcore->getOrganization();
                        $payment->create_user_id = $connectToGatewayBank->create_user_id ? $connectToGatewayBank->create_user_id : 1;
                        if ($payment->save(true)) {
                            return true;
                        } else {
                            print_r($payment->getErrors());
                            return false;
                        }
                        break;

                    case 'paymentCommitment':
                        $financialDocDetail = FinancialDocumentDetail::findOne($connectToGatewayBank->payment->return_id);
                        $financialDocDetail->financial_document_status_id = 28;
                        $financialDocDetail->catch_date = date('Y-m-d');
                        if ($financialDocDetail->save()) {
                            $smsBody = SmsBody::findOne(['organization_id' => $financialDocDetail->financialDocument->organization_id, 'type' => 6]);
                            if ($smsBody) {
                                $outputArray[0] = $financialDocDetail->financialDocument->organization->small_title;
                                $outputArray[1] = yii::$app->fstring->translateDigits(number_format($financialDocDetail->amount));
                                $outputArray[2] = yii::$app->ffinancial->getTuitionType($financialDocDetail->content_to_organization_base_field_id);
                                $variables = json_encode($outputArray);

                                $sms = new Sms;
                                $sms->title = 'پرداخت موفق تعهدات';
                                $sms->message = '-';
                                $sms->sms_body_id = $smsBody->id;
                                $sms->create_date = date('Y-m-d H:i:s');
                                $sms->create_return_id = 1;
                                $sms->create_return_type_id = 2;
                                $sms->publish_date = date('Y-m-d H:i:s');
                                $sms->organization_id = $financialDocDetail->financialDocument->organization_id;
                                if ($sms->save()) {
                                    $parentInfo = yii::$app->fuser->getParentId($financialDocDetail->financialDocument->return_id);

                                    $smsSend = new SmsSend;
                                    $smsSend->sms_id = $sms->id;
                                    $smsSend->variable = $variables;
                                    $smsSend->status = 0;
                                    if ($checks->financialDocument->returnIdProfiles->life_type == 1 || $checks->financialDocument->returnIdProfiles->life_type == 2) {
                                        $smsSend->user_id = $parentInfo['father'];
                                    } else {
                                        $smsSend->user_id = $parentInfo['mother'];
                                    }

                                    $smsSend->save();
                                }
                            }
                            yii::$app->ffinancial->getPaymentRateByStudentID($connectToGatewayBank->user_id, false, $financialDocDetail->financialDocument->academic_year_id, true);
                            return true;
                        } else return false;
                        break;
                }

                break;

            case 25: //refah
            case 14: //resallat
            case 6: //pasargad
            case 5: //parsian
            case 29: //sina
            case 3: //sina

                switch ($connectToGatewayBank->action) {

                    case 'registerFinancialDocs':

                        $checkIsRegistered = FinancialDocumentDetail::findOne(['payment_type_id' => 9, 'documnet_code' => $connectToGatewayBank->payment->id]);
                        if (!$checkIsRegistered) {
                            $detail = ContentToOrganizationBaseFieldDetail::findOne([
                                'content_to_organization_base_field_id' => Utility::explodText($connectToGatewayBank->payment->return_id, 0, ','),
                                'payment_type_id' => 9,
                            ]);
                            if ($detail) {
                                $tuitionsToFinancialHeadingDetail = TuitionsToFinancialHeadingDetail::findOne(['organization_id' => yii::$app->fcore->getOrganization()]);
                                if ($tuitionsToFinancialHeadingDetail)
                                    $financialHeadingDeptor = $tuitionsToFinancialHeadingDetail->financial_heading_detail_id;
                                else {
                                    $financialHeadingDeptor = 23;
                                    $additionalMsg = ' سرفصل شهریه تعریف نشده است!';
                                }
                                $register = FinancialDocuments::registerOnlineFinancialDocs($connectToGatewayBank->user_id,
                                    yii::$app->fcore->getOrganization(),
                                    $financialHeadingDeptor,
                                    $detail->return_id,
                                    $detail->return_type_id,
                                    $detail->financial_heading_detail_id,
                                    $connectToGatewayBank->amount . '0',
                                    $connectToGatewayBank->payment->id,
                                    $connectToGatewayBank->payment->return_id, null, $connectToGatewayBank->create_user_id);
                                if (!$register) {
                                    die('پرداخت شما ثبت شد ولی از مبلغ شهریه کسر نگردید! لطفا با مدرسه جهت بررسی این موضوع تماس بگیرید.');
                                } else {
                                    $academic = Academic::find()->where(
                                        [
                                            'user_id' => $connectToGatewayBank->user_id,
                                            'academic_year_id' => yii::$app->fcore->getRegistrationAcademicYear()
                                        ]
                                    )
                                        ->andWhere(['IN', 'organization_id', array_keys(yii::$app->fcore->getAllSchools())])
                                        ->one();

                                    if ($academic) {
                                        $academic->status = 18;
                                        $academic->save();
                                    }

                                    $profile = Profiles::findOne(['user_id' => $connectToGatewayBank->user_id]);
                                    $payment = new Payment;
                                    $payment->user_id = $connectToGatewayBank->user_id;
                                    $payment->amount = $connectToGatewayBank->amount;
                                    $payment->is_success = 1;
                                    $payment->type = 4;
                                    $payment->description = 'کسر از موجودی کیف پول ' . $profile->name . ' ' . $profile->lname . ' بابت پرداخت شهریه';
                                    $payment->create_date = date('Y-m-d H:i:s');
                                    $payment->organization_id = yii::$app->fcore->getOrganization();
                                    $payment->create_user_id = $connectToGatewayBank->create_user_id ? $connectToGatewayBank->create_user_id : 1;

                                    if ($payment->save(true))
                                        return true;
                                    else {
                                        print_r($payment->getErrors());
                                        return false;
                                    }
                                }
                            } else die('سرفصل مالی برای پرداخت آنلاین این شهریه در سامانه ثبت نگردیده است! لطفا این موضوع را جهت پیگیری با مدرسه درمیان بگذارید!');
                        }
                        break;
                    case 'paymentCommitment':
                        $financialDocDetail = FinancialDocumentDetail::findOne($connectToGatewayBank->payment->return_id);
                        $financialDocDetail->financial_document_status_id = 28;
                        $financialDocDetail->catch_date = date('Y-m-d');
                        if ($financialDocDetail->save()) {
                            $smsBody = SmsBody::findOne(['organization_id' => $financialDocDetail->financialDocument->organization_id, 'type' => 6]);
                            if ($smsBody) {
                                //die(print_r($smsBody));
                                $outputArray = array();
                                $outputArray[0] = $financialDocDetail->financialDocument->organization->small_title;
                                $outputArray[1] = yii::$app->fstring->translateDigits(number_format($financialDocDetail->amount));
                                $outputArray[2] = yii::$app->ffinancial->getTuitionType($financialDocDetail->content_to_organization_base_field_id, true);
                                $variables = json_encode($outputArray);

                                $sms = new Sms;
                                $sms->title = 'پرداخت موفق تعهدات';
                                $sms->message = '-';
                                $sms->sms_body_id = $smsBody->id;
                                $sms->create_date = date('Y-m-d H:i:s');
                                $sms->create_return_id = 1;
                                $sms->create_return_type_id = 2;
                                $sms->publish_date = date('Y-m-d H:i:s');
                                $sms->organization_id = $financialDocDetail->financialDocument->organization_id;
                                if ($sms->save(true)) {
                                    $parentInfo = yii::$app->fuser->getParentId($financialDocDetail->financialDocument->return_id);

                                    $smsSend = new SmsSend;
                                    $smsSend->sms_id = $sms->id;
                                    $smsSend->variable = $variables;
                                    $smsSend->status = 0;
                                    if ($financialDocDetail->financialDocument->returnIdProfiles->life_type == 1 || $financialDocDetail->financialDocument->returnIdProfiles->life_type == 2) {
                                        $smsSend->user_id = $parentInfo['father'];
                                    } else {
                                        $smsSend->user_id = $parentInfo['mother'];
                                    }

                                    $smsSend->save();
                                } else die(print_r($sms->getErrors()));
                            }
                            yii::$app->ffinancial->getPaymentRateByStudentID($connectToGatewayBank->user_id, false, $financialDocDetail->financialDocument->academic_year_id, true);
                            return true;
                        } else return false;
                        break;
                    case 'setApproveSchoolService':
                        $profile = Profiles::findOne(['user_id' => $connectToGatewayBank->user_id]);
                        $payment = new Payment;
                        $payment->user_id = $connectToGatewayBank->user_id;
                        $payment->amount = $connectToGatewayBank->amount;
                        $payment->is_success = 1;
                        $payment->type = 4;
                        $payment->description = 'کسر از موجودی کیف پول ' . $profile->name . ' ' . $profile->lname . ' بابت پرداخت شهریه سرویس';
                        $payment->create_date = date('Y-m-d H:i:s');
                        $payment->organization_id = yii::$app->fcore->getOrganization();
                        $payment->create_user_id = $connectToGatewayBank->create_user_id ? $connectToGatewayBank->create_user_id : 1;

                        if ($payment->save(true)) {
                            $academicToZoneAcademicYearDetail = AcademicToZoneAcademicYearDetail::findOne($connectToGatewayBank->payment->return_id);
                            $academicToZoneAcademicYearDetail->is_approved = 1;
                            $academicToZoneAcademicYearDetail->document_code = $connectToGatewayBank->payment->refid;
                            if($academicToZoneAcademicYearDetail->save(true))
                            return true;
                            else {
                                die(print_r($academicToZoneAcademicYearDetail->getErrors()));
                                return false;
                            }
                        } else {
                            print_r($payment->getErrors());
                            return false;
                        }
                        break;
                    case 'prereservepayment':
                        $profile = Profiles::findOne(['user_id' => $connectToGatewayBank->user_id]);
                        $payment = new Payment;
                        $payment->user_id = $connectToGatewayBank->user_id;
                        $payment->amount = $connectToGatewayBank->amount;
                        $payment->is_success = 1;
                        $payment->type = 17;
                        $payment->description = 'کسر از موجودی کیف پول ' . $profile->name . ' ' . $profile->lname . ' بابت هزینه مشاوره پیش ثبت نام';
                        $payment->create_date = date('Y-m-d H:i:s');
                        $payment->organization_id = yii::$app->fcore->getOrganization();
                        $payment->create_user_id = $connectToGatewayBank->create_user_id ? $connectToGatewayBank->create_user_id : 1;
                        if ($payment->save(true)) {
                            return true;
                        } else {
                            print_r($payment->getErrors());
                            return false;
                        }
                        break;
                    case 'inventory_increase':
                        $profile = Profiles::findOne(['user_id' => $connectToGatewayBank->user_id]);
                        $payment = Payment::findOne($connectToGatewayBank->return_id);
//                        $payment = new Payment;
//                        $payment->user_id = $connectToGatewayBank->user_id;
//                        $payment->amount = $connectToGatewayBank->amount;
//                        $payment->is_success = 1;
//                        $payment->type = 3;
                        $payment->description = 'افزایش موجودی کیف پول ' . $profile->name . ' ' . $profile->lname;
                        $payment->create_date = date('Y-m-d H:i:s');
//                        $payment->organization_id = yii::$app->fcore->getOrganization();
//                        $payment->create_user_id = $connectToGatewayBank->create_user_id ? $connectToGatewayBank->create_user_id : 1;
                        if ($payment->save(true)) {
                            return true;
                        } else {
                            print_r($payment->getErrors());
                            return false;
                        }

                        break;


                }

        }
    }

    public function loginWithYii1($forceLogin = true)
    {

        if (!Yii::$app->user->isGuest) {
            return true;
        } else {
            global $_Yii1Session;

            if (!empty($_Yii1Session['profile'])) {
                foreach ($_Yii1Session['profile'] as $item) {
                    foreach ($item as $t => $item2) {
                        if ($t == '_attributes')
                            foreach ($item2 as $key => $item3) {
                                $profileArr[$key] = $item3;
                            }
                    }
                }
                $userModel = \backend\models\Users::findOne($profileArr['user_id']);
                $model = new LoginForm();
                $model->username = $userModel->username;
                $model->password = 1;
                if ($model->loginByBridge()) {
                    return true;
                } elseif($forceLogin) {
                    Yii::$app->response->redirect(['/site/login'])->send();
                    die;
                }

            } elseif($forceLogin) {
                Yii::$app->response->redirect(['/site/login'])->send();
                die;
            }
            return true;
        }
    }

    public function getZoneInfo($zoneId)
    {
        $zone = Zones::findOne($zoneId);
        $this->zoneTitle .= $zone->title;
        if ($zone->parent_id) {
            $this->zoneTitle .= '/';
            $this->getZoneInfo($zone->parent_id);
        }
        return $this->zoneTitle;
    }

    public function getZonesAsDropDown($zoneId, $level, $firstRequest = true)
    {
        $zone = Zones::findOne($zoneId);
        if ($zone->parent_id) {
            $zones = Zones::findAll(['parent_id' => $zone->parent_id]);
            if ($zones && !$firstRequest) {
                $array = ['' => 'لطفا انتخاب کنید'];
                $arrZones = ArrayHelper::map($zones,
                    'id', 'title');
                $this->zoneTitle .=
                    '<div class="col-lg-3 m-b-15" level="' . ($level - 1) . '"><label class="label-mini" for="academic-year">منطقه(اختیاری)</label>' .
                    Html::tag('div', Html::dropDownList('zone-level[]', $zoneId, array_replace($array, $arrZones)
                        , ['class' => 'form-control zone', 'level' => $level - 1]), ['level' => $level - 1])
                    . '</div>*';

            }

            $this->getZonesAsDropDown($zone->parent_id, ($level - 1), false);
        } else {
            $zones = Zones::findAll(['parent_id' => null]);
            if ($zones) {
                $array = ['' => 'لطفا انتخاب کنید'];
                $arrZones = ArrayHelper::map($zones,
                    'id', 'title');
                $this->zoneTitle .=
                    '<div class="col-lg-3 m-b-15" level="1"><label class="label-mini" for="academic-year">منطقه(اختیاری)</label>' .
                    Html::tag('div', Html::dropDownList('ZoneToAcademicYear[zone_id]', $zoneId, array_replace($array, $arrZones)
                        , ['class' => 'form-control zone', 'level' => 1]), ['level' => 1])
                    . '</div>*';

            }
        }
        return $this->zoneTitle;
    }

    // Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

    public function callAPI($url, $data = false, $method = "POST")
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    public function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes / pow(10, $pow * 3), $precision) . ' ' . $units[$pow];
    }

}


?>
