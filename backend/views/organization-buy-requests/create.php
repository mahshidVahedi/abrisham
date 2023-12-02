<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = 'Create Organization Buy Requests';
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-buy-requests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
