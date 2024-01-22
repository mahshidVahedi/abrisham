<?php

namespace backend\controllers;

use backend\models\PermissionEnum;
use backend\models\Users;
use backend\models\OrganizationBuyRequests;
use backend\models\OrganizationBuyRequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;
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
        $request_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_LIST);
        if(!$request_list){
            $this->redirect(['site/Acsess-error']);
        }
        $searchModel = new OrganizationBuyRequestsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        // $this->layout = 'page';

        return $this->render('index', [
            'searchModel' => $searchModel,
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
        $request_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_LIST);
        if(!$request_list){
            $this->redirect(['site/Acsess-error']);
        }
        // $this->layout = 'page';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $request_create      =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_CREATE);
        if(!$request_create){
            $this->redirect(['site/Acsess-error']);
        }
        $model = new OrganizationBuyRequests();

        $model->scenario = 'scenarioCreate';
        // $this->layout = 'page';

        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        if ($this->request->isPost) {

            $model->created_sale_date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');

            $model->unique_key = substr(str_shuffle($str), 0, 6);

            $model->seller_user_id = 1;

            if ($model->load($this->request->post()) && $model->save()) {
                $model->status = 'CREATED';
                
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
        $request_edit       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_EDIT);
        if(!$request_edit){
            $this->redirect(['site/Acsess-error']);
        }

        $model = $this->findModel($id);

        $model->scenario = 'scenarioCreate';

        if ($this->request->isPost) {
            $model->seller_updated_date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $model->status = 'UPDATED_BY_SELLER';
            if ($model->load($this->request->post())) {
                if($model->process_status=='FINAL_REGISTER'){
                    $model->final_sale_date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                    $model->status = 'COMPLETED_BY_SELLER';
                }
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('updateBySeller', [
            'model' => $model,
        ]);

    }

    public function actionUpdateCustomer($unique_key)
    {
        $request_edit       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_EDIT);
        if(!$request_edit){
            $this->redirect(['site/Acsess-error']);
        }
        $model = $this->findModelByUniqueKey($unique_key);

        $model->scenario = 'scenarioUpdate';

        if ($this->request->isPost) {
            $model->customer_updated_date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $model->status = 'UPDATED_BY_CUSTOMER';
            if ($model->load($this->request->post()) && $model->save()) {

                return $this->redirect(['view', 'id' => $model->id]);
            }
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
    public function actionDelete($id)
    {
        $request_delete      =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_DELETE);
        if(!$request_delete){
            $this->redirect(['site/Acsess-error']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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

    protected function findModelByUniqueKey($unique_key)
    {
        if (($model = OrganizationBuyRequests::findOne(['unique_key' => $unique_key])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');

    }
}
