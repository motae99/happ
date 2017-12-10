<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientAccount;

/**
 * ClientAccountSearch represents the model behind the search form of `app\models\ClientAccount`.
 */
class ClientAccountSearch extends ClientAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'system_account_id'], 'integer'],
            [['account_no', 'client_account_name', 'description'], 'safe'],
            [['opening_balance', 'balance'], 'number'],
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
        $query = ClientAccount::find();

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
            'system_account_id' => $this->system_account_id,
            'opening_balance' => $this->opening_balance,
            'balance' => $this->balance,
        ]);

        $query->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'client_account_name', $this->client_account_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
