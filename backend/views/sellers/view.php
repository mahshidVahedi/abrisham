<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'فروشندگان', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sellers-view" style="width:80%; margin: auto; margin-top:10px;">

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

    <p style="float:left;">
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'status',
            'created_forms_count',
            'seller_updated_forms_count',
            'customer_updated_forms_count',
            'completed_by_seller_forms_count',
        ],
    ]) ?>

</div>
