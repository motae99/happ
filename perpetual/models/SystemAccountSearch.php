<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SystemAccount;

/**
 * SystemAccountSearch represents the model behind the search form of `app\models\SystemAccount`.
 */
class SystemAccountSearch extends SystemAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_type_id'], 'integer'],
            [['account_no', 'system_account_name', 'description', 'group', 'to_increase', 'color_class'], 'safe'],
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
        $query = SystemAccount::find();

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
            'account_type_id' => $this->account_type_id,
            'opening_balance' => $this->opening_balance,
            'balance' => $this->balance,
        ]);

        $query->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'system_account_name', $this->system_account_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'group', $this->group])
            ->andFilterWhere(['like', 'to_increase', $this->to_increase])
            ->andFilterWhere(['like', 'color_class', $this->color_class]);

        return $dataProvider;
    }
}
