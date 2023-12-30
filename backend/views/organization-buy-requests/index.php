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
<div class="organization-buy-requests-index" style="width:80%; margin: auto; margin-top:10px;">

    <h1><?=Html::encode($this->title)?></h1>

    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'created_sale_date',
        'organization_name',
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
                return Html::button('کپی لینک', [
                    'class' => 'btn btn-default waves-effect waves-lights',
                    'id' => 'sa-success',
                    'onclick' => 'copyToClipboard("' . $url . '")'
                ]);
            },
        ],
    ],
]); ?>
    <div style="float:left;">
        <?=Html::a('بازگشت', [''], ['class' => 'btn btn-outline-secondary mt-4 btn-lg'])?>
        <?=Html::a('ایجاد فرم درخواست خرید', ['create'], ['class' => 'btn btn-outline-success mt-4 btn-lg'])?>
    </div>

</div>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                swal("کپی شد", "قابل ارسال برای مشتری" ,"success");                
            })
            .catch((error) => {
                Swal({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",});
            });
    }
</script>