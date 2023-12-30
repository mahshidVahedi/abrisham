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
        array('label' => 'لیست فروشندگان',                          

            'url' => 'index.php?r=sellers%2Findex',
            'visible' => $isPersonalAccessCurrent,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-search"></i><span>{label}</span></a>',
        ),
        array(
            'label' => 'لیست درخواست ها',
            'url' => 'index.php?r=organization-buy-requests%2Findex',
            'visible' => $isStudent || $isStudentNewYear || $isPersonalAccessAll,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span>{label}</span>___appendCountForLessonMe___</a>'
        ),
        array(
            'label' => 'ایجاد درخواست',
            'url' => 'index.php?r=organization-buy-requests%2Fcreate',
            'visible' => $isStudent || $isStudentNewYear || $isPersonalAccessAll,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span>{label}</span>___appendCountForLessonMe___</a>'
        ),
        array(
            'label' => 'ایجاد فروشنده',
            'url' => 'index.php?r=sellers%2Fcreate',
            'visible' => $isStudent || $isStudentNewYear || $isPersonalAccessAll,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl gl-log-book"></i><span>{label}</span>___appendCountForLessonMe___</a>'
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