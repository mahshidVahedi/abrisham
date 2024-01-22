<?php

namespace backend\controllers;

use backend\models\PermissionEnum;
use backend\models\Users;
use backend\models\AssignPermissionToUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;

/**
 * AssignPermissionToUserController implements the CRUD actions for AssignPermissionToUser model.
 */
class AssignPermissionToUserController extends Controller
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
     * Lists all AssignPermissionToUser models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $assign_permission_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_LIST);
        if(!$assign_permission_list){
            $this->redirect(['site/Acsess-error']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => AssignPermissionToUser::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssignPermissionToUser model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $assign_permission_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_LIST);
        if(!$assign_permission_list){
            $this->redirect(['site/Acsess-error']);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AssignPermissionToUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $assign_permission_create       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_CREATE);
        if(!$assign_permission_create){
            $this->redirect(['site/Acsess-error']);
        }
        $model = new AssignPermissionToUser();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AssignPermissionToUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $assign_permission_edit       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_EDIT);
        if(!$assign_permission_edit){
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
     * Deletes an existing AssignPermissionToUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $assign_permission_delete       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_DELETE);
        if(!$assign_permission_delete){
            $this->redirect(['site/Acsess-error']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AssignPermissionToUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return AssignPermissionToUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssignPermissionToUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
