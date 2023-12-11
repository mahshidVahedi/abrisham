<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%sellers}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property int $created_forms_count
 * @property int $seller_updated_forms_count
 * @property int $customer_updated_forms_count
 * @property int $completed_by_seller_forms_count
 *
 * @property Users $user
 */
class Sellers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sellers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'required'],
            [['user_id', 'created_forms_count', 'seller_updated_forms_count', 'customer_updated_forms_count', 'completed_by_seller_forms_count'], 'integer'],
            [['status'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'user_id' => 'شناسه کاربری',
            'status' => 'وضعیت',
            'created_forms_count' => 'تعداد فرم های ایجاد شده',
            'seller_updated_forms_count' => 'تعداد فرم های به روز شده توسط فروشنده',
            'customer_updated_forms_count' => 'تعداد فرم های به روز شده توسط مشتری',
            'completed_by_seller_forms_count' => 'تعداد فرم های کامل شده توسط فروشنده',
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

    public function getCreatedFormsCount(){
        return $this->hasMany(OrganizationBuyRequests::class, ['seller_user_id' => 'user_id'])->count();
    }

    public function getSellerUpdatedFormsCount(){
        return OrganizationBuyRequests::find()->where(['seller_user_id' => $this->user_id, 'status' => 'UPDATED_BY_SELLER'])->count();
    }
    public function getCustomerUpdatedFormsCount(){
        return OrganizationBuyRequests::find()->where(['seller_user_id' => $this->user_id, 'status' => 'UPDATED_BY_Customer'])->count();
    }
    public function getSellerCompletedFormsCount(){
        return OrganizationBuyRequests::find()->where(['seller_user_id' => $this->user_id, 'status' => 'COMPLETED_BY_SELLER'])->count();
    }
}
