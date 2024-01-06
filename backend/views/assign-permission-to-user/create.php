<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\AssignPermissionToUser $model */

$this->title = 'ایجاد انتساب جدید';
$this->params['breadcrumbs'][] = ['label' => 'انتساب سطح دسترسی', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assign-permission-to-user-create">

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
