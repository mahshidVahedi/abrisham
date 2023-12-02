<?php

use backend\models\CommentToHomePage;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Comment To Home Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-to-home-page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comment To Home Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'organization_id',
            'comment.comment',
            'created_date',
            'created_user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CommentToHomePage $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
