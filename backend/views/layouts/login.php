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
    <link rel="stylesheet" type="text/css" href="../../web/nadiya_assets/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="../../web/nadiya_assets/css/core1.css">
    <link rel="stylesheet" type="text/css" href="../../web/nadiya_assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../web/nadiya_assets/css/icons.css">
    <link rel="stylesheet" type="text/css" href="../../web/nadiya_assets/css/pages.css">
    <link rel="stylesheet" type="text/css" href="../../web/nadiya_assets/css/responsive.css">
    <script src="../../web/nadiya_assets/js/modernizr.js"></script>
    <?php $this->registerCsrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody()?>

<main role="main">
    <div class="container-xxl">
        <?=$content?>
    </div>
</main>
        <script src="../../web/nadiya_assets/js/jquery.min.js"></script>
        <script src="../../web/nadiya_assets/js/bootstrap-rtl.min.js"></script>
        <script src="../../web/nadiya_assets/js/detect.js"></script>
        <script src="../../web/nadiya_assets/js/fastclick.js"></script>
        <script src="../../web/nadiya_assets/js/jquery.slimscroll.js"></script>
        <script src="../../web/nadiya_assets/js/jquery.blockUI.js"></script>
        <script src="../../web/nadiya_assets/js/waves.js"></script>
        <script src="../../web/nadiya_assets/js/wow.min.js"></script>
        <script src="../../web/nadiya_assets/js/jquery.nicescroll.js"></script>
        <script src="../../web/nadiya_assets/js/jquery.scrollTo.min.js"></script>
        <script src="../../web/nadiya_assets/js/jquery.core.js"></script>
        <script src="../../web/nadiya_assets/js/jquery.app.js"></script>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage();
