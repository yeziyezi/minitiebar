<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inner_reply".
 *
 * @property int $id
 * @property int $publish_user
 * @property string $publish_time
 * @property string $content
 * @property string $reply_id
 * @property int $to_user
 * @property int $type 0回复当前楼层1回复楼中楼
 *
 * @property User $publishUser
 * @property Reply $reply
 * @property User $toUser
 */
class InnerReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inner_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['publish_user', 'publish_time', 'to_user', 'type'], 'required'],
            [['publish_user', 'to_user', 'type'], 'integer'],
            [['publish_time'], 'safe'],
            [['content'], 'string', 'max' => 500],
            [['reply_id'], 'string', 'max' => 45],
            [['publish_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['publish_user' => 'id']],
            [['reply_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reply::className(), 'targetAttribute' => ['reply_id' => 'id']],
            [['to_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user' => 'id']],
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
            'reply_id' => 'Reply ID',
            'to_user' => 'To User',
            'type' => 'Type',
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
    public function getReply()
    {
        return $this->hasOne(Reply::className(), ['id' => 'reply_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user']);
    }
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $post=$this->reply->post;
        $post->last_reply_time=Date('Y-m-d H:i:s');
        $post->save();
    }

}
