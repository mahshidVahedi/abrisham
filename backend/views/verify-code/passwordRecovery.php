<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$this->title = 'recovery';
?>
<div class="account-pages w-100 h-100"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page h-100 mt-5" style="margin:auto; width:50%;">
        <div class="card-box ">
            <div class="panel-heading">
                <h3 class="text-center"> بازیابی رمز عبور <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body ">
                <?php $form = ActiveForm::begin();?>
                <div class="form-group">
                    <div class="col-xs-12" style="display: inline-block;">
                    <?=$form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control', 'required' => true])?>
                    <div style="float:left;">
                    <?=Html::submitButton(' ارسال کد تایید ', ['class' => 'btn btn-pink  text-uppercase waves-effect waves-light btn-lg'])?>
                    </div>
                    </div>

                </div>
                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
