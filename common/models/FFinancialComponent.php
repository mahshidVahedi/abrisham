<?php 
namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use backend\models\JobDetail;
use backend\models\Academic;
use backend\models\FinancialAccounts;
use backend\models\FinancialDocumentFactors;
use backend\models\FinancialHeadingDetail;
use backend\models\FinancialDocumentDetail;
use backend\models\TagToTagAssign;
use backend\models\Profiles;
use backend\models\Payment;
use backend\models\ContentToOrganizationBaseField;
use backend\models\ContentToPropertyField;
use backend\models\FinancialAcademicPaymentCommitmentsRate;

use kartik\select2\Select2;
use common\components\Utility;

class FFinancialComponent extends Component
{
    public  $financialHeadingArray = array();
    private $financialDocumentDetailArray = array(),
    $financialDocumentFactorArray = array();

    public  function getFinancialAccountsOwner($organizationId,$academicYearId,$returnId,$returnTypeId)
    {

        $defaultAccountInfo = array();
        $defaultAccountInfo['name']   = '-';
        $defaultAccountInfo['type']   = '-';
        switch($returnTypeId)
        {
            case 1: // is user
            case 5: // is user

                $isPersonal = JobDetail::find()->where([
                    'organization_id' => array_keys(yii::$app->fcore->getAllOrganization()),
                    'academic_year_id' => $academicYearId,
                    'user_id' => $returnId,
                ])->one();

                if($isPersonal)
                {   
                    $defaultAccountInfo['name']      = $isPersonal->profiles->name . ' ' . $isPersonal->profiles->lname;
                    $defaultAccountInfo['type']      = 'personal';
                }
                else  // is student
                { 
                    $academic = Academic::find()
                    ->where([
                        'user_id' => $returnId,
                        'academic_year_id' => $academicYearId,
                        'deleted' => 0
                        ]
                    )
                    ->andWhere(['IN','organization_id',array_keys(yii::$app->fcore->getAllOrganization()) ])
                    ->one();
                    if($academic)
                    {   
                        $defaultAccountInfo['name']  = $academic->profile->name .' ' . $academic->profile->lname.' (<strong class="text-danger">'.$academic->base->title.'</strong>/'.$academic->organization->small_title.')' ;
                        $defaultAccountInfo['type']  = 'student';
                    } 
                    else 
                    {
                        $profiles = Profiles::findOne($returnId);
                        if($profiles)
                        {
                            $defaultAccountInfo['name'] =  $profiles->name .' ' .$profiles->lname;
                            $defaultAccountInfo['type'] =  'parent'; 
                        }
                        else 
                        {
                            $defaultAccountInfo['name'] =  '-';
                            $defaultAccountInfo['type'] =  '-';
                        }
                    }
                } 
                break;

            case 2: // is financial account
                $finanAccOrg = FinancialAccounts::findOne($returnId);
                if($finanAccOrg) 
                {    
                    $defaultAccountInfo['name']  = $finanAccOrg->bank_id ? $finanAccOrg->bank->title.' - ' : ' ';
                    $defaultAccountInfo['name']  .= $finanAccOrg->title;
                    $defaultAccountInfo['type']  = $finanAccOrg->financial_account_type_id;
                }
                else{

                    $defaultAccountInfo['name'] = '-';
                    $defaultAccountInfo['type'] = 0;
                }

                break;

            case 3: // other users outside system
                $defaultAccountInfo['name'] =  $returnId;
                $defaultAccountInfo['type'] =  'outside user'; 
                break;

            case 4: // financial headnig
                //echo $returnId.'<br>'.$returnTypeId;die;
                $financialHeadingDetail = FinancialHeadingDetail::findOne($returnId);
                if($financialHeadingDetail)
                    $defaultAccountInfo['name'] =  $financialHeadingDetail->financialHeading->title;
                $defaultAccountInfo['type'] =  'financial headnig'; 
                break;
            case 6: // tag
                //echo $returnId.'<br>'.$returnTypeId;die;
                $tagToTag = TagToTagAssign::findOne($returnId);
                if($tagToTag)
                    $defaultAccountInfo['name'] =  $tagToTag->childTag->title;
                $defaultAccountInfo['type'] =  'tag'; 
                break;
        }
        return  $defaultAccountInfo;
    } 

    public function getFinancialHedingTitles($financialHeadingDetailId,$emptyLastResult = true)
    {
        if($emptyLastResult)
        {
           $this->financialHeadingArray = array(); 
        }
        $financialHeading = FinancialHeadingDetail::findOne($financialHeadingDetailId);
        if($financialHeading)
        {
            $this->financialHeadingArray[$financialHeading->financial_heading_id] = yii::$app->fstring->translateDigits($financialHeading->alias_number).'-'.$financialHeading->financialHeading->title;

            if($financialHeading->parent_id)
                $this->getFinancialHedingTitles($financialHeading->parent_id,false);
        }
        else return false;
                 
        return array_reverse($this->financialHeadingArray);
    } 

    public function checkPayedTutionsByUserId($userId,$tuitionsIdsSepratedComma)
    {
        $sql = "SELECT
                        fd.id,
                        sum(fdd.amount) as sum_amounts,
                        fdd.is_approved,
                        fdd.content_to_organization_base_field_id
                    FROM
                        tbl_financial_document_detail fdd
                        JOIN tbl_financial_documents fd ON ( fdd.financial_document_id = fd.id AND fd.return_type_id = 1 AND fd.return_id = :userId )
                        JOIN tbl_payment_type pt ON ( fdd.payment_type_id = pt.id ) 
                    WHERE
                        fdd.content_to_organization_base_field_id REGEXP CONCAT( '(^|,)(', REPLACE ( :tuitionsIdsSepratedComma, ',', '|' ), ')(,|$)' ) 
                        AND fdd.is_deleted = 0 AND fdd.is_warranty = 0 
                    GROUP BY
                    fdd.content_to_organization_base_field_id";
        //echo $sql;die;
        $output = Yii::$app->db->createCommand($sql)
        ->bindValue(':userId',  $userId)
        ->bindValue(':tuitionsIdsSepratedComma', $tuitionsIdsSepratedComma)
        ->queryOne();

        return $output;
    }

