<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Appointment;

/**
 * AppointmentSearch represents the model behind the search form of `app\models\Appointment`.
 */
class AppointmentSearch extends Appointment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'patient_id', 'availability_id', 'calender_id' ], 'integer'],
            [[ 'patientName', 'status', 'stat', 'paiedTo', 'provider', 'clinic_id', 'physician_id' ], 'string'],
            [[ 'patientPhone', 'queue' ], 'integer'],
            [[ 'date' ], 'safe'],
            [[ 'time' ], 'time'],
            [['created_at', 'confirmed_at'], 'safe'],
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
        $query = Appointment::find();

        $query->joinWith(['patient', 'calender', 'scheduale', 'insurance', 'clinic', 'doctor']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ],
                
            ],
        ]);

        $dataProvider->sort->attributes['queue'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['schedule.queue' => SORT_ASC],
            'desc' => ['schedule.queue' => SORT_DESC],
        ];

        // $dataProvider->sort->attributes['queue'] = [
        //     // The tables are the ones our relation are configured to
        //     // in my case they are prefixed with "tbl_"
        //     'asc' => ['scheduale.queue' => SORT_ASC],
        //     // 'desc' => ['appointment.created_at' => SORT_DESC],
        // ];

        // $dataProvider->query->andWhere(['date'=>date('Y-m-d')]);
        // $dataProvider->query->andWhere(['appointment.physician_id'=>'19']);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        // ]);

        // do we have values? if so, add a filter to our query
        if(!empty($this->date) && strpos($this->date, '-') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->date);
            $query->andFilterWhere(['between', 'calender.date', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date)) ]);
        }

        $query->andFilterWhere(['like', 'patient.contact_no', $this->patientPhone])
                ->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'patient.name', $this->patientName])
                ->andFilterWhere(['like', 'physician.name', $this->physician_id])
                ->andFilterWhere(['like', 'clinic.name', $this->clinic_id])
                ->andFilterWhere(['like', 'appointment.availability_id', $this->availability_id])
                ->andFilterWhere(['like', 'appointment.insured', $this->insured])
                ->andFilterWhere(['like', 'appointment.insurance_id', $this->insurance_id])
                ->andFilterWhere(['like', 'appointment.status', $this->status])
                ->andFilterWhere(['like', 'appointment.stat', $this->stat])
                ->andFilterWhere(['like', 'insurance.name', $this->provider]);

        return $dataProvider;
    }
}
