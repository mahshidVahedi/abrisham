<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$form = ActiveForm::begin(['id' => 'passwordRecovery-form']);
$this->title = 'recovery';
?>
<div class="account-pages w-100 h-100"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page h-100 mt-5" style="margin:auto; width:70%;">
        <div class="card-box ">
            <div class="panel-heading">
                <h3 class="text-center"> بازیابی رمز عبور <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body ">
                <?php $form = ActiveForm::begin(['id' => 'passwordRecovery-form']);?>
                <div class="form-group">
                    <div class="col-xs-12" style="display: inline-block;">
                    <?=$form->field($model, 'user_id')->textInput(['autofocus' => true, 'class' => 'form-control'])?>
                    <div style="float:left;">
                    <?=Html::a('ارسال کد تایید', [''], ['class' => 'btn btn-info waves-effect waves-light'])?>
                    </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                    <?=$form->field($model, 'otp')->textInput()?>
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <?=Html::submitButton('ورود و ثبت رمز جدید', ['class' => 'btn btn-pink btn-block text-uppercase waves-effect waves-light mt-10', 'name' => 'login-button'])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end();?>
<?php
?>