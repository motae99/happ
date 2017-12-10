<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InvoiceProduct;

/**
 * InvoiceProductSearch represents the model behind the search form of `app\models\InvoiceProduct`.
 */
class InvoiceProductSearch extends InvoiceProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id', 'product_id', 'quantity', 'buying_rate', 'selling_rate'], 'integer'],
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
        $query = InvoiceProduct::find();

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
            'invoice_id' => $this->invoice_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'buying_rate' => $this->buying_rate,
            'selling_rate' => $this->selling_rate,
        ]);

        return $dataProvider;
    }
}
