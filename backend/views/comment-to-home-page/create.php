<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\CommentToHomePage $model */

$this->title = 'Create Comment To Home Page';
$this->params['breadcrumbs'][] = ['label' => 'Comment To Home Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-to-home-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
