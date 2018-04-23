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
class LabExam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lab_exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lab_id', 'name', 'price', 'resault'], 'required'],
            [['lab_id'], 'integer'],
            [['description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lab_id' => Yii::t('app', 'Lab ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'resault' => Yii::t('app', 'Resault'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['id' => 'lab_id']);
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
