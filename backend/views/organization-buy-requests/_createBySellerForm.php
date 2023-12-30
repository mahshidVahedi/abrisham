<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="account-pages w-100 h-100"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page w-50 h-50">
        <div class="card-box ">
            <div class="panel-heading">
                <h3 class="text-center">ایجاد فرم درخواست خرید سامانه <strong class="text-custom">ابریشم</strong> </h3>
            </div>
            <div class="panel-body ">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="form-group">
                    <div class="col-xs-12">
                    <?= $form->field($model, 'manager_mobile')->textInput() ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                    <?= Html::submitButton('ذخیره', ['class' => 'btn btn-outline-success btn-lg']) ?>      
                    <?=Html::a('بازگشت', ['index'], ['class' => 'btn btn-outline-secondary btn-lg'])?>
                    <a href="index.php"><button class="btn btn-outline-dark btn-lg">صفحه اصلی</button></a>
                </div>
            </div>
        </div>
            </div>
    </div>
    </div>
    <!-- btn btn-pink btn-block text-uppercase waves-effect waves-light -->
<?php ActiveForm::end(); ?>