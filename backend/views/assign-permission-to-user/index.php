<?php

use backend\models\AssignPermissionToUser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'انتساب سطح دسترسی به کاربر';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assign-permission-to-user-index" style="width:80%; margin: auto; margin-top:10px;">

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

    <p dir="ltr">
        <?= Html::a('انتساب سطح دسترسی', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'permission_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}', // Only show the "view" button
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="gl glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('yii', 'View'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
