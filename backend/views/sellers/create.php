<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */

$this->title = 'Create Sellers';
$this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sellers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
