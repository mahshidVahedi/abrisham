<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;


/** @var yii\web\View $this */
/** @var backend\models\Permission $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'سطوح دسترسی', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="permission-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'name',
            'sellers-list',
            'sellers-create',
            'sellers-edit',
            'sellers-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'request-list',
            'request-create',
            'request-edit',
            'request-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'assign-permission',
        ],
    ]) ?>

</div>
