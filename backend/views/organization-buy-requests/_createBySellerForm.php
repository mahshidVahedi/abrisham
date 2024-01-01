<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div style="width:30%; margin: auto; margin-top: 5%;">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'manager_mobile')->textInput()?>
    
    <?=$form->field($model, 'organization_name')->textInput(['maxlength' => true])?>

    <div class="form-group" dir="ltr">
    <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary waves-effect waves-light btn-lg']) ?>      
    </div>

    <?php ActiveForm::end(); ?>

</div>
