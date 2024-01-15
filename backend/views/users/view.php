<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\Users $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'کاربران', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view" style="width:80%; margin: auto; margin-top:10px;">

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

    <p dir="ltr">
        <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('حذف', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>
    <div style="display:flex;">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'lname',
            'gender',
            // 'password',
            'email:email',
            // 'activkey',
            // 'create_at',
            // 'lastvisit_at',
            'superuser',
            'status',
            // 'fault_count',
            // 'fault_at',
            // 'unique_key',
        ],
    ]) ?>
</div>
</div>
