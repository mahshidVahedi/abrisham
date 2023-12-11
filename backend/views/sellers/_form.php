<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sellers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_forms_counts')->textInput() ?>

    <?= $form->field($model, 'seller_updated_forms_count')->textInput() ?>

    <?= $form->field($model, 'customer_updated_forms_count')->textInput() ?>

    <?= $form->field($model, 'completed_by_seller_forms_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
