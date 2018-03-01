<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Availability;

/**
 * AvailabilitySearch represents the model behind the search form of `app\models\Availability`.
 */
class AvailabilitySearch extends Availability
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'physician_id', 'clinic_id', 'max', 'created_by', 'updated_by'], 'integer'],
            [['date', 'from_time', 'to_time', 'status', 'created_at', 'updated_at'], 'safe'],
            [['appointment_fee', 'revisiting_fee'], 'number'],
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
        $query = Availability::find();

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
            'physician_id' => $this->physician_id,
            'clinic_id' => $this->clinic_id,
            'date' => $this->date,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'appointment_fee' => $this->appointment_fee,
            'revisiting_fee' => $this->revisiting_fee,
            'max' => $this->max,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
