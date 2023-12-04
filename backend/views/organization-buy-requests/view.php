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
        <?= Html::a('Update by customer', ['updateCustomer', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!--
             <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> 
        -->
    </p>

    <?= DetailView::widget([
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
            'created_at',
            'sale_date',
            'seller_user_id',
            'status',
        ],
    ]) ?>

</div>
