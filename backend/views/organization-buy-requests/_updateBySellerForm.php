<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-requests-form" style="direction: rtl;">
    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'organization_name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'manager_name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'manager_lastname')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'manager_nationality_code')->textInput()?>

    <?=$form->field($model, 'manager_gender')->dropDownList(['FEMALE' => 'خانم', 'MALE' => 'آقا'], ['prompt' => 'انتخاب کنید'])?>

    <?=$form->field($model, 'manager_email')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'organization_address')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'organization_phone')->textInput()?>

    <?=$form->field($model, 'school_type')->dropDownList(['girl' => 'دخترانه', 'boy' => 'پسرانه'], ['prompt' => 'انتخاب کنید'])?>

    <?= $form->field($model, 'pre_school_1')->checkbox()?>

    <?= $form->field($model, 'pre_school_2')->checkbox() ?>

    <?= $form->field($model, 'first')->checkbox() ?>

    <?= $form->field($model, 'secound')->checkbox() ?>

    <?= $form->field($model, 'third')->checkbox() ?>

    <?= $form->field($model, 'pre_primary1_together')->checkbox() ?>

    <?= $form->field($model, 'fourth')->checkbox() ?>

    <?= $form->field($model, 'fifth')->checkbox() ?>

    <?= $form->field($model, 'sixth')->checkbox() ?>

    <?= $form->field($model, 'primary1_primary2_together')->checkbox() ?>

    <?= $form->field($model, 'seventh')->checkbox() ?>

    <?= $form->field($model, 'eighth')->checkbox() ?>

    <?= $form->field($model, 'ninth')->checkbox() ?>

    <?= $form->field($model, 'tenth_math')->checkbox() ?>

    <?= $form->field($model, 'tenth_humanities')->checkbox() ?>

    <?= $form->field($model, 'tenth_empirical')->checkbox() ?>

    <?= $form->field($model, 'eleventh_math')->checkbox() ?>

    <?= $form->field($model, 'eleventh_humanities')->checkbox() ?>

    <?= $form->field($model, 'eleventh_empirical')->checkbox() ?>

    <?= $form->field($model, 'twelfth_math')->checkbox() ?>

    <?= $form->field($model, 'twelfth_humanities')->checkbox() ?>

    <?= $form->field($model, 'twelfth_empirical')->checkbox() ?>

    <?= $form->field($model, 'high1_high2_together')->checkbox() ?>

    <?=$form->field($model, 'process_status')->dropDownList(['FINAL_REGISTER' => 'ثبت نهایی', 'FINAL_DEVELOP' => 'توسعه نهایی'], ['prompt' => 'انتخاب کنید'])?>

    <div class="form-group" style="float: left; margin-top: 5%;">
        <?=Html::submitButton('‌ذخیره', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
