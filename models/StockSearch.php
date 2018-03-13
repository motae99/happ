<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stock;

/**
 * StockSearch represents the model behind the search form of `app\models\Stock`.
 */
class StockSearch extends Stock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phar_id', 'sup_id', 'drug_id', 'quantity', 'created_by', 'updated_by', 'updated_at'], 'integer'],
            [['created_at'], 'safe'],
            [['buying_price', 'selling_price'], 'number'],
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
        $query = Stock::find();

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
            'phar_id' => $this->phar_id,
            'sup_id' => $this->sup_id,
            'drug_id' => $this->drug_id,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
        ]);

        return $dataProvider;
    }
}
