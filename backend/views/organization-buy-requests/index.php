<?php

use backend\models\OrganizationBuyRequests;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequestsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Organization Buy Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-buy-requests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Organization Buy Requests', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'manager_name',
            'manager_lastname',
            'manager_nationality_code',
            'manager_mobile',
            'manager_gender',
            'manager_email:email',
            'organization_name',
            'organixation_address',
            'organization_phone',
            'unique_key',
            //'created_at',
            'sale_date',
            'seller_user_id',
            'status',
            'process_status',
            //'pre_school_1',
            //'pre_school_2',
            //'first',
            //'secound',
            //'third',
            //'fourth',
            //'fifth',
            //'sixth',
            //'seventh',
            //'eighth',
            //'ninth',
            //'tenth_math',
            //'tenth_humanities',
            //'tenth_empirical',
            //'eleventh_math',
            //'eleventh_humanities',
            //'eleventh_empirical',
            //'twelfth_math',
            //'twelfth_humanities',
            //'twelfth_empirical',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, OrganizationBuyRequests $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
