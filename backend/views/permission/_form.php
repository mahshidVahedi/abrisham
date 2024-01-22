<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Permission $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="permission-form" style="width:80%; margin: auto; margin-top:10px; margin-bottom:100px">

    <?php $form = ActiveForm::begin();?>
    <div style="width: 30%;">

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    </div>

    <div class="col-md-3">

    <?=$form->field($model, 'sellers_list')->checkbox()?>

    <?=$form->field($model, 'sellers_create')->checkbox()?>

    <?=$form->field($model, 'sellers_edit')->checkbox()?>

    <?=$form->field($model, 'sellers_delete')->checkbox()?>
    </div>

    <div class="col-md-3">

    <?=$form->field($model, 'users_list')->checkbox()?>

    <?=$form->field($model, 'users_create')->checkbox()?>

    <?=$form->field($model, 'users_edit')->checkbox()?>

    <?=$form->field($model, 'users_delete')->checkbox()?>
    </div>

    <div class="col-md-3">

    <?=$form->field($model, 'request_list')->checkbox()?>

    <?=$form->field($model, 'request_create')->checkbox()?>

    <?=$form->field($model, 'request_edit')->checkbox()?>

    <?=$form->field($model, 'request_delete')->checkbox()?>
    </div>

    <div class="col-md-3">

    <?=$form->field($model, 'permission_list')->checkbox()?>

    <?=$form->field($model, 'permission_create')->checkbox()?>

    <?=$form->field($model, 'permission_edit')->checkbox()?>

    <?=$form->field($model, 'permission_delete')->checkbox()?>

    </div>
    <div class="col-md-3">

<?=$form->field($model, 'assign_permission_list')->checkbox()?>

<?=$form->field($model, 'assign_permission_create')->checkbox()?>

<?=$form->field($model, 'assign_permission_edit')->checkbox()?>

<?=$form->field($model, 'assign_permission_delete')->checkbox()?>

</div>

    <div class="form-group" style="float: left;">
        <?=Html::submitButton('ذخیره', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
