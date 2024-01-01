<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\SellersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="d-flex justify-content-between flex-wrap">

<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'row'], // Add the 'row' class to the form
    ]); ?>
    <h5 style="margin-right: 10px;">
        جستجوی پیشرفته
    </h5>

    <div class="col-md-6">
        <?= $form->field($model, 'user_id') ?>

        <?= $form->field($model, 'status')->dropDownList([ 'ACTIVE' => 'فعال', 'INACTIVE' => 'غیرفعال', ], ['prompt' => 'انتخاب کنید']) ?>

        <?= $form->field($model, 'created_forms_count') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'seller_updated_forms_count') ?>

        <?php  echo $form->field($model, 'customer_updated_forms_count') ?>

        <?php  echo $form->field($model, 'completed_by_seller_forms_count') ?>
    </div>

    <div class="form-group mt-8 mb-6" style="float: left; margin-top: 10px;">
        <?= Html::submitButton('جستجو', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('ریست', ['class' => 'btn btn-inverse waves-effect waves-light']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
