<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\CommentToHomePage $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comment-to-home-page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment_id')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'created_user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
