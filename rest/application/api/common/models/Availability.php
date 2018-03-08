<?php

namespace api\common\models;

class Availability extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{availability}}';
	}
	public function fields()
    {
        return [
            'id',
            'doctor' => function($model) { return $model->doctor->name; },
            'clinic' => function($model) { return $model->clinic->name; },
            'day' => function($model) { return $model->date; },
            'from_time',
            'to_time',
            'appointment_fee',
        ];
    }

    public function extraFields() {
        return [
            'clinic' => function($model) { return $model->clinic; },
            // 'outstanding' => function($model) { return $model->outstanding; }
            // 'items' => function($model) { return $model->item; }
        ];
    }

	public function getClinic()
    {
        return $this->hasOne(Medical::className(), ['id' => 'clinic_id']);
    }

    public function getDoctor()
    {
        
        return $this->hasOne(Physicain::className(), ['id' => 'physician_id']);
    }

	public static function find() {
		return new AvailabilityQuery(get_called_class());
	}
}

class AvailabilityQuery extends \api\components\db\ActiveQuery
{
}