<?php

namespace api\common\models;

class Calender extends \api\components\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{calender}}';
    }


    public static function find() {
        return new CalenderQuery(get_called_class());
    }
}

class CalenderQuery extends \api\components\db\ActiveQuery
{
}