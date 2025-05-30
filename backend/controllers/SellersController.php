<?php

namespace backend\controllers;

use backend\models\PermissionEnum;
use backend\models\Users;
use backend\models\Sellers;
use backend\models\SellersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;

/**
 * SellersController implements the CRUD actions for Sellers model.
 */
class SellersController extends Controller
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
     * Lists all Sellers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $sellers_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_LIST);
        if(!$sellers_list){
            $this->redirect(['site/Acsess-error']);
        }
        
        $searchModel = new SellersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sellers model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $sellers_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_LIST);
        if(!$sellers_list){
            $this->redirect(['site/Acsess-error']);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sellers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $sellers_create       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_CREATE);
        if(!$sellers_create){
            $this->redirect(['site/Acsess-error']);
        }
        $model = new Sellers();
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
     * Updates an existing Sellers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $sellers_edit       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_EDIT);
        if(!$sellers_edit){
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
     * Deletes an existing Sellers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $sellers_delete       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_DELETE);
        if(!$sellers_delete){
            $this->redirect(['site/Acsess-error']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sellers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Sellers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sellers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
