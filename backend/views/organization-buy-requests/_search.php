<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequestsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-requests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'manager_name') ?>

    <?= $form->field($model, 'manager_lastname') ?>

    <?= $form->field($model, 'manager_nationality_code') ?>

    <?php  echo $form->field($model, 'manager_mobile') ?>

    <?php echo $form->field($model, 'manager_gender') ?>

    <?php  echo $form->field($model, 'manager_email') ?>

    <?php  echo $form->field($model, 'organization_name') ?>

    <?php  echo $form->field($model, 'organixation_address') ?>

    <?php  echo $form->field($model, 'organization_phone') ?>

    <?php  echo $form->field($model, 'unique_key') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php  echo $form->field($model, 'sale_date') ?>

    <?php  echo $form->field($model, 'seller_user_id') ?>

    <?php  echo $form->field($model, 'status') ?>

    <?php  echo $form->field($model, 'process_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
