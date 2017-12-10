<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%transaction}}".
 *
 * @property int $id
 * @property string $description
 * @property int $reference
 * @property string $reference_type
 * @property string $timestamp
 *
 * @property Entry[] $entries
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference'], 'integer'],
            [['timestamp'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['reference_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'reference' => Yii::t('app', 'Reference'),
            'reference_type' => Yii::t('app', 'Reference Type'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntries()
    {
        return $this->hasMany(Entry::className(), ['transaction_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }
}
