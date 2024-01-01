<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */

$this->title = 'ایجاد فروشنده';
$this->params['breadcrumbs'][] = ['label' => 'فروشندگان', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sellers-create">

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

    <div>
        <?php
            $this->params['breadcrumbs'][] = ['label' => 'فروشندگان', 'url' => ['index']];
            $this->params['breadcrumbs'][] = $this->title;
        ?>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
