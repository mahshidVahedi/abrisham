<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sellers-form " style="width:30%; margin: auto; margin-top: 5%;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'ACTIVE' => 'فعال', 'INACTIVE' => 'غیرفعال', ], ['prompt' => 'انتخاب کنید']) ?>

    <div class="form-group">
    <?= Html::submitButton('ذخیره', ['class' => 'btn btn-outline-success btn-lg']) ?>      
    <?=Html::a('بازگشت', ['index'], ['class' => 'btn btn-outline-secondary btn-lg'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
