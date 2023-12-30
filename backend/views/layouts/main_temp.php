<?php
use yii\web\UrlManager;
use yii\helpers\Html;
use backend\models\Profiles;
use backend\models\Users;
$this->beginPage();
$urlPublic    =    yii::getAlias('@yii1Url');
$urlPublicNew    =    yii::getAlias('@yii2Url');
$urlPublicYii2    =    Yii::getAlias('@yii2Url');
?>
<!DOCTYPE html>
<html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?= Yii::$app->request->BaseUrl?>/nadiya_assets/images/favicon_1.ico">
        <title><?= $this->title ?></title>
        <?= $this->head() ?>
        <?php $this->beginContent('@app/views/layouts/header_temp.php'); ?>
        <?php $this->endContent(); ?>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="<?= yii::getAlias('@web') ?>/nadiya_assets/js/vis-network.min.js"></script>
    </head>
    <body>
        <?= $this->beginBody()?>
        <div id="wrapper">
             <div style="display:none;position: fixed; top:0; right:0; width:100%; height:100%; background-color:rgba(0,0,0,.5); text-align:center; z-index:2000;" id="ajaxImg">
                <img  src="<?= Yii::$app->request->BaseUrl?>/nadiya_assets/images/loader.gif" style='text-align: center; margin: 250px auto;' alt="لطفا کمی صبر کنید!">
            </div>
             <div style="display:none;position: fixed; top:0; right:0; width:100%; height:100%; background-color:rgba(0,0,0,.5); text-align:center; z-index:2000;" id="waiting-list">
                <img src="<?= Yii::$app->request->BaseUrl?>/nadiya_assets/images/loader.gif" style='text-align: center; margin: 250px auto;' alt="please wait!">
            </div> 
            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-right">
                    <div class="text-center">
                        <a href="javascript:viod(0);">
                            <img src="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo Yii::$app->fcore->getOrganization();?>/images/logo-main.png" class="logo-main hidden-print"/>
                            <img src="<?php echo $urlPublicNew;?>/frontend_theme/<?php echo Yii::$app->fcore->getOrganization();?>/images/logo-favicon.png" class="logo-favicon hidden-print"/>                        </a>
                
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
                                <li><a href="<?php echo '/Contents/admin?type=weblog';?>" class="waves-effect waves-light">وبلاگ های من</a></li>
                                <?php if(Users::isPersonal()){ ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false">امور پرسنلی<span
                                            class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo '/personal/personalMonthlyReport';?>">ورود و خروج</a></li>
                                        <li><a href="<?php echo '/personal/personalManageRequests'; ?>">درخواست‌ها</a></li>
                                        <li><a href="<?php echo '/personal/ShowContract';?>">نمایش قرارداد</a></li>
                                        <li><a href="<?php echo '/personal/personalFoodReservation';?>">رزرو غذا</a></li>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>

                            
                            <!-- <form role="search" class="navbar-right app-search pull-right hidden-xs" id="search-form-theme" method="get" action = "<?php //echo $urlPublic.'/Contents/admin';?>">
                                 <input type="text" placeholder="جستجو در محتوا" class="form-control" name="Contents[title]">
                                 <a href="javascript:document.getElementById('search-form-theme').submit();""><i class="fa fa-search"></i></a>
                            </form> -->
                        

                            <ul class="nav navbar-nav navbar-left pull-left">
                                <?php
                                    echo $this->render('//layouts/_events');
                                ?>

                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="icon-settings"></i></a>
                                </li>
                                <li class="dropdown top-menu-item-xs">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="<?= yii::$app->fuser->getUserProfileImage(yii::$app->user->id); ?>" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                    
                                        <li><a style="color:red" href="<?php echo '/'.Users::findOne(Yii::$app->user->id)->unique_key;?>"><i class="ti-user m-r-10 text-custom"></i> صفحه شخصی من</a></li>
                                        <li><a href="<?=yii::$app->urlManager->createUrl('users/panelnew')?>"><i class="ti-user m-r-10 text-custom"></i> تغییر مشخصات</a></li>
                                        <li><a href="<?=yii::$app->urlManager->createUrl('users/personalfinancialnew')?>"><i class="gl gl-credit-card m-r-10 text-custom"></i> کیف پول</a></li>
                                        <li><a href="<?=yii::$app->urlManager->createUrl('users/personalfinancialnew')?>"><i class="gl gl-credit-card m-r-10 text-custom"></i> پرداخت اقساط</a></li>
                                        <li><a href="<?php echo '/users/events';?>"><i class="ti-settings m-r-10 text-custom"></i> رخدادها</a></li>
                                        <li><a href="<?php echo '/users/socialnetwork';?>"><i class="ti-lock m-r-10 text-custom"></i> گفتگوها</a></li>
                                        <li><a href="<?php echo '/user/ChangePassword';?>"><i class="gl gl-keys m-r-10 text-custom"></i> تغییر گذرواژه</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?=yii::$app->urlManager->createUrl('site/logout')?>"><i class="ti-power-off m-r-10 text-danger"></i> خروج</a></li>
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

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <?php $this->beginContent('@app/views/layouts/nav_nadia.php'); ?>
                    <?php $this->endContent(); ?>
                    <!--<div id="sidebar-menu">
                       
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
                    <?= $content ?>
                </div>

                <footer class="footer text-right">
                    © 1396. تمام حقوق محفوظ است
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <?php echo $this->render('//layouts/_following_me');?>
            <!--<div class="side-bar right-bar nicescroll">
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->

        <?= $this->endBody() ?>
    </body>
</html>

<?php //$this->beginContent('@app/views/layouts/footer.php'); ?> 
<?php //$this->endContent(); ?>
<?php //$this->beginContent('@app/views/layouts/_ajax_login.php'); ?>

<?php //$this->endContent(); ?>
<?php //$this->registerJsFile('@web/nadiya_assets/js/vis-network.min.js', [$this::POS_END]) ?>
<?= $this->endPage() ?>