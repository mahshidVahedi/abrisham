<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-requests-form" style="direction: rtl;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manager_mobile')->textInput() ?>

    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="float: left; margin-top: 5%;">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
