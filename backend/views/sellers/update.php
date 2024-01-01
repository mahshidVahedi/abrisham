<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */

$this->title = 'ویرایش فروشنده';
$this->params['breadcrumbs'][] = ['label' => 'فروشندگان', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="sellers-update">

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

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
