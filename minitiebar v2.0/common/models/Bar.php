<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bar".
 *
 * @property string $id 吧id
 * @property string $create_time 创建时间
 * @property int $post_number 贴子数量
 * @property int $watched_number 关注数量
 * @property string $intro 吧简介
 * @property string $name
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
            [['id', 'create_time'], 'required'],
            [['create_time'], 'safe'],
            [['post_number', 'watched_number'], 'integer'],
            [['id'], 'string', 'max' => 45],
            [['intro'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['id'], 'unique'],
            [['name'], 'unique'],
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
            'watched_number' => 'Watched Number',
            'intro' => 'Intro',
            'name' => 'Name',
        ];
    }
}
