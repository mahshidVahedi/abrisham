<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrganizationBuyRequests;

/**
 * OrganizationBuyRequestsSearch represents the model behind the search form of `backend\models\OrganizationBuyRequests`.
 */
class OrganizationBuyRequestsSearch extends OrganizationBuyRequests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'manager_mobile', 'created_at', 'seller_user_id', 'pre_school_1', 'pre_school_2', 'first', 'secound', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth_math', 'tenth_humanities', 'tenth_empirical', 'eleventh_math', 'eleventh_humanities', 'eleventh_empirical', 'twelfth_math', 'twelfth_humanities', 'twelfth_empirical'], 'integer'],
            [['date', 'manager_name', 'manager_lastname', 'manager_nationality_code', 'manager_gender', 'manager_email', 'organization_name', 'organixation_address', 'organization_phone', 'unique_key', 'sale_date', 'status', 'process_status'], 'safe'],
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
        $query = OrganizationBuyRequests::find();

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
            'date' => $this->date,
            'manager_mobile' => $this->manager_mobile,
            'created_at' => $this->created_at,
            'sale_date' => $this->sale_date,
            'seller_user_id' => $this->seller_user_id,
            'pre_school_1' => $this->pre_school_1,
            'pre_school_2' => $this->pre_school_2,
            'first' => $this->first,
            'secound' => $this->secound,
            'third' => $this->third,
            'fourth' => $this->fourth,
            'fifth' => $this->fifth,
            'sixth' => $this->sixth,
            'seventh' => $this->seventh,
            'eighth' => $this->eighth,
            'ninth' => $this->ninth,
            'tenth_math' => $this->tenth_math,
            'tenth_humanities' => $this->tenth_humanities,
            'tenth_empirical' => $this->tenth_empirical,
            'eleventh_math' => $this->eleventh_math,
            'eleventh_humanities' => $this->eleventh_humanities,
            'eleventh_empirical' => $this->eleventh_empirical,
            'twelfth_math' => $this->twelfth_math,
            'twelfth_humanities' => $this->twelfth_humanities,
            'twelfth_empirical' => $this->twelfth_empirical,
        ]);

        $query->andFilterWhere(['like', 'manager_name', $this->manager_name])
            ->andFilterWhere(['like', 'manager_lastname', $this->manager_lastname])
            ->andFilterWhere(['like', 'manager_nationality_code', $this->manager_nationality_code])
            ->andFilterWhere(['like', 'manager_gender', $this->manager_gender])
            ->andFilterWhere(['like', 'manager_email', $this->manager_email])
            ->andFilterWhere(['like', 'organization_name', $this->organization_name])
            ->andFilterWhere(['like', 'organixation_address', $this->organixation_address])
            ->andFilterWhere(['like', 'organization_phone', $this->organization_phone])
            ->andFilterWhere(['like', 'unique_key', $this->unique_key])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'process_status', $this->process_status]);

        return $dataProvider;
    }
}
