<?php

use backend\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index" style="width:80%; margin: auto; margin-top:10px;">


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
        <?= Html::a('ایجاد کاربر', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'name',
            'lname',
            'gender',
            //'password',
            //'email:email',
            //'activkey',
            //'create_at',
            //'lastvisit_at',
            //'superuser',
            //'status',
            //'fault_count',
            //'fault_at',
            //'unique_key',
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
        ],
    ); ?>


</div>
