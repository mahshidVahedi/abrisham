<?php
namespace common\components;

use yii;
use backend\models\Organizations;
use backend\models\OrganizationBaseToField;
use backend\models\OrganizationToBase;
use backend\models\Module;
use backend\models\Workflow;
use backend\models\RegisterStatus;

class DetailViewHelper {

    public static function getOrganizationTitle($data)
    {
        $org = Organizations::find($data->id);
        return $org->title; 
    }

    public static function getOrgTitleByOrganizationBaseToFielID($orgBaseFieldID)
    {
        $orgBaseField       = OrganizationBaseToField::find()->where(['id'=>$orgBaseFieldID])->one();
        $organizationToBase = OrganizationToBase::findOne($orgBaseField->organization_to_base_id);
        $organization       = $organizationToBase->organization->title;
        return $organization;
    }    

    public static function getAcademicYearTitleByOrganizationBaseToFielID($orgBaseFieldID)
    {
        $orgBaseField       = OrganizationBaseToField::find()->where(['id'=>$orgBaseFieldID])->one();
        $organizationToBase = OrganizationToBase::findOne($orgBaseField->organization_to_base_id);
        $academic           = $organizationToBase->academicYear->title;
        return $academic;
    }

    public static function getBaseTitleByOrganizationBaseToFielID($orgBaseFieldID)
    {
        $orgBaseField       = OrganizationBaseToField::find()->where(['id'=>$orgBaseFieldID])->one();
        $organizationToBase = OrganizationToBase::findOne($orgBaseField->organization_to_base_id);
        $base               = $organizationToBase->base->title;
        return $base;
    }    

    public static function getFieldTitleByOrganizationBaseToFielID($orgBaseFieldID)
    {
        $orgBaseField       = OrganizationBaseToField::find()->where(['id'=>$orgBaseFieldID])->one();
        return $orgBaseField->field->title;
    }    

    public static function getModuleTitleByID($ID)
    {
        $module = Module::findOne($ID);
        return $module->title;
    }

    public static function getWorkflowTitleByID($ID)
    {
        if($ID)
        {
            $workflow = Workflow::findOne($ID);
            return $workflow->title;
        }
        else return '-';
    }    

    public static function getStudentTypeTitle($studentType)
    {
        switch($studentType)
        {
            case 0:
                $note = 'خودی/فعلی';
                break;
            case 1:
                $note ='جدید';
                break;
            case 2:
                $note='هر دو نوع';
                break;
        } 
        return $note;
    }    
    
    public static function getRegisterStatusTitleByID($ID)
    {
        $status = RegisterStatus::findOne($ID);
        return $status->title;
    }

}

?>