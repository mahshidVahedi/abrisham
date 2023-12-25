<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use  yii\helpers\ArrayHelper;
use  backend\models\EstimateLessonToTypeScore;
use  backend\models\EstimateScoreType;
use  backend\models\EstimateScoreTypeDetail;
use  backend\models\EstimateAcademicToScore;
use  backend\models\ConseptToLesson;
use  backend\models\ConseptLessonToField;
use  backend\models\ConseptLessonFieldToGroup;
use  backend\models\OrganizationBaseToField;
use  backend\models\LessonToBaseNew;
use  backend\models\ModuleDetailAssign;
use  backend\models\OrganizationBaseLessonFieldToGroup;
use  backend\models\EstimateAcademicToScoreComapct;
use  backend\models\Academic;
use  backend\models\AcademicAbsentAndDelay;


class FEstimateComponent extends Component
{
    private
        $lastScoreDate,
        $minScore,
        $maxScore,
        $scores,
        $qualitativeAvg = 0,
        $qualitativeAvgWithZero = 0,
        $qualitativeUnit = 0,
        $qualitativeUnitWithZero = 0,
        $quantitativeMustPassUnit = 0,
        $quantitativePassedUnit = 0,
        $quantitativeMustPassUnitRelative = 0,
        $quantitativePassedUnitRelative = 0,
        $avgMain = 0,
        $unitMain = 0,
        $maxPixel = 0,
        $conseptsId = array(),
        $statusMain = '';

    public
        $conseptSum,
        $listConseptScore = array(),
        $conseptUnitsSum = 0,
        $lessonSum = 0,
        $lessonUnitsSum = 0;

    public function getScoreLabel($lessonToBase, $organizationId, $score, $type = 'showScore')
    {
        $relation = $type == 'showScore' ? 'estimateShowScoreType' : 'estimateScoreType';
        $scoreType = EstimateLessonToTypeScore::find()->where(['lesson_to_base_id' => $lessonToBase, 'organization_id' => $organizationId])->one();
        if ($scoreType) {

            $calculationCoefficient = $scoreType->{$relation}->calculation_coefficient;
            if ($scoreType->{$relation}->is_descriptive) {

                $scoreTypeDetail = EstimateScoreTypeDetail::find()->where(['estimate_score_type_id' => $scoreType->estimate_show_score_type])->all();
                if ($scoreTypeDetail) {
                    $arrTempMax = array();
                    $score = $score / $calculationCoefficient;
                    foreach ($scoreTypeDetail as $key => $scoreDetail) {
                        $arrTempMax[$key]['number'] = $scoreDetail->max_number;
                        $arrTempMax[$key]['color'] = $scoreDetail->color;
                        $arrTempMax[$key]['title'] = $scoreDetail->title;
                        if ($score > $scoreDetail->min_number && $score <= $scoreDetail->max_number) {
                            return array('title' => $scoreDetail->title, 'color' => $scoreDetail->color, 'note' => '', 'score' => $score, 'calculationCoefficient' => $calculationCoefficient);
                        }
                    }
                    ArrayHelper::multisort($arrTempMax, ['number'], [SORT_DESC]);
                    $first = reset($arrTempMax);
                    $end = end($arrTempMax);

                    if ($score > $first['number'])
                        return array('title' => $first['title'], 'color' => $first['color'], 'note' => '', 'score' => $score, 'calculationCoefficient' => $calculationCoefficient);
                    //else
                    //return array('title' => $end['title'],'color' => $end['color'],'note' => '');
                } else if (!$scoreType->estimateShowScoreType->is_descriptive) {
                    $limitation = $scoreType->{$relation}->max_number / 5;
                    $before = $score;
                    $score = round($score / $scoreType->{$relation}->calculation_coefficient, 2);
                    $title = $score / $limitation;
                    /*if($score == $before)
                    {
                    $title = $score/$scoreType->{$relation}->max_number;
                    $score = $score/$title;
                    $title += 0.1;
                    }
                    else if($title > 5)
                    {
                    $title = $score/$scoreType->{$relation}->max_number;
                    $score = $score/$title;
                    } */
                    switch (true) {
                        case $title > 4 and $title <= 5:
                            $color = 'bg-color-grass-green ';
                            break;
                        case $title > 3 and $title <= 4:
                            $color = 'bg-color-spring-green ';
                            break;
                        case $title > 2 and $title <= 3:
                            $color = 'bg-color-dark-yellow ';
                            break;
                        case $title > 1 and $title <= 2:
                            $color = 'bg-color-light-orange ';
                            break;
                        case $title <= 1:
                            $color = 'bg-color-red ';
                            break;
                        default:
                            $color = 'label-info ' . $limitation . '@' . $title . '->' . $score . '#' . $before;
                            break;

                    }
                    //if($score > $first['number'])
                    //return array('title' => $first['title'],'color' => $first['color'],'note' => '','score' => $score);
                    return array('title' => $score, 'color' => $color, 'note' => '', 'score' => $score, 'calculationCoefficient' => $calculationCoefficient);
                } else return array('title' => '-', 'color' => 'label-info', 'note' => 'جزئیات نمره‌دهی  ' + $scoreType->title . ' در سیستم تعیین نشده است!', 'score' => '-', 'calculationCoefficient' => 1);
            } else {

                $limitation = $scoreType->{$relation}->max_number / 5;
                $before = $score;
                $score = round($score / $calculationCoefficient, 2);
                $title = $score / $limitation;
                /*if($score == $before)
                {
                $title = $score/$scoreType->{$relation}->max_number;
                $score = $score/$title;
                $title += 0.1;
                }
                else if($title > 5)
                {
                $title = $score/$scoreType->{$relation}->max_number;
                $score = $score/$title;
                } */
                switch (true) {
                    case $title > 4 and $title <= 5:
                        $color = 'bg-color-grass-green ';
                        break;
                    case $title > 3 and $title <= 4:
                        $color = 'bg-color-spring-green ';
                        break;
                    case $title > 2 and $title <= 3:
                        $color = 'bg-color-dark-yellow ';
                        break;
                    case $title > 1 and $title <= 2:
                        $color = 'bg-color-light-orange ';
                        break;
                    case $title <= 1:
                        $color = 'bg-color-red -';
                        break;
                    default:
                        $color = 'label-info ' . $limitation . '@' . $title . '->' . $score . '#' . $before;
                        break;

                }
                //if($score > $first['number'])
                //return array('title' => $first['title'],'color' => $first['color'],'note' => '','score' => $score);
                return array('title' => $score, 'color' => $color, 'note' => '', 'score' => $score);
            }

            $scoreTypeDetail = EstimateScoreTypeDetail::find()->where(['estimate_score_type_id' => $scoreType->estimate_show_score_type])->all();
            if ($scoreTypeDetail) {
                foreach ($scoreTypeDetail as $key => $scoreDetail) {
                    if ($score >= $scoreDetail->min_number && $score <= $scoreDetail->max_number) {
                        return array('title' => $scoreDetail->title, 'color' => $scoreDetail->color, 'note' => '', 'score' => $score);
                    }
                }
            }
            return array('title' => '-', 'color' => 'bg-muted2', 'note' => 'نمره‌ وجود ندارد!');
        } else return array('title' => '!', 'color' => 'label-info', 'note' => 'روش نمره‌دهی تعیین نشده است!');
    }

    public function getScoreLabelByOrganizationBaseFieldId($organizationBaseFieldId, $score, $type = 'scoreType')
    {
        $relation = ($type == 'showScore') ? 'estimateShowScoreType' : 'estimateScoreType';
        $organizationBaseField = OrganizationBaseToField::findOne($organizationBaseFieldId);
        if ($organizationBaseField) {
            if ($organizationBaseField->estimate_score_type_id) {
                if ($organizationBaseField->{$relation}->is_descriptive) {
                    $calculationCoefficient = $organizationBaseField->{$relation}->calculation_coefficient;
                    $scoreTypeDetail = EstimateScoreTypeDetail::find()->where(['estimate_score_type_id' => $organizationBaseField->estimate_score_type_id])->all();
                    if ($scoreTypeDetail) {
                        $arrTempMax = array();
                        $score = $score / $calculationCoefficient;
                        foreach ($scoreTypeDetail as $key => $scoreDetail) {
                            $arrTempMax[$key]['number'] = $scoreDetail->max_number;
                            $arrTempMax[$key]['color'] = $scoreDetail->color;
                            $arrTempMax[$key]['title'] = $scoreDetail->title;
                            if ($score > $scoreDetail->min_number && $score <= $scoreDetail->max_number) {
                                return array('title' => $scoreDetail->title, 'color' => $scoreDetail->color, 'note' => '', 'score' => $score);
                            }
                        }
                        ArrayHelper::multisort($arrTempMax, ['number'], [SORT_DESC]);
                        $first = reset($arrTempMax);
                        $end = end($arrTempMax);

                        if ($score > $first['number'])
                            return array('title' => $first['title'], 'color' => $first['color'], 'note' => '', 'score' => $score);


                    } else return array('title' => '-', 'color' => 'label-info', 'note' => 'خطای دریافت اطلاعات سبک نمره‌دهی');
                } else {

                    $limitation = $organizationBaseField->{$relation}->max_number / 5;
                    $score = $organizationBaseField->{$relation}->calculation_coefficient ? round($score / $organizationBaseField->{$relation}->calculation_coefficient, 2) : 0;
                    $title = $limitation ? $score / $limitation : 0;
                    switch (true) {
                        case ($title > 4 and $title <= 5):
                            $color = 'bg-color-grass-green';
                            break;
                        case ($title > 3 and $title <= 4):
                            $color = 'bg-color-spring-green';
                            break;
                        case ($title > 2 and $title <= 3):
                            $color = 'bg-color-dark-yellow';
                            break;
                        case ($title > 1 and $title <= 2):
                            $color = 'bg-color-light-orange';
                            break;
                        case ($title <= 1):
                            $color = 'bg-color-red';
                            break;
                        default:
                            $color = 'label-info';
                            break;

                    }
                    return array('title' => $score, 'color' => $color, 'note' => '', 'score' => $score);
                }
            } else return array('title' => 'معدل کل دروس تنظیم نشده است', 'color' => '', 'note' => 'نمایش معدل کل دروس این رشته و پایه در کارنامه تنظیم نگردیده است');
        } else return array('title' => 'روش نمره‌دهی تعیین نشده', 'color' => '', 'note' => 'روش نمره‌دهی تعیین نشده است!');
    }

    public function getLessonUnit($organizationBaseLessonField, $organizationGroup)
    {
        $oblfg = OrganizationBaseLessonFieldToGroup::findOne(['organization_base_lesson_field_id' => $organizationBaseLessonField, 'organization_group_id' => $organizationGroup]);
        if ($oblfg)
            return $oblfg->unit;
        else return 1;
    }

