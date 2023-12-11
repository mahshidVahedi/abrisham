<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Sellers;

/**
 * SellersSearch represents the model behind the search form of `backend\models\Sellers`.
 */
class SellersSearch extends Sellers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_forms_counts', 'seller_updated_forms_count', 'customer_updated_forms_count', 'completed_by_seller_forms_count'], 'integer'],
            [['status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Sellers::find();

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
            'user_id' => $this->user_id,
            'created_forms_counts' => $this->created_forms_counts,
            'seller_updated_forms_count' => $this->seller_updated_forms_count,
            'customer_updated_forms_count' => $this->customer_updated_forms_count,
            'completed_by_seller_forms_count' => $this->completed_by_seller_forms_count,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
