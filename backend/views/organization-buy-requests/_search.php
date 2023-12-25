<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequestsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-buy-requests-search d-flex justify-content-between flex-wrap ">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'row'], // Add the 'row' class to the form
    ]); ?>
    <h3>
        جستجو   
    </h3>
    <?= $form->field($model,'keyword') ?>
    <h3>
        جستجوی پیشرفته
    </h3>
    <div class="col-md-4"> 
        <?= $form->field($model, 'created_sale_date') ?>
        <?= $form->field($model, 'manager_name') ?>
        <?= $form->field($model, 'manager_lastname') ?>
        <?= $form->field($model, 'manager_nationality_code') ?>
        <?= $form->field($model, 'manager_gender')->dropDownList(['FEMALE' => 'خانم', 'MALE' => 'آقا'], ['prompt' => 'انتخاب کنید']) ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->field($model, 'unique_key') ?>
        <?php echo $form->field($model, 'seller_updated_date') ?>
        <?php echo $form->field($model, 'customer_updated_date') ?>
        <?php echo $form->field($model, 'manager_mobile') ?>
        <?php echo $form->field($model, 'organization_name') ?>
    </div>
    <div class="col-md-4"> 
        <?php echo $form->field($model, 'seller_user_id') ?>
        <?= $form->field($model, 'status')->dropDownList(['CREATED' => 'ایجاد شده', 'UPDATED_BY_SELLER' => 'به روز رسانی توسط فروشنده', 'UPDATED_BY_CUSTOMER' => 'به روز رسانی توسط مشتری', 'COMPLETED_BY_SELLER'=> 'کامل شده توسط فروشنده', 'ARCHIEVED' => 'آرشیو شده' ],['prompt' => 'انتخاب کنید']) ?>
        <?= $form->field($model, 'process_status')->dropDownList(['FINAL_REGISTER' => 'ثبت نهایی', 'FINAL_DEVELOP' => 'توسعه نهایی'], ['prompt' => 'انتخاب کنید']) ?>
        <?php echo $form->field($model, 'final_sale_date') ?>
    </div>

    <div class="form-group mt-4 mb-6">
        <?= Html::submitButton('جستجو', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('ریست', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