    public function checkMaxPixelAndAvgCount($organizationBaseFieldObj, $getOnlySettingValues = false)
    {
        if (!$getOnlySettingValues) {
            $lessonItems = LessonToBaseNew::find()
                ->select('lb.*,oblfg.unit')
                ->alias('lb')
                ->joinWith('organizationBaseLessonToFields oblf')
                ->joinWith('organizationBaseLessonToFields.organizationBaseLessonFieldToGroups oblfg')
                ->where([
                    'lb.organization_base_id' => $organizationBaseFieldObj->organization_to_base_id,
                    'oblf.field_id' => $organizationBaseFieldObj->field_id,
                    'oblf.is_enable' => 1,
                    'oblfg.is_enable' => 1,
                ])
                ->orderBy(['oblfg.position' => SORT_ASC])
                ->all();
            if ($lessonItems) {
                foreach ($lessonItems as $lessonToBase) {
                    $scoreType = EstimateLessonToTypeScore::find()->where(['lesson_to_base_id' => $lessonToBase, 'organization_id' => $organizationBaseFieldObj->organizationToBase->organization_id])->one();
                    if ($scoreType) {
                        if ($scoreType->estimateShowScoreType->is_descriptive) {
                            $scoreTypeDetail = EstimateScoreTypeDetail::find()->where(['estimate_score_type_id' => $scoreType->estimate_show_score_type])->all();
                            if ($scoreTypeDetail) {
                                $arrTempMax = array();
                                foreach ($scoreTypeDetail as $key => $scoreDetail) {
                                    $this->maxPixel = ($this->maxPixel > $scoreDetail->pixel_length) ? $this->maxPixel : $scoreDetail->pixel_length;
                                }
                            }
                        } else {
                            $this->maxPixel = $this->maxPixel > 25 ? $this->maxPixel : 25;
                        }
                    }
                }
            }
        }

        $moduleDetailAssign = ModuleDetailAssign::find()->where([
            'organization_id' => $organizationBaseFieldObj->organizationToBase->organization_id,
            'academic_year_id' => $organizationBaseFieldObj->organizationToBase->academic_year_id,
            'base_id' => $organizationBaseFieldObj->organizationToBase->base_id,
            'field_id' => $organizationBaseFieldObj->field_id,
            'state' => 1,
            //'type' => 1,
        ]);

        $moduleDetailAssign = $moduleDetailAssign->all();

        $averages = [2, 3, 4, 5, 12];
        $teacherAvgCount = $parentAvgCount = $studentAvgCount = 0;
        $teacherSelectedAvgs = $parentSelectedAvgs = $studentSelectedAvgs = array();
        $showAvgNumberToParent = $showAvgNumberToStudent = $showAvgNumberToTeachers = false;
        $expectationToParent = $expectationToStudent = $expectationToTeachers = false;
        $sumSubConseptsUnitToTeachers = $sumSubConseptsUnitToParent = $sumSubConseptsUnitToStudent = false;
        $studentsAssessmentTableToTeachers = $studentsAssessmentTableToParent = $studentsAssessmentTableToStudent = false;
        $studentsAssessmentEightWeekToTeachers = $studentsAssessmentEightWeekToParent = $studentsAssessmentEightWeekToStudent = false;
        $studentsAssessmentBaseAndClassToTeachers = $studentsAssessmentBaseAndClassToParent = $studentsAssessmentBaseAndClassToStudent = false;
        $termicWorkbookToParents = $profesinalWorkbookToParents = false;
        $termicWorkbookToStudents = $profesinalWorkbookToStudents = false;
        if ($moduleDetailAssign) {
            foreach ($moduleDetailAssign as $mdAssign) {
                if (in_array($mdAssign->module_detail_id, $averages)) {
                    switch ($mdAssign->type) {
                        case 1 :
                            $teacherAvgCount++;
                            $teacherSelectedAvgs[] = $mdAssign->module_detail_id;
                            break;
                        case 2 :
                            $parentAvgCount++;
                            $parentSelectedAvgs[] = $mdAssign->module_detail_id;
                            break;
                        case 3 :
                            $studentAvgCount++;
                            $studentSelectedAvgs[] = $mdAssign->module_detail_id;
                            break;
                    }

                }
                if ($mdAssign->module_detail_id == 9) {
                    switch ($mdAssign->type) {
                        case 1 :
                            $showAvgNumberToTeachers = true;
                            break;
                        case 2 :
                            $showAvgNumberToParent = true;
                            break;
                        case 3 :
                            $showAvgNumberToStudent = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 7) {
                    switch ($mdAssign->type) {
                        case 1 :
                            $expectationToTeachers = true;
                            break;
                        case 2 :
                            $expectationToParent = true;
                            break;
                        case 3 :
                            $expectationToStudent = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 13) {
                    switch ($mdAssign->type) {
                        case 1 :
                            $sumSubConseptsUnitToTeachers = true;
                            break;
                        case 2 :
                            $sumSubConseptsUnitToParent = true;
                            break;
                        case 3 :
                            $sumSubConseptsUnitToStudent = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 14) {

                    switch ($mdAssign->type) {
                        case 1 :
                            $studentsAssessmentTableToTeachers = true;
                            break;
                        case 2 :
                            $studentsAssessmentTableToParent = true;
                            break;
                        case 3 :
                            $studentsAssessmentTableToStudent = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 15) {
                    switch ($mdAssign->type) {
                        case 1 :
                            $studentsAssessmentEightWeekToTeachers = true;
                            break;
                        case 2 :
                            $studentsAssessmentEightWeekToParent = true;
                            break;
                        case 3 :
                            $studentsAssessmentEightWeekToStudent = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 16) {
                    switch ($mdAssign->type) {
                        case 1 :
                            $studentsAssessmentBaseAndClassToTeachers = true;
                            break;
                        case 2 :
                            $studentsAssessmentBaseAndClassToParent = true;
                            break;
                        case 3 :
                            $studentsAssessmentBaseAndClassToStudent = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 19) {

                    switch ($mdAssign->type) {
                        case 2 :
                            $profesinalWorkbookToParents = true;
                            break;
                        case 3 :
                            $profesinalWorkbookToStudents = true;
                            break;
                    }
                }

                if ($mdAssign->module_detail_id == 20) {
                    switch ($mdAssign->type) {
                        case 2 :
                            $termicWorkbookToParents = true;
                            break;
                        case 3 :
                            $termicWorkbookToStudents = true;
                            break;
                    }
                }
            }
        }
        return array(
            'pixelLength' => $this->maxPixel,

            'teacherAvgCount' => $teacherAvgCount,
            'parentAvgCount' => $parentAvgCount,
            'studentAvgCount' => $studentAvgCount,

            'teacherSelectedAvgs' => $teacherSelectedAvgs,
            'parentSelectedAvgs' => $parentSelectedAvgs,
            'studentSelectedAvgs' => $studentSelectedAvgs,

            'avgNumberToParent' => $showAvgNumberToParent,
            'avgNumberToStudent' => $showAvgNumberToStudent,
            'avgNumberToTeachers' => $showAvgNumberToTeachers,

            'expectationToParent' => $expectationToParent,
            'expectationToStudent' => $expectationToStudent,
            'expectationToTeachers' => $expectationToTeachers,

            'sumSubConseptsUnitToParent' => $sumSubConseptsUnitToParent,
            'sumSubConseptsUnitToStudent' => $sumSubConseptsUnitToStudent,
            'sumSubConseptsUnitToTeachers' => $sumSubConseptsUnitToTeachers,

            'studentsAssessmentTableToTeachers' => $studentsAssessmentTableToTeachers,
            'studentsAssessmentTableToParent' => $studentsAssessmentTableToParent,
            'studentsAssessmentTableToStudent' => $studentsAssessmentTableToStudent,

            'studentsAssessmentEightWeekToTeachers' => $studentsAssessmentEightWeekToTeachers,
            'studentsAssessmentEightWeekToParent' => $studentsAssessmentEightWeekToParent,
            'studentsAssessmentEightWeekToStudent' => $studentsAssessmentEightWeekToStudent,

            'studentsAssessmentBaseAndClassToTeachers' => $studentsAssessmentBaseAndClassToTeachers,
            'studentsAssessmentBaseAndClassToParent' => $studentsAssessmentBaseAndClassToParent,
            'studentsAssessmentBaseAndClassToStudent' => $studentsAssessmentBaseAndClassToStudent,

            'profesinalWorkbookToParent' => $profesinalWorkbookToParents,
            'profesinalWorkbookToStudent' => $profesinalWorkbookToStudents,

            'termicWorkbookToParent' => $termicWorkbookToParents,
            'termicWorkbookToStudent' => $termicWorkbookToStudents,
        );
    }

    public function getReportTypeNote($reportTypeId)
    {
        switch ($reportTypeId) {
            case 1: //is last Score
                $reportNote = 'یعنی اگر یک مفهوم/زیرمفهوم چندین نمره داشته باشد، آخرین نمره‌ای که دانش‌آموز برای آن کسب کرده برای محاسبه معدل انتخاب می‌شود.';
                break;
            case 2: // is average scores
                $reportNote = 'یعنی اگر یک مفهوم/زیرمفهوم چندین نمره داشته باشد، معدل آنها جهت معدل‌گیری درس انتخاب می‌شوند.';
                break;
            case 3: // is minimum
                $reportNote = 'یعنی اگر یک مفهوم/زیرمفهوم چندین نمره داشته باشد، کمترین نمره‌ای که دانش‌آموز کسب کرده جهت معدل‌گیری درس انتخاب می‌شود.';
                break;
            case 4: // is maximum
                $reportNote = 'یعنی اگر یک مفهوم/زیرمفهوم چندین نمره داشته باشد، بیشترین نمره‌ای که دانش‌آموز کسب کرده جهت معدل‌گیری درس انتخاب می‌شود.';
                break;
            case 5:
                $reportNote = 'یعنی اگر یک مفهوم/زیرمفهوم چندین نمره داشته باشد، اولین نمره‌ای که دانش‌آموز برای آن کسب کرده برای محاسبه معدل انتخاب می‌شود.';
                break;
            case 6:
                $reportNote = 'یعنی نمرات زیرمفاهیم باهم جمع شده و در مفهوم اصلی قرار داده می‌شود.';
                break;
            default:
                $reportNote = 'این سبک معدل‌گیری در سیستم تعریف نشده است.';
                break;
        }
        return $reportNote;
    }

    public function updateEstimateAcademicToScoreCompact($academicId, $conseptToLessonId, $lessonToBaseId, $score)
    {

        $academic = Academic::findOne($academicId);

        $conseptToLessonGroup = ConseptLessonFieldToGroup::find()
            ->alias('clfg')
            ->join('INNER JOIN', '{{%consept_lesson_to_field}} clf', 'clfg.consept_lesson_field_id  = clf.id')
            ->join('INNER JOIN', '{{%consept_to_lesson}} cl', 'clf.consept_lesson_id         = cl.id')
            ->join('INNER JOIN', '{{%organization_groups}} og', 'clfg.organization_group_id    = og.id AND og.type = 1')
            ->join('INNER JOIN', '{{%academic_to_groups}} atg', 'og.id                         = atg.organization_group_id')
            ->where([
                'atg.academic_id' => $academicId,
                'clf.field_id' => $academic->field_id,
                'cl.consept_id' => $conseptToLessonId,
                'cl.lesson_to_base_id' => $lessonToBaseId,
            ])->one();

        if ($conseptToLessonGroup) {
            $allConsepts = array();
            $this->conseptsId = array();
            $allConsepts = $this->getConseptParentsInfo($conseptToLessonGroup->conseptLessonField->conseptLesson->id);

            $unitMain = 0;
            if ($allConsepts) {
                $counts = count($allConsepts);
                $done = 0;
                $i = 0;

                foreach ($allConsepts as $key => $consept) {
                    $i++;

                    if ($key != 'root') {
                        $estimateAcademicToScoreCompact = EstimateAcademicToScoreComapct::findOne(['academic_id' => $academicId, 'consept_to_lesson_id' => $consept]);

                        if ($estimateAcademicToScoreCompact) {


                            if ($estimateAcademicToScoreCompact->is_exsite == 0) {
                                if ($i == 1) { // reset number
                                    $estimateAcademicToScoreCompact->avg = $score;
                                    $estimateAcademicToScoreCompact->max_score = $score;
                                    $estimateAcademicToScoreCompact->min_score = $score;
                                    $estimateAcademicToScoreCompact->last_score = $score;
                                    $estimateAcademicToScoreCompact->first_score = $score;
                                    $estimateAcademicToScoreCompact->create_date = date('Y-m-d');
                                    $estimateAcademicToScoreCompact->is_exsite = 1;
                                } else {
                                    $estimateAcademicToScoreCompact->avg = ($estimateAcademicToScoreCompact->avg + $score) / 2;
                                    if ($estimateAcademicToScoreCompact->max_score < $score)
                                        $estimateAcademicToScoreCompact->max_score = $score;

                                    if ($estimateAcademicToScoreCompact->min_score > $score)
                                        $estimateAcademicToScoreCompact->min_score = $score;

                                    $estimateAcademicToScoreCompact->last_score = $score;
                                    //$estimateAcademicToScoreComapct->first_score            = $score; //No Need
                                    $estimateAcademicToScoreCompact->create_date = date('Y-m-d');

                                }
                            } else {
                                if ($i == 1) {
                                    $estimateAcademicToScoreCompact->avg = ($estimateAcademicToScoreCompact->avg + $score) / 2;
                                    if ($estimateAcademicToScoreCompact->max_score < $score)
                                        $estimateAcademicToScoreCompact->max_score = $score;

                                    if ($estimateAcademicToScoreCompact->min_score > $score)
                                        $estimateAcademicToScoreCompact->min_score = $score;

                                    $estimateAcademicToScoreCompact->last_score = $score;
                                    //$estimateAcademicToScoreComapct->first_score            = $score; //No Need
                                    $estimateAcademicToScoreCompact->create_date = date('Y-m-d');
                                }


                            }


                            if ($i == 1) {
                                $unitMain = $conseptToLessonGroup->unit;
                                //$unitMainDiv    =   $unitMain + $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->unit = $unitMain * $estimateAcademicToScoreCompact->unit;
                                //                                if( $estimateAcademicToScoreCompact->unit > 1)
                                $estimateAcademicToScoreCompact->score = $score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->avg_t_score = $estimateAcademicToScoreCompact->avg * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->max_t_score = $estimateAcademicToScoreCompact->max_score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->min_t_score = $estimateAcademicToScoreCompact->min_score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->last_t_score = $estimateAcademicToScoreCompact->last_score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->first_t_score = $estimateAcademicToScoreCompact->first_score * $estimateAcademicToScoreCompact->unit;


                                //                                else{
                                //                                    $estimateAcademicToScoreCompact->score    =    ($estimateAcademicToScoreCompact->score+$score)/$unitMainDiv ;
                                //                                }
                            } else {
                                $estimateAcademicToScoreCompact->unit = $unitMain * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->score = $score * $estimateAcademicToScoreCompact->unit;

                                $estimateAcademicToScoreCompact->avg_t_score = $estimateAcademicToScoreCompact->avg * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->max_t_score = $estimateAcademicToScoreCompact->max_score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->min_t_score = $estimateAcademicToScoreCompact->min_score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->last_t_score = $estimateAcademicToScoreCompact->last_score * $estimateAcademicToScoreCompact->unit;
                                $estimateAcademicToScoreCompact->first_t_score = $estimateAcademicToScoreCompact->first_score * $estimateAcademicToScoreCompact->unit;
                            }


                            if ($estimateAcademicToScoreCompact->save(true))
                                $done++;
                            else {
                                print_r($estimateAcademicToScoreCompact->getErrors());
                                die;
                            };
                        } else {
                            $unitMain = $conseptToLessonGroup->unit;
                            $estimateAcademicToScoreComapct = new EstimateAcademicToScoreComapct;
                            $estimateAcademicToScoreComapct->academic_id = $academicId;
                            $estimateAcademicToScoreComapct->consept_to_lesson_id = $consept;
                            $estimateAcademicToScoreComapct->unit = $unitMain;//$unitsToBePassed;
                            $estimateAcademicToScoreComapct->score = $unitMain * $score;
                            $estimateAcademicToScoreComapct->avg = $score;
                            $estimateAcademicToScoreComapct->max_score = $score;
                            $estimateAcademicToScoreComapct->min_score = $score;
                            $estimateAcademicToScoreComapct->last_score = $score;
                            $estimateAcademicToScoreComapct->first_score = $score;
                            $estimateAcademicToScoreComapct->create_date = date('Y-m-d');
                            $estimateAcademicToScoreComapct->avg_t_score = $estimateAcademicToScoreComapct->avg * $estimateAcademicToScoreComapct->unit;
                            $estimateAcademicToScoreComapct->max_t_score = $estimateAcademicToScoreComapct->max_score * $estimateAcademicToScoreComapct->unit;
                            $estimateAcademicToScoreComapct->min_t_score = $estimateAcademicToScoreComapct->min_score * $estimateAcademicToScoreComapct->unit;
                            $estimateAcademicToScoreComapct->last_t_score = $estimateAcademicToScoreComapct->last_score * $estimateAcademicToScoreComapct->unit;
                            $estimateAcademicToScoreComapct->first_t_score = $estimateAcademicToScoreComapct->first_score * $estimateAcademicToScoreComapct->unit;


                            if ($i == 1)
                                $estimateAcademicToScoreComapct->is_exsite = 1;  // exsite score

                            if ($estimateAcademicToScoreComapct->save(true))
                                $done++;
                            else {
                                print_r($estimateAcademicToScoreComapct->getErrors());
                                die();

                            }
                        }
                    } else {
                        //
                    }
                }
                // return $done;
            }


        }

    }

    private function getConseptParentsInfo($conseptToLessonId)
    {
        $conseptToLesson = ConseptToLesson::findOne($conseptToLessonId);

        if ($conseptToLesson) {
            $this->conseptsId[$conseptToLessonId] = $conseptToLessonId;
            if ($conseptToLesson->parent_id)
                $this->getConseptParentsInfo($conseptToLesson->parent_id);
            else $this->conseptsId['root'] = $conseptToLessonId;

            return $this->conseptsId;
        } else return false;
    }

    private function _setLogFile($message)
    {
        if (!is_dir(__DIR__ . '/festimate_logs'))
            mkdir(__DIR__ . '/festimate_logs');
        $my_file = __DIR__ . '/festimate_logs/output.log';

        $handle = fopen($my_file, 'a');
        $content = print_r($message, true);
        $content .= "\n";
        fwrite($handle, $content);
    }

    public function calculateAvg($academicId, $lessonToBaseId, $organizationId, $fieldId, $side = 'teacher', $svg = false, $fromDate = false, $toDate = false)
    {
        $academicInfo = Academic::findOne($academicId);
        $orgBaseToFieldInfo = OrganizationBaseToField::find()
            ->alias('obf')
            ->joinWith('organizationToBase ob')
            ->where([
                'ob.organization_id' => $academicInfo->organization_id,
                'ob.base_id' => $academicInfo->base_id,
                'ob.academic_year_id' => $academicInfo->academic_year_id,
                'obf.field_id' => $academicInfo->field_id,
            ])->one();

        $scoreType = EstimateLessonToTypeScore::find()->where([
            'lesson_to_base_id' => $lessonToBaseId,
            'organization_id' => $organizationId])->one();

        yii::$app->session->set('side', $side);
        $avgsInfo = array();
        $lessonQuantitativePassedSumRelative =
        $lessonQuantitativeUnitRelative =
        $lessonQuantitativePassedSum =
        $lessonQuantitativeUnit =
        $lessonCombinedSum =
        $lessonCombinedUnit =
        $lessonQualitativeSum =
        $lessonQualitativeSumWithZero =
        $lessonQualitativeAvg =
        $lessonQualitativeAvgWithZero =
        $lessonQualitativeUnitWithZero =
        $lessonQualitativeUnit =
        $conseptSum = 0;
        $avgSpan = '';
        $subConseptSection = false;

        $conseptsToLesson = ConseptToLesson::find()
            ->select('cl.consept_id,cl.id,clfg.expire_date,clf.field_id,clfg.position')
            ->alias('cl')
            ->innerJoin('{{%consept_lesson_to_field}} clf', 'cl.id = clf.consept_lesson_id')
            ->innerJoin('{{%consept_lesson_field_to_group}} clfg', 'clf.id = clfg.consept_lesson_field_id')
            ->distinct()
            ->where([
                'lesson_to_base_id' => $lessonToBaseId,
                'parent_id' => NULL,
                'clf.field_id' => $fieldId,
                'clfg.is_delete' => 0,
                'cl.is_delete' => 0,
                'clf.is_enable' => 1,
                'clfg.is_enable' => 1,
            ])
            ->orderBy(['clfg.position' => SORT_ASC, 'clfg.id' => SORT_ASC])->all();


        $outText = '';
        $outText2 = '';
        $countConseptsToLesson = count($conseptsToLesson);
        if ($conseptsToLesson) {
            $halfPassedConsepts = $this->haveHalfPassedConsepts($academicId, $lessonToBaseId, $fieldId);

            $workbookInfo = $this->checkMaxPixelAndAvgCount($orgBaseToFieldInfo, true);
            switch ($side) {
                case 'teacher':
                case 'teachers':
                    $workbookInfo['avgCount'] = $workbookInfo['teacherAvgCount'];
                    $workbookInfo['avgTypes'] = $workbookInfo['teacherSelectedAvgs'];
                    $showAvgNumber = $workbookInfo['avgNumberToTeachers'];
                    $expectation = $workbookInfo['expectationToTeachers'];
                    $sumSubConseptsUnit = $workbookInfo['sumSubConseptsUnitToTeachers'];
                    break;
                case 'parent':
                case 'parents':
                    $workbookInfo['avgCount'] = $workbookInfo['parentAvgCount'];
                    $workbookInfo['avgTypes'] = $workbookInfo['parentSelectedAvgs'];
                    $showAvgNumber = $workbookInfo['avgNumberToParent'];
                    $expectation = $workbookInfo['expectationToParent'];
                    $sumSubConseptsUnit = $workbookInfo['sumSubConseptsUnitToParent'];
                    break;
                case 'student':
                case 'students':
                    $workbookInfo['avgCount'] = $workbookInfo['studentAvgCount'];
                    $workbookInfo['avgTypes'] = $workbookInfo['studentSelectedAvgs'];
                    $showAvgNumber = $workbookInfo['avgNumberToStudent'];
                    $expectation = $workbookInfo['expectationToStudent'];
                    $sumSubConseptsUnit = $workbookInfo['sumSubConseptsUnitToStudent'];
                    break;
            }

            foreach ($conseptsToLesson as $conseptToLesson) {
                $this->_calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLesson, $academicId, $organizationId, $fieldId, $fromDate, $toDate, $conseptToLesson->expire_date);


                /*if (yii::$app->user->id == 963 || yii::$app->user->id == 1) {
                    if ($lessonToBaseId == 1840 && ($academicId == 16896) &&
                        (
                            $conseptToLesson->id == 61166
                        )) {
                        $outText = print_r($this->listConseptScore, true);
                        $this->_setLogFile('-----------------------------------------------------------------------------------------------------------------------------------');
                        $this->_setLogFile($outText);
                    }
                }*/

                foreach ($this->listConseptScore as $key => $arrData) {

                    $this->avgMain = 0;
                    $this->unitMain = 0;
                    $this->quantitativeMustPassUnitRelative = 0;
                    $this->quantitativePassedUnitRelative = 0;
                    $this->quantitativeMustPassUnit = 0;
                    $this->quantitativePassedUnit = 0;
                    $this->qualitativeAvg = 0;
                    $this->qualitativeAvgWithZero = 0;
                    $this->qualitativeUnitWithZero = 0;
                    $this->qualitativeUnit = 0;
                    $this->statusMain = array();

                    $this->_calculateConseptAvgByArrayResult($key,$organizationId);

                    $qualitativeAvg = ($this->qualitativeAvg != 0 and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;
                    $qualitativeAvgWithZero = ($this->qualitativeAvgWithZero != 0 and $this->qualitativeUnitWithZero) ? ($this->qualitativeAvgWithZero / $this->qualitativeUnitWithZero) : 0;
                    $quantitaveAvg = ($this->quantitativeMustPassUnit != 0 and $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit) / $this->quantitativeMustPassUnit) : 0;
                    $quantitaveAvgRelative = ($this->quantitativeMustPassUnitRelative != 0 and $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
                    $combinedAvg = ($this->avgMain != 0 and $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0;

                    /*if(yii::$app->user->id == 963 && $lessonToBaseId == 1658)
                    {
                    print_r($this->listConseptScore);
                    }
                    if(yii::$app->user->id == 963)
                    {
                    if($lessonToBaseId == 384 && ($academicId == 7141 || $academicId == 5819) && $conseptToLesson->id == 19343)
                    {
                    //echo '<br><hr>must: ';
                    //print_r($this->listConseptScore); die;
                    echo '<br>';
                    echo $this->qualitativeAvgWithZero .'/'.$this->qualitativeUnitWithZero;
                    //echo '-- passed:  ' ;
                    //echo $this->quantitativePassedUnit;
                    //echo '<br><hr>';
                    //die;
                    }
                    }*/

                    if ($conseptToLesson->id == $key) {
                        /*if(yii::$app->user->id == 963)
                        {
                        if($lessonToBaseId == 1508)
                        {
                        echo '<br><hr>';
                        print_r($arrData);
                        echo '<br><hr>';
                        die;
                        }
                        }*/

                        /*if(yii::$app->user->id == 963)
                        {
                        if($lessonToBaseId == 384 && ($academicId == 7141 || $academicId == 5819) && $conseptToLesson->id == 19343)
                        {
                        //echo '<br><hr>must: ';
                        //print_r($this->listConseptScore); die;
                        echo '<hr>in => '. $this->qualitativeAvgWithZero .'/'.$this->qualitativeUnitWithZero .'='.$qualitativeAvgWithZero;
                        //echo '-- passed:  ' ;
                        //echo $this->quantitativePassedUnit;
                        //echo '<br><hr>';
                        //die;
                        }
                        }*/


                        if ($scoreType->estimate_report_type_id == 6) // sum sub consepts scores
                        {
                            $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $arrData['data']['subConseptsAvgSum']);
                            $conseptAvg = $arrData['data']['subConseptsAvgSum'];
                        } else {
                            if (in_array(2, $workbookInfo['avgTypes'])) {
                                if ($organizationId == 4 || $organizationId == 2 ) {
                                    $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $arrData['data']['avg']);
                                    $conseptAvg = $arrData['data']['avg'];
                                } else {
                                    $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $qualitativeAvg);
                                    $conseptAvg = $qualitativeAvg;
                                }
                            } else if (in_array(12, $workbookInfo['avgTypes'])) {
                                //die($qualitativeAvgWithZero .' = '. $combinedAvg);

                                $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $arrData['data']['avg']);
                                $conseptAvg = $arrData['data']['avg'];
                            } else {
                                $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $combinedAvg);
                                $conseptAvg = $combinedAvg;
                            }
                        }

                        $scoreSign = '';
                        if ($countConseptsToLesson <= 8) {
                            $scoreSign .= $conseptToLesson->consept->title . '| ';
                        }
                        $scoreSign .= yii::$app->fstring->translateDigits($lable['title']);
                        $note = $conseptToLesson->consept->title;
                        $academicAbsentAndDelay = AcademicAbsentAndDelay::findOne(['academic_id' => $academicId, 'consept_to_lesson_id' => $key, 'is_deleted' => 0]);
                        if (!$combinedAvg && $arrData['data']['status'] == 'ExpireDate') {
                            $lable['color'] = 'bg-color-red';
                            $scoreSign = '<i class="gl gl-warning-sign m-t-5"></i>';
                            //$lable      = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
                            //$scoreSign  = yii::$app->fstring->translateDigits($lable['title']);
                            $note = $note . ' - تاریخ اخذ نمره گذشته و دانش‌آموز هیچ نمره‌ای دریافت نکرده است  !';
                            if ($academicAbsentAndDelay) {
                                if ($academicAbsentAndDelay->type == 1) {
                                    $scoreSign = '<span class="strong">غ</span>';
                                    $note = $note . ' - دانش‌آموز غایب بوده است  !';
                                } else {
                                    $scoreSign = '<span class="strong">ت</span>';
                                    $note = $note . ' - دانش‌آموز تاخیر داشته است  !';
                                }
                            }

                        } else if (!$combinedAvg && $arrData['data']['status'] != 'Passed') {
                            $lable['color'] = 'label-info';
                            $scoreSign = '-';
                            //$lable      = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
                            //$scoreSign  = yii::$app->fstring->translateDigits($lable['title']);
                            $note = $note . ' - بدون نمره!';
                            if ($academicAbsentAndDelay) {
                                $lable['color'] = 'bg-color-red';
                                if ($academicAbsentAndDelay->type == 1) {
                                    $scoreSign = '<span class="strong">غ</span>';
                                    $note = $note . ' - دانش‌آموز غایب بوده است  !';
                                } else {
                                    $scoreSign = '<span class="strong">ت</span>';
                                    $note = $note . ' - دانش‌آموز تاخیر داشته است  !';
                                }
                            }
                        }

                        $expireDateG = Utility::explodText($arrData['data']['expireDate'], 0, ' ');
                        if ($expireDateG != '0000-00-00' && $expireDateG)
                            $expireDate = yii::$app->fdate->convertDateToJalali($expireDateG, '/');
                        else $expireDate = '0000-00-00';

                        if (Utility::in_array_nested($conseptToLesson->id, $halfPassedConsepts)) {
                            $border = 'style="outline: 1px dashed red !important;outline-offset: 2px;"';
                            $note = $note . ' (این مفهوم به صورت کامل گذرانده نشده است!) ';
                            $halfForSvg = true;
                        } else {
                            $border = '';
                            $halfForSvg = false;
                        }

                        $avgTitle = '';
                        if ($side == 'teacher') {
                            $avgTitle = " - (معدل: $conseptAvg) ";
                        }

                        if ($svg) {
                            if ($academicAbsentAndDelay) {
                                $lable['color'] = 'bg-color-red';
                                if ($academicAbsentAndDelay->type == 1) {
                                    $lable['title'] = 'غ';
                                    $note = $note . ' - دانش‌آموز غایب بوده است  !';
                                } else {
                                    $lable['title'] = 'ت';
                                    $note = $note . ' - دانش‌آموز تاخیر داشته است  !';
                                }
                                $arrRes = ['color' => $lable['color'], 'title' => $lable['title'], 'conseptNumber' => $conseptToLesson->position, 'avg' => $combinedAvg];
                            } else {
                                if (!$combinedAvg && $arrData['data']['status'] == 'HaveTime') {
                                    $lable['color'] = 'bg-muted2';
                                    $lable['title'] = '-';
                                }

                                $arrRes = ['color' => $lable['color'], 'title' => $lable['title'], 'conseptNumber' => $conseptToLesson->position, 'avg' => $combinedAvg];
                            }
                            if ($expireDateG != '0000-00-00' && (strtotime($expireDateG) <= strtotime(date('Y-m-d'))))
                                $arrRes['flag'] = true;
                            else $arrRes['flag'] = false;

                            $arrRes['halfPassed'] = $halfForSvg;

                            $avgsInfo[] = $arrRes;
                        } else {
                            $avgSpan .= " <span  $border class=\"tag {$lable['color']} label m-l-5\" onclick=\"window.open('conseptsreport?academic=" . $academicId . "&lessonToBase=" . $lessonToBaseId . "&consept=" . $conseptToLesson->id . "')\" title='{$note} $avgTitle - تاریخ انقضاء $expireDate'>" . $scoreSign . "</span>";
                            if ($expectation) {
                                if ($expireDateG != '0000-00-00' && (strtotime($expireDateG) <= strtotime(date('Y-m-d')))) {
                                    $avgSpan .= "<span class=\"tag label score-flag\" title='انتظار ما'>
                                    <i class=\"gl gl-flag text-md\"></i>
                                    </span>";
                                }
                            }
                        }

                        $lessonCombinedSum += $combinedAvg * $this->unitMain;
                        $lessonCombinedUnit += $this->unitMain;

                        // $lessonQuantitativePassedSum      += $quantitaveAvg;//* $this->unitMain;
                        /* $lessonQuantitativePassedSum      += $this->quantitativePassedUnit;//* $this->unitMain;
                        if($expireDateG != '0000-00-00' && strtotime($expireDateG) <= strtotime( date('Y-m-d')))
                        $lessonQuantitativeUnit     += $this->quantitativeMustPassUnit;*/

                        /*if(yii::$app->user->id == 963)
                        {*/
                        // $lessonQuantitativePassedSum      += $quantitaveAvg;//* $this->unitMain;
                        //$lessonQuantitativePassedSum      += $this->quantitativePassedUnit;
                        //$lessonQuantitativePassedSum      += $arrData['data']['expireDate'];//*
                        if (strtotime($expireDateG) <= strtotime(date('Y-m-d'))) {
                            $lessonQuantitativeUnit += $arrData['data']['subConseptsUnitSum'] + $arrData['data']['unit'];
                            $outText2 .= $key . ',';
                        }

                        /*if(($arrData['data']['status'] == 'ExpireDate' || $arrData['data']['status'] == 'HaveTime' || $arrData['data']['status'] == 'TimeLess') && $arrData['data']['avg'])
                        {
                        $lessonQuantitativePassedSum += $arrData['data']['subConseptsUnitSumPassed'] + $arrData['data']['unit'];
                        }*/


                        if ($arrData['data']['avg']) {
                            if ($arrData['data']['subConseptsUnitSumPassed'])
                                $lessonQuantitativePassedSum += $arrData['data']['subConseptsUnitSumPassed'] + $arrData['data']['unit'];
                            else  $lessonQuantitativePassedSum += $arrData['data']['subConseptsUnitSum'] + $arrData['data']['unit'];
                        }
                        /*}
                        else
                        {
                        // $lessonQuantitativePassedSum      += $quantitaveAvg;//* $this->unitMain;
                        $lessonQuantitativePassedSum      += $this->quantitativePassedUnit;//* $this->unitMain;



                        if($expireDateG != '0000-00-00' && strtotime($expireDateG) <= strtotime( date('Y-m-d')))
                        $lessonQuantitativeUnit     += $this->quantitativeMustPassUnit;
                        } */


                        $lessonQuantitativePassedSumRelative += $quantitaveAvgRelative * $this->unitMain;
                        if (strtotime($expireDateG) <= strtotime(date('Y-m-d')))
                            $lessonQuantitativeUnitRelative += $this->unitMain;

                        if ($sumSubConseptsUnit) {
                            if ($organizationId == 4) {
                                $lessonQualitativeSum += $arrData['data']['avg'] * $arrData['data']['unit'];
                                $lessonQualitativeUnit += $arrData['data']['status'] == 'ExpireDate' ? $arrData['data']['unit'] : 0;
                            } else {
                                $lessonQualitativeSum += $qualitativeAvg * $this->qualitativeUnit;
                                $lessonQualitativeUnit += $this->qualitativeUnit;
                            }
                        } else {
                            if ($arrData['data']['status'] == 'Passed' || $arrData['data']['status'] == 'ExpireDate' || ($arrData['data']['status'] == 'TimeLess' && $arrData['data']['avg'])) {
                                if ($scoreType->estimate_report_type_id == 6) // sum sub consepts scores
                                {
                                    $lessonQualitativeSum += $arrData['data']['subConseptsAvgSum'] * $arrData['data']['unit'];
                                    $lessonQualitativeUnit += $arrData['data']['unit'];
                                } else {
                                    $lessonQualitativeSum += $arrData['data']['avg'] * $arrData['data']['unit'];
                                    $lessonQualitativeUnit += $arrData['data']['unit'];
                                    /*if(yii::$app->user->id == 963)
                                    {
                                        if($lessonToBaseId == 1713 && ($academicId == 12724)
                                        )
                                        {
                                            $outText = print_r("$lessonQualitativeSum  = $arrData[data][avg] *  $arrData[data][unit]",true);
                                            $this->_setLogFile('------------------------------------------------------');
                                            $outText = print_r("$lessonQualitativeUnit = $arrData[data][unit]",true);
                                            $this->_setLogFile('-----------------------------------------------------------------------------------------------------------------------------------');
                                            $this->_setLogFile($outText);
                                        }
                                    }  */

                                }
                            }

                        }

                        if ($sumSubConseptsUnit)
                            $lessonQualitativeSumWithZero += $qualitativeAvgWithZero * $this->qualitativeUnitWithZero;
                        else $lessonQualitativeSumWithZero += $arrData['data']['avg'] * $arrData['data']['unit'];

                        if ($arrData['data']['status'] == 'Passed' || $arrData['data']['status'] == 'ExpireDate' || ($arrData['data']['status'] == 'TimeLess' && $arrData['data']['avg'])) {
                            if ($sumSubConseptsUnit)
                                $lessonQualitativeUnitWithZero += $arrData['data']['subConseptsUnitSum'] + $arrData['data']['unit'];//$this->qualitativeUnitWithZero;
                            else    $lessonQualitativeUnitWithZero += $arrData['data']['unit'];
                        }
                    }
                }
                $this->listConseptScore = array();
            }

        } else
            return 0;

        /*if(yii::$app->user->id == 963 && $lessonToBaseId == 550)
        {
        die($outText);
        }*/

        $lessonCombinedAvg = ($lessonCombinedSum and $lessonCombinedUnit) ? $lessonCombinedSum / $lessonCombinedUnit : 0;
        $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonCombinedAvg);
        $scoreSign = $lable['title'];
        if (!$lessonCombinedAvg) {
            $lable['color'] = 'bg-color-red';
            if (!$svg)
                $scoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
            else  $scoreSign = '-';
        }

        $combinedAvgTitle = '';

        if ($side == 'teacher') {
            $combinedAvgTitle = "({$lessonCombinedAvg} = {$lessonCombinedUnit}÷{$lessonCombinedSum})";
        }
        if (!$svg)
            $lessonCombinedAvgSpan = "<span class=\"tag {$lable['color']} label m-l-5\" title='$combinedAvgTitle'>" . $scoreSign . "</span>";
        else $lessonCombinedAvgSpan = ['color' => $lable['color'], 'title' => $lable['title'], 'avg' => $lessonCombinedAvg];
        //--------------------------------------------

        $lessonQualitativeAvg = round(($lessonQualitativeSum and $lessonQualitativeUnit) ? $lessonQualitativeSum / $lessonQualitativeUnit : 0, 1);
        $lessonQualitativeLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQualitativeAvg);

        $lessonQualitativeScoreSign = $lessonQualitativeLable['title'];
        if (!$lessonQualitativeScoreSign) {
            $lessonQualitativeLable['color'] = 'bg-color-red';
            if (!$svg)
                $lessonQualitativeScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
            else  $lessonQualitativeScoreSign = '-';
        }
        $qualitativeAvgTitle = '';
        if ($side == 'teacher') {
            $avgConverted = $lessonQualitativeLable['calculationCoefficient'] ? $lessonQualitativeAvg / $lessonQualitativeLable['calculationCoefficient'] : null;
            $qualitativeAvgTitle = "معدل کیفی ({$lessonQualitativeAvg} = {$lessonQualitativeUnit} ÷ {$lessonQualitativeSum})

            ";
            if ($avgConverted) {
                $qualitativeAvgTitle .= "معدل تبدیل شده به نحوه‌ی ارشیابی این درس : $avgConverted";
            }
        }
        //--------------------------------------------
        $lessonQualitativeAvgWithZero = ($lessonQualitativeSumWithZero and $lessonQualitativeUnitWithZero) ? $lessonQualitativeSumWithZero / $lessonQualitativeUnitWithZero : 0;
        /*if(yii::$app->user->id == 963)
        {
        if($lessonToBaseId == 1691)
        {
        echo "$lessonToBaseId,$organizationId,$lessonQualitativeAvgWithZero,$lessonQualitativeUnitWithZero";die;
        }
        }*/

        /*if(yii::$app->user->id == 963)
        {
        if($lessonToBaseId == 384 && ($academicId == 7141 || $academicId == 5819))
        {
        //echo '<br><hr>must: ';
        //print_r($this->listConseptScore); die;
        echo '<br> inooo => ' . $lessonQualitativeSumWithZero .'/'.$lessonQualitativeUnitWithZero;
        //echo '-- passed:  ' ;
        //echo $this->quantitativePassedUnit;
        //echo '<br><hr>';
        //die;
        }
        } */


        $lessonQualitativeWithZeroLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQualitativeAvgWithZero);
        $lessonQualitativeWithZeroScoreSign = $lessonQualitativeWithZeroLable['title'];
        if (!$lessonQualitativeWithZeroScoreSign) {
            $lessonQualitativeWithZeroLable['color'] = 'bg-color-red';
            if (!$svg)
                $lessonQualitativeWithZeroScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
            else  $lessonQualitativeWithZeroScoreSign = '-';
        }
        $qualitativeAvgTitleWithZero = '';
        if ($side == 'teacher') {
            $avgConverted = $lessonQualitativeWithZeroLable['calculationCoefficient'] ? $lessonQualitativeAvgWithZero / $lessonQualitativeWithZeroLable['calculationCoefficient'] : '?';
            $qualitativeAvgTitleWithZero = "معدل کیفی ($lessonQualitativeAvgWithZero = (جمع نمرات: $lessonQualitativeSumWithZero) ÷  ( جمع‌واحدها$lessonQualitativeUnitWithZero ))
            معدل تبدیل شده به نحوه‌ی ارشیابی این درس : $avgConverted
            ";
        }

