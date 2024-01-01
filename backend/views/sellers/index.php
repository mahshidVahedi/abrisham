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
<div class="sellers-index" style="width:80%; margin: auto; margin-top:10px;">

    <h2><?= Html::encode($this->title) ?></h2>
    <p style="float:left;">
        <?= Html::a('ایجاد فروشنده', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'user_id',
            'status',
            [
                'attribute' => 'تعداد فرم های ایجاد شده',
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
