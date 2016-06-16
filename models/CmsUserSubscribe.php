<?php

namespace skeeks\cms\usersubscribe;

use skeeks\cms\models\CmsUser;
use Yii;


class CmsUserSubscribe extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%cms_user_subscribe}}';
    }


    public function rules()
    {
        return [
            [['created_at', 'cms_user_id', 'cms_user_subscribe_id'], 'integer'],
            [['cms_user_id', 'cms_user_subscribe_id'], 'required'],
            [['cms_user_id', 'cms_user_subscribe_id'], 'unique', 'targetAttribute' => ['cms_user_id', 'cms_user_subscribe_id'], 'message' => 'The combination of Cms User ID and Cms User Subscribe ID has already been taken.'],
            [['cms_user_subscribe_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['cms_user_subscribe_id' => 'id']],
            [['cms_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['cms_user_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'cms_user_id' => Yii::t('app', 'Cms User ID'),
            'cms_user_subscribe_id' => Yii::t('app', 'Cms User Subscribe ID'),
        ];
    }


    public function getCmsUserSubscribe()
    {
        return $this->hasOne(CmsUser::className(), ['id' => 'cms_user_subscribe_id']);
    }


    public function getCmsUser()
    {
        return $this->hasOne(CmsUser::className(), ['id' => 'cms_user_id']);
    }
}