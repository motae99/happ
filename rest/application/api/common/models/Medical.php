<?php

namespace api\common\models;

class Medical extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{clinic}}';
	}
	public function fields()
    {
        return [
            'id',
            'name',
            'state',
            'city',
            'address',
            'primary_contact',
            'secondary_contact',
            'type',
            'working_days',
            'start_time'=> function($model) { return $model->start; },
            'end_time'=> function($model) { return $model->end; },
            // 'specialization' => function($model) { return $model->spec; },
            // 'client_name'=> function($model) { return $model->client->client_name; },
            // 'total' => function($model) { return $model->amount; },
           
        ];
    }
    public function extraFields() {
        return [
            'specialization' => function($model) { return $model->spec; },
            'doctors' => function($model) { return $model->doctor; }
            // 'items' => function($model) { return $model->item; }
        ];
    }

    public function getSpec()
    {
        return $this->hasMany(Specialization::className(), ['clinic_id' => 'id']);
    }

    public function getDoctor()
    {
        return $this->hasMany(Availability::className(), ['clinic_id' => 'id']);
    }
	
	public static function find() {
		return new MedicalQuery(get_called_class());
	}
}

class MedicalQuery extends \api\components\db\ActiveQuery
{
}