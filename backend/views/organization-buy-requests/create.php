<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/** @var yii\web\View $this */
/** @var backend\models\OrganizationBuyRequests $model */

$this->title = 'ایجاد فرم درخواست خرید';
$this->params['breadcrumbs'][] = ['label' => 'فرم های درخواست خرید', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-buy-requests-create">

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
    </p>

    <?= $this->render('_createBySellerForm.php', [
        'model' => $model,
    ]) ?>

</div>