<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%assign_permission_to_user}}".
 *
 * @property int $uid
 * @property int $pid
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
            [['uid', 'pid'], 'required'],
            [['uid', 'pid'], 'integer'],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['uid' => 'id']],
            [['pid'], 'exist', 'skipOnError' => true, 'targetClass' => Permission::class, 'targetAttribute' => ['pid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'شناسه کاربری',
            'pid' => 'شناسه سطح دسترسی',
        ];
    }

    /**
     * Gets query for [[P]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getP()
    {
        return $this->hasOne(Permission::class, ['id' => 'pid']);
    }

    /**
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(Users::class, ['id' => 'uid']);
    }
    public function check ($userid,$sellers_list){

    }

}
