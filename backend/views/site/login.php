<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$form = ActiveForm::begin(['id' => 'login-form']);
$this->title = 'login';
?>
<div class="account-pages w-100 h-100"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page h-100 mt-5" style="margin:auto; width:50%;">
        <div class="card-box ">
            <div class="panel-heading">
                <h3 class="text-center"> ورود  به حساب کاربری <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body ">
                <?php $form = ActiveForm::begin(['id' => 'login-form']);?>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?=$form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control'])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])?>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <?=$form->field($model, 'rememberMe')->checkbox()?>
                        </div>
                    </div>
                </div> -->
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12 mb-10" style="margin-bottom: 10px;">
                    <?= Html::a('فراموشی رمز', ['verify-code/password-recovery'], ['class' => 'btn btn-inverse waves-effect waves-light', 'name' => 'forget-button'])?>
                    </div>
                    <div class="col-xs-12">
                        <?=Html::submitButton('ورود', ['class' => 'btn btn-pink btn-block text-uppercase waves-effect waves-light mt-10', 'name' => 'login-button'])?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end();?>
<?php
?>
