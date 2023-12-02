<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-requests-form" style="direction: rtl;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manager_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_nationality_code')->textInput() ?>

    <?= $form->field($model, 'manager_mobile')->textInput() ?>

    <?= $form->field($model, 'manager_gender')->dropDownList([ 'female' => 'Female', 'male' => 'Male', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'manager_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organixation_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_phone')->textInput() ?>

    <!-- <?= $form->field($model, 'unique_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?> -->

    <?= $form->field($model, 'seller_id')->textInput() ?>

    <div class="form-group" style="float: left; margin-top: 5%;">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
