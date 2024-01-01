<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Sellers $model */

$this->title = 'ایجاد فروشنده';
$this->params['breadcrumbs'][] = ['label' => 'فروشندگان', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sellers-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <div>
        <?php
            $this->params['breadcrumbs'][] = ['label' => 'فروشندگان', 'url' => ['index']];
            $this->params['breadcrumbs'][] = $this->title;
        ?>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
