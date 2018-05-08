<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InnerReply;

/**
 * InnerReplySearch represents the model behind the search form of `common\models\InnerReply`.
 */
class InnerReplySearch extends InnerReply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'publish_user'], 'integer'],
            [['publish_time', 'content', 'reply_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = InnerReply::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'publish_user' => $this->publish_user,
            'publish_time' => $this->publish_time,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'reply_id', $this->reply_id]);

        return $dataProvider;
    }
}
