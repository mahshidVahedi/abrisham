<?php

use yii\widgets\Menu;
//if(false) {
$urlPublic = 'test'; //Yii::getAlias('@yii1Url');
$urlPublicYii2 = 'test'; //Yii::getAlias('@yii2Url');
$isStudent = true;
$isStudentNewYear = true;
$isPersonalAccessCurrent = true;
$isPersonalAccessAll = true;
$isGuest = true;
$_SESSION['nadia'] = Menu::widget([
    'items' => [
        array('label' => 'آخرین ارسال‌های مدارس',
            'url' => '/Contents/AllContentOrg',
            'visible' => $isPersonalAccessCurrent,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-search"></i><span>{label}</span></a>',
        ),
        array(
            'label' => 'رخدادها',
            'url' => '/users/events',
            'visible' => !Yii::$app->user->isGuest,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-bell"></i><span>{label}</span></a>',
        ),
        array('label' => 'فرزندان من',
            'url' => '/academic/student',
            'visible' => !$isStudent and !$isStudentNewYear,
            //'visible'    =>    Relationship::_getStudentRelation(),
            'template' => '<a href="{url}" class="href_class check-login"><i class="fa fa-user fa-fw red"></i><span class="red">{label}</span></a>',
        ),
        array(
            'label' => 'دوره‌های من',
            'url' => '/users/educationMe',
            'visible' => !Yii::$app->user->isGuest,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-education"></i><span>{label}</span></a>',
        ),

        array(
            'label' => 'تکالیف من',
            'url' => '/users/workbookMe',
            'visible' => !Yii::$app->user->isGuest,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span>{label}</span>___appendCountForWorkbookMe___</a>',
        ),
        array(
            'label' => 'محتوای درسی من',
            'url' => '/users/lessonMe',
            'visible' => $isStudent || $isStudentNewYear || $isPersonalAccessAll,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span>{label}</span>___appendCountForLessonMe___</a>'),

        array(
            'label' => 'تکالیف',
            'url' => 'javascript:void(0);',
            'visible' => true,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
            'items' => array(
                array(
                    'label' => 'مدیریت تکالیف',
                    'url' => '/Contents/admin?type=homework',
                    'template' => '<a href="{url}" class="href_class check-login"><i class="fa fa-cog"></i><span>{label}</span></a>',
                    'visible' => true,
                ),
                array(
                    'label' => 'آخرین پاسخ‌های تکالیف',
                    'url' => '/users/events2',
                    'visible' => true,
                    'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span class="">{label}</span></a>',
                ),
                array(
                    'label' => 'گزارش انجام تکالیف',
                    'url' => '/academic/WorkbookManage',
                    'visible' => true,
                    'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span class="">{label}</span></a>',
                ),

            ),
        ),

    ],

]);
//}

$countForWorkbookMe = 0;

$appendCountForWorkbookMe = '';
$appendCountForLessonMe = '';

$newMessage = '';

?>
<div id="sidebar-menu">
<?php
echo str_replace(['___appendCountForWorkbookMe___', '___appendCountForLessonkMe___', '___appendCountForLessonMe___', '___newMessages___'], [$appendCountForWorkbookMe, $appendCountForLessonMe, $appendCountForLessonMe, $newMessage], $_SESSION['nadia']);
?>
    <div class="clearfix"></div>
</div>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>