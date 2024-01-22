<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Permission $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="permission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sellers_list')->textInput() ?>

    <?= $form->field($model, 'sellers_create')->textInput() ?>

    <?= $form->field($model, 'sellers_edit')->textInput() ?>

    <?= $form->field($model, 'sellers_delete')->textInput() ?>

    <?= $form->field($model, 'users_list')->textInput() ?>

    <?= $form->field($model, 'users_create')->textInput() ?>

    <?= $form->field($model, 'users_edit')->textInput() ?>

    <?= $form->field($model, 'users_delete')->textInput() ?>

    <?= $form->field($model, 'request_list')->textInput() ?>

    <?= $form->field($model, 'request_create')->textInput() ?>

    <?= $form->field($model, 'request_edit')->textInput() ?>

    <?= $form->field($model, 'request_delete')->textInput() ?>

    <?= $form->field($model, 'permission_list')->textInput() ?>

    <?= $form->field($model, 'permission_create')->textInput() ?>

    <?= $form->field($model, 'permission_edit')->textInput() ?>

    <?= $form->field($model, 'permission_delete')->textInput() ?>

    <?= $form->field($model, 'assign_permission_create')->textInput() ?>

    <?= $form->field($model, 'assign_permisson_list')->textInput() ?>

    <?= $form->field($model, 'assign_permission_edit')->textInput() ?>

    <?= $form->field($model, 'assign_permission_delete')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
