<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
$form = ActiveForm::begin(['id' => 'passwordRegister-form']);
?>
<div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page h-100 mt-5" style="margin:auto; width:50%;">
			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> ثبت کلمه عبور </h3>
				</div>
				<?php $form = ActiveForm::begin();?>

			<?=$form->field($model, 'newPassword')->passwordInput(['required' => true])?>

			<?=$form->field($model, 'newPasswordRepeat')->passwordInput(['required' => true])?>

			<div class="form-group text-center" style="margin-top: 10px;" >
    		<?=Html::submitButton('ثبت رمز عبور ', ['class' => 'btn btn-pink  text-uppercase waves-effect waves-light '])?>
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>