    public function getTutionsPriceByContentToOrganizationBaseFieldId($idsSepratedWithComma)
    {
        
        if($idsSepratedWithComma)
        {
            $sql = "SELECT DISTINCT
                        SUM( pr.price ) AS sum_prices,
                        GROUP_CONCAT( cobf.id ) AS content_to_organization_base_field_id
                        FROM
                        tbl_contents c
                        JOIN tbl_content_to_property_field cpf ON ( c.id = cpf.content_id )
                        JOIN tbl_property_fields pf ON ( cpf.property_field_id = pf.id AND pf.module_type = 1 )
                        JOIN tbl_property_field_detail pfd ON ( pf.id = pfd.property_field_id AND pfd.id = cpf.property_field_detail_id )
                        JOIN tbl_price pr ON ( c.id = pr.content_id )
                        JOIN tbl_content_to_organization_base_field cobf ON ( c.id = cobf.content_id )
                        JOIN tbl_organization_base_to_field obf ON ( cobf.organization_base_to_field_id = obf.id )
                        JOIN tbl_field f ON ( obf.field_id = f.id )
                        JOIN tbl_organization_to_base ob ON ( obf.organization_to_base_id = ob.id )
                        JOIN tbl_organization o ON ( ob.organization_id = o.id )
                        JOIN tbl_base b ON ( ob.base_id = b.id )
                        JOIN tbl_academic_year ay ON ( ob.academic_year_id = ay.id ) 
                        WHERE
                        cobf.id IN ($idsSepratedWithComma)";
            $output = Yii::$app->db->createCommand($sql)
            //->bindValue(':idsSepratedWithComma', $idsSepratedWithComma)
            ->queryOne();
    
            return $output;
            
        }
        else return array('sum_prices' => 1, 'content_to_organization_base_field_id' => 0);
    }
    
    public function checkStudentHasPaidTuition($userId,$stringTuitionsIdsSepratedWithComma,$getSum=false)
    {
            if(!$getSum)
            {    
                   $sql = "SELECT
                                fd.id,
                                fdd.id as fdd_id,
                                fdd.amount,
                                fdd.payment_type_id,
                                fdd.is_approved,
                                fdd.is_warranty,
                                fdd.documnet_code,
                                fdd.description,
                                fdd.documnet_date,
                                fdd.content_to_organization_base_field_id 
                            FROM
                            tbl_financial_document_detail fdd
                            JOIN tbl_financial_documents fd ON ( fdd.financial_document_id = fd.id AND fd.return_type_id = 1 AND fd.return_id = :userId )
                            JOIN tbl_payment_type pt ON ( fdd.payment_type_id = pt.id ) 
                            WHERE
                            fdd.content_to_organization_base_field_id REGEXP CONCAT( '(^|,)(', REPLACE ( :stringTuitionsIdsSepratedWithComma, ',', '|' ), ')(,|$)' ) 
                            AND fdd.is_deleted = 0 
                            ORDER BY fdd.documnet_date
                            ";
                   $output = Yii::$app->db->createCommand($sql)
                    ->bindValue(':userId',  $userId)
                    ->bindValue(':stringTuitionsIdsSepratedWithComma', $stringTuitionsIdsSepratedWithComma)
                   ->queryAll();
                   return $output;         
                                   
            }
            else
            {
                    $sql = "SELECT
                                Sum(fdd.amount) as sum_payment
                            FROM
                            tbl_financial_document_detail fdd
                            JOIN tbl_financial_documents fd ON ( fdd.financial_document_id = fd.id AND fd.return_type_id = 1 AND fd.return_id = :userId )
                            JOIN tbl_payment_type pt ON ( fdd.payment_type_id = pt.id ) 
                            WHERE
                            fdd.content_to_organization_base_field_id REGEXP CONCAT( '(^|,)(', REPLACE ( :stringTuitionsIdsSepratedWithComma, ',', '|' ), ')(,|$)' ) 
                            AND fdd.is_deleted = 0 AND fdd.is_warranty = 0";
                    $output = Yii::$app->db->createCommand($sql)
                    ->bindValue(':userId',  $userId)
                    ->bindValue(':stringTuitionsIdsSepratedWithComma', $stringTuitionsIdsSepratedWithComma)
                    ->queryOne();
                    return $output;        
            }
            
    }

    public function getBanksLogoDirectory()
    {
        return yii::getAlias('@yii1Url') . '/server/php/files/banks_logo/';
    } 

    public function getTuitionTitles($contentToOrganizationBaseFiledIdCommaSeprated)
    {
        $exps = explode(',',$contentToOrganizationBaseFiledIdCommaSeprated);
        $output = '';
        foreach($exps as $tuitionId)
        {
            $contentToOrganizationBaseFiled = ContentToOrganizationBaseField::findOne($tuitionId);
            if($contentToOrganizationBaseFiled)
                $output .= $contentToOrganizationBaseFiled->content->title.'/';
        }
        return rtrim($output,'/') ;
    } 
    
