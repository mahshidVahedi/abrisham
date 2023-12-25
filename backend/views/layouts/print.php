<?php
use yii\web\UrlManager;
use yii\helpers\Html;
use backend\models\Profiles;
$this->beginPage();
$urlPublic	=	'https://hedayatmizan.ir';
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
        <?php $this->beginContent('@app/views/layouts/header.php'); ?>
        <?php $this->endContent(); ?>
    </head>
    <body>
        <?= $this->beginBody()?>
        <div id="wrapper">
             <div style="display:none;position: fixed; top:0; right:0; width:100%; height:100%; background-color:rgba(0,0,0,.5); text-align:center; z-index:2000;" id="ajaxImg">
                <img  src="<?= Yii::$app->request->BaseUrl?>/nadiya_assets/images/loader.gif" style='text-align: center; margin: 250px auto;' alt="لطفا کمی صبر کنید!">
            </div>
            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-right">
                    <div class="text-center">
                        <a href="index.html" class="logo"><i class="icon-magnet icon-c-logo"></i><span>محیط کاربری</span></a>
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
                                <li><a href="<?php echo $urlPublic.'Contents/admin?type=weblog';?>" class="waves-effect waves-light">وبلاگ های من</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false">امور پرسنلی<span
                                            class="caret"></span></a>
                                    <ul class="dropdown-menu">
										<li><a href="<?php echo $urlPublic.'personal/personalMonthlyReport';?>">ورود و خروج</a></li>
                                        <li><a href="<?php echo $urlPublic.'personal/personalManageRequests';?>">درخواست‌ها</a></li>
                                        <li><a href="<?php echo $urlPublic.'personal/ShowContract';?>">نمایش قرارداد</a></li>
                                        <li><a href="<?php echo $urlPublic.'personal/personalFoodReservation';?>">رزرو غذا</a></li>
                                    </ul>
                                </li>
                            </ul>

                            
							<form role="search" class="navbar-right app-search pull-right hidden-xs" id="search-form-theme" method="get" action = "<?php echo $urlPublic.'/Contents/admin';?>">
                                 <input type="text" placeholder="جستجو در محتوا" class="form-control" name="Contents[title]">
                                 <a href="javascript:document.getElementById('search-form-theme').submit();""><i class="fa fa-search"></i></a>
                            </form>
						

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
                                    <?php
                                		if($userId = yii::$app->user->id){
											$profile = Profiles::findOne($userId);
											if(!empty($profile->image))
												  $dir   = yii::getAlias('@yii1Url') . '/server/php/files/' .$userId.'/profile/'. $profile->image;
											else  $dir   = yii::getAlias('@yii2Url').'/backend/web/nadiya_assets/images/users/default.png';
                                		}
                                		else $this->redirect('site/login');
                                	?>
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="<?= $dir ?>" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
									<?php  $urlPublic	=	yii::getAlias('@yii1Url');?>
                                        <li><a href="<?=$urlPublic.'/Personal/PersonalProfile';?>"><i class="ti-user m-r-10 text-custom"></i> پروفایل</a></li>
                                        <li><a href="<?=$urlPublic.'/users/events';?>"><i class="ti-settings m-r-10 text-custom"></i> رخدادها</a></li>
                                        <li><a href="<?=$urlPublic.'/users/socialnetwork';?>"><i class="ti-lock m-r-10 text-custom"></i> گفتگوها</a></li>
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
                <div class="content print-layout">
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
                <h4 class="text-center">چت</h4>
                <div class="contact-list nicescroll">
                    <ul class="list-group contacts-list">
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?= $dir ?>" alt="">
                                </div>
                                <span class="name">چانجل</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?= $dir ?>" alt="">
                                </div>
                                <span class="name">توماس</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?= $dir ?>" alt="">
                                </div>
                                <span class="name">دیوید</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?= $dir ?>" alt="">
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

        <?= $this->endBody() ?>
    </body>
</html>

<?php $this->beginContent('@app/views/layouts/footer.php'); ?>
<?php $this->endContent(); ?>
<?= $this->endPage() ?>