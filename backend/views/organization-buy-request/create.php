<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequest $model */

$this->title = 'Create Organization Buy Request';
$this->params['breadcrumbs'][] = ['label' => 'Organization Buy Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-buy-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
