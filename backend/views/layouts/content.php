<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>" class="h-100">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags()?>
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/core1.css" rel="stylesheet" type="text/css" />
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
    <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/modernizr.min.js"></script>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody()?>

<main role="main">
    <div class="container">
        <?=$content?>
    </div>
</main>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.min.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/bootstrap-rtl.min.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/detect.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/fastclick.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.slimscroll.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.blockUI.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/waves.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/wow.min.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.nicescroll.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.core.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/jquery.app.js"></script>
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage();
