<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Entry;

/**
 * EntrySearch represents the model behind the search form of `app\models\Entry`.
 */
class EntrySearch extends Entry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transaction_id', 'account_id'], 'integer'],
            [['is_depit', 'description', 'date', 'timestamp'], 'safe'],
            [['amount', 'balance'], 'number'],
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
        $query = Entry::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, //'acount_id'=>SORT_ASC,
            'sort'=> ['defaultOrder' => ['transaction_id'=>SORT_DESC,  ]],
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
            'transaction_id' => $this->transaction_id,
            'account_id' => $this->account_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'timestamp' => $this->timestamp,
            'balance' => $this->balance,
        ]);

        $query->andFilterWhere(['like', 'is_depit', $this->is_depit])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
