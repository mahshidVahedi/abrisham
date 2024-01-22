<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property int $username
 * @property string|null $name
 * @property string|null $lname
 * @property string|null $gender
 * @property string $password
 * @property string|null $email
 * @property string|null $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property int $superuser
 * @property int $status
 * @property int $fault_count
 * @property string $fault_at
 * @property string $unique_key

 *
 * @property OrganizationBuyRequests[] $organizationBuyRequests
 * @property Sellers[] $sellers
 */
class Users extends \yii\db\ActiveRecord  implements IdentityInterface
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;

    public $accsessLevel;

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'superuser', 'status', 'fault_count'], 'integer'],
            [['gender'], 'string'],
            [['create_at', 'lastvisit_at', 'fault_at'], 'safe'],
            [['password','name', 'lname'], 'string', 'max' => 255],
            [[ 'email', 'activkey'], 'string', 'max' => 128],
            [['unique_key'], 'string', 'max' => 6],
            [['username'], 'unique'],
            [['unique_key'], 'unique'],
            [['currentPassword','newPassword','newPasswordRepeat'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'نام کاربری',
            'name' => 'نام',
            'lname' => 'نام خانوادگی',
            'gender' => 'جنسیت',
            'password' => 'رمز عبور',
            'email' => 'ایمیل',
            'activkey' => 'Activkey',
            'create_at' => 'Create At',
            'lastvisit_at' => 'Lastvisit At',
            'superuser' => 'سوپر کاربر',
            'status' => 'فعال بودن',
            'fault_count' => 'Fault Count',
            'fault_at' => 'Fault At',
            'unique_key' => 'Unique Key',
            'newPasswordRepeat' => 'تکرار رمز جدید',
            'currentPassword' => 'رمز فعلی',
            'newPassword' => 'رمز جدید',
        ];
    }
    public static function findByUsername($username){
        return static::findOne(['username' => $username]);
    }
    public function findUser($username){
        if (($model = Users::findOne(['username' => $username])) !== null) {
            return $model;
        }
    }

    public static function findById($id){
        return static::findOne(['id' => $id]);
    }
    

    public function validatePassword($password)
{
    return Yii::$app->getSecurity()->validatePassword($password, $this->password);
}

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implement if needed
    }


    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // Implement if needed
    }

    public function validateAuthKey($authKey)
    {
        // Implement if needed
    }
    /**
     * Gets query for [[OrganizationBuyRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBuyRequests()
    {
        return $this->hasMany(OrganizationBuyRequests::class, ['seller_user_id' => 'id']);
    }
    public function setPassword($new_password) {
        $this->password = Yii::$app->security->generatePasswordHash($new_password);
      }

    /**
     * Gets query for [[Sellers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSellers()
    {
        return $this->hasMany(Sellers::class, ['user_id' => 'id']);
    }
    public static function checkAccsess($userId, $access){
        $findOnePermissionToUser          =   AssignPermissionToUser::findByUser($userId);
        if(!empty($findOnePermissionToUser)){
            $permission     =   Permission::findOne($findOnePermissionToUser-> permission_id);
            return $permission->{$access};
        }else{
            return false;
        }
       
        //$accsessLevel   =   $permission ->name;
        //'sellers_list', 'sellers_create', 'sellers_edit', 'sellers_delete', 'users_list', 'users_create', 'users_edit', 'users_delete', 'request_list', 'request_create', 'request_edit', 'request_delete', 'permission_list', 'permission_create', 'permission_edit', 'permission_delete', 'assign_permission'
   

        
    }
  
    

}
