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
 * @property int $lab_id
 * @property int $insurance_id
 *
 * @property Invoice[] $invoices
 */
class LabInsu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lab_insur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lab_id', 'insurance_id', 'discount'], 'required'],
            [['lab_id', 'insurance_id'], 'integer'],
            [['discount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lab_id' => Yii::t('app', 'Phar ID'),
            'insurance_id' => Yii::t('app', 'Insurance ID'),
            'discount' => Yii::t('app', 'Discount'),
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
        return new LabInsuQuery(get_called_class());
    }
}
