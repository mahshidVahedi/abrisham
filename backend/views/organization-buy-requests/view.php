<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = $model->organization_name;
$this->params['breadcrumbs'][] = ['label' => 'فرم های درخواست خرید', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organization-buy-requests-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => 'صفحه اصلی',
                'url' => 'index.php'
            ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    </p>

    <p>
    <?= Html::a('به روزرسانی توسط فروشنده', ['update', 'id' => $model->id], ['class' => 'btn btn-info waves-effect waves-light btn-lg']) ?>
    <?= Html::a('به روزرسانی توسط مشتری', ['organization-buy-requests/update-customer', 'unique_key' => $model->unique_key], ['class' => 'btn btn-info waves-effect waves-light btn-lg']) ?> 
    </p>
    <p>
    <?php 
    $url = \Yii::$app->urlManager->createAbsoluteUrl(['organization-buy-requests/update-customer', 'unique_key' => $model->unique_key]);
    echo Html::button('کپی لینک  <span class="gl  glyphicon-share "></span>', [
    'class' => 'btn btn-default waves-effect waves-light btn-lg',
    'onclick' => 'copyToClipboard("' . $url . '")'
    ]);?>
    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_sale_date',
            'manager_name',
            'manager_lastname',
            'manager_nationality_code',
            'manager_mobile',
            'manager_gender',
            'manager_email:email',
            'organization_name',
            'organization_address',
            'organization_phone',
            'school_type',
            'unique_key',
            'created_at',
            'seller_updated_date',
            'customer_updated_date',
            'seller_user_id',
            'status',
            'process_status',
            // 'pre_school_1',
            // 'pre_school_2',
            // 'first',
            // 'secound',
            // 'third',
            // 'fourth',
            // 'fifth',
            // 'sixth',
            // 'seventh',
            // 'eighth',
            // 'ninth',
            // 'tenth_math',
            // 'tenth_humanities',
            // 'tenth_empirical',
            // 'eleventh_math',
            // 'eleventh_humanities',
            // 'eleventh_empirical',
            // 'twelfth_math',
            // 'twelfth_humanities',
            'twelfth_empirical',
            'final_sale_date',
        ],
    ]) ?>
    

</div>
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