<?php

namespace backend\controllers;

use backend\models\Users;
use backend\models\VerifyCode;
use yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class VerifyCodeController extends \yii\web\Controller

{
    public function actionIndex()
    {
        return $this->render('index');
    }
    protected function findModel($id)
    {
        if (($model = VerifyCode::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPasswordRecovery()
    {
        $model = new VerifyCode();
        $this->layout = 'page';
        $str = '0123456789';
        if ($this->request->isPost) {
            $model->otp = substr(str_shuffle($str), 0, 6);
            $model->username = Yii::$app->request->post()['VerifyCode']['username'];
            $user = $model->getUserByUsername();
            $model->user_id = $user->id;
            if ($model->load($this->request->post()) && $model->save()) {
                if ($user !== null) {
                    return $this->redirect(['otp-check', 'id' => $model->id]);
                } else {
                    $model->addError('username', 'شماره همراه اشتباه است');
                }
            }
        }
        return $this->render('passwordRecovery', [
            'model' => $model,
        ]);
    }
    public function actionOtpCheck($id)
    {
        $model = $this->findModel($id);
        $this->layout = 'page';
        if ($this->request->isPost) {
            $sentCode = Yii::$app->request->post()['VerifyCode']['code'];
            if ($model->load($this->request->post()) && $model->save()) {
                // print_r($sentCode);
                // die();
                if ($sentCode == $model->otp) {
                    return $this->redirect(['password-register', 'id' => $model->id]);
                } else {
                    $model->addError('code', 'Incorrect OTP');
                    Yii::$app->session->setFlash('error', 'Incorrect OTP');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validation failed');
            }}
        return $this->render('otpCheck', [
            'model' => $model,
        ]);}

    public function actionPasswordRegister($id)
    {
        $this->layout = 'page';
        $model = $this->findModel($id);
        $user = $model->getUserById();
 
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $pass = Yii::$app->request->post()['VerifyCode']['newPassword'];;
            $newPass = Yii::$app->request->post()['VerifyCode']['newPasswordRepeat'];
            if ($pass == $newPass) {
                $user->setPassword($pass);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Password changed successfully.');
                    return $this->redirect(['delete', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error changing password.');
                }
            } else {
                $model->addError('newPasswordRepeat', 'رمز مطابقت ندارد');
            }
        }
        return $this->render('passwordRegister', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Url::toRoute(['/site/login']));
    }

}
