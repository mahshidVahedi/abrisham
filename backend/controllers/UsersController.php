<?php

namespace backend\controllers;

use backend\models\PermissionEnum;
use backend\models\Users;
use backend\models\UsersSearch;
use yii;
use yii\base\Security;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $users_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_LIST);
        if(!$users_list){
            $this->redirect(['site/Acsess-error']);
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $users_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_LIST);
        if(!$users_list){
            $this->redirect(['site/Acsess-error']);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $users_create      =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_CREATE);
        if(!$users_create){
            $this->redirect(['site/Acsess-error']);
        }
        $model = new Users();
        if ($model->load(Yii::$app->request->post())) {
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $users_edit       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_EDIT);
        if(!$users_edit){
            $this->redirect(['site/Acsess-error']);
        }
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $users_delete       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_DELETE);
        if(!$users_delete){
            $this->redirect(['site/Acsess-error']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);
        $this->layout = 'page';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->validatePassword($model->currentPassword)) {
                if ($model->newPassword == $model->newPasswordRepeat) {
                    $model->setPassword($model->newPassword);
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Password changed successfully.');
                        $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', 'Error changing password.');
                    }
                } else {
                    $model->addError('newPasswordRepeat', 'رمز مطابقت ندارد');
                }
            }
            else{
                $model->addError('currentPassword', 'رمز اشتباه است');
            }
        }
        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }
}
