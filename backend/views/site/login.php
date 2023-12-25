<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var yii\web\View $this */
/* @var yii\bootstrap5\ActiveForm $form */
/* @var \common\models\LoginForm $model */
$this->title = 'ورود';
$form = ActiveForm::begin(['id' => 'login-form']);
$this->registerCssFile('@web/nadiya_assets/css/bootstrap-rtl.min.css');
$this->registerCssFile('@web/nadiya_assets/css/core1.css');
$this->registerCssFile('@web/nadiya_assets/css/components.css');
$this->registerCssFile('@web/nadiya_assets/css/icons.css');
$this->registerCssFile('@web/nadiya_assets/css/pages.css');
$this->registerCssFile('@web/nadiya_assets/css/responsive.css');
$this->registerJsFile('@web/nadiya_assets/js/modernizr.min.js');
?>
<div class="account-pages"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page">
        <div class="card-box">
            <div class="panel-heading">
                <h3 class="text-center"> ورود  به حساب کاربری <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body">
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
$this->registerJsFile('@web/nadiya_assets/js/jquery.min.js');
$this->registerJsFile('@web/nadiya_assets/js/bootstrap-rtl.min.js');
$this->registerJsFile('@web/nadiya_assets/js/detect.js');
$this->registerJsFile('@web/nadiya_assets/js/fastclick.js');
$this->registerJsFile('@web/nadiya_assets/js/jquery.slimscroll.js');
$this->registerJsFile('@web/nadiya_assets/js/jquery.blockUI.js');
$this->registerJsFile('@web/nadiya_assets/js/waves.js');
$this->registerJsFile('@web/nadiya_assets/js/wow.min.js');
$this->registerJsFile('@web/nadiya_assets/js/jquery.nicescroll.js');
$this->registerJsFile('@web/nadiya_assets/js/jquery.scrollTo.min.js');
$this->registerJsFile('@web/nadiya_assets/js/jquery.core.js');
$this->registerJsFile('@web/nadiya_assets/js/jquery.app.js');
?>
