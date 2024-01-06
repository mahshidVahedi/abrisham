<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


/** @var yii\web\View $this */
/** @var backend\models\Permission $model */

$this->title = 'ایجاد سطح دسترسی ';
$this->params['breadcrumbs'][] = ['label' => 'سطوح دسترسی', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

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

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
