<?php

namespace app\models;

use Yii;

class Dolar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dollar}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', ], 'required'],
            [['value'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
            'created_at' => Yii::t('app', 'created_at'),
        ];
    }

}
