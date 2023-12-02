<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = 'Update Organization Buy Requests: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-buy-requests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
