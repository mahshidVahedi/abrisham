<?php
$organizationInfo           =   Yii::$app->fcore->getOrganization(true);
$currentOrganizationId      =  $organizationInfo['organization_id'];
$themeOrganizationId        =  $organizationInfo['theme_organization_id'];
use yii\web\UrlManager;
use yii\helpers\Html;
use backend\models\Profiles;
use backend\models\Users;
use backend\models\Comment;
$this->beginPage();
$urlPublic    =    yii::getAlias('@yii1Url');
$urlPublicNew    =    yii::getAlias('@yii2Url');
$urlPublicYii2    =    Yii::getAlias('@yii2Url');
$this->registerCss('.loader-logo {background-image: url("'.$urlPublicNew.'/frontend_theme/'.$themeOrganizationId.'/images/logo-favicon-180.png")}',[$this::POS_HEAD])
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="بخش مدیریت سامانه جامع مدارس">
    <meta name="author" content="ERPx.ir">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#36404a">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#36404a">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#36404a">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo $themeOrganizationId ;?>/images/logo-favicon.png">
    <link rel="icon" type="image/png" href="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo $themeOrganizationId ;?>/images/logo-favicon-192.png" sizes="192x192">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo $themeOrganizationId;?>/images/logo-favicon-180.png">
    <title><?= $this->title ?></title>
    <?= $this->head() ?>
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#36404a">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#36404a">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#36404a">

    <?php $this->beginContent('@app/views/layouts/header.php'); ?>

    <?php
    if(!empty($_SESSION['isLoginByApp'])){
        echo $this->registerCss(<<<CSS

#float-messenger,.topbar,.side-menu,.page-title{
    display: none;
}

.content-page > .content{
    margin-top: 0 !important;
}
CSS
            ,[$this::POS_HEAD]);

    }
    ?>

    <?php $this->endContent(); ?>
</head>
<body>
<?= $this->beginBody()?>

<div id="wrapper">
    <div class="loader-box" id="ajaxImg" style="display: none">
        <div class="loader"></div>
        <div class="loader-logo"></div>
    </div>
    <div class="loader-box" id="waiting-img" style="display: none">
        <div class="loader"></div>
        <div class="loader-logo"></div>
    </div>
    <div class="loader-box" id="waiting-list" style="display: none">
        <div class="loader"></div>
        <div class="loader-logo"></div>
    </div>
    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-right">
            <div class="text-center">
                <a href="/">
                    <img src="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo $themeOrganizationId ;?>/images/logo-main-admin.png" class="logo-main hidden-print"/>
                    <img src="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo $themeOrganizationId ;?>/images/logo-mini-admin.png" class="logo-favicon hidden-print"/>                        </a>

                <!-- Image Logo here -->
                <!--<a href="index.html" class="logo">-->
                <!--<i class="icon-c-logo"> <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/logo_sm.png" height="42"/> </i>-->
                <!--<span><img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/logo_light.png" height="20"/></span>-->
                <!--</a>-->
            </div>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="">
<!--                    <div class="pull-right">-->
<!--                        <button class="button-menu-mobile open-left waves-effect waves-light">-->
<!--                            <i class="md md-menu"></i>-->
<!--                        </button>-->
<!--                        <span class="clearfix"></span>-->
<!--                    </div>-->



                    <ul class="nav navbar-nav navbar-left pull-left">
                        <?php
                        //echo $this->render('//layouts/_events');
                        ?>

                        <li class="hidden-xs">
                            <a href="#" id="btn-fullscreen" class="waves-effect waves-light" title="تمام صفحه"><i class="icon-size-fullscreen"></i></a>
                        </li>
<!--                        <li class="top-menu-item-xs">-->
<!--                            <a href="/new/backend/web/users/dashboard" class="right-bar-toggle- waves-effect waves-light" title="میزکار من"><i class="fa fa-calendar-check-o"></i></a>-->
<!--                        </li>-->
                        <li class="dropdown top-menu-item-xs">
                            <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true" title="
									<?//= yii::$model["profile"]->name . $model["profile"]->lname ?>"><img src="<?= yii::$app->fuser->getUserProfileImage(yii::$app->user->id ? yii::$app->user->id : 0); ?>" alt="user-img" class="img-circle"> </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo '/user/ChangePassword';?>"><i class="gl gl-keys m-l-10 text-custom"></i> تغییر گذرواژه</a></li>
                                <li class="divider"></li>
                                <li><a href="<?=yii::$app->urlManager->createUrl('site/logout')?>"><i class="gl gl-power m-l-10 text-danger"></i> خروج</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page" style="margin-right: 0">
        <!-- Start content -->
        <div class="content">
            <?= $content ?>
        </div>

        <footer class="footer text-right ltr">
            © <a target="_blank" href="https://erpx.ir">AbriSham</a>&nbsp<?php echo Yii::$app->fstring->translateDigits(date('Y')-620);?>
        </footer>

    </div>



</div>
<!-- END wrapper -->

<?= $this->endBody() ?>
</body>
</html>

<?php $this->beginContent('@app/views/layouts/footer.php'); ?>
<?php $this->endContent(); ?>
<?php //$this->beginContent('@app/views/layouts/_ajax_login.php'); ?>
<?php //$this->endContent(); ?>
<?= $this->endPage() ?>
