<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\SellersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sellers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'created_forms_counts') ?>

    <?= $form->field($model, 'seller_updated_forms_count') ?>

    <?php // echo $form->field($model, 'customer_updated_forms_count') ?>

    <?php // echo $form->field($model, 'completed_by_seller_forms_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
