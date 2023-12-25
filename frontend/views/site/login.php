<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var yii\web\View $this */
/* @var yii\bootstrap5\ActiveForm $form */
/* @var \common\models\LoginForm $model */

$form = ActiveForm::begin(['id' => 'login-form']);
?>
<div class="account-pages">
    <div class="clearfix">
    </div>
    <div class="wrapper-page">
        <div class="card-box">
            <div class="panel-heading">
                <h3 class="text-center">ورود  به حساب <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'نام کاربری']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'پسورد']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <?= $form->field($model, 'rememberMe')->checkbox(['placeholder' => 'مرا به خاطر بسپار']) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <?= Html::submitButton('ورود', ['class' => 'btn btn-pink btn-block text-uppercase waves-effect waves-light', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <?= Html::a('فراموشی رمز', ['site/request-password-reset']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <!-- <p>حساب کاربری ندارید؟ <a href="page-register.html" class="text-primary m-l-5">عضو شوید<b></b></a></p> -->
        </div>
    </div>
</div>
<?php
ActiveForm::end();
?>