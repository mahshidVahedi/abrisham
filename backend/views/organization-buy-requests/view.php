<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Widget;
use eddmash\yii2clipboard\Clipboard;
/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$url = \Yii::$app->urlManager->createAbsoluteUrl(['organization-buy-requests/update-customer', 'unique_key' => $model->unique_key]);
echo Html::button('Copy Link', [
    'class' => 'btn btn-primary',
    'onclick' => 'copyToClipboard("' . $url . '")'
]);
?>
<div class="organization-buy-requests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a('Update by seller', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Update by customer', ['organization-buy-requests/update-customer', 'unique_key' => $model->unique_key], ['class' => 'btn btn-primary']) ?> 
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_sale_date',
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
            'seller_update_date',
            'customer_update_date',
            'seller_user_id',
            'status',
            'process_status',
            'pre_school_1',
            'pre_school_2',
            'first',
            'secound',
            'third',
            'fourth',
            'fifth',
            'sixth',
            'seventh',
            'eighth',
            'ninth',
            'tenth_math',
            'tenth_humanities',
            'tenth_empirical',
            'eleventh_math',
            'eleventh_humanities',
            'eleventh_empirical',
            'twelfth_math',
            'twelfth_humanities',
            'twelfth_empirical',
            'final_sale_date',
        ],
    ]) ?>

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