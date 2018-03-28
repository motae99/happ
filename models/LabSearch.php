<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lab;

/**
 * LabSearch represents the model behind the search form of `app\models\Lab`.
 */
class LabSearch extends Lab
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'to_hour', 'phone', 'secondary_phone', 'rate', 'created_by', 'updated_by'], 'integer'],
            [['name', 'state', 'city', 'address', 'working_days', 'from_hour', 'logitude', 'latitude', 'photo', 'created_at', 'updated_at'], 'safe'],
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
        $query = Lab::find();

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
            'from_hour' => $this->from_hour,
            'to_hour' => $this->to_hour,
            'phone' => $this->phone,
            'secondary_phone' => $this->secondary_phone,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'working_days', $this->working_days])
            ->andFilterWhere(['like', 'logitude', $this->logitude])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
