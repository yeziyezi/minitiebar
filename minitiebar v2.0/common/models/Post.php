<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $id 贴子id
 * @property string $title 主题
 * @property string $content 内容
 * @property string $publish_time 发布时间
 * @property string $last_reply_time 最后回复时间
 * @property int $reply_number 回复数
 * @property int $publish_user 发布者
 * @property int $reply_status 状态0正常1禁止回复
 * @property int $stick_status 状态0非置顶1置顶
 * @property string $bar_id
 *
 * @property User $publishUser
 * @property Bar $bar
 * @property Reply[] $replies
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'publish_time', 'last_reply_time', 'reply_number', 'publish_user','content','title'], 'required'],
            [['publish_time', 'last_reply_time'], 'safe'],
            [['reply_number', 'publish_user', 'reply_status', 'stick_status'], 'integer'],
            [['id', 'bar_id'], 'string', 'max' => 45],
            [['title'], 'string', 'max' => 30],
            [['content'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['publish_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['publish_user' => 'id']],
            [['bar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bar::className(), 'targetAttribute' => ['bar_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '正文',
            'publish_time' => '发布时间',
            'last_reply_time' => '最后回复时间',
            'reply_number' => '回复数',
            'publish_user' => '发布者',
            'reply_status' => '回复状态',
            'stick_status' => '置顶状态',
            'bar_id' => 'Bar ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublishUser()
    {
        return $this->hasOne(User::className(), ['id' => 'publish_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBar()
    {
        return $this->hasOne(Bar::className(), ['id' => 'bar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['post_id' => 'id']);
    }
}
