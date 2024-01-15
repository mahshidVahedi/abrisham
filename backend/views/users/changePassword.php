<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$form = ActiveForm::begin(['id' => 'changePassword-form']);
?>
<div class="account-pages w-100 h-100 "></div>
		<div class="clearfix"></div>
		<div class="wrapper-page h-100 mt-5" style="margin:auto;">
			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> تغییر کلمه عبور </h3>
				</div>
				<?php $form = ActiveForm::begin();?>

			<?=$form->field($model, 'currentPassword')->passwordInput(['required' => true])?>

			<?=$form->field($model, 'newPassword')->passwordInput(['required' => true])?>

			<?=$form->field($model, 'newPasswordRepeat')->passwordInput(['required' => true])?>

			<div class="form-group text-center" style="margin-top: 15px;" >
    		<?=Html::submitButton('تغییر رمز عبور ', ['class' => 'btn btn-pink  text-uppercase waves-effect waves-light btn-lg'])?>
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>
