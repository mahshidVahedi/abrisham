<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%sellers}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property int $created_forms_counts
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
            [['user_id', 'status', 'created_forms_counts', 'seller_updated_forms_count', 'customer_updated_forms_count', 'completed_by_seller_forms_count'], 'required'],
            [['user_id', 'created_forms_counts', 'seller_updated_forms_count', 'customer_updated_forms_count', 'completed_by_seller_forms_count'], 'integer'],
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
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_forms_counts' => 'Created Forms Counts',
            'seller_updated_forms_count' => 'Seller Updated Forms Count',
            'customer_updated_forms_count' => 'Customer Updated Forms Count',
            'completed_by_seller_forms_count' => 'Completed By Seller Forms Count',
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
}
