<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%comment_to_home_page}}".
 *
 * @property int $id
 * @property int $organization_id
 * @property int $comment_id
 * @property string $created_date
 * @property int $created_user_id
 *
 * @property Comment $comment
 */
class CommentToHomePage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment_to_home_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'comment_id', 'created_date', 'created_user_id'], 'required'],
            [['organization_id', 'comment_id', 'created_user_id'], 'integer'],
            [['created_date'], 'safe'],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::class, 'targetAttribute' => ['comment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'organization_id' => 'سازمان',
            'comment_id' => 'شناسه نظر',
            'created_date' => 'تاریخ ایجاد',
            'created_user_id' => 'شناسه کاربر ایجاد کننده',
        ];
    }

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::class, ['id' => 'comment_id']);
    }
}
