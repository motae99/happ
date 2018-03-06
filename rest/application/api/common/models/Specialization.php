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
        ];
    }

	
	public static function find() {
		return new SpecializationQuery(get_called_class());
	}
}

class SpecializationQuery extends \api\components\db\ActiveQuery
{
}