    public function getTuitionType($contentToOrganizationBaseFiledIdCommaSeprated,$getTitle = false)
    {
         $tuitionId = Utility::explodText($contentToOrganizationBaseFiledIdCommaSeprated,0,','); 
         $contentToOrganizationBaseFiled = ContentToOrganizationBaseField::find()
                                                ->alias('cobf')
                                                ->select('cpf.property_field_detail_id,cobf.content_id')
                                                ->join('INNER JOIN','{{%content_to_property_field}} cpf','cobf.content_id = cpf.content_id')
                                                ->where(['cobf.id' => $tuitionId])
                                                ->one();
                                                
         if($contentToOrganizationBaseFiled)
         {
            if($getTitle)
            {
                $contentToPropertyField = ContentToPropertyField::findOne(['content_id' => $contentToOrganizationBaseFiled->content_id,'property_field_detail_id' => $contentToOrganizationBaseFiled->property_field_detail_id]);
                return $contentToPropertyField->propertyFieldDetail->title_fa;
            } 
            else
            return $contentToOrganizationBaseFiled->property_field_detail_id;
         }
         return '-';
    } 
    
    public function getTuitionSummery($contentToOrganizationBaseFiledIdCommaSeprated)
    {
        $exps = explode(',',$contentToOrganizationBaseFiledIdCommaSeprated);
        $output = '';
        foreach($exps as $tuitionId)
        {
            $contentToOrganizationBaseFiled = ContentToOrganizationBaseField::findOne($tuitionId);
            if($contentToOrganizationBaseFiled)
                $output .= $contentToOrganizationBaseFiled->prepayment_description.'/';
        }
        return rtrim($output,'/') ;
    } 
    
    public function getTuitionPrices($contentToOrganizationBaseFiledIdCommaSeprated)
    {
        $exps = explode(',',$contentToOrganizationBaseFiledIdCommaSeprated);
        $output = 0;
        foreach($exps as $tuitionId)
        {
            $contentToOrganizationBaseFiled = ContentToOrganizationBaseField::find()->asArray()
                                                ->alias('cobf')
                                                ->select('p.price')
                                                ->join('INNER JOIN','tbl_price p','p.content_id = cobf.content_id')
                                                ->where(['cobf.id' => $tuitionId])
                                                ->one();
                                                ;
            if($contentToOrganizationBaseFiled)
                $output += $contentToOrganizationBaseFiled['price'];
        }
        return $output;
    }
    
    public function checkAcademicHasPaymentCommitment($userId)
    {
        $financials = FinancialDocumentDetail::find()->alias('fdd')
                                                   ->joinWith('financialDocument fd')
                                                   ->where(['fd.return_id' => $userId,
                                                   'fd.return_type_id' => 1,
                                                   'fdd.is_deleted' => 0,
                                                   'fdd.payment_type_id' => 11 ,
                                                   'fd.organization_id' => yii::$app->fcore->getOrganization() 
                                                   ])
                                                   ->andWhere(['NOT',['fdd.is_warranty' => 1]])
                                                   ->andWhere(['<','fd.academic_year_id',yii::$app->fcore->getRegistrationAcademicYear()])
                                                   ->andWhere(['<','fdd.documnet_date',date('Y-m-d')])
                                                   ->andWhere(['IN','fdd.financial_document_status_id',[27,30]])
                                                   ->all();
        if(count($financials))
            return true;
        else return false; 
    }
    
    
    public function getPaymentRateByStudentID($userId,$academicId = false,$academicYear = false,$isGatewayPayment = false)
    {
        return 'در دست بروزرسانی';
        if(!$academicYear)
            $academicYear = yii::$app->fcore->getAcademicYear();
        
        $numerator = $denominator = 0;
        if(!$academicId)
        {
            $academic  = Academic::findOne(['user_id' => $userId,'academic_year_id' => $academicYear,'organization_id' => array_keys(yii::$app->fcore->getAllOrganization()),'deleted' =>0]);
            $academicId = $academic->id;
        }
        $academicRate = FinancialAcademicPaymentCommitmentsRate::findOne(['academic_id' => $academicId]);
        if($academicRate && !$isGatewayPayment)
        {
            return $academicRate->rate_number;
        }
        else
        {  
            $financialsToRate = FinancialDocumentDetail::find()->alias('fdd')
                                                               ->joinWith('financialDocument fd')
                                                               ->where(['fd.return_id' => $userId,'fd.return_type_id' => 1,'fd.academic_year_id' => $academicYear,'fdd.is_deleted' => 0,'fdd.payment_type_id' => 11])
                                                               ->andWhere(['NOT',['fdd.is_warranty' => 1]])
                                                               ->orderBy(['fdd.documnet_date' => SORT_ASC])
                                                               ->all(); 

            if($financialsToRate)
            {
                foreach ($financialsToRate as $financialRowForRate)
                {
                    if($financialRowForRate->catch_date)
                    {  
                        $paymentDate    = strtotime($financialRowForRate->documnet_date);
                        $catchDate      = strtotime($financialRowForRate->catch_date);
                        $today          = date('Y-m-d');
                        
                        $finanDocsPaymentDateDiff           = strtotime($today) - $paymentDate;
                        $finanDocsPaymentDateDayCount       = round($finanDocsPaymentDateDiff / (60 * 60 * 24));
                        
                        $finanDocsCatchDateDiff             = strtotime($today) - $catchDate;
                        $finanDocsCatchDateDayCount         = round($finanDocsCatchDateDiff / (60 * 60 * 24));  
                        
                        $diffrenceDateStr                               = $catchDate - $paymentDate;
                        $finanDocsCatchDateDiffrenceDayCount            = round($diffrenceDateStr / (60 * 60 * 24));   
                        
                        $finanDocsCatchDateDayCount     =   $finanDocsCatchDateDayCount   ? $finanDocsCatchDateDayCount   : 1;
                        $numerator      +=  ($financialRowForRate->amount * $finanDocsCatchDateDayCount); 
                        
                        if(($paymentDate) <= strtotime($today))
                        {
                            $finanDocsPaymentDateDayCount   =   $finanDocsPaymentDateDayCount ? $finanDocsPaymentDateDayCount : 1;
                            $denominator                    +=  ($financialRowForRate->amount * $finanDocsPaymentDateDayCount);
                        }
                        else
                        {
                             //$numerator   = 1; 
                             $denominator += 1;
                        } 
                        
                        
                    }
                    else if(strtotime($financialRowForRate->documnet_date) < strtotime(date('Y-m-d')) && $financialRowForRate->payment_type_id == 11)
                    {   
                        $numerator   += 0; 
                        $finanDocsPaymentDateDiff           = strtotime(date('Y-m-d')) - strtotime($financialRowForRate->documnet_date);
                        $finanDocsPaymentDateDayCount       = round($finanDocsPaymentDateDiff / (60 * 60 * 24));
                        $denominator    +=  ($financialRowForRate->amount * $finanDocsPaymentDateDayCount);
                        //if(yii::$app->user->id == 963)  
//                            $this->_setLogFile('2===> '.$financialRowForRate->id .'=='. $denominator.'=='.$finanDocsPaymentDateDayCount);
                    }
                    else
                    { 
                        ++$numerator; 
                        ++$denominator;
                    }
                    
                }
                
            }
            else
            {
                return 100;
            }
            
            $average = $denominator ? round((($numerator / $denominator) * 100),0) : 0;
            if($average > 200)
            {
                $average = 200;
            }
            if($academicRate)
            {
                $academicRate->rate_number = $average;
                $academicRate->last_update = date('Y-m-d H:i:s');
                $academicRate->save();
            }
            else
            {
                $academicRate = new FinancialAcademicPaymentCommitmentsRate;
                $academicRate->academic_id = $academicId;
                $academicRate->rate_number = $average;
                $academicRate->last_update = date('Y-m-d H:i:s');
                $academicRate->save();
            }
            return $average;
        }
    } 
    
