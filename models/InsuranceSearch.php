<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Insurance;

/**
 * InsuranceSearch represents the model behind the search form of `app\models\Insurance`.
 */
class InsuranceSearch extends Insurance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'appointment_discount', 'appointment_cap', 'drug_discount', 'drug_cap', 'surgery_discount', 'surgery_cap', 'created_by', 'updated_by'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Insurance::find();

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
            'appointment_discount' => $this->appointment_discount,
            'appointment_cap' => $this->appointment_cap,
            'drug_discount' => $this->drug_discount,
            'drug_cap' => $this->drug_cap,
            'surgery_discount' => $this->surgery_discount,
            'surgery_cap' => $this->surgery_cap,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
