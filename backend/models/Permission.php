<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%permission}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int $sellers_list
 * @property int $sellers_create
 * @property int $sellers_edit
 * @property int $sellers_delete
 * @property int $users_list
 * @property int $users_create
 * @property int $users_edit
 * @property int $users_delete
 * @property int $request_list
 * @property int $request_create
 * @property int $request_edit
 * @property int $request_delete
 * @property int $permission_list
 * @property int $permission_create
 * @property int $permission_edit
 * @property int $permission_delete
 * @property int $assign_permission_create
 * @property int $assign_permission_list
 * @property int $assign_permission_edit
 * @property int $assign_permission_delete
 *
 * @property AssignPermissionToUser[] $assignPermissionToUsers
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permission}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sellers_list', 'sellers_create', 'sellers_edit', 'sellers_delete', 'users_list', 'users_create', 'users_edit', 'users_delete', 'request_list', 'request_create', 'request_edit', 'request_delete', 'permission_list', 'permission_create', 'permission_edit', 'permission_delete', 'assign_permission_create', 'assign_permisson_list', 'assign_permission_edit', 'assign_permission_delete'], 'required'],
            [['sellers_list', 'sellers_create', 'sellers_edit', 'sellers_delete', 'users_list', 'users_create', 'users_edit', 'users_delete', 'request_list', 'request_create', 'request_edit', 'request_delete', 'permission_list', 'permission_create', 'permission_edit', 'permission_delete', 'assign_permission_create', 'assign_permisson_list', 'assign_permission_edit', 'assign_permission_delete'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام',
            'sellers_list' => 'لیست فروشندگان',
            'sellers_create' => 'ایجاد فروشنده',
            'sellers_edit' => 'ویرایش فروشنده',
            'sellers_delete' => 'حذف فروشنده ',
            'users_list' => ' لیست کاربران',
            'users_create' => ' ایجاد کاربر',
            'users_edit' => 'ویرایش کاربر ',
            'users_delete' => 'حذف کاربر ',
            'request_list' => ' لیست درخواست ها',
            'request_create' => ' ایجاد درخواست',
            'request_edit' => ' ویرایش درخواست',
            'request_delete' => ' حذف درخواست',
            'permission_list' => ' لیست دسترسی ها',
            'permission_create' => ' ایجاد سطح دسترسی',
            'permission_edit' => ' ویرایش سطح دسترسی',
            'permission_delete' => ' حذف سطح دسترسی',
            'assign_permission' => ' انتساب سطح دسترسی',
            'assign_permisson_list' => 'لیست انتسابات',
            'assign_permission_edit' => 'ویرایش انتساب',
            'assign_permission_delete' => 'حذف انتساب',
        ];
    }

    /**
     * Gets query for [[AssignPermissionToUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignPermissionToUsers()
    {
        return $this->hasMany(AssignPermissionToUser::class, ['permission_id' => 'id']);
    }
}
