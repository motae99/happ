<?php

namespace app\models;

use Yii;


class Minimal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%minimal}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock_id', 'quantity'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'stock_id' => Yii::t('app', 'stock_id'),
            'quantity' => Yii::t('app', 'quantity'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }

    /**
     * @inheritdoc
     * @return AccountTypeQuery the active query used by this AR class.
     */

}
