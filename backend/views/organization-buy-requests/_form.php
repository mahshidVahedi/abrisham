<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-requests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manager_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_nationality_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_mobile')->textInput() ?>

    <?= $form->field($model, 'manager_gender')->dropDownList([ 'FEMALE' => 'خانم', 'MALE' => 'آقا', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'manager_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unique_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'process_status')->dropDownList([ 'FINAL_REGISTER' => 'FINAL REGISTER', 'FINAL_DEVELOP' => 'FINAL DEVELOP', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pre_school_1')->textInput() ?>

    <?= $form->field($model, 'pre_school_2')->textInput() ?>

    <?= $form->field($model, 'first')->textInput() ?>

    <?= $form->field($model, 'secound')->textInput() ?>

    <?= $form->field($model, 'third')->textInput() ?>

    <?= $form->field($model, 'fourth')->textInput() ?>

    <?= $form->field($model, 'fifth')->textInput() ?>

    <?= $form->field($model, 'sixth')->textInput() ?>

    <?= $form->field($model, 'seventh')->textInput() ?>

    <?= $form->field($model, 'eighth')->textInput() ?>

    <?= $form->field($model, 'ninth')->textInput() ?>

    <?= $form->field($model, 'tenth_math')->textInput() ?>

    <?= $form->field($model, 'tenth_humanities')->textInput() ?>

    <?= $form->field($model, 'tenth_empirical')->textInput() ?>

    <?= $form->field($model, 'eleventh_math')->textInput() ?>

    <?= $form->field($model, 'eleventh_humanities')->textInput() ?>

    <?= $form->field($model, 'eleventh_empirical')->textInput() ?>

    <?= $form->field($model, 'twelfth_math')->textInput() ?>

    <?= $form->field($model, 'twelfth_humanities')->textInput() ?>

    <?= $form->field($model, 'twelfth_empirical')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
