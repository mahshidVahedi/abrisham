<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%assign_permission_to_user}}".
 *
 * @property int $user_id
 * @property int $permission_id
 *
 * @property Permission $p
 * @property Users $u
 */
class AssignPermissionToUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assign_permission_to_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'permission_id'], 'required'],
            [['user_id', 'permission_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Permission::class, 'targetAttribute' => ['permission_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'شناسه کاربری',
            'permission_id' => 'شناسه سطح دسترسی',
        ];
    }

    /**
     * Gets query for [[P]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getP()
    {
        return $this->hasOne(Permission::class, ['id' => 'permission_id']);
    }

    /**
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function findByUser($user_id){
        if (($model = AssignPermissionToUser::findOne(['user_id' => $user_id])) !== null) {
            return $model;
        }
    }
    public function checkSellersCreate ($user_id){
        $model = AssignPermissionToUser::findByUser($user_id);
        $permission = Permission::findOne($model-> permission_id);
        if($permission -> sellers_create == 1){
            return true;
        }else{
            false;
        }
    }
}
