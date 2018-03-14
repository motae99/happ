<?php

namespace api\common\models;

class Specialization extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{specialization}}';
	}
	public function fields()
    {
        return [
            'id',
            'specialty',
            'clinic_id',
            'physician_id',
        ];
    }

	
	public static function find() {
		return new SpecializationQuery(get_called_class());
	}

	public function getDoctor()
    {
        return $this->hasMany(Physician::className(), ['physician_id' => 'id']);
    }

    public function getClinic()
    {
        return $this->hasMany(Medical::className(), ['clinic_id' => 'id']);
    }
}

class SpecializationQuery extends \api\components\db\ActiveQuery
{
}