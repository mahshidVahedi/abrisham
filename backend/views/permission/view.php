<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Permission $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="permission-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'sellers_list',
            'sellers_create',
            'sellers_edit',
            'sellers_delete',
            'users_list',
            'users_create',
            'users_edit',
            'users_delete',
            'request_list',
            'request_create',
            'request_edit',
            'request_delete',
            'permission_list',
            'permission_create',
            'permission_edit',
            'permission_delete',
            'assign_permission_create',
            'assign_permission_list',
            'assign_permission_edit',
            'assign_permission_delete',
        ],
    ]) ?>

</div>
