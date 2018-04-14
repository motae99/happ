<?php

namespace api\common\models;

class Schedule extends \api\components\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{schedule}}';
    }

   


    public static function find() {
        return new ScheduleQuery(get_called_class());
    }
}

class ScheduleQuery extends \api\components\db\ActiveQuery
{
}