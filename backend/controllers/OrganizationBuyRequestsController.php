<?php

namespace backend\controllers;

use backend\models\OrganizationBuyRequests;
use yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrganizationBuyRequestsController implements the CRUD actions for OrganizationBuyRequests model.
 */
class OrganizationBuyRequestsController extends Controller
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
     * Lists all OrganizationBuyRequests models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrganizationBuyRequests::find(),
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
     * Displays a single OrganizationBuyRequests model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OrganizationBuyRequests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new OrganizationBuyRequests();
        $model->scenario = 'scenarioCreate';
        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        if ($this->request->isPost) {
            $model->sale_date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $model->unique_key = substr(str_shuffle($str), 0, 6);
            $model->seller_user_id = 1;
            if ($model->load($this->request->post()) && $model->save()) {
                $model->status = 'created by admin';
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors());
                die;
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OrganizationBuyRequests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario='scenarioCreate';
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('updateBySeller', [
            'model' => $model,
        ]);
    }

    public function actionUpdateCustomer($id)
    {
        $model = $this->findModel($id);
        $model->scenario='scenarioUpdate';
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('updateByCustomer', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrganizationBuyRequests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();
    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the OrganizationBuyRequests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OrganizationBuyRequests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrganizationBuyRequests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