    private function _setLogFile($message)
    {
        if(!is_dir(__DIR__.'/finanical_logs'))
            mkdir(__DIR__.'/finanical_logs');
        $my_file = __DIR__.'/finanical_logs/output.log';

        $handle  = fopen($my_file, 'a');
        $content = print_r($message,true);
        $content .= "\n";
        fwrite($handle, $content);
    }
    
    public function getFinancialDocumentAmount($financialDocumentId)
    {     
        $sum = FinancialDocumentDetail::find()->where(['financial_document_id' => $financialDocumentId,'is_deleted' => 0,'is_warranty' => 0])->andWhere(['NOT IN','financial_document_status_id',[4,8]])->sum('amount') ;
        return $sum ? $sum : '-';
    }

    public function getFinancialdocumentsDetail($financialDocumentId)
    {
        $this->financialHeadingArray  = array();
        $financialDocumentsDetail = FinancialDocumentDetail::findAll(['financial_document_id' => $financialDocumentId,'is_deleted' => 0]) ;
        if($financialDocumentsDetail)
        {
            foreach($financialDocumentsDetail As $financialDcDetail)
            {    
                
                $owner = $this->getFinancialAccountsOwner($financialDcDetail->financialDocument->organization_id,$financialDcDetail->financialDocument->academic_year_id,$financialDcDetail->return_id,$financialDcDetail->return_type_id);
                
                $this->financialDocumentDetailArray[$financialDcDetail->id] = array(
                    'amount'            => $financialDcDetail->amount,
                    'des'               => $financialDcDetail->description,
                    'doc_number'        => $financialDcDetail->documnet_code,
                    'doc_date'          => $financialDcDetail->documnet_date,
                    'is_warranty'          => $financialDcDetail->is_warranty,
                    'status'            => $financialDcDetail->financialDocumentStatus->title,
                    'payment_type'      => $financialDcDetail->paymentType->title,
                    'bank'              => $financialDcDetail->bank_id ? $financialDcDetail->bank->title : '',
                    'content_to_organization_base_field_id'   => $financialDcDetail->content_to_organization_base_field_id ? $financialDcDetail->content_to_organization_base_field_id : '-',
                    'debtor'            => implode('/',$this->getFinancialHedingTitles($financialDcDetail->financial_heading_detail_id)) .'/'. $owner['name']
                );
                
            }
        }
        else return false;

        return $this->financialDocumentDetailArray;
    }
    
    public function inventoryDeduction($userId,$amount,$type,$desc='کسر از موجودی کیف پول بابت شهریه')
    {
        $payment = new Payment;
        $payment->user_id               = $userId;
        $payment->amount                = substr_replace($amount ,"",-1);  // مبلغ تبدیل به تومان شده است
        $payment->is_success            = 1;
        $payment->type                  = $type;
        $payment->description           = $desc;
        $payment->create_date           = date('Y-m-d H:i:s');
        $payment->organization_id       = yii::$app->fcore->getOrganization(); 
        $payment->create_user_id        = yii::$app->user->id;
        if(!$payment->save(true))
        {
            print_r($payment->getErrors()); 
            return false;
        }
        else return true;
    }

