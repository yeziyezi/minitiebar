<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property string $id
 * @property int $publish_user
 * @property string $publish_time
 * @property string $content
 * @property string $post_id
 *
 * @property InnerReply[] $innerReplies
 * @property User $publishUser
 * @property Post $post
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'publish_user', 'publish_time'], 'required'],
            [['publish_user'], 'integer'],
            [['publish_time'], 'safe'],
            [['id', 'post_id'], 'string', 'max' => 45],
            [['content'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['publish_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['publish_user' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'publish_user' => 'Publish User',
            'publish_time' => 'Publish Time',
            'content' => 'Content',
            'post_id' => 'Post ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInnerReplies()
    {
        return $this->hasMany(InnerReply::className(), ['reply_id' => 'id']);
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
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $post=$this->post;
        $post->last_reply_time=Date('Y-m-d H:i:s');
        $post->save();
    }
}
