<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
/** @var yii\web\View $this */
/** @var backend\models\AssignPermissionToUser $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'انتساب سطح دسترسی به کاربر', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assign-permission-to-user-view" style="width:80%; margin: auto; margin-top:10px;">

    <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'صفحه اصلی',
        'url' => 'index.php',
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])?>
    </p>

    <p style="float:left;">
        <?=Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <!-- <?=Html::a('حذف', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
])?> -->
    </p>
    <div class="md-col-4">
        <?=DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'uid',
                'pid',
            ],
        ])?>
    </div>



</div>
