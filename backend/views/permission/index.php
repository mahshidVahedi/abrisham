<?php

use backend\models\Permission;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Permission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'sellers_list',
            'sellers_create',
            'sellers_edit',
            //'sellers_delete',
            //'users_list',
            //'users_create',
            //'users_edit',
            //'users_delete',
            //'request_list',
            //'request_create',
            //'request_edit',
            //'request_delete',
            //'permission_list',
            //'permission_create',
            //'permission_edit',
            //'permission_delete',
            //'assign_permission_create',
            //'assign_permisson_list',
            //'assign_permission_edit',
            //'assign_permission_delete',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Permission $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
