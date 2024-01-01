<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Users $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-form" style="width:30%; margin: auto; margin-top: 5%;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'FEMALE' => 'خانم', 'MALE' => 'آقا', 'OTHER' => 'دیگر', ], ['prompt' => 'انتخاب کنید']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'superuser')->checkbox() ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group" dir="ltr">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
