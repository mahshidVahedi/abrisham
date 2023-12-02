<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequest $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-request-form" style="direction:rtl;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manager_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_ncode')->textInput() ?>

    <?= $form->field($model, 'manager_phone')->textInput() ?>

    <?= $form->field($model, 'manager_gender')->dropDownList([ 'female' => 'خانم', 'male' => 'آقا', ], ['prompt' => 'انتخاب کنید']) ?>

    <?= $form->field($model, 'manager_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'org_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'org_phone')->textInput() ?>

    <div class="form-group" style="float:left; margin-top:5%;">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
