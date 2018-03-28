<?php

namespace api\common\models;

class Lab extends \api\components\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{lab}}';
    }

    // public function fields()
    // {
    //     return [
    //         'id',
    //         'name',
    //     ];
    // }

    // public function extraFields() {
    //     return [
    //         'services' => function($model) { return $model->acceptance; },
    //     ];
    // }

    // public function getAcceptance()
    // {
    //     return $this->hasOne(LabAcceptance::className(), ['Lab_id' => 'id']);
    // }


    public static function find() {
        return new LabQuery(get_called_class());
    }
}

class LabQuery extends \api\components\db\ActiveQuery
{
}