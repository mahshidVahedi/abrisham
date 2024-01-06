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
<div class="permission-view" style="width:80%; margin: auto; margin-top:10px;">

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
        <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'حذف شود؟',
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
            'assign_permission',
        ],
    ]) ?>

</div>
