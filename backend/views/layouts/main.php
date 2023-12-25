<?php
//$organizationInfo           =   Yii::$app->fcore->getOrganization(true);
$currentOrganizationId = 1; //$organizationInfo['organization_id'];
$themeOrganizationId = 1; //$organizationInfo['theme_organization_id'];
use backend\models\Users;
use yii\helpers\Html;
use yii\web\UrlManager;
$this->beginPage();
$urlPublic = 'test'; //yii::getAlias('@yii1Url');
$urlPublicNew = 'test'; //yii::getAlias('@yii2Url');
$urlPublicYii2 = 'test'; //Yii::getAlias('@yii2Url');
// $this->registerCss('.loader-logo {background-image: url("' . $urlPublicNew . '/frontend_theme/' . $themeOrganizationId . '/images/logo-favicon-180.png")}', [$this::POS_HEAD])
// ?>
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
        <?=Html::csrfMetaTags()?>
        <link rel="shortcut icon" href="<?php echo $urlPublicNew; ?>/frontend_theme/<?php echo $themeOrganizationId; ?>/images/logo-favicon.png">
        <!-- <link rel="icon" type="image/png" href="<?php //echo $urlPublicNew; ?>/frontend_theme/<?php //echo $themeOrganizationId; ?>/images/logo-favicon-192.png" sizes="192x192"> -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $urlPublicNew; ?>/frontend_theme/<?php echo $themeOrganizationId; ?>/images/logo-favicon-180.png">
        <title><?=$this->title?></title>
        <?=$this->head()?>
        <!-- Chrome, Firefox OS and Opera -->
        <meta name="theme-color" content="#36404a">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#36404a">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#36404a">

        <?php $this->beginContent('@app/views/layouts/header.php');?>

            <?php
