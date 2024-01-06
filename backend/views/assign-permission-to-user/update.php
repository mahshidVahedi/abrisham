<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var backend\models\AssignPermissionToUser $model */

$this->title = 'Update Assign Permission To User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'انتساب سطح دسترسی به کاربر', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assign-permission-to-user-update">

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