        /*if(!$lessonQualitativeAvg)
        {
        if($lessonQualitativeUnit)
        {
        $lessonQualitativeLable     = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
        $lessonQualitativeScoreSign = $lessonQualitativeLable['title'];
        }
        } */

        if (!$svg) {
            $lessonQualitativeAvgSpan = "<span class=\"tag {$lessonQualitativeLable['color']} label m-l-5\" title='$qualitativeAvgTitle'>" . $lessonQualitativeScoreSign . "</span>";
            $lessonQualitativeAvgSpanWithZero = "<span class=\"tag {$lessonQualitativeWithZeroLable['color']} label m-l-5\" title='$qualitativeAvgTitleWithZero'>" . $lessonQualitativeWithZeroScoreSign . "</span>";
        } else {
            $lessonQualitativeAvgSpan = ['color' => $lessonQualitativeLable['color'], 'title' => $lessonQualitativeLable['title'], 'avg' => $lessonQualitativeAvg];
            $lessonQualitativeAvgSpanWithZero = ['color' => $lessonQualitativeWithZeroLable['color'], 'title' => $lessonQualitativeWithZeroLable['title'], 'avg' => $lessonQualitativeAvgWithZero];
        }
        //----------------------------------------------
        $lessonQuantitativeAvg = round(($lessonQuantitativePassedSum and $lessonQuantitativeUnit) ? $lessonQuantitativePassedSum * 100 / $lessonQuantitativeUnit : 0, 1);
        $lessonQuantitativeLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQuantitativeAvg);
        $lessonQuantitativeScoreSign = $lessonQuantitativeLable['title'];
        if (!$lessonQuantitativeScoreSign) {
            $lessonQuantitativeLable['color'] = 'bg-color-red';
            if (!$svg)
                $lessonQuantitativeScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
            else  $lessonQuantitativeScoreSign = '-';
        }

        /*if($lessonQualitativeUnit && !$lessonQuantitativeAvg)
        {
        $lessonQuantitativeLable     = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
        $lessonQuantitativeScoreSign = $lessonQuantitativeLable['title'];
        } */

        $quantitativeAvgTitle = '';
        if ($side == 'teacher') {
            $titleUnit = yii::$app->fstring->translateDigits($lessonQuantitativeUnit);
            $titleSum = yii::$app->fstring->translateDigits($lessonQuantitativePassedSum);
            $titleAvg = yii::$app->fstring->translateDigits($lessonQuantitativeAvg);
            $quantitativeAvgTitle = "معدل کمی $titleAvg ($titleSum از $titleUnit)";
        }
        if (!$svg)
            $lessonQuantitativeAvgSpan = "<span class=\"tag {$lessonQuantitativeLable['color']} label m-l-5\" title='$quantitativeAvgTitle'>" . $lessonQuantitativeScoreSign . "</span>";
        else    $lessonQuantitativeAvgSpan = ['color' => $lessonQuantitativeLable['color'], 'title' => $lessonQuantitativeLable['title'], 'avg' => $lessonQuantitativeAvg];
        //----------------------------------------------
        $lessonQuantitativeAvgRelative = round(($lessonQuantitativePassedSumRelative and $lessonQuantitativeUnitRelative) ? $lessonQuantitativePassedSumRelative / $lessonQuantitativeUnitRelative : 0, 1);
        $lessonQuantitativeLableRelative = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQuantitativeAvgRelative);
        $lessonQuantitativeScoreSign = $lessonQuantitativeLableRelative['title'];
        if (!$lessonQuantitativeScoreSign) {
            $lessonQuantitativeLableRelative['color'] = 'bg-color-red';
            if (!$svg)
                $lessonQuantitativeScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
            else  $lessonQuantitativeScoreSign = '-';
        }

        $quantitativeAvgRelativeTitle = '';
        if ($side == 'teacher') {
            $quantitativeAvgRelativeTitle = "معدل کمی ({$lessonQuantitativeAvgRelative} = {$lessonQuantitativeUnitRelative} ÷ {$lessonQuantitativePassedSumRelative})";
        }
        if (!$svg)
            $lessonQuantitativeAvgRelativeSpan = "<span class=\"tag {$lessonQuantitativeLableRelative['color']} label m-l-5\" title='$quantitativeAvgRelativeTitle'>" . $lessonQuantitativeScoreSign . "</span>";
        else $lessonQuantitativeAvgRelativeSpan = ['color' => $lessonQuantitativeLableRelative['color'], 'title' => $lessonQuantitativeLableRelative['title'], 'avg' => $lessonQuantitativeAvgRelative];
        //--------------------------------------------------

        $result = array('conseptsAvg' => (!$svg) ? $avgSpan : $avgsInfo,
            'lessonCombinedAvg' => $lessonCombinedAvgSpan,
            'lessonQualitativeAvgAsNumber' => $lessonQualitativeAvg,
            'lessonQualitativeAvgAsNumberWithZero' => $lessonQualitativeAvgWithZero,
            'lessonCombinedAvgAsNumber' => $lessonCombinedAvg,
            'lessonQualitativeAvg' => $lessonQualitativeAvgSpan,
            'lessonQualitativeAvgWithZero' => $lessonQualitativeAvgSpanWithZero,
            'lessonQuantitativeAvg' => $lessonQuantitativeAvgSpan,
            'lessonQuantitativeAvgAsNumber' => $lessonQuantitativeAvg,
            'lessonQuantitativeAvgRelative' => $lessonQuantitativeAvgRelativeSpan,
            'lessonQuantitativeAvgRelativeAsNumber' => $lessonQuantitativeAvgRelative,
        );

        return $result;
    }


    public function calculateconseptAvgOperation($lessonToBaseId, $conseptToLesson, $academicId, $organizationId, $fieldId, $side, $parentExpireDate = null, $returnAvgNumber = false)
    {
        $this->_calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLesson, $academicId, $organizationId, $fieldId, $parentExpireDate);
        foreach ($this->listConseptScore as $key => $arrData) {

            $this->avgMain = 0;
            $this->unitMain = 0;
            $this->quantitativeMustPassUnitRelative = 0;
            $this->quantitativePassedUnitRelative = 0;
            $this->quantitativeMustPassUnit = 0;
            $this->quantitativePassedUnit = 0;
            $this->qualitativeAvg = 0;
            $this->qualitativeAvgWithZero = 0;
            $this->qualitativeUnit = 0;
            $this->qualitativeUnitWithZero = 0;
            $this->statusMain = array();

            $this->_calculateConseptAvgByArrayResult($key,$organizationId);

            $qualitativeAvg = ($this->qualitativeAvg != 0 and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;
            $qualitativeAvgWithZero = ($this->qualitativeAvgWithZero != 0 and $this->qualitativeUnitWithZero) ? ($this->qualitativeAvgWithZero / $this->qualitativeUnitWithZero) : 0;
            $quantitaveAvg = ($this->quantitativeMustPassUnit != 0 and $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit * 100) / $this->quantitativeMustPassUnit) : 0;
            $quantitaveAvgRelative = ($this->quantitativeMustPassUnitRelative != 0 and $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
            $combinedAvg = ($this->avgMain != 0 and $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0;

            if ($conseptToLesson->id == $key) {
                /*if(yii::$app->user->id == 963)
                {
                if($lessonToBaseId == 30)
                {
                echo '<br><hr>';
                print_r($arrData);
                echo '<br><hr>';
                }
                } */

                $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $combinedAvg);
                $scoreSign = yii::$app->fstring->translateDigits($lable['title']);
                $note = $conseptToLesson->consept->title;
                if (!$combinedAvg && $arrData['data']['status'] == 'ExpireDate') {
                    $lable['color'] = 'bg-color-red';
                    $scoreSign = '<i class="gl gl-warning-sign m-t-5"></i>';
                    $note = $note . ' - تاریخ اخذ نمره گذشته و دانش‌آموز هیچ نمره‌ای دریافت نکرده است !';
                } else if (!$combinedAvg && $arrData['data']['status'] != 'Passed') {
                    $lable['color'] = 'label-info';
                    $scoreSign = '-';
                    $note = $note . ' - بدون نمره!';
                }

                $expireDateG = Utility::explodText($arrData['data']['expireDate'], 0, ' ');
                if ($expireDateG != '0000-00-00' && $expireDateG)
                    $expireDate = yii::$app->fdate->convertDateToJalali($expireDateG, '/');
                else $expireDate = '0000-00-00';

                $avgTitle = '';
                if ($side == 'teacher') {
                    $avgTitle = " - معدل ({$combinedAvg} = {$this->avgMain} / {$this->unitMain})";
                }

                $avgSpan = " <span  class=\"tag {$lable['color']} label m-l-5\" onclick=\"window.open('conseptsreport?academic=" . $academicId . "&lessonToBase=" . $lessonToBaseId . "&consept=" . $conseptToLesson->id . "')\" title='{$note} $avgTitle - $expireDate - $quantitaveAvgRelative'>" . $scoreSign . "</span>";

                if (!$returnAvgNumber)
                    return $avgSpan;
                else return ['avgSpan' => $avgSpan, 'avgNumber' => $combinedAvg];
            }
        }
    }

    public function calculateArrayConseptAvgOperation($lessonToBaseId, $arrayConseptToLesson, $academicId, $organizationId, $fieldId, $workbookDetailRow, $side, $parentExpireDate)
    {
        $sum = 0;
        foreach ($arrayConseptToLesson as $conseptToLessonId) {
            $conseptToLesson = ConseptToLesson::findOne($conseptToLessonId);
            $this->_calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLesson, $academicId, $organizationId, $fieldId, $parentExpireDate);
            foreach ($this->listConseptScore as $key => $arrData) {

                $this->avgMain = 0;
                $this->unitMain = 0;
                $this->quantitativeMustPassUnitRelative = 0;
                $this->quantitativePassedUnitRelative = 0;
                $this->quantitativeMustPassUnit = 0;
                $this->quantitativePassedUnit = 0;
                $this->qualitativeAvg = 0;
                $this->qualitativeUnit = 0;
                $this->statusMain = array();

                $this->_calculateConseptAvgByArrayResult($key,$organizationId);


                $qualitativeAvg = ($this->qualitativeAvg != 0 and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;
                /*$quantitaveAvg          = ($this->quantitativeMustPassUnit!= 0 and  $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit * 100) / $this->quantitativeMustPassUnit) : 0;
                $quantitaveAvgRelative  = ($this->quantitativeMustPassUnitRelative != 0 and  $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
                $combinedAvg            = ($this->avgMain!= 0 and  $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0 ;
                */

                if ($conseptToLesson->id == $key) {
                    $sum += $qualitativeAvg;
                }
            }
        }
        $avg = $sum / count($arrayConseptToLesson);
        $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $avg);
        $scoreSign = yii::$app->fstring->translateDigits($lable['title']);
        $note = "$sum ÷ " . count($arrayConseptToLesson) . '=' . $avg;
        return ['avg' => $avg, 'avgSpan' => $avgSpan = " <span  class=\"tag {$lable['color']}  label m-l-5\" lesson-id='$lessonToBaseId' avg='$avg' workbook-detail-row='$workbookDetailRow' title='{$note}'>" . $scoreSign . "</span>"];

    }

    public function calculateArrayConseptAvgOperationNew($lessonToBaseId, $arrayConseptToLesson, $academicId, $organizationId, $fieldId, $workbookDetailRow, $side, $parentExpireDate = null, $checkMainConseptHaveScore = false)
    {
        $sum = 0;
        $units = 0;
        foreach ($arrayConseptToLesson as $conseptToLessonId) {
            $conseptlessFieldToGroup = ConseptLessonFieldToGroup::findOne($conseptToLessonId);
            $conseptToLesson = ConseptToLesson::findOne($conseptlessFieldToGroup->conseptLessonField->conseptLesson->id);
            $this->_calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLesson, $academicId, $organizationId, $fieldId, false, false, $parentExpireDate, $checkMainConseptHaveScore);

            /*if(yii::$app->user->id == 1 && $lessonToBaseId == 1651)
            {
            die(print_r($this->listConseptScore));
            } */

            foreach ($this->listConseptScore as $key => $arrData) {

                $this->avgMain = 0;
                $this->unitMain = 0;
                $this->quantitativeMustPassUnitRelative = 0;
                $this->quantitativePassedUnitRelative = 0;
                $this->quantitativeMustPassUnit = 0;
                $this->quantitativePassedUnit = 0;
                $this->qualitativeAvg = 0;
                $this->qualitativeUnit = 0;
                $this->statusMain = array();

                $this->_calculateConseptAvgByArrayResult($key,$organizationId);

                $qualitativeAvg = ($this->qualitativeAvg and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;

                /*if($key == 57150 && yii::$app->user->id == 1){
                    die(print_r($arrData));
                }*/

                /*$quantitaveAvg          = ($this->quantitativeMustPassUnit!= 0 and  $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit * 100) / $this->quantitativeMustPassUnit) : 0;
                $quantitaveAvgRelative  = ($this->quantitativeMustPassUnitRelative != 0 and  $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
                $combinedAvg            = ($this->avgMain!= 0 and  $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0 ;
                */

                if ($conseptToLesson->id == $key) {
                    $sum += $qualitativeAvg * $this->qualitativeUnit;
                    $units += $this->qualitativeUnit;
                }
            }
        }
        $avg = $units ? ($sum) / $units : 0;
        $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $avg);
        $scoreSign = yii::$app->fstring->translateDigits($lable['title']);
        $note = '';//"$sum ÷ " .$units .'=' . $avg;
        return ['avg' => $avg, 'unit' => $units, 'avgSpan' => $avgSpan = " <span  class=\"tag {$lable['color']}  label m-l-5\" lesson-id='$lessonToBaseId' avg='$avg' workbook-detail-row='$workbookDetailRow' title='{$note}'>" . $scoreSign . "</span>"];

    }

    /**

     * For javaid refactor arsalan and hamed start
     */
    public function calculateArrayConseptAvgOperationNewJavid($lessonToBaseId, $arrayConseptToLesson, $academicId, $organizationId, $fieldId, $workbookDetailRow, $side, $parentExpireDate = null, $checkMainConseptHaveScore = false)
    {
        $sum = 0;
        $units = 0;
        $arrDetail = [];
        foreach ($arrayConseptToLesson as $conseptToLessonId) {
            $conseptlessFieldToGroup = ConseptLessonFieldToGroup::findOne($conseptToLessonId);
            $conseptToLesson = ConseptToLesson::findOne($conseptlessFieldToGroup->conseptLessonField->conseptLesson->id);
            $this->_calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLesson, $academicId, $organizationId, $fieldId, false, false, $parentExpireDate, $checkMainConseptHaveScore);

            /*if(yii::$app->user->id == 1 && $lessonToBaseId == 1651)
            {
            die(print_r($this->listConseptScore));
            } */

            foreach ($this->listConseptScore as $key => $arrData) {

                $this->avgMain = 0;
                $this->unitMain = 0;
                $this->quantitativeMustPassUnitRelative = 0;
                $this->quantitativePassedUnitRelative = 0;
                $this->quantitativeMustPassUnit = 0;
                $this->quantitativePassedUnit = 0;
                $this->qualitativeAvg = 0;
                $this->qualitativeUnit = 0;
                $this->statusMain = array();

                $this->_calculateConseptAvgByArrayResult($key,$organizationId);

                $qualitativeAvg = ($this->qualitativeAvg and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;

                /*if($key == 57150 && yii::$app->user->id == 1){
                    die(print_r($arrData));
                }*/

                /*$quantitaveAvg          = ($this->quantitativeMustPassUnit!= 0 and  $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit * 100) / $this->quantitativeMustPassUnit) : 0;
                $quantitaveAvgRelative  = ($this->quantitativeMustPassUnitRelative != 0 and  $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
                $combinedAvg            = ($this->avgMain!= 0 and  $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0 ;
                */

                if ($conseptToLesson->id == $key) {
                    $sum += $qualitativeAvg * $this->qualitativeUnit;
                    $units += $this->qualitativeUnit;
                    $arrDetail[] = [
                                        'title'=> $conseptToLesson->consept->title,
                                        'sum' => $qualitativeAvg * $this->qualitativeUnit,
                                        'unit' => $this->qualitativeUnit];
                }
            }
        }
        $avg = $units ? ($sum) / $units : 0;
        $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $avg);
        $scoreSign = yii::$app->fstring->translateDigits($lable['title']);
        $note = '';//"$sum ÷ " .$units .'=' . $avg;
        return [ 'arrDetail'=> $arrDetail, 'avg' => $avg, 'unit' => $units, 'avgSpan' => $avgSpan = " <span  class=\"tag {$lable['color']}  label m-l-5\" lesson-id='$lessonToBaseId' avg='$avg' workbook-detail-row='$workbookDetailRow' title='{$note}'>" . $scoreSign . "</span>"];

    }
    /**

     * For javaid refactor arsalan and hamed start
     */

    public function calculateConseptAvg($academicId, $lessonToBaseId, $conseptToLessonId, $organizationId, $fieldId, $side = 'teacher', $parentExpireDate = null)
    {
        $lessonQuantitativePassedSumRelative =
        $lessonQuantitativeUnitRelative =
        $lessonQuantitativePassedSum =
        $lessonQuantitativeUnit =
        $lessonCombinedSum =
        $lessonCombinedUnit =
        $lessonQualitativeSum =
        $lessonQualitativeSumWithZero =
        $lessonQualitativeAvg =
        $lessonQualitativeAvgWithZero =
        $lessonQualitativeUnit =
        $lessonQualitativeUnitWithZero =
        $conseptSum = 0;
        $sumSubConsepts = 0;
        $avgSpan = '';
        $subConseptSection = false;

        $subConsepts = ConseptToLesson::find()
            ->select('cl.consept_id,cl.id,cl.parent_id,clfg.expire_date')
            ->alias('cl')
            ->innerJoin('{{%consept_lesson_to_field}} clf', 'cl.id = clf.consept_lesson_id')
            ->innerJoin('{{%consept_lesson_field_to_group}} clfg', 'clf.id = clfg.consept_lesson_field_id')
            ->distinct()
            ->where([
                'cl.parent_id' => $conseptToLessonId,
                'cl.lesson_to_base_id' => $lessonToBaseId,
                'clf.is_enable' => 1,
                'clfg.is_enable' => 1,
                'clf.field_id' => $fieldId,
                'clfg.is_delete' => 0,
                'cl.is_delete' => 0,
            ])
            ->orderBy(['clfg.position' => SORT_ASC, 'clfg.id' => SORT_ASC])
            ->all();

//        die(print_r($subConsepts));

        if ($subConsepts) {
            $halfPassedConsepts = $this->haveHalfPassedConsepts($academicId, $lessonToBaseId, $fieldId);

            foreach ($subConsepts as $subConsept) {
                $this->_calculateAvgBasedOnConsept($lessonToBaseId, $subConsept, $academicId, $organizationId, $fieldId, false, false, $parentExpireDate);

                foreach ($this->listConseptScore as $key => $arrData) {

                    $this->avgMain = 0;
                    $this->unitMain = 0;
                    $this->quantitativeMustPassUnitRelative = 0;
                    $this->quantitativePassedUnitRelative = 0;
                    $this->quantitativeMustPassUnit = 0;
                    $this->quantitativePassedUnit = 0;
                    $this->qualitativeAvg = 0;
                    $this->qualitativeAvgWithZero = 0;
                    $this->qualitativeUnit = 0;
                    $this->qualitativeUnitWithZero = 0;
                    $this->statusMain = array();

                    $this->_calculateConseptAvgByArrayResult($key,$organizationId);

                    $qualitativeAvg = ($this->qualitativeAvg != 0 and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;
                    $qualitativeAvgWithZero = ($this->qualitativeAvgWithZero != 0 and $this->qualitativeUnitWithZero) ? ($this->qualitativeAvgWithZero / $this->qualitativeUnitWithZero) : 0;
                    $quantitaveAvg = ($this->quantitativeMustPassUnit != 0 and $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit * 100) / $this->quantitativeMustPassUnit) : 0;
                    $quantitaveAvgRelative = ($this->quantitativeMustPassUnitRelative != 0 and $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
                    $combinedAvg = ($this->avgMain != 0 and $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0;

                    if ($subConsept->id == $key) {
                        /*if(yii::$app->user->id == 963)
                        {
                        if($lessonToBaseId == 6)
                        {
                        echo '<br><hr>';
                        print_r($arrData);
                        echo '<br><hr>';
                        }
                        }*/

                        $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $combinedAvg);
                        $scoreSign = yii::$app->fstring->translateDigits($lable['title']);
                        $note = $subConsept->consept->title;

                        if (!$combinedAvg && $arrData['data']['status'] == 'ExpireDate') {
                            //$lable      = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
                            $lable['color'] = 'bg-color-red';
                            $scoreSign = '<i class="gl gl-warning-sign m-t-5"></i>';
                            //$scoreSign      = yii::$app->fstring->translateDigits($lable['title']);;
                            $note = $note . ' - تاریخ اخذ نمره گذشته و دانش‌آموز هیچ نمره‌ای دریافت نکرده است  !' . "{$this->avgMain} / {$this->unitMain}";
                        } else if (!$combinedAvg && $arrData['data']['status'] != 'Passed') {
                            $lable['color'] = 'label-info';
                            $scoreSign = '-';
                            //$lable      = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
                            //$scoreSign  = yii::$app->fstring->translateDigits($lable['title']);
                            $note = $note . ' - بدون نمره!';
                        }

                        $expireDateG = Utility::explodText($arrData['data']['expireDate'], 0, ' ');
                        if ($expireDateG != '0000-00-00' && $expireDateG)
                            $expireDate = yii::$app->fdate->convertDateToJalali($expireDateG, '/');
                        else $expireDate = '0000-00-00';

                        if (Utility::in_array_nested($subConsept->id, $halfPassedConsepts)) {
                            $halfPassed = true;
                        } else $halfPassed = false;

                        $avgTitle = '';
                        if ($side == 'teacher') {
                            $avgTitle = "- معدل({$combinedAvg} = {$this->avgMain} / {$this->unitMain})@ {$arrData['data']['status']} ";
                        }

                        $avgSpan .= " <span  class=\"tag {$lable['color']} label m-l-5\" onclick=\"window.location.href = 'conseptsreport?academic=" . $academicId . "&lessonToBase=" . $lessonToBaseId . "&consept=" . $conseptToLessonId . "&subConsept=" . $subConsept->id . "'\" title='{$note} $avgTitle - تاریخ انقضاء:‌$expireDate'> " . $scoreSign . " </span>";

                        $flag = false;
                        if ($expireDateG != '0000-00-00' && (strtotime($expireDateG) <= strtotime(date('Y-m-d')))) {
                            $flag = true;
                        }

                        $lessonCombinedSum += $combinedAvg * $this->unitMain;
                        $lessonCombinedUnit += $this->unitMain;

                        $lessonQuantitativePassedSum += $quantitaveAvg * $this->unitMain;
                        if (strtotime($expireDateG) <= strtotime(date('Y-m-d')))
                            $lessonQuantitativeUnit += $this->unitMain;

                        $lessonQuantitativePassedSumRelative += $quantitaveAvgRelative * $this->unitMain;
                        if (strtotime($expireDateG) <= strtotime(date('Y-m-d')))
                            $lessonQuantitativeUnitRelative += $this->unitMain;

                        $sumSubConsepts += $qualitativeAvg;

                        $lessonQualitativeSum += $qualitativeAvg * $this->qualitativeUnit;
                        $lessonQualitativeUnit += $this->qualitativeUnit;

                        $lessonQualitativeSumWithZero += $qualitativeAvgWithZero * $this->qualitativeUnitWithZero;
                        $lessonQualitativeUnitWithZero += $this->qualitativeUnitWithZero;
                    }
                }
                $this->listConseptScore = array();
            }

        } else {
            $halfPassedConsepts = $this->haveHalfPassedConsepts($academicId, $lessonToBaseId, $fieldId);
            $concept = ConseptToLesson::findOne($conseptToLessonId);
            $this->_calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLessonId, $academicId, $organizationId, $fieldId, false, false, $parentExpireDate);

            foreach ($this->listConseptScore as $key => $arrData) {

                $this->avgMain = 0;
                $this->unitMain = 0;
                $this->quantitativeMustPassUnitRelative = 0;
                $this->quantitativePassedUnitRelative = 0;
                $this->quantitativeMustPassUnit = 0;
                $this->quantitativePassedUnit = 0;
                $this->qualitativeAvg = 0;
                $this->qualitativeAvgWithZero = 0;
                $this->qualitativeUnit = 0;
                $this->qualitativeUnitWithZero = 0;
                $this->statusMain = array();

                $this->_calculateConseptAvgByArrayResult($key,$organizationId);

                $qualitativeAvg = ($this->qualitativeAvg != 0 and $this->qualitativeUnit) ? ($this->qualitativeAvg / $this->qualitativeUnit) : 0;
                $qualitativeAvgWithZero = ($this->qualitativeAvgWithZero != 0 and $this->qualitativeUnitWithZero) ? ($this->qualitativeAvgWithZero / $this->qualitativeUnitWithZero) : 0;
                $quantitaveAvg = ($this->quantitativeMustPassUnit != 0 and $this->quantitativePassedUnit) ? (($this->quantitativePassedUnit * 100) / $this->quantitativeMustPassUnit) : 0;
                $quantitaveAvgRelative = ($this->quantitativeMustPassUnitRelative != 0 and $this->quantitativePassedUnitRelative) ? (($this->quantitativePassedUnitRelative * 100) / $this->quantitativeMustPassUnitRelative) : 0;
                $combinedAvg = ($this->avgMain != 0 and $this->unitMain) ? ($this->avgMain / $this->unitMain) : 0;

                if ($conseptToLessonId == $key) {
                    /*if(yii::$app->user->id == 963)
                    {
                    if($lessonToBaseId == 6)
                    {
                    echo '<br><hr>';
                    print_r($arrData);
                    echo '<br><hr>';
                    }
                    }*/

                    $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $combinedAvg);
                    $scoreSign = yii::$app->fstring->translateDigits($lable['title']);
                    $note = $concept->consept->title;

                    if (!$combinedAvg && $arrData['data']['status'] == 'ExpireDate') {
                        //$lable      = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
                        $lable['color'] = 'bg-color-red';
                        $scoreSign = '<i class="gl gl-warning-sign m-t-5"></i>';
                        //$scoreSign      = yii::$app->fstring->translateDigits($lable['title']);;
                        $note = $note . ' - تاریخ اخذ نمره گذشته و دانش‌آموز هیچ نمره‌ای دریافت نکرده است  !' . "{$this->avgMain} / {$this->unitMain}";
                    } else if (!$combinedAvg && $arrData['data']['status'] != 'Passed') {
                        $lable['color'] = 'label-info';
                        $scoreSign = '-';
                        //$lable      = $this->getScoreLabel($lessonToBaseId,$organizationId,0.1);
                        //$scoreSign  = yii::$app->fstring->translateDigits($lable['title']);
                        $note = $note . ' - بدون نمره!';
                    }

                    $expireDateG = Utility::explodText($arrData['data']['expireDate'], 0, ' ');
                    if ($expireDateG != '0000-00-00' && $expireDateG)
                        $expireDate = yii::$app->fdate->convertDateToJalali($expireDateG, '/');
                    else $expireDate = '0000-00-00';

                    if (Utility::in_array_nested($concept->id, $halfPassedConsepts)) {
                        $halfPassed = true;
                    } else $halfPassed = false;

                    $avgTitle = '';
                    if ($side == 'teacher') {
                        $avgTitle = "- معدل({$combinedAvg} = {$this->avgMain} / {$this->unitMain})@ {$arrData['data']['status']} ";
                    }

                    $avgSpan .= " <span  class=\"tag {$lable['color']} label m-l-5\"
                                onclick=\"window.location.href = 'conseptsreport?academic=" . $academicId . "&lessonToBase=" . $lessonToBaseId . "&consept=" . $conseptToLessonId . "&subConsept=" . $concept->id . "'\"
                                title='{$note} $avgTitle - تاریخ انقضاء:‌$expireDate'>  " . " $scoreSign " . "  </span>";

                    $flag = false;
                    if ($expireDateG != '0000-00-00' && (strtotime($expireDateG) <= strtotime(date('Y-m-d')))) {
                        $flag = true;
                    }

                    $lessonCombinedSum += $combinedAvg * $this->unitMain;
                    $lessonCombinedUnit += $this->unitMain;

                    $lessonQuantitativePassedSum += $quantitaveAvg * $this->unitMain;
                    if (strtotime($expireDateG) <= strtotime(date('Y-m-d')))
                        $lessonQuantitativeUnit += $this->unitMain;

                    $lessonQuantitativePassedSumRelative += $quantitaveAvgRelative * $this->unitMain;
                    if (strtotime($expireDateG) <= strtotime(date('Y-m-d')))
                        $lessonQuantitativeUnitRelative += $this->unitMain;

                    $sumSubConsepts += $qualitativeAvg;

                    $lessonQualitativeSum += $qualitativeAvg * $this->qualitativeUnit;
                    $lessonQualitativeUnit += $this->qualitativeUnit;

                    $lessonQualitativeSumWithZero += $qualitativeAvgWithZero * $this->qualitativeUnitWithZero;
                    $lessonQualitativeUnitWithZero += $this->qualitativeUnitWithZero;
                }
            }
            $this->listConseptScore = array();
        }

        $lessonCombinedAvg = ($lessonCombinedSum and $lessonCombinedUnit) ? $lessonCombinedSum / $lessonCombinedUnit : 0;
        $lable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonCombinedAvg);
        $scoreSign = $lable['title'];
        if (!$lessonCombinedAvg) {
            $lable['color'] = 'bg-color-red';
            $scoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
        }

        $avgTitle = '';
        if ($side == 'teacher') {
            $avgTitle = " معدل ({$lessonCombinedAvg} = {$lessonCombinedUnit}÷{$lessonCombinedSum})";
        }

        $lessonCombinedAvgSpan = "<span class=\"tag {$lable['color']} label m-l-5\" title='$avgTitle'> " . $scoreSign . " </span>";

        //--------------------------------------------
        $lessonSumQualitativeLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $sumSubConsepts);
        $lessonQualitativeSumScoreSign = $lessonSumQualitativeLable['title'];
        if (!$lessonQualitativeSumScoreSign) {
            $lessonSumQualitativeLable['color'] = 'bg-color-red';
            $lessonQualitativeSumScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
        }
        $lessonQualitativeSumAvgSpan = "<span class=\"tag {$lessonSumQualitativeLable['color']} label m-l-5\" title='جمع نمرات ({$sumSubConsepts})'>" . $lessonQualitativeSumScoreSign . "</span>";

        //--------------------------------------------
        $lessonQualitativeAvg = ($lessonQualitativeSum and $lessonQualitativeUnit) ? $lessonQualitativeSum / $lessonQualitativeUnit : 0;
        $lessonQualitativeLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQualitativeAvg);
        $lessonQualitativeScoreSign = $lessonQualitativeLable['title'];
        if (!$lessonQualitativeScoreSign) {
            $lessonQualitativeLable['color'] = 'bg-color-red';
            $lessonQualitativeScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
        }
        $lessonQualitativeAvgSpan = "<span class=\"tag {$lessonQualitativeLable['color']} label m-l-5\" title='معدل کیفی ({$lessonQualitativeAvg} = {$lessonQualitativeUnit} ÷ {$lessonQualitativeSum})'>" . $lessonQualitativeScoreSign . "</span>";

        //--------------------------------------------
        $lessonQualitativeAvgWithZero = ($lessonQualitativeSumWithZero and $lessonQualitativeUnitWithZero) ? $lessonQualitativeSumWithZero / $lessonQualitativeUnitWithZero : 0;
        $lessonQualitativeWithZeroLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQualitativeAvgWithZero);
        $lessonQualitativeWithZeroScoreSign = $lessonQualitativeWithZeroLable['title'];
        if (!$lessonQualitativeWithZeroScoreSign) {
            $lessonQualitativeWithZeroLable['color'] = 'bg-color-red';
            $lessonQualitativeWithZeroScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
        }
        $lessonQualitativeWithZeroAvgSpan = "<span class=\"tag {$lessonQualitativeWithZeroLable['color']} label m-l-5\" title='معدل کیفی ({$lessonQualitativeAvgWithZero} = {$lessonQualitativeUnitWithZero} ÷ {$lessonQualitativeSumWithZero})'>" . $lessonQualitativeWithZeroScoreSign . "</span>";

        //----------------------------------------------
        $lessonQuantitativeAvg = ($lessonQuantitativePassedSum and $lessonQuantitativeUnit) ? $lessonQuantitativePassedSum / $lessonQuantitativeUnit : 0;
        $lessonQuantitativeLable = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQuantitativeAvg);
        $lessonQuantitativeScoreSign = $lessonQuantitativeLable['title'];
        if (!$lessonQuantitativeScoreSign) {
            $lessonQuantitativeLable['color'] = 'bg-color-red';
            $lessonQuantitativeScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
        }
        $lessonQuantitativeAvgSpan = "<span class=\"tag {$lessonQuantitativeLable['color']} label m-l-5\" title='معدل کمی ({$lessonQuantitativeAvg} = {$lessonQuantitativeUnit} ÷ {$lessonQuantitativePassedSum})'>" . $lessonQuantitativeScoreSign . "</span>";

        //----------------------------------------------
        $lessonQuantitativeAvgRelative = ($lessonQuantitativePassedSumRelative and $lessonQuantitativeUnitRelative) ? $lessonQuantitativePassedSumRelative / $lessonQuantitativeUnitRelative : 0;
        $lessonQuantitativeLableRelative = $this->getScoreLabel($lessonToBaseId, $organizationId, $lessonQuantitativeAvgRelative);
        $lessonQuantitativeScoreSign = $lessonQuantitativeLableRelative['title'];
        if (!$lessonQuantitativeScoreSign) {
            $lessonQuantitativeLableRelative['color'] = 'bg-color-red';
            $lessonQuantitativeScoreSign = '<i class="glyphicon glyphicon-minus-sign m-t-5"></i>';
        }
        $lessonQuantitativeAvgRelativeSpan = "<span class=\"tag {$lessonQuantitativeLableRelative['color']} label m-l-5\" title='معدل کمی ({$lessonQuantitativeAvgRelative} = {$lessonQuantitativeUnitRelative} ÷ {$lessonQuantitativePassedSumRelative})'>" . $lessonQuantitativeScoreSign . "</span>";

        //--------------------------------------------------
        $result = array(
            'conseptsAvg' => $avgSpan,
            'halfPassedStatus' => $halfPassed,
            'expired' => $flag,
            'lessonCombinedAvg' => $lessonCombinedAvgSpan,
            'lessonQualitativeAvgAsNumber' => $lessonQualitativeAvg,
            'lessonCombinedAvgAsNumber' => $lessonCombinedAvg,
            'lessonQualitativeAvg' => $lessonQualitativeAvgSpan,
            'lessonQualitativeSumAvg' => $lessonQualitativeSumAvgSpan,
            'lessonQualitativeAvgWithZero' => $lessonQualitativeWithZeroAvgSpan,
            'lessonQuantitativeAvg' => $lessonQuantitativeAvgSpan,
            'lessonQuantitativeAvgAsNumber' => $lessonQuantitativeAvg,
            'lessonQuantitativeAvgRelative' => $lessonQuantitativeAvgRelativeSpan,
            'lessonQuantitativeAvgRelativeAsNumber' => $lessonQuantitativeAvgRelative,
            'lessonQuantitativeAvgRelativeWithZero' => $lessonQualitativeAvgWithZero,
        );
        return $result;
    }

    public function haveHalfPassedConsepts($academicId, $lessonToBaseId, $fieldId, $getOne = false, $checkMafhoom = false)
    {

        $conseptsToLesson = ConseptToLesson::find()
            ->select('cl.consept_id,cl.id,clfg.expire_date,clf.field_id')
            ->alias('cl')
            ->innerJoin('{{%consept_lesson_to_field}} clf', 'cl.id = clf.consept_lesson_id')
            ->innerJoin('{{%consept_lesson_field_to_group}} clfg', 'clf.id = clfg.consept_lesson_field_id')
            ->distinct()
            ->where([
                'lesson_to_base_id' => $lessonToBaseId,
                'parent_id' => NULL,
                'clf.field_id' => $fieldId,
                'clf.is_enable' => 1,
                'clfg.is_enable' => 1,
                'clfg.is_optional' => 0,
                'clfg.is_delete' => 0,
                'cl.is_delete' => 0,
            ])
            ->orderBy(['clfg.position' => SORT_ASC])
            ->all();

        $conseptCount = count($conseptsToLesson);

        if ($conseptsToLesson) {
            $result = array();
            foreach ($conseptsToLesson as $conseptToLesson) {
                if (!EstimateAcademicToScore::find()->where(['academic_id' => $academicId, 'consept_to_lesson_id' => $conseptToLesson->id, 'is_deleted' => 0])->all()) {
                    $subConsepts = ConseptToLesson::find()
                        ->select('cl.consept_id,cl.id,clfg.expire_date')
                        ->alias('cl')
                        ->innerJoin('{{%consept_lesson_to_field}} clf', 'cl.id = clf.consept_lesson_id')
                        ->innerJoin('{{%consept_lesson_field_to_group}} clfg', 'clf.id = clfg.consept_lesson_field_id')
                        ->distinct()
                        ->where([
                            'cl.parent_id' => $conseptToLesson->id,
                            'cl.lesson_to_base_id' => $lessonToBaseId,
                            'clf.is_enable' => 1,
                            'clfg.is_enable' => 1,
                            'clf.field_id' => $fieldId,
                            'clfg.is_optional' => 0,
                            'clfg.is_comput_work_book' => 1,
                            'clfg.is_delete' => 0,
                            'cl.is_delete' => 0,
                        ])
                        ->orderBy(['clfg.position' => SORT_ASC])
                        ->all();


                    if ($subConsepts) {
                        $catchedScore = 0;
                        $subConseptsCount = count($subConsepts);
                        foreach ($subConsepts as $subConsept) {
                            if (EstimateAcademicToScore::find()->where(['academic_id' => $academicId, 'consept_to_lesson_id' => $subConsept->id, 'is_deleted' => 0])->all()) {
                                $catchedScore++;
                                $subConseptId = $subConsept->id;
                                $conseptTitle = $conseptToLesson->consept->title;
                            }
                        }
                        if ($catchedScore) {
                            if ($subConseptsCount > $catchedScore) {
                                if ($getOne) {
                                    return array(
                                        'consept' => $conseptToLesson->id,
                                        'subConsept' => $subConseptId,
                                        'conseptTitle' => $conseptTitle,
                                        'subConseptCount' => $subConseptsCount,
                                        'passedCount' => $catchedScore
                                    );
                                } else {
                                    $result[] = array(
                                        'consept' => $conseptToLesson->id,
                                        'subConsept' => $subConseptId,
                                        'conseptTitle' => $conseptTitle,
                                        'subConseptCount' => $subConseptsCount,
                                        'passedCount' => $catchedScore
                                    );
                                }
                            }
                        }
                    }
                }
            }
            return $result;
        }
        return false;
    }

    public function getMaxAndMinScores($arrayConceptLessonFieldToGroup,$lessonToBaseId,$organizationId)
    {
        $selectedArray = [];
        foreach ($arrayConceptLessonFieldToGroup as $conceptLessonFieldToGroup) {
            $conceptLessFieldToGroup = ConseptLessonFieldToGroup::findOne($conceptLessonFieldToGroup);
            $selectedArray[] = $conceptLessFieldToGroup->conseptLessonField->conseptLesson->id;
        }

        /*$max = EstimateAcademicToScore::find()
            ->where(['consept_to_lesson_id' => $selectedArray,
            'is_deleted' => 0,
            'is_parent' => 0,
        ])->max('score');

        $min = EstimateAcademicToScore::find()
            ->where(['consept_to_lesson_id' => $selectedArray,
            'is_deleted' => 0,
            'is_parent' => 0,
        ])->min('score');*/

        $max = 0;
        $min = 100;
        $avg = $sum = $count = 0;
        $all = EstimateAcademicToScore::find()
            ->where(['consept_to_lesson_id' => $selectedArray,
            'is_deleted' => 0,
            'is_parent' => 0,
        ])->all();
        if($all){
            foreach ($all as $row) {
                if($row->score > $max){
                    $max = $row->score;
                }
                if($row->score < $min){
                    $min = $row->score;
                }

                $sum += $row->score;
                $count++;
            }
        }

        if($count){
            $avg = ($sum/$count);
        }


        $maxLabel = $this->getScoreLabel($lessonToBaseId, $organizationId, $max);
        $maxScoreSign = yii::$app->fstring->translateDigits($maxLabel['title']);

        $minLabel = $this->getScoreLabel($lessonToBaseId, $organizationId, $min);
        $minScoreSign = yii::$app->fstring->translateDigits($minLabel['title']);

        $avgLabel = $this->getScoreLabel($lessonToBaseId, $organizationId, $avg);
        $avgScoreSign = yii::$app->fstring->translateDigits($avgLabel['title']);

        return ['max' => $max, 'min' => $min, 'avg' => $avg,
            'minSpan' =>  " <span  class=\"tag {$minLabel['color']}  label m-l-5\">" . $minScoreSign . "</span>",
            'maxSpan' =>  " <span  class=\"tag {$maxLabel['color']}  label m-l-5\">" . $maxScoreSign . "</span>",
            'avgSpan' =>  " <span  class=\"tag {$avgLabel['color']}  label m-l-5\">" . $avgScoreSign . "</span>",
        ];

    }

    private function checkConseptHaveScore($conseptLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId)
    {
        $conseptLessonToField = ConseptLessonToField::find()
            ->alias('clf')
            ->select('clf.*,clfg.*')
            ->innerJoin('{{%consept_lesson_field_to_group}} clfg', 'clf.id = clfg.consept_lesson_field_id')
            ->where(
                [
                    'clf.field_id' => $fieldId,
                    'clf.consept_lesson_id' => $conseptLessonObj->id
                ])
            ->one();


        if (!$conseptLessonToField) {
            return false;
        }

        $conseptToLesson = ConseptToLesson::find()->where([
            'lesson_to_base_id' => $lessonToBaseId,
            'consept_id' => $conseptLessonObj->consept_id,
            'parent_id' => $conseptLessonObj->parent_id,
        ])->one();

        /*if($lessonToBaseId == 1554){
        die('parent is: ' . $conseptLessonObj->id);
        }*/

        if ($conseptToLesson) {
            /*if($lessonToBaseId == 1554){
            die('c is: ' . $conseptToLesson->id);
            }*/

            $scores = EstimateAcademicToScore::find()->where([
                'academic_id' => $academicId,
                'consept_to_lesson_id' => $conseptToLesson->id,
                'is_deleted' => 0,
                'is_parent' => 0,
            ])->all();
            if ($scores)
                return true;
            else return false;
        } else {
            /*if($lessonToBaseId == 1554){
            die('cd is: ' . $conseptToLesson->id);
            }*/

            return false;
        }

    }

    //=========================================================================== private methods
    private function _getConseptNodeAvgAndStatus($conseptLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate = false, $toDate = false, $parentExpireDate = null)
    {
        $result = array();
        $conseptUnitSum = $conseptSum = $avg = 0;

        $conseptLessonToField = ConseptLessonToField::find()
            ->alias('clf')
            ->select('clf.*,clfg.*')
            ->innerJoin('{{%consept_lesson_field_to_group}} clfg', 'clf.id = clfg.consept_lesson_field_id')
            ->where(
                [
                    'clf.field_id' => $fieldId,
                    'clf.consept_lesson_id' => $conseptLessonObj->id
                ])
            ->one();


        if (!$conseptLessonToField) {
            return false;
        }

        /*if(yii::$app->user->id == 963)
        {
        if($lessonToBaseId == 6 and $conseptLessonObj->id == 1655)
        {
        print_r($conseptLessonObj);die;
        }
        }*/

        if ($conseptLessonToField->is_comput_work_book) {
            $scoreInfo = $this->_getAvg($academicId, $lessonToBaseId, $conseptLessonObj->consept_id, $conseptLessonToField->unit, $organizationId, $fieldId, $conseptLessonObj->parent_id, $fromDate, $toDate);
            if ($scoreInfo) {
                $status = 'Passed';
                $avg = $scoreInfo->score;
            } else {
                if ($conseptLessonToField->is_direct_score) {
                    if ($conseptLessonToField->expire_date) {
                        if (strtotime(Utility::explodText($conseptLessonToField->expire_date, 0, ' ')) > strtotime(date('Y-m-d'))) {
                            $status = 'HaveTime';
                        } else $status = 'ExpireDate';
                    } else {
                        if ($parentExpireDate) {

                            if (strtotime($parentExpireDate) > strtotime(date('Y-m-d')))
                                $status = 'HaveTime';
                            else $status = 'ExpireDate';
                        } else $status = 'TimeLess';
                    }
                } else $status = 'NotDirectScore';
            }
        } else {
            $scoreInfo = $this->_getAvg($academicId, $lessonToBaseId, $conseptLessonObj->consept_id, $conseptLessonToField->unit, $organizationId, $fieldId, $conseptLessonObj->parent_id, $fromDate, $toDate);
            $status = 'NotInWorkbook';
            $avg = $scoreInfo['score'];
        }
        //$conseptLessonToField->unit;
        $result = ['unit' => $conseptLessonToField->unit, 'status' => $status, 'avg' => $avg, 'expireDate' => $conseptLessonToField->expire_date];
        return $result;
    }

    private function _calculateAvgBasedOnConsept($lessonToBaseId, $conseptToLessonObj, $academicId, $organizationId, $fieldId, $fromDate = false, $toDate = false, $parentExpireDate = null, $checkMainConseptHaveScore = false)
    {
        $subConseptSum = $subConseptUnitSum = 0;

        $subConsepts = ConseptToLesson::find()->where([
            'lesson_to_base_id' => $lessonToBaseId,
            'parent_id' => $conseptToLessonObj->id,
            'is_delete' => 0
        ])->all();



        if ($checkMainConseptHaveScore) {

            if ($this->checkConseptHaveScore($conseptToLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId)) {

                $conseptInfo = $this->_getConseptNodeAvgAndStatus($conseptToLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate, $toDate, $parentExpireDate);
                /*if($conseptToLessonObj->id == 57150 && yii::$app->user->id == 1){
                    die('is : ' . $lessonToBaseId);
                }*/
                if(yii::$app->fcore->getOrganization() == 59)
                    if($conseptInfo['status'] == 'Passed' ||  $conseptInfo['status'] == 'NotInWorkbook'){
                        $conseptInfo['qualitativeAvg'] = $conseptInfo['avg'];
                    }
                    else {
                        $conseptInfo['qualitativeAvg'] = 0;
                    }
                else
                    $conseptInfo['qualitativeAvg'] = ( $conseptInfo['status'] == 'Passed') ? $conseptInfo['avg'] : 0;
                $this->listConseptScore[$conseptToLessonObj->id]['data'] = $conseptInfo;
                return $conseptInfo;
            } else {
                if ($subConsepts) //calculate avg based on sub consept
                {
                    $combinedTempUnit =
                    $combinedTempAvg =
                    $quantitativeAvgTemp =
                    $quantitativeUnitTemp =
                    $qualitativeAvgTemp =
                    $allQuantitiveUnitTemp = 0;
                    $allQuantitiveUnitTempPassed = 0;
                    $qualitativeUnitTemp = 0;

                    foreach ($subConsepts as $subConsept) {
                        $conseptInfo = $this->_getConseptNodeAvgAndStatus($subConsept, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate, $toDate, $parentExpireDate);
                        if ($conseptInfo) {
                            $allQuantitiveUnitTemp += $conseptInfo['unit'];
                            if ($conseptInfo['status'] == 'Passed') {
                                $allQuantitiveUnitTempPassed += $conseptInfo['unit'];
                            }

                            if ($conseptInfo['status'] == 'ExpireDate' || $conseptInfo['status'] == 'Passed') {
                                $combinedTempAvg += $conseptInfo['avg'] * $conseptInfo['unit'];
                                $combinedTempUnit += $conseptInfo['unit'];

                                if ($conseptInfo['status'] == 'Passed') {
                                    $qualitativeAvgTemp += $conseptInfo['avg'] * $conseptInfo['unit'];
                                    $qualitativeUnitTemp += $conseptInfo['unit'];
                                }

                            }
                            $this->listConseptScore[$conseptToLessonObj->id][$subConsept->id]['data'] = $conseptInfo;
                            $this->_calculateAvgBasedOnConsept($lessonToBaseId, $subConsept, $academicId, $organizationId, $fieldId, $fromDate, $toDate);
                        }
                    }

                    $conseptInfo = $this->_getConseptNodeAvgAndStatus($conseptToLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate, $toDate, $parentExpireDate);
                    $conseptInfo['subConseptsUnitSum'] = $allQuantitiveUnitTemp;
                    $conseptInfo['subConseptsUnitSumPassed'] = $allQuantitiveUnitTempPassed;
                    if ($conseptInfo['avg'] == 0) {
                        $conseptInfo['avg'] = ($combinedTempUnit) ? ($combinedTempAvg / $combinedTempUnit) : 0;
                        $conseptInfo['qualitativeAvg'] = ($qualitativeUnitTemp) ? ($qualitativeAvgTemp / $qualitativeUnitTemp) : 0;
                    } else {
                        $conseptInfo['qualitativeAvg'] = ($qualitativeUnitTemp) ? ($qualitativeAvgTemp / $qualitativeUnitTemp) : $conseptInfo['avg'];
                    }


                    $this->listConseptScore[$conseptToLessonObj->id]['data'] = $conseptInfo;
                }
            }


        } else {
            if ($subConsepts) //calculate avg based on sub consept
            {
                $combinedTempUnit =
                $combinedTempAvg =
                $quantitativeAvgTemp =
                $quantitativeUnitTemp =
                $qualitativeAvgTemp =
                $allQuantitiveUnitTemp = 0;
                $allQuantitiveUnitTempPassed = 0;
                $qualitativeUnitTemp = 0;

                foreach ($subConsepts as $subConsept) {
                    $conseptInfo = $this->_getConseptNodeAvgAndStatus($subConsept, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate, $toDate, $parentExpireDate);
                    if ($conseptInfo) {
                        $allQuantitiveUnitTemp += $conseptInfo['unit'];
                        $sumQualitativeAvgTemp += $conseptInfo['avg'];
                        if ($conseptInfo['status'] == 'Passed') {
                            $allQuantitiveUnitTempPassed += $conseptInfo['unit'];
                        }

                        if ($conseptInfo['status'] == 'ExpireDate' || $conseptInfo['status'] == 'Passed') {
                            $combinedTempAvg += $conseptInfo['avg'] * $conseptInfo['unit'];
                            $combinedTempUnit += $conseptInfo['unit'];

                            if ($conseptInfo['status'] == 'Passed') {
                                $qualitativeAvgTemp += $conseptInfo['avg'] * $conseptInfo['unit'];
                                $qualitativeUnitTemp += $conseptInfo['unit'];
                            }

                        }
                        $this->listConseptScore[$conseptToLessonObj->id][$subConsept->id]['data'] = $conseptInfo;
                        $this->_calculateAvgBasedOnConsept($lessonToBaseId, $subConsept, $academicId, $organizationId, $fieldId, $fromDate, $toDate);
                    }
                }

                $conseptInfo = $this->_getConseptNodeAvgAndStatus($conseptToLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate, $toDate, $parentExpireDate);
                $conseptInfo['subConseptsUnitSum'] = $allQuantitiveUnitTemp;
                $conseptInfo['subConseptsUnitSumPassed'] = $allQuantitiveUnitTempPassed;
                $conseptInfo['subConseptsAvgSum'] = $sumQualitativeAvgTemp;
                if ($conseptInfo['avg'] == 0) {
                    $conseptInfo['avg'] = ($combinedTempUnit) ? ($combinedTempAvg / $combinedTempUnit) : 0;
                    $conseptInfo['qualitativeAvg'] = ($qualitativeUnitTemp) ? ($qualitativeAvgTemp / $qualitativeUnitTemp) : 0;
                } else {
                    $conseptInfo['qualitativeAvg'] = ($qualitativeUnitTemp) ? ($qualitativeAvgTemp / $qualitativeUnitTemp) : $conseptInfo['avg'];
                }


                $this->listConseptScore[$conseptToLessonObj->id]['data'] = $conseptInfo;
            } else //calculate avg based on consept
            {

                $conseptInfo = $this->_getConseptNodeAvgAndStatus($conseptToLessonObj, $fieldId, $academicId, $lessonToBaseId, $organizationId, $fromDate, $toDate, $parentExpireDate);
                $conseptInfo['qualitativeAvg'] = $conseptInfo['status'] == 'Passed' ? $conseptInfo['avg'] : 0;
                $this->listConseptScore[$conseptToLessonObj->id]['data'] = $conseptInfo;
                return $conseptInfo;
            }
        }
    }

    protected function _calculateConseptAvgByArrayResult($key,$organizationId)
    {

        if (isset($this->listConseptScore[$key])) {

            /*if(yii::$app->user->id == 1)
            {
                if($key == 57150)
                {
                echo '<br><hr>';
                print_r($this->listConseptScore);
                echo '<hr>';
                print_r($this->listConseptScore[$key]);
                echo '<br>***<hr>';
                die('jj');
                }
            }*/

            // to show main concept avg uncomment this below

            if ( $organizationId == 2 && isset($this->listConseptScore[$key]['data']['avg']) && $this->listConseptScore[$key]['data']['avg'] > 0) {
                $this->avgMain += $this->listConseptScore[$key]['data']['avg'] * $this->listConseptScore[$key]['data']['unit'];
                $this->unitMain += $this->listConseptScore[$key]['data']['unit'];
            } else {
                $mainOrg = yii::$app->fcore->getOrganization();
                foreach ($this->listConseptScore[$key] as $newKey => $newValue) {
                    /*if(yii::$app->user->id == 1 && $key == 57150){
                            die('new key is : ' . $newKey);
                        }*/
                    $res = $this->_calculateConseptAvgByArrayResult($newKey,$organizationId);
                    if ($res == false) {

                        if (isset($newValue['avg']) and ($newValue['status'] == 'Passed' || ($newValue['status'] == 'NotInWorkbook' && $mainOrg = 59) || $newValue['status'] == 'ExpireDate' || ($newValue['status'] == 'HaveTime' && $newValue['avg'] != 0))) {
                            /*if($key == 57150)
                            {
                            echo 'beforre: ';
                            echo $this->avgMain.'<br>';
                            echo $this->unitMain.'<hr>';
                            //die('hh');
                            }*/
                            $this->avgMain += $newValue['avg'] * $newValue['unit'];
                            $this->unitMain += $newValue['unit'];

                            /*if($key == 57150)
                            {
                                echo $newValue['avg'] .'*'. $newValue['unit'].'key'. $newKey .'<br>';
                                echo $this->avgMain .'<br>';
                                echo $this->unitMain.'<hr>';
                                die('gf');
                            }*/


                            if ($newValue['status'] == 'ExpireDate' && isset($newValue['subConseptsUnitSum'])) {
                                $sumUnit = ((int)$newValue['unit'] + (int)$newValue['subConseptsUnitSum']);
                                $this->quantitativeMustPassUnit += $sumUnit;
                            } else if (strtotime($newValue['expireDate']) <= strtotime(date('Y-m-d'))) {
                                $sumUnit = ((int)$newValue['unit'] + (int)$newValue['subConseptsUnitSum']);
                                $this->quantitativeMustPassUnit += $sumUnit;
                            }

                            /*if($newValue['avg'] || $newValue['qualitativeAvg'])
                            {

                            $this->quantitativePassedUnit       += $newValue['unit'];

                            }*/
                            /*if($key == 57150 && yii::$app->user->id == 1)
                            {
                                die(print_r($newValue));
                            }*/
                            if (isset($newValue['subConseptsUnitSumPassed']) && $newValue['subConseptsUnitSumPassed'] != 0) {
                                $sumUnit = ((int)$newValue['unit'] + (int)$newValue['subConseptsUnitSumPassed']);
                                $this->quantitativePassedUnit += $sumUnit;

                            } else if ($newValue['subConseptsUnitSumPassed'] == 0 && $newValue['avg'] != 0) // be mafhoom mostaghim nomreh dadehand
                            {
                                $sumUnit = ((int)$newValue['unit'] + (int)$newValue['subConseptsUnitSum']);
                                $this->quantitativePassedUnit += $sumUnit;
                            }

                            if (isset($newValue['qualitativeAvg'])) // to calculate quantitative avg
                            {
                                $this->quantitativeMustPassUnitRelative = $newValue['unit'];
                            }

                            $this->statusMain[$newKey] = $newValue['status'];

                            if ($newValue['status'] == 'Passed' || ($newValue['status'] == 'NotInWorkbook' && $mainOrg = 59)) {
                                $this->qualitativeAvg += $newValue['qualitativeAvg'] * $newValue['unit'];
                                $this->qualitativeUnit += $newValue['unit'];
                                $this->quantitativePassedUnitRelative += $newValue['unit'];
                            }

                            if ($newValue['status'] == 'Passed' || $newValue['status'] == 'ExpireDate' || ($newValue['status'] == 'NotInWorkbook' && $mainOrg = 59)) {
                                /*if(yii::$app->user->id == 1 && $key == 57150)
                                {
                                    echo  "sss =>   $newValue[qualitativeAvg]  *  $newValue[unit]<br>";
                                    die('ogog');
                                }*/
                                $this->qualitativeAvgWithZero += $newValue['qualitativeAvg'] * $newValue['unit'];
                                $this->qualitativeUnitWithZero += $newValue['unit'];
                            }
                        } else {//if(($newValue['status'] == 'notInWorkbook')){
                            //die(print_r($newValue));
                            $this->avgMain += $newValue['avg'] * $newValue['unit'];
                            $this->unitMain += $newValue['unit'];
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    private function _getAvg($academicId, $lessonToBaseId, $conseptId, $unit, $organizationId, $fieldId, $parentId, $fromDate = false, $toDate = false)
    {
        $lessonTypeScore = EstimateLessonToTypeScore::find()->where(['lesson_to_base_id' => $lessonToBaseId, 'organization_id' => $organizationId])->one();

        if ($lessonTypeScore) {
            $reportType = $lessonTypeScore->estimate_report_type_id;
        } else $reportType = 2; // 2 is avg scors


        $conseptToLesson = ConseptToLesson::find()->where([
            'lesson_to_base_id' => $lessonToBaseId,
            'consept_id' => $conseptId,
            'parent_id' => $parentId,
        ])->one();

        if ($conseptToLesson) {
            $scores = EstimateAcademicToScore::find()->where([
                'academic_id' => $academicId,
                'consept_to_lesson_id' => $conseptToLesson->id,
                'is_deleted' => 0,
                'is_parent' => 0,
            ]);


            if ($fromDate) {                             //(`catch_score_date` >= '2020-09-26') AND (`catch_score_date` <= '2020-09-27')
                $scores = $scores->andWhere(['>', 'catch_score_date', $fromDate]);
                $scores = $scores->andWhere(['<=', 'catch_score_date', $toDate]);
                /*if(yii::$app->user->id == 963 && $conseptToLesson->id == 56344)
                {
                echo $query =  ($scores->createCommand()->getRawSql()).'<br>';
                } */
            }
            /*if(yii::$app->user->id == 963 && $conseptToLesson->id == 56344)
            {
            echo $query =  ($scores->createCommand()->getRawSql()).'<br>';
            }*/
            $scores = $scores->all();

        } else $scores = null;

        if ($scores) {
            /*if(yii::$app->user->id == 963 && $conseptToLesson->id == 56344)
            {

            die(print_r($scores));
            //echo ('query is : ' . $query);
            } */
            switch ($reportType) {
                case 1: //last score
                    /*if($conseptId == 1565 )
                    {
                    die('ok');
                    die(print_r($scores));
                    }*/
                    return $this->_calculateBasedOnLastScore($scores);
                    break;

                case 2: //average
                    if ($conseptToLesson)
                        return $this->_calculateBasedOnAvgScores($scores, $unit);
                    return false;

                    break;

                case 3: //min score
                    return $this->_calculateBasedMinScore($scores);
                    break;

                case 4: //max score
                    return $this->_calculateBasedMaxScore($scores);
                    break;

                case 5: //first score
                    return $this->_calculateBasedOnFirstScore($scores);
                    break;

                case 6: //sum score
                    return $this->_calculateBasedOnSumScore($scores);
                    break;
            }
        } else {
            return false;
        }
    }

    private function _calculateBasedOnLastScore($scores)
    {
        /*if($conseptId == 1565 )
        {
        echo($scores[0]->catch_score_date);
        echo($scores[0]->catch_score_date);
        die(print_r($scores));
        }*/
        $this->lastScoreDate = $scores[0]->catch_score_date;
        $this->scores = $scores[0];
        foreach ($scores as $score) {
            if (strtotime($score->catch_score_date) >= strtotime($this->lastScoreDate)) {
                $this->lastScoreDate = $score->catch_score_date;
                $this->scores = $score;
            }
        }
        return $this->scores;
    }

    private function _calculateBasedOnFirstScore($scores)
    {
        $this->lastScoreDate = $scores[0]->catch_score_date;
        $this->scores = $scores[0];
        foreach ($scores as $score) {
            if (strtotime($score->catch_score_date) <= strtotime($this->lastScoreDate)) {
                $this->lastScoreDate = $score->catch_score_date;
                $this->scores = $score;
            }
        }
        return $this->scores;
    }

    private function _calculateBasedOnSumScore($scores)
    {
        $scoresSum = 0;
        foreach ($scores as $score) {
            $scoresSum += $score->score;
        }
        if ($scoresSum) {
            //die('sum is: ' . $scoresSum);
            $sumScoreObj = (object)['score' => $scoresSum];
            return $sumScoreObj;
        }
        return false;
    }

    private function _calculateBasedOnAvgScores($scores, $unit)
    {
        $scoresSum = $scoreUnits = 0;
        foreach ($scores as $score) {
            $scoresSum += $score->score * $unit;
            $scoreUnits += $unit;
        }
        if ($scoresSum) {
            $scoreSvg = $scoresSum / $scoreUnits;
            $sumScoreObj = (object)['score' => $scoreSvg];
            return $sumScoreObj;
        }
        return false;
    }

    private function _calculateBasedMinScore($scores)
    {
        $this->minScore = $scores[0]->score;
        $this->scores = $scores[0];
        foreach ($scores as $score) {
            if (($score->score) <= ($this->minScore)) {
                $this->scores = $score;
            }
        }
        return $this->scores;
    }

    private function _calculateBasedMaxScore($scores)
    {
        $this->maxScore = $scores[0]->score;
        $this->scores = $scores[0];
        foreach ($scores as $score) {
            if (($score->score) >= ($this->maxScore)) {
                $this->scores = $score;
            }
        }
        return $this->scores;
    }

}
