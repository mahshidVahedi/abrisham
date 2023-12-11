<?php

use backend\models\Sellers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\SellersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'فروشندگان';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sellers-index" style="direction: rtl;">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ایجاد فروشنده', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'status',
            [
                'lable' => 'تعداد فرم های ایجاد شده',
                'value' => function ($model) {
                    return $model->createdFormsCount;
                }
            ],
            [
                'attribute' => 'تعداد فرم های به روز شده توسط فروشنده',
                'value'=> function ($model) {
                    return $model -> sellerUpdatedFormsCount;
                }
            ],
            [
                'attribute'=> 'تعداد فرم های به روز شده توسط مشتری',
                'value'=> function ($model) {
                    return $model -> customerUpdatedFormsCount;
                }
            ],
            [
                'attribute' => 'تعداد فرم های کامل شده توسط فروشنده',
                'value'=> function ($model) {
                    return $model -> sellerCompletedFormsCount;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Sellers $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