if (!empty($_SESSION['isLoginByApp'])) {
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
        <?php $this->endContent();?>
    </head>
    <body>
        <?=$this->beginBody()?>
        <?php //$this->beginContent('@app/views/layouts/_float_messenger.php'); ?>
        <?php/// $this->endContent(); ?>
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
                            <img src="<?php echo $urlPublicNew; ?>/frontend_theme/<?php echo $themeOrganizationId; ?>/images/logo-main-admin.png" class="logo-main hidden-print"/>
                            <img src="<?php echo $urlPublicNew; ?>/frontend_theme/<?php echo $themeOrganizationId; ?>/images/logo-mini-admin.png" class="logo-favicon hidden-print"/>                        </a>

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
                            <div class="pull-right">
                                <button class="button-menu-mobile open-left waves-effect waves-light">
                                    <i class="md md-menu"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            <ul class="nav navbar-nav hidden-xs">
                                <li><a href="<?php echo 'index.php?r=sellers%2Findex'; ?>" class="waves-effect waves-light"> لیست فروشندگان</a></li>
                                <li><a href="<?php echo 'index.php?r=site%2Flogin'; ?>" class="waves-effect waves-light">  ورود</a></li>
                            </ul>

                            <form role="search" class="navbar-right app-search pull-right hidden-xs" id="search-form-theme" method="get" action = "<?php echo $urlPublic . '/Contents/admin'; ?>">
                                 <input type="text" placeholder="جستجو در محتوا" class="form-control" name="Contents[title]">
                                 <a href="javascript:document.getElementById('search-form-theme').submit();""><i class="fa fa-search"></i></a>
                            </form>


                            <ul class="nav navbar-nav navbar-left pull-left">
                                <?php //echo $this->render('//layouts/_events'); ?>

                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light" title="تمام صفحه"><i class="icon-size-fullscreen"></i></a>
                                </li>
                                <li class="top-menu-item-xs">
                                    <a href="/new/backend/web/users/dashboard" class="right-bar-toggle- waves-effect waves-light" title="میزکار من"><i class="fa fa-calendar-check-o"></i></a>
                                </li>
                                <li class="dropdown top-menu-item-xs">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true" title="
									<?php //= yii::$model["profile"]->name . $model["profile"]->lname ?>"><img src="<?php // yii::$app->fuser->getUserProfileImage(yii::$app->user->id ? yii::$app->user->id : 0); ?>" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">

                                        <li><a href=""><i class="gl gl-user m-l-10 text-custom"></i> صفحه من</a></li>
                                        <li><a href="<?=yii::$app->urlManager->createUrl('users/panelnew')?>"><i class="gl gl-settings m-l-10 text-custom"></i> تنظیمات شخصی</a></li>
                                        <li><a href="<?=yii::$app->urlManager->createUrl('users/personalfinancialnew')?>"><i class="gl gl-wallet m-l-10 text-custom"></i> کیف پول و پرداخت‌ها</a></li>
                                        <!--li><a href="<?//=yii::$app->urlManager->createUrl('users/personalfinancialnew')?>"><i class="gl gl-credit-card m-l-10 text-custom"></i> پرداخت اقساط</a></li-->
                                        <!--li><a href="<?php // echo '/users/events';?>"><i class="gl gl-bell m-l-10 text-custom"></i> رخدادها</a></li-->
                                        <!--li><a href="<?//=yii::$app->urlManager->createUrl('users/chat')?>"><i class="gl gl-comments m-l-10 text-custom"></i> پیام‌رسان</a></li-->
                                        <li class="divider"></li>
                                        <li><a href="<?php echo '/user/ChangePassword'; ?>"><i class="gl gl-keys m-l-10 text-custom"></i> تغییر گذرواژه</a></li>
										<!--li><a href="<?php echo '/Contents/admin?type=ticket'; ?>"><i class="gl gl-headset m-l-10 text-custom"></i> پشتیبانی</a></li-->
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
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu" style="position: fixed !important; height: 100%; padding-bottom: 60px;">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <?php $this->beginContent('@app/views/layouts/nav_nadia.php');?>
                    <?php $this->endContent();?>
                    <!--<div id="sidebar-menu">
                        <ul>

                            <li class="text-muted menu-title">اصلی</li>

                            <li class="has_sub">
                                <a href="index.html" class="waves-effect"><i class="ti-home"></i> <span> داشبورد </span> <span class="menu-arrow"></span></a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-paint-bucket"></i> <span> کیت UI  </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="ui-buttons.html">دکمه ها</a></li>
                                    <li><a href="ui-panels.html">پنل ها</a></li>
                                    <li><a href="ui-portlets.html">پورتلت</a></li>
                                    <li><a href="ui-checkbox-radio.html">چک باکس</a></li>
                                    <li><a href="ui-tabs.html">تب ها</a></li>
                                    <li><a href="ui-modals.html">مودال ها</a></li>
                                    <li><a href="ui-progressbars.html">پروگرس بار</a></li>
                                    <li><a href="ui-notification.html">اطلاعیه ها</a></li>
                                    <li><a href="ui-images.html">تصاویر</a></li>
                                    <li><a href="ui-bootstrap.html">رابط بوت استرپ</a></li>
                                    <li><a href="ui-typography.html">تایپوگرافی</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-light-bulb"></i><span class="label label-primary pull-right">5</span><span> اجزا </span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="{url route='field/index'}">رشته‌ها</a></li>
                                    <li><a href="{url route='registerstatus/index'}">وضعیت‌ها</a></li>
                                    <li><a href="{url route='workflow/index'}">روند کاری</a></li>
                                    <li><a href="{url route='module/index'}">بخش‌ها</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>-->
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <?=$content?>
                </div>

                <footer class="footer text-right ltr">
					© <a target="_blank" href="https://erpx.ir">AbriSham</a>&nbsp<?php //echo Yii::$app->fstring->translateDigits(date('Y')-620);?>
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
<!--            --><?php //echo $this->render('//layouts/_following_me');?>
            <!--<div class="side-bar right-bar nicescroll">
                <h4 class="text-center">چت</h4>
                <div class="contact-list nicescroll">
                    <ul class="list-group contacts-list">
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="" alt="">
                                </div>
                                <span class="name">چانجل</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="" alt="">
                                </div>
                                <span class="name">توماس</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="" alt="">
                                </div>
                                <span class="name">دیوید</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="" alt="">
                                </div>
                                <span class="name">کارتینا</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/users/avatar-5.jpg" alt="">
                                </div>
                                <span class="name">شادا</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/users/avatar-6.jpg" alt="">
                                </div>
                                <span class="name">ادیمنه</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/users/avatar-7.jpg" alt="">
                                </div>
                                <span class="name">اوکا</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/users/avatar-8.jpg" alt="">
                                </div>
                                <span class="name">دانا</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/users/avatar-9.jpg" alt="">
                                </div>
                                <span class="name">جان</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="{yii::$app->request->BaseUrl}/nadiya_assets/images/users/avatar-10.jpg" alt="">
                                </div>
                                <span class="name">سورتو</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                    </ul>
                </div>
            </div> -->
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->

        <?=$this->endBody()?>
    </body>
</html>

<?php $this->beginContent('@app/views/layouts/footer.php');?>
<?php $this->endContent();?>
<?php //$this->beginContent('@app/views/layouts/_ajax_login.php'); ?>
<?php //$this->endContent(); ?>
<?=$this->endPage()?>
