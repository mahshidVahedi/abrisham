<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organization-buy-requests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update by seller', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update by customer', ['organization-buy-requests/update-customer', 'unique_key' => $model->unique_key], ['class' => 'btn btn-primary']) ?>    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            // 'created_at',
            'sale_date',
            'seller_user_id',
            'status',
            'process_status'
        ],
    ]) ?>

</div>