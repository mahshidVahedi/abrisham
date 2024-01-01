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
    <div style="margin-right: 10px;"> 
        <h5 >
            جستجو   
        </h5>
        <?php echo $form->field($model,'keyword') ?>
    </div>
    <h5 style="margin-right: 10px;">
        جستجوی پیشرفته
    </h5>
    <div class="col-md-4"> 
        <?= $form->field($model, 'created_sale_date') ?>
        <?= $form->field($model, 'manager_name') ?>
        <?= $form->field($model, 'manager_lastname') ?>
        <?= $form->field($model, 'manager_nationality_code') ?> 
    </div>
    <div class="col-md-4">
        <?php echo $form->field($model, 'unique_key') ?>
        <?php echo $form->field($model, 'seller_updated_date') ?>
        <?php echo $form->field($model, 'customer_updated_date') ?>
        <?php echo $form->field($model, 'organization_name') ?>
    </div>
    <div class="col-md-4"> 
        <?php echo $form->field($model, 'seller_user_id') ?>
        <?= $form->field($model, 'status')->dropDownList(['CREATED' => 'ایجاد شده', 'UPDATED_BY_SELLER' => 'به روز رسانی توسط فروشنده', 'UPDATED_BY_CUSTOMER' => 'به روز رسانی توسط مشتری', 'COMPLETED_BY_SELLER'=> 'کامل شده توسط فروشنده', 'ARCHIEVED' => 'آرشیو شده' ],['prompt' => 'انتخاب کنید']) ?>
        <?= $form->field($model, 'process_status')->dropDownList(['FINAL_REGISTER' => 'ثبت نهایی', 'FINAL_DEVELOP' => 'توسعه نهایی'], ['prompt' => 'انتخاب کنید']) ?>
        <?php echo $form->field($model, 'final_sale_date') ?>
    </div>

    <div class="form-group mt-8 mb-6" style="float: left; margin-top: 10px;">
        <?= Html::submitButton('جستجو', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('ریست', ['class' => 'btn btn-inverse waves-effect waves-light']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
