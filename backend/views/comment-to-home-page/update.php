<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\CommentToHomePage $model */

$this->title = 'Update Comment To Home Page: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comment To Home Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-to-home-page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
