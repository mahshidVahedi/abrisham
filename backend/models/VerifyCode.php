<?php

namespace backend\models;

use Yii;
/**
 * This is the model class for table "{{%verify_code}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $otp
 *
 * @property Users $user
 */
class VerifyCode extends \yii\db\ActiveRecord
{
    public $username;
    public $code;
    public $newPassword;
    public $newPasswordRepeat;
    public $_user;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%verify_code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['otp'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'شماره همراه',
            'otp' => 'کد تایید',
            'username' => 'تلفن همراه',
            'code' => 'کد ارسالی'
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
    public function findById($id){
        return static::findOne($id);
    }
    public function getUserByUsername()
    {
        if ($this->_user === null) {
            $this->_user = Users::findByUsername($this->username);
        }

        return $this->_user;
    }
}
