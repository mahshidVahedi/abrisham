<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>" class="h-100 w-100">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/core1.css">
    <link rel="stylesheet" type="text/css" href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/icons.css">
    <link rel="stylesheet" type="text/css" href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/pages.css">
    <link rel="stylesheet" type="text/css" href="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/css/responsive.css">
    <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/js/modernizr.min.js"></script>
    <?php $this->registerCsrfMetaTags()?>
    <?php $this->head()?>
</head>
<body class="d-flex flex-column w-100 h-100 account-pages">
<?php $this->beginBody()?>

<main role="main">
    <div class="container-xxl">
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
        <script src="<?=yii::$app->request->BaseUrl;?>/nadiya_assets/pages/jquery.sweet-alert.init.js"></script>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage();
