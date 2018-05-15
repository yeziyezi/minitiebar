<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bar".
 *
 * @property string $id 吧id
 * @property string $create_time 创建时间
 * @property int $post_number 贴子数量
 * @property string $intro 吧简介
 * @property string $name
 * @property int $create_user
 *
 * @property User $createUser
 * @property Post[] $posts
 */
class Bar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_time', 'create_user'], 'required'],
            [['create_time'], 'safe'],
            [['post_number', 'create_user'], 'integer'],
            [['id'], 'string', 'max' => 45],
            [['intro'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['id'], 'unique'],
            [['name'], 'unique'],
            [['create_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_time' => 'Create Time',
            'post_number' => 'Post Number',
            'intro' => '简介',
            'name' => '吧名',
            'create_user' => 'Create User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['bar_id' => 'id']);
    }
}
