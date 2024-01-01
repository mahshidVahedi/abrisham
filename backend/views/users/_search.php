<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\UsersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-search d-flex justify-content-between flex-wrap">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
    <h5 style="margin-right: 10px;">
        جستجوی پیشرفته
    </h5>
    <div class="md-col-8">

    <?=$form->field($model, 'username')?>

    <?=$form->field($model, 'name')?>
</div>
<div class="md-col-6">
  <?=$form->field($model, 'lname')?>

    <?=$form->field($model, 'gender')?>


 </div>
    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'activkey') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'lastvisit_at') ?>

    <?php // echo $form->field($model, 'superuser') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'fault_count') ?>

    <?php // echo $form->field($model, 'fault_at') ?>

    <?php // echo $form->field($model, 'unique_key') ?>

    <div class="form-group" dir="ltr">
        <?=Html::submitButton('جستجو', ['class' => 'btn btn-primary'])?>
        <?=Html::resetButton('ریست', ['class' => 'btn btn-inverse waves-effect waves-light'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
