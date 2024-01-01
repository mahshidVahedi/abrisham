<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = 'به روز رسانی اطلاعات توسط فروشنده';
$this->params['breadcrumbs'][] = ['label' => 'فرم های درخواست خرید', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'به روز رسانی اطلاعات توسط فروشنده';
?>
<div class="organization-buy-requests-update">

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

    <?= $this->render('_updateBySellerForm', [
        'model' => $model,
    ]) ?>

</div>
