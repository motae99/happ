<?php

namespace api\common\models;

class Insurance extends \api\components\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{insurance}}';
    }


    public static function find() {
        return new InsuranceQuery(get_called_class());
    }
}

class InsuranceQuery extends \api\components\db\ActiveQuery
{
}