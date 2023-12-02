<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequest $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organization-buy-request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'manager_name',
            'manager_lname',
            'manager_ncode',
            'manager_phone',
            'manager_gender',
            'manager_email:email',
            'org_name',
            'org_address',
            'org_phone',
        ],
    ]) ?>

</div>
