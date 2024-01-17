<?php

namespace backend\controllers;

use backend\models\Users;
use backend\models\VerifyCode;
use yii;
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
            if ($model->load($this->request->post()) && $model->save()) {
                $model->username    =   Yii::$app->request->post()['VerifyCode']['username'];
                $user = $model->getUserByUsername();
                if ($user !== null) {
                    $model->user_id = $user->id;
                    $model->otp = substr(str_shuffle($str), 0, 6);
                    print_r($model->user_id);
                    print_r($model->id);
                    die();
                    return $this->render('otpCheck', ['id' => $model->id]);
                } else {
                    $model->addError('username', 'شماره همراه اشتباه است');
                }
            }
        }
        // if ($model->load($this->request->post()) && $model->validate()) {
        //    // $model->username    =   Yii::$app->request->post()['VerifyCode']['username'];
        //     print_r( $model->username );
        //     die;
        //     //print_r( Yii::$app->request->post());
        //     //die;

        // }
        return $this->render('passwordRecovery', [
            'model' => $model,
        ]);
    }
    public function actionOtpCheck($id)
    {
        $this->layout = 'page';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->code == $model->otp) {
                return $this->render('passwordRegister', ['id' => $model->id]);
            } else {
                $model->addError('code', 'Incorrect OTP');
                Yii::$app->session->setFlash('error', 'Incorrect OTP');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Validation failed');
        }
        return $this->render('otpCheck', ['id' => $model->id]);
    }

    public function actionPasswordRegister($id)
    {
        $this->layout = 'page';
        $model = $this->findModel($id);
        $user = Users::findByUsername($model->username);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->newPassword == $model->newPasswordRepeat) {
                $user->setPassword($model->newPassword);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Password changed successfully.');
                    $this->$model->delete();
                    $this->goHome();
                } else {
                    Yii::$app->session->setFlash('error', 'Error changing password.');
                }
            } else {
                $model->addError('newPasswordRepeat', 'رمز مطابقت ندارد');
            }
        }
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

    }

}
