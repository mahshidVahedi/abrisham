<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%organization_url}}".
 *
 * @property int $id
 * @property int $organization_id
 * @property string $url
 * @property string $orgs
 * @property int $theme_organization_id
 *
 * @property Organization $organization
 */
class OrganizationUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_url}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'url'], 'required'],
            [['organization_id', 'theme_organization_id'], 'integer'],
            [['url'], 'string'],
            [['orgs'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'organization_id' => Yii::t('app', 'Organization ID'),
            'url' => Yii::t('app', 'Url'),
            'orgs' => Yii::t('app', 'Orgs'),
            'theme_organization_id' => Yii::t('app', 'Theme Organization ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }
}