    public function getFinancialdocumentsFactor($financialDocumentId,$organization,$academicYearId)
    {
        $financialDocumentsDetail = FinancialDocumentFactors::findAll(['financial_document_id' => $financialDocumentId,'is_deleted' => 0]) ;
        if($financialDocumentsDetail)
        {
            foreach($financialDocumentsDetail As $financialDcFactor)
            {    
                $deptorName = $this->getFinancialAccountsOwner($organization,$academicYearId,$financialDcFactor->return_id,$financialDcFactor->return_type_id);
                $this->financialDocumentFactorArray[$financialDcFactor->id] = array(
                    'amount'         => $financialDcFactor->amount,
                    'debptorInfo'    => $deptorName['name'],
                    'note'           => $financialDcFactor->description,
                    'expense_center' => $financialDcFactor->financial_account_organization_id ? $financialDcFactor->financialAccounts->title : 'کل مجموعه(عمومی)'
                );
            }
        }
        else return false;

        return $this->financialDocumentFactorArray;
    }

    public function getFinancialdocumentsReturnIdAsDropDown($returnId,$returnTypeId,$organizationId,$academicYearId,$alt = 1,$num = 1,$select2 = true)
    {
        switch($returnTypeId)
        {
            case 1: // is user
                $condition = [
                    'user_id' => $returnId,
                ];
                $academicYearId ? $condition['academic_year_id'] = $academicYearId : null;

                $isPersonal = JobDetail::find()->where($condition)->andWhere(
                    ['IN','organization_id',array_keys(yii::$app->fcore->getAllOrganization())])->one();
                if($isPersonal)
                {
                    $jobDetails   = JobDetail::find()->where(['IN','organization_id',array_keys(yii::$app->fcore->getAllOrganization())]);
                    $academicYearId ?  $jobDetails->andWhere(['academic_year_id' => $academicYearId]) : $jobDetails->andWhere(['academic_year_id' => yii::$app->fcore->getAcademicYear()]);   
                    $jobDetails = $jobDetails->all();

                    $usersArr = ArrayHelper::map($jobDetails,function($data){
                        return 'personal-' . $data->profiles->user_id;
                        },function($data){
                            return $data->profiles->name.' '.$data->profiles->lname;
                    });
                    $selected = 'personal-' . $returnId; 
                    $show = 'personal';
                }
                else  // is student
                { 
                    $show = 'student';
                    $condition = [
                        'organization_id'     => array_keys(yii::$app->fcore->getAllOrganization()),
                    ];
                    $academicYearId ? $condition['academic_year_id'] = $academicYearId : null;

                    $stuAcademic        = Academic::find()->where($condition)->all();

                    $usersArr = ArrayHelper::map($stuAcademic,function($data){
                        return 'students-' . $data->profiles->user_id;
                        },function($data){
                            return $data->profiles->name.' '.$data->profiles->lname;
                    });
                    $selected = 'students-' . $returnId; 
                }
                $outuput =  '   <div class="col-xs-12 col-md-6 col-lg-2"><label class="control-label label-mini">انتخاب کنید</label>'; 
                if($select2)
                    $outuput .= Select2::widget([
                        'name' => 'financial-heading-group['.$alt.'][]',
                        'value' => $selected,
                        'data' => $usersArr,
                        'options' => [
                            'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                            'placeholder' => 'انتخاب کنید...',
                            'alt' => $alt,
                            'num' => $num,
                            'class' => 'financial-heading'
                        ], 
                    ]);

                else $outuput  .= Html::dropDownList('financial-heading-group['.$alt.'][]',$selected,$usersArr,[
                    'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                    'prompt' => 'انتخاب کنید...',
                    'alt' => $alt,
                    'num' => $num ,
                    'class' => 'financial-heading form-control',
                    ]);

                return $outuput.
                '</div>';

                break;

            case 2: // is financial account
                $finanAccOrg = FinancialAccounts::findOne($returnId);
                $banksArray  = $financialAccArr = [];
                if($finanAccOrg)
                { 
                    //------------- get other account childs 
                    $finanAcc = FinancialAccounts::find()->where([
                        'financial_account_type_id' => $finanAccOrg->financial_account_type_id,
                        'bank_id' => $finanAccOrg->bank_id,
                        'organization_id' => yii::$app->fcore->getOrganization()])->all();
                    $financialAccArr  = ArrayHelper::map($finanAcc,function($data){
                        $id =  'account-'.$data->id;
                        if($id) return $id;
                        },function($data){
                            $accounNumber =  $data->account_number ?  '('.$data->account_number.')' : '';
                            return $data->title . $accounNumber;
                    });

                    $financialAccounts = FinancialAccounts::find()
                    ->select('bank_id')
                    ->distinct()
                    ->where([
                        'financial_account_type_id' => 2,
                    ])
                    ->andWhere(['NOT',['bank_id' => null]])
                    ->andWhere(['IN','organization_id', array_keys(yii::$app->fcore->getAllOrganization())])
                    ->all();


                    $banksArray = ArrayHelper::map($financialAccounts,function($data){
                        $id = $data->bank_id ? 'bank-'.$data->bank_id : null;
                        if($id) return $id;
                        },function($data){
                            if($data->bank_id)
                            { 
                                return $data->bank->title;   
                            }
                    }); 
                }

                return '<div class="col-xs-12 col-md-6 col-lg-2"><label class="control-label label-mini">انتخاب کنید</label>'. 
                Html::dropDownList('financial-heading-group['.$alt.'][]','bank-'.$finanAccOrg->bank_id,$banksArray,[
                    'class' => 'form-control financial-heading',
                    'alt' => $alt,
                    'dir' => 'rtl',
                    'num' => $num,
                    'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                ]) .
                '</div>
                <div class="col-xs-12 col-md-6 col-lg-2"><label class="control-label label-mini">انتخاب کنید</label>'. 
                Html::dropDownList('financial-heading-group['.$alt.'][]','account-'.$finanAccOrg->id,$financialAccArr,[
                    'class' => 'form-control financial-heading',
                    'alt' => $alt,
                    'dir' => 'rtl',
                    'num' => $num+1,
                    'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                ]) .
                '</div>';

                break;

            case 3: // other users outside system
                return $show = 'other 3';
                break;

            case 4: // if financial headings

                $finanHeading = FinancialHeadingDetail::findAll(['parent_id' => $returnId]);
                $arrFinanhead = ArrayHelper::map($finanHeading,'id',
                    function($data)
                    {
                        return yii::$app->fstring->translateDigits($data->alias_number).' - '.$data->financialHeading->title;
                    }
                );
                $outuput = '<div class="col-xs-12 col-md-6 col-lg-2"><label class="control-label label-mini">انتخاب کنید</label>'; 
                if($select2)
                    $outuput .= Select2::widget([
                        'name' => 'financial-heading-group['.$alt.'][]',
                        'value' => null,
                        'data' => $arrFinanhead,
                        'options' => [
                            'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                            'placeholder' => 'انتخاب کنید...',
                            'alt' => $alt,
                            'num' => $num,
                            'class' => 'financial-heading'
                        ], 
                    ]);                        
                else $outuput  .= Html::dropDownList('financial-heading-group['.$alt.'][]',null,$arrFinanhead,[
                    'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                    'prompt' => 'انتخاب کنید...',
                    'alt' => $alt,
                    'num' => $num ,
                    'class' => 'financial-heading form-control',
                    ]);
                $outuput .= '</div>';
                return $outuput.
                '</div>';
                break;

            case 6: // if financial tags
                return $show = 'other 6';
                break;

            case 5: // if financial headings
                $condition = [
                    'job_id' => 129,
                ];
                $academicYearId ? $condition['academic_year_id'] = $academicYearId : null;

                $envoys = JobDetail::find()->where($condition)
                ->andWhere([
                    'IN','organization_id' , array_keys(yii::$app->fcore->getAllOrganization())
                ])
                ->all();
                $envoysArray = ArrayHelper::map($envoys,function($data){
                    return 'envoys-'.$data->user_id;
                    },function($data){
                        return $data->profiles->name .' ' . $data->profiles->lname;
                }) ;
                return '   <div class="col-xs-12 col-md-6 col-lg-2"><label class="control-label label-mini">انتخاب کنید</label>'. 
                Html::dropDownList('financial-heading-group['.$alt.'][]','envoys-'.$returnId,$envoysArray,[
                    'class' => 'form-control financial-heading',
                    'alt' => $alt,
                    'dir' => 'rtl',
                    'num' => $num,
                    'id' => 'financial-heading-'.Utility::generateRandomString(7,true),
                ]) .
                '</div>';
                break; 
            default: // other users outside system
                die('not defined in financialcomponents');
                break;
        }     

        $defaultAcademicYear  =  $academicYearId; 
    }

    public function getExpenseCenters()
    {
        $expenseCenters = FinancialAccounts::findAll(['financial_account_type_id' => 7,'organization_id' => yii::$app->fcore->getOrganization()]);
        return  ArrayHelper::map($expenseCenters,'id','title');
    }

    public function checkDebtorOrCreditor($returnId,$returnTypeId,$academicYearId)
    {
        $pays = $gets = $getsCredit = 0;
        if($academicYearId)
            $academicYear = " AND (fd.academic_year_id = :academic_year_id)";
        else $academicYear = '';
        $connection = Yii::$app->getDb();
        if($returnId)
        {    
            $sql =  "
            SELECT
            fd.id,
            fd.return_id as from_return_id,
            fd.return_type_id as from_return_type_id,
            fd.organization_id,
            fd.academic_year_id,
            fd.create_date,
            fdd.payment_type_id,
            sum(fdd.amount) as amount,
            sum(fdd.credit_amount) as credit_amount,
            pt.title AS payment_type,
            fds.title AS d_status,
            fds.color AS color,
            fdd.documnet_date ,
            fdd.return_id AS  to_return_id,
            fdd.return_type_id AS to_return_type_id
            FROM tbl_financial_documents fd
            JOIN tbl_financial_document_detail fdd ON (fd.id = fdd.financial_document_id)
            JOIN tbl_payment_type pt on (fdd.payment_type_id = pt.id)
            JOIN tbl_financial_document_status fds ON (fdd.financial_document_status_id = fds.id)
            WHERE fd.organization_id=".yii::$app->fcore->getOrganization()." AND fdd.is_deleted = 0
            AND ( (fd.return_id IN (:returnId)  AND fd.return_type_id = :return_type_id) OR (fdd.return_id IN (:returnId) AND fdd.return_type_id = :return_type_id))
            $academicYear
            GROUP BY
            fd.id,fdd.return_id
            ORDER BY fd.id DESC";

            $command = $connection->createCommand($sql);
            $rows = $command
            ->bindValue(':academic_year_id', $academicYearId)
            ->bindValue(':return_type_id', $returnTypeId)
            ->bindValue(':returnId', $returnId)
            ->queryAll();

            if($rows)
            {

                foreach($rows as $row)
                {
                    if($row['from_return_id'] == $returnId)
                    {
                        $pays += $row['amount'];
                    }
                    else
                    {
                        $gets       += $row['amount'];
                        $getsCredit += $row['credit_amount'] ? $row['credit_amount'] : 0;
                    }
                }
                $result = $gets - $pays;

                if($result > 0) 
                    $status  = 'creditor';
                else 
                    $status  = 'deptor';
            }
            else 
            {
                $result  = '0';  
                $status  = 'creditor';
            }
            $accountInfo = $this->getFinancialAccountsOwner(yii::$app->fcore->getOrganization(),$academicYearId,$returnId,$returnTypeId);
            $image = $contact =  null ;
            if($accountInfo['type'] == 'student' || $accountInfo['type'] == 'personal' || $accountInfo['type'] == 'parent')
            {
                if($accountInfo['type'] == 'personal')
                {
                    $image  = yii::$app->fuser->getUserImage($returnId,false,true);
                }
                else
                {
                    $image  = yii::$app->fuser->getUserImage($returnId,$academicYearId);
                }  
                $contact    = yii::$app->fuser->getUserContactInfo($returnId);
            }

            return array(     
                'result'        => $result , 
                'status'        => $status,
                'gets'          => $gets ,   
                'pays'          => $pays ,  
                'getsCredit'    => $getsCredit ,  
                'accountName'   => $accountInfo['name'],
                'image'         => $image,
                'contact'       => $contact,
                'showNumber'    => 'yes',
            );
        }
        else
        {
            $accountInfo = $this->getFinancialAccountsOwner(yii::$app->fcore->getOrganization(),$academicYearId,$returnId,$returnTypeId);
            return array(     
                'result' => 0 , 
                'status' => 'deptor', 
                'gets' => 0 ,   
                'pays' => 0 , 
                'getsCredit'    => 0 , 
                'accountName'   => $accountInfo['name'],
                'image'         => null,
                'contact' => null,
                'showNumber' => 'no',
            );
        } ;
    } 

    public function checkDebtorOrCreditorByHeading($financialHeadingId,$academicYearId)
    {
        $rows = false;
        
        if($academicYearId)
            $academicYear = " AND (fd.academic_year_id = $academicYearId)";
        else $academicYear = '';

        $headings   =   array();
        $this->financialHeadingArray   =   array();
        $headings = $this->getSubHeadingsFromHeadings($financialHeadingId,false,true);
        if($headings)
        {
            /*if( (yii::$app->user->id == 1 || (yii::$app->user->id == 963))  && $financialHeadingId == 1142)
            {
                print_r($headings);
                die;
            }*/
            
            $allFinancialHeading =  $headings ? array_keys($headings) : [];
            
            $connection = Yii::$app->getDb();
            $sql = "
                        SELECT
                            fd.id,
                            fd.return_id as from_return_id,
                            fd.return_type_id as from_return_type_id,
                            fd.organization_id,
                            fd.academic_year_id,
                            fd.financial_heading_detail_id AS from_financial_heading_detail_id,
                            fd.create_date,
                            fdd.payment_type_id,
                            sum(fdd.amount) as amount,
                            pt.title AS payment_type,
                            fds.title AS d_status,
                            fds.color AS color,
                            fdd.documnet_date ,
                            fdd.return_id AS  to_return_id,
                            fdd.financial_heading_detail_id AS to_financial_heading_detail_id,
                            fdd.return_type_id AS to_return_type_id
                        FROM tbl_financial_documents fd
                            JOIN tbl_financial_document_detail fdd ON (fd.id = fdd.financial_document_id)
                            JOIN tbl_payment_type pt on (fdd.payment_type_id = pt.id)
                            JOIN tbl_financial_document_status fds ON (fdd.financial_document_status_id = fds.id)
                        WHERE fd.organization_id=".yii::$app->fcore->getOrganization()." AND fdd.is_deleted = 0
                        AND (fd.financial_heading_detail_id  IN (".implode(',',$allFinancialHeading).") OR fdd.financial_heading_detail_id  IN (".implode(',',$allFinancialHeading)."))
                        $academicYear
                        GROUP BY
                        fd.id,fdd.return_id
                        ORDER BY fd.id DESC";
            /*if(yii::$app->user->id == 963)
            {
                echo $sql;die;
            }*/
            $command = $connection->createCommand($sql);
            $rows = $command
            //->bindValue(':academic_year_id', $academicYearId)
            //->bindValue(':allFinancialHeading', implode(',',$allFinancialHeading))
            ->queryAll();
            
        }
        $pays = $gets = 0;
        if($rows)
        {

            foreach($rows as $row)
            {
                if(in_array($row['from_financial_heading_detail_id'],$allFinancialHeading))
                {
                    $pays += $row['amount'];
                }
                else
                {
                    $gets += $row['amount'];
                }
            }
            $result = $gets - $pays;

            if($result > 0) 
                $status  = 'creditor';
            else 
                $status  = 'deptor';
        }
        else 
        {
            $result = '0';  
            $status  = 'creditor';
        }
        
        $accountInfo = $this->getFinancialAccountsOwner(yii::$app->fcore->getOrganization(),$academicYearId,$financialHeadingId,4);
        $image = $contact =  null ;
        if($accountInfo['type'] == 'student' || $accountInfo['type'] == 'personal' || $accountInfo['type'] == 'parent')
        {
            if($accountInfo['type'] == 'personal')
            {
                $image  = yii::$app->fuser->getUserImage($returnId,false,true);
            }
            else
            {
                $image  = yii::$app->fuser->getUserImage($returnId,$academicYearId);
            }  
            $contact    = yii::$app->fuser->getUserContactInfo($returnId);
        }

        return array(     
            'result' => $result , 
            'gets' => $gets ,   
            'pays' => $pays , 
            'status' => $status, 
            'accountName' => $accountInfo['name'],
            'image' => $image,
            'contact' => $contact,
            'showNumber' => 'yes',
        );
    }

    public function getReturnLabelById($returnId,$returnTypeId,$academicYearId)
    {
        switch($returnTypeId)
        {
            case 1: // is user
                $isPersonal = JobDetail::find()->where([
                    'academic_year_id' => $academicYearId,
                    'user_id' => $returnId,
                ])
                ->andWhere(['IN','organization_id',array_keys(yii::$app->fcore->getAllOrganization())])
                ->one();
                if($isPersonal)
                {
                    $faLable = 'پرسنل';
                    $enLable = 'personal';
                }
                else
                {
                    $faLable = 'دانش‌آموز';
                    $enLable = 'student';
                }
                break;
            case 2: 
                $faLable = 'حساب مالی';
                $enLable = 'account';
                break;

            case 3: 
                $faLable = 'کاربر خارج از سیستم';
                $enLable = 'outside';
                break;

            case 4: 
                $faLable = 'سرفصل مالی';
                $enLable = 'heading';
                break;

            case 5: 
                $faLable = 'تنخواه‌گردان';
                $enLable = 'envoys';
                break;

            case 6: 
                $faLable = 'برچسب مالی';
                $enLable = 'tags';
                break;

            default: 
                die('Not Defined In getReturnLabelById Method in Financial Component!');
                break;

        }
        return ['faLabel' => $faLable,'enLabel' => $enLable];
    }

    public function getReturnTypeIdByLabel($returnLabel)
    {
        switch($returnLabel)
        {
            case 'personals': // is user
            case 'personal': // is user
            case 'student': // is user
            case 'students': // is user
                return 1;
                break;

            case 'bank': 
            case 'banks': 
            case 'account': 
            case 'accounts': 
                return 2;
                break;

            case 'outside': 
            case 'outsides': 
                return 3;
                break;

            case 'heading': 
            case 'headings': 
                return 4;
                break;

            case 'envoys': 
            case 'envoy': 
                return 5;

            case 'tag': 
            case 'tags': 
                return 6;
                break;

            default: 
                die( $returnLabel . '=> Not Defined In getReturnIdByLabel Method in Financial Component!');
                break;

        }
    }

    public function getDepositBankAccountSum($userId,$bankAccountcardId)
    {
        return $finacialDocumentDetail = FinancialDocumentDetail::find()
        ->where(['return_id' => $userId,'bank_account_card_id' =>$bankAccountcardId])
        ->andWhere(['OR' ,['is_approved' => 1],['is_approved' => 2]])
        ->sum('amount');
    }

    public function getRemovalBankAccountSum($userId,$bankAccountcardId)
    {
        return $finacialDocumentDetail = FinancialDocumentDetail::find()
        ->alias('fdd')
        ->joinWith('financialDocument fd')
        ->where(['fd.return_id' => $userId,'fdd.bank_account_card_id' => $bankAccountcardId])
        ->sum('amount');
    }

    public function getSubHeadingsFromHeadings($root,$getOneLevel = false,$addRootIdToOutput = false)
    {
        if($addRootIdToOutput)
        {
           $child = FinancialHeadingDetail::findOne($root);
           if($child)
           $this->financialHeadingArray[$child->id] = $child->financialHeading->title; 
        }
        
        $childs = FinancialHeadingDetail::findAll(['parent_id' => $root]);
        if($childs)
        {
            if(count($childs) == 1)
            {    
                if($childs[0]->final_action)
                {
                    /*$financialAccounts = FinancialAccounts::find()
                    ->where([
                    'financial_account_type_id' => 2,
                    ])
                    ->andWhere(['IN','organization_id', array_keys(yii::$app->fcore->getAllOrganization())])
                    ->andWhere(['NOT',['bank_id' => null]])
                    ->all(); */
                    $this->financialHeadingArray[$childs[0]->parent_id] = $childs[0]->financialHeading->title;
                }
            }
            else
            { 
                foreach($childs AS $child)
                {
                    $this->financialHeadingArray[$child->id] = $child->financialHeading->title;
                    if(!$getOneLevel)
                        self::getSubHeadingsFromHeadings($child->id);
                }
            }
            return $this->financialHeadingArray; 
        }
        else return false;
    }

    public function getSelected($stringElemnts)
    {
        $exp = explode('</option>',$stringElemnts);
        foreach($exp as $elemnt)
        {
            if(strpos($elemnt,'selected') !== false)
            {
                $value = Utility::explodText($elemnt,1,'"');
                $title = Utility::explodText($elemnt,1,'>');
                return array('value' => $value, 'title' => $title);
            }
        }
        return false;
    }
    
    public function checkPayedMainTuitionsBySchedule($userId,$contentToOrgBaseFieldId)
    {
          $contentToOrganizationBaseField = ContentToOrganizationBaseField::findOne($contentToOrgBaseFieldId);
                                                                    /*->alias('cobf')
                                                                    ->select('cpf.property_field_id')
                                                                    ->join('INNER JOIN','{{%content_to_property_field}} cpf','cobf.content_id = cpf.content_id')
                                                                    ->where(['cobf.id' => $contentToOrgBaseFieldId])
                                                                    ->one();*/
          if($contentToOrganizationBaseField)
          {
              $contentToPropertyField = ContentToPropertyField::find()->where(['content_id' => $contentToOrganizationBaseField->content_id])->one();
              if($contentToPropertyField)
              {
                  if($contentToPropertyField->property_field_detail_id == '6')
                  {
                       $financialDocumentDetail = FinancialDocumentDetail::find()
                                                    ->alias('fdd')
                                                    ->joinWith('financialDocument fd')
                                                    ->where(['fd.return_id' => $userId,'fd.return_type_id' => 1,'fdd.payment_type_id' => 11,'fdd.is_deleted' => 0])
                                                    ->all();
                       if(count($financialDocumentDetail))
                            return 1;
                       else return 0;
                  }
                  else return $contentToOrgBaseFieldId; 
              }
              else return $contentToOrgBaseFieldId;
          }
          return  $contentToOrgBaseFieldId;
    }
}
?>