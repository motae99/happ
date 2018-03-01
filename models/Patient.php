<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient".
 *
 * @property int $id
 * @property string $name
 * @property int $contact_no
 * @property string $gender
 * @property string $martial_status
 * @property string $has_insurance
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'contact_no', 'gender', 'martial_status', 'has_insurance', 'created_at', 'created_by'], 'required'],
            [['contact_no', 'created_by', 'updated_by',  'insurance_id', 'insurance_no'], 'integer'],
            [['gender', 'martial_status', 'has_insurance'], 'string'],
            [['created_at', 'updated_at', 'valid_till'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['contact_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'contact_no' => Yii::t('app', 'Contact No'),
            'gender' => Yii::t('app', 'Gender'),
            'martial_status' => Yii::t('app', 'Martial Status'),
            'has_insurance' => Yii::t('app', 'Has Insurance'),
            'insurance_id' => Yii::t('app', 'Insurance ID'),
            'insurance_no' => Yii::t('app', 'Insurance No'),
            'valid_till' => Yii::t('app', 'Valid Till'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PatientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PatientQuery(get_called_class());
    }
}
