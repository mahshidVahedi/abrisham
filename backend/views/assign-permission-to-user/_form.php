<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AssignPermissionToUser $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="assign-permission-to-user-form"  style="width:30%; margin: auto; margin-top: 5%;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'pid')->textInput() ?>

    <div class="form-group" dir="ltr">
    <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary waves-effect waves-light btn-lg']) ?>      
    </div>

    <?php ActiveForm::end(); ?>

</div>
