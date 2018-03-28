<?php

namespace api\common\models;

class Pharmacy extends \api\components\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{pharmacy}}';
    }


    public static function find() {
        return new PharmacyQuery(get_called_class());
    }
}

class PharmacyQuery extends \api\components\db\ActiveQuery
{
}