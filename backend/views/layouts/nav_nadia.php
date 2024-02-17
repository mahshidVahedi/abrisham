<?php
use backend\models\PermissionEnum;
use yii\widgets\Menu;
use backend\models\Users;
$sellers_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_LIST);
$sellers_create   =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::SELLERS_CREATE); 
$request_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_LIST);
$request_create       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::REQUEST_CREATE);
$users_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_LIST);
$users_create       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::USERS_CREATE);
$permission_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::PERMISSION_LIST);
$permission_create       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::PERMISSION_CREATE);
$assign_permission_list       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_CREATE);
$assign_permission_create       =   Users::checkAccsess(Yii::$app->user->id, PermissionEnum::ASSIGN_PERMISSION_LIST);
$isGuest      =      Yii::$app->user->isGuest;

$_SESSION['nadia'] = Menu::widget([
    'items' => [
        array(
            'label' => 'صفحه اصلی',
            'url' => 'index.php',
            'visible' => true,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-home "></i><span>{label}</span></a>'
        ),
        array(
            'label' => 'ورود به حساب کاربری',
            'url' => 'index.php?r=site%2Flogin',
            'visible' => $isGuest,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-log-in  "></i><span>{label}</span></a>'
        ),
        array(
            'label' => ' فروشندگان',
            'url' => 'javascript:void(0);',
            'visible' => $sellers_list || $sellers_create,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-briefcase "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=sellers%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=> $sellers_list,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=sellers%2Fcreate' ,
                        'visible'=>$sellers_create,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => ' درخواست ها',
            'url' => 'javascript:void(0);',
            'visible' => $request_create || $request_list,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-inbox "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=organization-buy-requests%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$request_list,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=organization-buy-requests%2Fcreate' ,
                        'visible'=> $request_create ,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => 'کاربران',
            'url' => 'javascript:void(0);',
            'visible' => $users_create || $users_list,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-user "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=users%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$users_list,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=users%2Fcreate' ,
                        'visible'=>$users_create,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),
        array(
            'label' => 'سطح دسترسی',
            'url' => 'javascript:void(0);',
            'visible' => $permission_list || $permission_create,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl   glyphicon-check  "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=permission%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$permission_list,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=permission%2Fcreate' ,
                        'visible'=>$permission_create,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        ),array(
            'label' => 'انتساب سطح دسترسی',
            'url' => 'javascript:void(0);',
            'visible' => $assign_permission_create,
            'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-edit "></i><span>{label}</span></span><span class="menu-arrow"></span></a>',
                'items'=>array(
                    array(
                        'label'=>'لیست',
                        'url'=>'index.php?r=assign-permission-to-user%2Findex',
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl glyphicon-list"></i><span>{label}</span></a>',
                        'visible'=>$assign_permission_list,
                    ),
                    array(
                        'label'    =>    'جدید',
                        'url'    =>    'index.php?r=assign-permission-to-user%2Fcreate' ,
                        'visible'=>$assign_permission_create || $assign_permission_list,
                        'template' => '<a href="{url}" class="href_class check-login"><i class="gl  glyphicon-circle-arrow-left "></i><span class="">{label}</span></a>',
                    ),
                ),
        )
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