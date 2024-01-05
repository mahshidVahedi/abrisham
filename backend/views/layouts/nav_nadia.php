<?php

use yii\widgets\Menu;
//if(false) {
$urlPublic = 'test'; //Yii::getAlias('@yii1Url');
$urlPublicYii2 = 'test'; //Yii::getAlias('@yii2Url');
$isSeller = true;
$isManager = true;
$isGuest = true;
$_SESSION['nadia'] = Menu::widget([
    'items' => [
        array(
            'label' => 'صفحه اصلی',
            'url' => 'index.php',
            'visible' => $isSeller || $isManager || $isGuest,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-home "></i><span>{label}</span></a>'
        ),
        array(
            'label' => ' فروشندگان',
            'url' => 'javascript:void(0);',
            'visible' => $isManager,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-briefcase "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=sellers%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$isManager
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=sellers%2Fcreate' ,
                        'visible'=>$isManager ,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => ' درخواست ها',
            'url' => 'javascript:void(0);',
            'visible' => $isManager || $isSeller,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-inbox "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=organization-buy-requests%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$isManager|| $isSeller,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=organization-buy-requests%2Fcreate' ,
                        'visible'=>$isSeller   ,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => 'کاربران',
            'url' => 'javascript:void(0);',
            'visible' => $isManager,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-user "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=users%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$isManager,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=users%2Fcreate' ,
                        'visible'=>$isManager,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => 'سطح دسترسی',
            'url' => 'javascript:void(0);',
            'visible' => $isManager,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-user "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=permission%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$isManager,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=permission%2Fcreate' ,
                        'visible'=>$isManager,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => 'انتساب سطح دسترسی',
            'url' => 'index.php?r=assignPermissionToUser%2Flogin',
            'visible' => $isManager,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-log-in "></i><span>{label}</span></a>'
        ),
        array(
            'label' => 'ورود',
            'url' => 'index.php?r=site%2Flogin',
            'visible' => $isGuest,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-log-in "></i><span>{label}</span></a>'
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
</div>
</nav>