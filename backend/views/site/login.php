<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$form = ActiveForm::begin(['id' => 'login-form']);
$this->title = 'login';
?>
<div class="account-pages w-100 h-100"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page w-50 h-50">
        <div class="card-box ">
            <div class="panel-heading">
                <h3 class="text-center"> ورود  به حساب کاربری <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body ">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <?= Html::submitButton('ورود', ['class' => 'btn btn-pink btn-block text-uppercase waves-effect waves-light', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end();?>
<?php
?>
