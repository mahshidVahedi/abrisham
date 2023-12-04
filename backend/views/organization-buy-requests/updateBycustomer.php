<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = 'Update Organization Buy Requests: ' . $model->unique_key;
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unique_key, 'url' => ['view', 'id' => $model->unique_key]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-buy-requests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_updateByCustomerForm', [
        'model' => $model,
    ]) ?>

</div>
