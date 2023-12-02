<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%partners}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $image_url
 * @property string $external_url
 * @property int $organization_id
 */
class Partners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%partners}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'unique'],
            [['title', 'image_url', 'external_url'], 'required'],
            [['organization_id'], 'integer'],
            [['title', 'description', 'image_url', 'external_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'title' => 'عنوان',
            'description' => 'توضیحات',
            'image_url' => 'آدرس تصویر',
            'external_url' => 'آدرس لینک خارجی',
            'organization_id' => 'سازمان',
        ];
    }
}
