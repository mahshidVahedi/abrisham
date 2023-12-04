<?php

use backend\models\OrganizationBuyRequests;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Organization Buy Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-buy-requests-index">

    <h1><?=Html::encode($this->title)?></h1>

    <p>
        <?=Html::a('Create Organization Buy Requests', ['create'], ['class' => 'btn btn-success'])?>
    </p>


    <?=GridView::widget([
    'dataProvider' => $dataProvider,
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
        'sale_date',
        'seller_user_id',
        'unique_key',
        'status',
        //'created_at',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, OrganizationBuyRequests $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
        ],
    ],
]);?>


</div>
