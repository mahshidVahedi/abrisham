<?php

use backend\models\OrganizationBuyRequests;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequestsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'فرم های درخواست خرید';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-buy-requests-index" style="direction: rtl;">

    <h1><?=Html::encode($this->title)?></h1>

    <p>
        <?=Html::a('ایجاد فرم درخواست خرید', ['create'], ['class' => 'btn btn-success mt-4'])?>
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        'created_sale_date',
        // 'manager_name',
        // 'manager_lastname',
        // 'manager_nationality_code',
        // 'manager_mobile',
        // 'manager_gender',
        // 'manager_email:email',
        'organization_name',
        // 'organization_address',
        // 'organization_phone',
        // 'school_type',
        'unique_key',
        'seller_updated_date',
        'customer_updated_date',
        'seller_user_id',
        'status',
        'process_status',
        'final_sale_date',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, OrganizationBuyRequests $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
        ],
        [
            'format' => 'raw',
            'value' => function($model) {
                $url = \Yii::$app->urlManager->createAbsoluteUrl(['organization-buy-requests/update-customer', 'unique_key' => $model->unique_key]);
                return Html::button('Copy Link for customer', [
                    'class' => 'btn btn-primary',
                    'onclick' => 'copyToClipboard("' . $url . '")'
                ]);
            },
        ],
    ],
]); ?>


</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                alert('Link copied to clipboard: ' + text);
            })
            .catch((error) => {
                alert('Error copying link to clipboard. Please copy the link manually.');
            });
    }
</script>