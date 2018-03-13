<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior; 

/**
 * This is the model class for table "phar_insu".
 *
 * @property int $id
 * @property int $phar_id
 * @property int $insurance_id
 *
 * @property Invoice[] $invoices
 */
class PharInsu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phar_insu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phar_id', 'insurance_id'], 'required'],
            [['phar_id', 'insurance_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phar_id' => Yii::t('app', 'Phar ID'),
            'insurance_id' => Yii::t('app', 'Insurance ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['insurance_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PharInsuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PharInsuQuery(get_called_class());
    }
}
