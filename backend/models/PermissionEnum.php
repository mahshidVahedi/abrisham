<?php

namespace backend\models;

use tigrov\enum\Enum;

class PermissionEnum extends \tigrov\enum\EnumBehavior
{
    const SELLERS_LIST = 'sellers_list';
    const SELLERS_CREATE = 'sellers_create';
    const SELLERS_EDIT = 'sellers_edit';
    const SELLERS_DELETE = 'sellers_delete';
    const USERS_LIST = 'users_list';
    const USERS_CREATE = 'users_create';
    const USERS_EDIT = 'users_edit';
    const USERS_DELETE = 'users_delete';
    const REQUEST_LIST = 'request_list';
    const REQUEST_CREATE = 'request_create';
    const REQUEST_EDIT = 'request_edit';
    const REQUEST_DELETE = 'request_delete';
    const PERMISSION_LIST = 'permission_list';
    const PERMISSION_CREATE = 'permission_create';
    const PERMISSION_EDIT = 'permission_edit';
    const PERMISSION_DELETE = 'permission_delete';
    const ASSIGN_PERMISSION_CREATE = 'assign_permission';
    const ASSIGN_PERMISSION_LIST = 'assign_permission_list';
    const ASSIGN_PERMISSION_EDIT = 'assign_permission_edit';
    const ASSIGN_PERMISSION_DELETE = 'assign_permission_delete';
}