<?php

namespace backend\controllers;
use backend\models\Users;
use backend\models\VerifyCode;

class VerifyCodeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPasswordRecovery(){
        $users=new Users();
        // $model =  $model::findByUsername($username);
        $this->layout='page';
        $model=new VerifyCode();
        return $this->render('passwordRecovery', [
            'model' => $model,
        ]);
    }

}
